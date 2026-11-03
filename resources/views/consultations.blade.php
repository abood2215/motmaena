@extends('layouts.app')

@section('title', app()->getLocale() == 'ar' ? 'استشارات أسرية وزوجية وتربوية في الكويت | مركز مطمئنة' : 'Family, Marital & Parenting Consultations in Kuwait | Motmaena Center')
@section('meta_description', app()->getLocale() == 'ar' ? 'استشارات اجتماعية وتربوية وأسرية خاصة في مركز مطمئنة بالكويت، وطلب موعد حضوري أو هاتفي مع أ.د. طارق الحبيب. احجز عبر الموقع أو واتساب.' : 'Private social, parenting and family consultations at Motmaena Center in Kuwait, and requesting an in-person or phone appointment with Prof. Dr. Tariq Al-Habib. Book on the site or WhatsApp.')
@include('partials.breadcrumb-schema', ['items' => [[app()->getLocale() == 'ar' ? 'الاستشارات' : 'Consultations', route('consultations')]]])

{{-- Consultations, in the site's quiet editorial look (partials/lx-styles): the booking form is always in view,
     the terms are accepted with one tick inside it, WhatsApp is one tap away. --}}
@php
    $isAr = app()->getLocale() === 'ar';
    $lang = $isAr ? 'ar' : 'en';
    $t = fn ($ar, $en) => $isAr ? $ar : $en;
    $price = config('center.prices');
    $bookText = $t('مرحباً، أريد حجز استشارة', 'Hello, I want to book a consultation');
    $waBook = 'https://wa.me/' . $site['whatsapp'] . '?text=' . urlencode($bookText);
    $waPretty = \App\Models\SiteSetting::pretty($site['whatsapp']);

    $pains = [
        ['family',  $t('مشكلة أسرية لا تُحل', 'Family conflict that won\'t resolve'), $t('خلافات متكررة، توتر دائم، وشعور بأن كل محاولة تنتهي بالفشل', 'Recurring conflicts, constant tension, feeling every attempt ends in failure')],
        ['child',   $t('تساؤلات حول مستقبل طفلك', 'Anxiety about your child\'s future'), $t('تصرفات لا تفهمها، تأخر دراسي، أو أسئلة تربوية معلّقة بلا إجابة', 'Behaviors you don\'t understand, academic delays, or unanswered parenting questions')],
        ['people',  $t('عزلة وانسحاب اجتماعي', 'Social isolation and withdrawal'), $t('صعوبة في بناء علاقات صحية أو الشعور بالانتماء في محيطك', 'Difficulty building healthy relationships or feeling a sense of belonging')],
        ['scale',   $t('قرار مصيري لا تعرف اتجاهه', 'A life-changing decision with no direction'), $t('تقف أمام خيار كبير وتحتاج منظوراً خارجياً من أخصائي', 'Standing before a major choice and needing an outside perspective from a specialist')],
        ['repeat',  $t('أنماط سلبية تتكرر', 'Negative patterns that keep repeating'), $t('تشعر أنك تقع في نفس الأخطاء مرات عديدة دون أن تفهم السبب', 'You feel you keep making the same mistakes without understanding why')],
        ['weight',  $t('ضغوط لا تحتملها وحدك', 'Pressures too heavy to carry alone'), $t('مسؤوليات متراكمة وشعور بأنك تحمل أكثر مما يمكن لشخص واحد أن يحتمل', 'Accumulated responsibilities and feeling you carry more than one person can bear')],
    ];

    $outcomes = [
        ['compass', $t('وضوح واتجاه', 'Clarity & Direction'), $t('تخرج بفهم دقيق لمشكلتك وخطة عمل تطبيقية قابلة للتنفيذ فوراً', 'You leave with a precise understanding of your issue and an immediately actionable plan')],
        ['shield',  $t('أدوات عملية', 'Practical Tools'), $t('استراتيجيات مجربة تستطيع تطبيقها في حياتك اليومية والأسرية', 'Proven strategies you can apply in your daily and family life')],
        ['chat',    $t('مهارات تواصل', 'Communication Skills'), $t('كيف تتحدث وتُسمَع — بناء حوار بنّاء مع من حولك', 'How to speak and be heard — build constructive dialogue with those around you')],
        ['sprout',  $t('خطة توجيهية شخصية', 'Personal Guidance Plan'), $t('توصيات مخصصة لوضعك تحديداً — وليس حلولاً عامة', 'Recommendations tailored specifically to your situation — not generic solutions')],
    ];

    $team = [
        ['book',   $t('أخصائي تربوي', 'Educational Specialist'), null, $t('أخصائي في التوجيه التربوي واكتشاف أساليب التعلم المناسبة للأطفال', 'Specialist in educational guidance and identifying appropriate learning styles for children')],
        ['heart',  $t('أخصائي اجتماعي', 'Social Specialist'), $t('إرشاد اجتماعي وأسري', 'Social & Family Guidance'), $t('يساعدك على بناء علاقات صحية وتحسين الأنماط الاجتماعية السلبية', 'Helps you build healthy relationships and improve negative social patterns')],
        ['target', $t('أخصائي تطوير ذات', 'Self-Development Specialist'), null, $t('يرافقك في رحلة اكتشاف الذات وبناء عادات الحياة الصحية', 'Accompanies you on a journey of self-discovery and building healthy life habits')],
    ];

    $steps = [
        [$t('تواصل معنا', 'Get in touch'), $t('املأ النموذج، أو أرسل "أريد حجز استشارة" على الرقم ' . $waPretty . ' وسيردّ عليك فريقنا', 'Fill in the form, or send "I want to book a consultation" to ' . $waPretty . ' and our team will reply')],
        [$t('اختر الأخصائي والموعد المناسب', 'Choose Your Specialist & Time'), $t('سيساعدك الفريق في اختيار الأخصائي الأنسب لاحتياجك ومواعيد تناسب جدولك', 'The team will help you select the right specialist and times that suit your schedule')],
        [$t('احضر جلستك واحصل على توصياتك', 'Attend Your Session & Get Your Recommendations'), $t('جلسة تفاعلية تخرج منها بخطة توجيهية شخصية ومخصصة لوضعك', 'An interactive session that gives you a personalized guidance plan tailored to your situation')],
    ];

    $faqs = $isAr ? [
        ['q' => 'ما الاستشارات المتاحة حاليًا؟', 'a' => 'يقدم المركز حاليًا الاستشارات الزوجية والأسرية والتربوية والاجتماعية، وجلسات تطوير الذات. أما خدمة الاستشارات النفسية فغير متاحة حاليًا، وسيُعلن عنها عند افتتاحها.'],
        ['q' => 'كيف أعرف نوع الاستشارة المناسبة؟', 'a' => 'تواصل مع فريق المواعيد واشرح احتياجك بصورة مختصرة، وسيساعدك الفريق في اختيار الخدمة المناسبة من الخدمات المتاحة.'],
        ['q' => 'ما الفرق بين الاستشارة هنا وعند أي أخصائي آخر؟', 'a' => 'الأخصائيون في مركز مطمئنة يجمعون بين الخبرة الأكاديمية والتطبيق الميداني. الجلسة مبنية على فهم وضعك تحديداً — ليست نصائح عامة بل خطة عمل مخصصة لك أنت.'],
        ['q' => 'هل معلومات الاستشارة خاصة؟', 'a' => 'يحرص المركز على التعامل مع معلومات العملاء بخصوصية وفق السياسات والإجراءات المعتمدة لديه.'],
        ['q' => 'كيف يتم اختيار الأخصائي المناسب لي؟', 'a' => 'عند التواصل عبر واتساب سيسألك الفريق بعض الأسئلة البسيطة ثم يرشدك إلى الأخصائي الأنسب لطبيعة استشارتك سواء كانت أسرية أو تربوية أو اجتماعية.'],
        ['q' => 'هل يمكن الحجز لجلسة مع الدكتور طارق مباشرة؟', 'a' => 'نعم، يمكنك حجز جلسة هاتفية مع الدكتور طارق الحبيب مباشرة حسب توافر المواعيد. تواصل مع الفريق وسيؤكدون لك الموعد المتاح.'],
        ['q' => 'كم مدة الجلسة؟', 'a' => 'مدة الجلسة من 45 دقيقة إلى ساعة.'],
        ['q' => 'كم سعر الاستشارة؟', 'a' => 'الجلسة الفردية مع أخصائي ' . $price['specialist'] . ' د.ك. ومع أ.د. طارق الحبيب: الجلسة الأولى ' . $price['dr_tariq_first'] . ' د.ك، وجلسة المتابعة ' . $price['dr_tariq_follow_up'] . ' د.ك.'],
        ['q' => 'هل يمكن الحجز عن بعد (أونلاين)؟', 'a' => 'نعم، نوفر جلسات عن بعد لمن لا يستطيع الحضور الشخصي. تتم الجلسات عبر منصات تواصل مشفّرة وآمنة.'],
        ['q' => 'ما سياسة الإلغاء؟', 'a' => 'يمكن تأجيل الموعد دون أي رسوم قبل 24 ساعة على الأقل من موعده. لا يوجد استرجاع نقدي للمبالغ المدفوعة، ويمكنك استخدام المبلغ في أي خدمة أخرى داخل المركز.'],
        ['q' => 'هل تتوفر استشارات نفسية؟', 'a' => 'خدمة الاستشارات النفسية غير متاحة حاليًا، ويعمل المركز على تجهيزها وسيتم الإعلان عن موعد إطلاقها قريبًا.'],
    ] : [
        ['q' => 'Which consultations are available now?', 'a' => 'The center currently offers marital, family, parenting and social consultations, and self-development sessions. Psychological consultations are not available yet and will be announced when they open.'],
        ['q' => 'How do I know which consultation suits me?', 'a' => 'Contact the appointments team and describe what you need briefly; they will help you choose the right service from those available.'],
        ['q' => 'What makes your consultations different?', 'a' => 'Motmaena\'s specialists combine academic expertise with real-world application. The session is built around your specific situation — not generic advice, but a personalized action plan made for you.'],
        ['q' => 'Is what I share kept private?', 'a' => 'The center handles the information you share privately, according to its approved policies and procedures.'],
        ['q' => 'How is the right specialist chosen for me?', 'a' => 'When you contact us via WhatsApp, the team will ask a few simple questions and then guide you to the specialist best suited for your consultation type — family, educational, or social.'],
        ['q' => 'Can I book directly with Dr. Tariq?', 'a' => 'Yes, you can book a phone session with Dr. Tariq Al-Habib directly, based on appointment availability. Contact the team and they\'ll confirm an available time.'],
        ['q' => 'How long is a session?', 'a' => 'A session lasts from 45 minutes to an hour.'],
        ['q' => 'How much is a consultation?', 'a' => 'A one-to-one session with a specialist is ' . $price['specialist'] . ' KWD. With Prof. Dr. Tariq Al-Habib: ' . $price['dr_tariq_first'] . ' KWD for the first session and ' . $price['dr_tariq_follow_up'] . ' KWD for a follow-up.'],
        ['q' => 'Can I book online (remote sessions)?', 'a' => 'Yes, we offer remote sessions for those who cannot attend in person. Sessions are conducted via secure, encrypted communication platforms.'],
        ['q' => 'What is the cancellation policy?', 'a' => 'Appointments can be rescheduled free of charge at least 24 hours in advance. Payments are not refunded in cash, but you can use the amount for any other service at the Center.'],
        ['q' => 'Are psychological consultations available?', 'a' => 'Psychological consultations are not available yet; the center is preparing the service and will announce its launch date soon.'],
    ];

    $terms = [
        ['calendar', $t('المواعيد والحجز', 'Appointments & Booking'), $t('يُعدّ الموعد محجوزاً فور تأكيده من الفريق. الإلغاء قبل 24 ساعة مجاني.', 'Appointment is confirmed upon team confirmation. Cancellation 24+ hours ahead is free of charge.')],
        ['clock',    $t('التأخر والغياب', 'Late Arrival & No-Shows'), $t('التأخر أكثر من 15 دقيقة يُعدّ غياباً. تُطبَّق رسوم الموعد الكامل.', 'Arriving 15+ minutes late is considered a no-show. Full session fee applies.')],
        ['lock',     $t('السرية التامة', 'Full Confidentiality'), $t('جميع محتويات الجلسات سرية بالكامل ولا تُشارك مع أي طرف.', 'All session content is fully confidential and never shared with any party.')],
        ['people',   $t('أدب التعامل', 'Respectful Conduct'), $t('يُرجى الالتزام بالاحترام المتبادل طوال الجلسة. يحق للأخصائي إنهاء الجلسة عند الإخلال بذلك.', 'Mutual respect is required throughout. The specialist reserves the right to end the session if violated.')],
        ['compass',  $t('نطاق الخدمة', 'Scope of Service'), $t('الاستشارات اجتماعية وتربوية بحتة. في حالة الحاجة لتدخل طبي يُحال المراجع للجهة المختصة.', 'Consultations are strictly social and educational. If medical intervention is needed, the client is referred appropriately.')],
        ['card',     $t('الدفع والاسترداد', 'Payment & Refunds'), $t('رسوم الجلسة غير قابلة للاسترداد بعد إجرائها. يمكن إعادة الجدولة بشروط محددة.', 'Session fees are non-refundable once conducted. Rescheduling is possible under specific conditions.')],
    ];

    $types = $isAr
        ? ['استشارة زوجية', 'استشارة أسرية', 'استشارة تربوية', 'استشارة اجتماعية', 'تطوير الذات', 'استشارة هاتفية مع د. طارق']
        : ['Marital Consultation', 'Family Consultation', 'Educational Consultation', 'Social Consultation', 'Self Development', 'Phone session with Dr. Tariq'];
    $typeLabels = ['استشارة هاتفية مع د. طارق' => 'استشارة هاتفية مع د. طارق الحبيب'];
    $countries = [
        ['965', $t('الكويت', 'Kuwait')], ['966', $t('السعودية', 'Saudi Arabia')], ['971', $t('الإمارات', 'UAE')], ['974', $t('قطر', 'Qatar')],
        ['973', $t('البحرين', 'Bahrain')], ['968', $t('عُمان', 'Oman')], ['962', $t('الأردن', 'Jordan')], ['20', $t('مصر', 'Egypt')],
        ['963', $t('سوريا', 'Syria')], ['961', $t('لبنان', 'Lebanon')],
    ];
