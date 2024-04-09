<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
{
    $request->validate([
        'nombre' => 'required|string',
        'password' => 'required|string',
    ]);

    $credentials = $request->only('nombre', 'password');

    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        $token = $user->createToken('AppName')->plainTextToken;
        return response()->json([
            'id' => $user->id,
            'user' => $user,
            'token' => $token,
            'usertype' => $user->usertype
        ], 200);
    }

    return response()->json(['error' => 'Credenciales inválidas'], 401);
}



    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        Auth::logout();
        return response()->json(['message' => 'Logout exitoso'], 200);
    }

}
