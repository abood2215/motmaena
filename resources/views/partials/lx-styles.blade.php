{{-- The site's quiet, editorial look: ivory, wine, a muted gold hairline, thin-line icons. No glow, no bounce, no emoji. --}}
@once
<style>
    .lx { --wine: #6b1d2c; --wine-d: #4a121d; --gold: #a8844f; --gold-l: #d9c4a0; --ink: #1f1a17; --body: #5b524b; --muted: #8a8078; --line: #e9e1d6; --ivory: #faf7f2; --paper: #ffffff; color: var(--body); }
    .dark .lx { --ink: #f5efe8; --body: #d6cdc4; --muted: #a39a91; --line: rgba(255,255,255,.1); --ivory: #120e0d; --paper: #1a1514; --gold: #c4a473; }
    .lx-ivory { background: var(--ivory); }
    .lx-paper { background: var(--paper); }
    .lx-ink { background: #1c1714; color: #efe8df; }
    .lx-label { display: inline-flex; align-items: center; gap: 10px; font-size: 13px; font-weight: 700; letter-spacing: .03em; color: var(--gold); }
    .lx-label::before { content: ''; width: 28px; height: 1px; background: currentColor; }
    .lx-h1 { font-weight: 800; color: var(--ink); line-height: 1.22; font-size: clamp(2rem, 4.4vw, 3.3rem); letter-spacing: -.01em; }
    .lx-h2 { font-weight: 800; color: var(--ink); line-height: 1.28; font-size: clamp(1.55rem, 2.8vw, 2.2rem); }
    .lx-h3 { font-weight: 800; color: var(--ink); line-height: 1.35; font-size: 1.2rem; }
    .lx-text { color: var(--body); font-weight: 500; line-height: 1.95; }
    .lx-muted { color: var(--muted); }
    .lx-wine { color: var(--wine); }
    .dark .lx-wine { color: var(--gold-l); }
    .lx-btn { display: inline-flex; align-items: center; justify-content: center; gap: 10px; font-weight: 800; font-size: 16px; padding: 14px 26px; border-radius: 10px; border: 1px solid transparent; transition: background .2s, color .2s, border-color .2s; white-space: nowrap; }
    .lx-btn-primary { background: var(--wine); color: #fff; }
    .lx-btn-primary:hover { background: var(--wine-d); }
    .lx-btn-outline { border-color: color-mix(in srgb, var(--ink) 35%, transparent); color: var(--ink); }
    .lx-btn-outline:hover { border-color: var(--ink); background: var(--ink); color: var(--paper); }
    .lx-btn-light { background: #fff; color: var(--wine-d); }
    .lx-btn-light:hover { background: #f3ece3; }
    .lx-btn:disabled { opacity: .6; }
    @media (max-width: 400px) { .lx-btn { white-space: normal; text-align: center; } }
    .lx-card { background: var(--paper); border: 1px solid var(--line); border-radius: 14px; }
    .lx-rule { height: 1px; background: var(--line); }
    .lx-ico { width: 22px; height: 22px; flex-shrink: 0; fill: none; stroke: var(--wine); stroke-width: 1.5; stroke-linecap: round; stroke-linejoin: round; }
    .dark .lx-ico { stroke: var(--gold-l); }
    /* Portrait: a plain photo with a thin gold frame set off behind it */
    .lx-photo { position: relative; }
    .lx-photo::before { content: ''; position: absolute; inset: 18px -18px -18px 18px; border: 1px solid var(--gold); border-radius: 6px; pointer-events: none; }
    [dir="rtl"] .lx-photo::before { inset: 18px 18px -18px -18px; }
    .lx-photo img { position: relative; display: block; width: 100%; border-radius: 6px; object-fit: cover; }
    .lx-date { display: flex; flex-direction: column; align-items: center; justify-content: center; width: 74px; flex-shrink: 0; padding: 10px 0; border: 1px solid var(--line); border-radius: 10px; background: var(--ivory); }
    .lx-date b { font-size: 28px; font-weight: 800; color: var(--wine); line-height: 1; }
    .dark .lx-date b { color: var(--gold-l); }
    .lx-date span { font-size: 12px; font-weight: 700; color: var(--muted); margin-top: 4px; }
    .lx-old { text-decoration: line-through; color: var(--muted); font-weight: 600; }
    .lx-input { width: 100%; border: 1px solid var(--line); background: var(--paper); border-radius: 10px; padding: 13px 14px; font-size: 15px; font-weight: 600; color: var(--ink); outline: none; transition: border-color .15s, box-shadow .15s; }
    .lx-input::placeholder { color: var(--muted); font-weight: 500; }
    .lx-input:focus { border-color: var(--wine); box-shadow: 0 0 0 3px color-mix(in srgb, var(--wine) 12%, transparent); }
    .lx-choice { position: relative; display: block; cursor: pointer; }
    .lx-choice input { position: absolute; opacity: 0; pointer-events: none; }
    .lx-choice > span { display: flex; align-items: center; gap: 12px; padding: 14px 16px; border: 1px solid var(--line); border-radius: 10px; background: var(--paper); font-weight: 700; color: var(--ink); transition: border-color .15s, box-shadow .15s; }
    .lx-choice input:checked + span { border-color: var(--wine); box-shadow: inset 0 0 0 1px var(--wine); }
    .lx-choice input:focus-visible + span { outline: 2px solid var(--wine); outline-offset: 2px; }
    .lx-dot { width: 16px; height: 16px; border-radius: 99px; border: 1.5px solid var(--muted); flex-shrink: 0; display: inline-flex; align-items: center; justify-content: center; }
    .lx-choice input:checked + span .lx-dot { border-color: var(--wine); }
    .lx-choice input:checked + span .lx-dot::after { content: ''; width: 8px; height: 8px; border-radius: 99px; background: var(--wine); }
    .lx-topic { display: flex; gap: 10px; align-items: flex-start; font-weight: 600; color: var(--body); line-height: 1.7; }
    .lx-topic .lx-ico { width: 18px; height: 18px; margin-top: 4px; stroke: var(--gold); }
    .lx-icon-ring { width: 44px; height: 44px; border-radius: 999px; border: 1px solid var(--line); display: inline-flex; align-items: center; justify-content: center; flex-shrink: 0; background: var(--paper); }
    .lx-section { padding-block: 4rem; }
    @media (min-width: 640px) { .lx-section { padding-block: 6rem; } }
    .lx-notice { border: 1px solid color-mix(in srgb, var(--gold) 45%, transparent); background: color-mix(in srgb, var(--gold) 7%, var(--paper)); border-radius: 12px; }
    /* Questions: native <details>, no script needed */
    .lx-faq { border-bottom: 1px solid var(--line); }
    .lx-faq summary { list-style: none; cursor: pointer; display: flex; align-items: center; justify-content: space-between; gap: 16px; padding: 20px 0; font-weight: 800; color: var(--ink); }
    .lx-faq summary::-webkit-details-marker { display: none; }
    .lx-faq summary::after { content: '+'; font-size: 22px; font-weight: 500; color: var(--wine); line-height: 1; flex-shrink: 0; }
    .dark .lx-faq summary::after { color: var(--gold-l); }
    .lx-faq[open] summary::after { content: '−'; }
    .lx-faq p { padding-bottom: 20px; margin-top: -4px; }
    .lx-select { appearance: none; background-image: linear-gradient(45deg, transparent 50%, var(--muted) 50%), linear-gradient(135deg, var(--muted) 50%, transparent 50%); background-position: calc(100% - 20px) 55%, calc(100% - 15px) 55%; background-size: 5px 5px; background-repeat: no-repeat; padding-inline-end: 36px; }
    [dir="rtl"] .lx-select { background-position: 20px 55%, 15px 55%; }
    .lx-check { display: flex; gap: 12px; align-items: flex-start; cursor: pointer; font-size: 14px; font-weight: 600; line-height: 1.8; color: var(--body); }
    .lx-check input { width: 18px; height: 18px; margin-top: 4px; flex-shrink: 0; accent-color: var(--wine); }
    .lx-link { color: var(--wine); font-weight: 800; text-decoration: underline; text-underline-offset: 4px; }
    .dark .lx-link { color: var(--gold-l); }
    .lx-price { font-weight: 800; color: var(--ink); line-height: 1; }
    /* Sticky booking bar (phones): slides in after the first call to action */
    .mh-bar { transform: translateY(110%); transition: transform .3s ease; }
    .mh-bar.on { transform: translateY(0); }
    @media (max-width: 1023px) {
        #global-float-wa, #back-to-top { transition: bottom .3s ease, opacity .5s, transform .5s; }
        body.mh-bar-on #global-float-wa, body.mh-bar-on #back-to-top { bottom: 92px; }
    }
</style>
@endonce
