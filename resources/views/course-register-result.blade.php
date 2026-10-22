@extends('layouts.app')

@php
    $lang = app()->getLocale() == 'ar' ? 'ar' : 'en';
    $isAr = $lang === 'ar';
    $paid = $registration->status === 'paid';
    $waText = rawurlencode(($isAr ? 'مرحباً، بخصوص تسجيلي رقم #' : 'Hello, about my registration #') . $registration->id . ' - ' . ($offer['title'][$lang] ?? ''));
@endphp

@section('title', ($paid ? ($isAr ? 'تم التسجيل بنجاح' : 'Registration confirmed') : ($isAr ? 'لم يكتمل الدفع' : 'Payment not completed')) . ' - ' . __('Motmaena Center'))

@section('content')
<style>
    .reward-card { background: linear-gradient(135deg, var(--c1), var(--c2) 60%, #f59e0b 140%); box-shadow: 0 18px 40px -16px var(--c1); }
</style>
<section class="py-14 sm:py-24 bg-[color:var(--cbg)] dark:bg-[#0b1220]" dir="{{ $isAr ? 'rtl' : 'ltr' }}" style="{{ \App\Models\CourseOffer::paletteCss(\App\Models\CourseOffer::CHECKOUT_THEME) }}">
    <div class="container mx-auto px-4 max-w-lg">
        <div class="rounded-3xl bg-white dark:bg-[#111a2b] shadow-xl border border-[color:var(--cbd)] dark:border-white/10 p-7 sm:p-10 text-center">

            @if($paid)
                <div class="w-16 h-16 mx-auto mb-5 rounded-full bg-green-100 dark:bg-green-500/15 flex items-center justify-center">
                    <svg class="w-8 h-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                </div>
                <h1 class="text-2xl font-black text-gray-900 dark:text-white mb-2">{{ $isAr ? 'تم تسجيلك بنجاح!' : 'You are registered!' }}</h1>
                <p class="text-gray-500 dark:text-gray-400 font-bold mb-7">{{ $isAr ? 'شكراً لك، سيتواصل معك فريق مطمئنة قبل موعد الدورة.' : 'Thank you! The Motmaena team will contact you before the course.' }}</p>

                @if($gift = $registration->rewardCode())
                    @php
                        $amount = rtrim(rtrim(number_format((float) $gift->value, 3), '0'), '.');
                        $shareText = $isAr
                            ? 'هدية إلك من مركز مطمئنة 🎁 كود خصم ' . $amount . ' دنانير على أي دورة: ' . $gift->code . ' — ' . route('home')
                            : 'A gift for you from Motmaena Center 🎁 ' . $amount . ' KWD off any course: ' . $gift->code . ' — ' . route('home');
                    @endphp
                    <div class="reward-card rounded-3xl p-6 mb-7 text-white">
                        <div class="text-4xl mb-2">🎁</div>
                        <p class="text-xl font-black mb-1">{{ $isAr ? 'مفاجأة إلك!' : 'A surprise for you!' }}</p>
                        <p class="text-sm font-bold text-white/90 mb-4 leading-relaxed">
                            {{ $isAr ? 'شكراً لثقتك فينا، هاد كود خصم بقيمة ' . $amount . ' دنانير على أي دورة جاية بمركز مطمئنة.' : 'Thank you for trusting us — here is ' . $amount . ' KWD off any upcoming course at Motmaena Center.' }}
                        </p>
                        <div class="inline-flex flex-col items-center bg-white rounded-2xl px-6 py-3 mb-3">
                            <span class="text-[11px] font-black text-gray-400">{{ $isAr ? 'كود الخصم' : 'Discount code' }}</span>
                            <span class="text-3xl font-black tracking-widest text-[color:var(--c1)]" dir="ltr">{{ $gift->code }}</span>
                            <span class="text-xs font-black text-[#b45309]">{{ $isAr ? 'خصم ثابت ' . $amount . ' د.ك' : 'Fixed ' . $amount . ' KWD off' }}</span>
                        </div>
                        <p class="text-xs font-bold text-white/80 mb-4">{{ $isAr ? 'إلك أو اهديه لحدا بتحبه — بينستخدم مرة وحدة.' : 'Use it yourself or gift it to someone — valid for one use.' }}</p>
                        <div class="flex flex-wrap justify-center gap-2">
                            <button type="button" onclick="navigator.clipboard.writeText('{{ $gift->code }}');this.textContent='{{ $isAr ? 'تم النسخ ✓' : 'Copied ✓' }}'" class="rounded-xl px-5 py-2.5 font-black bg-white/20 border border-white/30">{{ $isAr ? 'نسخ الكود' : 'Copy code' }}</button>
                            <a href="https://wa.me/?text={{ rawurlencode($shareText) }}" target="_blank" class="rounded-xl px-5 py-2.5 font-black bg-[#25d366] text-white">{{ $isAr ? 'اهديه عبر واتساب' : 'Gift it on WhatsApp' }}</a>
                        </div>
                    </div>
                @endif
            @else
                <div class="w-16 h-16 mx-auto mb-5 rounded-full bg-red-100 dark:bg-red-500/15 flex items-center justify-center">
                    <svg class="w-8 h-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </div>
                <h1 class="text-2xl font-black text-gray-900 dark:text-white mb-2">{{ $isAr ? 'لم يكتمل الدفع' : 'Payment was not completed' }}</h1>
                <p class="text-gray-500 dark:text-gray-400 font-bold mb-7">{{ $isAr ? 'لم يتم خصم أي مبلغ. يمكنك المحاولة مرة أخرى أو التواصل معنا.' : 'You were not charged. You can try again or contact us.' }}</p>
            @endif

            <div class="rounded-2xl bg-[color:var(--ct)] dark:bg-white/5 p-4 text-sm font-bold space-y-2 {{ $isAr ? 'text-right' : 'text-left' }} mb-7">
                <div class="flex justify-between gap-4"><span class="text-gray-500">{{ $isAr ? 'الدورة' : 'Course' }}</span><span class="text-gray-900 dark:text-white">{{ $offer['title'][$lang] ?? '' }}</span></div>
                @if($offer)
                <div class="flex justify-between gap-4"><span class="text-gray-500">{{ $isAr ? 'الموعد' : 'When' }}</span><span class="text-gray-900 dark:text-white">{{ $offer['day'][$lang] }} {{ \Carbon\Carbon::parse($offer['date'])->format('Y/m/d') }} — {{ $offer['time'][$lang] }}</span></div>
                @endif
                <div class="flex justify-between gap-4"><span class="text-gray-500">{{ $isAr ? 'رقم التسجيل' : 'Registration #' }}</span><span class="text-gray-900 dark:text-white">#{{ $registration->id }}</span></div>
                <div class="flex justify-between gap-4"><span class="text-gray-500">{{ $isAr ? 'المبلغ' : 'Amount' }}</span><span class="text-gray-900 dark:text-white">{{ number_format($registration->final_amount, 3) }} {{ $isAr ? 'د.ك' : 'KWD' }}</span></div>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                @unless($paid)
                <a href="{{ route('course.register', $registration->course_key) }}" class="rounded-xl px-6 py-3 font-black text-white" style="background: linear-gradient(135deg, var(--cb), var(--c1));">
                    {{ $isAr ? 'حاول مرة أخرى' : 'Try again' }}
                </a>
                @endunless
                <a href="https://wa.me/{{ $site['whatsapp'] }}?text={{ $waText }}" target="_blank" class="rounded-xl px-6 py-3 font-black bg-[#25d366] text-white">
                    {{ $isAr ? 'تواصل عبر واتساب' : 'WhatsApp us' }}
                </a>
                <a href="{{ route('home') }}" class="rounded-xl px-6 py-3 font-black text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-white/10">
                    {{ $isAr ? 'الرئيسية' : 'Home' }}
                </a>
            </div>
        </div>
    </div>
</section>
@if($paid)
<script>
    // Count the conversion once, even if the page is refreshed
    (function () {
        var key = 'purchase-tracked-{{ $registration->id }}';
        try { if (sessionStorage.getItem(key)) return; sessionStorage.setItem(key, '1'); } catch (e) {}
        window.trackEvent && trackEvent('Purchase', { value: {{ (float) $registration->final_amount }}, currency: 'KWD' });
    })();
</script>
@endif
@endsection
