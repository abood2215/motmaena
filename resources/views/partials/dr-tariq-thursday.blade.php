{{-- "Book a consultation with Dr. Tariq" (in person or by phone) — the customer leaves a request (sent to the center system)
     and the secretaries call back. Shown on the homepage and the consultations page (Admin → Content switch).
     Admin → Content can also set one day: then the block names that day, and hides itself once it has passed. --}}
@php
    $drtAr = app()->getLocale() == 'ar';
    $drtLang = $drtAr ? 'ar' : 'en';
    $drtT = fn ($ar, $en) => $drtAr ? $ar : $en;
    $drtSettings = \App\Models\SiteSetting::current();
    $drtDated = filled($drtSettings['dr_tariq_date'] ?? '');            // a specific day was set in the admin
    $drtNext = \App\Http\Controllers\DrTariqController::day()?->locale($drtLang); // null when unset or already past
    $drtDay = $drtNext?->translatedFormat('l');           // e.g. الخميس
    $drtDate = $drtNext?->translatedFormat('j F');        // e.g. 29 أكتوبر
    $drtAreas = [
        ['rings',   $drtT('الزوجية', 'Marriage')],
        ['family',  $drtT('التربوية', 'Parenting')],
        ['people',  $drtT('الاجتماعية', 'Social')],
        ['compass', $drtT('الحياتية', 'Life')],
    ];
