<?php declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Tests\TestCase;

final class UploadFileTest extends TestCase
{
    /** @test */
    public function user_sees_success_message_is_password_is_correct_and_file_is_present(): void
    {
        $this->post(action('UploadController@upload'), [
            'password' => config('app.password'),
            'file' => new UploadedFile(storage_path('price.xls'), 'price.xls', 'application/vnd.ms-excel'),
        ])->assertSessionHas('success');
    }

    /** @test */
    public function user_sees_error_message_if_password_is_empty(): void
    {
        $this->post(action('UploadController@upload'), [
            'password' => '',
            'file' => new UploadedFile(storage_path('price.xls'), 'price.xls', 'application/vnd.ms-excel'),
        ])->assertSessionHas('error');
    }

    /** @test */
    public function user_sees_error_message_if_file_is_missing(): void
    {
        $this->post(action('UploadController@upload'), [
            'password' => config('app.password'),
        ])->assertSessionHas('error');
    }

    /** @test */
    public function user_sees_error_message_if_file_is_empty(): void
    {
        $this->post(action('UploadController@upload'), [
            'password' => config('app.password'),
            'file' => '',
        ])->assertSessionHas('error');
    }
}
