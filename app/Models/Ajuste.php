<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ajuste extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'default',
        'sm_med',
        'med_big',
        'Enfermedad1',
        'Enfermedad2',
        'Enfermedad3',
        'Bajon'
    ];
    const UPDATED_AT = null;
    const CREATED_AT = null;
}
