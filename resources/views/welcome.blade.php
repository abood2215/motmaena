@extends('layouts.app')

@section('title', __('Welcome') . ' - ' . __('Motmaena Center'))
@section('og_image', asset('og-anger-management.jpg'))

@section('content')

{{-- ════════════════ ANNOUNCEMENT STRIP ════════════════ --}}
@php $announce = config('course_offers.anger-management'); @endphp
@if($announce && $announce['active'])
<a href="{{ route('course.register', 'anger-management') }}"
   class="group block bg-gradient-to-l from-[#1d4e89] to-[#3b5f95] text-white">
    <div class="container mx-auto px-4 py-2.5 flex items-center justify-center gap-2 sm:gap-3 text-xs sm:text-sm font-bold text-center">
        <span class="w-2 h-2 rounded-full bg-[#8fd3ff] animate-pulse shrink-0"></span>
        <span>
            {{ $announce['title'][app()->getLocale() == 'ar' ? 'ar' : 'en'] }}
            <span class="text-white/70">·</span>
            {{ app()->getLocale() == 'ar' ? 'الأربعاء 28 أكتوبر' : 'Wed, Oct 28' }}
            <span class="text-white/70">·</span>
            {{ $announce['price'] }} {{ app()->getLocale() == 'ar' ? 'د.ك' : 'KWD' }}
        </span>
        <span class="shrink-0 inline-flex items-center gap-1 bg-white text-[#1d4e89] font-black px-2.5 py-1 rounded-full transition group-hover:bg-[#bfe3ff]">
            {{ app()->getLocale() == 'ar' ? 'سجّل الآن' : 'Register' }}
            <svg class="w-3 h-3 {{ app()->getLocale() == 'ar' ? 'rotate-180' : '' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        </span>
    </div>
</a>
@endif

