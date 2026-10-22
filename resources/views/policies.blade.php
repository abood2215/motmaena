@extends('layouts.app')

@php
    $isAr = app()->getLocale() == 'ar';

    // [heading, [paragraphs]] per section — Arabic / English
    $sections = [
        'terms' => [
            'title' => $isAr ? 'الشروط والأحكام' : 'Terms & Conditions',
            'items' => $isAr ? [
                ['عن المركز', ['مركز مطمئنة للإرشاد الاجتماعي والتربوي وتنمية المهارات الحياتية، الكويت – برج أحمد – بجوار المستشفى الأميري. باستخدامك لهذا الموقع أو تسجيلك في أي من خدماتنا فإنك توافق على هذه الشروط.']],
                ['طبيعة الخدمات', ['يقدم المركز دورات تدريبية وجلسات واستشارات اجتماعية وتربوية وتنمية مهارات حياتية. هذه الخدمات تعليمية وإرشادية، ولا تُعد بديلاً عن التشخيص أو العلاج الطبي.']],
                ['الأسعار والدفع', ['جميع الأسعار المعروضة بالدينار الكويتي (د.ك). يتم الدفع الإلكتروني عبر بوابة ماي فاتورة (كي نت، فيزا، ماستركارد، Apple Pay)، ولا يحتفظ المركز ببيانات بطاقتك. يُعد التسجيل مؤكداً بعد اكتمال الدفع بنجاح.', 'أكواد الخصم تُطبّق حسب شروط كل كود (المدة وعدد مرات الاستخدام)، ولا يمكن استبدالها بمبالغ نقدية.']],
                ['الحضور والشهادات', ['يلتزم المتدرب بالحضور في الموعد المحدد. تُمنح الشهادة وفق الشروط المعلنة لكل دورة.']],
                ['حقوق الملكية', ['جميع المواد والمحتوى المقدم في الدورات ملك للمركز، ولا يجوز تصويرها أو نسخها أو إعادة نشرها دون إذن كتابي.']],
                ['تعديل الشروط', ['يحق للمركز تعديل هذه الشروط أو مواعيد الدورات عند الحاجة، مع إبلاغ المسجّلين بأي تغيير يخص تسجيلهم. تخضع هذه الشروط لقوانين دولة الكويت.']],
            ] : [
                ['About us', ['Motmaena Center for social & educational guidance and life skills, Kuwait – Burj Ahmed – near Al-Amiri Hospital. By using this website or registering for any of our services you agree to these terms.']],
                ['Our services', ['We offer training courses, sessions and social & educational consultations. These services are educational and advisory, and are not a substitute for medical diagnosis or treatment.']],
                ['Prices & payment', ['All prices are in Kuwaiti Dinar (KWD). Online payment is processed by MyFatoorah (KNET, Visa, Mastercard, Apple Pay); we do not store your card details. A registration is confirmed once payment succeeds.', 'Discount codes apply according to each code\'s conditions (validity and number of uses) and cannot be exchanged for cash.']],
                ['Attendance & certificates', ['Trainees are expected to attend on the scheduled date. Certificates are issued according to the conditions announced for each course.']],
                ['Intellectual property', ['All course materials belong to the Center and may not be recorded, copied or republished without written permission.']],
                ['Changes', ['The Center may update these terms or course schedules when needed and will inform registrants of any change affecting them. These terms are governed by the laws of the State of Kuwait.']],
            ],
        ],
        'refund' => [
            'title' => $isAr ? 'سياسة الإلغاء' : 'Cancellation Policy',
            'items' => $isAr ? [
                ['لا يوجد استرجاع نقدي', ['المبالغ المدفوعة غير قابلة للاسترجاع النقدي، ويمكنك بدلاً من ذلك استخدام كامل المبلغ في أي خدمة أخرى داخل المركز (دورة، جلسة، استشارة، أو باقة).']],
                ['إذا لم تتمكن من الحضور', ['يبقى المبلغ رصيداً لك تستخدمه في أي خدمة أخرى داخل المركز، حتى لو لم تتمكن من إبلاغنا مسبقاً. نرجو إبلاغنا متى أمكن لنحجز مقعدك لشخص آخر.']],
                ['إلغاء الدورة من قبل المركز', ['إذا ألغى المركز الدورة أو غيّر موعدها، يمكنك اختيار التحويل إلى الموعد الجديد أو استخدام المبلغ في أي خدمة أخرى داخل المركز.']],
                ['الجلسات والاستشارات', ['يمكن تأجيل الموعد دون رسوم قبل 24 ساعة على الأقل من موعده.']],
                ['طريقة الطلب', ['تواصل معنا عبر واتساب على الرقم +965 5566 5161 مع ذكر رقم التسجيل، وسنساعدك في اختيار الخدمة البديلة.']],
            ] : [
                ['No cash refunds', ['Payments are non-refundable. Instead, you can use the full amount for any other service at the Center (a course, session, consultation or package).']],
                ['If you cannot attend', ['The amount stays as credit for any other service at the Center, even if you could not let us know in advance. Please tell us when you can, so we can offer your seat to someone else.']],
                ['Course cancelled by the Center', ['If the Center cancels or reschedules a course, you can move to the new date or use the amount for any other service at the Center.']],
                ['Sessions & consultations', ['Appointments can be rescheduled free of charge at least 24 hours in advance.']],
                ['How to request', ['Contact us on WhatsApp at +965 5566 5161 with your registration number and we will help you choose an alternative service.']],
            ],
        ],
        'privacy' => [
            'title' => $isAr ? 'سياسة الخصوصية' : 'Privacy Policy',
            'items' => $isAr ? [
                ['البيانات التي نجمعها', ['عند التسجيل أو الحجز نجمع: الاسم، رقم الهاتف، البريد الإلكتروني (اختياري)، والملاحظات التي تكتبها. بيانات البطاقة البنكية تُدخل في صفحة ماي فاتورة الآمنة ولا تصل إلينا.']],
                ['استخدام البيانات', ['نستخدم بياناتك فقط لتأكيد تسجيلك، والتواصل معك بخصوص الدورة أو الموعد، وإصدار الشهادات.']],
                ['مشاركة البيانات', ['لا نبيع بياناتك ولا نشاركها مع أي طرف، باستثناء بوابة الدفع (ماي فاتورة) بالقدر اللازم لإتمام الدفع، أو إذا طلبتها جهة رسمية وفق القانون.']],
                ['السرية', ['محتوى الجلسات والاستشارات سري تماماً ولا يُشارك مع أي جهة.']],
                ['حقوقك', ['يمكنك طلب الاطلاع على بياناتك أو تعديلها أو حذفها في أي وقت عبر التواصل معنا على واتساب.']],
            ] : [
                ['Data we collect', ['When you register or book we collect your name, phone number, email (optional) and any notes you write. Card details are entered on MyFatoorah\'s secure page and never reach us.']],
                ['How we use it', ['Only to confirm your registration, contact you about your course or appointment, and issue certificates.']],
                ['Sharing', ['We do not sell or share your data, except with the payment gateway (MyFatoorah) as needed to process payment, or when legally required by an official authority.']],
                ['Confidentiality', ['Everything discussed in sessions and consultations is fully confidential.']],
                ['Your rights', ['You can ask to see, correct or delete your data at any time by contacting us on WhatsApp.']],
            ],
        ],
    ];
