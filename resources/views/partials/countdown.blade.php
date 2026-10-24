{{-- Countdown to $startsAt (ISO string), in a warm accent that stands out on any course colour. Hidden once the time has passed. --}}
@php $isArC = app()->getLocale() == 'ar'; @endphp
@if(!empty($compact))
{{-- Slim one-line version for the checkout summary --}}
<div class="countdown flex items-center justify-between gap-3 rounded-xl px-3.5 py-2.5 bg-[#fbf6ee] dark:bg-white/5 text-sm {{ $class ?? '' }}" data-target="{{ $startsAt }}">
    <span class="font-bold text-gray-600 dark:text-gray-300">⏳ {{ $isArC ? 'تبدأ الدورة بعد' : 'Starts in' }}</span>
    <span class="flex items-baseline gap-2.5 font-black text-gray-900 dark:text-white tabular-nums" dir="{{ $isArC ? 'rtl' : 'ltr' }}">
        @foreach([['d', $isArC ? 'يوم' : 'd'], ['h', $isArC ? 'ساعة' : 'h'], ['m', $isArC ? 'دقيقة' : 'm']] as [$unit, $label])
            <span><span data-unit="{{ $unit }}">--</span> <small class="text-[11px] font-bold text-gray-500 dark:text-gray-400">{{ $label }}</small></span>
        @endforeach
    </span>
</div>
@else
<div class="countdown flex items-center gap-2 {{ $class ?? '' }}" data-target="{{ $startsAt }}">
    <span class="hidden sm:inline text-xs font-black opacity-90 {{ !empty($dark) ? 'text-white' : 'text-gray-700 dark:text-gray-200' }}">⏳ {{ $isArC ? 'باقي على الدورة' : 'Starts in' }}</span>
    @foreach([['d', $isArC ? 'يوم' : 'days'], ['h', $isArC ? 'ساعة' : 'hrs'], ['m', $isArC ? 'دقيقة' : 'min'], ['s', $isArC ? 'ثانية' : 'sec']] as [$unit, $label])
    <div class="countdown-box text-center min-w-[54px] rounded-xl px-2 py-1.5 text-[#3b1d00]">
        <div class="font-black text-xl leading-none tabular-nums" data-unit="{{ $unit }}">--</div>
        <div class="text-[10px] font-black opacity-75 mt-1">{{ $label }}</div>
    </div>
    @endforeach
</div>
@endif

@once
<style>
    .countdown-box {
        background: linear-gradient(160deg, #fde68a 0%, #fbbf24 45%, #f59e0b 100%);
        box-shadow: 0 6px 16px -6px rgba(245, 158, 11, .75), inset 0 1px 0 rgba(255, 255, 255, .6);
    }
    .countdown-box [data-unit="s"] { animation: cd-tick 1s steps(1) infinite; }
    @keyframes cd-tick { 50% { opacity: .85; } }
</style>
<script>
(function () {
    function tick() {
        document.querySelectorAll('.countdown[data-target]').forEach(function (el) {
            var diff = new Date(el.dataset.target) - new Date();
            if (isNaN(diff) || diff <= 0) { el.style.display = 'none'; return; }
            var parts = { d: Math.floor(diff / 864e5), h: Math.floor(diff / 36e5) % 24, m: Math.floor(diff / 6e4) % 60, s: Math.floor(diff / 1e3) % 60 };
            Object.keys(parts).forEach(function (k) {
                var n = el.querySelector('[data-unit="' + k + '"]');
                if (n) n.textContent = String(parts[k]).padStart(2, '0');
            });
        });
    }
    tick();
    setInterval(tick, 1000);
})();
</script>
@endonce
