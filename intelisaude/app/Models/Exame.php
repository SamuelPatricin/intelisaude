<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exame extends Model
{
    protected $table = 'exames';

    protected $fillable = [
        'usuario_id',
        'nome_arquivo',
        'caminho_arquivo',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
}
