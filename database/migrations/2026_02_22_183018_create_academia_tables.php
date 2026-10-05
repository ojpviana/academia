<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabela de Treinadores
        Schema::create('treinadores', function (Blueprint $table) {
            $table->id('idTreinador');
            $table->string('nome', 100);
            $table->integer('idade');
            $table->timestamps();
        });

        // Tabela de Atletas
        Schema::create('atletas', function (Blueprint $table) {
            $table->id('idAtleta');
            $table->string('nome', 100);
            $table->integer('idade');
            $table->decimal('peso', 5, 2);
            $table->boolean('excluido')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('atletas');
        Schema::dropIfExists('treinadores');
    }
};
