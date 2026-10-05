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
    Schema::table('historico_treinos', function (Blueprint $table) {
        // Renomeia o campo atual para ficar mais claro e adiciona o de origem
        $table->string('treino_de')->nullable()->after('atleta_id');
        $table->renameColumn('nome_treino', 'treino_para');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('historico_treinos', function (Blueprint $table) {
            //
        });
    }
};
