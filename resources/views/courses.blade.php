@extends('layouts.app')

@section('title', __('Courses') . ' - ' . __('Motmaena Center'))

@section('content')

{{-- ════════════════ HERO SECTION ════════════════ --}}
<section class="relative py-12 sm:py-20 bg-secondary dark:bg-dark-surface overflow-hidden border-b border-gray-100 dark:border-dark-border">
    {{-- Background Orbs --}}
    <div class="absolute top-0 {{ app()->getLocale() == 'ar' ? 'right-0' : 'left-0' }} w-1/2 h-full bg-gradient-to-b from-primary/5 to-transparent pointer-events-none"></div>
    
    <div class="container mx-auto px-4 relative z-10 text-center">
        <div class="inline-flex items-center gap-2 bg-white dark:bg-dark-border px-4 py-2 rounded-full shadow-sm mb-6 border border-primary/10 reveal">
            <span class="w-2 h-2 bg-primary rounded-full animate-pulse shrink-0"></span>
            <span class="text-primary font-bold text-xs uppercase tracking-widest">{{ __('Exclusive and recorded courses') }}</span>
        </div>
        
        <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold text-gray-900 dark:text-white mb-6 reveal">
            {{ app()->getLocale() == 'ar' ? 'جميع الدورات المتخصصة' : 'All Specialized Courses' }}
        </h1>
        
        <p class="text-sm sm:text-base lg:text-lg text-[var(--muted-color)] max-w-2xl mx-auto leading-relaxed reveal">
            {{ app()->getLocale() == 'ar' 
                ? 'استكشف مجموعة واسعة من الدورات النفسية والتربوية تحت إشراف البروفيسور طارق الحبيب لتطوير مهاراتك وصحتك النفسية.' 
                : 'Explore a wide range of psychological and educational courses under the supervision of Professor Tariq Al-Habib to develop your skills and mental health.' }}
        </p>
    </div>
</section>

{{-- ════════════════ COURSES GRID SECTION ════════════════ --}}
<section id="courses" class="py-14 sm:py-20 md:py-24 bg-white dark:bg-dark-bg relative overflow-hidden">
    <div class="container mx-auto px-4">
        <livewire:course-grid />
    </div>
</section>

@endsection

@push('scripts')
<script>
    // Reveal animation for the new page
    document.addEventListener('DOMContentLoaded', () => {
        if (typeof reveal === 'function') reveal();
    });
</script>
@endpush
