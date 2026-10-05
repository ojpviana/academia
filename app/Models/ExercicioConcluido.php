<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExercicioConcluido extends Model
{
    protected $fillable = ['atleta_id', 'treino_atleta_id', 'observacao', 'carga_kg', 'is_pr', 'data_conclusao'];

    public function atleta()
    {
        return $this->belongsTo(Atleta::class, 'atleta_id', 'idAtleta');
    }

    public function treinoAtleta()
    {
        return $this->belongsTo(TreinoAtleta::class, 'treino_atleta_id', 'id');
    }
}
