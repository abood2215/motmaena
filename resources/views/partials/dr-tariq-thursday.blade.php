{{-- "A day with Dr. Tariq" — limited appointments on one day the admin sets (Admin → Content); the customer leaves a request
     (sent to the center system) and the secretaries call back. Shown on the homepage and the consultations page,
     and hidden automatically once that day has passed. --}}
@php
    $drtAr = app()->getLocale() == 'ar';
    $drtLang = $drtAr ? 'ar' : 'en';
    $drtT = fn ($ar, $en) => $drtAr ? $ar : $en;
    $drtNext = \App\Http\Controllers\DrTariqController::day()?->locale($drtLang);
    $drtDay = $drtNext?->translatedFormat('l');           // e.g. الخميس
    $drtDate = $drtNext?->translatedFormat('j F');        // e.g. 29 أكتوبر
@endphp
@if($drtNext && (\App\Models\SiteSetting::current()['dr_tariq_thursday'] ?? '1') === '1')
<section id="dr-tariq" class="drt py-12 sm:py-16 scroll-mt-20" dir="{{ $drtAr ? 'rtl' : 'ltr' }}">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="drt-card relative overflow-hidden">
            <div class="drt-dots" aria-hidden="true"></div>
            <div class="drt-glow" aria-hidden="true"></div>

            {{-- The chance: the day + countdown to it --}}
            <div class="drt-urgent relative">
                <div class="flex items-center gap-2.5 font-black">
                    <span class="drt-live"><i></i></span>
                    @if($drtNext->isToday())
                        <span>🔥 {{ $drtT('اليوم! الدكتور طارق يستقبل الاستشارات — اطلب موعدك الآن', 'Today! Dr. Tariq is seeing people — request now') }}</span>
                    @else
                        <span>🔥 {{ $drtT('فرصة هذا الأسبوع:', 'This week\'s chance:') }} <b class="drt-urgent-date">{{ $drtDay }} {{ $drtDate }}</b></span>
                    @endif
                </div>
                @unless($drtNext->isToday())
                    @include('partials.countdown', ['startsAt' => $drtNext->toDateString() . 'T00:00:00+03:00', 'dark' => true, 'countdownLabel' => $drtT('باقي على الموعد', 'Starts in')])
                @endunless
            </div>

            <div class="relative grid lg:grid-cols-12 gap-8 lg:gap-12 items-center p-6 sm:p-10 lg:p-12 pt-8 sm:pt-10">

                {{-- The doctor --}}
                <div class="lg:col-span-5 flex justify-center">
                    <div class="drt-photo-wrap">
                        <div class="drt-photo">
                            <img src="{{ asset('photos/dr-tariq-smile.webp') }}" alt="{{ config('doctor.name.' . $drtLang) }}" loading="lazy">
                        </div>
                        <div class="drt-seal" aria-hidden="true">
                            <span class="drt-seal-top">{{ $drtDay }}</span>
                            <span class="drt-seal-day">{{ $drtNext->format('j') }}</span>
                            <span class="drt-seal-top">{{ $drtNext->translatedFormat('F') }}</span>
                        </div>
                        <div class="drt-limited">⏳ {{ $drtT('مواعيد محدودة', 'Limited slots') }}</div>
                    </div>
                </div>

                {{-- Offer + request form --}}
                <div class="lg:col-span-7">
                    <p class="drt-eyebrow">{{ $drtT('استشارة شخصية مع الدكتور', 'A personal consultation with the doctor') }}</p>
                    <h2 class="drt-title">{{ $drtT('قابل', 'Meet') }} <span>{{ config('doctor.name.' . $drtLang) }}</span> {{ $drtT('شخصياً', 'in person') }}</h2>
                    <p class="drt-sub">{{ config('doctor.title.' . $drtLang) }}</p>
                    <p class="drt-text">
                        {{ $drtT('يوم ' . $drtDay . ' ' . $drtDate . ' يخصّص الدكتور طارق عدداً محدوداً جداً من المواعيد للاستشارات الحياتية والاجتماعية والتربوية. اطلب موعدك الآن — الأولوية لأول المسجّلين.', 'On ' . $drtDay . ' ' . $drtDate . ' Dr. Tariq keeps a very limited number of appointments for life, social and parenting counselling. Request yours now — first come, first served.') }}
                    </p>

                    <div class="drt-stats mb-6">
                        <div><b>+30</b><span>{{ $drtT('سنة خبرة', 'years') }}</span></div>
                        <div><b>+100K</b><span>{{ $drtT('مستفيد', 'helped') }}</span></div>
                        <div><b>🔒</b><span>{{ $drtT('سرية تامة', 'confidential') }}</span></div>
                        <div><b>🏢 · 📞</b><span>{{ $drtT('حضوري أو هاتفي', 'in person / phone') }}</span></div>
                    </div>

                    <form class="drt-form" method="POST" action="{{ route('dr-tariq.request') }}" novalidate>
                        @csrf
                        <input type="text" name="website" tabindex="-1" autocomplete="off" class="hidden" aria-hidden="true">

                        <div class="drt-form-head">
                            <span class="drt-form-ico">📅</span>
                            <div>
                                <p class="drt-form-title">{{ $drtT('احجز مكانك يوم ' . $drtDay, 'Save your place on ' . $drtDay) }}</p>
                                <p class="drt-form-sub">{{ $drtT('خطوتين بس — وبنتصل فيك نأكد الموعد', 'Two quick steps — we call you to confirm') }}</p>
                            </div>
                        </div>

                        <p class="drt-step"><b>1</b> {{ $drtT('كيف بتفضّل الاستشارة؟', 'How would you like it?') }}</p>
                        <div class="grid grid-cols-2 gap-2.5 mb-5">
                            @foreach(\App\Http\Controllers\DrTariqController::MODES as $key => $label)
                                <label class="drt-pill">
                                    <input type="radio" name="mode" value="{{ $key }}" @checked($loop->first)>
                                    <span>{{ $key === 'in_person' ? '🏢' : '📞' }} {{ $label[$drtLang] }}</span>
                                </label>
                            @endforeach
                        </div>

                        <p class="drt-step"><b>2</b> {{ $drtT('بياناتك', 'Your details') }}</p>
                        <div class="grid sm:grid-cols-2 gap-2.5 mb-4">
                            <input type="text" name="name" maxlength="120" autocomplete="name" class="drt-input" placeholder="{{ $drtT('الاسم', 'Name') }}">
                            <input type="tel" name="phone" required maxlength="20" dir="ltr" autocomplete="tel" class="drt-input {{ $drtAr ? 'text-right' : '' }}" placeholder="{{ $drtT('رقم الجوال (واتساب) *', 'Phone (WhatsApp) *') }}">
                        </div>

                        <button type="submit" class="drt-btn">
                            <span class="drt-btn-label">{{ $drtT('اطلب موعدك مع د. طارق', 'Request your appointment') }}</span>
                            <span aria-hidden="true">{{ $drtAr ? '←' : '→' }}</span>
                        </button>
                        <p class="drt-msg hidden" role="status"></p>
                        <p class="drt-hurry">⚡ {{ $drtT('المواعيد بتخلص بسرعة — الأولوية لأول المسجّلين', 'Slots go fast — first come, first served') }}</p>
                        <p class="drt-note">🔒 {{ $drtT('بدون دفع الآن · بياناتك سرية · بنتواصل معك لتأكيد الموعد', 'Nothing to pay now · confidential · we call you to confirm') }}</p>
                    </form>

                    <div class="drt-done hidden">
                        <div class="drt-done-ico">✓</div>
                        <p class="drt-done-title">{{ $drtT('وصل طلبك!', 'Request received!') }}</p>
                        <p class="drt-done-text">{{ $drtT('قسم المواعيد رح يتواصل معك على رقمك قريباً لتأكيد موعدك مع د. طارق يوم ' . $drtDay . ' ' . $drtDate . '.', 'Our appointments team will call you soon to confirm your appointment with Dr. Tariq on ' . $drtDay . ' ' . $drtDate . '.') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@once
<style>
    .drt { --dw: #6d1b2b; --dwd: #4a0f1b; --dg: #c9a35c; --dgl: #ead8b1; background: #fff; }
    .dark .drt { background: #0f0b0c; }
    .drt-card { border-radius: 2rem; color: #fff; background: radial-gradient(120% 120% at 100% 0%, #8a2a3b, var(--dw) 45%, var(--dwd)); box-shadow: 0 40px 80px -40px var(--dwd); }
    .drt-card::before { content: ''; position: absolute; inset: 12px; border: 1.5px solid color-mix(in srgb, var(--dg) 45%, transparent); border-radius: 1.6rem; pointer-events: none; }
    .drt-dots { position: absolute; inset: 0; opacity: .07; background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 22px 22px; pointer-events: none; }
    .drt-glow { position: absolute; width: 520px; height: 520px; inset-inline-start: -160px; top: 40px; border-radius: 999px; background: radial-gradient(circle, rgba(234,216,177,.22), transparent 65%); pointer-events: none; }

    /* This week's chance strip */
    .drt-urgent { display: flex; align-items: center; justify-content: space-between; gap: 12px 20px; flex-wrap: wrap; padding: 14px 24px; margin: 12px 12px 0; border-radius: 1.4rem 1.4rem 14px 14px; background: linear-gradient(90deg, rgba(0,0,0,.28), rgba(0,0,0,.12)); border-bottom: 1px solid rgba(234,216,177,.25); font-size: 15px; }
    .drt-urgent-date { color: var(--dgl); }
    .drt-live { position: relative; width: 12px; height: 12px; flex-shrink: 0; }
    .drt-live i, .drt-live::after { position: absolute; inset: 0; border-radius: 999px; background: #f87171; }
    .drt-live::after { content: ''; animation: drt-ping 1.6s ease-out infinite; }
    @keyframes drt-ping { from { transform: scale(1); opacity: .8; } to { transform: scale(2.6); opacity: 0; } }

    /* Trust numbers */
    .drt-stats { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); border: 1px solid rgba(255,255,255,.16); border-radius: 16px; background: rgba(255,255,255,.06); overflow: hidden; }
    .drt-stats > div { padding: 10px 8px; text-align: center; }
    .drt-stats > div + div { border-inline-start: 1px solid rgba(255,255,255,.12); }
    .drt-stats b { display: block; font-size: 18px; font-weight: 900; color: var(--dg); line-height: 1.2; }
    .drt-stats span { display: block; font-size: 11.5px; font-weight: 700; color: rgba(255,255,255,.75); }
    @media (max-width: 479px) { .drt-stats { grid-template-columns: repeat(2, minmax(0, 1fr)); } .drt-stats > div:nth-child(3) { border-inline-start: 0; } .drt-stats > div:nth-child(n+3) { border-top: 1px solid rgba(255,255,255,.12); } }

    .drt-photo-wrap { position: relative; width: min(100%, 380px); }
    .drt-photo { aspect-ratio: 4 / 5; border-radius: 999px 999px 28px 28px; overflow: hidden; border: 2px solid color-mix(in srgb, var(--dg) 75%, transparent); box-shadow: 0 30px 60px -30px rgba(0,0,0,.7); background: var(--dwd); }
    .drt-photo img { width: 100%; height: 100%; object-fit: cover; object-position: top; }
    .drt-seal { position: absolute; top: 18px; inset-inline-end: -14px; width: 92px; height: 92px; border-radius: 999px; display: flex; flex-direction: column; align-items: center; justify-content: center; color: #3b1d00; background: radial-gradient(circle at 35% 30%, #f6e7c4, var(--dg) 60%, #a67c35); box-shadow: 0 14px 30px -12px rgba(0,0,0,.6), inset 0 0 0 4px rgba(255,255,255,.35); transform: rotate(-8deg); }
    .drt-seal-top { font-size: 11px; font-weight: 900; line-height: 1.1; }
    .drt-seal-day { font-size: 30px; font-weight: 900; line-height: 1; }
    .drt-limited { position: absolute; bottom: -14px; left: 50%; transform: translateX(-50%); white-space: nowrap; font-size: 13px; font-weight: 900; padding: 8px 16px; border-radius: 999px; color: #3b1d00; background: linear-gradient(110deg, var(--dg) 0%, #f3e2b8 45%, var(--dg) 60%, #b38a3e 100%); background-size: 220% 100%; animation: drt-shine 3.2s linear infinite; box-shadow: 0 10px 24px -10px var(--dg); }
    @keyframes drt-shine { from { background-position: 120% 0; } to { background-position: -120% 0; } }

    .drt-eyebrow { color: var(--dgl); font-weight: 900; font-size: 14px; margin-bottom: 6px; }
    .drt-title { font-weight: 900; line-height: 1.2; font-size: clamp(1.7rem, 3.6vw, 2.6rem); margin-bottom: 4px; }
    .drt-title span { color: var(--dg); }
    .drt-sub { color: rgba(255,255,255,.75); font-weight: 700; font-size: 14px; margin-bottom: 14px; }
    .drt-text { color: rgba(255,255,255,.88); font-weight: 600; line-height: 1.9; margin-bottom: 16px; max-width: 40rem; }
    .drt-chip { display: inline-flex; align-items: center; gap: 6px; font-size: 13px; font-weight: 800; padding: 8px 12px; border-radius: 12px; background: rgba(255,255,255,.1); border: 1px solid rgba(255,255,255,.18); }
    .drt-chip b { color: var(--dgl); }

    .drt-form { position: relative; color: #3b2418; background: linear-gradient(160deg, #fbf5ea 0%, #f3e6d0 100%); border: 1px solid #e6d3b3; border-radius: 24px; padding: 20px; box-shadow: 0 30px 60px -30px rgba(0,0,0,.55), inset 0 1px 0 rgba(255,255,255,.7); }
    .drt-form::before { content: ''; position: absolute; inset: 7px; border: 1px dashed rgba(166,124,53,.45); border-radius: 18px; pointer-events: none; }
    .drt-form > * { position: relative; }
    .drt-form-head { display: flex; align-items: center; gap: 12px; padding-bottom: 14px; margin-bottom: 16px; border-bottom: 1px solid #e6d3b3; }
    .drt-form-ico { width: 46px; height: 46px; flex-shrink: 0; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 22px; background: linear-gradient(135deg, var(--dw), var(--dwd)); box-shadow: 0 10px 20px -10px var(--dwd); }
    .drt-form-title { font-size: 18px; font-weight: 900; color: var(--dwd); line-height: 1.3; }
    .drt-form-sub { font-size: 13px; font-weight: 700; color: #8a6a4a; }
    .drt-step { display: flex; align-items: center; gap: 8px; font-size: 14px; font-weight: 900; color: #4a2c1d; margin-bottom: 10px; }
    .drt-step b { width: 24px; height: 24px; border-radius: 99px; display: inline-flex; align-items: center; justify-content: center; font-size: 12px; color: #fff; background: var(--dw); }
    .drt-pill { position: relative; cursor: pointer; display: block; }
    .drt-pill input { position: absolute; opacity: 0; pointer-events: none; }
    .drt-pill span { display: flex; align-items: center; justify-content: center; gap: 6px; font-weight: 900; font-size: 15px; padding: 13px 12px; border-radius: 14px; color: #4a2c1d; background: #fff; border: 1.5px solid #e6d3b3; transition: border-color .15s, background .15s, box-shadow .15s, color .15s; }
    .drt-pill span:hover { border-color: var(--dg); }
    .drt-pill input:checked + span { color: var(--dwd); background: #fff7e8; border-color: var(--dw); box-shadow: 0 0 0 3px rgba(109,27,43,.12); }
    .drt-pill input:focus-visible + span { outline: 2px solid var(--dw); outline-offset: 2px; }
    .drt-input { width: 100%; border-radius: 14px; padding: 13px 14px; font-size: 15px; font-weight: 700; color: #2a1a12; background: #fff; border: 1.5px solid #e6d3b3; outline: none; transition: border-color .15s, box-shadow .15s; }
    .drt-input::placeholder { color: #a8927a; }
    .drt-input:focus { border-color: var(--dw); box-shadow: 0 0 0 4px rgba(109,27,43,.1); }
    .drt-btn { width: 100%; display: inline-flex; align-items: center; justify-content: center; gap: 10px; font-weight: 900; font-size: 17px; padding: 16px 22px; border-radius: 16px; color: #fff; background: linear-gradient(135deg, #8a2a3b, var(--dw) 55%, var(--dwd)); box-shadow: 0 16px 30px -14px var(--dwd); transition: transform .15s, filter .15s; animation: drt-pulse 2.4s ease-in-out infinite; }
    @keyframes drt-pulse { 0%, 100% { box-shadow: 0 16px 30px -14px var(--dwd), 0 0 0 0 rgba(109,27,43,.35); } 50% { box-shadow: 0 16px 30px -14px var(--dwd), 0 0 0 10px rgba(109,27,43,0); } }
    .drt-btn:hover { transform: translateY(-2px); filter: brightness(1.08); }
    .drt-btn:disabled { opacity: .6; transform: none; }
    .drt-msg { margin-top: 10px; font-size: 14px; font-weight: 800; color: #b91c1c; }
    .drt-hurry { margin-top: 12px; text-align: center; font-size: 13px; font-weight: 900; color: #a5541a; }
    .drt-note { margin-top: 6px; font-size: 12.5px; font-weight: 700; color: #8a6a4a; text-align: center; }
    .drt-done { text-align: center; padding: 30px 18px; border-radius: 24px; color: #3b2418; background: linear-gradient(160deg, #fbf5ea 0%, #f3e6d0 100%); border: 1px solid #e6d3b3; }
    .drt-done-ico { width: 64px; height: 64px; margin: 0 auto 12px; border-radius: 999px; display: flex; align-items: center; justify-content: center; font-size: 30px; font-weight: 900; color: #fff; background: linear-gradient(135deg, var(--dw), var(--dwd)); }
    .drt-done-title { font-size: 22px; font-weight: 900; margin-bottom: 6px; color: var(--dwd); }
    .drt-done-text { color: #5b4030; font-weight: 600; line-height: 1.9; }
    @media (prefers-reduced-motion: reduce) { .drt-limited, .drt-btn, .drt-live::after { animation: none; } }
</style>
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
                window.trackEvent && trackEvent('Lead', { content_name: 'dr_tariq_thursday' });
                return;
            }
            var errs = res.d.errors || {};
            var first = Object.keys(errs).map(function (k) { return errs[k][0]; })[0];
            msg.textContent = first || res.d.message || (res.status === 429 ? @json($drtT('محاولات كثيرة، جرّب بعد دقيقة', 'Too many tries, wait a minute')) : '');
            msg.classList.remove('hidden');
        })
        .catch(function () { form.submit(); })
        .finally(function () { btn.disabled = false; });
});
</script>
@endonce
@endif
