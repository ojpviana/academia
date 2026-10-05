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
        Schema::create('treino_templates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('treinador_id');
            $table->string('nome_template');
            $table->text('descricao')->nullable();
            $table->timestamps();

            $table->foreign('treinador_id')->references('idTreinador')->on('treinadores')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('treino_templates');
    }
};
