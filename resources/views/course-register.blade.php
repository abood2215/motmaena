@extends('layouts.app')

@php
    $lang = app()->getLocale() == 'ar' ? 'ar' : 'en';
    $isAr = $lang === 'ar';
    $kwd = $isAr ? 'د.ك' : 'KWD';
    $price = number_format((float) $offer['price'], 3);
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

                <div class="p-5 sm:p-6 space-y-5">
                    {{-- When / where --}}
                    @php
                        $details = [
                            ['M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', $offer['day'][$lang] . '، ' . \Carbon\Carbon::parse($offer['date'])->locale($lang)->translatedFormat('j F Y')],
                            ['M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', $offer['time'][$lang]],
                            ['M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z', $offer['location'][$lang]],
                            ['M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', $offer['certificate'][$lang]],
                        ];
                    @endphp
                    <ul class="space-y-3">
                        @foreach($details as [$icon, $text])
                            @continue(trim((string) $text) === '')
                            <li class="flex items-start gap-3 text-sm font-bold text-gray-700 dark:text-gray-200">
                                <span class="w-8 h-8 rounded-lg bg-[color:var(--ct)] dark:bg-white/5 text-[color:var(--c1)] dark:text-[color:var(--ca)] flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}"/></svg>
                                </span>
                                <span class="pt-1.5 leading-snug">{{ $text }}</span>
                            </li>
                        @endforeach
                    </ul>

                    {{-- Countdown + seats --}}
                    <div class="flex flex-wrap items-center gap-2">
                        @include('partials.countdown', ['startsAt' => $offer['starts_at']])
                        @if($offer['seats_left'] !== null)
                            <span class="text-xs font-black px-3 py-1.5 rounded-full {{ $offer['is_full'] ? 'bg-red-100 text-red-700' : ($offer['seats_left'] <= 10 ? 'bg-amber-100 text-amber-800' : 'bg-gray-100 text-gray-700 dark:bg-white/10 dark:text-gray-200') }}">
                                {{ $offer['is_full'] ? ($isAr ? 'اكتمل العدد' : 'Fully booked') : ($isAr ? 'متبقي ' . $offer['seats_left'] . ' مقعد' : $offer['seats_left'] . ' seats left') }}
                            </span>
                        @endif
                    </div>

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
                        <div class="flex justify-between items-baseline pt-2">
                            <span class="text-base font-black text-gray-900 dark:text-white">{{ $isAr ? 'الإجمالي' : 'Total' }}</span>
                            <span class="text-3xl font-black text-[color:var(--c1)] dark:text-[color:var(--ca)]"><span id="p-final">{{ $price }}</span> <small class="text-sm">{{ $kwd }}</small></span>
                        </div>
                        @if($offer['show_installments'])
                        <p class="text-xs font-bold text-gray-500 dark:text-gray-400 text-end">{{ $isAr ? 'أو قسّطها على 4 دفعات مع deema' : 'or split into 4 payments with deema' }}</p>
                        @endif
                    </div>
                </div>
            </aside>

            {{-- ═══ Details + pay ═══ --}}
            <div id="reg-card" class="co-card lg:col-span-7 p-5 sm:p-8 scroll-mt-24">
                <h2 class="text-xl sm:text-2xl font-black text-gray-900 dark:text-white mb-1">{{ $isAr ? 'بيانات المشترك' : 'Attendee details' }}</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 font-semibold mb-6">{{ $isAr ? 'بنستخدمها لتأكيد حجزك والتواصل معك قبل الدورة.' : 'Used to confirm your seat and contact you before the course.' }}</p>

                @if($errors->has('payment'))
                <div class="mb-5 rounded-xl bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/30 text-red-700 dark:text-red-300 text-sm font-bold p-3">
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
                <form method="POST" action="{{ route('course.register.store', $offerKey) }}" id="reg-form" class="space-y-5">
                    @csrf

                    <div>
                        <label class="co-label">{{ $isAr ? 'الاسم الكامل' : 'Full name' }} <span class="text-[color:var(--c1)]">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" required maxlength="120" autocomplete="name" class="co-input" placeholder="{{ $isAr ? 'كما تحب يظهر بالشهادة' : 'As it should appear on the certificate' }}">
                        @error('name')<p class="text-red-600 text-xs font-bold mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="co-label">{{ $isAr ? 'رقم الهاتف (واتساب)' : 'Phone (WhatsApp)' }} <span class="text-[color:var(--c1)]">*</span></label>
                            <input type="tel" name="phone" value="{{ old('phone') }}" required dir="ltr" autocomplete="tel" placeholder="5xxxxxxx" class="co-input {{ $isAr ? 'text-right' : '' }}">
                            @error('phone')<p class="text-red-600 text-xs font-bold mt-1">{{ $isAr ? 'رقم الهاتف غير صحيح' : $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="co-label">{{ $isAr ? 'البريد الإلكتروني' : 'Email' }} <span class="text-gray-400 font-bold">({{ $isAr ? 'اختياري' : 'optional' }})</span></label>
                            <input type="email" name="email" value="{{ old('email') }}" maxlength="150" dir="ltr" autocomplete="email" class="co-input {{ $isAr ? 'text-right' : '' }}">
                            @error('email')<p class="text-red-600 text-xs font-bold mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    {{-- Discount code (tucked away until needed) --}}
                    <details class="rounded-xl border border-gray-200 dark:border-white/10 px-4 py-3" @if(old('code') || $errors->has('code')) open @endif>
                        <summary class="cursor-pointer list-none text-sm font-black text-[color:var(--c1)] dark:text-[color:var(--ca)]">
                            {{ $isAr ? 'عندك كود خصم؟' : 'Have a discount code?' }}
                        </summary>
                        <div class="flex gap-2 mt-3">
                            <input type="text" name="code" id="code" value="{{ old('code') }}" maxlength="40" dir="ltr" autocomplete="off" class="co-input uppercase" placeholder="CODE">
                            <button type="button" id="apply-code" class="shrink-0 rounded-xl px-5 text-sm font-black text-white bg-gray-900 hover:bg-gray-700 dark:bg-white dark:text-gray-900 transition">
                                {{ $isAr ? 'تطبيق' : 'Apply' }}
                            </button>
                        </div>
                        <p id="code-msg" class="text-xs font-bold mt-2 {{ $errors->has('code') ? 'text-red-600' : 'hidden' }}">{{ $errors->first('code') }}</p>
                    </details>

                    <button type="submit" id="pay-btn"
                            class="co-pay w-full rounded-2xl py-4 text-base sm:text-lg font-black text-white disabled:opacity-60 inline-flex items-center justify-center gap-2.5">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        <span id="pay-label">{{ $isAr ? 'ادفع' : 'Pay' }} <span id="pay-amount">{{ $price }}</span> {{ $kwd }}</span>
                    </button>

                    <div class="flex flex-wrap items-center justify-center gap-2">
                        @foreach(['KNET', 'VISA', 'Mastercard', 'Apple Pay'] as $method)
                            <span class="text-[11px] font-black px-3 py-1.5 rounded-lg border border-gray-200 dark:border-white/10 text-gray-600 dark:text-gray-300 bg-white dark:bg-white/5" dir="ltr">{{ $method }}</span>
                        @endforeach
                    </div>

                    <div class="flex items-center justify-center gap-2 text-xs font-bold text-gray-500 dark:text-gray-400">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        {{ $isAr ? 'الدفع آمن ومشفّر عبر ماي فاتورة — ما بنحتفظ ببيانات بطاقتك' : 'Secure, encrypted payment via MyFatoorah — we never store your card' }}
                    </div>

                    <p class="text-center text-[11px] font-semibold text-gray-400 leading-relaxed">
                        {{ $isAr ? 'بإتمام الدفع فإنك توافق على' : 'By paying you agree to the' }}
                        <a href="{{ route('policies') }}#terms" target="_blank" class="underline hover:text-[color:var(--c1)]">{{ $isAr ? 'الشروط والأحكام' : 'Terms' }}</a>
                        {{ $isAr ? 'و' : 'and' }}
                        <a href="{{ route('policies') }}#refund" target="_blank" class="underline hover:text-[color:var(--c1)]">{{ $isAr ? 'سياسة الإلغاء' : 'Cancellation Policy' }}</a>
                    </p>
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

    function showMsg(text, ok) {
        msg.textContent = text;
        msg.className = 'text-xs font-bold mt-2 ' + (ok ? 'text-emerald-600' : 'text-red-600');
    }

    function setTotal(value) {
        document.getElementById('p-final').textContent = value;
        document.getElementById('pay-amount').textContent = value;
    }

    function resetPrice() {
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
                body: JSON.stringify({ code }),
            });
            const data = await res.json();
            if (data.ok) {
                document.getElementById('p-discount').textContent = fmt(data.discount);
                setTotal(fmt(data.final));
                document.getElementById('discount-row').classList.replace('hidden', 'flex');
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
        document.getElementById('pay-label').textContent = @json($isAr ? 'جاري التحويل لصفحة الدفع...' : 'Redirecting to payment...');
    });

    @if(old('code') && !$errors->has('code'))
    document.getElementById('apply-code').click();
    @endif
})();
</script>

@endsection
