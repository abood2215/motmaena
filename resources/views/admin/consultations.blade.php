<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>لوحة الاستشارات — مطمئنة</title>
<style>
@import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@400;600;700;800;900&display=swap');
* { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: 'Tajawal', sans-serif; background: #f5ede0; color: #1a1a1a; min-height: 100vh; }

/* Header */
.top-bar {
  background: linear-gradient(135deg, #1a0a0a, #2d1515);
  color: #fff;
  padding: 16px 28px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 16px;
}
.top-bar .brand { font-size: 20px; font-weight: 900; color: #f87171; }
.top-bar .title { font-size: 14px; color: rgba(255,255,255,.65); }
.top-bar .logout-btn {
  background: rgba(255,255,255,.1);
  border: 1px solid rgba(255,255,255,.2);
  color: #fff;
  border-radius: 8px;
  padding: 7px 16px;
  font-size: 13px;
  font-family: inherit;
  cursor: pointer;
  text-decoration: none;
}

/* Stats */
.stats-row {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 16px;
  padding: 24px 28px 0;
  max-width: 1100px;
  margin: 0 auto;
}
.stat-card {
  background: #fff;
  border-radius: 16px;
  padding: 22px 20px;
  text-align: center;
  border: 1px solid #e8ddd5;
  border-top: 4px solid var(--c);
}
.stat-card .num { font-size: 34px; font-weight: 900; color: var(--c); }
.stat-card .lbl { font-size: 13px; color: #6b7280; margin-top: 4px; }

/* Filters */
.filters {
  padding: 20px 28px 0;
  max-width: 1100px;
  margin: 0 auto;
  display: flex;
  gap: 10px;
  flex-wrap: wrap;
  align-items: center;
}
.filter-btn {
  background: #fff;
  border: 1.5px solid #e8ddd5;
  border-radius: 999px;
  padding: 8px 20px;
  font-size: 13px;
  font-weight: 700;
  font-family: inherit;
  cursor: pointer;
  transition: all .15s;
  color: #6b7280;
}
.filter-btn.active, .filter-btn:hover { background: #b04141; color: #fff; border-color: #b04141; }
.search-input {
  background: #fff;
  border: 1.5px solid #e8ddd5;
  border-radius: 999px;
  padding: 8px 20px;
  font-size: 13px;
  font-family: inherit;
  outline: none;
  width: 220px;
  transition: border-color .2s;
  margin-right: auto;
}
.search-input:focus { border-color: #b04141; }

/* Table */
.table-wrap {
  padding: 20px 28px 40px;
  max-width: 1100px;
  margin: 0 auto;
}
.table-card {
  background: #fff;
  border: 1px solid #e8ddd5;
  border-radius: 20px;
  overflow: hidden;
}
table { width: 100%; border-collapse: collapse; }
thead { background: #fdf8f3; }
th {
  padding: 14px 16px;
  font-size: 13px;
  font-weight: 700;
  color: #6b7280;
  text-align: right;
  border-bottom: 1px solid #e8ddd5;
  white-space: nowrap;
}
td {
  padding: 14px 16px;
  font-size: 14px;
  color: #1a1a1a;
  border-bottom: 1px solid #f0e8e0;
  vertical-align: middle;
}
tr:last-child td { border-bottom: none; }
tr:hover td { background: #fdf8f3; }

.phone-badge {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  background: #f5ede0;
  border-radius: 8px;
  padding: 5px 12px;
  font-weight: 700;
  font-size: 14px;
  color: #1a1a1a;
  direction: ltr;
}
.type-tag {
  display: inline-block;
  background: #fdf2f2;
  color: #b04141;
  border: 1px solid rgba(176,65,65,.2);
  border-radius: 999px;
  padding: 3px 12px;
  font-size: 12px;
  font-weight: 700;
}
.notes-text {
  font-size: 13px;
  color: #6b7280;
  max-width: 200px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.date-text { font-size: 12px; color: #9ca3af; }

/* Status */
.status-form { display: flex; gap: 4px; }
.status-btn {
  border: 1.5px solid transparent;
  border-radius: 999px;
  padding: 5px 12px;
  font-size: 12px;
  font-weight: 700;
  font-family: inherit;
  cursor: pointer;
  transition: all .15s;
}
.status-btn.pending  { background: #fef3c7; color: #92400e; border-color: #fcd34d; }
.status-btn.contacted{ background: #dbeafe; color: #1e40af; border-color: #93c5fd; }
.status-btn.done     { background: #d1fae5; color: #065f46; border-color: #6ee7b7; }
.status-btn.active-status { box-shadow: 0 0 0 2px currentColor; }

.wa-btn {
  background: #25d366;
  color: #fff;
  border: none;
  border-radius: 8px;
  padding: 7px 14px;
  font-size: 13px;
  font-weight: 700;
  font-family: inherit;
  cursor: pointer;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 5px;
  transition: background .15s;
}
.wa-btn:hover { background: #1da851; }

.empty-state {
  text-align: center;
  padding: 60px 20px;
  color: #9ca3af;
  font-size: 15px;
}
.empty-state .emoji { font-size: 42px; display: block; margin-bottom: 12px; }

@media (max-width: 768px) {
  .stats-row { grid-template-columns: repeat(2, 1fr); }
  .filters, .table-wrap, .stats-row { padding-left: 16px; padding-right: 16px; }
  .search-input { width: 100%; margin-right: 0; }
  th, td { padding: 10px 12px; }
}
</style>
</head>
<body>

<div class="top-bar">
  <div>
    <div class="brand">مطمئنة</div>
    <div class="title">لوحة تحكم الاستشارات</div>
  </div>
  <a href="{{ route('admin.logout') }}" class="logout-btn">خروج</a>
</div>

{{-- Stats --}}
<div class="stats-row">
  <div class="stat-card" style="--c:#b04141">
    <div class="num">{{ $stats['total'] }}</div>
    <div class="lbl">إجمالي الطلبات</div>
  </div>
  <div class="stat-card" style="--c:#d97706">
    <div class="num">{{ $stats['pending'] }}</div>
    <div class="lbl">بانتظار التواصل</div>
  </div>
  <div class="stat-card" style="--c:#2563eb">
    <div class="num">{{ $stats['contacted'] }}</div>
    <div class="lbl">تم التواصل</div>
  </div>
  <div class="stat-card" style="--c:#059669">
    <div class="num">{{ $stats['done'] }}</div>
    <div class="lbl">مكتملة</div>
  </div>
</div>

{{-- Filters + Search --}}
<div class="filters">
  <button class="filter-btn active" onclick="filterTable('all', this)">الكل</button>
  <button class="filter-btn" onclick="filterTable('pending', this)">بانتظار التواصل</button>
  <button class="filter-btn" onclick="filterTable('contacted', this)">تم التواصل</button>
  <button class="filter-btn" onclick="filterTable('done', this)">مكتملة</button>
  <input type="text" class="search-input" placeholder="ابحث برقم الهاتف أو نوع الاستشارة..." oninput="searchTable(this.value)">
</div>

{{-- Table --}}
<div class="table-wrap">
  <div class="table-card">
    @if($bookings->isEmpty())
      <div class="empty-state">
        <span class="emoji">📭</span>
        لا توجد طلبات حتى الآن
      </div>
    @else
      <table id="bookings-table">
        <thead>
          <tr>
            <th>#</th>
            <th>رقم الهاتف</th>
            <th>نوع الاستشارة</th>
            <th>تفاصيل</th>
            <th>التاريخ</th>
            <th>الحالة</th>
            <th>تواصل</th>
          </tr>
        </thead>
        <tbody>
          @foreach($bookings as $booking)
          <tr data-status="{{ $booking->status }}" data-search="{{ strtolower($booking->phone . ' ' . $booking->problem_type) }}">
            <td style="color:#9ca3af;font-size:13px;">{{ $booking->id }}</td>
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
                <span style="color:#d1d5db;font-size:12px;">—</span>
              @endif
            </td>
            <td>
              <div class="date-text">{{ $booking->created_at->format('Y/m/d') }}</div>
              <div class="date-text">{{ $booking->created_at->format('H:i') }}</div>
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
              @php
                $msg = "مرحباً، معي فريق مركز مطمئنة.\nتواصلنا معك بخصوص طلب الاستشارة ({$booking->problem_type}).\nهل يناسبك نحدد موعداً الآن؟";
              @endphp
              <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $booking->phone) }}?text={{ urlencode($msg) }}"
                 target="_blank" class="wa-btn">
                <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.135.561 4.14 1.541 5.876L.057 23.272a.5.5 0 00.616.632l5.57-1.453A11.93 11.93 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.99 0-3.851-.523-5.461-1.436l-.393-.228-4.076 1.064 1.1-3.98-.255-.407A9.953 9.953 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>
                واتساب
              </a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    @endif
  </div>
</div>

<script>
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
</script>

</body>
</html>
