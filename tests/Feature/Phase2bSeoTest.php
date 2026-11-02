<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/** Phase 2b: titles and descriptions, BreadcrumbList data, related-service links, the way back from a course. */
class Phase2bSeoTest extends TestCase
{
    use RefreshDatabase;

    private const PAGES = ['/', '/courses', '/consultations', '/sessions', '/packages', '/policies', '/register/anger-management'];

    private function meta(string $html, string $pattern): string
    {
        preg_match($pattern, $html, $m);
        return html_entity_decode($m[1] ?? '', ENT_QUOTES);
    }

    /** @return array<int, array> every JSON-LD block on the page, decoded */
    private function jsonLd(string $html): array
    {
        preg_match_all('#<script type="application/ld\+json">(.*?)</script>#s', $html, $m);
        return array_map(function ($json) {
            $data = json_decode($json, true);
            $this->assertIsArray($data, 'JSON-LD must be valid JSON');
            return $data;
        }, $m[1]);
    }

    /** Only the BreadcrumbList blocks (pages may also carry the center or course-event data) */
    private function breadcrumbs(string $html): array
    {
        return array_values(array_filter($this->jsonLd($html), fn ($b) => ($b['@type'] ?? null) === 'BreadcrumbList'));
    }

    public function test_titles_and_descriptions_in_arabic_and_english(): void
    {
        $expect = [
            '/'               => ['استشارات زوجية وتربوية واجتماعية في الكويت | مركز مطمئنة', 'Marital, Parenting & Social Consultations in Kuwait | Motmaena Center'],
            '/courses'        => ['دورات حضورية ومسجّلة في الكويت | مركز مطمئنة', 'In-person and Recorded Courses in Kuwait | Motmaena Center'],
            '/consultations'  => ['استشارات أسرية وزوجية وتربوية في الكويت | مركز مطمئنة', 'Family, Marital & Parenting Consultations in Kuwait | Motmaena Center'],
            '/sessions'       => ['جلسات وتقييم الأطفال في الكويت | مركز مطمئنة', "Children's Sessions & Assessments in Kuwait | Motmaena Center"],
            '/packages'       => ['باقات دعم الطفل: التواصل وصعوبات التعلم والسلوك | مركز مطمئنة', 'Child Support Packages: Communication, Learning & Behaviour | Motmaena Center'],
            '/register/anger-management' => ['دورة إدارة الغضب في الكويت | مركز مطمئنة', null],
        ];

        foreach ($expect as $page => [$ar, $en]) {
            $html = $this->withSession(['locale' => 'ar'])->get($page)->assertOk()->getContent();
            $this->assertSame($ar, $this->meta($html, '#<title>(.*?)</title>#s'), "AR title of $page");
            $desc = $this->meta($html, '#<meta name="description" content="([^"]*)"#');
            $this->assertNotSame('', $desc);
            $this->assertLessThanOrEqual(170, mb_strlen($desc), "AR description of $page is too long");

            if ($en) {
                $htmlEn = $this->withSession(['locale' => 'en'])->get($page)->assertOk()->getContent();
                $this->assertSame($en, $this->meta($htmlEn, '#<title>(.*?)</title>#s'), "EN title of $page");
                $this->assertStringContainsString('<html lang="en" dir="ltr">', $htmlEn);
            }
            $this->assertStringContainsString('<html lang="ar" dir="rtl">', $html);
        }

        // The course page description is built from its own data
        $this->assertStringContainsString('أ.د. طارق الحبيب', $this->meta($this->get('/register/anger-management')->getContent(), '#<meta name="description" content="([^"]*)"#'));
    }

    private function description(string $page, string $locale): string
    {
        $html = $this->withSession(['locale' => $locale])->get($page)->assertOk()->getContent();
        return $this->meta($html, '#<meta name="description" content="([^"]*)"#');
    }

    public function test_consultations_description_speaks_of_requesting_an_appointment(): void
    {
        $ar = $this->description('/consultations', 'ar');
        $this->assertStringContainsString('طلب موعد حضوري أو هاتفي مع أ.د. طارق الحبيب.', $ar);
        $this->assertStringNotContainsString('مواعيد حضورية', $ar);

        $en = $this->description('/consultations', 'en');
        $this->assertStringContainsString('requesting an in-person or phone appointment with Prof. Dr. Tariq Al-Habib.', $en);
    }

