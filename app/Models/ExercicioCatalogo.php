<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExercicioCatalogo extends Model
{
    protected $table = 'exercicios_catalogo';
    public $timestamps = false;

    protected $fillable = [
        'nome',
        'grupo_muscular',
        'descricao',
        'video_url'
    ];
}
