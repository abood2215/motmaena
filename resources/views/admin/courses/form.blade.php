@extends('admin.layout')

@section('title', $offer->exists ? 'تعديل دورة' : 'دورة جديدة')

@section('actions')
  <a href="{{ route('admin.courses') }}" class="btn btn-outline btn-sm">← رجوع</a>
@endsection

@section('content')
@php $v = fn ($field) => old($field, $offer->$field); @endphp

@isset($duplicateOf)
<div class="alert ok">نسخة من «{{ $duplicateOf->title_ar }}» — غيّر الاسم والتاريخ واللي بدك ياه، والباقي (التصميم، الصورة، المحاور) محفوظ.</div>
@endisset

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
        <label>عدد المقاعد (فاضي = بدون حد)</label>
        <input name="seats" type="number" min="1" max="10000" value="{{ $v('seats') }}" placeholder="مثلاً 30">
        <p class="hint">لما تمتلي المقاعد المدفوعة، التسجيل بيتسكّر لحاله وبيطلع "اكتمل العدد".</p>
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
    <h3>🎨 تصميم الإعلان</h3>
    <div class="field-grid">
      <div class="full">
        <label>لون الإعلان والإطار</label>
        <div class="row-actions" id="theme-swatches">
          @foreach(\App\Models\CourseOffer::THEMES as $hex => $name)
            <button type="button" title="{{ $name }}" data-hex="{{ $hex }}" onclick="pickTheme('{{ $hex }}')"
                    style="width:38px;height:38px;border-radius:12px;border:3px solid #fff;box-shadow:0 0 0 1.5px var(--border);cursor:pointer;background:linear-gradient(135deg, {{ $hex }}, {{ $hex }}99)"></button>
          @endforeach
          <label class="check" style="margin:0 8px">أو لون مخصص:
            <input type="color" name="theme_color" id="theme_color" value="{{ old('theme_color', $offer->theme_color ?: \App\Models\CourseOffer::DEFAULT_THEME) }}" oninput="previewTheme()" style="width:46px;height:34px;padding:0;border:none;background:none">
          </label>
        </div>
        <div id="theme-preview" style="margin-top:12px;border-radius:16px;padding:16px 18px;color:#fff;display:flex;justify-content:space-between;align-items:center;gap:12px">
          <div>
            <div id="pv-badge" style="display:inline-block;font-size:11px;font-weight:800;padding:4px 10px;border-radius:99px;background:rgba(255,255,255,.18);margin-bottom:6px"></div>
            <div style="font-size:20px;font-weight:900"><span id="pv-accent"></span> <span id="pv-rest"></span></div>
          </div>
          <span id="pv-btn" style="font-weight:900;font-size:13px;padding:9px 16px;border-radius:10px;background:#fff">سجّل وادفع الآن</span>
        </div>
        <p class="hint">معاينة تقريبية — كل ألوان الإعلان وصفحة الدفع بتتولّد من هاللون.</p>
      </div>
      <div>
        <label>النص الصغير فوق العنوان (عربي)</label>
        <input name="badge_ar" id="badge_ar" value="{{ $v('badge_ar') }}" maxlength="80" placeholder="دورة جديدة · التسجيل مفتوح" oninput="previewTheme()">
      </div>
      <div>
        <label>النص الصغير فوق العنوان (إنجليزي)</label>
        <input name="badge_en" value="{{ $v('badge_en') }}" maxlength="80" dir="ltr" placeholder="New course · Registration open">
      </div>
      <div class="full">
        <input type="hidden" name="show_installments" value="0">
        <label class="check"><input type="checkbox" name="show_installments" value="1" @checked(old('show_installments', $offer->show_installments ?? true))> إظهار "deema — قسّط على 4 دفعات" جنب السعر</label>
      </div>
    </div>
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
            <input type="hidden" name="copy_image" value="{{ $offer->exists ? '' : $offer->image }}">
            <label class="check"><input type="checkbox" name="remove_image" value="1"> رجوع للصورة الافتراضية</label>
          @else
            <span class="hint">حالياً: صورة الدكتور الافتراضية</span>
          @endif
        </div>
      </div>
      <div>
        <label>صورة المشاركة (اللي بتطلع لما حدا يبعت الرابط على واتساب/إنستغرام) — البوستر مثلاً</label>
        <input type="file" name="share_file" accept="image/png,image/jpeg,image/webp">
        <div class="row-actions" style="margin-top:8px">
          @if($offer->share_image)
            <img src="{{ asset($offer->share_image) }}" alt="" style="height:44px;border-radius:8px">
            <input type="hidden" name="copy_share" value="{{ $offer->exists ? '' : $offer->share_image }}">
            <label class="check"><input type="checkbox" name="remove_share" value="1"> إزالة</label>
          @else
            <span class="hint">بدون صورة بيطلع شعار المركز. الأفضل مقاس 1200×630.</span>
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

<script>
function mixWhite(hex, w) {
  var n = parseInt(hex.slice(1), 16), r = n >> 16, g = (n >> 8) & 255, b = n & 255;
  var f = function (c) { return Math.round(c + (255 - c) * w).toString(16).padStart(2, '0'); };
  return '#' + f(r) + f(g) + f(b);
}
function previewTheme() {
  var hex = document.getElementById('theme_color').value;
  var title = (document.querySelector('[name=title_ar]').value || 'دورة إدارة الغضب').split(' ');
  document.getElementById('theme-preview').style.background = 'linear-gradient(270deg,' + hex + ',' + mixWhite(hex, .18) + ',' + mixWhite(hex, .5) + ')';
  document.getElementById('pv-accent').style.color = mixWhite(hex, .72);
  document.getElementById('pv-accent').textContent = title[0];
  document.getElementById('pv-rest').textContent = title.slice(1).join(' ');
  document.getElementById('pv-badge').textContent = document.getElementById('badge_ar').value || 'دورة جديدة · التسجيل مفتوح';
  document.getElementById('pv-btn').style.color = hex;
  document.querySelectorAll('#theme-swatches [data-hex]').forEach(function (b) {
    b.style.boxShadow = b.dataset.hex === hex ? '0 0 0 3px ' + hex : '0 0 0 1.5px var(--border)';
  });
}
function pickTheme(hex) { document.getElementById('theme_color').value = hex; previewTheme(); }
document.querySelector('[name=title_ar]').addEventListener('input', previewTheme);
previewTheme();
</script>
@endsection
