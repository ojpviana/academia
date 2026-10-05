<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table("planos", function (Blueprint $table) {
            $table->integer("duracao_meses")->default(1)->after("valor_padrao");
        });
    }
    public function down(): void {
        Schema::table("planos", function (Blueprint $table) {
            $table->dropColumn("duracao_meses");
        });
    }
};
