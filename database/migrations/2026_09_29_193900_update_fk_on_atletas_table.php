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
            $table->dropColumn(['plano_tipo', 'forma_pagamento']);
            
            $table->unsignedBigInteger('plano_id')->nullable();
            $table->unsignedBigInteger('forma_pagamento_id')->nullable();
            
            $table->foreign('plano_id')->references('id')->on('planos')->onDelete('set null');
            $table->foreign('forma_pagamento_id')->references('id')->on('forma_pagamentos')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('atletas', function (Blueprint $table) {
            $table->dropForeign(['plano_id']);
            $table->dropForeign(['forma_pagamento_id']);
            
            $table->dropColumn(['plano_id', 'forma_pagamento_id']);
            
            $table->string('plano_tipo')->default('Mensal')->nullable();
            $table->string('forma_pagamento')->default('Pix')->nullable();
        });
    }
};
