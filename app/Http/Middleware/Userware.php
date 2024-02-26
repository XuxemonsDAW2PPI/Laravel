<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class Userware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function login(Request $request, Closure $next): Response
    {
        $User = User::find($request->input('User'));
        if ($User == null) {
            //return redirect()->route('tasks.auth')->with('error', 'No se ha encontrado ningun Usuario');
        } else {
            if($User->UserType == 'Usuario') {
                session(['User' => $User]);
                //return redirect()->route('tasks.User');
            } else if ($User->UserType == 'Admin'){
                session(['User' => $User]);
                //return redirect()->route('tasks.admin');
            }
        }
    }
}
