<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Domains\Usuarios\Models\User;

class EssentialSeeder extends Seeder
{
    /**
     * Seed essencial para todos os ambientes.
     * Cria apenas dados indispensáveis: critérios, disciplinas e usuário desenvolvedor.
     */
    public function run(): void
    {
        $this->command->info("🔧 Executando seeders essenciais...");

        // 1. Critérios de avaliação
        $this->call(CriterioSeeder::class);

        // 2. Disciplinas do currículo
        $this->call(DisciplinaSeeder::class);

        // 3. Usuário desenvolvedor
        $this->createDevUser();

        $this->command->info("✓ Seeders essenciais concluídos!");
    }

    /**
     * Cria o usuário desenvolvedor usando dados do config
     */
    private function createDevUser(): void
    {
        try {
            $devConfig = config('seeders.dev_user');

            $user = User::firstOrCreate(
                ['email' => $devConfig['email']],
                [
                    'name' => $devConfig['name'],
                    'password' => Hash::make($devConfig['password']),
                    'role' => $devConfig['role'],
                    'is_active' => true,
                    'email_verified_at' => now(),
                ]
            );

            if ($user->wasRecentlyCreated) {
                $this->command->info("✓ Usuário desenvolvedor criado: {$devConfig['email']}");
            } else {
                $this->command->info("✓ Usuário desenvolvedor já existe: {$devConfig['email']}");
            }
        } catch (\Exception $e) {
            $this->command->error("❌ Erro ao criar usuário desenvolvedor: {$e->getMessage()}");
            throw $e;
        }
    }
}
