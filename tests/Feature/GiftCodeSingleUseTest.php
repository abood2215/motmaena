<?php

namespace Tests\Feature;

use App\Models\CourseOffer;
use App\Models\CourseRegistration;
use App\Models\DiscountCode;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

/**
 * The 10 KWD gift code end to end, the way it really happens: people pay for one course
 * without a code and each gets a gift; later a new course opens and the codes are spent there.
 * Every code must work exactly once, for anyone, on any course — and the admin must see it all.
 */
class GiftCodeSingleUseTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Cache::flush();
        config(['services.myfatoorah.api_key' => 'k', 'services.myfatoorah.base_url' => 'https://mf.test']);
        Http::fake(['mf.test/v2/SendPayment' => Http::response(['IsSuccess' => true, 'Data' => ['InvoiceId' => 7, 'InvoiceURL' => 'https://pay.test']])]);
        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class);

        CourseOffer::create([
            'slug' => 'positive-parenting', 'title_ar' => 'دورة فنون التربية الإيجابية', 'price' => 25,
            'date' => '2026-11-18', 'is_active' => true,
        ]);
    }

    /** Starts a checkout on the site and returns the (still unpaid) registration. */
    private function checkout(string $course, string $name, string $phone, ?string $code = null): CourseRegistration
    {
        $this->post("/register/{$course}", array_filter(['name' => $name, 'phone' => $phone, 'code' => $code]))
            ->assertSessionHasNoErrors()->assertRedirect('https://pay.test');

        return CourseRegistration::latest('id')->first();
    }

    private function pay(CourseRegistration $r): CourseRegistration
    {
        $r->markPaid('PAY-' . $r->id, 'KNET');
        return $r->fresh();
    }

    private function check(string $course, string $code, ?string $phone = null)
    {
        return $this->postJson("/register/{$course}/check-code", array_filter(['code' => $code, 'phone' => $phone]));
    }

    public function test_two_gifts_from_one_course_are_each_spent_once_on_the_next_course(): void
    {
        // Two people pay for the anger course without a code → two different single-use gifts
        $alaa = $this->pay($this->checkout('anger-management', 'علاء', '51111111'));
        $sara = $this->pay($this->checkout('anger-management', 'سارة', '52222222'));
        $giftA = $alaa->rewardCode();
        $giftS = $sara->rewardCode();

        $this->assertNotSame($giftA->code, $giftS->code);
        foreach ([$giftA, $giftS] as $g) {
            $this->assertMatchesRegularExpression('/^GIFT[ABCDEFGHJKMNPQRSTUVWXYZ2-9]{4}$/', $g->code); // no 0/O, 1/I/L
            $this->assertSame(1, $g->max_uses);
            $this->assertSame('10.000', $g->value);
            $this->assertNull($g->course_key); // any course
        }

        // A friend uses Alaa's code on the NEW course (typed in lower case with spaces): real 10 KWD off
        $this->check('positive-parenting', '  ' . strtolower($giftA->code) . ' ')->assertOk()->assertJson(['discount' => 10, 'final' => 15]);
        $friend = $this->pay($this->checkout('positive-parenting', 'محمد', '53333333', strtolower($giftA->code)));
        $this->assertSame('15.000', $friend->final_amount);
        $this->assertSame('10.000', $friend->discount_amount);
        Http::assertSent(fn ($r) => str_contains($r->url(), 'SendPayment') && $r['InvoiceValue'] == 15);
        $this->assertSame(1, $giftA->fresh()->used_count);
        $this->assertNull($friend->rewardCode()); // paid with a code → no new gift

        // Alaa's code is now dead for everyone — the friend, Alaa himself, anyone, on any course
        foreach ([['positive-parenting', '53333333'], ['positive-parenting', '51111111'], ['anger-management', '59999999']] as [$course, $phone]) {
            $this->check($course, $giftA->code, $phone)->assertStatus(422)->assertJson(['message' => 'تم استنفاد كود الخصم']);
        }
        $this->from('/register/positive-parenting')
            ->post('/register/positive-parenting', ['name' => 'علاء', 'phone' => '51111111', 'code' => $giftA->code])
            ->assertSessionHasErrors('code');
        $this->assertSame(1, $giftA->fresh()->used_count);

        // Sara spends her own gift on the new course — allowed, once
        $saraAgain = $this->pay($this->checkout('positive-parenting', 'سارة', '52222222', $giftS->code));
        $this->assertSame('15.000', $saraAgain->final_amount);
        $this->assertSame(1, $giftS->fresh()->used_count);
        $this->check('positive-parenting', $giftS->code)->assertStatus(422);

        // The admin sees every code: who got it, that it's used, and by whom on which course
        $this->withSession(['admin_auth' => true])->get('/admin/discount-codes')
            ->assertOk()
            ->assertSee('أكواد الهدايا')
            ->assertSee($giftA->code)->assertSee($giftS->code)
            ->assertSee('محمد')->assertSee('53333333')
            ->assertSee('صاحب الكود نفسه')
            ->assertSee('دورة فنون التربية الإيجابية')
            ->assertDontSee('انستخدم 2 مرات');
    }

    public function test_a_code_is_held_while_someone_pays_and_freed_if_they_never_do(): void
    {
        $gift = $this->pay($this->checkout('anger-management', 'علاء', '51111111'))->rewardCode();

        // Someone opens the payment page with the code but hasn't paid yet
        $pending = $this->checkout('positive-parenting', 'ريم', '54444444', $gift->code);

        // Nobody else can grab it meanwhile; the same person can retry
        $this->check('positive-parenting', $gift->code, '55555555')->assertStatus(422);
        $this->check('positive-parenting', $gift->code, '54444444')->assertOk();
        $this->withSession(['admin_auth' => true])->get('/admin/discount-codes')->assertSee('محجوز بدفع جاري')->assertSee('ريم');

        // She never pays: after the hold the code is free again, still unused
        $this->travel(DiscountCode::HOLD_MINUTES + 1)->minutes();
        $this->assertSame('pending', $pending->fresh()->status);
        $this->assertSame(0, $gift->fresh()->used_count);
        $this->check('positive-parenting', $gift->code, '55555555')->assertOk();
    }

    public function test_a_stopped_gift_code_cannot_be_used(): void
    {
        $gift = $this->pay($this->checkout('anger-management', 'علاء', '51111111'))->rewardCode();

        $this->withSession(['admin_auth' => true])->post('/admin/discount-codes/' . $gift->id . '/toggle')->assertSessionHas('ok');
        $this->check('positive-parenting', $gift->code)->assertStatus(422)->assertJson(['message' => 'كود الخصم غير مفعّل']);
        $this->get('/admin/discount-codes')->assertSee('موقوف');
    }
}
