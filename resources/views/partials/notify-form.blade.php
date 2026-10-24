{{-- "Notify me about the next course" — $courseKey optional, $dark for use on dark/blue backgrounds --}}
@php
    $isArN = app()->getLocale() == 'ar';
    $formId = 'notify-' . \Illuminate\Support\Str::random(6);
@endphp
<form id="{{ $formId }}" method="POST" action="{{ route('leads.store') }}" class="flex flex-col sm:flex-row sm:flex-wrap {{ !empty($paper) ? 'gap-3 sm:items-end' : 'gap-2' }} w-full" onsubmit="return submitNotify(this)">
    @csrf
    <input type="hidden" name="course_key" value="{{ $courseKey ?? '' }}">
    <input type="text" name="website" tabindex="-1" autocomplete="off" class="hidden" aria-hidden="true">
    <input type="tel" name="phone" required dir="ltr" placeholder="{{ $isArN ? 'رقم الواتساب' : 'WhatsApp number' }}"
           class="{{ !empty($paper) ? 'ps-input' : 'flex-1 min-w-0 rounded-xl px-4 py-3 text-sm font-bold outline-none' }} {{ !empty($paper) ? '' : (!empty($dark) ? 'bg-white/15 border border-white/25 text-white placeholder-white/60 focus:bg-white/20' : 'bg-white dark:bg-white/5 border border-gray-200 dark:border-white/10 text-gray-900 dark:text-white focus:border-primary') }} {{ $isArN ? 'text-right' : '' }}">
    <button class="{{ !empty($paper) ? 'ps-btn' : 'shrink-0 rounded-xl px-5 py-3 text-sm font-black whitespace-nowrap transition' }} {{ !empty($paper) ? '' : (!empty($dark) ? 'bg-white text-[#6d1b2b] hover:bg-[#f5ebe6]' : 'bg-primary text-white hover:bg-primary-dark') }}">
        {{ empty($paper) ? '🔔 ' : '' }}{{ $isArN ? 'بلّغني' : 'Notify me' }}
    </button>
    <p class="notify-msg hidden w-full text-sm font-bold sm:basis-full"></p>
</form>

@once
<script>
function submitNotify(form) {
    var btn = form.querySelector('button'), msg = form.querySelector('.notify-msg');
    btn.disabled = true;
    fetch(form.action, { method: 'POST', headers: { 'Accept': 'application/json' }, body: new FormData(form) })
        .then(function (r) { return r.json().then(function (d) { return { ok: r.ok, d: d }; }); })
        .then(function (res) {
            msg.textContent = res.ok ? res.d.message : ((res.d.errors && res.d.errors.phone && res.d.errors.phone[0]) || res.d.message);
            msg.className = 'notify-msg w-full text-sm font-bold sm:basis-full ' + (res.ok ? 'text-green-500' : 'text-red-500');
            if (res.ok) { form.querySelector('input[name=phone]').value = ''; window.trackEvent && trackEvent('Lead', {}); }
        })
        .catch(function () { form.submit(); })
        .finally(function () { btn.disabled = false; });
    return false;
}
</script>
@endonce