@endphp

@section('content')
@include('partials.lx-styles')
<style>
    /* This page has its own floating button and booking bar */
    #global-float-wa { display: none !important; }
    .cs-float { position: fixed; bottom: 22px; inset-inline-end: 18px; z-index: 60; width: 54px; height: 54px; border-radius: 999px; background: #1f8f4e; color: #fff; display: flex; align-items: center; justify-content: center; box-shadow: 0 12px 28px -10px rgba(0,0,0,.45); transition: bottom .3s ease, transform .2s; }
    .cs-float:hover { transform: translateY(-2px); }
    .cs-float .lx-ico { stroke: #fff; width: 26px; height: 26px; }
    @media (max-width: 1023px) { body.mh-bar-on .cs-float { bottom: 92px; } }
    .cs-step { display: grid; grid-template-columns: 40px 1fr; gap: 16px; }
    .cs-step + .cs-step { margin-top: 26px; }
    .cs-num { width: 40px; height: 40px; border-radius: 999px; border: 1px solid var(--gold); color: var(--wine); font-weight: 800; display: flex; align-items: center; justify-content: center; }
    .dark .cs-num { color: var(--gold-l); }
    .cs-phone { display: grid; grid-template-columns: 9.5rem 1fr; gap: 10px; }
    @media (max-width: 400px) { .cs-phone { grid-template-columns: 7.8rem 1fr; } }
</style>

<div class="lx" dir="{{ $isAr ? 'rtl' : 'ltr' }}">

{{-- ═══════════════ HERO ═══════════════ --}}
<section class="lx-ivory" data-track-location="hero">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-20">
        <nav aria-label="{{ $t('مسار التنقل', 'Breadcrumb') }}" class="mb-8 text-sm font-semibold lx-muted">
            <a href="{{ route('home') }}" class="hover:underline underline-offset-4">{{ $t('الرئيسية', 'Home') }}</a>
            <span class="mx-2">/</span>
            <span aria-current="page" style="color: var(--ink)">{{ $t('الاستشارات', 'Consultations') }}</span>
        </nav>
        <div class="grid lg:grid-cols-12 gap-12 lg:gap-16 items-center">
            <div class="lg:col-span-7">
                <p class="lx-label mb-5">{{ $t('مركز مطمئنة · بإشراف أ.د. طارق الحبيب', 'Motmaena Center · supervised by Prof. Dr. Tariq Al-Habib') }}</p>
                {{-- The heading names the service and the place, as people search for it; the question stays as the opening line --}}
                <h1 class="lx-h1 mb-5">{{ $t('استشارات أسرية وتربوية واجتماعية في الكويت', 'Family, parenting & social consultations in Kuwait') }}</h1>
                <p class="lx-text text-lg mb-8 max-w-2xl"><strong style="color: var(--ink)">{{ $t('هل تبحث عن إجابات لمشكلة تؤرقك؟', 'Looking for answers to what\'s troubling you?') }}</strong> {{ $t('جلسة واحدة مع أخصائي قد تغيّر منظورك كليًا — احجز موعدك اليوم', 'One session with a specialist can completely change your perspective — book today') }}</p>
                <div id="hero-cta" class="flex flex-col sm:flex-row gap-3">
                    <a href="#book" class="lx-btn lx-btn-primary">{{ $t('احجز استشارتك', 'Book your consultation') }}</a>
                    <a href="{{ $waBook }}" target="_blank" rel="noopener" class="lx-btn lx-btn-outline">@include('partials.lx-icon', ['i' => 'whatsapp', 'class' => '!w-5 !h-5']){{ $t('اسألنا على الواتساب', 'Ask us on WhatsApp') }}</a>
                </div>
            </div>
            <div class="lg:col-span-5">
                <div class="lx-photo max-w-[320px] sm:max-w-[420px] mx-auto">
                    <img src="{{ asset('photos/center-reception.webp') }}" alt="{{ $t('استقبال مركز مطمئنة', 'Motmaena Center reception') }}" width="1800" height="1200" class="aspect-[3/2]" fetchpriority="high">
                </div>
            </div>
        </div>
    </div>

    {{-- What to expect --}}
    <div class="border-t" style="border-color: var(--line)">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-7 grid grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach([
                ['card', $t('جلسة فردية ' . $price['specialist'] . ' د.ك', 'One-to-one session ' . $price['specialist'] . ' KWD'), $t('مع أخصائي · ' . config('center.session_length.ar'), 'With a specialist · ' . config('center.session_length.en'))],
                ['clock', $t('السبت – الخميس', 'Saturday – Thursday'), $t('9 صباحًا – 9 مساءً · الجمعة مغلق', '9 am – 9 pm · closed Friday')],
                ['building', $t('في المركز', 'At the center'), $t('برج أحمد، بجوار المستشفى الأميري', 'Burj Ahmed, near Al-Amiri Hospital')],
                ['lock', $t('خصوصية معلوماتك', 'Your privacy'), $t('وفق سياسات المركز وإجراءاته', 'Under the center policies')],
            ] as [$icon, $title, $sub])
                <div class="flex items-start gap-3">
                    @include('partials.lx-icon', ['i' => $icon, 'class' => 'mt-0.5'])
                    <div><p class="font-bold text-sm" style="color: var(--ink)">{{ $title }}</p><p class="text-xs lx-muted font-semibold mt-0.5">{{ $sub }}</p></div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════ IS THIS YOU? ═══════════════ --}}
