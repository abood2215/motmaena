<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>لوحة الاستشارات — مطمئنة</title>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<style>
@import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;600;700;800;900&display=swap');
*{box-sizing:border-box;margin:0;padding:0}
:root{
  --bg:#f0ebe4;
  --surface:#fff;
  --border:#e5ddd5;
  --red:#b04141;
  --red-light:#fdf2f2;
  --text:#1a1a1a;
  --muted:#6b7280;
  --sidebar:#16110d;
  --sidebar-w:240px;
  --top:60px;
}
body{font-family:'Tajawal',sans-serif;background:var(--bg);color:var(--text);min-height:100vh;display:flex}

/* ── Sidebar ── */
.sidebar{
  width:var(--sidebar-w);min-width:var(--sidebar-w);
  background:var(--sidebar);
  height:100vh;position:fixed;right:0;top:0;
  display:flex;flex-direction:column;
  z-index:200;
  transition:.3s;
}
.sb-logo{padding:20px 20px 14px;border-bottom:1px solid rgba(255,255,255,.07)}
.sb-logo .brand{font-size:22px;font-weight:900;color:#f87171;letter-spacing:-.5px}
.sb-logo .sub{font-size:11px;color:rgba(255,255,255,.35);margin-top:2px}
.sb-nav{padding:14px 0;flex:1;overflow-y:auto}
.sb-nav a{
  display:flex;align-items:center;gap:10px;
  padding:11px 20px;font-size:13.5px;font-weight:600;
  color:rgba(255,255,255,.55);text-decoration:none;
  transition:.15s;border-right:3px solid transparent;
  position:relative;
}
.sb-nav a:hover{color:#fff;background:rgba(255,255,255,.05);border-right-color:rgba(248,113,113,.4)}
.sb-nav a.active{color:#f87171;background:rgba(248,113,113,.08);border-right-color:#f87171}
.sb-nav .icon{font-size:16px;min-width:20px;text-align:center}
.sb-badge{
  background:#ef4444;color:#fff;font-size:10px;font-weight:800;
  border-radius:999px;padding:1px 7px;margin-right:auto;
  display:none;
}
.sb-badge.visible{display:inline-block}
.sb-footer{padding:16px 20px;border-top:1px solid rgba(255,255,255,.07)}
.logout-btn{
  display:flex;align-items:center;gap:8px;
  color:rgba(255,255,255,.4);font-size:13px;font-weight:600;
  text-decoration:none;padding:8px 0;transition:.15s;
}
.logout-btn:hover{color:#f87171}

/* ── Main ── */
.main{margin-right:var(--sidebar-w);flex:1;min-height:100vh;display:flex;flex-direction:column}
.topbar{
  height:var(--top);background:#fff;
  border-bottom:1px solid var(--border);
  display:flex;align-items:center;padding:0 28px;gap:16px;
  position:sticky;top:0;z-index:100;
}
.topbar .page-title{font-size:15px;font-weight:800;color:var(--text)}
.topbar .page-sub{font-size:12px;color:var(--muted);margin-top:2px}
.topbar-actions{margin-right:auto;display:flex;gap:8px;align-items:center}
.btn{
  display:inline-flex;align-items:center;gap:6px;
  padding:8px 16px;border-radius:10px;
  font-size:13px;font-weight:700;font-family:inherit;
  cursor:pointer;border:none;transition:.15s;
  text-decoration:none;
}
.btn-primary{background:var(--red);color:#fff}
.btn-primary:hover{background:#8a3232}
.btn-outline{background:#fff;border:1.5px solid var(--border);color:var(--muted)}
.btn-outline:hover{border-color:var(--red);color:var(--red)}
.btn-green{background:#059669;color:#fff}
.btn-green:hover{background:#047857}
.btn-sm{padding:6px 12px;font-size:12px;border-radius:8px}

/* Auto-refresh badge */
.refresh-dot{width:8px;height:8px;border-radius:50%;background:#10b981;animation:pulse-dot 2s infinite}
@keyframes pulse-dot{0%,100%{opacity:1}50%{opacity:.4}}
.last-refresh{font-size:11px;color:var(--muted)}

.content{padding:24px 28px 40px;flex:1}

/* ── Stats ── */
.stats-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:24px}
.stat-card{
  background:#fff;border:1px solid var(--border);border-radius:16px;
  padding:20px 18px;position:relative;overflow:hidden;
}
.stat-card::before{
  content:'';position:absolute;top:0;left:0;right:0;height:3px;
  background:var(--c);
}
.stat-card .num{font-size:36px;font-weight:900;color:var(--c);line-height:1}
.stat-card .lbl{font-size:12px;color:var(--muted);margin-top:6px;font-weight:600}
.stat-card .trend{font-size:11px;margin-top:4px;color:var(--muted)}
.stat-card .watermark{
  position:absolute;left:-8px;bottom:-12px;
  font-size:70px;opacity:.04;font-weight:900;color:var(--c);
  pointer-events:none;line-height:1;
}

/* ── Charts Row ── */
.charts-row{display:grid;grid-template-columns:2fr 1fr;gap:16px;margin-bottom:24px}
.chart-card{background:#fff;border:1px solid var(--border);border-radius:16px;padding:20px}
.chart-card h3{font-size:14px;font-weight:800;color:var(--text);margin-bottom:16px}
.chart-wrap{position:relative;height:180px}

/* ── Filters Bar ── */
.filters-bar{
  background:#fff;border:1px solid var(--border);border-radius:14px;
  padding:14px 18px;display:flex;gap:10px;align-items:center;
  flex-wrap:wrap;margin-bottom:16px;
}
.filter-btn{
  background:transparent;border:1.5px solid var(--border);
  border-radius:999px;padding:7px 18px;
  font-size:13px;font-weight:700;font-family:inherit;
  cursor:pointer;transition:.15s;color:var(--muted);
}
.filter-btn.active,.filter-btn:hover{background:var(--red);color:#fff;border-color:var(--red)}
.search-wrap{margin-right:auto;position:relative}
.search-input{
  background:#f9f5f1;border:1.5px solid var(--border);
  border-radius:10px;padding:8px 36px 8px 16px;
  font-size:13px;font-family:inherit;outline:none;width:220px;
  transition:border-color .2s;
}
.search-input:focus{border-color:var(--red)}
.search-icon{position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--muted);pointer-events:none;font-size:14px}

/* ── Table ── */
.table-card{background:#fff;border:1px solid var(--border);border-radius:16px;overflow:hidden}
.table-scroll{overflow-x:auto}
table{width:100%;border-collapse:collapse;min-width:800px}
thead{background:#fdf8f3}
th{
  padding:13px 16px;font-size:12px;font-weight:800;
  color:var(--muted);text-align:right;
  border-bottom:1px solid var(--border);white-space:nowrap;text-transform:uppercase;letter-spacing:.3px;
}
td{
  padding:14px 16px;font-size:13.5px;color:var(--text);
  border-bottom:1px solid #f5ede4;vertical-align:middle;
}
tr:last-child td{border-bottom:none}
tr:hover td{background:#fdf8f3}
tr.new-booking td{background:#fffbeb}

.phone-badge{
  display:inline-flex;align-items:center;gap:5px;
  background:#f5ede0;border-radius:8px;padding:5px 10px;
  font-weight:700;font-size:13px;direction:ltr;color:var(--text);
}
.type-tag{
  display:inline-block;background:var(--red-light);color:var(--red);
  border:1px solid rgba(176,65,65,.18);border-radius:999px;
  padding:3px 11px;font-size:12px;font-weight:700;white-space:nowrap;
}
.notes-text{font-size:12px;color:var(--muted);max-width:180px;
  white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.date-text{font-size:11px;color:#9ca3af;white-space:nowrap}
.new-dot{
  display:inline-block;width:8px;height:8px;border-radius:50%;
  background:#ef4444;margin-left:4px;vertical-align:middle;
  animation:pulse-dot 1.5s infinite;
}

/* Status buttons */
.status-form{display:flex;gap:3px;flex-wrap:nowrap}
.status-btn{
  border:1.5px solid transparent;border-radius:999px;
  padding:4px 10px;font-size:11px;font-weight:700;font-family:inherit;
  cursor:pointer;transition:all .15s;white-space:nowrap;
}
.status-btn.pending{background:#fef3c7;color:#92400e;border-color:#fcd34d}
.status-btn.contacted{background:#dbeafe;color:#1e40af;border-color:#93c5fd}
.status-btn.done{background:#d1fae5;color:#065f46;border-color:#6ee7b7}
.status-btn.active-status{box-shadow:0 0 0 2px currentColor;transform:scale(1.05)}

.wa-btn{
  background:#25d366;color:#fff;border:none;border-radius:8px;
  padding:6px 12px;font-size:12px;font-weight:700;font-family:inherit;
  cursor:pointer;text-decoration:none;display:inline-flex;
  align-items:center;gap:4px;transition:background .15s;white-space:nowrap;
}
.wa-btn:hover{background:#1da851}

.detail-btn{
  background:#f5ede0;border:none;border-radius:8px;
  padding:6px 12px;font-size:12px;font-weight:700;font-family:inherit;
  cursor:pointer;color:var(--red);transition:.15s;
}
.detail-btn:hover{background:var(--red-light)}

/* ── Modal ── */
.modal-overlay{
  position:fixed;inset:0;background:rgba(0,0,0,.55);
  z-index:500;display:none;align-items:center;justify-content:center;
  backdrop-filter:blur(4px);
}
.modal-overlay.open{display:flex}
.modal{
  background:#fff;border-radius:20px;width:520px;max-width:95vw;
  max-height:90vh;overflow-y:auto;padding:28px;position:relative;
  animation:modal-in .2s ease;
}
@keyframes modal-in{from{transform:translateY(20px) scale(.97);opacity:0}to{transform:none;opacity:1}}
.modal-close{
  position:absolute;top:16px;left:16px;
  background:#f5ede0;border:none;border-radius:8px;
  width:32px;height:32px;font-size:16px;cursor:pointer;
  display:flex;align-items:center;justify-content:center;color:var(--muted);
  transition:.15s;
}
.modal-close:hover{background:var(--red-light);color:var(--red)}
.modal h2{font-size:18px;font-weight:900;margin-bottom:6px}
.modal .modal-id{font-size:12px;color:var(--muted);margin-bottom:20px}
.modal-grid{display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:16px}
.info-box{background:#fdf8f3;border:1px solid var(--border);border-radius:10px;padding:12px}
.info-box .il{font-size:11px;color:var(--muted);font-weight:700;margin-bottom:4px;text-transform:uppercase}
.info-box .iv{font-size:14px;font-weight:700;color:var(--text)}
.full-notes{background:#fdf8f3;border:1px solid var(--border);border-radius:10px;padding:12px;margin-bottom:16px}
.full-notes .il{font-size:11px;color:var(--muted);font-weight:700;margin-bottom:6px}
.full-notes .iv{font-size:13px;color:var(--text);line-height:1.6}
.admin-notes-area{
  width:100%;border:1.5px solid var(--border);border-radius:10px;
  padding:12px;font-size:13px;font-family:inherit;
  resize:vertical;min-height:90px;outline:none;
  transition:border-color .2s;
}
.admin-notes-area:focus{border-color:var(--red)}
.notes-save-row{display:flex;gap:8px;margin-top:8px;align-items:center}
.notes-saved{font-size:12px;color:#059669;display:none}
.modal-wa-section{
  background:#f0fdf4;border:1px solid #86efac;border-radius:12px;
  padding:14px;margin-top:16px;
}
.modal-wa-section h4{font-size:12px;font-weight:800;color:#065f46;margin-bottom:10px}
.wa-template{
  background:#fff;border:1px solid #bbf7d0;border-radius:8px;
  padding:10px 12px;font-size:12px;color:#065f46;
  cursor:pointer;margin-bottom:6px;transition:.15s;display:block;
  text-align:right;width:100%;font-family:inherit;font-weight:600;
}
.wa-template:hover{background:#dcfce7;border-color:#4ade80}
.wa-template:last-child{margin-bottom:0}

/* Timeline */
.timeline{margin-top:16px}
.timeline h4{font-size:12px;font-weight:800;color:var(--muted);margin-bottom:10px;text-transform:uppercase}
.tl-item{display:flex;gap:10px;align-items:flex-start;margin-bottom:8px;font-size:12px}
.tl-dot{width:8px;height:8px;border-radius:50%;margin-top:4px;flex-shrink:0}
.tl-dot.pending{background:#fcd34d}
.tl-dot.contacted{background:#93c5fd}
.tl-dot.done{background:#6ee7b7}
.tl-dot.created{background:#d1d5db}

/* Empty */
.empty-state{text-align:center;padding:60px 20px;color:var(--muted)}
.empty-state .ei{font-size:42px;display:block;margin-bottom:12px}

/* Toast */
.toast-wrap{position:fixed;bottom:24px;right:24px;z-index:9999;display:flex;flex-direction:column;gap:10px}
.toast{
  background:#1a1a1a;color:#fff;border-radius:12px;
  padding:12px 18px;font-size:13px;font-weight:600;
  display:flex;align-items:center;gap:10px;
  animation:toast-in .3s ease;min-width:260px;max-width:320px;
  box-shadow:0 8px 24px rgba(0,0,0,.25);
}
.toast.success{border-right:4px solid #10b981}
.toast.error{border-right:4px solid #ef4444}
@keyframes toast-in{from{transform:translateX(30px);opacity:0}to{transform:none;opacity:1}}

/* Responsive */
@media(max-width:900px){
  .sidebar{display:none}
  .main{margin-right:0}
  .stats-grid{grid-template-columns:repeat(2,1fr)}
  .charts-row{grid-template-columns:1fr}
}
@media(max-width:600px){
  .stats-grid{grid-template-columns:1fr 1fr}
  .content{padding:16px}
}
</style>
</head>
<body>

{{-- ── Sidebar ── --}}
<aside class="sidebar">
  <div class="sb-logo">
    <div class="brand">مطمئنة</div>
    <div class="sub">لوحة التحكم الإدارية</div>
  </div>
  <nav class="sb-nav">
    <a href="{{ route('admin.consultations') }}" class="active">
      <span class="icon">📋</span> الاستشارات
      <span class="sb-badge" id="sb-new-badge">0</span>
    </a>
  </nav>
  <div class="sb-footer">
    <a href="{{ route('admin.logout') }}" class="logout-btn">
      <span>⎋</span> تسجيل الخروج
    </a>
  </div>
</aside>

{{-- ── Main ── --}}
<div class="main">

  {{-- Top Bar --}}
  <header class="topbar">
    <div>
      <div class="page-title">إدارة الاستشارات</div>
      <div class="page-sub">آخر تحديث: <span id="last-refresh-time">الآن</span></div>
    </div>
    <div class="topbar-actions">
      <span class="refresh-dot" title="تحديث تلقائي كل دقيقة"></span>
      <a href="{{ route('admin.consultations.export') }}" class="btn btn-outline btn-sm">
        ⬇ تصدير CSV
      </a>
    </div>
  </header>

  <div class="content">

    {{-- Stats --}}
    <div class="stats-grid">
      <div class="stat-card" style="--c:#b04141">
        <div class="num" id="st-total">{{ $stats['total'] }}</div>
        <div class="lbl">إجمالي الطلبات</div>
        <div class="watermark">∑</div>
      </div>
      <div class="stat-card" style="--c:#d97706">
        <div class="num" id="st-pending">{{ $stats['pending'] }}</div>
        <div class="lbl">بانتظار التواصل</div>
        <div class="watermark">⏳</div>
      </div>
      <div class="stat-card" style="--c:#2563eb">
        <div class="num" id="st-contacted">{{ $stats['contacted'] }}</div>
        <div class="lbl">تم التواصل</div>
        <div class="watermark">📞</div>
      </div>
      <div class="stat-card" style="--c:#059669">
        <div class="num" id="st-done">{{ $stats['done'] }}</div>
        <div class="lbl">مكتملة</div>
        <div class="watermark">✓</div>
      </div>
    </div>

    {{-- Charts --}}
    <div class="charts-row">
      <div class="chart-card">
        <h3>📈 الحجوزات — آخر 14 يوم</h3>
        <div class="chart-wrap">
          <canvas id="bookingsChart"></canvas>
        </div>
      </div>
      <div class="chart-card">
        <h3>🗂 توزيع أنواع الاستشارات</h3>
        <div class="chart-wrap">
          <canvas id="typeChart"></canvas>
        </div>
      </div>
    </div>

    {{-- Filters --}}
    <div class="filters-bar">
      <button class="filter-btn active" onclick="filterTable('all',this)">الكل ({{ $stats['total'] }})</button>
      <button class="filter-btn" onclick="filterTable('pending',this)">انتظار ({{ $stats['pending'] }})</button>
      <button class="filter-btn" onclick="filterTable('contacted',this)">تواصلنا ({{ $stats['contacted'] }})</button>
      <button class="filter-btn" onclick="filterTable('done',this)">مكتمل ({{ $stats['done'] }})</button>
      <div class="search-wrap">
        <input type="text" class="search-input" id="search-input" placeholder="ابحث باسم أو رقم أو نوع..." oninput="searchTable(this.value)">
        <span class="search-icon">🔍</span>
      </div>
    </div>

    {{-- Table --}}
    <div class="table-card">
      <div class="table-scroll">
        @if($bookings->isEmpty())
          <div class="empty-state">
            <span class="ei">📭</span>
            لا توجد طلبات حتى الآن
          </div>
        @else
          <table id="bookings-table">
            <thead>
              <tr>
                <th>#</th>
                <th>رقم الهاتف</th>
                <th>نوع الاستشارة</th>
                <th>الملاحظات</th>
                <th>تاريخ الطلب</th>
                <th>الحالة</th>
                <th>إجراءات</th>
              </tr>
            </thead>
            <tbody>
              @foreach($bookings as $booking)
              @php
                $isNew = $booking->created_at->gte(now()->subHour()) && $booking->status === 'pending';
              @endphp
              <tr
                data-status="{{ $booking->status }}"
                data-search="{{ strtolower($booking->phone . ' ' . $booking->problem_type . ' ' . $booking->notes) }}"
                data-id="{{ $booking->id }}"
                class="{{ $isNew ? 'new-booking' : '' }}"
              >
                <td style="color:var(--muted);font-size:12px">
                  {{ $booking->id }}
                  @if($isNew)<span class="new-dot" title="جديد"></span>@endif
                </td>
                <td>
                  <div class="phone-badge">
                    📱 {{ $booking->phone }}
                  </div>
                </td>
                <td><span class="type-tag">{{ $booking->problem_type }}</span></td>
                <td>
                  @if($booking->notes)
                    <div class="notes-text" title="{{ $booking->notes }}">{{ $booking->notes }}</div>
                  @else
                    <span style="color:#d1d5db;font-size:12px">—</span>
                  @endif
                  @if($booking->admin_notes)
                    <div style="font-size:11px;color:#2563eb;margin-top:3px">
                      📌 {{ Str::limit($booking->admin_notes, 40) }}
                    </div>
                  @endif
                </td>
                <td>
                  <div class="date-text">{{ $booking->created_at->format('Y/m/d') }}</div>
                  <div class="date-text">{{ $booking->created_at->format('H:i') }}</div>
                  <div class="date-text" style="color:#b04141">{{ $booking->created_at->diffForHumans() }}</div>
                </td>
                <td>
                  <form class="status-form" method="POST" action="{{ route('admin.consultations.status', $booking) }}">
                    @csrf
                    <button type="submit" name="status" value="pending"
                      class="status-btn pending {{ $booking->status === 'pending' ? 'active-status' : '' }}">انتظار</button>
                    <button type="submit" name="status" value="contacted"
                      class="status-btn contacted {{ $booking->status === 'contacted' ? 'active-status' : '' }}">تواصلنا</button>
                    <button type="submit" name="status" value="done"
                      class="status-btn done {{ $booking->status === 'done' ? 'active-status' : '' }}">مكتمل</button>
                  </form>
                </td>
                <td>
                  <div style="display:flex;gap:6px;align-items:center">
                    <button class="detail-btn"
                      onclick="openModal({
                        id: {{ $booking->id }},
                        phone: '{{ addslashes($booking->phone) }}',
                        type: '{{ addslashes($booking->problem_type) }}',
                        notes: '{{ addslashes($booking->notes ?? '') }}',
                        admin_notes: '{{ addslashes($booking->admin_notes ?? '') }}',
                        status: '{{ $booking->status }}',
                        date: '{{ $booking->created_at->format('Y/m/d H:i') }}',
                        ago: '{{ $booking->created_at->diffForHumans() }}'
                      })">
                      📂 تفاصيل
                    </button>
                    @php
                      $waMsg = "مرحباً،\nمعي فريق مركز مطمئنة 🌿\nتواصلنا معك بخصوص طلب الاستشارة ({$booking->problem_type}).\nهل يناسبك نحدد موعداً الآن؟";
                    @endphp
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $booking->phone) }}?text={{ urlencode($waMsg) }}"
                       target="_blank" class="wa-btn">
                      <svg width="13" height="13" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.135.561 4.14 1.541 5.876L.057 23.272a.5.5 0 00.616.632l5.57-1.453A11.93 11.93 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.99 0-3.851-.523-5.461-1.436l-.393-.228-4.076 1.064 1.1-3.98-.255-.407A9.953 9.953 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>
                      واتساب
                    </a>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        @endif
      </div>
    </div>

  </div>
</div>

{{-- ── Booking Detail Modal ── --}}
<div class="modal-overlay" id="modal-overlay" onclick="closeModalOnBg(event)">
  <div class="modal" id="modal">
    <button class="modal-close" onclick="closeModal()">✕</button>
    <h2 id="m-title">تفاصيل الطلب</h2>
    <div class="modal-id" id="m-id"></div>

    <div class="modal-grid">
      <div class="info-box">
        <div class="il">رقم الهاتف</div>
        <div class="iv" id="m-phone" style="direction:ltr"></div>
      </div>
      <div class="info-box">
        <div class="il">نوع الاستشارة</div>
        <div class="iv" id="m-type"></div>
      </div>
      <div class="info-box">
        <div class="il">الحالة</div>
        <div class="iv" id="m-status"></div>
      </div>
      <div class="info-box">
        <div class="il">تاريخ الطلب</div>
        <div class="iv" id="m-date" style="font-size:13px"></div>
      </div>
    </div>

    <div class="full-notes" id="m-notes-box">
      <div class="il">ملاحظات العميل</div>
      <div class="iv" id="m-notes"></div>
    </div>

    <div>
      <div style="font-size:12px;font-weight:800;color:var(--muted);margin-bottom:6px;text-transform:uppercase">
        📌 ملاحظات الإدارة
      </div>
      <textarea class="admin-notes-area" id="m-admin-notes" placeholder="أضف ملاحظاتك هنا..."></textarea>
      <div class="notes-save-row">
        <button class="btn btn-primary btn-sm" onclick="saveNotes()">حفظ الملاحظات</button>
        <span class="notes-saved" id="notes-saved-msg">✓ تم الحفظ</span>
      </div>
    </div>

    <div class="modal-wa-section">
      <h4>📤 قوالب رسائل واتساب</h4>
      <button class="wa-template" onclick="sendTemplate(1)">
        👋 أول تواصل — ترحيب وتحديد موعد
      </button>
      <button class="wa-template" onclick="sendTemplate(2)">
        📅 تأكيد الموعد بعد الاتفاق
      </button>
      <button class="wa-template" onclick="sendTemplate(3)">
        🔔 تذكير — ما ردّ على أول رسالة
      </button>
      <button class="wa-template" onclick="sendTemplate(4)">
        💬 استفسار — يبي يعرف أكثر عن الخدمة
      </button>
      <button class="wa-template" onclick="sendTemplate(5)">
        ✅ إغلاق — بعد اكتمال الاستشارة
      </button>
    </div>
  </div>
</div>

{{-- Toast Container --}}
<div class="toast-wrap" id="toast-wrap"></div>

<script>
// ── Chart Data ──
const bookingDays   = @json($days->keys());
const bookingCounts = @json($days->values());
const typeLabels    = @json($typeBreakdown->pluck('problem_type'));
const typeCounts    = @json($typeBreakdown->pluck('cnt'));

// ── Bookings Line Chart ──
new Chart(document.getElementById('bookingsChart'), {
  type: 'line',
  data: {
    labels: bookingDays,
    datasets: [{
      label: 'حجوزات',
      data: bookingCounts,
      borderColor: '#b04141',
      backgroundColor: 'rgba(176,65,65,.08)',
      fill: true,
      tension: .4,
      pointRadius: 4,
      pointBackgroundColor: '#b04141',
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: { legend: { display: false } },
    scales: {
      x: { grid: { display: false }, ticks: { font: { family: 'Tajawal', size: 10 }, maxRotation: 0 } },
      y: { beginAtZero: true, grid: { color: '#f0e8e0' }, ticks: { stepSize: 1, font: { family: 'Tajawal', size: 10 } } }
    }
  }
});

// ── Type Donut Chart ──
const donutColors = ['#b04141','#d97706','#2563eb','#059669','#7c3aed','#db2777','#0891b2'];
new Chart(document.getElementById('typeChart'), {
  type: 'doughnut',
  data: {
    labels: typeLabels,
    datasets: [{
      data: typeCounts,
      backgroundColor: donutColors.slice(0, typeLabels.length),
      borderWidth: 2,
      borderColor: '#fff',
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: {
        position: 'bottom',
        labels: { font: { family: 'Tajawal', size: 11 }, padding: 10, boxWidth: 12 }
      }
    },
    cutout: '62%',
  }
});

// ── Filter & Search ──
function filterTable(status, btn) {
  document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  document.querySelectorAll('#bookings-table tbody tr').forEach(row => {
    row.style.display = (status === 'all' || row.dataset.status === status) ? '' : 'none';
  });
}
function searchTable(q) {
  q = q.toLowerCase();
  document.querySelectorAll('#bookings-table tbody tr').forEach(row => {
    row.style.display = row.dataset.search.includes(q) ? '' : 'none';
  });
}

// ── Modal ──
let currentBookingId = null;
let currentPhone     = null;
let currentType      = null;

function openModal(data) {
  currentBookingId = data.id;
  currentPhone     = data.phone;
  currentType      = data.type;

  document.getElementById('m-title').textContent = 'طلب استشارة #' + data.id;
  document.getElementById('m-id').textContent     = 'مقدم ' + data.ago;
  document.getElementById('m-phone').textContent  = data.phone;
  document.getElementById('m-type').textContent   = data.type;
  document.getElementById('m-date').textContent   = data.date;

  const statusMap = { pending: '⏳ انتظار التواصل', contacted: '📞 تم التواصل', done: '✅ مكتملة' };
  document.getElementById('m-status').textContent = statusMap[data.status] || data.status;

  const notesBox = document.getElementById('m-notes-box');
  if (data.notes) {
    document.getElementById('m-notes').textContent = data.notes;
    notesBox.style.display = 'block';
  } else {
    notesBox.style.display = 'none';
  }

  document.getElementById('m-admin-notes').value = data.admin_notes || '';
  document.getElementById('notes-saved-msg').style.display = 'none';

  document.getElementById('modal-overlay').classList.add('open');
}

function closeModal() {
  document.getElementById('modal-overlay').classList.remove('open');
}
function closeModalOnBg(e) {
  if (e.target === document.getElementById('modal-overlay')) closeModal();
}

document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });

// ── Save Admin Notes ──
function saveNotes() {
  const notes = document.getElementById('m-admin-notes').value;
  fetch(`/admin/consultations/${currentBookingId}/notes`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': '{{ csrf_token() }}',
      'Accept': 'application/json',
    },
    body: JSON.stringify({ admin_notes: notes }),
  })
  .then(r => r.json())
  .then(data => {
    if (data.ok) {
      const el = document.getElementById('notes-saved-msg');
      el.style.display = 'inline';
      showToast('✓ تم حفظ الملاحظة', 'success');
      setTimeout(() => { el.style.display = 'none'; }, 3000);
    }
  })
  .catch(() => showToast('خطأ في الحفظ', 'error'));
}

// ── WhatsApp Templates ──
function sendTemplate(n) {
  const cleanPhone = currentPhone.replace(/[^0-9]/g, '');
  const msgs = {
    1:
`السلام عليكم 🌿

معاك فريق مركز مطمئنة للصحة النفسية والتنمية الذاتية.

وصلنا طلبك للاستشارة بخصوص *${currentType}* وشكراً على ثقتك فينا 🤍

ودّنا نحجزلك موعد مع المختص المناسب.

هل تقدر تعطينا وقتك المناسب؟ 🗓`,

    2:
`السلام عليكم 🌿

تم تأكيد موعدك في مركز مطمئنة ✅

📋 نوع الاستشارة: *${currentType}*
📍 سيتواصل معك المختص في الوقت المحدد

نتمنى لك جلسة مثمرة ومفيدة 🤍
مركز مطمئنة`,

    3:
`السلام عليكم 🔔

معاك فريق مركز مطمئنة.

لاحظنا إنك ما رديت على رسالتنا السابقة، وبدّنا نتأكد إنك بخير 🤍

طلبك لاستشارة *${currentType}* لا يزال محجوزاً ومتاح لك.

متى يناسبك نتواصل؟`,

    4:
`السلام عليكم 🌿

شكراً على تواصلك مع مركز مطمئنة للصحة النفسية والتنمية الذاتية.

نقدر نجاوب على أي استفسار عندك بخصوص *${currentType}*.

لا تتردد، احنا هنا لأجلك 🤍`,

    5:
`السلام عليكم 🌿

من فريق مركز مطمئنة — يسعدنا إن جلستك اكتملت بنجاح ✅

رأيك يهمّنا كثير، هل تقدر تشاركنا انطباعك عن تجربتك معنا؟

وإذا احتجت أي شيء في أي وقت، احنا دايماً هنا 🤍
مركز مطمئنة`,
  };
  window.open(`https://wa.me/${cleanPhone}?text=${encodeURIComponent(msgs[n])}`, '_blank');
}

// ── Toast ──
function showToast(msg, type = 'success') {
  const wrap = document.getElementById('toast-wrap');
  const t = document.createElement('div');
  t.className = `toast ${type}`;
  t.textContent = msg;
  wrap.appendChild(t);
  setTimeout(() => t.remove(), 3500);
}

// ── Auto-refresh: check for new bookings every 60s ──
let prevCount = {{ $stats['pending'] }};

function refreshCheck() {
  fetch('{{ route('admin.consultations.new-count') }}')
    .then(r => r.json())
    .then(data => {
      const badge = document.getElementById('sb-new-badge');
      if (data.count > 0) {
        badge.textContent = data.count;
        badge.classList.add('visible');
        if (data.count > prevCount) {
          showToast(`🔔 طلب استشارة جديد! (${data.count})`, 'success');
        }
      } else {
        badge.classList.remove('visible');
      }
      prevCount = data.count;
      document.getElementById('last-refresh-time').textContent = new Date().toLocaleTimeString('ar-KW');
    })
    .catch(() => {});
}

setInterval(refreshCheck, 60000);
refreshCheck();
</script>

</body>
</html>
