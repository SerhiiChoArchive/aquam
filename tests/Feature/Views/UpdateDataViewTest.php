<?php

declare(strict_types=1);

namespace Tests\Feature\Views;

use App\Http\Controllers\PriceListController;
use App\Models\User;
use Tests\TestCase;

class UpdateDataViewTest extends TestCase
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
     */
    private $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->path = action('UpdateDataController@index');
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