<section class="lx-paper lx-section">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mb-12">
            <p class="lx-label mb-3">{{ $t('متى تحتاج استشارة', 'When to ask for help') }}</p>
            <h2 class="lx-h2 mb-3">{{ $t('هل تمرّ بأيٍّ من هذا؟', 'Are you going through this?') }}</h2>
            <p class="lx-text">{{ $t('كثيرون يعيشون نفس المشاعر — وكثيرون وجدوا المخرج بعد جلسة واحدة', 'Many people share the same feelings — and many found the way out after just one session') }}</p>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($pains as $i => [$icon, $title, $desc])
                <div class="lx-card p-6 flex gap-4">
                    <span class="lx-icon-ring">@include('partials.lx-icon', ['i' => $icon])</span>
                    <div>
                        <h3 class="font-extrabold mb-1.5" style="color: var(--ink)">{{ $title }}</h3>
                        <p class="text-sm lx-muted font-semibold leading-relaxed">{{ $desc }}</p>
                        {{-- Related service: children's assessment and sessions --}}
                        @if($i === 1)
                            <a href="{{ route('sessions') }}" class="inline-block mt-3 text-sm lx-link">{{ $t('جلسات وتقييم الأطفال ←', "Children's sessions & assessment →") }}</a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        <p class="mt-10 font-bold text-lg" style="color: var(--ink)">
            {{ $t('إذا قرأت سطراً واحداً من هذا وشعرت أنه يصفك — فأنت في المكان الصحيح.', 'If even one line above describes you — you\'re in the right place.') }}
            <a href="#book" class="lx-link whitespace-nowrap">{{ $t('احجز استشارتك', 'Book your consultation') }}</a>
        </p>
    </div>
</section>

{{-- ═══════════════ DR. TARIQ (request → center system) ═══════════════ --}}
@include('partials.dr-tariq-thursday')

{{-- Unconfirmed figures and quotes: hidden until the center confirms them (config/claims.php) --}}
@if(config('claims.show_unverified'))
<section class="lx-ivory lx-section">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 mb-14">
            @foreach([['4800', '+4,800', $t('استشارة منجزة', 'Consultations Completed')], ['97', '97%', $t('معدل الرضا', 'Satisfaction Rate')], ['12', '+12', $t('سنة لمركز مطمئنة', 'Years of Motmaena')], ['4', '4', $t('متخصصين معتمدين', 'Certified Specialists')]] as [$n, $shown, $l])
                <div><p class="text-3xl font-extrabold lx-wine" dir="ltr" data-target="{{ $n }}">{{ $shown }}</p><p class="text-sm lx-muted font-semibold mt-1">{{ $l }}</p></div>
            @endforeach
        </div>
        <h2 class="lx-h2 mb-8">{{ $t('ماذا قال من حجزوا قبلك؟', 'What did those who booked before you say?') }}</h2>
        <div class="grid md:grid-cols-3 gap-5">
            @foreach([
                [$t('من سنتين وأنا ما أقدر أتعامل مع المشاكل اللي بالبيت. بعد جلستين مع المستشار الأسري تغيّر كل شي — صار عندي أدوات فعلية أطبّقها كل يوم والحمدلله.', 'I was unable to handle household tensions for two years. After two sessions with the family advisor, everything changed — I now have real tools I apply daily.'), $t('محمد العنزي', 'Mohammed Al-Anzi')],
                [$t('كنت خايفة على تصرفات ولدي بالمدرسة وما أدري وين أبدأ. جلسة المرشد التربوي أعطتني خارطة طريق واضحة والحين أحس براحة بال ما توقعتها.', 'I was worried about my son\'s school behavior and didn\'t know where to start. The educational session gave me a clear roadmap and I now feel at peace.'), $t('فاطمة العتيبي', 'Fatima Al-Otaibi')],
                [$t('كان عندي قرار صعب يقلقني من زمان وما أدري وين أروح. جلست مع الدكتور طارق وطلعت بوضوح ما لقيته عند أي أحد ثاني. والله شكراً من القلب.', 'I was facing a difficult decision that changed my life. The session with Dr. Tariq gave me clarity I couldn\'t find anywhere else. Thank you from the heart.'), $t('عبدالله المطيري', 'Abdullah Al-Mutairi')],
            ] as [$quote, $who])
                <figure class="lx-card p-6"><p class="text-sm lx-muted mb-2">★★★★★</p><blockquote class="lx-text">{{ $quote }}</blockquote><figcaption class="mt-4 font-bold" style="color: var(--ink)">{{ $who }}</figcaption></figure>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ═══════════════ WHAT YOU LEAVE WITH ═══════════════ --}}
