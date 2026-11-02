<?php

/*
 | Marketing figures, ratings and quotes that the center has not confirmed yet
 | (e.g. "+4,800 consultations", "97% satisfaction", named testimonials, star ratings).
 | They stay in the templates but are hidden.
 |
 | This is fixed in code on purpose, not read from .env: showing them again must be a
 | reviewed code change made only after the center confirms every figure, never a
 | server setting someone can flip by mistake. Tests\Feature\Phase1CleanupTest checks it.
 */
return [
    'show_unverified' => false,
];