    public function test_course_description_is_built_from_the_course_data_only(): void
    {
        // Seeded course: Wednesday 28 October 2026, 7-9 pm, a recorded place, 30 KWD; deema not configured
        $this->assertSame(
            'دورة إدارة الغضب مع أ.د. طارق الحبيب — الأربعاء 28 أكتوبر 2026، 7:00 - 9:00 مساءً، في مركز مطمئنة بالكويت. الرسوم 30 د.ك.',
            $this->description('/register/anger-management', 'ar')
        );
        $this->assertSame(
            'Anger Management Course with Prof. Dr. Tariq Al-Habib — Wednesday 28 October 2026, 7:00 - 9:00 PM. Fee 30 KWD.',
            $this->description('/register/anger-management', 'en')
        );

        // deema is mentioned only when it is really offered for this course
        config(['services.deema.api_key' => 'deema-key']);
        $ar = $this->description('/register/anger-management', 'ar');
        $this->assertStringEndsWith('الرسوم 30 د.ك أو 4 دفعات مع deema.', $ar);
        $this->assertLessThanOrEqual(160, mb_strlen($ar));
        $this->assertStringEndsWith('Fee 30 KWD or 4 payments with deema.', $this->description('/register/anger-management', 'en'));

        \App\Models\CourseOffer::where('slug', 'anger-management')->update(['show_installments' => false]);
        $this->assertStringNotContainsString('deema', $this->description('/register/anger-management', 'ar'));
        $this->assertStringNotContainsString('deema', $this->description('/register/anger-management', 'en'));

        // No recorded place, no time: neither is invented
        \App\Models\CourseOffer::where('slug', 'anger-management')->update(['location_ar' => null, 'location_en' => null, 'time_ar' => null, 'time_en' => null]);
        $this->assertSame('دورة إدارة الغضب مع أ.د. طارق الحبيب — الأربعاء 28 أكتوبر 2026. الرسوم 30 د.ك.', $this->description('/register/anger-management', 'ar'));
        $this->assertSame('Anger Management Course with Prof. Dr. Tariq Al-Habib — Wednesday 28 October 2026. Fee 30 KWD.', $this->description('/register/anger-management', 'en'));
    }

    public function test_no_unproven_claims_in_titles_or_descriptions(): void
    {
        foreach (self::PAGES as $page) {
            foreach (['ar', 'en'] as $locale) {
                $html = $this->withSession(['locale' => $locale])->get($page)->assertOk()->getContent();
                $text = $this->meta($html, '#<title>(.*?)</title>#s') . ' ' . $this->meta($html, '#<meta name="description" content="([^"]*)"#')
                      . ' ' . $this->meta($html, '#<meta property="og:description" content="([^"]*)"#');
                foreach (['معتمد', 'certified', 'accredited', 'أفضل', 'best', '100%', 'آلاف', 'thousands'] as $claim) {
                    $this->assertStringNotContainsStringIgnoringCase($claim, $text, "\"$claim\" in the meta of $page ($locale)");
                }
            }
        }
    }

    public function test_breadcrumb_data_is_valid_and_points_at_real_pages(): void
    {
        $this->assertEmpty($this->breadcrumbs($this->get('/')->getContent()), 'no breadcrumb on the homepage itself');

        $cases = [
            '/courses'       => ['الرئيسية', 'الدورات'],
            '/consultations' => ['الرئيسية', 'الاستشارات'],
            '/sessions'      => ['الرئيسية', 'الجلسات'],
            '/packages'      => ['الرئيسية', 'الباقات'],
            '/policies'      => ['الرئيسية', 'الشروط والسياسات'],
            '/register/anger-management' => ['الرئيسية', 'الدورات', 'دورة إدارة الغضب'],
        ];

        foreach ($cases as $page => $names) {
            $blocks = $this->breadcrumbs($this->get($page)->getContent());
            $this->assertCount(1, $blocks, "one breadcrumb block on $page");
            $list = $blocks[0];
            $this->assertSame('https://schema.org', $list['@context']);
            $this->assertSame('BreadcrumbList', $list['@type']);
            $this->assertSame($names, array_column($list['itemListElement'], 'name'), "names on $page");

            foreach ($list['itemListElement'] as $i => $item) {
                $this->assertSame('ListItem', $item['@type']);
                $this->assertSame($i + 1, $item['position']);
                $this->get(parse_url($item['item'], PHP_URL_PATH) ?: '/')->assertOk(); // every crumb is a working page
            }
            $this->assertSame(url($page), end($list['itemListElement'])['item'], "last crumb is $page itself");
        }

        $en = $this->breadcrumbs($this->withSession(['locale' => 'en'])->get('/register/anger-management')->getContent());
        $this->assertSame(['Home', 'Courses', 'Anger Management Course'], array_column($en[0]['itemListElement'], 'name'));
    }

    public function test_course_page_has_a_visible_way_back_to_all_courses(): void
    {
        $this->get('/register/anger-management')->assertOk()
            ->assertSee('aria-label="مسار التنقل"', false)
            ->assertSee('href="' . route('courses') . '"', false)
            ->assertSee('aria-current="page"', false);
        $this->withSession(['locale' => 'en'])->get('/register/anger-management')->assertSee('aria-label="Breadcrumb"', false);
    }

    public function test_related_services_link_to_each_other(): void
    {
        $this->get('/consultations')->assertSee('href="' . route('sessions') . '"', false)->assertSee('جلسات وتقييم الأطفال');
        $this->get('/sessions')->assertSee('href="' . route('packages') . '"', false)->assertSee('باقات دعم الطفل');
        $this->get('/packages')->assertSee('href="' . route('sessions') . '"', false)->assertSee('تقييم الطفل وخطط الجلسات');
    }
}
