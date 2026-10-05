<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TreinoTemplateExercicio extends Model
{
    protected $table = 'treino_template_exercicios';
    protected $fillable = ['template_id', 'exercicio_id', 'series', 'repeticoes', 'dia_semana'];

    public function template()
    {
        return $this->belongsTo(TreinoTemplate::class, 'template_id', 'id');
    }

    public function exercicio()
    {
        return $this->belongsTo(ExercicioCatalogo::class, 'exercicio_id', 'id');
    }
}
