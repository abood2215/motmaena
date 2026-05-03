@extends('layouts.app')

@section('title', __('Welcome') . ' - ' . __('Motmaena Center'))

@section('content')

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
                    <div class="text-[10px] sm:text-sm text-[var(--muted-color)] mt-0.5">{{ app()->getLocale() == 'ar' ? 'تقييم التطبيق' : 'App Rating' }}</div>
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

{{-- ════════════════ SPECIAL EVENT: DR. TARIQ VISIT ════════════════ --}}
<section id="special-event" class="relative overflow-hidden dark:bg-[#09111f] bg-[#0e1a2e]" style="min-height: 680px;">

    {{-- Kuwait Towers background --}}
    <div class="absolute inset-0 z-0 pointer-events-none">
        <img src="{{ asset('kuwait-towers.webp') }}" alt=""
             class="w-full h-full object-cover object-center opacity-50"
             onerror="this.style.display='none'">
        {{-- Heavy dark overlay on the right (content side) — both modes --}}
        <div class="absolute inset-0"
             style="background: linear-gradient(to left, rgba(5,12,25,0.93) 0%, rgba(5,12,25,0.88) 35%, rgba(5,12,25,0.55) 58%, transparent 100%)"></div>
        {{-- Darken bottom for readability --}}
        <div class="absolute inset-0"
             style="background: linear-gradient(to top, rgba(5,12,25,0.80) 0%, transparent 50%)"></div>
        {{-- Extra subtle tint on left (photo side) so photo stands out --}}
        <div class="absolute inset-0"
             style="background: linear-gradient(to right, rgba(5,12,25,0.55) 0%, transparent 45%)"></div>
    </div>

    {{-- Red glow bottom --}}
    <div class="absolute bottom-0 left-1/4 w-96 h-48 pointer-events-none" style="background: radial-gradient(ellipse, rgba(176,65,65,0.18) 0%, transparent 70%); filter: blur(40px);"></div>

    {{-- ══ Dr. Photo: anchored bottom-left (absolute) ══ --}}
    <div class="{{ app()->getLocale() == 'ar' ? 'left-0' : 'right-0' }} absolute bottom-0 z-10 pointer-events-none"
         style="width: clamp(260px, 42vw, 560px);">
        <img src="{{ asset('courses-img/dr-tariq.png') }}"
             alt="{{ app()->getLocale() == 'ar' ? 'أ.د طارق الحبيب' : 'Prof. Dr. Tariq Al-Habib' }}"
             class="w-full h-auto object-contain object-bottom drop-shadow-[0_0_80px_rgba(176,65,65,0.45)]"
             style="max-height: 680px;">
        {{-- fade bottom of photo into section bg --}}
        <div class="absolute bottom-0 inset-x-0 h-24" style="background: linear-gradient(to top, rgba(13,6,6,1) 0%, transparent 100%)"></div>
    </div>

    {{-- ══ Content: right column (or left for EN) ══ --}}
    <div class="relative z-20 container mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 lg:py-20 text-white">
        <div class="flex {{ app()->getLocale() == 'ar' ? 'justify-end' : 'justify-start' }}">
            <div class="w-full sm:w-[80%] lg:w-[58%] xl:w-[54%]"
                 dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}"
                 style="{{ app()->getLocale() == 'ar' ? 'text-align: right;' : 'text-align: left;' }} text-shadow: 0 2px 10px rgba(0,0,0,0.85);">


                {{-- Logo row --}}
                <div class="flex items-center {{ app()->getLocale() == 'ar' ? 'justify-end' : 'justify-start' }} gap-2.5 mb-7">
                    <img src="{{ asset('image.png') }}" alt="مطمئنة" class="h-6 brightness-0 invert opacity-60">
                    <div class="w-px h-4 bg-white/15"></div>
                    <img src="{{ asset('deema-logo.png') }}" alt="deema" class="h-6 brightness-0 invert opacity-50">
                </div>

                {{-- يتواجد --}}
                <p class="text-white/55 text-base sm:text-lg font-bold mb-2 tracking-wider">
                    {{ app()->getLocale() == 'ar' ? 'يتواجد' : 'Now Present' }}
                </p>

                {{-- Name in red box --}}
                <div class="inline-block mb-3" style="background: rgba(176,65,65,0.82); border-radius: 8px; padding: 8px 20px;">
                    <h2 class="text-white font-black leading-tight" style="font-size: clamp(1.6rem, 4vw, 2.8rem);">
                        {{ app()->getLocale() == 'ar' ? 'أ.د. طارق الحبيب' : 'Prof. Dr. Tariq Al-Habib' }}
                    </h2>
                </div>

                {{-- في مركز مطمئنة --}}
                <p class="text-white/70 text-base sm:text-lg font-bold mb-7">
                    {{ app()->getLocale() == 'ar' ? 'في مركز مطمئنة - الكويت' : 'at Motmaena Center - Kuwait' }}
                </p>

                {{-- خلال شهر stamp + مايو 2026 --}}
                <div class="flex items-center gap-4 mb-7">
                    <div class="shrink-0 w-[52px] h-[52px] rounded-full flex flex-col items-center justify-center border border-white/40"
                         style="background: rgba(255,255,255,0.08); backdrop-filter: blur(6px);">
                        <span class="text-white/80 text-[9px] font-bold leading-none">خلال</span>
                        <span class="text-white/80 text-[9px] font-bold leading-none mt-0.5">شهر</span>
                    </div>
                    <div class="flex items-baseline gap-2">
                        <span class="text-white font-black leading-none" style="font-size: clamp(2.2rem, 5vw, 3.5rem);">{{ app()->getLocale() == 'ar' ? 'مايو' : 'May' }}</span>
                        <span class="text-white/55 font-bold leading-none" style="font-size: clamp(1.3rem, 3vw, 2rem);">2026</span>
                    </div>
                </div>

                {{-- Date cards --}}
                @php
                    $visitDates = [
                        13 => ['ar' => 'الأربعاء', 'en' => 'Wednesday'],
                        12 => ['ar' => 'الثلاثاء', 'en' => 'Tuesday'],
                    ];
                @endphp
                <div class="flex items-start gap-5 mb-7">
                    @foreach($visitDates as $date => $day)
                    <div class="text-center">
                        <div class="text-white/40 text-[10px] font-black uppercase tracking-widest leading-none mb-0.5">May</div>
                        <div class="text-white font-black leading-none" style="font-size: clamp(2.8rem, 6vw, 4rem);">{{ $date }}</div>
                        <div class="text-white/55 text-sm font-bold mt-0.5">{{ app()->getLocale() == 'ar' ? $day['ar'] : $day['en'] }}</div>
                    </div>
                    @if($date === 13)
                    <div class="w-px bg-white/15 self-stretch my-1"></div>
                    @endif
                    @endforeach
                </div>

                {{-- Consultation line --}}
                <div class="{{ app()->getLocale() == 'ar' ? 'border-r-[3px] pr-4' : 'border-l-[3px] pl-4' }} border-primary mb-7">
                    <p class="text-white/80 text-base sm:text-lg font-bold leading-snug">
                        {{ app()->getLocale() == 'ar' ? 'لتقديم الاستشارات الحياتية' : 'Offering life consultations' }}
                    </p>
                    <p class="text-white text-lg sm:text-xl font-black leading-snug">
                        {{ app()->getLocale() == 'ar' ? 'والتربوية والاجتماعية' : 'Educational & Social' }}
                    </p>
                </div>

                {{-- Contact + CTA --}}
                <div class="border-t border-white/[0.12] pt-5 flex flex-wrap items-center gap-x-8 gap-y-4">
                    <div>
                        <div class="text-white/35 text-[10px] uppercase tracking-widest font-bold mb-1">{{ app()->getLocale() == 'ar' ? 'للتواصل والاستفسار' : 'Contact' }}</div>
                        <div class="text-white font-black text-sm leading-snug" dir="ltr">+965 556 651 61</div>
                        <div class="text-white/55 font-semibold text-sm leading-snug" dir="ltr">+965 998 801 40</div>
                        <div class="flex items-center gap-1.5 mt-1">
                            <svg class="w-3 h-3 text-primary/60 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span class="text-white/35 text-xs">{{ app()->getLocale() == 'ar' ? 'الكويت - برج أحمد - بجوار المستشفى الأميري' : 'Kuwait - Burj Ahmed - near Al-Amiri Hospital' }}</span>
                        </div>
                    </div>
                    <a href="https://wa.me/96555665161" target="_blank"
                       class="inline-flex items-center gap-2 font-black text-sm px-5 py-3 rounded-xl transition-all duration-300 hover:-translate-y-0.5 active:scale-95 whitespace-nowrap"
                       style="background: rgba(255,255,255,0.11); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.16); color: #fff;">
                        <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.72.937 3.658 1.43 5.623 1.43h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        {{ app()->getLocale() == 'ar' ? 'احجز الآن' : 'Book Now' }}
                    </a>
                </div>

            </div>
        </div>
    </div>
