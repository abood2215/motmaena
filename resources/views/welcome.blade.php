@extends('layouts.app')

{{-- Homepage, in the quiet editorial look (partials/lx-styles): ivory and white, wine for actions, a thin gold line, real photos.
     Leads with the open course offer (Admin → Courses → offers) or the featured course. --}}
@php
    $lang = app()->getLocale() == 'ar' ? 'ar' : 'en';
    $isAr = $lang === 'ar';
    $t = fn ($ar, $en) => $isAr ? $ar : $en;
    $kwd = $t('د.ك', 'KWD');
    $fmt = fn ($v) => \App\Models\CourseBundle::fmt((float) $v);
    $when = fn (array $c) => \Carbon\Carbon::parse($c['date'])->locale($lang);

    $featuredModel = \App\Models\CourseOffer::featured();
    $featured = $featuredModel?->toOfferArray();
    $courses = \App\Models\CourseOffer::upcoming()->map->toOfferArray()->values();     // every open course, by date
    $bundle = \App\Models\CourseBundle::current();                                      // e.g. both November courses for 45
    $bundleCourses = $bundle ? $bundle->courses()->map->toOfferArray()->values() : collect();
    $heroCourses = $bundle ? $bundleCourses : ($featured ? collect([$featured]) : collect());

    $faqs = \App\Models\Faq::where('is_active', true)->orderBy('sort')->get();
    $testimonials = \App\Models\Testimonial::where('is_active', true)->orderBy('sort')->get();
    $waLink = fn ($text) => 'https://wa.me/' . $site['whatsapp'] . '?text=' . rawurlencode($text);

    // Gift code for paying a full price without a code (Admin → Content → gift amount; 0 hides every mention)
    $gift = \App\Models\CourseRegistration::giftAmount();
    $giftTxt = \App\Models\CourseRegistration::giftAmountText();
    $canBook = ($featured && !$featured['is_full']) || $bundle;
    $customAnnouncement = $site['announcement_' . $lang] ?? '';
@endphp

{{-- Title and description describe the center itself (stable for search), not the offer of the month --}}
@section('title', $t('استشارات أسرية وتربوية ودورات في الكويت | مركز مطمئنة', 'Family & Parenting Consultations and Courses in Kuwait | Motmaena Center'))
@section('meta_description', $t(
    'مركز مطمئنة في الكويت بإشراف أ.د. طارق الحبيب: استشارات أسرية وزوجية وتربوية، وجلسات وباقات للأطفال، ودورات حضورية ومسجّلة.',
    'Motmaena Center in Kuwait, supervised by Prof. Dr. Tariq Al-Habib: family, marital and parenting consultations, sessions and packages for children, and in-person and recorded courses.'
))
@if($featured && $featured['share_image'])
    @section('og_image', asset($featured['share_image']))
@endif

