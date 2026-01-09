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
        Schema::create('alunos', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('nome');
            $table->integer('numero_chamada');
            $table->foreignId('turma_id')->constrained('turmas')->onDelete('cascade');
            $table->string('foto', 500)->nullable();
            $table->timestamps();

            $table->unique(['turma_id', 'numero_chamada'], 'unique_chamada_turma');
            $table->index('turma_id');
            $table->index('nome');
            $table->index('uuid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alunos');
    }
};
