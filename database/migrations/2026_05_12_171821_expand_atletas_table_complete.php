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
            // Removidos telefone, frequencia_semanal e objetivo porque já criamos antes!

            // Saúde e Segurança
            $table->string('atestado_medico')->nullable();
            $table->text('anamnese')->nullable(); // PAR-Q e notas de saúde

            // Comercial e Financeiro
            $table->enum('plano_tipo', ['Mensal', 'Trimestral', 'Semestral', 'Anual', 'Gympass', 'Totalpass'])->default('Mensal');
            $table->string('modalidades')->default('Musculação');
            $table->date('data_vencimento')->nullable();
            $table->enum('forma_pagamento', ['Cartão Recorrente', 'Pix', 'Boleto', 'Dinheiro'])->default('Pix');

            // Estratégia de Treino
            $table->enum('status', ['Ativo', 'Inativo'])->default('Ativo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
