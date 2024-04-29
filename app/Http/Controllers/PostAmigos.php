<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\amigos;
use App\Models\User;

class PostAmigos extends Controller
{
    public function buscaramigo(Request $request){
        $amigo = User::where('tag', $request->input('amigo'));
        if (!$User) {
            return response()->json(['Usuario no encontarado']);
        }
        return response()->json($amigo);
    }


    public function añadiramigo($idUser, Request $request){
        $amigos = new amigos();

        $amigo = User::where('tag', $request->input('amigo'));
        if (!$User) {
            return response()->json(['Usuario no encontarado']);
        }
        $amigos->idusuario1 = $idUser;
        $amigos->idusuario2 = $amigo->id;
        $amigos->estado = "Pendiente";
        $amigos->save();

        return response()->json('Solicitud enviada correctamente');
    }

    public function listaamigos($idUser){
        $amigos = amigos::where('idusuario1', $idUser) // Filtrar por usuario1
                       ->orWhere('idusuario2', $idUser) // También filtrar por usuario2
                       ->where('estado', "Aceptado") 
                       ->get();
        if(!$amigos){
            return response()->json('No tienes amigos');
        }
        return response()->json($amigos);
    }

    public function aceptaramigo($idUser, Request $request){
        $amigo = User::where('tag', $request->input('solicitud'));
        if(!$amigo){
            return response()->json('Usuario no encontrado');
        }
        $amigos = amigos::where('idusuario1', $idUser)
                ->where('idusuario2', $amigo->id)
                ->get();
        if(!$amigos){
            return response()->json('Solicitud no encontrada');
        }

        $amigos->estado = "Aceptado";
        $amigos->save();
        return repsonse()->json('Aceptaste la solicitud de amistad');
    }

    public function rechazaramigo($idUser, Request $request){
        $amigo = User::where('tag', $request->input('solicitud'));
        if(!$amigo){
            return response()->json('Usuario no encontrado');
        }
        $amigos = amigos::where('idusuario1', $idUser)
                ->where('idusuario2', $amigo->id)
                ->get();
        if(!$amigos){
            return response()->json('Solicitud no encontrada');
        }

        $amigos->delete();
        return repsonse()->json('Rechazaste la solicitud de amistad');
    }

}
