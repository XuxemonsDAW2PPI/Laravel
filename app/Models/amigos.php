<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class amigos extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'idusuario1',
        'nombre1',
        'idusuario2',
        'nombre2',
        'estado'
    ];
    const UPDATED_AT = null;
    const CREATED_AT = null;
}
