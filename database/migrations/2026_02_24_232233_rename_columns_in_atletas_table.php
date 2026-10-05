<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('atletas', function (Blueprint $table) {
            // Renomeia a coluna de criação padrão para o seu nome personalizado
            $table->renameColumn('created_at', 'criado_data');

            // Remove a coluna de atualização que você não quer manter
            $table->dropColumn('updated_at');
        });
    }

    public function down(): void
    {
        Schema::table('atletas', function (Blueprint $table) {
            $table->renameColumn('criado_data', 'created_at');
            $table->timestamp('updated_at')->nullable();
        });
    }
};
