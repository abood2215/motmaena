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
</style>
@endonce