<section class="lx-ivory lx-section">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 grid lg:grid-cols-12 gap-10 lg:gap-16">
        <div class="lg:col-span-4">
            <p class="lx-label mb-3">{{ $t('بعد الجلسة', 'After the session') }}</p>
            <h2 class="lx-h2 mb-3">{{ $t('ماذا ستحقق من هذه الجلسة؟', 'What will you achieve from this session?') }}</h2>
        </div>
        <div class="lg:col-span-8 grid sm:grid-cols-2 gap-x-10 gap-y-8">
            @foreach($outcomes as [$icon, $title, $desc])
                <div class="flex gap-4">
                    @include('partials.lx-icon', ['i' => $icon, 'class' => 'mt-1'])
                    <div><h3 class="font-extrabold mb-1.5" style="color: var(--ink)">{{ $title }}</h3><p class="lx-text text-[15px]">{{ $desc }}</p></div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════ TEAM ═══════════════ --}}
<section class="lx-paper lx-section">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mb-12">
            <p class="lx-label mb-3">{{ $t('من يستقبلك', 'Who you will meet') }}</p>
            <h2 class="lx-h2 mb-3">{{ $t('فريق الأخصائيين', 'Our Specialists') }}</h2>
            <p class="lx-text">{{ $t('أخصائيون في مجالاتهم', 'Specialists in their fields') }}</p>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="lx-card p-6">
                <img src="{{ asset('courses-img/dr-tariq-thumb.webp') }}" alt="" width="256" height="256" loading="lazy" decoding="async" class="w-14 h-14 rounded-full object-cover object-top mb-5" style="border: 1px solid var(--line)">
                <h3 class="lx-h3 mb-1">{{ $t('أ.د. طارق الحبيب', 'Prof. Tariq Al-Habib') }}</h3>
                <p class="text-sm font-bold lx-wine mb-3">{{ config('doctor.title.' . $lang) }}</p>
                {{-- The years of experience are not confirmed yet (config/claims.php); the availability note stays --}}
                @if(config('claims.show_unverified'))
                    <p class="text-sm lx-muted font-semibold leading-relaxed">{{ $t('خبرة تزيد على 30 سنة في الطب النفسي والإرشاد الأسري — جلسات هاتفية حسب توافر المواعيد', '30+ years in psychiatry and family counselling — phone sessions subject to availability') }}</p>
                @else
                    <p class="text-sm lx-muted font-semibold leading-relaxed">{{ $t('جلسات هاتفية حسب توافر المواعيد', 'Phone sessions subject to availability') }}</p>
                @endif
            </div>
            @foreach($team as [$icon, $title, $spec, $desc])
                <div class="lx-card p-6">
                    <span class="lx-icon-ring !w-14 !h-14 mb-5">@include('partials.lx-icon', ['i' => $icon])</span>
                    <h3 class="lx-h3 mb-1">{{ $title }}</h3>
                    @if($spec)<p class="text-sm font-bold lx-wine mb-3">{{ $spec }}</p>@endif
                    <p class="text-sm lx-muted font-semibold leading-relaxed {{ $spec ? '' : 'mt-3' }}">{{ $desc }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════ BOOKING: steps + the form, side by side ═══════════════ --}}