</section>
{{-- ════════════════ TRAINING COURSES SECTION ════════════════ --}}
<section id="training" class="py-12 sm:py-20 md:py-24 bg-gray-50 dark:bg-[#0d0d0d] relative overflow-hidden">

    {{-- Background decoration --}}
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-0 {{ app()->getLocale() == 'ar' ? 'left-0' : 'right-0' }} w-[400px] h-[400px] bg-primary/[0.04] rounded-full blur-3xl -translate-y-1/2"></div>
        <div class="absolute bottom-0 {{ app()->getLocale() == 'ar' ? 'right-0' : 'left-0' }} w-[300px] h-[300px] bg-primary/[0.03] rounded-full blur-3xl translate-y-1/2"></div>
    </div>

    <div class="container mx-auto px-4 sm:px-6 relative z-10">
        <div class="flex flex-col lg:flex-row items-center gap-8 lg:gap-16">

            {{-- IMAGE SIDE — hidden on mobile, shown on lg+ --}}
            <div class="hidden lg:flex w-full lg:w-2/5 justify-center relative">
                <div class="relative w-full max-w-[360px]">
                    <div class="absolute inset-x-6 bottom-0 top-8 bg-gradient-to-b from-primary/10 to-primary/[0.03] dark:from-primary/20 dark:to-primary/[0.05] rounded-[2.5rem] border border-primary/10 dark:border-primary/15"></div>

                    {{-- In-person badge --}}
                    <div class="absolute top-4 {{ app()->getLocale() == 'ar' ? 'right-2' : 'left-2' }} z-20">
                        <div class="flex items-center gap-2 bg-primary text-white text-xs font-black px-3 py-1.5 rounded-full shadow-lg">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            {{ app()->getLocale() == 'ar' ? 'حضوري' : 'In-Person' }}
                        </div>
                    </div>

                    {{-- Dr. Photo --}}
                    <div class="relative z-10 pt-12 px-6 pb-0">
                        <img src="{{ asset('courses-img/dr-tariq.png') }}"
                             alt="{{ app()->getLocale() == 'ar' ? 'أ.د طارق الحبيب' : 'Prof. Dr. Tariq Al-Habib' }}"
                             class="w-full h-auto object-contain drop-shadow-[0_30px_60px_rgba(176,65,65,0.2)] dark:drop-shadow-[0_30px_60px_rgba(176,65,65,0.35)]">
                    </div>

                    {{-- Floating: certificate --}}
                    <div class="absolute bottom-10 {{ app()->getLocale() == 'ar' ? 'left-0 xl:-left-4' : 'right-0 xl:-right-4' }} z-20 animate-float" style="animation-delay:0.8s">
                        <div class="bg-white dark:bg-white/10 border border-gray-100 dark:border-white/20 backdrop-blur-xl px-4 py-3 rounded-2xl shadow-lg max-w-[140px]">
                            <div class="flex items-start gap-2">
                                <div class="w-7 h-7 bg-green-50 dark:bg-green-500/20 rounded-lg flex items-center justify-center shrink-0 mt-0.5">
                                    <svg class="w-4 h-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <div>
                                    <div class="text-[10px] font-black leading-tight text-gray-900 dark:text-gray-100">{{ app()->getLocale() == 'ar' ? 'شهادة معتمدة' : 'Certified' }}</div>
                                    <div class="text-[9px] font-medium mt-0.5 leading-tight text-gray-500 dark:text-gray-400">{{ app()->getLocale() == 'ar' ? 'ديوان الخدمة المدنية' : 'Civil Service Bureau' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Floating: time --}}
                    <div class="absolute top-10 {{ app()->getLocale() == 'ar' ? 'left-0 xl:-left-2' : 'right-0 xl:-right-2' }} z-20 animate-float" style="animation-delay:1.3s">
                        <div class="bg-gradient-to-br from-primary to-[#8a2f2f] px-4 py-2.5 rounded-xl shadow-[0_10px_30px_-8px_rgba(176,65,65,0.5)] border border-white/10">
                            <div class="text-white text-[10px] font-black opacity-70">{{ app()->getLocale() == 'ar' ? 'الوقت' : 'Time' }}</div>
                            <div class="text-white text-xs font-black" dir="ltr">07:00 – 09:00م</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CONTENT SIDE --}}
            <div class="w-full lg:w-3/5 {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

                {{-- Mobile: Dr photo strip --}}
                <div class="flex lg:hidden items-center gap-4 mb-6 p-4 rounded-2xl border-2 border-primary/20" style="background: linear-gradient(135deg, rgba(176,65,65,0.06) 0%, rgba(176,65,65,0.02) 100%);">
                    <img src="{{ asset('courses-img/dr-tariq.png') }}"
                         alt="{{ app()->getLocale() == 'ar' ? 'أ.د طارق الحبيب' : 'Prof. Dr. Tariq Al-Habib' }}"
                         class="w-20 h-24 object-contain object-bottom shrink-0 drop-shadow-md">
                    <div class="flex-1 min-w-0">
                        <div class="inline-flex items-center gap-1.5 bg-primary text-white text-[10px] font-black px-2.5 py-1 rounded-full mb-2 shadow-sm">
                            <svg class="w-3 h-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            {{ app()->getLocale() == 'ar' ? 'حضوري' : 'In-Person' }}
                        </div>
                        <p class="text-primary font-black text-lg leading-tight">{{ app()->getLocale() == 'ar' ? 'أ.د. طارق الحبيب' : 'Prof. Dr. Tariq' }}</p>
                        <p class="text-xs font-medium mt-0.5 text-gray-500 dark:text-gray-400">{{ app()->getLocale() == 'ar' ? 'بروفسور وخبير الإرشاد الاجتماعي والتربوي وتنمية المهارات الحياتية' : 'Prof. & Social Guidance Expert' }}</p>
                        <div class="flex items-center gap-1.5 mt-2">
                            <svg class="w-3 h-3 text-primary shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span class="text-[11px] font-bold text-gray-600 dark:text-gray-300" dir="ltr">07:00 – 09:00م</span>
                        </div>
                    </div>
                </div>

                {{-- Badge --}}
                <div class="inline-flex items-center gap-2 border border-primary/35 bg-primary/[0.07] px-4 py-1.5 rounded-full mb-4">
                    <span class="w-1.5 h-1.5 bg-primary rounded-full animate-pulse"></span>
                    <span class="text-primary text-[11px] font-black tracking-[0.2em] uppercase">{{ app()->getLocale() == 'ar' ? 'دورات تدريبية' : 'Training Courses' }}</span>
                </div>

                {{-- Title --}}
                <h2 class="text-3xl sm:text-4xl lg:text-[3rem] font-black leading-[1.1] mb-2 text-gray-900 dark:text-gray-100">
                    {{ app()->getLocale() == 'ar' ? 'الدورات التدريبية' : 'Training Courses' }}
                </h2>

                {{-- Dr. Name & Title — desktop only --}}
                <p class="hidden lg:block text-primary font-black text-xl sm:text-2xl mb-1">{{ app()->getLocale() == 'ar' ? 'أ.د. طارق الحبيب' : 'Prof. Dr. Tariq Al-Habib' }}</p>
                <p class="hidden lg:block text-sm font-medium mb-6 text-gray-500 dark:text-gray-400">{{ app()->getLocale() == 'ar' ? 'بروفسور وخبير الإرشاد الاجتماعي والتربوي وتنمية المهارات الحياتية' : 'Professor & Social, Educational Guidance Expert' }}</p>
                <div class="block lg:hidden mb-6"></div>

                {{-- Courses — mobile: cards / desktop: table --}}

                {{-- MOBILE CARDS --}}
                <div class="flex flex-col gap-3 sm:hidden mb-6">
                    @php $courses = [
                        ['name_ar' => 'مهارات حل المشكلات', 'name_en' => 'Problem Solving Skills', 'date_ar' => '13 مايو 2026', 'date_en' => 'May 13, 2026', 'time_ar' => '7–9 م', 'time_en' => '7–9 PM'],
                    ]; @endphp
                    @foreach($courses as $c)
                    <div class="rounded-2xl border border-gray-200 dark:border-white/[0.12] p-4 bg-white dark:bg-white/[0.06]">
                        <div class="font-black text-sm mb-2 text-gray-900 dark:text-gray-100">{{ app()->getLocale() == 'ar' ? $c['name_ar'] : $c['name_en'] }}</div>
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="text-[11px] font-medium px-2 py-0.5 rounded-full bg-gray-100 dark:bg-white/10 text-gray-500 dark:text-gray-400">{{ app()->getLocale() == 'ar' ? 'الأربعاء' : 'Wed' }}</span>
                            <span class="text-primary font-black text-[11px]">{{ app()->getLocale() == 'ar' ? $c['date_ar'] : $c['date_en'] }}</span>
                            <span class="ms-auto font-black text-sm text-gray-900 dark:text-gray-100">{{ app()->getLocale() == 'ar' ? '30 د.ك' : '30 KWD' }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- DESKTOP TABLE --}}
                <div class="hidden sm:block mb-6 rounded-2xl overflow-hidden border border-gray-200 dark:border-white/[0.12] shadow-sm">
                    <div class="flex bg-primary text-white text-xs font-black px-4 py-3 gap-3">
                        <div class="flex-1 {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }}">{{ app()->getLocale() == 'ar' ? 'المحاضرة' : 'Course' }}</div>
                        <div class="w-20 text-center shrink-0">{{ app()->getLocale() == 'ar' ? 'اليوم' : 'Day' }}</div>
                        <div class="w-28 text-center shrink-0">{{ app()->getLocale() == 'ar' ? 'التاريخ' : 'Date' }}</div>
                        <div class="w-20 text-center shrink-0">{{ app()->getLocale() == 'ar' ? 'السعر' : 'Price' }}</div>
                    </div>
                    <div class="flex px-4 py-4 gap-3 items-center bg-white dark:bg-white/[0.06]">
                        <div class="flex-1 {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }} font-bold text-sm text-gray-900 dark:text-gray-100">{{ app()->getLocale() == 'ar' ? 'مهارات حل المشكلات' : 'Problem Solving Skills' }}</div>
                        <div class="w-20 text-center text-xs font-medium shrink-0 text-gray-500 dark:text-gray-400">{{ app()->getLocale() == 'ar' ? 'الأربعاء' : 'Wed' }}</div>
                        <div class="w-28 text-center text-primary font-black text-xs shrink-0">{{ app()->getLocale() == 'ar' ? '13 مايو 2026' : 'May 13, 2026' }}</div>
                        <div class="w-20 text-center font-black text-xs shrink-0 text-gray-900 dark:text-gray-100">{{ app()->getLocale() == 'ar' ? '30 د.ك' : '30 KWD' }}</div>
                    </div>
                </div>

                {{-- Course Topics --}}
                <div class="mb-5 bg-gray-50 dark:bg-white/[0.04] border border-gray-200 dark:border-white/[0.08] rounded-2xl px-5 py-4">
                    <div class="text-xs font-black uppercase tracking-widest text-primary mb-3">{{ app()->getLocale() == 'ar' ? 'المحاور' : 'Topics' }}</div>
                    <ul class="space-y-2">
                        @foreach([
                            ['ar'=>'مفهوم حل المشكلات','en'=>'Understanding Problem Solving'],
                            ['ar'=>'الأركان الأساسية لحل المشكلات','en'=>'Core Pillars of Problem Solving'],
                            ['ar'=>'تصنيف المشكلات وأنواعها','en'=>'Types & Classification of Problems'],
                            ['ar'=>'استراتيجيات حل المشكلات','en'=>'Problem Solving Strategies'],
                            ['ar'=>'خطوات ومراحل حل المشكلات','en'=>'Steps & Stages of Problem Solving'],
                        ] as $topic)
                        <li class="flex items-center gap-2.5 text-sm font-medium text-gray-700 dark:text-gray-300">
                            <span class="w-1.5 h-1.5 rounded-full bg-primary shrink-0"></span>
                            {{ app()->getLocale() == 'ar' ? $topic['ar'] : $topic['en'] }}
                        </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Price + Deema + Certificate --}}
                <div class="mb-5 rounded-2xl overflow-hidden border border-primary/20 shadow-sm">
                    {{-- Price row --}}
                    <div class="flex items-center gap-3 sm:gap-4 px-4 sm:px-5 py-4 bg-white dark:bg-white/[0.06]">
                        <div class="flex-1 min-w-0">
                            <div class="text-xs font-bold mb-1 text-gray-500 dark:text-gray-400">{{ app()->getLocale() == 'ar' ? 'رسوم الاشتراك' : 'Registration Fee' }}</div>
                            <div class="flex items-baseline gap-2">
                                <span class="text-primary font-black text-2xl sm:text-3xl">{{ app()->getLocale() == 'ar' ? '30 دينار' : '30 KWD' }}</span>
                            </div>
                        </div>
                        {{-- Deema --}}
                        <div class="shrink-0 text-center border border-blue-200 dark:border-blue-400/30 rounded-xl px-3 py-2 bg-blue-50 dark:bg-blue-900/20">
                            <div class="text-blue-700 dark:text-blue-300 font-black text-[11px]">{{ app()->getLocale() == 'ar' ? 'قسط على' : 'Pay in' }}</div>
                            <div class="text-blue-700 dark:text-blue-300 font-black text-lg leading-none">4</div>
                            <div class="text-blue-600 dark:text-blue-400 font-black text-[10px]">{{ app()->getLocale() == 'ar' ? 'دفعات' : 'Payments' }}</div>
                            <div class="text-blue-500 font-black text-[9px] mt-0.5">deema</div>
                        </div>
                    </div>
                    {{-- Certificate row --}}
                    <div class="flex items-center gap-3 px-4 sm:px-5 py-3 bg-green-50 dark:bg-green-900/10 border-t border-green-100 dark:border-green-400/10">
                        <svg class="w-4 h-4 text-green-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                        <span class="text-xs font-bold text-green-700 dark:text-green-400">{{ app()->getLocale() == 'ar' ? 'شهادة معتمدة من ديوان الخدمة المدنية والتطبيقي' : 'Certificate accredited by Civil Service Bureau' }}</span>
                    </div>
                </div>

                {{-- CTA --}}
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 sm:gap-4">
                    <a href="https://wa.me/96555665161" target="_blank"
                       class="group inline-flex items-center justify-center gap-3 text-white font-black text-base px-6 py-4 rounded-2xl transition-all duration-300 hover:-translate-y-1 active:scale-95"
                       style="background: linear-gradient(135deg, #c95050 0%, #b04141 50%, #8a2f2f 100%); box-shadow: 0 16px 40px -10px rgba(176,65,65,0.5);">
                        <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.72.937 3.658 1.43 5.623 1.43h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        {{ app()->getLocale() == 'ar' ? 'سجّل الآن بالواتساب' : 'Register via WhatsApp' }}
                    </a>
                    <div class="flex items-center gap-3">
                        <div class="w-px h-10 hidden sm:block bg-gray-200 dark:bg-white/[0.12]"></div>
                        <div>
                            <div class="text-[10px] uppercase tracking-widest font-bold text-gray-500 dark:text-gray-400">{{ app()->getLocale() == 'ar' ? 'للتواصل والاستفسار' : 'Contact' }}</div>
                            <div class="font-black text-sm mt-0.5 text-gray-900 dark:text-gray-100" dir="ltr">+965 998 801 40</div>
                        </div>
                    </div>
                </div>

                {{-- Location Strip --}}
                <div class="mt-6 pt-5 border-t border-gray-200 dark:border-white/[0.08] flex items-center gap-3">
                    <svg class="w-3.5 h-3.5 text-primary/50 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">{{ app()->getLocale() == 'ar' ? 'الكويت — برج أحمد، بجوار المستشفى الأميري' : 'Kuwait — Burj Ahmed, near Al-Amiri Hospital' }}</span>
                </div>

            </div>
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
                <div class="text-3xl sm:text-4xl lg:text-5xl font-black text-white mb-2" data-counter="15">0</div>
                <div class="w-10 h-1 bg-white/30 rounded-full mx-auto mb-2"></div>
                <div class="text-white/70 text-xs sm:text-sm font-medium">{{ app()->getLocale() == 'ar' ? 'سنة من التميز' : 'Years of Excellence' }}</div>
            </div>
            <div class="text-center reveal">
                <div class="text-3xl sm:text-4xl lg:text-5xl font-black text-white mb-2" data-counter="4.9" data-decimal="true">0</div>
                <div class="w-10 h-1 bg-white/30 rounded-full mx-auto mb-2"></div>
                <div class="text-white/70 text-xs sm:text-sm font-medium">{{ app()->getLocale() == 'ar' ? 'تقييم التطبيق' : 'App Rating' }}</div>
            </div>
        </div>
    </div>
