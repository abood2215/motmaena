@extends('layouts.app')

@section('title', $course->title . ' - ' . __('Motmaena Center'))
@section('meta_description', $course->description)

@section('content')

{{-- ════════════════ COURSE HERO ════════════════ --}}
<section class="relative py-14 sm:py-20 bg-secondary dark:bg-dark-surface overflow-hidden">
    <div class="absolute top-0 {{ app()->getLocale() == 'ar' ? 'right-0' : 'left-0' }} w-1/2 h-full bg-gradient-to-b from-primary/5 to-transparent pointer-events-none"></div>
    <div class="container mx-auto px-4">
        <div class="flex flex-col lg:flex-row items-start gap-10 lg:gap-16">

            {{-- Course Image --}}
            <div class="w-full lg:w-1/2 reveal">
                <div class="rounded-3xl overflow-hidden shadow-2xl border border-gray-100 dark:border-dark-border">
                    <img src="{{ $course->image ?? 'https://placehold.co/800x500/b04141/white?text=' . urlencode($course->title) }}"
                         alt="{{ $course->title }}"
                         class="w-full h-64 sm:h-80 lg:h-[400px] object-cover">
                </div>
            </div>

            {{-- Course Info --}}
            <div class="w-full lg:w-1/2 {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }} reveal-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}">
                <div class="flex flex-wrap items-center gap-3 mb-5">
                    <span class="bg-primary/10 text-primary px-4 py-1.5 rounded-full text-xs font-bold">{{ __($course->level) }}</span>
                    @if($course->is_new)
                    <span class="bg-green-500/10 text-green-600 px-4 py-1.5 rounded-full text-xs font-bold">{{ __('New') }}</span>
                    @endif
                </div>

                <h1 class="text-2xl sm:text-3xl md:text-4xl font-black text-gray-900 dark:text-white mb-5 leading-tight">{{ $course->title }}</h1>

                <p class="text-[var(--muted-color)] text-sm sm:text-base leading-relaxed mb-8">{{ $course->description }}</p>

                {{-- Course Meta Grid --}}
                <div class="grid grid-cols-2 gap-4 mb-8">
                    <div class="bg-white dark:bg-dark-bg p-4 rounded-2xl border border-gray-100 dark:border-dark-border text-center">
                        <div class="text-primary mb-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div class="text-xs text-[var(--muted-color)]">{{ app()->getLocale() == 'ar' ? 'المدة' : 'Duration' }}</div>
                        <div class="text-sm font-bold text-gray-900 dark:text-white">{{ app()->getLocale() == 'ar' ? '8 ساعات' : '8 Hours' }}</div>
                    </div>
                    <div class="bg-white dark:bg-dark-bg p-4 rounded-2xl border border-gray-100 dark:border-dark-border text-center">
                        <div class="text-primary mb-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        </div>
                        <div class="text-xs text-[var(--muted-color)]">{{ app()->getLocale() == 'ar' ? 'الدروس' : 'Lessons' }}</div>
                        <div class="text-sm font-bold text-gray-900 dark:text-white">{{ app()->getLocale() == 'ar' ? '24 درس' : '24 Lessons' }}</div>
                    </div>
                    <div class="bg-white dark:bg-dark-bg p-4 rounded-2xl border border-gray-100 dark:border-dark-border text-center">
                        <div class="text-primary mb-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <div class="text-xs text-[var(--muted-color)]">{{ app()->getLocale() == 'ar' ? 'شهادة' : 'Certificate' }}</div>
                        <div class="text-sm font-bold text-gray-900 dark:text-white">{{ app()->getLocale() == 'ar' ? 'معتمدة' : 'Accredited' }}</div>
                    </div>
                    <div class="bg-white dark:bg-dark-bg p-4 rounded-2xl border border-gray-100 dark:border-dark-border text-center">
                        <div class="text-primary mb-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/></svg>
                        </div>
                        <div class="text-xs text-[var(--muted-color)]">{{ app()->getLocale() == 'ar' ? 'اللغة' : 'Language' }}</div>
                        <div class="text-sm font-bold text-gray-900 dark:text-white">{{ app()->getLocale() == 'ar' ? 'العربية' : 'Arabic' }}</div>
                    </div>
                </div>

                {{-- Price & CTA --}}
                <div class="flex flex-col sm:flex-row items-center gap-4 bg-white dark:bg-dark-bg p-6 rounded-2xl border border-gray-100 dark:border-dark-border shadow-lg">
                    <div class="flex-1 text-center sm:{{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }}">
                        <span class="text-xs text-[var(--muted-color)] block mb-1">{{ app()->getLocale() == 'ar' ? 'سعر الدورة' : 'Course Price' }}</span>
                        <span class="text-3xl sm:text-4xl font-black text-primary">{{ number_format($course->price) }} <small class="text-sm font-bold opacity-70">{{ __('SAR') }}</small></span>
                    </div>
                    <a href="#" class="btn-motmaena text-sm sm:text-base px-10 py-3.5 shadow-xl shadow-primary/20 w-full sm:w-auto text-center">
                        {{ app()->getLocale() == 'ar' ? 'سجّل الآن' : 'Register Now' }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ════════════════ COURSE CONTENT ════════════════ --}}
