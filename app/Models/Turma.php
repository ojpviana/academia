<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Turma extends Model
{
    protected $table = 'turmas';

    protected $fillable = [
        'modalidade_id',
        'treinador_id',
        'dia_semana',
        'hora_inicio',
        'hora_fim',
        'limite_alunos'
    ];

    public function modalidade()
    {
        return $this->belongsTo(ModalidadeExtra::class, 'modalidade_id');
    }

    public function treinador()
    {
        return $this->belongsTo(Treinador::class, 'treinador_id');
    }

    public function atletas()
    {
        return $this->belongsToMany(Atleta::class, 'atleta_turma', 'turma_id', 'atleta_id');
    }
}
