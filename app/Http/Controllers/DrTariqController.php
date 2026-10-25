<?php

namespace App\Http\Controllers;

use App\Models\ConsultationBooking;
use App\Services\CenterSystem;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * "Book with Dr. Tariq" on the day set in Admin → Content — the customer only leaves a request (in person or by phone,
 * name and number). It goes to the center system (motmaina-center.com), where the
 * secretaries see it on the Dr. Tariq appointments page and call back to fix the time and the fee.
 */
class DrTariqController extends Controller
{
    /** The customer doesn't pick a type — the secretaries ask on the call. */
    public const TOPIC = 'استشارة مع د. طارق (حياتية / اجتماعية / تربوية)';

    public const MODES = [
        'in_person' => ['ar' => 'حضوري بالمركز', 'en' => 'In person'],
        'phone'     => ['ar' => 'هاتفية', 'en' => 'By phone'],
    ];

    public function store(Request $request, CenterSystem $center)
    {
        $data = $request->validate([
            'name'    => 'nullable|string|max:120',
            'phone'   => ['required', 'string', 'regex:/^\+?[0-9\s\-]{8,16}$/'],
            'mode'    => ['required', Rule::in(array_keys(self::MODES))],
            'notes'   => 'nullable|string|max:300',
            'website' => 'nullable|max:0', // honeypot
        ], [
            'phone.required' => $this->t('اكتب رقم جوالك عشان نتواصل معك', 'Please enter your phone number'),
            'phone.regex'    => $this->t('رقم الجوال غير صحيح', 'Invalid phone number'),
            'mode.required'  => $this->t('اختار حضوري أو هاتفي', 'Choose in person or by phone'),
        ]);

        $digits = preg_replace('/\D/', '', $data['phone']);
        if (strlen($digits) === 11 && str_starts_with($digits, '965')) $digits = substr($digits, 3);

        $booking = ConsultationBooking::create([
            'kind'         => 'dr_tariq',
            'name'         => filled($data['name'] ?? null) ? trim($data['name']) : null,
            'phone'        => $digits,
            'problem_type' => self::TOPIC,
            'mode'         => self::MODES[$data['mode']]['ar'],
            'notes'        => $data['notes'] ?? null,
        ]);

        $center->pushDoctorRequest($booking);

        $message = $this->t(
            'وصل طلبك ✓ قسم المواعيد رح يتواصل معك على رقمك لتأكيد موعدك.',
            'Request received ✓ Our appointments team will call you to confirm your appointment.'
        );

        return $request->expectsJson()
            ? response()->json(['ok' => true, 'message' => $message])
            : back()->with('drt_ok', $message);
    }

    /** The day Dr. Tariq sees people (Admin → Content), or null when unset or already past (Kuwait time). */
    public static function day(): ?\Carbon\Carbon
    {
        $value = \App\Models\SiteSetting::current()['dr_tariq_date'] ?? \App\Models\SiteSetting::DEFAULTS['dr_tariq_date'];
        if (blank($value)) return null;

        try {
            $day = \Carbon\Carbon::parse($value, 'Asia/Kuwait')->startOfDay();
        } catch (\Throwable) {
            return null;
        }

        return $day->lt(now('Asia/Kuwait')->startOfDay()) ? null : $day;
    }

    private function t(string $ar, string $en): string
    {
        return app()->getLocale() === 'ar' ? $ar : $en;
    }
}
