<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Domains\Usuarios\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            $users = [
                [
                    'name' => 'Desenvolvedor Codevilla',
                    'email' => 'dev@codevilla.edu.br',
                    'password' => 'dev@codevilla2026',
                    'role' => 'desenvolvedor',
                ],
                [
                    'name' => 'Coordenação Codevilla',
                    'email' => 'coord@codevilla.edu.br',
                    'password' => 'password123',
                    'role' => 'coordenacao',
                ],
                [
                    'name' => 'Professor Teste',
                    'email' => 'professor@codevilla.edu.br',
                    'password' => 'password123',
                    'role' => 'professor',
                ],
            ];

            $count = 0;
            foreach ($users as $userData) {
                User::firstOrCreate(
                    ['email' => $userData['email']],
                    [
                        'name' => $userData['name'],
                        'password' => Hash::make($userData['password']),
                        'role' => $userData['role'],
                        'is_active' => true,
                        'email_verified_at' => now(),
                    ]
                );
                $count++;
            }

            $this->command->info("✓ Criados {$count} usuários base");
        } catch (\Exception $e) {
            $this->command->error("❌ Erro ao criar usuários: {$e->getMessage()}");
            throw $e;
        }
    }
}
