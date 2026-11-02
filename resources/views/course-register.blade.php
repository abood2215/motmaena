@extends('layouts.app')

@php
    $lang = app()->getLocale() == 'ar' ? 'ar' : 'en';
    $isAr = $lang === 'ar';
    $kwd = $isAr ? 'د.ك' : 'KWD';
    $price = number_format((float) $offer['price'], 3);
    $giftAmount = \App\Models\CourseRegistration::giftAmount();
    $giftTxt = \App\Models\CourseRegistration::giftAmountText();
@endphp

@section('title', $offer['title'][$lang] . ($isAr ? ' في الكويت | مركز مطمئنة' : ' in Kuwait | Motmaena Center'))

@if($offer['share_image'])
    @section('og_image', asset($offer['share_image']))
@endif
{{-- Built only from the course's own data (about 155 characters): name, trainer, date, time, price.
     The place is added only when the course has one recorded, and deema only when it is offered for this course. --}}
@php
    $metaDate = $offer['day'][$lang] . ' ' . \Carbon\Carbon::parse($offer['date'])->locale($lang)->translatedFormat('j F Y');
    $metaTime = trim((string) $offer['time'][$lang]);
    $hasPlace = trim((string) $offer['location']['ar']) !== '';
@endphp
@section('meta_description', $isAr
    ? $offer['title']['ar'] . ' مع ' . $offer['trainer']['ar'] . ' — ' . $metaDate . ($metaTime ? '، ' . $metaTime : '') . ($hasPlace ? '، في مركز مطمئنة بالكويت' : '') . '. الرسوم ' . $offer['price'] . ' د.ك' . ($deemaEnabled ? ' أو 4 دفعات مع deema.' : '.')
    : $offer['title']['en'] . ' with ' . $offer['trainer']['en'] . ' — ' . $metaDate . ($metaTime ? ', ' . $metaTime : '') . '. Fee ' . $offer['price'] . ' KWD' . ($deemaEnabled ? ' or 4 payments with deema.' : '.'))
@include('partials.breadcrumb-schema', ['items' => [
    [$isAr ? 'الدورات' : 'Courses', route('courses')],
    [$offer['title'][$lang], route('course.register', $offerKey)],
]])
@include('partials.course-event-schema')

@section('content')
@include('partials.lx-styles')

{{-- Course page + checkout in the site's quiet editorial look (partials/lx-styles). The form, its field names and ids,
     and the script below are unchanged: the payment flow is exactly as before. --}}
