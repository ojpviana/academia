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
        Schema::create('avaliacao_fisicas', function (Blueprint $table) {
            $table->id();
            $table->integer('atleta_id'); // FK para atletas (idAtleta)
            $table->unsignedBigInteger('treinador_id')->nullable(); // FK para treinadores
            $table->date('data_avaliacao');
            $table->decimal('peso', 5, 2)->nullable(); // Ex: 80.50
            $table->decimal('altura', 3, 2)->nullable(); // Ex: 1.80
            $table->decimal('bf', 5, 2)->nullable(); // Body Fat
            $table->decimal('peito', 5, 2)->nullable();
            $table->decimal('cintura', 5, 2)->nullable();
            $table->decimal('abdome', 5, 2)->nullable();
            $table->decimal('quadril', 5, 2)->nullable();
            $table->decimal('coxa', 5, 2)->nullable();
            $table->decimal('braco', 5, 2)->nullable();
            $table->text('observacoes')->nullable();
            $table->timestamps();

            $table->foreign('atleta_id')->references('idAtleta')->on('atletas')->onDelete('cascade');
            $table->foreign('treinador_id')->references('id')->on('treinadores')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avaliacao_fisicas');
    }
};