@section('content')
@include('partials.lx-styles')
<style>
    /* Psychological center — coming soon: a printed "announcement card" with a postage stamp + postmark */
    .ps-card { --ink: #6d1b2b; --paper: #f4ebdd; position: relative; background: var(--paper); color: #2a1a17; border-radius: 2rem; overflow: hidden;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='160' height='160'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.85' numOctaves='3' stitchTiles='stitch'/%3E%3CfeColorMatrix values='0 0 0 0 .35 0 0 0 0 .22 0 0 0 0 .12 0 0 0 .09 0'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E"); }
    .ps-card::before { content: ''; position: absolute; inset: 14px; border: 1px solid color-mix(in srgb, var(--ink) 35%, transparent); border-radius: 1.4rem; pointer-events: none; }
    .ps-card::after { content: ''; position: absolute; inset: 19px; border: 1px solid color-mix(in srgb, var(--ink) 15%, transparent); border-radius: 1.2rem; pointer-events: none; }
    .ps-ruqaa { font-family: 'Aref Ruqaa', 'Tajawal', serif; font-weight: 700; }
    .ps-soon { font-size: clamp(4.6rem, 11vw, 8rem); line-height: 1.4; color: var(--ink); padding-top: .1em; }
    /* Eyebrow: centred on mobile/tablet → a line on both sides keeps it balanced; right-aligned on desktop → one line trailing the text */
    .ps-eyebrow { display: inline-flex; align-items: center; gap: 14px; margin-bottom: .35rem; font-size: clamp(16px, 1.6vw, 19px); font-weight: 900; letter-spacing: .02em; color: #9a7434; }
    .ps-eyebrow::before, .ps-eyebrow::after { content: ''; width: 40px; height: 2px; border-radius: 2px; background: currentColor; opacity: .85; }
    @media (min-width: 1024px) { .ps-eyebrow::before, .ps-eyebrow::after { width: 52px; } }
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
    .lx-course-row { display: flex; align-items: center; gap: 16px; padding: 16px 0; }
    .lx-course-row + .lx-course-row { border-top: 1px solid var(--line); }
    .lx-topic { display: flex; gap: 10px; align-items: flex-start; font-weight: 600; color: var(--body); line-height: 1.7; }
    .lx-topic .lx-ico { width: 18px; height: 18px; margin-top: 4px; stroke: var(--gold); }
    /* Sticky booking bar (phones) */
    .mh-bar { transform: translateY(110%); transition: transform .3s ease; }
    .mh-bar.on { transform: translateY(0); }
    @media (max-width: 1023px) {
        #global-float-wa, #back-to-top { transition: bottom .3s ease, opacity .5s, transform .5s; }
        body.mh-bar-on #global-float-wa, body.mh-bar-on #back-to-top { bottom: 92px; }
    }
</style>

<div class="lx" dir="{{ $isAr ? 'rtl' : 'ltr' }}">

{{-- ═══════════════ ANNOUNCEMENT STRIP ═══════════════ --}}
@if($customAnnouncement || $bundle || $featured)
<a href="{{ $bundle ? route('bundle.register', $bundle->slug) : ($featured && !$featured['is_full'] ? route('course.register', $featured['slug']) : route('courses')) }}" class="block lx-ink">
    <div class="container mx-auto px-4 py-2.5 flex items-center justify-center gap-3 text-xs sm:text-sm font-semibold text-center">
        <span>
            @if($customAnnouncement)
                {{ $customAnnouncement }}
            @elseif($bundle)
                {{ $t('عرض خاص: الدورتان معاً بـ ' . $fmt($bundle->price) . ' د.ك بدلاً من ' . $fmt($bundle->fullPrice()) . ' د.ك', 'Special offer: both courses for ' . $fmt($bundle->price) . ' KWD instead of ' . $fmt($bundle->fullPrice()) . ' KWD') }}
                <span class="opacity-60 mx-1">·</span>{{ $t('حتى ' . $when($bundleCourses->first())->translatedFormat('j F'), 'until ' . $when($bundleCourses->first())->translatedFormat('j F')) }}
            @else
                {{ $featured['title'][$lang] }} <span class="opacity-60 mx-1">·</span> {{ $featured['day'][$lang] }} {{ $when($featured)->translatedFormat('j F') }}
            @endif
        </span>
        <span class="shrink-0 underline underline-offset-4" style="color: #d9c4a0">{{ $t('التفاصيل', 'Details') }}</span>
    </div>
</a>
@endif

{{-- ═══════════════ HERO ═══════════════ --}}
<section class="lx-ivory">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-14 sm:py-20 lg:py-24">
        <div class="grid lg:grid-cols-12 gap-14 lg:gap-16 items-center">

            <div class="lg:col-span-7">
                @if($heroCourses->isNotEmpty())
                    <p class="lx-label mb-5">{{ $bundle ? $t('برنامج ' . $when($heroCourses->first())->translatedFormat('F') . ' · مركز مطمئنة', $when($heroCourses->first())->translatedFormat('F') . ' programme · Motmaena Center') : $featured['badge'][$lang] }}</p>
                    <h1 class="lx-h1 mb-5">
                        @if($bundle)
                            {{ $t('دورتان حضوريتان مع', 'Two in-person courses with') }} <span class="lx-wine whitespace-nowrap">{{ $t('أ.د. طارق الحبيب', 'Prof. Dr. Tariq Al-Habib') }}</span>
                        @else
                            {{ $featured['title'][$lang] }}
                        @endif
                    </h1>
                    <p class="lx-text text-lg mb-8 max-w-2xl">
                        @if($bundle)
                            {{ $t(config('doctor.title.ar') . '. برنامج عملي بشهادة معتمدة، في مقر مركز مطمئنة بالكويت.', config('doctor.title.en') . '. A practical programme with an accredited certificate, at Motmaena Center in Kuwait.') }}
                        @else
                            {{ $t('مع ', 'with ') }}{{ $featured['trainer'][$lang] }}{{ $featured['certificate'][$lang] ? ' · ' . $featured['certificate'][$lang] : '' }}
                        @endif
                    </p>

                    {{-- The schedule --}}
                    <div class="lx-card px-5 sm:px-6 mb-8">
                        @foreach($heroCourses as $c)
                            <a href="{{ route('course.register', $c['slug']) }}" class="lx-course-row group">
                                <div class="lx-date"><b>{{ $when($c)->format('j') }}</b><span>{{ $when($c)->translatedFormat('F') }}</span></div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-extrabold group-hover:underline underline-offset-4" style="color: var(--ink)">{{ $c['title'][$lang] }}</p>
                                    <p class="text-sm lx-muted font-semibold mt-1">{{ $c['day'][$lang] }} · {{ $c['time'][$lang] }} · {{ $t('حضوري', 'In person') }}@if($c['seats_left'] !== null) · {{ $c['is_full'] ? $t('اكتمل العدد', 'Full') : $t('متبقي ' . $c['seats_left'] . ' مقعد', $c['seats_left'] . ' seats left') }}@endif</p>
                                </div>
                                <span class="font-extrabold whitespace-nowrap" style="color: var(--ink)">{{ $c['price'] }} <small class="text-xs lx-muted">{{ $kwd }}</small></span>
                            </a>
                        @endforeach
                    </div>

                    <div id="hero-cta" class="flex flex-col sm:flex-row gap-3">
                        @if($bundle)
                            <a href="{{ route('bundle.register', $bundle->slug) }}" class="lx-btn lx-btn-primary">
                                {{ $t('الدورتان معاً · ' . $fmt($bundle->price) . ' د.ك', 'Both courses · ' . $fmt($bundle->price) . ' KWD') }}
                                <span class="lx-old !text-white/60 text-sm">{{ $fmt($bundle->fullPrice()) }}</span>
                            </a>
                            <a href="#courses" class="lx-btn lx-btn-outline">{{ $t('التسجيل في دورة واحدة', 'Register for one course') }}</a>
                        @elseif($featured['is_full'])
                            <div class="w-full max-w-md">@include('partials.notify-form', ['courseKey' => $featured['slug']])</div>
                        @else
                            <a href="{{ route('course.register', $featured['slug']) }}" class="lx-btn lx-btn-primary">{{ $t('التسجيل في الدورة · ', 'Register · ') }}{{ $featured['price'] }} {{ $kwd }}</a>
                            <a href="#courses" class="lx-btn lx-btn-outline">{{ $t('محاور الدورة', 'Course outline') }}</a>
                        @endif
                    </div>
                    <p class="text-sm lx-muted font-semibold mt-4">{{ $t('دفع آمن بالكي نت والبطاقات، أو تقسيط على 4 دفعات مع deema.', 'Secure payment by KNET or card, or 4 payments with deema.') }}</p>
                @else
                    <p class="lx-label mb-5">{{ $t('مركز مطمئنة · الكويت', 'Motmaena Center · Kuwait') }}</p>
                    <h1 class="lx-h1 mb-5">{{ $t('حياة أهدأ، وعلاقات أقوى', 'A calmer life, stronger relationships') }}</h1>
                    <p class="lx-text text-lg mb-8 max-w-2xl">{{ $t('دورات وجلسات واستشارات اجتماعية وتربوية بإشراف أ.د. طارق الحبيب، بروفيسور واستشاري الطب النفسي.', 'Courses, sessions and social & educational consultations supervised by Prof. Dr. Tariq Al-Habib, professor & consultant psychiatrist.') }}</p>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('consultations') }}" class="lx-btn lx-btn-primary">{{ $t('احجز استشارة', 'Book a consultation') }}</a>
                        <a href="{{ route('courses') }}" class="lx-btn lx-btn-outline">{{ $t('تصفّح الدورات', 'Browse courses') }}</a>
                    </div>
                @endif
            </div>

            <div class="lg:col-span-5">
                <figure class="max-w-[320px] sm:max-w-[380px] mx-auto">
                    <div class="lx-photo">
                        <img src="{{ asset('photos/dr-tariq-formal.webp') }}" alt="{{ $t('أ.د. طارق الحبيب', 'Prof. Dr. Tariq Al-Habib') }}" width="900" height="1441" class="aspect-[4/5] object-top">
                    </div>
                    <figcaption class="mt-8 text-center">
                        <p class="font-extrabold text-lg" style="color: var(--ink)">{{ $t('أ.د. طارق الحبيب', 'Prof. Dr. Tariq Al-Habib') }}</p>
                        <p class="text-sm lx-muted font-semibold mt-1">{{ config('doctor.title.' . $lang) }}</p>
                    </figcaption>
                </figure>
            </div>
        </div>
    </div>

    {{-- Trust row --}}
    <div class="border-t" style="border-color: var(--line)">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-7 grid grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach([
                ['award', $t('شهادة معتمدة', 'Accredited certificate'), $t('ديوان الخدمة المدنية والتطبيقي', 'Civil Service Commission & PAAET')],
                ['building', $t('حضوري في المركز', 'In person'), $t('برج أحمد، بجوار المستشفى الأميري', 'Burj Ahmed, near Al-Amiri Hospital')],
                ['lock', $t('دفع آمن', 'Secure payment'), 'KNET · Visa · Apple Pay'],
                ['split', $t('تقسيط بدون تعقيد', 'Easy instalments'), $t('4 دفعات مع deema', '4 payments with deema')],
            ] as [$icon, $title, $sub])
                <div class="flex items-start gap-3">
                    @include('partials.lx-icon', ['i' => $icon, 'class' => 'mt-0.5'])
                    <div><p class="font-bold text-sm" style="color: var(--ink)">{{ $title }}</p><p class="text-xs lx-muted font-semibold mt-0.5">{{ $sub }}</p></div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════ COURSES ═══════════════ --}}
