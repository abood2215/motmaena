<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // The seeded anger-management course is on 2026-10-28: pin "now" before it so the
        // suite doesn't start failing once that date has passed. Tests may travel elsewhere.
        $this->travelTo('2026-10-25 12:00:00');
    }
}
