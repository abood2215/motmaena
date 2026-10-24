@extends('layouts.app')

{{-- Homepage. The hero sells the featured course (Admin → Courses → "featured"); its colour follows the course theme. --}}
@php
    $lang = app()->getLocale() == 'ar' ? 'ar' : 'en';
    $isAr = $lang === 'ar';
    $t = fn ($ar, $en) => $isAr ? $ar : $en;

    $featuredModel = \App\Models\CourseOffer::featured();
    $featured = $featuredModel?->toOfferArray();
    $others = \App\Models\CourseOffer::upcoming()->reject(fn ($o) => $featuredModel && $o->id === $featuredModel->id)->map->toOfferArray();
    $faqs = \App\Models\Faq::where('is_active', true)->orderBy('sort')->get();
    $testimonials = \App\Models\Testimonial::where('is_active', true)->orderBy('sort')->get();
    $waLink = fn ($text) => 'https://wa.me/' . $site['whatsapp'] . '?text=' . rawurlencode($text);

    // Gift code for paying without a discount code (Admin → Content → gift amount; 0 hides every mention)
    $gift = \App\Models\CourseRegistration::giftAmount();
    $giftTxt = \App\Models\CourseRegistration::giftAmountText();
    $canBook = $featured && !$featured['is_full'];
    $friendPrice = $featured ? (float) $featured['price'] - $gift : 0;
    $fmt = fn ($v) => rtrim(rtrim(number_format((float) $v, 3, '.', ''), '0'), '.');
@endphp

@section('title', __('Welcome') . ' - ' . __('Motmaena Center'))
@if($canBook)
    @section('meta_description', $t($featured['title']['ar'] . ' مع أ.د. طارق الحبيب · ' . $featured['day']['ar'] . ' ' . \Carbon\Carbon::parse($featured['date'])->locale('ar')->translatedFormat('j F') . ' · ' . $featured['price'] . ' د.ك' . ($gift > 0 ? ' + كود هدية ' . $giftTxt . ' د.ك مع الحجز' : '') . '. مركز مطمئنة، الكويت.', $featured['title']['en'] . ' with Prof. Dr. Tariq Al-Habib · ' . \Carbon\Carbon::parse($featured['date'])->locale('en')->translatedFormat('j F') . ' · ' . $featured['price'] . ' KWD' . ($gift > 0 ? ' + a ' . $giftTxt . ' KWD gift code' : '') . '. Motmaena Center, Kuwait.'))
@endif
@if($featured && $featured['share_image'])
    @section('og_image', asset($featured['share_image']))
@endif

