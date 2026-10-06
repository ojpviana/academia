<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Treinador extends Model
{
    use SoftDeletes;

    protected $table = 'treinadores';
    protected $fillable = [
        'user_id', 'cpf', 'rg', 'data_nascimento', 'telefone',
        'endereco_completo', 'cref', 'funcao', 'tipo_vinculo',
        'turno_id', 'salario', 'data_ultimo_pagamento', 'turno_horario', 'modelo_remuneracao', 'dados_bancarios'
    ];

    // ESTA É A RELAÇÃO QUE ESTÁ FALTANDO
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function templates()
    {
        return $this->hasMany(TreinoTemplate::class, 'treinador_id', 'id');
    }
}
