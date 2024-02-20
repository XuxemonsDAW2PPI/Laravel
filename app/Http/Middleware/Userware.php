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
    public function handle(Request $request, Closure $next): Response
    {
        $Usuarioss = Usuarioss::find($request->input('Usuarios'));
        if ($Usuarioss == null) {
            return redirect()->route('tasks.auth')->with('error', 'No se ha encontrado ningun Usuarios');
        } else {
            if($Usuarios->UserType == 'Usuarios') {
                session(['Usuarios' => $Usuarios]);
                return redirect()->route('tasks.Usuarios');
            } else if ($Usuarios->UserType == 'Admin'){
                session(['Usuarios' => $Usuarios]);
                return redirect()->route('tasks.admin');
            }
        }
    }
}
