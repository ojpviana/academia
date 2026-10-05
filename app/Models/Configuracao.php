<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuracao extends Model
{
    protected $table = 'configuracoes';

    protected $fillable = ['chave', 'valor'];

    /**
     * Helper to easily get a config value
     */
    public static function getValor($chave, $default = null)
    {
        $config = self::where('chave', $chave)->first();
        return $config ? $config->valor : $default;
    }
}
