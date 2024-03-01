<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class PostUser extends Controller
{
    public function login()
    {
        return response()->json("HOLA!");
    }

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
        $User->nombre = $request->input('Nombre');
        $User->password = $request->input('Password');
        $User->email = $request->input('Email');
        $User->userType = $request->input('UserType');
        $User->save();
        return response()->json('Usuario creado correctamente');
    }

    public function update(Request $request, $id)
    {
        $User = User::find($id);
        if (!$User) {
            return response()->json('Usuario no encontrado');
        }
        $User->id = $request->input('id');
        $User->nombre = $request->input('Nombre');
        $User->password = $request->input('Password');
        $User->email = $request->input('Email');
        $User->userType = $request->input('UserType');
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
