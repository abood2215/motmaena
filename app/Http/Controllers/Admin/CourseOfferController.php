<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseOffer;
use App\Models\CourseRegistration;
use App\Models\DiscountCode;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CourseOfferController extends Controller
{
    public function index()
    {
        $offers = CourseOffer::orderByDesc('date')->get();
        $counts = CourseRegistration::where('status', 'paid')->selectRaw('course_key, count(*) as c, sum(final_amount) as total')
            ->groupBy('course_key')->get()->keyBy('course_key');

        return view('admin.courses.index', compact('offers', 'counts'));
    }

    public function create()
    {
        return view('admin.courses.form', ['offer' => new CourseOffer([
            'trainer_ar' => 'أ.د. طارق الحبيب',
            'trainer_en' => 'Prof. Dr. Tariq Al-Habib',
            'location_ar' => 'حضوري - الكويت، برج أحمد، بجوار المستشفى الأميري',
            'location_en' => 'In-person - Kuwait, Burj Ahmed, near Al-Amiri Hospital',
            'is_active' => true,
        ])]);
    }

    public function store(Request $request)
    {
        $offer = CourseOffer::create($this->validated($request));
        $this->handleFeatured($offer);

        return redirect()->route('admin.courses')->with('ok', "تمت إضافة الدورة «{$offer->title_ar}»");
    }

    public function edit(CourseOffer $offer)
    {
        return view('admin.courses.form', compact('offer'));
    }

    public function update(Request $request, CourseOffer $offer)
    {
        $data = $this->validated($request, $offer);

        if ($offer->slug !== $data['slug'] && CourseRegistration::where('course_key', $offer->slug)->exists()) {
            // Old registrations point at the slug; keep their history intact
            CourseRegistration::where('course_key', $offer->slug)->update(['course_key' => $data['slug']]);
        }
        DiscountCode::where('course_key', $offer->slug)->update(['course_key' => $data['slug']]);

        $offer->update($data);
        $this->handleFeatured($offer);

        return redirect()->route('admin.courses')->with('ok', "تم حفظ «{$offer->title_ar}»");
    }

    public function toggle(CourseOffer $offer, string $field)
    {
        abort_unless(in_array($field, ['is_active', 'is_featured'], true), 404);

        $offer->update([$field => !$offer->$field]);
        $this->handleFeatured($offer);

        return back()->with('ok', 'تم التحديث');
    }

    public function destroy(CourseOffer $offer)
    {
        if (CourseRegistration::where('course_key', $offer->slug)->exists()) {
            return back()->with('error', 'لا يمكن حذف دورة عليها تسجيلات — أوقف التسجيل فيها بدلاً من الحذف.');
        }

        $offer->delete();

        return back()->with('ok', 'تم حذف الدورة');
    }

    /** Only one course is featured on the homepage at a time. */
    private function handleFeatured(CourseOffer $offer): void
    {
        if ($offer->is_featured) {
            CourseOffer::whereKeyNot($offer->id)->update(['is_featured' => false]);
        }
    }

    private function validated(Request $request, ?CourseOffer $offer = null): array
    {
        $request->merge(['slug' => Str::slug($request->input('slug') ?: $request->input('title_en') ?: Str::random(6))]);

        $data = $request->validate([
            'title_ar'       => 'required|string|max:150',
            'title_en'       => 'nullable|string|max:150',
            'slug'           => ['required', 'alpha_dash', 'max:60', Rule::unique('course_offers', 'slug')->ignore($offer?->id)],
            'trainer_ar'     => 'required|string|max:120',
            'trainer_en'     => 'nullable|string|max:120',
            'price'          => 'required|numeric|min:0|max:100000',
            'date'           => 'required|date',
            'time_ar'        => 'nullable|string|max:80',
            'time_en'        => 'nullable|string|max:80',
            'location_ar'    => 'nullable|string|max:200',
            'location_en'    => 'nullable|string|max:200',
            'certificate_ar' => 'nullable|string|max:200',
            'certificate_en' => 'nullable|string|max:200',
            'topics_ar'      => 'nullable|string|max:3000',
            'topics_en'      => 'nullable|string|max:3000',
            'image_file'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ], [
            'slug.unique' => 'هذا الرابط مستخدم لدورة أخرى',
            'image_file.image' => 'الملف يجب أن يكون صورة',
            'image_file.max' => 'حجم الصورة يجب ألا يتجاوز 4MB',
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $data['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $name = $data['slug'] . '-' . time() . '.' . $file->extension();
            $file->move(public_path('uploads/courses'), $name);
            $data['image'] = 'uploads/courses/' . $name;
        } elseif ($request->boolean('remove_image')) {
            $data['image'] = null;
        }
        unset($data['image_file']);

        return $data;
    }
}
