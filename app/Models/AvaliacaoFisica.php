<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AvaliacaoFisica extends Model
{
    protected $table = 'avaliacao_fisicas';

    protected $fillable = [
        'atleta_id',
        'treinador_id',
        'data_avaliacao',
        'peso',
        'altura',
        'bf',
        'peito',
        'cintura',
        'abdome',
        'quadril',
        'coxa',
        'braco',
        'observacoes'
    ];

    public function atleta()
    {
        return $this->belongsTo(Atleta::class, 'atleta_id', 'idAtleta');
    }

    public function treinador()
    {
        return $this->belongsTo(Treinador::class, 'treinador_id');
    }
}
