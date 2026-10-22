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
        ], [
            'whatsapp.digits_between' => 'رقم الواتساب غير صحيح — اكتبه مع مفتاح الدولة مثل 96555665161',
            'phone.digits_between'    => 'رقم الهاتف غير صحيح — اكتبه مع مفتاح الدولة مثل 96599880140',
        ]);

        // Local 8-digit Kuwaiti numbers get the country code
        foreach (['whatsapp', 'phone'] as $k) {
            if (strlen($data[$k]) === 8) $data[$k] = '965' . $data[$k];
        }

        SiteSetting::setMany($data);

        return back()->with('ok', 'تم حفظ معلومات الموقع');
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
