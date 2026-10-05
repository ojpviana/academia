<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Atleta extends Model
{
    use SoftDeletes;

    protected $table = 'atletas';
    protected $primaryKey = 'idAtleta';

    public $timestamps = false;

    protected $fillable = [
        'user_id','nome', 'peso', 'idade', 'telefone', 'cpf',
        'cep', 'endereco', 'numero', 'bairro', 'cidade', 'estado',
        'atestado_medico', 'anamnese', 'par_q', 'plano_id', 'modalidades',
        'data_vencimento', 'forma_pagamento_id', 'frequencia_semanal', 'streak_atual',
        'objetivo', 'status', 'treinador_id'
];

    protected $casts = [
        'criado_data' => 'datetime',
        'excluido_data' => 'datetime',
        'anamnese' => 'array',
        'par_q' => 'array',
    ];


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($atleta) {
            $atleta->excluido = 0;
            $atleta->criado_data = date('Y-m-d H:i:s'); // Injeta a data sempre que um novo registro for criado
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function plano()
    {
        return $this->belongsTo(Plano::class, 'plano_id');
    }

    public function formaPagamento()
    {
        return $this->belongsTo(FormaPagamento::class, 'forma_pagamento_id');
    }

    public function turmas()
    {
        return $this->belongsToMany(Turma::class, 'atleta_turma', 'atleta_id', 'turma_id');
    }

    public function frequencias()
    {
        return $this->hasMany(AlunoFrequencia::class, 'atleta_id', 'idAtleta');
    }
}
