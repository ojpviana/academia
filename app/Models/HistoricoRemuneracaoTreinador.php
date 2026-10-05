<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricoRemuneracaoTreinador extends Model
{
    use HasFactory;

    protected $table = 'historico_remuneracoes_treinadores';

    protected $fillable = [
        'treinador_id',
        'valor_remuneracao',
        'data_inicio',
        'data_fim'
    ];

    public function treinador()
    {
        return $this->belongsTo(Treinador::class);
    }
}
