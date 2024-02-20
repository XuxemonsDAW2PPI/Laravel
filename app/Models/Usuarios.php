<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuarios extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'Nombre',
        'Contraseña',
        'Correo',
        'UserType',
    ];
    const UPDATED_AT = null;
    const CREATED_AT = null;

}
