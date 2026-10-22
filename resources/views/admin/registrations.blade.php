@extends('admin.layout')

@section('title', 'التسجيلات والمتابعة')

@section('actions')
  <a href="{{ route('admin.registrations.export') }}" class="btn btn-outline btn-sm">&#8595; تصدير</a>
@endsection

@section('content')
@php
  $labels = ['paid' => 'مدفوع', 'pending' => 'بانتظار الدفع', 'failed' => 'فشل / ملغي'];
  $kwd = fn ($v) => rtrim(rtrim(number_format((float) $v, 3), '0'), '.');
  $isFollowUp = request('status') === 'followup';
@endphp

<div class="stats-grid">
  <div class="stat-card" style="--c:#b04141"><div class="num">{{ $stats['total'] }}</div><div class="lbl">إجمالي التسجيلات</div></div>
  <div class="stat-card" style="--c:#059669"><div class="num">{{ $stats['paid'] }}</div><div class="lbl">مدفوع</div></div>
  <div class="stat-card" style="--c:#d97706"><div class="num">{{ $stats['pending'] }}</div><div class="lbl">بانتظار الدفع</div></div>
  <div class="stat-card" style="--c:#2563eb"><div class="num">{{ $kwd($stats['revenue']) }}</div><div class="lbl">الإيراد (د.ك)</div></div>
</div>

<div class="filter-bar">
  <a href="{{ route('admin.registrations', ['status' => 'followup']) }}" class="filter-btn {{ $isFollowUp ? 'active' : '' }}">🔔 بحاجة متابعة</a>
  <a href="{{ route('admin.registrations') }}" class="filter-btn {{ !request('status') ? 'active' : '' }}">الكل</a>
  @foreach($labels as $key => $label)
    <a href="{{ route('admin.registrations', ['status' => $key]) }}" class="filter-btn {{ request('status') === $key ? 'active' : '' }}">{{ $label }}</a>
  @endforeach
</div>

@if($isFollowUp)
<div class="card">
  <h3>🔔 ناس بلّشوا التسجيل وما كمّلوا الدفع</h3>
  <p class="small" style="margin-bottom:10px">
    ابعتلهم رسالة واتساب جاهزة فيها رابط الدورة — وإذا بدك، ضيف كود خصم يشجعهم يكمّلوا. بعد ما تتواصل اضغط "تم التواصل" حتى ينشال من القائمة.
  </p>
  <label class="small" style="font-weight:800">كود خصم يُضاف للرسالة (اختياري):</label>
  <select id="fu-code" style="border:1.5px solid var(--border);border-radius:10px;padding:7px 10px;font-family:inherit;margin-inline-start:6px">
    <option value="">بدون كود</option>
    @foreach($codes as $c)
      <option value="{{ $c->code }}">{{ $c->code }} — {{ $c->type === 'percent' ? $kwd($c->value) . '%' : $kwd($c->value) . ' د.ك' }}</option>
    @endforeach
  </select>
  <a href="{{ route('admin.codes') }}" class="small" style="margin-inline-start:8px">+ إنشاء كود</a>
</div>
@endif

