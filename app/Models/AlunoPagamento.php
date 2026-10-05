<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlunoPagamento extends Model
{
    protected $table = 'alunos_pgto';

    protected $fillable = [
        'atleta_id',
        'valor',
        'data_pagamento',
        'status'
    ];
    public function atleta()
    {
        // "Este pagamento pertence a um Atleta.
        // A chave estrangeira aqui é 'atleta_id' e a chave primária lá é 'idAtleta'"
        return $this->belongsTo(Atleta::class, 'atleta_id', 'idAtleta');
    }
}
