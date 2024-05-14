<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class intercambio extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'idusuario1',
        'usertag1',
        'nombre_xuxemon1',
        'tipo1',
        'tamano_xuxemon1',
        'caramelos_comidosx1',
        'idusuario2',
        'usertag2',
        'nombre_xuxemon2',
        'tipo2',
        'tamano_xuxemon2',
        'caramelos_comidosx2',
        'consentimiento1',
        'consentimiento2',
        'estado'
    ];
    const UPDATED_AT = null;
    const CREATED_AT = null;
}