@if($courses->isNotEmpty())
<section id="courses" class="lx-paper py-16 sm:py-24 scroll-mt-20">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mb-12">
            <p class="lx-label mb-3">{{ $t('التسجيل مفتوح', 'Registration open') }}</p>
            <h2 class="lx-h2">{{ $t('الدورات القادمة', 'Upcoming courses') }}</h2>
        </div>

        <div class="grid md:grid-cols-2 {{ $courses->count() > 2 ? 'xl:grid-cols-3' : '' }} gap-6">
            @foreach($courses as $c)
            <article id="course-{{ $c['slug'] }}" class="lx-card p-6 sm:p-8 flex flex-col">
                <div class="flex items-start gap-4 mb-6">
                    <div class="lx-date"><b>{{ $when($c)->format('j') }}</b><span>{{ $when($c)->translatedFormat('F') }}</span></div>
                    <div class="min-w-0">
                        <h3 class="lx-h3">{{ $c['title'][$lang] }}</h3>
                        <p class="text-sm lx-muted font-semibold mt-1">{{ $c['trainer'][$lang] }}</p>
                    </div>
                </div>

                <div class="space-y-2 text-sm font-semibold mb-6">
                    <p class="flex items-center gap-2.5">@include('partials.lx-icon', ['i' => 'calendar', 'class' => '!w-[18px] !h-[18px]']){{ $c['day'][$lang] }} {{ $when($c)->translatedFormat('j F Y') }}</p>
                    @if($c['time'][$lang])<p class="flex items-center gap-2.5">@include('partials.lx-icon', ['i' => 'clock', 'class' => '!w-[18px] !h-[18px]']){{ $c['time'][$lang] }}</p>@endif
                    <p class="flex items-center gap-2.5">@include('partials.lx-icon', ['i' => 'pin', 'class' => '!w-[18px] !h-[18px]']){{ $t('حضوري · برج أحمد، الكويت', 'In person · Burj Ahmed, Kuwait') }}</p>
                    @if($c['certificate'][$lang])<p class="flex items-start gap-2.5">@include('partials.lx-icon', ['i' => 'award', 'class' => '!w-[18px] !h-[18px] mt-0.5']){{ $c['certificate'][$lang] }}</p>@endif
                </div>

                @if($c['topics'][$lang])
                    <div class="lx-rule mb-5"></div>
                    <p class="text-sm font-bold mb-3" style="color: var(--ink)">{{ $t('محاور الدورة', 'Course outline') }}</p>
                    <ul class="space-y-1.5 mb-6 text-[15px]">
                        @foreach($c['topics'][$lang] as $topic)
                            <li class="lx-topic">@include('partials.lx-icon', ['i' => 'check']){{ $topic }}</li>
                        @endforeach
                    </ul>
                @endif

                <div class="mt-auto pt-5 flex items-center justify-between gap-4 border-t" style="border-color: var(--line)">
                    <div>
                        <span class="font-extrabold text-2xl" style="color: var(--ink)">{{ $c['price'] }} <small class="text-sm lx-muted">{{ $kwd }}</small></span>
                        @if($c['seats_left'] !== null)<p class="text-xs font-bold {{ $c['is_full'] ? 'text-red-700' : 'lx-muted' }}">{{ $c['is_full'] ? $t('اكتمل العدد', 'Fully booked') : $t('متبقي ' . $c['seats_left'] . ' مقعد', $c['seats_left'] . ' seats left') }}</p>@endif
                    </div>
                    @if($c['is_full'])
                        <a href="{{ route('course.register', $c['slug']) }}" class="lx-btn lx-btn-outline">{{ $t('بلّغني بالموعد القادم', 'Notify me') }}</a>
                    @else
                        <a href="{{ route('course.register', $c['slug']) }}" class="lx-btn lx-btn-primary">{{ $t('التسجيل', 'Register') }}</a>
                    @endif
                </div>
            </article>
            @endforeach
        </div>

        @if($bundle)
        <div class="lx-ink rounded-[14px] mt-6 p-7 sm:p-9 flex flex-col lg:flex-row lg:items-center gap-6 lg:gap-10">
            <div class="flex-1">
                <p class="lx-label mb-3" style="color: #d9c4a0">{{ $bundle->title($lang) }}</p>
                <p class="text-2xl sm:text-3xl font-extrabold text-white leading-snug">
                    {{ $t('سجّل في الدورتين معاً بـ ' . $fmt($bundle->price) . ' د.ك', 'Both courses for ' . $fmt($bundle->price) . ' KWD') }}
                    <span class="text-lg font-semibold text-white/50 line-through mx-2">{{ $fmt($bundle->fullPrice()) }} {{ $kwd }}</span>
                </p>
                <p class="text-white/70 font-semibold mt-2">{{ $t('توفير ' . $fmt($bundle->savings()) . ' د.ك · متاح حتى ' . $when($bundleCourses->first())->translatedFormat('l j F') . ' · لا يُجمع مع أكواد الخصم', 'Save ' . $fmt($bundle->savings()) . ' KWD · until ' . $when($bundleCourses->first())->translatedFormat('l j F') . ' · not combined with discount codes') }}</p>
            </div>
            <a href="{{ route('bundle.register', $bundle->slug) }}" class="lx-btn lx-btn-light shrink-0">{{ $t('احجز العرض', 'Book the offer') }}</a>
        </div>
        @endif

        @if($gift > 0)
        <div id="gift" class="mt-6 lx-card lx-ivory px-6 py-5 flex items-start gap-4 scroll-mt-24">
            @include('partials.lx-icon', ['i' => 'gift', 'class' => 'mt-0.5'])
            <p class="text-[15px] font-semibold leading-relaxed">
                <span class="font-extrabold" style="color: var(--ink)">{{ $t('هدية التسجيل:', 'A gift with your booking:') }}</span>
                {{ $t('كل من يسجّل في دورة بسعرها الكامل يحصل بعد الدفع على كود خصم بقيمة ' . $giftTxt . ' د.ك، لدورته القادمة أو لمن يحب. يُستخدم مرة واحدة، ولا يشمل العروض أو التسجيل بكود خصم.', 'Everyone who books a course at full price gets a ' . $giftTxt . ' KWD code after paying, for their next course or someone they love. Single use; not with offers or other codes.') }}
            </p>
        </div>
        @endif
    </div>
