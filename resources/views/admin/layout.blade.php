<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title') — مطمئنة</title>
<style>
@import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;600;700;800;900&display=swap');
*{box-sizing:border-box;margin:0;padding:0}
:root{
  --bg:#f4ede4;--surface:#fff;--border:#e8ddd3;
  --red:#b04141;--red2:#8a3232;--red-light:#fdf2f2;
  --text:#1a1a1a;--muted:#6b7280;--sidebar:#120d09;
  --sb-w:250px;--top:64px;--radius:16px;
}
body{font-family:'Tajawal',sans-serif;background:var(--bg);color:var(--text);min-height:100vh}

.sidebar{width:var(--sb-w);background:var(--sidebar);height:100vh;position:fixed;right:0;top:0;display:flex;flex-direction:column;z-index:300;transition:transform .28s;box-shadow:2px 0 24px rgba(0,0,0,.35)}
.sb-logo{padding:22px 22px 16px;border-bottom:1px solid rgba(255,255,255,.06);background:linear-gradient(135deg,rgba(176,65,65,.15),transparent)}
.sb-logo .brand{font-size:24px;font-weight:900;color:#f87171}
.sb-logo .sub{font-size:11px;color:rgba(255,255,255,.3);margin-top:3px;font-weight:500}
.sb-nav{padding:12px 0;flex:1}
.sb-nav a{display:flex;align-items:center;gap:11px;padding:12px 22px;font-size:13.5px;font-weight:600;color:rgba(255,255,255,.5);text-decoration:none;transition:.18s;border-right:3px solid transparent;margin:2px 0}
.sb-nav a:hover{color:#fff;background:rgba(255,255,255,.06)}
.sb-nav a.active{color:#f87171;background:rgba(248,113,113,.1);border-right-color:#f87171}
.sb-icon{font-size:17px;min-width:22px;text-align:center}
.sb-footer{padding:16px 22px;border-top:1px solid rgba(255,255,255,.06)}
.logout-btn{color:rgba(255,255,255,.35);font-size:13px;font-weight:600;text-decoration:none}
.logout-btn:hover{color:#f87171}
.sb-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:290}
.sb-overlay.open{display:block}

.main{margin-right:var(--sb-w);min-height:100vh}
.topbar{height:var(--top);background:#fff;border-bottom:1px solid var(--border);display:flex;align-items:center;padding:0 24px;gap:12px;position:sticky;top:0;z-index:100}
.hamburger{display:none;background:none;border:none;cursor:pointer;flex-direction:column;gap:5px;padding:6px}
.hamburger span{display:block;width:22px;height:2px;background:var(--text);border-radius:2px}
.page-title{font-size:16px;font-weight:900}
.topbar-right{margin-right:auto;display:flex;gap:8px;align-items:center}
.content{padding:22px 24px 48px}

.btn{display:inline-flex;align-items:center;gap:6px;padding:9px 18px;border-radius:10px;font-size:13px;font-weight:700;font-family:inherit;cursor:pointer;border:none;transition:.15s;text-decoration:none;white-space:nowrap}
.btn-primary{background:var(--red);color:#fff}
.btn-primary:hover{background:var(--red2)}
.btn-outline{background:#fff;border:1.5px solid var(--border);color:var(--muted)}
.btn-outline:hover{border-color:var(--red);color:var(--red)}
.btn-sm{padding:6px 12px;font-size:12px}

.stats-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:20px}
.stat-card{background:#fff;border:1px solid var(--border);border-radius:var(--radius);padding:20px 18px;position:relative;overflow:hidden}
.stat-card::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;background:var(--c)}
.stat-card .num{font-size:34px;font-weight:900;color:var(--c);line-height:1}
.stat-card .lbl{font-size:12px;color:var(--muted);margin-top:6px;font-weight:700}

.card{background:#fff;border:1px solid var(--border);border-radius:var(--radius);padding:20px;margin-bottom:16px}
.card h3{font-size:14px;font-weight:900;margin-bottom:14px}
.filter-bar{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:14px}
.filter-btn{background:#fff;border:1.5px solid var(--border);border-radius:999px;padding:7px 16px;font-size:12.5px;font-weight:700;color:var(--muted);text-decoration:none}
.filter-btn.active,.filter-btn:hover{background:var(--red);color:#fff;border-color:var(--red)}

.table-card{background:#fff;border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
.table-scroll{overflow-x:auto}
table{width:100%;border-collapse:collapse;min-width:820px}
thead{background:linear-gradient(135deg,#fdf8f2,#fef3e8)}
th{padding:13px 14px;font-size:11px;font-weight:800;color:var(--muted);text-align:right;border-bottom:1px solid var(--border);white-space:nowrap}
td{padding:12px 14px;font-size:13.5px;border-bottom:1px solid #f5ede2;vertical-align:middle}
tr:last-child td{border-bottom:none}
tr:hover td{background:#fdf9f5}
.ltr{direction:ltr;display:inline-block}
.small{font-size:11.5px;color:var(--muted)}
.tag{display:inline-block;border-radius:999px;padding:4px 11px;font-size:11.5px;font-weight:800;white-space:nowrap;border:1px solid transparent}
.tag.paid,.tag.on{background:#d1fae5;color:#065f46;border-color:#6ee7b7}
.tag.pending{background:#fef3c7;color:#92400e;border-color:#fcd34d}
.tag.failed,.tag.off{background:#fee2e2;color:#991b1b;border-color:#fca5a5}
.tag.code{background:var(--red-light);color:var(--red);font-family:monospace;font-size:12.5px}
.empty{text-align:center;padding:50px 20px;color:var(--muted)}

.form-grid{display:grid;grid-template-columns:repeat(6,1fr);gap:10px;align-items:end}
.form-grid label{display:block;font-size:11px;font-weight:800;color:var(--muted);margin-bottom:5px}
.form-grid input,.form-grid select{width:100%;border:1.5px solid var(--border);border-radius:10px;padding:9px 11px;font-size:13px;font-family:inherit;background:#fafafa;outline:none}
.form-grid input:focus,.form-grid select:focus{border-color:var(--red);background:#fff}
.alert{border-radius:12px;padding:11px 14px;font-size:13px;font-weight:700;margin-bottom:14px}
.alert.ok{background:#d1fae5;color:#065f46}
.alert.err{background:#fee2e2;color:#991b1b}
.inline{display:inline}

.dash-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px}
.dash-grid .card{margin-bottom:0}
.bar-row{display:grid;grid-template-columns:minmax(110px,1.2fr) 2fr auto;gap:10px;align-items:center;padding:7px 0;border-bottom:1px solid #f5ede2;font-size:13px}
.bar-row:last-child{border-bottom:none}
.bar{height:8px;background:#f5ede0;border-radius:99px;overflow:hidden}
.bar span{display:block;height:100%;background:var(--red);border-radius:99px}
.bar-num{font-size:12px;color:var(--muted);white-space:nowrap}

.field-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:12px}
.field-grid .full{grid-column:1/-1}
.field-grid label,.stack label{display:block;font-size:11.5px;font-weight:800;color:var(--muted);margin-bottom:5px}
.field-grid input,.field-grid textarea,.field-grid select,.stack input,.stack textarea{width:100%;border:1.5px solid var(--border);border-radius:10px;padding:9px 11px;font-size:13.5px;font-family:inherit;background:#fafafa;outline:none}
.field-grid textarea,.stack textarea{min-height:90px;resize:vertical;line-height:1.6}
.field-grid input:focus,.field-grid textarea:focus,.stack input:focus,.stack textarea:focus{border-color:var(--red);background:#fff}
.check,.field-grid label.check{display:inline-flex;align-items:center;gap:7px;font-size:13px;font-weight:700;color:var(--text);margin-inline-end:18px}
.field-grid input[type=checkbox],.check input{width:auto;accent-color:var(--red)}
.hint{font-size:11.5px;color:var(--muted);margin-top:4px}
.stack{display:grid;gap:10px}
.row-actions{display:flex;gap:6px;flex-wrap:wrap;align-items:center}
.thumb{width:44px;height:44px;border-radius:10px;object-fit:cover;object-position:top;background:#f5ede0}
details.edit-box{border:1px solid var(--border);border-radius:12px;padding:10px 14px;margin-bottom:10px;background:#fff}
details.edit-box summary{cursor:pointer;font-weight:800;font-size:13.5px;display:flex;justify-content:space-between;gap:10px;align-items:center}
details.edit-box[open] summary{margin-bottom:12px}

@media(max-width:960px){
  .dash-grid,.field-grid{grid-template-columns:1fr}
}

@media(max-width:960px){
  .sidebar{transform:translateX(calc(100% + 4px))}
  .sidebar.open{transform:none}
  .main{margin-right:0}
  .hamburger{display:flex}
  .stats-grid{grid-template-columns:repeat(2,1fr)}
  .form-grid{grid-template-columns:repeat(2,1fr)}
  .content{padding:14px 12px 56px}
}
</style>
</head>
<body>

<div class="sb-overlay" id="sb-overlay" onclick="toggleSidebar()"></div>
@include('admin.partials.sidebar')

<div class="main">
  <header class="topbar">
    <button class="hamburger" onclick="toggleSidebar()" aria-label="القائمة"><span></span><span></span><span></span></button>
    <div class="page-title">@yield('title')</div>
    <div class="topbar-right">@yield('actions')</div>
  </header>

  <div class="content">
    @if(session('ok'))<div class="alert ok">{{ session('ok') }}</div>@endif
    @if(session('error'))<div class="alert err">{{ session('error') }}</div>@endif
    @if($errors->any())<div class="alert err">{{ $errors->first() }}</div>@endif

    @yield('content')
  </div>
</div>

<script>
function toggleSidebar(){
  document.getElementById('sidebar').classList.toggle('open');
  document.getElementById('sb-overlay').classList.toggle('open');
}
</script>
</body>
</html>
