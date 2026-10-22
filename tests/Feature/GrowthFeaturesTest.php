<?php

namespace Tests\Feature;

use App\Models\CourseOffer;
use App\Models\CourseRegistration;
use App\Models\DiscountCode;
use App\Models\Lead;
use App\Models\Testimonial;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GrowthFeaturesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Cache::flush();
        $this->travelTo('2026-10-22 12:00:00');
        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class);
        config(['services.myfatoorah.api_key' => 'k', 'services.myfatoorah.base_url' => 'https://mf.test']);
    }

    private function fakePaid(float $value): void
    {
        Http::fake([
            'mf.test/v2/SendPayment' => Http::response(['IsSuccess' => true, 'Data' => ['InvoiceId' => 7, 'InvoiceURL' => 'https://pay.test']]),
            'mf.test/v2/GetPaymentStatus' => Http::response(['IsSuccess' => true, 'Data' => [
                'InvoiceId' => 7, 'InvoiceStatus' => 'Paid', 'InvoiceValue' => $value, 'InvoiceTransactions' => [['PaymentId' => 'P2']],
            ]]),
        ]);
    }

    private function paid(string $phone, string $course = 'anger-management'): CourseRegistration
    {
        $r = CourseRegistration::create(['course_key' => $course, 'name' => 'X', 'phone' => $phone, 'original_amount' => 30, 'final_amount' => 30]);
        $r->markPaid('P', 'KNET');
        return $r;
    }

    public function test_seats_run_out_and_registration_closes(): void
    {
        CourseOffer::where('slug', 'anger-management')->update(['seats' => 2]);
        $this->paid('51111111');

        $this->get('/')->assertSee('متبقي 1 مقعد');
        $this->paid('52222222');

        $this->get('/')->assertSee('اكتمل العدد');
        $this->get('/register/anger-management')->assertOk()->assertSee('اكتمل العدد')->assertDontSee('id="reg-form"', false);
        $this->post('/register/anger-management', ['name' => 'Late', 'phone' => '53333333'])->assertSessionHasErrors('payment');
        Http::assertNothingSent();
    }

    public function test_past_courses_close_and_upcoming_list_shows_other_courses(): void
    {
        CourseOffer::create(['slug' => 'parenting', 'title_ar' => 'دورة التربية', 'price' => 20, 'date' => '2026-11-15', 'is_active' => true]);
        CourseOffer::create(['slug' => 'old', 'title_ar' => 'دورة قديمة', 'price' => 20, 'date' => '2026-10-01', 'is_active' => true]);

        $this->get('/')->assertSee('الدورات القادمة')->assertSee('دورة التربية')->assertDontSee('دورة قديمة');
        $this->get('/register/old')->assertNotFound();
        $this->get('/register/parenting')->assertOk();
    }

    public function test_notify_me_saves_one_row_per_number(): void
    {
        $this->postJson('/notify', ['phone' => '+965 5555 1234'])->assertOk()->assertJson(['ok' => true]);
        $this->postJson('/notify', ['phone' => '55551234', 'course_key' => 'anger-management'])->assertOk();
        $this->postJson('/notify', ['phone' => '12'])->assertStatus(422);
        $this->postJson('/notify', ['phone' => '55559999', 'website' => 'spam'])->assertStatus(422);

        $this->assertSame(1, Lead::count());
        $this->assertSame('anger-management', Lead::first()->course_key);

        $this->withSession(['admin_auth' => true])->get('/admin/leads')->assertOk()->assertSee('55551234');
    }

    public function test_paying_without_a_code_lets_the_customer_pick_a_friend_code(): void
    {
        $this->get('/register/anger-management')->assertSee('هدية مع تسجيلك');

        $owner = $this->paid('51111111');
        $this->get('/done/' . $owner->review_token)->assertSee('اختار لمين الكود');

        // Choose "for a friend"
        $this->followingRedirects()->post('/done/' . $owner->review_token . '/reward/referral')->assertSee('كود صديقك');
        $code = $owner->rewardCode();
        $this->assertSame('referral', $code->kind);
        // A second choice is ignored
        $this->post('/done/' . $owner->review_token . '/reward/self');
        $this->assertSame(1, DiscountCode::where('owner_registration_id', $owner->id)->count());

        // Owner can't use their own friend code
        $this->post('/register/anger-management', ['name' => 'Self', 'phone' => '+965 51111111', 'code' => $code->code])->assertSessionHasErrors('code');

        // Friend gets 10% off and pays; paying with a code earns no gift
        $this->fakePaid(27);
        $this->postJson('/register/anger-management/check-code', ['code' => $code->code])->assertJson(['final' => 27]);
        $this->post('/register/anger-management', ['name' => 'Friend', 'phone' => '52222222', 'code' => $code->code])->assertRedirect('https://pay.test');
        $this->followingRedirects()->get('/payment/callback?paymentId=P2')->assertSee('تم تسجيلك بنجاح')->assertDontSee('اختار لمين الكود');

        $this->withSession(['admin_auth' => true])->get('/admin')->assertSee($code->code)->assertSee('1 صديق');
        $this->get('/admin/registrations')->assertSee('👥 لصديق');
        $this->get('/admin/discount-codes')->assertDontSee($code->code);
    }

    public function test_self_code_works_once_and_only_for_its_owner(): void
    {
        $owner = $this->paid('51111111');
        $this->post('/done/' . $owner->review_token . '/reward/self');
        $code = $owner->rewardCode();
        $this->assertSame('self', $code->kind);
        $this->assertSame(1, $code->max_uses);

        CourseOffer::create(['slug' => 'next', 'title_ar' => 'الدورة الجاية', 'price' => 20, 'date' => '2026-12-01', 'is_active' => true]);
        $this->post('/register/next', ['name' => 'Other', 'phone' => '59999999', 'code' => $code->code])->assertSessionHasErrors('code');

        $this->fakePaid(18);
        $this->post('/register/next', ['name' => 'Owner', 'phone' => '51111111', 'code' => $code->code])->assertRedirect('https://pay.test');
        $this->get('/payment/callback?paymentId=P2');
        $this->assertSame(1, $code->fresh()->used_count);
        $this->postJson('/register/next/check-code', ['code' => $code->code])->assertStatus(422);
    }

    public function test_rewards_can_be_switched_off(): void
    {
        \App\Models\SiteSetting::setMany(['referral_discount_percent' => '0', 'self_discount_percent' => '0']);
        $owner = $this->paid('51111111');
        $this->assertFalse($owner->rewardEligible());
        $this->assertNull($owner->claimReward('referral'));
        $this->get('/register/anger-management')->assertDontSee('هدية مع تسجيلك');
    }

    public function test_review_link_creates_a_hidden_testimonial(): void
    {
        $r = $this->paid('51111111');
        $this->assertNotNull($r->review_token);

        $this->withSession(['admin_auth' => true])->get('/admin/courses/' . CourseOffer::first()->id . '/reviews')
            ->assertOk()->assertSee(rawurlencode(route('review.show', $r->review_token)), false);

        $this->get('/review/' . $r->review_token)->assertOk();
        $this->post('/review/' . $r->review_token, ['rating' => 5, 'quote' => 'دورة ممتازة جداً', 'name' => 'سارة', 'show_name' => '1'])
            ->assertRedirect();

        $t = Testimonial::first();
        $this->assertFalse($t->is_active);
        $this->assertSame('سارة', $t->name);
        $this->get('/')->assertDontSee('دورة ممتازة جداً');

        $this->get('/review/not-a-token')->assertNotFound();
    }
}
