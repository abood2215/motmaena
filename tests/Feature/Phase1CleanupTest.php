<?php

namespace Tests\Feature;

use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/** Phase 1: unconfirmed claims hidden, a clean sitemap, a proper page for ended courses, labelled icons. */
class Phase1CleanupTest extends TestCase
{
    use RefreshDatabase;

    private const STAR = 'M9.049 2.927'; // the star icon on recorded course cards

    public function test_unconfirmed_figures_ratings_and_quotes_are_hidden(): void
    {
        Course::create(['title' => 'إدارة الغضب', 'description' => 'وصف', 'price' => 0, 'level' => 'beginner', 'external_url' => 'https://example.com']);

        $this->get('/consultations')->assertOk()
            ->assertDontSee('محمد العنزي')->assertDontSee('data-target="4800"', false)
            ->assertDontSee('data-target="100000"', false)->assertDontSee('★★★★★');
        $this->get('/sessions')->assertOk()->assertDontSee('data-target="500"', false)->assertDontSee('★★★★★');
        $this->get('/')->assertOk()->assertDontSee('سنة في الطب النفسي');
        $this->get('/courses')->assertOk()->assertSee('إدارة الغضب')->assertDontSee(self::STAR, false);

        // Nothing is deleted: one switch brings everything back once the center confirms it
        config(['claims.show_unverified' => true]);
        $this->get('/consultations')->assertSee('محمد العنزي')->assertSee('data-target="4800"', false);
        $this->get('/sessions')->assertSee('data-target="500"', false);
        $this->get('/')->assertSee('سنة في الطب النفسي');
        $this->get('/courses')->assertSee(self::STAR, false);
    }

    public function test_sitemap_lists_only_working_pages_and_leaves_out_ended_courses(): void
    {
        $this->travelTo('2026-11-02 12:00:00'); // anger-management (28 Oct) has been held

        $xml = $this->get('/sitemap.xml')->assertOk()->getContent();
        $this->assertStringNotContainsString('/register/anger-management', $xml);
        $this->assertStringContainsString('/register/psychological-first-aid', $xml);

        preg_match_all('#<loc>([^<]+)</loc>#', $xml, $m);
        $this->assertNotEmpty($m[1]);
        foreach ($m[1] as $loc) {
            $this->get(parse_url($loc, PHP_URL_PATH) ?: '/')->assertOk();
        }

        // lastmod only where a real edit date exists (the courses), never on the static pages
        $this->assertMatchesRegularExpression('#/register/psychological-first-aid</loc><lastmod>\d{4}-\d{2}-\d{2}T#', $xml);
        $this->assertStringContainsString('/courses</loc></url>', $xml);
    }

    public function test_an_ended_course_link_explains_it_ended_and_offers_notify_me(): void
    {
        $this->travelTo('2026-11-02 12:00:00');

        $this->get('/register/anger-management')->assertStatus(410)
            ->assertSee('انتهت هذه الدورة')
            ->assertSee('name="course_key" value="anger-management"', false) // notify me for the next date
            ->assertSee('/register/psychological-first-aid', false)           // courses open now
            ->assertDontSee('id="reg-form"', false);

        $this->withSession(['locale' => 'en'])->get('/register/anger-management')
            ->assertStatus(410)->assertSee('This course took place on');

        // Registering and paying for it stay blocked, and unknown links are still 404
        $this->post('/register/anger-management', ['name' => 'Late', 'phone' => '51234567'])->assertNotFound();
        $this->get('/register/no-such-course')->assertNotFound();
    }

    public function test_icon_only_links_have_screen_reader_labels(): void
    {
        $this->get('/')->assertOk()
            ->assertSee('aria-label="حساب مركز مطمئنة على إنستغرام', false)
            ->assertSee('aria-label="صفحة مركز مطمئنة على فيسبوك', false)
            ->assertSee('aria-label="حساب مركز مطمئنة على سناب شات', false)
            ->assertSee('aria-label="حساب مركز مطمئنة على تيك توك', false)
            ->assertSee('aria-label="تواصل معنا على واتساب', false);
    }
}
