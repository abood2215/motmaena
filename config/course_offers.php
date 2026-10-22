<?php

/*
|--------------------------------------------------------------------------
| Paid Course Offers
|--------------------------------------------------------------------------
|
| Courses that can be registered for and paid online (MyFatoorah).
| The key is used in the URL: /register/{key}. Prices are in KWD.
|
*/

return [

    'anger-management' => [
        'active'   => true,
        'title'    => ['ar' => 'دورة إدارة الغضب', 'en' => 'Anger Management Course'],
        'trainer'  => ['ar' => 'أ.د. طارق الحبيب', 'en' => 'Prof. Dr. Tariq Al-Habib'],
        'price'    => 30,
        'date'     => '2026-10-28',
        'day'      => ['ar' => 'الأربعاء', 'en' => 'Wednesday'],
        'time'     => ['ar' => '7:00 - 9:00 مساءً', 'en' => '7:00 - 9:00 PM'],
        'location' => ['ar' => 'حضوري - الكويت، برج أحمد، بجوار المستشفى الأميري', 'en' => 'In-person - Kuwait, Burj Ahmed, near Al-Amiri Hospital'],
        'certificate' => ['ar' => 'شهادة معتمدة من ديوان الخدمة المدنية والتطبيقي', 'en' => 'Certificate accredited by the Civil Service Commission & PAAET'],
        'topics' => [
            'ar' => ['مفهوم الغضب وأنواعه', 'مراحل الغضب', 'أسباب الغضب', 'الخبرة المتكاملة الضابطة للغضب', 'أنماط التفكير السلبي المحفزة للغضب', 'استراتيجيات التعامل مع الغضب', 'دور الجانب الروحي في إدارة الغضب', 'برنامج التحكم في الغضب'],
            'en' => ['The concept and types of anger', 'Stages of anger', 'Causes of anger', 'An integrated approach to controlling anger', 'Negative thinking patterns that trigger anger', 'Strategies for dealing with anger', 'The spiritual side of anger management', 'Anger control program'],
        ],
    ],

];
