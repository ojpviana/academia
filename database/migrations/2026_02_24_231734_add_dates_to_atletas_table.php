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
            // 'created_at' e 'updated_at' (padrão do Laravel para data de criação)
            // Se você já tiver timestamps, o Laravel apenas ignorará.
            if (!Schema::hasColumn('atletas', 'created_at')) {
                $table->timestamps();
            }

            // Coluna específica para a data de exclusão lógica
            if (!Schema::hasColumn('atletas', 'excluido_data')) {
                $table->dateTime('excluido_data')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('atletas', function (Blueprint $table) {
            $table->dropColumn(['excluido_data']);
        });
    }
};
