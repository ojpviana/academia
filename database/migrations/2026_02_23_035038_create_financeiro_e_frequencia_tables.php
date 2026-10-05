<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tabela de Pagamentos (Receita)
        if (!Schema::hasTable('alunos_pgto')) {
            Schema::create('alunos_pgto', function (Blueprint $table) {
                $table->id();
                $table->foreignId('atleta_id')->constrained('atletas', 'idAtleta');
                $table->decimal('valor', 8, 2);
                $table->date('data_pagamento');
                $table->string('status')->default('Pendente');
                $table->timestamps();
            });
        }

        // 2. Tabela de Frequência (Presença)
        if (!Schema::hasTable('alunos_freq')) {
            Schema::create('alunos_freq', function (Blueprint $table) {
                $table->id();
                $table->foreignId('atleta_id')->constrained('atletas', 'idAtleta');
                $table->timestamp('data_hora_entrada');
                $table->timestamps();
            });
        }

        // 3. Adicionando a coluna 'excluido' na tabela atletas (Soft Delete)
        // Isso permite manter o histórico que você deseja para o IFSP
        if (Schema::hasTable('atletas') && !Schema::hasColumn('atletas', 'excluido')) {
            Schema::table('atletas', function (Blueprint $table) {
                $table->boolean('excluido')->default(0);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('alunos_freq');
        Schema::dropIfExists('alunos_pgto');
        // Removemos apenas a coluna se necessário, para não apagar a tabela atletas inteira
        if (Schema::hasColumn('atletas', 'excluido')) {
            Schema::table('atletas', function (Blueprint $table) {
                $table->dropColumn('excluido');
            });
        }
    }
};
