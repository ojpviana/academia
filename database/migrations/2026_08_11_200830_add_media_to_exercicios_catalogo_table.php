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
        Schema::table('exercicios_catalogo', function (Blueprint $table) {
            $table->text('descricao')->nullable()->after('grupo_muscular');
            $table->string('video_url')->nullable()->after('descricao');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exercicios_catalogo', function (Blueprint $table) {
            $table->dropColumn(['descricao', 'video_url']);
        });
    }
};
