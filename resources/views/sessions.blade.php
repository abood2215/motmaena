@extends('layouts.app')

@section('title', app()->getLocale() == 'ar' ? 'جلسات وتقييم الأطفال في الكويت | مركز مطمئنة' : "Children's Sessions & Assessments in Kuwait | Motmaena Center")
@include('partials.breadcrumb-schema', ['items' => [[app()->getLocale() == 'ar' ? 'الجلسات' : 'Sessions', route('sessions')]]])
@section('meta_description', app()->getLocale() == 'ar' ? 'جلسات وباقات لتنمية مهارات طفلك وتعديل سلوكه، وتقييمات متخصصة، مع إمكانية التقسيط — مركز مطمئنة، الكويت.' : 'Sessions and packages to build your child\'s skills and behaviour, with specialist assessments and instalments — Motmaena Center, Kuwait.')

{{-- Children's sessions, in the site's quiet editorial look (partials/lx-styles): every price in plain view,
     one wine button per card, and WhatsApp messages that name the package asked about. --}}
@php
    $isAr = app()->getLocale() === 'ar';
    $t = fn ($ar, $en) => $isAr ? $ar : $en;
    $kd = __('KD');
    $wa = fn (string $topic) => 'https://wa.me/' . $site['whatsapp'] . '?text=' . rawurlencode($t('مرحباً، أستفسر عن: ', 'Hello, I would like to ask about: ') . $topic);

    $plans = [
        ['sessions' => __('12 Sessions'), 'price' => 360, 'features' => [__('Massive improvement area'), __('One Month Duration'), __('3 Days / Week')], 'cta' => __('Get Started'), 'featured' => false],
        ['sessions' => __('24 Sessions'), 'price' => 750, 'features' => [__('Significant Behavioral Change'), __('3 Months Duration'), __('2 Days / Week')], 'cta' => __('Choose This Package'), 'featured' => true],
        ['sessions' => __('36 Sessions'), 'price' => 900, 'features' => [__('Total Mastery & Skills'), __('3 Months Duration'), __('3 Days / Week')], 'cta' => __('Select Package'), 'featured' => false],
    ];
    // Removed "≈ 31 KD per person / month only" from the 24-session package: 31 is the price per SESSION (750 / 24 = 31.25);
    // that 3-month package is about 250 KD a month. No replacement until the center confirms the wording.

    $tracks = [
        [__('Intensive Month') . ' · ' . __('12 Sessions'), 360, __('3 Days Per Week'), __('Book Now'), false],
        [__('Therapeutic Track') . ' · ' . __('24 Sessions'), 750, __('2 Days Per Week / 3 Months'), __('Choose Track'), true],
        [__('Advanced Track') . ' · ' . __('36 Sessions'), 900, __('3 Days Per Week / 3 Months'), __('Get Started'), false],
    ];
@endphp

