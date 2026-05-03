@extends('layouts.app')

@section('title', __('Session Packages') . ' — ' . __('Motmaena Center'))

@section('content')
<style>
*, *::before, *::after { box-sizing: border-box; }

:root {
  --red:    #b04141;
  --red-2:  #c55555;
  --red-lt: #fde8e8;
  --gold:   #D4A853;
  --cream:  #FEFAF4;
  --warm:   #F7F0E6;
  --text:   #1A0A0A;
  --muted:  #7A5C5C;
  --s-border: rgba(176,65,65,.12);
  --surface:#FFF8F0;
}

.dark .sessions-page {
  --red:    #d34c4c;
  --red-2:  #e65c5c;
  --red-lt: rgba(176,65,65,.15);
  --gold:   #E5B96F;
  --cream:  #0f0f0f;
  --warm:   #1a1a1a;
  --text:   #f0f0f0;
  --muted:  #9a9a9a;
  --s-border: rgba(255,255,255,.1);
  --surface: #141414;
}

.dark .sessions-page .plan-card:hover,
.dark .sessions-page .eval-card:hover,
.dark .sessions-page .reinforce-card:hover { 
  box-shadow: 0 32px 70px rgba(0,0,0,.5); 
  border-color: rgba(176,65,65,.4);
}
.dark .sessions-page .sess-btn-secondary { border-color: rgba(255,255,255,.2); }


/* ── Reveal (scoped to sessions page) ── */
.sessions-page .reveal { opacity:0; transform:translateY(32px); transition: opacity .8s ease, transform .8s ease; }
.sessions-page .reveal.active { opacity:1; transform:none; }

/* ─── HERO ─── */
.hero {
  min-height: calc(100vh - 80px);
  display: grid;
  align-items: center;
  padding: 80px 40px 80px;
  position: relative;
  overflow: hidden;
  background: var(--cream);
}
.hero::before {
  content:'';
  position: absolute;
  width: 900px; height: 900px;
  border-radius: 50%;
  border: 1px solid rgba(176,65,65,.08);
  top: 50%; left: -200px;
  transform: translateY(-50%);
}
.hero::after {
  content:'';
  position: absolute;
  width: 600px; height: 600px;
  border-radius: 50%;
  border: 1px solid rgba(176,65,65,.06);
  top: 50%; left: -50px;
  transform: translateY(-50%);
}
.hero-inner {
  position: relative; z-index: 2;
  max-width: 1200px; margin: 0 auto;
  display: grid;
  grid-template-columns: 1fr 420px;
  gap: 60px;
  align-items: center;
  width: 100%;
}
.hero-tag {
  display: inline-flex; align-items: center; gap: 8px;
  background: var(--red-lt); border: 1px solid rgba(176,65,65,.2);
  padding: 8px 18px; border-radius: 100px;
  font-size: .75rem; font-weight: 700; color: var(--red);
  letter-spacing: .1em; text-transform: uppercase;
  margin-bottom: 32px;
}
.hero-tag i {
  width: 6px; height: 6px; background: var(--red);
  border-radius: 50%;
  animation: blink 1.5s ease-in-out infinite;
}
@keyframes blink { 0%,100%{opacity:1} 50%{opacity:.3} }
.hero-title {
  font-family: 'Tajawal', sans-serif;
  font-weight: 900;
  font-size: clamp(3rem, 7vw, 6.5rem);
  line-height: 1.0;
  color: var(--text);
  margin-bottom: 24px;
}
.hero-title .accent {
  color: var(--red);
  position: relative;
}
.hero-title .accent::after {
  content: '';
  position: absolute;
  bottom: 4px; right: 0; left: 0;
  height: 6px;
  background: linear-gradient(90deg, var(--gold), transparent);
  border-radius: 3px;
  opacity: .6;
}
.hero-sub {
  font-size: 1.05rem; line-height: 1.9;
  color: var(--muted);
  max-width: 480px;
  margin-bottom: 40px;
}
.hero-btns { display: flex; gap: 14px; flex-wrap: wrap; }
.sess-btn-primary {
  background: var(--red); color: #fff;
  padding: 16px 36px; border-radius: 16px;
  font-weight: 700; font-size: 1rem; text-decoration: none;
  display: flex; align-items: center; gap: 10px;
  transition: transform .25s, box-shadow .25s;
  box-shadow: 0 16px 40px rgba(176,65,65,.3);
}
.sess-btn-primary:hover { transform: translateY(-3px); box-shadow: 0 24px 48px rgba(176,65,65,.4); }
.sess-btn-secondary {
  background: transparent; color: var(--text);
  padding: 16px 36px; border-radius: 16px;
  font-weight: 700; font-size: 1rem; text-decoration: none;
  border: 1.5px solid rgba(26,10,10,.15);
  transition: border-color .25s, background .25s;
}
.sess-btn-secondary:hover { border-color: var(--red); background: var(--warm); }

/* Hero stats card */
.hero-stats {
  background: var(--surface);
  border-radius: 28px;
  padding: 36px 32px;
  box-shadow: 0 32px 80px rgba(176,65,65,.1), 0 0 0 1px var(--s-border);
  position: relative;
}
.hero-stats::before {
  content:'';
  position: absolute; top: 0; right: 0;
  width: 120px; height: 120px;
  background: radial-gradient(circle, rgba(212,168,83,.15) 0%, transparent 70%);
  border-radius: 0 28px 0 0;
}
.stats-label {
  font-size: .7rem; font-weight: 700; letter-spacing: .15em;
  text-transform: uppercase; color: var(--muted); margin-bottom: 28px;
}
.stat-row { display: flex; gap: 0; margin-bottom: 0; }
.stat-item {
  flex: 1;
  padding: 20px 16px;
  text-align: center;
  position: relative;
}
.stat-item + .stat-item::before {
  content: '';
  position: absolute; top: 20%; right: 0;
  width: 1px; height: 60%;
  background: var(--s-border);
}
.stat-num {
  font-size: 2.8rem; font-weight: 900; color: var(--red);
  line-height: 1; display: block;
}
.stat-lbl {
  font-size: .72rem; font-weight: 600; color: var(--muted);
  margin-top: 6px; display: block;
}
.rating-row {
  margin-top: 28px; padding-top: 24px;
  border-top: 1px solid var(--s-border);
  display: flex; gap: 12px; align-items: center;
}
.stars { color: var(--gold); font-size: 1.1rem; letter-spacing: 2px; }
.rating-text { font-size: .82rem; color: var(--muted); line-height: 1.5; }
.rating-text strong { color: var(--text); display: block; font-size: .95rem; }

