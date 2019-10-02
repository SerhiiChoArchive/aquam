<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Aqua-m',
            'email' => 'admin@main.com',
            'password' => Hash::make(config('app.password')),
        ]);
    }
}
