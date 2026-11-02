<?php

namespace Tests\Feature;

use App\Livewire\CourseGrid;
use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/** Phase 3: shorter pages, the booking form always in view, the way to each service near the top. */
class Phase3UxTest extends TestCase
{
    use RefreshDatabase;

    public function test_recorded_courses_show_twelve_then_more(): void
    {
        foreach (range(1, 15) as $i) {
            Course::create(['title' => 'دورة رقم ' . $i, 'description' => 'وصف', 'price' => 0, 'level' => 'عام', 'external_url' => 'https://example.com/' . $i]);
        }

        app()->setLocale('ar');
        Livewire::test(CourseGrid::class)
            ->assertViewHas('courses', fn ($c) => $c->count() === 12)
            ->assertSee('عرض المزيد من الدورات')
            ->call('loadMore')
            ->assertViewHas('courses', fn ($c) => $c->count() === 15)
            ->assertDontSee('عرض المزيد من الدورات')
            ->set('search', 'رقم 1')                       // a new search starts again from the first 12
            ->assertSet('perPage', 12);
    }

    public function test_the_consultation_form_is_in_view_and_needs_the_terms_ticked(): void
    {
        $html = $this->get('/consultations')->assertOk()->getContent();

        $this->assertStringContainsString('id="booking-form"', $html);
        $this->assertMatchesRegularExpression('#<input type="checkbox" id="consent-check" required>#', $html);
        // The booking form is no longer hidden behind the terms, and WhatsApp buttons are not blocked
        $this->assertStringNotContainsString('booking-form-wrap', $html);
        $this->assertStringNotContainsString('toggleBookingForm', $html);
        // Quiet design: no live "online now" bar, no emoji markers
        foreach (['متواجدون الآن', '😔', '💔', '⚠️'] as $gone) {
            $this->assertStringNotContainsString($gone, $html);
        }
    }

    public function test_homepage_leads_with_the_services(): void
    {
        $html = $this->get('/')->assertOk()->getContent();
        $services = strpos($html, 'كيف نقدر نساعدك؟');
        $courses = strpos($html, 'id="courses"');
        $this->assertNotFalse($services);
        $this->assertTrue($courses === false || $services < $courses, 'services come before the course list');
    }

    public function test_every_redesigned_page_uses_the_shared_look_in_both_languages(): void
    {
        foreach (['/', '/courses', '/consultations', '/sessions', '/register/anger-management'] as $page) {
            foreach (['ar', 'en'] as $locale) {
                $this->withSession(['locale' => $locale])->get($page)->assertOk()->assertSee('class="lx', false);
            }
        }
    }
}
