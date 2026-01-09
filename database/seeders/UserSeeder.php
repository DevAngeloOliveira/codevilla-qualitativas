<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Usuário Desenvolvedor (Superadmin)
        DB::table('users')->insert([
            'name' => 'Desenvolvedor Codevilla',
            'email' => 'dev@codevilla.edu.br',
            'password' => Hash::make('dev@codevilla2026'),
            'role' => 'desenvolvedor',
            'is_active' => true,
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Usuário Coordenação
        DB::table('users')->insert([
            'name' => 'Coordenação Codevilla',
            'email' => 'coord@codevilla.edu.br',
            'password' => Hash::make('password123'),
            'role' => 'coordenacao',
            'is_active' => true,
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Usuário Professor de Teste
        DB::table('users')->insert([
            'name' => 'Professor Teste',
            'email' => 'professor@codevilla.edu.br',
            'password' => Hash::make('password123'),
            'role' => 'professor',
            'is_active' => true,
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
