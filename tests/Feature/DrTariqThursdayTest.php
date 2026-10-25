<?php

namespace Tests\Feature;

use App\Models\ConsultationBooking;
use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class DrTariqThursdayTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Cache::flush();
        config(['services.crm.url' => 'https://crm.test', 'services.crm.token' => 'crm-token']);
        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class);
    }

    public function test_the_offer_shows_on_the_homepage_and_consultations_page(): void
    {
        $this->get('/')->assertOk()->assertSee('id="dr-tariq"', false)->assertSee('مواعيد محدودة')->assertSee('استشارة تربوية');
        $this->get('/consultations')->assertOk()->assertSee('id="dr-tariq"', false);

        SiteSetting::setMany(['dr_tariq_thursday' => '0']);
        $this->get('/')->assertDontSee('id="dr-tariq"', false);
        $this->withSession(['admin_auth' => true])->get('/admin/content')->assertSee('اطلب موعدك مع د. طارق يوم الخميس');
    }

    public function test_a_request_is_saved_and_sent_to_the_call_center(): void
    {
        Http::fake(['crm.test/*' => Http::response(['ok' => true, 'contact_id' => 5, 'task_id' => 77])]);

        $this->postJson('/dr-tariq/request', ['name' => 'سارة', 'phone' => '+965 5111 2222', 'topic' => 'parenting', 'mode' => 'phone', 'notes' => 'بخصوص ابني'])
            ->assertOk()->assertJson(['ok' => true]);

        $b = ConsultationBooking::firstOrFail();
        $this->assertSame('dr_tariq', $b->kind);
        $this->assertSame('51112222', $b->phone);
        $this->assertSame('استشارة تربوية', $b->problem_type);
        $this->assertSame('هاتفية', $b->mode);
        $this->assertSame(77, (int) $b->crm_task_id);

        Http::assertSent(fn ($r) => $r->url() === 'https://crm.test/api/website/doctor-requests'
            && $r->hasHeader('X-Website-Token', 'crm-token')
            && $r['request_id'] === $b->id && $r['name'] === 'سارة' && $r['phone'] === '51112222'
            && $r['topic'] === 'استشارة تربوية' && $r['mode'] === 'هاتفية' && $r['notes'] === 'بخصوص ابني');

        $this->withSession(['admin_auth' => true])->get('/admin/consultations')
            ->assertSee('موعد مع د. طارق (الخميس)')->assertSee('سارة')->assertSee('✓ وصل للكول سنتر');
    }

    public function test_only_the_phone_is_required_and_crm_trouble_never_loses_the_request(): void
    {
        Http::fake(['crm.test/*' => Http::response('down', 500)]);

        $this->postJson('/dr-tariq/request', ['topic' => 'life', 'mode' => 'in_person'])->assertStatus(422)->assertJsonValidationErrors('phone');
        $this->postJson('/dr-tariq/request', ['phone' => '55566161', 'topic' => 'x', 'mode' => 'in_person'])->assertJsonValidationErrors('topic');

        $this->postJson('/dr-tariq/request', ['phone' => '55566161', 'topic' => 'life', 'mode' => 'in_person'])->assertOk();
        $b = ConsultationBooking::firstOrFail();
        $this->assertNull($b->name);
        $this->assertNull($b->crm_task_id);
        $this->assertNotNull($b->crm_error);

        $this->withSession(['admin_auth' => true])->get('/admin/consultations')->assertSee('ما وصل للكول سنتر');
    }
}
