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
  --bg:#f4ede4;
  --surface:#fff;
  --border:#e8ddd3;
  --red:#b04141;
  --red2:#8a3232;
  --red-light:#fdf2f2;
  --text:#1a1a1a;
  --muted:#6b7280;
  --sidebar:#120d09;
  --sb-w:250px;
  --top:64px;
  --radius:16px;
}
html,body{height:100%}
body{font-family:'Tajawal',sans-serif;background:var(--bg);color:var(--text);min-height:100vh;display:flex;flex-direction:row}

/* ═══════════ SIDEBAR ═══════════ */
.sidebar{
  width:var(--sb-w);min-width:var(--sb-w);
  background:var(--sidebar);
  height:100vh;position:fixed;right:0;top:0;
  display:flex;flex-direction:column;z-index:300;
  transition:transform .28s cubic-bezier(.4,0,.2,1);
  box-shadow:2px 0 24px rgba(0,0,0,.35);
}
.sb-logo{
  padding:22px 22px 16px;
  border-bottom:1px solid rgba(255,255,255,.06);
  background:linear-gradient(135deg,rgba(176,65,65,.15),transparent);
}
.sb-logo .brand{font-size:24px;font-weight:900;color:#f87171;letter-spacing:-.5px;display:flex;align-items:center;gap:8px}
.sb-logo .brand-dot{width:8px;height:8px;border-radius:50%;background:#f87171;animation:pulse-dot 2s infinite}
.sb-logo .sub{font-size:11px;color:rgba(255,255,255,.3);margin-top:3px;font-weight:500}
.sb-nav{padding:12px 0;flex:1;overflow-y:auto}
.sb-nav a{
  display:flex;align-items:center;gap:11px;
  padding:12px 22px;font-size:13.5px;font-weight:600;
  color:rgba(255,255,255,.5);text-decoration:none;
  transition:.18s;border-right:3px solid transparent;
  margin:2px 0;
}
.sb-nav a:hover{color:#fff;background:rgba(255,255,255,.06);border-right-color:rgba(248,113,113,.5)}
.sb-nav a.active{color:#f87171;background:rgba(248,113,113,.1);border-right-color:#f87171}
.sb-icon{font-size:17px;min-width:22px;text-align:center}
.sb-badge{
  background:#ef4444;color:#fff;font-size:10px;font-weight:900;
  border-radius:999px;padding:2px 8px;margin-right:auto;
  display:none;animation:badge-pop .2s ease;
}
.sb-badge.visible{display:inline-block}
@keyframes badge-pop{from{transform:scale(0)}to{transform:scale(1)}}
.sb-footer{padding:16px 22px;border-top:1px solid rgba(255,255,255,.06)}
.logout-btn{
  display:flex;align-items:center;gap:9px;
  color:rgba(255,255,255,.35);font-size:13px;font-weight:600;
  text-decoration:none;padding:9px 0;transition:.18s;border-radius:10px;
}
.logout-btn:hover{color:#f87171}

/* Overlay for mobile sidebar */
.sb-overlay{
  display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);
  z-index:290;backdrop-filter:blur(2px);
}
.sb-overlay.open{display:block}

/* ═══════════ MAIN ═══════════ */
.main{margin-right:var(--sb-w);flex:1;min-height:100vh;display:flex;flex-direction:column;overflow-x:hidden}

/* ═══════════ TOPBAR ═══════════ */
.topbar{
  height:var(--top);background:#fff;
  border-bottom:1px solid var(--border);
  display:flex;align-items:center;padding:0 24px;gap:12px;
  position:sticky;top:0;z-index:100;
  box-shadow:0 1px 8px rgba(0,0,0,.05);
}
.hamburger{
  display:none;background:none;border:none;cursor:pointer;
  flex-direction:column;gap:5px;padding:6px;border-radius:8px;
  transition:.15s;
}
.hamburger:hover{background:#f5ede0}
.hamburger span{display:block;width:22px;height:2px;background:var(--text);border-radius:2px;transition:.2s}
.page-title{font-size:16px;font-weight:900;color:var(--text)}
.page-sub{font-size:11px;color:var(--muted);margin-top:1px}
.topbar-right{margin-right:auto;display:flex;gap:8px;align-items:center}
.refresh-dot{width:8px;height:8px;border-radius:50%;background:#10b981;flex-shrink:0}
.last-time{font-size:11px;color:var(--muted)}

/* Buttons */
.btn{
  display:inline-flex;align-items:center;gap:6px;
  padding:9px 18px;border-radius:10px;font-size:13px;font-weight:700;
  font-family:inherit;cursor:pointer;border:none;transition:.15s;text-decoration:none;
  white-space:nowrap;
}
.btn-primary{background:var(--red);color:#fff;box-shadow:0 2px 10px rgba(176,65,65,.25)}
.btn-primary:hover{background:var(--red2);transform:translateY(-1px)}
.btn-outline{background:#fff;border:1.5px solid var(--border);color:var(--muted)}
.btn-outline:hover{border-color:var(--red);color:var(--red)}
.btn-sm{padding:7px 14px;font-size:12px}

/* ═══════════ CONTENT ═══════════ */
.content{padding:22px 24px 48px;flex:1}

/* ═══════════ STATS ═══════════ */
.stats-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:20px}
.stat-card{
  background:#fff;border:1px solid var(--border);border-radius:var(--radius);
  padding:20px 18px;position:relative;overflow:hidden;
  transition:transform .2s,box-shadow .2s;
}
.stat-card:hover{transform:translateY(-2px);box-shadow:0 6px 20px rgba(0,0,0,.08)}
.stat-card::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;background:var(--c)}
.stat-card .num{font-size:38px;font-weight:900;color:var(--c);line-height:1;letter-spacing:-1px}
.stat-card .lbl{font-size:12px;color:var(--muted);margin-top:6px;font-weight:700;text-transform:uppercase;letter-spacing:.3px}
.stat-card .wm{position:absolute;left:-6px;bottom:-14px;font-size:72px;opacity:.04;font-weight:900;color:var(--c);pointer-events:none;line-height:1}

/* ═══════════ CHARTS ═══════════ */
.charts-row{display:grid;grid-template-columns:2fr 1fr;gap:14px;margin-bottom:20px}
.chart-card{background:#fff;border:1px solid var(--border);border-radius:var(--radius);padding:20px}
.chart-card h3{font-size:13px;font-weight:800;color:var(--text);margin-bottom:14px;display:flex;align-items:center;gap:6px}
.chart-wrap{position:relative;height:175px}

/* ═══════════ FILTER BAR ═══════════ */
.filter-bar{
  background:#fff;border:1px solid var(--border);border-radius:var(--radius);
  padding:13px 16px;display:flex;gap:8px;align-items:center;
  flex-wrap:wrap;margin-bottom:14px;
}
.filter-btn{
  background:transparent;border:1.5px solid var(--border);border-radius:999px;
  padding:7px 16px;font-size:12.5px;font-weight:700;font-family:inherit;
  cursor:pointer;transition:.15s;color:var(--muted);
}
.filter-btn.active,.filter-btn:hover{background:var(--red);color:#fff;border-color:var(--red)}
.search-box{margin-right:auto;position:relative;display:flex;align-items:center}
.search-input{
  background:#f9f5f0;border:1.5px solid var(--border);border-radius:10px;
  padding:8px 14px 8px 38px;font-size:13px;font-family:inherit;outline:none;
  width:200px;transition:.2s;
}
.search-input:focus{border-color:var(--red);width:240px}
.search-icon{position:absolute;left:12px;color:var(--muted);font-size:14px;pointer-events:none}

/* ═══════════ TABLE ═══════════ */
.table-card{background:#fff;border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
.table-scroll{overflow-x:auto;-webkit-overflow-scrolling:touch}
table{width:100%;border-collapse:collapse;min-width:750px}
thead{background:linear-gradient(135deg,#fdf8f2,#fef3e8)}
th{
  padding:13px 14px;font-size:11px;font-weight:800;color:var(--muted);
  text-align:right;border-bottom:1px solid var(--border);
  white-space:nowrap;letter-spacing:.5px;text-transform:uppercase;
}
td{padding:13px 14px;font-size:13.5px;color:var(--text);border-bottom:1px solid #f5ede2;vertical-align:middle}
tr:last-child td{border-bottom:none}
tr:hover td{background:#fdf9f5}
tr.row-new td{background:#fffbeb}
tr.row-new:hover td{background:#fef9e0}

.phone-badge{
  display:inline-flex;align-items:center;gap:5px;
  background:#f5ede0;border-radius:8px;padding:5px 10px;
  font-weight:700;font-size:13px;color:var(--text);direction:ltr;
  border:1px solid #e8ddd0;
}
.type-tag{
  display:inline-block;background:var(--red-light);color:var(--red);
  border:1px solid rgba(176,65,65,.15);border-radius:999px;
  padding:4px 12px;font-size:12px;font-weight:700;white-space:nowrap;
}
.notes-text{font-size:12px;color:var(--muted);max-width:160px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.admin-note-preview{font-size:11px;color:#2563eb;margin-top:3px;max-width:160px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.date-line{font-size:11px;color:#9ca3af;white-space:nowrap;line-height:1.6}
.new-dot{display:inline-block;width:7px;height:7px;border-radius:50%;background:#ef4444;vertical-align:middle;margin-right:3px;animation:pulse-dot 1.5s infinite}
@keyframes pulse-dot{0%,100%{opacity:1;transform:scale(1)}50%{opacity:.5;transform:scale(.8)}}

/* Status */
.status-form{display:flex;gap:3px;flex-wrap:nowrap}
.s-btn{
  border:1.5px solid transparent;border-radius:999px;
  padding:4px 9px;font-size:11px;font-weight:700;font-family:inherit;
  cursor:pointer;transition:.15s;white-space:nowrap;
}
.s-btn.pending{background:#fef3c7;color:#92400e;border-color:#fcd34d}
.s-btn.contacted{background:#dbeafe;color:#1e40af;border-color:#93c5fd}
.s-btn.done{background:#d1fae5;color:#065f46;border-color:#6ee7b7}
.s-btn.active-s{box-shadow:0 0 0 2px currentColor;transform:scale(1.06)}

/* Action buttons */
.action-row{display:flex;gap:5px;align-items:center}
.detail-btn{
  background:#f5ede0;border:1px solid var(--border);border-radius:8px;
  padding:6px 11px;font-size:11.5px;font-weight:700;font-family:inherit;
  cursor:pointer;color:var(--red);transition:.15s;
}
.detail-btn:hover{background:var(--red-light);border-color:rgba(176,65,65,.3)}
.wa-btn{
  background:#25d366;color:#fff;border:none;border-radius:8px;
  padding:6px 11px;font-size:11.5px;font-weight:700;font-family:inherit;
  cursor:pointer;text-decoration:none;display:inline-flex;
  align-items:center;gap:4px;transition:.15s;
}
.wa-btn:hover{background:#1da851}

/* Empty */
.empty-state{text-align:center;padding:60px 20px;color:var(--muted)}
.empty-state .ei{font-size:44px;display:block;margin-bottom:12px}

/* ═══════════ MODAL ═══════════ */
.modal-overlay{
  position:fixed;inset:0;background:rgba(0,0,0,.55);
  z-index:500;display:none;align-items:center;justify-content:center;
  backdrop-filter:blur(4px);padding:16px;
}
.modal-overlay.open{display:flex}
.modal{
  background:#fff;border-radius:20px;width:100%;max-width:520px;
  max-height:90vh;overflow-y:auto;padding:26px;position:relative;
  animation:modal-in .22s cubic-bezier(.34,1.56,.64,1);
}
@keyframes modal-in{from{transform:translateY(24px) scale(.96);opacity:0}to{transform:none;opacity:1}}
.modal-close{
  position:absolute;top:14px;left:14px;
  background:#f5ede0;border:none;border-radius:8px;
  width:32px;height:32px;font-size:15px;cursor:pointer;
  display:flex;align-items:center;justify-content:center;color:var(--muted);transition:.15s;
}
.modal-close:hover{background:var(--red-light);color:var(--red)}
.modal-header{margin-bottom:18px;padding-left:40px}
.modal-header h2{font-size:18px;font-weight:900}
.modal-header p{font-size:12px;color:var(--muted);margin-top:3px}
.info-grid{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:14px}
.info-box{background:#fdf8f3;border:1px solid var(--border);border-radius:10px;padding:11px 13px}
.info-box .il{font-size:10px;color:var(--muted);font-weight:800;text-transform:uppercase;letter-spacing:.4px;margin-bottom:4px}
.info-box .iv{font-size:14px;font-weight:700}
.notes-box{background:#fdf8f3;border:1px solid var(--border);border-radius:10px;padding:12px;margin-bottom:14px}
.notes-box .il{font-size:10px;color:var(--muted);font-weight:800;text-transform:uppercase;letter-spacing:.4px;margin-bottom:6px}
.notes-box .iv{font-size:13px;line-height:1.65;color:var(--text)}
.admin-notes-label{font-size:11px;font-weight:800;color:var(--muted);text-transform:uppercase;letter-spacing:.4px;margin-bottom:7px;display:flex;align-items:center;gap:5px}
.admin-notes-area{
  width:100%;border:1.5px solid var(--border);border-radius:10px;
  padding:11px 13px;font-size:13px;font-family:inherit;
  resize:vertical;min-height:85px;outline:none;transition:.2s;background:#fafafa;
}
.admin-notes-area:focus{border-color:var(--red);background:#fff}
.notes-footer{display:flex;gap:8px;align-items:center;margin-top:8px}
.save-ok{font-size:12px;color:#059669;font-weight:700;display:none}

/* WA Templates in modal */
.wa-section{
  background:linear-gradient(135deg,#f0fdf4,#ecfdf5);
  border:1px solid #86efac;border-radius:12px;padding:14px;margin-top:16px;
}
.wa-section h4{font-size:11px;font-weight:800;color:#065f46;margin-bottom:10px;text-transform:uppercase;letter-spacing:.4px}
.tpl-btn{
  background:#fff;border:1px solid #bbf7d0;border-radius:8px;
  padding:9px 12px;font-size:12.5px;color:#065f46;
  cursor:pointer;margin-bottom:6px;transition:.15s;display:flex;align-items:flex-start;gap:8px;
  text-align:right;width:100%;font-family:inherit;font-weight:600;line-height:1.4;
}
.tpl-btn:hover{background:#dcfce7;border-color:#4ade80;transform:translateX(-2px)}
.tpl-btn:last-child{margin-bottom:0}
.tpl-icon{font-size:15px;flex-shrink:0;margin-top:1px}

/* ═══════════ TOAST ═══════════ */
.toast-wrap{position:fixed;bottom:20px;right:20px;z-index:9999;display:flex;flex-direction:column;gap:8px}
.toast{
  background:#1a1a1a;color:#fff;border-radius:12px;
  padding:11px 16px;font-size:13px;font-weight:600;
  display:flex;align-items:center;gap:10px;
  animation:toast-in .25s ease;min-width:250px;max-width:320px;
  box-shadow:0 8px 28px rgba(0,0,0,.28);
}
.toast.ok{border-right:4px solid #10b981}
.toast.err{border-right:4px solid #ef4444}
@keyframes toast-in{from{transform:translateX(24px);opacity:0}to{transform:none;opacity:1}}

/* ═══════════ RESPONSIVE ═══════════ */
@media(max-width:960px){
  /* hide sidebar by default on tablet/mobile */
  .sidebar{
    transform:translateX(calc(100% + 4px));
    box-shadow:none;
  }
  .sidebar.open{transform:translateX(0);box-shadow:-4px 0 32px rgba(0,0,0,.4)}
  .main{margin-right:0 !important;width:100%}
  .hamburger{display:flex}
  .stats-grid{grid-template-columns:repeat(2,1fr);gap:12px}
  .charts-row{grid-template-columns:1fr}
  .content{padding:14px 14px 56px}
  .topbar{padding:0 14px;gap:10px}
  .search-input,.search-input:focus{width:130px}
  .chart-wrap{height:140px}
}

/* ── Card layout for phones ── */
@media(max-width:680px){
  /* remove horizontal scroll — go full card */
  .table-card{background:transparent;border:none;border-radius:0;overflow:visible}
  .table-scroll{overflow:visible}
  table,thead,tbody,tr,th,td{display:block;width:100%}
  thead{display:none}

  /* each row = a card */
  #tbl tbody tr{
    background:#fff;
    border:1px solid var(--border);
    border-radius:16px;
    padding:16px;
    margin-bottom:12px;
    position:relative;
    box-shadow:0 2px 8px rgba(0,0,0,.05);
  }
  #tbl tbody tr.row-new{background:#fffbeb;border-color:#fcd34d}

  /* hide # td */
  #tbl tbody td:nth-child(1){
    position:absolute;top:14px;left:14px;
    font-size:10px;color:var(--muted);margin:0;padding:0;border:none;
  }
  /* phone — large */
  #tbl tbody td:nth-child(2){
    padding:0;border:none;margin-bottom:6px;padding-right:24px;
  }
  .phone-badge{font-size:15px;font-weight:800}

  /* type tag */
  #tbl tbody td:nth-child(3){padding:0;border:none;margin-bottom:8px}

  /* notes */
  #tbl tbody td:nth-child(4){padding:0;border:none;margin-bottom:6px}
  .notes-text{max-width:100%}

  /* date */
  #tbl tbody td:nth-child(5){padding:0;border:none;margin-bottom:10px}

  /* status */
  #tbl tbody td:nth-child(6){padding:0;border:none;margin-bottom:10px}
  .status-form{flex-wrap:wrap;gap:4px}
  .s-btn{padding:6px 14px;font-size:12px}

  /* actions */
  #tbl tbody td:nth-child(7){
    padding:0;border:none;padding-top:10px;
    border-top:1px solid var(--border);
  }
  .action-row{justify-content:flex-start}
  .detail-btn,.wa-btn{padding:8px 16px;font-size:13px;border-radius:10px}
}

/* ── Small phones ── */
@media(max-width:420px){
  body{overflow-x:hidden}
  .stats-grid{gap:8px}
  .stat-card{padding:14px 12px}
  .stat-card .num{font-size:26px}
  .stat-card .lbl{font-size:11px}
  .filter-bar{padding:10px 12px;gap:6px}
  .filter-btn{padding:6px 12px;font-size:11px}
  .search-input,.search-input:focus{width:120px}
  .topbar{padding:0 10px;gap:6px}
  .page-title{font-size:14px}
  .page-sub{display:none}
  .btn-sm{padding:6px 10px;font-size:11px}
  .content{padding:12px 10px 56px}
  /* modal full-screen */
  .modal-overlay{padding:0;align-items:flex-end}
  .modal{border-radius:20px 20px 0 0;max-height:88vh;padding:20px 16px}
  .info-grid{grid-template-columns:1fr}
  .toast-wrap{bottom:0;right:0;left:0;padding:0 8px 8px}
  .toast{min-width:unset;border-radius:12px}
}
</style>
</head>
<body>

{{-- Sidebar overlay for mobile --}}
<div class="sb-overlay" id="sb-overlay" onclick="closeSidebar()"></div>

{{-- ═══ SIDEBAR ═══ --}}
<aside class="sidebar" id="sidebar">
  <div class="sb-logo">
    <div class="brand">
      <span class="brand-dot"></span>مطمئنة
    </div>
    <div class="sub">لوحة التحكم الإدارية</div>
  </div>
  <nav class="sb-nav">
    <a href="{{ route('admin.consultations') }}" class="active">
      <span class="sb-icon">&#128203;</span>
      الاستشارات
      <span class="sb-badge" id="sb-badge">0</span>
    </a>
  </nav>
  <div class="sb-footer">
    <a href="{{ route('admin.logout') }}" class="logout-btn">
      <span>&#x2BA8;</span> تسجيل الخروج
    </a>
  </div>
</aside>

{{-- ═══ MAIN ═══ --}}
<div class="main">

  <header class="topbar">
    <button class="hamburger" id="hamburger" onclick="toggleSidebar()" aria-label="القائمة">
      <span></span><span></span><span></span>
    </button>
    <div>
      <div class="page-title">إدارة الاستشارات</div>
      <div class="page-sub">تحديث تلقائي كل دقيقة &mdash; <span id="last-time">الآن</span></div>
    </div>
    <div class="topbar-right">
      <span class="refresh-dot" title="يعمل"></span>
      <a href="{{ route('admin.consultations.export') }}" class="btn btn-outline btn-sm">
        &#8595; تصدير
      </a>
    </div>
  </header>

  <div class="content">

    {{-- Stats --}}
    <div class="stats-grid">
      <div class="stat-card" style="--c:#b04141">
        <div class="num">{{ $stats['total'] }}</div>
        <div class="lbl">إجمالي الطلبات</div>
        <div class="wm">&#931;</div>
      </div>
      <div class="stat-card" style="--c:#d97706">
        <div class="num">{{ $stats['pending'] }}</div>
        <div class="lbl">بانتظار التواصل</div>
        <div class="wm">&#9201;</div>
      </div>
      <div class="stat-card" style="--c:#2563eb">
        <div class="num">{{ $stats['contacted'] }}</div>
        <div class="lbl">تم التواصل</div>
        <div class="wm">&#128222;</div>
      </div>
      <div class="stat-card" style="--c:#059669">
        <div class="num">{{ $stats['done'] }}</div>
        <div class="lbl">مكتملة</div>
        <div class="wm">&#10003;</div>
      </div>
    </div>

    {{-- Charts --}}
    <div class="charts-row">
      <div class="chart-card">
        <h3>&#128200; الحجوزات — آخر 14 يوم</h3>
        <div class="chart-wrap"><canvas id="bookingsChart"></canvas></div>
      </div>
      <div class="chart-card">
        <h3>&#128202; توزيع أنواع الاستشارات</h3>
        <div class="chart-wrap"><canvas id="typeChart"></canvas></div>
      </div>
    </div>

    {{-- Filter bar --}}
    <div class="filter-bar">
      <button class="filter-btn active" onclick="doFilter('all',this)">الكل ({{ $stats['total'] }})</button>
      <button class="filter-btn" onclick="doFilter('pending',this)">انتظار ({{ $stats['pending'] }})</button>
      <button class="filter-btn" onclick="doFilter('contacted',this)">تواصلنا ({{ $stats['contacted'] }})</button>
      <button class="filter-btn" onclick="doFilter('done',this)">مكتمل ({{ $stats['done'] }})</button>
      <div class="search-box">
        <span class="search-icon">&#128269;</span>
        <input type="text" class="search-input" placeholder="ابحث..." oninput="doSearch(this.value)">
      </div>
    </div>

    {{-- Table --}}
    <div class="table-card">
      <div class="table-scroll">
        @if($bookings->isEmpty())
          <div class="empty-state">
            <span class="ei">&#128205;</span>
            لا توجد طلبات حتى الآن
          </div>
        @else
          <table id="tbl">
            <thead>
              <tr>
                <th>#</th>
                <th>رقم الهاتف</th>
                <th>نوع الاستشارة</th>
                <th>الملاحظات</th>
                <th>التاريخ</th>
                <th>الحالة</th>
                <th>إجراءات</th>
              </tr>
            </thead>
            <tbody>
              @foreach($bookings as $b)
              @php $isNew = $b->created_at->gte(now()->subHour()) && $b->status === 'pending'; @endphp
              <tr
                data-status="{{ $b->status }}"
                data-search="{{ strtolower($b->phone.' '.$b->problem_type.' '.($b->notes ?? '')) }}"
                class="{{ $isNew ? 'row-new' : '' }}"
              >
                <td style="color:var(--muted);font-size:12px;font-weight:700">
                  @if($isNew)<span class="new-dot"></span>@endif
                  #{{ $b->id }}
                </td>
                <td><div class="phone-badge">{{ $b->phone }}</div></td>
                <td><span class="type-tag">{{ $b->problem_type }}</span></td>
                <td>
                  @if($b->notes)
                    <div class="notes-text" title="{{ $b->notes }}">{{ $b->notes }}</div>
                  @else
                    <span style="color:#d1d5db;font-size:12px">—</span>
                  @endif
                  @if($b->admin_notes)
                    <div class="admin-note-preview" title="{{ $b->admin_notes }}">&#128204; {{ $b->admin_notes }}</div>
                  @endif
                </td>
                <td>
                  <div class="date-line">{{ $b->created_at->format('Y/m/d') }}</div>
                  <div class="date-line">{{ $b->created_at->format('H:i') }}</div>
                  <div class="date-line" style="color:var(--red)">{{ $b->created_at->diffForHumans() }}</div>
                </td>
                <td>
                  <form class="status-form" method="POST" action="{{ route('admin.consultations.status', $b) }}">
                    @csrf
                    <button type="submit" name="status" value="pending"   class="s-btn pending   {{ $b->status==='pending'   ? 'active-s':'' }}">انتظار</button>
                    <button type="submit" name="status" value="contacted" class="s-btn contacted {{ $b->status==='contacted' ? 'active-s':'' }}">تواصلنا</button>
                    <button type="submit" name="status" value="done"      class="s-btn done      {{ $b->status==='done'      ? 'active-s':'' }}">مكتمل</button>
                  </form>
                </td>
                <td>
                  <div class="action-row">
                    <button class="detail-btn"
                      data-id="{{ $b->id }}"
                      data-phone="{{ $b->phone }}"
                      data-type="{{ $b->problem_type }}"
                      data-notes="{{ $b->notes ?? '' }}"
                      data-anotes="{{ $b->admin_notes ?? '' }}"
                      data-status="{{ $b->status }}"
                      data-date="{{ $b->created_at->format('Y/m/d H:i') }}"
                      data-ago="{{ $b->created_at->diffForHumans() }}"
                      onclick="openModalFromEl(this)">
                      &#128194; تفاصيل
                    </button>
                    <a href="#"
                       onclick="quickWA('{{ preg_replace('/[^0-9]/', '', $b->phone) }}','{{ addslashes($b->problem_type) }}');return false"
                       class="wa-btn">
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

{{-- ═══ MODAL ═══ --}}
<div class="modal-overlay" id="modal-overlay" onclick="bgClose(event)">
  <div class="modal">
    <button class="modal-close" onclick="closeModal()">&#10005;</button>

    <div class="modal-header">
      <h2 id="m-title">تفاصيل الطلب</h2>
      <p id="m-ago"></p>
    </div>

    <div class="info-grid">
      <div class="info-box">
        <div class="il">رقم الهاتف</div>
        <div class="iv" id="m-phone" style="direction:ltr;font-size:15px"></div>
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

    <div class="notes-box" id="m-notes-box">
      <div class="il">ملاحظات العميل</div>
      <div class="iv" id="m-notes"></div>
    </div>

    <div class="admin-notes-label">&#128204; ملاحظات الإدارة</div>
    <textarea class="admin-notes-area" id="m-admin-notes" placeholder="أضف ملاحظاتك هنا..."></textarea>
    <div class="notes-footer">
      <button class="btn btn-primary btn-sm" onclick="saveNotes()">حفظ الملاحظة</button>
      <span class="save-ok" id="save-ok">&#10003; تم الحفظ</span>
    </div>

    <div class="wa-section">
      <h4>&#128228; قوالب واتساب</h4>
      <button class="tpl-btn" onclick="sendTpl(1)">
        <span class="tpl-icon">&#128075;</span>
        <span>أول تواصل — ترحيب وتحديد موعد</span>
      </button>
      <button class="tpl-btn" onclick="sendTpl(2)">
        <span class="tpl-icon">&#128197;</span>
        <span>تأكيد الموعد بعد الاتفاق</span>
      </button>
      <button class="tpl-btn" onclick="sendTpl(3)">
        <span class="tpl-icon">&#128276;</span>
        <span>تذكير — ما ردّ على أول رسالة</span>
      </button>
      <button class="tpl-btn" onclick="sendTpl(4)">
        <span class="tpl-icon">&#128172;</span>
        <span>استفسار — يبي يعرف أكثر عن الخدمة</span>
      </button>
      <button class="tpl-btn" onclick="sendTpl(5)">
        <span class="tpl-icon">&#9989;</span>
        <span>إغلاق — بعد اكتمال الاستشارة</span>
      </button>
    </div>
  </div>
</div>

<div class="toast-wrap" id="toasts"></div>

<script>
// ── Chart data ──
const chartDays   = @json($days->keys());
const chartCounts = @json($days->values());
const typeLabels  = @json($typeBreakdown->pluck('problem_type'));
const typeCounts  = @json($typeBreakdown->pluck('cnt'));

Chart.defaults.font.family = 'Tajawal';

new Chart(document.getElementById('bookingsChart'), {
  type: 'line',
  data: {
    labels: chartDays,
    datasets: [{
      label: 'حجوزات',
      data: chartCounts,
      borderColor: '#b04141',
      backgroundColor: 'rgba(176,65,65,.07)',
      fill: true, tension: .45,
      pointRadius: 4, pointBackgroundColor: '#b04141',
      pointBorderColor: '#fff', pointBorderWidth: 2,
    }]
  },
  options: {
    responsive: true, maintainAspectRatio: false,
    plugins: { legend: { display: false }, tooltip: { rtl: true } },
    scales: {
      x: { grid: { display: false }, ticks: { font: { size: 10 }, maxRotation: 0 } },
      y: { beginAtZero: true, grid: { color: '#f0e8de' }, ticks: { stepSize: 1, font: { size: 10 } } }
    }
  }
});

const donutColors = ['#b04141','#d97706','#2563eb','#059669','#7c3aed','#db2777','#0891b2','#d97706'];
new Chart(document.getElementById('typeChart'), {
  type: 'doughnut',
  data: {
    labels: typeLabels,
    datasets: [{
      data: typeCounts,
      backgroundColor: donutColors.slice(0, typeLabels.length),
      borderWidth: 2, borderColor: '#fff',
    }]
  },
  options: {
    responsive: true, maintainAspectRatio: false,
    plugins: {
      legend: {
        position: 'bottom',
        labels: { font: { size: 11 }, padding: 8, boxWidth: 11 }
      }
    },
    cutout: '62%',
  }
});

// ── Sidebar mobile ──
function toggleSidebar() {
  document.getElementById('sidebar').classList.toggle('open');
  document.getElementById('sb-overlay').classList.toggle('open');
}
function closeSidebar() {
  document.getElementById('sidebar').classList.remove('open');
  document.getElementById('sb-overlay').classList.remove('open');
}

// ── Filter & Search ──
function doFilter(status, btn) {
  document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  document.querySelectorAll('#tbl tbody tr').forEach(r => {
    r.style.display = (status === 'all' || r.dataset.status === status) ? '' : 'none';
  });
}
function doSearch(q) {
  q = q.toLowerCase();
  document.querySelectorAll('#tbl tbody tr').forEach(r => {
    r.style.display = r.dataset.search.includes(q) ? '' : 'none';
  });
}

// ── Modal ──
let mId = null, mPhone = null, mType = null;

function openModalFromEl(el) {
  openModal({
    id:          el.dataset.id,
    phone:       el.dataset.phone,
    type:        el.dataset.type,
    notes:       el.dataset.notes,
    admin_notes: el.dataset.anotes,
    status:      el.dataset.status,
    date:        el.dataset.date,
    ago:         el.dataset.ago,
  });
}

function openModal(d) {
  mId = d.id; mPhone = d.phone; mType = d.type;
  document.getElementById('m-title').textContent  = 'طلب #' + d.id;
  document.getElementById('m-ago').textContent    = 'مُقدَّم ' + d.ago;
  document.getElementById('m-phone').textContent  = d.phone;
  document.getElementById('m-type').textContent   = d.type;
  document.getElementById('m-date').textContent   = d.date;
  const statusMap = { pending: 'انتظار التواصل', contacted: 'تم التواصل', done: 'مكتملة' };
  document.getElementById('m-status').textContent = statusMap[d.status] || d.status;
  const nb = document.getElementById('m-notes-box');
  if (d.notes) { document.getElementById('m-notes').textContent = d.notes; nb.style.display = 'block'; }
  else { nb.style.display = 'none'; }
  document.getElementById('m-admin-notes').value = d.admin_notes || '';
  document.getElementById('save-ok').style.display = 'none';
  document.getElementById('modal-overlay').classList.add('open');
}
function closeModal() { document.getElementById('modal-overlay').classList.remove('open'); }
function bgClose(e) { if (e.target === document.getElementById('modal-overlay')) closeModal(); }
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });

// ── Save admin notes ──
function saveNotes() {
  fetch('/admin/consultations/' + mId + '/notes', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
    body: JSON.stringify({ admin_notes: document.getElementById('m-admin-notes').value }),
  })
  .then(r => r.json())
  .then(d => {
    if (d.ok) {
      const el = document.getElementById('save-ok');
      el.style.display = 'inline';
      toast('تم حفظ الملاحظة', 'ok');
      setTimeout(() => el.style.display = 'none', 3000);
    }
  })
  .catch(() => toast('خطأ في الحفظ', 'err'));
}

// ── WhatsApp quick button (table row) ──
function quickWA(phone, type) {
  const msg = 'السلام عليكم 🌿\nمعاك فريق مركز مطمئنة ✨\nوصلنا طلبك بخصوص *' + type + '* 🗂\nمتى يناسبك نحدد موعدًا؟ 📅';
  window.open('https://wa.me/' + phone + '?text=' + encodeURIComponent(msg), '_blank');
}

// ── WhatsApp templates (modal) ──
function sendTpl(n) {
  const p = mPhone.replace(/[^0-9]/g, '');
  const t = mType;
  const msgs = {
    1: 'السلام عليكم 🌿\n\nمعاك فريق مركز مطمئنة ✨\n\nوصلنا طلبك بخصوص *' + t + '* 🗂\nوشكرًا جزيلًا على ثقتك فينا 🤍\n\nودّنا نحجزلك موعد في أقرب وقت يناسبك 📅\nمتى تكون متاحًا؟',
    2: 'السلام عليكم 🌿\n\n✅ تم تأكيد موعدك في مركز مطمئنة\n\n📋 الخدمة: *' + t + '*\n\nسيتواصل معك أحد الفريق في الوقت المحدد 🕐\nنتمنى لك تجربة مثمرة 🤍\nمركز مطمئنة',
    3: 'السلام عليكم 🌿\n\nمعاك فريق مركز مطمئنة 🔔\n\nتواصلنا معك سابقًا بخصوص *' + t + '*\nولاحظنا إنك ما رديت 🙂\n\nطلبك لا يزال محجوزًا لك 🗓\nمتى يناسبك نكمل؟',
    4: 'السلام عليكم 🌿\n\nشكرًا على تواصلك مع مركز مطمئنة 💬\n\nيسعدنا نجاوب على أي استفسار عندك بخصوص *' + t + '*\n\nلا تتردد، احنا هنا دائمًا لأجلك 🤍',
    5: 'السلام عليكم 🌿\n\nمن فريق مركز مطمئنة 🎉\n\nيسعدنا إن جلستك اكتملت بنجاح ✅\n\nرأيك يهمّنا كثيرًا 💛\nهل تقدر تشاركنا انطباعك عن تجربتك معنا؟\n\nنسعد دائمًا بخدمتك 🤍'
  };
  window.open('https://wa.me/' + p + '?text=' + encodeURIComponent(msgs[n]), '_blank');
}

// ── Toast ──
function toast(msg, type) {
  const w = document.getElementById('toasts');
  const t = document.createElement('div');
  t.className = 'toast ' + type;
  t.textContent = msg;
  w.appendChild(t);
  setTimeout(() => t.remove(), 3500);
}

// ── Auto-refresh badge ──
let prevPending = {{ $stats['pending'] }};
function refreshCheck() {
  fetch('{{ route('admin.consultations.new-count') }}')
    .then(r => r.json())
    .then(d => {
      const badge = document.getElementById('sb-badge');
      if (d.count > 0) {
        badge.textContent = d.count;
        badge.classList.add('visible');
        if (d.count > prevPending) toast('طلب استشارة جديد! (' + d.count + ')', 'ok');
      } else {
        badge.classList.remove('visible');
      }
      prevPending = d.count;
      document.getElementById('last-time').textContent = new Date().toLocaleTimeString('ar-KW', {hour:'2-digit',minute:'2-digit'});
    }).catch(() => {});
}
setInterval(refreshCheck, 60000);
refreshCheck();
</script>
</body>
</html>