</section>

{{-- ════════════════ TESTIMONIALS SECTION ════════════════ --}}
<section class="py-14 sm:py-20 md:py-24 bg-white dark:bg-dark-bg relative overflow-hidden">
    <div class="container mx-auto px-4">
        <div class="text-center mb-10 sm:mb-16 reveal">
            <span class="inline-block bg-primary/10 text-primary px-4 py-1.5 rounded-full text-[10px] sm:text-xs font-bold mb-5 tracking-widest uppercase">{{ app()->getLocale() == 'ar' ? 'آراء المتدربين' : 'Testimonials' }}</span>
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-black text-gray-900 dark:text-white mb-4">
                {{ app()->getLocale() == 'ar' ? 'ماذا يقول متدربونا؟' : 'What Our Trainees Say?' }}
            </h2>
            <p class="text-[var(--muted-color)] text-sm sm:text-base max-w-2xl mx-auto">{{ app()->getLocale() == 'ar' ? 'تجارب حقيقية من متدربين استفادوا من دوراتنا المتخصصة' : 'Real experiences from trainees who benefited from our courses' }}</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6 lg:gap-8">
            {{-- Testimonial 1 --}}
            <div class="card-premium p-6 sm:p-8 hover:-translate-y-2 reveal" style="transition-delay: 0.1s">
                <div class="flex items-center gap-1 mb-4">
                    @for($i = 0; $i < 5; $i++)
                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    @endfor
                </div>
                <p class="text-[var(--muted-color)] text-sm leading-relaxed mb-6">{{ app()->getLocale() == 'ar' ? '"دورة الذكاء العاطفي غيرت حياتي بالكامل! أصبحت أفهم مشاعري ومشاعر من حولي بشكل أعمق. شكراً للدكتور طارق على هذا المحتوى الرائع."' : '"The Emotional Intelligence course completely changed my life! I now understand my emotions and those around me much better. Thank you Dr. Tariq for this wonderful content."' }}</p>
                <div class="flex items-center gap-3 pt-4 border-t border-gray-100 dark:border-dark-border">
                    <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center text-primary font-bold text-sm">ن.ع</div>
                    <div>
                        <div class="text-sm font-bold text-gray-900 dark:text-white">{{ app()->getLocale() == 'ar' ? 'نورة العتيبي' : 'Noura Al-Otaibi' }}</div>
                        <div class="text-xs text-[var(--muted-color)]">{{ app()->getLocale() == 'ar' ? 'الكويت' : 'Kuwait' }}</div>
                    </div>
                </div>
            </div>
            {{-- Testimonial 2 --}}
            <div class="card-premium p-6 sm:p-8 hover:-translate-y-2 reveal" style="transition-delay: 0.2s">
                <div class="flex items-center gap-1 mb-4">
                    @for($i = 0; $i < 5; $i++)
                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    @endfor
                </div>
                <p class="text-[var(--muted-color)] text-sm leading-relaxed mb-6">{{ app()->getLocale() == 'ar' ? '"محتوى علمي ممتاز ومبني على أسس أكاديمية قوية. الدكتور طارق يقدم المعلومات بأسلوب مبسط وعملي. أنصح الجميع بالتسجيل في دوراته."' : '"Excellent scientific content built on strong academic foundations. Dr. Tariq presents information in a simple and practical way. I recommend everyone to enroll in his courses."' }}</p>
                <div class="flex items-center gap-3 pt-4 border-t border-gray-100 dark:border-dark-border">
                    <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center text-primary font-bold text-sm">م.ا</div>
                    <div>
                        <div class="text-sm font-bold text-gray-900 dark:text-white">{{ app()->getLocale() == 'ar' ? 'محمد الأحمدي' : 'Mohammed Al-Ahmadi' }}</div>
                        <div class="text-xs text-[var(--muted-color)]">{{ app()->getLocale() == 'ar' ? 'السعودية' : 'Saudi Arabia' }}</div>
                    </div>
                </div>
            </div>
            {{-- Testimonial 3 --}}
            <div class="card-premium p-6 sm:p-8 hover:-translate-y-2 reveal" style="transition-delay: 0.3s">
                <div class="flex items-center gap-1 mb-4">
                    @for($i = 0; $i < 5; $i++)
                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    @endfor
                </div>
                <p class="text-[var(--muted-color)] text-sm leading-relaxed mb-6">{{ app()->getLocale() == 'ar' ? '"دورة فنون تربية الأطفال كانت نقطة تحول في تعاملي مع أطفالي. تعلمت أساليب تربوية فعالة ومبنية على أسس تربوية علمية. شكراً مطمئنة!"' : '"The Parenting course was a turning point in dealing with my children. I learned effective parenting methods based on scientific educational foundations. Thank you Motmaena!"' }}</p>
                <div class="flex items-center gap-3 pt-4 border-t border-gray-100 dark:border-dark-border">
                    <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center text-primary font-bold text-sm">س.م</div>
                    <div>
                        <div class="text-sm font-bold text-gray-900 dark:text-white">{{ app()->getLocale() == 'ar' ? 'سارة المطيري' : 'Sara Al-Mutairi' }}</div>
                        <div class="text-xs text-[var(--muted-color)]">{{ app()->getLocale() == 'ar' ? 'الإمارات' : 'UAE' }}</div>
                    </div>
                </div>
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
