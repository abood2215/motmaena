@extends('admin.layout')

@section('title', $offer->exists ? 'تعديل دورة' : 'دورة جديدة')

@section('actions')
  <a href="{{ route('admin.courses') }}" class="btn btn-outline btn-sm">← رجوع</a>
@endsection

@section('content')
@php $v = fn ($field) => old($field, $offer->$field); @endphp

<form method="POST" enctype="multipart/form-data"
      action="{{ $offer->exists ? route('admin.courses.update', $offer) : route('admin.courses.store') }}">
  @csrf
  @if($offer->exists) @method('PUT') @endif

  <div class="card">
    <h3>معلومات الدورة</h3>
    <div class="field-grid">
      <div>
        <label>اسم الدورة (عربي) *</label>
        <input name="title_ar" value="{{ $v('title_ar') }}" required maxlength="150" placeholder="دورة إدارة الغضب">
      </div>
      <div>
        <label>اسم الدورة (إنجليزي)</label>
        <input name="title_en" value="{{ $v('title_en') }}" maxlength="150" dir="ltr" placeholder="Anger Management Course">
      </div>
      <div>
        <label>المدرّب (عربي) *</label>
        <input name="trainer_ar" value="{{ $v('trainer_ar') }}" required maxlength="120">
      </div>
      <div>
        <label>المدرّب (إنجليزي)</label>
        <input name="trainer_en" value="{{ $v('trainer_en') }}" maxlength="120" dir="ltr">
      </div>
      <div>
        <label>السعر (د.ك) *</label>
        <input name="price" type="number" step="0.001" min="0" value="{{ $v('price') !== null ? rtrim(rtrim(number_format((float) $v('price'), 3, '.', ''), '0'), '.') : '' }}" required>
      </div>
      <div>
        <label>التاريخ *</label>
        <input name="date" type="date" value="{{ old('date', $offer->date?->format('Y-m-d')) }}" required>
      </div>
      <div>
        <label>الوقت (عربي)</label>
        <input name="time_ar" value="{{ $v('time_ar') }}" maxlength="80" placeholder="7:00 - 9:00 مساءً">
      </div>
      <div>
        <label>الوقت (إنجليزي)</label>
        <input name="time_en" value="{{ $v('time_en') }}" maxlength="80" dir="ltr" placeholder="7:00 - 9:00 PM">
      </div>
      <div>
        <label>المكان (عربي)</label>
        <input name="location_ar" value="{{ $v('location_ar') }}" maxlength="200">
      </div>
      <div>
        <label>المكان (إنجليزي)</label>
        <input name="location_en" value="{{ $v('location_en') }}" maxlength="200" dir="ltr">
      </div>
      <div>
        <label>الشهادة (عربي)</label>
        <input name="certificate_ar" value="{{ $v('certificate_ar') }}" maxlength="200" placeholder="شهادة معتمدة من ...">
      </div>
      <div>
        <label>الشهادة (إنجليزي)</label>
        <input name="certificate_en" value="{{ $v('certificate_en') }}" maxlength="200" dir="ltr">
      </div>
      <div>
        <label>المحاور (عربي) — كل محور بسطر</label>
        <textarea name="topics_ar" rows="8">{{ $v('topics_ar') }}</textarea>
      </div>
      <div>
        <label>المحاور (إنجليزي) — كل محور بسطر</label>
        <textarea name="topics_en" rows="8" dir="ltr">{{ $v('topics_en') }}</textarea>
      </div>
    </div>
    <p class="hint">الخانات الإنجليزية اختيارية — إذا تركتها فاضية بيطلع النص العربي بالنسخة الإنجليزية.</p>
  </div>

  <div class="card">
    <h3>الصورة والرابط</h3>
    <div class="field-grid">
      <div>
        <label>صورة المدرّب / الدورة (PNG بخلفية شفافة أفضل)</label>
        <input type="file" name="image_file" accept="image/png,image/jpeg,image/webp">
        <div class="row-actions" style="margin-top:8px">
          <img class="thumb" src="{{ asset($offer->image ?: \App\Models\CourseOffer::DEFAULT_IMAGE) }}" alt="">
          @if($offer->image)
            <label class="check"><input type="checkbox" name="remove_image" value="1"> رجوع للصورة الافتراضية</label>
          @else
            <span class="hint">حالياً: صورة الدكتور الافتراضية</span>
          @endif
        </div>
      </div>
      <div>
        <label>رابط الصفحة (إنجليزي، بدون مسافات)</label>
        <input name="slug" value="{{ $v('slug') }}" maxlength="60" dir="ltr" placeholder="anger-management">
        <p class="hint ltr">{{ url('/register') }}/<strong>{{ $v('slug') ?: '...' }}</strong></p>
        <p class="hint">إذا تركته فاضي بيتعمل من الاسم الإنجليزي.</p>
      </div>
    </div>
  </div>

  <div class="card">
    <label class="check"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $offer->is_active))> التسجيل مفتوح</label>
    <label class="check"><input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $offer->is_featured))> مميّزة (تطلع بإعلان الصفحة الرئيسية)</label>
    <div style="margin-top:14px">
      <button class="btn btn-primary">{{ $offer->exists ? 'حفظ التعديلات' : 'إضافة الدورة' }}</button>
    </div>
  </div>
</form>
@endsection
