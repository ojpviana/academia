<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Administrador Geral',
            'email' => 'admin@gympro.com', // Seu e-mail de login
            'password' => Hash::make('admin123'), // Senha criptografada
            'role' => 'admin' // O cargo que dá acesso ao dashboard financeiro
        ]);
    }
}
