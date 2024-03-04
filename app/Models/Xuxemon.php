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
        'imagen'
    ];
    const UPDATED_AT = null;
    const CREATED_AT = null;
}
