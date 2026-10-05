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
            $table->string('telefone', 20)->nullable()->after('nome');
            $table->integer('frequencia_semanal')->default(3)->after('idade');
            $table->string('objetivo')->nullable()->after('frequencia_semanal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('atletas', function (Blueprint $table) {
            //
        });
    }
};
