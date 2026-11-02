<?php

namespace Tests\Feature;

use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/** Phase 2a: light WebP copies of the heavy images, lazy loading below the fold, sizes to stop layout shift. */
class Phase2aImagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_light_images_exist_and_the_originals_are_kept(): void
    {
        foreach (['courses-img/dr-tariq-thumb.webp' => 20, 'logo.webp' => 30, 'deema-logo.webp' => 10] as $file => $maxKb) {
            $this->assertFileExists(public_path($file));
            $this->assertLessThan($maxKb * 1024, filesize(public_path($file)), "$file should stay small");
        }
        foreach (['courses-img/dr-tariq.png', 'logo.png', 'deema-logo.png'] as $original) {
            $this->assertFileExists(public_path($original)); // not deleted
        }
    }

    public function test_pages_no_longer_load_the_heavy_files(): void
    {
        Course::create(['title' => 'إدارة الغضب', 'description' => 'وصف', 'price' => 0, 'level' => 'beginner', 'external_url' => 'https://example.com']);

        foreach (['/', '/courses', '/consultations', '/sessions', '/packages', '/register/anger-management'] as $page) {
            foreach (['ar', 'en'] as $locale) {
                $this->withSession(['locale' => $locale])->get($page)->assertOk()
                    ->assertDontSee('courses-img/dr-tariq.png', false)
                    ->assertDontSee('/logo.png', false)
                    ->assertDontSee('deema-logo.png', false);
            }
        }
    }

    public function test_header_logo_loads_at_once_and_below_the_fold_images_wait(): void
    {
        Course::create(['title' => 'إدارة الغضب', 'description' => 'وصف', 'price' => 0, 'level' => 'beginner', 'external_url' => 'https://example.com']);

        $home = $this->get('/')->assertOk()->getContent();
        preg_match_all('#<img[^>]*logo\.webp[^>]*>#', $home, $logos);
        $this->assertCount(2, $logos[0]);                                      // header + footer
        $this->assertStringNotContainsString('loading="lazy"', $logos[0][0]); // header: visible at once
        $this->assertStringContainsString('loading="lazy"', $logos[0][1]);    // footer: below the fold
        foreach ($logos[0] as $img) {
            $this->assertStringContainsString('width="384" height="145"', $img);
            $this->assertStringContainsString('w-auto', $img);                // the size attributes never stretch it
        }

        $courses = $this->get('/courses')->getContent();
        preg_match_all('#<img[^>]*dr-tariq-thumb\.webp[^>]*>#', $courses, $thumbs);
        $this->assertNotEmpty($thumbs[0]);
        foreach ($thumbs[0] as $img) {
            $this->assertStringContainsString('loading="lazy"', $img);
            $this->assertStringContainsString('width="256" height="256"', $img);
        }

        $this->get('/consultations')->assertSee('alt="أ.د. طارق الحبيب"', false)->assertDontSee('alt="Dr. Tariq"', false);
    }
}
