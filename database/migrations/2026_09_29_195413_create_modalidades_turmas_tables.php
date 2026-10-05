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
        Schema::create('modalidades_extras', function (Blueprint $table) {
            $table->id();
            $table->string('nome')->unique();
            $table->timestamps();
        });

        Schema::create('turmas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('modalidade_id')->constrained('modalidades_extras')->onDelete('cascade');
            $table->unsignedBigInteger('treinador_id')->nullable(); // Reference to treinadores, but since treinadores table has id or idTreinador? 
            $table->string('dia_semana');
            $table->time('hora_inicio');
            $table->time('hora_fim');
            $table->integer('limite_alunos')->default(20);
            $table->timestamps();

            $table->foreign('treinador_id')->references('id')->on('treinadores')->onDelete('set null');
        });

        Schema::create('atleta_turma', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('atleta_id'); // Referencing atletas which has idAtleta
            $table->foreignId('turma_id')->constrained('turmas')->onDelete('cascade');
            $table->timestamps();

            $table->foreign('atleta_id')->references('idAtleta')->on('atletas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atleta_turma');
        Schema::dropIfExists('turmas');
        Schema::dropIfExists('modalidades_extras');
    }
};