{{-- ════════════════ HERO SECTION ════════════════ --}}
<section class="relative lg:min-h-[92vh] flex items-center bg-secondary dark:bg-dark-surface overflow-hidden border-b border-gray-100 dark:border-dark-border">

    {{-- Background Orbs (Removed red glows) --}}
    <div class="absolute top-0 {{ app()->getLocale() == 'ar' ? 'right-0' : 'left-0' }} w-1/2 h-full bg-gradient-to-b from-gray-500/5 to-transparent pointer-events-none" data-parallax="0.15"></div>

    <div class="container mx-auto px-4 py-10 sm:py-14 lg:py-0 flex flex-col lg:flex-row items-center gap-8 lg:gap-16 relative z-10">

        {{-- ─── Text Content ─── --}}
        <div class="w-full lg:w-1/2 {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }}">

            {{-- Pill Badge --}}
            <div class="animate-blur-in" style="animation-delay: 0s;">
                <div class="inline-flex items-center gap-2 bg-white dark:bg-dark-border px-4 py-2 rounded-full mb-5 lg:mb-8">
                    <span class="w-1.5 h-1.5 bg-primary rounded-full shrink-0"></span>
                    <span class="text-primary font-bold text-[10px] sm:text-xs uppercase tracking-wide sm:tracking-widest">{{ __('Exclusive and recorded courses') }}</span>
                </div>
            </div>

            {{-- Headline --}}
            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-7xl font-extrabold text-gray-900 dark:text-white mb-5 lg:mb-8 leading-[1.2] lg:leading-[1.1] tracking-tight">
                <span class="block overflow-hidden pb-1">
                    <span class="block animate-word-reveal" style="animation-delay: 0.1s;">{{ __('Develop your skills') }}</span>
                </span>
                <span class="block overflow-hidden pb-1">
                    <span class="block gradient-text animate-word-reveal" style="animation-delay: 0.28s;">{{ __('Psychological and Life') }}</span>
                </span>
            </h1>

            {{-- Subtitle --}}
            <p class="text-sm sm:text-base lg:text-xl text-[var(--muted-color)] mb-7 lg:mb-12 max-w-xl leading-relaxed animate-blur-in" style="animation-delay: 0.48s;">
                {{ __('With Professor') }}
                <span class="text-gray-900 dark:text-white font-bold">{{ __('Dr. Tariq Al-Habib') }}</span><br>
                <span class="text-xs sm:text-sm lg:text-base">{{ __('Consultant Psychiatrist') }}</span>
            </p>

            {{-- CTA Buttons --}}
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 animate-blur-in" style="animation-delay: 0.62s;">
                <a href="{{ route('courses') }}" class="btn-motmaena text-sm sm:text-base px-6 sm:px-10 py-3 sm:py-4 text-center shadow-xl shadow-primary/30">
                    {{ __('Start your journey now') }}
                </a>
                <a href="#about" class="btn-outline dark:bg-transparent dark:text-white dark:border-white/20 text-sm sm:text-base px-6 sm:px-10 py-3 sm:py-4 text-center bg-white">
                    {{ __('About the Professor') }}
                </a>
            </div>

            {{-- Stats Row --}}
            <div class="flex items-stretch gap-4 sm:gap-6 lg:gap-8 mt-8 lg:mt-14 pt-7 lg:pt-10 border-t border-gray-100 dark:border-dark-border animate-blur-in" style="animation-delay: 0.75s;">
                <div class="{{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }} animate-stat-pop" style="animation-delay: 0.8s;">
                    <div class="text-lg sm:text-2xl lg:text-3xl font-black text-gray-900 dark:text-white">+100K</div>
                    <div class="text-[10px] sm:text-sm text-[var(--muted-color)] mt-0.5">{{ app()->getLocale() == 'ar' ? 'متدرب' : 'Trainees' }}</div>
                </div>
                <div class="w-px bg-gray-200 dark:bg-dark-border self-stretch shrink-0"></div>
                <div class="{{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }} animate-stat-pop" style="animation-delay: 0.95s;">
                    <div class="text-lg sm:text-2xl lg:text-3xl font-black text-gray-900 dark:text-white">55+</div>
                    <div class="text-[10px] sm:text-sm text-[var(--muted-color)] mt-0.5">{{ app()->getLocale() == 'ar' ? 'دورة متخصصة' : 'Courses' }}</div>
                </div>
                <div class="w-px bg-gray-200 dark:bg-dark-border self-stretch shrink-0"></div>
                <div class="{{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }} animate-stat-pop" style="animation-delay: 1.1s;">
                    <div class="flex items-baseline gap-1">
                        <span class="text-lg sm:text-2xl lg:text-3xl font-black text-gray-900 dark:text-white">4.9</span>
                        <span class="text-primary text-sm sm:text-xl font-black">★</span>
                    </div>
                    <div class="text-[10px] sm:text-sm text-[var(--muted-color)] mt-0.5">{{ app()->getLocale() == 'ar' ? 'تقييم المتدربين' : 'Trainee Rating' }}</div>
                </div>
            </div>
        </div>

        {{-- ─── Hero Visual (V3: The Wellness Core) ─── --}}
        <div class="w-full lg:w-1/2 flex justify-center pb-12 sm:pb-16 lg:pb-0 reveal-scale" style="animation-delay: 0.18s;">
            <div class="relative w-full max-w-[300px] sm:max-w-[400px] lg:max-w-xl aspect-square flex items-center justify-center">

                {{-- Deep Atmospheric Glows --}}
                <div class="absolute inset-0 pointer-events-none">
                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[120%] h-[120%] bg-primary/20 rounded-full blur-[120px] animate-pulse" style="animation-duration: 8s;"></div>
                    <div class="absolute top-1/4 left-1/4 w-32 h-32 bg-primary-light/30 rounded-full blur-[60px] animate-float"></div>
                </div>

                {{-- Central Doctor Profile Card --}}
                <div class="relative z-20 group">

                    {{-- Decorative slow-spin border ring --}}
                    <div class="absolute -inset-6 sm:-inset-10 border border-primary/15 rounded-[3.5rem] animate-spin-slow pointer-events-none" style="animation-duration:22s;"></div>
                    <div class="absolute -inset-12 sm:-inset-16 border border-primary/8 rounded-[4.5rem] animate-spin-reverse-slow pointer-events-none" style="animation-duration:30s;"></div>

                    {{-- Portrait Card --}}
                    <div class="relative overflow-hidden
                                w-[185px] h-[255px] sm:w-[225px] sm:h-[305px]
                                rounded-[2.5rem]
                                border-2 border-white/80 dark:border-white/10
                                shadow-[0_35px_80px_-10px_rgba(176,65,65,0.45),_0_8px_25px_-5px_rgba(0,0,0,0.14)]
                                transition-all duration-700
                                hover:shadow-[0_48px_100px_-10px_rgba(176,65,65,0.55),_0_10px_30px_-5px_rgba(0,0,0,0.18)]
                                hover:-translate-y-1.5">

                        {{-- Doctor Photo --}}
                        <img src="{{ asset('courses-img/dr-tariq.png') }}"
                             alt="أ.د طارق الحبيب"
                             class="absolute inset-0 w-full h-full object-cover object-top transition-transform duration-700 group-hover:scale-105">

                        {{-- Bottom gradient info strip --}}
                        <div class="absolute bottom-0 inset-x-0 pt-16 pb-4 px-4 text-center"
                             style="background: linear-gradient(to top, rgba(100,30,30,0.95) 0%, rgba(176,65,65,0.75) 55%, transparent 100%)">
                            <h3 class="text-white font-black text-[14px] sm:text-[15px] leading-snug mb-0.5">
                                {{ app()->getLocale() == 'ar' ? 'أ.د طارق الحبيب' : 'Prof. Dr. Tariq' }}
                            </h3>
                            <p class="text-white/70 text-[9px] sm:text-[10px] font-semibold tracking-wide mb-2">
                                {{ app()->getLocale() == 'ar' ? 'خبير الإرشاد الاجتماعي والتربوي وتنمية المهارات الحياتية' : 'Social, Educational & Life Skills Expert' }}
                            </p>
                            <div class="flex justify-center gap-px text-yellow-300 text-[11px]">★★★★★</div>
                        </div>

                        {{-- Top pill badge --}}
                        <div class="absolute top-3.5 {{ app()->getLocale() == 'ar' ? 'left-3.5' : 'right-3.5' }}
                                    bg-white/92 dark:bg-dark-surface/90 backdrop-blur-sm
                                    text-primary text-[9px] font-black
                                    px-2.5 py-1 rounded-full
                                    shadow-md border border-primary/20">
                            {{ app()->getLocale() == 'ar' ? 'استشاري' : 'Consultant' }}
                        </div>

                    </div>
                </div>

                {{-- Connected Satellite Cards (The Satellites) --}}

                {{-- Stat: Experience (Top Right) --}}
                <div class="absolute -top-4 -right-4 sm:top-4 sm:right-4 z-30 animate-float" style="animation-delay: 1s;">
                    <div class="bg-white/90 dark:bg-dark-surface/90 backdrop-blur-xl px-4 sm:px-6 py-3 sm:py-4 rounded-3xl shadow-2xl border border-gray-100 dark:border-dark-border flex items-center gap-3">
                        <div class="w-10 h-10 bg-primary/10 rounded-2xl flex items-center justify-center text-primary font-black text-lg">30+</div>
                        <div>
                            <div class="text-[10px] sm:text-xs font-bold text-gray-900 dark:text-white">{{ app()->getLocale() == 'ar' ? 'سنة خبرة' : 'Years' }}</div>
                            <div class="text-[9px] text-green-500 font-bold">{{ app()->getLocale() == 'ar' ? 'خبرة عالمية' : 'Expertise' }}</div>
                        </div>
                    </div>
                </div>

                {{-- Stat: Trainees (Bottom Right) --}}
                <div class="absolute -bottom-6 -right-2 sm:bottom-10 sm:right-0 z-30 animate-float" style="animation-delay: 2s;">
                    <div class="bg-white/90 dark:bg-dark-surface/90 backdrop-blur-xl px-4 sm:px-6 py-3 sm:py-4 rounded-3xl shadow-2xl border border-gray-100 dark:border-dark-border">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="flex -space-x-3">
                                <div class="w-8 h-8 rounded-full border-2 border-white bg-gray-200"></div>
                                <div class="w-8 h-8 rounded-full border-2 border-white bg-primary text-white flex items-center justify-center text-[8px] font-bold">+</div>
                            </div>
                            <span class="text-xs sm:text-sm font-black text-gray-900 dark:text-white">100K+</span>
                        </div>
                        <div class="text-[9px] font-bold text-[var(--muted-color)] tracking-wider uppercase">{{ app()->getLocale() == 'ar' ? 'متدرب حقيقي' : 'Real Trainees' }}</div>
                    </div>
                </div>

                {{-- Stat: Rating (Middle Left) --}}
                <div class="absolute top-[40%] -left-6 sm:left-0 z-30 animate-float hidden sm:block" style="animation-delay: 1.5s;">
                    <div class="glass-effect-heavy p-4 sm:p-5 rounded-[2.5rem] shadow-xl border border-white/40 flex flex-col items-center">
                        <div class="text-xl sm:text-2xl font-black text-primary leading-none mb-1">4.9</div>
                        <div class="flex text-yellow-500 scale-90 mb-1">★★★★★</div>
                        <div class="text-[8px] font-black text-gray-400 uppercase tracking-widest">{{ app()->getLocale() == 'ar' ? 'تقييم عام' : 'Global Score' }}</div>
                    </div>
                </div>

                {{-- Stat: Certification (Bottom Left) --}}
                <div class="absolute -bottom-10 -left-2 sm:bottom-0 sm:left-10 z-30 animate-float hidden sm:block" style="animation-delay: 0.5s;">
                    <div class="bg-gradient-to-br from-primary to-primary-dark p-4 sm:p-5 rounded-3xl shadow-2xl shadow-primary/40 text-white flex items-center gap-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 sm:h-8 sm:w-8 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        <div>
                            <div class="text-xs sm:text-sm font-black">{{ app()->getLocale() == 'ar' ? 'معتمد' : 'Accredited' }}</div>
                            <div class="text-[9px] text-white/60">{{ app()->getLocale() == 'ar' ? 'شهادات مهنية' : 'Pro Certificates' }}</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

