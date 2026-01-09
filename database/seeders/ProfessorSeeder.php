<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfessorSeeder extends Seeder
{
    public function run(): void
    {
        $professores = [
            ['nome' => 'Maria Eduarda Santos', 'email' => 'maria.santos@codevilla.edu.br', 'especialidade' => 'Matemática'],
            ['nome' => 'João Pedro Silva', 'email' => 'joao.silva@codevilla.edu.br', 'especialidade' => 'Português'],
            ['nome' => 'Ana Carolina Costa', 'email' => 'ana.costa@codevilla.edu.br', 'especialidade' => 'História'],
            ['nome' => 'Carlos Eduardo Lima', 'email' => 'carlos.lima@codevilla.edu.br', 'especialidade' => 'Geografia'],
            ['nome' => 'Fernanda Oliveira', 'email' => 'fernanda.oliveira@codevilla.edu.br', 'especialidade' => 'Ciências'],
            ['nome' => 'Rafael Martins', 'email' => 'rafael.martins@codevilla.edu.br', 'especialidade' => 'Educação Física'],
            ['nome' => 'Patricia Almeida', 'email' => 'patricia.almeida@codevilla.edu.br', 'especialidade' => 'Inglês'],
            ['nome' => 'Roberto Ferreira', 'email' => 'roberto.ferreira@codevilla.edu.br', 'especialidade' => 'Arte'],
        ];

        foreach ($professores as $professor) {
            // Criar usuário professor
            $userId = DB::table('users')->insertGetId([
                'name' => $professor['nome'],
                'email' => $professor['email'],
                'password' => Hash::make('professor123'),
                'role' => 'professor',
                'is_active' => true,
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Criar registro de professor (se houver tabela separada)
            // Aqui você pode adicionar lógica adicional se tiver uma tabela 'professores' separada
        }
    }
}
