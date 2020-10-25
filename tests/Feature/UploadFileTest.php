<?php declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class UploadFileTest extends TestCase
{
    private $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /** @test */
    public function user_sees_error_message_if_file_is_missing(): void
    {
        $this->actingAs($this->user)->post(action('UploadController@upload'))->assertSessionHas('error');
    }

    /** @test */
    public function user_sees_error_message_if_file_is_empty(): void
    {
        $this->actingAs($this->user)
            ->post(action('UploadController@upload'), ['file' => ''])
            ->assertSessionHas('error');
    }
}
