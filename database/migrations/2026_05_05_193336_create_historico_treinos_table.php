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
        Schema::create('historico_treinos', function (Blueprint $table) {
            $table->id();
            // Referência ao aluno (Ajuste 'idAtleta' se a sua PK for apenas 'id')
            $table->foreignId('atleta_id')->constrained('atletas', 'idAtleta')->onDelete('cascade');
            $table->string('nome_treino'); // Qual ficha ele abriu (Treino A, Treino B)
            $table->text('observacao')->nullable(); // O motivo da troca
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historico_treinos');
    }
};