<div class="table-card">
  <div class="table-scroll">
    @if($registrations->isEmpty())
      <div class="empty">{{ $isFollowUp ? 'ما في حدا بحاجة متابعة حالياً 👌' : 'لا توجد تسجيلات بعد' }}</div>
    @else
    <table>
      <thead>
        <tr>
          <th>#</th><th>الاسم</th><th>الهاتف</th><th>الدورة</th><th>كود الخصم</th><th>المبلغ</th><th>الحالة</th><th>🎁 الهدية</th><th>المصدر</th><th>التاريخ</th><th></th>
        </tr>
      </thead>
      <tbody>
        @foreach($registrations as $r)
        @php
          $digits = preg_replace('/\D/', '', $r->phone);
          $wa = strlen($digits) === 8 ? '965' . $digits : ltrim($digits, '0');
          $offer = $r->offer();
        @endphp
        <tr>
          <td class="small">{{ $r->id }}</td>
          <td>
            <strong>{{ $r->name }}</strong>
            @if($r->email)<div class="small ltr">{{ $r->email }}</div>@endif
          </td>
          <td><a class="ltr" href="https://wa.me/{{ $wa }}" target="_blank" style="color:inherit;font-weight:700">{{ $r->phone }}</a></td>
          <td class="small">{{ $offer['title']['ar'] ?? $r->course_key }}</td>
          <td>
            @if($r->discount_code)
              <span class="tag code">{{ $r->discount_code }}</span>
              <div class="small">- {{ $kwd($r->discount_amount) }} د.ك</div>
            @else
              <span class="small">—</span>
            @endif
          </td>
          <td><strong>{{ $kwd($r->final_amount) }}</strong> <span class="small">د.ك</span></td>
          <td>
            <span class="tag {{ $r->status }}">{{ $labels[$r->status] ?? $r->status }}</span>
            @if($r->payment_method)<div class="small">{{ $r->payment_method }}</div>@endif
            @if($r->followed_up_at)<div class="small">✓ تم التواصل</div>@endif
          </td>
          <td class="small">
            @if($gift = $r->rewardCode())
              {{ $gift->kind === 'self' ? '🙋 لنفسه' : '👥 لصديق' }}
              <div><span class="tag code">{{ $gift->code }}</span></div>
              <div>{{ $gift->kind === 'self' ? ($gift->used_count ? '✓ استخدمه' : 'لسا ما استخدمه') : 'استخدمه ' . $gift->used_count . ' صديق' }}</div>
            @elseif($r->rewardEligible())
              <span style="color:#d97706">لسا ما اختار</span>
            @else
              —
            @endif
          </td>
          <td class="small">{{ $r->sourceLabel() }}@if($r->utm_campaign)<div>{{ $r->utm_campaign }}</div>@endif</td>
          <td class="small">
            {{ $r->created_at->format('Y-m-d H:i') }}
            @if($r->invoice_id)<div>فاتورة: <span class="ltr">{{ $r->invoice_id }}</span></div>@endif
          </td>
          <td>
            <div class="row-actions">
              @if($isFollowUp)
                <a href="#" class="btn btn-sm" style="background:#25d366;color:#fff"
                   data-wa="{{ $wa }}" data-name="{{ $r->name }}" data-course="{{ $offer['title']['ar'] ?? '' }}"
                   data-link="{{ route('course.register', $r->course_key) }}" onclick="return sendFollowUp(this)">واتساب</a>
                <form method="POST" action="{{ route('admin.registrations.followed', $r) }}" class="inline">@csrf
                  <button class="btn btn-outline btn-sm">تم التواصل ✓</button>
                </form>
              @endif
              @if($r->status !== 'paid' && $r->invoice_id)
              <form method="POST" action="{{ route('admin.registrations.verify', $r) }}" class="inline">@csrf
                <button class="btn btn-outline btn-sm" title="التحقق من حالة الدفع في ماي فاتورة">&#8635; تحقق</button>
              </form>
              @endif
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
function sendFollowUp(btn) {
  var code = (document.getElementById('fu-code') || {}).value || '';
  var d = btn.dataset;
  var msg = 'مرحباً ' + d.name + ' 🌷\n'
          + 'لاحظنا إنك بلّشت التسجيل في ' + d.course + ' وما اكتمل الدفع.\n'
          + 'إذا واجهتك أي مشكلة أو عندك سؤال، إحنا جاهزين نساعدك.\n';
  if (code) msg += '\nوكهدية منا، استخدم كود الخصم ' + code + ' عند التسجيل 🎁\n';
  msg += '\nرابط التسجيل: ' + d.link + '\n\nمركز مطمئنة';
  window.open('https://wa.me/' + d.wa + '?text=' + encodeURIComponent(msg), '_blank');
  return false;
}
</script>
@endsection
