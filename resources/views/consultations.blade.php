@extends('layouts.app')

@section('title', __('Consultations') . ' — ' . __('Motmaena Center'))

@section('content')

<style>
/* ── Hide global layout WA button on this page (has its own) ── */
#global-float-wa { display: none !important; }

/* ── Directional reveal variants ── */
.reveal-left  { opacity: 0; transform: translateX({{ app()->getLocale() === 'ar' ? '40px' : '-40px' }}); transition: opacity 0.65s cubic-bezier(.22,1,.36,1), transform 0.65s cubic-bezier(.22,1,.36,1); }
.reveal-right { opacity: 0; transform: translateX({{ app()->getLocale() === 'ar' ? '-40px' : '40px' }}); transition: opacity 0.65s cubic-bezier(.22,1,.36,1), transform 0.65s cubic-bezier(.22,1,.36,1); }
.reveal-left.active, .reveal-right.active { opacity: 1; transform: none; }

/* ── Variables ── */
.consult-page {
  --red:    #b04141;
  --red-d:  #8a3232;
  --red-lt: #fdf2f2;
  --gold:   #c8922a;
  --gold-lt:#fdf6e3;
  --cream:  #fdf8f3;
  --warm:   #f5ede0;
  --surface:#ffffff;
  --text:   #1a1a1a;
  --muted:  #6b7280;
  --border: #e8ddd5;
  --radius: 16px;
  font-family: 'Tajawal', 'Inter', sans-serif;
  background: var(--cream);
  color: var(--text);
}
.dark .consult-page {
  --cream:  #0f0c0a;
  --warm:   #1a1410;
  --surface:#1e1a16;
  --text:   #f0ebe4;
  --muted:  #9ca3af;
  --border: #2e2820;
  --red-lt: #2a1515;
  --gold-lt:#2a2010;
}

