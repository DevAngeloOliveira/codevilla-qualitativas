<?php

namespace Tests\Feature;

use App\Domains\Usuarios\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfessorRoutesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testa acesso de professor ao dashboard de professor.
     */
    public function test_professor_can_access_professor_dashboard(): void
    {
        $user = User::factory()->create(['role' => 'professor']);

        $response = $this->actingAs($user)->get('/professor/dashboard');

        $response->assertStatus(200);
    }

    /**
     * Testa acesso de professor à listagem de avaliações.
     */
    public function test_professor_can_access_avaliacoes_index(): void
    {
        $user = User::factory()->create(['role' => 'professor']);

        $response = $this->actingAs($user)->get('/professor/avaliacoes');

        $response->assertStatus(200);
    }

    /**
     * Testa bloqueio de coordenação tentando acessar rotas de professor.
     */
    public function test_coordenacao_cannot_access_professor_avaliacoes(): void
    {
        $user = User::factory()->create(['role' => 'coordenacao']);

        $response = $this->actingAs($user)->get('/professor/avaliacoes');

        $response->assertStatus(403);
    }

    /**
     * Testa bloqueio de desenvolvedor tentando acessar rotas de professor.
     */
    public function test_desenvolvedor_cannot_access_professor_routes(): void
    {
        $user = User::factory()->create(['role' => 'desenvolvedor']);

        $response = $this->actingAs($user)->get('/professor/dashboard');

        $response->assertStatus(403);
    }
}
