<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DevelopmentSeeder extends Seeder
{
    /**
     * Seed para ambientes de desenvolvimento/teste.
     * Popula o banco com dados fictícios para testes.
     */
    public function run(): void
    {
        $this->command->warn("⚠️  ATENÇÃO: Populando banco com dados FICTÍCIOS para desenvolvimento");
        $this->command->info("🔧 Executando seeders de desenvolvimento...");

        // 1. Usuários (professores, coordenação)
        if (class_exists('Database\Seeders\UserSeeder')) {
            $this->call(UserSeeder::class);
        }

        if (class_exists('Database\Seeders\ProfessorSeeder')) {
            $this->call(ProfessorSeeder::class);
        }

        // 2. Turmas
        if (class_exists('Database\Seeders\TurmaSeeder')) {
            $this->call(TurmaSeeder::class);
        }

        // 3. Alunos
        if (class_exists('Database\Seeders\AlunoSeeder')) {
            $this->call(AlunoSeeder::class);
        }

        // 4. Atribuições professor-disciplina-turma
        $this->call(AtribuicaoSeeder::class);

        // 5. Avaliações (se existir)
        if (class_exists(\Database\Seeders\AvaliacaoSeeder::class)) {
            $this->call(\Database\Seeders\AvaliacaoSeeder::class);
        }

        $this->command->info("✓ Seeders de desenvolvimento concluídos!");
    }
}
