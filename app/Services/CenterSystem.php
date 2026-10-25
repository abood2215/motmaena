<?php

namespace App\Services;

use App\Models\ConsultationBooking;
use App\Models\CourseOffer;
use App\Models\CourseRegistration;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Sends paid course registrations to the center's internal system (motmaina-center.com),
 * which finds the client's file by phone (or opens one) and adds a check + invoice for the course.
 * Also sends "Thursday with Dr. Tariq" requests, which show up there on the Dr. Tariq appointments page
 * with a 📅 notification for the secretaries.
 */
class CenterSystem
{
    public function enabled(): bool
    {
        return filled(config('services.center.url')) && filled(config('services.center.token'));
    }

    /** Sends one paid registration. Never throws: the outcome is saved on the registration. */
    public function push(CourseRegistration $registration): bool
    {
        if (!$this->enabled() || $registration->status !== 'paid' || $registration->center_rec_id) {
            return (bool) $registration->center_rec_id;
        }

        $code = CourseOffer::where('slug', $registration->course_key)->value('center_course_code');
        if (blank($code)) {
            return $this->failed($registration, 'الدورة ما إلها "كود الدورة بالنظام" — حطّه من تعديل الدورة');
        }

        $payment = match ($registration->payment_method) {
            'deema'    => 'deema',
            'discount' => 'discount',
            default    => 'myfatoorah',
        };

        try {
            $response = Http::withHeaders(['X-Website-Token' => config('services.center.token')])
                ->acceptJson()->timeout(20)
                ->post(rtrim(config('services.center.url'), '/') . '/api/website/registrations', [
                    'registration_id' => $registration->id,
                    'name'            => $registration->name,
                    'phone'           => $registration->phone,
                    'email'           => $registration->email,
                    'course_code'     => $code,
                    'original_amount' => (float) $registration->original_amount,
                    'discount_amount' => (float) $registration->discount_amount,
                    'paid_amount'     => (float) $registration->final_amount,
                    'discount_code'   => $registration->discount_code,
                    'payment'         => $payment,
                    'gateway'         => $registration->payment_method,
                    'payment_ref'     => $registration->payment_id,
                    'source'          => mb_substr($registration->sourceLabel(), 0, 80),
                    'paid_at'         => ($registration->paid_at ?? now())->toIso8601String(),
                ]);
        } catch (\Throwable $e) {
            return $this->failed($registration, 'تعذّر الاتصال بالنظام: ' . $e->getMessage());
        }

        if (!$response->successful() || !$response->json('ok')) {
            return $this->failed($registration, $response->json('message') ?: 'ردّ النظام برقم ' . $response->status());
        }

        $registration->update([
            'center_patient_id' => $response->json('patient_id'),
            'center_rec_id'     => $response->json('rec_id'),
            'center_synced_at'  => now(),
            'center_error'      => null,
        ]);

        return true;
    }

    /** Sends one Dr. Tariq appointment request. Never throws: the outcome is saved on the booking. */
    public function pushDoctorRequest(ConsultationBooking $booking): bool
    {
        if (!$this->enabled() || $booking->crm_task_id) {
            return (bool) $booking->crm_task_id;
        }

        $source = session('visit_source', []);

        try {
            $response = Http::withHeaders(['X-Website-Token' => config('services.center.token')])
                ->acceptJson()->timeout(15)
                ->post(rtrim(config('services.center.url'), '/') . '/api/website/doctor-requests', [
                    'request_id' => $booking->id,
                    'name'       => $booking->name,
                    'phone'      => $booking->phone,
                    'topic'      => $booking->problem_type,
                    'mode'       => $booking->mode,
                    'notes'      => $booking->notes,
                    'source'     => mb_substr((string) ($source['utm_source'] ?? $source['referrer'] ?? ''), 0, 80) ?: null,
                ]);
        } catch (\Throwable $e) {
            return $this->requestFailed($booking, 'تعذّر الاتصال بالنظام: ' . $e->getMessage());
        }

        if (!$response->successful() || !$response->json('ok')) {
            return $this->requestFailed($booking, $response->json('message') ?: 'ردّ النظام برقم ' . $response->status());
        }

        $booking->update(['crm_task_id' => $response->json('id'), 'crm_error' => null]);

        return true;
    }

    private function requestFailed(ConsultationBooking $booking, string $error): bool
    {
        Log::warning('Center system doctor request failed', ['booking' => $booking->id, 'error' => $error]);
        $booking->update(['crm_error' => mb_substr($error, 0, 255)]);

        return false;
    }

    private function failed(CourseRegistration $registration, string $error): bool
    {
        Log::warning('Center system sync failed', ['registration' => $registration->id, 'error' => $error]);
        $registration->update(['center_error' => mb_substr($error, 0, 255)]);

        return false;
    }
}
