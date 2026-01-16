<?php

namespace Database\Seeders;

use App\Domains\Alunos\Models\Turma;
use Illuminate\Database\Seeder;

class TurmaSeeder extends Seeder
{
    public function run(): void
    {
        try {
            $anoLetivo = config('seeders.ano_letivo_atual');

            $turmas = [
                ['nome' => '6 Ano A', 'ano_letivo' => $anoLetivo, 'turno' => 'Matutino', 'segmento' => 'Ensino Fundamental II', 'ativa' => true],
                ['nome' => '6 Ano B', 'ano_letivo' => $anoLetivo, 'turno' => 'Vespertino', 'segmento' => 'Ensino Fundamental II', 'ativa' => true],
                ['nome' => '7 Ano A', 'ano_letivo' => $anoLetivo, 'turno' => 'Matutino', 'segmento' => 'Ensino Fundamental II', 'ativa' => true],
                ['nome' => '7 Ano B', 'ano_letivo' => $anoLetivo, 'turno' => 'Vespertino', 'segmento' => 'Ensino Fundamental II', 'ativa' => true],
                ['nome' => '8 Ano A', 'ano_letivo' => $anoLetivo, 'turno' => 'Matutino', 'segmento' => 'Ensino Fundamental II', 'ativa' => true],
                ['nome' => '8 Ano B', 'ano_letivo' => $anoLetivo, 'turno' => 'Vespertino', 'segmento' => 'Ensino Fundamental II', 'ativa' => true],
                ['nome' => '9 Ano A', 'ano_letivo' => $anoLetivo, 'turno' => 'Matutino', 'segmento' => 'Ensino Fundamental II', 'ativa' => true],
                ['nome' => '9 Ano B', 'ano_letivo' => $anoLetivo, 'turno' => 'Vespertino', 'segmento' => 'Ensino Fundamental II', 'ativa' => true],
            ];

            $count = 0;
            foreach ($turmas as $turmaData) {
                Turma::firstOrCreate(
                    [
                        'nome' => $turmaData['nome'],
                        'ano_letivo' => $turmaData['ano_letivo']
                    ],
                    $turmaData
                );
                $count++;
            }

            $this->command->info("✓ Criadas {$count} turmas para o ano letivo {$anoLetivo}");
        } catch (\Exception $e) {
            $this->command->error("❌ Erro ao criar turmas: {$e->getMessage()}");
            throw $e;
        }
    }
}
