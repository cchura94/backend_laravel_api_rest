<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // crear usuarios
        $user = new User();
        $user->name = "admin";
        $user->email = "admin@mail.com";
        $user->password = "admin54321";
        $user->save();
    }
}
