<?php

namespace Database\Seeders;

use App\Models\User;
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
            'name' => 'Kenil Shah',
            'email' => 'kenilshah1106@gmail.com',
            'password' => Hash::make('abcd1234'),
            'about' => 'Some description about me',
            'location' => 'India',
            'reputation' => rand(100, 200),
            'role' => User::ADMIN
        ]);
    }
}
