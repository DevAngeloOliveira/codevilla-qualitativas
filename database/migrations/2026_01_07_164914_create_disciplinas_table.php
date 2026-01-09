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
        Schema::create('disciplinas', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 100)->unique();
            $table->string('codigo', 20)->unique()->nullable();
            $table->string('segmento', 100)->default('Ensino Fundamental II');
            $table->boolean('ativa')->default(true);
            $table->timestamps();

            $table->index('nome');
            $table->index('ativa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disciplinas');
    }
};
