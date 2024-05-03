<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\amigos;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PostAmigos extends Controller
{
    public function buscaramigo($userId, Request $request) {
        $tag = $request->input('tag');
        
        $user = User::find($userId);
        
        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }
        
        if ($user->tag === $tag) {
            return response()->json(['message' => 'Este tag es tuyo']);
        }
        
        $users = User::where('tag', $tag)->get();
        
        if ($users->isEmpty()) {
            return response()->json(['message' => 'No se encontró ningún usuario con el tag proporcionado'], 404);
        }
        
        $tags = $users->pluck('tag')->unique()->values();
        
        return response()->json(['tags' => $tags]);
    }
    
    


    public function añadiramigo($idUser, Request $request){
        $usuarioActual = User::findOrFail($idUser);
    
        $amigo = User::where('tag', $request->input('amigo'))->first();
    
        if (!$amigo) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }
        
        // Verificar si ya hay una solicitud pendiente o aceptada entre estos usuarios
        $existingRequest = Amigos::where(function ($query) use ($idUser, $amigo) {
            $query->where('idusuario1', $idUser)
                ->where('idusuario2', $amigo->id)
                ->orWhere('idusuario1', $amigo->id)
                ->where('idusuario2', $idUser);
        })->first();
        
        if ($existingRequest) {
            return response()->json(['error' => 'Ya existe una solicitud entre estos usuarios'], 400);
        }
        
        DB::beginTransaction();
        
        try {
            $amigos = new Amigos();
            $amigos->idusuario1 = $idUser;
            $amigos->idusuario2 = $amigo->id;
            $amigos->nombre1 = $usuarioActual->tag; 
            $amigos->nombre2 = $amigo->tag;
            $amigos->estado = "Pendiente";
            $amigos->save();
        
            DB::commit();
        
            return response()->json(['message' => 'Solicitud enviada correctamente', 'amigo' => $amigos], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Hubo un error al procesar la solicitud'], 500);
        }
    }
    

    public function listaSolicitudesAmistad($idUser){
        // Buscar las solicitudes de amistad pendientes para el usuario dado
        $solicitudes = Amigos::where('idusuario2', $idUser)
                            ->where('estado', 'Pendiente')
                            ->get();
    
        if($solicitudes->isEmpty()) {
            return response()->json(['message' => 'No tienes solicitudes de amistad pendientes'], 404);
        }
    
        $solicitudesConDetalle = [];
        foreach ($solicitudes as $solicitud) {
            $usuario = User::find($solicitud->idusuario1);
            $solicitudesConDetalle[] = [
                'id' => $solicitud->id,
                'nombre' => $usuario->nombre,
                'tag' => $usuario->tag,
            ];
        }
    
        return response()->json($solicitudesConDetalle);
    }
    

    public function listaamigos($idUser){
        $amigos = Amigos::where(function ($query) use ($idUser) {
                        $query->where('idusuario1', $idUser)
                            ->orWhere('idusuario2', $idUser);
                    })
                    ->where('estado', 'Aceptado')
                    ->get();
    
        if($amigos->isEmpty()) {
            return response()->json(['message' => 'No tienes amigos'], 404);
        }
    
        $nombresAmigos = collect();
    
        foreach ($amigos as $amigo) {
            if ($amigo->idusuario1 == $idUser) {
                $nombresAmigos->push($amigo->nombre2);
            } else {
                $nombresAmigos->push($amigo->nombre1);
            }
        }
    
        return response()->json($nombresAmigos);
    }
    

    public function aceptaramigo($idUser, Request $request){
        $amigoUsuario = User::where('tag', $request->input('solicitud'))->first();

        if (!$amigoUsuario) {
            return response()->json(['error' => 'Usuario no encontrado']);
        }
        
        $amigos = Amigos::where('idusuario2', $idUser)
                        ->where('idusuario1', $amigoUsuario->id)
                        ->get();
        
        if($amigos->isEmpty()){
            return response()->json(['error' => 'Solicitud no encontrada']);
        }
        
        // Actualizar el estado de la solicitud
        foreach ($amigos as $amigoSolicitud) {
            $amigoSolicitud->estado = "Aceptado";
            $amigoSolicitud->save();
        }
        
        return response()->json(['message' => 'Aceptaste la solicitud de amistad']);        
    }

    public function rechazaramigo($idUser, Request $request){
        $amigo = User::where('tag', $request->input('solicitud'))->first();

        if(!$amigo){
            return response()->json(['error' => 'Usuario no encontrado']);
        }
        
        $amigoSolicitud = Amigos::where('idusuario2', $idUser)
                                 ->where('idusuario1', $amigo->id)
                                 ->first();
        
        if(!$amigoSolicitud){
            return response()->json(['error' => 'Solicitud no encontrada']);
        }
        
        $amigoSolicitud->delete();
        
        return response()->json(['message' => 'Rechazaste la solicitud de amistad']);        
    }

}
