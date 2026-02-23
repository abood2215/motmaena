@extends('layouts.app')
@section('title', __('Session Subscriptions') . ' - ' . __('Motmaena Center'))
@section('content')

{{-- ════════════════════════════════════════════════════
  HERO
════════════════════════════════════════════════════ --}}
<section class="bg-[var(--bg-color)] pt-20 pb-24 sm:pt-28 sm:pb-32">
  <div class="container mx-auto px-6 text-center max-w-3xl">

    <span class="inline-block text-primary text-[11px] font-black uppercase tracking-[.22em] mb-6 reveal">
      {{ __('Linguistic, Educational, and Training Consultations') }}
    </span>

    <h1 class="text-4xl sm:text-5xl md:text-6xl font-black leading-[1.1] text-[var(--text-color)] mb-6 reveal">
      {{ app()->getLocale() == 'ar' ? 'طفلك يستحق' : 'Your Child Deserves' }}<br>
      <span class="gradient-text">{{ app()->getLocale() == 'ar' ? 'الأفضل' : 'The Best' }}</span>
    </h1>

    <p class="text-[var(--muted-color)] text-base sm:text-lg leading-relaxed mb-10 reveal">
      {{ __("Comprehensive specialized programs designed to support children's growth, skills development, and behavior modification under professional supervision.") }}
    </p>

    <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-16 reveal">
      <a href="https://wa.me/96555665161" target="_blank"
         class="btn-motmaena px-10 py-4 text-base flex items-center gap-3 shadow-lg shadow-primary/25">
        <svg class="w-5 h-5 shrink-0" viewBox="0 0 24 24" fill="currentColor">
          <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.72.937 3.658 1.43 5.623 1.43h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
        </svg>
        {{ __('Talk to a Specialist') }}
      </a>
      <a href="#plans" class="btn-outline px-10 py-4 text-base">{{ __('View All Plans') }}</a>
    </div>

    {{-- إحصائيات --}}
    <div class="grid grid-cols-3 gap-6 max-w-md mx-auto border-t border-[var(--border-color)] dark:border-dark-border pt-10 reveal">
      @foreach([
        ['n'=>500, 's'=>'+', 'l'=> app()->getLocale()=='ar' ? 'طفل مستفيد'   : 'Children'],
        ['n'=>10,  's'=>'+', 'l'=> app()->getLocale()=='ar' ? 'سنوات خبرة'   : 'Years Exp.'],
        ['n'=>98,  's'=>'%', 'l'=> app()->getLocale()=='ar' ? 'رضا الأهالي'  : 'Satisfaction'],
      ] as $s)
      <div>
        <div class="text-2xl sm:text-3xl font-black text-primary" data-counter="{{ $s['n'] }}">{{ $s['n'] }}{{ $s['s'] }}</div>
        <div class="text-[11px] font-bold text-[var(--muted-color)] uppercase tracking-wider mt-1">{{ $s['l'] }}</div>
      </div>
      @endforeach
    </div>

  </div>
</section>


