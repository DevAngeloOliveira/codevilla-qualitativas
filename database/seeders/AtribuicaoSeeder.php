<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AtribuicaoSeeder extends Seeder
{
    public function run(): void
    {
        // Buscar todos os professores (exceto coordenação e desenvolvedor)
        $professores = DB::table('users')
            ->where('role', 'professor')
            ->where('email', '!=', 'professor@codevilla.edu.br') // Excluir o professor de teste inicial
            ->pluck('id')
            ->toArray();

        // Buscar todas as disciplinas
        $disciplinas = DB::table('disciplinas')->pluck('id', 'nome')->toArray();

        // Buscar todas as turmas
        $turmas = DB::table('turmas')->pluck('id')->toArray();

        if (empty($professores)) {
            return; // Não há professores para atribuir
        }

        // Mapear especialidades dos professores com disciplinas
        $atribuicoes = [
            'maria.santos@codevilla.edu.br' => 'Matemática',
            'joao.silva@codevilla.edu.br' => 'Português',
            'ana.costa@codevilla.edu.br' => 'História',
            'carlos.lima@codevilla.edu.br' => 'Geografia',
            'fernanda.oliveira@codevilla.edu.br' => 'Ciências',
            'rafael.martins@codevilla.edu.br' => 'Educação Física',
            'patricia.almeida@codevilla.edu.br' => 'Inglês',
            'roberto.ferreira@codevilla.edu.br' => 'Arte',
        ];

        foreach ($atribuicoes as $email => $disciplinaNome) {
            $professor = DB::table('users')->where('email', $email)->first();

            if (!$professor || !isset($disciplinas[$disciplinaNome])) {
                continue;
            }

            $disciplinaId = $disciplinas[$disciplinaNome];

            // Atribuir professor à disciplina
            DB::table('professor_disciplina')->insert([
                'user_id' => $professor->id,
                'disciplina_id' => $disciplinaId,
            ]);

            // Atribuir professor a todas as turmas para sua disciplina
            foreach ($turmas as $turmaId) {
                DB::table('professor_turma')->insert([
                    'user_id' => $professor->id,
                    'turma_id' => $turmaId,
                    'disciplina_id' => $disciplinaId,
                    'ano_letivo' => date('Y'),
                ]);
            }
        }
    }
}
