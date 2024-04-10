<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\inventario;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PostInventario extends Controller
{
    public function show($userId)
{
    if ($userId === null) {
        return response()->json('ID de usuario no proporcionada', 400);
    }

    $inventario = inventario::where('idusuario', $userId)->get();

    if ($inventario->isEmpty()) {
        return response()->json('Inventario no encontrado para este usuario', 404);
    }

    return response()->json($inventario);
}

public function aumentarCantidadAleatoria($userId)
    {
        $inventario = inventario::where('idusuario', $userId)->first();

        if (!$inventario) {
            return response()->json('Inventario no encontrado para este usuario', 404);
        }

        $columnasInventario = Schema::getColumnListing('inventarios');
        $columnasPermitidas = array_diff($columnasInventario, ['id', 'idusuario']);

        $columnaAleatoria = collect($columnasPermitidas)->random();

        $nuevoValor = $inventario->{$columnaAleatoria} + 2;

        $inventario->update([$columnaAleatoria => $nuevoValor]);

        return response()->json('Cantidad de ' . $columnaAleatoria . ' aumentada en 2 unidades');
    }





}
