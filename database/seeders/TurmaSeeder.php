<?php

namespace Database\Seeders;

use App\Domains\Alunos\Models\Turma;
use Illuminate\Database\Seeder;

class TurmaSeeder extends Seeder
{
    public function run(): void
    {
        $anoLetivo = date('Y');

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

        foreach ($turmas as $turmaData) {
            Turma::create($turmaData);
        }
    }
}
