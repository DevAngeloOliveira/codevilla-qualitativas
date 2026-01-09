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
        Schema::create('avaliacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aluno_id')->constrained('alunos')->onDelete('cascade');
            $table->foreignId('professor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('disciplina_id')->constrained('disciplinas')->onDelete('cascade');
            $table->foreignId('turma_id')->constrained('turmas')->onDelete('cascade');
            $table->tinyInteger('trimestre')->unsigned();
            $table->year('ano_letivo');
            $table->decimal('nota_final', 4, 2)->default(0.00);
            $table->text('observacoes')->nullable();
            $table->boolean('finalizada')->default(false);
            $table->timestamps();

            $table->unique(['aluno_id', 'professor_id', 'disciplina_id', 'trimestre', 'ano_letivo'], 'unique_avaliacao');
            $table->index('professor_id');
            $table->index(['turma_id', 'trimestre'], 'idx_turma_trimestre');
            $table->index('ano_letivo');
            $table->index(['professor_id', 'turma_id', 'disciplina_id', 'trimestre'], 'idx_search');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avaliacoes');
    }
};
