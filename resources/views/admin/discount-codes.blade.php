@extends('admin.layout')

@section('title', 'أكواد الخصم')

@section('content')

<div class="card">
  <h3>&#10133; إضافة كود جديد</h3>
  <form method="POST" action="{{ route('admin.codes.store') }}" class="form-grid">
    @csrf
    <div>
      <label>الكود</label>
      <input name="code" value="{{ old('code') }}" required maxlength="40" dir="ltr" placeholder="ANGER10" style="text-transform:uppercase">
    </div>
    <div>
      <label>نوع الخصم</label>
      <select name="type">
        <option value="percent" @selected(old('type') === 'percent')>نسبة %</option>
        <option value="fixed" @selected(old('type') === 'fixed')>مبلغ ثابت (د.ك)</option>
      </select>
    </div>
    <div>
      <label>القيمة</label>
      <input name="value" type="number" step="0.001" min="0.001" value="{{ old('value') }}" required>
    </div>
    <div>
      <label>الدورة</label>
      <select name="course_key">
        <option value="">كل الدورات</option>
        @foreach($offers as $key => $offer)
          <option value="{{ $key }}" @selected(old('course_key') === $key)>{{ $offer['title']['ar'] }}</option>
        @endforeach
      </select>
    </div>
    <div>
      <label>أقصى عدد استخدام (فارغ = بلا حد)</label>
      <input name="max_uses" type="number" min="1" value="{{ old('max_uses') }}">
    </div>
    <div>
      <label>ينتهي بتاريخ (اختياري)</label>
      <input name="expires_at" type="date" value="{{ old('expires_at') }}">
    </div>
    <div style="grid-column:1/-1">
      <button class="btn btn-primary">إضافة الكود</button>
    </div>
  </form>
</div>

<div class="table-card">
  <div class="table-scroll">
    @if($codes->isEmpty())
      <div class="empty">لا توجد أكواد خصم بعد</div>
    @else
    <table>
      <thead>
        <tr><th>الكود</th><th>الخصم</th><th>الدورة</th><th>الاستخدام</th><th>ينتهي</th><th>الحالة</th><th></th></tr>
      </thead>
      <tbody>
        @foreach($codes as $c)
        @php $reason = $c->unusableReason($c->course_key ?? ''); @endphp
        <tr>
          <td><span class="tag code">{{ $c->code }}</span></td>
          <td><strong>{{ $c->type === 'percent' ? rtrim(rtrim($c->value, '0'), '.') . '%' : rtrim(rtrim($c->value, '0'), '.') . ' د.ك' }}</strong></td>
          <td class="small">{{ $c->course_key ? ($offers[$c->course_key]['title']['ar'] ?? $c->course_key) : 'كل الدورات' }}</td>
          <td>{{ $c->used_count }} / {{ $c->max_uses ?? '∞' }}</td>
          <td class="small">{{ $c->expires_at?->format('Y-m-d') ?? '—' }}</td>
          <td>
            @if(!$c->is_active)
              <span class="tag off">موقوف</span>
            @elseif($reason === 'expired')
              <span class="tag off">منتهي</span>
            @elseif($reason === 'used_up')
              <span class="tag off">مستنفد</span>
            @else
              <span class="tag on">فعّال</span>
            @endif
          </td>
          <td style="white-space:nowrap">
            <form method="POST" action="{{ route('admin.codes.toggle', $c) }}" class="inline">
              @csrf
              <button class="btn btn-outline btn-sm">{{ $c->is_active ? 'إيقاف' : 'تفعيل' }}</button>
            </form>
            <form method="POST" action="{{ route('admin.codes.destroy', $c) }}" class="inline" onsubmit="return confirm('حذف الكود {{ $c->code }}؟')">
              @csrf @method('DELETE')
              <button class="btn btn-outline btn-sm" style="color:#b91c1c">حذف</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    @endif
  </div>
</div>
@endsection