@section('content')
@include('partials.lx-styles')
<style>
    .ss-price { font-size: 2.6rem; font-weight: 800; color: var(--ink); line-height: 1; }
    .ss-price small { font-size: .9rem; font-weight: 700; color: var(--muted); margin-inline-start: 4px; }
    .ss-featured { border-color: var(--wine); box-shadow: inset 0 0 0 1px var(--wine); }
    .ss-badge { display: inline-block; font-size: 12px; font-weight: 800; color: var(--wine); border: 1px solid var(--wine); border-radius: 999px; padding: 3px 12px; }
    .dark .ss-badge, .dark .ss-featured { border-color: var(--gold-l); color: var(--gold-l); }
    .dark .ss-featured { box-shadow: inset 0 0 0 1px var(--gold-l); }
    .ss-row { display: flex; align-items: center; justify-content: space-between; gap: 16px; padding: 18px 0; }
    .ss-row + .ss-row { border-top: 1px solid var(--line); }
    .ss-steps { display: flex; align-items: center; gap: 10px; }
    .ss-steps span { width: 38px; height: 38px; border-radius: 999px; border: 1px solid rgba(255,255,255,.35); display: inline-flex; align-items: center; justify-content: center; font-weight: 800; color: #fff; }
    .ss-steps i { flex: 1; height: 1px; background: rgba(255,255,255,.25); min-width: 12px; }
</style>

<div class="lx" dir="{{ $isAr ? 'rtl' : 'ltr' }}">

{{-- ═══════════════ HERO ═══════════════ --}}
<section class="lx-ivory" data-track-location="hero">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-20">
        <nav aria-label="{{ $t('مسار التنقل', 'Breadcrumb') }}" class="mb-8 text-sm font-semibold lx-muted">
            <a href="{{ route('home') }}" class="hover:underline underline-offset-4">{{ $t('الرئيسية', 'Home') }}</a>
            <span class="mx-2">/</span>
            <span aria-current="page" style="color: var(--ink)">{{ $t('جلسات الأطفال', 'Child sessions') }}</span>
        </nav>
        <div class="grid lg:grid-cols-12 gap-12 lg:gap-16 items-center">
            <div class="lg:col-span-7">
                <p class="lx-label mb-5">{{ __('Linguistic, Educational, and Training Consultations') }}</p>
                {{-- The heading names the service and the place, as parents search for it --}}
                <h1 class="lx-h1 mb-5">{{ $t('جلسات وتقييم الأطفال في الكويت', 'Sessions & assessments for children in Kuwait') }}</h1>
                <p class="lx-text text-lg mb-8 max-w-2xl"><strong style="color: var(--ink)">{{ strip_tags(__('Your Child Deserves the Best')) }}.</strong> {{ __('Sessions Hero Subtitle') }}</p>
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="#plans" class="lx-btn lx-btn-primary">{{ __('View Plans') }}</a>
                    <a href="{{ $wa($t('جلسات الأطفال', 'Child sessions')) }}" target="_blank" rel="noopener" class="lx-btn lx-btn-outline">@include('partials.lx-icon', ['i' => 'whatsapp', 'class' => '!w-5 !h-5']){{ __('Talk to a Specialist') }}</a>
                </div>
            </div>

            {{-- Unconfirmed figures and rating: hidden until the center confirms them (config/claims.php) --}}
            @if(config('claims.show_unverified'))
            <div class="lg:col-span-5 lx-card p-7">
                <p class="text-sm font-bold lx-muted mb-5">{{ __('Our Achievements in Numbers') }}</p>
                <div class="grid grid-cols-3 gap-4 mb-6">
                    @foreach([['500', '+500', __('Children Benefited')], ['12', '+12', __('Years Experience')], ['98', '98%', __('Parent Satisfaction')]] as [$n, $shown, $l])
                        <div><p class="text-2xl font-extrabold lx-wine" data-target="{{ $n }}">{{ $shown }}</p><p class="text-xs lx-muted font-semibold mt-1">{{ $l }}</p></div>
                    @endforeach
                </div>
                <p class="text-sm"><span class="lx-muted">★★★★★</span> <strong style="color: var(--ink)">{{ __('Exceptional Family Satisfaction') }}</strong> · {{ __('Real reviews from our followers\' families') }}</p>
            </div>
            @else
            <div class="lg:col-span-5">
                <div class="lx-card p-7">
                    <p class="text-sm font-bold lx-muted mb-2">{{ __('Approved Pricing') }}</p>
                    <div class="ss-row"><span class="font-bold" style="color: var(--ink)">{{ __('Initial Evaluation') }}</span><span class="font-extrabold" style="color: var(--ink)">50 <small class="lx-muted">{{ $kd }}</small></span></div>
                    <div class="ss-row"><span class="font-bold" style="color: var(--ink)">{{ __('Specialist Tests') }}</span><span class="font-extrabold" style="color: var(--ink)">120 <small class="lx-muted">{{ $kd }}</small></span></div>
                    <div class="ss-row"><span class="font-bold" style="color: var(--ink)">{{ __('Session Packages') }}</span><span class="font-extrabold" style="color: var(--ink)"><small class="lx-muted">{{ $t('من', 'from') }}</small> 360 <small class="lx-muted">{{ $kd }}</small></span></div>
                    <p class="text-sm lx-muted font-semibold mt-3 flex items-center gap-2">@include('partials.lx-icon', ['i' => 'split', 'class' => '!w-[18px] !h-[18px]']){{ $t('تقسيط على 4 دفعات مع deema', '4 payments with deema') }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>

{{-- ═══════════════ ASSESSMENTS ═══════════════ --}}
<section class="lx-paper lx-section">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mb-10">
            <p class="lx-label mb-3">{{ __('Approved Pricing') }}</p>
            <h2 class="lx-h2">{{ __('Academic, Behavioral, and Skill Services') }}</h2>
        </div>
        <div class="grid md:grid-cols-2 gap-5">
            <div class="lx-card p-6 sm:p-8 flex items-center gap-5">
                <span class="lx-icon-ring">@include('partials.lx-icon', ['i' => 'eye'])</span>
                <div class="flex-1 min-w-0">
                    <h3 class="lx-h3">{{ __('Initial Evaluation') }}</h3>
                    <p class="text-sm lx-muted font-semibold mt-1">{{ __('Comprehensive diagnostic session') }}</p>
                </div>
                <p class="ss-price">50<small>{{ $kd }}</small></p>
            </div>
            <div class="lx-card p-6 sm:p-8">
                <div class="flex items-center gap-5">
                    <span class="lx-icon-ring">@include('partials.lx-icon', ['i' => 'chart'])</span>
                    <div class="flex-1 min-w-0">
                        <h3 class="lx-h3">{{ __('Specialist Tests') }}</h3>
                        <p class="text-sm lx-muted font-semibold mt-1">{{ __('ADHD, IQ, and Behavioral Assessments') }}</p>
                    </div>
                    <p class="ss-price">120<small>{{ $kd }}</small></p>
                </div>
                <div class="flex flex-wrap gap-2 mt-5 pt-5 border-t" style="border-color: var(--line)">
                    @foreach([__('Academic'), __('Behavioral'), __('IQ Test')] as $tag)
                        <span class="text-xs font-bold px-3 py-1.5 rounded-full" style="border: 1px solid var(--line); color: var(--ink)">{{ $tag }}</span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════ SESSION PACKAGES ═══════════════ --}}
