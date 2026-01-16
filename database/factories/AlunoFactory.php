<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Domains\Alunos\Models\{Aluno, Turma};

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Domains\Alunos\Models\Aluno>
 */
class AlunoFactory extends Factory
{
    protected $model = Aluno::class;

    public function definition(): array
    {
        return [
            'uuid' => Str::uuid(),
            'nome' => fake()->name(),
            'numero_chamada' => fake()->numberBetween(1, 40),
            'turma_id' => Turma::factory(),
            'foto' => null,
            'ativo' => true,
        ];
    }

    public function forTurma(int $turmaId): static
    {
        return $this->state(fn(array $attributes) => ['turma_id' => $turmaId]);
    }

    public function inactive(): static
    {
        return $this->state(fn(array $attributes) => ['ativo' => false]);
    }

    public function withPhoto(): static
    {
        return $this->state(fn(array $attributes) => [
            'foto' => 'fotos/alunos/' . fake()->uuid() . '.jpg',
        ]);
    }
}