</section>
@endif

{{-- ═══════════════ ABOUT THE DOCTOR ═══════════════ --}}
<section class="lx-ivory py-16 sm:py-24">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 grid lg:grid-cols-12 gap-10 lg:gap-16">
        <div class="lg:col-span-4">
            <p class="lx-label mb-3">{{ $t('عن الدكتور', 'About the doctor') }}</p>
            <h2 class="lx-h2 mb-2">{{ $t('أ.د. طارق الحبيب', 'Prof. Dr. Tariq Al-Habib') }}</h2>
            <p class="lx-muted font-semibold">{{ config('doctor.title.' . $lang) }}</p>
        </div>
        <div class="lg:col-span-8">
            <p class="lx-text text-lg {{ config('claims.show_unverified') ? 'mb-10' : '' }}">{{ config('doctor.bio.' . $lang) }}</p>
            {{-- Figures awaiting the center's confirmation (config/claims.php) --}}
            @if(config('claims.show_unverified'))
            <div class="grid grid-cols-3 gap-6 border-t pt-8" style="border-color: var(--line)">
                @foreach([['+30', $t('سنة في الطب النفسي', 'years in psychiatry')], ['+50', $t('دورة وبرنامج', 'courses')], ['+12', $t('سنة لمركز مطمئنة', 'years of Motmaena')]] as [$n, $l])
                    <div><p class="text-3xl sm:text-4xl font-extrabold lx-wine" dir="ltr">{{ $n }}</p><p class="text-sm lx-muted font-semibold mt-1">{{ $l }}</p></div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</section>

{{-- ═══════════════ CONSULTATION WITH DR. TARIQ (request → center system) ═══════════════ --}}
@include('partials.dr-tariq-thursday')

{{-- ═══════════════ SERVICES ═══════════════ --}}
<section class="lx-ivory py-16 sm:py-24">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mb-12">
            <p class="lx-label mb-3">{{ $t('خدماتنا', 'Our services') }}</p>
            <h2 class="lx-h2">{{ $t('كيف نقدر نساعدك؟', 'How can we help?') }}</h2>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach([
                [route('consultations'), 'chat', $t('الاستشارات', 'Consultations'), $t('جلسة خاصة وسرية مع أخصائي، أو جلسة مع الدكتور طارق.', 'A private session with a specialist, or with Dr. Tariq.')],
                [route('sessions'), 'child', $t('جلسات الأطفال', 'Child sessions'), $t('برامج لتنمية مهارات طفلك وسلوكه بإشراف أخصائيين.', 'Programmes to develop your child\'s skills and behaviour.')],
                [route('packages'), 'layers', $t('الباقات', 'Packages'), $t('باقات متكاملة للتواصل وصعوبات التعلم والثقة بالنفس.', 'Complete packages for communication, learning difficulties and confidence.')],
                [route('courses'), 'play', $t('الدورات المسجّلة', 'Recorded courses'), $t('أكثر من 50 دورة تتابعها في أي وقت.', '50+ courses you can watch anytime.')],
            ] as [$href, $icon, $title, $desc])
            <a href="{{ $href }}" class="lx-card p-6 group flex flex-col">
                <span class="w-11 h-11 rounded-full flex items-center justify-center mb-5" style="border: 1px solid var(--line)">@include('partials.lx-icon', ['i' => $icon])</span>
                <h3 class="lx-h3 mb-2">{{ $title }}</h3>
                <p class="text-sm lx-muted font-semibold leading-relaxed mb-5">{{ $desc }}</p>
                <span class="mt-auto text-sm font-bold lx-wine group-hover:underline underline-offset-4">{{ $t('اعرف أكثر', 'Learn more') }}</span>
            </a>
            @endforeach
        </div>
    </div>
</section>

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

{{-- ═══════════════ THE CENTER ═══════════════ --}}
<section class="lx-ivory py-16 sm:py-24">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 grid lg:grid-cols-12 gap-10 lg:gap-16 items-center">
        <div class="lg:col-span-7">
            <img src="{{ asset('photos/center-reception.webp') }}" alt="{{ $t('استقبال مركز مطمئنة', 'Motmaena Center reception') }}" loading="lazy" width="1800" height="1200" class="w-full aspect-[3/2] object-cover rounded-[6px]">
        </div>
        <div class="lg:col-span-5">
            <p class="lx-label mb-3">{{ $t('زورونا', 'Visit us') }}</p>
            <h2 class="lx-h2 mb-4">{{ $t('مكان هادئ يطمّنك من أول خطوة', 'A calm place from the very first step') }}</h2>
            <p class="lx-text mb-6">{{ $t('استقبال دافئ وأجواء مريحة بإطلالة على البحر، لتشعر بالراحة والخصوصية من لحظة وصولك.', 'A warm welcome and a relaxed setting overlooking the sea, so you feel at ease and private from the moment you arrive.') }}</p>
            <p class="flex items-center gap-2.5 font-semibold mb-8">@include('partials.lx-icon', ['i' => 'pin']){{ $t('الكويت · برج أحمد · بجوار المستشفى الأميري', 'Kuwait · Burj Ahmed · next to Al-Amiri Hospital') }}</p>
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('consultations') }}" class="lx-btn lx-btn-primary">{{ $t('احجز استشارة', 'Book a consultation') }}</a>
                <a href="{{ $waLink($t('مرحباً مركز مطمئنة، ممكن موقع المركز؟', 'Hello Motmaena Center, could you send me your location?')) }}" target="_blank" class="lx-btn lx-btn-outline">{{ $t('اطلب الموقع عبر الواتساب', 'Get directions on WhatsApp') }}</a>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════ TESTIMONIALS ═══════════════ --}}
