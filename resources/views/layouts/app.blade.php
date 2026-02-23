<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

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
        <div class="min-h-screen flex flex-col">
            <header class="bg-[var(--bg-color)]/90 backdrop-blur-md sticky top-0 z-50 border-b border-[var(--border-color)] shadow-sm">
                <nav class="container mx-auto px-4 py-4 flex items-center justify-between">
                    <div class="flex items-center gap-8 md:gap-12">
                        <a href="/" class="flex items-center group shrink-0">
                            <img src="{{ asset('logo-clinic.png') }}" alt="{{ __('Motmaena Center') }}" class="h-12 md:h-14 transition-transform group-hover:scale-105 dark:brightness-110">
                        </a>
                        <div class="hidden lg:flex items-center gap-8">
                            <a href="/" class="nav-link {{ request()->is('/') ? 'text-primary font-bold' : '' }}">{{ __('Home') }}</a>
                            <a href="#" class="nav-link">{{ __('Clinics') }}</a>
                            <a href="/#courses" class="nav-link">{{ __('Courses') }}</a>
                            <a href="#" class="nav-link">{{ __('App') }}</a>
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

                        <a href="#" class="hidden sm:inline-block btn-motmaena text-xs md:text-sm px-4 md:px-5 py-2 md:py-2.5 shadow-lg shadow-primary/20">{{ __('Login') }}</a>
                    </div>
                </nav>
            </header>

            <!-- Mobile Menu -->
            <div id="mobile-menu" class="hidden lg:hidden bg-[var(--bg-color)] border-b border-[var(--border-color)] shadow-lg animate-menu-in">
                <nav class="container mx-auto px-4 py-4 flex flex-col">
                    <a href="/" class="flex items-center gap-3 px-4 py-3.5 rounded-xl hover:bg-primary/5 hover:text-primary transition-all font-semibold text-[var(--text-color)] {{ request()->is('/') ? 'text-primary' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                        {{ __('Home') }}
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-3.5 rounded-xl hover:bg-primary/5 hover:text-primary transition-all font-semibold text-[var(--text-color)]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                        {{ __('Clinics') }}
                    </a>
                    <a href="/#courses" class="flex items-center gap-3 px-4 py-3.5 rounded-xl hover:bg-primary/5 hover:text-primary transition-all font-semibold text-[var(--text-color)]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                        {{ __('Courses') }}
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-3.5 rounded-xl hover:bg-primary/5 hover:text-primary transition-all font-semibold text-[var(--text-color)]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                        {{ __('App') }}
                    </a>
                    <div class="mt-4 pt-4 border-t border-[var(--border-color)]">
                        <a href="#" class="btn-motmaena w-full text-center">{{ __('Login') }}</a>
                    </div>
                </nav>
            </div>

            <main class="flex-grow">
                @yield('content')
            </main>

            <footer class="bg-[var(--surface-color)] border-t border-[var(--border-color)] py-16 mt-auto">
                <div class="container mx-auto px-4">
                    <div class="flex flex-col items-center gap-8 text-center">
                        <img src="{{ asset('logo-clinic.png') }}" alt="{{ __('Motmaena Center') }}" class="h-16 opacity-90 grayscale hover:grayscale-0 transition-all dark:invert dark:brightness-110">
                        
                        <div class="flex flex-wrap justify-center gap-x-10 gap-y-4">
                            <a href="/" class="text-sm font-semibold text-[var(--text-color)] hover:text-primary transition-colors">{{ __('Home') }}</a>
                            <a href="#" class="text-sm font-semibold text-[var(--text-color)] hover:text-primary transition-colors">{{ __('Clinics') }}</a>
                            <a href="#courses" class="text-sm font-semibold text-[var(--text-color)] hover:text-primary transition-colors">{{ __('Courses') }}</a>
                        </div>

                        <!-- Social Media Links -->
                        <div class="flex flex-wrap items-center justify-center gap-6">
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
                mobileMenuBtn.addEventListener('click', () => {
                    const isOpen = !mobileMenu.classList.contains('hidden');
                    mobileMenu.classList.toggle('hidden');
                    hamburgerIcon.classList.toggle('hidden', !isOpen ? false : true);
                    closeIcon.classList.toggle('hidden', !isOpen ? true : false);
                });
            }

            // Scroll Reveal Animation
            function reveal() {
                var reveals = document.querySelectorAll(".reveal, .reveal-left, .reveal-right");
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
        </script>
        <!-- Floating WhatsApp Button -->
        <a href="https://wa.me/96555665161" target="_blank" 
           class="fixed bottom-8 {{ app()->getLocale() == 'ar' ? 'left-8' : 'right-8' }} z-[60] group flex items-center gap-3"
           title="{{ __('Contact us on WhatsApp') }}">
            <div class="bg-white dark:bg-dark-surface px-4 py-2 rounded-full shadow-2xl border border-primary/10 opacity-0 -translate-x-4 pointer-events-none group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-500 hidden md:flex items-center gap-2">
                <span class="text-xs font-bold text-gray-900 dark:text-white whitespace-nowrap">{{ __('Talk to us') }}</span>
                <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span>
            </div>
            <div class="relative">
                <div class="absolute inset-0 bg-[#25D366] rounded-full animate-ping opacity-20"></div>
                <div class="relative bg-[#25D366] text-white p-3.5 rounded-full shadow-2xl transform transition-transform duration-500 hover:scale-110 active:scale-95 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.72.937 3.658 1.43 5.623 1.43h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                </div>
            </div>
        </a>

        @livewireScripts
    </body>
</html>
