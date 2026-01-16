<?php

namespace Tests\Feature;

use App\Domains\Usuarios\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testa se a página de login é exibida.
     */
    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    /**
     * Testa login com usuário desenvolvedor.
     */
    public function test_desenvolvedor_can_authenticate(): void
    {
        $user = User::factory()->create([
            'email' => 'dev@test.com',
            'password' => bcrypt('password'),
            'role' => 'desenvolvedor',
        ]);

        $response = $this->post('/login', [
            'email' => 'dev@test.com',
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/dashboard');
    }

    /**
     * Testa login com usuário coordenação.
     */
    public function test_coordenacao_can_authenticate(): void
    {
        $user = User::factory()->create([
            'email' => 'coordenacao@test.com',
            'password' => bcrypt('password'),
            'role' => 'coordenacao',
        ]);

        $response = $this->post('/login', [
            'email' => 'coordenacao@test.com',
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/dashboard');
    }

    /**
     * Testa login com usuário professor.
     */
    public function test_professor_can_authenticate(): void
    {
        $user = User::factory()->create([
            'email' => 'professor@test.com',
            'password' => bcrypt('password'),
            'role' => 'professor',
        ]);

        $response = $this->post('/login', [
            'email' => 'professor@test.com',
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/dashboard');
    }

    /**
     * Testa falha de autenticação com credenciais inválidas.
     */
    public function test_users_cannot_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create([
            'email' => 'test@test.com',
            'password' => bcrypt('password'),
        ]);

        $this->post('/login', [
            'email' => 'test@test.com',
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    /**
     * Testa logout.
     */
    public function test_users_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }
}
