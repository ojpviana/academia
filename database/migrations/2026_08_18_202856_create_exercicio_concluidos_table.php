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
        Schema::create('exercicio_concluidos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('atleta_id');
            $table->unsignedBigInteger('treino_atleta_id');
            $table->text('observacao')->nullable();
            $table->date('data_conclusao');
            $table->timestamps();

            $table->foreign('atleta_id')->references('idAtleta')->on('atletas')->onDelete('cascade');
            $table->foreign('treino_atleta_id')->references('id')->on('treinos_atletas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercicio_concluidos');
    }
};
