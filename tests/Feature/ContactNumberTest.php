<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactNumberTest extends TestCase
{
    use RefreshDatabase;

    public function test_every_page_uses_the_one_center_number(): void
    {
        foreach (['/', '/courses', '/packages', '/sessions', '/consultations', '/policies'] as $page) {
            $this->get($page)->assertOk()
                ->assertSee('wa.me/96556551112', false)
                ->assertSee('+965 56551112')
                ->assertDontSee('55665161')
                ->assertDontSee('99880140');
        }
    }
}
