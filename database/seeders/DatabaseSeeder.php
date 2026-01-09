<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * Simplificado para produção - apenas dados essenciais
     */
    public function run(): void
    {
        // Em produção, seeders complexos não são necessários
        // O usuário desenvolvedor já é criado automaticamente no docker-entrypoint.sh
        // Dados de teste podem ser criados manualmente via interface

        if ($this->command) {
            $this->command->info('✅ Seeders não executados - dados devem ser criados via interface');
            $this->command->info('👤 Usuário desenvolvedor já foi criado: dev@codevilla.com / Dev@2026');
        }
    }
}