/* ── Urgency Strip ── */
.urgency-strip {
  background: linear-gradient(90deg, #7c2d12, var(--red), #7c2d12);
  color: #fff;
  text-align: center;
  padding: 11px 16px;
  font-size: 14px;
  font-weight: 700;
  letter-spacing: .3px;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  position: relative;
  z-index: 10;
}
.urgency-strip .pulse-dot {
  width: 9px; height: 9px;
  background: #fbbf24;
  border-radius: 50%;
  display: inline-block;
  animation: pulseDot 1.4s ease-in-out infinite;
}
@keyframes pulseDot { 0%,100%{transform:scale(1);opacity:1} 50%{transform:scale(1.6);opacity:.6} }

/* ── Hero ── */
.hero-consult {
  background: linear-gradient(145deg, #1a0a0a 0%, #2d1212 40%, #3d1a1a 70%, #1a0a0a 100%);
  color: #fff;
  padding: 80px 24px 60px;
  text-align: center;
  position: relative;
  overflow: hidden;
}
.hero-consult::before {
  content:'';
  position:absolute; inset:0;
  background: radial-gradient(ellipse 70% 50% at 50% 30%, rgba(176,65,65,.35), transparent);
  pointer-events:none;
}
.hero-consult .badge-urgent {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  background: rgba(251,191,36,.15);
  border: 1px solid rgba(251,191,36,.4);
  color: #fbbf24;
  border-radius: 999px;
  padding: 5px 16px;
  font-size: 13px;
  font-weight: 700;
  margin-bottom: 20px;
  animation: fadeSlideDown .7s ease both;
}
.hero-consult h1 {
  font-size: clamp(26px,5vw,46px);
  font-weight: 900;
  line-height: 1.25;
  margin-bottom: 14px;
  animation: fadeSlideDown .8s .1s ease both;
}
.hero-consult h1 .accent { color: #f87171; }
.hero-consult p.sub {
  font-size: 17px;
  color: rgba(255,255,255,.75);
  max-width: 540px;
  margin: 0 auto 32px;
  animation: fadeSlideDown .8s .2s ease both;
}
.hero-cta-group {
  display: flex;
  gap: 14px;
  justify-content: center;
  flex-wrap: wrap;
  animation: fadeSlideDown .8s .3s ease both;
}
.btn-hero-primary {
  background: var(--red);
  color: #fff;
  border: none;
  border-radius: 999px;
  padding: 15px 36px;
  font-size: 17px;
  font-weight: 800;
  cursor: pointer;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 8px;
  transition: background .2s, transform .15s, box-shadow .2s;
  box-shadow: 0 4px 20px rgba(176,65,65,.5);
}
.btn-hero-primary:hover { background: var(--red-d); transform: translateY(-2px); box-shadow: 0 8px 30px rgba(176,65,65,.6); }
.btn-hero-secondary {
  background: rgba(255,255,255,.1);
  color: #fff;
  border: 1.5px solid rgba(255,255,255,.3);
  border-radius: 999px;
  padding: 14px 28px;
  font-size: 15px;
  font-weight: 600;
  cursor: pointer;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 8px;
  transition: background .2s;
  backdrop-filter: blur(8px);
}
.btn-hero-secondary:hover { background: rgba(255,255,255,.18); }
.spots-counter {
  margin-top: 28px;
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: rgba(255,255,255,.07);
  border: 1px solid rgba(255,255,255,.15);
  border-radius: 12px;
  padding: 10px 20px;
  font-size: 14px;
  color: rgba(255,255,255,.85);
  animation: fadeSlideDown .8s .4s ease both;
}
.spots-counter .spots-num {
  font-size: 22px;
  font-weight: 900;
  color: #fbbf24;
}

/* ── Pain Points ── */
.pain-section {
  padding: 70px 24px;
  background: var(--warm);
  text-align: center;
}
.pain-section h2 { font-size: clamp(22px,3.5vw,34px); font-weight: 900; margin-bottom: 8px; }
.pain-section .sub { color: var(--muted); font-size: 15px; margin-bottom: 40px; }
.pain-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 18px;
  max-width: 900px;
  margin: 0 auto 36px;
}
.pain-card {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: var(--radius);
  padding: 24px 20px;
  text-align: center;
  transition: transform .2s, box-shadow .2s;
  cursor: default;
}
.pain-card:hover { transform: translateY(-4px); box-shadow: 0 10px 30px rgba(0,0,0,.08); }
.pain-card .emoji { font-size: 32px; margin-bottom: 10px; }
.pain-card p { font-size: 14.5px; color: var(--muted); line-height: 1.65; }
.pain-card p strong { color: var(--text); display: block; margin-bottom: 4px; font-size: 15px; }
.pain-answer {
  background: linear-gradient(135deg, var(--red), var(--red-d));
  color: #fff;
  border-radius: var(--radius);
  padding: 22px 28px;
  max-width: 640px;
  margin: 0 auto;
  font-size: 16px;
  font-weight: 700;
  line-height: 1.6;
}

/* ── Dr. Tariq Featured ── */
.dr-section {
  padding: 80px 24px;
  background: linear-gradient(135deg, #1a0a0a 0%, #2d1515 50%, #1a0808 100%);
  color: #fff;
  position: relative;
  overflow: hidden;
}
.dr-section::before {
  content:'';
  position:absolute; inset:0;
  background: radial-gradient(ellipse 60% 60% at 80% 50%, rgba(176,65,65,.25), transparent);
  pointer-events:none;
}
.dr-inner {
  max-width: 1000px;
  margin: 0 auto;
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 60px;
  align-items: center;
}
.dr-badge {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  background: rgba(176,65,65,.25);
  border: 1px solid rgba(176,65,65,.5);
  color: #f87171;
  border-radius: 999px;
  padding: 5px 14px;
  font-size: 12px;
  font-weight: 700;
  margin-bottom: 16px;
}
.dr-section h2 { font-size: clamp(22px,3vw,34px); font-weight: 900; margin-bottom: 12px; line-height: 1.3; }
.dr-section h2 .gold { color: #fbbf24; }
.dr-section p.bio { font-size: 15px; color: rgba(255,255,255,.75); line-height: 1.8; margin-bottom: 24px; }
.dr-stats {
  display: flex;
  gap: 24px;
  flex-wrap: wrap;
}
.dr-stat { text-align: center; }
.dr-stat .num { font-size: 28px; font-weight: 900; color: #fbbf24; display: block; }
.dr-stat .lbl { font-size: 12px; color: rgba(255,255,255,.6); }
.dr-img-wrap {
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
}
.dr-img-wrap .ring {
  width: 260px; height: 260px;
  border-radius: 50%;
  border: 3px solid rgba(176,65,65,.4);
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
}
.dr-img-wrap .ring::before {
  content:'';
  position:absolute;
  inset: -10px;
  border-radius: 50%;
  border: 2px dashed rgba(176,65,65,.2);
  animation: spinSlow 20s linear infinite;
}
@keyframes spinSlow { to { transform: rotate(360deg); } }
.dr-img-wrap img {
  width: 230px; height: 230px;
  border-radius: 50%;
  object-fit: cover;
  object-position: top;
}
.dr-img-placeholder {
  width: 230px; height: 230px;
  border-radius: 50%;
  background: linear-gradient(135deg, var(--red), var(--red-d));
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 72px;
  font-weight: 900;
  color: rgba(255,255,255,.3);
}

/* ── Stats Bar ── */
.stats-bar {
  background: var(--red);
  padding: 40px 24px;
  color: #fff;
}
.stats-inner {
  max-width: 900px;
  margin: 0 auto;
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 24px;
  text-align: center;
}
.stat-item .num { font-size: 36px; font-weight: 900; display: block; }
.stat-item .lbl { font-size: 13px; opacity: .85; margin-top: 4px; }

/* ── Testimonials ── */
.testimonials-section {
  padding: 80px 24px;
  background: var(--surface);
}
.testimonials-section h2 { font-size: clamp(20px,3vw,30px); font-weight: 900; text-align: center; margin-bottom: 8px; }
.testimonials-section .sub { color: var(--muted); text-align: center; font-size: 14.5px; margin-bottom: 40px; }
.testimonials-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 22px;
  max-width: 1000px;
  margin: 0 auto;
}
.testimonial-card {
  background: var(--cream);
  border: 1px solid var(--border);
  border-radius: var(--radius);
  padding: 28px 24px;
  position: relative;
}
.testimonial-card .stars { color: #fbbf24; font-size: 16px; margin-bottom: 12px; letter-spacing: 2px; }
.testimonial-card .quote-text { font-size: 14.5px; color: var(--muted); line-height: 1.75; margin-bottom: 18px; font-style: italic; }
.testimonial-card .quote-mark {
  position: absolute;
  top: 14px;
  {{ app()->getLocale() === 'ar' ? 'left' : 'right' }}: 18px;
  font-size: 48px;
  color: var(--red);
  opacity: .12;
  font-family: Georgia, serif;
  line-height: 1;
}
.testimonial-author {
  display: flex;
  align-items: center;
  gap: 10px;
}
.testimonial-author .avatar {
  width: 38px; height: 38px;
  border-radius: 50%;
  background: linear-gradient(135deg, var(--red), var(--red-d));
  color: #fff;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 15px;
  font-weight: 800;
  flex-shrink: 0;
}
.testimonial-author .info .name { font-size: 14px; font-weight: 700; color: var(--text); }
.testimonial-author .info .role { font-size: 12px; color: var(--muted); }

/* ── Outcomes ── */
.outcomes-section {
  padding: 80px 24px;
  background: var(--warm);
}
.section-header { text-align: center; margin-bottom: 48px; }
.section-header h2 { font-size: clamp(20px,3vw,32px); font-weight: 900; margin-bottom: 8px; }
.section-header p { color: var(--muted); font-size: 15px; max-width: 500px; margin: 0 auto; }
.outcomes-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 18px;
  max-width: 800px;
  margin: 0 auto;
}
.outcome-item {
  display: flex;
  align-items: flex-start;
  gap: 14px;
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: 14px;
  padding: 22px 20px;
  transition: box-shadow .2s;
}
.outcome-item:hover { box-shadow: 0 6px 20px rgba(0,0,0,.07); }
.outcome-item .icon {
  width: 44px; height: 44px;
  border-radius: 12px;
  background: var(--red-lt);
  color: var(--red);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 20px;
  flex-shrink: 0;
}
.outcome-item .txt strong { font-size: 15px; color: var(--text); display: block; margin-bottom: 4px; }
.outcome-item .txt span { font-size: 13.5px; color: var(--muted); line-height: 1.55; }

/* ── Advisors ── */
.advisors-section {
  padding: 80px 24px;
  background: var(--surface);
}
.advisors-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 20px;
  max-width: 1000px;
  margin: 0 auto;
}
.advisor-card {
  background: var(--cream);
  border: 1px solid var(--border);
  border-radius: var(--radius);
  padding: 28px 20px;
  text-align: center;
  transition: transform .2s, box-shadow .2s;
}
.advisor-card:hover { transform: translateY(-4px); box-shadow: 0 10px 28px rgba(0,0,0,.09); }
.advisor-card .avatar {
  width: 72px; height: 72px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 16px;
  position: relative;
}
.advisor-card .avatar svg { width: 32px; height: 32px; }
.advisor-card .online-dot {
  position: absolute;
  bottom: 3px;
  left: 3px;
  width: 14px; height: 14px;
  background: #22c55e;
  border-radius: 50%;
  border: 2px solid var(--surface);
  animation: pulseDot 2s ease-in-out infinite;
}
.advisor-card h4 { font-size: 15px; font-weight: 800; margin-bottom: 4px; color: var(--text); }
.advisor-card .spec { font-size: 13px; color: var(--red); font-weight: 600; margin-bottom: 8px; }
.advisor-card p { font-size: 12.5px; color: var(--muted); line-height: 1.55; }

/* ── Steps ── */
.steps-section {
  padding: 80px 24px;
  background: var(--warm);
}
.steps-list {
  max-width: 700px;
  margin: 0 auto;
  display: flex;
  flex-direction: column;
  gap: 0;
}
.step-item {
  display: flex;
  gap: 20px;
  position: relative;
  padding-bottom: 36px;
}
.step-item:last-child { padding-bottom: 0; }
.step-item:not(:last-child)::after {
  content:'';
  position:absolute;
  {{ app()->getLocale() === 'ar' ? 'right' : 'left' }}: 19px;
  top: 46px;
  bottom: 0;
  width: 2px;
  background: linear-gradient(to bottom, var(--red), transparent);
}
.step-num {
  width: 40px; height: 40px;
  border-radius: 50%;
  background: var(--red);
  color: #fff;
  font-size: 16px;
  font-weight: 900;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
  box-shadow: 0 4px 12px rgba(176,65,65,.4);
}
.step-content h4 { font-size: 16px; font-weight: 800; margin-bottom: 6px; color: var(--text); }
.step-content p { font-size: 14px; color: var(--muted); line-height: 1.65; }

/* ── FAQ ── */
.faq-section {
  padding: 80px 24px;
  background: var(--surface);
}
.faq-list {
  max-width: 720px;
  margin: 0 auto;
  display: flex;
  flex-direction: column;
  gap: 12px;
}
.faq-item {
  background: var(--cream);
  border: 1px solid var(--border);
  border-radius: 14px;
  overflow: hidden;
  transition: box-shadow .2s;
}
.faq-item.open { box-shadow: 0 4px 18px rgba(0,0,0,.08); }
.faq-q {
  width: 100%;
  background: none;
  border: none;
  padding: 18px 22px;
  font-family: inherit;
  font-size: 15px;
  font-weight: 700;
  color: var(--text);
  text-align: {{ app()->getLocale() === 'ar' ? 'right' : 'left' }};
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 12px;
}
.faq-q .arrow {
  width: 22px; height: 22px;
  background: var(--red-lt);
  border-radius: 50%;
  color: var(--red);
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
  font-size: 14px;
  transition: transform .25s;
}
.faq-item.open .faq-q .arrow { transform: rotate(180deg); }
.faq-a {
  max-height: 0;
  overflow: hidden;
  transition: max-height .35s ease, padding .25s;
  padding: 0 22px;
  font-size: 14px;
  color: var(--muted);
  line-height: 1.75;
}
.faq-item.open .faq-a { max-height: 300px; padding: 0 22px 18px; }

/* ── Terms ── */
.terms-section {
  padding: 60px 24px;
  background: var(--warm);
}
.terms-box {
  max-width: 760px;
  margin: 0 auto;
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: 20px;
  overflow: hidden;
}
.terms-disclaimer {
  background: linear-gradient(90deg, var(--gold-lt), #fffdf5);
  border-bottom: 1px solid rgba(200,146,42,.25);
  padding: 18px 24px;
  display: flex;
  gap: 12px;
  align-items: flex-start;
}
.terms-disclaimer .icon { font-size: 22px; flex-shrink: 0; margin-top: 2px; }
.terms-disclaimer p { font-size: 13.5px; color: #7c5a10; line-height: 1.65; }
.terms-body { padding: 24px; }
.terms-body h3 { font-size: 16px; font-weight: 800; margin-bottom: 16px; color: var(--text); }
.terms-items { display: flex; flex-direction: column; gap: 12px; margin-bottom: 20px; }
.term-row {
  display: flex;
  gap: 12px;
  align-items: flex-start;
  padding: 14px;
  background: var(--cream);
  border-radius: 12px;
  border: 1px solid var(--border);
}
.term-row .t-icon { font-size: 18px; flex-shrink: 0; margin-top: 2px; }
.term-row p { font-size: 13.5px; color: var(--muted); line-height: 1.65; }
.term-row p strong { color: var(--text); display: block; margin-bottom: 3px; font-size: 13.5px; }
.consent-row {
  display: flex;
  gap: 12px;
  align-items: flex-start;
  padding: 16px;
  background: var(--red-lt);
  border: 1.5px solid rgba(176,65,65,.2);
  border-radius: 12px;
}
.consent-row input[type=checkbox] {
  width: 18px; height: 18px;
  flex-shrink: 0;
  margin-top: 3px;
  accent-color: var(--red);
}
.consent-row label { font-size: 13.5px; color: var(--text); line-height: 1.65; cursor: pointer; }
.consent-row label strong { color: var(--red); }

/* ── Booking Form ── */
.booking-form-wrap {
  max-height: 0;
  overflow: hidden;
  transition: max-height .5s cubic-bezier(.16,1,.3,1), opacity .4s ease;
  opacity: 0;
}
.booking-form-wrap.open {
  max-height: 600px;
  opacity: 1;
}
.booking-form {
  margin-top: 20px;
  background: var(--cream);
  border: 2px solid rgba(176,65,65,.25);
  border-radius: 16px;
  padding: 24px;
  display: flex;
  flex-direction: column;
  gap: 14px;
}
.booking-form h4 {
  font-size: 16px;
  font-weight: 800;
  color: var(--text);
  display: flex;
  align-items: center;
  gap: 8px;
}
.form-row { display: flex; flex-direction: column; gap: 6px; }
.form-row label { font-size: 13px; font-weight: 700; color: var(--muted); }
.form-row input,
.form-row select,
.form-row textarea {
  width: 100%;
  background: var(--surface);
  border: 1.5px solid var(--border);
  border-radius: 12px;
  padding: 12px 16px;
  font-size: 15px;
  font-family: inherit;
  color: var(--text);
  outline: none;
  transition: border-color .2s;
  direction: rtl;
}
.form-row input:focus,
.form-row select:focus,
.form-row textarea:focus { border-color: var(--red); }
.form-row textarea { resize: none; height: 80px; }
.phone-row { display: flex; gap: 8px; }
.phone-row select { width: 150px; flex-shrink: 0; }
.phone-row input  { flex: 1; }
.optional-tag {
  display: inline-block;
  background: #f3f4f6;
  color: #9ca3af;
  border-radius: 999px;
  padding: 1px 10px;
  font-size: 11px;
  font-weight: 600;
  margin-right: 6px;
}
.dark .optional-tag { background: #2a2420; color: #6b7280; }
.consent-required-note {
  display: none;
  color: var(--red);
  font-size: 13px;
  font-weight: 700;
  margin-top: 10px;
  padding: 10px 14px;
  background: var(--red-lt);
  border-radius: 10px;
  border: 1px solid rgba(176,65,65,.2);
}
.form-submit-btn {
  background: #25d366;
  color: #fff;
  border: none;
  border-radius: 999px;
  padding: 15px 28px;
  font-size: 16px;
  font-weight: 800;
  font-family: inherit;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  transition: background .2s, transform .15s;
  box-shadow: 0 4px 18px rgba(37,211,102,.35);
  margin-top: 4px;
}
.form-submit-btn:hover { background: #1da851; transform: translateY(-2px); }

/* ── Final CTA ── */
.final-cta {
  padding: 80px 24px;
  background: linear-gradient(135deg, #1a0a0a, #2d1515);
  color: #fff;
  text-align: center;
}
.final-cta h2 { font-size: clamp(22px,4vw,38px); font-weight: 900; margin-bottom: 12px; }
.final-cta h2 .accent { color: #f87171; }
.final-cta p { font-size: 16px; color: rgba(255,255,255,.7); max-width: 520px; margin: 0 auto 32px; }
.final-cta .countdown {
  display: inline-flex;
  align-items: center;
  gap: 10px;
  background: rgba(251,191,36,.1);
  border: 1px solid rgba(251,191,36,.3);
  color: #fbbf24;
  border-radius: 12px;
  padding: 10px 20px;
  font-size: 14px;
  font-weight: 700;
  margin-bottom: 28px;
}
.final-cta-btns { display: flex; gap: 16px; justify-content: center; flex-wrap: wrap; }
.btn-final {
  background: #25d366;
  color: #fff;
  border: none;
  border-radius: 999px;
  padding: 16px 40px;
  font-size: 17px;
  font-weight: 800;
  cursor: pointer;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 9px;
  transition: background .2s, transform .15s, box-shadow .2s;
  box-shadow: 0 4px 22px rgba(37,211,102,.4);
}
.btn-final:hover { background: #1da851; transform: translateY(-2px); box-shadow: 0 8px 32px rgba(37,211,102,.55); }
.btn-final-red {
  background: var(--red);
  box-shadow: 0 4px 22px rgba(176,65,65,.45);
}
.btn-final-red:hover { background: var(--red-d); box-shadow: 0 8px 32px rgba(176,65,65,.6); }

/* ── Sticky Bar ── */
.sticky-bar {
  position: fixed;
  bottom: -80px;
  left: 0; right: 0;
  background: var(--surface);
  border-top: 2px solid var(--border);
  padding: 14px 20px;
  z-index: 1000;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 14px;
  box-shadow: 0 -4px 24px rgba(0,0,0,.12);
  transition: bottom .4s cubic-bezier(.16,1,.3,1);
}
.sticky-bar.visible { bottom: 0; }
.sticky-bar .sticky-text { font-size: 14px; font-weight: 700; color: var(--text); }
.sticky-bar .sticky-text span { display: block; font-size: 12px; color: var(--muted); font-weight: 400; }
.sticky-bar .sticky-btn {
  background: #25d366;
  color: #fff;
  border: none;
  border-radius: 999px;
  padding: 11px 24px;
  font-size: 14px;
  font-weight: 800;
  cursor: pointer;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 7px;
  white-space: nowrap;
  transition: background .2s;
}
.sticky-bar .sticky-btn:hover { background: #1da851; }

/* ── Reveal Animation ── */
.reveal { opacity: 0; transform: translateY(28px); transition: opacity .65s ease, transform .65s ease; }
.reveal.active { opacity: 1; transform: none; }
.reveal-delay-1 { transition-delay: .1s; }
.reveal-delay-2 { transition-delay: .2s; }
.reveal-delay-3 { transition-delay: .3s; }
.reveal-delay-4 { transition-delay: .4s; }

/* ── Live Presence Bar ── */
.live-bar {
  background: #f0fdf4;
  border-bottom: 1px solid #bbf7d0;
  padding: 9px 20px;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 20px;
  flex-wrap: wrap;
  font-size: 13px;
  font-weight: 600;
  color: #166534;
}
.dark .live-bar { background: #052e16; border-color: #14532d; color: #86efac; }
.live-bar .live-item { display: flex; align-items: center; gap: 6px; }
.live-bar .green-dot {
  width: 8px; height: 8px;
  background: #22c55e;
  border-radius: 50%;
  animation: pulseDot 1.8s ease-in-out infinite;
  flex-shrink: 0;
}
.live-bar .sep { color: #86efac; }

/* ── Last Booking Toast ── */
.last-booking-toast {
  position: fixed;
  bottom: 90px;
  {{ app()->getLocale() === 'ar' ? 'right' : 'left' }}: 20px;
  background: var(--surface);
  border: 1px solid var(--border);
  border-right: 3px solid #22c55e;
  border-radius: 14px;
  padding: 12px 16px;
  font-size: 13px;
  color: var(--text);
  box-shadow: 0 8px 28px rgba(0,0,0,.12);
  z-index: 999;
  max-width: 240px;
  display: flex;
  align-items: center;
  gap: 10px;
  animation: toastIn .5s ease;
  cursor: pointer;
}
.last-booking-toast .t-icon { font-size: 22px; flex-shrink: 0; }
.last-booking-toast .t-txt strong { display: block; font-size: 13px; color: var(--text); }
.last-booking-toast .t-txt span { font-size: 12px; color: var(--muted); }
@keyframes toastIn { from { opacity:0; transform: translateX({{ app()->getLocale() === 'ar' ? '20px' : '-20px' }}); } to { opacity:1; transform:none; } }

/* ── Floating WhatsApp ── */
.float-wa {
  position: fixed;
  bottom: 90px;
  {{ app()->getLocale() === 'ar' ? 'left' : 'right' }}: 20px;
  width: 56px; height: 56px;
  background: #25d366;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 4px 20px rgba(37,211,102,.5);
  z-index: 998;
  text-decoration: none;
  transition: transform .2s, box-shadow .2s;
  animation: waPulse 3s ease-in-out infinite;
}
.float-wa:hover { transform: scale(1.1); box-shadow: 0 8px 30px rgba(37,211,102,.65); animation: none; }
.float-wa svg { width: 28px; height: 28px; }
@keyframes waPulse {
  0%,100% { box-shadow: 0 4px 20px rgba(37,211,102,.5); }
  50% { box-shadow: 0 4px 32px rgba(37,211,102,.8), 0 0 0 8px rgba(37,211,102,.15); }
}
.float-wa .wa-label {
  position: absolute;
  top: -36px;
  background: #1a1a1a;
  color: #fff;
  font-size: 12px;
  font-weight: 700;
  border-radius: 8px;
  padding: 5px 10px;
  white-space: nowrap;
  opacity: 0;
  transition: opacity .2s;
  pointer-events: none;
}
.float-wa:hover .wa-label { opacity: 1; }

/* ── Animations ── */
@keyframes fadeSlideDown { from { opacity:0; transform:translateY(-18px); } to { opacity:1; transform:none; } }

/* ── Responsive ── */
@media (max-width: 1024px) {
  .pain-grid { grid-template-columns: repeat(2, 1fr); }
  .testimonials-grid { grid-template-columns: repeat(2, 1fr); }
  .advisors-grid { grid-template-columns: repeat(2, 1fr); }
  .stats-inner { grid-template-columns: repeat(2, 1fr); }
  .dr-inner { grid-template-columns: 1fr; gap: 40px; text-align: center; }
  .dr-stats { justify-content: center; }
  .dr-img-wrap { order: -1; }
}
@media (max-width: 768px) {
  .pain-grid { grid-template-columns: 1fr; }
  .testimonials-grid { grid-template-columns: 1fr; }
  .advisors-grid { grid-template-columns: repeat(2, 1fr); }
  .outcomes-grid { grid-template-columns: 1fr; }
  .sticky-bar { flex-direction: column; gap: 10px; padding: 12px 16px; }
  .sticky-bar .sticky-btn { width: 100%; justify-content: center; }
}
@media (max-width: 480px) {
  .advisors-grid { grid-template-columns: 1fr; }
  .stats-inner { grid-template-columns: 1fr 1fr; }
  .dr-img-wrap .ring { width: 200px; height: 200px; }
  .dr-img-wrap img, .dr-img-placeholder { width: 176px; height: 176px; }
  /* hero mobile */
  .hero-consult h1 { font-size: clamp(1.7rem, 7vw, 2.4rem); }
  .hero-consult .sub { font-size: 14px; }
  .hero-cta-group { flex-direction: column; gap: 12px; }
  .btn-hero-primary, .btn-hero-secondary { width: 100%; justify-content: center; }
  /* pain cards compact on small phones */
  .pain-card { padding: 16px 14px; }
  .pain-card .emoji { font-size: 28px; }
  /* steps */
  .step-num { width: 40px; height: 40px; font-size: 18px; }
  /* testimonials */
  .testimonial-card { padding: 20px 16px; }
  /* advisors */
  .advisor-card { padding: 20px 16px; }
  /* outcomes */
  .outcome-item { padding: 14px 16px; }
  /* dr section */
  .dr-inner { gap: 24px; }
  /* live bar scroll on mobile */
  .live-bar { overflow-x: auto; white-space: nowrap; flex-wrap: nowrap; gap: 12px; padding: 10px 16px; }
  .live-bar .sep { display: none; }
}
/* Stagger reveal for grid children on mobile */
@media (max-width: 768px) {
  .pain-grid .pain-card:nth-child(1) { transition-delay: 0s; }
  .pain-grid .pain-card:nth-child(2) { transition-delay: .12s; }
  .pain-grid .pain-card:nth-child(3) { transition-delay: .24s; }
  .pain-grid .pain-card:nth-child(4) { transition-delay: .36s; }
  .testimonials-grid .testimonial-card:nth-child(1) { transition-delay: 0s; }
  .testimonials-grid .testimonial-card:nth-child(2) { transition-delay: .15s; }
  .testimonials-grid .testimonial-card:nth-child(3) { transition-delay: .30s; }
  .advisors-grid .advisor-card:nth-child(1) { transition-delay: 0s; }
  .advisors-grid .advisor-card:nth-child(2) { transition-delay: .12s; }
  .advisors-grid .advisor-card:nth-child(3) { transition-delay: .24s; }
  .advisors-grid .advisor-card:nth-child(4) { transition-delay: .36s; }
}
</style>

<div class="consult-page">

  {{-- ── Live Presence Bar ── --}}
  <div class="live-bar">
    <div class="live-item">
      <span class="green-dot"></span>
      @if(app()->getLocale() === 'ar')
        <span>متواجدون الآن ونرد خلال دقائق</span>
      @else
        <span>Online now — we reply within minutes</span>
      @endif
    </div>
    <span class="sep">|</span>
    <div class="live-item">
      <span>👁</span>
      <span id="live-viewers">{{ rand(8,22) }}</span>
      {{ app()->getLocale() === 'ar' ? 'شخص يشاهد الصفحة الآن' : 'people viewing now' }}
    </div>
    <span class="sep">|</span>
    <div class="live-item">
      <span>✅</span>
      {{ app()->getLocale() === 'ar' ? 'آخر حجز منذ' : 'Last booking' }}
      <span id="last-book-time">{{ rand(4,18) }}</span>
      {{ app()->getLocale() === 'ar' ? 'دقيقة' : 'min ago' }}
    </div>
  </div>

  {{-- ── Urgency Strip ── --}}
  <div class="urgency-strip">
    <span class="pulse-dot"></span>
    @if(app()->getLocale() === 'ar')
      <span>🔴 تبقّى <span id="spots-strip" style="font-size:18px;color:#fbbf24;">٣</span> أماكن فقط هذا الأسبوع — الحجز الآن قبل امتلاء المواعيد</span>
    @else
      <span>🔴 Only <span id="spots-strip-en" style="font-size:18px;color:#fbbf24;">3</span> spots left this week — Book now before they fill up</span>
    @endif
  </div>

  {{-- ── Hero ── --}}
  <section class="hero-consult">
    <div style="max-width:700px;margin:0 auto;position:relative;z-index:1;">
      <div class="badge-urgent">
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 2l2.4 7.4H22l-6.2 4.5 2.4 7.4L12 17l-6.2 4.3 2.4-7.4L2 9.4h7.6z"/></svg>
        @if(app()->getLocale() === 'ar') استشارات اجتماعية وتربوية متخصصة @else Specialized Social & Educational Consultations @endif
      </div>

      <h1>
        @if(app()->getLocale() === 'ar')
          هل تبحث عن <span class="accent">إجابات حقيقية</span><br>لمشكلة تؤرقك؟
        @else
          Looking for <span class="accent">real answers</span><br>to what's troubling you?
        @endif
      </h1>

      <p class="sub">
        @if(app()->getLocale() === 'ar')
          جلسة واحدة مع متخصص معتمد قد تغيّر منظورك كليًا — احجز موعدك اليوم
        @else
          One session with a certified advisor can completely change your perspective — book today
        @endif
      </p>

      <div class="hero-cta-group">
        <a href="https://wa.me/96555665161?text={{ urlencode(app()->getLocale() === 'ar' ? 'مرحباً، أود حجز استشارة' : 'Hello, I would like to book a consultation') }}" target="_blank" class="btn-hero-primary">
          <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.135.561 4.14 1.541 5.876L.057 23.272a.5.5 0 00.616.632l5.57-1.453A11.93 11.93 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.99 0-3.851-.523-5.461-1.436l-.393-.228-4.076 1.064 1.1-3.98-.255-.407A9.953 9.953 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>
          {{ app()->getLocale() === 'ar' ? 'احجز استشارتك الآن' : 'Book Your Session Now' }}
        </a>
        <a href="#faq" class="btn-hero-secondary">
          <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
          {{ app()->getLocale() === 'ar' ? 'الأسئلة الشائعة' : 'Common Questions' }}
        </a>
      </div>

      <div class="spots-counter">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#fbbf24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        @if(app()->getLocale() === 'ar')
          المواعيد المتاحة هذا الأسبوع: <span class="spots-num" id="spots-hero">٣</span> فقط
        @else
          Available spots this week: <span class="spots-num" id="spots-hero-en">3</span> only
        @endif
      </div>
    </div>
  </section>

  {{-- ── Pain Points ── --}}
  <section class="pain-section">
    <div style="max-width:1000px;margin:0 auto;">
      <h2 class="reveal">
        @if(app()->getLocale() === 'ar') 😔 هل تمرّ بأيٍّ من هذا؟ @else 😔 Are you going through this? @endif
      </h2>
      <p class="sub reveal">{{ app()->getLocale() === 'ar' ? 'كثيرون يعيشون نفس المشاعر — وكثيرون وجدوا المخرج بعد جلسة واحدة' : 'Many people share the same feelings — and many found the way out after just one session' }}</p>
      <div class="pain-grid">
        <div class="pain-card reveal">
          <div class="emoji">💔</div>
          <p><strong>{{ app()->getLocale() === 'ar' ? 'مشكلة أسرية لا تُحل' : 'Family conflict that won\'t resolve' }}</strong>
          {{ app()->getLocale() === 'ar' ? 'خلافات متكررة، توتر دائم، وشعور بأن كل محاولة تنتهي بالفشل' : 'Recurring conflicts, constant tension, feeling every attempt ends in failure' }}
          </p>
        </div>
        <div class="pain-card reveal reveal-delay-1">
          <div class="emoji">📚</div>
          <p><strong>{{ app()->getLocale() === 'ar' ? 'تساؤلات حول مستقبل طفلك' : 'Anxiety about your child\'s future' }}</strong>
          {{ app()->getLocale() === 'ar' ? 'تصرفات لا تفهمها، تأخر دراسي، أو أسئلة تربوية معلّقة بلا إجابة' : 'Behaviors you don\'t understand, academic delays, or unanswered parenting questions' }}
          </p>
        </div>
        <div class="pain-card reveal reveal-delay-2">
          <div class="emoji">😶</div>
          <p><strong>{{ app()->getLocale() === 'ar' ? 'عزلة وانسحاب اجتماعي' : 'Social isolation and withdrawal' }}</strong>
          {{ app()->getLocale() === 'ar' ? 'صعوبة في بناء علاقات صحية أو الشعور بالانتماء في محيطك' : 'Difficulty building healthy relationships or feeling a sense of belonging' }}
          </p>
        </div>
        <div class="pain-card reveal reveal-delay-1">
          <div class="emoji">⚖️</div>
          <p><strong>{{ app()->getLocale() === 'ar' ? 'قرار مصيري لا تعرف اتجاهه' : 'A life-changing decision with no direction' }}</strong>
          {{ app()->getLocale() === 'ar' ? 'تقف أمام خيار كبير وتحتاج منظوراً خارجياً من متخصص موثوق' : 'Standing before a major choice and needing an outside perspective from a trusted expert' }}
          </p>
        </div>
        <div class="pain-card reveal reveal-delay-2">
          <div class="emoji">🔄</div>
          <p><strong>{{ app()->getLocale() === 'ar' ? 'أنماط سلبية تتكرر' : 'Negative patterns that keep repeating' }}</strong>
          {{ app()->getLocale() === 'ar' ? 'تشعر أنك تقع في نفس الأخطاء مرات عديدة دون أن تفهم السبب' : 'You feel you keep making the same mistakes without understanding why' }}
          </p>
        </div>
        <div class="pain-card reveal reveal-delay-3">
          <div class="emoji">🌪️</div>
          <p><strong>{{ app()->getLocale() === 'ar' ? 'ضغوط لا تحتملها وحدك' : 'Pressures too heavy to carry alone' }}</strong>
          {{ app()->getLocale() === 'ar' ? 'مسؤوليات متراكمة وشعور بأنك تحمل أكثر مما يمكن لشخص واحد أن يحتمل' : 'Accumulated responsibilities and feeling you carry more than one person can bear' }}
          </p>
        </div>
      </div>
      <div class="pain-answer reveal">
        @if(app()->getLocale() === 'ar')
          ✅ إذا قرأت سطراً واحداً من هذا وشعرت أنه يصفك — فأنت في المكان الصحيح. <br>استشارة واحدة قد تكون بداية التحوّل.
        @else
          ✅ If you read even one line above and felt it described you — you're in the right place. <br>One consultation could be the beginning of your transformation.
        @endif
      </div>
    </div>
  </section>

  {{-- ── Dr. Tariq Featured ── --}}
  <section class="dr-section">
    <div class="dr-inner">
      <div class="reveal-left">
        <div class="dr-badge">
          <svg width="12" height="12" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l2.4 7.4H22l-6.2 4.5 2.4 7.4L12 17l-6.2 4.3 2.4-7.4L2 9.4h7.6z"/></svg>
          {{ app()->getLocale() === 'ar' ? 'مستشار بارز في الإرشاد الأسري والتربوي' : 'Leading Advisor in Family & Educational Counseling' }}
        </div>
        <h2>
          @if(app()->getLocale() === 'ar')
            أ.د. <span class="gold">طارق الحبيب</span><br>معك في كل خطوة
          @else
            Prof. <span class="gold">Tariq Al-Habib</span><br>with you every step
          @endif
        </h2>
        <p class="bio">
          @if(app()->getLocale() === 'ar')
            خبير في الإرشاد الأسري والاجتماعي والتربوي، وصاحب منهجية فريدة قائمة على الفهم العميق للطبيعة الإنسانية. ساعد مئات الآلاف في مواجهة تحدياتهم الحياتية وبناء علاقات أكثر صحة ونضجاً.
          @else
            An expert in family, social, and educational counseling with a unique methodology built on deep understanding of human nature. He has helped hundreds of thousands face life's challenges and build healthier, more mature relationships.
          @endif
        </p>
        <div class="dr-stats">
          <div class="dr-stat">
            <span class="num" data-target="100000">0</span>
            <span class="lbl">{{ app()->getLocale() === 'ar' ? '+ مستفيد' : '+ Beneficiaries' }}</span>
          </div>
          <div class="dr-stat">
            <span class="num" data-target="25">0</span>
            <span class="lbl">{{ app()->getLocale() === 'ar' ? 'سنة خبرة' : 'Years Experience' }}</span>
          </div>
          <div class="dr-stat">
            <span class="num" data-target="97">0</span>
            <span class="lbl">{{ app()->getLocale() === 'ar' ? '% رضا المراجعين' : '% Client Satisfaction' }}</span>
          </div>
        </div>
      </div>
      <div class="dr-img-wrap reveal">
        <div class="ring">
          <img src="{{ asset('courses-img/dr-tariq.png') }}" alt="Dr. Tariq" onerror="this.style.display='none';this.nextElementSibling.style.display='flex';" />
          <div class="dr-img-placeholder" style="display:none;">ط</div>
        </div>
      </div>
    </div>
  </section>

  {{-- ── Stats Bar ── --}}
  <section class="stats-bar">
    <div class="stats-inner">
      <div class="stat-item reveal">
        <span class="num" data-target="4800">0</span>
        <span class="lbl">{{ app()->getLocale() === 'ar' ? 'استشارة منجزة' : 'Consultations Completed' }}</span>
      </div>
      <div class="stat-item reveal reveal-delay-1">
        <span class="num" data-target="97">0</span>
        <span class="lbl">{{ app()->getLocale() === 'ar' ? '% معدل الرضا' : '% Satisfaction Rate' }}</span>
      </div>
      <div class="stat-item reveal reveal-delay-2">
        <span class="num" data-target="25">0</span>
        <span class="lbl">{{ app()->getLocale() === 'ar' ? 'سنة خبرة مجمّعة' : 'Years Combined Experience' }}</span>
      </div>
      <div class="stat-item reveal reveal-delay-3">
        <span class="num" data-target="4">0</span>
        <span class="lbl">{{ app()->getLocale() === 'ar' ? 'متخصصين معتمدين' : 'Certified Specialists' }}</span>
      </div>
    </div>
  </section>

  {{-- ── Testimonials ── --}}
  <section class="testimonials-section">
    <div style="max-width:1000px;margin:0 auto;">
      <h2 class="reveal">{{ app()->getLocale() === 'ar' ? 'ماذا قال من حجزوا قبلك؟' : 'What did those who booked before you say?' }}</h2>
      <p class="sub reveal">{{ app()->getLocale() === 'ar' ? 'تجارب حقيقية من مراجعين اختاروا تغيير مساراتهم' : 'Real experiences from clients who chose to change their path' }}</p>
      <div class="testimonials-grid">
        <div class="testimonial-card reveal">
          <div class="quote-mark">"</div>
          <div class="stars">★★★★★</div>
          <p class="quote-text">
            {{ app()->getLocale() === 'ar'
              ? 'من سنتين وأنا ما أقدر أتعامل مع المشاكل اللي بالبيت. بعد جلستين مع المستشار الأسري تغيّر كل شي — صار عندي أدوات فعلية أطبّقها كل يوم والحمدلله.'
              : 'I was unable to handle household tensions for two years. After two sessions with the family advisor, everything changed — I now have real tools I apply daily.' }}
          </p>
          <div class="testimonial-author">
            <div class="avatar">م</div>
            <div class="info">
              <div class="name">{{ app()->getLocale() === 'ar' ? 'محمد العنزي' : 'Mohammed Al-Anzi' }}</div>
              <div class="role">{{ app()->getLocale() === 'ar' ? 'مراجع أسري' : 'Family Client' }}</div>
            </div>
          </div>
        </div>
        <div class="testimonial-card reveal reveal-delay-1">
          <div class="quote-mark">"</div>
          <div class="stars">★★★★★</div>
          <p class="quote-text">
            {{ app()->getLocale() === 'ar'
              ? 'كنت خايفة على تصرفات ولدي بالمدرسة وما أدري وين أبدأ. جلسة المرشد التربوي أعطتني خارطة طريق واضحة والحين أحس براحة بال ما توقعتها.'
              : 'I was worried about my son\'s school behavior and didn\'t know where to start. The educational session gave me a clear roadmap and I now feel at peace.' }}
          </p>
          <div class="testimonial-author">
            <div class="avatar">ف</div>
            <div class="info">
              <div class="name">{{ app()->getLocale() === 'ar' ? 'فاطمة العتيبي' : 'Fatima Al-Otaibi' }}</div>
              <div class="role">{{ app()->getLocale() === 'ar' ? 'أم' : 'Parent' }}</div>
            </div>
          </div>
        </div>
        <div class="testimonial-card reveal reveal-delay-2">
          <div class="quote-mark">"</div>
          <div class="stars">★★★★★</div>
          <p class="quote-text">
            {{ app()->getLocale() === 'ar'
              ? 'كان عندي قرار صعب يقلقني من زمان وما أدري وين أروح. جلست مع الدكتور طارق وطلعت بوضوح ما لقيته عند أي أحد ثاني. والله شكراً من القلب.'
              : 'I was facing a difficult decision that changed my life. The session with Dr. Tariq gave me clarity I couldn\'t find anywhere else. Thank you from the heart.' }}
          </p>
          <div class="testimonial-author">
            <div class="avatar">ع</div>
            <div class="info">
              <div class="name">{{ app()->getLocale() === 'ar' ? 'عبدالله المطيري' : 'Abdullah Al-Mutairi' }}</div>
              <div class="role">{{ app()->getLocale() === 'ar' ? 'مراجع' : 'Client' }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- ── Outcomes ── --}}
  <section class="outcomes-section">
    <div style="max-width:900px;margin:0 auto;">
      <div class="section-header">
        <h2 class="reveal">{{ app()->getLocale() === 'ar' ? 'ماذا ستحقق من هذه الجلسة؟' : 'What will you achieve from this session?' }}</h2>
        <p class="reveal">{{ app()->getLocale() === 'ar' ? 'نتائج ملموسة تبدأ من أول جلسة' : 'Tangible results starting from the first session' }}</p>
      </div>
      <div class="outcomes-grid">
        <div class="outcome-item reveal">
          <div class="icon">🧭</div>
          <div class="txt">
            <strong>{{ app()->getLocale() === 'ar' ? 'وضوح واتجاه' : 'Clarity & Direction' }}</strong>
            <span>{{ app()->getLocale() === 'ar' ? 'تخرج بفهم دقيق لمشكلتك وخطة عمل تطبيقية قابلة للتنفيذ فوراً' : 'You leave with a precise understanding of your issue and an immediately actionable plan' }}</span>
          </div>
        </div>
        <div class="outcome-item reveal reveal-delay-1">
          <div class="icon">🛡️</div>
          <div class="txt">
            <strong>{{ app()->getLocale() === 'ar' ? 'أدوات عملية' : 'Practical Tools' }}</strong>
            <span>{{ app()->getLocale() === 'ar' ? 'استراتيجيات مجربة تستطيع تطبيقها في حياتك اليومية والأسرية' : 'Proven strategies you can apply in your daily and family life' }}</span>
          </div>
        </div>
        <div class="outcome-item reveal reveal-delay-1">
          <div class="icon">💬</div>
          <div class="txt">
            <strong>{{ app()->getLocale() === 'ar' ? 'مهارات تواصل' : 'Communication Skills' }}</strong>
            <span>{{ app()->getLocale() === 'ar' ? 'كيف تتحدث وتُسمَع — بناء حوار بنّاء مع من حولك' : 'How to speak and be heard — build constructive dialogue with those around you' }}</span>
          </div>
        </div>
        <div class="outcome-item reveal reveal-delay-2">
          <div class="icon">🌱</div>
          <div class="txt">
            <strong>{{ app()->getLocale() === 'ar' ? 'خطة توجيهية شخصية' : 'Personal Guidance Plan' }}</strong>
            <span>{{ app()->getLocale() === 'ar' ? 'توصيات مخصصة لوضعك تحديداً — وليس حلولاً عامة' : 'Recommendations tailored specifically to your situation — not generic solutions' }}</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- ── Advisors ── --}}
  <section class="advisors-section">
    <div style="max-width:1000px;margin:0 auto;">
      <div class="section-header">
        <h2 class="reveal">{{ app()->getLocale() === 'ar' ? 'فريق متخصصينا' : 'Our Specialist Team' }}</h2>
        <p class="reveal">{{ app()->getLocale() === 'ar' ? 'متخصصون معتمدون في مجالاتهم' : 'Certified professionals in their fields' }}</p>
      </div>
      <div class="advisors-grid">
        <div class="advisor-card reveal">
          <div class="avatar" style="background:linear-gradient(135deg,#b04141,#7c2d12);">
            <svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            <span class="online-dot"></span>
          </div>
          <h4>{{ app()->getLocale() === 'ar' ? 'أ.د. طارق الحبيب' : 'Prof. Tariq Al-Habib' }}</h4>
          <div class="spec">{{ app()->getLocale() === 'ar' ? 'مرشد أسري واجتماعي' : 'Family & Social Counselor' }}</div>
          <p>{{ app()->getLocale() === 'ar' ? 'خبرة تزيد على 25 سنة في الإرشاد الأسري وتطوير العلاقات' : 'Over 25 years experience in family counseling and relationship development' }}</p>
        </div>
        <div class="advisor-card reveal reveal-delay-1">
          <div class="avatar" style="background:linear-gradient(135deg,#2563eb,#1e40af);">
            <svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
            <span class="online-dot"></span>
          </div>
          <h4>{{ app()->getLocale() === 'ar' ? 'مرشد تربوي' : 'Educational Advisor' }}</h4>
          <div class="spec">{{ app()->getLocale() === 'ar' ? 'تربوي معتمد' : 'Certified Educational Counselor' }}</div>
          <p>{{ app()->getLocale() === 'ar' ? 'متخصص في التوجيه التربوي واكتشاف أساليب التعلم المناسبة للأطفال' : 'Specialist in educational guidance and identifying appropriate learning styles for children' }}</p>
        </div>
        <div class="advisor-card reveal reveal-delay-2">
          <div class="avatar" style="background:linear-gradient(135deg,#059669,#065f46);">
            <svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
            <span class="online-dot"></span>
          </div>
          <h4>{{ app()->getLocale() === 'ar' ? 'مستشار اجتماعي' : 'Social Consultant' }}</h4>
          <div class="spec">{{ app()->getLocale() === 'ar' ? 'إرشاد اجتماعي وأسري' : 'Social & Family Guidance' }}</div>
          <p>{{ app()->getLocale() === 'ar' ? 'يساعدك على بناء علاقات صحية وتحسين الأنماط الاجتماعية السلبية' : 'Helps you build healthy relationships and improve negative social patterns' }}</p>
        </div>
        <div class="advisor-card reveal reveal-delay-3">
          <div class="avatar" style="background:linear-gradient(135deg,#d97706,#92400e);">
            <svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="3"/></svg>
            <span class="online-dot"></span>
          </div>
          <h4>{{ app()->getLocale() === 'ar' ? 'مدرّب تطوير ذات' : 'Self-Development Coach' }}</h4>
          <div class="spec">{{ app()->getLocale() === 'ar' ? 'مدرّب معتمد' : 'Certified Life Coach' }}</div>
          <p>{{ app()->getLocale() === 'ar' ? 'يرافقك في رحلة اكتشاف الذات وبناء عادات الحياة الصحية' : 'Accompanies you on a journey of self-discovery and building healthy life habits' }}</p>
        </div>
      </div>
    </div>
  </section>

  {{-- ── Booking Steps ── --}}
  <section class="steps-section">
    <div style="max-width:900px;margin:0 auto;">
      <div class="section-header">
        <h2 class="reveal">{{ app()->getLocale() === 'ar' ? 'كيف تحجز في 3 خطوات؟' : 'How to Book in 3 Steps?' }}</h2>
        <p class="reveal">{{ app()->getLocale() === 'ar' ? 'عملية بسيطة لا تأخذ أكثر من دقيقتين' : 'A simple process that takes no more than two minutes' }}</p>
      </div>
      <div class="steps-list">
        <div class="step-item reveal">
          <div class="step-num">١</div>
          <div class="step-content">
            <h4>{{ app()->getLocale() === 'ar' ? 'تواصل معنا عبر واتساب' : 'Contact Us via WhatsApp' }}</h4>
            <p>{{ app()->getLocale() === 'ar' ? 'أرسل "أريد حجز استشارة" على الرقم 96555665161+ وسيردّ عليك فريقنا خلال دقائق' : 'Send "I want to book a consultation" to +96555665161 and our team will respond within minutes' }}</p>
          </div>
        </div>
        <div class="step-item reveal reveal-delay-1">
          <div class="step-num">٢</div>
          <div class="step-content">
            <h4>{{ app()->getLocale() === 'ar' ? 'اختر المتخصص والموعد المناسب' : 'Choose Your Specialist & Time' }}</h4>
            <p>{{ app()->getLocale() === 'ar' ? 'سيساعدك الفريق في اختيار المتخصص الأنسب لاحتياجك ومواعيد تناسب جدولك' : 'The team will help you select the right specialist and times that suit your schedule' }}</p>
          </div>
        </div>
        <div class="step-item reveal reveal-delay-2">
          <div class="step-num">٣</div>
          <div class="step-content">
            <h4>{{ app()->getLocale() === 'ar' ? 'احضر جلستك واحصل على توصياتك' : 'Attend Your Session & Get Your Recommendations' }}</h4>
            <p>{{ app()->getLocale() === 'ar' ? 'جلسة تفاعلية تخرج منها بخطة توجيهية شخصية ومخصصة لوضعك' : 'An interactive session that gives you a personalized guidance plan tailored to your situation' }}</p>
          </div>
        </div>
      </div>
      <div style="text-align:center;margin-top:40px;" class="reveal">
        <a href="https://wa.me/96555665161?text={{ urlencode(app()->getLocale() === 'ar' ? 'مرحباً، أريد حجز استشارة' : 'Hello, I want to book a consultation') }}" target="_blank" class="btn-hero-primary" style="display:inline-flex;">
          <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.135.561 4.14 1.541 5.876L.057 23.272a.5.5 0 00.616.632l5.57-1.453A11.93 11.93 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.99 0-3.851-.523-5.461-1.436l-.393-.228-4.076 1.064 1.1-3.98-.255-.407A9.953 9.953 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>
          {{ app()->getLocale() === 'ar' ? 'ابدأ الحجز الآن' : 'Start Booking Now' }}
        </a>
      </div>
    </div>
  </section>

  {{-- ── FAQ ── --}}
  <section class="faq-section" id="faq">
    <div style="max-width:720px;margin:0 auto;">
      <div class="section-header">
        <h2 class="reveal">{{ app()->getLocale() === 'ar' ? 'الأسئلة الأكثر شيوعاً' : 'Frequently Asked Questions' }}</h2>
        <p class="reveal">{{ app()->getLocale() === 'ar' ? 'إجابات واضحة لكل ما يدور في ذهنك' : 'Clear answers to everything on your mind' }}</p>
      </div>
      <div class="faq-list reveal">

        @php
        $faqs = app()->getLocale() === 'ar' ? [
          ['q' => 'ما الفرق بين الاستشارة هنا وعند أي مستشار آخر؟', 'a' => 'المستشارون في مركز مطمئنة يجمعون بين الخبرة الأكاديمية والتطبيق الميداني. الجلسة مبنية على فهم وضعك تحديداً — ليست نصائح عامة بل خطة عمل مخصصة لك أنت.'],
          ['q' => 'هل الجلسة سرية؟', 'a' => 'نعم تماماً. جميع ما يُقال في الجلسة يبقى بيننا وبينك بشكل كامل. لا يُشارك أي معلومة مع أي طرف ثالث تحت أي ظرف.'],
          ['q' => 'كيف يتم اختيار المستشار المناسب لي؟', 'a' => 'عند التواصل عبر واتساب سيسألك الفريق بعض الأسئلة البسيطة ثم يرشدك إلى المستشار الأنسب لطبيعة استشارتك سواء كانت أسرية أو تربوية أو اجتماعية.'],
          ['q' => 'هل يمكن الحجز لجلسة مع الدكتور طارق مباشرة؟', 'a' => 'نعم، يمكنك طلب حجز جلسة مع الدكتور طارق الحبيب مباشرة حسب توافر المواعيد. تواصل مع الفريق وسيؤكدون لك الإتاحة الحالية.'],
          ['q' => 'كم مدة الجلسة؟', 'a' => 'الجلسة الاعتيادية مدتها 50 دقيقة. في بعض الحالات قد تُعقد جلسة أولية للتقييم تكون أقصر.'],
          ['q' => 'هل يمكن الحجز عن بعد (أونلاين)؟', 'a' => 'نعم، نوفر جلسات عن بعد لمن لا يستطيع الحضور الشخصي. تتم الجلسات عبر منصات تواصل مشفّرة وآمنة.'],
          ['q' => 'ما سياسة الإلغاء؟', 'a' => 'يمكن إلغاء الموعد أو تأجيله قبل 24 ساعة على الأقل من الموعد دون أي رسوم. الإلغاء بعد ذلك يخضع لرسوم رمزية بحسب السياسة المعتمدة.'],
        ] : [
          ['q' => 'What makes your consultations different?', 'a' => 'Motmaena\'s specialists combine academic expertise with real-world application. The session is built around your specific situation — not generic advice, but a personalized action plan made for you.'],
          ['q' => 'Is the session confidential?', 'a' => 'Absolutely. Everything discussed in your session remains strictly between you and your specialist. No information is shared with any third party under any circumstances.'],
          ['q' => 'How is the right specialist chosen for me?', 'a' => 'When you contact us via WhatsApp, the team will ask a few simple questions and then guide you to the specialist best suited for your consultation type — family, educational, or social.'],
          ['q' => 'Can I book directly with Dr. Tariq?', 'a' => 'Yes, you can request a session with Dr. Tariq Al-Habib directly based on appointment availability. Contact the team and they\'ll confirm current availability for you.'],
          ['q' => 'How long is a session?', 'a' => 'A standard session is 50 minutes. In some cases, a shorter initial evaluation session may be arranged first.'],
          ['q' => 'Can I book online (remote sessions)?', 'a' => 'Yes, we offer remote sessions for those who cannot attend in person. Sessions are conducted via secure, encrypted communication platforms.'],
          ['q' => 'What is the cancellation policy?', 'a' => 'Appointments can be cancelled or rescheduled at least 24 hours in advance with no fees. Late cancellations are subject to a nominal fee per the approved policy.'],
        ];
        @endphp

        @foreach($faqs as $i => $faq)
          <div class="faq-item" data-faq="{{ $i }}">
            <button class="faq-q" type="button" data-faq-btn="{{ $i }}">
              <span>{{ $faq['q'] }}</span>
              <span class="arrow">▾</span>
            </button>
            <div class="faq-a">{{ $faq['a'] }}</div>
          </div>
        @endforeach

      </div>
    </div>
  </section>

  {{-- ── Terms ── --}}
  <section class="terms-section">
    <div style="max-width:760px;margin:0 auto;">
      <div class="section-header" style="margin-bottom:28px;">
        <h2 class="reveal">{{ app()->getLocale() === 'ar' ? 'الشروط وسياسة الخدمة' : 'Terms & Service Policy' }}</h2>
      </div>
      <div class="terms-box reveal">
        <div class="terms-disclaimer">
          <span class="icon">⚠️</span>
          <p>
            @if(app()->getLocale() === 'ar')
              <strong>إشعار مهم:</strong> الخدمات المقدمة هنا هي <strong>استشارات اجتماعية وتربوية وأسرية فقط</strong> وليست تشخيصاً طبياً أو علاجاً أو تدخلاً إكلينيكياً. لا تُغني عن مراجعة الطبيب أو الأخصائي الطبي عند الحاجة.
            @else
              <strong>Important Notice:</strong> Services provided here are <strong>social, educational, and family consultations only</strong> — not medical diagnosis, psychological treatment, or clinical intervention. They do not replace consulting a physician or medical specialist when needed.
            @endif
          </p>
        </div>
        <div class="terms-body">
          <h3>{{ app()->getLocale() === 'ar' ? 'سياسة الاستشارات' : 'Consultation Policy' }}</h3>
          <div class="terms-items">
            <div class="term-row">
              <span class="t-icon">📅</span>
              <p><strong>{{ app()->getLocale() === 'ar' ? 'المواعيد والحجز' : 'Appointments & Booking' }}</strong>
              {{ app()->getLocale() === 'ar' ? 'يُعدّ الموعد محجوزاً فور تأكيده من الفريق. الإلغاء قبل 24 ساعة مجاني.' : 'Appointment is confirmed upon team confirmation. Cancellation 24+ hours ahead is free of charge.' }}</p>
            </div>
            <div class="term-row">
              <span class="t-icon">⏰</span>
              <p><strong>{{ app()->getLocale() === 'ar' ? 'التأخر والغياب' : 'Late Arrival & No-Shows' }}</strong>
              {{ app()->getLocale() === 'ar' ? 'التأخر أكثر من 15 دقيقة يُعدّ غياباً. تُطبَّق رسوم الموعد الكامل.' : 'Arriving 15+ minutes late is considered a no-show. Full session fee applies.' }}</p>
            </div>
            <div class="term-row">
              <span class="t-icon">🔒</span>
              <p><strong>{{ app()->getLocale() === 'ar' ? 'السرية التامة' : 'Full Confidentiality' }}</strong>
              {{ app()->getLocale() === 'ar' ? 'جميع محتويات الجلسات سرية بالكامل ولا تُشارك مع أي طرف.' : 'All session content is fully confidential and never shared with any party.' }}</p>
            </div>
            <div class="term-row">
              <span class="t-icon">🤝</span>
              <p><strong>{{ app()->getLocale() === 'ar' ? 'أدب التعامل' : 'Respectful Conduct' }}</strong>
              {{ app()->getLocale() === 'ar' ? 'يُرجى الالتزام بالاحترام المتبادل طوال الجلسة. يحق للمتخصص إنهاء الجلسة عند الإخلال بذلك.' : 'Mutual respect is required throughout. The specialist reserves the right to end the session if violated.' }}</p>
            </div>
            <div class="term-row">
              <span class="t-icon">📋</span>
              <p><strong>{{ app()->getLocale() === 'ar' ? 'نطاق الخدمة' : 'Scope of Service' }}</strong>
              {{ app()->getLocale() === 'ar' ? 'الاستشارات اجتماعية وتربوية بحتة. في حالة الحاجة لتدخل طبي يُحال المراجع للجهة المختصة.' : 'Consultations are strictly social and educational. If medical intervention is needed, the client is referred appropriately.' }}</p>
            </div>
            <div class="term-row">
              <span class="t-icon">💳</span>
              <p><strong>{{ app()->getLocale() === 'ar' ? 'الدفع والاسترداد' : 'Payment & Refunds' }}</strong>
              {{ app()->getLocale() === 'ar' ? 'رسوم الجلسة غير قابلة للاسترداد بعد إجرائها. يمكن إعادة الجدولة بشروط محددة.' : 'Session fees are non-refundable once conducted. Rescheduling is possible under specific conditions.' }}</p>
            </div>
          </div>
          <div class="consent-row">
            <input type="checkbox" id="consent-check" onchange="toggleBookingForm(this.checked)">
            <label for="consent-check">
              {{ app()->getLocale() === 'ar'
                ? 'أقرّ بأنني اطلعت على جميع الشروط وأفهم أن الخدمة المقدمة هي استشارات اجتماعية وتربوية، وليست علاجاً طبياً. أوافق على الالتزام بسياسة المركز.'
                : 'I acknowledge reading all terms and understand that the service is social & educational consultation, not medical treatment. I agree to abide by the center\'s policy.' }}
              <strong> {{ app()->getLocale() === 'ar' ? '(الحجز يعني الموافقة التلقائية)' : '(Booking implies automatic acceptance)' }}</strong>
            </label>
          </div>

          {{-- Hint: must agree first --}}
          <div class="consent-required-note" id="consent-required-note">
            ⚠️ {{ app()->getLocale() === 'ar' ? 'يرجى الموافقة على الشروط أعلاه أولاً قبل الحجز' : 'Please agree to the terms above before booking' }}
          </div>

          {{-- Booking Form — appears after agreeing --}}
          <div class="booking-form-wrap" id="booking-form-wrap">
            <form class="booking-form" method="POST" action="{{ route('consultations.book') }}" id="booking-form">
              @csrf

              <h4>
                <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.135.561 4.14 1.541 5.876L.057 23.272a.5.5 0 00.616.632l5.57-1.453A11.93 11.93 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.99 0-3.851-.523-5.461-1.436l-.393-.228-4.076 1.064 1.1-3.98-.255-.407A9.953 9.953 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>
                {{ app()->getLocale() === 'ar' ? 'أدخل بياناتك لتأكيد الحجز' : 'Enter your details to confirm booking' }}
              </h4>

              {{-- Phone with country code --}}
              <div class="form-row">
                <label>📱 {{ app()->getLocale() === 'ar' ? 'رقم هاتفك (واتساب)' : 'Your WhatsApp number' }}</label>
                <div class="phone-row">
                  <select id="country-code" onchange="updatePhoneField()">
                    <option value="965" selected>🇰🇼 +965 الكويت</option>
                    <option value="966">🇸🇦 +966 السعودية</option>
                    <option value="971">🇦🇪 +971 الإمارات</option>
                    <option value="974">🇶🇦 +974 قطر</option>
                    <option value="973">🇧🇭 +973 البحرين</option>
                    <option value="968">🇴🇲 +968 عُمان</option>
                    <option value="962">🇯🇴 +962 الأردن</option>
                    <option value="20">🇪🇬 +20 مصر</option>
                    <option value="963">🇸🇾 +963 سوريا</option>
                    <option value="961">🇱🇧 +961 لبنان</option>
                    <option value="other">🌍 {{ app()->getLocale() === 'ar' ? 'أخرى' : 'Other' }}</option>
                  </select>
                  <input type="tel" id="phone-number"
                    placeholder="{{ app()->getLocale() === 'ar' ? 'رقم الهاتف' : 'Phone number' }}"
                    required
                    oninput="updatePhoneField()">
                </div>
                <input type="hidden" name="phone" id="phone-hidden">
              </div>

              {{-- Consultation type --}}
              <div class="form-row">
                <label>📋 {{ app()->getLocale() === 'ar' ? 'نوع الاستشارة' : 'Consultation type' }}</label>
                <select name="problem_type" required>
                  <option value="" disabled selected>{{ app()->getLocale() === 'ar' ? '— اختر —' : '— Select —' }}</option>
                  @if(app()->getLocale() === 'ar')
                    <option value="استشارة أسرية">👨‍👩‍👧 استشارة أسرية</option>
                    <option value="استشارة تربوية">📚 استشارة تربوية</option>
                    <option value="استشارة اجتماعية">🤝 استشارة اجتماعية</option>
                    <option value="تطوير الذات">🎯 تطوير الذات</option>
                    <option value="استشارة مع د. طارق">⭐ استشارة مع د. طارق الحبيب</option>
                  @else
                    <option value="Family Consultation">👨‍👩‍👧 Family Consultation</option>
                    <option value="Educational Consultation">📚 Educational Consultation</option>
                    <option value="Social Consultation">🤝 Social Consultation</option>
                    <option value="Self Development">🎯 Self Development</option>
                    <option value="Session with Dr. Tariq">⭐ Session with Dr. Tariq</option>
                  @endif
                </select>
              </div>

              {{-- Notes — optional --}}
              <div class="form-row">
                <label>
                  💬 {{ app()->getLocale() === 'ar' ? 'شاركنا شي عن وضعك' : 'Share something about your situation' }}
                  <span class="optional-tag">{{ app()->getLocale() === 'ar' ? 'اختياري' : 'optional' }}</span>
                </label>
                <textarea name="notes"
                  placeholder="{{ app()->getLocale() === 'ar' ? 'مثال: عندي مشكلة في التعامل مع ابني...' : 'e.g. I\'m struggling with a family situation...' }}"></textarea>
              </div>

              <button type="submit" class="form-submit-btn">
                <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.135.561 4.14 1.541 5.876L.057 23.272a.5.5 0 00.616.632l5.57-1.453A11.93 11.93 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.99 0-3.851-.523-5.461-1.436l-.393-.228-4.076 1.064 1.1-3.98-.255-.407A9.953 9.953 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>
                {{ app()->getLocale() === 'ar' ? 'تأكيد وإرسال عبر واتساب' : 'Confirm & Send via WhatsApp' }}
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- ── Final CTA ── --}}
  <section class="final-cta">
    <div style="max-width:700px;margin:0 auto;position:relative;z-index:1;">
      <h2 class="reveal">
        @if(app()->getLocale() === 'ar')
          لا تدع الفرصة تفوتك — <span class="accent">احجز الآن</span>
        @else
          Don't miss the opportunity — <span class="accent">Book Now</span>
        @endif
      </h2>
      <p class="reveal">
        {{ app()->getLocale() === 'ar'
          ? 'انضم إلى آلاف الأشخاص الذين وجدوا وضوحاً وتغييراً حقيقياً في حياتهم بعد جلسة واحدة مع متخصصينا'
          : 'Join thousands who found real clarity and change in their lives after just one session with our specialists' }}
      </p>
      <div class="countdown reveal">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        {{ app()->getLocale() === 'ar' ? 'المواعيد تمتلئ بسرعة — تبقّى ' : 'Spots fill fast — only ' }}
        <span id="spots-final" style="font-size:18px;font-weight:900;">{{ app()->getLocale() === 'ar' ? '٣' : '3' }}</span>
        {{ app()->getLocale() === 'ar' ? ' أماكن هذا الأسبوع' : ' spots left this week' }}
      </div>
      <div class="final-cta-btns reveal">
        <a href="https://wa.me/96555665161?text={{ urlencode(app()->getLocale() === 'ar' ? 'مرحباً، أريد حجز استشارة' : 'Hello, I want to book a consultation') }}" target="_blank" class="btn-final">
          <svg width="22" height="22" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.135.561 4.14 1.541 5.876L.057 23.272a.5.5 0 00.616.632l5.57-1.453A11.93 11.93 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.99 0-3.851-.523-5.461-1.436l-.393-.228-4.076 1.064 1.1-3.98-.255-.407A9.953 9.953 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>
          {{ app()->getLocale() === 'ar' ? 'احجز عبر واتساب' : 'Book via WhatsApp' }}
        </a>
        <a href="tel:+96555665161" class="btn-final btn-final-red">
          <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
          {{ app()->getLocale() === 'ar' ? 'اتصل بنا مباشرة' : 'Call Us Directly' }}
        </a>
      </div>
      <p style="margin-top:20px;font-size:13px;color:rgba(255,255,255,.4);" class="reveal">
        {{ app()->getLocale() === 'ar' ? '🔒 جلساتنا سرية تماماً — معلوماتك لن تُشارك أبداً' : '🔒 Our sessions are fully confidential — your information will never be shared' }}
      </p>
    </div>
  </section>

  {{-- ── Sticky Bottom Bar ── --}}
  <div class="sticky-bar" id="sticky-bar">
    <div class="sticky-text">
      {{ app()->getLocale() === 'ar' ? 'احجز استشارتك الآن' : 'Book Your Consultation Now' }}
      <span id="sticky-spots-text">{{ app()->getLocale() === 'ar' ? 'تبقّى ٣ أماكن فقط هذا الأسبوع' : 'Only 3 spots left this week' }}</span>
    </div>
    <a href="https://wa.me/96555665161?text={{ urlencode(app()->getLocale() === 'ar' ? 'مرحباً، أريد حجز استشارة' : 'Hello, I want to book a consultation') }}" target="_blank" class="sticky-btn">
      <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.135.561 4.14 1.541 5.876L.057 23.272a.5.5 0 00.616.632l5.57-1.453A11.93 11.93 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.99 0-3.851-.523-5.461-1.436l-.393-.228-4.076 1.064 1.1-3.98-.255-.407A9.953 9.953 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>
      {{ app()->getLocale() === 'ar' ? 'احجز الآن' : 'Book Now' }}
    </a>
  </div>

  {{-- ── Floating WhatsApp ── --}}
  <a href="https://wa.me/96555665161?text={{ urlencode(app()->getLocale() === 'ar' ? 'مرحباً، أريد حجز استشارة' : 'Hello, I want to book a consultation') }}"
     target="_blank" class="float-wa" id="float-wa" title="">
    <span class="wa-label">{{ app()->getLocale() === 'ar' ? 'احجز الآن' : 'Book Now' }}</span>
    <svg fill="#fff" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.135.561 4.14 1.541 5.876L.057 23.272a.5.5 0 00.616.632l5.57-1.453A11.93 11.93 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.99 0-3.851-.523-5.461-1.436l-.393-.228-4.076 1.064 1.1-3.98-.255-.407A9.953 9.953 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>
  </a>

  {{-- ── Last Booking Toast ── --}}
  <div class="last-booking-toast" id="booking-toast" style="display:none;" onclick="this.style.display='none'">
    <span class="t-icon">✅</span>
    <div class="t-txt">
      <strong>{{ app()->getLocale() === 'ar' ? 'تم حجز موعد جديد' : 'New booking just made' }}</strong>
      <span id="toast-msg">{{ app()->getLocale() === 'ar' ? 'من الكويت — منذ قليل' : 'From Kuwait — just now' }}</span>
    </div>
  </div>

</div>

<script>
/* ── Booking form toggle ── */
function toggleBookingForm(checked) {
  const wrap = document.getElementById('booking-form-wrap');
  const note = document.getElementById('consent-required-note');
  if (!wrap) return;
  if (checked) {
    wrap.classList.add('open');
    if (note) note.style.display = 'none';
    setTimeout(() => wrap.scrollIntoView({ behavior: 'smooth', block: 'nearest' }), 120);
  } else {
    wrap.classList.remove('open');
  }
}

/* ── Intercept CTA buttons that need consent ── */
document.addEventListener('DOMContentLoaded', function() {
  /* Show hint if user tries to click WhatsApp CTAs without agreeing */
  document.querySelectorAll('.btn-hero-primary, .btn-final, .sticky-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
      const cb = document.getElementById('consent-check');
      if (cb && !cb.checked) {
        e.preventDefault();
        const note = document.getElementById('consent-required-note');
        if (note) {
          note.style.display = 'block';
          note.scrollIntoView({ behavior: 'smooth', block: 'center' });
          note.style.animation = 'none';
          setTimeout(() => note.style.animation = '', 10);
        }
        /* Scroll to terms */
        document.querySelector('.terms-section')?.scrollIntoView({ behavior: 'smooth', block: 'center' });
      }
    });
  });
});

/* ── Phone field with country code ── */
function updatePhoneField() {
  const code = document.getElementById('country-code');
  const num  = document.getElementById('phone-number');
  const hidden = document.getElementById('phone-hidden');
  if (!code || !num || !hidden) return;
  const selectedCode = code.value === 'other' ? '' : code.value;
  const raw = num.value.replace(/\D/g, '');
  hidden.value = selectedCode ? ('+' + selectedCode + raw) : raw;
  num.removeAttribute('name');
  hidden.setAttribute('name', 'phone');
}

/* ── Booking form AJAX submit — builds WhatsApp URL via JS for correct emoji ── */
(function () {
  const form = document.getElementById('booking-form');
  if (!form) return;

  form.addEventListener('submit', function (e) {
    e.preventDefault();
    updatePhoneField();

    const fd = new FormData(form);
    const phone = fd.get('phone') || '';
    const type  = fd.get('problem_type') || '';
    const notes = fd.get('notes') || '';

    fetch(form.action, {
      method: 'POST',
      headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
      body: fd
    })
    .then(r => r.ok ? r.json() : Promise.reject(r))
    .then(json => {
      if (!json.ok) return;

      let msg = '★ مرحباً مركز مطمئنة\n'
              + 'أريد حجز استشارة\n\n'
              + '✔ *رقم التواصل:* ' + phone + '\n'
              + '✔ *نوع الاستشارة:* ' + type;
      if (notes.trim()) {
        msg += '\n✏ *ملاحظات:* ' + notes;
      }

      window.location.href = 'https://wa.me/96555665161?text=' + encodeURIComponent(msg);
    })
    .catch(() => {
      // Fallback: plain POST (no emoji but still works)
      form.removeEventListener('submit', arguments.callee);
      form.submit();
    });
  });
})();

(function(){
  const isAr = '{{ app()->getLocale() }}' === 'ar';
  const arabicNums = ['٠','١','٢','٣','٤','٥','٦','٧','٨','٩'];
  function toAr(n){ return String(n).split('').map(d => arabicNums[+d]||d).join(''); }

  /* ── Reveal on scroll ── */
  const reveals = document.querySelectorAll('.consult-page .reveal, .consult-page .reveal-left, .consult-page .reveal-right');
  const obs = new IntersectionObserver(entries => {
    entries.forEach(e => { if(e.isIntersecting){ e.target.classList.add('active'); obs.unobserve(e.target); } });
  }, { threshold: 0.08 });
  reveals.forEach(el => obs.observe(el));

  /* ── Animated counters ── */
  function animateCounter(el, target, duration) {
    const start = performance.now();
    const step = ts => {
      const progress = Math.min((ts - start) / duration, 1);
      const ease = 1 - Math.pow(1 - progress, 3);
      const current = Math.round(ease * target);
      if(target >= 1000){
        el.textContent = (current >= 1000 ? Math.round(current/1000) + 'K' : current);
      } else {
        el.textContent = current;
      }
      if(progress < 1) requestAnimationFrame(step);
    };
    requestAnimationFrame(step);
  }
  const counterObs = new IntersectionObserver(entries => {
    entries.forEach(e => {
      if(e.isIntersecting){
        animateCounter(e.target, parseInt(e.target.dataset.target), 1800);
        counterObs.unobserve(e.target);
      }
    });
  }, { threshold: 0.4 });
  document.querySelectorAll('[data-target]').forEach(el => counterObs.observe(el));

  /* ── FAQ Accordion ── */
  document.querySelectorAll('[data-faq-btn]').forEach(btn => {
    btn.addEventListener('click', function() {
      const idx = this.getAttribute('data-faq-btn');
      const item = document.querySelector('.faq-item[data-faq="'+idx+'"]');
      const isOpen = item.classList.contains('open');
      document.querySelectorAll('.faq-item.open').forEach(i => i.classList.remove('open'));
      if(!isOpen) item.classList.add('open');
    });
  });
  const firstFaq = document.querySelector('.faq-item[data-faq="0"]');
  if(firstFaq) firstFaq.classList.add('open');

  /* ── Sticky bar ── */
  const stickyBar = document.getElementById('sticky-bar');
  let shown = false;
  window.addEventListener('scroll', () => {
    const s = window.scrollY > 500;
    if(s !== shown){ shown = s; stickyBar.classList.toggle('visible', s); }
  }, { passive: true });

  /* ── Spots FOMO counter ── */
  let spots = 3;
  const spotsEls = ['spots-strip','spots-strip-en','spots-hero','spots-hero-en','spots-final'].map(id => document.getElementById(id)).filter(Boolean);

  function updateSpots(n){
    spotsEls.forEach(el => {
      const useAr = isAr && !el.id.endsWith('-en');
      el.textContent = useAr ? toAr(n) : n;
    });
    const stickySpan = document.getElementById('sticky-spots-text');
    if(stickySpan){
      stickySpan.textContent = isAr
        ? 'تبقّى ' + toAr(n) + ' أماكن فقط هذا الأسبوع'
        : 'Only ' + n + ' spot' + (n===1?'':'s') + ' left this week';
    }
  }

  setTimeout(() => {
    if(spots > 1){ spots--; updateSpots(spots); }
  }, 8000 + Math.random() * 14000);

  /* ── Live viewers fluctuation ── */
  const viewersEl = document.getElementById('live-viewers');
  if(viewersEl){
    let v = parseInt(viewersEl.textContent) || 12;
    setInterval(() => {
      v = Math.max(5, Math.min(30, v + (Math.random() > .5 ? 1 : -1)));
      viewersEl.textContent = v;
    }, 7000);
  }

  /* ── Last booking time update ── */
  const lastBookEl = document.getElementById('last-book-time');
  if(lastBookEl){
    let mins = parseInt(lastBookEl.textContent) || 8;
    setInterval(() => { mins++; lastBookEl.textContent = mins; }, 60000);
  }

  /* ── Booking toast notifications ── */
  const toast = document.getElementById('booking-toast');
  const toastMsg = document.getElementById('toast-msg');
  const toastNames = isAr
    ? ['من الكويت — منذ دقيقتين','من الرياض — منذ 5 دقائق','من الإمارات — منذ 7 دقائق','من الكويت — منذ لحظات','من قطر — منذ 3 دقائق']
    : ['From Kuwait — 2 min ago','From UAE — 5 min ago','From Saudi — just now','From Kuwait — 3 min ago'];
  let toastIdx = 0;
  function showToast(){
    if(!toast || !toastMsg) return;
    toastMsg.textContent = toastNames[toastIdx % toastNames.length];
    toastIdx++;
    toast.style.display = 'flex';
    setTimeout(() => { if(toast) toast.style.display = 'none'; }, 5000);
  }
  setTimeout(showToast, 6000);
  setInterval(showToast, 35000 + Math.random() * 20000);

  /* ── Hide float-wa when sticky bar visible ── */
  const floatWa = document.getElementById('float-wa');
  if(floatWa && stickyBar){
    const mo = new MutationObserver(() => {
      floatWa.style.display = stickyBar.classList.contains('visible') ? 'none' : 'flex';
    });
    mo.observe(stickyBar, { attributes: true, attributeFilter: ['class'] });
  }

})();
</script>

@endsection