<section id="book" class="lx-ivory lx-section scroll-mt-20" data-track-location="steps">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 grid lg:grid-cols-12 gap-12 lg:gap-16 items-start">
        <div class="lg:col-span-5">
            <p class="lx-label mb-3">{{ $t('الحجز', 'Booking') }}</p>
            <h2 class="lx-h2 mb-8">{{ $t('كيف تحجز في 3 خطوات؟', 'How to Book in 3 Steps?') }}</h2>
            @foreach($steps as $i => [$title, $desc])
                <div class="cs-step">
                    <span class="cs-num">{{ $i + 1 }}</span>
                    <div><h3 class="font-extrabold mb-1" style="color: var(--ink)">{{ $title }}</h3><p class="lx-text text-[15px]">{{ $desc }}</p></div>
                </div>
            @endforeach
            {{-- Prices and hours, as given by the center (config/center.php) --}}
            <div class="lx-card mt-10 px-5">
                <div class="flex items-center justify-between gap-4 py-4">
                    <span class="font-bold" style="color: var(--ink)">{{ $t('جلسة فردية مع أخصائي', 'One-to-one session with a specialist') }}</span>
                    <span class="font-extrabold whitespace-nowrap" style="color: var(--ink)">{{ $price['specialist'] }} <small class="lx-muted">{{ $t('د.ك', 'KWD') }}</small></span>
                </div>
                <div class="flex items-center justify-between gap-4 py-4 border-t" style="border-color: var(--line)">
                    <span class="font-bold" style="color: var(--ink)">{{ $t('مع أ.د. طارق الحبيب', 'With Prof. Dr. Tariq Al-Habib') }}<small class="block text-xs lx-muted font-semibold mt-0.5">{{ $t('جلسة المتابعة ' . $price['dr_tariq_follow_up'] . ' د.ك', 'Follow-up session ' . $price['dr_tariq_follow_up'] . ' KWD') }}</small></span>
                    <span class="font-extrabold whitespace-nowrap text-end" style="color: var(--ink)">{{ $price['dr_tariq_first'] }} <small class="lx-muted">{{ $t('د.ك', 'KWD') }}</small><small class="block text-xs lx-muted font-semibold">{{ $t('الجلسة الأولى', 'first session') }}</small></span>
                </div>
                <div class="flex items-start gap-3 py-4 border-t text-sm font-semibold" style="border-color: var(--line)">
                    @include('partials.lx-icon', ['i' => 'clock', 'class' => '!w-5 !h-5 mt-0.5'])
                    <span>{{ config('center.hours.' . $lang) }}<span class="block lx-muted mt-0.5">{{ $t('مدة الجلسة ', 'Session length: ') }}{{ config('center.session_length.' . $lang) }}</span></span>
                </div>
            </div>
            <div class="lx-notice p-5 mt-10 flex gap-3">
                @include('partials.lx-icon', ['i' => 'alert', 'class' => 'mt-0.5'])
                <p class="text-sm font-semibold leading-relaxed">
                    <strong style="color: var(--ink)">{{ $t('إشعار مهم:', 'Important notice:') }}</strong>
                    {{ $t('الخدمات المقدمة هنا هي استشارات اجتماعية وتربوية وأسرية فقط وليست تشخيصاً طبياً أو علاجاً أو تدخلاً إكلينيكياً. لا تُغني عن مراجعة الطبيب أو الأخصائي الطبي عند الحاجة.', 'Services provided here are social, educational, and family consultations only — not medical diagnosis, psychological treatment, or clinical intervention. They do not replace consulting a physician or medical specialist when needed.') }}
                </p>
            </div>
        </div>

        <div class="lg:col-span-7">
            <div class="lx-card p-6 sm:p-9 shadow-[0_30px_60px_-45px_rgba(31,26,23,.45)]">
                <h3 class="lx-h3 mb-1">{{ $t('أدخل بياناتك لتأكيد الحجز', 'Enter your details to confirm booking') }}</h3>
                <p class="text-sm lx-muted font-semibold mb-7">{{ $t('نرسل طلبك للفريق ونفتح لك الواتساب لإكمال الحجز.', 'We pass your request to the team and open WhatsApp to finish booking.') }}</p>

                <form class="space-y-5" method="POST" action="{{ route('consultations.book') }}" id="booking-form">
                    @csrf
                    <div>
                        <label for="phone-number" class="block text-sm font-bold mb-2" style="color: var(--ink)">{{ $t('رقم هاتفك (واتساب)', 'Your WhatsApp number') }}</label>
                        <div class="cs-phone" dir="ltr">
                            <select id="country-code" class="lx-input lx-select" onchange="updatePhoneField()" aria-label="{{ $t('رمز الدولة', 'Country code') }}">
                                @foreach($countries as [$code, $name])
                                    <option value="{{ $code }}" @selected($code === '965')>+{{ $code }} {{ $name }}</option>
                                @endforeach
                                <option value="other">{{ $t('أخرى', 'Other') }}</option>
                            </select>
                            <input type="tel" id="phone-number" class="lx-input" inputmode="tel" autocomplete="tel-national" placeholder="{{ $t('رقم الهاتف', 'Phone number') }}" required oninput="updatePhoneField()">
                        </div>
                        <input type="hidden" name="phone" id="phone-hidden">
                    </div>

                    <div>
                        <label for="problem-type" class="block text-sm font-bold mb-2" style="color: var(--ink)">{{ $t('نوع الاستشارة', 'Consultation type') }}</label>
                        <select name="problem_type" id="problem-type" class="lx-input lx-select" required>
                            <option value="" disabled selected>{{ $t('— اختر —', '— Select —') }}</option>
                            @foreach($types as $type)
                                <option value="{{ $type }}">{{ $typeLabels[$type] ?? $type }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="booking-notes" class="block text-sm font-bold mb-2" style="color: var(--ink)">{{ $t('شاركنا شي عن وضعك', 'Share something about your situation') }} <span class="lx-muted font-semibold">({{ $t('اختياري', 'optional') }})</span></label>
                        <textarea name="notes" id="booking-notes" rows="3" class="lx-input" placeholder="{{ $t('مثال: عندي مشكلة في التعامل مع ابني...', 'e.g. I\'m struggling with a family situation...') }}"></textarea>
                    </div>

                    <label class="lx-check">
                        <input type="checkbox" id="consent-check" required>
                        <span>{{ $t('أقرّ بأنني اطلعت على', 'I have read the') }} <a href="#terms" class="lx-link">{{ $t('شروط الخدمة', 'terms of service') }}</a> {{ $t('وأفهم أن الخدمة استشارات اجتماعية وتربوية، وليست علاجاً طبياً، وأوافق على سياسة المركز.', 'and understand the service is social & educational consultation, not medical treatment. I agree to the center\'s policy.') }}</span>
                    </label>

                    <button type="submit" class="lx-btn lx-btn-primary w-full">@include('partials.lx-icon', ['i' => 'whatsapp', 'class' => '!w-5 !h-5 !stroke-white']){{ $t('تأكيد وإرسال عبر واتساب', 'Confirm & Send via WhatsApp') }}</button>
                </form>

                <p class="text-sm font-semibold mt-6 text-center"><a href="https://wa.me/{{ $site['whatsapp'] }}?text={{ rawurlencode($t('مرحبًا مركز مطمئنة، أرغب في معرفة نوع الاستشارة المناسبة لاحتياجي.', 'Hello Motmaena Center, I would like to know which consultation suits my needs.')) }}" target="_blank" rel="noopener" class="lx-link">{{ $t('لست متأكدًا؟ ساعدني في اختيار الاستشارة', 'Not sure? Help me choose a consultation') }}</a></p>
                <p class="text-sm lx-muted font-semibold mt-5 text-center">
                    {{ $t('تفضّل الاتصال؟', 'Prefer to call?') }}
                    <a href="tel:+{{ $site['whatsapp'] }}" class="lx-link" dir="ltr">{{ $waPretty }}</a>
                </p>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════ QUESTIONS ═══════════════ --}}
