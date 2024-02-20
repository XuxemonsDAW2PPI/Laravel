<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuarios;

class PostUser extends Controller
{
    public function index()
    {
        $Usuarios = Usuarios::all();
        return response()->json($Usuarios);
    }

    public function show($id)
    {
        $Usuarios = Usuarios::find($id);
        if (!$Usuarios) {
            return response()->json('Usuario no encontrado');
        }
        return response()->json($Usuarios);
    }

    public function store(Request $request)
    {
        $Usuarios = new Usuarios();
        $Usuarios->id = $request->input('id');
        $Usuarios->Nombre = $request->input('Nombre');
        $Usuarios->Contraseña = $request->input('Contraseña');
        $Usuarios->Correo = $request->input('Correo');
        $Usuarios->UserType = $request->input('UserType');
        $Usuarios->save();
        return response()->json('Usuario creado correctamente');
    }

    public function update(Request $request, $id)
    {
        $Usuarios = Usuarios::find($id);
        if (!$Usuarios) {
            return response()->json('Usuario no encontrado');
        }
        $Usuarios->id = $request->input('id');
        $Usuarios->Nombre = $request->input('Nombre');
        $Usuarios->Contraseña = $request->input('Contraseña');
        $Usuarios->Correo = $request->input('Correo');
        $Usuarios->UserType = $request->input('UserType');
        $Usuarios->save();
        return response()->json('Usuario actualizado correctamente');
    }

    public function destroy($id)
    {
        $Usuarios = Usuarios::find($id);
        if (!$Usuarios) {
            return response()->json(['Usuario not found']);
        }
        $Usuarios->delete();
        return response()->json(['Usuario borrado']);
    }
}
