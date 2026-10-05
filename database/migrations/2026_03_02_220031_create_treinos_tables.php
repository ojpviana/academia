<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Catálogo de consulta (A "API" de nomes)
        Schema::create('exercicios_catalogo', function (Blueprint $table) {
            $table->id();
            $table->string('nome'); // Ex: Supino Reto
            $table->string('grupo_muscular'); // Ex: Peito
        });

        // Vínculo real Aluno -> Treino
        Schema::create('treinos_atleta', function (Blueprint $table) {
            $table->id();
            $table->integer('atleta_id'); // FK para atletas
            $table->integer('exercicio_id'); // FK para catalogo
            $table->string('series'); // Ex: 3
            $table->string('repeticoes'); // Ex: 12 a 15
            $table->string('carga')->nullable(); // Ex: 20kg
            $table->string('dia_semana'); // Ex: Segunda ou Treino A

            $table->foreign('atleta_id')->references('idAtleta')->on('atletas');
            $table->foreign('exercicio_id')->references('id')->on('exercicios_catalogo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('treinos_tables');
    }
};
