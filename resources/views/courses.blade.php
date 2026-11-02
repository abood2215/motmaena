@extends('layouts.app')

@section('title', app()->getLocale() == 'ar' ? 'دورات حضورية ومسجّلة في الكويت | مركز مطمئنة' : 'In-person and Recorded Courses in Kuwait | Motmaena Center')
@section('meta_description', app()->getLocale() == 'ar' ? 'دورات حضورية في مقر مركز مطمئنة بالكويت، ودورات مسجّلة في التربية وتطوير الذات والعلاقات تتابعها في أي وقت، بإشراف أ.د. طارق الحبيب.' : 'In-person courses at Motmaena Center in Kuwait, and recorded courses on parenting, self-development and relationships to watch anytime, supervised by Prof. Dr. Tariq Al-Habib.')
@include('partials.breadcrumb-schema', ['items' => [[app()->getLocale() == 'ar' ? 'الدورات' : 'Courses', route('courses')]]])

@section('content')

@include('partials.lx-styles')
@php $isArP = app()->getLocale() == 'ar'; @endphp

{{-- ════════════════ HERO ════════════════ --}}
<section class="lx lx-ivory border-b" style="border-color: var(--line)" dir="{{ $isArP ? 'rtl' : 'ltr' }}">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
        <nav aria-label="{{ $isArP ? 'مسار التنقل' : 'Breadcrumb' }}" class="mb-8 text-sm font-semibold lx-muted">
            <a href="{{ route('home') }}" class="hover:underline underline-offset-4">{{ $isArP ? 'الرئيسية' : 'Home' }}</a>
            <span class="mx-2">/</span>
            <span aria-current="page" style="color: var(--ink)">{{ $isArP ? 'الدورات' : 'Courses' }}</span>
        </nav>
        <p class="lx-label mb-4">{{ __('Exclusive and recorded courses') }}</p>
        <h1 class="lx-h1 mb-5">{{ $isArP ? 'دورات حضورية ومسجّلة مع أ.د. طارق الحبيب' : 'In-person and recorded courses with Prof. Dr. Tariq Al-Habib' }}</h1>
        <p class="lx-text text-lg max-w-2xl">
            {{ $isArP
                ? 'استكشف مجموعة واسعة من الدورات التنموية والتربوية تحت إشراف أ.د. طارق الحبيب، بروفيسور واستشاري الطب النفسي، لتطوير مهاراتك ومهاراتك الشخصية.'
                : 'Explore a wide range of developmental and educational courses under the supervision of Prof. Dr. Tariq Al-Habib, professor & consultant psychiatrist, to develop your skills and personal skills.' }}
        </p>
        <div class="flex flex-col sm:flex-row gap-3 mt-8">
            @if(rescue(fn () => \App\Models\CourseOffer::upcoming()->isNotEmpty(), false, false))
            <a href="#live" class="lx-btn lx-btn-primary">{{ $isArP ? 'الدورات الحضورية القادمة' : 'Upcoming in-person courses' }}</a>
            @endif
            <a href="#courses" class="lx-btn lx-btn-outline">{{ $isArP ? 'الدورات المسجّلة' : 'Recorded courses' }}</a>
        </div>
    </div>
</section>

{{-- ════════════════ OPEN (LIVE) COURSES — same course the homepage advertises ════════════════ --}}
@php
    $liveOffers = rescue(function () {
        $featured = \App\Models\CourseOffer::featured();
        return \App\Models\CourseOffer::upcoming()
            ->sortBy(fn ($o) => $featured && $o->id === $featured->id ? 0 : 1)
            ->map->toOfferArray()->values();
    }, collect(), false);
@endphp
@if($liveOffers->isNotEmpty())
<section id="live" class="lx lx-paper pt-12 sm:pt-16 scroll-mt-20" dir="{{ $isArP ? 'rtl' : 'ltr' }}">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        <div>
            <p class="lx-label mb-3">{{ $isArP ? 'حضوري في المركز' : 'In person at the center' }}</p>
            <h2 class="lx-h2">{{ $isArP ? 'التسجيل مفتوح الآن' : 'Registration open now' }}</h2>
        </div>
        @foreach($liveOffers as $offer)
            @include('partials.live-course-banner', ['offer' => $offer])
        @endforeach
        @php $liveBundle = \App\Models\CourseBundle::current(); @endphp
        @if($liveBundle)
            @php $lbAr = app()->getLocale() == 'ar'; $lbFmt = fn ($v) => \App\Models\CourseBundle::fmt((float) $v); @endphp
            <div class="lx lx-ink rounded-[14px] p-7 sm:p-9 flex flex-col lg:flex-row lg:items-center gap-6" dir="{{ $lbAr ? 'rtl' : 'ltr' }}">
                <div class="flex-1">
                    <p class="lx-label mb-3" style="color: #d9c4a0">{{ $liveBundle->title($lbAr ? 'ar' : 'en') }}</p>
                    <p class="text-2xl font-extrabold text-white">
                        {{ $lbAr ? 'الدورتان معاً بـ ' . $lbFmt($liveBundle->price) . ' د.ك' : 'Both courses for ' . $lbFmt($liveBundle->price) . ' KWD' }}
                        <span class="text-lg font-semibold text-white/50 line-through mx-2">{{ $lbFmt($liveBundle->fullPrice()) }}</span>
                    </p>
                    <p class="text-white/70 font-semibold mt-1">{{ $liveBundle->courses()->pluck($lbAr ? 'title_ar' : 'title_en')->implode(' + ') }}</p>
                </div>
                <a href="{{ route('bundle.register', $liveBundle->slug) }}" class="lx-btn lx-btn-light shrink-0">{{ $lbAr ? 'احجز العرض' : 'Book the offer' }}</a>
            </div>
        @endif
    </div>
</section>
@endif

{{-- ════════════════ COURSES GRID SECTION ════════════════ --}}
<section id="courses" class="lx lx-paper py-14 sm:py-20 scroll-mt-20">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <livewire:course-grid />
    </div>
</section>

@endsection

@push('scripts')
<script>
    // Reveal animation for the new page
    document.addEventListener('DOMContentLoaded', () => {
        if (typeof reveal === 'function') reveal();
    });
</script>
@endpush