/* ─── SECTION HEADER ─── */
.sec-header { margin-bottom: 56px; }
.sec-tag {
  font-size: .72rem; font-weight: 700; letter-spacing: .2em;
  text-transform: uppercase; color: var(--red); margin-bottom: 12px;
  display: flex; align-items: center; gap: 8px;
}
.sec-tag::before {
  content: '';
  width: 24px; height: 2px;
  background: var(--red); display: inline-block;
}
.sec-title {
  font-size: clamp(1.8rem, 3.5vw, 2.8rem);
  font-weight: 900; line-height: 1.15;
  color: var(--text);
}
.sec-sub {
  margin-top: 12px; font-size: 1rem;
  color: var(--muted); line-height: 1.7; max-width: 500px;
}

/* ─── SECTIONS / CONTAINER ─── */
.s-section { padding: 100px 40px; background: var(--cream); position: relative; }
.s-section.alt { background: var(--warm); }
.s-container { max-width: 1200px; margin: 0 auto; }

/* ─── EVAL ─── */
.eval-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
.eval-card {
  background: var(--surface);
  border-radius: 24px;
  padding: 36px;
  display: flex; align-items: center; justify-content: space-between; gap: 24px;
  border: 1px solid var(--s-border);
  transition: transform .3s, box-shadow .3s;
  cursor: default;
}
.eval-card:hover { transform: translateY(-6px); box-shadow: 0 24px 60px rgba(176,65,65,.1); }
.eval-icon {
  width: 56px; height: 56px; border-radius: 18px;
  background: var(--warm); display: flex; align-items: center; justify-content: center;
  color: var(--red); flex-shrink: 0;
  transition: background .3s, color .3s;
}
.eval-card:hover .eval-icon { background: var(--red); color: #fff; }
.eval-name { font-size: 1.05rem; font-weight: 700; color: var(--text); }
.eval-name-sub { font-size: .85rem; color: var(--muted); margin-top: 4px; }
.eval-price { text-align: left; flex-shrink: 0; }
.price-big { font-size: 3.2rem; font-weight: 900; color: var(--red); line-height: 1; }
.price-unit {
  font-size: .72rem; font-weight: 700; color: var(--muted);
  letter-spacing: .1em; text-transform: uppercase; margin-top: 4px;
}
.eval-tags { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 20px; }
.s-tag {
  padding: 6px 14px; border-radius: 100px;
  font-size: .72rem; font-weight: 700; letter-spacing: .08em;
  background: var(--warm); color: var(--red);
  border: 1px solid rgba(176,65,65,.15);
  transition: background .2s, color .2s;
}
.s-tag:hover { background: var(--red); color: #fff; cursor: default; }

/* ─── PLANS ─── */
.plans-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 16px;
  align-items: stretch;
}
.plan-card {
  background: var(--surface);
  border-radius: 24px;
  padding: 32px 28px;
  display: flex; flex-direction: column; gap: 0;
  border: 1px solid var(--s-border);
  transition: transform .3s, box-shadow .3s;
  position: relative; overflow: hidden;
}
.plan-card:hover { transform: translateY(-8px); box-shadow: 0 32px 70px rgba(176,65,65,.1); }
.plan-card.featured {
  background: var(--red);
  border-color: var(--red);
  transform: scale(1.03);
  box-shadow: 0 40px 80px rgba(176,65,65,.3);
}
.dark .plan-card.featured {
  box-shadow: 0 40px 80px rgba(0,0,0,.5), 0 0 32px rgba(176,65,65,.2);
}
.plan-card.featured:hover { transform: scale(1.03) translateY(-8px); box-shadow: 0 40px 80px rgba(176,65,65,.4); }
.plan-card.daily { background: #1A0A0A; border-color: transparent; }
.dark .plan-card.daily { background: #000; }
.plan-card.daily .plan-price { color: var(--red-2); }
.plan-card.daily .plan-feature { color: rgba(255,255,255,.7); }
.plan-card.daily .plan-sessions { color: rgba(255,255,255,.5); }
.plan-card.daily .plan-kd { color: rgba(255,255,255,.45); }


.plan-badge {
  display: inline-block;
  padding: 6px 14px; border-radius: 100px;
  font-size: .68rem; font-weight: 700; letter-spacing: .12em; text-transform: uppercase;
  background: rgba(212,168,83,.2); color: var(--gold);
  border: 1px solid rgba(212,168,83,.3);
  margin-bottom: 24px; align-self: flex-start;
}
.plan-sessions {
  font-size: .72rem; font-weight: 700; letter-spacing: .15em; text-transform: uppercase;
  color: var(--muted); margin-bottom: 10px;
}
.plan-card.featured .plan-sessions { color: rgba(255,255,255,.6); }
.plan-card.daily .plan-sessions { color: rgba(255,255,255,.5); }
.plan-price-wrap { margin-bottom: 28px; }
.plan-price { font-size: 4rem; font-weight: 900; color: var(--text); line-height: 1; }
.plan-card.featured .plan-price { color: #fff; text-shadow: 0 2px 10px rgba(0,0,0,.1); }
.plan-card.featured .plan-sessions,
.plan-card.featured .plan-per-session,
.plan-card.featured .plan-feature {
  color: #fff;
  text-shadow: 0 1px 4px rgba(0,0,0,.15);
}
.plan-card.daily .plan-price { color: var(--red-2); font-size: 3.2rem; }
.plan-kd {
  font-size: .9rem; font-weight: 700; color: var(--muted);
  margin-right: 4px; vertical-align: top; margin-top: 8px; display: inline-block;
}
.plan-card.featured .plan-kd { color: rgba(255,255,255,.6); }
.plan-per-session { font-size: .78rem; color: var(--muted); margin-top: 4px; }
.plan-card.featured .plan-per-session { color: rgba(255,255,255,.55); }
.plan-divider { height: 1px; background: var(--s-border); margin-bottom: 24px; }
.plan-card.featured .plan-divider { background: rgba(255,255,255,.15); }
.plan-card.daily .plan-divider { background: rgba(255,255,255,.1); }
.plan-features { list-style: none; padding: 0; display: flex; flex-direction: column; gap: 12px; flex: 1; margin-bottom: 28px; }
.plan-feature { display: flex; align-items: center; gap: 10px; font-size: .88rem; color: var(--muted); }
.plan-card.featured .plan-feature { color: rgba(255,255,255,.8); }
.plan-card.daily .plan-feature { color: rgba(255,255,255,.7); }
.plan-check {
  width: 20px; height: 20px; border-radius: 50%;
  background: var(--warm); flex-shrink: 0;
  display: flex; align-items: center; justify-content: center;
}
.plan-card.featured .plan-check { background: rgba(255,255,255,.2); }
.plan-card.daily .plan-check { background: rgba(176,65,65,.25); }
.check-icon { color: var(--red); font-size: .75rem; font-weight: 900; }
.plan-card.featured .check-icon { color: #fff; }
.plan-card.daily .check-icon { color: var(--red-2); }
.plan-btn {
  display: block; text-align: center; padding: 14px;
  border-radius: 14px; font-weight: 700; font-size: .9rem;
  text-decoration: none; transition: all .25s;
  border: 1.5px solid var(--s-border);
  color: var(--text); background: transparent;
}
.plan-btn:hover { background: var(--warm); border-color: var(--red); color: var(--red); }
.plan-card.featured .plan-btn {
  background: #fff; color: var(--red); border-color: transparent;
  box-shadow: 0 8px 24px rgba(0,0,0,.15);
}
.plan-card.featured .plan-btn:hover { transform: translateY(-2px); box-shadow: 0 14px 32px rgba(0,0,0,.2); }
.plan-card.daily .plan-btn { background: var(--red); color: #fff; border-color: transparent; }

/* daily plan pills */
.daily-pills { display: flex; flex-direction: column; gap: 10px; margin-bottom: 28px; flex: 1; }
.daily-pill {
  padding: 12px 16px; border-radius: 12px;
  background: rgba(255,255,255,.06); border: 1px solid rgba(255,255,255,.08);
  font-size: .82rem; font-weight: 600; color: rgba(255,255,255,.75);
  display: flex; align-items: center; gap: 10px;
}
.daily-pill-dot { width: 6px; height: 6px; background: var(--red-2); border-radius: 50%; flex-shrink: 0; }

/* ─── CLUB + REINFORCEMENT ─── */
.two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
.club-card {
  background: var(--red);
  border-radius: 28px;
  padding: 48px 44px;
  position: relative; overflow: hidden;
}
.club-card::before {
  content: '';
  position: absolute; bottom: -80px; left: -80px;
  width: 300px; height: 300px; border-radius: 50%;
  background: rgba(255,255,255,.06);
}
.club-card::after {
  content: '';
  position: absolute; top: -60px; right: -60px;
  width: 200px; height: 200px; border-radius: 50%;
  background: rgba(255,255,255,.04);
}
.club-inner { position: relative; z-index: 2; }
.club-eyebrow {
  display: inline-block;
  font-size: .7rem; font-weight: 700; letter-spacing: .2em; text-transform: uppercase;
  color: rgba(255,255,255,.7);
  background: rgba(255,255,255,.12); border: 1px solid rgba(255,255,255,.18);
  padding: 7px 16px; border-radius: 100px; margin-bottom: 20px;
}
.club-title { font-size: 2rem; font-weight: 900; color: #fff; margin-bottom: 36px; }
.club-prices { display: flex; flex-direction: column; gap: 16px; margin-bottom: 32px; }
.club-price-row {
  display: flex; align-items: center; justify-content: space-between;
  background: rgba(255,255,255,.1); border: 1px solid rgba(255,255,255,.14);
  border-radius: 16px; padding: 18px 24px;
}
.club-price-amount { font-size: 2rem; font-weight: 900; color: #fff; }
.club-price-label { font-size: .78rem; font-weight: 600; color: rgba(255,255,255,.6); }
.sibling-box {
  background: rgba(0,0,0,.15); border: 1.5px solid rgba(255,255,255,.2);
  border-radius: 16px; padding: 26px 30px;
  display: flex; align-items: center; justify-content: space-between;
  margin-top: 10px;
}
.sibling-label {
  font-size: .8rem; font-weight: 900; letter-spacing: .15em;
  text-transform: uppercase; color: #fff;
  margin-bottom: 8px;
  text-shadow: 0 1px 4px rgba(0,0,0,.2);
}
.sibling-amount { 
  font-size: 2.6rem; font-weight: 900; color: #FFD700; line-height: 1; 
  text-shadow: 0 2px 10px rgba(0,0,0,.2);
}
.sibling-sub { 
  font-size: .85rem; color: #fff; font-weight: 700; margin-top: 6px; 
  text-shadow: 0 1px 3px rgba(0,0,0,.2);
}
.sibling-icon { color: #FFD700; opacity: 1; filter: drop-shadow(0 2px 6px rgba(0,0,0,.2)); }
.reinforce-card {
  background: var(--surface);
  border-radius: 28px;
  padding: 48px 44px;
  border: 1px solid var(--s-border);
  transition: transform .3s, box-shadow .3s;
}
.reinforce-card:hover { transform: translateY(-6px); box-shadow: 0 32px 70px rgba(176,65,65,.08); }
.reinforce-header {
  display: flex; align-items: flex-start; justify-content: space-between; gap: 20px;
  margin-bottom: 32px;
}
.reinforce-title { font-size: 1.8rem; font-weight: 900; color: var(--text); }
.reinforce-sub { font-size: .85rem; color: var(--muted); margin-top: 6px; }
.reinforce-details { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
.detail-item {
  background: var(--warm); border-radius: 16px; padding: 18px 20px;
  display: flex; align-items: center; gap: 12px;
  transition: background .25s;
}
.detail-item:hover { background: var(--red-lt); }
.detail-icon {
  width: 36px; height: 36px; background: var(--surface);
  border-radius: 10px; display: flex; align-items: center; justify-content: center;
  color: var(--red); flex-shrink: 0;
}
.detail-text { font-size: .82rem; font-weight: 700; color: var(--text); }

/* ─── SPECIALIZED (Always Dark) ─── */
.specialized-bg { background: #1A0A0A; padding: 100px 40px; color: #fff; }
.dark .specialized-bg { background: #000; }
.specialized-bg .sec-title { color: #fff; }
.specialized-bg .sec-sub { color: rgba(255,255,255,.5); }
.specialized-bg .sec-tag { color: rgba(255,255,255,.5); }
.specialized-bg .sec-tag::before { background: rgba(255,255,255,.3); }
.specialized-bg .spec-eval-name { color: #fff; }
.specialized-bg .spec-eval-sub { color: rgba(255,255,255,.45); }
.specialized-bg .spec-daily-title { color: #fff; }
.specialized-bg .spec-daily-unit { color: rgba(255,255,255,.4); }
.specialized-bg .spec-club-title { color: #fff; }
.specialized-bg .spec-club-sub { color: rgba(255,255,255,.45); }
.specialized-bg .meta-value { color: rgba(255,255,255,.8); }
.specialized-bg .spec-club-price { color: #fff; }
.specialized-bg .sp-label { color: rgba(255,255,255,.45); }
.specialized-bg .sp-price { color: #fff; }
.specialized-bg .sp-sched { background: rgba(255,255,255,.08); color: rgba(255,255,255,.7); }
.specialized-bg .sp-btn { background: rgba(255,255,255,.08); color: rgba(255,255,255,.8); border-color: rgba(255,255,255,.1); }

.spec-eval-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px; }
.spec-eval-card {
  background: rgba(255,255,255,.05);
  border: 1px solid rgba(255,255,255,.08);
  border-radius: 20px; padding: 28px 32px;
  display: flex; align-items: center; justify-content: space-between; gap: 20px;
  transition: background .3s, border-color .3s;
}
.spec-eval-card:hover { background: rgba(255,255,255,.08); border-color: rgba(176,65,65,.4); }
.spec-eval-icon {
  width: 52px; height: 52px; border-radius: 16px;
  background: rgba(176,65,65,.2); display: flex; align-items: center; justify-content: center;
  color: var(--red-2); flex-shrink: 0;
}
.spec-eval-name { font-size: 1rem; font-weight: 700; color: #fff; }
.spec-eval-sub { font-size: .82rem; color: rgba(255,255,255,.45); margin-top: 4px; }
.spec-price-big { font-size: 3rem; font-weight: 900; color: var(--red-2); line-height: 1; text-align: left; }
.spec-price-unit { font-size: .68rem; font-weight: 700; color: rgba(255,255,255,.3); text-transform: uppercase; letter-spacing: .1em; margin-top: 3px; text-align: left; }
.spec-pkgs { display: grid; grid-template-columns: 1fr 1.1fr 1fr; gap: 16px; margin-bottom: 20px; }
.spec-pkg {
  border-radius: 24px; padding: 36px 32px;
  border: 1px solid rgba(255,255,255,.08);
  background: rgba(255,255,255,.04);
  display: flex; flex-direction: column; gap: 0;
  transition: border-color .3s, background .3s;
}
.spec-pkg:hover { background: rgba(255,255,255,.07); border-color: rgba(176,65,65,.4); }
.spec-pkg.sp-feat { background: var(--red); border-color: transparent; }
.sp-label {
  font-size: .7rem; font-weight: 700; letter-spacing: .15em; text-transform: uppercase;
  color: rgba(255,255,255,.45); margin-bottom: 16px;
}
.spec-pkg.sp-feat .sp-label { color: rgba(255,255,255,.7); }
.sp-price { font-size: 4rem; font-weight: 900; color: #fff; line-height: 1; margin-bottom: 8px; }
.sp-badge {
  display: inline-block;
  background: rgba(212,168,83,.2); color: var(--gold);
  border: 1px solid rgba(212,168,83,.3);
  font-size: .68rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase;
  padding: 5px 12px; border-radius: 100px; margin-bottom: 20px; align-self: flex-start;
}
.sp-sched {
  background: rgba(255,255,255,.08); border-radius: 12px; padding: 12px 16px;
  font-size: .82rem; font-weight: 700; color: rgba(255,255,255,.7);
  margin-bottom: 24px; flex: 1;
}
.spec-pkg.sp-feat .sp-sched { background: rgba(255,255,255,.15); color: rgba(255,255,255,.9); }
.sp-btn {
  display: block; text-align: center;
  padding: 13px; border-radius: 12px;
  font-weight: 700; font-size: .88rem; text-decoration: none;
  background: rgba(255,255,255,.08); color: rgba(255,255,255,.8);
  border: 1px solid rgba(255,255,255,.1);
  transition: all .25s;
}
.sp-btn:hover { background: rgba(176,65,65,.5); color: #fff; border-color: transparent; }
.spec-pkg.sp-feat .sp-btn { background: #fff; color: var(--red); border-color: transparent; }
.spec-pkg.sp-feat .sp-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,.2); }
.spec-bottom { display: grid; grid-template-columns: 1fr; gap: 16px; }
.spec-daily {
  background: rgba(176,65,65,.15);
  border: 1px solid rgba(176,65,65,.3);
  border-radius: 24px; padding: 40px 36px;
}
.spec-daily-eyebrow {
  display: inline-flex; align-items: center; gap: 8px;
  background: rgba(176,65,65,.2); border: 1px solid rgba(176,65,65,.3);
  font-size: .7rem; font-weight: 700; letter-spacing: .15em; text-transform: uppercase;
  color: var(--red-2); padding: 7px 14px; border-radius: 100px; margin-bottom: 20px;
}
.spec-daily-title { font-size: 1.7rem; font-weight: 900; color: #fff; margin-bottom: 16px; }
.spec-daily-price { font-size: 3.5rem; font-weight: 900; color: var(--red-2); line-height: 1; margin-bottom: 8px; }
.spec-daily-unit { font-size: .82rem; color: rgba(255,255,255,.4); margin-bottom: 28px; }
.spec-daily-items { display: flex; gap: 10px; flex-wrap: wrap; }
.spec-daily-item {
  padding: 8px 16px; border-radius: 100px;
  background: rgba(255,255,255,.07); border: 1px solid rgba(255,255,255,.1);
  font-size: .78rem; font-weight: 600; color: rgba(255,255,255,.65);
}
.spec-club {
  background: rgba(255,255,255,.04);
  border: 1px solid rgba(255,255,255,.08);
  border-radius: 24px; padding: 40px 36px;
  display: flex; flex-direction: column;
  transition: border-color .3s;
  max-width: 680px; margin-inline: auto; width: 100%;
}
.spec-club:hover { border-color: rgba(176,65,65,.4); }
.spec-club-icon {
  width: 56px; height: 56px; background: rgba(176,65,65,.2);
  border-radius: 18px; display: flex; align-items: center; justify-content: center;
  color: var(--red-2); margin-bottom: 20px;
}
.spec-club-title { font-size: 1.6rem; font-weight: 900; color: #fff; margin-bottom: 10px; }
.spec-club-sub { font-size: .88rem; color: rgba(255,255,255,.45); line-height: 1.7; margin-bottom: 28px; }
.spec-club-meta { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 28px; flex: 1; }
.meta-item { background: rgba(255,255,255,.06); border-radius: 12px; padding: 14px 16px; }
.meta-label { font-size: .65rem; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; color: rgba(255,255,255,.3); margin-bottom: 5px; }
.meta-value { font-size: .9rem; font-weight: 700; color: rgba(255,255,255,.8); }
.spec-club-footer { display: flex; align-items: center; justify-content: space-between; padding-top: 24px; border-top: 1px solid rgba(255,255,255,.08); }
.spec-club-price { font-size: 2.8rem; font-weight: 900; color: #fff; line-height: 1; }
.spec-club-btn {
  background: var(--red); color: #fff;
  padding: 13px 28px; border-radius: 14px;
  font-weight: 700; font-size: .9rem; text-decoration: none;
  transition: transform .2s, box-shadow .2s;
}
.spec-club-btn:hover { transform: translateY(-2px); box-shadow: 0 10px 28px rgba(176,65,65,.5); }

/* ─── CTA ─── */
.cta-section {
  padding: 120px 40px;
  background: var(--cream);
  text-align: center;
  position: relative; overflow: hidden;
}
.cta-section::before {
  content: '';
  position: absolute; inset: 0;
  background: radial-gradient(ellipse 60% 70% at 50% 50%, rgba(176,65,65,.06) 0%, transparent 70%);
}
.cta-inner { position: relative; z-index: 2; max-width: 700px; margin: 0 auto; }
.cta-badge {
  display: inline-flex; align-items: center; gap: 8px;
  background: var(--warm); border: 1px solid var(--s-border);
  padding: 10px 20px; border-radius: 100px;
  font-size: .75rem; font-weight: 700; color: var(--muted);
  letter-spacing: .08em; margin-bottom: 32px;
}
.cta-title {
  font-size: clamp(2.2rem, 4vw, 3.8rem);
  font-weight: 900; line-height: 1.15; color: var(--text);
  margin-bottom: 20px;
}
.cta-title span { color: var(--red); }
.cta-sub {
  font-size: 1.05rem; color: var(--muted); line-height: 1.8;
  margin-bottom: 48px; max-width: 520px; margin-inline: auto;
}
.cta-btns { display: flex; gap: 14px; justify-content: center; flex-wrap: wrap; }
.cta-primary {
  background: var(--red); color: #fff;
  padding: 18px 44px; border-radius: 18px;
  font-weight: 700; font-size: 1.05rem; text-decoration: none;
  display: flex; align-items: center; gap: 12px;
  box-shadow: 0 20px 50px rgba(176,65,65,.3);
  transition: transform .25s, box-shadow .25s;
}
.cta-primary:hover { transform: translateY(-4px); box-shadow: 0 28px 60px rgba(176,65,65,.4); }
.cta-secondary {
  background: transparent; color: var(--text);
  padding: 18px 44px; border-radius: 18px;
  font-weight: 700; font-size: 1.05rem; text-decoration: none;
  border: 1.5px solid rgba(26,10,10,.15);
  display: flex; align-items: center; gap: 12px;
  transition: all .25s;
}
.cta-secondary:hover { border-color: var(--red); color: var(--red); background: var(--warm); }

/* ─── RESPONSIVE ─── */
@media (max-width: 1024px) {
  .hero-inner { grid-template-columns: 1fr; gap: 40px; }
  .hero-stats { max-width: 100%; }
  .plans-grid { grid-template-columns: 1fr 1fr; }
  .spec-pkgs { grid-template-columns: 1fr 1fr; }
  .spec-bottom { grid-template-columns: 1fr; }
}
@media (max-width: 768px) {
  .s-section { padding: 48px 24px; }
  .specialized-bg { padding: 48px 24px; }
  .cta-section { padding: 64px 24px; }
  .hero { padding: 40px 24px 60px; min-height: auto; }
  .hero-title { font-size: clamp(2.2rem, 10vw, 3.5rem); line-height: 1.1; }
  .hero-sub { font-size: 0.95rem; }
  .eval-grid, .two-col, .spec-eval-grid, .spec-bottom { grid-template-columns: 1fr; }
  .plans-grid { grid-template-columns: 1fr; }
  .plan-card.featured { transform: none; margin: 10px 0; }
  .plan-price { font-size: 3.2rem; }
  .club-card, .reinforce-card { padding: 32px 24px; }
  .price-big { font-size: 2.8rem; }
}
@media (max-width: 480px) {
  .s-section { padding: 40px 16px; }
  .specialized-bg { padding: 40px 16px; }
  .cta-section { padding: 48px 16px; }
  .hero { padding: 40px 16px 40px; }
  .hero-btns { flex-direction: column; }
  .sess-btn-primary, .sess-btn-secondary { width: 100%; justify-content: center; }
  .hero-stats { padding: 24px 16px; }
  .stat-num { font-size: 2rem; }
  .stat-lbl { font-size: 0.65rem; }
  .reinforce-details { grid-template-columns: 1fr; gap: 10px; }
  .spec-club-meta { grid-template-columns: 1fr; }
  .spec-pkgs { grid-template-columns: 1fr; }
  .spec-eval-card { padding: 16px; flex-direction: column; text-align: center; gap: 12px; }
  .spec-price-big { text-align: center; font-size: 2.5rem; margin-top: 4px; }
  .spec-price-unit { text-align: center; }
  .cta-btns { flex-direction: column; }
  .cta-primary, .cta-secondary { width: 100%; justify-content: center; padding: 14px 24px; }
  .plan-price { font-size: 2.8rem; }
  .plan-card { padding: 24px 20px; }
  .club-card { padding: 28px 20px; }
  .reinforce-card { padding: 28px 20px; }
  .sibling-amount { font-size: 2rem; }
  .spec-daily { padding: 28px 24px; }
  .spec-club { padding: 28px 24px; }
  .rating-row { flex-direction: column; align-items: flex-start; gap: 8px; }
}
@media (max-width: 375px) {
  .hero-title { font-size: clamp(1.9rem, 9vw, 2.5rem); }
  .stat-num { font-size: 1.8rem; }
  .price-big { font-size: 2.4rem; }
  .plan-price { font-size: 2.4rem; }
  .club-title { font-size: 1.6rem; }
}
</style>

<div class="sessions-page" style="font-family: 'Tajawal', sans-serif;">


<!-- ══════════════════════ HERO ══════════════════════ -->
<section class="hero">
  <div class="hero-inner reveal">

    <div>
      <div class="hero-tag">
        <i></i>
        {{ __('Linguistic, Educational, and Training Consultations') }}
      </div>
      <h1 class="hero-title">
        {!! __('Your Child Deserves the Best') !!}
      </h1>
      <p class="hero-sub">
        {{ __('Sessions Hero Subtitle') }}
      </p>
      <div class="hero-btns">
        <a href="https://wa.me/96555665161" class="sess-btn-primary">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.72.937 3.658 1.43 5.623 1.43h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
          </svg>
          {{ __('Talk to a Specialist') }}
        </a>
        <a href="#plans" class="sess-btn-secondary">{{ __('View Plans') }}</a>
      </div>
    </div>

    <!-- Stats Card -->
    <div class="hero-stats">
      <p class="stats-label">{{ __('Our Achievements in Numbers') }}</p>
      <div class="stat-row">
        <div class="stat-item">
          <span class="stat-num" data-target="500">0</span>
          <span class="stat-lbl">{{ __('Children Benefited') }}</span>
        </div>
        <div class="stat-item">
          <span class="stat-num" data-target="10">0</span>
          <span class="stat-lbl">{{ __('Years Experience') }}</span>
        </div>
        <div class="stat-item">
          <span class="stat-num" data-target="98" data-suffix="%">0</span>
          <span class="stat-lbl">{{ __('Parent Satisfaction') }}</span>
        </div>
      </div>
      <div class="rating-row">
        <div class="stars">★★★★★</div>
        <div class="rating-text">
          <strong>{{ __('Exceptional Family Satisfaction') }}</strong>
          {{ __('Real reviews from our followers\' families') }}
        </div>
      </div>
    </div>

  </div>
</section>


<!-- ══════════════════════ EVAL ══════════════════════ -->
<section class="s-section alt">
  <div class="s-container">
    <div class="sec-header reveal">
      <div class="sec-tag">{{ __('Approved Pricing') }}</div>
      <h2 class="sec-title">{{ __('Academic, Behavioral, and Skill Services') }}</h2>
    </div>
    <div class="eval-grid reveal">

      <div class="eval-card">
        <div style="display:flex;align-items:center;gap:20px;">
          <div class="eval-icon">
            <svg width="26" height="26" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
          </div>
          <div>
            <div class="eval-name">{{ __('Initial Evaluation') }}</div>
            <div class="eval-name-sub">{{ __('Comprehensive diagnostic session') }}</div>
          </div>
        </div>
        <div class="eval-price">
          <div class="price-big">50</div>
          <div class="price-unit">{{ __('KD') }}</div>
        </div>
      </div>

      <div class="eval-card" style="flex-direction:column;align-items:stretch;gap:0;">
        <div style="display:flex;align-items:center;justify-content:space-between;gap:20px;">
          <div style="display:flex;align-items:center;gap:20px;">
            <div class="eval-icon">
              <svg width="26" height="26" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
              </svg>
            </div>
            <div>
              <div class="eval-name">{{ __('Specialist Tests') }}</div>
              <div class="eval-name-sub">{{ __('ADHD, IQ, and Behavioral Assessments') }}</div>
            </div>
          </div>
          <div class="eval-price">
            <div class="price-big">120</div>
            <div class="price-unit">{{ __('KD') }}</div>
          </div>
        </div>
        <div class="eval-tags" style="border-top:1px solid var(--s-border);margin-top:20px;padding-top:20px;">
          <span class="s-tag">{{ __('Academic') }}</span>
          <span class="s-tag">{{ __('Behavioral') }}</span>
          <span class="s-tag">{{ __('IQ Test') }}</span>
        </div>
      </div>

    </div>
  </div>
</section>


<!-- ══════════════════════ PLANS ══════════════════════ -->
<section class="s-section" id="plans">
  <div class="s-container">
    <div class="sec-header reveal" style="text-align:center;">
      <div class="sec-tag" style="justify-content:center;">{{ __('Choose Your Plan') }}</div>
      <h2 class="sec-title">{{ __('Session Packages') }}</h2>
      <p class="sec-sub" style="margin-inline:auto;">{{ __('Sessions Subtitle') }}</p>
    </div>

    <div class="plans-grid reveal">

      <!-- 12 جلسة -->
      <div class="plan-card">
        <div class="plan-sessions">{{ __('12 Sessions') }}</div>
        <div class="plan-price-wrap">
          <span class="plan-kd">{{ __('KD') }}</span><span class="plan-price">360</span>
        </div>
        <div class="plan-divider"></div>
        <ul class="plan-features">
          <li class="plan-feature"><span class="plan-check"><span class="check-icon">✓</span></span>{{ __('Massive improvement area') }}</li>
          <li class="plan-feature"><span class="plan-check"><span class="check-icon">✓</span></span>{{ __('One Month Duration') }}</li>
          <li class="plan-feature"><span class="plan-check"><span class="check-icon">✓</span></span>{{ __('3 Days / Week') }}</li>
        </ul>
        <a href="https://wa.me/96555665161" class="plan-btn">{{ __('Get Started') }}</a>
      </div>

      <!-- 24 جلسة FEATURED -->
      <div class="plan-card featured">
        <div class="plan-badge">⭐ {{ __('Most Popular') }}</div>
        <div class="plan-sessions">{{ __('24 Sessions') }}</div>
        <div class="plan-price-wrap">
          <span class="plan-kd" style="color:rgba(255,255,255,.6)">{{ __('KD') }}</span>
          <span class="plan-price">750</span>
        </div>
        <p class="plan-per-session">≈ 31 {{ __('KD') }} {{ __('Per person / Month only') }}</p>
        <div class="plan-divider" style="margin-top:16px;margin-bottom:24px;"></div>
        <ul class="plan-features">
          <li class="plan-feature"><span class="plan-check"><span class="check-icon">✓</span></span>{{ __('Significant Behavioral Change') }}</li>
          <li class="plan-feature"><span class="plan-check"><span class="check-icon">✓</span></span>{{ __('3 Months Duration') }}</li>
          <li class="plan-feature"><span class="plan-check"><span class="check-icon">✓</span></span>{{ __('2 Days / Week') }}</li>
        </ul>
        <a href="https://wa.me/96555665161" class="plan-btn">{{ __('Choose This Package') }}</a>
      </div>

      <!-- 36 جلسة -->
      <div class="plan-card">
        <div class="plan-sessions">{{ __('36 Sessions') }}</div>
        <div class="plan-price-wrap">
          <span class="plan-kd">{{ __('KD') }}</span><span class="plan-price">900</span>
        </div>
        <div class="plan-divider"></div>
        <ul class="plan-features">
          <li class="plan-feature"><span class="plan-check"><span class="check-icon">✓</span></span>{{ __('Total Mastery & Skills') }}</li>
          <li class="plan-feature"><span class="plan-check"><span class="check-icon">✓</span></span>{{ __('3 Months Duration') }}</li>
          <li class="plan-feature"><span class="plan-check"><span class="check-icon">✓</span></span>{{ __('3 Days / Week') }}</li>
        </ul>
        <a href="https://wa.me/96555665161" class="plan-btn">{{ __('Select Package') }}</a>
      </div>


    </div>
  </div>
</section>

    {{-- ─── Deema Installment Banner ─── --}}
    <div class="s-container mt-12 sm:mt-20">
        <div class="reveal px-4 sm:px-0">
            <div class="rounded-3xl overflow-hidden ring-1 ring-white/20 shadow-xl" style="background:linear-gradient(135deg,#8b3333 0%,#b04141 50%,#7a2a2a 100%);position:relative;">

                {{-- Animated background blobs --}}
                <div style="position:absolute;top:-60px;right:-60px;width:220px;height:220px;border-radius:50%;background:radial-gradient(circle,rgba(255,220,220,0.15),transparent 70%);animation:orbFloat 6s ease-in-out infinite;pointer-events:none;"></div>
                <div style="position:absolute;bottom:-50px;left:-40px;width:180px;height:180px;border-radius:50%;background:radial-gradient(circle,rgba(255,255,255,0.08),transparent 70%);animation:orbFloat 8s ease-in-out infinite reverse;pointer-events:none;"></div>

                {{-- Subtle dot pattern --}}
                <div style="position:absolute;inset:0;pointer-events:none;opacity:0.07;background-image:radial-gradient(rgba(255,255,255,0.8) 1px,transparent 1px);background-size:20px 20px;"></div>

                <div style="position:relative;z-index:1;" class="px-8 py-12 sm:px-14 sm:py-16">

                    {{-- Header: Partnership badge + Title --}}
                    <div class="flex flex-col items-center text-center mb-10 sm:mb-12">
                        <div class="inline-flex items-center gap-3 mb-5 px-5 py-2.5 rounded-2xl" style="background:rgba(255,255,255,0.13);border:1px solid rgba(255,255,255,0.25);">
                            <img src="{{ asset('deema-logo.png') }}" alt="Deema" class="h-6 sm:h-7 w-auto object-contain" style="filter:brightness(0) invert(1);">
                            <div class="w-px h-5" style="background:rgba(255,255,255,0.3);"></div>
                            <span class="text-white/80 text-[10px] sm:text-xs font-bold uppercase tracking-widest">
                                {{ app()->getLocale() == 'ar' ? 'بالتعاون مع Deema' : 'In partnership with Deema' }}
                            </span>
                        </div>
                        <h4 class="text-3xl sm:text-4xl font-black text-white leading-snug">
                            {{ app()->getLocale() == 'ar' ? 'قسّط اشتراكك على' : 'Pay your subscription in' }}
                            <span style="color:rgba(255,210,210,0.95);">
                                {{ app()->getLocale() == 'ar' ? '4 دفعات ميسّرة' : '4 easy installments' }}
                            </span>
                        </h4>
                    </div>

                    {{-- Steps: 1 → 2 → 3 → 4 --}}
                    <div class="flex items-center justify-center mb-10 sm:mb-12">
                        @for($step = 1; $step <= 4; $step++)
                            <div class="flex flex-col items-center gap-1.5 sm:gap-2 shrink-0">
                                <div class="w-10 h-10 sm:w-16 sm:h-16 rounded-xl sm:rounded-2xl flex items-center justify-center font-black text-lg sm:text-3xl transition-all duration-300 hover:-translate-y-1 hover:scale-105 shrink-0"
                                     style="background:rgba(255,255,255,0.18);border:1.5px solid rgba(255,255,255,0.35);color:#fff;box-shadow:0 8px 24px -6px rgba(0,0,0,0.25),inset 0 1px 0 rgba(255,255,255,0.2);">
                                    {{ $step }}
                                </div>
                                <span class="text-white/65 text-[9px] sm:text-[11px] font-bold tracking-wide">
                                    {{ app()->getLocale() == 'ar' ? 'دفعة '.$step : 'Pay '.$step }}
                                </span>
                            </div>
                            @if($step < 4)
                                <div class="flex items-center gap-1 sm:gap-1.5 mb-5 mx-1 sm:mx-6">
                                    <span class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full" style="background:rgba(255,255,255,0.55);"></span>
                                    <span class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full" style="background:rgba(255,255,255,0.28);"></span>
                                    <span class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full hidden xs:block" style="background:rgba(255,255,255,0.12);"></span>
                                </div>
                            @endif
                        @endfor
                    </div>

                    {{-- Badges + CTA --}}
                    <div class="flex flex-col items-center gap-5">
                        <div class="flex flex-wrap justify-center gap-3">
                            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-[11px] font-bold"
                                  style="background:rgba(255,255,255,0.13);color:rgba(255,255,255,0.92);border:1px solid rgba(255,255,255,0.22);">
                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                {{ app()->getLocale() == 'ar' ? 'بدون رسوم إضافية' : 'Zero Extra Fees' }}
                            </span>
                            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-[11px] font-bold"
                                  style="background:rgba(255,255,255,0.13);color:rgba(255,255,255,0.92);border:1px solid rgba(255,255,255,0.22);">
                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                {{ app()->getLocale() == 'ar' ? 'موافقة فورية' : 'Instant Approval' }}
                            </span>
                            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-[11px] font-bold"
                                  style="background:rgba(255,255,255,0.13);color:rgba(255,255,255,0.92);border:1px solid rgba(255,255,255,0.22);">
                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                {{ app()->getLocale() == 'ar' ? 'آمن 100%' : '100% Secure' }}
                            </span>
                        </div>
                        <a href="https://wa.me/96555665161" target="_blank"
                           class="shimmer-btn inline-flex items-center gap-2.5 px-8 py-3.5 rounded-2xl font-bold text-sm transition-all duration-300 hover:-translate-y-1"
                           style="background:#fff;color:#8b3333;box-shadow:0 10px 30px -8px rgba(0,0,0,0.35);">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.72.937 3.658 1.43 5.623 1.43h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                            {{ app()->getLocale() == 'ar' ? 'تواصل معنا الآن' : 'Contact Us Now' }}
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>


<!-- ══════════════════════ CLUB + REINFORCE ══════════════════════ -->
<section class="s-section alt">
  <div class="s-container">
    <div class="two-col reveal">

      <!-- النادي -->
      <div class="club-card">
        <div class="club-inner">
          <div class="club-eyebrow">{{ __('The Club') }}</div>
          <h3 class="club-title">{{ __('Monthly Subscriptions') }}</h3>
          <div class="club-prices">
            <div class="club-price-row">
              <div><div class="club-price-amount">250 {{ __('KD') }}</div></div>
              <div class="club-price-label">{{ app()->getLocale() == 'ar' ? 'اشتراك يومي · مدة شهر' : 'Daily · One Month' }}</div>
            </div>
            <div class="club-price-row">
              <div><div class="club-price-amount">150 {{ __('KD') }}</div></div>
              <div class="club-price-label">{{ app()->getLocale() == 'ar' ? '٣ أيام بالأسبوع · ٤٥ دقيقة' : '3 Days/Week · 45 Min' }}</div>
            </div>
          </div>
          <div class="sibling-box">
            <div>
              <div class="sibling-label">{{ __('Sibling Discount') }}</div>
              <div class="sibling-sub">{{ app()->getLocale() == 'ar' ? 'تواصل معنا للاستفسار' : 'Contact us for details' }}</div>
            </div>
            <div class="sibling-icon">
              <svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
              </svg>
            </div>
          </div>
        </div>
      </div>

      <!-- تقوية المواد -->
      <div class="reinforce-card">
        <div class="reinforce-header">
          <div>
            <h3 class="reinforce-title">{{ __('Subject Reinforcement') }}</h3>
            <p class="reinforce-sub">{{ __('Reinforcement Subjects') }}</p>
          </div>
          <div style="text-align:left;flex-shrink:0;">
            <div class="price-big">200</div>
            <div class="price-unit">{{ __('KD') }}</div>
          </div>
        </div>
        <div style="height:1px;background:var(--s-border);margin-bottom:28px;"></div>
        <div class="reinforce-details">
          <div class="detail-item">
            <div class="detail-icon">
              <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <span class="detail-text">{{ __('1.5 Hours / Session') }}</span>
          </div>
          <div class="detail-item">
            <div class="detail-icon">
              <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <span class="detail-text">{{ __('2 Days / Week') }}</span>
          </div>
          <div class="detail-item">
            <div class="detail-icon">
              <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <span class="detail-text">{{ __('8 Total Sessions') }}</span>
          </div>
          <div class="detail-item">
            <div class="detail-icon">
              <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            </div>
            <span class="detail-text">{{ __('Comprehensive Follow-up') }}</span>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>


<!-- ══════════════════════ SPECIALIZED ══════════════════════ -->
<section class="specialized-bg">
  <div class="s-container">
    <div class="sec-header reveal" style="text-align:center;">
      <div class="sec-tag" style="justify-content:center;color:rgba(255,255,255,.45)">
        <span style="width:24px;height:2px;background:rgba(255,255,255,.3);display:inline-block;"></span>
        {{ __('Specialized Support') }}
      </div>
      <h2 class="sec-title">{{ __('Services for Autism, Down Syndrome, & Disabilities') }}</h2>
      <p class="sec-sub" style="margin-inline:auto;">{{ __('Highly specialized therapeutic programs tailored for children with neurodevelopmental and physical challenges, delivered by experts.') }}</p>
    </div>

    <div class="spec-eval-grid reveal">
      <div class="spec-eval-card">
        <div style="display:flex;align-items:center;gap:16px;">
          <div class="spec-eval-icon">
            <svg width="26" height="26" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
          </div>
          <div>
            <div class="spec-eval-name">{{ __('Opening Evaluation') }}</div>
            <div class="spec-eval-sub">{{ __('Specialized assessment protocols') }}</div>
          </div>
        </div>
        <div>
          <div class="spec-price-big">50</div>
          <div class="spec-price-unit">{{ __('KD') }}</div>
        </div>
      </div>
      <div class="spec-eval-card">
        <div style="display:flex;align-items:center;gap:16px;">
          <div class="spec-eval-icon">
            <svg width="26" height="26" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11 4a2 2 0 114 0v1a2 2 0 012 2v3a2 2 0 01-2 2H9a2 2 0 01-2-2V7a2 2 0 012-2V4m2 10v2m0 4h.01M6 20h12a2 2 0 002-2v-1a2 2 0 00-2-2H6a2 2 0 00-2 2v1a2 2 0 002 2z"/></svg>
          </div>
          <div>
            <div class="spec-eval-name">{{ __('Disability Diagnosis') }}</div>
            <div class="spec-eval-sub">{{ __('Global standardized intelligence tests') }}</div>
          </div>
        </div>
        <div>
          <div class="spec-price-big">120</div>
          <div class="spec-price-unit">{{ __('KD') }}</div>
        </div>
      </div>
    </div>

    <div class="spec-pkgs reveal">
      <div class="spec-pkg">
        <div class="sp-label">{{ __('Intensive Month') }} · {{ __('12 Sessions') }}</div>
        <div class="sp-price">360</div>
        <div style="font-size:.75rem;color:rgba(255,255,255,.3);margin-bottom:20px;">{{ __('KD') }}</div>
        <div class="sp-sched">{{ __('3 Days Per Week') }}</div>
        <a href="https://wa.me/96555665161" class="sp-btn">{{ __('Book Now') }}</a>
      </div>
      <div class="spec-pkg sp-feat">
        <div class="sp-badge">✦ {{ __('Best Value') }} ✦</div>
        <div class="sp-label">{{ __('Therapeutic Track') }} · {{ __('24 Sessions') }}</div>
        <div class="sp-price">750</div>
        <div style="font-size:.85rem;color:rgba(255,255,255,.55);margin-bottom:20px;">{{ __('KD') }}</div>
        <div class="sp-sched">{{ __('2 Days Per Week / 3 Months') }}</div>
        <a href="https://wa.me/96555665161" class="sp-btn">{{ __('Choose Track') }}</a>
      </div>
      <div class="spec-pkg">
        <div class="sp-label">{{ __('Advanced Track') }} · {{ __('36 Sessions') }}</div>
        <div class="sp-price">900</div>
        <div style="font-size:.75rem;color:rgba(255,255,255,.3);margin-bottom:20px;">{{ __('KD') }}</div>
        <div class="sp-sched">{{ __('3 Days Per Week / 3 Months') }}</div>
        <a href="https://wa.me/96555665161" class="sp-btn">{{ __('Get Started') }}</a>
      </div>
    </div>

    <div class="spec-bottom reveal">
      <div class="spec-club">
        <div class="spec-club-icon">
          <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
          </svg>
        </div>
        <h3 class="spec-club-title">{{ __('Specialized Reception Club') }}</h3>
        <p class="spec-club-sub">{{ __('Morning support program focused on social integration and basic skills development for children with disabilities.') }}</p>
        <div class="spec-club-meta">
          <div class="meta-item">
            <div class="meta-label">{{ __('Schedule') }}</div>
            <div class="meta-value">{{ __('One Month Duration') }}</div>
          </div>
          <div class="meta-item">
            <div class="meta-label">{{ __('Available') }}</div>
            <div class="meta-value">{{ __('Sun - Thu') }}</div>
          </div>
        </div>
        <div class="spec-club-footer">
          <div>
            <div class="spec-club-price">200</div>
            <div style="font-size:.75rem;color:rgba(255,255,255,.3);text-transform:uppercase;letter-spacing:.1em;">{{ __('KD') }}</div>
          </div>
          <a href="https://wa.me/96555665161" class="spec-club-btn">{{ __('Inquire') }}</a>
        </div>
      </div>
    </div>

  </div>
</section>


<!-- ══════════════════════ CTA ══════════════════════ -->
<section class="cta-section">
  <div class="cta-inner reveal">
    <div class="cta-badge">
      <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
      {{ __('Opening Evaluation Fee') }}
    </div>
    <h2 class="cta-title">
      {!! __('Ready to Start Your Child\'s Journey?') !!}
    </h2>
    <p class="cta-sub">
      {{ __('Our specialized consultants are ready to assist you in choosing the most appropriate path for your child\'s unique needs.') }}
    </p>
    <div class="cta-btns">
      <a href="https://wa.me/96555665161" class="cta-primary">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="#25D366">
          <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.72.937 3.658 1.43 5.623 1.43h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
        </svg>
        {{ __('Talk to a Specialist') }}
      </a>
      <a href="tel:+96555665161" class="cta-secondary">
        <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
        </svg>
        {{ __('Call Us Directly') }}
      </a>
    </div>
  </div>
</section>


</div>{{-- .sessions-page --}}

<script>
// Counter animation for sessions page (uses data-target + data-suffix)
(function() {
  // Reveal observer
  const revealIO = new IntersectionObserver((entries) => {
    entries.forEach(e => {
      if (e.isIntersecting) {
        e.target.classList.add('active');
      }
    });
  }, { threshold: 0.15 });

  document.querySelectorAll('.reveal').forEach(el => {
    revealIO.observe(el);
  });

  // Counter animation
  const counterIO = new IntersectionObserver((entries) => {
    entries.forEach((e) => {
      if (!e.isIntersecting) return;
      var el = e.target;
      var target = +el.dataset.target;
      var suffix = el.dataset.suffix || '+';
      var n = 0, step = Math.ceil(target / 60);
      var t = setInterval(() => {
        n = Math.min(n + step, target);
        el.textContent = n + suffix;
        if (n >= target) clearInterval(t);
      }, 25);
      counterIO.unobserve(el);
    });
  }, { threshold: 0.5 });

  document.querySelectorAll('[data-target]').forEach((el) => {
    counterIO.observe(el);
  });
})();
</script>

@endsection
