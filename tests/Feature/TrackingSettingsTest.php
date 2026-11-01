<?php

namespace Tests\Feature;

use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

/** Ad pixels, Google Analytics and site-verification tags, set from Admin → Content. */
class TrackingSettingsTest extends TestCase
{
    use RefreshDatabase;

    private const SNAP = '1a2b3c4d-1234-5678-9abc-1234567890ab';

    protected function setUp(): void
    {
        parent::setUp();
        Cache::flush();
        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class);
        config(['services.analytics' => []]);
    }

    private function save(array $values)
    {
        return $this->withSession(['admin_auth' => true])->post('/admin/content/tracking', $values + [
            'tr_ga4' => '', 'tr_meta_pixel' => '', 'tr_tiktok_pixel' => '', 'tr_snap_pixel' => '',
            'tr_google_verification' => '', 'tr_meta_verification' => '',
        ]);
    }

    public function test_nothing_is_loaded_until_ids_are_set(): void
    {
        $this->get('/')->assertOk()
            ->assertDontSee('googletagmanager.com/gtag', false)->assertDontSee('fbevents.js', false)
            ->assertDontSee('analytics.tiktok.com', false)->assertDontSee('sc-static.net', false)
            ->assertDontSee('google-site-verification', false)->assertDontSee('facebook-domain-verification', false);
    }

    public function test_admin_sets_every_tracker_and_they_load_on_the_site(): void
    {
        $this->save([
            'tr_ga4' => ' g-ab12cd34ef ',
            'tr_meta_pixel' => '123456789012345',
            'tr_tiktok_pixel' => 'c1abcdef2ghij3klmn4o',
            'tr_snap_pixel' => self::SNAP,
            // pasted as the whole tag, the way Google/Meta show it
            'tr_google_verification' => '<meta name="google-site-verification" content="AbC_def-1234567890xyzAbC_def-12345" />',
            'tr_meta_verification' => '<meta name="facebook-domain-verification" content="abc123def456ghi789jkl012mno345" />',
        ])->assertSessionHasNoErrors()->assertSessionHas('ok');

        $this->assertSame('G-AB12CD34EF', SiteSetting::tracking()['ga4']);
        $this->assertSame('C1ABCDEF2GHIJ3KLMN4O', SiteSetting::tracking()['tiktok_pixel']);

        $this->get('/')->assertOk()
            ->assertSee('gtag/js?id=G-AB12CD34EF', false)
            ->assertSee("fbq('init', \"123456789012345\")", false)
            ->assertSee('ttq.load("C1ABCDEF2GHIJ3KLMN4O")', false)
            ->assertSee("snaptr('init', \"" . self::SNAP . '"', false)
            ->assertSee('<meta name="google-site-verification" content="AbC_def-1234567890xyzAbC_def-12345">', false)
            ->assertSee('<meta name="facebook-domain-verification" content="abc123def456ghi789jkl012mno345">', false);

        // Same trackers on the checkout page, where InitiateCheckout fires
        $this->get('/register/anger-management')->assertSee('fbevents.js', false)->assertSee("trackEvent('InitiateCheckout'", false);

        $this->get('/admin/content')->assertSee('✓ شغّال');
    }

    public function test_wrong_ids_are_refused_and_clearing_turns_a_tracker_off(): void
    {
        $this->save(['tr_ga4' => 'UA-12345-1', 'tr_meta_pixel' => 'abc', 'tr_snap_pixel' => 'nope'])
            ->assertSessionHasErrors(['tr_ga4', 'tr_meta_pixel', 'tr_snap_pixel']);
        $this->get('/')->assertDontSee('googletagmanager.com/gtag', false);

        $this->save(['tr_meta_pixel' => '123456789012345'])->assertSessionHasNoErrors();
        $this->get('/')->assertSee('fbevents.js', false);

        $this->save([])->assertSessionHasNoErrors();
        Cache::flush();
        $this->get('/')->assertDontSee('fbevents.js', false);
    }

    public function test_env_values_still_work_when_the_admin_field_is_empty(): void
    {
        config(['services.analytics' => ['ga4' => 'G-FROMENV123']]);
        $this->get('/')->assertSee('gtag/js?id=G-FROMENV123', false);
    }
}
