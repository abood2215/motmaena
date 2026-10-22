@extends('layouts.app')

@php
    $lang = app()->getLocale() == 'ar' ? 'ar' : 'en';
    $isAr = $lang === 'ar';
@endphp

@section('title', ($isAr ? 'التسجيل في ' : 'Register: ') . $offer['title'][$lang] . ' - ' . __('Motmaena Center'))

@if($offer['share_image'])
    @section('og_image', asset($offer['share_image']))
@endif
@section('meta_description', $offer['title'][$lang] . ' — ' . $offer['trainer'][$lang] . ' · ' . $offer['day'][$lang] . ' ' . \Carbon\Carbon::parse($offer['date'])->format('Y/m/d') . ' · ' . $offer['price'] . ($isAr ? ' د.ك' : ' KWD'))

@section('content')

{{-- Colours come from the course theme: --c1 (deep) … --c4, --cb buttons, --ca light accent, --ct/--cbd tints --}}
<style>
    .reg-bg { background:
        radial-gradient(60rem 30rem at 85% -10%, color-mix(in srgb, var(--c3) 45%, transparent), transparent 60%),
        radial-gradient(40rem 26rem at 0% 100%, color-mix(in srgb, #f59e0b 22%, transparent), transparent 60%),
        var(--cbg); }
    .dark .reg-bg { background: radial-gradient(60rem 30rem at 85% -10%, color-mix(in srgb, var(--c1) 55%, transparent), transparent 60%), #0b1220; }
    .reg-panel { background: linear-gradient(135deg, var(--c1) 0%, var(--c2) 55%, var(--c3) 100%); box-shadow: 0 30px 70px -28px var(--c1); }
    .reg-ribbon { background: linear-gradient(90deg, var(--c1), var(--cb), #f59e0b); }
    .pay-btn { background: linear-gradient(135deg, var(--cb), var(--c1)); box-shadow: 0 16px 34px -12px var(--c1); position: relative; overflow: hidden; }
    .pay-btn::after { content: ''; position: absolute; inset: 0; background: linear-gradient(110deg, transparent 30%, rgba(255,255,255,.35) 50%, transparent 70%); transform: translateX(-120%); animation: pay-shine 2.8s ease-in-out infinite; }
    @keyframes pay-shine { 60%, 100% { transform: translateX(120%); } }
    .total-amount { background: linear-gradient(135deg, var(--c1), var(--cb)); -webkit-background-clip: text; background-clip: text; color: transparent; }
    .dark .total-amount { background: none; color: var(--ca); }
    .gift-box { background: linear-gradient(135deg, #fff7e6, #ffedd5); border: 1.5px dashed #f59e0b; }
    .dark .gift-box { background: rgba(245, 158, 11, .1); }
</style>
<section class="reg-bg py-10 sm:py-16" dir="{{ $isAr ? 'rtl' : 'ltr' }}" style="{{ \App\Models\CourseOffer::paletteCss($offer['theme']) }}">
    <div class="container mx-auto px-4 max-w-6xl">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 lg:gap-8 items-start">

            {{-- ═══ Course summary ═══ --}}
            <div class="reg-panel lg:col-span-3 rounded-3xl overflow-hidden text-white">
                <div class="p-6 sm:p-9">
                    <span class="inline-flex items-center gap-1.5 text-xs font-black px-3 py-1.5 rounded-full bg-white/15 border border-white/20 mb-4">
                        <span class="w-1.5 h-1.5 rounded-full bg-[color:var(--ca)] animate-pulse"></span>
                        {{ $offer['badge'][$lang] }}
                    </span>
                    <h1 class="font-black leading-tight mb-2" style="font-size: clamp(1.8rem, 4vw, 2.8rem);">{{ $offer['title'][$lang] }}</h1>
                    <p class="text-white/75 text-lg font-bold mb-5">{{ $offer['trainer'][$lang] }}</p>

                    <div class="flex flex-wrap items-center gap-3 mb-7">
                        @include('partials.countdown', ['startsAt' => $offer['starts_at'], 'dark' => true])
                        @if($offer['seats_left'] !== null)
                            <span class="inline-flex items-center gap-2 rounded-xl px-3.5 py-2 text-sm font-black {{ $offer['is_full'] ? 'bg-red-500/90' : ($offer['seats_left'] <= 10 ? 'bg-amber-400 text-[#1d1d1d]' : 'bg-white/15 border border-white/25') }}">
                                🎟️ {{ $offer['is_full'] ? ($isAr ? 'اكتمل العدد' : 'Fully booked') : ($isAr ? 'متبقي ' . $offer['seats_left'] . ' مقعد' : $offer['seats_left'] . ' seats left') }}
                            </span>
                        @endif
                    </div>

                    @unless($offer['is_full'])
                    <a href="#reg-card" class="lg:hidden flex items-center justify-center gap-2 w-full rounded-2xl bg-white text-[color:var(--c1)] font-black py-3.5 mb-6 shadow-lg">
                        {{ $isAr ? 'احجز مقعدك الآن — ' . $offer['price'] . ' د.ك' : 'Book your seat — ' . $offer['price'] . ' KWD' }} ↓
                    </a>
                    @endunless

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-7">
                        @foreach([
                            ['icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'label' => $isAr ? 'التاريخ' : 'Date', 'value' => $offer['day'][$lang] . ' ' . \Carbon\Carbon::parse($offer['date'])->format('Y/m/d')],
                            ['icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'label' => $isAr ? 'الوقت' : 'Time', 'value' => $offer['time'][$lang]],
                            ['icon' => 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z', 'label' => $isAr ? 'المكان' : 'Location', 'value' => $offer['location'][$lang]],
                        ] as $meta)
                        @continue(trim((string) $meta['value']) === '')
                        <div class="rounded-2xl bg-white/10 border border-white/15 p-4">
                            <svg class="w-5 h-5 text-[color:var(--ca)] mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $meta['icon'] }}"/></svg>
                            <div class="text-white/55 text-[11px] font-bold mb-0.5">{{ $meta['label'] }}</div>
                            <div class="text-sm font-black leading-snug">{{ $meta['value'] }}</div>
                        </div>
                        @endforeach
                    </div>

                    <p class="text-white/55 text-xs font-black uppercase tracking-widest mb-3">{{ $isAr ? 'محاور الدورة' : 'Course Topics' }}</p>
                    <ul class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-2 mb-7">
                        @foreach($offer['topics'][$lang] as $topic)
                        <li class="flex items-start gap-2 text-sm font-bold text-white/90 leading-snug">
                            <svg class="w-4 h-4 mt-0.5 text-[color:var(--ca)] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            {{ $topic }}
                        </li>
                        @endforeach
                    </ul>

                    @if($offer['certificate'][$lang])
                    <div class="flex items-center gap-3 rounded-2xl bg-white text-[color:var(--c1)] p-4">
                        <span class="w-9 h-9 rounded-full bg-[color:var(--cb)] text-white flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        </span>
                        <span class="text-sm font-black">{{ $offer['certificate'][$lang] }}</span>
                    </div>
                    @endif
                </div>
            </div>

            {{-- ═══ Registration form ═══ --}}
            <div id="reg-card" class="scroll-mt-24 lg:col-span-2 rounded-3xl bg-white dark:bg-[#111a2b] shadow-2xl border border-[color:var(--cbd)] dark:border-white/10 overflow-hidden lg:sticky lg:top-28">
                <div class="reg-ribbon h-1.5"></div>
                <div class="p-6 sm:p-8">
                <h2 class="text-2xl font-black text-[color:var(--c1)] dark:text-white mb-1">{{ $isAr ? 'احجز مقعدك الآن' : 'Book your seat' }}</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">{{ $isAr ? 'عبّئ بياناتك وادفع إلكترونياً بأمان عبر ماي فاتورة' : 'Fill in your details and pay securely via MyFatoorah' }}</p>

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
                <form method="POST" action="{{ route('course.register.store', $offerKey) }}" id="reg-form" class="space-y-4">
                    @csrf
                    @php $input = 'w-full rounded-xl border border-[color:var(--cbd)] dark:border-white/10 bg-[color:var(--ct)] dark:bg-white/5 px-4 py-3 text-sm font-bold text-gray-900 dark:text-white outline-none focus:border-[color:var(--cb)] focus:ring-2 focus:ring-[color:var(--cb)]/20 transition'; @endphp

                    <div>
                        <label class="block text-xs font-black text-gray-600 dark:text-gray-300 mb-1.5">{{ $isAr ? 'الاسم الكامل' : 'Full name' }} *</label>
                        <input type="text" name="name" value="{{ old('name') }}" required maxlength="120" class="{{ $input }}">
                        @error('name')<p class="text-red-600 text-xs font-bold mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-xs font-black text-gray-600 dark:text-gray-300 mb-1.5">{{ $isAr ? 'رقم الهاتف' : 'Phone number' }} *</label>
                        <input type="tel" name="phone" value="{{ old('phone') }}" required dir="ltr" placeholder="5xxxxxxx" class="{{ $input }} {{ $isAr ? 'text-right' : '' }}">
                        @error('phone')<p class="text-red-600 text-xs font-bold mt-1">{{ $isAr ? 'رقم الهاتف غير صحيح' : $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-xs font-black text-gray-600 dark:text-gray-300 mb-1.5">{{ $isAr ? 'البريد الإلكتروني (اختياري)' : 'Email (optional)' }}</label>
                        <input type="email" name="email" value="{{ old('email') }}" maxlength="150" dir="ltr" class="{{ $input }} {{ $isAr ? 'text-right' : '' }}">
                        @error('email')<p class="text-red-600 text-xs font-bold mt-1">{{ $message }}</p>@enderror
                    </div>

                    {{-- Discount code --}}
                    <div>
                        <label class="block text-xs font-black text-gray-600 dark:text-gray-300 mb-1.5">{{ $isAr ? 'كود الخصم (إن وجد)' : 'Discount code (optional)' }}</label>
                        <div class="flex gap-2">
                            <input type="text" name="code" id="code" value="{{ old('code') }}" maxlength="40" dir="ltr" autocomplete="off" class="{{ $input }} uppercase">
                            <button type="button" id="apply-code" class="shrink-0 rounded-xl px-4 text-sm font-black text-[color:var(--cb)] border-2 border-[color:var(--cb)]/30 hover:bg-[color:var(--cb)]/5 transition">
                                {{ $isAr ? 'تطبيق' : 'Apply' }}
                            </button>
                        </div>
                        <p id="code-msg" class="text-xs font-bold mt-1 {{ $errors->has('code') ? 'text-red-600' : 'hidden' }}">{{ $errors->first('code') }}</p>
                    </div>

                    {{-- Reward for paying without a code --}}
                    @php
                        $giftOptions = (new \App\Models\CourseRegistration)->rewardOptions();
                        $pct = fn ($v) => rtrim(rtrim(number_format((float) $v, 2), '0'), '.');
                    @endphp
                    @if($giftOptions)
                    <div id="gift-box" class="gift-box rounded-2xl p-4 text-sm">
                        <p class="font-black text-[#9a3412] dark:text-amber-300 mb-1">🎁 {{ $isAr ? 'هدية مع تسجيلك!' : 'A gift with your booking!' }}</p>
                        <p class="font-bold text-[#7c2d12] dark:text-amber-100/90 leading-relaxed">
                            {{ $isAr ? 'سجّل بدون كود خصم، وبعد الدفع بتاخد كود هدية — إنت بتختار:' : 'Book without a discount code and get a gift code after paying — you choose:' }}
                        </p>
                        <ul class="mt-2 space-y-1 font-bold text-[#7c2d12] dark:text-amber-100/90">
                            @isset($giftOptions['referral'])<li>👥 {{ $isAr ? 'لصديق أو شريك: خصم ' . $pct($giftOptions['referral']) . '% إله' : 'For a friend: ' . $pct($giftOptions['referral']) . '% off for them' }}@if((float) ($site['referral_reward_kwd'] ?? 0) > 0){{ $isAr ? ' + رصيد ' . $pct($site['referral_reward_kwd']) . ' د.ك إلك' : ' + ' . $pct($site['referral_reward_kwd']) . ' KWD credit for you' }}@endif</li>@endisset
                            @isset($giftOptions['self'])<li>🙋 {{ $isAr ? 'لنفسك: خصم ' . $pct($giftOptions['self']) . '% على دورتك الجاية' : 'For you: ' . $pct($giftOptions['self']) . '% off your next course' }}</li>@endisset
                        </ul>
                        <p id="gift-off" class="hidden mt-2 text-xs font-black text-[#9a3412] dark:text-amber-300">{{ $isAr ? '* الهدية للتسجيل بدون كود — شيل الكود إذا بدك الهدية.' : '* The gift is for bookings without a code — remove the code to get it.' }}</p>
                    </div>
                    @endif

                    {{-- Price breakdown --}}
                    <div class="rounded-2xl bg-[color:var(--ct)] dark:bg-white/5 p-4 space-y-2 text-sm font-bold">
                        <div class="flex justify-between text-gray-600 dark:text-gray-300">
                            <span>{{ $isAr ? 'رسوم الاشتراك' : 'Course fee' }}</span>
                            <span><span id="p-original">{{ number_format($offer['price'], 3) }}</span> {{ $isAr ? 'د.ك' : 'KWD' }}</span>
                        </div>
                        <div id="discount-row" class="hidden justify-between text-green-600">
                            <span>{{ $isAr ? 'الخصم' : 'Discount' }}</span>
                            <span>- <span id="p-discount">0</span> {{ $isAr ? 'د.ك' : 'KWD' }}</span>
                        </div>
                        <div class="flex justify-between items-baseline border-t border-[color:var(--cbd)] dark:border-white/10 pt-2">
                            <span class="text-gray-900 dark:text-white">{{ $isAr ? 'الإجمالي' : 'Total' }}</span>
                            <span class="text-3xl font-black total-amount"><span id="p-final">{{ number_format($offer['price'], 3) }}</span> <small class="text-xs">{{ $isAr ? 'د.ك' : 'KWD' }}</small></span>
                        </div>
                    </div>

                    <button type="submit" id="pay-btn"
                            class="pay-btn w-full rounded-2xl py-4 text-lg font-black text-white transition hover:-translate-y-0.5 active:scale-[.98] disabled:opacity-60 inline-flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        <span id="pay-label">{{ $isAr ? 'ادفع واحجز مقعدك' : 'Pay & book your seat' }}</span>
                    </button>

                    <div class="flex flex-wrap items-center justify-center gap-1.5">
                        @foreach(['KNET', 'VISA', 'Mastercard', 'Apple Pay'] as $method)
                            <span class="text-[11px] font-black px-2.5 py-1 rounded-lg border border-gray-200 dark:border-white/10 text-gray-600 dark:text-gray-300 bg-gray-50 dark:bg-white/5" dir="ltr">{{ $method }}</span>
                        @endforeach
                    </div>

                    <p class="text-center text-[11px] font-bold text-gray-500 dark:text-gray-400 leading-relaxed">
                        {{ $isAr ? 'بالضغط على "ادفع واحجز مقعدك" فإنك توافق على' : 'By continuing you agree to the' }}
                        <a href="{{ route('policies') }}#terms" target="_blank" class="underline text-[color:var(--cb)]">{{ $isAr ? 'الشروط والأحكام' : 'Terms' }}</a>
                        {{ $isAr ? 'و' : 'and' }}
                        <a href="{{ route('policies') }}#refund" target="_blank" class="underline text-[color:var(--cb)]">{{ $isAr ? 'سياسة الإلغاء' : 'Cancellation Policy' }}</a>
                    </p>

                    <p class="flex items-center justify-center gap-1.5 text-[11px] font-bold text-gray-400">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        {{ $isAr ? 'دفع آمن ومشفّر عبر ماي فاتورة' : 'Secure, encrypted payment via MyFatoorah' }}
                    </p>
                </form>
                @endif
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
        msg.className = 'text-xs font-bold mt-1 ' + (ok ? 'text-green-600' : 'text-red-600');
    }

    function giftState(codeApplied) {
        var off = document.getElementById('gift-off'), box = document.getElementById('gift-box');
        if (!box) return;
        off.classList.toggle('hidden', !codeApplied);
        box.style.opacity = codeApplied ? '.55' : '1';
    }

    function resetPrice() {
        giftState(false);
        document.getElementById('discount-row').classList.replace('flex', 'hidden');
        document.getElementById('p-final').textContent = document.getElementById('p-original').textContent;
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
                document.getElementById('p-final').textContent = fmt(data.final);
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
        const btn = document.getElementById('pay-btn');
        btn.disabled = true;
        document.getElementById('pay-label').textContent = @json($isAr ? 'جاري التحويل لصفحة الدفع...' : 'Redirecting to payment...');
    });

    @if(old('code') && !$errors->has('code'))
    document.getElementById('apply-code').click();
    @endif
})();
</script>

@endsection
