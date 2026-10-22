@extends('admin.layout')

@section('title', 'قائمة "بلّغني"')

@section('actions')
  <a href="{{ route('admin.leads.export') }}" class="btn btn-outline btn-sm">&#8595; تصدير</a>
@endsection

@section('content')
<div class="stats-grid">
  <div class="stat-card" style="--c:#b04141"><div class="num">{{ $leads->count() }}</div><div class="lbl">{{ request('filter') === 'new' ? 'بانتظار التواصل' : 'إجمالي الأرقام' }}</div></div>
  <div class="stat-card" style="--c:#d97706"><div class="num">{{ $newCount }}</div><div class="lbl">لسا ما تواصلنا معهم</div></div>
</div>

<div class="card">
  <h3>📣 بلّغهم بالدورة الجاية</h3>
  <p class="small" style="margin-bottom:10px">اختار الدورة، وبعدين اضغط "واتساب" جنب كل رقم — بتنفتح رسالة جاهزة فيها رابط التسجيل. أو انسخ كل الأرقام لقائمة بث واتساب.</p>
  <div class="row-actions">
    <select id="lead-course" style="border:1.5px solid var(--border);border-radius:10px;padding:8px 10px;font-family:inherit">
      @foreach($courses as $c)
        <option value="{{ route('course.register', $c->slug) }}" data-title="{{ $c->title_ar }}" data-date="{{ $c->date->locale('ar')->translatedFormat('l j F') }}">{{ $c->title_ar }} — {{ $c->date->format('Y-m-d') }}</option>
      @endforeach
      @if($courses->isEmpty())<option value="{{ route('home') }}" data-title="" data-date="">(ما في دورة مفتوحة حالياً)</option>@endif
    </select>
    <button type="button" class="btn btn-outline btn-sm" onclick="copyNumbers(this)">📋 نسخ كل الأرقام اللي ما تواصلنا معهم</button>
  </div>
</div>

<div class="filter-bar">
  <a href="{{ route('admin.leads') }}" class="filter-btn {{ !request('filter') ? 'active' : '' }}">الكل</a>
  <a href="{{ route('admin.leads', ['filter' => 'new']) }}" class="filter-btn {{ request('filter') === 'new' ? 'active' : '' }}">لسا ما تواصلنا</a>
</div>

<div class="table-card">
  <div class="table-scroll">
    @if($leads->isEmpty())
      <div class="empty">ما في أرقام بعد — النموذج موجود بالصفحة الرئيسية وبصفحة أي دورة مكتملة.</div>
    @else
    <table>
      <thead><tr><th>الرقم</th><th>الاسم</th><th>مهتم بـ</th><th>المصدر</th><th>التاريخ</th><th>الحالة</th><th></th></tr></thead>
      <tbody>
        @foreach($leads as $l)
        @php $wa = strlen($l->phone) === 8 ? '965' . $l->phone : ltrim($l->phone, '0'); @endphp
        <tr data-phone="{{ $wa }}" data-new="{{ $l->contacted_at ? 0 : 1 }}">
          <td><strong class="ltr">{{ $l->phone }}</strong></td>
          <td>{{ $l->name ?: '—' }}</td>
          <td class="small">{{ $titles[$l->course_key] ?? 'أي دورة' }}</td>
          <td class="small">{{ $l->utm_source ?: ($l->referrer ?: 'مباشر') }}</td>
          <td class="small">{{ $l->updated_at->format('Y-m-d') }}</td>
          <td>@if($l->contacted_at)<span class="tag on">تم التواصل</span>@else<span class="tag pending">جديد</span>@endif</td>
          <td>
            <div class="row-actions">
              <a href="#" class="btn btn-sm" style="background:#25d366;color:#fff" onclick="return sendLead('{{ $wa }}')">واتساب</a>
              <form method="POST" action="{{ route('admin.leads.contacted', $l) }}" class="inline">@csrf
                <button class="btn btn-outline btn-sm">{{ $l->contacted_at ? 'إرجاع لجديد' : 'تم التواصل ✓' }}</button>
              </form>
              <form method="POST" action="{{ route('admin.leads.destroy', $l) }}" class="inline" onsubmit="return confirm('حذف الرقم؟')">@csrf @method('DELETE')
                <button class="btn btn-outline btn-sm" style="color:#b91c1c">حذف</button>
              </form>
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    @endif
  </div>
</div>

<script>
function sendLead(phone) {
  var sel = document.getElementById('lead-course'), opt = sel.options[sel.selectedIndex];
  var msg = 'مرحباً 🌷\nطلبت منا نبلّغك بالدورات الجديدة في مركز مطمئنة.\n';
  if (opt.dataset.title) msg += '\nانفتح التسجيل في ' + opt.dataset.title + ' — ' + opt.dataset.date + '.\n';
  msg += '\nللتسجيل: ' + opt.value;
  window.open('https://wa.me/' + phone + '?text=' + encodeURIComponent(msg), '_blank');
  return false;
}
function copyNumbers(btn) {
  var nums = Array.from(document.querySelectorAll('tr[data-new="1"]')).map(function (r) { return '+' + r.dataset.phone; });
  navigator.clipboard.writeText(nums.join('\n'));
  btn.textContent = 'تم نسخ ' + nums.length + ' رقم ✓';
}
</script>
@endsection
