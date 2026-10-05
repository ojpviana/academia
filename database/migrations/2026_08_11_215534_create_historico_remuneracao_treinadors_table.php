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
        Schema::create('historico_remuneracoes_treinadores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('treinador_id')->constrained('treinadores')->onDelete('cascade');
            $table->string('valor_remuneracao');
            $table->date('data_inicio');
            $table->date('data_fim')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historico_remuneracoes_treinadores');
    }
};
