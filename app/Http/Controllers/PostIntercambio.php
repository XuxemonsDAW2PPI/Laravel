<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\intercambio;

class PostIntercambio extends Controller
{
    public function registrarSolicitudIntercambio($idUsuario1, $tagUsuario1, $nombreXuxemon1, $tipo1, $tamanoXuxemon1, $caramelosComidosXuxemon1, $idUsuario2, $tagUsuario2) {
        try {
        $intercambio = new intercambio();
        $intercambio->idusuario1 = $idUsuario1;
        $intercambio->usertag1 = $tagUsuario1;
        $intercambio->nombre_xuxemon1 = $nombreXuxemon1;
        $intercambio->tipo1 = $tipo1;
        $intercambio->tamano_xuxemon1 = $tamanoXuxemon1;
        $intercambio->caramelos_comidosx1 = $caramelosComidosXuxemon1;
        $intercambio->idusuario2 = $idUsuario2;
        $intercambio->usertag2 = $tagUsuario2;
        $intercambio->nombre_xuxemon2 = null;
        $intercambio->tipo2 = null;
        $intercambio->tamano_xuxemon2 = null;
        $intercambio->caramelos_comidosx2 = null;
        $intercambio->consentimiento1 = null;
        $intercambio->consentimiento2 = null;
        $intercambio->estado = "Pendiente";
        $intercambio->save();
    
            return response()->json(['message' => 'Solicitud de intercambio registrada correctamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al registrar la solicitud de intercambio'], 500);
        }
    }

    public function listasolicitudespendientes($idUsuario)
    {
        $solicitudesPendientes = intercambio::where('estado', 'Pendiente')
            ->where(function ($query) use ($idUsuario) {
                $query->where('idusuario1', $idUsuario)
                    ->orWhere('idusuario2', $idUsuario);
            })
            ->get();

        // Crear un array para almacenar las respuestas
        $respuestas = [];

        // Recorrer las solicitudes pendientes encontradas
        foreach ($solicitudesPendientes as $solicitud) {
            // Verificar si el usuario actual es idusuario1
            if ($solicitud->idusuario1 == $idUsuario) {
                // Si el nombre_xuxemon2 es null, significa que falta el xuxemon de intercambio del otro usuario
                if ($solicitud->nombre_xuxemon2 === null) {
                    $mensaje = "Falta el xuxemon de intercambio del otro usuario";
                    $respuesta = [
                        'nombre_xuxemon1' => $solicitud->nombre_xuxemon1,
                        'tamano_xuxemon1' => $solicitud->tamano_xuxemon1,
                        'tipo1' => $solicitud->tipo1,
                        'idusuario2' => $solicitud->idusuario2,
                        'usertag' => $solicitud->usertag2,
                        'mensaje' => $mensaje
                    ];
                    // Agregar la respuesta al array de respuestas
                    $respuestas[] = $respuesta;
                } else {
                    // Si hay valores en todas las columnas, devolver todas las columnas con sus valores
                    $respuestas[] = $solicitud;
                }
            }
            elseif ($solicitud->idusuario2 == $idUsuario) {
                $respuesta = [
                    'idusuario1' => $solicitud->idusuario1,
                    'usertag' => $solicitud->usertag1,
                    'nombre_xuxemon1' => $solicitud->nombre_xuxemon1,
                    'tamano_xuxemon1' => $solicitud->tamano_xuxemon1,
                    'tipo1' => $solicitud->tipo1,
                    'caramelos_comidosx1' => $solicitud->caramelos_comidosx1
                ];
                // Agregar la respuesta al array de respuestas
                $respuestas[] = $respuesta;
            }
        }

        return response()->json($respuestas);
    }

    public function obtenerSolicitudesRecibidas($idUsuario)
    {
        $solicitudesRecibidas = intercambio::where('idusuario2', $idUsuario)
            ->where('estado', 'Pendiente')
            ->select('id', 'idusuario1', 'usertag1', 'nombre_xuxemon1', 'tamano_xuxemon1', 'tipo1', 'caramelos_comidosx1')
            ->get();

        return response()->json($solicitudesRecibidas);
    }

    public function denegarintercambio($idUsuario, $idIntercambio)
    {
        $intercambio = intercambio::where('id', $idIntercambio)
            ->where(function ($query) use ($idUsuario) {
                $query->where('idusuario1', $idUsuario)
                    ->orWhere('idusuario2', $idUsuario);
            })
            ->first();

        if ($intercambio) {
            $intercambio->delete();
            return response()->json(['message' => 'Intercambio denegado correctamente']);
        } else {
            // Si no se encontró el registro, devolver un mensaje de error
            return response()->json(['error' => 'No se encontró el registro de intercambio'], 404);
        }
    }
}
