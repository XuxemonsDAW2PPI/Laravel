<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Userware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = User::where('Nombre', $request->input('Nombre'))->first();

        if ($user === null) {
            return Response::json(['error' => 'No se ha encontrado ningún usuario'], 404);
        }

        // Comprueba si la contraseña coincide
        if ($request->input('Password') !== $user->Password) {
            return Response::json(['error' => 'Contraseña incorrecta'], 403);
        }

        if ($user->UserType === 'Usuario' || $user->UserType === 'Admin') {
            session(['User' => $user]);
            return $next($request);
        }

        return Response::json(['error' => 'Tipo de usuario no válido'], 403);
    }
}
