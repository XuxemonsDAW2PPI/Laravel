<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\inventario;
use Illuminate\Support\Facades\Session;

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

//Falta la funcion de aumentar la cantidad de cualquier objeto del inventario.

/*public function updateInventario(Request $request, $userId)
{
    $request->validate([
        'inventario' => 'required|array',
    ]);

    $inventario = $request->input('inventario');

    foreach ($inventario as $item) {
        $elemento = inventario::find($item['id']);

        if (!$elemento) {
            return response()->json('Elemento de inventario no encontrado', 404);
        }

        $elemento->monedas += 2;
        $elemento->caramelos += 2;
        $elemento->piruleta += 2;
        $elemento->piruletal += 2;
        $elemento->algodon += 2;
        $elemento->tabletachoco += 2;
        $elemento->caramelo += 2;
        $elemento->baston += 2;
        $elemento->caramelolargo += 2;
        $elemento->carameloredondo += 2;
        $elemento->surtido += 2;

        $elemento->save();
    }

    return response()->json('Inventario actualizado exitosamente');
}*/



}
