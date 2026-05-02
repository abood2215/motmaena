<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="@yield('meta_description', __('Motmaena Center for Social, Educational & Life Skills - Exclusive and recorded courses with Dr. Tariq Al-Habib'))">
        <meta name="keywords" content="مطمئنة, دورات تنموية, طارق الحبيب, استشارات أسرية وتربوية, تطوير الذات, الكويت">
        <meta name="author" content="Motmaena Center">

        <!-- Open Graph / Facebook -->
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:title" content="@yield('title', __('Welcome') . ' - ' . __('Motmaena Center'))">
        <meta property="og:description" content="@yield('meta_description', __('Motmaena Center for Social, Educational & Life Skills - Exclusive and recorded courses with Dr. Tariq Al-Habib'))">
        <meta property="og:image" content="{{ asset('image.png') }}">

        <!-- Twitter -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="@yield('title', __('Welcome') . ' - ' . __('Motmaena Center'))">
        <meta name="twitter:description" content="@yield('meta_description', __('Motmaena Center for Social, Educational & Life Skills - Exclusive and recorded courses with Dr. Tariq Al-Habib'))">
        <meta name="twitter:image" content="{{ asset('image.png') }}">

        <title>@yield('title', __('Welcome') . ' - ' . __('Motmaena Center'))</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Tajawal:wght@400;500;700;800;900&display=swap" rel="stylesheet">

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles

        <script>
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark')
            } else {
                document.documentElement.classList.remove('dark')
            }
        </script>
    </head>
    <body class="bg-[var(--bg-color)] text-[var(--text-color)] antialiased transition-colors duration-300">

        <!-- ═══════ PRELOADER ═══════ -->
        <div id="preloader" class="fixed inset-0 z-[9999] bg-[var(--bg-color)] flex items-center justify-center transition-opacity duration-700">
            <div class="flex flex-col items-center gap-6">
                <div class="preloader-logo">
                    <img src="{{ asset('image.png') }}" alt="{{ __('Motmaena Center') }}" class="h-20 md:h-24">
                </div>
                <div class="flex gap-1.5">
                    <span class="w-2.5 h-2.5 bg-primary rounded-full animate-bounce" style="animation-delay: 0s"></span>
                    <span class="w-2.5 h-2.5 bg-primary rounded-full animate-bounce" style="animation-delay: 0.15s"></span>
                    <span class="w-2.5 h-2.5 bg-primary rounded-full animate-bounce" style="animation-delay: 0.3s"></span>
                </div>
            </div>
        </div>

        <div class="min-h-screen flex flex-col">


            <header class="bg-[var(--bg-color)]/90 backdrop-blur-md sticky top-0 z-50 border-b border-[var(--border-color)] shadow-sm">
                <nav class="container mx-auto px-4 py-4 flex items-center justify-between">
                    <div class="flex items-center gap-8 md:gap-12">
                        <a href="/" class="flex items-center group shrink-0">
                            <img src="{{ asset('image.png') }}" alt="{{ __('Motmaena Center') }}" class="h-12 md:h-14 transition-transform group-hover:scale-105 dark:brightness-110">
                        </a>
                        <div class="hidden lg:flex items-center gap-8">
                            <a href="/" class="nav-link {{ request()->is('/') ? 'text-primary font-bold' : '' }}">{{ __('Home') }}</a>
                            <a href="{{ route('courses') }}" class="nav-link {{ request()->routeIs('courses') ? 'text-primary font-bold' : '' }}">{{ __('Courses') }}</a>
                            <a href="{{ route('packages') }}" class="nav-link flex items-center gap-1.5 group/pkg {{ request()->routeIs('packages') ? 'text-primary font-bold' : '' }}">
                                {{ __('Packages') }}
                                <span class="inline-flex items-center justify-center bg-primary/10 text-primary text-[8px] font-black px-1.5 py-0.5 rounded-full leading-none uppercase tracking-wide group-hover/pkg:bg-primary group-hover/pkg:text-white transition-all duration-200">{{ app()->getLocale() == 'ar' ? 'جديد' : 'New' }}</span>
                            </a>
                            <a href="{{ route('sessions') }}" class="nav-link {{ request()->routeIs('sessions') ? 'text-primary font-bold' : '' }}">{{ __('Sessions') }}</a>
                            <a href="{{ route('consultations') }}" class="nav-link {{ request()->routeIs('consultations') ? 'text-primary font-bold' : '' }}">{{ __('Consultations') }}</a>
                            <a href="{{ url('/#app-section') }}" class="nav-link">{{ __('App') }}</a>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 sm:gap-3 md:gap-4">
                        <!-- Hamburger (mobile only) -->
                        <button id="mobile-menu-btn" class="lg:hidden p-2.5 rounded-xl bg-gray-50 dark:bg-dark-border text-gray-500 dark:text-gray-300 hover:bg-primary/10 hover:text-primary transition-all" aria-label="Menu">
                            <svg id="hamburger-icon" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                            <svg id="close-icon" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                        <!-- Theme Toggle -->
                        <button onclick="toggleTheme()" class="p-2.5 rounded-xl bg-gray-50 dark:bg-dark-border text-gray-500 dark:text-gray-300 hover:bg-primary/10 hover:text-primary transition-all" title="Toggle Theme">
                            <svg id="theme-icon-light" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden dark:block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707" />
                            </svg>
                            <svg id="theme-icon-dark" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 block dark:hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                            </svg>
                        </button>

                        <!-- Language Switcher -->
                        <div class="flex items-center bg-gray-50 dark:bg-dark-border rounded-xl p-1">
                            <a href="{{ route('lang.switch', 'ar') }}" class="px-3 md:px-4 py-1.5 rounded-lg text-xs font-bold transition-all {{ app()->getLocale() == 'ar' ? 'bg-primary text-white shadow-sm' : 'text-gray-500 hover:text-primary' }}">عربي</a>
                            <a href="{{ route('lang.switch', 'en') }}" class="px-3 md:px-4 py-1.5 rounded-lg text-xs font-bold transition-all {{ app()->getLocale() == 'en' ? 'bg-primary text-white shadow-sm' : 'text-gray-500 hover:text-primary' }}">EN</a>
                        </div>

                    </div>
                </nav>

            <!-- Mobile Menu -->
            <div id="mobile-menu" class="hidden lg:hidden bg-[var(--bg-color)]/95 backdrop-blur-md border-b border-[var(--border-color)] shadow-xl animate-menu-in max-h-[calc(100vh-80px)] overflow-y-auto">
                <nav class="container mx-auto px-3 sm:px-4 py-3 sm:py-6 flex flex-col gap-1">
                    <a href="/" class="flex items-center gap-3 px-4 py-3.5 rounded-xl hover:bg-primary/5 hover:text-primary transition-all font-bold text-[var(--text-color)] group {{ request()->is('/') ? 'bg-primary/5 text-primary' : '' }}">
                        <div class="w-8 h-8 rounded-lg bg-gray-100 dark:bg-dark-border flex items-center justify-center group-hover:bg-primary/10 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                        </div>
                        {{ __('Home') }}
                    </a>
                    <a href="{{ route('courses') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-xl hover:bg-primary/5 hover:text-primary transition-all font-bold text-[var(--text-color)] group {{ request()->routeIs('courses') ? 'bg-primary/5 text-primary' : '' }}">
                        <div class="w-8 h-8 rounded-lg bg-gray-100 dark:bg-dark-border flex items-center justify-center group-hover:bg-primary/10 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                        </div>
                        {{ __('Courses') }}
                    </a>
                    <a href="{{ route('packages') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-xl hover:bg-primary/5 hover:text-primary transition-all font-bold text-[var(--text-color)] group {{ request()->routeIs('packages') ? 'bg-primary/5 text-primary' : '' }}">
                        <div class="w-8 h-8 rounded-lg bg-primary/10 text-primary flex items-center justify-center group-hover:bg-primary group-hover:text-white transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        </div>
                        {{ __('Packages') }}
                        <span class="ms-auto inline-flex items-center justify-center bg-primary text-white text-[8px] font-black px-1.5 py-0.5 rounded-full leading-none uppercase tracking-wide">{{ app()->getLocale() == 'ar' ? 'جديد' : 'New' }}</span>
                    </a>
                    <a href="{{ route('sessions') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-xl hover:bg-primary/5 hover:text-primary transition-all font-bold text-[var(--text-color)] group {{ request()->routeIs('sessions') ? 'bg-primary/5 text-primary' : '' }}">
                        <div class="w-8 h-8 rounded-lg bg-gray-100 dark:bg-dark-border flex items-center justify-center group-hover:bg-primary/10 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        </div>
                        {{ __('Sessions') }}
                    </a>
                    <a href="{{ route('consultations') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-xl hover:bg-primary/5 hover:text-primary transition-all font-bold text-[var(--text-color)] group {{ request()->routeIs('consultations') ? 'bg-primary/5 text-primary' : '' }}">
                        <div class="w-8 h-8 rounded-lg bg-gray-100 dark:bg-dark-border flex items-center justify-center group-hover:bg-primary/10 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-3 3v-3z" /></svg>
                        </div>
                        {{ __('Consultations') }}
                    </a>
                    <a href="{{ url('/#app-section') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-xl hover:bg-primary/5 hover:text-primary transition-all font-bold text-[var(--text-color)] group">
                        <div class="w-8 h-8 rounded-lg bg-gray-100 dark:bg-dark-border flex items-center justify-center group-hover:bg-primary/10 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                        </div>
                        {{ __('App') }}
                    </a>
                </nav>
            </div>
        </header>


            <main class="flex-grow">
                @yield('content')
            </main>

            <footer class="bg-[var(--surface-color)] border-t border-[var(--border-color)] py-10 sm:py-16 mt-auto">
                <div class="container mx-auto px-4">
                    <div class="flex flex-col items-center gap-5 sm:gap-8 text-center">
                        <img src="{{ asset('image.png') }}" alt="{{ __('Motmaena Center') }}" class="h-12 sm:h-16 opacity-90 grayscale hover:grayscale-0 transition-all dark:brightness-110">
                        
                        <div class="flex flex-wrap justify-center gap-x-5 sm:gap-x-8 md:gap-x-10 gap-y-2 sm:gap-y-3">
                            <a href="/" class="text-sm font-semibold text-[var(--text-color)] hover:text-primary transition-colors">{{ __('Home') }}</a>
                            <a href="{{ route('courses') }}" class="text-sm font-semibold text-[var(--text-color)] {{ request()->routeIs('courses') ? 'text-primary' : '' }} hover:text-primary transition-colors">{{ __('Courses') }}</a>
                            <a href="{{ route('packages') }}" class="text-sm font-semibold text-[var(--text-color)] {{ request()->routeIs('packages') ? 'text-primary' : '' }} hover:text-primary transition-colors">{{ __('Packages') }}</a>
                        </div>

                        <!-- Social Media Links -->
                        <div class="flex flex-wrap items-center justify-center gap-3 sm:gap-4 md:gap-6">
                            <a href="https://www.instagram.com/motmaena_kw/?hl=ar" target="_blank" class="p-3 rounded-full bg-gray-50 dark:bg-dark-border text-gray-400 hover:text-[#E4405F] hover:bg-[#E4405F]/10 transition-all hover:-translate-y-1 shadow-sm" title="Instagram">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                            </a>
                            <a href="https://www.facebook.com/motmaenakw" target="_blank" class="p-3 rounded-full bg-gray-50 dark:bg-dark-border text-gray-400 hover:text-[#1877F2] hover:bg-[#1877F2]/10 transition-all hover:-translate-y-1 shadow-sm" title="Facebook">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
                            </a>
                            <a href="https://www.snapchat.com/@motmaenacenter/spotlight/W7_EDlXWTBiXAEEniNoMPwAAYYWZnc3RpZXZnAZTP-JaEAZTP-IsuAAAAAQ" target="_blank" class="p-3 rounded-full bg-gray-50 dark:bg-dark-border text-gray-400 hover:text-[#FFFC00] hover:bg-[#FFFC00]/20 transition-all hover:-translate-y-1 shadow-sm" title="Snapchat">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12.065 2c.574 0 4.271.144 5.886 3.78.55 1.249.427 3.384.338 4.89l-.003.07a.438.438 0 0 0 .332.451c.268.08.71.21 1.374.315l.285.05a.573.573 0 0 1 .483.588c0 .247-.163.49-.432.621l-.003.002a5.276 5.276 0 0 1-.954.32 3.198 3.198 0 0 1-.335.04c-.185.006-.375.074-.517.223-.13.14-.178.322-.14.499.086.35.45.764 1.145.966l.037.012c.251.08.4.314.355.565-.033.18-.153.33-.327.4-.136.056-.305.1-.51.136-.326.054-.462.191-.571.438-.059.134-.077.253-.077.254-.006.018-.007.038-.007.058 0 .055.025.105.07.134.262.174.71.408 1.336.542l.033.008c.14.035.21.19.144.326-.025.052-.071.097-.129.124-1.009.48-1.64.98-1.857 1.495l-.007.014c-.07.169-.257.262-.437.218-1.021-.258-1.943-.78-3.001-.78-.17 0-.344.013-.517.04-1.03.157-1.898.712-2.931.712-.185 0-.368-.017-.544-.05-1.006-.19-1.844-.72-2.852-.72-.156 0-.312.01-.463.032-1.038.146-1.685.719-2.95.719-.025 0-.05 0-.075-.001-.16-.01-.297-.097-.352-.241l-.007-.015c-.215-.515-.847-1.015-1.857-1.495-.058-.027-.104-.072-.129-.124-.066-.136.004-.291.144-.326l.033-.008c.626-.134 1.074-.368 1.336-.542.045-.03.07-.08.07-.134 0-.02-.001-.04-.007-.058 0-.001-.018-.12-.077-.254-.11-.247-.245-.384-.57-.438-.207-.036-.376-.08-.511-.136-.174-.07-.294-.22-.327-.4-.044-.251.104-.485.355-.565l.037-.012c.695-.202 1.06-.616 1.145-.966.038-.177-.01-.36-.14-.499-.142-.149-.332-.217-.517-.223-.11-.005-.223-.017-.335-.04a4.944 4.944 0 0 1-.954-.32l-.003-.002c-.269-.131-.432-.374-.432-.621a.572.572 0 0 1 .483-.588l.285-.05c.664-.105 1.106-.235 1.374-.315a.437.437 0 0 0 .332-.451l-.003-.07c-.089-1.506-.212-3.641.338-4.89C7.794 2.144 11.491 2 12.065 2z"/>
                                </svg>
                            </a>
                            <a href="https://www.tiktok.com/@motmaena_kw" target="_blank" class="p-3 rounded-full bg-gray-50 dark:bg-dark-border text-gray-400 hover:text-black dark:hover:text-white hover:bg-black/5 dark:hover:bg-white/10 transition-all hover:-translate-y-1 shadow-sm" title="TikTok">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12a4 4 0 1 0 4 4V4a5 5 0 0 0 5 5"></path></svg>
                            </a>
                        </div>

                        <div class="h-px w-24 bg-primary/20"></div>

                        <!-- Google Maps -->
                        <div class="w-full max-w-2xl mx-auto">
                            <h4 class="text-sm font-bold text-[var(--text-color)] mb-4">{{ app()->getLocale() == 'ar' ? '📍 موقعنا' : '📍 Our Location' }}</h4>
                            <div class="rounded-2xl overflow-hidden border border-[var(--border-color)] shadow-lg">
                                <iframe
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3477.8!2d47.9907505!3d29.3901935!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3fcf85ac7308d461%3A0x108f7b378447d243!2z2YXYsdmD2LIg2YXYt9mF2KbZhtipINmE2YTYp9iz2KrYtNin2LHYp9iqINin2YTZhtmB2LPZitipIHwg2KXYtNix2KfZgSDYoy7YryDYt9in2LHZgiDYp9mE2K3YqNmK2Kg!5e0!3m2!1sar!2skw!4v1700000000000!5m2!1sar!2skw"
                                    width="100%" height="200" style="border:0;" allowfullscreen="" loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade"
                                    class="w-full"></iframe>
                            </div>
                        </div>

                        <div class="h-px w-24 bg-primary/20"></div>

                        <p class="text-sm text-[var(--muted-color)] leading-relaxed">
                            {{ __('Motmaena Center') }} &copy; {{ date('Y') }}. {{ __('All rights reserved.') }}
                        </p>
                    </div>
                </div>
            </footer>
        </div>

        <script>
            // Theme Toggle
            function toggleTheme() {
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.theme = 'light';
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.theme = 'dark';
                }
            }

            // Mobile Menu Toggle
            const mobileMenuBtn = document.getElementById('mobile-menu-btn');
            const mobileMenu    = document.getElementById('mobile-menu');
            const hamburgerIcon = document.getElementById('hamburger-icon');
            const closeIcon     = document.getElementById('close-icon');

            if (mobileMenuBtn) {
                const toggleMenu = (forceState) => {
                    const isClosing = (typeof forceState === 'boolean') ? !forceState : !mobileMenu.classList.contains('hidden');
                    
                    if (isClosing) {
                        mobileMenu.classList.add('hidden');
                        hamburgerIcon.classList.remove('hidden');
                        closeIcon.classList.add('hidden');
                        document.body.style.overflow = '';
                    } else {
                        mobileMenu.classList.remove('hidden');
                        hamburgerIcon.classList.add('hidden');
                        closeIcon.classList.remove('hidden');
                        document.body.style.overflow = 'hidden';
                    }
                };

                mobileMenuBtn.onclick = (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    toggleMenu();
                };

                // Close menu when clicking any link inside it
                mobileMenu.querySelectorAll('a').forEach(link => {
                    link.onclick = () => {
                        setTimeout(() => toggleMenu(false), 150);
                    };
                });

                // Close menu when clicking outside
                document.onclick = (e) => {
                    if (!mobileMenu.classList.contains('hidden') && !mobileMenu.contains(e.target) && !mobileMenuBtn.contains(e.target)) {
                        toggleMenu(false);
                    }
                };
            }

            // Scroll Reveal Animation
            function reveal() {
                var reveals = document.querySelectorAll(".reveal, .reveal-left, .reveal-right, .reveal-scale");
                for (var i = 0; i < reveals.length; i++) {
                    var windowHeight = window.innerHeight;
                    var elementTop = reveals[i].getBoundingClientRect().top;
                    var elementVisible = 150;
                    if (elementTop < windowHeight - elementVisible) {
                        reveals[i].classList.add("active");
                    }
                }
            }

            window.addEventListener("scroll", reveal);
            window.addEventListener("load", reveal);
            // Re-run reveal after Livewire updates DOM (filtering/search)
            document.addEventListener('livewire:updated', () => setTimeout(reveal, 40));

            // ═══════ PRELOADER ═══════
            window.addEventListener('load', function() {
                const preloader = document.getElementById('preloader');
                if (preloader) {
                    setTimeout(() => {
                        preloader.style.opacity = '0';
                        preloader.style.pointerEvents = 'none';
                        setTimeout(() => preloader.remove(), 700);
                    }, 800);
                }
            });

            // ═══════ BACK TO TOP ═══════
            const backToTop = document.getElementById('back-to-top');
            if (backToTop) {
                window.addEventListener('scroll', () => {
                    if (window.scrollY > 400) {
                        backToTop.classList.remove('opacity-0', 'translate-y-5', 'pointer-events-none');
                        backToTop.classList.add('opacity-100', 'translate-y-0');
                    } else {
                        backToTop.classList.add('opacity-0', 'translate-y-5', 'pointer-events-none');
                        backToTop.classList.remove('opacity-100', 'translate-y-0');
                    }
                });
                backToTop.addEventListener('click', () => {
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });
            }

            // ═══════ PARALLAX ═══════
            window.addEventListener('scroll', () => {
                const scrolled = window.scrollY;
                document.querySelectorAll('[data-parallax]').forEach(el => {
                    const speed = parseFloat(el.dataset.parallax) || 0.3;
                    el.style.transform = `translateY(${scrolled * speed}px)`;
                });
            });

            // ═══════ FAQ TOGGLE ═══════
            function toggleFaq(btn) {
                const item = btn.closest('.faq-item');
                const content = item.querySelector('.faq-content');
                const icon = item.querySelector('.faq-icon');
                const isOpen = content.style.maxHeight && content.style.maxHeight !== '0px';
                // Close all others
                document.querySelectorAll('.faq-item').forEach(faq => {
                    faq.querySelector('.faq-content').style.maxHeight = '0px';
                    faq.querySelector('.faq-icon').style.transform = 'rotate(0deg)';
                });
                if (!isOpen) {
                    content.style.maxHeight = content.scrollHeight + 'px';
                    icon.style.transform = 'rotate(180deg)';
                }
            }

            // ═══════ COUNTER ANIMATION ═══════
            function animateCounter(el) {
                const target = parseFloat(el.dataset.counter);
                const isDecimal = el.dataset.decimal === 'true';
                const duration = 2000;
                const start = performance.now();
                const suffix = target >= 1000 ? '+' : (isDecimal ? '' : '+');
                function update(now) {
                    const elapsed = now - start;
                    const progress = Math.min(elapsed / duration, 1);
                    const eased = 1 - Math.pow(1 - progress, 3);
                    let current = eased * target;
                    if (isDecimal) {
                        el.textContent = current.toFixed(1) + suffix;
                    } else if (target >= 1000) {
                        el.textContent = Math.floor(current / 1000) + 'K' + suffix;
                    } else {
                        el.textContent = Math.floor(current) + suffix;
                    }
                    if (progress < 1) requestAnimationFrame(update);
                }
                requestAnimationFrame(update);
            }
            const counterObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        animateCounter(entry.target);
                        counterObserver.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.5 });
            document.querySelectorAll('[data-counter]').forEach(el => counterObserver.observe(el));
        </script>
        <!-- Floating WhatsApp Button -->
        <a href="https://wa.me/96555665161" target="_blank"
           id="global-float-wa"
           class="fixed bottom-5 sm:bottom-8 {{ app()->getLocale() == 'ar' ? 'left-4 sm:left-8' : 'right-4 sm:right-8' }} z-[60] group flex items-center gap-3"
           title="{{ __('Contact us on WhatsApp') }}">
            <div class="bg-white dark:bg-dark-surface px-4 py-2 rounded-full shadow-2xl border border-primary/10 opacity-0 -translate-x-4 pointer-events-none group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-500 hidden md:flex items-center gap-2">
                <span class="text-xs font-bold text-gray-900 dark:text-white whitespace-nowrap">{{ __('Talk to us') }}</span>
                <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span>
            </div>
            <div class="relative">
                <div class="absolute inset-0 bg-[#25D366] rounded-full animate-ping opacity-20"></div>
                <div class="relative bg-[#25D366] text-white p-3 sm:p-3.5 rounded-full shadow-2xl transform transition-transform duration-500 hover:scale-110 active:scale-95 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" class="sm:w-[30px] sm:h-[30px]" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.72.937 3.658 1.43 5.623 1.43h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                </div>
            </div>
        </a>

        <!-- ═══════ BACK TO TOP BUTTON ═══════ -->
        <button id="back-to-top" class="fixed bottom-5 sm:bottom-8 {{ app()->getLocale() == 'ar' ? 'right-4 sm:right-8' : 'left-4 sm:left-8' }} z-[60] bg-primary/90 hover:bg-primary text-white p-2.5 sm:p-3 rounded-full shadow-2xl opacity-0 translate-y-5 pointer-events-none transition-all duration-500 hover:scale-110 active:scale-95 backdrop-blur" title="{{ app()->getLocale() == 'ar' ? 'العودة للأعلى' : 'Back to top' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7"/>
            </svg>
        </button>

        @livewireScripts
    </body>
</html>