<section id="plans" class="lx-ivory lx-section scroll-mt-20">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mb-10">
            <p class="lx-label mb-3">{{ __('Choose Your Plan') }}</p>
            <h2 class="lx-h2 mb-3">{{ __('Session Packages') }}</h2>
            <p class="lx-text">{{ __('Sessions Subtitle') }}</p>
        </div>
        <div class="grid md:grid-cols-3 gap-5">
            @foreach($plans as $p)
                <div class="lx-card p-6 sm:p-8 flex flex-col {{ $p['featured'] ? 'ss-featured' : '' }}">
                    <div class="flex items-center justify-between gap-3 mb-5">
                        <p class="font-bold" style="color: var(--ink)">{{ $p['sessions'] }}</p>
                        @if($p['featured'])<span class="ss-badge">{{ __('Most Popular') }}</span>@endif
                    </div>
                    <p class="ss-price mb-6">{{ $p['price'] }}<small>{{ $kd }}</small></p>
                    <ul class="space-y-2 mb-8 pt-5 border-t" style="border-color: var(--line)">
                        @foreach($p['features'] as $f)
                            <li class="lx-topic">@include('partials.lx-icon', ['i' => 'check']){{ $f }}</li>
                        @endforeach
                    </ul>
                    <a href="{{ $wa(__('Session Packages') . ' · ' . $p['sessions'] . ' · ' . $p['price'] . ' ' . $kd) }}" target="_blank" rel="noopener" class="mt-auto lx-btn {{ $p['featured'] ? 'lx-btn-primary' : 'lx-btn-outline' }} w-full">{{ $p['cta'] }}</a>
                </div>
            @endforeach
        </div>

        {{-- Instalments with deema --}}
        <div class="lx-ink rounded-[14px] mt-8 p-7 sm:p-10 grid lg:grid-cols-12 gap-8 items-center" data-track-location="installments">
            <div class="lg:col-span-7">
                <div class="flex items-center gap-3 mb-4">
                    <img src="{{ asset('deema-logo.webp') }}" alt="deema" width="160" height="112" loading="lazy" decoding="async" class="h-6 w-auto object-contain" style="filter: brightness(0) invert(1)">
                    <span class="text-xs font-bold text-white/60">{{ $t('بالتعاون مع Deema', 'In partnership with Deema') }}</span>
                </div>
                <p class="text-2xl sm:text-3xl font-extrabold text-white leading-snug mb-3">{{ $t('قسّط اشتراكك على 4 دفعات ميسّرة', 'Pay your subscription in 4 easy installments') }}</p>
                <p class="text-sm text-white/65 font-semibold">{{ $t('بدون رسوم إضافية', 'Zero Extra Fees') }} · {{ $t('موافقة فورية', 'Instant Approval') }} · {{ $t('آمن 100%', '100% Secure') }}</p>
            </div>
            <div class="lg:col-span-5">
                <div class="ss-steps mb-6" dir="ltr">
                    @for($step = 1; $step <= 4; $step++)
                        <span>{{ $step }}</span>@if($step < 4)<i></i>@endif
                    @endfor
                </div>
                <a href="{{ $wa($t('التقسيط مع deema', 'Instalments with deema')) }}" target="_blank" rel="noopener" class="lx-btn lx-btn-light w-full">@include('partials.lx-icon', ['i' => 'whatsapp', 'class' => '!w-5 !h-5']){{ $t('تواصل معنا الآن', 'Contact Us Now') }}</a>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════ CLUB + SUBJECT REINFORCEMENT ═══════════════ --}}
