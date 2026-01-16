<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SeedEnvironment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:seed-environment
                            {--essential : Executar apenas seeders essenciais (critérios, disciplinas, dev user)}
                            {--development : Executar seeders de desenvolvimento (dados fictícios completos)}
                            {--staging : Executar seeder de staging (cópia de produção ou fake)}
                            {--production : Executar seeders de produção (apenas essenciais)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed database baseado no ambiente ou flags específicas';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $environment = app()->environment();

        $this->info("🌍 Ambiente atual: {$environment}");
        $this->info("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");

        // Determinar qual seeder executar
        if ($this->option('essential')) {
            $this->seedEssential();
        } elseif ($this->option('development')) {
            $this->seedDevelopment();
        } elseif ($this->option('staging')) {
            $this->seedStaging();
        } elseif ($this->option('production')) {
            $this->seedProduction();
        } else {
            // Auto-detectar baseado no ambiente
            $this->autoDetectAndSeed($environment);
        }

        $this->info("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
        $this->info("✅ Seeding concluído!");

        return Command::SUCCESS;
    }

    /**
     * Auto-detecta ambiente e executa seeders apropriados
     */
    private function autoDetectAndSeed(string $environment): void
    {
        $this->info("🔍 Detecção automática de ambiente...");

        match ($environment) {
            'production' => $this->seedProduction(),
            'staging' => $this->seedStaging(),
            'local', 'development', 'testing' => $this->seedDevelopment(),
            default => $this->seedDevelopment(),
        };
    }

    /**
     * Executa seeders essenciais
     */
    private function seedEssential(): void
    {
        $this->warn("⚠️  Executando APENAS seeders essenciais");
        $this->call('db:seed', ['--class' => 'EssentialSeeder']);
    }

    /**
     * Executa seeders de desenvolvimento
     */
    private function seedDevelopment(): void
    {
        $this->info("🔧 Executando seeders de DESENVOLVIMENTO");
        $this->call('db:seed', ['--class' => 'EssentialSeeder']);
        $this->call('db:seed', ['--class' => 'DevelopmentSeeder']);
    }

    /**
     * Executa seeders de staging
     */
    private function seedStaging(): void
    {
        $sourceType = env('DATABASE_SOURCE_TYPE', 'fake');

        if ($sourceType === 'production') {
            $this->warn("⚠️  STAGING: Copiando dados de PRODUÇÃO");

            if (!$this->confirm('Deseja realmente copiar dados de produção?')) {
                $this->error('❌ Operação cancelada');
                return;
            }

            $this->call('db:seed', ['--class' => 'StagingSeeder']);
        } else {
            $this->warn("⚠️  STAGING: Criando dados fictícios");
            $this->call('db:seed', ['--class' => 'EssentialSeeder']);
            $this->call('db:seed', ['--class' => 'DevelopmentSeeder']);
        }
    }

    /**
     * Executa seeders de produção
     */
    private function seedProduction(): void
    {
        $this->error("⚠️  PRODUÇÃO: Executando apenas seeders essenciais");

        if (!$this->confirm('Confirma execução de seeders em PRODUÇÃO?')) {
            $this->error('❌ Operação cancelada');
            return;
        }

        $this->call('db:seed', ['--class' => 'EssentialSeeder']);
    }
}
