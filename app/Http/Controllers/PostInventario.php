<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\inventario;
use Illuminate\Support\Facades\Session;

class PostInventario extends Controller
{
    public function show()
    {
        $user = session('User');
        $inventario = inventario::where('idusuario', $user->id)->get();
        if ($xuxemoninv->isEmpty()) {
            return response()->json('Usuario no encontrado');
        }
        return response()->json($inventario);
    }
}
