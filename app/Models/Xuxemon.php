<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Xuxemon extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'nombre',
        'tipo',
        'imagen',
        'caramelos_comidos'
    ];
    const UPDATED_AT = null;
    const CREATED_AT = null;
}
