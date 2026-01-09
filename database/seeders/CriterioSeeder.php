<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CriterioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $criterios = [
            // Grupo 1: Assiduidade e postura
            ['codigo' => 'c1', 'grupo' => 'Assiduidade e postura', 'titulo' => 'Frequência e pontualidade', 'descricao' => 'Avalia a presença e pontualidade do aluno nas aulas', 'peso' => 0.6, 'ordem' => 1],
            ['codigo' => 'c2', 'grupo' => 'Assiduidade e postura', 'titulo' => 'Postura e disciplina em sala', 'descricao' => 'Avalia o comportamento e disciplina do aluno durante as aulas', 'peso' => 0.6, 'ordem' => 2],

            // Grupo 2: Engajamento acadêmico
            ['codigo' => 'c3', 'grupo' => 'Engajamento acadêmico', 'titulo' => 'Participação ativa nas aulas', 'descricao' => 'Avalia o envolvimento e participação do aluno nas atividades', 'peso' => 0.8, 'ordem' => 3],
            ['codigo' => 'c4', 'grupo' => 'Engajamento acadêmico', 'titulo' => 'Engajamento cognitivo', 'descricao' => 'Avalia o interesse e envolvimento mental nas atividades', 'peso' => 0.8, 'ordem' => 4],

            // Grupo 3: Responsabilidade e execução
            ['codigo' => 'c5', 'grupo' => 'Responsabilidade e execução', 'titulo' => 'Entrega das atividades', 'descricao' => 'Avalia a pontualidade e qualidade na entrega de tarefas', 'peso' => 1.0, 'ordem' => 5],
            ['codigo' => 'c6', 'grupo' => 'Responsabilidade e execução', 'titulo' => 'Organização do caderno/livro', 'descricao' => 'Avalia a organização e cuidado com materiais escolares', 'peso' => 1.0, 'ordem' => 6],
            ['codigo' => 'c7', 'grupo' => 'Responsabilidade e execução', 'titulo' => 'Vistos e correções realizadas', 'descricao' => 'Avalia se o aluno realiza correções e busca vistos', 'peso' => 1.0, 'ordem' => 7],

            // Grupo 4: Relações e socioemocional
            ['codigo' => 'c8', 'grupo' => 'Relações e socioemocional', 'titulo' => 'Respeito ao professor', 'descricao' => 'Avalia o respeito e consideração com o professor', 'peso' => 0.7, 'ordem' => 8],
            ['codigo' => 'c9', 'grupo' => 'Relações e socioemocional', 'titulo' => 'Respeito aos colegas', 'descricao' => 'Avalia o respeito e convivência com os colegas', 'peso' => 0.7, 'ordem' => 9],
            ['codigo' => 'c10', 'grupo' => 'Relações e socioemocional', 'titulo' => 'Colaboração em grupo', 'descricao' => 'Avalia a capacidade de trabalhar em equipe', 'peso' => 0.7, 'ordem' => 10],

            // Grupo 5: Autonomia e evolução
            ['codigo' => 'c11', 'grupo' => 'Autonomia e evolução', 'titulo' => 'Autonomia', 'descricao' => 'Avalia a capacidade de trabalhar de forma independente', 'peso' => 0.7, 'ordem' => 11],
            ['codigo' => 'c12', 'grupo' => 'Autonomia e evolução', 'titulo' => 'Evolução ao longo do trimestre', 'descricao' => 'Avalia o progresso e desenvolvimento do aluno', 'peso' => 0.7, 'ordem' => 12],
        ];

        foreach ($criterios as $criterio) {
            DB::table('criterios')->insert([
                'codigo' => $criterio['codigo'],
                'grupo' => $criterio['grupo'],
                'titulo' => $criterio['titulo'],
                'descricao' => $criterio['descricao'],
                'peso' => $criterio['peso'],
                'ordem' => $criterio['ordem'],
                'ativo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
