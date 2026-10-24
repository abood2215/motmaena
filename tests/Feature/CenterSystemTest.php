<?php

namespace Tests\Feature;

use App\Models\CourseOffer;
use App\Models\CourseRegistration;
use App\Models\DiscountCode;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CenterSystemTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        config([
            'services.myfatoorah.api_key' => 'k', 'services.myfatoorah.base_url' => 'https://mf.test',
            'services.center.url' => 'https://center.test', 'services.center.token' => 'center-token',
        ]);
        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class);
        CourseOffer::where('slug', 'anger-management')->update(['center_course_code' => 'ANGER']);
    }

    private function fake(array $centerReply = ['ok' => true, 'patient_id' => 213, 'rec_id' => 5001, 'new_patient' => false], int $status = 200, float $paid = 30): void
    {
        Http::fake([
            'mf.test/v2/SendPayment' => Http::response(['IsSuccess' => true, 'Data' => ['InvoiceId' => 7, 'InvoiceURL' => 'https://pay.test']]),
            'mf.test/v2/GetPaymentStatus' => Http::response(['IsSuccess' => true, 'Data' => [
                'InvoiceId' => 7, 'InvoiceStatus' => 'Paid', 'InvoiceValue' => $paid,
                'InvoiceTransactions' => [['PaymentId' => 'P9', 'PaymentGateway' => 'KNET']],
            ]]),
            'center.test/*' => Http::response($centerReply, $status),
        ]);
    }

    private function payByCard(array $extra = []): CourseRegistration
    {
        $this->post('/register/anger-management', ['name' => 'علاء', 'phone' => '+965 5547 6845'] + $extra)->assertRedirect('https://pay.test');
        $this->get('/payment/callback?paymentId=P9');

        return CourseRegistration::latest('id')->first();
    }

    public function test_paid_registration_is_sent_to_the_center_with_full_details(): void
    {
        $this->fake(paid: 20);
        DiscountCode::create(['code' => 'TEN', 'type' => 'fixed', 'value' => 10]);
        $reg = $this->payByCard(['email' => 'a@b.com', 'code' => 'ten']);

        Http::assertSent(fn ($r) => $r->url() === 'https://center.test/api/website/registrations'
            && $r->hasHeader('X-Website-Token', 'center-token')
            && $r['registration_id'] === $reg->id && $r['name'] === 'علاء' && $r['phone'] === '55476845' && $r['email'] === 'a@b.com'
            && $r['course_code'] === 'ANGER'
            && $r['original_amount'] == 30 && $r['discount_amount'] == 10 && $r['paid_amount'] == 20 && $r['discount_code'] === 'TEN'
            && $r['payment'] === 'myfatoorah' && $r['gateway'] === 'KNET' && $r['payment_ref'] === 'P9');

        $reg->refresh();
        $this->assertSame(213, (int) $reg->center_patient_id);
        $this->assertSame(5001, (int) $reg->center_rec_id);
        $this->assertNull($reg->center_error);

        // Callback again: sent once only
        $this->get('/payment/callback?paymentId=P9');
        Http::assertSentCount(4); // SendPayment, 2× GetPaymentStatus, 1× center

        $this->withSession(['admin_auth' => true])->get('/admin/registrations')->assertSee('✓ بنظام المركز: ملف #213');
    }

    public function test_deema_payments_are_sent_as_deema(): void
    {
        config(['services.deema.api_key' => 'dk', 'services.deema.base_url' => 'https://deema.test']);
        Http::fake([
            'deema.test/api/merchant/v1/purchase' => Http::response(['data' => ['order_reference' => 'ref-1', 'redirect_link' => 'https://pay.deema.test']]),
            'deema.test/api/merchant/v1/purchase/ref-1/retrieve_by_reference' => Http::response(['data' => ['deema_order_id' => 55, 'status' => 'captured', 'amount' => 30]]),
            'center.test/*' => Http::response(['ok' => true, 'patient_id' => 900, 'rec_id' => 6001, 'new_patient' => true]),
        ]);

        $this->post('/register/anger-management', ['name' => 'سارة', 'phone' => '91112233', 'method' => 'deema']);
        $reg = CourseRegistration::first();
        $this->followingRedirects()->get(Http::recorded()->first()[0]['merchant_urls']['success'])->assertSee('تم تسجيلك بنجاح');

        Http::assertSent(fn ($r) => str_starts_with($r->url(), 'https://center.test') && $r['payment'] === 'deema' && $r['payment_ref'] === '55' && $r['paid_amount'] == 30);
        $this->assertSame(900, (int) $reg->fresh()->center_patient_id);
    }

    public function test_a_center_problem_never_breaks_the_payment_and_can_be_resent(): void
    {
        $this->fake(['ok' => false, 'message' => 'كود الدورة ANGER مش موجود بالنظام'], 422);
        $reg = $this->payByCard();

        $this->assertSame('paid', $reg->status);
        $this->assertNull($reg->center_rec_id);
        $this->assertSame('كود الدورة ANGER مش موجود بالنظام', $reg->center_error);

        $this->withSession(['admin_auth' => true])->get('/admin/registrations')
            ->assertSee('ما انبعت لنظام المركز')->assertSee('أرسل للنظام');

        // Fixed on the center side: resend from the admin
        Http::swap(new \Illuminate\Http\Client\Factory);
        Http::fake(['center.test/*' => Http::response(['ok' => true, 'patient_id' => 213, 'rec_id' => 5002])]);
        $this->post('/admin/registrations/' . $reg->id . '/center')->assertSessionHas('ok');
        $this->assertSame(5002, (int) $reg->fresh()->center_rec_id);
    }

    public function test_course_without_center_code_is_flagged(): void
    {
        CourseOffer::where('slug', 'anger-management')->update(['center_course_code' => null]);
        $this->fake();
        $reg = $this->payByCard();

        Http::assertNotSent(fn ($r) => str_starts_with($r->url(), 'https://center.test'));
        $this->assertStringContainsString('كود الدورة بالنظام', $reg->center_error);
    }

    public function test_nothing_is_sent_when_the_link_is_off(): void
    {
        config(['services.center.url' => null]);
        $this->fake();
        $reg = $this->payByCard();

        Http::assertNotSent(fn ($r) => str_starts_with($r->url(), 'https://center.test'));
        $this->assertNull($reg->center_error);
    }

    public function test_admin_can_set_the_center_course_code(): void
    {
        $offer = CourseOffer::where('slug', 'anger-management')->first();
        $this->withSession(['admin_auth' => true])->get('/admin/courses/' . $offer->id . '/edit')
            ->assertSee('كود الدورة بالنظام')->assertSee('value="ANGER"', false);
    }
}
