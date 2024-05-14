<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = ['user_id'];

    public function mensajes()
    {
        return $this->hasMany(Mensaje::class);
    }
}
