<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,          // Usuários (desenvolvedor, coordenação, professor teste)
            CriterioSeeder::class,      // Critérios de avaliação
            DisciplinaSeeder::class,    // Disciplinas
            TurmaSeeder::class,         // Turmas
            AlunoSeeder::class,         // Alunos
            ProfessorSeeder::class,     // Professores adicionais
            AtribuicaoSeeder::class,    // Atribuições professor-disciplina-turma
        ]);
    }
}
