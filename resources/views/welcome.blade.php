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
@endphp

@section('title', __('Welcome') . ' - ' . __('Motmaena Center'))
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
    .mh-arch img { position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); width: 104%; max-width: none; }
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

                    <div class="flex flex-col sm:flex-row items-center justify-center {{ $isAr ? 'lg:justify-start' : 'lg:justify-start' }} gap-3">
                        @if($featured['is_full'])
                            <div class="w-full max-w-md">@include('partials.notify-form', ['courseKey' => $featured['slug']])</div>
                        @else
                            <a href="{{ route('course.register', $featured['slug']) }}" class="mh-btn mh-btn-primary text-lg w-full sm:w-auto">
                                {{ $t('احجز مقعدك', 'Book your seat') }} · {{ $featured['price'] }} {{ $t('د.ك', 'KWD') }}
                                <svg class="w-5 h-5 {{ $isAr ? 'rotate-180' : '' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                            </a>
                            <a href="#course" class="mh-btn mh-btn-ghost w-full sm:w-auto">{{ $t('محاور الدورة', 'What you will learn') }}</a>
                        @endif
                    </div>
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
                        <img src="{{ asset($featured['image'] ?? \App\Models\CourseOffer::DEFAULT_IMAGE) }}" alt="{{ $t('أ.د. طارق الحبيب', 'Prof. Dr. Tariq Al-Habib') }}">
                    </div>
                    <div class="absolute -bottom-5 {{ $isAr ? '-right-3 sm:-right-8' : '-left-3 sm:-left-8' }} bg-white dark:bg-[#1a1415] rounded-2xl shadow-xl px-4 py-3 border border-[#efe5e0] dark:border-white/10">
                        <p class="font-black text-sm mh-title">{{ $t('أ.د. طارق الحبيب', 'Prof. Dr. Tariq Al-Habib') }}</p>
                        <p class="text-xs font-bold text-stone-500 dark:text-stone-400">{{ config('doctor.title.' . $lang) }}</p>
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

{{-- ═══════════════ FEATURED COURSE DETAILS ═══════════════ --}}
@if($featured && $featured['topics'][$lang])
<section id="course" class="py-16 sm:py-20 bg-white dark:bg-[#0f0b0c] scroll-mt-20">
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
            <div class="lg:col-span-8 grid sm:grid-cols-2 gap-4">
                @foreach($featured['topics'][$lang] as $i => $topic)
                    <div class="mh-card p-5 flex items-start gap-4">
                        <span class="mh-num text-2xl leading-none w-9 shrink-0">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
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
<section class="py-16 sm:py-20 mh-cream">
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
                <p class="text-sm font-bold text-stone-500 dark:text-stone-400 mb-5">{{ $o['trainer'][$lang] }}@if($o['time'][$lang]) · {{ $o['time'][$lang] }}@endif</p>
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

{{-- ═══════════════ SERVICES ═══════════════ --}}
<section class="py-16 sm:py-20 bg-white dark:bg-[#0f0b0c]">
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
<section class="mh-wine text-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-14 sm:py-16 grid lg:grid-cols-2 gap-8 items-center">
        <div class="text-center {{ $isAr ? 'lg:text-right' : 'lg:text-left' }}">
            <h2 class="text-2xl sm:text-3xl font-black mb-2">{{ $featured && !$featured['is_full'] ? $t('جاهز تحجز مقعدك؟', 'Ready to book your seat?') : $t('لا تفوّتك الدورة الجاية', "Don't miss the next course") }}</h2>
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

</div>
@endsection
