<?php

/*
 | Marketing figures, ratings and quotes that the center has not confirmed yet
 | (e.g. "+4,800 consultations", "97% satisfaction", named testimonials, star ratings).
 | They stay in the templates but are hidden until the center confirms them;
 | set SHOW_UNVERIFIED_CLAIMS=true only once every figure has a source.
 */
return [
    'show_unverified' => (bool) env('SHOW_UNVERIFIED_CLAIMS', false),
];
