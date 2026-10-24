@extends('layouts.app')

@section('title', __('Packages') . ' - ' . __('Motmaena Center'))
@section('meta_description', app()->getLocale() == 'ar' ? 'باقات متكاملة لدعم طفلك: التواصل الاجتماعي، صعوبات التعلم، الثقة بالنفس، تعديل السلوك والمزيد — في مركز مطمئنة بالكويت.' : 'Complete packages to support your child: social communication, learning difficulties, confidence, behaviour and more — at Motmaena Center, Kuwait.')

@section('content')
@php
    $isAr = app()->getLocale() == 'ar';
    $waLink = fn ($text) => 'https://wa.me/' . $site['whatsapp'] . '?text=' . rawurlencode($text);
    $waIcon = '<svg class="w-[18px] h-[18px] shrink-0" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.72.937 3.658 1.43 5.623 1.43h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>';

            $packages = [
                [
                    'title' => $isAr ? 'تنمية التواصل الاجتماعي' : 'Social Communication Development',
                    'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 4a2 2 0 114 0v1a2 2 0 01-2 2 2 2 0 01-2-2V4zm-3 8a3 3 0 01-3-3V7a3 3 0 013-3h.5a3 3 0 013 3v2a3 3 0 01-3 3H8zm10-5a3 3 0 00-3 3v2a3 3 0 003 3h.5a3 3 0 003-3V7a3 3 0 00-3-3H18zM6 20a1 1 0 01-1-1v-1a5 5 0 015-5h4a5 5 0 015 5v1a1 1 0 01-1 1H6z"/></svg>',
                    'tags'  => $isAr
                        ? ['تنمية التواصل اللفظي والبصري', 'تحسين المهارات الاجتماعية', 'دعم السلوك وتعديله']
                        : ['Verbal & Visual Communication', 'Social Skills Enhancement', 'Behavior Support & Modification'],
                    'symptoms' => $isAr ? [
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
                    'title' => $isAr ? 'صعوبات التعلم' : 'Learning Disabilities',
                    'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>',
                    'tags'  => $isAr
                        ? ['تنمية مهارات القراءة والكتابة', 'تحسين الانتباه والتركيز', 'خطط تعليمية فردية مخصصة']
                        : ['Reading & Writing Skills', 'Attention & Focus Improvement', 'Personalized Learning Plans'],
                    'symptoms' => $isAr ? [
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
                    'title' => $isAr ? 'نقص الثقة بالنفس' : 'Lack of Confidence',
                    'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>',
                    'tags'  => $isAr
                        ? ['تعزيز الشخصية الإيجابية', 'رفع مستوى الثقة بالنفس', 'دعم مهارات التعبير الذاتي']
                        : ['Positive Personality Boost', 'Self-Confidence Raising', 'Self-Expression Skills'],
                    'symptoms' => $isAr ? [
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
                    'title' => $isAr ? 'الذكاء وتنمية القدرات' : 'Intelligence & Abilities',
                    'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>',
                    'tags'  => $isAr
                        ? ['اختبارات الذكاء والكفاءات', 'برامج تنمية التفكير الإبداعي', 'مهارات حل المشكلات']
                        : ['IQ & Aptitude Assessments', 'Creative Thinking Programs', 'Problem Solving Skills'],
                    'symptoms' => $isAr ? [
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
                    'title' => $isAr ? 'دعم التواصل الاجتماعي' : 'Social Communication Support',
                    'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/></svg>',
                    'tags'  => $isAr
                        ? ['برنامج تدريجي ومنظم للتواصل', 'تعزيز الثقة الاجتماعية', 'تدريب لفظي ومهاري متخصص']
                        : ['Gradual Communication Program', 'Social Confidence Building', 'Verbal & Skill Training'],
                    'symptoms' => $isAr ? [
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
                    'title' => $isAr ? 'التكيف والسلوك لدى الطفل' : 'Child Adaptation & Behavior',
                    'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>',
                    'tags'  => $isAr
                        ? ['دعم الطفل في التكيف مع مواقف النوم والاستقلال', 'مساعدة الطفل على الاندماج في البيئة المدرسية', 'تنمية مهارات التحكم بالسلوك والتعبير المناسب']
                        : ['Sleep & Independence Support', 'School Integration Support', 'Behavior & Expression Skills'],
                    'symptoms' => $isAr ? [
                        ['category' => 'عوامل مرتبطة بالنمو والتعلم', 'items' => [
                            'مراحل النمو الطبيعي وتأثيرها على سلوك الطفل',
                            'تأثر الطفل بالمواقف اليومية والخبرات الجديدة',
                            'استجابة الطفل للبيئة المحيطة',
                        ]],
                        ['category' => 'دور الأسرة والبيئة التعليمية', 'items' => [
                            'أساليب التعامل داخل الأسرة وتأثيرها على السلوك',
                            'التغيرات الحياتية (انتقال، مدرسة جديدة...)',
                            'طبيعة التفاعل داخل المدرسة',
                            'دعم الطفل في التكيف الاجتماعي',
                        ]],
                        ['category' => 'الفروق الفردية لدى الأطفال', 'items' => [
                            'اختلاف استجابة الأطفال للمؤثرات (صوت، ضوء...)',
                            'خصائص الطفل الفردية وكيفية دعمه تربوياً',
                        ]],
                    ] : [
                        ['category' => 'Growth & Learning Factors', 'items' => [
                            'Natural developmental stages and their effect on child behavior',
                            'How daily situations and new experiences shape the child',
                            'The child\'s response to the surrounding environment',
                        ]],
                        ['category' => 'Family & Educational Environment', 'items' => [
                            'Family interaction styles and their impact on behavior',
                            'Life transitions (relocation, new school...)',
                            'Nature of interaction within the school setting',
                            'Supporting the child in social adaptation',
                        ]],
                        ['category' => 'Individual Differences', 'items' => [
                            'Varied child responses to stimuli (sound, light...)',
                            'Each child\'s unique traits and how to support them educationally',
                        ]],
                    ],
                ],
                [
                    'title' => $isAr ? 'التأتأة' : 'Stuttering',
                    'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                    'tags'  => $isAr
                        ? ['جلسات النطق والتواصل الفعّال', 'تحسين الطلاقة اللغوية', 'تقنيات تخفيف التوتر وزيادة الثقة']
                        : ['Speech & Communication Sessions', 'Language Fluency Improvement', 'Tension Reduction Techniques'],
                    'symptoms' => $isAr ? [
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
                    'title' => $isAr ? 'تنمية القدرات الاجتماعية والأكاديمية' : 'Social & Academic Development',
                    'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>',
                    'tags'  => $isAr
                        ? ['تنظيم السلوك والطاقة الزائدة', 'تحسين التركيز والانتباه', 'خطط متابعة مدرسية شاملة']
                        : ['Behavior & Energy Management', 'Focus & Attention Improvement', 'Comprehensive School Plans'],
                    'symptoms' => $isAr ? [
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
                    'title' => $isAr ? 'تعديل السلوك التربوي والاجتماعي' : 'Educational & Social Behavior',
                    'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                    'tags'  => $isAr
                        ? ['تعديل السلوك العدواني والانفجاري', 'إدارة الغضب والعناد', 'ضبط الانفعالات وتوجيهها']
                        : ['Positive Behavior Development', 'Anger & Stubbornness Management', 'Emotional Control & Guidance'],
                    'symptoms' => $isAr ? [
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
                    'title' => $isAr ? 'المهارات' : 'Skills',
                    'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>',
                    'tags'  => $isAr
                        ? ['مهارات حياتية وتواصل فعّال', 'ضبط المشاعر والسلوك', 'مهارات اجتماعية وتفاعلية']
                        : ['Life & Communication Skills', 'Emotion & Behavior Regulation', 'Social & Interactive Skills'],
                    'symptoms' => $isAr ? [
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
                    'title' => $isAr ? 'تعديل السلوك التربوي غير المرغوب' : 'Unwanted Behavior Modification',
                    'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>',
                    'tags'  => $isAr
                        ? ['تعديل السلوك غير المرغوب', 'تدريب مهارات التحكم الذاتي', 'متابعة تخصصية ودعم أسري']
                        : ['Unwanted Behavior Modification', 'Self-Control Skills Training', 'Specialized Follow-up & Family Support'],
                    'symptoms' => $isAr ? [
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
                    'title' => $isAr ? 'تعزيز الاستقلالية والثقة' : 'Independence & Confidence Building',
                    'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>',
                    'tags'  => $isAr
                        ? ['بناء الثقة الاجتماعية', 'دعم التكيّف المدرسي', 'تمكين الاستقلالية والثقة']
                        : ['Building Social Confidence', 'School Adjustment Support', 'Independence & Confidence Building'],
                    'symptoms' => $isAr ? [
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
                    'title' => $isAr ? 'دعم الاحتياجات الخاصة' : 'Special Needs Support',
                    'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>',
                    'tags'  => $isAr
                        ? ['تنمية المهارات المعرفية الأساسية', 'مهارات الحياة اليومية المستقلة', 'تدريب أكاديمي مبسط ومنظم']
                        : ['Core Cognitive Skills Development', 'Independent Daily Life Skills', 'Structured Academic Training'],
                    'symptoms' => $isAr ? [
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

<style>
    .pk { --wine: #6d1b2b; --gold: #9a7434; }
    .pk h1, .pk h2, .pk h3 { text-wrap: balance; }
    .pk-eyebrow { display: inline-flex; align-items: center; gap: 12px; font-size: 15px; font-weight: 900; color: var(--gold); }
    .pk-eyebrow::before, .pk-eyebrow::after { content: ''; width: 36px; height: 2px; border-radius: 2px; background: currentColor; opacity: .8; }
    .dark .pk-eyebrow { color: #d4b06a; }
    .pk-chip { display: inline-flex; align-items: center; gap: 8px; padding: 9px 15px; border-radius: 999px; background: #fff; border: 1px solid #eadfd3; font-size: 13px; font-weight: 800; color: #4b3a33; white-space: nowrap; transition: border-color .15s, color .15s, background .15s; }
    .pk-chip b { font-size: 11px; color: #b08a45; font-weight: 900; }
    .pk-chip:hover { border-color: var(--wine); color: var(--wine); }
    .dark .pk-chip { background: rgba(255,255,255,.04); border-color: rgba(255,255,255,.1); color: #e5e7eb; }
    .pk-card { display: flex; flex-direction: column; background: #fff; border: 1px solid #eee5dc; border-radius: 24px; padding: 26px; scroll-margin-top: 110px; transition: border-color .2s, box-shadow .2s, transform .2s; }
    .pk-card:hover { border-color: #dcc7b6; box-shadow: 0 26px 50px -32px rgba(74,15,27,.4); transform: translateY(-3px); }
    .pk-card:target { border-color: var(--wine); box-shadow: 0 0 0 4px rgba(109,27,43,.12); }
    .dark .pk-card { background: rgba(255,255,255,.03); border-color: rgba(255,255,255,.08); }
    .pk-icon { width: 52px; height: 52px; border-radius: 16px; padding: 13px; background: #f7efe9; color: var(--wine); flex-shrink: 0; transition: background .2s, color .2s; }
    .pk-card:hover .pk-icon { background: var(--wine); color: #fff; }
    .dark .pk-icon { background: rgba(255,255,255,.06); color: #e7a3ae; }
    .pk-num { font-size: 13px; font-weight: 900; letter-spacing: .1em; color: #b08a45; }
    .pk-check { width: 20px; height: 20px; border-radius: 99px; background: #f5ece6; color: var(--wine); display: inline-flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 1px; }
    .dark .pk-check { background: rgba(255,255,255,.08); color: #e7a3ae; }
    .pk-more summary { list-style: none; cursor: pointer; display: flex; align-items: center; justify-content: space-between; gap: 8px; padding: 11px 0; border-top: 1px dashed #e7dbcf; font-size: 13px; font-weight: 800; color: #7a6253; }
    .pk-more summary::-webkit-details-marker { display: none; }
    .pk-more summary:hover { color: var(--wine); }
    .pk-more[open] summary svg { transform: rotate(180deg); }
    .dark .pk-more summary { border-color: rgba(255,255,255,.1); color: #c7b8ad; }
    .pk-cta { display: flex; align-items: center; justify-content: center; gap: 8px; width: 100%; padding: 12px 16px; border-radius: 14px; border: 1.5px solid var(--wine); color: var(--wine); font-size: 14px; font-weight: 900; transition: background .2s, color .2s; }
    .pk-cta:hover { background: var(--wine); color: #fff; }
    .dark .pk-cta { border-color: #e7a3ae; color: #f3c6cd; }
    .dark .pk-cta:hover { background: #e7a3ae; color: #2a0d13; }
</style>

<div class="pk">

{{-- ════════════════ HERO ════════════════ --}}
<section class="relative overflow-hidden bg-[#fbf6ee] dark:bg-dark-surface border-b border-[#efe4d6] dark:border-dark-border">
    <div class="container mx-auto px-4 py-14 sm:py-20 text-center">
        <span class="pk-eyebrow">{{ $isAr ? 'باقات متكاملة للأطفال' : 'Complete programs for children' }}</span>

        <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-gray-900 dark:text-white mt-4 mb-5 leading-tight">
            {{ $isAr ? 'باقات متخصصة لدعم طفلك' : 'Specialised Packages for Your Child' }}
        </h1>

        <p class="text-[15px] sm:text-lg font-semibold text-[#6b5446] dark:text-gray-300 max-w-2xl mx-auto leading-loose">
            {{ $isAr ? 'برامج فردية تساعد طفلك في السلوك والتعلّم والتواصل والثقة بالنفس، في مركز مطمئنة بإشراف ' . config('doctor.name.ar') . '.' : 'One-to-one programs that help your child with behaviour, learning, communication and confidence, at Motmaena Center, supervised by ' . config('doctor.name.en') . '.' }}
        </p>

        <div class="flex flex-wrap items-center justify-center gap-x-6 gap-y-2 mt-7 text-sm font-bold text-[#4b3a33] dark:text-gray-200">
            @foreach([$isAr ? 'خطة فردية لكل طفل' : 'A personal plan for every child', $isAr ? 'متابعة مستمرة مع الأهل' : 'Ongoing follow-up with parents', $isAr ? 'تقسيط على 4 دفعات' : 'Pay in 4 installments'] as $point)
                <span class="inline-flex items-center gap-2">
                    <span class="pk-check"><svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3.2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></span>
                    {{ $point }}
                </span>
            @endforeach
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-3 mt-9">
            <a href="{{ $waLink($isAr ? 'مرحباً، بدي أستشير عن باقة مناسبة لطفلي' : 'Hello, I would like advice on the right package for my child') }}" target="_blank" rel="noopener"
               class="inline-flex items-center gap-2.5 px-7 py-3.5 rounded-2xl bg-[#6d1b2b] hover:bg-[#4a0f1b] text-white font-black shadow-[0_14px_30px_-14px_rgba(109,27,43,.8)] transition">
                {!! $waIcon !!} {{ $isAr ? 'احكِ لنا عن طفلك' : 'Tell us about your child' }}
            </a>
            <a href="#packages-section" class="inline-flex items-center gap-2 px-6 py-3.5 rounded-2xl font-black text-[#6d1b2b] dark:text-[#f3c6cd] hover:bg-white/70 dark:hover:bg-white/5 transition">
                {{ $isAr ? 'تصفّح الباقات' : 'Browse packages' }}
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
            </a>
        </div>
    </div>
</section>

{{-- ════════════════ PACKAGES ════════════════ --}}
<section id="packages-section" class="py-12 sm:py-16 bg-white dark:bg-dark-bg scroll-mt-20">
    <div class="container mx-auto px-4">

        {{-- Quick jump: find the package by the child's need --}}
        <div class="mb-10 sm:mb-12 text-center">
            <p class="font-black text-gray-900 dark:text-white mb-4">{{ $isAr ? 'شو بيحتاج طفلك؟ اختر وانتقل للباقة مباشرة' : 'What does your child need? Jump straight to a package' }}</p>
            <div class="flex sm:flex-wrap sm:justify-center gap-2 overflow-x-auto pb-2 -mx-4 px-4 sm:mx-0 sm:px-0 sm:overflow-visible" style="scrollbar-width: none;">
                @foreach($packages as $i => $package)
                    <a href="#pkg-{{ $i + 1 }}" class="pk-chip"><b dir="ltr">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</b>{{ $package['title'] }}</a>
                @endforeach
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6">
            @foreach($packages as $i => $package)
            <article id="pkg-{{ $i + 1 }}" class="pk-card reveal">
                <div class="flex items-start justify-between mb-5">
                    <div class="pk-icon">{!! $package['icon'] !!}</div>
                    <span class="pk-num" dir="ltr">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                </div>

                <h3 class="text-lg font-black text-gray-900 dark:text-white mb-4 leading-snug">{{ $package['title'] }}</h3>

                <ul class="space-y-2.5 mb-5">
                    @foreach($package['tags'] as $tag)
                    <li class="flex items-start gap-2.5 text-sm font-semibold text-[#5a463b] dark:text-gray-300 leading-relaxed">
                        <span class="pk-check"><svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3.2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></span>
                        <span>{{ $tag }}</span>
                    </li>
                    @endforeach
                </ul>

                <div class="mt-auto">
                    @if(!empty($package['symptoms']))
                    <details class="pk-more mb-4">
                        <summary>
                            {{ $isAr ? 'اعرف أكثر: العلامات والأسباب' : 'Learn more: signs & causes' }}
                            <svg class="w-4 h-4 shrink-0 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                        </summary>
                        <div class="space-y-4 pt-1 pb-2">
                            @foreach($package['symptoms'] as $group)
                            <div>
                                <h4 class="text-[13px] font-black text-[#6d1b2b] dark:text-[#f3c6cd] mb-2">{{ $group['category'] }}</h4>
                                <ul class="space-y-1.5">
                                    @foreach($group['items'] as $item)
                                    <li class="flex items-start gap-2 text-[13px] font-semibold text-[#6b5446] dark:text-gray-400 leading-relaxed">
                                        <span class="w-1.5 h-1.5 rounded-full bg-[#b08a45] shrink-0 mt-2"></span>
                                        <span>{{ $item }}</span>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            @endforeach
                        </div>
                    </details>
                    @endif

                    <a href="{{ $waLink(($isAr ? 'مرحباً، بدي أستفسر عن باقة: ' : 'Hello, I would like to ask about the package: ') . $package['title']) }}" target="_blank" rel="noopener" class="pk-cta">
                        {!! $waIcon !!} {{ $isAr ? 'استفسر عن هذه الباقة' : 'Ask about this package' }}
                    </a>
                </div>
            </article>
            @endforeach

            {{-- Not sure? Fills the last row next to the final card --}}
            <div class="reveal sm:col-span-1 lg:col-span-2 rounded-[24px] bg-[#6d1b2b] text-white p-8 sm:p-10 flex flex-col justify-center relative overflow-hidden">
                <div class="absolute -top-16 {{ $isAr ? '-left-16' : '-right-16' }} w-56 h-56 rounded-full border-[28px] border-white/[.06]"></div>
                <span class="text-[#e8c98f] text-sm font-black mb-2">{{ $isAr ? 'مش متأكد؟' : 'Not sure?' }}</span>
                <h3 class="text-2xl sm:text-3xl font-black leading-snug mb-3">{{ $isAr ? 'ما بتعرف أي باقة تناسب طفلك؟' : "Don't know which package fits your child?" }}</h3>
                <p class="text-white/80 font-semibold leading-loose mb-7 max-w-lg">{{ $isAr ? 'احكِ لنا عن طفلك على الواتساب، ونقترح لك الباقة الأنسب بعد تقييم أولي — أو احجز استشارة مع المختص.' : 'Tell us about your child on WhatsApp and we will suggest the right package after a first assessment — or book a consultation.' }}</p>
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ $waLink($isAr ? 'مرحباً، بدي أستشير عن باقة مناسبة لطفلي' : 'Hello, I would like advice on the right package for my child') }}" target="_blank" rel="noopener"
                       class="inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-2xl bg-white text-[#6d1b2b] font-black hover:bg-[#f5ebe6] transition">
                        {!! $waIcon !!} {{ $isAr ? 'استشرنا على الواتساب' : 'Ask us on WhatsApp' }}
                    </a>
                    <a href="{{ route('consultations') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-2xl border border-white/30 font-black hover:bg-white/10 transition">
                        {{ $isAr ? 'احجز استشارة' : 'Book a consultation' }}
                    </a>
                </div>
            </div>
        </div>

        {{-- ─── deema installments ─── --}}
        <div class="mt-14 sm:mt-20 reveal">
            <div class="rounded-[28px] bg-[#fbf6ee] dark:bg-white/[.03] border border-[#efe4d6] dark:border-white/10 p-7 sm:p-12 grid lg:grid-cols-2 gap-8 lg:gap-12 items-center">
                <div class="text-center {{ $isAr ? 'lg:text-right' : 'lg:text-left' }}">
                    <span class="inline-flex items-center gap-2.5 bg-white dark:bg-white/5 border border-[#eadfd3] dark:border-white/10 rounded-full px-4 py-2 mb-5">
                        <img src="{{ asset('deema-logo.png') }}" alt="deema" class="h-6 w-auto">
                        <span class="text-xs font-black text-[#7a6253] dark:text-gray-300">{{ $isAr ? 'بالتعاون مع deema' : 'In partnership with deema' }}</span>
                    </span>
                    <h2 class="text-2xl sm:text-4xl font-black text-gray-900 dark:text-white leading-snug mb-3">
                        {{ $isAr ? 'قسّط اشتراكك على' : 'Split your subscription into' }} <span class="text-[#6d1b2b] dark:text-[#f3c6cd]">{{ $isAr ? '4 دفعات' : '4 payments' }}</span>
                    </h2>
                    <p class="font-semibold text-[#6b5446] dark:text-gray-300 leading-loose mb-6">{{ $isAr ? 'ادفع أول دفعة اليوم والباقي على 3 دفعات — بدون رسوم إضافية وبموافقة فورية.' : 'Pay the first part today and the rest over 3 payments — no extra fees, instant approval.' }}</p>
                    <a href="{{ $waLink($isAr ? 'مرحباً، بدي أشترك بباقة وأقسّط مع deema' : 'Hello, I would like to subscribe to a package and pay with deema') }}" target="_blank" rel="noopener"
                       class="inline-flex items-center gap-2.5 px-7 py-3.5 rounded-2xl bg-[#6d1b2b] hover:bg-[#4a0f1b] text-white font-black transition">
                        {!! $waIcon !!} {{ $isAr ? 'تواصل معنا للاشتراك' : 'Contact us to subscribe' }}
                    </a>
                </div>

                {{-- 4 payments: first today --}}
                <div class="grid grid-cols-4 gap-2 sm:gap-3">
                    @for($p = 1; $p <= 4; $p++)
                    <div class="text-center">
                        <div class="h-3 rounded-full mb-3 {{ $p === 1 ? 'bg-[#6d1b2b]' : 'bg-[#6d1b2b]/15 dark:bg-white/10' }}"></div>
                        <div class="text-2xl sm:text-4xl font-black {{ $p === 1 ? 'text-[#6d1b2b] dark:text-[#f3c6cd]' : 'text-gray-400' }}">{{ $p }}</div>
                        <div class="text-[11px] sm:text-xs font-bold text-[#8a7462] mt-1">{{ $p === 1 ? ($isAr ? 'اليوم' : 'Today') : ($isAr ? 'دفعة ' . $p : 'Payment ' . $p) }}</div>
                    </div>
                    @endfor
                </div>
            </div>
        </div>

    </div>
</section>

</div>

<script>
    document.addEventListener('DOMContentLoaded', () => { if (typeof reveal === 'function') reveal(); });
</script>

@endsection
