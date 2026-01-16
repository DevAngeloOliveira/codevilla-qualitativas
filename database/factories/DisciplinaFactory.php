<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Domains\Disciplinas\Models\Disciplina;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Domains\Disciplinas\Models\Disciplina>
 */
class DisciplinaFactory extends Factory
{
    protected $model = Disciplina::class;

    public function definition(): array
    {
        $disciplinas = [
            ['nome' => 'Português', 'codigo' => 'PORT'],
            ['nome' => 'Matemática', 'codigo' => 'MAT'],
            ['nome' => 'Ciências', 'codigo' => 'CIEN'],
            ['nome' => 'História', 'codigo' => 'HIST'],
            ['nome' => 'Geografia', 'codigo' => 'GEO'],
        ];

        $disciplina = fake()->randomElement($disciplinas);

        return [
            'nome' => $disciplina['nome'],
            'codigo' => $disciplina['codigo'],
            'segmento' => 'Ensino Fundamental II',
            'ativa' => true,
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn(array $attributes) => ['ativa' => false]);
    }
}
