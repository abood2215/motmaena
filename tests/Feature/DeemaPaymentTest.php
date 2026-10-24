<?php

namespace Tests\Feature;

use App\Models\CourseRegistration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class DeemaPaymentTest extends TestCase
{
    use RefreshDatabase;

    private const REF = 'e13420e1-cd72-40d4-a344-870a1a902b56';

    protected function setUp(): void
    {
        parent::setUp();
        config([
            'services.deema.api_key' => 'deema-key',
            'services.deema.base_url' => 'https://deema.test',
            'services.deema.webhook_header' => 'X-Deema-Secret',
            'services.deema.webhook_secret' => 'shh',
        ]);
        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class);
    }

    private function fakeDeema(string $status = 'fully_captured', float $amount = 30): void
    {
        Http::fake([
            'deema.test/api/merchant/v1/purchase' => Http::response(['message' => 'Purchase created successfully', 'data' => [
                'order_reference' => self::REF, 'purchase_id' => 1, 'order_status' => 'pending',
                'redirect_link' => 'https://pay.deema.test/?order_reference=' . self::REF,
            ]]),
            'deema.test/api/merchant/v1/purchase/' . self::REF . '/retrieve_by_reference' => Http::response(['message' => 'Fetch order by reference', 'data' => [
                'deema_order_id' => 77, 'order_reference' => self::REF, 'status' => $status, 'amount' => $amount, 'currency_code' => 'KWD',
            ]]),
        ]);
    }

    private function startDeemaCheckout(): CourseRegistration
    {
        $this->post('/register/anger-management', ['name' => 'Test', 'phone' => '55566161', 'method' => 'deema'])
            ->assertRedirect('https://pay.deema.test/?order_reference=' . self::REF);

        return CourseRegistration::first();
    }

    private function returnUrl(CourseRegistration $reg): string
    {
        return Http::recorded()->first()[0]['merchant_urls']['success'];
    }

    public function test_deema_option_shows_only_when_deema_is_set_up(): void
    {
        $this->get('/register/anger-management')->assertSee('name="method" value="deema"', false);

        config(['services.deema.api_key' => null]);
        $this->get('/register/anger-management')->assertDontSee('name="method" value="deema"', false);
    }

    public function test_customer_returning_after_paying_is_registered(): void
    {
        $this->fakeDeema();
        $reg = $this->startDeemaCheckout();

        $this->assertSame('pending', $reg->status);
        $this->assertSame(self::REF, $reg->invoice_id);
        Http::assertSent(fn ($r) => $r->url() === 'https://deema.test/api/merchant/v1/purchase'
            && $r->hasHeader('Authorization', 'Basic deema-key')
            && $r['amount'] == 30 && $r['currency_code'] === 'KWD' && $r['merchant_order_id'] === 'REG-' . $reg->id);

        $this->followingRedirects()->get($this->returnUrl($reg))->assertOk()->assertSee('تم تسجيلك بنجاح');
        $this->assertSame('paid', $reg->fresh()->status);
        $this->assertSame('deema', $reg->fresh()->payment_method);
    }

    public function test_return_link_needs_its_signature(): void
    {
        $this->fakeDeema();
        $reg = $this->startDeemaCheckout();

        $this->get('/payment/deema/' . $reg->id)->assertNotFound();
        $this->get('/payment/deema/' . $reg->id . '?sig=nope')->assertNotFound();
    }

    public function test_cancelled_order_is_not_paid(): void
    {
        $this->fakeDeema('payment_cancelled');
        $reg = $this->startDeemaCheckout();

        $this->get($this->returnUrl($reg))->assertSee('لم يكتمل الدفع');
        $this->assertSame('failed', $reg->fresh()->status);
    }

    public function test_webhook_marks_paid_after_checking_with_deema(): void
    {
        $this->fakeDeema();
        $reg = $this->startDeemaCheckout();
        $payload = ['merchant_order_ref' => 'REG-' . $reg->id, 'order_ref' => self::REF, 'status' => 'captured', 'purchase_id' => 1];

        $this->postJson('/webhooks/deema', $payload)->assertUnauthorized();
        $this->postJson('/webhooks/deema', $payload, ['X-Deema-Secret' => 'wrong'])->assertUnauthorized();
        $this->assertSame('pending', $reg->fresh()->status);

        $this->postJson('/webhooks/deema', $payload, ['X-Deema-Secret' => 'shh'])->assertOk()->assertJson(['received' => true]);
        $this->assertSame('paid', $reg->fresh()->status);
    }

    public function test_webhook_body_alone_cannot_mark_paid(): void
    {
        $this->fakeDeema('pending');
        $reg = $this->startDeemaCheckout();

        $this->postJson('/webhooks/deema', ['order_ref' => self::REF, 'status' => 'captured'], ['X-Deema-Secret' => 'shh'])->assertOk();
        $this->assertSame('pending', $reg->fresh()->status);
    }

    public function test_underpaid_order_is_not_paid(): void
    {
        $this->fakeDeema('fully_captured', 1);
        $reg = $this->startDeemaCheckout();

        $this->get($this->returnUrl($reg));
        $this->assertNotSame('paid', $reg->fresh()->status);
    }

    public function test_deema_error_falls_back_with_a_message(): void
    {
        Http::fake(['deema.test/*' => Http::response(['message' => 'The purchase amount is not within the merchant\'s credit limit range.', 'data' => ['error_code' => 115]], 400)]);

        $this->from('/register/anger-management')
            ->post('/register/anger-management', ['name' => 'Test', 'phone' => '55566161', 'method' => 'deema'])
            ->assertRedirect('/register/anger-management')
            ->assertSessionHasErrors('payment');
        $this->assertSame('failed', CourseRegistration::first()->status);
    }
}
