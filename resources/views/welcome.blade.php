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
                <a href="#" class="btn-outline dark:bg-transparent dark:text-white dark:border-white/20 text-sm sm:text-base px-6 sm:px-10 py-3 sm:py-4 text-center bg-white">
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
                                {{ app()->getLocale() == 'ar' ? 'استشاري الطب النفسي' : 'Consultant Psychiatrist' }}
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
                        <p class="text-white/70 text-sm">{{ app()->getLocale() == 'ar' ? 'استشاري الطب النفسي' : 'Consultant Psychiatrist' }}</p>
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
                    {{ app()->getLocale() == 'ar' ? 'مركز مطمئنة للاستشارات النفسية' : 'Motmaena Center for Psychological Counseling' }}
                </h2>
                <p class="text-[var(--muted-color)] text-sm sm:text-base leading-relaxed mb-6">
                    {{ app()->getLocale() == 'ar' ? 'مركز مطمئنة هو مركز متخصص في الاستشارات والدورات النفسية تحت إشراف البروفيسور طارق الحبيب، أحد أبرز الأطباء النفسيين في العالم العربي. يقدم المركز دورات حصرية ومسجلة تساعدك على تطوير صحتك النفسية وبناء علاقات أفضل.' : 'Motmaena Center is a specialized center for psychological counseling and courses under the supervision of Professor Tariq Al-Habib, one of the most prominent psychiatrists in the Arab world. The center offers exclusive recorded courses to help you develop your mental health and build better relationships.' }}
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
                <p class="text-[var(--muted-color)] text-sm leading-relaxed mb-6">{{ app()->getLocale() == 'ar' ? '"دورة فنون تربية الأطفال كانت نقطة تحول في تعاملي مع أطفالي. تعلمت أساليب تربوية فعالة ومبنية على أسس نفسية علمية. شكراً مطمئنة!"' : '"The Parenting course was a turning point in dealing with my children. I learned effective parenting methods based on scientific psychological foundations. Thank you Motmaena!"' }}</p>
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
                    <p class="px-5 sm:px-6 pb-5 sm:pb-6 text-[var(--muted-color)] text-sm leading-relaxed">{{ app()->getLocale() == 'ar' ? 'يمكنك التسجيل عبر الموقع الإلكتروني أو من خلال تطبيق مطمئنة المتاح على App Store و Google Play. اختر الدورة المناسبة لك واضغط على "سجل الآن" لإتمام عملية التسجيل والدفع.' : 'You can register through the website or the Motmaena app on App Store and Google Play. Choose your course and click "Register Now" to complete registration and payment.' }}</p>
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

