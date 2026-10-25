<?php

namespace App\Services;

use App\Models\ConsultationBooking;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Sends Dr. Tariq appointment requests to the call-center CRM (crm.motmaina-center.com),
 * which turns each one into a call task and notifies the staff so they call the customer back.
 */
class CrmSystem
{
    public function enabled(): bool
    {
        return filled(config('services.crm.url')) && filled(config('services.crm.token'));
    }

    /** Never throws: the outcome is saved on the booking. */
    public function pushDoctorRequest(ConsultationBooking $booking): bool
    {
        if (!$this->enabled() || $booking->crm_task_id) {
            return (bool) $booking->crm_task_id;
        }

        try {
            $response = Http::withHeaders(['X-Website-Token' => config('services.crm.token')])
                ->acceptJson()->timeout(15)
                ->post(rtrim(config('services.crm.url'), '/') . '/api/website/doctor-requests', [
                    'request_id' => $booking->id,
                    'name'       => $booking->name,
                    'phone'      => $booking->phone,
                    'topic'      => $booking->problem_type,
                    'mode'       => $booking->mode,
                    'notes'      => $booking->notes,
                    'source'     => mb_substr($this->source(), 0, 80) ?: null,
                ]);
        } catch (\Throwable $e) {
            return $this->failed($booking, 'تعذّر الاتصال بالكول سنتر: ' . $e->getMessage());
        }

        if (!$response->successful() || !$response->json('ok')) {
            return $this->failed($booking, $response->json('message') ?: 'ردّ الكول سنتر برقم ' . $response->status());
        }

        $booking->update(['crm_task_id' => $response->json('task_id'), 'crm_error' => null]);

        return true;
    }

    private function source(): string
    {
        $s = session('visit_source', []);
        return $s['utm_source'] ?? $s['referrer'] ?? '';
    }

    private function failed(ConsultationBooking $booking, string $error): bool
    {
        Log::warning('CRM doctor request failed', ['booking' => $booking->id, 'error' => $error]);
        $booking->update(['crm_error' => mb_substr($error, 0, 255)]);

        return false;
    }
}
