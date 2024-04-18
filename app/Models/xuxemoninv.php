<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class xuxemoninv extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'idxuxemon',
        'idusuario',
        'nombre',
        'tipo',
        'tamano',
        'imagen',
        'Enfermedad1',
        'Enfermedad2',
        'Enfermedad3',
        'caramelos_comidos'
    ];
    const UPDATED_AT = null;
    const CREATED_AT = null;
}
