<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\SiteSetting;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function index()
    {
        return view('admin.content', [
            'settings'     => SiteSetting::current(),
            'faqs'         => Faq::orderBy('sort')->get(),
            'testimonials' => Testimonial::orderBy('sort')->get(),
        ]);
    }

    public function updateSettings(Request $request)
    {
        $digits = fn ($v) => preg_replace('/\D/', '', (string) $v);
        $request->merge(['whatsapp' => $digits($request->whatsapp), 'phone' => $digits($request->phone)]);

        $data = $request->validate([
            'whatsapp'        => 'required|digits_between:8,15',
            'phone'           => 'required|digits_between:8,15',
            'address_ar'      => 'required|string|max:200',
            'address_en'      => 'nullable|string|max:200',
            'announcement_ar' => 'nullable|string|max:160',
            'announcement_en' => 'nullable|string|max:160',
            'gift_code_kwd'   => 'nullable|numeric|min:0|max:1000',
            'dr_tariq_date'   => 'nullable|date_format:Y-m-d',
        ], [
            'whatsapp.digits_between' => 'رقم الواتساب غير صحيح — اكتبه مع مفتاح الدولة مثل 96555665161',
            'phone.digits_between'    => 'رقم الهاتف غير صحيح — اكتبه مع مفتاح الدولة مثل 96599880140',
        ]);

        if ($request->has('dr_tariq_thursday')) $data['dr_tariq_thursday'] = $request->boolean('dr_tariq_thursday') ? '1' : '0';
        if ($request->has('psych_soon')) $data['psych_soon'] = $request->boolean('psych_soon') ? '1' : '0';

        // Local 8-digit Kuwaiti numbers get the country code
        foreach (['whatsapp', 'phone'] as $k) {
            if (strlen($data[$k]) === 8) $data[$k] = '965' . $data[$k];
        }

        // Text fields may be cleared; referral numbers left out of the form keep their current value
        $clearable = ['address_en', 'announcement_ar', 'announcement_en', 'dr_tariq_date'];
        SiteSetting::setMany(array_filter($data, fn ($v, $k) => $v !== null || in_array($k, $clearable, true), ARRAY_FILTER_USE_BOTH));

        return back()->with('ok', 'تم حفظ معلومات الموقع');
    }

    // ─── Ad / analytics tracking ───

    public function updateTracking(Request $request)
    {
        // People often paste the whole <meta …> tag or a script line: keep just the ID / token
        $clean = function (?string $v): string {
            $v = trim((string) $v);
            if (preg_match('/content\s*=\s*["\']([^"\']+)["\']/i', $v, $m)) $v = $m[1];
            return trim($v, " \t\n\r\0\x0B\"'");
        };
        $request->merge(collect(array_keys(SiteSetting::TRACKING))->mapWithKeys(fn ($k) => [$k => $clean($request->input($k))])->all());
        $request->merge(['tr_ga4' => strtoupper($request->input('tr_ga4')), 'tr_tiktok_pixel' => strtoupper($request->input('tr_tiktok_pixel'))]);

        $data = $request->validate([
            'tr_ga4'                 => ['nullable', 'regex:/^G-[A-Z0-9]{4,20}$/'],
            'tr_meta_pixel'          => ['nullable', 'regex:/^\d{8,20}$/'],
            'tr_tiktok_pixel'        => ['nullable', 'regex:/^[A-Z0-9]{10,30}$/'],
            'tr_snap_pixel'          => ['nullable', 'regex:/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i'],
            'tr_google_verification' => ['nullable', 'regex:/^[A-Za-z0-9_\-]{20,100}$/'],
            'tr_meta_verification'   => ['nullable', 'regex:/^[a-z0-9]{20,60}$/i'],
        ], [
            'tr_ga4.regex'                 => 'رقم Google Analytics لازم يبلّش بـ G- (مثل G-AB12CD34EF)',
            'tr_meta_pixel.regex'          => 'Meta Pixel ID أرقام بس (مثل 123456789012345)',
            'tr_tiktok_pixel.regex'        => 'TikTok Pixel ID حروف إنجليزية وأرقام (مثل C1ABCDEF2GHIJ3KLMN4O)',
            'tr_snap_pixel.regex'          => 'Snap Pixel ID بالشكل 1a2b3c4d-1234-5678-9abc-1234567890ab',
            'tr_google_verification.regex' => 'كود تحقق Google غير صحيح — الصق الكود من Search Console (طريقة HTML tag)',
            'tr_meta_verification.regex'   => 'كود تحقق Meta غير صحيح — الصق الكود من Business Settings → Domains',
        ]);

        SiteSetting::setMany(array_map(fn ($v) => $v ?: null, $data)); // empty = turned off

        return back()->with('ok', 'تم حفظ إعدادات التتبّع — بتشتغل فوراً بالموقع')->withFragment('tracking');
    }

    // ─── FAQ ───

    public function storeFaq(Request $request)
    {
        Faq::create($this->faqData($request) + ['sort' => (Faq::max('sort') ?? 0) + 1]);
        return back()->with('ok', 'تمت إضافة السؤال');
    }

    public function updateFaq(Request $request, Faq $faq)
    {
        $faq->update($this->faqData($request));
        return back()->with('ok', 'تم حفظ السؤال');
    }

    public function destroyFaq(Faq $faq)
    {
        $faq->delete();
        return back()->with('ok', 'تم حذف السؤال');
    }

    private function faqData(Request $request): array
    {
        return $request->validate([
            'question_ar' => 'required|string|max:300',
            'answer_ar'   => 'required|string|max:3000',
            'question_en' => 'nullable|string|max:300',
            'answer_en'   => 'nullable|string|max:3000',
            'sort'        => 'nullable|integer|min:0|max:1000',
        ]) + ['is_active' => $request->boolean('is_active', true)];
    }

    // ─── Testimonials ───

    public function storeTestimonial(Request $request)
    {
        Testimonial::create($this->testimonialData($request) + ['sort' => (Testimonial::max('sort') ?? 0) + 1]);
        return back()->with('ok', 'تمت إضافة الرأي');
    }

    public function updateTestimonial(Request $request, Testimonial $testimonial)
    {
        $testimonial->update($this->testimonialData($request));
        return back()->with('ok', 'تم حفظ الرأي');
    }

    public function destroyTestimonial(Testimonial $testimonial)
    {
        $testimonial->delete();
        return back()->with('ok', 'تم حذف الرأي');
    }

    private function testimonialData(Request $request): array
    {
        return $request->validate([
            'name'     => 'required|string|max:120',
            'subtitle' => 'nullable|string|max:120',
            'quote'    => 'required|string|max:1000',
            'rating'   => 'required|integer|min:1|max:5',
            'sort'     => 'nullable|integer|min:0|max:1000',
        ]) + ['is_active' => $request->boolean('is_active', true)];
    }
}
