<?php

/*
| Facts about the center shown on the site, as given by the center (2026-11-03).
| Change them here and every page (and the search-engine data) follows.
*/

return [

    // Open every day except Friday
    'hours' => [
        'ar'     => 'السبت – الخميس: 9 صباحًا – 9 مساءً · الجمعة مغلق',
        'en'     => 'Saturday – Thursday: 9 am – 9 pm · Closed on Friday',
        'days'   => ['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday'],
        'opens'  => '09:00',
        'closes' => '21:00',
    ],

    // Consultation prices in KWD
    'prices' => [
        'specialist'         => 50, // a one-to-one session with a specialist
        'dr_tariq_first'     => 80, // first session with Prof. Dr. Tariq Al-Habib
        'dr_tariq_follow_up' => 60, // follow-up session with him
    ],

    // Session length
    'session_length' => ['ar' => 'من 45 دقيقة إلى ساعة', 'en' => '45 minutes to an hour'],
];
