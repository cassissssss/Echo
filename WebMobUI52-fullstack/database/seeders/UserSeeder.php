<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Crée un utilisateur administrateur par défaut si l'email n'existe pas déjà.
     */
    public function run(): void
    {
        if (!User::where('email', 'admin@echo.ch')->exists()) {
            User::create([
                'name' => 'Admin',
                'email' => 'admin@echo.ch',
                'password' => Hash::make('1234'),
            ]);
        }
    }
}
