<?php

namespace Tests\Feature;

use App\Domains\Usuarios\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testa redirecionamento do dashboard para desenvolvedor.
     */
    public function test_desenvolvedor_is_redirected_to_desenvolvedor_dashboard(): void
    {
        $user = User::factory()->create(['role' => 'desenvolvedor']);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertRedirect('/desenvolvedor/dashboard');
    }

    /**
     * Testa redirecionamento do dashboard para coordenação.
     */
    public function test_coordenacao_is_redirected_to_admin_dashboard(): void
    {
        $user = User::factory()->create(['role' => 'coordenacao']);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertRedirect('/admin/dashboard');
    }

    /**
     * Testa redirecionamento do dashboard para professor.
     */
    public function test_professor_is_redirected_to_professor_dashboard(): void
    {
        $user = User::factory()->create(['role' => 'professor']);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertRedirect('/professor/dashboard');
    }

    /**
     * Testa acesso de desenvolvedor ao dashboard de desenvolvedor.
     */
    public function test_desenvolvedor_can_access_desenvolvedor_dashboard(): void
    {
        $user = User::factory()->create(['role' => 'desenvolvedor']);

        $response = $this->actingAs($user)->get('/desenvolvedor/dashboard');

        $response->assertStatus(200);
    }

    /**
     * Testa acesso de coordenação ao dashboard admin.
     */
    public function test_coordenacao_can_access_admin_dashboard(): void
    {
        $user = User::factory()->create(['role' => 'coordenacao']);

        $response = $this->actingAs($user)->get('/admin/dashboard');

        $response->assertStatus(200);
    }

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
     * Testa bloqueio de professor tentando acessar dashboard admin.
     */
    public function test_professor_cannot_access_admin_dashboard(): void
    {
        $user = User::factory()->create(['role' => 'professor']);

        $response = $this->actingAs($user)->get('/admin/dashboard');

        $response->assertStatus(403);
    }

    /**
     * Testa bloqueio de coordenação tentando acessar dashboard de professor.
     */
    public function test_coordenacao_cannot_access_professor_dashboard(): void
    {
        $user = User::factory()->create(['role' => 'coordenacao']);

        $response = $this->actingAs($user)->get('/professor/dashboard');

        $response->assertStatus(403);
    }

    /**
     * Testa bloqueio de professor tentando acessar dashboard de desenvolvedor.
     */
    public function test_professor_cannot_access_desenvolvedor_dashboard(): void
    {
        $user = User::factory()->create(['role' => 'professor']);

        $response = $this->actingAs($user)->get('/desenvolvedor/dashboard');

        $response->assertStatus(403);
    }

    /**
     * Testa bloqueio de usuário não autenticado.
     */
    public function test_guests_cannot_access_protected_routes(): void
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');

        $response = $this->get('/admin/dashboard');
        $response->assertRedirect('/login');

        $response = $this->get('/professor/dashboard');
        $response->assertRedirect('/login');

        $response = $this->get('/desenvolvedor/dashboard');
        $response->assertRedirect('/login');
    }
}
