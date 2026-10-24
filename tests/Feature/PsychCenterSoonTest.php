<?php

namespace Tests\Feature;

use App\Models\Lead;
use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class PsychCenterSoonTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Cache::flush();
        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class);
    }

    public function test_homepage_announces_the_center_and_collects_numbers(): void
    {
        $this->get('/')->assertOk()->assertSee('id="psych-center"', false)->assertSee('مجمع مطمئنة للاستشارات النفسية');

        $this->postJson('/notify', ['phone' => '+965 5111 2222', 'course_key' => Lead::PSYCH_CENTER])
            ->assertOk()->assertJsonFragment(['message' => 'تم! بنبلّغك على واتساب أول ما يفتح المركز 🌷']);
        $this->assertSame(Lead::PSYCH_CENTER, Lead::where('phone', '51112222')->value('course_key'));

        $this->withSession(['admin_auth' => true])->get('/admin/leads')->assertSee('المركز النفسي (قريباً)');
    }

    public function test_admin_can_switch_it_off(): void
    {
        SiteSetting::setMany(['psych_soon' => '0']);
        $this->get('/')->assertOk()->assertDontSee('id="psych-center"', false);

        $this->withSession(['admin_auth' => true])->get('/admin/content')->assertSee('المركز النفسي — قريباً');
    }
}
