{{-- Banner for one open (live) course: $offer = CourseOffer::toOfferArray(). Colours follow the course theme. --}}
@php
    $isArB = app()->getLocale() == 'ar';
    $langB = $isArB ? 'ar' : 'en';
    $tB = fn ($ar, $en) => $isArB ? $ar : $en;
    $giftB = \App\Models\CourseRegistration::giftAmount();
    $giftTxtB = \App\Models\CourseRegistration::giftAmountText();
    $dateB = \Carbon\Carbon::parse($offer['date'])->locale($langB);
@endphp
<article class="live-course relative overflow-hidden rounded-3xl text-white shadow-xl reveal" dir="{{ $isArB ? 'rtl' : 'ltr' }}"
         style="{{ \App\Models\CourseOffer::paletteCss($offer['theme']) }}; background: linear-gradient(135deg, var(--c1) 0%, var(--c2) 100%);">
    <div class="absolute -top-24 {{ $isArB ? '-left-24' : '-right-24' }} w-72 h-72 rounded-full bg-white/10 pointer-events-none"></div>

    <div class="relative grid grid-cols-1 md:grid-cols-12 items-end">
        <div class="md:col-span-8 p-6 sm:p-8 lg:p-10">
            <span class="inline-flex items-center gap-2 rounded-full bg-white/15 border border-white/25 px-3.5 py-1.5 text-xs font-black mb-4">
                <span class="w-2 h-2 rounded-full bg-emerald-300 animate-pulse"></span>
                {{ $offer['badge'][$langB] }}@if($offer['seats_left'] !== null) · {{ $offer['is_full'] ? $tB('اكتمل العدد', 'Fully booked') : $tB('متبقي ' . $offer['seats_left'] . ' مقعد', $offer['seats_left'] . ' seats left') }}@endif
            </span>

            <h2 class="font-black leading-tight mb-2" style="font-size: clamp(1.8rem, 4vw, 2.8rem);">{{ $offer['title'][$langB] }}</h2>
            <p class="text-white/85 font-bold mb-5">
                {{ $tB('مع', 'with') }} <span class="font-black text-white">{{ $offer['trainer'][$langB] }}</span>
                @if($offer['certificate'][$langB])<span class="block text-sm text-white/70 mt-1">{{ $offer['certificate'][$langB] }}</span>@endif
            </p>

            <div class="flex flex-wrap gap-2 mb-5 text-sm font-bold">
                <span class="rounded-xl border border-white/20 px-3 py-1.5" style="background: rgba(255,255,255,.12)">📅 {{ $offer['day'][$langB] }} {{ $dateB->translatedFormat('j F') }}</span>
                @if($offer['time'][$langB])<span class="rounded-xl border border-white/20 px-3 py-1.5" style="background: rgba(255,255,255,.12)">🕖 {{ $offer['time'][$langB] }}</span>@endif
                @if($offer['location'][$langB])<span class="rounded-xl border border-white/20 px-3 py-1.5" style="background: rgba(255,255,255,.12)">📍 {{ $offer['location'][$langB] }}</span>@endif
            </div>

            @include('partials.countdown', ['startsAt' => $offer['starts_at'], 'dark' => true, 'class' => 'mb-6'])

            @if($offer['is_full'])
                <div class="max-w-md text-gray-900">@include('partials.notify-form', ['courseKey' => $offer['slug']])</div>
            @else
                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('course.register', $offer['slug']) }}"
                       class="inline-flex items-center justify-center gap-2 rounded-2xl bg-white px-7 py-4 text-lg font-black shadow-lg hover:-translate-y-0.5 transition" style="color: var(--c1)">
                        {{ $tB('احجز مقعدك', 'Book your seat') }} · {{ $offer['price'] }} {{ $tB('د.ك', 'KWD') }}
                    </a>
                    @if($offer['show_installments'])
                        <span class="text-sm font-bold text-white/85">{{ $tB('أو قسّطها على 4 دفعات مع deema', 'or split into 4 payments with deema') }}</span>
                    @endif
                </div>
                @if($giftB > 0)
                    <p class="mt-4 inline-flex items-center gap-2 rounded-xl px-3.5 py-2 text-sm font-black text-[#3b1d00]" style="background: linear-gradient(160deg, #fde68a, #fbbf24)">
                        🎁 {{ $tB('احجز وخذ كود هدية بقيمة ' . $giftTxtB . ' د.ك', 'Book and get a ' . $giftTxtB . ' KWD gift code') }}
                    </p>
                @endif
            @endif
        </div>

        <div class="hidden md:flex md:col-span-4 justify-center items-end self-stretch">
            <img src="{{ asset($offer['image']) }}" alt="{{ $offer['trainer'][$langB] }}" class="max-h-[380px] w-auto object-contain object-bottom drop-shadow-2xl" loading="lazy">
        </div>
    </div>
</article>
