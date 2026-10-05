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
        // Só adiciona se a coluna ainda não existir na tabela 'atletas'
        if (Schema::hasTable('atletas') && !Schema::hasColumn('atletas', 'excluido')) {
            Schema::table('atletas', function (Blueprint $table) {
                $table->boolean('excluido')->default(0); // 0 = ativo, 1 = removido
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('atletas', 'excluido')) {
            Schema::table('atletas', function (Blueprint $table) {
                $table->dropColumn('excluido');
            });
        }
    }
};
