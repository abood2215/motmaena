@extends('admin.layout')

@section('title', 'لوحة التحكم')

@php
    $kwd = fn ($v) => rtrim(rtrim(number_format((float) $v, 3), '0'), '.');
@endphp

@section('content')

<div class="stats-grid">
  <div class="stat-card" style="--c:#059669"><div class="num">{{ $kwd($stats['revenue_today']) }}</div><div class="lbl">إيراد اليوم (د.ك)</div></div>
  <div class="stat-card" style="--c:#2563eb"><div class="num">{{ $kwd($stats['revenue_7']) }}</div><div class="lbl">آخر 7 أيام (د.ك)</div></div>
  <div class="stat-card" style="--c:#7c3aed"><div class="num">{{ $kwd($stats['revenue_30']) }}</div><div class="lbl">آخر 30 يوم (د.ك)</div></div>
  <div class="stat-card" style="--c:#b04141"><div class="num">{{ $kwd($stats['revenue_all']) }}</div><div class="lbl">إجمالي الإيراد (د.ك)</div></div>
</div>

<div class="stats-grid">
  <div class="stat-card" style="--c:#059669"><div class="num">{{ $stats['paid'] }}</div><div class="lbl">تسجيل مدفوع</div></div>
  <div class="stat-card" style="--c:#d97706"><div class="num">{{ $stats['conversion'] }}%</div><div class="lbl">نسبة إكمال الدفع</div></div>
  <a href="{{ route('admin.registrations', ['status' => 'followup']) }}" class="stat-card" style="--c:#dc2626;text-decoration:none;color:inherit">
    <div class="num">{{ $stats['follow_up'] }}</div><div class="lbl">بحاجة متابعة ←</div>
  </a>
  <a href="{{ route('admin.consultations') }}" class="stat-card" style="--c:#0891b2;text-decoration:none;color:inherit">
    <div class="num">{{ $stats['consultations_new'] }}</div><div class="lbl">استشارات بانتظار التواصل ←</div>
  </a>
</div>

<div class="card">
  <h3>📈 الإيراد اليومي — آخر 30 يوم (د.ك)</h3>
  <div style="position:relative;height:220px"><canvas id="revenueChart"></canvas></div>
</div>

<div class="dash-grid">
  <div class="card">
    <h3>📣 من وين إجوا الزباين (مدفوع)</h3>
    @forelse($sources as $s)
      <div class="bar-row">
        <span class="bar-label">{{ $s['label'] }}</span>
        <span class="bar"><span style="width: {{ max(4, round($s['count'] / max(1, $sources->max('count')) * 100)) }}%"></span></span>
        <span class="bar-num">{{ $s['count'] }} · {{ $kwd($s['revenue']) }} د.ك</span>
      </div>
    @empty
      <p class="small">لا يوجد بيانات بعد. أضف <span class="ltr">?utm_source=instagram</span> لروابط إعلاناتك حتى تعرف أي إعلان جاب الزبون.</p>
    @endforelse
  </div>

  <div class="card">
    <h3>🏷️ أكثر أكواد الخصم استخداماً</h3>
    @forelse($codes as $c)
      <div class="bar-row">
        <span class="bar-label"><span class="tag code">{{ $c['code'] }}</span></span>
        <span class="bar"><span style="width: {{ max(4, round($c['count'] / max(1, $codes->max('count')) * 100)) }}%"></span></span>
        <span class="bar-num">{{ $c['count'] }} · خصم {{ $kwd($c['discount']) }} د.ك</span>
      </div>
    @empty
      <p class="small">ما انستخدم أي كود خصم بعد.</p>
    @endforelse
  </div>

  <div class="card">
    <h3>🎓 الإيراد حسب الدورة</h3>
    @forelse($courses as $c)
      <div class="bar-row">
        <span class="bar-label">{{ $c['title'] }}</span>
        <span class="bar"><span style="width: {{ max(4, round($c['revenue'] / max(1, $courses->max('revenue')) * 100)) }}%"></span></span>
        <span class="bar-num">{{ $c['count'] }} · {{ $kwd($c['revenue']) }} د.ك</span>
      </div>
    @empty
      <p class="small">لا يوجد تسجيلات مدفوعة بعد.</p>
    @endforelse
  </div>

  <div class="card">
    <h3>🎁 الإحالات (سجّل مع صديق)</h3>
    @forelse($referrals as $r)
      <div class="bar-row">
        <span class="bar-label"><strong>{{ $r['owner']?->name ?? '—' }}</strong> <span class="small ltr">{{ $r['owner']?->phone }}</span> <span class="tag code">{{ $r['code'] }}</span></span>
        <span class="bar"><span style="width: {{ max(4, round($r['friends'] / max(1, $referrals->max('friends')) * 100)) }}%"></span></span>
        <span class="bar-num">{{ $r['friends'] }} صديق · رصيد {{ $kwd($r['credit']) }} د.ك</span>
      </div>
    @empty
      <p class="small">لسا ما حدا سجّل بكود صديق. الكود بيطلع لكل عميل بعد الدفع مع زر مشاركة واتساب.</p>
    @endforelse
  </div>

  <div class="card">
    <h3>🕒 آخر التسجيلات المدفوعة</h3>
    @forelse($latest as $r)
      <div class="bar-row">
        <span class="bar-label"><strong>{{ $r->name }}</strong> <span class="small">{{ $r->offer()['title']['ar'] ?? $r->course_key }}</span></span>
        <span class="bar-num">{{ $kwd($r->final_amount) }} د.ك · {{ $r->paid_at?->diffForHumans() }}</span>
      </div>
    @empty
      <p class="small">لا يوجد تسجيلات مدفوعة بعد.</p>
    @endforelse
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
new Chart(document.getElementById('revenueChart'), {
  type: 'bar',
  data: {
    labels: @json($chart->keys()->map(fn ($d) => \Carbon\Carbon::parse($d)->format('d/m'))->values()),
    datasets: [{ data: @json($chart->values()), backgroundColor: '#b04141', borderRadius: 6, maxBarThickness: 22 }]
  },
  options: {
    maintainAspectRatio: false,
    plugins: { legend: { display: false } },
    scales: { y: { beginAtZero: true, ticks: { precision: 0 } }, x: { grid: { display: false } } }
  }
});
</script>
@endsection
