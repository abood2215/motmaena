<?php

namespace App\Http\Controllers;

use App\Models\CourseOffer;
use App\Models\Lead;
use Illuminate\Http\Request;

/** "Notify me about the next course" sign-ups. */
class LeadController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'       => 'nullable|string|max:120',
            'phone'      => ['required', 'string', 'regex:/^\+?[0-9\s\-]{8,16}$/'],
            'course_key' => 'nullable|string|max:60',
            'website'    => 'nullable|max:0', // honeypot: bots fill every field
        ], [
            'phone.regex' => app()->getLocale() === 'ar' ? 'رقم الهاتف غير صحيح' : 'Invalid phone number',
        ]);

        $digits = preg_replace('/\D/', '', $data['phone']);
        $phone = (str_starts_with($digits, '965') && strlen($digits) === 11) ? substr($digits, 3) : $digits;
        $courseKey = ($data['course_key'] ?? null) === Lead::PSYCH_CENTER
            ? Lead::PSYCH_CENTER
            : CourseOffer::where('slug', $data['course_key'] ?? '')->value('slug');
        $source = session('visit_source', []);

        // One row per number; a repeat sign-up just refreshes it back to "not contacted"
        Lead::updateOrCreate(['phone' => $phone], [
            'name'         => $data['name'] ?? null,
            'course_key'   => $courseKey,
            'utm_source'   => $source['utm_source'] ?? null,
            'referrer'     => $source['referrer'] ?? null,
            'contacted_at' => null,
        ]);

        $message = $courseKey === Lead::PSYCH_CENTER
            ? (app()->getLocale() === 'ar' ? 'تم! بنبلّغك على واتساب أول ما يفتح المركز 🌷' : 'Done! We will message you on WhatsApp as soon as the center opens.')
            : (app()->getLocale() === 'ar' ? 'تم! سنرسل لك على واتساب أول ما تنزل الدورة القادمة 🌷' : 'Done! We will message you on WhatsApp when the next course opens.');

        return $request->expectsJson()
            ? response()->json(['ok' => true, 'message' => $message])
            : back()->with('lead_ok', $message);
    }
}
