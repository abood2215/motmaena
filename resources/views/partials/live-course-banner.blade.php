{{-- One open (live) course on the courses page, in the quiet editorial look: $offer = CourseOffer::toOfferArray(). --}}
@php
    $isArB = app()->getLocale() == 'ar';
    $langB = $isArB ? 'ar' : 'en';
    $tB = fn ($ar, $en) => $isArB ? $ar : $en;
    $dateB = \Carbon\Carbon::parse($offer['date'])->locale($langB);
@endphp
@include('partials.lx-styles')
<article class="lx lx-card p-6 sm:p-8 grid lg:grid-cols-12 gap-6 lg:gap-10 items-start" dir="{{ $isArB ? 'rtl' : 'ltr' }}">
    <div class="lg:col-span-7 flex items-start gap-5">
        {{-- Phones: the date is in the details below, so the text gets the full width --}}
        <div class="lx-date max-sm:!hidden"><b>{{ $dateB->format('j') }}</b><span>{{ $dateB->translatedFormat('F') }}</span></div>
        <div class="min-w-0">
            <p class="lx-label mb-2">{{ $offer['badge'][$langB] }}</p>
            <h2 class="lx-h2 !text-[1.6rem] mb-1">{{ $offer['title'][$langB] }}</h2>
            <p class="lx-muted font-semibold mb-4">{{ $tB('مع', 'with') }} {{ $offer['trainer'][$langB] }}</p>
            <div class="space-y-1.5 text-sm font-semibold">
                <p class="flex items-center gap-2.5">@include('partials.lx-icon', ['i' => 'calendar', 'class' => '!w-[18px] !h-[18px]']){{ $offer['day'][$langB] }} {{ $dateB->translatedFormat('j F Y') }}@if($offer['time'][$langB]) · {{ $offer['time'][$langB] }}@endif</p>
                <p class="flex items-center gap-2.5">@include('partials.lx-icon', ['i' => 'pin', 'class' => '!w-[18px] !h-[18px]']){{ $offer['location'][$langB] ?: $tB('حضوري · الكويت', 'In person · Kuwait') }}</p>
                @if($offer['certificate'][$langB])<p class="flex items-start gap-2.5">@include('partials.lx-icon', ['i' => 'award', 'class' => '!w-[18px] !h-[18px] mt-0.5']){{ $offer['certificate'][$langB] }}</p>@endif
            </div>
        </div>
    </div>

    <div class="lg:col-span-5 lg:border-s lg:ps-10 flex flex-col gap-4" style="border-color: var(--line)">
        <div>
            <span class="font-extrabold text-3xl" style="color: var(--ink)">{{ $offer['price'] }} <small class="text-base lx-muted">{{ $tB('د.ك', 'KWD') }}</small></span>
            @if($offer['seats_left'] !== null)<p class="text-sm font-bold {{ $offer['is_full'] ? 'text-red-700' : 'lx-muted' }}">{{ $offer['is_full'] ? $tB('اكتمل العدد', 'Fully booked') : $tB('متبقي ' . $offer['seats_left'] . ' مقعد', $offer['seats_left'] . ' seats left') }}</p>@endif
            @if($offer['show_installments'] && !$offer['is_full'])<p class="text-sm lx-muted font-semibold">{{ $tB('أو 4 دفعات مع deema', 'or 4 payments with deema') }}</p>@endif
        </div>
        @if($offer['is_full'])
            <div>@include('partials.notify-form', ['courseKey' => $offer['slug']])</div>
        @else
            <a href="{{ route('course.register', $offer['slug']) }}" class="lx-btn lx-btn-primary w-full">{{ $tB('التسجيل في الدورة', 'Register') }}</a>
        @endif
    </div>
</article>
