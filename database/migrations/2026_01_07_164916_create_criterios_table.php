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
        Schema::create('criterios', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 10)->unique();
            $table->string('grupo', 100);
            $table->string('titulo');
            $table->text('descricao')->nullable();
            $table->decimal('peso', 3, 2);
            $table->integer('ordem');
            $table->boolean('ativo')->default(true);
            $table->timestamps();

            $table->index('codigo');
            $table->index('grupo');
            $table->index('ordem');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('criterios');
    }
};
