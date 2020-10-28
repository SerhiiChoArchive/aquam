<?php

declare(strict_types=1);

namespace Tests\Feature\Views;

use App\Models\User;
use Tests\TestCase;

class PriceListViewTest extends TestCase
{
    private string $path;
    private User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->path = action('PriceListController@index');
        $this->user = User::factory()->create();
    }

    /** @test */
    public function guest_cant_visit_the_page(): void
    {
        $this->get($this->path)->assertRedirect(route('login'));
    }

    /** @test */
    public function user_can_visit_the_page(): void
    {
        $this->actingAs($this->user)->get($this->path)->assertSuccessful();
    }
}