<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DesenvolvedorRoutesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testa acesso de desenvolvedor ao dashboard.
     */
    public function test_desenvolvedor_can_access_desenvolvedor_dashboard(): void
    {
        $user = User::factory()->create(['role' => 'desenvolvedor']);

        $response = $this->actingAs($user)->get('/desenvolvedor/dashboard');

        $response->assertStatus(200);
    }

    /**
     * Testa acesso de desenvolvedor à gestão de usuários.
     */
    public function test_desenvolvedor_can_access_users_management(): void
    {
        $user = User::factory()->create(['role' => 'desenvolvedor']);

        $response = $this->actingAs($user)->get('/desenvolvedor/users');

        $response->assertStatus(200);
    }

    /**
     * Testa criação de usuário por desenvolvedor.
     */
    public function test_desenvolvedor_can_create_user(): void
    {
        $developer = User::factory()->create(['role' => 'desenvolvedor']);

        $response = $this->actingAs($developer)->post('/desenvolvedor/users', [
            'name' => 'Novo Professor',
            'email' => 'professor.novo@test.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'professor',
        ]);

        $response->assertRedirect('/desenvolvedor/users');
        $this->assertDatabaseHas('users', [
            'email' => 'professor.novo@test.com',
            'role' => 'professor',
        ]);
    }

    /**
     * Testa bloqueio de coordenação tentando acessar rotas de desenvolvedor.
     */
    public function test_coordenacao_cannot_access_desenvolvedor_routes(): void
    {
        $user = User::factory()->create(['role' => 'coordenacao']);

        $response = $this->actingAs($user)->get('/desenvolvedor/dashboard');

        $response->assertStatus(403);
    }

    /**
     * Testa bloqueio de professor tentando acessar gestão de usuários.
     */
    public function test_professor_cannot_access_users_management(): void
    {
        $user = User::factory()->create(['role' => 'professor']);

        $response = $this->actingAs($user)->get('/desenvolvedor/users');

        $response->assertStatus(403);
    }

    /**
     * Testa bloqueio de coordenação tentando criar usuário.
     */
    public function test_coordenacao_cannot_create_user(): void
    {
        $user = User::factory()->create(['role' => 'coordenacao']);

        $response = $this->actingAs($user)->post('/desenvolvedor/users', [
            'name' => 'Tentativa Falha',
            'email' => 'falha@test.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'professor',
        ]);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('users', [
            'email' => 'falha@test.com',
        ]);
    }
}
