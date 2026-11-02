<?php

namespace Tests\Feature;

use App\Models\CourseOffer;
use App\Models\CourseRegistration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

/** The two November courses added from the posters, as the site looks on 1 November. */
class NovemberCoursesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Cache::flush();
        $this->travelTo('2026-11-01 12:00:00'); // the anger course (28 Oct) is over
        config([
            'services.myfatoorah.api_key' => 'k', 'services.myfatoorah.base_url' => 'https://mf.test',
            'services.center.url' => 'https://center.test', 'services.center.token' => 't',
        ]);
        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class);
    }

    public function test_both_courses_are_set_up_and_first_aid_leads_the_homepage(): void
    {
        $pfa = CourseOffer::where('slug', 'psychological-first-aid')->firstOrFail();
        $cs = CourseOffer::where('slug', 'communication-skills')->firstOrFail();

        $this->assertSame('30.000', $pfa->price);
        $this->assertSame('2026-11-11', $pfa->date->toDateString());
        $this->assertSame('AS1', $pfa->center_course_code);
        $this->assertSame('2026-11-25', $cs->date->toDateString());
        $this->assertSame('psychological-first-aid', CourseOffer::featured()->slug);
        $this->assertCount(7, $pfa->toOfferArray()['topics']['ar']);
        $this->assertCount(6, $cs->toOfferArray()['topics']['ar']);
        $this->assertFileExists(public_path($pfa->share_image));
        $this->assertFileExists(public_path($cs->share_image));

        $this->get('/')->assertOk()
            ->assertSee('الإسعافات النفسية الأولية')->assertSee('مهارات التواصل وفن الحوار')
            ->assertSee('og-psychological-first-aid.jpg', false);
        $this->get('/register/psychological-first-aid')->assertOk()->assertSee('كيف تتعامل مع من يريد الانتحار')->assertSee('الهيئة العامة للتعليم التطبيقي');
        $this->get('/register/communication-skills')->assertOk()->assertSee('خصائص المتحدث المؤثر');
        $this->get('/register/anger-management')->assertOk()->assertSee('انتهت هذه الدورة')->assertSee('content="noindex, follow"', false); // held: the old link explains it ended
        $this->get('/courses')->assertSee('الإسعافات النفسية الأولية');
    }

    public function test_an_anger_course_gift_code_takes_10_off_first_aid_and_lands_in_the_center_as_AS1(): void
    {
        Http::fake([
            'mf.test/v2/SendPayment' => Http::response(['IsSuccess' => true, 'Data' => ['InvoiceId' => 9, 'InvoiceURL' => 'https://pay.test']]),
            'center.test/*' => Http::response(['ok' => true, 'patient_id' => 1, 'rec_id' => 2]),
        ]);

        // Someone who paid for the anger course in October got a gift code
        $this->travelTo('2026-10-25 12:00:00');
        $owner = CourseRegistration::create(['course_key' => 'anger-management', 'name' => 'علاء', 'phone' => '51111111', 'original_amount' => 30, 'final_amount' => 30]);
        $owner->markPaid('P1', 'KNET');
        $gift = $owner->rewardCode()->code;
        $this->travelTo('2026-11-01 12:00:00');

        $this->postJson('/register/psychological-first-aid/check-code', ['code' => $gift])->assertOk()->assertJson(['discount' => 10, 'final' => 20]);
        $this->post('/register/psychological-first-aid', ['name' => 'سارة', 'phone' => '52222222', 'code' => $gift])->assertRedirect('https://pay.test');
        $reg = CourseRegistration::latest('id')->first();
        $this->assertSame('20.000', $reg->final_amount);
        Http::assertSent(fn ($r) => str_contains($r->url(), 'SendPayment') && $r['InvoiceValue'] == 20);

        $reg->markPaid('P2', 'KNET');
        Http::assertSent(fn ($r) => str_starts_with($r->url(), 'https://center.test') && $r['course_code'] === 'AS1'
            && $r['original_amount'] == 30 && $r['discount_amount'] == 10 && $r['paid_amount'] == 20 && $r['discount_code'] === $gift);
        $this->postJson('/register/communication-skills/check-code', ['code' => $gift])->assertStatus(422); // spent
    }
}
