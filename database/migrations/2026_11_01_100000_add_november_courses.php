<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * November courses from the center's posters:
     * - Psychological First Aid, Wed 11 Nov — the homepage course, linked to AS1 in the center system
     * - Communication Skills & the Art of Dialogue, Wed 25 Nov — center code still to be set in the admin
     * Both 30 KWD; any earlier gift code (10 KWD, any course) works on them.
     * Dr. Tariq's consultation box goes back to open booking (no fixed day).
     */
    private const COMMON = [
        'trainer_ar'        => 'أ.د. طارق الحبيب',
        'trainer_en'        => 'Prof. Dr. Tariq Al-Habib',
        'price'             => 30,
        'time_ar'           => '7:00 - 9:00 مساءً',
        'time_en'           => '7:00 - 9:00 PM',
        'location_ar'       => 'حضوري - الكويت، برج أحمد، بجوار المستشفى الأميري',
        'location_en'       => 'In-person - Kuwait, Burj Ahmed, near Al-Amiri Hospital',
        'certificate_ar'    => 'شهادة معتمدة من ديوان الخدمة المدنية والهيئة العامة للتعليم التطبيقي والتدريب',
        'certificate_en'    => 'Certificate accredited by the Civil Service Commission & PAAET',
        'theme_color'       => '#6d1b2b',
        'show_installments' => true,
        'is_active'         => true,
    ];

    private function courses(): array
    {
        return [
            'psychological-first-aid' => [
                'title_ar' => 'دورة الإسعافات النفسية الأولية',
                'title_en' => 'Psychological First Aid Course',
                'date' => '2026-11-11',
                'topics_ar' => implode("\n", [
                    'أهمية الإسعافات النفسية الأولية، لمن تُقدَّم، وما هي إجراءاتها',
                    'أنواع الصدمات النفسية',
                    'كيف تتعامل مع من يريد الانتحار',
                    'كيف تتعامل مع الذهان الحاد والهوس الحاد',
                    'كيف تتعامل مع من تعرّض للاغتصاب',
                    'كيف تبلّغ المصاب بالفقد المفاجئ',
                    'أسباب الانهيار العصبي وكيفية التعامل معه',
                ]),
                'topics_en' => implode("\n", [
                    'Why psychological first aid matters, who it is for, and its steps',
                    'Types of psychological trauma',
                    'Helping someone who wants to take their own life',
                    'Dealing with acute psychosis and acute mania',
                    'Supporting someone who has been sexually assaulted',
                    'Breaking the news of a sudden loss',
                    'Nervous breakdown: its causes and how to respond',
                ]),
                'share_image' => 'og-psychological-first-aid.jpg',
                'center_course_code' => 'AS1',
                'is_featured' => true,
            ],
            'communication-skills' => [
                'title_ar' => 'دورة مهارات التواصل وفن الحوار',
                'title_en' => 'Communication Skills & the Art of Dialogue',
                'date' => '2026-11-25',
                'topics_ar' => implode("\n", [
                    'أهمية تعلّم مهارات التواصل مع الآخرين',
                    'وسائل التواصل وأهدافه',
                    'شروط الاتصال الناجح',
                    'أخلاقيات التواصل',
                    'خصائص المتحدث المؤثر',
                    'خطوات عملية نحو التأثير وإقناع الآخرين',
                ]),
                'topics_en' => implode("\n", [
                    'Why communication skills matter',
                    'Ways and goals of communication',
                    'What makes communication succeed',
                    'The ethics of communication',
                    'Traits of an influential speaker',
                    'Practical steps to influence and persuade',
                ]),
                'share_image' => 'og-communication-skills.jpg',
                'center_course_code' => null,
                'is_featured' => false,
            ],
        ];
    }

    public function up(): void
    {
        foreach ($this->courses() as $slug => $row) {
            // Already added by hand from the admin? Leave it exactly as it is.
            if (DB::table('course_offers')->where('slug', $slug)->exists()) continue;

            DB::table('course_offers')->insert(['slug' => $slug] + $row + self::COMMON + ['created_at' => now(), 'updated_at' => now()]);
        }

        // One homepage course at a time (same rule as the admin): Psychological First Aid
        if (DB::table('course_offers')->where('slug', 'psychological-first-aid')->where('is_featured', true)->exists()) {
            DB::table('course_offers')->where('slug', '!=', 'psychological-first-aid')->update(['is_featured' => false]);
        }

        // Dr. Tariq: open booking (in person or by phone) instead of the passed 29 October
        if (Schema::hasTable('site_settings')) {
            DB::table('site_settings')->where('key', 'dr_tariq_date')->delete();
            \Illuminate\Support\Facades\Cache::forget('site_settings');
        }
    }

    public function down(): void
    {
        // Only remove a course nobody has registered for
        foreach (array_keys($this->courses()) as $slug) {
            if (!DB::table('course_registrations')->where('course_key', $slug)->exists()) {
                DB::table('course_offers')->where('slug', $slug)->delete();
            }
        }
    }
};
