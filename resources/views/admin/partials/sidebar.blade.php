@php
    $followUpCount = \App\Models\CourseRegistration::needsFollowUp()->get(['phone', 'course_key'])->unique(fn ($r) => $r->phone . '|' . $r->course_key)->count();
    $navLinks = [
        ['route' => 'admin.dashboard',     'match' => 'admin.dashboard',      'icon' => '&#128202;', 'label' => 'الرئيسية'],
        ['route' => 'admin.courses',       'match' => 'admin.courses*',       'icon' => '&#127891;', 'label' => 'الدورات'],
        ['route' => 'admin.registrations', 'match' => 'admin.registrations*', 'icon' => '&#128179;', 'label' => 'التسجيلات والمتابعة', 'badge' => $followUpCount],
        ['route' => 'admin.codes',         'match' => 'admin.codes*',         'icon' => '&#127991;', 'label' => 'أكواد الخصم'],
        ['route' => 'admin.content',       'match' => 'admin.content*',       'icon' => '&#9998;',   'label' => 'محتوى الموقع'],
        ['route' => 'admin.consultations', 'match' => 'admin.consultations',  'icon' => '&#128203;', 'label' => 'الاستشارات'],
    ];
@endphp
<aside class="sidebar" id="sidebar">
  <div class="sb-logo">
    <div class="brand">مطمئنة</div>
    <div class="sub">لوحة التحكم الإدارية</div>
  </div>
  <nav class="sb-nav">
    @foreach($navLinks as $link)
    <a href="{{ route($link['route']) }}" class="{{ request()->routeIs($link['match']) ? 'active' : '' }}">
      <span class="sb-icon">{!! $link['icon'] !!}</span>
      {{ $link['label'] }}
      @if(!empty($link['badge']))
        <span style="margin-inline-start:auto;background:#ef4444;color:#fff;font-size:10px;font-weight:900;border-radius:999px;padding:2px 8px">{{ $link['badge'] }}</span>
      @endif
      @if($link['route'] === 'admin.consultations' && request()->routeIs('admin.consultations'))<span class="sb-badge" id="sb-badge">0</span>@endif
    </a>
    @endforeach
    <a href="{{ route('home') }}" target="_blank">
      <span class="sb-icon">&#8599;</span>
      فتح الموقع
    </a>
  </nav>
  <div class="sb-footer">
    <a href="{{ route('admin.logout') }}" class="logout-btn">
      <span>&#x2BA8;</span> تسجيل الخروج
    </a>
  </div>
</aside>