@endphp
@if(($drtSettings['dr_tariq_thursday'] ?? '1') === '1' && (!$drtDated || $drtNext))
@include('partials.lx-styles')
<section id="dr-tariq" class="lx lx-paper py-16 sm:py-24 scroll-mt-20" dir="{{ $drtAr ? 'rtl' : 'ltr' }}">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-12 gap-12 lg:gap-16 items-center">

            {{-- Portrait --}}
            <div class="lg:col-span-5">
                <div class="lx-photo max-w-[300px] sm:max-w-[360px] mx-auto">
                    <img src="{{ asset('photos/dr-tariq-smile.webp') }}" alt="{{ config('doctor.name.' . $drtLang) }}" loading="lazy" width="900" height="1486" class="aspect-[4/5] object-top">
                </div>
            </div>

            {{-- Offer + request form --}}
            <div class="lg:col-span-7">
                <p class="lx-label mb-4">{{ $drtNext ? $drtT('يوم ' . $drtDay . ' ' . $drtDate, $drtDay . ' ' . $drtDate) : $drtT('استشارة خاصة', 'Private consultation') }}</p>
                <h2 class="lx-h2 mb-2">{{ $drtT('احجز استشارتك مع', 'Book your consultation with') }} <span class="lx-wine whitespace-nowrap">{{ config('doctor.name.' . $drtLang) }}</span></h2>
                <p class="lx-muted font-semibold mb-5">{{ config('doctor.title.' . $drtLang) }} · {{ $drtT('المشرف العام على مراكز مطمئنة', 'Head of the Motmaena centers') }}</p>
                <p class="lx-text mb-7 max-w-2xl">
                    @if($drtNext)
                        {{ $drtT('يخصّص الدكتور طارق يوم ' . $drtDay . ' ' . $drtDate . ' عدداً محدوداً من المواعيد، حضورياً في المركز أو هاتفياً. اترك بياناتك ويتواصل معك قسم المواعيد لتأكيد الوقت.', 'On ' . $drtDay . ' ' . $drtDate . ' Dr. Tariq keeps a limited number of appointments, in person or by phone. Leave your details and our appointments team will confirm a time with you.') }}
                    @else
                        {{ $drtT('جلسة خاصة مع الدكتور طارق، حضورياً في المركز أو هاتفياً. المواعيد محدودة؛ اترك بياناتك ويتواصل معك قسم المواعيد لتحديد الوقت المناسب.', 'A private session with Dr. Tariq, at the center or by phone. Appointments are limited — leave your details and our team will arrange a time with you.') }}
                    @endif
                </p>

                <p class="text-sm font-bold mb-3" style="color: var(--ink)">{{ $drtT('في الجوانب', 'Areas') }}</p>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5 mb-8">
                    @foreach($drtAreas as [$icon, $area])
                        <div class="lx-card flex items-center gap-2.5 px-4 py-3 !rounded-[10px]">
                            @include('partials.lx-icon', ['i' => $icon])
                            <span class="font-bold" style="color: var(--ink)">{{ $area }}</span>
                        </div>
                    @endforeach
                </div>

                <form class="drt-form lx-card p-5 sm:p-6 lx-ivory" method="POST" action="{{ route('dr-tariq.request') }}" novalidate>
                    @csrf
                    <input type="text" name="website" tabindex="-1" autocomplete="off" class="hidden" aria-hidden="true">

                    <p class="font-extrabold mb-4" style="color: var(--ink)">{{ $drtNext ? $drtT('احجز مكانك يوم ' . $drtDay, 'Save your place on ' . $drtDay) : $drtT('اطلب موعد استشارتك', 'Request your appointment') }}</p>

                    <div class="grid grid-cols-2 gap-2.5 mb-3">
                        @foreach(\App\Http\Controllers\DrTariqController::MODES as $key => $label)
                            <label class="lx-choice">
                                <input type="radio" name="mode" value="{{ $key }}" @checked($loop->first)>
                                <span>@include('partials.lx-icon', ['i' => $key === 'in_person' ? 'building' : 'phone']) {{ $label[$drtLang] }}</span>
                            </label>
                        @endforeach
                    </div>
                    <div class="grid sm:grid-cols-2 gap-2.5 mb-4">
                        <input type="text" name="name" maxlength="120" autocomplete="name" class="lx-input" placeholder="{{ $drtT('الاسم', 'Name') }}">
                        <input type="tel" name="phone" required maxlength="20" dir="ltr" autocomplete="tel" class="lx-input {{ $drtAr ? 'text-right' : '' }}" placeholder="{{ $drtT('رقم الجوال (واتساب) *', 'Phone (WhatsApp) *') }}">
                    </div>

                    <button type="submit" class="drt-btn lx-btn lx-btn-primary w-full">
                        <span class="drt-btn-label">{{ $drtT('اطلب موعدك مع د. طارق', 'Request your appointment') }}</span>
                    </button>
                    <p class="drt-msg hidden mt-3 text-sm font-bold text-red-700" role="status"></p>
                    <p class="mt-3 text-xs lx-muted font-semibold text-center">{{ $drtT('المواعيد محدودة · بياناتك سرية · يتواصل معك قسم المواعيد لتأكيد الموعد', 'Limited appointments · confidential · our team will confirm with you') }}</p>
                </form>

                <div class="drt-done hidden lx-card lx-ivory p-8 text-center">
                    <div class="w-14 h-14 mx-auto mb-4 rounded-full flex items-center justify-center" style="border: 1px solid var(--gold)">@include('partials.lx-icon', ['i' => 'check', 'class' => '!w-7 !h-7'])</div>
                    <p class="lx-h3 mb-2">{{ $drtT('وصل طلبك', 'Request received') }}</p>
                    <p class="lx-text">{{ $drtNext ? $drtT('سيتواصل معك قسم المواعيد قريباً لتأكيد موعدك مع د. طارق يوم ' . $drtDay . ' ' . $drtDate . '.', 'Our appointments team will call you soon to confirm your appointment with Dr. Tariq on ' . $drtDay . ' ' . $drtDate . '.') : $drtT('سيتواصل معك قسم المواعيد قريباً لترتيب موعدك مع د. طارق.', 'Our appointments team will call you soon to arrange your appointment with Dr. Tariq.') }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

@once
<script>
document.addEventListener('submit', function (e) {
    var form = e.target.closest && e.target.closest('.drt-form');
    if (!form) return;
    e.preventDefault();
    var btn = form.querySelector('.drt-btn'), msg = form.querySelector('.drt-msg');
    btn.disabled = true;
    msg.classList.add('hidden');
    fetch(form.action, { method: 'POST', headers: { 'Accept': 'application/json' }, body: new FormData(form) })
        .then(function (r) { return r.json().then(function (d) { return { ok: r.ok, status: r.status, d: d }; }); })
        .then(function (res) {
            if (res.ok) {
                form.classList.add('hidden');
                form.parentNode.querySelector('.drt-done').classList.remove('hidden');
                window.trackEvent && trackEvent('Lead', { content_name: 'dr_tariq' });
                return;
            }
            var errs = res.d.errors || {};
            var first = Object.keys(errs).map(function (k) { return errs[k][0]; })[0];
            msg.textContent = first || res.d.message || (res.status === 429 ? @json($drtT('محاولات كثيرة، حاول بعد دقيقة', 'Too many tries, wait a minute')) : '');
            msg.classList.remove('hidden');
        })
        .catch(function () { form.submit(); })
        .finally(function () { btn.disabled = false; });
});
</script>
@endonce
@endif
