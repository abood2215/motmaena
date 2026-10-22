@extends('admin.layout')

@section('title', 'الدورات')

@section('actions')
  <a href="{{ route('admin.courses.create') }}" class="btn btn-primary btn-sm">+ دورة جديدة</a>
@endsection

@section('content')
<p class="small" style="margin-bottom:14px">
  كل دورة "التسجيل مفتوح" إلها صفحة تسجيل ودفع خاصة. الدورة "المميّزة" هي اللي بتطلع بالإعلان الكبير وشريط الإعلان بالصفحة الرئيسية (وحدة بس بنفس الوقت).
</p>

<div class="table-card">
  <div class="table-scroll">
    @if($offers->isEmpty())
      <div class="empty">لا توجد دورات بعد — اضغط "دورة جديدة"</div>
    @else
    <table>
      <thead>
        <tr><th></th><th>الدورة</th><th>التاريخ</th><th>السعر</th><th>المدفوع</th><th>الحالة</th><th></th></tr>
      </thead>
      <tbody>
        @foreach($offers as $o)
        @php $c = $counts[$o->slug] ?? null; @endphp
        <tr>
          <td><img class="thumb" src="{{ asset($o->image ?: \App\Models\CourseOffer::DEFAULT_IMAGE) }}" alt="" style="background: {{ $o->theme_color }}"></td>
          <td>
            <strong>{{ $o->title_ar }}</strong>
            <div class="small ltr">{{ route('course.register', $o->slug) }}</div>
          </td>
          <td class="small">{{ $o->date->format('Y-m-d') }}<div>{{ $o->date->locale('ar')->dayName }}</div></td>
          <td><strong>{{ rtrim(rtrim(number_format((float) $o->price, 3), '0'), '.') }}</strong> <span class="small">د.ك</span></td>
          <td class="small">{{ $c->c ?? 0 }}{{ $o->seats ? ' / ' . $o->seats : '' }} تسجيل<div>{{ rtrim(rtrim(number_format((float) ($c->total ?? 0), 3), '0'), '.') }} د.ك</div></td>
          <td>
            <form method="POST" action="{{ route('admin.courses.toggle', [$o, 'is_active']) }}" class="inline">@csrf
              <button class="tag {{ $o->is_active ? 'on' : 'off' }}" style="cursor:pointer">{{ $o->is_active ? 'التسجيل مفتوح' : 'مغلق' }}</button>
            </form>
            <form method="POST" action="{{ route('admin.courses.toggle', [$o, 'is_featured']) }}" class="inline">@csrf
              <button class="tag {{ $o->is_featured ? 'pending' : '' }}" style="cursor:pointer;border-color:var(--border)">{{ $o->is_featured ? '⭐ مميّزة' : 'اجعلها مميّزة' }}</button>
            </form>
          </td>
          <td>
            <div class="row-actions">
              <a href="{{ route('admin.courses.edit', $o) }}" class="btn btn-outline btn-sm">تعديل</a>
              <a href="{{ route('admin.courses.create', ['from' => $o->id]) }}" class="btn btn-outline btn-sm" title="دورة جديدة بنفس التصميم والمعلومات — بتغيّر بس اللي بدك ياه">⧉ نسخ كدورة جديدة</a>
              <a href="{{ route('admin.courses.reviews', $o) }}" class="btn btn-outline btn-sm">⭐ طلب تقييم</a>
              <a href="{{ route('course.register', $o->slug) }}" target="_blank" class="btn btn-outline btn-sm">عرض</a>
              <button type="button" class="btn btn-outline btn-sm" onclick="navigator.clipboard.writeText('{{ route('course.register', $o->slug) }}');this.textContent='تم النسخ ✓'">نسخ الرابط</button>
              <form method="POST" action="{{ route('admin.courses.destroy', $o) }}" class="inline" onsubmit="return confirm('حذف الدورة؟')">@csrf @method('DELETE')
                <button class="btn btn-outline btn-sm" style="color:#b91c1c">حذف</button>
              </form>
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    @endif
  </div>
</div>
@endsection