<section class="py-14 sm:py-20 bg-white dark:bg-dark-bg">
    <div class="container mx-auto px-4 max-w-4xl">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-10">

            {{-- Main Content --}}
            <div class="lg:col-span-3 {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }} reveal">
                <h2 class="text-xl sm:text-2xl font-black text-gray-900 dark:text-white mb-6">{{ app()->getLocale() == 'ar' ? 'ماذا ستتعلم؟' : 'What will you learn?' }}</h2>
                <div class="space-y-3 mb-10">
                    @php
                    $features = app()->getLocale() == 'ar' ? [
                        'فهم المبادئ الأساسية في علم النفس',
                        'تطوير مهارات الذكاء العاطفي',
                        'بناء علاقات اجتماعية صحية ومستدامة',
                        'التعامل مع الضغوط النفسية بفعالية',
                        'تطبيق أساليب عملية في الحياة اليومية',
                        'فهم السلوك البشري وأنماط التفكير',
                    ] : [
                        'Understand core psychology principles',
                        'Develop emotional intelligence skills',
                        'Build healthy and sustainable relationships',
                        'Effectively manage psychological stress',
                        'Apply practical methods in daily life',
                        'Understand human behavior and thinking patterns',
                    ];
                    @endphp
                    @foreach($features as $feature)
                    <div class="flex items-start gap-3">
                        <div class="mt-0.5 w-5 h-5 rounded-full bg-primary/10 flex items-center justify-center shrink-0">
                            <svg class="w-3 h-3 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <span class="text-sm text-gray-700 dark:text-gray-300">{{ $feature }}</span>
                    </div>
                    @endforeach
                </div>

                <h2 class="text-xl sm:text-2xl font-black text-gray-900 dark:text-white mb-6">{{ app()->getLocale() == 'ar' ? 'عن المدرب' : 'About the Instructor' }}</h2>
                <div class="flex items-center gap-4 bg-gray-50 dark:bg-dark-surface p-5 rounded-2xl border border-gray-100 dark:border-dark-border">
                    <div class="w-14 h-14 bg-primary/10 rounded-full flex items-center justify-center text-primary font-black text-xl shrink-0">د.ط</div>
                    <div>
                        <div class="font-bold text-gray-900 dark:text-white">{{ app()->getLocale() == 'ar' ? 'أ.د طارق الحبيب' : 'Prof. Dr. Tariq Al-Habib' }}</div>
                        <div class="text-xs text-[var(--muted-color)]">{{ app()->getLocale() == 'ar' ? 'استشاري الطب النفسي - أكثر من 30 سنة خبرة' : 'Consultant Psychiatrist - 30+ years experience' }}</div>
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="lg:col-span-2 reveal-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}">
                <div class="bg-gray-50 dark:bg-dark-surface p-6 rounded-2xl border border-gray-100 dark:border-dark-border sticky top-28">
                    <h3 class="font-bold text-gray-900 dark:text-white mb-5">{{ app()->getLocale() == 'ar' ? 'تشمل الدورة:' : 'Course includes:' }}</h3>
                    <div class="space-y-4">
                        @php
                        $includes = app()->getLocale() == 'ar' ? [
                            ['icon' => 'M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z', 'text' => 'فيديوهات عالية الجودة'],
                            ['icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'text' => 'ملفات ومراجع إضافية'],
                            ['icon' => 'M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z', 'text' => 'وصول من الجوال والكمبيوتر'],
                            ['icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'text' => 'شهادة إتمام معتمدة'],
                            ['icon' => 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15', 'text' => 'وصول مدى الحياة'],
                        ] : [
                            ['icon' => 'M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z', 'text' => 'High quality videos'],
                            ['icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'text' => 'Additional files & references'],
                            ['icon' => 'M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z', 'text' => 'Mobile & desktop access'],
                            ['icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'text' => 'Accredited certificate'],
                            ['icon' => 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15', 'text' => 'Lifetime access'],
                        ];
                        @endphp
                        @foreach($includes as $item)
                        <div class="flex items-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"/></svg>
                            <span class="text-sm text-gray-700 dark:text-gray-300">{{ $item['text'] }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