@if($testimonials->isNotEmpty())
<section class="lx-paper py-16 sm:py-24">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mb-12">
            <p class="lx-label mb-3">{{ $t('آراء المتدربين', 'Testimonials') }}</p>
            <h2 class="lx-h2">{{ $t('تجارب حقيقية', 'Real experiences') }}</h2>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($testimonials as $tm)
            <figure class="lx-card p-7 flex flex-col">
                <div class="mb-4 tracking-widest" style="color: var(--gold)">{{ str_repeat('★', $tm->rating) }}</div>
                <blockquote class="lx-text mb-6">“{{ $tm->quote }}”</blockquote>
                <figcaption class="mt-auto pt-5 border-t" style="border-color: var(--line)">
                    <span class="block font-extrabold text-sm" style="color: var(--ink)">{{ $tm->name }}</span>
                    @if($tm->subtitle)<span class="block text-xs lx-muted font-semibold mt-0.5">{{ $tm->subtitle }}</span>@endif
                </figcaption>
            </figure>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ═══════════════ FAQ ═══════════════ --}}
@if($faqs->isNotEmpty())
<section class="{{ $testimonials->isNotEmpty() ? 'lx-ivory' : 'lx-paper' }} py-16 sm:py-24">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 grid lg:grid-cols-12 gap-10">
        <div class="lg:col-span-4">
            <p class="lx-label mb-3">{{ $t('أسئلة شائعة', 'FAQ') }}</p>
            <h2 class="lx-h2">{{ $t('عندك سؤال؟', 'Questions?') }}</h2>
        </div>
        <div class="lg:col-span-8 border-t" style="border-color: var(--line)">
            @foreach($faqs as $faq)
            <details class="group border-b" style="border-color: var(--line)">
                <summary class="cursor-pointer list-none flex items-center justify-between gap-4 py-5 font-bold" style="color: var(--ink)">
                    {{ $faq->question($lang) }}
                    <span class="text-xl lx-wine transition group-open:rotate-45">+</span>
                </summary>
                <p class="pb-6 lx-text whitespace-pre-line">{{ $faq->answer($lang) }}</p>
            </details>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ═══════════════ FINAL CTA ═══════════════ --}}
