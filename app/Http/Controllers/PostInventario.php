<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\inventario;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

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

    public function disminuirCantidadObjeto($userId, $objeto)
    {
        if ($userId === null || $objeto === null) {
            return response()->json('ID de usuario o objeto no proporcionado', 400);
        }

        $inventario = inventario::where('idusuario', $userId)->first();

        if (!$inventario) {
            return response()->json('Inventario no encontrado para este usuario', 404);
        }

        if (!isset($inventario->{$objeto})) {
            return response()->json('El objeto seleccionado no existe en el inventario', 404);
        }

        if ($inventario->{$objeto} <= 0) {
            return response()->json('La cantidad del objeto seleccionado es igual o menor que cero', 400);
        }

        $inventario->{$objeto} -= 1;
        $inventario->save();

        return response()->json('Cantidad de ' . $objeto . ' disminuida en 1 unidad');
    }

    
    public function aumentarObjetosDiarios($userId): JsonResponse
    {
        $user = User::find($userId);
    
        if (!$user) {
            return response()->json('Usuario no encontrado', 404);
        }
    
        $inventario = Inventario::firstOrCreate(['idusuario' => $userId]);
    
        // Verifica si la función ya se ejecutó hoy
        if ($user->ultima_ejecucion) {
            $ultimaEjecucion = Carbon::parse($user->ultima_ejecucion);
    
            if ($ultimaEjecucion->isToday()) {
                return response()->json('Debes esperar al siguiente día para ejecutar la función nuevamente', 400);
            }
        }
    
        // Aumenta la cantidad de objetos aleatorios en el inventario
        for ($i = 0; $i < 10; $i++) {
            $columnasInventario = Schema::getColumnListing('inventarios');
            $columnasPermitidas = array_diff($columnasInventario, ['id', 'idusuario']);
            $columnaAleatoria = collect($columnasPermitidas)->random();
            $nuevoValor = $inventario->{$columnaAleatoria} + 1;
            $inventario->{$columnaAleatoria} = $nuevoValor;
        }
    
        // Guarda los cambios en el inventario
        $inventario->save();
    
        // Actualiza la fecha de última ejecución
        $user->ultima_ejecucion = now();
        $user->save();
    
        return response()->json('Se han aumentado 10 objetos aleatorios al inventario del usuario.');
    }
}


    

    




