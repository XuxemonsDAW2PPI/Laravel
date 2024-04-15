<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\inventario;

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
        $User = new User();
        $User->id = $request->input('id');
        $User->nombre = $request->input('nombre');
        $User->password = $request->input('password');
        $User->email = $request->input('email');
        $User->userType = $request->input('usertype');
        $User->save();

        $inventario = new inventario();
        $inventario->idusuario = $User->id;
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
}
