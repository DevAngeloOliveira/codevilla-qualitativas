<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * Detecta automaticamente o ambiente e executa seeders apropriados.
     */
    public function run(): void
    {
        $environment = app()->environment();

        $this->command->info("🌍 Ambiente detectado: {$environment}");
        $this->command->info("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");

        match ($environment) {
            'production' => $this->seedProduction(),
            'staging' => $this->seedStaging(),
            'local', 'development', 'testing' => $this->seedDevelopment(),
            default => $this->seedDevelopment(),
        };

        $this->command->info("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
        $this->command->info("✅ Seeding concluído para ambiente: {$environment}");
    }

    /**
     * Seeds para ambiente de produção - apenas dados essenciais
     */
    private function seedProduction(): void
    {
        $this->command->warn("⚠️  PRODUÇÃO: Criando apenas dados essenciais");
        $this->call(EssentialSeeder::class);
    }

    /**
     * Seeds para ambiente de staging - cópia de produção ou dados fake
     */
    private function seedStaging(): void
    {
        $sourceType = env('DATABASE_SOURCE_TYPE', 'fake');

        if ($sourceType === 'production') {
            $this->command->warn("⚠️  STAGING: Copiando dados de PRODUÇÃO com anonimização");
            $this->call(StagingSeeder::class);
        } else {
            $this->command->warn("⚠️  STAGING: Criando dados fictícios");
            $this->call(EssentialSeeder::class);
            $this->call(DevelopmentSeeder::class);
        }
    }

    /**
     * Seeds para ambientes de desenvolvimento - dados completos para testes
     */
    private function seedDevelopment(): void
    {
        $this->command->info("🔧 DESENVOLVIMENTO: Criando dados completos para testes");
        $this->call(EssentialSeeder::class);
        $this->call(DevelopmentSeeder::class);
    }
}
