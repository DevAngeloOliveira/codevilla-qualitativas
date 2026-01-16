<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Adicionar campo de versão aos critérios
        Schema::table('criterios', function (Blueprint $table) {
            $table->string('versao', 10)->default('1.0')->after('codigo');
            $table->date('vigencia_inicio')->nullable()->after('ativo');
            $table->date('vigencia_fim')->nullable()->after('vigencia_inicio');

            // Index para buscar critérios ativos em determinada data
            $table->index(['ativo', 'vigencia_inicio', 'vigencia_fim']);
        });

        // Adicionar campo de versão dos critérios às avaliações
        Schema::table('avaliacoes', function (Blueprint $table) {
            $table->string('criterios_versao', 10)->default('1.0')->after('trimestre');
            $table->index('criterios_versao');
        });

        // Atualizar critérios existentes com data de vigência
        DB::table('criterios')->update([
            'versao' => '1.0',
            'vigencia_inicio' => now()->startOfYear(),
        ]);

        // Atualizar avaliações existentes
        DB::table('avaliacoes')->update([
            'criterios_versao' => '1.0',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('avaliacoes', function (Blueprint $table) {
            $table->dropIndex(['criterios_versao']);
            $table->dropColumn('criterios_versao');
        });

        Schema::table('criterios', function (Blueprint $table) {
            $table->dropIndex(['ativo', 'vigencia_inicio', 'vigencia_fim']);
            $table->dropColumn(['versao', 'vigencia_inicio', 'vigencia_fim']);
        });
    }
};
