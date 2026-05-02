@extends('layouts.app')

@section('title', __('Packages') . ' - ' . __('Motmaena Center'))

@section('content')

{{-- ════════════════ HERO SECTION ════════════════ --}}
<section class="relative py-12 sm:py-20 bg-secondary dark:bg-dark-surface overflow-hidden border-b border-gray-100 dark:border-dark-border">
    {{-- Background Orbs --}}
    <div class="absolute top-0 {{ app()->getLocale() == 'ar' ? 'right-0' : 'left-0' }} w-1/2 h-full bg-gradient-to-b from-primary/5 to-transparent pointer-events-none"></div>
    
    <div class="container mx-auto px-4 relative z-10 text-center">
        <div class="inline-flex items-center gap-2 bg-white dark:bg-dark-border px-4 py-2 rounded-full shadow-sm mb-6 border border-primary/10 reveal">
            <span class="w-2 h-2 bg-primary rounded-full animate-pulse shrink-0"></span>
            <span class="text-primary font-bold text-xs uppercase tracking-widest">{{ app()->getLocale() == 'ar' ? 'باقات متكاملة' : 'Integrated Packages' }}</span>
        </div>
        
        <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold text-gray-900 dark:text-white mb-6 reveal">
            {{ app()->getLocale() == 'ar' ? 'باقات متخصصة لدعم طفلك' : 'Specialized Packages for Your Child' }}
        </h1>
        
        <p class="text-sm sm:text-base lg:text-lg text-[var(--muted-color)] max-w-2xl mx-auto leading-relaxed reveal">
            {{ app()->getLocale() == 'ar' 
                ? 'برامج تنموية متكاملة تشمل دعم السلوك والمهارات والنمو الشامل عند الأطفال بأقصى معايير الجودة.' 
                : 'Comprehensive developmental and support programs covering behavior, skills, and holistic growth for children at the highest quality standards.' }}
        </p>
    </div>
</section>

