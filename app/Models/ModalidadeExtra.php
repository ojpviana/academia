<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModalidadeExtra extends Model
{
    protected $table = 'modalidades_extras';

    protected $fillable = ['nome'];

    public function turmas()
    {
        return $this->hasMany(Turma::class, 'modalidade_id');
    }
}
