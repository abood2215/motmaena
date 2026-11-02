@extends('layouts.app')

{{-- Checkout for a course bundle (e.g. both November courses for 45 KWD): one payment, one registration per course. --}}
@php
    $lang = app()->getLocale() == 'ar' ? 'ar' : 'en';
    $isAr = $lang === 'ar';
    $t = fn ($ar, $en) => $isAr ? $ar : $en;
    $kwd = $t('د.ك', 'KWD');
    $fmt = fn ($v) => \App\Models\CourseBundle::fmt((float) $v);
    $price = (float) $bundle->price;
    $full = $bundle->fullPrice();
    $lastDay = \Carbon\Carbon::parse($courses->first()['date'])->locale($lang);
@endphp

@section('title', $bundle->title($lang) . ' - ' . __('Motmaena Center'))
@section('meta_description', $t(
    $courses->pluck('title.ar')->implode(' + ') . ' مع أ.د. طارق الحبيب بـ ' . $fmt($price) . ' د.ك بدل ' . $fmt($full) . ' د.ك. مركز مطمئنة، الكويت.',
    $courses->pluck('title.en')->implode(' + ') . ' with Prof. Dr. Tariq Al-Habib for ' . $fmt($price) . ' KWD instead of ' . $fmt($full) . ' KWD.'
))

@section('content')
@include('partials.lx-styles')

