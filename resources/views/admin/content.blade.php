@extends('admin.layout')

@section('title', 'محتوى الموقع')

@section('content')

{{-- ═══ Contact + announcement ═══ --}}
<div class="card">
  <h3>📞 معلومات التواصل وشريط الإعلان</h3>
  <form method="POST" action="{{ route('admin.content.settings') }}">
    @csrf
    <div class="field-grid">
      <div>
        <label>رقم الواتساب (مع مفتاح الدولة)</label>
        <input name="whatsapp" value="{{ old('whatsapp', $settings['whatsapp']) }}" dir="ltr" required>
        <p class="hint">بيتغيّر بكل أزرار الواتساب بالموقع.</p>
      </div>
      <div>
        <label>رقم الهاتف للاتصال</label>
        <input name="phone" value="{{ old('phone', $settings['phone']) }}" dir="ltr" required>
      </div>
      <div>
        <label>العنوان (عربي)</label>
        <input name="address_ar" value="{{ old('address_ar', $settings['address_ar']) }}" required maxlength="200">
      </div>
      <div>
        <label>العنوان (إنجليزي)</label>
        <input name="address_en" value="{{ old('address_en', $settings['address_en']) }}" maxlength="200" dir="ltr">
      </div>
      <div>
        <label>نص شريط الإعلان أعلى الصفحة الرئيسية (عربي)</label>
        <input name="announcement_ar" value="{{ old('announcement_ar', $settings['announcement_ar']) }}" maxlength="160" placeholder="فاضي = يطلع اسم الدورة المميّزة وتاريخها وسعرها تلقائياً">
      </div>
      <div>
        <label>نص شريط الإعلان (إنجليزي)</label>
        <input name="announcement_en" value="{{ old('announcement_en', $settings['announcement_en']) }}" maxlength="160" dir="ltr">
      </div>
      <div>
        <label>🎁 قيمة كود الهدية (د.ك) — 0 يوقفه</label>
        <input name="gift_code_kwd" type="number" step="0.5" min="0" max="1000" value="{{ old('gift_code_kwd', $settings['gift_code_kwd']) }}" required>
        <p class="hint">كل اللي بيدفع بدون كود خصم بياخد كود هدية بهالقيمة، مرة وحدة على أي دورة (إله أو لحدا بيهديه).</p>
      </div>
      <div class="full">
        <input type="hidden" name="dr_tariq_thursday" value="0">
        <label class="check"><input type="checkbox" name="dr_tariq_thursday" value="1" @checked(old('dr_tariq_thursday', $settings['dr_tariq_thursday']) === '1')> 📅 إظهار "اطلب موعدك مع د. طارق يوم الخميس" (الرئيسية وصفحة الاستشارات)</label>
        <p class="hint">الطلبات بتوصل للكول سنتر كمهمة اتصال + إشعار، وبتطلع كمان بصفحة الاستشارات هون. شيل الصح إذا اكتملت مواعيد الخميس.</p>
      </div>
      <div class="full">
        <input type="hidden" name="psych_soon" value="0">
        <label class="check"><input type="checkbox" name="psych_soon" value="1" @checked(old('psych_soon', $settings['psych_soon']) === '1')> 🧠 إظهار إعلان "المركز النفسي — قريباً" بالصفحة الرئيسية</label>
        <p class="hint">اللي بيسجّلوا أرقامهم فيه بيطلعوا بصفحة "بلّغني" تحت "المركز النفسي (قريباً)". شيل الصح لما يفتح المركز.</p>
      </div>
    </div>
    <div style="margin-top:12px"><button class="btn btn-primary">حفظ</button></div>
  </form>
</div>

{{-- ═══ Testimonials ═══ --}}
<div class="card">
  <h3>💬 آراء المتدربين <span class="small">(القسم بيظهر بالصفحة الرئيسية بس إذا في رأي واحد ظاهر على الأقل — حط آراء حقيقية فقط وبإذن أصحابها)</span></h3>

  @foreach($testimonials as $t)
  <details class="edit-box">
    <summary>
      <span>@if($t->registration_id && !$t->is_active)<span class="tag pending">تقييم جديد من متدرب</span> @endif{{ $t->name }} <span style="color:#f59e0b">{{ str_repeat('★', $t->rating) }}</span> <span class="small">— {{ \Illuminate\Support\Str::limit($t->quote, 60) }}</span></span>
      <span class="tag {{ $t->is_active ? 'on' : 'off' }}">{{ $t->is_active ? 'ظاهر' : 'مخفي' }}</span>
    </summary>
    <form method="POST" action="{{ route('admin.content.testimonials.update', $t) }}" class="field-grid">
      @csrf @method('PUT')
      @include('admin.partials.testimonial-fields', ['t' => $t])
      <div class="full row-actions">
        <button class="btn btn-primary btn-sm">حفظ</button>
        <button form="del-t-{{ $t->id }}" class="btn btn-outline btn-sm" style="color:#b91c1c">حذف</button>
      </div>
    </form>
    <form id="del-t-{{ $t->id }}" method="POST" action="{{ route('admin.content.testimonials.destroy', $t) }}" onsubmit="return confirm('حذف الرأي؟')">@csrf @method('DELETE')</form>
  </details>
  @endforeach

  <details class="edit-box" @if($testimonials->isEmpty()) open @endif>
    <summary><span>+ إضافة رأي جديد</span></summary>
    <form method="POST" action="{{ route('admin.content.testimonials.store') }}" class="field-grid">
      @csrf
      @include('admin.partials.testimonial-fields', ['t' => new \App\Models\Testimonial(['rating' => 5, 'is_active' => true])])
      <div class="full"><button class="btn btn-primary btn-sm">إضافة</button></div>
    </form>
  </details>
</div>

{{-- ═══ FAQ ═══ --}}
<div class="card">
  <h3>❓ الأسئلة الشائعة بالصفحة الرئيسية</h3>

  @foreach($faqs as $f)
  <details class="edit-box">
    <summary>
      <span>{{ $f->question_ar }}</span>
      <span class="tag {{ $f->is_active ? 'on' : 'off' }}">{{ $f->is_active ? 'ظاهر' : 'مخفي' }}</span>
    </summary>
    <form method="POST" action="{{ route('admin.content.faqs.update', $f) }}" class="field-grid">
      @csrf @method('PUT')
      @include('admin.partials.faq-fields', ['f' => $f])
      <div class="full row-actions">
        <button class="btn btn-primary btn-sm">حفظ</button>
        <button form="del-f-{{ $f->id }}" class="btn btn-outline btn-sm" style="color:#b91c1c">حذف</button>
      </div>
    </form>
    <form id="del-f-{{ $f->id }}" method="POST" action="{{ route('admin.content.faqs.destroy', $f) }}" onsubmit="return confirm('حذف السؤال؟')">@csrf @method('DELETE')</form>
  </details>
  @endforeach

  <details class="edit-box">
    <summary><span>+ إضافة سؤال جديد</span></summary>
    <form method="POST" action="{{ route('admin.content.faqs.store') }}" class="field-grid">
      @csrf
      @include('admin.partials.faq-fields', ['f' => new \App\Models\Faq(['is_active' => true])])
      <div class="full"><button class="btn btn-primary btn-sm">إضافة</button></div>
    </form>
  </details>
</div>
@endsection