<section class="lx-paper lx-section">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 grid lg:grid-cols-2 gap-5">
        <div class="lx-card p-6 sm:p-8">
            <p class="lx-label mb-3">{{ __('The Club') }}</p>
            <h3 class="lx-h2 mb-6">{{ __('Monthly Subscriptions') }}</h3>
            <div class="ss-row"><span class="font-bold" style="color: var(--ink)">{{ $t('اشتراك يومي · مدة شهر', 'Daily · One Month') }}</span><span class="text-2xl font-extrabold" style="color: var(--ink)">250 <small class="text-sm lx-muted">{{ $kd }}</small></span></div>
            <div class="ss-row"><span class="font-bold" style="color: var(--ink)">{{ $t('٣ أيام بالأسبوع · ٤٥ دقيقة', '3 Days/Week · 45 Min') }}</span><span class="text-2xl font-extrabold" style="color: var(--ink)">150 <small class="text-sm lx-muted">{{ $kd }}</small></span></div>
            <div class="lx-notice p-4 mt-5 flex items-center gap-3">
                @include('partials.lx-icon', ['i' => 'family'])
                <p class="text-sm font-semibold"><strong style="color: var(--ink)">{{ __('Sibling Discount') }}</strong> · {{ $t('تواصل معنا للاستفسار', 'Contact us for details') }}</p>
            </div>
            <a href="{{ $wa(__('Monthly Subscriptions')) }}" target="_blank" rel="noopener" class="lx-btn lx-btn-outline w-full mt-6">{{ __('Inquire') }}</a>
        </div>

        <div class="lx-card p-6 sm:p-8 flex flex-col">
            <div class="flex items-start justify-between gap-4 mb-6">
                <div>
                    <p class="lx-label mb-3">{{ $t('تقوية', 'Tutoring') }}</p>
                    <h3 class="lx-h2">{{ __('Subject Reinforcement') }}</h3>
                    <p class="text-sm lx-muted font-semibold mt-2">{{ __('Reinforcement Subjects') }}</p>
                </div>
                <p class="ss-price">200<small>{{ $kd }}</small></p>
            </div>
            <div class="grid grid-cols-2 gap-3 mb-6">
                @foreach([['clock', __('1.5 Hours / Session')], ['calendar', __('2 Days / Week')], ['layers', __('8 Total Sessions')], ['check', __('Comprehensive Follow-up')]] as [$icon, $label])
                    <div class="flex items-center gap-2.5 text-sm font-bold" style="color: var(--ink)">@include('partials.lx-icon', ['i' => $icon, 'class' => '!w-[18px] !h-[18px]']){{ $label }}</div>
                @endforeach
            </div>
            <a href="{{ $wa(__('Subject Reinforcement')) }}" target="_blank" rel="noopener" class="mt-auto lx-btn lx-btn-outline w-full">{{ __('Inquire') }}</a>
        </div>
    </div>
</section>