<section id="final-cta" class="lx-ink">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-16 grid lg:grid-cols-2 gap-10 items-center">
        <div>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-white mb-3">{{ $canBook ? $t('احجز مقعدك', 'Book your seat') : $t('لا تفوّتك الدورة القادمة', "Don't miss the next course") }}</h2>
            <p class="text-white/70 font-semibold">{{ $t('أو اترك رقمك ونبلغك عند فتح التسجيل في دورة جديدة.', 'Or leave your number and we will tell you when a new course opens.') }}</p>
        </div>
        <div class="flex flex-col gap-3">
            @if($bundle)
                <a href="{{ route('bundle.register', $bundle->slug) }}" class="lx-btn lx-btn-light w-full">{{ $t('الدورتان معاً · ' . $fmt($bundle->price) . ' د.ك', 'Both courses · ' . $fmt($bundle->price) . ' KWD') }}</a>
            @elseif($featured && !$featured['is_full'])
                <a href="{{ route('course.register', $featured['slug']) }}" class="lx-btn lx-btn-light w-full">{{ $featured['title'][$lang] }} · {{ $featured['price'] }} {{ $kwd }}</a>
            @endif
            @include('partials.notify-form', ['dark' => true])
            <a href="{{ $waLink($t('مرحباً مركز مطمئنة، عندي استفسار', 'Hello Motmaena Center, I have a question')) }}" target="_blank" class="text-center text-sm font-semibold text-white/70 hover:text-white">{{ $t('أو تواصل معنا عبر الواتساب', 'or chat with us on WhatsApp') }}</a>
        </div>
    </div>
