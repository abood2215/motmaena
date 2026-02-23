@extends('layouts.app')

@section('title', __('Welcome') . ' - ' . __('Motmaena Center'))

@section('content')

{{-- ════════════════ HERO SECTION ════════════════ --}}
<section class="relative lg:min-h-[92vh] flex items-center bg-secondary dark:bg-dark-surface overflow-hidden border-b border-gray-100 dark:border-dark-border">

    {{-- Background Orbs --}}
    <div class="absolute top-0 {{ app()->getLocale() == 'ar' ? 'right-0' : 'left-0' }} w-1/2 h-full bg-gradient-to-b from-primary/5 to-transparent pointer-events-none"></div>
    <div class="absolute top-1/3 {{ app()->getLocale() == 'ar' ? 'right-1/3' : 'left-1/3' }} w-[400px] h-[400px] bg-primary/6 rounded-full blur-[120px] pointer-events-none animate-float" style="animation-duration: 8s;"></div>
    <div class="absolute -bottom-20 -left-10 w-[280px] h-[280px] bg-primary/4 rounded-full blur-[70px] pointer-events-none"></div>

    <div class="container mx-auto px-4 py-12 sm:py-16 lg:py-0 flex flex-col lg:flex-row items-center gap-10 lg:gap-16 relative z-10">

        {{-- ─── Text Content ─── --}}
        <div class="w-full lg:w-1/2 {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }}">

            {{-- Pill Badge --}}
            <div class="animate-blur-in" style="animation-delay: 0s;">
                <div class="inline-flex items-center gap-2 bg-white dark:bg-dark-border px-4 py-2 rounded-full shadow-sm mb-5 lg:mb-8 border border-primary/10">
                    <span class="w-2 h-2 bg-primary rounded-full animate-pulse shrink-0"></span>
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
                <a href="#courses" class="btn-motmaena text-sm sm:text-base px-6 sm:px-10 py-3 sm:py-4 text-center shadow-xl shadow-primary/30">
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
                    <div class="text-lg sm:text-2xl lg:text-3xl font-black text-gray-900 dark:text-white">50+</div>
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

        {{-- ─── Phone Mockup ─── --}}
        <div class="w-full lg:w-1/2 flex justify-center pb-10 sm:pb-14 lg:pb-0 animate-blur-in" style="animation-delay: 0.18s;">
            <div class="relative group animate-float">

                {{-- Glow ring --}}
                <div class="absolute -inset-4 sm:-inset-8 bg-gradient-to-tr from-primary to-primary-light rounded-[3rem] lg:rounded-[4rem] opacity-15 blur-[50px] sm:blur-[65px] group-hover:opacity-30 transition-all duration-1000 pointer-events-none"></div>

                {{-- Phone frame --}}
                <div class="relative w-44 sm:w-56 md:w-64 lg:w-72 rounded-[2.5rem] sm:rounded-[3rem] lg:rounded-[3.5rem] overflow-hidden border-[8px] sm:border-[10px] border-gray-900 dark:border-gray-700 shadow-[0_30px_60px_-10px_rgba(0,0,0,0.35)] sm:shadow-[0_50px_100px_-16px_rgba(0,0,0,0.45)] md:{{ app()->getLocale() == 'ar' ? 'rotate-2' : '-rotate-2' }} group-hover:rotate-0 transition-all duration-700"
                    style="aspect-ratio: 9/19.5;">
                    <div class="w-full h-full flex flex-col">
                        <div class="flex-none h-[38%] bg-primary relative flex items-center justify-center overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-br from-primary-light/40 to-primary-dark/60"></div>
                            <span class="relative text-white/15 text-6xl sm:text-8xl font-black select-none leading-none">م</span>
                        </div>
                        <div class="flex-1 bg-white dark:bg-dark-surface flex items-center justify-center px-5 sm:px-7 py-4">
                            <img src="{{ asset('logo-clinic.png') }}" alt="{{ __('Motmaena Center') }}" class="w-full max-w-[100px] sm:max-w-[140px] lg:max-w-[155px] object-contain">
                        </div>
                    </div>
                    {{-- Notch --}}
                    <div class="absolute top-2 sm:top-3 left-1/2 -translate-x-1/2 w-14 sm:w-20 h-4 sm:h-5 bg-gray-900 dark:bg-gray-800 rounded-full z-20"></div>
                    {{-- Home indicator --}}
                    <div class="absolute bottom-1.5 left-1/2 -translate-x-1/2 w-9 sm:w-12 h-1 bg-gray-400/40 rounded-full z-20"></div>
                    {{-- Screen glare --}}
                    <div class="absolute inset-0 bg-gradient-to-br from-white/8 via-transparent to-transparent pointer-events-none z-10"></div>
                </div>

                {{-- Floating badge – trainees (hidden on xs mobile) --}}
                <div class="hidden sm:flex absolute -bottom-6 {{ app()->getLocale() == 'ar' ? '-left-3 md:-left-10' : '-right-3 md:-right-10' }} glass-effect px-3 sm:px-4 py-2.5 sm:py-3 rounded-2xl shadow-2xl animate-blur-in" style="animation-delay: 0.9s;">
                    <div class="flex items-center gap-2 sm:gap-3">
                        <div class="w-8 sm:w-9 h-8 sm:h-9 bg-primary rounded-xl flex items-center justify-center text-white shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 sm:h-5 w-4 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-[9px] sm:text-[10px] text-primary font-bold uppercase tracking-wide">{{ __('Enroll now') }}</div>
                            <div class="text-xs sm:text-sm font-extrabold text-gray-900 dark:text-white">{{ __('100k+ Trainees') }}</div>
                        </div>
                    </div>
                </div>

                {{-- Floating badge – rating (hidden on xs mobile) --}}
                <div class="hidden sm:flex absolute -top-5 {{ app()->getLocale() == 'ar' ? '-right-3 md:-right-10' : '-left-3 md:-left-10' }} bg-white dark:bg-dark-surface px-3 sm:px-4 py-2.5 sm:py-3 rounded-2xl shadow-xl border border-gray-100 dark:border-dark-border animate-blur-in" style="animation-delay: 1.05s;">
                    <div class="flex items-center gap-2">
                        <span class="text-lg sm:text-xl leading-none">⭐</span>
                        <div>
                            <div class="text-[9px] sm:text-[10px] text-[var(--muted-color)] font-medium">{{ app()->getLocale() == 'ar' ? 'تقييم' : 'Rating' }}</div>
                            <div class="text-xs sm:text-sm font-black text-gray-900 dark:text-white">4.9 / 5</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

{{-- ════════════════ COURSES SECTION ════════════════ --}}
<section id="courses" class="py-14 sm:py-20 md:py-24 bg-white dark:bg-dark-bg relative overflow-hidden reveal">
    <livewire:course-grid />
</section>

{{-- ════════════════ APP SECTION ════════════════ --}}
<section class="py-14 sm:py-20 md:py-24 bg-secondary dark:bg-dark-surface overflow-hidden">
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
