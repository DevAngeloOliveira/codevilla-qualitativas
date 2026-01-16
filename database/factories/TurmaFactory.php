<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Domains\Alunos\Models\Turma;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Domains\Alunos\Models\Turma>
 */
class TurmaFactory extends Factory
{
    protected $model = Turma::class;

    public function definition(): array
    {
        $anos = ['6º', '7º', '8º', '9º'];
        $letras = ['A', 'B', 'C'];

        return [
            'uuid' => Str::uuid(),
            'nome' => fake()->randomElement($anos) . ' ' . fake()->randomElement($letras),
            'ano_letivo' => date('Y'),
            'turno' => fake()->randomElement(['Matutino', 'Vespertino']),
            'segmento' => 'Ensino Fundamental II',
            'ativa' => true,
        ];
    }

    public function ano(int $ano): static
    {
        return $this->state(fn(array $attributes) => ['ano_letivo' => $ano]);
    }

    public function inactive(): static
    {
        return $this->state(fn(array $attributes) => ['ativa' => false]);
    }
}
