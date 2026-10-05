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
        Schema::create('treino_template_exercicios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('template_id');
            $table->unsignedBigInteger('exercicio_id');
            $table->string('series')->nullable();
            $table->string('repeticoes')->nullable();
            $table->string('dia_semana')->nullable();
            $table->timestamps();

            $table->foreign('template_id')->references('id')->on('treino_templates')->onDelete('cascade');
            $table->foreign('exercicio_id')->references('id')->on('exercicios_catalogo')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('treino_template_exercicios');
    }
};
