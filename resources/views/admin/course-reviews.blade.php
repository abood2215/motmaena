@extends('admin.layout')

@section('title', 'طلب تقييم — ' . $offer->title_ar)

@section('actions')
  <a href="{{ route('admin.courses') }}" class="btn btn-outline btn-sm">← الدورات</a>
@endsection

@section('content')
<div class="card">
  <h3>⭐ اطلب من المتدربين يقيّموا الدورة</h3>
  <p class="small">
    كل متدرب إله رابط تقييم خاص فيه. اضغط "واتساب" جنب الاسم وبتنفتح رسالة جاهزة. التقييمات بتوصلك بـ
    <a href="{{ route('admin.content') }}">محتوى الموقع ← آراء المتدربين</a>
    وبتكون مخفية لحد ما تختار تنشرها. الأفضل تبعت الطلب بنفس يوم الدورة أو اليوم اللي بعده.
  </p>
</div>

<div class="table-card">
  <div class="table-scroll">
    @if($registrations->isEmpty())
      <div class="empty">ما في تسجيلات مدفوعة بهالدورة بعد.</div>
    @else
    <table>
      <thead><tr><th>الاسم</th><th>الهاتف</th><th>طلب التقييم</th><th>التقييم</th><th></th></tr></thead>
      <tbody>
        @foreach($registrations as $r)
        @php
          $digits = preg_replace('/\D/', '', $r->phone);
          $wa = strlen($digits) === 8 ? '965' . $digits : ltrim($digits, '0');
          $msg = "مرحباً {$r->name} 🌷\nشكراً لحضورك {$offer->title_ar} في مركز مطمئنة.\nيهمنا رأيك — ممكن تقيّم الدورة بدقيقة وحدة؟\n" . route('review.show', $r->review_token);
        @endphp
        <tr>
          <td><strong>{{ $r->name }}</strong></td>
          <td class="ltr">{{ $r->phone }}</td>
          <td class="small" id="req-{{ $r->id }}">{{ $r->review_requested_at ? '✓ ' . $r->review_requested_at->format('Y-m-d') : '—' }}</td>
          <td>
            @if($r->testimonial)
              <span style="color:#f59e0b">{{ str_repeat('★', $r->testimonial->rating) }}</span>
              <div class="small">{{ \Illuminate\Support\Str::limit($r->testimonial->quote, 50) }}</div>
            @else
              <span class="small">لسا</span>
            @endif
          </td>
          <td>
            @unless($r->testimonial)
            <a href="https://wa.me/{{ $wa }}?text={{ rawurlencode($msg) }}" target="_blank" class="btn btn-sm" style="background:#25d366;color:#fff"
               onclick="fetch('{{ route('admin.registrations.review-requested', $r) }}', {method:'POST', headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','Accept':'application/json'}}); document.getElementById('req-{{ $r->id }}').textContent='✓ اليوم';">واتساب</a>
            @endunless
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    @endif
  </div>
</div>
@endsection
