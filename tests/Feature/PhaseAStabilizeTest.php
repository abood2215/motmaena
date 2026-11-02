<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\StrayRequestException;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

/** Stabilize: analytics only on the live site, no real outside calls from tests, unused claim texts gone. */
class PhaseAStabilizeTest extends TestCase
{
    use RefreshDatabase;

    private const GA = 'googletagmanager.com/gtag/js?id=G-D6RWC35SM1';
    private const LIVE = 'https://motmaena.motmaina-center.com/';

    public function test_no_tracker_loads_on_development_copies(): void
    {
        $this->assertSame('G-D6RWC35SM1', \App\Models\SiteSetting::tracking()['ga4']); // the ID itself is unchanged

        foreach (['testing', 'local', 'development', 'staging'] as $env) {
            $this->app['env'] = $env;
            $this->get(self::LIVE)->assertOk()
                ->assertDontSee(self::GA, false)
                ->assertSee('window.trackEvent = function', false); // buttons that call it keep working
        }
    }

    public function test_staging_never_tracks_even_on_a_real_domain(): void
    {
        $this->app['env'] = 'staging';

        foreach ([self::LIVE, 'https://staging.motmaina-center.com/', self::LIVE . 'courses'] as $url) {
            $this->get($url)->assertOk()->assertDontSee(self::GA, false)->assertDontSee('fbevents.js', false);
        }
        $this->assertFalse(\App\Models\SiteSetting::trackingAllowed());
    }

    public function test_analytics_loads_on_the_live_site_but_not_on_localhost(): void
    {
        $this->app['env'] = 'production';

        $this->get(self::LIVE)->assertOk()->assertSee(self::GA, false);
        $this->get(self::LIVE . 'courses')->assertOk()->assertSee(self::GA, false);

        // A copy run on a developer's machine with production settings still sends nothing
        foreach (['http://localhost/', 'http://127.0.0.1/'] as $url) {
            $this->get($url)->assertOk()->assertDontSee(self::GA, false);
        }
    }

    public function test_tests_cannot_reach_real_outside_services(): void
    {
        try {
            Http::get('https://api.myfatoorah.com/v2/GetPaymentStatus');
            $this->fail('An un-faked outside request must be refused');
        } catch (StrayRequestException $e) {
            $this->assertStringContainsString('api.myfatoorah.com', $e->getMessage());
        }

        // Faked calls still work as before
        Http::fake(['deema.test/*' => Http::response(['ok' => true])]);
        $this->assertTrue(Http::get('https://deema.test/ping')->json('ok'));
    }

    public function test_unused_claim_texts_are_gone_and_used_ones_stay(): void
    {
        $ar = json_decode(file_get_contents(resource_path('lang/ar.json')), true);
        $en = json_decode(file_get_contents(resource_path('lang/en.json')), true);
        $this->assertIsArray($ar);
        $this->assertIsArray($en);

        foreach (['Consultant Psychiatrist', 'Certified Specialists', 'Licensed & experienced team',
                  'Standardized ADHD, IQ, and Autism tests', 'Expert Clinical Support', 'Clinical Sessions',
                  'Per person / Month only', 'Best Value'] as $key) {
            $this->assertArrayNotHasKey($key, $ar, $key);
            $this->assertArrayNotHasKey($key, $en, $key);
        }
        $this->assertNull(config('doctor.tagline'));

        // Still used, so still there and still shown
        $this->assertSame('الأكثر طلباً', $ar['Most Popular']);
        $this->assertSame('بروفيسور واستشاري الطب النفسي', config('doctor.title.ar'));
        $this->withSession(['locale' => 'ar'])->get('/sessions')->assertOk()->assertSee('الأكثر طلباً')->assertSee('750');
        $this->withSession(['locale' => 'en'])->get('/sessions')->assertOk()->assertSee('Most Popular');
    }
}
