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
        Schema::create('avaliacao_criterio', function (Blueprint $table) {
            $table->id();
            $table->foreignId('avaliacao_id')->constrained('avaliacoes')->onDelete('cascade');
            $table->foreignId('criterio_id')->constrained('criterios')->onDelete('cascade');
            $table->tinyInteger('valor')->unsigned();
            $table->timestamps();

            $table->unique(['avaliacao_id', 'criterio_id'], 'unique_aval_criterio');
            $table->index('avaliacao_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avaliacao_criterio');
    }
};
