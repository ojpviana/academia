<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Converte as colunas ENUM para STRING (compatível com SQLite)
        Schema::table('atletas', function (Blueprint $table) {
            $table->string('plano_tipo')->default('Mensal')->change();
            $table->string('forma_pagamento')->default('Pix')->change();
        });
    }

    public function down(): void
    {
        //
    }
};