{{-- ═══════════════ SPECIAL NEEDS ═══════════════ --}}
<section class="lx-ivory lx-section" data-track-location="special-needs">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mb-10">
            <p class="lx-label mb-3">{{ __('Specialized Support') }}</p>
            <h2 class="lx-h2 mb-3">{{ __('Services for Autism, Down Syndrome, & Disabilities') }}</h2>
            <p class="lx-text">{{ __('Highly specialized therapeutic programs tailored for children with neurodevelopmental and physical challenges, delivered by experts.') }}</p>
        </div>

        <div class="grid md:grid-cols-2 gap-5 mb-5">
            @foreach([['shield', __('Opening Evaluation'), __('Specialized assessment protocols'), 50], ['chart', __('Disability Diagnosis'), __('Global standardized intelligence tests'), 120]] as [$icon, $name, $sub, $price])
                <div class="lx-card p-6 sm:p-8 flex items-center gap-5">
                    <span class="lx-icon-ring">@include('partials.lx-icon', ['i' => $icon])</span>
                    <div class="flex-1 min-w-0"><h3 class="lx-h3">{{ $name }}</h3><p class="text-sm lx-muted font-semibold mt-1">{{ $sub }}</p></div>
                    <p class="ss-price">{{ $price }}<small>{{ $kd }}</small></p>
                </div>
            @endforeach
        </div>

        <div class="grid md:grid-cols-3 gap-5 mb-5">
            @foreach($tracks as [$label, $price, $sched, $cta, $feat])
                <div class="lx-card p-6 sm:p-8 flex flex-col {{ $feat ? 'ss-featured' : '' }}">
                    <p class="font-bold mb-4" style="color: var(--ink)">{{ $label }}</p>
                    <p class="ss-price mb-4">{{ $price }}<small>{{ $kd }}</small></p>
                    <p class="text-sm lx-muted font-semibold mb-6 flex items-center gap-2">@include('partials.lx-icon', ['i' => 'calendar', 'class' => '!w-[18px] !h-[18px]']){{ $sched }}</p>
                    <a href="{{ $wa(__('Specialized Support') . ' · ' . $label) }}" target="_blank" rel="noopener" class="mt-auto lx-btn {{ $feat ? 'lx-btn-primary' : 'lx-btn-outline' }} w-full">{{ $cta }}</a>
                </div>
            @endforeach
        </div>

        <div class="lx-card p-6 sm:p-8 grid lg:grid-cols-12 gap-6 items-center">
            <div class="lg:col-span-8 flex gap-5">
                <span class="lx-icon-ring">@include('partials.lx-icon', ['i' => 'building'])</span>
                <div>
                    <h3 class="lx-h3 mb-2">{{ __('Specialized Reception Club') }}</h3>
                    <p class="lx-text text-[15px] mb-3">{{ __('Morning support program focused on social integration and basic skills development for children with disabilities.') }}</p>
                    <p class="text-sm font-bold" style="color: var(--ink)">{{ __('Schedule') }}: <span class="lx-muted">{{ __('One Month Duration') }}</span> · {{ __('Available') }}: <span class="lx-muted">{{ __('Sun - Thu') }}</span></p>
                </div>
            </div>
            <div class="lg:col-span-4 flex items-center justify-between lg:justify-end gap-6">
                <p class="ss-price">200<small>{{ $kd }}</small></p>
                <a href="{{ $wa(__('Specialized Reception Club')) }}" target="_blank" rel="noopener" class="lx-btn lx-btn-outline">{{ __('Inquire') }}</a>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════ CLOSING CALL TO ACTION ═══════════════ --}}
<section class="lx-ink" data-track-location="final-cta">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20 text-center max-w-3xl">
        <p class="lx-label mb-4 justify-center" style="color: #d9c4a0">{{ __('Opening Evaluation Fee') }}</p>
        <h2 class="text-3xl sm:text-4xl font-extrabold text-white leading-snug mb-4">{{ strip_tags(__('Ready to Start Your Child\'s Journey?')) }}</h2>
        <p class="text-white/65 font-semibold mb-8">{{ __('Our specialized consultants are ready to assist you in choosing the most appropriate path for your child\'s unique needs.') }}</p>
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ $wa($t('جلسات الأطفال', 'Child sessions')) }}" target="_blank" rel="noopener" class="lx-btn lx-btn-light">@include('partials.lx-icon', ['i' => 'whatsapp', 'class' => '!w-5 !h-5']){{ __('Talk to a Specialist') }}</a>
            <a href="tel:+{{ $site['whatsapp'] }}" class="lx-btn border border-white/30 text-white hover:bg-white/10">@include('partials.lx-icon', ['i' => 'phone', 'class' => '!w-5 !h-5 !stroke-white']){{ __('Call Us Directly') }}</a>
        </div>
        {{-- Related service: the support packages by need (communication, learning, behaviour…) --}}
        <p class="mt-8 text-white/70 font-semibold">
            {{ $t('تبحث عن برنامج حسب احتياج طفلك؟', 'Looking for a programme for a specific need?') }}
            <a href="{{ route('packages') }}" class="underline underline-offset-4 font-extrabold" style="color: #d9c4a0">{{ $t('باقات دعم الطفل', 'Child support packages') }}</a>
        </p>
    </div>
</section>

</div>
@endsection
