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

{{-- ═══ Gift codes: issued automatically after paying without a code — one use each, any course ═══ --}}
<div class="card" id="gifts">
  <h3>🎁 أكواد الهدايا <span class="small">(تطلع تلقائياً لكل واحد يدفع بدون كود · لأي دورة · تنستخدم مرة وحدة بس)</span></h3>
  <div class="stats-grid" style="margin:12px 0 0">
    <div class="stat-card" style="--c:#b04141"><div class="num">{{ $giftStats['issued'] }}</div><div class="lbl">انعطت</div></div>
    <div class="stat-card" style="--c:#059669"><div class="num">{{ $giftStats['available'] }}</div><div class="lbl">متاحة (لسا ما انستخدمت)</div></div>
    <div class="stat-card" style="--c:#d97706"><div class="num">{{ $giftStats['held'] }}</div><div class="lbl">محجوزة بدفع جاري</div></div>
    <div class="stat-card" style="--c:#6b7280"><div class="num">{{ $giftStats['used'] }}</div><div class="lbl">انستخدمت</div></div>
  </div>
</div>

<div class="table-card">
  <div class="table-scroll">
    @if($gifts->isEmpty())
      <div class="empty">لسا ما انعطى ولا كود هدية</div>
    @else
    <table>
      <thead>
        <tr><th>الكود</th><th>انعطى لـ</th><th>الحالة</th><th>استخدمه</th><th></th></tr>
      </thead>
      <tbody>
        @foreach($gifts as $g)
        @php
            $owner = $g->owner;
            $use   = $g->paidUses->first();
            $hold  = $holds[$g->id] ?? null;
        @endphp
        <tr>
          <td>
            <span class="tag code">{{ $g->code }}</span>
            <div class="small">{{ rtrim(rtrim(number_format((float) $g->value, 3), '0'), '.') }} د.ك · لأي دورة</div>
          </td>
          <td class="small">
            @if($owner)
              <strong>{{ $owner->name }}</strong> · <span class="ltr">{{ $owner->phone }}</span>
              <div>دفع لـ: {{ $titles[$owner->course_key] ?? $owner->course_key }}</div>
              <div>{{ ($owner->paid_at ?? $g->created_at)->format('Y-m-d') }}</div>
            @else
              —
            @endif
          </td>
          <td>
            @if($g->paidUses->count() > 1)
              <span class="tag failed">⚠️ انستخدم {{ $g->paidUses->count() }} مرات</span>
            @elseif($use)
              <span class="tag off">✓ انستخدم</span>
            @elseif(!$g->is_active)
              <span class="tag off">موقوف</span>
            @elseif($hold)
              <span class="tag pending">⏳ محجوز بدفع جاري</span>
              <div class="small">{{ $hold->name }} · <span class="ltr">{{ $hold->phone }}</span></div>
            @else
              <span class="tag on">متاح</span>
            @endif
          </td>
          <td class="small">
            @forelse($g->paidUses as $u)
              <div>
                <strong>{{ $u->name }}</strong> · <span class="ltr">{{ $u->phone }}</span>
                @if($owner && $u->phone === $owner->phone)<span class="tag code" style="font-size:10px">صاحب الكود نفسه</span>@endif
                <div>{{ $titles[$u->course_key] ?? $u->course_key }} · خصم {{ rtrim(rtrim(number_format((float) $u->discount_amount, 3), '0'), '.') }} د.ك · دفع {{ number_format((float) $u->final_amount, 3) }} د.ك</div>
                <div>{{ $u->paid_at?->format('Y-m-d H:i') }}</div>
              </div>
            @empty
              —
            @endforelse
          </td>
          <td style="white-space:nowrap">
            @if(!$use)
            <form method="POST" action="{{ route('admin.codes.toggle', $g) }}" class="inline" onsubmit="return confirm('{{ $g->is_active ? 'إيقاف' : 'تفعيل' }} الكود {{ $g->code }}؟')">
              @csrf
              <button class="btn btn-outline btn-sm">{{ $g->is_active ? 'إيقاف' : 'تفعيل' }}</button>
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