<section class="lx lx-ivory py-10 sm:py-16" dir="{{ $isAr ? 'rtl' : 'ltr' }}">
    <div class="container mx-auto px-4 max-w-6xl">

        <div class="text-center mb-10">
            <p class="lx-label mb-3">{{ $t('عرض خاص', 'Special offer') }}</p>
            <h1 class="lx-h2 mb-3">{{ $bundle->title($lang) }}</h1>
            <p class="lx-text max-w-2xl mx-auto">
                {{ $t('سجّل في الدورتين معاً مع أ.د. طارق الحبيب بـ ' . $fmt($price) . ' د.ك بدلاً من ' . $fmt($full) . ' د.ك.', 'Join both courses with Prof. Dr. Tariq Al-Habib for ' . $fmt($price) . ' KWD instead of ' . $fmt($full) . ' KWD.') }}
            </p>
        </div>

        <div class="grid lg:grid-cols-12 gap-6 lg:gap-8 items-start">

            {{-- Summary --}}
            <aside class="lx-card lg:col-span-5 lg:order-last p-6 sm:p-7">
                <p class="lx-h3 mb-5">{{ $t('ملخّص العرض', 'Offer summary') }}</p>

                <div class="space-y-4 mb-6">
                    @foreach($courses as $c)
                        @php $d = \Carbon\Carbon::parse($c['date'])->locale($lang); @endphp
                        <div class="flex items-start gap-4">
                            <div class="lx-date"><b>{{ $d->format('j') }}</b><span>{{ $d->translatedFormat('F') }}</span></div>
                            <div class="min-w-0 pt-1">
                                <p class="font-extrabold" style="color: var(--ink)">{{ $c['title'][$lang] }}</p>
                                <p class="text-sm lx-muted font-semibold mt-1">{{ $c['day'][$lang] }} · {{ $c['time'][$lang] }}</p>
                                <p class="text-sm lx-muted font-semibold">{{ $t('حضوري · برج أحمد، الكويت', 'In person · Burj Ahmed, Kuwait') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="lx-rule mb-4"></div>
                <div class="space-y-2 text-[15px] font-semibold mb-4">
                    <div class="flex justify-between"><span>{{ $t('سعر الدورتين منفصلتين', 'Both courses separately') }}</span><span class="lx-old">{{ $fmt($full) }} {{ $kwd }}</span></div>
                    <div class="flex justify-between lx-wine"><span>{{ $t('التوفير', 'You save') }}</span><span>{{ $fmt($bundle->savings()) }} {{ $kwd }}</span></div>
                </div>
                <div class="lx-rule mb-4"></div>
                <div class="flex items-baseline justify-between mb-5">
                    <span class="font-extrabold" style="color: var(--ink)">{{ $t('الإجمالي', 'Total') }}</span>
                    <span class="font-extrabold text-3xl" style="color: var(--ink)">{{ $fmt($price) }} <small class="text-base">{{ $kwd }}</small></span>
                </div>

                <ul class="space-y-2.5 text-sm font-semibold">
                    <li class="flex items-start gap-2.5">@include('partials.lx-icon', ['i' => 'award', 'class' => '!w-5 !h-5'])<span>{{ $courses->first()['certificate'][$lang] ?: $t('شهادة حضور معتمدة لكل دورة', 'Accredited certificate for each course') }}</span></li>
                    <li class="flex items-start gap-2.5">@include('partials.lx-icon', ['i' => 'calendar', 'class' => '!w-5 !h-5'])<span>{{ $t('العرض متاح حتى ' . $lastDay->translatedFormat('l j F'), 'Available until ' . $lastDay->translatedFormat('l j F')) }}</span></li>
                    <li class="flex items-start gap-2.5 lx-muted">@include('partials.lx-icon', ['i' => 'gift', 'class' => '!w-5 !h-5'])<span>{{ $t('العرض لا يُجمع مع أكواد الخصم أو الهدايا.', 'Cannot be combined with discount or gift codes.') }}</span></li>
                </ul>
            </aside>

            {{-- Form --}}
            <div class="lx-card lg:col-span-7 p-6 sm:p-8">
                <p class="lx-h3 mb-1">{{ $t('بيانات المشترك', 'Your details') }}</p>
                <p class="text-sm lx-muted font-semibold mb-6">{{ $t('نستخدمها لتأكيد حجزك في الدورتين وإرسال التذكير.', 'Used to confirm your seat in both courses and to remind you.') }}</p>

                @if($errors->has('payment'))
                    <div class="mb-5 rounded-lg border border-red-200 bg-red-50 text-red-700 px-4 py-3 text-sm font-bold">{{ $errors->first('payment') }}</div>
                @endif

                <form method="POST" action="{{ route('bundle.register.store', $bundle->slug) }}" id="bundle-form" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-sm font-bold mb-2" style="color: var(--ink)" for="b-name">{{ $t('الاسم الكامل', 'Full name') }} <span class="lx-wine">*</span></label>
                        <input id="b-name" name="name" value="{{ old('name') }}" required maxlength="120" autocomplete="name" class="lx-input" placeholder="{{ $t('كما تحب أن يظهر في الشهادة', 'As it should appear on the certificate') }}">
                        @error('name')<p class="text-red-600 text-xs font-bold mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold mb-2" style="color: var(--ink)" for="b-phone">{{ $t('رقم الجوال (واتساب)', 'Phone (WhatsApp)') }} <span class="lx-wine">*</span></label>
                            <input id="b-phone" name="phone" type="tel" value="{{ old('phone') }}" required dir="ltr" autocomplete="tel" class="lx-input {{ $isAr ? 'text-right' : '' }}" placeholder="5xxxxxxx">
                            @error('phone')<p class="text-red-600 text-xs font-bold mt-1">{{ $t('رقم الجوال غير صحيح', 'Invalid phone number') }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-2" style="color: var(--ink)" for="b-email">{{ $t('البريد الإلكتروني', 'Email') }} <span class="lx-muted text-xs">({{ $t('اختياري', 'optional') }})</span></label>
                            <input id="b-email" name="email" type="email" value="{{ old('email') }}" dir="ltr" autocomplete="email" class="lx-input">
                            @error('email')<p class="text-red-600 text-xs font-bold mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    @if($deemaEnabled)
                    <fieldset>
                        <legend class="block text-sm font-bold mb-2" style="color: var(--ink)">{{ $t('طريقة الدفع', 'Payment method') }}</legend>
                        <div class="grid sm:grid-cols-2 gap-3">
                            <label class="lx-choice">
                                <input type="radio" name="method" value="card" @checked(old('method', 'card') !== 'deema')>
                                <span><i class="lx-dot"></i><span class="flex-1">{{ $t('دفع كامل', 'Pay in full') }}<small class="block text-xs lx-muted font-semibold mt-0.5">KNET · Visa · Mastercard · Apple Pay</small></span></span>
                            </label>
                            <label class="lx-choice">
                                <input type="radio" name="method" value="deema" @checked(old('method') === 'deema')>
                                <span><i class="lx-dot"></i><span class="flex-1">{{ $t('تقسيط على 4 دفعات', 'Split into 4 payments') }}<small class="block text-xs lx-muted font-semibold mt-0.5">{{ $t('مع deema', 'with deema') }} · 4 × {{ $fmt($price / 4) }} {{ $kwd }}</small></span></span>
                            </label>
                        </div>
                    </fieldset>
                    @endif

                    <button type="submit" id="bundle-pay" class="lx-btn lx-btn-primary w-full !py-4 text-lg">
                        @include('partials.lx-icon', ['i' => 'lock', 'class' => '!stroke-white !w-5 !h-5'])
                        <span id="bundle-pay-label">{{ $t('الدفع والتسجيل في الدورتين', 'Pay & register for both') }} · {{ $fmt($price) }} {{ $kwd }}</span>
                    </button>

                    <p class="text-center text-xs lx-muted font-semibold leading-relaxed">
                        {{ $t('دفع آمن ومشفّر. بإتمام الدفع فإنك توافق على', 'Secure, encrypted payment. By paying you agree to the') }}
                        <a href="{{ route('policies') }}#terms" target="_blank" class="underline">{{ $t('الشروط والأحكام', 'Terms') }}</a>
                        {{ $t('و', 'and') }}
                        <a href="{{ route('policies') }}#refund" target="_blank" class="underline">{{ $t('سياسة الإلغاء', 'Cancellation Policy') }}</a>.
                    </p>
                </form>

                <div class="lx-rule my-6"></div>
                <p class="text-sm font-semibold text-center">
                    {{ $t('تفضّل دورة وحدة؟', 'Prefer just one course?') }}
                    @foreach($courses as $c)
                        <a href="{{ route('course.register', $c['slug']) }}" class="lx-wine underline underline-offset-4 mx-1">{{ $c['title'][$lang] }}</a>@if(!$loop->last)<span class="lx-muted">·</span>@endif
                    @endforeach
                </p>
            </div>
        </div>
    </div>
</section>

<script>
    // The bundle page was seen (bundle name and price only)
    window.trackEvent && trackEvent('ViewContent', { content_type: 'bundle', content_name: @json($bundle->slug), content_ids: [@json($bundle->slug)], value: {{ $price }}, currency: 'KWD' });

    document.getElementById('bundle-form').addEventListener('submit', function () {
        window.trackEvent && trackEvent('InitiateCheckout', { value: {{ $price }}, currency: 'KWD', content_name: @json($bundle->slug) });
        var btn = document.getElementById('bundle-pay');
        btn.disabled = true;
        document.getElementById('bundle-pay-label').textContent = @json($t('جاري التحويل لصفحة الدفع…', 'Redirecting to payment…'));
    });
</script>
@endsection
