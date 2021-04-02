<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => "Javier Aliaga",
            'email' => "reivaj_31@hotmail.com",
            'password' => Hash::make("12345678"),
        ]);
    }
}
