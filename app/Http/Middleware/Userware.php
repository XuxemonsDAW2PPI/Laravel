<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Usuarioss;

class Userware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function login(Request $request, Closure $next): Response
    {
        $Usuarios = Usuarios::find($request->input('Usuarios'));
        if ($Usuarios == null) {
            //return redirect()->route('tasks.auth')->with('error', 'No se ha encontrado ningun Usuario');
        } else {
            if($Usuarios->UserType == 'Usuario') {
                session(['Usuarios' => $Usuarios]);
                //return redirect()->route('tasks.Usuarios');
            } else if ($Usuarios->UserType == 'Admin'){
                session(['Usuarios' => $Usuarios]);
                //return redirect()->route('tasks.admin');
            }
        }
    }
}
