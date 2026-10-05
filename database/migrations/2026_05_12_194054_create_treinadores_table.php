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
        Schema::create('treinadores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Link com o login

            // Dados Pessoais
            $table->string('cpf', 14)->nullable();
            $table->string('rg', 20)->nullable();
            $table->date('data_nascimento')->nullable();

            // Contato
            $table->string('telefone', 20)->nullable();
            $table->string('endereco_completo')->nullable();

            // Dados Profissionais e Financeiros
            $table->string('cref')->nullable();
            $table->string('funcao')->nullable();
            $table->enum('tipo_vinculo', ['CLT', 'PJ', 'Estagiário', 'Autônomo'])->default('PJ');
            $table->string('turno_horario')->nullable();
            $table->string('modelo_remuneracao')->nullable();
            $table->text('dados_bancarios')->nullable();

            $table->timestamps();
        });

        // Só adiciona a coluna no atleta se ela não existir ainda
        if (!Schema::hasColumn('atletas', 'treinador_id')) {
            Schema::table('atletas', function (Blueprint $table) {
                $table->unsignedBigInteger('treinador_id')->nullable()->after('user_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('treinadores');
    }
};
