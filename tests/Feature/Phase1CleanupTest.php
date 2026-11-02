<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\CourseOffer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/** Phase 1: unconfirmed claims hidden, a clean sitemap, a proper page for ended courses, labelled icons. */
class Phase1CleanupTest extends TestCase
{
    use RefreshDatabase;

    private const STAR = 'M9.049 2.927'; // the star icon on recorded course cards
    private const NOINDEX = '<meta name="robots" content="noindex, follow">';

    public function test_unconfirmed_claims_are_hidden_by_default_and_no_setting_can_turn_them_on(): void
    {
        $this->assertFalse(config('claims.show_unverified'));

        // The value is fixed in code: an .env / server variable cannot switch it on
        putenv('SHOW_UNVERIFIED_CLAIMS=true');
        $_ENV['SHOW_UNVERIFIED_CLAIMS'] = $_SERVER['SHOW_UNVERIFIED_CLAIMS'] = 'true';
        try {
            $this->assertFalse((require config_path('claims.php'))['show_unverified']);
        } finally {
            putenv('SHOW_UNVERIFIED_CLAIMS');
            unset($_ENV['SHOW_UNVERIFIED_CLAIMS'], $_SERVER['SHOW_UNVERIFIED_CLAIMS']);
        }

        // ...and the test setup does not switch it on either
        $this->assertStringNotContainsString('SHOW_UNVERIFIED_CLAIMS', file_get_contents(base_path('phpunit.xml')));
    }

    public function test_unconfirmed_figures_ratings_and_quotes_are_hidden(): void
    {
        Course::create(['title' => 'إدارة الغضب', 'description' => 'وصف', 'price' => 0, 'level' => 'beginner', 'external_url' => 'https://example.com']);

        $this->get('/consultations')->assertOk()
            ->assertDontSee('محمد العنزي')->assertDontSee('data-target="4800"', false)
            ->assertDontSee('data-target="100000"', false)->assertDontSee('★★★★★')
            ->assertDontSee('خبرة تزيد على 30 سنة')->assertDontSee('آلاف الأشخاص')
            ->assertSee('جلسات هاتفية حسب توافر المواعيد'); // the availability note stays
        $this->get('/sessions')->assertOk()->assertDontSee('data-target="500"', false)->assertDontSee('★★★★★');
        $this->get('/')->assertOk()->assertDontSee('سنة في الطب النفسي');
        $this->get('/courses')->assertOk()->assertSee('إدارة الغضب')->assertDontSee(self::STAR, false);

        // Nothing is deleted: the one switch (changed in code once confirmed) brings them back
        config(['claims.show_unverified' => true]);
        $this->get('/consultations')->assertSee('محمد العنزي')->assertSee('data-target="4800"', false)
            ->assertSee('خبرة تزيد على 30 سنة')->assertSee('آلاف الأشخاص');
        $this->get('/sessions')->assertSee('data-target="500"', false);
        $this->get('/')->assertSee('سنة في الطب النفسي');
        $this->get('/courses')->assertSee(self::STAR, false);
    }

    public function test_the_best_value_badge_is_gone_from_the_session_tracks(): void
    {
        // 360/12 = 30, 750/24 = 31.25, 900/36 = 25 KWD a session: the 750 track is not the best value
        $this->get('/sessions')->assertOk()->assertDontSee('أفضل قيمة')->assertSee('750');
        $this->withSession(['locale' => 'en'])->get('/sessions')->assertDontSee('Best Value');
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
            $this->get(parse_url($loc, PHP_URL_PATH) ?: '/')->assertOk()->assertDontSee(self::NOINDEX, false);
        }

        // lastmod only where a real edit date exists (the courses), never on the static pages
        $this->assertMatchesRegularExpression('#/register/psychological-first-aid</loc><lastmod>\d{4}-\d{2}-\d{2}T#', $xml);
        $this->assertStringContainsString('/courses</loc></url>', $xml);
    }

    public function test_an_ended_course_link_explains_it_ended_offers_notify_me_and_is_noindex(): void
    {
        $this->travelTo('2026-11-02 12:00:00');

        $this->get('/register/anger-management')->assertOk()
            ->assertSee(self::NOINDEX, false)
            ->assertSee('انتهت هذه الدورة')
            ->assertSee('name="course_key" value="anger-management"', false) // notify me for the next date
            ->assertSee('/register/psychological-first-aid', false)           // courses open now
            ->assertDontSee('id="reg-form"', false);

        $this->withSession(['locale' => 'en'])->get('/register/anger-management')
            ->assertOk()->assertSee(self::NOINDEX, false)->assertSee('This course took place on');

        // Registering and paying for it stay blocked, and unknown links are still 404
        $this->post('/register/anger-management', ['name' => 'Late', 'phone' => '51234567'])->assertNotFound();
        $this->get('/register/no-such-course')->assertNotFound();
    }

    public function test_open_course_pages_are_indexable(): void
    {
        $this->travelTo('2026-11-02 12:00:00');

        foreach (['/', '/courses', '/consultations', '/register/psychological-first-aid', '/register/communication-skills'] as $page) {
            $this->get($page)->assertOk()->assertDontSee('name="robots"', false);
        }
    }

    public function test_reopening_an_ended_course_brings_back_the_normal_indexable_page(): void
    {
        $this->travelTo('2026-11-02 12:00:00');
        $this->get('/register/anger-management')->assertSee(self::NOINDEX, false);

        // The admin gives the same course a new date: same link, back to the normal page
        CourseOffer::where('slug', 'anger-management')->update(['date' => '2026-12-09', 'is_active' => true]);

        $this->get('/register/anger-management')->assertOk()
            ->assertSee('id="reg-form"', false)
            ->assertDontSee('name="robots"', false)
            ->assertDontSee('انتهت هذه الدورة');
        $this->assertStringContainsString('/register/anger-management', $this->get('/sitemap.xml')->getContent());
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
