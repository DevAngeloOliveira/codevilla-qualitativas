<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('turmas', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('nome', 50);
            $table->year('ano_letivo');
            $table->enum('turno', ['Matutino', 'Vespertino'])->default('Matutino');
            $table->string('segmento', 100)->default('Ensino Fundamental II');
            $table->boolean('ativa')->default(true);
            $table->timestamps();

            $table->unique(['nome', 'ano_letivo', 'turno'], 'unique_turma_ano_turno');
            $table->index('nome');
            $table->index('ano_letivo');
            $table->index('turno');
            $table->index('ativa');
            $table->index('uuid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('turmas');
    }
};
