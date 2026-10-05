<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TreinoAtleta extends Model
{
    protected $table = 'treinos_atleta';
    protected $fillable = ['atleta_id', 'exercicio_id', 'series', 'repeticoes', 'meta_carga_kg', 'dia_semana'];
    public $timestamps = false;

    public function exercicio() {
        return $this->belongsTo(ExercicioCatalogo::class, 'exercicio_id');
    }
}
