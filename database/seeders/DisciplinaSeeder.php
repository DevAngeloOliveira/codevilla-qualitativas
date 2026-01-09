<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DisciplinaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $disciplinas = [
            ['nome' => 'Português', 'codigo' => 'PORT', 'segmento' => 'Ensino Fundamental II'],
            ['nome' => 'Matemática', 'codigo' => 'MAT', 'segmento' => 'Ensino Fundamental II'],
            ['nome' => 'Ciências', 'codigo' => 'CIEN', 'segmento' => 'Ensino Fundamental II'],
            ['nome' => 'História', 'codigo' => 'HIST', 'segmento' => 'Ensino Fundamental II'],
            ['nome' => 'Geografia', 'codigo' => 'GEO', 'segmento' => 'Ensino Fundamental II'],
            ['nome' => 'Inglês', 'codigo' => 'ING', 'segmento' => 'Ensino Fundamental II'],
            ['nome' => 'Educação Física', 'codigo' => 'ED_FIS', 'segmento' => 'Ensino Fundamental II'],
            ['nome' => 'Artes', 'codigo' => 'ART', 'segmento' => 'Ensino Fundamental II'],
            ['nome' => 'Filosofia', 'codigo' => 'FIL', 'segmento' => 'Ensino Fundamental II'],
            ['nome' => 'Ensino Religioso', 'codigo' => 'ENS_REL', 'segmento' => 'Ensino Fundamental II'],
        ];

        foreach ($disciplinas as $disciplina) {
            DB::table('disciplinas')->insert([
                'nome' => $disciplina['nome'],
                'codigo' => $disciplina['codigo'],
                'segmento' => $disciplina['segmento'],
                'ativa' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
