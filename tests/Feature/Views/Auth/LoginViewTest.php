<?php

declare(strict_types=1);

namespace Tests\Feature\Views\Auth;

use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoginViewTest extends TestCase
{
    use DatabaseTransactions;

    private string $path;
    private User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->path = route('login');
        $this->user = User::factory()->create();
    }

    /** @test */
    public function user_cant_see_the_page(): void
    {
        $this->actingAs(User::factory()->make())->get($this->path)->assertRedirect();
    }

    /** @test */
    public function guest_can_see_the_page(): void
    {
        $this->get($this->path)->assertOk()->assertViewIs('auth.login');
    }

    /** @test */
    public function user_can_login(): void
    {
        $form_data = [
            'email' => $this->user->email,
            'password' => 'password'
        ];

        $this->get(route('login'));

        $this->post($this->path, $form_data)
            ->assertRedirect(action('DashboardController@index'));
    }

    /**
     * We will login user and create cookie to check them
     *
     * @test
     */
    public function remember_me_functionality_works(): void
    {
        $response = $this->post('/login', [
            'email' => $this->user->email,
            'password' => 'password',
            'remember' => 'on',
        ]);

        // Creating cookie
        $cookie = vsprintf('%s|%s|%s', [
            $this->user->id,
            $this->user->getRememberToken(),
            $this->user->password,
        ]);

        $response->assertCookie(Auth::guard()->getRecallerName(), $cookie);
    }
}
