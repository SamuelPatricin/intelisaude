<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // <-- MUITO IMPORTANTE
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios'; // Ou o nome da sua tabela se for diferente

    protected $fillable = [
        'nome', 'email', 'senha','codigo_verificacao', 'verificado',
    ];

    protected $hidden = [
        'senha', // oculta a senha ao converter para array/json
    ];
}