<section id="faq" class="lx-paper lx-section scroll-mt-20">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 grid lg:grid-cols-12 gap-10 lg:gap-16">
        <div class="lg:col-span-4">
            <p class="lx-label mb-3">{{ $t('أسئلة شائعة', 'Questions') }}</p>
            <h2 class="lx-h2">{{ $t('الأسئلة الأكثر شيوعاً', 'Frequently Asked Questions') }}</h2>
        </div>
        <div class="lg:col-span-8 border-t" style="border-color: var(--line)">
            @foreach($faqs as $i => $faq)
                <details class="lx-faq" @if($i === 0) open @endif>
                    <summary>{{ $faq['q'] }}</summary>
                    <p class="lx-text">{{ $faq['a'] }}</p>
                </details>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════ TERMS ═══════════════ --}}
<section id="terms" class="lx-ivory lx-section scroll-mt-20">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mb-10">
            <p class="lx-label mb-3">{{ $t('قبل الحجز', 'Before you book') }}</p>
            <h2 class="lx-h2">{{ $t('الشروط وسياسة الخدمة', 'Terms & Service Policy') }}</h2>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-x-10 gap-y-8">
            @foreach($terms as [$icon, $title, $desc])
                <div class="flex gap-4">
                    @include('partials.lx-icon', ['i' => $icon, 'class' => 'mt-1'])
                    <div><h3 class="font-extrabold mb-1" style="color: var(--ink)">{{ $title }}</h3><p class="text-sm lx-muted font-semibold leading-relaxed">{{ $desc }}</p></div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════ CLOSING CALL TO ACTION ═══════════════ --}}
