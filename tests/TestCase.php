<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Http;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // No test may reach a real outside service (MyFatoorah, deema, the center system…):
        // any HTTP call that a test has not faked with Http::fake() throws instead of going out.
        Http::preventStrayRequests();

        // The seeded anger-management course is on 2026-10-28: pin "now" before it so the
        // suite doesn't start failing once that date has passed. Tests may travel elsewhere.
        $this->travelTo('2026-10-25 12:00:00');
    }
}
