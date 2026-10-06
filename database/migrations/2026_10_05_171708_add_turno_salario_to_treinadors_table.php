<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table("treinadores", function (Blueprint $table) {
            $table->unsignedBigInteger("turno_id")->nullable();
            $table->decimal("salario", 10, 2)->default(0);
            $table->date("data_ultimo_pagamento")->nullable();
            $table->foreign("turno_id")->references("id")->on("turnos")->onDelete("set null");
        });
    }
    public function down(): void {
        Schema::table("treinadores", function (Blueprint $table) {
            $table->dropForeign(["turno_id"]);
            $table->dropColumn(["turno_id", "salario", "data_ultimo_pagamento"]);
        });
    }
};