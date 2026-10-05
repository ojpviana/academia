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
        Schema::table('atletas', function (Blueprint $table) {
            $table->integer('streak_atual')->default(0)->after('frequencia_semanal');
        });

        Schema::table('exercicio_concluidos', function (Blueprint $table) {
            $table->boolean('is_pr')->default(false)->after('carga_kg');
        });

        Schema::table('treinos_atleta', function (Blueprint $table) {
            $table->decimal('meta_carga_kg', 8, 2)->nullable()->after('repeticoes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('atletas', function (Blueprint $table) {
            $table->dropColumn('streak_atual');
        });

        Schema::table('exercicio_concluidos', function (Blueprint $table) {
            $table->dropColumn('is_pr');
        });

        Schema::table('treinos_atleta', function (Blueprint $table) {
            $table->dropColumn('meta_carga_kg');
        });
    }
};
