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

{{-- ════════════════ SPECIAL EVENT: PREMIUM DR. TARIQ VISIT ════════════════ --}}
<section id="special-event" class="relative overflow-hidden bg-[#fdf4ef] dark:bg-[#0d0606]">

    {{-- ── Ambient Background Glows ── --}}
    <div class="absolute top-0 {{ app()->getLocale() == 'ar' ? 'right-0' : 'left-0' }} w-[700px] h-[700px] bg-primary/[0.06] dark:bg-primary/[0.22] rounded-full blur-[160px] -translate-y-1/2 translate-x-1/3 pointer-events-none"></div>
    <div class="absolute bottom-0 {{ app()->getLocale() == 'ar' ? 'left-0' : 'right-0' }} w-[500px] h-[500px] bg-primary/[0.04] dark:bg-primary/[0.14] rounded-full blur-[140px] translate-y-1/3 pointer-events-none"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[900px] h-[500px] bg-primary/[0.03] dark:bg-primary/[0.06] rounded-full blur-[120px] pointer-events-none"></div>

    {{-- ── Floating Particles (dark only) ── --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none hidden dark:block" aria-hidden="true">
        @foreach([['top-[15%]','left-[8%]','w-1','h-1','opacity-30','1s'],['top-[35%]','left-[3%]','w-0.5','h-0.5','opacity-20','2.5s'],['top-[65%]','left-[12%]','w-1','h-1','opacity-25','0.5s'],['top-[80%]','left-[5%]','w-0.5','h-0.5','opacity-15','3s'],['top-[20%]','right-[6%]','w-1','h-1','opacity-25','1.5s'],['top-[55%]','right-[4%]','w-0.5','h-0.5','opacity-20','0.8s'],['top-[75%]','right-[10%]','w-1','h-1','opacity-30','2s'],['top-[45%]','left-[50%]','w-0.5','h-0.5','opacity-10','1.2s']] as [$t,$s,$w,$h,$op,$del])
        <div class="absolute {{ $t }} {{ $s }} {{ $w }} {{ $h }} bg-primary rounded-full {{ $op }} animate-pulse" style="animation-delay:{{ $del }}"></div>
        @endforeach
    </div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24 lg:py-28 relative z-10">
        <div class="grid lg:grid-cols-[42%_58%] gap-8 lg:gap-12 xl:gap-20 items-center max-w-7xl mx-auto">

            {{-- ══════════ LEFT COLUMN: Dr. Photo with Islamic Arch ══════════ --}}
            <div class="relative flex justify-center {{ app()->getLocale() == 'ar' ? 'lg:order-1' : 'lg:order-2' }} reveal-scale">

                {{-- Outer rotating ring --}}
                <div class="absolute inset-8 rounded-full border border-primary/15 dark:border-primary/10 animate-[spin_25s_linear_infinite] pointer-events-none"></div>
                <div class="absolute inset-16 rounded-full border border-primary/8 dark:border-white/5 animate-[spin_18s_linear_infinite_reverse] pointer-events-none"></div>

                {{-- Glow behind arch --}}
                <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                    <div class="w-3/4 h-3/4 bg-primary/[0.07] dark:bg-primary/15 rounded-full blur-[60px]"></div>
                </div>

                {{-- Islamic Arch Container --}}
                <div class="relative w-[260px] sm:w-[320px] lg:w-[380px] xl:w-[420px]">

                    {{-- SVG Islamic Arch Frame --}}
                    <svg class="absolute inset-0 w-full h-[115%] -top-[7%] arch-svg-frame" viewBox="0 0 420 560" xmlns="http://www.w3.org/2000/svg" fill="none">
                        <path d="M210,18 C140,18 55,75 55,195 L55,430 Q55,468 88,485 L165,510 L210,522 L255,510 L332,485 Q365,468 365,430 L365,195 C365,75 280,18 210,18 Z"
                              fill="url(#archGrad)" stroke="url(#archStroke)" stroke-width="1.5" opacity="0.9"/>
                        <path d="M210,35 C148,35 72,87 72,198 L72,428 Q72,461 100,477 L170,501 L210,512 L250,501 L320,477 Q348,461 348,428 L348,198 C348,87 272,35 210,35 Z"
                              stroke="url(#archStroke2)" stroke-width="1" fill="none" opacity="0.5"/>
                        <path d="M210,4 L220,18 L210,32 L200,18 Z" fill="url(#diamondGrad)" filter="url(#glow)"/>
                        <path d="M210,10 L216,18 L210,26 L204,18 Z" fill="rgba(255,210,180,0.8)"/>
                        <circle cx="55" cy="200" r="5" fill="rgba(176,65,65,0.7)" filter="url(#glow)"/>
                        <circle cx="365" cy="200" r="5" fill="rgba(176,65,65,0.7)" filter="url(#glow)"/>
                        <circle cx="55" cy="320" r="3" fill="rgba(176,65,65,0.4)"/>
                        <circle cx="365" cy="320" r="3" fill="rgba(176,65,65,0.4)"/>
                        <circle cx="55" cy="420" r="2" fill="rgba(176,65,65,0.25)"/>
                        <circle cx="365" cy="420" r="2" fill="rgba(176,65,65,0.25)"/>
                        <circle cx="130" cy="55" r="1.5" fill="rgba(176,65,65,0.4)"/>
                        <circle cx="290" cy="55" r="1.5" fill="rgba(176,65,65,0.4)"/>
                        <circle cx="80" cy="120" r="1" fill="rgba(176,65,65,0.25)"/>
                        <circle cx="340" cy="120" r="1" fill="rgba(176,65,65,0.25)"/>
                        <defs>
                            <linearGradient id="archGrad" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="rgba(176,65,65,0.18)"/>
                                <stop offset="60%" stop-color="rgba(176,65,65,0.06)"/>
                                <stop offset="100%" stop-color="rgba(176,65,65,0.02)"/>
                            </linearGradient>
                            <linearGradient id="archStroke" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="rgba(176,65,65,0.9)"/>
                                <stop offset="50%" stop-color="rgba(176,65,65,0.5)"/>
                                <stop offset="100%" stop-color="rgba(176,65,65,0.1)"/>
                            </linearGradient>
                            <linearGradient id="archStroke2" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="rgba(176,65,65,0.35)"/>
                                <stop offset="100%" stop-color="rgba(176,65,65,0.03)"/>
                            </linearGradient>
                            <linearGradient id="diamondGrad" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="rgba(255,220,180,0.9)"/>
                                <stop offset="100%" stop-color="rgba(176,65,65,1)"/>
                            </linearGradient>
                            <filter id="glow" x="-50%" y="-50%" width="200%" height="200%">
                                <feGaussianBlur stdDeviation="3" result="blur"/>
                                <feMerge><feMergeNode in="blur"/><feMergeNode in="SourceGraphic"/></feMerge>
                            </filter>
                        </defs>
                    </svg>

                    {{-- Dr. Photo --}}
                    <div class="relative z-10 pt-10 px-6 pb-0">
                        <img src="{{ asset('courses-img/dr-tariq.png') }}"
                             alt="{{ app()->getLocale() == 'ar' ? 'أ.د طارق الحبيب' : 'Prof. Dr. Tariq Al-Habib' }}"
                             class="w-full h-auto object-contain object-bottom drop-shadow-[0_40px_80px_rgba(176,65,65,0.25)] dark:drop-shadow-[0_40px_80px_rgba(176,65,65,0.4)]">
                    </div>
                </div>

                {{-- Floating Badge: Years --}}
                <div class="absolute top-6 {{ app()->getLocale() == 'ar' ? 'right-0 lg:-right-2' : 'left-0 lg:-left-2' }} z-20 animate-float" style="animation-delay:0.4s">
                    <div class="bg-white dark:bg-white/10 border border-gray-100 dark:border-white/20 backdrop-blur-xl px-4 py-3 rounded-2xl shadow-lg dark:shadow-2xl">
                        <div class="flex items-center gap-2.5">
                            <div class="w-9 h-9 bg-primary/10 dark:bg-primary/20 rounded-xl flex items-center justify-center border border-primary/20 dark:border-primary/30">
                                <svg class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            </div>
                            <div>
                                <div class="text-gray-900 dark:text-white text-sm font-black leading-none">+30</div>
                                <div class="text-gray-400 dark:text-white/40 text-[10px] font-bold mt-0.5">{{ app()->getLocale() == 'ar' ? 'سنة خبرة' : 'Yrs. Exp.' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Floating Badge: Live --}}
                <div class="absolute bottom-12 {{ app()->getLocale() == 'ar' ? 'left-0 lg:-left-2' : 'right-0 lg:-right-2' }} z-20 animate-float" style="animation-delay:1s">
                    <div class="bg-gradient-to-br from-primary to-[#8a2f2f] px-5 py-3 rounded-2xl shadow-[0_15px_40px_-10px_rgba(176,65,65,0.55)] border border-white/10">
                        <div class="flex items-center gap-2">
                            <div class="relative">
                                <div class="w-2.5 h-2.5 bg-green-400 rounded-full"></div>
                                <div class="absolute inset-0 w-2.5 h-2.5 bg-green-400 rounded-full animate-ping opacity-60"></div>
                            </div>
                            <div class="text-white text-xs font-black whitespace-nowrap">{{ app()->getLocale() == 'ar' ? 'متاح ● مايو 2026' : 'Available ● May 2026' }}</div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- ══════════ RIGHT COLUMN: Content ══════════ --}}
            <div class="{{ app()->getLocale() == 'ar' ? 'text-right lg:order-2' : 'text-left lg:order-1' }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

                {{-- Branding Row --}}
                <div class="flex items-center {{ app()->getLocale() == 'ar' ? 'justify-end' : 'justify-start' }} gap-3 mb-8">
                    <img src="{{ asset('logo-clinic.png') }}" alt="مطمئنة" class="h-7 dark:brightness-[1.8] dark:opacity-80">
                    <div class="w-px h-5 bg-gray-200 dark:bg-white/15"></div>
                    <span class="text-[10px] font-black text-gray-400 dark:text-white/30 tracking-[0.35em] uppercase">Motmaena · Kuwait</span>
                </div>

                {{-- Badge --}}
                <div class="inline-flex items-center gap-2 border border-primary/35 bg-primary/[0.07] px-4 py-1.5 rounded-full mb-5">
                    <span class="w-1.5 h-1.5 bg-primary rounded-full animate-pulse"></span>
                    <span class="text-primary text-[11px] font-black tracking-[0.25em] uppercase">{{ app()->getLocale() == 'ar' ? 'زيارة حصرية' : 'Exclusive Visit' }}</span>
                </div>

                {{-- يتواجد --}}
                <p class="text-gray-400 dark:text-white/35 text-base sm:text-lg font-bold mb-1 tracking-wide">{{ app()->getLocale() == 'ar' ? 'يتواجد' : 'Now Present' }}</p>

                {{-- Name: dark red in light mode, white→red gradient in dark mode --}}
                <h2 class="event-dr-title text-4xl sm:text-5xl lg:text-[3.5rem] xl:text-6xl font-black leading-[1.05] mb-3">
                    {{ app()->getLocale() == 'ar' ? 'أ.د. طارق الحبيب' : 'Prof. Dr. Tariq Al-Habib' }}
                </h2>

                {{-- Title --}}
                <p class="text-gray-500 dark:text-white/45 text-sm sm:text-base font-medium mb-1.5">{{ app()->getLocale() == 'ar' ? 'بروفسور وخبير الإرشاد الاجتماعي والتربوي وتنمية المهارات الحياتية' : 'Professor & Social, Educational Guidance Expert' }}</p>

                {{-- Location line --}}
                <p class="text-gray-700 dark:text-white/80 text-lg sm:text-xl font-bold mb-7">
                    {{ app()->getLocale() == 'ar' ? 'في مركز مطمئنة الكويت' : 'at Motmaena Kuwait Center' }}
                </p>

                {{-- Month Badge --}}
                <div class="inline-flex items-center gap-3 bg-white dark:bg-white/[0.04] border border-gray-200 dark:border-white/10 rounded-2xl px-5 py-3 mb-8 shadow-sm dark:shadow-none">
                    <svg class="w-5 h-5 text-primary shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span class="text-gray-400 dark:text-white/50 text-xs font-bold uppercase tracking-widest">{{ app()->getLocale() == 'ar' ? 'خلال شهر' : 'During' }}</span>
                    <div class="w-px h-4 bg-gray-200 dark:bg-white/15"></div>
                    <span class="text-primary font-black text-base sm:text-lg">{{ app()->getLocale() == 'ar' ? 'مايو 2026' : 'May 2026' }}</span>
                </div>

                {{-- Dates Grid — 3×2 --}}
                <div class="mb-8">
                    <p class="text-gray-400 dark:text-white/25 text-[10px] font-black uppercase tracking-[0.3em] mb-4">{{ app()->getLocale() == 'ar' ? 'مواعيد الاستشارات المتاحة' : 'Available Consultation Dates' }}</p>
                    <div class="grid grid-cols-3 gap-2.5 sm:gap-3 max-w-[320px]">
                        @php
                            $visitDates = [
                                12 => ['ar' => 'الثلاثاء', 'en' => 'Tuesday'],
                                13 => ['ar' => 'الأربعاء', 'en' => 'Wednesday'],
                            ];
                        @endphp
                        @foreach($visitDates as $date => $day)
                        <div class="group relative bg-white dark:bg-white/[0.04] hover:bg-primary/[0.07] dark:hover:bg-primary/20 border border-gray-200 dark:border-white/[0.08] hover:border-primary/50 dark:hover:border-primary/50 rounded-xl p-2.5 sm:p-3 text-center cursor-pointer transition-all duration-300 hover:-translate-y-1.5 hover:shadow-[0_12px_28px_-8px_rgba(176,65,65,0.25)] dark:hover:shadow-[0_16px_36px_-8px_rgba(176,65,65,0.55)] overflow-hidden shadow-sm dark:shadow-none">
                            <div class="absolute inset-0 bg-gradient-to-b from-primary/[0.05] to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-xl"></div>
                            <div class="relative z-10">
                                <div class="text-[8px] font-black text-gray-300 dark:text-white/20 group-hover:text-primary/60 transition-colors leading-none">05 | مايو</div>
                                <div class="text-2xl sm:text-3xl font-black text-gray-800 dark:text-white leading-tight my-0.5">{{ str_pad($date, 2, '0', STR_PAD_LEFT) }}</div>
                                <div class="text-[8px] font-bold text-gray-300 dark:text-white/15 group-hover:text-primary/40 dark:group-hover:text-white/30 transition-colors leading-none">{{ app()->getLocale() == 'ar' ? $day['ar'] : $day['en'] }}</div>
                            </div>
                            <div class="absolute top-1.5 {{ app()->getLocale() == 'ar' ? 'left-1.5' : 'right-1.5' }} w-1.5 h-1.5 bg-green-500 rounded-full opacity-40 group-hover:opacity-100 transition-opacity animate-pulse"></div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Service Description --}}
                <p class="{{ app()->getLocale() == 'ar' ? 'border-r-2 pr-4' : 'border-l-2 pl-4' }} border-primary/40 text-gray-500 dark:text-white/40 text-sm sm:text-base leading-relaxed mb-8">
                    {{ app()->getLocale() == 'ar' ? 'لتقديم الاستشارات الاجتماعية والحياتية والتربوية والتدريب' : 'Social, life, educational consultations & professional training' }}
                </p>

                {{-- CTA Row --}}
                <div class="flex flex-col sm:flex-row items-start gap-4">
                    <a href="https://wa.me/96555665161" target="_blank"
                       class="group inline-flex items-center gap-3 text-white font-black text-base sm:text-lg px-7 py-4 rounded-2xl transition-all duration-300 hover:-translate-y-1 active:scale-95 whitespace-nowrap"
                       style="background: linear-gradient(135deg, #c95050 0%, #b04141 50%, #8a2f2f 100%); box-shadow: 0 16px 40px -10px rgba(176,65,65,0.5);">
                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.72.937 3.658 1.43 5.623 1.43h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        {{ app()->getLocale() == 'ar' ? 'احجز الآن بالواتساب' : 'Book via WhatsApp' }}
                    </a>

                    <div class="flex items-center gap-3 self-center">
                        <div class="w-px h-10 bg-gray-200 dark:bg-white/10 hidden sm:block"></div>
                        <div>
                            <div class="text-gray-400 dark:text-white/25 text-[10px] uppercase tracking-widest font-bold">{{ app()->getLocale() == 'ar' ? 'للتواصل والاستفسار' : 'Contact' }}</div>
                            <div class="text-gray-600 dark:text-white/55 font-black text-sm mt-0.5" dir="ltr">+965 556 651 61</div>
                        </div>
                    </div>
                </div>

                {{-- Location Strip --}}
                <div class="mt-7 pt-6 border-t border-gray-100 dark:border-white/[0.06] flex items-center gap-3">
                    <svg class="w-3.5 h-3.5 text-primary/50 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span class="text-gray-400 dark:text-white/25 text-xs font-medium">{{ app()->getLocale() == 'ar' ? 'الكويت — برج أحمد، بجوار المستشفى الأميري' : 'Kuwait — Burj Ahmed, near Al-Amiri Hospital' }}</span>
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

                    {{-- Zoom badge --}}
                    <div class="absolute top-4 {{ app()->getLocale() == 'ar' ? 'right-2' : 'left-2' }} z-20">
                        <div class="flex items-center gap-2 bg-primary text-white text-xs font-black px-3 py-1.5 rounded-full shadow-lg">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M17 10.5V7c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v10c0 .55.45 1 1 1h12c.55 0 1-.45 1-1v-3.5l4 4v-11l-4 4z"/></svg>
                            {{ app()->getLocale() == 'ar' ? 'أونلاين عبر زووم' : 'Online via Zoom' }}
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
                            <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M17 10.5V7c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v10c0 .55.45 1 1 1h12c.55 0 1-.45 1-1v-3.5l4 4v-11l-4 4z"/></svg>
                            {{ app()->getLocale() == 'ar' ? 'أونلاين عبر زووم' : 'Online via Zoom' }}
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

                {{-- Bundle Price --}}
                <div class="flex items-center gap-3 sm:gap-4 border border-primary/20 rounded-2xl px-4 sm:px-5 py-4 mb-6 shadow-sm bg-white dark:bg-white/[0.06]">
                    <div class="w-9 h-9 sm:w-10 sm:h-10 bg-primary/10 rounded-xl flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-xs font-bold mb-1 text-gray-500 dark:text-gray-400">{{ app()->getLocale() == 'ar' ? 'سعر الاشتراك في الدورتين' : 'Bundle Price (Both Courses)' }}</div>
                        <div class="flex items-baseline gap-2 sm:gap-3">
                            <span class="text-primary font-black text-xl sm:text-2xl lg:text-3xl">{{ app()->getLocale() == 'ar' ? '50 دينار' : '50 KWD' }}</span>
                            <span class="text-sm font-bold line-through opacity-40 text-gray-900 dark:text-gray-100">{{ app()->getLocale() == 'ar' ? '60' : '60 KWD' }}</span>
                        </div>
                    </div>
                    <div class="shrink-0">
                        <div class="text-white text-[10px] font-black px-2.5 py-1.5 rounded-full whitespace-nowrap shadow-sm" style="background:#16a34a;">{{ app()->getLocale() == 'ar' ? 'وفّر 10 د.ك' : 'Save 10 KWD' }}</div>
                    </div>
                </div>

                {{-- Per-course price note --}}
                <p class="text-xs font-medium mb-6 text-gray-500 dark:text-gray-400">
                    {{ app()->getLocale() == 'ar' ? '* سعر كل دورة منفردة 30 دينار كويتي' : '* Each course individually: 30 KWD' }}
                </p>

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