{{-- ════════════════════════════════════════════════════
  التقييم والاختبارات
════════════════════════════════════════════════════ --}}
<section class="bg-[var(--surface-color)] dark:bg-dark-surface py-20 sm:py-24">
  <div class="container mx-auto px-6">

    {{-- عنوان القسم --}}
    <div class="mb-12 reveal {{ app()->getLocale()=='ar' ? 'text-right' : 'text-left' }}">
      <span class="text-[11px] font-black uppercase tracking-[.2em] text-primary">{{ __('Approved Pricing') }}</span>
      <h2 class="text-2xl sm:text-3xl font-black text-[var(--text-color)] mt-2">
        {{ __('Academic, Behavioral, and Skill Services') }}
      </h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

      {{-- التقييم الأولي --}}
      <div class="reveal-left bg-[var(--bg-color)] dark:bg-dark-bg rounded-3xl border border-[var(--border-color)] dark:border-dark-border p-8 flex items-center justify-between gap-6 group hover:border-primary/40 hover:shadow-lg hover:shadow-primary/8 transition-all duration-300">
        <div class="flex items-center gap-5">
          <div class="w-12 h-12 rounded-2xl bg-primary/10 flex items-center justify-center text-primary shrink-0 group-hover:bg-primary group-hover:text-white transition-all duration-300">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
          </div>
          <div>
            <p class="font-black text-[var(--text-color)] text-base">{{ __('Initial Evaluation') }}</p>
            <p class="text-sm text-[var(--muted-color)] mt-0.5">{{ __('Comprehensive diagnostic session') }}</p>
          </div>
        </div>
        <div class="shrink-0 text-end">
          <div class="text-4xl font-black text-primary leading-none">50</div>
          <div class="text-[10px] font-black text-[var(--muted-color)] uppercase tracking-wider mt-0.5">{{ __('KD') }}</div>
        </div>
      </div>

      {{-- الاختبارات المتخصصة --}}
      <div class="reveal-right bg-[var(--bg-color)] dark:bg-dark-bg rounded-3xl border border-[var(--border-color)] dark:border-dark-border p-8 flex flex-col gap-6 group hover:border-primary/40 hover:shadow-lg hover:shadow-primary/8 transition-all duration-300">
        <div class="flex items-center justify-between gap-4">
          <div class="flex items-center gap-5">
            <div class="w-12 h-12 rounded-2xl bg-primary/10 flex items-center justify-center text-primary shrink-0 group-hover:bg-primary group-hover:text-white transition-all duration-300">
              <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
              </svg>
            </div>
            <div>
              <p class="font-black text-[var(--text-color)] text-base">{{ __('Specialist Tests') }}</p>
              <p class="text-sm text-[var(--muted-color)] mt-0.5">{{ __('ADHD, IQ, and Behavioral Assessments') }}</p>
            </div>
          </div>
          <div class="shrink-0 text-end">
            <div class="text-4xl font-black text-primary leading-none">120</div>
            <div class="text-[10px] font-black text-[var(--muted-color)] uppercase tracking-wider mt-0.5">{{ __('KD') }}</div>
          </div>
        </div>
        <div class="flex flex-wrap gap-2 pt-5 border-t border-[var(--border-color)] dark:border-dark-border">
          @foreach([__('Academic'), __('Behavioral'), __('IQ Test')] as $tag)
            <span class="px-3 py-1.5 text-[11px] font-black uppercase tracking-wider text-primary bg-primary/8 rounded-xl border border-primary/15">{{ $tag }}</span>
          @endforeach
        </div>
      </div>

    </div>
  </div>
</section>


