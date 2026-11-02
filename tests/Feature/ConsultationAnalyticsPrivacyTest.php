<?php

namespace Tests\Feature;

use App\Models\ConsultationBooking;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/** Booking a consultation is counted in analytics as a lead only: its type and notes never leave for Google. */
class ConsultationAnalyticsPrivacyTest extends TestCase
{
    use RefreshDatabase;

    /** @return array<int, string> the argument list of every trackEvent(...) call on the page */
    private function trackEventCalls(string $html): array
    {
        preg_match_all('#trackEvent\(\s*\'(?:Lead|Contact|Purchase|InitiateCheckout)\'[^;]*\)#', $html, $m);
        return $m[0];
    }

    public function test_the_lead_event_carries_no_consultation_type_or_notes(): void
    {
        foreach (['ar', 'en'] as $locale) {
            $html = $this->withSession(['locale' => $locale])->get('/consultations')->assertOk()->getContent();

            // The one lead event of the booking form, and nothing else in it
            $this->assertStringContainsString("trackEvent('Lead', { content_name: 'consultation' })", $html);
            $this->assertStringNotContainsString('content_category', $html);

            foreach ($this->trackEventCalls($html) as $call) {
                foreach (['problem_type', 'type', 'notes', 'phone', 'content_category'] as $field) {
                    $this->assertDoesNotMatchRegularExpression('/\b' . $field . '\b/', $call, "\"$field\" sent to analytics in: $call");
                }
            }
        }

        // Same rule for the other pages with request forms (Dr. Tariq request, notify-me)
        foreach (['/', '/courses'] as $page) {
            foreach ($this->trackEventCalls($this->get($page)->getContent()) as $call) {
                $this->assertDoesNotMatchRegularExpression('/\b(problem_type|notes|phone|content_category)\b/', $call, $call);
            }
        }
    }

    public function test_the_booking_itself_is_still_saved_in_full(): void
    {
        $payload = ['phone' => '+96555551234', 'problem_type' => 'استشارة أسرية', 'notes' => 'ملاحظة للأخصائي'];

        $this->postJson('/consultations/book', $payload)->assertOk()->assertJson(['ok' => true]);

        $booking = ConsultationBooking::sole();
        $this->assertSame('+96555551234', $booking->phone);
        $this->assertSame('استشارة أسرية', $booking->problem_type);
        $this->assertSame('ملاحظة للأخصائي', $booking->notes);
    }
}
