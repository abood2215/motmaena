@extends('admin.layout')

@section('title', 'تسجيلات الدورات')

@section('actions')
  <a href="{{ route('admin.registrations.export') }}" class="btn btn-outline btn-sm">&#8595; تصدير</a>
@endsection

@section('content')
@php $labels = ['paid' => 'مدفوع', 'pending' => 'بانتظار الدفع', 'failed' => 'فشل / ملغي']; @endphp

<div class="stats-grid">
  <div class="stat-card" style="--c:#b04141"><div class="num">{{ $stats['total'] }}</div><div class="lbl">إجمالي التسجيلات</div></div>
  <div class="stat-card" style="--c:#059669"><div class="num">{{ $stats['paid'] }}</div><div class="lbl">مدفوع</div></div>
  <div class="stat-card" style="--c:#d97706"><div class="num">{{ $stats['pending'] }}</div><div class="lbl">بانتظار الدفع</div></div>
  <div class="stat-card" style="--c:#2563eb"><div class="num">{{ rtrim(rtrim(number_format($stats['revenue'], 3), '0'), '.') }}</div><div class="lbl">الإيراد (د.ك)</div></div>
</div>

<div class="filter-bar">
  <a href="{{ route('admin.registrations') }}" class="filter-btn {{ !request('status') ? 'active' : '' }}">الكل</a>
  @foreach($labels as $key => $label)
    <a href="{{ route('admin.registrations', ['status' => $key]) }}" class="filter-btn {{ request('status') === $key ? 'active' : '' }}">{{ $label }}</a>
  @endforeach
</div>

<div class="table-card">
  <div class="table-scroll">
    @if($registrations->isEmpty())
      <div class="empty">لا توجد تسجيلات بعد</div>
    @else
    <table>
      <thead>
        <tr>
          <th>#</th><th>الاسم</th><th>الهاتف</th><th>الدورة</th><th>كود الخصم</th><th>المدفوع</th><th>الحالة</th><th>التاريخ</th><th></th>
        </tr>
      </thead>
      <tbody>
        @foreach($registrations as $r)
        <tr>
          <td class="small">{{ $r->id }}</td>
          <td>
            <strong>{{ $r->name }}</strong>
            @if($r->email)<div class="small ltr">{{ $r->email }}</div>@endif
          </td>
          <td>
            @php $digits = preg_replace('/\D/', '', $r->phone); @endphp
            <a class="ltr" href="https://wa.me/{{ strlen($digits) === 8 ? '965' . $digits : ltrim($digits, '0') }}" target="_blank" style="color:inherit;font-weight:700">{{ $r->phone }}</a>
          </td>
          <td class="small">{{ $r->offer()['title']['ar'] ?? $r->course_key }}</td>
          <td>
            @if($r->discount_code)
              <span class="tag code">{{ $r->discount_code }}</span>
              <div class="small">- {{ rtrim(rtrim(number_format($r->discount_amount, 3), '0'), '.') }} د.ك</div>
            @else
              <span class="small">—</span>
            @endif
          </td>
          <td><strong>{{ rtrim(rtrim(number_format($r->final_amount, 3), '0'), '.') }}</strong> <span class="small">د.ك</span></td>
          <td>
            <span class="tag {{ $r->status }}">{{ $labels[$r->status] ?? $r->status }}</span>
            @if($r->payment_method)<div class="small">{{ $r->payment_method }}</div>@endif
          </td>
          <td class="small">
            {{ $r->created_at->timezone('Asia/Kuwait')->format('Y-m-d H:i') }}
            @if($r->invoice_id)<div>فاتورة: <span class="ltr">{{ $r->invoice_id }}</span></div>@endif
          </td>
          <td>
            @if($r->status !== 'paid' && $r->invoice_id)
            <form method="POST" action="{{ route('admin.registrations.verify', $r) }}" class="inline">
              @csrf
              <button class="btn btn-outline btn-sm" title="التحقق من حالة الدفع في ماي فاتورة">&#8635; تحقق</button>
            </form>
            @endif
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    @endif
  </div>
</div>
@endsection
