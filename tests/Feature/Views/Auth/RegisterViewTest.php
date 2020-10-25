<?php

declare(strict_types=1);

namespace Tests\Feature\Views\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RegisterViewTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var string
     */
    private $path;

    public function setUp(): void
    {
        parent::setUp();
        $this->path = route('register');
    }

    public function auth_user_cant_see_the_page(): void
    {
        $this->actingAs(User::factory()->make())->get($this->path)->assertRedirect();
    }

    /** @test */
    public function guest_can_see_the_page(): void
    {
        $this->get($this->path)->assertOk()->assertViewIs('auth.register');
    }

    /** @test */
    public function new_user_can_register_with_correct_data(): void
    {
        $this->withoutExceptionHandling();

        $form_data = [
            'name' => 'Anna Korot',
            'email' => 'interesting@mail.com',
            'password' => 'test-password',
            'password_confirmation' => 'test-password',
        ];

        $this->post($this->path, $form_data);
        $this->assertDatabaseHas('users', ['email' => $form_data['email']]);
    }
}
