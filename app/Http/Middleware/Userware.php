<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\User;
use Illuminate\Support\Facades\Hash; // Importar la clase Hash

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
        $user = User::where('nombre', $request->input('nombre'))->first();

        if ($user === null) {
            return Response::json(['error' => 'No se ha encontrado ningún usuario'], 404);
        }

        // Comprueba si la contraseña coincide usando la función de hash
        if (!Hash::check($request->input('password'), $user->password)) {
            return Response::json(['error' => 'Contraseña incorrecta'], 403);
        }

        if ($user->usertype === 'Usuario' || $user->usertype === 'Admin') {
            session(['User' => $user]);
            return $next($request);
        }

        return Response::json(['error' => 'Tipo de usuario no válido'], 403);
    }
}