@endphp

@section('title', ($isAr ? 'الشروط والسياسات' : 'Terms & Policies') . ' - ' . __('Motmaena Center'))

@section('content')
<section class="py-12 sm:py-16 bg-secondary dark:bg-dark-surface border-b border-[var(--border-color)]">
    <div class="container mx-auto px-4 max-w-3xl text-center">
        <h1 class="text-2xl sm:text-4xl font-black text-gray-900 dark:text-white mb-3">{{ $isAr ? 'الشروط والسياسات' : 'Terms & Policies' }}</h1>
        <p class="text-sm text-[var(--muted-color)]">{{ $isAr ? 'آخر تحديث: أكتوبر 2026' : 'Last updated: October 2026' }}</p>
        <div class="flex flex-wrap justify-center gap-2 mt-6">
            @foreach($sections as $id => $section)
                <a href="#{{ $id }}" class="text-xs sm:text-sm font-bold px-4 py-2 rounded-full border border-primary/25 text-primary hover:bg-primary hover:text-white transition">{{ $section['title'] }}</a>
            @endforeach
        </div>
    </div>
</section>

<section class="py-10 sm:py-14 bg-white dark:bg-dark-bg">
    <div class="container mx-auto px-4 max-w-3xl space-y-12 {{ $isAr ? 'text-right' : 'text-left' }}">
        @foreach($sections as $id => $section)
        <div id="{{ $id }}" class="scroll-mt-28">
            <h2 class="text-xl sm:text-2xl font-black text-gray-900 dark:text-white mb-5 pb-3 border-b-2 border-primary/20">{{ $section['title'] }}</h2>
            <div class="space-y-5">
                @foreach($section['items'] as [$heading, $paragraphs])
                <div>
                    <h3 class="font-black text-primary mb-2">{{ $heading }}</h3>
                    @if(count($paragraphs) > 1)
                        <ul class="space-y-1.5 text-sm sm:text-[15px] leading-relaxed text-gray-700 dark:text-gray-300 list-disc {{ $isAr ? 'pr-5' : 'pl-5' }}">
                            @foreach($paragraphs as $p)<li>{{ $p }}</li>@endforeach
                        </ul>
                    @else
                        <p class="text-sm sm:text-[15px] leading-relaxed text-gray-700 dark:text-gray-300">{{ $paragraphs[0] }}</p>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
</section>
@endsection