<style>
    .co-meta li { display: flex; align-items: flex-start; gap: 10px; font-weight: 700; color: var(--ink); line-height: 1.6; }
    .co-meta .lx-ico { width: 20px; height: 20px; margin-top: 2px; }
    .co-label { display: block; font-size: 14px; font-weight: 800; color: var(--ink); margin-bottom: 8px; }
    .co-sec { display: flex; align-items: center; gap: 10px; font-size: 17px; font-weight: 800; color: var(--ink); }
    .co-sec b { width: 26px; height: 26px; border-radius: 99px; display: inline-flex; align-items: center; justify-content: center; font-size: 12px; border: 1px solid var(--gold); color: var(--wine); flex-shrink: 0; }
    .dark .co-sec b { color: var(--gold-l); }
    .pm-opt { display: flex; align-items: center; gap: 12px; padding: 14px 16px; border: 1px solid var(--line); border-radius: 10px; background: var(--paper); cursor: pointer; transition: border-color .15s, box-shadow .15s; }
    .pm-opt:hover { border-color: color-mix(in srgb, var(--wine) 40%, var(--line)); }
    .pm-opt:has(.pm-radio:checked) { border-color: var(--wine); box-shadow: inset 0 0 0 1px var(--wine); }
    .dark .pm-opt:has(.pm-radio:checked) { border-color: var(--gold-l); box-shadow: inset 0 0 0 1px var(--gold-l); }
    .pm-radio { width: 18px; height: 18px; flex-shrink: 0; accent-color: var(--wine); }
    .co-code summary::-webkit-details-marker { display: none; }
    .co-wa-input { font-size: 18px; font-weight: 800; letter-spacing: .05em; font-variant-numeric: tabular-nums; padding-inline-end: 46px; }
    .co-wa-input::placeholder { letter-spacing: .05em; }
    .co-bad .lx-input { border-color: #c2410c; }
    .co-gift { transition: opacity .2s; }
    .countdown { background: var(--ivory) !important; border: 1px solid var(--line); }
</style>

<div class="lx" dir="{{ $isAr ? 'rtl' : 'ltr' }}">
{{-- Checkout always keeps the center's wine palette (course colours stay on the homepage banner) --}}
<section data-track-location="course-page" style="{{ \App\Models\CourseOffer::paletteCss(\App\Models\CourseOffer::CHECKOUT_THEME) }}">

    {{-- ═══ Course header ═══ --}}
    <div class="lx-ivory border-b" style="border-color: var(--line)">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-6xl py-8 sm:py-12">
            {{-- Where you are, and the way back to all courses (matches the BreadcrumbList data) --}}
            <nav aria-label="{{ $isAr ? 'مسار التنقل' : 'Breadcrumb' }}" class="mb-6 text-sm font-semibold lx-muted">
                <ol class="flex flex-wrap items-center gap-x-2 gap-y-1">
                    <li><a href="{{ route('home') }}" class="hover:underline underline-offset-4">{{ $isAr ? 'الرئيسية' : 'Home' }}</a></li>
                    <li aria-hidden="true">/</li>
                    <li><a href="{{ route('courses') }}" class="hover:underline underline-offset-4">{{ $isAr ? 'الدورات' : 'Courses' }}</a></li>
                    <li aria-hidden="true">/</li>
                    <li aria-current="page" style="color: var(--ink)">{{ $offer['title'][$lang] }}</li>
                </ol>
            </nav>

            <p class="lx-label mb-4">{{ $offer['badge'][$lang] }}</p>
            <h1 class="lx-h1 mb-5">{{ $offer['title'][$lang] }}</h1>
            <div class="flex items-center gap-3 mb-6">
                <img src="{{ asset($offer['image']) }}" alt="" width="56" height="56" class="w-12 h-12 rounded-full object-cover object-top shrink-0" style="border: 1px solid var(--line); background: var(--paper)">
                <p class="font-bold" style="color: var(--ink)">{{ $isAr ? 'مع ' : 'with ' }}{{ $offer['trainer'][$lang] }}</p>
            </div>
            @php
                $details = [
                    ['calendar', $offer['day'][$lang] . '، ' . \Carbon\Carbon::parse($offer['date'])->locale($lang)->translatedFormat('j F Y')],
                    ['clock', $offer['time'][$lang]],
                    ['pin', $offer['location'][$lang]],
                    ['award', $offer['certificate'][$lang]],
                ];
            @endphp
            <ul class="co-meta grid sm:grid-cols-2 gap-x-8 gap-y-3 text-[15px]">
                @foreach($details as [$icon, $text])
                    @continue(trim((string) $text) === '')
                    <li>@include('partials.lx-icon', ['i' => $icon])<span>{{ $text }}</span></li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="lx-paper">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-6xl py-10 sm:py-14 grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-start">

            {{-- ═══ Price + details + pay (first on phones, the side column on desktop) ═══ --}}
            <div id="reg-card" class="lg:col-span-5 lg:order-last lg:sticky lg:top-28 scroll-mt-24">
                <div class="lx-card p-5 sm:p-7 shadow-[0_30px_60px_-45px_rgba(31,26,23,.45)]">

                    {{-- Price --}}
                    <div class="space-y-2 text-sm font-bold">
                        <div class="flex justify-between lx-muted">
                            <span>{{ $isAr ? 'رسوم الاشتراك' : 'Course fee' }}</span>
                            <span><span id="p-original">{{ $price }}</span> {{ $kwd }}</span>
                        </div>
                        <div id="discount-row" class="hidden justify-between text-emerald-700">
                            <span>{{ $isAr ? 'الخصم' : 'Discount' }}</span>
                            <span>- <span id="p-discount">0</span> {{ $kwd }}</span>
                        </div>
                        <div class="flex justify-between items-baseline pt-1">
                            <span class="text-base font-extrabold" style="color: var(--ink)">{{ $isAr ? 'الإجمالي' : 'Total' }}</span>
                            <span class="lx-price text-4xl"><span id="p-final">{{ $price }}</span> <small class="text-sm lx-muted">{{ $kwd }}</small></span>
                        </div>
                        @if($deemaEnabled)
                            <p class="text-xs lx-muted font-semibold text-end">{{ $isAr ? 'أو 4 دفعات مع deema' : 'or 4 payments with deema' }}</p>
                        @endif
                    </div>

                    {{-- Countdown + seats --}}
                    <div class="mt-5 space-y-2">
                        @include('partials.countdown', ['startsAt' => $offer['starts_at'], 'compact' => true])
                        @if($offer['seats_left'] !== null)
                            <p class="text-xs font-extrabold {{ $offer['is_full'] ? 'text-red-700' : ($offer['seats_left'] <= 10 ? 'text-amber-700' : 'lx-muted') }}">
                                {{ $offer['is_full'] ? ($isAr ? 'اكتمل العدد' : 'Fully booked') : ($isAr ? 'متبقي ' . $offer['seats_left'] . ' مقعد' : $offer['seats_left'] . ' seats left') }}
                            </p>
                        @endif
                    </div>

                    <div class="lx-rule my-6"></div>

                    @if($errors->has('payment'))
                    <div class="mb-6 rounded-[10px] bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/30 text-red-700 dark:text-red-300 text-sm font-bold p-3">
                        {{ $errors->first('payment') }}
                    </div>
                    @endif

                    @if($offer['is_full'])
                    <div>
                        <p class="font-extrabold mb-1" style="color: var(--ink)">{{ $isAr ? 'اكتمل العدد في هذا الموعد' : 'This date is fully booked' }}</p>
                        <p class="text-sm lx-muted font-semibold mb-4">{{ $isAr ? 'اترك رقم الواتساب ونبلّغك أول ما ينفتح موعد جديد.' : 'Leave your WhatsApp number and we will tell you when a new date opens.' }}</p>
                        @include('partials.notify-form', ['courseKey' => $offerKey])
                    </div>
                    @else
                    <form method="POST" action="{{ route('course.register.store', $offerKey) }}" id="reg-form" class="space-y-7">
                        @csrf

                        {{-- 1. Attendee details --}}
                        <div>
                            <h2 class="co-sec"><b>1</b>{{ $isAr ? 'بياناتك' : 'Your details' }}</h2>
                            <div class="space-y-4 mt-4">
                                <div>
                                    <label for="reg-name" class="co-label">{{ $isAr ? 'الاسم الكامل' : 'Full name' }} <span class="lx-muted font-semibold">({{ $isAr ? 'بيطلع بالشهادة' : 'printed on the certificate' }})</span></label>
                                    <input type="text" id="reg-name" name="name" value="{{ old('name') }}" required maxlength="120" autocomplete="name" class="lx-input" placeholder="{{ $isAr ? 'كما تحب يظهر بالشهادة' : 'As it should appear on the certificate' }}">
                                    @error('name')<p class="text-red-700 text-xs font-bold mt-1">{{ $message }}</p>@enderror
                                </div>

                                {{-- WhatsApp number: how the center reaches the attendee later --}}
                                <div class="{{ $errors->has('phone') ? 'co-bad' : '' }}">
                                    <label for="phone" class="co-label !flex items-center gap-2">@include('partials.lx-icon', ['i' => 'whatsapp', 'class' => '!w-[18px] !h-[18px]']){{ $isAr ? 'رقم الواتساب' : 'WhatsApp number' }}</label>
                                    <div class="relative">
                                        <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required dir="ltr" inputmode="tel" autocomplete="tel" placeholder="5xxx xxxx" class="lx-input co-wa-input {{ $isAr ? 'text-right' : '' }}">
                                        <svg id="wa-ok" class="hidden absolute top-1/2 -translate-y-1/2 {{ $isAr ? 'left-3.5' : 'right-3.5' }} w-6 h-6 text-emerald-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.4"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    @error('phone')<p class="text-red-700 text-xs font-bold mt-2">{{ $isAr ? 'رقم الهاتف غير صحيح، تأكد منه وجرّب مرة ثانية' : $message }}</p>@enderror
                                    <p class="text-xs lx-muted font-semibold mt-2 leading-relaxed">{{ $isAr ? 'على هذا الرقم نأكّد حجزك ونبلّغك بأي تحديث عن الدورة — تأكد إنه صحيح وعليه واتساب.' : 'We confirm your seat and send course updates to this number — make sure it is correct and on WhatsApp.' }}</p>
                                </div>

                                {{-- Discount code: a quiet link until needed --}}
                                <details class="co-code group" @if(old('code') || $errors->has('code')) open @endif>
                                    <summary class="cursor-pointer list-none inline-flex items-center gap-1.5 text-sm lx-link !no-underline hover:!underline">
                                        <svg class="w-4 h-4 transition group-open:rotate-45" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m-7-7h14"/></svg>
                                        {{ $isAr ? 'عندك كود خصم أو كود هدية؟' : 'Have a discount or gift code?' }}
                                    </summary>
                                    <div class="flex gap-2 mt-3">
                                        <input type="text" name="code" id="code" value="{{ old('code') }}" maxlength="40" dir="ltr" autocomplete="off" class="lx-input uppercase" placeholder="CODE">
                                        <button type="button" id="apply-code" class="lx-btn lx-btn-outline shrink-0 !px-5 !py-3 text-sm">{{ $isAr ? 'تطبيق' : 'Apply' }}</button>
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
                                            <span class="font-extrabold" style="color: var(--ink)">{{ $isAr ? 'ادفع المبلغ كامل' : 'Pay in full' }}</span>
                                            <span class="text-sm sm:text-base font-extrabold whitespace-nowrap" style="color: var(--ink)"><span class="js-total">{{ $price }}</span> {{ $kwd }}</span>
                                        </span>
                                        <span class="block text-xs font-semibold lx-muted mt-1" dir="ltr" style="text-align: {{ $isAr ? 'right' : 'left' }}">{{ $cardMethods }}</span>
                                    </span>
                                </label>
                                <label class="pm-opt">
                                    <input type="radio" name="method" value="deema" class="pm-radio" @checked($viaDeema)>
                                    <span class="flex-1 min-w-0">
                                        <span class="flex items-center justify-between gap-2">
                                            <span class="font-extrabold whitespace-nowrap" style="color: var(--ink)">{{ $isAr ? 'قسّطها على 4 دفعات' : 'Split into 4 payments' }}</span>
                                            <span class="text-sm sm:text-base font-extrabold whitespace-nowrap" style="color: var(--ink)">4 × <span class="js-quarter">{{ number_format((float) $offer['price'] / 4, 3) }}</span> {{ $kwd }}</span>
                                        </span>
                                        <span class="flex items-center justify-between gap-3 mt-1">
                                            <span class="text-xs font-semibold lx-muted">{{ $isAr ? 'ادفع أول دفعة اليوم والباقي على 3 دفعات' : 'Pay the first part today, the rest in 3 payments' }}</span>
                                            <span class="shrink-0 rounded-md bg-white border px-1" style="border-color: var(--line)"><img src="{{ asset('deema-logo.webp') }}" alt="deema" width="160" height="112" class="h-6 w-auto object-contain"></span>
                                        </span>
                                    </span>
                                </label>
                            </div>
                        </fieldset>
                        @endif

                        {{-- Pay --}}
                        <div class="space-y-3">
                            <button type="submit" id="pay-btn" class="lx-btn lx-btn-primary w-full !py-4 text-base sm:text-lg">
                                @include('partials.lx-icon', ['i' => 'lock', 'class' => '!w-5 !h-5 !stroke-white'])
                                <span id="pay-label"><span id="pay-card">{{ $isAr ? 'ادفع' : 'Pay' }} <span class="js-total">{{ $price }}</span> {{ $kwd }}</span><span id="pay-deema" class="hidden">{{ $isAr ? 'تابع للتقسيط مع deema' : 'Continue with deema' }}</span></span>
                            </button>

                            @unless($deemaEnabled)
                            <p class="text-center text-xs font-bold lx-muted" dir="ltr">{{ $cardMethods }}</p>
                            @endunless

                            <p class="flex items-start justify-center gap-2 text-xs font-semibold lx-muted text-center">
                                @include('partials.lx-icon', ['i' => 'shield', 'class' => '!w-4 !h-4 mt-0.5'])
                                <span id="secure-note" data-card="{{ $isAr ? 'الدفع آمن ومشفّر عبر ماي فاتورة — ما بنحتفظ ببيانات بطاقتك' : 'Secure, encrypted payment via MyFatoorah — we never store your card' }}" data-deema="{{ $isAr ? 'رح ننقلك لصفحة deema الآمنة لإكمال التقسيط' : 'You will continue on deema\'s secure page to set up the installments' }}">{{ $isAr ? 'الدفع آمن ومشفّر عبر ماي فاتورة — ما بنحتفظ ببيانات بطاقتك' : 'Secure, encrypted payment via MyFatoorah — we never store your card' }}</span>
                            </p>

                            <p class="text-center text-[11px] font-semibold lx-muted leading-relaxed">
                                {{ $isAr ? 'بإتمام الدفع فإنك توافق على' : 'By paying you agree to the' }}
                                <a href="{{ route('policies') }}#terms" target="_blank" class="underline">{{ $isAr ? 'الشروط والأحكام' : 'Terms' }}</a>
                                {{ $isAr ? 'و' : 'and' }}
                                <a href="{{ route('policies') }}#refund" target="_blank" class="underline">{{ $isAr ? 'سياسة الإلغاء' : 'Cancellation Policy' }}</a>
                            </p>
                        </div>
                    </form>
                    @endif

                    {{-- Help --}}
                    <div class="mt-6 pt-5 border-t flex flex-wrap items-center justify-between gap-3 text-sm font-semibold lx-muted" style="border-color: var(--line)">
                        <span>{{ $isAr ? 'عندك سؤال قبل الدفع؟' : 'Questions before paying?' }}</span>
                        <a href="https://wa.me/{{ $site['whatsapp'] }}?text={{ rawurlencode(($isAr ? 'مرحباً، عندي سؤال عن ' : 'Hello, I have a question about ') . $offer['title'][$lang]) }}" target="_blank" class="inline-flex items-center gap-2 lx-link !no-underline hover:!underline">
                            @include('partials.lx-icon', ['i' => 'whatsapp', 'class' => '!w-[18px] !h-[18px]'])
                            {{ $isAr ? 'كلّمنا عالواتساب' : 'Chat on WhatsApp' }}
                        </a>
                    </div>
                </div>
            </div>

            {{-- ═══ About the course ═══ --}}
            <div class="lg:col-span-7 space-y-10">
                @if($offer['topics'][$lang])
                <div>
                    <h2 class="lx-h2 !text-2xl mb-5">{{ $isAr ? 'محاور الدورة' : 'Course topics' }}</h2>
                    <ul class="space-y-2.5 text-[16px]">
                        @foreach($offer['topics'][$lang] as $topic)
                            <li class="lx-topic">@include('partials.lx-icon', ['i' => 'check']){{ $topic }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                {{-- The one place the gift is explained (only for paying without a discount code) --}}
                @if($giftAmount > 0 && !$offer['is_full'])
                <div id="gift-card" class="co-gift lx-notice p-5 flex items-start gap-4">
                    @include('partials.lx-icon', ['i' => 'gift', 'class' => 'mt-0.5'])
                    <div class="text-sm min-w-0">
                        <p class="font-extrabold leading-snug" style="color: var(--ink)">{{ $isAr ? 'هديتك بعد الدفع: كود خصم بقيمة ' . $giftTxt . ' د.ك' : 'Your gift after paying: a ' . $giftTxt . ' KWD discount code' }}</p>
                        <p class="font-semibold lx-muted mt-1 leading-relaxed">{{ $isAr ? 'استخدمه على دورتك الجاية أو اهديه لصديقك.' : 'Use it on your next course or gift it to a friend.' }}</p>
                        <p id="gift-off" class="hidden font-bold lx-wine text-xs mt-1.5">{{ $isAr ? '* الهدية للتسجيل بدون كود خصم.' : '* The gift applies to bookings without a discount code.' }}</p>
                    </div>
                </div>
                @endif

                {{-- This course is part of an open offer (e.g. both November courses for 45) --}}
                @php $regBundle = \App\Models\CourseBundle::current(); @endphp
                @if($regBundle && in_array($offerKey, $regBundle->course_keys ?? [], true))
                <a href="{{ route('bundle.register', $regBundle->slug) }}" class="lx-ink rounded-[14px] p-6 flex flex-col sm:flex-row sm:items-center gap-4 sm:gap-6 group">
                    <div class="flex-1 min-w-0">
                        <p class="text-lg font-extrabold text-white">{{ $isAr ? 'أو الدورتان معاً بـ ' . \App\Models\CourseBundle::fmt((float) $regBundle->price) . ' د.ك' : 'Or both courses for ' . \App\Models\CourseBundle::fmt((float) $regBundle->price) . ' KWD' }} <span class="line-through text-white/45 font-bold">{{ \App\Models\CourseBundle::fmt($regBundle->fullPrice()) }}</span></p>
                        <p class="font-semibold text-white/65 mt-1 text-sm">{{ $regBundle->courses()->pluck($isAr ? 'title_ar' : 'title_en')->implode(' + ') }}</p>
                    </div>
                    <span class="lx-btn lx-btn-light shrink-0 !py-3 text-sm">{{ $isAr ? 'احجز العرض' : 'Book the offer' }}</span>
                </a>
                @endif

                {{-- The trainer --}}
                <div class="lx-card p-6 flex gap-5 items-start">
                    <img src="{{ asset($offer['image']) }}" alt="" loading="lazy" class="w-20 h-20 rounded-[10px] object-cover object-top shrink-0" style="background: var(--ivory)">
                    <div>
                        <p class="lx-label mb-2">{{ $isAr ? 'المدرّب' : 'The trainer' }}</p>
                        <p class="lx-h3 mb-1">{{ $offer['trainer'][$lang] }}</p>
                        @if(str_contains($offer['trainer']['ar'], 'طارق'))<p class="text-sm lx-muted font-semibold leading-relaxed">{{ config('doctor.title.' . $lang) }}</p>@endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
</div>

<script>
    // The course page was seen (course name and price only)
    window.trackEvent && trackEvent('ViewContent', { content_type: 'course', content_name: @json($offer['title']['ar']), content_ids: [@json($offerKey)], value: {{ (float) $offer['price'] }}, currency: 'KWD' });
</script>
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
        window.trackEvent && trackEvent('InitiateCheckout', { value: parseFloat(document.getElementById('p-final').textContent) || 0, currency: 'KWD', content_type: 'course', content_name: @json($offer['title']['ar']), content_ids: [@json($offerKey)] });
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
