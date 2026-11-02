<?php

namespace Tests\Feature;

use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

/** Ad pixels are ready but off: they load only with an ID from the admin, on the live site, and send no personal data. */
class PixelReadinessTest extends TestCase
{
    use RefreshDatabase;

    private const META = '123456789012345';
    private const TIKTOK = 'C1ABCDEF2GHIJ3KLMN4O';
    private const SNAP = '1a2b3c4d-1234-5678-9abc-1234567890ab';

    protected function setUp(): void
    {
        parent::setUp();
        Cache::flush();
        config(['services.analytics' => []]);
    }

    public function test_no_pixel_loads_without_an_id(): void
    {
        config(['services.tracking_enabled' => true]);

        foreach (['/', '/courses', '/consultations', '/register/anger-management'] as $page) {
            $this->get($page)->assertOk()
                ->assertDontSee('fbevents.js', false)->assertDontSee('analytics.tiktok.com', false)->assertDontSee('sc-static.net', false);
        }
    }

    public function test_pixels_stay_off_outside_the_live_site_even_with_ids(): void
    {
        SiteSetting::setMany(['tr_meta_pixel' => self::META, 'tr_tiktok_pixel' => self::TIKTOK, 'tr_snap_pixel' => self::SNAP]);

        // The testing environment is not production: nothing loads
        $this->get('/')->assertOk()->assertDontSee('fbevents.js', false)->assertDontSee('analytics.tiktok.com', false)->assertDontSee('sc-static.net', false);
    }

    public function test_with_ids_each_pixel_loads_with_no_automatic_collection(): void
    {
        config(['services.tracking_enabled' => true]);
        SiteSetting::setMany(['tr_meta_pixel' => self::META, 'tr_tiktok_pixel' => self::TIKTOK, 'tr_snap_pixel' => self::SNAP]);

        $html = $this->get('/register/anger-management')->assertOk()->getContent();

        $this->assertStringContainsString('connect.facebook.net/en_US/fbevents.js', $html);
        $this->assertStringContainsString('analytics.tiktok.com/i18n/pixel/events.js', $html);
        $this->assertStringContainsString('sc-static.net/scevent.min.js', $html);

        // Meta: automatic button/metadata collection is switched off before the pixel starts
        $this->assertMatchesRegularExpression('#fbq\(\'set\', \'autoConfig\', false, "' . self::META . '"\);\s*fbq\(\'init\', "' . self::META . '"\)#', $html);
        // Snap starts without any user details
        $this->assertStringContainsString('snaptr(\'init\', "' . self::SNAP . '", {});', $html);
        // No advanced matching with customer details anywhere
        foreach (['user_email', 'user_phone_number', 'ttq.identify(', '", {em'] as $field) {
            $this->assertStringNotContainsString($field, $html);
        }

        // Every site event has a name on every platform
        foreach (["ViewContent: 'ViewContent'", "RegisterClick: 'ClickButton'", "Purchase: 'CompletePayment'", "ViewContent: 'VIEW_CONTENT'", "Purchase: 'PURCHASE'"] as $map) {
            $this->assertStringContainsString($map, $html);
        }
    }
}
