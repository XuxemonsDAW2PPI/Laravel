<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\inventario;
use App\Models\xuxemoninv;

class PostUser extends Controller
{

    public function index()
    {
        $User = User::all();
        return response()->json($User);
    }

    public function show($id)
    {
        $User = User::find($id);
        if (!$User) {
            return response()->json('Usuario no encontrado');
        }
        return response()->json($User);
    }

    public function store(Request $request)
    {
        $user = new User();
        $user->nombre = $request->input('nombre');
        $user->password = $request->input('password');
        $user->email = $request->input('email');
        $user->userType = $request->input('usertype');
        $user->save();

        $inventario = new inventario();
        $inventario->idusuario = $user->id;
        $inventario->save();

        return response()->json('Usuario creado correctamente');

    }

    public function update(Request $request, $id)
    {
        $User = User::find($id);
        if (!$User) {
            return response()->json('Usuario no encontrado');
        }
        $User->id = $request->input('id');
        $User->nombre = $request->input('nombre');
        $User->password = $request->input('password');
        $User->email = $request->input('email');
        $User->userType = $request->input('usertype');
        $User->save();
        return response()->json('Usuario actualizado correctamente');
    }

    public function destroy($id)
    {
        $User = User::find($id);
        if (!$User) {
            return response()->json(['Usuario not found']);
        }
        $User->delete();
        return response()->json(['Usuario borrado']);
    }

    public function asignar4Xuxe($userId)
{
    // Obtener los datos de todos los xuxemons desde el archivo JSON
    $xuxemonsData = file_get_contents('./../database/data/data.json');
    $allXuxemons = json_decode($xuxemonsData, true);

    // Elegir aleatoriamente 4 xuxemons para el nuevo usuario
    $randomXuxemons = collect($allXuxemons)->random(4);
    $tamanos = ['Pequeño', 'Mediano', 'Grande'];

    // Obtener el usuario
    $user = User::find($userId);

    if (!$user) {
        return response()->json('Usuario no encontrado');
    }

    // Crear registros en la tabla xuxemoninvs asociados al nuevo usuario
    foreach ($randomXuxemons as $xuxemon) {
        $xuxemoninv = new xuxemoninv();
        $xuxemoninv->idxuxemon = $xuxemon['id'];
        $xuxemoninv->idusuario = $userId;
        $xuxemoninv->nombre = $xuxemon['nombre'];
        $xuxemoninv->tipo = $xuxemon['tipo'];
        $xuxemoninv->tamano = $tamanos[array_rand($tamanos)]; // Seleccionar aleatoriamente un tamaño
        $xuxemoninv->imagen = $xuxemon['imagen'];
        $xuxemoninv->estado = 'Activo';
        $xuxemoninv->caramelos_comidos = $xuxemon['caramelos_comidos'];
        $xuxemoninv->save();
    }

    return response()->json('Se han asignado 4 Xuxemons al usuario.');
}
}
