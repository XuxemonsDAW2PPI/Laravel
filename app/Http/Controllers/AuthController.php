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
        $credentials = $request->only('nombre', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            Session::put('User', $user);
            return response()->json(['user' => $user], 200);
        }

        return response()->json(['error' => 'Credenciales inválidas'], 401);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        Session::remove('User');
        return response()->json(['message' => 'Logout exitoso'], 200);
    }
}
