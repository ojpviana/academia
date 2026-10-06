<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Turno extends Model {
    protected $fillable = ['nome_turno', 'hora_inicio', 'hora_fim'];
}