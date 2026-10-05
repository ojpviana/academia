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
            $table->softDeletes();
            $table->string('atestado_path')->nullable();
            $table->string('parq_path')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('atletas', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn(['atestado_path', 'parq_path']);
        });
    }
};