{{-- ════════════════ APP SECTION ════════════════ --}}
<section id="app-section" class="py-14 sm:py-20 md:py-24 bg-secondary dark:bg-dark-surface overflow-hidden">
    <div class="container mx-auto px-4">
        <div class="bg-primary rounded-3xl sm:rounded-[2.5rem] lg:rounded-[3rem] p-6 sm:p-10 lg:p-20 flex flex-col lg:flex-row items-center gap-8 lg:gap-16 relative shadow-2xl overflow-hidden reveal">

            {{-- Decorative blobs --}}
            <div class="absolute top-0 right-0 w-72 sm:w-96 h-72 sm:h-96 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/2 blur-3xl pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-48 sm:w-64 h-48 sm:h-64 bg-black/10 rounded-full translate-y-1/2 -translate-x-1/2 blur-2xl pointer-events-none"></div>
            <div class="absolute inset-0 opacity-[0.04] pointer-events-none" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 28px 28px;"></div>

            {{-- Text Content --}}
            <div class="w-full lg:w-3/5 text-white z-10 {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }} reveal-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}">
                <span class="inline-block bg-white/20 backdrop-blur px-4 py-1.5 rounded-full text-[10px] sm:text-xs font-bold mb-5 sm:mb-8 tracking-widest border border-white/10 uppercase">
                    {{ __('Available now') }}
                </span>
                <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-6xl font-black mb-4 sm:mb-8 leading-tight">{{ __('Motmaena in your pocket') }}</h2>
                <p class="text-sm sm:text-base lg:text-lg opacity-80 mb-7 sm:mb-12 leading-relaxed max-w-xl">{{ __('We are here to facilitate access') }}</p>

                {{-- Store Buttons --}}
                <div class="flex flex-wrap gap-3 sm:gap-4">
                    <a href="https://apps.apple.com/us/app/motmaina-%D9%85%D8%B7%D9%85%D8%A6%D9%86%D8%A9/id6477853064" target="_blank"
                       class="flex items-center gap-2.5 sm:gap-3 bg-white text-gray-900 px-4 sm:px-7 py-2.5 sm:py-4 rounded-xl sm:rounded-2xl font-bold hover:bg-gray-100 transition-all duration-300 hover:-translate-y-1 shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 sm:h-7 w-5 sm:w-7 shrink-0" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.8-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/>
                        </svg>
                        <div class="{{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }}">
                            <div class="text-[9px] sm:text-[10px] opacity-60 uppercase tracking-wide leading-none mb-0.5">Download on the</div>
                            <div class="text-sm sm:text-base font-black leading-none">App Store</div>
                        </div>
                    </a>
                    <a href="https://play.google.com/store/apps/details?id=com.motmaena_app&hl=ar" target="_blank"
                       class="flex items-center gap-2.5 sm:gap-3 bg-white/15 backdrop-blur text-white border border-white/25 px-4 sm:px-7 py-2.5 sm:py-4 rounded-xl sm:rounded-2xl font-bold hover:bg-white/25 transition-all duration-300 hover:-translate-y-1 shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 sm:h-7 w-5 sm:w-7 shrink-0" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M3.18 23.76c.3.17.66.19.99.08l12.45-7.19-2.79-2.79-10.65 9.9zm-1.68-19.6C1.2 4.53 1 5.12 1 5.73v12.54c0 .61.2 1.2.5 1.57l.08.08 7.03-7.03v-.17L1.5 5.7l-.01.06zM20.24 9.2l-2.56-1.48-3.12 3.12 3.12 3.12 2.59-1.49c.74-.43.74-1.83-.03-2.27zM4.17.32L16.62 7.5l-2.79 2.79L1.18.39C1.51.19 1.87.17 2.2.28l1.97 1.04z"/>
                        </svg>
                        <div class="{{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }}">
                            <div class="text-[9px] sm:text-[10px] opacity-60 uppercase tracking-wide leading-none mb-0.5">Get it on</div>
                            <div class="text-sm sm:text-base font-black leading-none">Google Play</div>
                        </div>
                    </a>
                </div>
            </div>

            {{-- Phone Mockup – desktop only --}}
            <div class="hidden lg:block lg:w-2/5 relative reveal-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}" style="transition-delay: 0.3s;">
                <div class="relative z-10 flex justify-center animate-float" style="animation-delay: 0.5s;">
                    <div class="relative w-52 md:w-60 rounded-[3rem] overflow-hidden border-[8px] border-gray-900 shadow-[0_50px_100px_-20px_rgba(0,0,0,0.6)] -rotate-3 hover:rotate-0 transition-all duration-700"
                        style="aspect-ratio: 9/19.5;">
                        <div class="w-full h-full flex flex-col">
                            <div class="flex-none h-[38%] bg-primary-dark relative flex items-center justify-center overflow-hidden">
                                <div class="absolute inset-0 bg-gradient-to-br from-primary/60 to-primary-dark"></div>
                                <span class="relative text-white/15 text-7xl font-black select-none leading-none">م</span>
                            </div>
                            <div class="flex-1 bg-white flex items-center justify-center px-5 py-4">
                                <img src="{{ asset('logo-clinic.png') }}" alt="{{ __('Motmaena Center') }}" class="w-full object-contain">
                            </div>
                        </div>
                        <div class="absolute top-2.5 left-1/2 -translate-x-1/2 w-14 h-4 bg-gray-900 rounded-full z-20"></div>
                        <div class="absolute bottom-1.5 left-1/2 -translate-x-1/2 w-10 h-1 bg-gray-400/40 rounded-full z-20"></div>
                        <div class="absolute inset-0 bg-gradient-to-br from-white/8 via-transparent to-transparent pointer-events-none z-10"></div>
                    </div>
                    <div class="absolute -top-5 {{ app()->getLocale() == 'ar' ? '-right-5 lg:-right-8' : '-left-5 lg:-left-8' }} bg-white p-3.5 rounded-2xl shadow-xl border border-gray-100 animate-bounce">
                        <div class="bg-primary/10 p-1.5 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