{{-- ════════════════════════════════════════════════════
  PLANS — الباقات العامة
════════════════════════════════════════════════════ --}}
<section id="plans" class="bg-[var(--bg-color)] py-20 sm:py-28">
  <div class="container mx-auto px-6">

    {{-- عنوان --}}
    <div class="text-center mb-14 reveal">
      <span class="text-[11px] font-black uppercase tracking-[.2em] text-primary">{{ __('Choose Your Plan') }}</span>
      <h2 class="text-2xl sm:text-4xl font-black text-[var(--text-color)] mt-2 mb-3">
        {{ app()->getLocale()=='ar' ? 'باقات الجلسات' : 'Session Packages' }}
      </h2>
      <p class="text-[var(--muted-color)] text-sm sm:text-base">{{ __('Flexible packages tailored to your child\'s pace') }}</p>
    </div>

    {{-- الشبكة --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

      {{-- ─── 12 جلسة ─── --}}
      <div class="reveal-scale bg-[var(--surface-color)] dark:bg-dark-surface rounded-3xl border border-[var(--border-color)] dark:border-dark-border p-8 flex flex-col gap-8 hover:shadow-xl hover:shadow-primary/10 hover:border-primary/30 transition-all duration-300" style="transition-delay:0ms">
        <div>
          <span class="text-[10px] font-black uppercase tracking-widest text-[var(--muted-color)]">{{ __('12 Sessions') }}</span>
          <div class="mt-3 flex items-end gap-2 leading-none">
            <span class="text-5xl font-black text-[var(--text-color)]">360</span>
            <span class="text-base font-bold text-[var(--muted-color)] pb-1">KD</span>
          </div>
        </div>
        <ul class="flex flex-col gap-3 flex-1">
          @foreach([__('Massive improvement area'), __('Duration: 1 Month'), __('3 Days / Week')] as $f)
          <li class="flex items-center gap-3 text-sm text-[var(--muted-color)]">
            <svg class="w-4 h-4 text-primary shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
            {{ $f }}
          </li>
          @endforeach
        </ul>
        <a href="https://wa.me/96555665161" class="btn-outline w-full text-center py-3 text-sm">{{ __('Get Started') }}</a>
      </div>

      {{-- ─── 24 جلسة (FEATURED) ─── --}}
      <div class="reveal-scale rounded-3xl p-8 flex flex-col gap-8 relative overflow-hidden" style="transition-delay:80ms">
        {{-- خلفية primary تعمل في الوضعين --}}
        <div class="absolute inset-0 bg-primary rounded-3xl"></div>
        {{-- نقاط خفيفة --}}
        <div class="absolute inset-0 opacity-[0.06] rounded-3xl pointer-events-none"
             style="background-image:radial-gradient(circle,white 1px,transparent 1px);background-size:18px 18px;"></div>

        <div class="relative z-10 flex flex-col gap-8 h-full">
          {{-- شارة --}}
          <div class="self-start bg-white/20 border border-white/25 text-white text-[9px] font-black uppercase tracking-widest px-3 py-1.5 rounded-full">
            ⭐ {{ __('Most Popular') }}
          </div>
          <div>
            <span class="text-[10px] font-black uppercase tracking-widest text-white/60">{{ __('24 Sessions') }}</span>
            <div class="mt-3 flex items-end gap-2 leading-none">
              <span class="text-5xl font-black text-white">750</span>
              <span class="text-base font-bold text-white/60 pb-1">KD</span>
            </div>
            <p class="text-white/60 text-xs font-bold mt-2">
              {{ app()->getLocale()=='ar' ? '≈ 31 د.ك للجلسة' : '≈ 31 KD / session' }}
            </p>
          </div>
          <ul class="flex flex-col gap-3 flex-1">
            @foreach([__('Significant Behavioral Change'), __('Duration: 3 Months'), __('2 Days / Week')] as $f)
            <li class="flex items-center gap-3 text-sm text-white/85">
              <svg class="w-4 h-4 text-white/70 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
              {{ $f }}
            </li>
            @endforeach
          </ul>
          <a href="https://wa.me/96555665161" target="_blank"
             class="w-full bg-white text-primary font-black py-3.5 rounded-2xl text-center text-sm hover:bg-gray-50 transition-colors shadow-lg">
            {{ __('Choose Plan') }}
          </a>
        </div>
      </div>

      {{-- ─── 36 جلسة ─── --}}
      <div class="reveal-scale bg-[var(--surface-color)] dark:bg-dark-surface rounded-3xl border border-[var(--border-color)] dark:border-dark-border p-8 flex flex-col gap-8 hover:shadow-xl hover:shadow-primary/10 hover:border-primary/30 transition-all duration-300" style="transition-delay:160ms">
        <div>
          <span class="text-[10px] font-black uppercase tracking-widest text-[var(--muted-color)]">{{ __('36 Sessions') }}</span>
          <div class="mt-3 flex items-end gap-2 leading-none">
            <span class="text-5xl font-black text-[var(--text-color)]">900</span>
            <span class="text-base font-bold text-[var(--muted-color)] pb-1">KD</span>
          </div>
        </div>
        <ul class="flex flex-col gap-3 flex-1">
          @foreach([__('Total Mastery & Skills'), __('Duration: 3 Months'), __('3 Days / Week')] as $f)
          <li class="flex items-center gap-3 text-sm text-[var(--muted-color)]">
            <svg class="w-4 h-4 text-primary shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
            {{ $f }}
          </li>
          @endforeach
        </ul>
        <a href="https://wa.me/96555665161" class="btn-outline w-full text-center py-3 text-sm">{{ __('Select Package') }}</a>
      </div>

      {{-- ─── يومي ─── --}}
      <div class="reveal-scale bg-[var(--surface-color)] dark:bg-dark-surface rounded-3xl border-2 border-dashed border-primary/30 dark:border-primary/25 p-8 flex flex-col gap-8 hover:shadow-xl hover:shadow-primary/10 transition-all duration-300" style="transition-delay:240ms">
        <div>
          <span class="text-[10px] font-black uppercase tracking-widest text-primary">{{ __('Daily Subscription') }}</span>
          <div class="mt-3 flex items-end gap-2 leading-none">
            <span class="text-4xl font-black text-[var(--text-color)]">1950</span>
            <span class="text-xs font-bold text-[var(--muted-color)] pb-1">KD/{{ app()->getLocale()=='ar' ? 'شهر' : 'mo' }}</span>
          </div>
        </div>
        <ul class="flex flex-col gap-3 flex-1">
          <li class="flex items-center gap-3 text-sm font-bold text-primary">
            <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
            {{ __('Comprehensive Daily Care') }}
          </li>
          <li class="flex items-center gap-3 text-sm text-[var(--muted-color)]">
            <svg class="w-4 h-4 text-primary shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
            {{ __('Club + Sessions + Reinforcement') }}
          </li>
        </ul>
        <a href="https://wa.me/96555665161" class="btn-motmaena w-full text-center py-3 text-sm">{{ __('Inquire Now') }}</a>
      </div>

    </div>
  </div>
</section>


{{-- ════════════════════════════════════════════════════
  النادي + تقوية المواد
════════════════════════════════════════════════════ --}}
<section class="bg-[var(--surface-color)] dark:bg-dark-surface py-20 sm:py-24">
  <div class="container mx-auto px-6">

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

      {{-- النادي --}}
      <div class="reveal-left relative rounded-3xl overflow-hidden">
        <div class="absolute inset-0 bg-primary"></div>
        <div class="absolute inset-0 opacity-[0.06] pointer-events-none"
             style="background-image:radial-gradient(circle,white 1px,transparent 1px);background-size:20px 20px;"></div>
        <div class="relative z-10 p-10 sm:p-12">
          <span class="inline-block text-[10px] font-black uppercase tracking-widest bg-white/15 border border-white/20 text-white px-3 py-1.5 rounded-full mb-8">{{ __('The Club') }}</span>
          <h3 class="text-2xl sm:text-3xl font-black text-white mb-8">{{ __('Monthly Subscriptions') }}</h3>

          <div class="flex flex-col sm:flex-row items-start sm:items-end justify-between gap-8">
            <div class="space-y-4">
              <div class="flex items-center gap-4">
                <span class="text-2xl font-black text-white">150 KD</span>
                <span class="text-xs text-white/60 font-bold uppercase">{{ __('Per Month') }}</span>
              </div>
              <div class="flex items-center gap-4">
                <span class="text-2xl font-black text-white">250 KD</span>
                <span class="text-xs text-white/60 font-bold uppercase">{{ __('For 2 Months') }}</span>
              </div>
            </div>
            <div class="bg-white/12 backdrop-blur border border-white/20 rounded-2xl p-6 text-center min-w-[160px]">
              <p class="text-[9px] font-black uppercase tracking-wider text-white/50 mb-2">{{ __('Sibling Discount') }}</p>
              <p class="text-3xl font-black text-yellow-300 leading-none">135 KD</p>
              <p class="text-[9px] text-white/50 mt-2">{{ __('Per person / Month only') }}</p>
            </div>
          </div>
        </div>
      </div>

      {{-- تقوية المواد --}}
      <div class="reveal-right bg-[var(--bg-color)] dark:bg-dark-bg rounded-3xl border border-[var(--border-color)] dark:border-dark-border p-10 sm:p-12 hover:border-primary/30 hover:shadow-xl hover:shadow-primary/8 transition-all duration-300">
        <div class="flex items-start justify-between gap-4 mb-8">
          <div>
            <h3 class="text-2xl sm:text-3xl font-black text-[var(--text-color)]">{{ __('Subject Reinforcement') }}</h3>
            <p class="text-sm text-[var(--muted-color)] mt-1.5">{{ __('Arabic, English, Social, Islamic, and Science') }}</p>
          </div>
          <div class="shrink-0 text-end">
            <div class="text-4xl font-black text-primary leading-none">200</div>
            <div class="text-[10px] font-black text-[var(--muted-color)] uppercase tracking-wider mt-0.5">KD</div>
          </div>
        </div>
        <div class="grid grid-cols-2 gap-3">
          @foreach([
            ['icon'=>'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',  'l'=> __('1.5 Hours / Session')],
            ['icon'=>'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'l'=> __('2 Days / Week')],
            ['icon'=>'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2', 'l'=> __('8 Total Sessions')],
            ['icon'=>'M5 13l4 4L19 7', 'l'=> __('Comprehensive Follow-up')],
          ] as $row)
          <div class="flex items-center gap-3 bg-[var(--surface-color)] dark:bg-dark-surface rounded-2xl p-4">
            <div class="w-8 h-8 bg-primary/10 rounded-xl flex items-center justify-center text-primary shrink-0">
              <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $row['icon'] }}"/>
              </svg>
            </div>
            <span class="text-xs font-bold text-[var(--text-color)]">{{ $row['l'] }}</span>
          </div>
          @endforeach
        </div>
      </div>

    </div>
  </div>
</section>


{{-- ════════════════════════════════════════════════════
  فاصل
════════════════════════════════════════════════════ --}}
<div class="bg-[var(--bg-color)] py-10 reveal">
  <div class="container mx-auto px-6 flex items-center gap-5">
    <div class="flex-1 h-px bg-[var(--border-color)] dark:bg-dark-border"></div>
    <span class="text-[11px] font-black uppercase tracking-[.22em] text-[var(--muted-color)] shrink-0">
      {{ __('Specialized Support') }}
    </span>
    <div class="flex-1 h-px bg-[var(--border-color)] dark:bg-dark-border"></div>
  </div>
</div>


{{-- ════════════════════════════════════════════════════
  الخدمات المتخصصة — توحد / داون / إعاقة
════════════════════════════════════════════════════ --}}
<section id="specialized-services" class="bg-[var(--bg-color)] pb-20 sm:pb-28">
  <div class="container mx-auto px-6">

    {{-- عنوان القسم --}}
    <div class="text-center mb-14 reveal">
      <span class="inline-flex items-center gap-2 text-[11px] font-black uppercase tracking-[.2em] text-primary">
        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
        </svg>
        {{ __('Specialized Support') }}
      </span>
      <h2 class="text-2xl sm:text-4xl font-black text-[var(--text-color)] mt-3 mb-4">
        {{ __('Services for Autism, Down Syndrome, & Disabilities') }}
      </h2>
      <p class="text-[var(--muted-color)] text-sm sm:text-base max-w-xl mx-auto leading-relaxed">
        {{ __('Highly specialized therapeutic programs tailored for children with neurodevelopmental and physical challenges, delivered by experts.') }}
      </p>
    </div>

    {{-- بطاقتا التقييم --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-10">
      @foreach([
        ['dir'=>'reveal-left',  'icon'=>'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'title'=>__('Opening Evaluation'),  'sub'=>__('Specialized assessment protocols'),   'price'=>50],
        ['dir'=>'reveal-right', 'icon'=>'M11 4a2 2 0 114 0v1a2 2 0 012 2v3a2 2 0 01-2 2H9a2 2 0 01-2-2V7a2 2 0 012-2V4m2 10v2m0 4h.01M6 20h12a2 2 0 002-2v-1a2 2 0 00-2-2H6a2 2 0 00-2 2v1a2 2 0 002 2z', 'title'=>__('Disability Diagnosis'), 'sub'=>__('Global standardized intelligence tests'), 'price'=>120],
      ] as $c)
      <div class="{{ $c['dir'] }} bg-[var(--surface-color)] dark:bg-dark-surface rounded-3xl border border-[var(--border-color)] dark:border-dark-border p-8 flex items-center justify-between gap-6 group hover:border-primary/40 hover:shadow-lg hover:shadow-primary/8 transition-all duration-300">
        <div class="flex items-center gap-5">
          <div class="w-12 h-12 rounded-2xl bg-primary/10 flex items-center justify-center text-primary shrink-0 group-hover:bg-primary group-hover:text-white transition-all duration-300">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $c['icon'] }}"/>
            </svg>
          </div>
          <div>
            <p class="font-black text-[var(--text-color)] text-base">{{ $c['title'] }}</p>
            <p class="text-sm text-[var(--muted-color)] mt-0.5">{{ $c['sub'] }}</p>
          </div>
        </div>
        <div class="shrink-0 text-end">
          <div class="text-4xl font-black text-primary leading-none">{{ $c['price'] }}</div>
          <div class="text-[10px] font-black text-[var(--muted-color)] uppercase tracking-wider mt-0.5">{{ __('KD') }}</div>
        </div>
      </div>
      @endforeach
    </div>

    {{-- 3 باقات متخصصة --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-10">
      @php
      $spkgs = [
        ['dir'=>'reveal-left',  'label'=>__('Intensive Month'),   'sub'=>__('12 Sessions'), 'price'=>360, 'sched'=>__('3 Days Per Week'),            'btn'=>__('Book Now'),     'featured'=>false],
        ['dir'=>'reveal-scale', 'label'=>__('Therapeutic Track'), 'sub'=>__('24 Sessions'), 'price'=>750, 'sched'=>__('2 Days Per Week / 3 Months'),  'btn'=>__('Choose Track'), 'featured'=>true],
        ['dir'=>'reveal-right', 'label'=>__('Advanced Track'),    'sub'=>__('36 Sessions'), 'price'=>900, 'sched'=>__('3 Days Per Week / 3 Months'),  'btn'=>__('Get Started'),  'featured'=>false],
      ];
      @endphp
      @foreach($spkgs as $pkg)

      @if($pkg['featured'])
      <div class="{{ $pkg['dir'] }} relative rounded-3xl p-10 flex flex-col items-center text-center gap-8 overflow-hidden shadow-2xl shadow-primary/20 dark:shadow-primary/35">
        <div class="absolute inset-0 bg-primary rounded-3xl"></div>
        <div class="absolute inset-0 opacity-[0.06] rounded-3xl pointer-events-none"
             style="background-image:radial-gradient(circle,white 1px,transparent 1px);background-size:16px 16px;"></div>
        <div class="relative z-10 flex flex-col items-center gap-8 w-full">
          <div class="bg-white/20 border border-white/30 text-white text-[9px] font-black uppercase tracking-widest px-4 py-1.5 rounded-full self-center">
            ✦ {{ __('Best Value') }} ✦
          </div>
          <div class="text-center">
            <p class="text-[10px] font-black uppercase tracking-widest text-white/60 mb-3">{{ $pkg['label'] }} · {{ $pkg['sub'] }}</p>
            <div class="flex items-end gap-2 justify-center leading-none">
              <span class="text-6xl font-black text-white">{{ $pkg['price'] }}</span>
              <span class="text-lg font-bold text-white/60 pb-1">KD</span>
            </div>
          </div>
          <div class="bg-white/10 border border-white/15 rounded-2xl px-6 py-4 w-full">
            <p class="text-[9px] text-white/60 font-black uppercase tracking-wider mb-1.5">{{ __('Schedule') }}</p>
            <p class="text-sm font-black text-white">{{ $pkg['sched'] }}</p>
          </div>
          <a href="https://wa.me/96555665161"
             class="w-full bg-white text-primary font-black py-4 rounded-2xl text-sm hover:bg-gray-50 transition-colors shadow-lg">
            {{ $pkg['btn'] }}
          </a>
        </div>
      </div>

      @else
      <div class="{{ $pkg['dir'] }} bg-[var(--surface-color)] dark:bg-dark-surface rounded-3xl border border-[var(--border-color)] dark:border-dark-border p-10 flex flex-col items-center text-center gap-8 hover:shadow-xl hover:shadow-primary/8 hover:border-primary/30 transition-all duration-300">
        <div class="text-center w-full">
          <p class="text-[10px] font-black uppercase tracking-widest text-[var(--muted-color)] mb-3">{{ $pkg['label'] }} · {{ $pkg['sub'] }}</p>
          <div class="flex items-end gap-2 justify-center leading-none">
            <span class="text-6xl font-black text-[var(--text-color)]">{{ $pkg['price'] }}</span>
            <span class="text-lg font-bold text-[var(--muted-color)] pb-1">KD</span>
          </div>
        </div>
        <div class="bg-[var(--bg-color)] dark:bg-dark-bg border border-[var(--border-color)] dark:border-dark-border rounded-2xl px-6 py-4 w-full">
          <p class="text-[9px] text-[var(--muted-color)] font-black uppercase tracking-wider mb-1.5">{{ __('Schedule') }}</p>
          <p class="text-sm font-black text-[var(--text-color)]">{{ $pkg['sched'] }}</p>
        </div>
        <a href="https://wa.me/96555665161" class="btn-motmaena w-full py-4 text-sm">{{ $pkg['btn'] }}</a>
      </div>
      @endif

      @endforeach
    </div>

    {{-- يومي + نادي الاستقبال --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 reveal">

      {{-- الاشتراك اليومي المتخصص --}}
      <div class="relative rounded-3xl overflow-hidden min-h-[300px]">
        <div class="absolute inset-0 bg-gray-950 dark:bg-[#0a0a0a]"></div>
        <div class="absolute inset-0 bg-gradient-to-br from-primary/45 to-transparent"></div>
        <div class="absolute inset-0 opacity-[0.04] pointer-events-none"
             style="background-image:radial-gradient(circle,white 1px,transparent 1px);background-size:16px 16px;"></div>

        <div class="relative z-10 p-10 sm:p-12 flex flex-col gap-8 h-full text-white">
          <div>
            <span class="inline-flex items-center gap-2 bg-white/10 border border-white/15 text-[10px] font-black uppercase tracking-widest px-3 py-1.5 rounded-full mb-6">
              <span class="w-1.5 h-1.5 bg-primary rounded-full animate-pulse"></span>
              {{ __('All-Inclusive') }}
            </span>
            <h3 class="text-2xl sm:text-3xl font-black mb-4 leading-snug">{{ __('Daily Specialized Subscription') }}</h3>
            <div class="flex items-end gap-2">
              <span class="text-5xl font-black text-primary leading-none">1950</span>
              <span class="text-base font-bold text-white/50 pb-1 uppercase">{{ __('KD / Month') }}</span>
            </div>
          </div>
          <div class="grid grid-cols-3 gap-3 mt-auto">
            @foreach([__('Club'), __('Clinical Sessions'), __('Academic Support')] as $item)
            <div class="bg-white/6 border border-white/10 rounded-2xl py-4 px-2 text-center">
              <span class="block w-1.5 h-1.5 bg-primary rounded-full mx-auto mb-2.5 shadow-[0_0_8px_#b04141]"></span>
              <span class="text-[9px] font-bold uppercase tracking-wide leading-tight">{{ $item }}</span>
            </div>
            @endforeach
          </div>
        </div>
      </div>

      {{-- نادي الاستقبال --}}
      <div class="bg-[var(--surface-color)] dark:bg-dark-surface rounded-3xl border border-[var(--border-color)] dark:border-dark-border p-10 sm:p-12 flex flex-col justify-between hover:border-primary/30 hover:shadow-xl hover:shadow-primary/8 transition-all duration-300 group">
        <div>
          <div class="flex items-center gap-4 mb-5">
            <div class="w-12 h-12 bg-primary/10 rounded-2xl flex items-center justify-center text-primary shrink-0 group-hover:bg-primary group-hover:text-white transition-all duration-300">
              <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
              </svg>
            </div>
            <h3 class="text-xl sm:text-2xl font-black text-[var(--text-color)]">{{ __('Specialized Reception Club') }}</h3>
          </div>
          <p class="text-sm text-[var(--muted-color)] leading-relaxed mb-8">
            {{ __('Morning support program focused on social integration and basic skills development for children with disabilities.') }}
          </p>
          <div class="grid grid-cols-2 gap-6 mb-8">
            <div class="border-s-2 border-primary/25 ps-4">
              <p class="text-[9px] font-black text-[var(--muted-color)] uppercase tracking-widest mb-1">{{ __('Duration') }}</p>
              <p class="font-black text-[var(--text-color)]">{{ __('1 Month') }}</p>
            </div>
            <div class="border-s-2 border-primary/25 ps-4">
              <p class="text-[9px] font-black text-[var(--muted-color)] uppercase tracking-widest mb-1">{{ __('Availability') }}</p>
              <p class="font-black text-[var(--text-color)]">{{ __('Sun - Thu') }}</p>
            </div>
          </div>
        </div>
        <div class="flex items-center justify-between pt-6 border-t border-[var(--border-color)] dark:border-dark-border">
          <div class="flex items-end gap-1.5 leading-none">
            <span class="text-4xl font-black text-primary">200</span>
            <span class="text-sm font-bold text-[var(--muted-color)] pb-0.5 uppercase">KD</span>
          </div>
          <a href="https://wa.me/96555665161" class="btn-motmaena px-8 py-3 text-sm">{{ __('Inquire') }}</a>
        </div>
      </div>

    </div>
  </div>
</section>


{{-- ════════════════════════════════════════════════════
  CTA
════════════════════════════════════════════════════ --}}
<section class="bg-primary py-20 sm:py-28 relative overflow-hidden">
  <div class="absolute inset-0 opacity-[0.05] pointer-events-none"
       style="background-image:radial-gradient(circle,white 1px,transparent 1px);background-size:22px 22px;"></div>
  <div class="container mx-auto px-6 text-center relative z-10 reveal">

    <h2 class="text-3xl sm:text-4xl md:text-5xl font-black text-white mb-5 leading-tight">
      {{ __("Ready to Start Your Child's Journey?") }}
    </h2>
    <p class="text-white/70 text-base sm:text-lg max-w-xl mx-auto mb-10 leading-relaxed">
      {{ __("Our specialized consultants are ready to assist you in choosing the most appropriate path for your child's unique needs.") }}
    </p>

    <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-8">
      <a href="https://wa.me/96555665161" target="_blank"
         class="bg-white text-primary font-black px-10 py-4 rounded-2xl shadow-xl hover:bg-gray-50 transition-all hover:-translate-y-0.5 flex items-center gap-3 text-base">
        <svg class="w-5 h-5 text-[#25D366]" viewBox="0 0 24 24" fill="currentColor">
          <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.72.937 3.658 1.43 5.623 1.43h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
        </svg>
        {{ __('Talk to a Specialist') }}
      </a>
      <a href="tel:+96555665161"
         class="bg-white/15 border border-white/25 font-black px-10 py-4 rounded-2xl text-white hover:bg-white/25 transition-all hover:-translate-y-0.5 flex items-center gap-3 text-base">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
        </svg>
        {{ __('Call Us Directly') }}
      </a>
    </div>

    <p class="text-white/40 text-xs font-bold tracking-widest uppercase">
      {{ __('Opening Evaluation Fee: 50 KD') }}
    </p>
  </div>
</section>

@endsection
