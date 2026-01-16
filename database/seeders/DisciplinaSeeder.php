<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Domains\Disciplinas\Models\Disciplina;

class DisciplinaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            $disciplinas = config('seeders.disciplinas');

            $count = 0;
            foreach ($disciplinas as $disciplina) {
                Disciplina::firstOrCreate(
                    ['codigo' => $disciplina['codigo']],
                    [
                        'nome' => $disciplina['nome'],
                        'segmento' => $disciplina['segmento'],
                        'ativa' => $disciplina['ativa'],
                    ]
                );
                $count++;
            }

            $this->command->info("✓ Criadas {$count} disciplinas");
        } catch (\Exception $e) {
            $this->command->error("❌ Erro ao criar disciplinas: {$e->getMessage()}");
            throw $e;
        }
    }
}
