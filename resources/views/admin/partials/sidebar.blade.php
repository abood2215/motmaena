<aside class="sidebar" id="sidebar">
  <div class="sb-logo">
    <div class="brand">مطمئنة</div>
    <div class="sub">لوحة التحكم الإدارية</div>
  </div>
  <nav class="sb-nav">
    <a href="{{ route('admin.consultations') }}" class="{{ request()->routeIs('admin.consultations') ? 'active' : '' }}">
      <span class="sb-icon">&#128203;</span>
      الاستشارات
      @if(request()->routeIs('admin.consultations'))<span class="sb-badge" id="sb-badge">0</span>@endif
    </a>
    <a href="{{ route('admin.registrations') }}" class="{{ request()->routeIs('admin.registrations*') ? 'active' : '' }}">
      <span class="sb-icon">&#127891;</span>
      تسجيلات الدورات
    </a>
    <a href="{{ route('admin.codes') }}" class="{{ request()->routeIs('admin.codes*') ? 'active' : '' }}">
      <span class="sb-icon">&#127991;</span>
      أكواد الخصم
    </a>
  </nav>
  <div class="sb-footer">
    <a href="{{ route('admin.logout') }}" class="logout-btn">
      <span>&#x2BA8;</span> تسجيل الخروج
    </a>
  </div>
</aside>
