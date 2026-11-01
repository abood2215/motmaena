<?php

namespace Tests\Feature;

use App\Models\CourseBundle;
use App\Models\CourseOffer;
use App\Models\CourseRegistration;
use App\Models\DiscountCode;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

/** "Both November courses for 45 KWD": one payment, one registration per course at 22.5 each. */
class CourseBundleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Cache::flush();
        $this->travelTo('2026-11-02 12:00:00');
        config([
            'services.myfatoorah.api_key' => 'k', 'services.myfatoorah.base_url' => 'https://mf.test',
            'services.center.url' => 'https://center.test', 'services.center.token' => 't',
            'services.deema.api_key' => 'dk', 'services.deema.base_url' => 'https://deema.test',
            'services.deema.webhook_header' => 'X-Deema-Secret', 'services.deema.webhook_secret' => 'shh',
        ]);
        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class);
    }

    private function fakeCard(float $paidValue = 45): void
    {
        Http::fake([
            'mf.test/v2/SendPayment' => Http::response(['IsSuccess' => true, 'Data' => ['InvoiceId' => 88, 'InvoiceURL' => 'https://pay.test/88']]),
            'mf.test/v2/GetPaymentStatus' => Http::response(['IsSuccess' => true, 'Data' => [
                'InvoiceId' => 88, 'InvoiceStatus' => 'Paid', 'InvoiceValue' => $paidValue,
                'InvoiceTransactions' => [['PaymentId' => 'PB1', 'PaymentGateway' => 'KNET']],
            ]]),
            'center.test/*' => Http::response(['ok' => true, 'patient_id' => 1, 'rec_id' => 2]),
        ]);
    }

    public function test_the_offer_is_set_up_with_the_two_november_courses(): void
    {
        $b = CourseBundle::findOpen('november-courses');
        $this->assertNotNull($b);
        $this->assertSame('45.000', $b->price);
        $this->assertSame(60.0, $b->fullPrice());
        $this->assertSame(15.0, $b->savings());
        $this->assertSame(['psychological-first-aid' => 22.5, 'communication-skills' => 22.5], $b->shares());

        $this->get('/register/bundle/november-courses')->assertOk()
            ->assertSee('عرض دورتَي نوفمبر')->assertSee('دورة الإسعافات النفسية الأولية')->assertSee('دورة مهارات التواصل وفن الحوار')
            ->assertSee('45')->assertSee('60')->assertSee('لا يُجمع مع أكواد الخصم')->assertDontSee('name="code"', false);
    }

    public function test_paying_by_card_registers_both_courses_at_22_5_with_no_gift_and_two_center_checks(): void
    {
        $this->fakeCard();

        $this->post('/register/bundle/november-courses', ['name' => 'سارة', 'phone' => '+965 5111 2222', 'email' => 's@x.com'])
            ->assertRedirect('https://pay.test/88');
        Http::assertSent(fn ($r) => str_contains($r->url(), 'SendPayment') && $r['InvoiceValue'] == 45
            && count($r['InvoiceItems']) === 2 && $r['InvoiceItems'][0]['UnitPrice'] == 22.5);

        $rows = CourseRegistration::orderBy('id')->get();
        $this->assertCount(2, $rows);
        $this->assertSame(['psychological-first-aid', 'communication-skills'], $rows->pluck('course_key')->all());
        $this->assertSame(1, $rows->pluck('bundle_group')->unique()->count());
        foreach ($rows as $r) {
            $this->assertSame('30.000', $r->original_amount);
            $this->assertSame('7.500', $r->discount_amount);
            $this->assertSame('22.500', $r->final_amount);
            $this->assertSame('88', $r->invoice_id);
            $this->assertSame('51112222', $r->phone);
        }

        $this->followingRedirects()->get('/payment/callback?paymentId=PB1')->assertOk()
            ->assertSee('تم تسجيلك بنجاح')->assertSee('دورة مهارات التواصل وفن الحوار')->assertSee('45.000')->assertDontSee('مفاجأة إلك');

        foreach ($rows->fresh() as $r) {
            $this->assertSame('paid', $r->status);
            $this->assertNull($r->rewardCode()); // the offer earns no gift code
        }
        $this->assertSame(0, DiscountCode::count());

        // One check per course in the center system, 22.5 each, marked as the offer
        Http::assertSent(fn ($r) => str_starts_with($r->url(), 'https://center.test') && $r['course_code'] === 'AS1'
            && $r['paid_amount'] == 22.5 && $r['discount_amount'] == 7.5 && $r['offer'] === 'عرض دورتَي نوفمبر');
        $this->assertSame(1, CourseRegistration::where('course_key', 'communication-skills')->where('status', 'paid')->count());
    }

    public function test_an_underpaid_invoice_marks_neither_course_paid(): void
    {
        $this->fakeCard(22.5); // only half came through
        $this->post('/register/bundle/november-courses', ['name' => 'سارة', 'phone' => '51112222']);
        $this->get('/payment/callback?paymentId=PB1')->assertSee('لم يكتمل الدفع');

        $this->assertSame(['failed', 'failed'], CourseRegistration::orderBy('id')->pluck('status')->all());
    }

    public function test_deema_covers_the_whole_offer(): void
    {
        Http::fake([
            'deema.test/api/merchant/v1/purchase' => Http::response(['data' => ['order_reference' => 'bnd-ref', 'redirect_link' => 'https://pay.deema.test/b']]),
            'deema.test/api/merchant/v1/purchase/bnd-ref/retrieve_by_reference' => Http::response(['data' => ['deema_order_id' => 9, 'status' => 'captured', 'amount' => 45]]),
            'center.test/*' => Http::response(['ok' => true, 'patient_id' => 1, 'rec_id' => 2]),
        ]);

        $this->get('/register/bundle/november-courses')->assertSee('name="method" value="deema"', false);
        $this->post('/register/bundle/november-courses', ['name' => 'سارة', 'phone' => '51112222', 'method' => 'deema'])->assertRedirect('https://pay.deema.test/b');
        Http::assertSent(fn ($r) => $r->url() === 'https://deema.test/api/merchant/v1/purchase' && $r['amount'] == 45 && str_starts_with($r['merchant_order_id'], 'BND-'));

        $this->postJson('/webhooks/deema', ['order_ref' => 'bnd-ref', 'status' => 'captured'], ['X-Deema-Secret' => 'shh'])->assertOk();
        $this->assertSame(['paid', 'paid'], CourseRegistration::orderBy('id')->pluck('status')->all());
        $this->assertSame(['deema', 'deema'], CourseRegistration::orderBy('id')->pluck('payment_method')->all());
    }

    public function test_the_offer_closes_when_a_course_is_full_or_over(): void
    {
        CourseOffer::where('slug', 'communication-skills')->update(['seats' => 1]);
        CourseRegistration::create(['course_key' => 'communication-skills', 'name' => 'X', 'phone' => '59999999', 'original_amount' => 30, 'final_amount' => 30, 'status' => 'paid']);
        $this->get('/register/bundle/november-courses')->assertNotFound();
        $this->post('/register/bundle/november-courses', ['name' => 'A', 'phone' => '51112222'])->assertRedirect(route('courses'));

        CourseOffer::where('slug', 'communication-skills')->update(['seats' => null]);
        $this->get('/register/bundle/november-courses')->assertOk();

        $this->travelTo('2026-11-12 10:00:00'); // first-aid course is over
        $this->get('/register/bundle/november-courses')->assertNotFound();
        $this->assertNull(CourseBundle::current());
    }

    public function test_admin_sees_and_controls_the_offer(): void
    {
        $this->fakeCard();
        $this->post('/register/bundle/november-courses', ['name' => 'سارة', 'phone' => '51112222']);
        $this->get('/payment/callback?paymentId=PB1');

        $admin = $this->withSession(['admin_auth' => true]);
        $admin->get('/admin/courses')->assertOk()->assertSee('عرض دورتَي نوفمبر')->assertSee('1 عملية شراء مدفوعة')->assertSee('ظاهر بالموقع');
        $admin->get('/admin/registrations')->assertSee('ضمن عرض الدورتين');

        $bundle = CourseBundle::first();
        $admin->put('/admin/bundles/' . $bundle->id, ['price' => 40, 'is_active' => 1])->assertSessionHas('ok');
        $this->assertSame('40.000', $bundle->fresh()->price);
        $admin->put('/admin/bundles/' . $bundle->id, ['price' => 40, 'is_active' => 0]);
        $this->get('/register/bundle/november-courses')->assertNotFound();
    }

    public function test_a_single_course_still_works_as_before_and_still_earns_a_gift(): void
    {
        $this->fakeCard(30);
        $this->post('/register/psychological-first-aid', ['name' => 'علاء', 'phone' => '55556666'])->assertRedirect('https://pay.test/88');
        $this->get('/payment/callback?paymentId=PB1');
        $reg = CourseRegistration::first();
        $this->assertSame('paid', $reg->status);
        $this->assertNull($reg->bundle_group);
        $this->assertNotNull($reg->rewardCode());
    }
}
