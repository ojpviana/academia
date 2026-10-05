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
        Schema::table('exercicio_concluidos', function (Blueprint $table) {
            $table->decimal('carga_kg', 8, 2)->nullable()->after('observacao');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exercicio_concluidos', function (Blueprint $table) {
            $table->dropColumn('carga_kg');
        });
    }
};
