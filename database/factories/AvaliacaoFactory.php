<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Domains\Avaliacoes\Models\Avaliacao;
use App\Domains\Alunos\Models\{Aluno, Turma};
use App\Domains\Disciplinas\Models\Disciplina;
use App\Domains\Usuarios\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Domains\Avaliacoes\Models\Avaliacao>
 */
class AvaliacaoFactory extends Factory
{
    protected $model = Avaliacao::class;

    public function definition(): array
    {
        return [
            'aluno_id' => Aluno::factory(),
            'professor_id' => User::factory()->professor(),
            'disciplina_id' => Disciplina::factory(),
            'turma_id' => Turma::factory(),
            'trimestre' => fake()->numberBetween(1, 3),
            'ano_letivo' => date('Y'),
            'criterios_versao' => '1.0',
            'nota_final' => fake()->randomFloat(2, 0, 10),
            'observacoes' => fake()->optional()->paragraph(),
            'finalizada' => false,
        ];
    }

    public function finalizada(): static
    {
        return $this->state(fn(array $attributes) => ['finalizada' => true]);
    }

    public function trimestre(int $trimestre): static
    {
        return $this->state(fn(array $attributes) => ['trimestre' => $trimestre]);
    }

    public function semObservacoes(): static
    {
        return $this->state(fn(array $attributes) => ['observacoes' => null]);
    }
}
