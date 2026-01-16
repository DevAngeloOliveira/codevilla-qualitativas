<?php

namespace Tests\Feature;

use App\Domains\Disciplinas\Models\Disciplina;
use App\Domains\Alunos\Models\Turma;
use App\Domains\Usuarios\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminRoutesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testa acesso de coordenação à listagem de turmas.
     */
    public function test_coordenacao_can_access_turmas_index(): void
    {
        $user = User::factory()->create(['role' => 'coordenacao']);

        $response = $this->actingAs($user)->get('/admin/turmas');

        $response->assertStatus(200);
    }

    /**
     * Testa acesso de coordenação à criação de turma.
     */
    public function test_coordenacao_can_access_turmas_create(): void
    {
        $user = User::factory()->create(['role' => 'coordenacao']);

        $response = $this->actingAs($user)->get('/admin/turmas/create');

        $response->assertStatus(200);
    }

    /**
     * Testa criação de turma por coordenação.
     */
    public function test_coordenacao_can_create_turma(): void
    {
        $user = User::factory()->create(['role' => 'coordenacao']);

        $response = $this->actingAs($user)->post('/admin/turmas', [
            'nome' => 'Turma A',
            'ano_letivo' => '2026',
            'turno' => 'matutino',
            'etapa_ensino' => '1º Ano',
        ]);

        $response->assertRedirect('/admin/turmas');
        $this->assertDatabaseHas('turmas', [
            'nome' => 'Turma A',
            'ano_letivo' => '2026',
        ]);
    }

    /**
     * Testa acesso de coordenação à listagem de disciplinas.
     */
    public function test_coordenacao_can_access_disciplinas_index(): void
    {
        $user = User::factory()->create(['role' => 'coordenacao']);

        $response = $this->actingAs($user)->get('/admin/disciplinas');

        $response->assertStatus(200);
    }

    /**
     * Testa criação de disciplina por coordenação.
     */
    public function test_coordenacao_can_create_disciplina(): void
    {
        $user = User::factory()->create(['role' => 'coordenacao']);

        $response = $this->actingAs($user)->post('/admin/disciplinas', [
            'nome' => 'Matemática',
            'codigo' => 'MAT001',
            'carga_horaria' => 60,
        ]);

        $response->assertRedirect('/admin/disciplinas');
        $this->assertDatabaseHas('disciplinas', [
            'nome' => 'Matemática',
            'codigo' => 'MAT001',
        ]);
    }

    /**
     * Testa acesso de coordenação à listagem de professores.
     */
    public function test_coordenacao_can_access_professores_index(): void
    {
        $user = User::factory()->create(['role' => 'coordenacao']);

        $response = $this->actingAs($user)->get('/admin/professores');

        $response->assertStatus(200);
    }

    /**
     * Testa bloqueio de professor tentando acessar rotas admin.
     */
    public function test_professor_cannot_access_admin_turmas(): void
    {
        $user = User::factory()->create(['role' => 'professor']);

        $response = $this->actingAs($user)->get('/admin/turmas');

        $response->assertStatus(403);
    }

    /**
     * Testa bloqueio de professor tentando criar turma.
     */
    public function test_professor_cannot_create_turma(): void
    {
        $user = User::factory()->create(['role' => 'professor']);

        $response = $this->actingAs($user)->post('/admin/turmas', [
            'nome' => 'Turma B',
            'ano_letivo' => '2026',
            'turno' => 'vespertino',
            'etapa_ensino' => '2º Ano',
        ]);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('turmas', [
            'nome' => 'Turma B',
        ]);
    }
}