@section('content')
<style>
    .mh { --wine: #6d1b2b; --wine-d: color-mix(in srgb, var(--wine) 68%, #000); --wine-l: color-mix(in srgb, var(--wine) 82%, #fff); --gold: #c9a35c; --gold-l: #ead8b1; --cream: #faf6f1; --ink: #1c1917; }
    .mh-cream { background: var(--cream); }
    .dark .mh-cream { background: #120d0e; }
    .mh-wine { background: linear-gradient(135deg, var(--wine-d), var(--wine) 55%, var(--wine-l)); }
    .mh-gold { color: var(--gold); }
    .mh-title { color: var(--ink); }
    .dark .mh-title { color: #fff; }
    .mh-eyebrow { display: inline-flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 800; color: var(--wine); background: #fff; border: 1px solid #ecdcd6; padding: 6px 14px; border-radius: 999px; }
    .dark .mh-eyebrow { background: rgba(255,255,255,.06); border-color: rgba(255,255,255,.12); color: var(--gold-l); }
    .mh-btn { display: inline-flex; align-items: center; justify-content: center; gap: 10px; font-weight: 900; border-radius: 16px; padding: 16px 28px; transition: transform .15s, box-shadow .15s, background .15s; white-space: nowrap; }
    .mh-btn-primary { background: var(--wine); color: #fff; box-shadow: 0 14px 30px -12px var(--wine); }
    .mh-btn-primary:hover { background: var(--wine-d); transform: translateY(-2px); }
    .mh-btn-ghost { background: #fff; color: var(--wine); border: 1.5px solid #e7d3cc; }
    .mh-btn-ghost:hover { border-color: var(--wine); }
    .dark .mh-btn-ghost { background: transparent; color: var(--gold-l); border-color: rgba(255,255,255,.2); }
    .mh-arch { position: relative; aspect-ratio: 4 / 5; border-radius: 999px 999px 32px 32px; background: radial-gradient(120% 80% at 50% 100%, var(--wine-l), var(--wine) 45%, var(--wine-d)); overflow: hidden; box-shadow: 0 40px 80px -40px var(--wine-d); }
    .mh-arch::before { content: ''; position: absolute; inset: 14px; border-radius: inherit; border: 1.5px solid color-mix(in srgb, var(--gold) 70%, transparent); pointer-events: none; z-index: 2; }
    .mh-arch img { position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); width: 104%; max-width: none; filter: drop-shadow(0 18px 30px rgba(0,0,0,.35)); }
    .mh-arch::after { content: ''; position: absolute; inset: auto 0 0 0; height: 20%; background: linear-gradient(to top, color-mix(in srgb, var(--wine-d) 90%, transparent), transparent 95%); pointer-events: none; z-index: 1; }
    .mh-arch-glow { position: absolute; inset: 0; background: radial-gradient(60% 45% at 55% 30%, color-mix(in srgb, var(--gold-l) 45%, transparent), transparent 70%); pointer-events: none; }
    .mh-chip { display: inline-flex; align-items: center; gap: 8px; background: #fff; border: 1px solid #eee2dc; border-radius: 14px; padding: 10px 14px; font-size: 14px; font-weight: 800; color: #3f3a37; }
    .dark .mh-chip { background: rgba(255,255,255,.05); border-color: rgba(255,255,255,.1); color: #e7e5e4; }
    .mh-chip svg { color: var(--wine); }
    .dark .mh-chip svg { color: var(--gold); }
    .mh-card { background: #fff; border: 1px solid #efe5e0; border-radius: 24px; transition: transform .2s, box-shadow .2s; }
    .mh-card:hover { transform: translateY(-4px); box-shadow: 0 24px 50px -30px rgba(74, 15, 27, .45); }
    .dark .mh-card { background: #1a1415; border-color: rgba(255,255,255,.08); }
    .mh-num { font-family: inherit; font-weight: 900; color: var(--gold); }
    .mh-divider { height: 1px; background: linear-gradient(90deg, transparent, #e4d3cc, transparent); }
    .mh-section-title { font-size: clamp(1.6rem, 3.2vw, 2.4rem); font-weight: 900; line-height: 1.25; }

    .mh-accent { color: var(--wine); }
    .dark .mh-accent { color: var(--gold-l); }

    /* Gift offer */
    .mh-gift-pill { display: flex; align-items: center; gap: 12px; background: #fffaf0; border: 1.5px dashed var(--gold); border-radius: 18px; padding: 12px 16px; transition: transform .15s, box-shadow .15s; }
    .mh-gift-pill:hover { transform: translateY(-2px); box-shadow: 0 14px 30px -18px var(--gold); }
    .dark .mh-gift-pill { background: rgba(201,163,92,.08); }
    .mh-gift-ico { width: 44px; height: 44px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 22px; background: linear-gradient(135deg, var(--gold), #b38a3e); box-shadow: 0 8px 18px -8px #b38a3e; flex-shrink: 0; }
    .mh-coupon { position: relative; border-radius: 28px; color: #fff; background: radial-gradient(120% 90% at 100% 0%, var(--wine-l), var(--wine) 50%, var(--wine-d)); box-shadow: 0 40px 70px -40px var(--wine-d); overflow: hidden; }
    .mh-coupon::before { content: ''; position: absolute; inset: 10px; border: 1.5px solid color-mix(in srgb, var(--gold) 55%, transparent); border-radius: 20px; pointer-events: none; }
    .mh-coupon-cut { position: relative; border-top: 2px dashed rgba(255,255,255,.28); }
    .mh-coupon-cut::before, .mh-coupon-cut::after { content: ''; position: absolute; top: -15px; width: 28px; height: 28px; border-radius: 99px; background: var(--mh-bg, #fff); }
    .dark .mh-coupon-cut::before, .dark .mh-coupon-cut::after { background: #0f0b0c; }
    .mh-coupon-cut::before { left: -14px; } .mh-coupon-cut::after { right: -14px; }
    .mh-step { display: flex; gap: 14px; align-items: flex-start; }
    .mh-step-n { width: 36px; height: 36px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-weight: 900; color: #fff; background: var(--wine); flex-shrink: 0; }

    /* Psychological center — coming soon: a printed "announcement card" with a postage stamp + postmark */
    .ps-card { --ink: #6d1b2b; --paper: #f4ebdd; position: relative; background: var(--paper); color: #2a1a17; border-radius: 2rem; overflow: hidden;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='160' height='160'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.85' numOctaves='3' stitchTiles='stitch'/%3E%3CfeColorMatrix values='0 0 0 0 .35 0 0 0 0 .22 0 0 0 0 .12 0 0 0 .09 0'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E"); }
    .ps-card::before { content: ''; position: absolute; inset: 14px; border: 1px solid color-mix(in srgb, var(--ink) 35%, transparent); border-radius: 1.4rem; pointer-events: none; }
    .ps-card::after { content: ''; position: absolute; inset: 19px; border: 1px solid color-mix(in srgb, var(--ink) 15%, transparent); border-radius: 1.2rem; pointer-events: none; }
    .ps-ruqaa { font-family: 'Aref Ruqaa', 'Tajawal', serif; font-weight: 700; }
    .ps-soon { font-size: clamp(4.6rem, 11vw, 8rem); line-height: 1.4; color: var(--ink); padding-top: .1em; }
    .ps-eyebrow { display: inline-flex; align-items: center; gap: 12px; font-size: 13px; font-weight: 900; letter-spacing: .02em; color: #9a7434; }
    .ps-eyebrow::before { content: ''; width: 36px; height: 1.5px; background: currentColor; }
    .ps-list { border-top: 1px solid color-mix(in srgb, var(--ink) 22%, transparent); }
    .ps-list > div + div { border-inline-start: 1px solid color-mix(in srgb, var(--ink) 14%, transparent); }
    @media (max-width: 639px) { .ps-list > div + div { border-inline-start: 0; border-top: 1px solid color-mix(in srgb, var(--ink) 14%, transparent); } }
    .ps-num { font-size: 13px; font-weight: 900; color: #b08a45; letter-spacing: .08em; }
    /* Stamp: perforated edge cut with a mask; the shadow sits on the wrapper because masks clip it */
    .ps-stamp-wrap { filter: drop-shadow(0 18px 22px rgba(60,20,20,.22)) drop-shadow(0 2px 3px rgba(60,20,20,.15)); transform: rotate(-5deg); }
    .ps-stamp { --r: 7px; background: #fffdf8; padding: calc(2.4 * var(--r));
        -webkit-mask: radial-gradient(var(--r), #0000 97%, #000) round calc(-1.5 * var(--r)) calc(-1.5 * var(--r)) / calc(3 * var(--r)) calc(3 * var(--r)), linear-gradient(#000 0 0) no-repeat 50% / calc(100% - 3 * var(--r)) calc(100% - 3 * var(--r));
                mask: radial-gradient(var(--r), #0000 97%, #000) round calc(-1.5 * var(--r)) calc(-1.5 * var(--r)) / calc(3 * var(--r)) calc(3 * var(--r)), linear-gradient(#000 0 0) no-repeat 50% / calc(100% - 3 * var(--r)) calc(100% - 3 * var(--r)); }
    .ps-stamp img { display: block; width: 100%; border-radius: 10px; }
    .ps-postmark { position: absolute; color: var(--ink); opacity: .88; mix-blend-mode: multiply; transform: rotate(14deg); pointer-events: none; }
    .ps-waves { position: absolute; color: var(--ink); opacity: .55; mix-blend-mode: multiply; pointer-events: none; }
    .ps-input { flex: 1; min-width: 0; background: transparent; border: 0; border-bottom: 1.5px solid color-mix(in srgb, var(--ink) 45%, transparent); padding: 12px 2px; font-size: 16px; font-weight: 700; color: #2a1a17; outline: none; transition: border-color .2s; }
    .ps-input::placeholder { color: #9b8b7c; }
    .ps-input:focus { border-color: var(--ink); }
    .ps-btn { flex-shrink: 0; background: var(--ink); color: #fff; font-weight: 900; font-size: 15px; padding: 12px 22px; border-radius: 999px; transition: background .2s, transform .2s; }
    .ps-btn:hover { background: #4a0f1b; transform: translateY(-1px); }
    .ps-btn:disabled { opacity: .6; }

    /* Sticky booking bar (phones) */
    .mh-bar { transform: translateY(110%); transition: transform .3s ease; }
    .mh-bar.on { transform: translateY(0); }
    @media (max-width: 1023px) {
        #global-float-wa, #back-to-top { transition: bottom .3s ease, opacity .5s, transform .5s; }
        body.mh-bar-on #global-float-wa, body.mh-bar-on #back-to-top { bottom: 92px; }
    }
</style>

@php $customAnnouncement = $site['announcement_' . $lang] ?? ''; @endphp
<div class="mh" dir="{{ $isAr ? 'rtl' : 'ltr' }}" @if($featured) style="--wine: {{ $featured['theme'] }}" @endif>

{{-- ═══════════════ ANNOUNCEMENT STRIP ═══════════════ --}}
@if($featured || $customAnnouncement)
<a href="{{ $featured && !$featured['is_full'] ? route('course.register', $featured['slug']) : route('courses') }}" class="group block text-white" style="background: linear-gradient(90deg, var(--wine-d), var(--wine));">
    <div class="container mx-auto px-4 py-2.5 flex items-center justify-center gap-3 text-xs sm:text-sm font-bold text-center">
        <span class="w-2 h-2 rounded-full animate-pulse shrink-0" style="background: var(--gold)"></span>
        <span>
            @if($customAnnouncement)
                {{ $customAnnouncement }}
            @elseif($canBook && $gift > 0)
                🎁 {{ $t('احجز الآن وخذ كود هدية بقيمة ' . $giftTxt . ' د.ك', 'Book now and get a ' . $giftTxt . ' KWD gift code') }}
            @else
                {{ $featured['title'][$lang] }} <span class="text-white/60">·</span> {{ $featured['day'][$lang] }} {{ \Carbon\Carbon::parse($featured['date'])->locale($lang)->translatedFormat('j F') }} <span class="text-white/60">·</span> {{ $featured['price'] }} {{ $t('د.ك', 'KWD') }}
            @endif
        </span>
        <span class="shrink-0 font-black px-3 py-1 rounded-full" style="background: var(--gold); color: #2a1408">{{ $t('سجّل الآن', 'Register') }}</span>
    </div>
</a>
@endif

{{-- ═══════════════ HERO ═══════════════ --}}
<section class="mh-cream relative overflow-hidden">
    <div class="absolute -top-40 {{ $isAr ? '-left-40' : '-right-40' }} w-[36rem] h-[36rem] rounded-full opacity-40 pointer-events-none" style="background: radial-gradient(circle, var(--gold-l), transparent 65%);"></div>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-14 lg:py-20 relative">
        <div class="grid lg:grid-cols-12 gap-10 lg:gap-14 items-center">

            {{-- Copy --}}
            <div class="lg:col-span-7 text-center {{ $isAr ? 'lg:text-right' : 'lg:text-left' }}">
                @if($featured)
                    <span class="mh-eyebrow mb-5">
                        <span class="w-2 h-2 rounded-full bg-[#c9a35c] animate-pulse"></span>
                        {{ $featured['badge'][$lang] }}@if($featured['seats_left'] !== null) · {{ $featured['is_full'] ? $t('اكتمل العدد', 'Fully booked') : $t('متبقي ' . $featured['seats_left'] . ' مقعد', $featured['seats_left'] . ' seats left') }}@endif
                    </span>
                    <h1 class="mh-title font-black leading-[1.15] mb-4" style="font-size: clamp(2.3rem, 5.6vw, 4.2rem);">{{ $featured['title'][$lang] }}</h1>
                    <p class="text-lg sm:text-xl font-bold text-stone-600 dark:text-stone-300 mb-6">
                        {{ $t('مع', 'with') }} <span class="font-black" style="color: var(--wine)">{{ $featured['trainer'][$lang] }}</span>
                        @if($featured['certificate'][$lang])<span class="block text-sm sm:text-base font-semibold text-stone-500 dark:text-stone-400 mt-1">{{ $featured['certificate'][$lang] }}</span>@endif
                    </p>

                    <div class="flex flex-wrap justify-center {{ $isAr ? 'lg:justify-start' : 'lg:justify-start' }} gap-2.5 mb-6">
                        <span class="mh-chip"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>{{ $featured['day'][$lang] }} {{ \Carbon\Carbon::parse($featured['date'])->locale($lang)->translatedFormat('j F') }}</span>
                        @if($featured['time'][$lang])<span class="mh-chip"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>{{ $featured['time'][$lang] }}</span>@endif
                        <span class="mh-chip"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>{{ $t('حضوري · الكويت', 'In person · Kuwait') }}</span>
                    </div>

                    <div class="flex justify-center {{ $isAr ? 'lg:justify-start' : 'lg:justify-start' }} mb-8">
                        @include('partials.countdown', ['startsAt' => $featured['starts_at']])
                    </div>

                    <div id="hero-cta" class="flex flex-col sm:flex-row items-center justify-center {{ $isAr ? 'lg:justify-start' : 'lg:justify-start' }} gap-3">
                        @if($featured['is_full'])
                            <div class="w-full max-w-md">@include('partials.notify-form', ['courseKey' => $featured['slug']])</div>
                        @else
                            <a href="{{ route('course.register', $featured['slug']) }}" class="mh-btn mh-btn-primary text-lg w-full sm:w-auto">
                                {{ $t('احجز مقعدك', 'Book your seat') }} · {{ $featured['price'] }} {{ $t('د.ك', 'KWD') }}
                                <svg class="w-5 h-5 {{ $isAr ? 'rotate-180' : '' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                            </a>
                            <a href="#course" class="mh-btn mh-btn-ghost max-sm:!hidden sm:w-auto">{{ $t('محاور الدورة', 'What you will learn') }}</a>
                        @endif
                    </div>
                    @if($canBook && $gift > 0)
                        <a href="#gift" class="mh-gift-pill mt-5 max-w-md mx-auto lg:mx-0 text-start">
                            <span class="mh-gift-ico">🎁</span>
                            <span class="min-w-0">
                                <span class="block font-black text-[15px] mh-title">{{ $t('هدية مع حجزك: كود خصم بقيمة ' . $giftTxt . ' د.ك', 'Your booking comes with a ' . $giftTxt . ' KWD gift code') }}</span>
                                <span class="block text-xs sm:text-sm font-bold text-stone-500 dark:text-stone-400 mt-0.5">{{ $t('لدورتك الجاية أو اهديه لصديقك', 'For your next course, or gift it to a friend') }} · <span class="mh-accent">{{ $t('كيف؟', 'How?') }}</span></span>
                            </span>
                        </a>
                    @endif
                    @if($featured['show_installments'] && !$featured['is_full'])
                        <p class="text-xs font-bold text-stone-500 dark:text-stone-400 mt-3">{{ $t('أو قسّطها على 4 دفعات مع deema', 'or split into 4 payments with deema') }}</p>
                    @endif
                @else
                    <span class="mh-eyebrow mb-5">{{ $t('مركز مطمئنة · الكويت', 'Motmaena Center · Kuwait') }}</span>
                    <h1 class="mh-title font-black leading-[1.15] mb-5" style="font-size: clamp(2.3rem, 5.6vw, 4.2rem);">{{ $t('حياة أهدأ، وعلاقات أقوى', 'A calmer life, stronger relationships') }}</h1>
                    <p class="text-lg sm:text-xl font-bold text-stone-600 dark:text-stone-300 mb-8">{{ $t('دورات وجلسات واستشارات اجتماعية وتربوية بإشراف أ.د. طارق الحبيب، بروفيسور واستشاري الطب النفسي.', 'Courses, sessions and social & educational consultations supervised by Prof. Dr. Tariq Al-Habib, professor & consultant psychiatrist.') }}</p>
                    <div class="flex flex-col sm:flex-row items-center justify-center {{ $isAr ? 'lg:justify-start' : 'lg:justify-start' }} gap-3">
                        <a href="{{ route('consultations') }}" class="mh-btn mh-btn-primary w-full sm:w-auto">{{ $t('احجز استشارة', 'Book a consultation') }}</a>
                        <a href="{{ route('courses') }}" class="mh-btn mh-btn-ghost w-full sm:w-auto">{{ $t('تصفّح الدورات', 'Browse courses') }}</a>
                    </div>
                @endif
            </div>

            {{-- Portrait --}}
            <div class="lg:col-span-5">
                <div class="relative max-w-[260px] sm:max-w-[340px] lg:max-w-[380px] mx-auto">
                    <div class="mh-arch">
                        <div class="mh-arch-glow"></div>
                        <img src="{{ asset($featured['image'] ?? \App\Models\CourseOffer::DEFAULT_IMAGE) }}" alt="{{ $t('أ.د. طارق الحبيب', 'Prof. Dr. Tariq Al-Habib') }}">
                    </div>
                    {{-- Experience badge sits on the empty side of the arch, clear of the face --}}
                    <div class="absolute top-[18%] {{ $isAr ? '-left-4 sm:-left-10' : '-right-4 sm:-right-10' }} z-10 bg-white dark:bg-[#1a1415] rounded-2xl shadow-xl px-3.5 py-2.5 border border-[#efe5e0] dark:border-white/10 text-center">
                        <div class="mh-num text-xl sm:text-2xl leading-none">+30</div>
                        <div class="text-[11px] sm:text-xs font-bold text-stone-500 dark:text-stone-400 mt-0.5">{{ $t('سنة خبرة', 'years') }}</div>
                    </div>
                    {{-- Name sits under the arch so it never covers the photo --}}
                    <div class="mt-5 text-center">
                        <p class="font-black text-base sm:text-lg mh-title">{{ $t('أ.د. طارق الحبيب', 'Prof. Dr. Tariq Al-Habib') }}</p>
                        <p class="flex items-center justify-center gap-2 text-xs sm:text-sm font-bold text-stone-500 dark:text-stone-400 mt-1">
                            <span class="h-px w-6" style="background: var(--gold)"></span>{{ config('doctor.title.' . $lang) }}<span class="h-px w-6" style="background: var(--gold)"></span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Trust bar --}}
    <div class="border-t border-[#ecdcd6] dark:border-white/10 bg-white/60 dark:bg-white/[0.02]">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 grid grid-cols-2 lg:grid-cols-4 gap-5 text-center">
            @foreach([
                ['+30', $t('سنة خبرة للدكتور', 'years of experience')],
                ['+12', $t('سنة لمركز مطمئنة', 'years of Motmaena')],
                ['<svg class="w-7 h-7 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>', $t('شهادات معتمدة', 'Accredited certificates')],
                ['<svg class="w-7 h-7 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>', $t('دفع آمن: كي نت · فيزا · Apple Pay', 'Secure: KNET · Visa · Apple Pay')],
            ] as [$num, $label])
                <div>
                    <div class="mh-num text-2xl sm:text-3xl leading-none mb-1 h-8 flex items-center justify-center">{!! $num !!}</div>
                    <div class="text-xs sm:text-sm font-bold text-stone-600 dark:text-stone-300">{{ $label }}</div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════ GIFT OFFER ═══════════════ --}}
@if($canBook && $gift > 0)
<section id="gift" class="py-14 sm:py-20 bg-white dark:bg-[#0f0b0c] scroll-mt-20" style="--mh-bg: #fff">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 grid lg:grid-cols-12 gap-10 lg:gap-14 items-center">

        {{-- Coupon --}}
        <div class="lg:col-span-5">
            <div class="mh-coupon max-w-sm mx-auto text-center">
                <div class="px-7 pt-7 pb-6 sm:pt-8 sm:pb-7">
                    <p class="font-black text-sm" style="color: var(--gold-l)">🎁 {{ $t('هدية من مركز مطمئنة', 'A gift from Motmaena Center') }}</p>
                    <div class="flex items-baseline justify-center gap-2 my-2" dir="ltr">
                        <span class="font-black leading-none text-[4.5rem] sm:text-[5.5rem]" style="color: var(--gold)">{{ $giftTxt }}</span>
                        <span class="text-2xl font-black text-white/90">{{ $t('د.ك', 'KWD') }}</span>
                    </div>
                    <p class="font-bold text-white/85">{{ $t('خصم على أي دورة جاية', 'Off any upcoming course') }}</p>
                </div>
                <div class="mh-coupon-cut"></div>
                <div class="px-7 pt-6 pb-8">
                    <div class="inline-block bg-white rounded-xl px-5 py-2 font-black tracking-[.3em] text-lg" style="color: var(--wine)" dir="ltr">GIFT••••</div>
                    <p class="text-xs font-bold text-white/75 mt-3">{{ $t('لك أو لصديقك · يُستخدم مرة وحدة', 'For you or a friend · single use') }}</p>
                </div>
            </div>
        </div>

        {{-- Copy + steps --}}
        <div class="lg:col-span-7 text-center {{ $isAr ? 'lg:text-right' : 'lg:text-left' }}">
            <p class="mh-gold font-black text-sm mb-2">{{ $t('عرض الحجز', 'Booking offer') }}</p>
            <h2 class="mh-section-title mh-title mb-3">{{ $t('احجز اليوم… وخذ هدية بقيمة ' . $giftTxt . ' د.ك', 'Book today… and get a ' . $giftTxt . ' KWD gift') }}</h2>
            <p class="font-semibold text-stone-600 dark:text-stone-300 leading-relaxed mb-7 max-w-xl mx-auto lg:mx-0">{{ $t('كل من يحجز ويدفع بدون كود خصم، ياخذ فوراً كود هدية يقدر يستخدمه بنفسه أو يهديه لأحد يحبه.', 'Everyone who books and pays without a discount code instantly gets a gift code to use or pass on.') }}</p>

            <ol class="space-y-5 max-w-xl mx-auto lg:mx-0 text-start mb-7">
                @foreach([
                    [$t('احجز وادفع', 'Book & pay'), $t('سجّل بالدورة وادفع أونلاين بدون كود خصم.', 'Register and pay online without a discount code.')],
                    [$t('استلم كود الهدية', 'Get your gift code'), $t('يظهر لك كود بقيمة ' . $giftTxt . ' د.ك فور إتمام الدفع.', 'A ' . $giftTxt . ' KWD code appears as soon as you pay.')],
                    [$t('استخدمه أو اهديه', 'Use it or gift it'), $t('على دورتك الجاية بمطمئنة، أو ارسله لصديقك بضغطة واتساب.', 'On your next Motmaena course, or send it to a friend on WhatsApp.')],
                ] as $i => [$title, $desc])
                    <li class="mh-step">
                        <span class="mh-step-n">{{ $i + 1 }}</span>
                        <span><span class="block font-black mh-title">{{ $title }}</span><span class="block text-sm font-semibold text-stone-600 dark:text-stone-300 mt-0.5">{{ $desc }}</span></span>
                    </li>
                @endforeach
            </ol>

            @if($friendPrice > 0)
            <div class="rounded-2xl bg-[#faf6f1] dark:bg-white/5 border border-[#efe5e0] dark:border-white/10 px-4 py-3 text-sm font-bold text-stone-700 dark:text-stone-200 max-w-xl mx-auto lg:mx-0 mb-7 text-start">
                💡 {{ $t('مثال: صديقك يحضر «' . $featured['title']['ar'] . '» بـ', 'Example: your friend joins "' . $featured['title']['en'] . '" for') }}
                <span class="font-black mh-accent">{{ $fmt($friendPrice) }} {{ $t('د.ك', 'KWD') }}</span>
                {{ $t('بدل', 'instead of') }} <span class="line-through text-stone-400">{{ $featured['price'] }} {{ $t('د.ك', 'KWD') }}</span>
            </div>
            @endif

            <a href="{{ route('course.register', $featured['slug']) }}" class="mh-btn mh-btn-primary w-full sm:w-auto">{{ $t('احجز مقعدك وخذ هديتك', 'Book your seat & get your gift') }}</a>
            <p class="text-xs font-semibold text-stone-400 mt-3">{{ $t('* الهدية للحجوزات المدفوعة بدون كود خصم، والكود يُستخدم مرة وحدة.', '* For paid bookings without a discount code. Each gift code works once.') }}</p>
        </div>
    </div>
</section>
@endif

{{-- ═══════════════ FEATURED COURSE DETAILS ═══════════════ --}}
@if($featured && $featured['topics'][$lang])
<section id="course" class="py-16 sm:py-20 mh-cream scroll-mt-20">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-12 gap-10 items-start">
            <div class="lg:col-span-4 text-center {{ $isAr ? 'lg:text-right' : 'lg:text-left' }}">
                <p class="mh-gold font-black text-sm mb-2">{{ $t('ماذا ستتعلم؟', 'What you will learn') }}</p>
                <h2 class="mh-section-title mh-title mb-4">{{ $featured['title'][$lang] }}</h2>
                <p class="font-semibold text-stone-600 dark:text-stone-300 mb-6 leading-relaxed">{{ $t('دورة حضورية عملية بإشراف أ.د. طارق الحبيب، بتطلع منها بأدوات تقدر تطبّقها من أول يوم.', 'A practical in-person course with Prof. Dr. Tariq Al-Habib — leave with tools you can use from day one.') }}</p>
                @unless($featured['is_full'])
                <a href="{{ route('course.register', $featured['slug']) }}" class="mh-btn mh-btn-primary">{{ $t('احجز مقعدك', 'Book your seat') }}</a>
                @endunless
            </div>
            <div class="lg:col-span-8 grid sm:grid-cols-2 gap-3 sm:gap-4">
                @foreach($featured['topics'][$lang] as $i => $topic)
                    <div class="mh-card p-4 sm:p-5 flex items-center sm:items-start gap-4">
                        <span class="mh-num text-xl sm:text-2xl leading-none w-8 sm:w-9 shrink-0">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                        <span class="font-bold text-stone-800 dark:text-stone-100 leading-snug pt-0.5">{{ $topic }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

{{-- ═══════════════ OTHER UPCOMING COURSES ═══════════════ --}}
@if($others->isNotEmpty())
<section class="py-16 sm:py-20 bg-white dark:bg-[#0f0b0c]">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <p class="mh-gold font-black text-sm mb-2">{{ $t('التسجيل مفتوح', 'Registration open') }}</p>
            <h2 class="mh-section-title mh-title">{{ $t('دورات قادمة', 'Upcoming courses') }}</h2>
        </div>
        <div class="flex flex-wrap justify-center gap-5">
            @foreach($others as $o)
            <a href="{{ route('course.register', $o['slug']) }}" class="mh-card w-full sm:w-[calc(50%-10px)] lg:w-[calc(33.333%-14px)] p-6 flex flex-col">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-black px-3 py-1 rounded-full" style="background: #f5ebe6; color: var(--wine)">{{ $o['day'][$lang] }} {{ \Carbon\Carbon::parse($o['date'])->locale($lang)->translatedFormat('j F') }}</span>
                    @if($o['seats_left'] !== null)<span class="text-xs font-black {{ $o['is_full'] ? 'text-red-600' : 'text-amber-600' }}">{{ $o['is_full'] ? $t('اكتمل', 'Full') : $t('متبقي ' . $o['seats_left'], $o['seats_left'] . ' left') }}</span>@endif
                </div>
                <h3 class="text-xl font-black mh-title mb-1">{{ $o['title'][$lang] }}</h3>
                <p class="text-sm font-bold text-stone-500 dark:text-stone-400 {{ $gift > 0 && !$o['is_full'] ? 'mb-3' : 'mb-5' }}">{{ $o['trainer'][$lang] }}@if($o['time'][$lang]) · {{ $o['time'][$lang] }}@endif</p>
                @if($gift > 0 && !$o['is_full'])
                    <p class="text-xs font-black mb-5" style="color: #9a6b1f">🎁 {{ $t('+ كود هدية ' . $giftTxt . ' د.ك مع الحجز', '+ ' . $giftTxt . ' KWD gift code with booking') }}</p>
                @endif
                <div class="mt-auto flex items-center justify-between pt-4 border-t border-[#efe5e0] dark:border-white/10">
                    <span class="font-black text-xl" style="color: var(--wine)">{{ $o['price'] }} <small class="text-xs">{{ $t('د.ك', 'KWD') }}</small></span>
                    <span class="font-black text-sm" style="color: var(--wine)">{{ $t('التفاصيل والحجز ←', 'Details & booking →') }}</span>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ═══════════════ PSYCHOLOGICAL CENTER — COMING SOON (Admin → Content → switch) ═══════════════ --}}
@if(($site['psych_soon'] ?? '1') === '1')
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Aref+Ruqaa:wght@700&display=swap">
<section id="psych-center" class="py-16 sm:py-20 bg-white dark:bg-[#0f0b0c] scroll-mt-20">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="ps-card shadow-[0_30px_70px_-40px_rgba(74,15,27,.45)]">
            <div class="relative grid lg:grid-cols-12 gap-6 lg:gap-10 items-center px-6 py-12 sm:p-12 lg:p-16">

                {{-- Stamp + postmark --}}
                <div class="lg:col-span-5 flex justify-center">
                    <div class="relative w-[min(58vw,230px)] sm:w-[270px] lg:w-[300px] mb-12 lg:mb-0">
                        <div class="ps-stamp-wrap">
                            <div class="ps-stamp">
                                <img src="{{ asset('photos/motmaena-app-icon.webp') }}" alt="{{ $t('مطمئنة', 'Motmaena') }}" width="432" height="432" loading="lazy">
                            </div>
                        </div>

                        {{-- Ink postmark --}}
                        <svg class="ps-postmark w-[56%] -bottom-[22%] -left-[22%]" viewBox="0 0 200 200" aria-hidden="true">
                            <defs>
                                <path id="ps-ring" d="M100,100 m-72,0 a72,72 0 1,1 144,0 a72,72 0 1,1 -144,0"/>
                                <filter id="ps-ink"><feTurbulence type="fractalNoise" baseFrequency="1.1" numOctaves="2" seed="4"/><feDisplacementMap in="SourceGraphic" scale="3"/></filter>
                            </defs>
                            <g filter="url(#ps-ink)" fill="none" stroke="currentColor">
                                <circle cx="100" cy="100" r="94" stroke-width="3.5"/>
                                <circle cx="100" cy="100" r="88" stroke-width="1.2"/>
                                <circle cx="100" cy="100" r="54" stroke-width="1.5"/>
                                <text fill="currentColor" stroke="none" font-size="14" font-weight="800" font-family="Tajawal, sans-serif" direction="ltr" style="direction: ltr; unicode-bidi: isolate"><textPath href="#ps-ring" textLength="440" lengthAdjust="spacing">COMING SOON ✦ MOTMAENA ✦ KUWAIT ✦</textPath></text>
                                <text x="100" y="113" text-anchor="middle" fill="currentColor" stroke="none" font-size="38" class="ps-ruqaa" direction="rtl">قريباً</text>
                            </g>
                        </svg>
                        {{-- Cancellation waves --}}
                        <svg class="ps-waves w-[66%] -bottom-[12%] left-[36%]" viewBox="0 0 220 60" aria-hidden="true">
                            <g fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" filter="url(#ps-ink)">
                                @foreach([8, 22, 36, 50] as $y)
                                    <path d="M0 {{ $y }} q13.75 -7 27.5 0 t27.5 0 t27.5 0 t27.5 0 t27.5 0 t27.5 0 t27.5 0 t27.5 0"/>
                                @endforeach
                            </g>
                        </svg>
                    </div>
                </div>

                {{-- Announcement --}}
                <div class="lg:col-span-7 text-center {{ $isAr ? 'lg:text-right' : 'lg:text-left' }}">
                    <span class="ps-eyebrow">{{ $t('خطوة جديدة من مطمئنة', 'Something new from Motmaena') }}</span>

                    <div class="ps-ruqaa ps-soon mb-4">{{ $t('قريباً', 'Soon') }}</div>

                    <h2 class="font-black leading-snug mb-2 text-[#2a1a17]" style="font-size: clamp(1.4rem, 2.8vw, 2.2rem); text-wrap: balance;">{{ $t('مجمع مطمئنة للاستشارات النفسية', 'Motmaena Psychological Counselling Center') }}</h2>
                    <p class="font-bold text-[#6b5446] mb-5">{{ $t('بإشراف', 'Supervised by') }} <span style="color: var(--ink)">{{ config('doctor.name.' . $lang) }}</span></p>

                    <p class="text-[#5a463b] font-semibold leading-loose mb-8 max-w-xl mx-auto {{ $isAr ? 'lg:ml-auto lg:mr-0' : 'lg:mr-auto lg:ml-0' }}">
                        {{ $t('مساحة هادئة وآمنة لصحتك النفسية: استشارات نفسية متخصصة للأفراد والأسر، بسرية تامة. الافتتاح قريب جداً.', 'A calm, safe place for your mental health: specialised psychological counselling for individuals and families, in full confidence. Opening very soon.') }}
                    </p>

                    <div class="ps-list grid grid-cols-1 sm:grid-cols-3 mb-9 {{ $isAr ? 'text-right' : 'text-left' }}">
                        @foreach([[$t('استشارات نفسية', 'Counselling'), $t('متخصصة وموثوقة', 'Specialised & trusted')], [$t('سرية تامة', 'Fully confidential'), $t('خصوصيتك أولاً', 'Your privacy first')], [$t('للأفراد والأسر', 'Individuals & families'), $t('لكل أفراد العائلة', 'For the whole family')]] as $i => [$title, $sub])
                            <div class="py-4 sm:px-4 {{ $isAr ? 'sm:first:pr-0' : 'sm:first:pl-0' }}">
                                <span class="ps-num" dir="ltr">0{{ $i + 1 }}</span>
                                <p class="font-black text-[#2a1a17] mt-1">{{ $title }}</p>
                                <p class="text-xs font-bold text-[#8a7462]">{{ $sub }}</p>
                            </div>
                        @endforeach
                    </div>

                    <div class="max-w-xl mx-auto {{ $isAr ? 'lg:ml-auto lg:mr-0 text-right' : 'lg:mr-auto lg:ml-0 text-left' }}">
                        <p class="font-black text-[#2a1a17] mb-1">{{ $t('كن أول من يعرف بالافتتاح', 'Be the first to know when we open') }}</p>
                        <p class="text-sm font-semibold text-[#8a7462] mb-2">{{ $t('سجّل رقم الواتساب ونبعتلك رسالة يوم الافتتاح.', 'Leave your WhatsApp number and we will message you on opening day.') }}</p>
                        @include('partials.notify-form', ['courseKey' => \App\Models\Lead::PSYCH_CENTER, 'paper' => true])
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

{{-- ═══════════════ SERVICES ═══════════════ --}}
<section class="py-16 sm:py-20 mh-cream">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <p class="mh-gold font-black text-sm mb-2">{{ $t('خدماتنا', 'Our services') }}</p>
            <h2 class="mh-section-title mh-title">{{ $t('كيف نقدر نساعدك؟', 'How can we help?') }}</h2>
        </div>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-5">
            @foreach([
                [route('consultations'), '💬', $t('الاستشارات', 'Consultations'), $t('جلسة خاصة وسرية مع متخصص، أو جلسة هاتفية مع الدكتور طارق.', 'A private session with a specialist, or a phone session with Dr. Tariq.')],
                [route('sessions'), '🧒', $t('جلسات الأطفال', 'Child sessions'), $t('برامج لتنمية مهارات طفلك وسلوكه بإشراف متخصصين.', 'Programmes to develop your child\'s skills and behaviour.')],
                [route('packages'), '📦', $t('الباقات', 'Packages'), $t('باقات متكاملة للتواصل، صعوبات التعلم، والثقة بالنفس.', 'Complete packages for communication, learning difficulties and confidence.')],
                [route('courses'), '🎓', $t('الدورات المسجّلة', 'Recorded courses'), $t('أكثر من 50 دورة تقدر تتابعها بأي وقت.', '50+ courses you can watch anytime.')],
            ] as [$href, $icon, $title, $desc])
            <a href="{{ $href }}" class="mh-card p-4 sm:p-6 group">
                <span class="w-11 h-11 sm:w-12 sm:h-12 rounded-2xl flex items-center justify-center text-2xl mb-3 sm:mb-4" style="background: #f5ebe6">{{ $icon }}</span>
                <h3 class="text-base sm:text-lg font-black mh-title mb-2">{{ $title }}</h3>
                <p class="hidden sm:block text-sm font-semibold text-stone-600 dark:text-stone-300 leading-relaxed mb-4">{{ $desc }}</p>
                <span class="text-sm font-black" style="color: var(--wine)">{{ $t('اعرف أكثر ←', 'Learn more →') }}</span>
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════ ABOUT THE DOCTOR ═══════════════ --}}
<section class="mh-wine text-white relative overflow-hidden">
    <div class="absolute inset-0 opacity-[.07] pointer-events-none" style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 22px 22px;"></div>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20 relative grid lg:grid-cols-12 gap-10 items-center">
        <div class="lg:col-span-4 flex justify-center">
            <div class="relative w-60 sm:w-72">
                <div class="absolute inset-0 rounded-[2rem] border-2 {{ $isAr ? '-translate-x-3' : 'translate-x-3' }} translate-y-3" style="border-color: var(--gold)"></div>
                <img src="{{ asset('photos/dr-tariq-smile.webp') }}" alt="{{ $t('أ.د. طارق الحبيب', 'Prof. Dr. Tariq Al-Habib') }}" loading="lazy" width="900" height="1486" class="relative w-full aspect-[4/5] rounded-[2rem] object-cover object-top shadow-2xl">
            </div>
        </div>
        <div class="lg:col-span-8 text-center {{ $isAr ? 'lg:text-right' : 'lg:text-left' }}">
            <p class="font-black text-sm mb-2" style="color: var(--gold-l)">{{ config('doctor.title.' . $lang) }}</p>
            <h2 class="mh-section-title mb-4">{{ $t('أ.د. طارق الحبيب', 'Prof. Dr. Tariq Al-Habib') }}</h2>
            <p class="text-white/85 font-semibold leading-loose mb-6 max-w-2xl {{ $isAr ? 'lg:ml-auto' : '' }}">{{ config('doctor.bio.' . $lang) }}</p>
            <div class="flex flex-wrap justify-center {{ $isAr ? 'lg:justify-start' : 'lg:justify-start' }} gap-8">
                @foreach([['+30', $t('سنة خبرة', 'years')], ['+50', $t('دورة', 'courses')], ['+12', $t('سنة لمطمئنة', 'years of Motmaena')]] as [$n, $l])
                    <div><div class="text-3xl font-black" style="color: var(--gold)">{{ $n }}</div><div class="text-sm font-bold text-white/75">{{ $l }}</div></div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════ THE CENTER ═══════════════ --}}
<section class="py-16 sm:py-20 bg-white dark:bg-[#0f0b0c]">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 grid lg:grid-cols-12 gap-10 items-center">
        <div class="lg:col-span-7 relative">
            <img src="{{ asset('photos/center-reception.webp') }}" alt="{{ $t('استقبال مركز مطمئنة', 'Motmaena Center reception') }}" loading="lazy" width="1800" height="1200" class="w-full aspect-[3/2] object-cover rounded-[2rem] shadow-2xl">
            <div class="absolute -bottom-5 {{ $isAr ? 'left-4 sm:left-8' : 'right-4 sm:right-8' }} bg-white dark:bg-[#1a1415] rounded-2xl shadow-xl px-4 py-3 border border-[#efe5e0] dark:border-white/10 text-center">
                <div class="mh-num text-2xl leading-none">+12</div>
                <div class="text-xs font-bold text-stone-500 dark:text-stone-400">{{ $t('سنة في خدمتكم', 'years serving you') }}</div>
            </div>
        </div>
        <div class="lg:col-span-5 text-center {{ $isAr ? 'lg:text-right' : 'lg:text-left' }} pt-4 lg:pt-0">
            <p class="mh-gold font-black text-sm mb-2">{{ $t('زورونا', 'Visit us') }}</p>
            <h2 class="mh-section-title mh-title mb-4">{{ $t('مكان هادئ يطمّنك من أول خطوة', 'A calm place from the very first step') }}</h2>
            <p class="font-semibold text-stone-600 dark:text-stone-300 leading-loose mb-6">{{ $t('استقبال دافئ وأجواء مريحة بإطلالة على البحر، عشان تحس بالراحة والخصوصية من لحظة وصولك.', 'A warm welcome and a relaxed setting overlooking the sea, so you feel at ease and private from the moment you arrive.') }}</p>
            <div class="flex flex-wrap justify-center {{ $isAr ? 'lg:justify-start' : 'lg:justify-start' }} gap-2.5 mb-7">
                <span class="mh-chip"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>{{ $t('الكويت · برج أحمد · بجوار المستشفى الأميري', 'Kuwait · Ahmad Tower · next to Amiri Hospital') }}</span>
            </div>
            <div class="flex flex-col sm:flex-row items-center justify-center {{ $isAr ? 'lg:justify-start' : 'lg:justify-start' }} gap-3">
                <a href="{{ route('consultations') }}" class="mh-btn mh-btn-primary w-full sm:w-auto">{{ $t('احجز استشارة', 'Book a consultation') }}</a>
                <a href="{{ $waLink($t('مرحباً مركز مطمئنة، ممكن موقع المركز؟', 'Hello Motmaena Center, could you send me your location?')) }}" target="_blank" class="mh-btn mh-btn-ghost w-full sm:w-auto">{{ $t('اطلب الموقع عالواتساب', 'Get directions on WhatsApp') }}</a>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════ TESTIMONIALS ═══════════════ --}}
@if($testimonials->isNotEmpty())
<section class="py-16 sm:py-20 mh-cream">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <p class="mh-gold font-black text-sm mb-2">{{ $t('آراء المتدربين', 'Testimonials') }}</p>
            <h2 class="mh-section-title mh-title">{{ $t('تجارب حقيقية', 'Real experiences') }}</h2>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($testimonials as $tm)
            <figure class="mh-card p-6">
                <div class="mb-3" style="color: var(--gold)">{{ str_repeat('★', $tm->rating) }}</div>
                <blockquote class="font-semibold text-stone-700 dark:text-stone-200 leading-relaxed mb-5">“{{ $tm->quote }}”</blockquote>
                <figcaption class="flex items-center gap-3">
                    <span class="w-10 h-10 rounded-full flex items-center justify-center font-black text-white" style="background: var(--wine)">{{ mb_substr($tm->name, 0, 1) }}</span>
                    <span><span class="block font-black mh-title text-sm">{{ $tm->name }}</span>@if($tm->subtitle)<span class="block text-xs font-bold text-stone-500">{{ $tm->subtitle }}</span>@endif</span>
                </figcaption>
            </figure>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ═══════════════ FAQ ═══════════════ --}}
@if($faqs->isNotEmpty())
<section class="py-16 sm:py-20 bg-white dark:bg-[#0f0b0c]">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-3xl">
        <div class="text-center mb-10">
            <p class="mh-gold font-black text-sm mb-2">{{ $t('أسئلة شائعة', 'FAQ') }}</p>
            <h2 class="mh-section-title mh-title">{{ $t('عندك سؤال؟', 'Questions?') }}</h2>
        </div>
        <div class="space-y-3">
            @foreach($faqs as $faq)
            <details class="mh-card group p-0 hover:translate-y-0">
                <summary class="cursor-pointer list-none flex items-center justify-between gap-4 p-5 font-black mh-title">
                    {{ $faq->question($lang) }}
                    <span class="w-8 h-8 rounded-full flex items-center justify-center shrink-0 transition group-open:rotate-45" style="background: #f5ebe6; color: var(--wine)">+</span>
                </summary>
                <p class="px-5 pb-5 -mt-1 font-semibold text-stone-600 dark:text-stone-300 leading-relaxed whitespace-pre-line">{{ $faq->answer($lang) }}</p>
            </details>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ═══════════════ FINAL CTA ═══════════════ --}}
<section id="final-cta" class="mh-wine text-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-14 sm:py-16 grid lg:grid-cols-2 gap-8 items-center">
        <div class="text-center {{ $isAr ? 'lg:text-right' : 'lg:text-left' }}">
            <h2 class="text-2xl sm:text-3xl font-black mb-2">{{ $canBook ? $t('جاهز تحجز مقعدك؟', 'Ready to book your seat?') : $t('لا تفوّتك الدورة الجاية', "Don't miss the next course") }}</h2>
            @if($canBook && $gift > 0)
                <p class="font-black mb-1" style="color: var(--gold-l)">🎁 {{ $t('ومع حجزك كود هدية بقيمة ' . $giftTxt . ' د.ك لك أو لصديقك.', 'Plus a ' . $giftTxt . ' KWD gift code for you or a friend.') }}</p>
            @endif
            <p class="text-white/80 font-semibold">{{ $t('أو اترك رقمك ونبلّغك أول ما ينفتح التسجيل بدورة جديدة.', 'Or leave your number and we will tell you when a new course opens.') }}</p>
        </div>
        <div class="flex flex-col gap-3">
            @if($featured && !$featured['is_full'])
                <a href="{{ route('course.register', $featured['slug']) }}" class="mh-btn bg-white text-[#6d1b2b] hover:-translate-y-0.5 w-full">{{ $t('احجز', 'Book') }} {{ $featured['title'][$lang] }} · {{ $featured['price'] }} {{ $t('د.ك', 'KWD') }}</a>
            @endif
            @include('partials.notify-form', ['dark' => true])
            <a href="{{ $waLink($t('مرحباً مركز مطمئنة، عندي استفسار', 'Hello Motmaena Center, I have a question')) }}" target="_blank" class="text-center text-sm font-black text-white/85 hover:text-white">{{ $t('أو كلّمنا عالواتساب', 'or chat with us on WhatsApp') }}</a>
        </div>
    </div>
</section>

{{-- ═══════════════ STICKY BOOKING BAR (phones) ═══════════════ --}}
@if($canBook)
<div id="mh-bar" class="mh-bar lg:hidden fixed inset-x-0 bottom-0 z-[70] bg-white/95 dark:bg-[#1a1415]/95 backdrop-blur border-t border-[#efe5e0] dark:border-white/10 shadow-[0_-12px_30px_-18px_rgba(0,0,0,.35)]" style="padding-bottom: max(12px, env(safe-area-inset-bottom))">
    <div class="container mx-auto px-4 pt-3 flex items-center gap-3">
        <div class="min-w-0 flex-1">
            <p class="font-black text-sm mh-title truncate">{{ $featured['title'][$lang] }}</p>
            <p class="text-xs font-bold truncate">
                <span class="mh-accent">{{ $featured['price'] }} {{ $t('د.ك', 'KWD') }}</span>
                @if($gift > 0)<span class="text-stone-500 dark:text-stone-400"> · 🎁 {{ $t('+ هدية ' . $giftTxt . ' د.ك', '+ ' . $giftTxt . ' KWD gift') }}</span>@endif
            </p>
        </div>
        <a href="{{ route('course.register', $featured['slug']) }}" class="mh-btn mh-btn-primary !py-3 !px-5 text-sm">{{ $t('احجز مقعدك', 'Book now') }}</a>
    </div>
</div>
<script>
    // Show the bar once the hero button is scrolled away; hide it again at the closing call-to-action
    (function () {
        var bar = document.getElementById('mh-bar'), hero = document.getElementById('hero-cta'), end = document.getElementById('final-cta');
        if (!bar || !hero) return;
        var ticking = false;
        function update() {
            ticking = false;
            var on = hero.getBoundingClientRect().bottom < 0 && (!end || end.getBoundingClientRect().top > window.innerHeight);
            bar.classList.toggle('on', on);
            document.body.classList.toggle('mh-bar-on', on);
        }
        window.addEventListener('scroll', function () { if (!ticking) { ticking = true; requestAnimationFrame(update); } }, { passive: true });
        update();
    })();
</script>
@endif

</div>
@endsection