<section id="final-cta" class="lx-ink" data-track-location="final-cta">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20 text-center max-w-3xl">
        <p class="lx-label mb-4 justify-center" style="color: #d9c4a0">{{ $t('المواعيد محدودة', 'Limited appointments') }}</p>
        <h2 class="text-3xl sm:text-4xl font-extrabold text-white leading-snug mb-4">{{ $t('احجز استشارتك الآن', 'Book your consultation now') }}</h2>
        {{-- "Thousands" of clients is not confirmed yet (config/claims.php) --}}
        @if(config('claims.show_unverified'))
            <p class="text-white/70 font-semibold mb-2">{{ $t('انضم إلى آلاف الأشخاص الذين وجدوا وضوحاً وتغييراً حقيقياً في حياتهم بعد جلسة واحدة مع أخصائيينا', 'Join thousands who found real clarity and change in their lives after just one session with our specialists') }}</p>
        @endif
        <p class="text-white/60 font-semibold mb-8">{{ $t('نتعامل مع معلوماتك بخصوصية وفق سياسات المركز', 'We handle your information privately, under the center policies') }}</p>
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ $waBook }}" target="_blank" rel="noopener" class="lx-btn lx-btn-light">@include('partials.lx-icon', ['i' => 'whatsapp', 'class' => '!w-5 !h-5']){{ $t('احجز عبر واتساب', 'Book via WhatsApp') }}</a>
            <a href="tel:+{{ $site['whatsapp'] }}" class="lx-btn border border-white/30 text-white hover:bg-white/10">@include('partials.lx-icon', ['i' => 'phone', 'class' => '!w-5 !h-5 !stroke-white']){{ $t('اتصل بنا مباشرة', 'Call Us Directly') }}</a>
        </div>
    </div>
