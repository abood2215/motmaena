@extends('layouts.app')

@php
    $lang = app()->getLocale() == 'ar' ? 'ar' : 'en';
    $isAr = $lang === 'ar';
    $kwd = $isAr ? 'د.ك' : 'KWD';
    $price = number_format((float) $offer['price'], 3);
    $giftAmount = \App\Models\CourseRegistration::giftAmount();
    $giftTxt = \App\Models\CourseRegistration::giftAmountText();
@endphp

@section('title', ($isAr ? 'التسجيل في ' : 'Register: ') . $offer['title'][$lang] . ' - ' . __('Motmaena Center'))

@if($offer['share_image'])
    @section('og_image', asset($offer['share_image']))
@endif
@section('meta_description', $offer['title'][$lang] . ' — ' . $offer['trainer'][$lang] . ' · ' . $offer['day'][$lang] . ' ' . \Carbon\Carbon::parse($offer['date'])->format('Y/m/d') . ' · ' . $offer['price'] . ($isAr ? ' د.ك' : ' KWD'))

@section('content')

{{-- Checkout always uses the center's wine palette (course colours stay on the homepage banner) --}}
<style>
    .co-page { background: linear-gradient(180deg, var(--ct) 0%, #fff 320px); }
    .dark .co-page { background: #0b0f14; }
    .co-card { background: #fff; border: 1px solid var(--cbd); border-radius: 22px; box-shadow: 0 1px 2px rgba(16,24,40,.04), 0 12px 32px -18px rgba(16,24,40,.18); }
    .dark .co-card { background: #141a22; border-color: rgba(255,255,255,.08); }
    .co-head { background: linear-gradient(135deg, var(--c1) 0%, var(--c2) 100%); }
    .co-input { width: 100%; border: 1.5px solid #e5e7eb; background: #fff; border-radius: 12px; padding: 12px 14px; font-size: 15px; font-weight: 600; outline: none; transition: border-color .15s, box-shadow .15s; color: #111827; }
    .co-input:focus { border-color: var(--c1); box-shadow: 0 0 0 4px color-mix(in srgb, var(--c1) 12%, transparent); }
    .dark .co-input { background: rgba(255,255,255,.04); border-color: rgba(255,255,255,.12); color: #fff; }
    .co-label { display: block; font-size: 13px; font-weight: 800; color: #374151; margin-bottom: 6px; }
    .dark .co-label { color: #d1d5db; }
    .co-pay { background: var(--c1); box-shadow: 0 10px 24px -10px var(--c1); transition: background .15s, transform .15s; }
    .co-pay:hover { background: color-mix(in srgb, var(--c1) 88%, #000); transform: translateY(-1px); }
    .co-step { display: inline-flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 800; color: #9ca3af; }
    .co-step b { width: 24px; height: 24px; border-radius: 99px; display: inline-flex; align-items: center; justify-content: center; font-size: 12px; background: #f3f4f6; color: #6b7280; }
    .co-step.on { color: var(--c1); }
    .co-step.on b { background: var(--c1); color: #fff; }
    .dark .co-step.on { color: var(--ca); }
    /* Numbered form sections: 1 your details, 2 payment */
    .co-sec { display: flex; align-items: center; gap: 10px; font-size: 18px; font-weight: 900; color: #111827; }
    .co-sec b { width: 28px; height: 28px; border-radius: 99px; display: inline-flex; align-items: center; justify-content: center; font-size: 13px; background: var(--c1); color: #fff; flex-shrink: 0; }
    .dark .co-sec { color: #fff; }
    .co-sec-sub { font-size: 13px; font-weight: 600; color: #6b7280; margin: 4px 38px 0 0; }
    [dir="ltr"] .co-sec-sub { margin: 4px 0 0 38px; }
    .dark .co-sec-sub { color: #9ca3af; }
    .pm-opt { display: flex; align-items: center; gap: 12px; padding: 14px 16px; border: 1.5px solid #e5e7eb; border-radius: 16px; background: #fff; cursor: pointer; transition: border-color .15s, background .15s, box-shadow .15s; }
    .pm-opt:hover { border-color: color-mix(in srgb, var(--c1) 45%, #e5e7eb); }
    .pm-opt:has(.pm-radio:checked) { border-color: var(--c1); background: color-mix(in srgb, var(--c1) 4%, #fff); box-shadow: 0 0 0 3px color-mix(in srgb, var(--c1) 10%, transparent); }
    .dark .pm-opt { background: rgba(255,255,255,.03); border-color: rgba(255,255,255,.12); }
    .dark .pm-opt:has(.pm-radio:checked) { border-color: var(--ca); background: rgba(255,255,255,.06); }
    .pm-radio { width: 20px; height: 20px; flex-shrink: 0; accent-color: var(--c1); }
    .co-code summary::-webkit-details-marker { display: none; }
    .co-gift { background: linear-gradient(135deg, #fffaf0 0%, #fbf0dc 100%); border: 1.5px dashed #d9b877; transition: opacity .2s; }
    .dark .co-gift { background: rgba(251,191,36,.06); border-color: rgba(252,211,77,.3); }
    /* WhatsApp number box */
    .co-wa { background: #f1faf4; border: 1.5px solid #bfe8cd; border-radius: 18px; padding: 16px; transition: border-color .15s, box-shadow .15s; }
    .co-wa:focus-within { border-color: #25d366; box-shadow: 0 0 0 4px rgba(37,211,102,.12); }
    .co-wa.is-bad { background: #fef4f4; border-color: #f3b4b4; }
    .dark .co-wa { background: rgba(37,211,102,.06); border-color: rgba(37,211,102,.28); }
    .co-wa-icon { width: 30px; height: 30px; border-radius: 99px; background: #25d366; color: #fff; display: inline-flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 10px -3px rgba(37,211,102,.6); }
    .co-wa-input { font-size: 19px; font-weight: 800; letter-spacing: .06em; padding-top: 14px; padding-bottom: 14px; border-color: #cfe9d8; font-variant-numeric: tabular-nums; padding-inline-end: 46px; }
    .co-wa-input:focus { border-color: #25d366; box-shadow: none; }
    .co-wa-input::placeholder { letter-spacing: .06em; font-weight: 600; }
    .co-wa-hint { font-size: 12.5px; font-weight: 700; color: #3f6b4f; margin-top: 10px; line-height: 1.7; }
    .dark .co-wa-hint { color: #9fd8b3; }
</style>

<section class="co-page py-8 sm:py-12" dir="{{ $isAr ? 'rtl' : 'ltr' }}" style="{{ \App\Models\CourseOffer::paletteCss(\App\Models\CourseOffer::CHECKOUT_THEME) }}">
    <div class="container mx-auto px-4 max-w-6xl">

        {{-- Steps --}}
        <div class="flex items-center justify-center gap-3 sm:gap-5 mb-8">
            <span class="co-step on"><b>1</b>{{ $isAr ? 'بياناتك' : 'Your details' }}</span>
            <span class="w-8 sm:w-14 h-px bg-gray-300 dark:bg-white/10"></span>
            <span class="co-step"><b>2</b>{{ $isAr ? 'الدفع' : 'Payment' }}</span>
            <span class="w-8 sm:w-14 h-px bg-gray-300 dark:bg-white/10"></span>
            <span class="co-step"><b>3</b>{{ $isAr ? 'التأكيد' : 'Confirmation' }}</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-start">

            {{-- ═══ Order summary ═══ --}}
            <aside class="co-card overflow-hidden lg:col-span-5 lg:order-last lg:sticky lg:top-28">
                <div class="co-head text-white p-5 sm:p-6 flex items-center gap-4">
                    <div class="w-16 h-16 rounded-2xl bg-white/15 overflow-hidden shrink-0 flex items-end justify-center">
                        <img src="{{ asset($offer['image']) }}" alt="" class="h-full w-auto object-cover object-top">
                    </div>
                    <div class="min-w-0">
                        <p class="text-[11px] font-black text-white/70 mb-0.5">{{ $offer['badge'][$lang] }}</p>
                        <h1 class="text-lg sm:text-xl font-black leading-snug">{{ $offer['title'][$lang] }}</h1>
                        <p class="text-sm font-bold text-white/80">{{ $offer['trainer'][$lang] }}</p>
                    </div>
                </div>

                <div class="p-5 sm:p-6 space-y-4">
                    {{-- When / where --}}
                    @php
                        $details = [
                            ['M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', $offer['day'][$lang] . '، ' . \Carbon\Carbon::parse($offer['date'])->locale($lang)->translatedFormat('j F Y')],
                            ['M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', $offer['time'][$lang]],
                            ['M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z', $offer['location'][$lang]],
                            ['M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', $offer['certificate'][$lang]],
                        ];
                    @endphp
                    <ul class="space-y-2.5">
                        @foreach($details as [$icon, $text])
                            @continue(trim((string) $text) === '')
                            <li class="flex items-start gap-2.5 text-sm font-bold text-gray-700 dark:text-gray-200 leading-snug">
                                <svg class="w-[18px] h-[18px] mt-px shrink-0 text-[color:var(--c1)] dark:text-[color:var(--ca)]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}"/></svg>
                                <span>{{ $text }}</span>
                            </li>
                        @endforeach
                    </ul>

                    {{-- Countdown + seats --}}
                    @include('partials.countdown', ['startsAt' => $offer['starts_at'], 'compact' => true])
                    @if($offer['seats_left'] !== null)
                        <p class="text-xs font-black {{ $offer['is_full'] ? 'text-red-700' : ($offer['seats_left'] <= 10 ? 'text-amber-700' : 'text-gray-500 dark:text-gray-400') }}">
                            {{ $offer['is_full'] ? ($isAr ? 'اكتمل العدد' : 'Fully booked') : ($isAr ? 'متبقي ' . $offer['seats_left'] . ' مقعد' : $offer['seats_left'] . ' seats left') }}
                        </p>
                    @endif

                    {{-- Topics (collapsed) --}}
                    @if($offer['topics'][$lang])
                    <details class="group rounded-xl border border-gray-200 dark:border-white/10 px-4 py-3">
                        <summary class="cursor-pointer list-none flex items-center justify-between text-sm font-black text-gray-800 dark:text-gray-100">
                            {{ $isAr ? 'محاور الدورة' : 'Course topics' }} <span class="text-gray-400">({{ count($offer['topics'][$lang]) }})</span>
                            <svg class="w-4 h-4 text-gray-400 transition group-open:rotate-180 {{ $isAr ? 'mr-auto' : 'ml-auto' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                        </summary>
                        <ul class="mt-3 space-y-1.5">
                            @foreach($offer['topics'][$lang] as $topic)
                                <li class="flex items-start gap-2 text-sm text-gray-600 dark:text-gray-300 font-semibold">
                                    <svg class="w-4 h-4 mt-0.5 text-[color:var(--c1)] dark:text-[color:var(--ca)] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    {{ $topic }}
                                </li>
                            @endforeach
                        </ul>
                    </details>
                    @endif

                    {{-- Price --}}
                    <div class="border-t border-dashed border-gray-200 dark:border-white/10 pt-4 space-y-2 text-sm font-bold">
                        <div class="flex justify-between text-gray-600 dark:text-gray-300">
                            <span>{{ $isAr ? 'رسوم الاشتراك' : 'Course fee' }}</span>
                            <span><span id="p-original">{{ $price }}</span> {{ $kwd }}</span>
                        </div>
                        <div id="discount-row" class="hidden justify-between text-emerald-600">
                            <span>{{ $isAr ? 'الخصم' : 'Discount' }}</span>
                            <span>- <span id="p-discount">0</span> {{ $kwd }}</span>
                        </div>
                        <div class="flex justify-between items-baseline pt-1">
                            <span class="text-base font-black text-gray-900 dark:text-white">{{ $isAr ? 'الإجمالي' : 'Total' }}</span>
                            <span class="text-3xl font-black text-[color:var(--c1)] dark:text-[color:var(--ca)]"><span id="p-final">{{ $price }}</span> <small class="text-sm">{{ $kwd }}</small></span>
                        </div>
                    </div>

                    {{-- The one place the gift is explained (only for paying without a discount code) --}}
                    @if($giftAmount > 0 && !$offer['is_full'])
                    <div id="gift-card" class="co-gift rounded-2xl p-4 flex items-start gap-3">
                        <span class="w-10 h-10 rounded-xl text-white flex items-center justify-center text-lg shrink-0" style="background: linear-gradient(135deg, #c9a35c, #b38a3e)">🎁</span>
                        <div class="text-sm min-w-0">
                            <p class="font-black text-gray-900 dark:text-white leading-snug">{{ $isAr ? 'هديتك بعد الدفع: كود خصم بقيمة ' . $giftTxt . ' د.ك' : 'Your gift after paying: a ' . $giftTxt . ' KWD discount code' }}</p>
                            <p class="font-semibold text-[#8a5a12] dark:text-amber-200/80 mt-1 leading-relaxed">{{ $isAr ? 'استخدمه على دورتك الجاية أو اهديه لصديقك.' : 'Use it on your next course or gift it to a friend.' }}</p>
                            <p id="gift-off" class="hidden font-bold text-[color:var(--c1)] dark:text-[color:var(--ca)] text-xs mt-1.5">{{ $isAr ? '* الهدية للتسجيل بدون كود خصم.' : '* The gift applies to bookings without a discount code.' }}</p>
                        </div>
                    </div>
                    @endif

                    @unless($offer['is_full'])
                    <a href="#reg-card" class="lg:hidden flex items-center justify-center gap-2 rounded-xl py-3 text-sm font-black text-white co-pay">
                        {{ $isAr ? 'أكمل الحجز' : 'Continue booking' }}
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7-7-7"/></svg>
                    </a>
                    @endunless
                </div>
            </aside>

            {{-- ═══ Details + pay ═══ --}}
            <div id="reg-card" class="co-card lg:col-span-7 p-5 sm:p-8 scroll-mt-24">

                @if($errors->has('payment'))
                <div class="mb-6 rounded-xl bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/30 text-red-700 dark:text-red-300 text-sm font-bold p-3">
                    {{ $errors->first('payment') }}
                </div>
                @endif

                @if($offer['is_full'])
                <div class="rounded-2xl bg-[color:var(--ct)] dark:bg-white/5 p-5">
                    <p class="font-black text-[color:var(--c1)] dark:text-white mb-1">{{ $isAr ? 'اكتمل العدد في هذا الموعد 🙏' : 'This date is fully booked 🙏' }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 font-bold mb-4">{{ $isAr ? 'اترك رقم الواتساب ونبلّغك أول ما ينفتح موعد جديد.' : 'Leave your WhatsApp number and we will tell you when a new date opens.' }}</p>
                    @include('partials.notify-form', ['courseKey' => $offerKey])
                </div>
                @else
                <form method="POST" action="{{ route('course.register.store', $offerKey) }}" id="reg-form" class="space-y-8">
                    @csrf

                    {{-- 1. Attendee details --}}
                    <div>
                        <h2 class="co-sec"><b>1</b>{{ $isAr ? 'بياناتك' : 'Your details' }}</h2>
                        <p class="co-sec-sub">{{ $isAr ? 'بنستخدمها لتأكيد حجزك والتواصل معك قبل الدورة.' : 'Used to confirm your seat and contact you before the course.' }}</p>

                        <div class="space-y-4 mt-5">
                            <div>
                                <label class="co-label">{{ $isAr ? 'الاسم الكامل' : 'Full name' }} <span class="text-[color:var(--c1)]">*</span> <span class="text-gray-400 font-bold">({{ $isAr ? 'بيطلع بالشهادة' : 'printed on the certificate' }})</span></label>
                                <input type="text" name="name" value="{{ old('name') }}" required maxlength="120" autocomplete="name" class="co-input" placeholder="{{ $isAr ? 'كما تحب يظهر بالشهادة' : 'As it should appear on the certificate' }}">
                                @error('name')<p class="text-red-600 text-xs font-bold mt-1">{{ $message }}</p>@enderror
                            </div>

                            {{-- WhatsApp number: highlighted, it is how the center reaches the attendee later --}}
                            <div class="co-wa {{ $errors->has('phone') ? 'is-bad' : '' }}">
                                <label for="phone" class="flex items-center gap-2.5 mb-2.5">
                                    <span class="co-wa-icon"><svg viewBox="0 0 24 24" fill="currentColor" class="w-[18px] h-[18px]"><path d="M17.47 14.38c-.3-.15-1.75-.86-2.02-.96-.27-.1-.47-.15-.67.15-.2.3-.77.96-.94 1.16-.17.2-.35.22-.64.07-.3-.15-1.26-.46-2.39-1.47-.88-.79-1.48-1.76-1.65-2.06-.17-.3-.02-.46.13-.6.13-.14.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.03-.52-.07-.15-.67-1.6-.92-2.2-.24-.58-.49-.5-.67-.5h-.57c-.2 0-.52.07-.79.37-.27.3-1.04 1.02-1.04 2.48 0 1.46 1.07 2.88 1.21 3.07.15.2 2.1 3.2 5.08 4.49.71.31 1.26.49 1.7.63.71.22 1.36.19 1.87.12.57-.09 1.75-.72 2-1.41.25-.69.25-1.29.17-1.41-.07-.12-.27-.2-.57-.35zM12.04 21.5h-.01a9.45 9.45 0 0 1-4.82-1.32l-.35-.2-3.58.94.96-3.49-.23-.36a9.44 9.44 0 0 1-1.45-5.03c0-5.22 4.25-9.46 9.48-9.46 2.53 0 4.9.99 6.7 2.78a9.4 9.4 0 0 1 2.77 6.7c0 5.22-4.25 9.46-9.47 9.46zm8.06-17.52A11.32 11.32 0 0 0 12.04.66C5.76.66.65 5.77.65 12.05c0 2 .52 3.96 1.52 5.69L.55 23.7l6.1-1.6a11.36 11.36 0 0 0 5.4 1.37h.01c6.27 0 11.38-5.1 11.39-11.38 0-3.04-1.18-5.9-3.34-8.05z"/></svg></span>
                                    <span class="text-[15px] font-black text-gray-900 dark:text-white">{{ $isAr ? 'رقم الواتساب' : 'WhatsApp number' }} <span class="text-[color:var(--c1)]">*</span></span>
                                </label>
                                <div class="relative">
                                    <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required dir="ltr" inputmode="tel" autocomplete="tel" placeholder="5xxx xxxx" class="co-input co-wa-input {{ $isAr ? 'text-right' : '' }}">
                                    <svg id="wa-ok" class="hidden absolute top-1/2 -translate-y-1/2 {{ $isAr ? 'left-3.5' : 'right-3.5' }} w-6 h-6 text-[#1da851]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.6"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                @error('phone')<p class="text-red-600 text-xs font-bold mt-2">{{ $isAr ? 'رقم الهاتف غير صحيح، تأكد منه وجرّب مرة ثانية' : $message }}</p>@enderror
                                <p class="co-wa-hint">{{ $isAr ? 'على هذا الرقم نأكّد حجزك ونبلّغك بأي تحديث عن الدورة — تأكد إنه صحيح وعليه واتساب.' : 'We confirm your seat and send course updates to this number — make sure it is correct and on WhatsApp.' }}</p>
                            </div>

                            {{-- Discount code: a quiet link until needed --}}
                            <details class="co-code group" @if(old('code') || $errors->has('code')) open @endif>
                                <summary class="cursor-pointer list-none inline-flex items-center gap-1.5 text-sm font-black text-[color:var(--c1)] dark:text-[color:var(--ca)] hover:underline">
                                    <svg class="w-4 h-4 transition group-open:rotate-45" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m-7-7h14"/></svg>
                                    {{ $isAr ? 'عندك كود خصم أو كود هدية؟' : 'Have a discount or gift code?' }}
                                </summary>
                                <div class="flex gap-2 mt-3">
                                    <input type="text" name="code" id="code" value="{{ old('code') }}" maxlength="40" dir="ltr" autocomplete="off" class="co-input uppercase" placeholder="CODE">
                                    <button type="button" id="apply-code" class="shrink-0 rounded-xl px-5 text-sm font-black text-white bg-gray-900 hover:bg-gray-700 dark:bg-white dark:text-gray-900 transition">
                                        {{ $isAr ? 'تطبيق' : 'Apply' }}
                                    </button>
                                </div>
                                <p id="code-msg" class="text-xs font-bold mt-2 {{ $errors->has('code') ? 'text-red-600' : 'hidden' }}">{{ $errors->first('code') }}</p>
                            </details>
                        </div>
                    </div>

                    @php $cardMethods = 'KNET · VISA · Mastercard · Apple Pay'; @endphp

                    {{-- 2. Payment: full (MyFatoorah) or 4 installments (deema) --}}
                    @if($deemaEnabled)
                    @php $viaDeema = old('method') === 'deema'; @endphp
                    <fieldset>
                        <legend class="co-sec"><b>2</b>{{ $isAr ? 'طريقة الدفع' : 'Payment method' }}</legend>

                        <div class="space-y-3 mt-4">
                            <label class="pm-opt">
                                <input type="radio" name="method" value="card" class="pm-radio" @checked(!$viaDeema)>
                                <span class="flex-1 min-w-0">
                                    <span class="flex items-center justify-between gap-2">
                                        <span class="font-black text-gray-900 dark:text-white">{{ $isAr ? 'ادفع المبلغ كامل' : 'Pay in full' }}</span>
                                        <span class="text-sm sm:text-base font-black text-gray-900 dark:text-white whitespace-nowrap"><span class="js-total">{{ $price }}</span> {{ $kwd }}</span>
                                    </span>
                                    <span class="block text-xs font-bold text-gray-500 dark:text-gray-400 mt-1" dir="ltr" style="text-align: {{ $isAr ? 'right' : 'left' }}">{{ $cardMethods }}</span>
                                </span>
                            </label>

                            <label class="pm-opt">
                                <input type="radio" name="method" value="deema" class="pm-radio" @checked($viaDeema)>
                                <span class="flex-1 min-w-0">
                                    <span class="flex items-center justify-between gap-2">
                                        <span class="font-black text-gray-900 dark:text-white whitespace-nowrap">{{ $isAr ? 'قسّطها على 4 دفعات' : 'Split into 4 payments' }}</span>
                                        <span class="text-sm sm:text-base font-black text-gray-900 dark:text-white whitespace-nowrap">4 × <span class="js-quarter">{{ number_format((float) $offer['price'] / 4, 3) }}</span> {{ $kwd }}</span>
                                    </span>
                                    <span class="flex items-center justify-between gap-3 mt-1">
                                        <span class="text-xs font-bold text-gray-500 dark:text-gray-400">{{ $isAr ? 'ادفع أول دفعة اليوم والباقي على 3 دفعات' : 'Pay the first part today, the rest in 3 payments' }}</span>
                                        <span class="shrink-0 rounded-md bg-white border border-gray-200 dark:border-white/10 px-1"><img src="{{ asset('deema-logo.png') }}" alt="deema" class="h-6 w-auto object-contain"></span>
                                    </span>
                                </span>
                            </label>
                        </div>
                    </fieldset>
                    @endif

                    {{-- Pay --}}
                    <div class="space-y-3">
                        <button type="submit" id="pay-btn"
                                class="co-pay w-full rounded-2xl py-4 text-base sm:text-lg font-black text-white disabled:opacity-60 inline-flex items-center justify-center gap-2.5">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            <span id="pay-label"><span id="pay-card">{{ $isAr ? 'ادفع' : 'Pay' }} <span class="js-total">{{ $price }}</span> {{ $kwd }}</span><span id="pay-deema" class="hidden">{{ $isAr ? 'تابع للتقسيط مع deema' : 'Continue with deema' }}</span></span>
                        </button>

                        @unless($deemaEnabled)
                        <p class="text-center text-xs font-black text-gray-500 dark:text-gray-400" dir="ltr">{{ $cardMethods }}</p>
                        @endunless

                        <div class="flex items-center justify-center gap-2 text-xs font-bold text-gray-500 dark:text-gray-400">
                            <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            <span id="secure-note" data-card="{{ $isAr ? 'الدفع آمن ومشفّر عبر ماي فاتورة — ما بنحتفظ ببيانات بطاقتك' : 'Secure, encrypted payment via MyFatoorah — we never store your card' }}" data-deema="{{ $isAr ? 'رح ننقلك لصفحة deema الآمنة لإكمال التقسيط' : 'You will continue on deema\'s secure page to set up the installments' }}">{{ $isAr ? 'الدفع آمن ومشفّر عبر ماي فاتورة — ما بنحتفظ ببيانات بطاقتك' : 'Secure, encrypted payment via MyFatoorah — we never store your card' }}</span>
                        </div>

                        <p class="text-center text-[11px] font-semibold text-gray-400 leading-relaxed">
                            {{ $isAr ? 'بإتمام الدفع فإنك توافق على' : 'By paying you agree to the' }}
                            <a href="{{ route('policies') }}#terms" target="_blank" class="underline hover:text-[color:var(--c1)]">{{ $isAr ? 'الشروط والأحكام' : 'Terms' }}</a>
                            {{ $isAr ? 'و' : 'and' }}
                            <a href="{{ route('policies') }}#refund" target="_blank" class="underline hover:text-[color:var(--c1)]">{{ $isAr ? 'سياسة الإلغاء' : 'Cancellation Policy' }}</a>
                        </p>
                    </div>
                </form>
                @endif

                {{-- Help --}}
                <div class="mt-6 pt-5 border-t border-gray-100 dark:border-white/10 flex flex-wrap items-center justify-between gap-3 text-sm font-bold text-gray-500 dark:text-gray-400">
                    <span>{{ $isAr ? 'عندك سؤال قبل الدفع؟' : 'Questions before paying?' }}</span>
                    <a href="https://wa.me/{{ $site['whatsapp'] }}?text={{ rawurlencode(($isAr ? 'مرحباً، عندي سؤال عن ' : 'Hello, I have a question about ') . $offer['title'][$lang]) }}" target="_blank" class="inline-flex items-center gap-2 text-[#128c4a] hover:underline">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884"/></svg>
                        {{ $isAr ? 'كلّمنا عالواتساب' : 'Chat on WhatsApp' }}
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

<script>
(function () {
    if (!document.getElementById('reg-form')) return;
    const codeInput = document.getElementById('code');
    const msg = document.getElementById('code-msg');
    const fmt = n => Number(n).toFixed(3);

    // Green tick once the WhatsApp number has enough digits (same rule as the server)
    const phone = document.getElementById('phone'), waOk = document.getElementById('wa-ok');
    const checkPhone = () => {
        const v = phone.value.trim();
        waOk.classList.toggle('hidden', !/^\+?[0-9\s\-]{8,16}$/.test(v) || v.replace(/\D/g, '').length < 8);
    };
    phone.addEventListener('input', checkPhone);
    checkPhone();

    function showMsg(text, ok) {
        msg.textContent = text;
        msg.className = 'text-xs font-bold mt-2 ' + (ok ? 'text-emerald-600' : 'text-red-600');
    }

    function setTotal(value) {
        document.getElementById('p-final').textContent = value;
        document.querySelectorAll('.js-total').forEach(el => el.textContent = value);
        document.querySelectorAll('.js-quarter').forEach(el => el.textContent = fmt(parseFloat(value) / 4));
    }

    // Payment method choice: the button and the note follow the selected option
    const methodRadios = document.querySelectorAll('input[name="method"]');
    const viaDeema = () => document.querySelector('input[name="method"]:checked')?.value === 'deema';
    function showMethod() {
        const deema = viaDeema();
        document.getElementById('pay-card').classList.toggle('hidden', deema);
        document.getElementById('pay-deema').classList.toggle('hidden', !deema);
        const note = document.getElementById('secure-note');
        note.textContent = deema ? note.dataset.deema : note.dataset.card;
    }
    methodRadios.forEach(r => r.addEventListener('change', showMethod));
    if (methodRadios.length) showMethod();

    // A discount code cancels the gift: dim the gift card and say why
    function giftState(codeApplied) {
        var card = document.getElementById('gift-card');
        if (!card) return;
        card.style.opacity = codeApplied ? '.55' : '1';
        document.getElementById('gift-off').classList.toggle('hidden', !codeApplied);
    }

    function resetPrice() {
        giftState(false);
        document.getElementById('discount-row').classList.replace('flex', 'hidden');
        setTotal(document.getElementById('p-original').textContent);
    }

    document.getElementById('apply-code').addEventListener('click', async function () {
        const code = codeInput.value.trim();
        if (!code) { resetPrice(); msg.classList.add('hidden'); return; }

        this.disabled = true;
        try {
            const res = await fetch(@json(route('course.register.check-code', $offerKey)), {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': @json(csrf_token()) },
                body: JSON.stringify({ code, phone: document.querySelector('#reg-form [name="phone"]').value.trim() }),
            });
            const data = await res.json();
            if (data.ok) {
                document.getElementById('p-discount').textContent = fmt(data.discount);
                setTotal(fmt(data.final));
                document.getElementById('discount-row').classList.replace('hidden', 'flex');
                giftState(true);
                showMsg(@json($isAr ? 'تم تطبيق كود الخصم ✓' : 'Discount applied ✓'), true);
            } else {
                resetPrice();
                showMsg(data.message || (res.status === 429 ? @json($isAr ? 'محاولات كثيرة، انتظر دقيقة' : 'Too many attempts, wait a minute') : @json($isAr ? 'كود غير صالح' : 'Invalid code')), false);
            }
        } catch (e) {
            showMsg(@json($isAr ? 'تعذّر التحقق من الكود' : 'Could not check the code'), false);
        } finally {
            this.disabled = false;
        }
    });

    // Code changed after applying: the server recalculates anyway, just stop showing a stale price
    codeInput.addEventListener('input', () => { resetPrice(); msg.classList.add('hidden'); });

    document.getElementById('reg-form').addEventListener('submit', () => {
        window.trackEvent && trackEvent('InitiateCheckout', { value: parseFloat(document.getElementById('p-final').textContent) || 0, currency: 'KWD' });
        document.getElementById('pay-btn').disabled = true;
        document.getElementById('pay-label').textContent = viaDeema()
            ? @json($isAr ? 'جاري التحويل لصفحة deema...' : 'Redirecting to deema...')
            : @json($isAr ? 'جاري التحويل لصفحة الدفع...' : 'Redirecting to payment...');
    });

    @if(old('code') && !$errors->has('code'))
    document.getElementById('apply-code').click();
    @endif
})();
</script>

@endsection
