{{-- An old course link (held or closed): say so clearly, offer "notify me" and the courses open now. --}}
@extends('layouts.app')

@php
    $isAr = app()->getLocale() == 'ar';
    $lang = $isAr ? 'ar' : 'en';
    $t = fn ($ar, $en) => $isAr ? $ar : $en;
    $when = fn ($o) => \Carbon\Carbon::parse($o['date'])->locale($lang);
@endphp

@section('title', $t('انتهت ', 'Ended: ') . $offer['title'][$lang] . ' - ' . __('Motmaena Center'))
@section('meta_description', $held
    ? $t('انتهت ' . $offer['title']['ar'] . '. سجّل رقمك ونبلغك بالموعد القادم، أو اطّلع على الدورات المفتوحة في مركز مطمئنة.', $offer['title']['en'] . ' has ended. Leave your number for the next date, or see the courses open now at Motmaena Center.')
    : $t('التسجيل في ' . $offer['title']['ar'] . ' مغلق حالياً. سجّل رقمك ونبلغك بالموعد القادم.', 'Registration for ' . $offer['title']['en'] . ' is closed for now. Leave your number for the next date.'))

@section('content')
@include('partials.lx-styles')
<section class="lx lx-ivory py-14 sm:py-20" dir="{{ $isAr ? 'rtl' : 'ltr' }}">
    <div class="container mx-auto px-4 max-w-3xl flex flex-col gap-8">

        <div class="flex flex-col gap-4">
            <p class="lx-label">{{ $held ? $t('دورة سابقة', 'Past course') : $t('التسجيل مغلق', 'Registration closed') }}</p>
            <h1 class="lx-h2">{{ $offer['title'][$lang] }}</h1>
            <p class="lx-text text-lg">
                @if($held)
                    {{ $t('انتهت هذه الدورة بتاريخ ' . $when($offer)->translatedFormat('j F Y') . '. شكراً لاهتمامك.', 'This course took place on ' . $when($offer)->translatedFormat('j F Y') . '. Thank you for your interest.') }}
                @else
                    {{ $t('التسجيل في هذه الدورة مغلق حالياً.', 'Registration for this course is closed for now.') }}
                @endif
            </p>
        </div>

        <div class="lx-card p-6 sm:p-8 flex flex-col gap-4">
            <h2 class="lx-h3">{{ $t('بلّغني بالموعد القادم', 'Tell me about the next date') }}</h2>
            <p class="lx-muted font-semibold">{{ $t('اترك رقم الواتساب ونبلغك أول ما يُفتح موعد جديد لهذه الدورة.', 'Leave your WhatsApp number and we will tell you when a new date opens.') }}</p>
            @include('partials.notify-form', ['courseKey' => $offerKey])
        </div>

        @if($upcoming->isNotEmpty())
        <div class="flex flex-col gap-4">
            <h2 class="lx-h3">{{ $t('دورات مفتوحة للتسجيل الآن', 'Courses open for registration now') }}</h2>
            @foreach($upcoming as $c)
                <a href="{{ route('course.register', $c['slug']) }}" class="lx-card p-4 sm:p-5 flex items-center gap-4 hover:border-[color:var(--wine)] transition-colors">
                    <div class="lx-date"><b>{{ $when($c)->format('j') }}</b><span>{{ $when($c)->translatedFormat('F') }}</span></div>
                    <div class="flex-1 min-w-0">
                        <p class="font-extrabold" style="color: var(--ink)">{{ $c['title'][$lang] }}</p>
                        <p class="text-sm lx-muted font-semibold mt-1">{{ $c['day'][$lang] }}@if($c['time'][$lang]) · {{ $c['time'][$lang] }}@endif</p>
                    </div>
                    <span class="font-extrabold whitespace-nowrap" style="color: var(--ink)">{{ $c['price'] }} <small class="text-xs lx-muted">{{ $t('د.ك', 'KWD') }}</small></span>
                </a>
            @endforeach
        </div>
        @endif

        <div class="flex flex-col sm:flex-row gap-3">
            <a href="{{ route('courses') }}" class="lx-btn lx-btn-outline">{{ $t('كل الدورات', 'All courses') }}</a>
            <a href="{{ route('home') }}" class="lx-btn lx-btn-outline">{{ $t('الصفحة الرئيسية', 'Home') }}</a>
        </div>
    </div>
</section>
@endsection