</section>

{{-- ═══════════════ STICKY BOOKING BAR (phones) ═══════════════ --}}
@if($canBook)
<div id="mh-bar" class="mh-bar lg:hidden fixed inset-x-0 bottom-0 z-[70] lx-paper border-t shadow-[0_-12px_30px_-18px_rgba(0,0,0,.35)]" style="border-color: var(--line); padding-bottom: max(12px, env(safe-area-inset-bottom))">
    <div class="container mx-auto px-4 pt-3 flex items-center gap-3">
        <div class="min-w-0 flex-1">
            @if($bundle)
                <p class="font-extrabold text-sm truncate" style="color: var(--ink)">{{ $t('الدورتان معاً', 'Both courses') }}</p>
                <p class="text-xs font-bold truncate"><span class="lx-wine">{{ $fmt($bundle->price) }} {{ $kwd }}</span> <span class="lx-old">{{ $fmt($bundle->fullPrice()) }}</span></p>
            @else
                <p class="font-extrabold text-sm truncate" style="color: var(--ink)">{{ $featured['title'][$lang] }}</p>
                <p class="text-xs font-bold lx-wine">{{ $featured['price'] }} {{ $kwd }}</p>
            @endif
        </div>
        <a href="{{ $bundle ? route('bundle.register', $bundle->slug) : route('course.register', $featured['slug']) }}" class="lx-btn lx-btn-primary !py-3 !px-5 text-sm">{{ $t('احجز', 'Book') }}</a>
    </div>
</div>
<script>
    // Show the bar once the hero buttons are scrolled away; hide it again at the closing call-to-action
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
