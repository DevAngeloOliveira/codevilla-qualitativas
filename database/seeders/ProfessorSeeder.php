<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Domains\Usuarios\Models\User;

class ProfessorSeeder extends Seeder
{
    public function run(): void
    {
        try {
            $professores = [
                ['nome' => 'Maria Eduarda Santos', 'email' => 'maria.santos@codevilla.edu.br', 'especialidade' => 'Matemática'],
                ['nome' => 'João Pedro Silva', 'email' => 'joao.silva@codevilla.edu.br', 'especialidade' => 'Português'],
                ['nome' => 'Ana Carolina Costa', 'email' => 'ana.costa@codevilla.edu.br', 'especialidade' => 'História'],
                ['nome' => 'Carlos Eduardo Lima', 'email' => 'carlos.lima@codevilla.edu.br', 'especialidade' => 'Geografia'],
                ['nome' => 'Fernanda Oliveira', 'email' => 'fernanda.oliveira@codevilla.edu.br', 'especialidade' => 'Ciências'],
                ['nome' => 'Rafael Martins', 'email' => 'rafael.martins@codevilla.edu.br', 'especialidade' => 'Educação Física'],
                ['nome' => 'Patricia Almeida', 'email' => 'patricia.almeida@codevilla.edu.br', 'especialidade' => 'Inglês'],
                ['nome' => 'Roberto Ferreira', 'email' => 'roberto.ferreira@codevilla.edu.br', 'especialidade' => 'Artes'],
            ];

            $count = 0;
            foreach ($professores as $professor) {
                User::firstOrCreate(
                    ['email' => $professor['email']],
                    [
                        'name' => $professor['nome'],
                        'password' => Hash::make('professor123'),
                        'role' => 'professor',
                        'is_active' => true,
                        'email_verified_at' => now(),
                    ]
                );
                $count++;
            }

            $this->command->info("✓ Criados {$count} professores");
        } catch (\Exception $e) {
            $this->command->error("❌ Erro ao criar professores: {$e->getMessage()}");
            throw $e;
        }
    }
}
