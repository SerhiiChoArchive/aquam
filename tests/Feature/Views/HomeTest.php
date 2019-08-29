<?php declare(strict_types=1);

namespace Tests\Feature\Views;

use Tests\TestCase;

class HomeTest extends TestCase
{
    /** @test */
    public function any_user_can_visit_home_page(): void
    {
        $this->get(action('PageController@home'))
            ->assertOk()
            ->assertViewIs('home');
    }
}