{{-- ════════════════ CHILDREN SPECIALISED PACKAGES SECTION ════════════════ --}}
<section id="packages-section" class="py-12 sm:py-20 md:py-28 bg-white dark:bg-dark-bg relative overflow-hidden">

    {{-- Dot-grid pattern --}}
    <div class="absolute inset-0 pointer-events-none opacity-[0.035] dark:opacity-[0.02]" style="background-image: radial-gradient(#b04141 1px, transparent 1px); background-size: 26px 26px;"></div>

    {{-- Ambient glows --}}
    <div class="absolute top-1/4 -right-32 w-[600px] h-[600px] bg-primary/5 rounded-full blur-[200px] pointer-events-none"></div>
    <div class="absolute bottom-1/4 -left-32 w-[500px] h-[500px] bg-primary/4 rounded-full blur-[180px] pointer-events-none"></div>

    <div class="container mx-auto px-4 relative z-10">

        {{-- ─── Packages Grid ─── --}}
        @php
            $pkgColors = [
                ['g' => 'linear-gradient(135deg,#0ea5e9,#0284c7)', 'sh' => 'rgba(14,165,233,.4)',  'hex' => '#0ea5e9'],
                ['g' => 'linear-gradient(135deg,#8b5cf6,#7c3aed)', 'sh' => 'rgba(139,92,246,.4)', 'hex' => '#8b5cf6'],
                ['g' => 'linear-gradient(135deg,#f59e0b,#d97706)', 'sh' => 'rgba(245,158,11,.4)', 'hex' => '#f59e0b'],
                ['g' => 'linear-gradient(135deg,#10b981,#059669)', 'sh' => 'rgba(16,185,129,.4)',  'hex' => '#10b981'],
                ['g' => 'linear-gradient(135deg,#6366f1,#4f46e5)', 'sh' => 'rgba(99,102,241,.4)', 'hex' => '#6366f1'],
                ['g' => 'linear-gradient(135deg,#f97316,#ea580c)', 'sh' => 'rgba(249,115,22,.4)', 'hex' => '#f97316'],
                ['g' => 'linear-gradient(135deg,#ec4899,#db2777)', 'sh' => 'rgba(236,72,153,.4)', 'hex' => '#ec4899'],
                ['g' => 'linear-gradient(135deg,#b04141,#7f1d1d)', 'sh' => 'rgba(176,65,65,.4)',  'hex' => '#b04141'],
                ['g' => 'linear-gradient(135deg,#06b6d4,#0891b2)', 'sh' => 'rgba(6,182,212,.4)',  'hex' => '#06b6d4'],
                ['g' => 'linear-gradient(135deg,#22c55e,#16a34a)', 'sh' => 'rgba(34,197,94,.4)',  'hex' => '#22c55e'],
                ['g' => 'linear-gradient(135deg,#a855f7,#9333ea)', 'sh' => 'rgba(168,85,247,.4)', 'hex' => '#a855f7'],
                ['g' => 'linear-gradient(135deg,#14b8a6,#0d9488)', 'sh' => 'rgba(20,184,166,.4)', 'hex' => '#14b8a6'],
            ];

            $packages = [
                [
                    'title' => app()->getLocale() == 'ar' ? 'تنمية التواصل الاجتماعي' : 'Social Communication Development',
                    'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 4a2 2 0 114 0v1a2 2 0 01-2 2 2 2 0 01-2-2V4zm-3 8a3 3 0 01-3-3V7a3 3 0 013-3h.5a3 3 0 013 3v2a3 3 0 01-3 3H8zm10-5a3 3 0 00-3 3v2a3 3 0 003 3h.5a3 3 0 003-3V7a3 3 0 00-3-3H18zM6 20a1 1 0 01-1-1v-1a5 5 0 015-5h4a5 5 0 015 5v1a1 1 0 01-1 1H6z"/></svg>',
                    'tags'  => app()->getLocale() == 'ar'
                        ? ['تنمية التواصل اللفظي والبصري', 'تحسين المهارات الاجتماعية', 'دعم السلوك وتعديله']
                        : ['Verbal & Visual Communication', 'Social Skills Enhancement', 'Behavior Support & Modification'],
                    'symptoms' => app()->getLocale() == 'ar' ? [
                        ['category' => 'المهارات الاجتماعية', 'items' => [
                            'لا يستجيب لمناداة اسمه',
                            'لا يُكثر من الاتصال البصري المباشر',
                            'يرفض العناق أو ينكمش على نفسه',
                            'يبدو إنه لا يدرك مشاعر وأحاسيس الآخرين',
                            'يحب أن يلعب لوحده، يتوقع في عالمه الشخصي الخاص به',
                        ]],
                    ] : [
                        ['category' => 'Social Skills', 'items' => [
                            'Does not respond to name',
                            'Avoids direct eye contact',
                            'Rejects hugs or withdraws',
                            'Seems unaware of others\' feelings',
                            'Prefers solitary play in own world',
                        ]],
                    ],
                ],
                [
                    'title' => app()->getLocale() == 'ar' ? 'صعوبات التعلم' : 'Learning Disabilities',
                    'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>',
                    'tags'  => app()->getLocale() == 'ar'
                        ? ['تنمية مهارات القراءة والكتابة', 'تحسين الانتباه والتركيز', 'خطط تعليمية فردية مخصصة']
                        : ['Reading & Writing Skills', 'Attention & Focus Improvement', 'Personalized Learning Plans'],
                    'symptoms' => app()->getLocale() == 'ar' ? [
                        ['category' => 'مرحلة ما قبل المدرسة', 'items' => [
                            'صعوبة في نطق الكلمات وصعوبة في العثور على الكلمة الصحيحة',
                            'وجود صعوبة في تعلم الأبجدية والأرقام والألوان والأشكال وأيام الأسبوع',
                            'صعوبة في السيطرة على أقلام التلوين وأقلام الرصاص',
                            'صعوبة في التعامل مع الأزرار وصعوبة في ربط الحذاء',
                        ]],
                        ['category' => 'المرحلة العمرية من سن (4-9) سنوات', 'items' => [
                            'مشاكل في تعلم صلة الوصل بين الأصوات والكلمات',
                            'الخلط بين الكلمات الأساسية عند القراءة',
                            'أخطاء إملائية دائمة وتكرار الأخطاء',
                            'صعوبة في تعلم مهارات الحسابية الأساسية مثل الجمع والطرح',
                        ]],
                        ['category' => 'المرحلة العمرية من سن (9-15) سنة', 'items' => [
                            'صعوبة في القراءة والكتابة ومهارات الرياضيات',
                            'مشكلة في اختبارات الأسئلة المفتوحة',
                            'مشكلة في المناقشات أثناء الدروس وتجنب التعبير بصوت عالٍ',
                            'تهجئة نفس الكلمة بطريقتين من ورقة واحدة',
                        ]],
                    ] : [
                        ['category' => 'Pre-School Stage', 'items' => [
                            'Difficulty pronouncing words and finding the right word',
                            'Difficulty learning alphabet, numbers, colors, shapes, and days',
                            'Difficulty controlling crayons and pencils',
                            'Difficulty with buttons and tying shoes',
                        ]],
                        ['category' => 'Age 4-9 Years', 'items' => [
                            'Problems connecting sounds and words',
                            'Confusing basic words when reading',
                            'Persistent spelling errors',
                            'Difficulty with basic math like addition and subtraction',
                        ]],
                        ['category' => 'Age 9-15 Years', 'items' => [
                            'Difficulty with reading, writing, and math skills',
                            'Problems with open-ended test questions',
                            'Avoiding class discussions and speaking aloud',
                            'Spelling the same word two different ways on one page',
                        ]],
                    ],
                ],
                [
                    'title' => app()->getLocale() == 'ar' ? 'نقص الثقة بالنفس' : 'Lack of Confidence',
                    'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>',
                    'tags'  => app()->getLocale() == 'ar'
                        ? ['تعزيز الشخصية الإيجابية', 'رفع مستوى الثقة بالنفس', 'دعم مهارات التعبير الذاتي']
                        : ['Positive Personality Boost', 'Self-Confidence Raising', 'Self-Expression Skills'],
                    'symptoms' => app()->getLocale() == 'ar' ? [
                        ['category' => 'أسلوب التربية والبيئة المحيطة', 'items' => [
                            'أسلوب التربية القاسي أو الناقد المستمر',
                            'الحماية الزائدة والتدليل المفرط الذي يمنع الاستقلالية',
                            'الإهمال أو غياب التشجيع والتقدير',
                            'غياب النماذج الإيجابية في حياة الطفل',
                        ]],
                        ['category' => 'العوامل الاجتماعية والبيئية', 'items' => [
                            'التجارب الاجتماعية السلبية (التنمر، صعوبة تكوين الصداقات)',
                            'توقعات الأهل العالية جداً والضغط للوصول للكمال',
                            'التعرض للصدمات (الطلاق، الانتقال المتكرر)',
                        ]],
                    ] : [
                        ['category' => 'Parenting & Environment', 'items' => [
                            'Harsh or constant critical parenting style',
                            'Overprotection and excessive pampering preventing independence',
                            'Neglect or lack of encouragement and appreciation',
                            'Absence of positive role models in the child\'s life',
                        ]],
                        ['category' => 'Social & Environmental Factors', 'items' => [
                            'Negative social experiences (bullying, difficulty making friends)',
                            'Excessively high parental expectations and pressure for perfection',
                            'Exposure to trauma (divorce, frequent relocation)',
                        ]],
                    ],
                ],
                [
                    'title' => app()->getLocale() == 'ar' ? 'الذكاء وتنمية القدرات' : 'Intelligence & Abilities',
                    'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>',
                    'tags'  => app()->getLocale() == 'ar'
                        ? ['اختبارات الذكاء والكفاءات', 'برامج تنمية التفكير الإبداعي', 'مهارات حل المشكلات']
                        : ['IQ & Aptitude Assessments', 'Creative Thinking Programs', 'Problem Solving Skills'],
                    'symptoms' => app()->getLocale() == 'ar' ? [
                        ['category' => 'أسباب تراجع الأداء الذهني', 'items' => [
                            'سوء التغذية (نقص الحديد، اليود، أوميغا 3)',
                            'الفقر البيئي ونقص التحفيز والتحدث مع الطفل',
                            'الإفرط في استخدام الشاشات والأجهزة الإلكترونية',
                            'الضغط والخوف المستمر من العقاب',
                        ]],
                        ['category' => 'طرق تنمية القدرات الذهنية', 'items' => [
                            'القراءة التفاعلية وطرح الأسئلة التحليلية',
                            'الألعاب الاستراتيجية (ليغو، بازل، شطرنج)',
                            'النشاط البدني والرياضة لزيادة تدفق الأكسجين للمخ',
                            'تشجيع الفضول والبحث عن الإجابات',
                            'النوم الكافي لتخزين المعلومات وتقوية الذاكرة',
                        ]],
                    ] : [
                        ['category' => 'Causes of Mental Decline', 'items' => [
                            'Malnutrition (deficiency in iron, iodine, omega-3)',
                            'Environmental poverty, lack of stimulation & conversation',
                            'Excessive screen time and electronic device usage',
                            'Psychological pressure and constant fear of punishment',
                        ]],
                        ['category' => 'Ways to Develop Abilities', 'items' => [
                            'Interactive reading and analytical questioning',
                            'Strategic games (Legos, puzzles, chess)',
                            'Physical activity and sports to boost brain oxygen',
                            'Encouraging curiosity and searching for answers',
                            'Adequate sleep for storage and memory strengthening',
                        ]],
                    ],
                ],
                [
                    'title' => app()->getLocale() == 'ar' ? 'دعم التواصل الاجتماعي' : 'Social Communication Support',
                    'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/></svg>',
                    'tags'  => app()->getLocale() == 'ar'
                        ? ['برنامج تدريجي ومنظم للتواصل', 'تعزيز الثقة الاجتماعية', 'تدريب لفظي ومهاري متخصص']
                        : ['Gradual Communication Program', 'Social Confidence Building', 'Verbal & Skill Training'],
                    'symptoms' => app()->getLocale() == 'ar' ? [
                        ['category' => 'العلامات التي ندعم فيها', 'items' => [
                            'تأثر المستوى الأكاديمي بسبب ضعف المشاركة في المدرسة',
                            'صعوبة التكيف الاجتماعي والخجل الشديد',
                            'صعوبة في تكوين الصداقات والعلاقات الاجتماعية',
                            'يمكن للطفل أن يتحسن مع البرامج التدريبية المناسبة',
                        ]],
                    ] : [
                        ['category' => 'Signs We Can Help With', 'items' => [
                            'Academic performance affected by limited school participation',
                            'Difficulty with social adaptation and shyness',
                            'Difficulty forming friendships and social relationships',
                            'Children can improve significantly with the right training programs',
                        ]],
                    ],
                ],
                [
                    'title' => app()->getLocale() == 'ar' ? 'الخوف والقلق' : 'Fear & Anxiety',
                    'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>',
                    'tags'  => app()->getLocale() == 'ar'
                        ? ['التعامل مع مخاوف النوم والظلام', 'توتر المدرسة والانفصال', 'تنظيم المشاعر والانفعالات']
                        : ['Sleep & Nighttime Support', 'School Transition Support', 'Emotion & Feelings Regulation'],
                    'symptoms' => app()->getLocale() == 'ar' ? [
                        ['category' => 'أسباب تطورية وبيئية', 'items' => [
                            'توتر الانفصال الطبيعي (بين 6 أشهر و 3 سنوات)',
                            'الخوف من الغرباء كآلية دفاعية فطرية',
                            'المخاوف الخيالية (الظلام، الوحوش، الأصوات العالية)',
                        ]],
                        ['category' => 'البيئة والأسرة والمجتمع', 'items' => [
                            'الخلافات الوالدية والشجار المستمر يؤثران على الطفل',
                            'التغييرات الكبيرة (منزل جديد، مدرسة، مولود جديد)',
                            'أسلوب التربية (الحماية الزائدة أو النقد القاسي)',
                            'التنمر، الضغط الدراسي، وصعوبة التكيف الاجتماعي',
                        ]],
                        ['category' => 'عوامل التطور والحساسية الحسية', 'items' => [
                            'الحساسية الحسية المفرطة تجاه الأصوات أو الإضاءة',
                            'الاستعداد الطبيعي والعوامل الفردية للطفل',
                        ]],
                    ] : [
                        ['category' => 'Developmental Causes', 'items' => [
                            'Natural separation anxiety (6m - 3y)',
                            'Fear of strangers as a defense mechanism',
                            'Imaginary fears (darkness, monsters, loud noises)',
                        ]],
                        ['category' => 'Environmental & Social', 'items' => [
                            'Parental conflicts and constant arguing',
                            'Major changes (new home, school, new baby)',
                            'Parenting style (overprotection or harsh criticism)',
                            'Bullying, academic pressure, and social adaptation',
                        ]],
                        ['category' => 'Developmental & Sensory Factors', 'items' => [
                            'Sensory hypersensitivity to sound or light',
                            'Individual temperament and natural tendencies',
                        ]],
                    ],
                ],
                [
                    'title' => app()->getLocale() == 'ar' ? 'التأتأة' : 'Stuttering',
                    'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                    'tags'  => app()->getLocale() == 'ar'
                        ? ['جلسات النطق والتواصل الفعّال', 'تحسين الطلاقة اللغوية', 'تقنيات تخفيف التوتر وزيادة الثقة']
                        : ['Speech & Communication Sessions', 'Language Fluency Improvement', 'Tension Reduction Techniques'],
                    'symptoms' => app()->getLocale() == 'ar' ? [
                        ['category' => 'عوامل التطور الطبيعي', 'items' => [
                            'استعداد فردي يؤثر على طلاقة الكلام',
                            'تسارع في التطور اللغوي مع بطء في التنسيق الحركي للنطق',
                        ]],
                        ['category' => 'عوامل نمو اللغة', 'items' => [
                            'تسابق الأفكار مع قدرات النطق (العقل أسرع من العضلات)',
                            'محاولة استخدام جمل معقدة قبل اكتمال المهارات اللغوية',
                        ]],
                        ['category' => 'عوامل بيئية وتربوية', 'items' => [
                            'الضغط للحديث بسرعة أو أمام الغرباء',
                            'التوتر الأسري والبيئة المشحونة',
                            'ردود فعل الآخرين السلبية (السخرية أو المقاطعة)',
                            'الحساسية الزائدة لردود الفعل',
                        ]],
                    ] : [
                        ['category' => 'Natural Development Factors', 'items' => [
                            'Individual traits affecting speech fluency',
                            'Fast language development with slower speech coordination',
                        ]],
                        ['category' => 'Language Development', 'items' => [
                            'Racing thoughts vs speech abilities (mind faster than tongue)',
                            'Using complex sentences before skills are ready',
                        ]],
                        ['category' => 'Environmental & Social', 'items' => [
                            'Pressure to speak quickly or in public',
                            'Family stress and anxiety-charged environment',
                            'Negative reactions (mockery or interruptions)',
                            'Performance anxiety and hypersensitivity to feedback',
                        ]],
                    ],
                ],
                [
                    'title' => app()->getLocale() == 'ar' ? 'تنمية الانتباه والتركيز' : 'Attention & Focus Development',
                    'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>',
                    'tags'  => app()->getLocale() == 'ar'
                        ? ['تنظيم السلوك والطاقة الزائدة', 'تحسين التركيز والانتباه', 'خطط متابعة مدرسية شاملة']
                        : ['Behavior & Energy Management', 'Focus & Attention Improvement', 'Comprehensive School Plans'],
                    'symptoms' => app()->getLocale() == 'ar' ? [
                        ['category' => 'العلامات التي ندعم فيها', 'items' => [
                            'الحركة الدائمة',
                            'عدم القدرة على الإصغاء',
                            'العجز عن اتباع التعليمات',
                            'الاستغراق في أحلام اليقظة',
                            'صعوبة إنجاز المهام',
                            'صعوبة المكوث في مكان لمدة تتجاوز في الغالب الـ 3-5 دقائق',
                            'صعوبة القيام بالمهام والمتطلبات العمرية',
                            'عدم القدرة على ضبط الانفعالات',
                            'الغضب الشديد',
                            'عدم القدرة على الانتظار',
                            'عدم القدرة على التعامل مع الخبرات البيئية بالشكل السليم',
                        ]],
                    ] : [
                        ['category' => 'Signs We Can Help With', 'items' => [
                            'Constant movement',
                            'Inability to listen',
                            'Unable to follow instructions',
                            'Daydreaming',
                            'Difficulty completing tasks',
                            'Difficulty staying in one place for more than 3-5 minutes',
                            'Difficulty with age-appropriate tasks',
                            'Inability to control emotions',
                            'Intense anger',
                            'Inability to wait',
                            'Difficulty handling environmental experiences properly',
                        ]],
                    ],
                ],
                [
                    'title' => app()->getLocale() == 'ar' ? 'التقييمات التخصصية' : 'Specialized Assessments',
                    'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>',
                    'tags'  => app()->getLocale() == 'ar'
                        ? ['اختبارات الذكاء والسلوك المعتمدة', 'تقييمات تربوية ومدرسية', 'تقييم شامل ودقيق']
                        : ['Accredited IQ & Behavior Tests', 'Educational & School Evaluations', 'Comprehensive Educational Assessment'],
                    'symptoms' => [],
                ],
                [
                    'title' => app()->getLocale() == 'ar' ? 'السلوكيات' : 'Behaviors',
                    'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                    'tags'  => app()->getLocale() == 'ar'
                        ? ['تعديل السلوك العدواني والانفجاري', 'إدارة الغضب والعناد', 'ضبط الانفعالات وتوجيهها']
                        : ['Positive Behavior Development', 'Anger & Stubbornness Management', 'Emotional Control & Guidance'],
                    'symptoms' => app()->getLocale() == 'ar' ? [
                        ['category' => 'العوامل المؤثرة في تشكيل السلوك', 'items' => [
                            'التقليد والمحاكاة: الطفل مرآة لوالديه ويتعلم بالملاحظة',
                            'تفاوت في مستوى التطور والتحكم الذاتي',
                            'تلبية الاحتياجات: وسيلة لجذب الانتباه أو التعبير عن رغباته',
                        ]],
                        ['category' => 'أنواع السلوكيات وأسبابها المحتملة', 'items' => [
                            'العناد: رغبة الطفل في إثبات استقلاليته وشخصيته',
                            'العدوانية: شعور بالإحباط أو تفريغ طاقة زائدة أو تقليد',
                            'الكذب: غالباً ما يكون خيالي في سن صغير أو خوفاً من العقاب',
                            'الانطواء: قد يعود لضعف الثقة بالنفس أو الحماية الزائدة',
                        ]],
                        ['category' => 'تعديل السلوك وتنمية الإيجابية', 'items' => [
                            'التعزيز الإيجابي: مكافأة السلوك الجيد بالمدح أو المكافأة',
                            'وضع الحدود بوضوح: الثبات في التعامل (Consistency)',
                            'التفريغ الحركي: ممارسة الرياضة واللعب الحركي لتفريغ الطاقة',
                            'الذكاء العاطفي: تعليم الطفل تسمية مشاعره لتقليل العنف',
                        ]],
                    ] : [
                        ['category' => 'Factors Affecting Behavior', 'items' => [
                            'Imitation: Children mirror parents and learn by observation',
                            'Developmental differences in self-regulation',
                            'Meeting Needs: A way to get attention or express desires',
                        ]],
                        ['category' => 'Common Behaviors & Causes', 'items' => [
                            'Stubbornness: Desire to prove independence and personality',
                            'Aggression: Frustration, excess energy, or imitation',
                            'Lying: Often imaginary at young ages or fear of punishment',
                            'Withdrawal: Low self-confidence or overprotection',
                        ]],
                        ['category' => 'Behavior Modification', 'items' => [
                            'Positive Reinforcement: Rewarding good behavior with praise',
                            'Clear Boundaries: Consistency in rules and consequences',
                            'Physical Release: Exercise and active play to vent energy',
                            'Emotional Intelligence: Naming feelings to reduce aggression',
                        ]],
                    ],
                ],
                [
                    'title' => app()->getLocale() == 'ar' ? 'المهارات' : 'Skills',
                    'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>',
                    'tags'  => app()->getLocale() == 'ar'
                        ? ['مهارات حياتية وتواصل فعّال', 'ضبط المشاعر والسلوك', 'مهارات اجتماعية وتفاعلية']
                        : ['Life & Communication Skills', 'Emotion & Behavior Regulation', 'Social & Interactive Skills'],
                    'symptoms' => app()->getLocale() == 'ar' ? [
                        ['category' => 'عوامل اكتساب المهارات', 'items' => [
                            'النمو الطبيعي للعضلات وقدرات الكلام',
                            'الاستمرارية والتكرار لترسيخ المهارات المكتسبة',
                            'نوعية المحفزات في البيئة (قصص، تفاعل، لعب حر)',
                            'الدعم العاطفي والشعور بالأمان ينمي شجاعة التجربة',
                        ]],
                    ] : [
                        ['category' => 'Skill Acquisition', 'items' => [
                            'Natural growth of muscles and speech capabilities',
                            'Consistency and repetition to reinforce acquired skills',
                            'Quality of environment (stories, interaction, play)',
                            'Emotional security builds courage to experiment',
                        ]],
                    ],
                ],
                [
                    'title' => app()->getLocale() == 'ar' ? 'دعم التحديات السلوكية' : 'Behavioral Challenges Support',
                    'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>',
                    'tags'  => app()->getLocale() == 'ar'
                        ? ['تعديل السلوك غير المرغوب', 'تدريب مهارات التحكم الذاتي', 'متابعة تخصصية ودعم أسري']
                        : ['Unwanted Behavior Modification', 'Self-Control Skills Training', 'Specialized Follow-up & Family Support'],
                    'symptoms' => app()->getLocale() == 'ar' ? [
                        ['category' => 'العلامات التي ندعم فيها', 'items' => [
                            'تكرار حركات أو أصوات لا إرادية بشكل مزعج',
                            'صعوبة في التحكم بالسلوك الانفعالي في المواقف الاجتماعية',
                            'تأثر الأداء الأكاديمي والاجتماعي جراء الحركات المتكررة',
                        ]],
                    ] : [
                        ['category' => 'Signs We Can Help With', 'items' => [
                            'Repeated involuntary movements or sounds',
                            'Difficulty controlling impulsive behaviors in social settings',
                            'Academic and social performance affected by repetitive patterns',
                        ]],
                    ],
                ],
                [
                    'title' => app()->getLocale() == 'ar' ? 'تعزيز الاستقلالية والثقة' : 'Independence & Confidence Building',
                    'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>',
                    'tags'  => app()->getLocale() == 'ar'
                        ? ['بناء الثقة الاجتماعية', 'دعم التكيّف المدرسي', 'تمكين الاستقلالية والثقة']
                        : ['Building Social Confidence', 'School Adjustment Support', 'Independence & Confidence Building'],
                    'symptoms' => app()->getLocale() == 'ar' ? [
                        ['category' => 'العلامات التي ندعم فيها', 'items' => [
                            'توتر شديد عند الفراق عن الوالدين أو الأشخاص المقربين',
                            'بكاء مستمر وصعوبة في التكيّف مع مواقف الانفصال اليومية',
                            'قلق مستمر حول سلامة الأشخاص المحيطين وأماكن وجودهم',
                            'رفض الذهاب للمدرسة أو النوم بعيداً عن المنزل',
                            'صعوبة النوم والإصرار على وجود أحد الوالدين',
                            'شكاوى جسدية (صداع، آلام بطن) تختفي عند وجود الوالدين',
                        ]],
                    ] : [
                        ['category' => 'Signs We Can Help With', 'items' => [
                            'Extreme distress when separating from parents or attachment figures',
                            'Persistent crying and difficulty adapting to daily separation situations',
                            'Ongoing worry about the safety and whereabouts of loved ones',
                            'Refusal to go to school or sleep away from home',
                            'Sleep difficulties and insisting on a parent being present at bedtime',
                            'Physical complaints (headaches, stomach aches) that ease when parents are present',
                        ]],
                    ],
                ],
                [
                    'title' => app()->getLocale() == 'ar' ? 'دعم الاحتياجات الخاصة' : 'Special Needs Support',
                    'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>',
                    'tags'  => app()->getLocale() == 'ar'
                        ? ['تنمية المهارات المعرفية الأساسية', 'مهارات الحياة اليومية المستقلة', 'تدريب أكاديمي مبسط ومنظم']
                        : ['Core Cognitive Skills Development', 'Independent Daily Life Skills', 'Structured Academic Training'],
                    'symptoms' => app()->getLocale() == 'ar' ? [
                        ['category' => 'المهارات التي ندعم تطويرها', 'items' => [
                            'مهارات التواصل اللفظي وغير اللفظي',
                            'مهارات الاعتناء بالنفس والاستقلالية',
                            'المهارات الاجتماعية والاندماج مع الآخرين',
                        ]],
                        ['category' => 'أسلوب الدعم المتبع', 'items' => [
                            'تقييم شامل لتحديد احتياجات الطفل الفردية',
                            'برامج مخصصة وفق الإيقاع الخاص بكل طفل',
                            'متابعة مستمرة مع الأهل لتحقيق أفضل النتائج',
                        ]],
                    ] : [
                        ['category' => 'Skills We Support', 'items' => [
                            'Verbal and non-verbal communication skills',
                            'Self-care and independent daily living skills',
                            'Social skills and integration with peers',
                        ]],
                        ['category' => 'Our Support Approach', 'items' => [
                            'Comprehensive assessment to identify each child\'s needs',
                            'Customized programs designed around each child\'s pace',
                            'Ongoing parent involvement for best outcomes',
                        ]],
                    ],
                ],
            ];
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6">
            @foreach($packages as $index => $package)
            @php $c = $pkgColors[$index % count($pkgColors)]; @endphp
            <div class="group relative bg-white dark:bg-dark-bg rounded-[1.75rem] overflow-hidden border border-gray-100 dark:border-dark-border shadow-sm hover:shadow-[0_28px_64px_-12px_rgba(0,0,0,0.14)] hover:-translate-y-2.5 transition-all duration-500 reveal" style="animation-delay:{{ $index * 0.06 }}s;">

                {{-- Colored top stripe --}}
                <div class="h-1.5 w-full" style="background: {{ $c['g'] }};"></div>

                <div class="p-6 sm:p-7 relative">
                    {{-- Large number watermark --}}
                    <div class="absolute {{ app()->getLocale() == 'ar' ? 'left-3' : 'right-3' }} top-3 font-black text-gray-100 dark:text-dark-border/60 select-none pointer-events-none leading-none" style="font-size: 5rem; letter-spacing: -0.05em; line-height: 1; font-family: 'Inter', sans-serif;">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</div>

                    <div class="relative z-10">
                        {{-- Gradient icon --}}
                        <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-white mb-5 transition-all duration-500 group-hover:scale-110 group-hover:rotate-3 p-3.5"
                             style="background: {{ $c['g'] }}; box-shadow: 0 12px 32px -6px {{ $c['sh'] }};">
                            {!! $package['icon'] !!}
                        </div>

                        {{-- Title --}}
                        <h3 class="text-[1.1rem] sm:text-[1.15rem] font-black text-gray-900 dark:text-white mb-4 leading-snug group-hover:text-primary transition-colors duration-300">
                            {{ $package['title'] }}
                        </h3>

                        {{-- Feature list --}}
                        <ul class="space-y-2.5 mb-5">
                            @foreach($package['tags'] as $tag)
                            <li class="flex items-center gap-2.5 text-[0.8rem] sm:text-sm text-[var(--muted-color)]">
                                <span class="w-5 h-5 rounded-full flex-shrink-0 flex items-center justify-center"
                                      style="background: {{ $c['g'] }}; box-shadow: 0 4px 12px -2px {{ $c['sh'] }};">
                                    <svg class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </span>
                                <span>{{ $tag }}</span>
                            </li>
                            @endforeach
                        </ul>

                        @if(!empty($package['symptoms']))
                        {{-- Symptoms Toggle Button --}}
                        <button onclick="toggleSymptoms(this)" class="symptoms-toggle-btn w-full flex items-center justify-between gap-2 px-4 py-2.5 rounded-xl text-[0.78rem] sm:text-[0.82rem] font-bold transition-all duration-300 mb-4 border"
                                style="color: {{ $c['hex'] }}; border-color: {{ $c['hex'] }}20; background: {{ $c['hex'] }}08;"
                                onmouseenter="this.style.background='{{ $c['hex'] }}12'" onmouseleave="this.style.background='{{ $c['hex'] }}08'">
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                {{ app()->getLocale() == 'ar' ? 'الأعراض والعلامات' : 'Signs & Symptoms' }}
                            </span>
                            <svg class="w-4 h-4 shrink-0 transition-transform duration-300 symptoms-chevron" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        {{-- Expandable Symptoms Section --}}
                        <div class="symptoms-panel overflow-hidden transition-all duration-500 ease-in-out" style="max-height: 0; opacity: 0;">
                            <div class="rounded-2xl p-4 mb-4 space-y-4 border" style="background: {{ $c['hex'] }}06; border-color: {{ $c['hex'] }}12;">
                                @foreach($package['symptoms'] as $catIdx => $symptomGroup)
                                <div>
                                    {{-- Category Header --}}
                                    <div class="flex items-center gap-2 mb-2.5">
                                        <span class="w-1.5 h-6 rounded-full shrink-0" style="background: {{ $c['g'] }};"></span>
                                        <h4 class="text-[0.8rem] sm:text-[0.85rem] font-black text-gray-800 dark:text-white">
                                            {{ $symptomGroup['category'] }}
                                        </h4>
                                    </div>
                                    {{-- Symptom Items --}}
                                    <ul class="space-y-2 {{ app()->getLocale() == 'ar' ? 'pr-4' : 'pl-4' }}">
                                        @foreach($symptomGroup['items'] as $symptom)
                                        <li class="flex items-start gap-2 text-[0.75rem] sm:text-[0.8rem] text-[var(--muted-color)] leading-relaxed">
                                            <span class="w-1.5 h-1.5 rounded-full shrink-0 mt-1.5" style="background: {{ $c['hex'] }};"></span>
                                            <span>{{ $symptom }}</span>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                                @if(!$loop->last)
                                <div class="h-px w-full" style="background: {{ $c['hex'] }}15;"></div>
                                @endif
                                @endforeach
                            </div>
                        </div>
                        @endif

                        {{-- Divider --}}
                        <div class="h-px bg-gray-100 dark:bg-dark-border mb-4"></div>

                        {{-- CTA WhatsApp Button --}}
                        <a href="https://wa.me/96555665161" target="_blank"
                           class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-white text-[0.82rem] font-bold transition-all duration-300 hover:-translate-y-0.5 hover:shadow-lg"
                           style="background: {{ $c['g'] }}; box-shadow: 0 6px 20px -4px {{ $c['sh'] }};">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.72.937 3.658 1.43 5.623 1.43h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                            {{ app()->getLocale() == 'ar' ? 'تواصل معنا عبر واتساب' : 'Contact via WhatsApp' }}
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- ─── Deema Installment Banner ─── --}}
        <div class="mt-12 sm:mt-20 reveal px-4 sm:px-0">
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
                                <div class="flex items-center gap-1 sm:gap-1.5 mb-5 mx-1 sm:mx-4">
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
</section>

{{-- Inline script (layout has no @stack) --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        if (typeof reveal === 'function') reveal();
    });

    function toggleSymptoms(btn) {
        let panel = btn.nextElementSibling;
        while (panel && !panel.classList.contains('symptoms-panel')) {
            panel = panel.nextElementSibling;
        }
        if (!panel) return;

        const chevron = btn.querySelector('.symptoms-chevron');
        const isOpen = panel.getAttribute('data-open') === 'true';

        if (isOpen) {
            panel.style.maxHeight = '0px';
            panel.style.opacity = '0';
            panel.setAttribute('data-open', 'false');
            if (chevron) chevron.style.transform = 'rotate(0deg)';
        } else {
            panel.style.maxHeight = panel.scrollHeight + 'px';
            panel.style.opacity = '1';
            panel.setAttribute('data-open', 'true');
            if (chevron) chevron.style.transform = 'rotate(180deg)';
        }
    }
</script>

@endsection
