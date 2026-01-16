<?php

namespace Database\Seeders;

use App\Domains\Alunos\Models\Aluno;
use App\Domains\Alunos\Models\Turma;
use Illuminate\Database\Seeder;

class AlunoSeeder extends Seeder
{
    /**
     * Remove acentos de uma string para normalizar a ordenação
     */
    private function removerAcentos(string $string): string
    {
        $mapa = [
            'á' => 'a',
            'à' => 'a',
            'ã' => 'a',
            'â' => 'a',
            'ä' => 'a',
            'é' => 'e',
            'è' => 'e',
            'ê' => 'e',
            'ë' => 'e',
            'í' => 'i',
            'ì' => 'i',
            'î' => 'i',
            'ï' => 'i',
            'ó' => 'o',
            'ò' => 'o',
            'õ' => 'o',
            'ô' => 'o',
            'ö' => 'o',
            'ú' => 'u',
            'ù' => 'u',
            'û' => 'u',
            'ü' => 'u',
            'ç' => 'c',
            'ñ' => 'n',
            'Á' => 'A',
            'À' => 'A',
            'Ã' => 'A',
            'Â' => 'A',
            'Ä' => 'A',
            'É' => 'E',
            'È' => 'E',
            'Ê' => 'E',
            'Ë' => 'E',
            'Í' => 'I',
            'Ì' => 'I',
            'Î' => 'I',
            'Ï' => 'I',
            'Ó' => 'O',
            'Ò' => 'O',
            'Õ' => 'O',
            'Ô' => 'O',
            'Ö' => 'O',
            'Ú' => 'U',
            'Ù' => 'U',
            'Û' => 'U',
            'Ü' => 'U',
            'Ç' => 'C',
            'Ñ' => 'N',
        ];

        return strtr($string, $mapa);
    }

    public function run(): void
    {
        try {
            // Verificar se existem turmas
            $turmas = Turma::all();

            if ($turmas->isEmpty()) {
                $this->command->warn("⚠️  Nenhuma turma encontrada. Execute TurmaSeeder primeiro.");
                return;
            }

            // Lista de nomes reais brasileiros com acentuação
            $nomes = [
                'Ana Clara Silva',
                'André Felipe Santos',
                'Ângela Maria Costa',
                'Bruno Henrique Oliveira',
                'Beatriz Helena Lima',
                'Carlos Eduardo Souza',
                'Caio Vinicius Rocha',
                'Célia Cristina Alves',
                'Daniela Ferreira Costa',
                'Diego Martins Silva',
                'Eduardo Santos Pereira',
                'Érica Fernandes Lima',
                'Fabiana Cristina Costa',
                'Felipe Augusto Santos',
                'Fernanda Alves Martins',
                'Gabriel Henrique Rocha',
                'Giovanna Silva Costa',
                'Gustavo Luís Oliveira',
                'Helena Maria Santos',
                'Henrique César Lima',
                'Igor Rodrigues Almeida',
                'Isabela Maria Costa',
                'João Pedro Silva',
                'José Carlos Santos',
                'Juliana Beatriz Oliveira',
                'Júlio César Lima',
                'Kamila Fernandes Costa',
                'Kevin Lucas Silva',
                'Larissa Fernandes Santos',
                'Leonardo Gabriel Rocha',
                'Lívia Cristina Costa',
                'Lucas Matheus Silva',
                'Mariana Beatriz Santos',
                'Mateus Gabriel Lima',
                'Matheus Augusto Costa',
                'Miguel Henrique Silva',
                'Natália Cristina Santos',
                'Nicolas Eduardo Lima',
                'Olivia Isabella Costa',
                'Otávio Gabriel Silva',
                'Paula Regina Santos',
                'Pedro Henrique Lima',
                'Rafael Eduardo Costa',
                'Raquel Fernandes Silva',
                'Ricardo José Santos',
                'Rodrigo Alves Lima',
                'Sophia Isabella Costa',
                'Tânia Maria Silva',
                'Thiago Henrique Santos',
                'Valentina Maria Lima',
                'Vítor Hugo Costa',
                'William Lucas Silva',
                'Yasmin Gabriela Santos',
                'Yuri Gabriel Lima',
                'Zélia Cristina Costa'
            ];

            $totalAlunos = 0;

            foreach ($turmas as $turma) {
                $this->command->info("  → Criando alunos para turma: {$turma->nome}");

                // Selecionar 25 nomes aleatórios para esta turma
                $nomesParaTurma = [];
                $nomesDisponiveis = $nomes;
                shuffle($nomesDisponiveis);

                for ($i = 0; $i < min(25, count($nomesDisponiveis)); $i++) {
                    $nomesParaTurma[] = $nomesDisponiveis[$i];
                }

                // Ordenar nomes alfabeticamente removendo acentos
                usort($nomesParaTurma, function ($a, $b) {
                    return strcoll(
                        mb_strtolower($this->removerAcentos($a)),
                        mb_strtolower($this->removerAcentos($b))
                    );
                });

                // Criar alunos com numero_chamada baseado na ordem alfabética
                foreach ($nomesParaTurma as $index => $nome) {
                    Aluno::firstOrCreate(
                        [
                            'nome' => $nome,
                            'turma_id' => $turma->id,
                        ],
                        [
                            'numero_chamada' => $index + 1,
                            'foto' => null,
                        ]
                    );
                }

                $totalAlunos += count($nomesParaTurma);
            }

            $this->command->info("✓ Criados {$totalAlunos} alunos distribuídos em " . $turmas->count() . " turmas");
        } catch (\Exception $e) {
            $this->command->error("❌ Erro ao criar alunos: {$e->getMessage()}");
            throw $e;
        }
    }
}