{{-- ════════════════ FEATURED COURSE: ANGER MANAGEMENT (poster palette) ════════════════ --}}
@php
    $lang  = app()->getLocale() == 'ar' ? 'ar' : 'en';
    $isAr  = $lang === 'ar';
    $offer = config('course_offers.anger-management');
@endphp
<section id="special-event" class="relative overflow-hidden py-12 sm:py-16 lg:py-20 bg-[#eef1f6] dark:bg-[#0b1220]">
    <div class="absolute -top-24 {{ $isAr ? '-left-24' : '-right-24' }} w-96 h-96 rounded-full bg-[#1565c0]/10 blur-3xl pointer-events-none"></div>

    <div class="relative container mx-auto px-4 sm:px-6 lg:px-8" dir="{{ $isAr ? 'rtl' : 'ltr' }}">

        <div class="relative rounded-[2rem] overflow-hidden shadow-2xl shadow-[#1d4e89]/20"
             style="background: linear-gradient({{ $isAr ? '270deg' : '90deg' }}, #1d4e89 0%, #3b5f95 50%, #7f97bf 100%);">
            <div class="flex flex-col lg:flex-row">

                {{-- Content --}}
                <div class="flex-1 p-6 sm:p-10 lg:p-12 text-white">
                    <span class="inline-flex items-center gap-2 text-xs sm:text-sm font-black px-3.5 py-1.5 rounded-full bg-white/15 border border-white/25 mb-5">
                        <span class="w-2 h-2 rounded-full bg-[#8fd3ff] animate-pulse"></span>
                        {{ $isAr ? 'دورة جديدة · التسجيل مفتوح' : 'New course · Registration open' }}
                    </span>

                    <h2 class="font-black leading-tight mb-2" style="font-size: clamp(2rem, 5vw, 3.4rem);">
                        @if($isAr)
                            <span class="text-[#bfe3ff]">دورة</span> إدارة الغضب
                        @else
                            Anger <span class="text-[#bfe3ff]">Management</span>
                        @endif
                    </h2>
                    <p class="text-white/80 text-lg sm:text-xl font-black mb-7">{{ $offer['trainer'][$lang] }}</p>

                    {{-- Topics --}}
                    <p class="inline-block text-[#1d4e89] bg-white text-xs font-black px-3 py-1 rounded-md mb-3">{{ $isAr ? 'المحاور' : 'Topics' }}</p>
                    <ul class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-2 mb-8">
                        @foreach($offer['topics'][$lang] as $topic)
                        <li class="flex items-start gap-2 text-sm sm:text-[15px] font-bold text-white/90 leading-snug">
                            <span class="mt-2 w-1.5 h-1.5 rounded-full bg-[#8fd3ff] shrink-0"></span>
                            {{ $topic }}
                        </li>
                        @endforeach
                    </ul>

                    {{-- Date / time / place --}}
                    @php
                        $infoItems = [
                            ['icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'top' => $offer['day'][$lang], 'bottom' => \Carbon\Carbon::parse($offer['date'])->format('Y/m/d'), 'dir' => 'ltr'],
                            ['icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'top' => $isAr ? 'مساءً' : 'Evening', 'bottom' => '7:00 - 9:00', 'dir' => 'ltr'],
                            ['icon' => 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z', 'top' => $isAr ? 'حضوري' : 'In-person', 'bottom' => $isAr ? 'برج أحمد - الكويت' : 'Burj Ahmed, Kuwait', 'dir' => 'auto'],
                        ];
                    @endphp
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-8">
                        @foreach($infoItems as $info)
                        <div class="flex items-center gap-3 rounded-2xl bg-white/10 border border-white/15 p-3">
                            <span class="w-10 h-10 rounded-xl bg-[#1d4e89] border border-white/20 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $info['icon'] }}"/></svg>
                            </span>
                            <span>
                                <span class="block text-white/65 text-xs font-bold">{{ $info['top'] }}</span>
                                <span class="block font-black text-sm" dir="{{ $info['dir'] }}">{{ $info['bottom'] }}</span>
                            </span>
                        </div>
                        @endforeach
                    </div>

                    {{-- Price + CTA --}}
                    <div class="flex flex-col xl:flex-row xl:items-center gap-4 xl:gap-6 rounded-2xl bg-white p-4 sm:p-5 text-[#1d4e89]">
                        <div class="flex items-center gap-4">
                            <div class="whitespace-nowrap">
                                <span class="block text-xs font-bold text-gray-500">{{ $isAr ? 'رسوم الاشتراك' : 'Course fee' }}</span>
                                <span class="font-black leading-none" style="font-size: clamp(2rem, 4vw, 2.6rem);">{{ $offer['price'] }}</span>
                                <span class="font-black">{{ $isAr ? 'دينار' : 'KWD' }}</span>
                            </div>
                            <span class="text-center whitespace-nowrap text-[11px] font-black leading-tight px-3 py-2 rounded-2xl bg-[#fdecef] text-[#d6334b]">
                                deema<br>{{ $isAr ? 'قسّط على 4 دفعات' : 'Split in 4 payments' }}
                            </span>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-2 {{ $isAr ? 'xl:mr-auto' : 'xl:ml-auto' }}">
                            <a href="{{ route('course.register', 'anger-management') }}"
                               class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-xl px-7 py-3.5 font-black text-white shadow-lg shadow-[#1565c0]/30 transition hover:-translate-y-0.5 active:scale-95"
                               style="background: linear-gradient(135deg, #1565c0, #1d4e89);">
                                {{ $isAr ? 'سجّل وادفع الآن' : 'Register & pay now' }}
                                <svg class="w-4 h-4 {{ $isAr ? 'rotate-180' : '' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                            </a>
                            <a href="https://wa.me/96555665161?text={{ rawurlencode($isAr ? 'مرحباً، أريد الاستفسار عن دورة إدارة الغضب' : 'Hello, I would like to ask about the Anger Management course') }}" target="_blank"
                               class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-xl px-5 py-3.5 font-black text-[#1d4e89] border-2 border-[#1d4e89]/15 hover:bg-[#1d4e89]/5 transition">
                                {{ $isAr ? 'استفسار واتساب' : 'Ask on WhatsApp' }}
                            </a>
                        </div>
                    </div>

                    {{-- Certificate --}}
                    <p class="flex items-center gap-2 mt-5 text-sm font-black text-white/90">
                        <span class="w-6 h-6 rounded-full bg-[#1565c0] border border-white/30 flex items-center justify-center shrink-0">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        </span>
                        {{ $offer['certificate'][$lang] }}
                    </p>
                </div>

                {{-- Photo --}}
                <div class="relative lg:w-[38%] min-h-[300px] sm:min-h-[380px] lg:min-h-0 bg-[#5f7aa8]/40 flex items-end justify-center overflow-hidden">
                    <div class="absolute inset-0" style="background: radial-gradient(circle at 50% 70%, rgba(255,255,255,0.25), transparent 65%);"></div>
                    <img src="{{ asset('courses-img/dr-tariq.png') }}" alt="{{ $offer['trainer'][$lang] }}"
                         class="relative w-[78%] sm:w-[60%] lg:w-[92%] h-auto object-contain object-bottom drop-shadow-2xl">
                </div>
            </div>
        </div>

        {{-- Contact --}}
        <div class="flex flex-wrap items-center justify-between gap-4 mt-6 text-sm font-bold text-gray-600 dark:text-gray-300">
            <span>{{ $isAr ? 'للتواصل والاستفسار:' : 'Contact:' }} <span dir="ltr" class="text-[#1d4e89] dark:text-[#8fd3ff] font-black">+965 556 651 61</span> · <span dir="ltr" class="text-[#1d4e89] dark:text-[#8fd3ff] font-black">+965 998 801 40</span></span>
            <span>{{ $isAr ? 'الكويت - برج أحمد - بجوار المستشفى الأميري' : 'Kuwait - Burj Ahmed - near Al-Amiri Hospital' }}</span>
        </div>
    </div>
</section>
{{-- ════════════════ ABOUT SECTION ════════════════ --}}
<section id="about" class="py-14 sm:py-20 md:py-24 bg-white dark:bg-dark-bg relative overflow-hidden">
    <div class="container mx-auto px-4">
        <div class="flex flex-col lg:flex-row items-center gap-6 sm:gap-8 lg:gap-20">

            {{-- Image / Visual Side --}}
            <div class="w-full lg:w-2/5 flex justify-center reveal-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}">
                <div class="relative">
                    <div class="absolute -inset-4 bg-gradient-to-tr from-primary/20 to-primary-light/10 rounded-3xl blur-2xl pointer-events-none"></div>
                    <div class="relative bg-gradient-to-br from-primary to-primary-dark rounded-3xl p-8 sm:p-12 shadow-2xl text-center">
                        <div class="w-28 h-28 sm:w-36 sm:h-36 rounded-full mx-auto mb-6 overflow-hidden border-4 border-white/30 shadow-xl">
                            <img src="{{ asset('courses-img/dr-tariq.png') }}" alt="أ.د طارق الحبيب" class="w-full h-full object-cover object-top">
                        </div>
                        <h3 class="text-xl sm:text-2xl font-black text-white mb-2">{{ app()->getLocale() == 'ar' ? 'أ.د طارق الحبيب' : 'Prof. Dr. Tariq Al-Habib' }}</h3>
                        <p class="text-white/70 text-sm">{{ app()->getLocale() == 'ar' ? 'خبير الإرشاد الاجتماعي والتربوي وتنمية المهارات الحياتية' : 'Social, Educational & Life Skills Expert' }}</p>
                        <div class="flex justify-center gap-2 sm:gap-3 mt-4 sm:mt-6">
                            <div class="bg-white/15 backdrop-blur px-2 sm:px-4 py-2 rounded-xl border border-white/10">
                                <div class="text-base sm:text-lg font-black text-white">+30</div>
                                <div class="text-[9px] sm:text-[10px] text-white/60">{{ app()->getLocale() == 'ar' ? 'سنة خبرة' : 'Years Exp.' }}</div>
                            </div>
                            <div class="bg-white/15 backdrop-blur px-2 sm:px-4 py-2 rounded-xl border border-white/10">
                                <div class="text-base sm:text-lg font-black text-white">+55</div>
                                <div class="text-[9px] sm:text-[10px] text-white/60">{{ app()->getLocale() == 'ar' ? 'دورة' : 'Courses' }}</div>
                            </div>
                            <div class="bg-white/15 backdrop-blur px-2 sm:px-4 py-2 rounded-xl border border-white/10">
                                <div class="text-base sm:text-lg font-black text-white">+100K</div>
                                <div class="text-[9px] sm:text-[10px] text-white/60">{{ app()->getLocale() == 'ar' ? 'متدرب' : 'Trainees' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Text Content --}}
            <div class="w-full lg:w-3/5 {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }} reveal-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}">
                <span class="inline-block bg-primary/10 text-primary px-4 py-1.5 rounded-full text-[10px] sm:text-xs font-bold mb-5 tracking-widest uppercase">{{ app()->getLocale() == 'ar' ? 'من نحن' : 'About Us' }}</span>
                <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-black text-gray-900 dark:text-white mb-6 leading-tight">
                    {{ app()->getLocale() == 'ar' ? 'مركز مطمئنة للإرشاد الاجتماعي والتربوي وتنمية المهارات الحياتية' : 'Motmaena Center for Social, Educational & Life Skills' }}
                </h2>
                <p class="text-[var(--muted-color)] text-sm sm:text-base leading-relaxed mb-6">
                    {{ app()->getLocale() == 'ar' ? 'مركز مطمئنة مركز متخصص في الإرشاد الاجتماعي والتربوي وتنمية المهارات الحياتية، تحت إشراف البروفيسور طارق الحبيب. يقدم المركز دورات حصرية ومسجلة تساعدك على بناء مهاراتك الحياتية وتعزيز علاقاتك الاجتماعية والأسرية.' : 'Motmaena Center specializes in social, educational and life skills guidance under the supervision of Professor Tariq Al-Habib. We offer exclusive recorded courses to help you build life skills and strengthen your relationships.' }}
                </p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
                    <div class="flex items-center gap-3 bg-gray-50 dark:bg-dark-surface p-4 rounded-2xl border border-gray-100 dark:border-dark-border">
                        <div class="w-10 h-10 bg-primary/10 rounded-xl flex items-center justify-center text-primary shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <span class="text-sm font-bold text-gray-900 dark:text-white">{{ app()->getLocale() == 'ar' ? 'دورات حصرية ومسجلة' : 'Exclusive Recorded Courses' }}</span>
                    </div>
                    <div class="flex items-center gap-3 bg-gray-50 dark:bg-dark-surface p-4 rounded-2xl border border-gray-100 dark:border-dark-border">
                        <div class="w-10 h-10 bg-primary/10 rounded-xl flex items-center justify-center text-primary shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        </div>
                        <span class="text-sm font-bold text-gray-900 dark:text-white">{{ app()->getLocale() == 'ar' ? 'محتوى علمي معتمد' : 'Certified Content' }}</span>
                    </div>
                    <div class="flex items-center gap-3 bg-gray-50 dark:bg-dark-surface p-4 rounded-2xl border border-gray-100 dark:border-dark-border">
                        <div class="w-10 h-10 bg-primary/10 rounded-xl flex items-center justify-center text-primary shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <span class="text-sm font-bold text-gray-900 dark:text-white">{{ app()->getLocale() == 'ar' ? 'إشراف أكاديمي متميز' : 'Distinguished Supervision' }}</span>
                    </div>
                    <div class="flex items-center gap-3 bg-gray-50 dark:bg-dark-surface p-4 rounded-2xl border border-gray-100 dark:border-dark-border">
                        <div class="w-10 h-10 bg-primary/10 rounded-xl flex items-center justify-center text-primary shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        </div>
                        <span class="text-sm font-bold text-gray-900 dark:text-white">{{ app()->getLocale() == 'ar' ? 'تعلّم من أي مكان' : 'Learn from Anywhere' }}</span>
                    </div>
                </div>
                <a href="{{ route('courses') }}" class="btn-motmaena text-sm sm:text-base px-8 py-3.5 shadow-xl shadow-primary/20">{{ app()->getLocale() == 'ar' ? 'استكشف الدورات' : 'Explore Courses' }}</a>
            </div>
        </div>
    </div>
</section>



{{-- ════════════════ COUNTER SECTION ════════════════ --}}
<section class="py-14 sm:py-20 bg-primary relative overflow-hidden">
    <div class="absolute inset-0 opacity-[0.04] pointer-events-none" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 24px 24px;"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 lg:gap-10">
            <div class="text-center reveal">
                <div class="text-3xl sm:text-4xl lg:text-5xl font-black text-white mb-2" data-counter="100000">0</div>
                <div class="w-10 h-1 bg-white/30 rounded-full mx-auto mb-2"></div>
                <div class="text-white/70 text-xs sm:text-sm font-medium">{{ app()->getLocale() == 'ar' ? 'متدرب مسجل' : 'Registered Trainees' }}</div>
            </div>
            <div class="text-center reveal">
                <div class="text-3xl sm:text-4xl lg:text-5xl font-black text-white mb-2" data-counter="55">0</div>
                <div class="w-10 h-1 bg-white/30 rounded-full mx-auto mb-2"></div>
                <div class="text-white/70 text-xs sm:text-sm font-medium">{{ app()->getLocale() == 'ar' ? 'دورة متخصصة' : 'Specialized Courses' }}</div>
            </div>
            <div class="text-center reveal">
                <div class="text-3xl sm:text-4xl lg:text-5xl font-black text-white mb-2" data-counter="12">0</div>
                <div class="w-10 h-1 bg-white/30 rounded-full mx-auto mb-2"></div>
                <div class="text-white/70 text-xs sm:text-sm font-medium">{{ app()->getLocale() == 'ar' ? 'سنة من التميز' : 'Years of Excellence' }}</div>
            </div>
            <div class="text-center reveal">
                <div class="text-3xl sm:text-4xl lg:text-5xl font-black text-white mb-2" data-counter="4.9" data-decimal="true">0</div>
                <div class="w-10 h-1 bg-white/30 rounded-full mx-auto mb-2"></div>
                <div class="text-white/70 text-xs sm:text-sm font-medium">{{ app()->getLocale() == 'ar' ? 'تقييم المتدربين' : 'Trainee Rating' }}</div>
            </div>
        </div>
    </div>
</section>

{{-- ════════════════ FAQ SECTION ════════════════ --}}
<section class="py-14 sm:py-20 md:py-24 bg-secondary dark:bg-dark-surface relative overflow-hidden">
    <div class="container mx-auto px-4 max-w-3xl">
        <div class="text-center mb-10 sm:mb-16 reveal">
            <span class="inline-block bg-primary/10 text-primary px-4 py-1.5 rounded-full text-[10px] sm:text-xs font-bold mb-5 tracking-widest uppercase">{{ app()->getLocale() == 'ar' ? 'أسئلة شائعة' : 'FAQ' }}</span>
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-black text-gray-900 dark:text-white mb-4">
                {{ app()->getLocale() == 'ar' ? 'الأسئلة الأكثر شيوعاً' : 'Frequently Asked Questions' }}
            </h2>
        </div>
        <div class="space-y-3 sm:space-y-4 reveal">
            {{-- FAQ 1 --}}
            <div class="faq-item bg-white dark:bg-dark-bg rounded-2xl border border-gray-100 dark:border-dark-border overflow-hidden shadow-sm">
                <button onclick="toggleFaq(this)" class="w-full flex items-center justify-between p-5 sm:p-6 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} gap-4">
                    <span class="font-bold text-sm sm:text-base text-gray-900 dark:text-white">{{ app()->getLocale() == 'ar' ? 'كيف أسجل في الدورات؟' : 'How do I register for courses?' }}</span>
                    <svg class="faq-icon h-5 w-5 text-primary shrink-0 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div class="faq-content max-h-0 overflow-hidden transition-all duration-500 ease-in-out">
                    <p class="px-5 sm:px-6 pb-5 sm:pb-6 text-[var(--muted-color)] text-sm leading-relaxed">{{ app()->getLocale() == 'ar' ? 'يمكنك التسجيل عبر الموقع الإلكتروني. اختر الدورة المناسبة لك واضغط على "سجل الآن" لإتمام عملية التسجيل والدفع.' : 'You can register through the website. Choose your course and click "Register Now" to complete registration and payment.' }}</p>
                </div>
            </div>
            {{-- FAQ 2 --}}
            <div class="faq-item bg-white dark:bg-dark-bg rounded-2xl border border-gray-100 dark:border-dark-border overflow-hidden shadow-sm">
                <button onclick="toggleFaq(this)" class="w-full flex items-center justify-between p-5 sm:p-6 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} gap-4">
                    <span class="font-bold text-sm sm:text-base text-gray-900 dark:text-white">{{ app()->getLocale() == 'ar' ? 'هل الدورات مسجلة أم مباشرة؟' : 'Are courses recorded or live?' }}</span>
                    <svg class="faq-icon h-5 w-5 text-primary shrink-0 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div class="faq-content max-h-0 overflow-hidden transition-all duration-500 ease-in-out">
                    <p class="px-5 sm:px-6 pb-5 sm:pb-6 text-[var(--muted-color)] text-sm leading-relaxed">{{ app()->getLocale() == 'ar' ? 'نقدم دورات مسجلة يمكنك مشاهدتها في أي وقت يناسبك، بالإضافة إلى بعض الدورات المباشرة التي يتم الإعلان عنها بشكل دوري.' : 'We offer recorded courses you can watch anytime, plus some live courses announced periodically.' }}</p>
                </div>
            </div>
            {{-- FAQ 3 --}}
            <div class="faq-item bg-white dark:bg-dark-bg rounded-2xl border border-gray-100 dark:border-dark-border overflow-hidden shadow-sm">
                <button onclick="toggleFaq(this)" class="w-full flex items-center justify-between p-5 sm:p-6 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} gap-4">
                    <span class="font-bold text-sm sm:text-base text-gray-900 dark:text-white">{{ app()->getLocale() == 'ar' ? 'هل أحصل على شهادة بعد إتمام الدورة؟' : 'Do I get a certificate after completing the course?' }}</span>
                    <svg class="faq-icon h-5 w-5 text-primary shrink-0 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div class="faq-content max-h-0 overflow-hidden transition-all duration-500 ease-in-out">
                    <p class="px-5 sm:px-6 pb-5 sm:pb-6 text-[var(--muted-color)] text-sm leading-relaxed">{{ app()->getLocale() == 'ar' ? 'نعم، يحصل كل متدرب على شهادة إتمام معتمدة من مركز مطمئنة بعد إنهاء جميع محتويات الدورة بنجاح.' : 'Yes, every trainee receives a completion certificate accredited by Motmaena Center after finishing all course content.' }}</p>
                </div>
            </div>
            {{-- FAQ 4 --}}
            <div class="faq-item bg-white dark:bg-dark-bg rounded-2xl border border-gray-100 dark:border-dark-border overflow-hidden shadow-sm">
                <button onclick="toggleFaq(this)" class="w-full flex items-center justify-between p-5 sm:p-6 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} gap-4">
                    <span class="font-bold text-sm sm:text-base text-gray-900 dark:text-white">{{ app()->getLocale() == 'ar' ? 'ما هي طرق الدفع المتاحة؟' : 'What payment methods are available?' }}</span>
                    <svg class="faq-icon h-5 w-5 text-primary shrink-0 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div class="faq-content max-h-0 overflow-hidden transition-all duration-500 ease-in-out">
                    <p class="px-5 sm:px-6 pb-5 sm:pb-6 text-[var(--muted-color)] text-sm leading-relaxed">{{ app()->getLocale() == 'ar' ? 'نقبل الدفع عبر البطاقات البنكية (فيزا، ماستركارد)، كي نت، وApple Pay. كما يمكن الدفع عبر التحويل البنكي.' : 'We accept bank cards (Visa, Mastercard), KNET, Apple Pay, and bank transfers.' }}</p>
                </div>
            </div>
            {{-- FAQ 5 --}}
            <div class="faq-item bg-white dark:bg-dark-bg rounded-2xl border border-gray-100 dark:border-dark-border overflow-hidden shadow-sm">
                <button onclick="toggleFaq(this)" class="w-full flex items-center justify-between p-5 sm:p-6 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} gap-4">
                    <span class="font-bold text-sm sm:text-base text-gray-900 dark:text-white">{{ app()->getLocale() == 'ar' ? 'هل يمكنني مشاهدة الدورة أكثر من مرة؟' : 'Can I watch the course more than once?' }}</span>
                    <svg class="faq-icon h-5 w-5 text-primary shrink-0 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div class="faq-content max-h-0 overflow-hidden transition-all duration-500 ease-in-out">
                    <p class="px-5 sm:px-6 pb-5 sm:pb-6 text-[var(--muted-color)] text-sm leading-relaxed">{{ app()->getLocale() == 'ar' ? 'بالتأكيد! بمجرد التسجيل في الدورة، يمكنك إعادة مشاهدة المحتوى عدد غير محدود من المرات طوال فترة اشتراكك.' : 'Absolutely! Once enrolled, you can re-watch the content unlimited times throughout your subscription period.' }}</p>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection
