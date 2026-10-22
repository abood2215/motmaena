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
<section class="py-14 sm:py-24 bg-[color:var(--cbg)] dark:bg-[#0b1220]" dir="{{ $isAr ? 'rtl' : 'ltr' }}" style="{{ \App\Models\CourseOffer::paletteCss($offer['theme'] ?? null) }}">
    <div class="container mx-auto px-4 max-w-lg">
        <div class="rounded-3xl bg-white dark:bg-[#111a2b] shadow-xl border border-[color:var(--cbd)] dark:border-white/10 p-7 sm:p-10 text-center">

            @if($paid)
                <div class="w-16 h-16 mx-auto mb-5 rounded-full bg-green-100 dark:bg-green-500/15 flex items-center justify-center">
                    <svg class="w-8 h-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                </div>
                <h1 class="text-2xl font-black text-gray-900 dark:text-white mb-2">{{ $isAr ? 'تم تسجيلك بنجاح!' : 'You are registered!' }}</h1>
                <p class="text-gray-500 dark:text-gray-400 font-bold mb-7">{{ $isAr ? 'شكراً لك، سيتواصل معك فريق مطمئنة قبل موعد الدورة.' : 'Thank you! The Motmaena team will contact you before the course.' }}</p>

                @php
                    $rewardCode = $registration->rewardCode();
                    $options = $registration->rewardOptions();
                    $fmtPct = fn ($v) => rtrim(rtrim(number_format((float) $v, 2), '0'), '.');
                    $credit = (float) ($site['referral_reward_kwd'] ?? 0);
                @endphp

                @if($rewardCode)
                    @php
                        $percent = $fmtPct($rewardCode->value);
                        $shareLink = route('course.register', $registration->course_key);
                        $shareText = $isAr
                            ? 'سجّلت في ' . ($offer['title']['ar'] ?? 'دورة') . ' بمركز مطمئنة 🌷 سجّل معي واستخدم كودي ' . $rewardCode->code . ' وخذ خصم ' . $percent . '%: ' . $shareLink
                            : 'I signed up for ' . ($offer['title']['en'] ?? 'a course') . ' at Motmaena Center. Join me with my code ' . $rewardCode->code . ' for ' . $percent . '% off: ' . $shareLink;
                    @endphp
                    <div class="reward-card rounded-2xl p-5 mb-7 text-white">
                        @if($rewardCode->kind === 'self')
                            <p class="font-black mb-1">🎁 {{ $isAr ? 'كود الخصم الخاص فيك' : 'Your personal discount code' }}</p>
                            <p class="text-sm font-bold text-white/85 mb-3">{{ $isAr ? 'خصم ' . $percent . '% على دورتك الجاية — مرة وحدة، وبنفس رقم هاتفك. احفظه!' : $percent . '% off your next course — one time, with this phone number. Keep it!' }}</p>
                        @else
                            <p class="font-black mb-1">🎁 {{ $isAr ? 'كود صديقك' : 'Your friend code' }}</p>
                            <p class="text-sm font-bold text-white/85 mb-3">
                                {{ $isAr ? 'صديقك ياخد خصم ' . $percent . '% بهذا الكود' : 'Your friend gets ' . $percent . '% off with this code' }}@if($credit > 0){{ $isAr ? '، وإنت بتاخد رصيد ' . $fmtPct($credit) . ' د.ك عن كل صديق يسجّل.' : ', and you earn ' . $fmtPct($credit) . ' KWD credit for each friend who joins.' }}@else.@endif
                            </p>
                        @endif
                        <div class="inline-block bg-white text-[color:var(--c1)] rounded-xl px-5 py-2 text-3xl font-black tracking-widest mb-4" dir="ltr">{{ $rewardCode->code }}</div>
                        <div class="flex flex-wrap justify-center gap-2">
                            <button type="button" onclick="navigator.clipboard.writeText('{{ $rewardCode->code }}');this.textContent='{{ $isAr ? 'تم النسخ ✓' : 'Copied ✓' }}'" class="rounded-xl px-5 py-2.5 font-black bg-white/20 border border-white/30">{{ $isAr ? 'نسخ الكود' : 'Copy code' }}</button>
                            @if($rewardCode->kind !== 'self')
                            <a href="https://wa.me/?text={{ rawurlencode($shareText) }}" target="_blank" class="rounded-xl px-5 py-2.5 font-black bg-[#25d366] text-white">{{ $isAr ? 'شارك عبر واتساب' : 'Share on WhatsApp' }}</a>
                            @endif
                        </div>
                    </div>
                @elseif($registration->rewardEligible())
                    <div class="reward-card rounded-2xl p-5 mb-7 text-white">
                        <p class="text-lg font-black mb-1">🎁 {{ $isAr ? 'هديتك جاهزة! اختار لمين الكود:' : 'Your gift is ready! Who is the code for?' }}</p>
                        <p class="text-sm font-bold text-white/80 mb-4">{{ $isAr ? 'اختيار واحد بس — بعدها بيطلعلك الكود فوراً.' : 'One choice only — your code appears right away.' }}</p>
                        <div class="grid gap-3 {{ count($options) > 1 ? 'sm:grid-cols-2' : '' }}">
                            @isset($options['referral'])
                            <form method="POST" action="{{ route('registration.reward', [$registration->review_token, 'referral']) }}">@csrf
                                <button class="w-full h-full rounded-2xl bg-white text-[color:var(--c1)] p-4 font-black hover:-translate-y-0.5 transition text-center">
                                    <span class="block text-2xl mb-1">👥</span>
                                    {{ $isAr ? 'لصديق أو شريك' : 'For a friend' }}
                                    <span class="block text-xs font-bold text-gray-500 mt-1">{{ $isAr ? 'هو بياخد خصم ' . $fmtPct($options['referral']) . '%' : 'They get ' . $fmtPct($options['referral']) . '% off' }}@if($credit > 0){{ $isAr ? ' وإنت رصيد ' . $fmtPct($credit) . ' د.ك' : ', you earn ' . $fmtPct($credit) . ' KWD' }}@endif</span>
                                </button>
                            </form>
                            @endisset
                            @isset($options['self'])
                            <form method="POST" action="{{ route('registration.reward', [$registration->review_token, 'self']) }}">@csrf
                                <button class="w-full h-full rounded-2xl bg-white text-[color:var(--c1)] p-4 font-black hover:-translate-y-0.5 transition text-center">
                                    <span class="block text-2xl mb-1">🙋</span>
                                    {{ $isAr ? 'لنفسي' : 'For me' }}
                                    <span class="block text-xs font-bold text-gray-500 mt-1">{{ $isAr ? 'خصم ' . $fmtPct($options['self']) . '% على دورتي الجاية' : $fmtPct($options['self']) . '% off my next course' }}</span>
                                </button>
                            </form>
                            @endisset
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
