<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Domains\Usuarios\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'role' => 'professor',
            'is_active' => true,
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the user is a professor.
     */
    public function professor(): static
    {
        return $this->state(fn(array $attributes) => [
            'role' => 'professor',
        ]);
    }

    /**
     * Indicate that the user is coordenacao.
     */
    public function coordenacao(): static
    {
        return $this->state(fn(array $attributes) => [
            'role' => 'coordenacao',
        ]);
    }

    /**
     * Indicate that the user is desenvolvedor.
     */
    public function desenvolvedor(): static
    {
        return $this->state(fn(array $attributes) => [
            'role' => 'desenvolvedor',
        ]);
    }

    /**
     * Indicate that the user is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_active' => false,
        ]);
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
