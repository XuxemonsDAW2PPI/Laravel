<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\intercambio;
use App\Models\xuxemoninv;

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
            $solicitudesEnviadas = Intercambio::where('idusuario1', $idUsuario)
                ->where('estado', 'Pendiente')
                ->select(
                    'nombre_xuxemon1',
                    'tipo1',
                    'tamano_xuxemon1',
                    'caramelos_comidosx1',
                    'idusuario2',
                    'usertag2',
                    'nombre_xuxemon2',
                    'tipo2',
                    'tamano_xuxemon2',
                    'caramelos_comidosx2',
                    'consentimiento1',
                    'consentimiento2',
                    'estado'
                )
                ->get();
        
            $solicitudesRecibidas = Intercambio::where('idusuario2', $idUsuario)
                ->where('estado', 'Pendiente')
                ->count();
        
            if ($solicitudesRecibidas > 0) {
                return response()->json(['message' => 'No se pueden devolver solicitudes enviadas si el usuario es idusuario2'], 400);
            }
        
            return response()->json($solicitudesEnviadas);
        }
    

    public function obtenerSolicitudesRecibidas($idUsuario)
{
    $solicitudesRecibidas = intercambio::where('idusuario2', $idUsuario)
        ->where('estado', 'Pendiente')
        ->where(function($query) {
            $query->whereNull('consentimiento2')
                  ->orWhere('consentimiento2', '!=', 'Confirmado');
        })
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

    public function aceptarSolicitudIntercambio(Request $request, $idusuario)
    {
        // Validar los datos recibidos
        $request->validate([
            'nombre_xuxemon2' => 'required|string|max:255',
            'tipo2' => 'required|string|max:255',
            'tamano_xuxemon2' => 'required|string|max:255',
            'caramelos_comidosx2' => 'required|integer'
        ]);

        // Buscar el registro que coincide con las condiciones especificadas
        $intercambio = intercambio::where('idusuario2', $idusuario)
            ->where('estado', 'Pendiente')
            ->whereNull('nombre_xuxemon2')
            ->whereNull('tipo2')
            ->whereNull('tamano_xuxemon2')
            ->whereNull('caramelos_comidosx2')
            ->whereNull('consentimiento1')
            ->whereNull('consentimiento2')
            ->first();

        // Verificar si se encontró un registro que cumpla con las condiciones
        if (!$intercambio) {
            return response()->json(['error' => 'No se encontró un intercambio que cumpla con las condiciones especificadas.'], 404);
        }

        // Actualizar el registro con los datos proporcionados
        $intercambio->update([
            'nombre_xuxemon2' => $request->nombre_xuxemon2,
            'tipo2' => $request->tipo2,
            'tamano_xuxemon2' => $request->tamano_xuxemon2,
            'caramelos_comidosx2' => $request->caramelos_comidosx2,
            'consentimiento2' => 'Confirmado'
        ]);

        // Devolver una respuesta de éxito
        return response()->json(['message' => 'Solicitud de intercambio aceptada con éxito.'], 200);
    }


    public function confirmarIntercambio1(Request $request)
{
    $idUsuario = $request->input('idusuario');

    // Buscar el registro de intercambio
    $intercambio = Intercambio::where('estado', 'Pendiente')
        ->where('idusuario1', $idUsuario)
        ->whereNull('consentimiento1')
        ->first();

    if ($intercambio) {
        // Actualizar la columna consentimiento1 a "Confirmado"
        $intercambio->consentimiento1 = 'Confirmado';
        $intercambio->save();

        // Buscar los Xuxemons en la tabla xuxemoninvs para el intercambio
        $xuxemonUsuario1 = xuxemoninv::where('idusuario', $intercambio->idusuario1)
            ->where('nombre', $intercambio->nombre_xuxemon1)
            ->first();

        $xuxemonUsuario2 = xuxemoninv::where('idusuario', $intercambio->idusuario2)
            ->where('nombre', $intercambio->nombre_xuxemon2)
            ->first();

        if ($xuxemonUsuario1 && $xuxemonUsuario2) {
            $tempIdUsuario = $xuxemonUsuario1->idusuario;
            $xuxemonUsuario1->idusuario = $xuxemonUsuario2->idusuario;
            $xuxemonUsuario2->idusuario = $tempIdUsuario;

            // Guardar los cambios
            $xuxemonUsuario1->save();
            $xuxemonUsuario2->save();

            return response()->json(['message' => 'Intercambio confirmado y Xuxemons intercambiados con éxito.'], 200);
        } else {
            return response()->json(['error' => 'No se encontraron los Xuxemons para el intercambio.'], 404);
        }
    } else {
        return response()->json(['error' => 'No se encontró el registro de intercambio o ya ha sido confirmado.'], 404);
    }

}

}
