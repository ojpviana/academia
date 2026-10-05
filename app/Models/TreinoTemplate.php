<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TreinoTemplate extends Model
{
    protected $fillable = ['treinador_id', 'nome_template', 'descricao'];

    public function treinador()
    {
        return $this->belongsTo(Treinador::class, 'treinador_id', 'id');
    }

    public function exercicios()
    {
        return $this->hasMany(TreinoTemplateExercicio::class, 'template_id', 'id');
    }
}
