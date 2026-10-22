{{-- Countdown to $startsAt (ISO string). Hidden once the time has passed. --}}
@php $isArC = app()->getLocale() == 'ar'; @endphp
<div class="countdown flex items-center gap-2 {{ $class ?? '' }}" data-target="{{ $startsAt }}">
    @foreach([['d', $isArC ? 'يوم' : 'days'], ['h', $isArC ? 'ساعة' : 'hrs'], ['m', $isArC ? 'دقيقة' : 'min'], ['s', $isArC ? 'ثانية' : 'sec']] as [$unit, $label])
    <div class="text-center min-w-[52px] rounded-xl px-2 py-1.5 {{ !empty($dark) ? 'bg-white/12 border border-white/20' : 'bg-[#eef3fa] dark:bg-white/5' }}">
        <div class="font-black text-xl leading-none" data-unit="{{ $unit }}">--</div>
        <div class="text-[10px] font-bold opacity-70 mt-1">{{ $label }}</div>
    </div>
    @endforeach
</div>

@once
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
