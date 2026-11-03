<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/** Search engines see the center and each open course; headings say what people search for; the header button fits the page. */
class SearchAndConversionTest extends TestCase
{
    use RefreshDatabase;

    /** @return array<int, array> every JSON-LD block of a page, decoded */
    private function jsonLd(string $html): array
    {
        preg_match_all('#<script type="application/ld\+json">(.*?)</script>#s', $html, $m);
        return array_map(function ($json) {
            $data = json_decode($json, true);
            $this->assertIsArray($data, 'JSON-LD must be valid JSON');
            return $data;
        }, $m[1]);
    }

    private function ofType(string $html, string $type): ?array
    {
        foreach ($this->jsonLd($html) as $block) {
            if (($block['@type'] ?? null) === $type) return $block;
        }
        return null;
    }

    public function test_homepage_describes_the_center_with_real_facts_only(): void
    {
        $org = $this->ofType($this->get('/')->assertOk()->getContent(), 'ProfessionalService');
        $this->assertNotNull($org, 'the center is described on the homepage');

        $this->assertSame('مركز مطمئنة', $org['name']);
        $this->assertSame(route('home'), $org['url']);
        $this->assertSame('+96556551112', $org['telephone']);
        $this->assertSame('KW', $org['address']['addressCountry']);
        $this->assertStringContainsString('برج أحمد', $org['address']['streetAddress']);
        $this->assertSame('أ.د. طارق الحبيب', $org['founder']['name']);
        $this->assertContains('https://www.instagram.com/motmaena_kw/', $org['sameAs']);
        // Nothing the center has not confirmed
        foreach (['aggregateRating', 'review'] as $unconfirmed) {
            $this->assertArrayNotHasKey($unconfirmed, $org);
        }

        // Hours and prices the center confirmed (config/center.php)
        $this->assertSame(['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday'], $org['openingHoursSpecification'][0]['dayOfWeek']);
        $this->assertSame('09:00', $org['openingHoursSpecification'][0]['opens']);
        $this->assertSame('21:00', $org['openingHoursSpecification'][0]['closes']);
        $this->assertSame('50–80 KWD', $org['priceRange']);

        $en = $this->ofType($this->withSession(['locale' => 'en'])->get('/')->getContent(), 'ProfessionalService');
        $this->assertSame('Motmaena Center', $en['name']);
    }

    public function test_an_open_course_is_an_event_with_date_place_and_price(): void
    {
        $event = $this->ofType($this->get('/register/anger-management')->assertOk()->getContent(), 'EducationEvent');
        $this->assertNotNull($event);

        $this->assertSame('دورة إدارة الغضب', $event['name']);
        $this->assertMatchesRegularExpression('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}(:\d{2})?\+03:00$/', $event['startDate']);
        $this->assertSame('https://schema.org/OfflineEventAttendanceMode', $event['eventAttendanceMode']);
        $this->assertSame('KWD', $event['offers']['priceCurrency']);
        $this->assertGreaterThan(0, (float) $event['offers']['price']);
        $this->assertSame(route('course.register', 'anger-management'), $event['url']);
        $this->assertSame('KW', $event['location']['address']['addressCountry']);
    }

    public function test_headings_name_the_service_and_the_place(): void
    {
        $this->get('/consultations')->assertSee('<h1 class="lx-h1 mb-5">استشارات أسرية وتربوية واجتماعية في الكويت</h1>', false)
            ->assertSee('هل تبحث عن إجابات لمشكلة تؤرقك؟');
        $this->get('/sessions')->assertSee('<h1 class="lx-h1 mb-5">جلسات وتقييم الأطفال في الكويت</h1>', false)
            ->assertSee('طفلك يستحق الأفضل');
        $this->get('/courses')->assertSee('دورات حضورية ومسجّلة مع أ.د. طارق الحبيب');

        foreach (['/', '/courses', '/consultations', '/sessions', '/packages', '/register/anger-management'] as $page) {
            $this->assertSame(1, substr_count($this->get($page)->getContent(), '<h1'), "one main heading on $page");
        }
    }

    public function test_the_header_button_fits_the_page(): void
    {
        $this->assertMatchesRegularExpression('~href="#book"\s+data-track-location="header"~', $this->get('/consultations')->getContent());
        $this->get('/consultations')->assertSee('احجز استشارتك');
        $this->get('/sessions')->assertSee('استشرنا عن طفلك');
        $this->get('/packages')->assertSee('استشرنا عن طفلك');
    }

    public function test_the_unused_latin_font_is_not_downloaded(): void
    {
        $this->get('/')->assertOk()->assertDontSee('family=Inter', false)->assertSee('family=Tajawal', false);
    }
}
