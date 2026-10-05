<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Corrige a FK de treino_templates.treinador_id, que apontava para
 * treinadores.idTreinador (coluna inexistente — a PK real é "id").
 * No SQLite isso causava "foreign key mismatch" em qualquer INSERT,
 * impedindo a criação de templates.
 *
 * As tabelas são recriadas apenas se estiverem vazias (o que é garantido,
 * já que nenhum insert era possível com a FK quebrada).
 */
return new class extends Migration
{
    public function up(): void
    {
        if (DB::table('treino_template_exercicios')->count() > 0 || DB::table('treino_templates')->count() > 0) {
            throw new RuntimeException('treino_templates possui dados; ajuste a FK manualmente para não perder registros.');
        }

        Schema::dropIfExists('treino_template_exercicios');
        Schema::dropIfExists('treino_templates');

        Schema::create('treino_templates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('treinador_id');
            $table->string('nome_template');
            $table->text('descricao')->nullable();
            $table->timestamps();

            $table->foreign('treinador_id')->references('id')->on('treinadores')->onDelete('cascade');
        });

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

    public function down(): void
    {
        // Sem rollback: a estrutura anterior era inválida (FK para coluna inexistente).
    }
};
