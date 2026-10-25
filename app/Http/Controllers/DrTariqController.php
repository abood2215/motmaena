<?php

namespace App\Http\Controllers;

use App\Models\ConsultationBooking;
use App\Services\CenterSystem;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * "Book with Dr. Tariq on Thursday" — the customer only leaves a request (topic, in person or
 * by phone, name and number). It goes to the center system (motmaina-center.com), where the
 * secretaries see it on the Dr. Tariq appointments page and call back to fix the time and the fee.
 */
class DrTariqController extends Controller
{
    public const TOPICS = [
        'life'      => ['ar' => 'استشارة حياتية', 'en' => 'Life counselling'],
        'social'    => ['ar' => 'استشارة اجتماعية', 'en' => 'Social counselling'],
        'parenting' => ['ar' => 'استشارة تربوية', 'en' => 'Parenting counselling'],
    ];

    public const MODES = [
        'in_person' => ['ar' => 'حضوري بالمركز', 'en' => 'In person'],
        'phone'     => ['ar' => 'هاتفية', 'en' => 'By phone'],
    ];

    public function store(Request $request, CenterSystem $center)
    {
        $data = $request->validate([
            'name'    => 'nullable|string|max:120',
            'phone'   => ['required', 'string', 'regex:/^\+?[0-9\s\-]{8,16}$/'],
            'topic'   => ['required', Rule::in(array_keys(self::TOPICS))],
            'mode'    => ['required', Rule::in(array_keys(self::MODES))],
            'notes'   => 'nullable|string|max:300',
            'website' => 'nullable|max:0', // honeypot
        ], [
            'phone.required' => $this->t('اكتب رقم جوالك عشان نتواصل معك', 'Please enter your phone number'),
            'phone.regex'    => $this->t('رقم الجوال غير صحيح', 'Invalid phone number'),
            'topic.required' => $this->t('اختار نوع الاستشارة', 'Choose the type of counselling'),
            'mode.required'  => $this->t('اختار حضوري أو هاتفي', 'Choose in person or by phone'),
        ]);

        $digits = preg_replace('/\D/', '', $data['phone']);
        if (strlen($digits) === 11 && str_starts_with($digits, '965')) $digits = substr($digits, 3);

        $booking = ConsultationBooking::create([
            'kind'         => 'dr_tariq',
            'name'         => filled($data['name'] ?? null) ? trim($data['name']) : null,
            'phone'        => $digits,
            'problem_type' => self::TOPICS[$data['topic']]['ar'],
            'mode'         => self::MODES[$data['mode']]['ar'],
            'notes'        => $data['notes'] ?? null,
        ]);

        $center->pushDoctorRequest($booking);

        $message = $this->t(
            'وصل طلبك ✓ قسم المواعيد رح يتواصل معك على رقمك لتأكيد موعدك يوم الخميس.',
            'Request received ✓ Our appointments team will call you to confirm your Thursday slot.'
        );

        return $request->expectsJson()
            ? response()->json(['ok' => true, 'message' => $message])
            : back()->with('drt_ok', $message);
    }

    /** The coming Thursday (today if it is Thursday), Kuwait time. */
    public static function nextThursday(): \Carbon\Carbon
    {
        $now = now('Asia/Kuwait');
        return $now->isThursday() ? $now->startOfDay() : $now->next(\Carbon\Carbon::THURSDAY);
    }

    private function t(string $ar, string $en): string
    {
        return app()->getLocale() === 'ar' ? $ar : $en;
    }
}
