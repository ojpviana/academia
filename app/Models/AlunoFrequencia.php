<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlunoFrequencia extends Model
{
    protected $table = 'alunos_freq';
    protected $fillable = ['atleta_id', 'data_hora_entrada'];
    public $timestamps = true;
}