</section>

{{-- ═══════════════ STICKY BOOKING BAR (phones) ═══════════════ --}}
<div id="mh-bar" data-track-location="sticky-bar" class="mh-bar lg:hidden fixed inset-x-0 bottom-0 z-[70] lx-paper border-t shadow-[0_-12px_30px_-18px_rgba(0,0,0,.35)]" style="border-color: var(--line); padding-bottom: max(12px, env(safe-area-inset-bottom))">
    <div class="container mx-auto px-4 pt-3 flex items-center gap-3">
        <div class="min-w-0 flex-1">
            <p class="font-extrabold text-sm truncate" style="color: var(--ink)">{{ $t('احجز استشارتك الآن', 'Book Your Consultation Now') }}</p>
            <p class="text-xs font-semibold lx-muted truncate">{{ $t('زوجية · أسرية · تربوية · اجتماعية', 'Marital · family · parenting · social') }}</p>
        </div>
        <a href="{{ $waBook }}" target="_blank" rel="noopener" class="lx-btn lx-btn-outline !py-3 !px-3.5" aria-label="{{ $t('واتساب', 'WhatsApp') }}">@include('partials.lx-icon', ['i' => 'whatsapp', 'class' => '!w-5 !h-5'])</a>
        <a href="#book" class="lx-btn lx-btn-primary !py-3 !px-5 text-sm">{{ $t('احجز الآن', 'Book Now') }}</a>
    </div>
</div>

{{-- Floating WhatsApp --}}
<a href="{{ $waBook }}" target="_blank" rel="noopener" class="cs-float" id="float-wa" data-track-location="floating" aria-label="{{ $t('احجز عبر واتساب', 'Book via WhatsApp') }}">@include('partials.lx-icon', ['i' => 'whatsapp'])</a>

</div>

<script>
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

/* ── Booking form submit — saves to DB in background, opens WhatsApp immediately ── */
(function () {
    var form = document.getElementById('booking-form');
    if (!form) return;

    form.addEventListener('submit', function (e) {
    e.preventDefault();
    updatePhoneField();

    var fd   = new FormData(form);
    var phone = fd.get('phone') || '';
    var type  = fd.get('problem_type') || '';
    var notes = fd.get('notes') || '';

    // Save to DB silently in the background
    // keepalive lets the save finish even though the page leaves for WhatsApp right after
    fetch(form.action, {
      method: 'POST',
      keepalive: true,
      headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
      body: fd
    }).catch(function(){});
    // Counted as a lead only: never send the consultation type or notes to analytics
    window.trackEvent && trackEvent('Lead', { content_name: 'consultation' });

    // Open WhatsApp immediately without waiting
    var star = String.fromCodePoint(0x1F31F);
    var chk  = String.fromCodePoint(0x2705);
    var pin  = String.fromCodePoint(0x1F4DD);
    var msg = star + ' مرحبًا مركز مطمئنة\nأريد حجز استشارة\n\n'
            + chk + ' *رقم التواصل:* ' + phone + '\n'
            + chk + ' *نوع الاستشارة:* ' + type;
    if (notes.trim()) {
      msg += '\n' + pin + ' *ملاحظات:* ' + notes;
    }

    window.location.href = 'https://wa.me/{{ $site['whatsapp'] }}?text=' + encodeURIComponent(msg);
    });
})();

/* ── Sticky bar: after the hero buttons, until the closing call to action ── */
(function () {
    var bar = document.getElementById('mh-bar'), hero = document.getElementById('hero-cta'), book = document.getElementById('book'), end = document.getElementById('final-cta');
    if (!bar || !hero) return;
    var ticking = false;
    function inView(el) { if (!el) return false; var r = el.getBoundingClientRect(); return r.top < window.innerHeight && r.bottom > 0; }
    function update() {
        ticking = false;
        var on = hero.getBoundingClientRect().bottom < 0 && !inView(book) && !inView(end);
        bar.classList.toggle('on', on);
        document.body.classList.toggle('mh-bar-on', on);
    }
    window.addEventListener('scroll', function () { if (!ticking) { ticking = true; requestAnimationFrame(update); } }, { passive: true });
    update();
})();
</script>

@endsection
