<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/** Measurement: course views, taps on "register", checkout start with the course, and where WhatsApp was tapped. No personal data. */
class MeasurementEventsTest extends TestCase
{
    use RefreshDatabase;

    /** @return array<int, string> every trackEvent(...) call written on the page */
    private function trackEventCalls(string $html): array
    {
        preg_match_all("#trackEvent\(\s*'[A-Za-z]+'[^;]*\)#", $html, $m);
        return $m[0];
    }

    private function assertNoPersonalData(string $html): void
    {
        foreach ($this->trackEventCalls($html) as $call) {
            $this->assertDoesNotMatchRegularExpression('/\b(name|phone|email|notes|problem_type|href|text)\b|getElementById\(\'(name|phone|email)\'\)/', $call, $call);
        }
    }

    public function test_the_course_page_counts_a_view_and_the_checkout_start_names_the_course(): void
    {
        foreach (['ar', 'en'] as $locale) {
            $html = $this->withSession(['locale' => $locale])->get('/register/anger-management')->assertOk()->getContent();

            $this->assertMatchesRegularExpression(
                "#trackEvent\('ViewContent', \{ content_type: 'course', content_name: \"[^\"]+\", content_ids: \[\"anger-management\"\], value: [0-9.]+, currency: 'KWD' \}\)#u", $html);
            $this->assertMatchesRegularExpression(
                "#trackEvent\('InitiateCheckout', \{ value: parseFloat\(document.getElementById\('p-final'\).textContent\) \|\| 0, currency: 'KWD', content_type: 'course', content_name: \"[^\"]+\", content_ids: \[\"anger-management\"\] \}\)#u", $html);
            $this->assertNoPersonalData($html);
        }
    }

    public function test_the_bundle_page_counts_a_view(): void
    {
        $this->travelTo('2026-11-02 12:00:00');

        $html = $this->get('/register/bundle/november-courses')->assertOk()->getContent();
        $this->assertStringContainsString(
            "trackEvent('ViewContent', { content_type: 'bundle', content_name: \"november-courses\", content_ids: [\"november-courses\"], value: 45, currency: 'KWD' })", $html);
        $this->assertNoPersonalData($html);
    }

    public function test_taps_on_register_and_whatsapp_are_counted_with_their_place_only(): void
    {
        $html = $this->get('/')->assertOk()->getContent();

        // New events are mapped for every platform
        $this->assertStringContainsString("ViewContent: 'view_item', RegisterClick: 'register_click'", $html);
        $this->assertStringContainsString("RegisterClick: 'ClickButton'", $html);
        $this->assertStringContainsString("ViewContent: 'VIEW_CONTENT'", $html);
        $this->assertStringContainsString("var fbMethod = fbStandard[name] ? 'track' : 'trackCustom';", $html);

        // WhatsApp: the place of the button, never the link or its message
        $this->assertStringContainsString("window.trackEvent('Contact', { content_name: 'whatsapp', link_location: window.trackLocation(wa) })", $html);
        // Register: the course key read from the link, and the place of the link
        $this->assertStringContainsString("closest('a[href*=\"/register/\"]')", $html);
        $this->assertStringContainsString("window.trackEvent('RegisterClick', { content_type: m[1] ? 'bundle' : 'course', content_name: decodeURIComponent(m[2]), content_ids: [decodeURIComponent(m[2])], link_location: window.trackLocation(reg) })", $html);

        // The floating WhatsApp button names its place
        $this->assertMatchesRegularExpression('#id="global-float-wa"\s+data-track-location="floating"#', $html);

        // The home page links to course registration, so the tap is measurable there
        $this->assertStringContainsString('/register/', $html);
        $this->assertNoPersonalData($html);
    }

    public function test_the_main_buttons_name_their_place_on_the_page(): void
    {
        $expected = [
            '/'              => ['top-banner', 'november-courses', 'visit-center', 'sticky-bar', 'floating'],
            '/consultations' => ['hero', 'steps', 'final-cta', 'sticky-bar', 'floating'],
            '/sessions'      => ['hero', 'installments', 'special-needs', 'final-cta'],
            '/packages'      => ['hero'],
            '/register/anger-management' => ['course-page'],
        ];
        foreach ($expected as $page => $places) {
            $html = $this->get($page)->assertOk()->getContent();
            foreach ($places as $place) {
                $this->assertStringContainsString('data-track-location="' . $place . '"', $html, "$page: $place");
            }
        }
    }

    public function test_pages_with_forms_still_send_no_personal_data(): void
    {
        foreach (['/', '/courses', '/consultations', '/sessions', '/packages'] as $page) {
            foreach (['ar', 'en'] as $locale) {
                $this->assertNoPersonalData($this->withSession(['locale' => $locale])->get($page)->assertOk()->getContent());
            }
        }
    }
}
