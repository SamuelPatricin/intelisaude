<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; 
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios'; 

    protected $fillable = [
        'nome',
        'email',
        'senha',
        'codigo_verificacao',
        'verificado',
    ];

    protected $hidden = [
        'senha', 
    ];

    public function exames()
    {
        return $this->hasMany(Exame::class, 'usuario_id');
    }

}