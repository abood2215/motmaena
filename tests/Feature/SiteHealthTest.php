<?php

namespace Tests\Feature;

use App\Models\ConsultationBooking;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

/** Every public page loads in both languages with its own title, description, icon and share image. */
class SiteHealthTest extends TestCase
{
    use RefreshDatabase;

    private const PAGES = ['/', '/courses', '/packages', '/sessions', '/consultations', '/policies', '/register/anger-management'];

    protected function setUp(): void
    {
        parent::setUp();
        Cache::flush();
        $this->travelTo('2026-10-22 12:00:00');
        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class);
    }

    public function test_public_pages_load_with_head_tags_in_arabic(): void
    {
        foreach (self::PAGES as $path) {
            $html = $this->get($path)->assertOk()->getContent();
            $this->assertStringStartsWith('<!DOCTYPE html>', $html, $path);
            $this->assertStringContainsString('مركز مطمئنة</title>', $html, $path);
            $this->assertMatchesRegularExpression('/<meta name="description" content="[^"]*[\x{0600}-\x{06FF}]/u', $html, "$path needs an Arabic description");
            $this->assertStringContainsString('rel="icon"', $html, $path);
            $this->assertStringContainsString('og:image" content="http', $html, $path);
        }
    }

    public function test_public_pages_load_in_english(): void
    {
        $this->get('/lang/en');
        foreach (self::PAGES as $path) {
            $this->get($path)->assertOk()->assertSee('Motmaena Center</title>', false);
        }
    }

    public function test_icon_and_share_images_exist(): void
    {
        foreach (['favicon.ico', 'apple-touch-icon.png', 'og-default.jpg', 'og-anger-management.jpg'] as $file) {
            $this->assertGreaterThan(1000, filesize(public_path($file)), $file);
        }
    }

    public function test_missing_page_shows_branded_arabic_404(): void
    {
        $this->get('/no-such-page')->assertNotFound()->assertSee('الصفحة غير موجودة')->assertSee('/courses', false);
    }

    public function test_terms_explain_the_gift_code(): void
    {
        $this->get('/policies')->assertSee('كود الهدية')->assertSee('deema');
    }

    public function test_consultation_booking_is_saved_and_rate_limited(): void
    {
        $payload = ['phone' => '+96555551234', 'problem_type' => 'استشارة أسرية', 'notes' => 'test'];
        $this->postJson('/consultations/book', $payload)->assertOk()->assertJson(['ok' => true]);
        $this->assertSame(1, ConsultationBooking::count());

        for ($i = 0; $i < 5; $i++) $this->postJson('/consultations/book', $payload);
        $this->postJson('/consultations/book', $payload)->assertStatus(429);
    }
}
