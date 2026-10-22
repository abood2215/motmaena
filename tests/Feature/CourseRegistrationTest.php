<?php

namespace Tests\Feature;

use App\Models\CourseRegistration;
use App\Models\DiscountCode;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CourseRegistrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        config(['services.myfatoorah.api_key' => 'test-key', 'services.myfatoorah.base_url' => 'https://mf.test']);
        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class);
    }

    private function fakeMyFatoorah(string $invoiceStatus = 'Paid', float $invoiceValue = 30): void
    {
        Http::fake([
            'mf.test/v2/SendPayment' => Http::response(['IsSuccess' => true, 'Data' => ['InvoiceId' => 555, 'InvoiceURL' => 'https://pay.test/inv/555']]),
            'mf.test/v2/GetPaymentStatus' => Http::response(['IsSuccess' => true, 'Data' => [
                'InvoiceId' => 555,
                'InvoiceStatus' => $invoiceStatus,
                'InvoiceValue' => $invoiceValue,
                'InvoiceTransactions' => [['PaymentId' => 'PAY1', 'PaymentGateway' => 'KNET', 'TransactionStatus' => 'Succss']],
            ]]),
        ]);
    }

    public function test_pages_render(): void
    {
        $this->get('/')->assertOk()->assertSee('إدارة الغضب');
        $this->get('/register/anger-management')->assertOk();
        $this->get('/register/unknown')->assertNotFound();
    }

    public function test_full_payment_flow_with_discount_code(): void
    {
        $this->fakeMyFatoorah('Paid', 24);
        DiscountCode::create(['code' => 'ANGER20', 'type' => 'percent', 'value' => 20, 'max_uses' => 1]);

        $this->postJson('/register/anger-management/check-code', ['code' => 'anger20'])
            ->assertOk()->assertJson(['final' => 24, 'discount' => 6]);

        $this->post('/register/anger-management', ['name' => 'Test', 'phone' => '+965 55566161', 'code' => 'anger20'])
            ->assertRedirect('https://pay.test/inv/555');

        $reg = CourseRegistration::first();
        $this->assertSame('pending', $reg->status);
        $this->assertSame('24.000', $reg->final_amount);
        Http::assertSent(fn ($r) => str_contains($r->url(), 'SendPayment') && $r['InvoiceValue'] == 24 && $r['CustomerMobile'] === '55566161');

        // Callback twice: must only count the code once
        $this->get('/payment/callback?paymentId=PAY1')->assertOk()->assertSee('تم تسجيلك بنجاح');
        $this->get('/payment/callback?paymentId=PAY1')->assertOk();

        $this->assertSame('paid', $reg->fresh()->status);
        $this->assertSame(1, DiscountCode::first()->used_count);

        // Code is now used up
        $this->postJson('/register/anger-management/check-code', ['code' => 'ANGER20'])->assertStatus(422);
    }

    public function test_unpaid_or_underpaid_invoice_is_not_marked_paid(): void
    {
        $this->fakeMyFatoorah('Paid', 1); // paid less than the price
        $this->post('/register/anger-management', ['name' => 'Test', 'phone' => '55566161']);

        $this->get('/payment/callback?paymentId=PAY1')->assertSee('لم يكتمل الدفع');
        $this->assertSame('failed', CourseRegistration::first()->status);
    }

    public function test_invalid_codes_are_rejected(): void
    {
        DiscountCode::create(['code' => 'OLD', 'type' => 'fixed', 'value' => 5, 'expires_at' => now()->subDay()]);
        DiscountCode::create(['code' => 'OFF', 'type' => 'fixed', 'value' => 5, 'is_active' => false]);

        foreach (['OLD', 'OFF', 'NOPE'] as $code) {
            $this->postJson('/register/anger-management/check-code', ['code' => $code])->assertStatus(422);
        }
    }

    public function test_full_discount_skips_payment(): void
    {
        Http::fake();
        DiscountCode::create(['code' => 'FREE', 'type' => 'percent', 'value' => 100]);

        $this->post('/register/anger-management', ['name' => 'Test', 'phone' => '55566161', 'code' => 'FREE'])
            ->assertOk()->assertSee('تم تسجيلك بنجاح');

        Http::assertNothingSent();
        $this->assertSame('paid', CourseRegistration::first()->status);
    }

    public function test_admin_login_uses_configured_key_only(): void
    {
        config(['app.admin_key' => 'secret-key']);

        $this->post('/admin/login', ['password' => 'motmaena-admin-2025'])->assertSessionHasErrors('password');
        $this->post('/admin/login', ['password' => 'secret-key'])->assertRedirect(route('admin.consultations'));
        $this->assertTrue(session('admin_auth'));

        // No key configured: nobody can log in
        session()->flush();
        config(['app.admin_key' => null]);
        $this->post('/admin/login', ['password' => ''])->assertSessionHasErrors('password');
    }

    public function test_admin_pages_require_login(): void
    {
        $this->get('/admin/registrations')->assertRedirect(route('admin.consultations'));
        $this->get('/admin/discount-codes')->assertRedirect(route('admin.consultations'));

        $this->withSession(['admin_auth' => true]);
        $this->get('/admin/registrations')->assertOk();
        $this->get('/admin/discount-codes')->assertOk();
        $this->get('/admin/consultations')->assertOk();

        $this->post('/admin/discount-codes', ['code' => 'new10', 'type' => 'percent', 'value' => 10])->assertRedirect();
        $this->assertDatabaseHas('discount_codes', ['code' => 'NEW10']);
    }
}
