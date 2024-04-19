<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class inventario extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'idusuario',
        'monedas',
        'caramelos',
        'piruleta',
        'piruletal',
        'algodon',
        'tabletachoco',
        'caramelo',
        'baston',
        'caramelolargo',
        'carameloredondo',
        'surtido',
        'XalDeFrutas',
        'Inxulina'
    ];
    const UPDATED_AT = null;
    const CREATED_AT = null;
}
