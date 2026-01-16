<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Domains\Usuarios\Models\User;
use App\Domains\Disciplinas\Models\Disciplina;
use App\Domains\Alunos\Models\Turma;

class AtribuicaoSeeder extends Seeder
{
    public function run(): void
    {
        try {
            // Verificar se existem dados básicos necessários
            if (User::where('role', 'professor')->count() === 0) {
                $this->command->warn("⚠️  Nenhum professor encontrado. Execute UserSeeder ou ProfessorSeeder primeiro.");
                return;
            }

            if (Disciplina::count() === 0) {
                $this->command->warn("⚠️  Nenhuma disciplina encontrada. Execute DisciplinaSeeder primeiro.");
                return;
            }

            if (Turma::count() === 0) {
                $this->command->warn("⚠️  Nenhuma turma encontrada. Execute TurmaSeeder primeiro.");
                return;
            }

            // Buscar todas as disciplinas
            $disciplinas = Disciplina::pluck('id', 'nome')->toArray();

            // Buscar todas as turmas
            $turmas = Turma::pluck('id')->toArray();

            // Ano letivo atual
            $anoLetivo = config('seeders.ano_letivo_atual');

            // Mapear especialidades dos professores com disciplinas (corrigido: Arte → Artes)
            $atribuicoes = [
                'maria.santos@codevilla.edu.br' => 'Matemática',
                'joao.silva@codevilla.edu.br' => 'Português',
                'ana.costa@codevilla.edu.br' => 'História',
                'carlos.lima@codevilla.edu.br' => 'Geografia',
                'fernanda.oliveira@codevilla.edu.br' => 'Ciências',
                'rafael.martins@codevilla.edu.br' => 'Educação Física',
                'patricia.almeida@codevilla.edu.br' => 'Inglês',
                'roberto.ferreira@codevilla.edu.br' => 'Artes',  // CORRIGIDO: Arte → Artes
            ];

            $countProfessores = 0;
            $countAtribuicoes = 0;

            foreach ($atribuicoes as $email => $disciplinaNome) {
                $professor = User::where('email', $email)->first();

                if (!$professor) {
                    $this->command->warn("⚠️  Professor com email {$email} não encontrado");
                    continue;
                }

                if (!isset($disciplinas[$disciplinaNome])) {
                    $this->command->warn("⚠️  Disciplina '{$disciplinaNome}' não encontrada");
                    continue;
                }

                $disciplinaId = $disciplinas[$disciplinaNome];

                // Atribuir professor à disciplina (idempotente)
                DB::table('professor_disciplina')->insertOrIgnore([
                    'user_id' => $professor->id,
                    'disciplina_id' => $disciplinaId,
                ]);

                $countProfessores++;

                // Atribuir professor a todas as turmas para sua disciplina
                foreach ($turmas as $turmaId) {
                    DB::table('professor_turma')->insertOrIgnore([
                        'user_id' => $professor->id,
                        'turma_id' => $turmaId,
                        'disciplina_id' => $disciplinaId,
                        'ano_letivo' => $anoLetivo,
                    ]);
                    $countAtribuicoes++;
                }
            }

            $this->command->info("✓ Atribuídos {$countProfessores} professores às suas disciplinas");
            $this->command->info("✓ Criadas {$countAtribuicoes} atribuições professor-turma-disciplina");
        } catch (\Exception $e) {
            $this->command->error("❌ Erro ao criar atribuições: {$e->getMessage()}");
            throw $e;
        }
    }
}
