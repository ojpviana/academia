<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoricoTreino extends Model
{
    protected $fillable = ['atleta_id', 'treino_de', 'treino_para', 'observacao'];

    public function atleta()
    {
        return $this->belongsTo(Atleta::class, 'atleta_id', 'idAtleta');
    }
}
