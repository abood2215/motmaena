{{-- "Notify me about the next course" — $courseKey optional, $dark for use on dark/blue backgrounds --}}
@php
    $isArN = app()->getLocale() == 'ar';
    $formId = 'notify-' . \Illuminate\Support\Str::random(6);
    $waSide = $isArN ? 'right' : 'left'; // WhatsApp icon sits where the text starts
@endphp
<form id="{{ $formId }}" method="POST" action="{{ route('leads.store') }}" class="flex flex-col sm:flex-row sm:flex-wrap {{ !empty($paper) ? 'gap-3 sm:items-end' : 'gap-2' }} w-full" onsubmit="return submitNotify(this)">
    @csrf
    <input type="hidden" name="course_key" value="{{ $courseKey ?? '' }}">
    <input type="text" name="website" tabindex="-1" autocomplete="off" class="hidden" aria-hidden="true">
    <div class="relative flex-1 min-w-0 flex">
        <svg style="{{ $waSide }}: {{ !empty($paper) ? '.15rem' : '.8rem' }}" class="absolute top-1/2 -translate-y-1/2 w-5 h-5 text-[#25d366] pointer-events-none" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.47 14.38c-.3-.15-1.75-.86-2.02-.96-.27-.1-.47-.15-.67.15-.2.3-.77.96-.94 1.16-.17.2-.35.22-.64.07-.3-.15-1.26-.46-2.39-1.47-.88-.79-1.48-1.76-1.65-2.06-.17-.3-.02-.46.13-.6.13-.14.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.03-.52-.07-.15-.67-1.6-.92-2.2-.24-.58-.49-.5-.67-.5h-.57c-.2 0-.52.07-.79.37-.27.3-1.04 1.02-1.04 2.48 0 1.46 1.07 2.88 1.21 3.07.15.2 2.1 3.2 5.08 4.49.71.31 1.26.49 1.7.63.71.22 1.36.19 1.87.12.57-.09 1.75-.72 2-1.41.25-.69.25-1.29.17-1.41-.07-.12-.27-.2-.57-.35zM12.04 21.5h-.01a9.45 9.45 0 0 1-4.82-1.32l-.35-.2-3.58.94.96-3.49-.23-.36a9.44 9.44 0 0 1-1.45-5.03c0-5.22 4.25-9.46 9.48-9.46 2.53 0 4.9.99 6.7 2.78a9.4 9.4 0 0 1 2.77 6.7c0 5.22-4.25 9.46-9.47 9.46zm8.06-17.52A11.32 11.32 0 0 0 12.04.66C5.76.66.65 5.77.65 12.05c0 2 .52 3.96 1.52 5.69L.55 23.7l6.1-1.6a11.36 11.36 0 0 0 5.4 1.37h.01c6.27 0 11.38-5.1 11.39-11.38 0-3.04-1.18-5.9-3.34-8.05z"/></svg>
        <input type="tel" name="phone" required dir="ltr" inputmode="tel" style="padding-{{ $waSide }}: {{ !empty($paper) ? '2rem' : '2.5rem' }}" placeholder="{{ $isArN ? 'رقم الواتساب' : 'WhatsApp number' }}"
           class="{{ !empty($paper) ? 'ps-input' : 'flex-1 min-w-0 rounded-xl px-4 py-3 text-sm font-bold outline-none' }} {{ !empty($paper) ? '' : (!empty($dark) ? 'bg-white/15 border border-white/25 text-white placeholder-white/60 focus:bg-white/20' : 'bg-white dark:bg-white/5 border border-gray-200 dark:border-white/10 text-gray-900 dark:text-white focus:border-primary') }} {{ $isArN ? 'text-right' : '' }}">
    </div>
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
