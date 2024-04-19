<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Xuxemon;
use App\Models\xuxemoninv;
use App\Models\Ajuste;

class PostInvXuxe extends Controller
{
    public function give($request)
    {
        $xuxemoninv = new xuxemoninv();
        $xuxemoninv->idxuxemon = $request->input('idx');
        $xuxemoninv->idusuario = $request->input('idu');
        $xuxemoninv->nombre = $request->input('nombre');
        $xuxemoninv->tipo = $request->input('tipo');
        $xuxemoninv->tamano = $request->input('tamano');
        $xuxemoninv->imagen = $request->input('imagen');
        $xuxemoninv->save();
    }

    public function mostrar($id)
    {
        $xuxemoninv = xuxemoninv::where('idusuario', $id)->get();
        if ($xuxemoninv->isEmpty()) {
            return response()->json('Usuario no encontrado');
        }
        return response()->json($xuxemoninv);
    }

    public function destroy($idusuario, $id)
{
    $xuxemoninv = xuxemoninv::where('idusuario', $idusuario)
                             ->where('id', $id)
                             ->first();

    if (!$xuxemoninv) {
        return response()->json(['error' => 'Xuxemon inválido'], 404);
    }

    $xuxemoninv->delete();

    return response()->json(['success' => 'Xuxemon eliminado correctamente']);
}
    

    public function alimentarXuxemon($idUser, $nombre)
    {   
        $min = 1;
        $max = 100;
        $Aj = Ajuste::where('id', 1)->first();
        $nrando = rand($min, $max);

        $xuxemonInv = xuxemoninv::where('idusuario', $idUser)
                        ->where('nombre', $nombre)
                        ->first();

        if (!$xuxemonInv) {
            return response()->json(['error' => 'Xuxemon no encontrado'], 404);
        }

        if ($xuxemonInv->Enfermedad3 == true) {
            return response()->json(['error' => 'Xuxemon tiene Atracón']);
        }

        if ($nrando <= $Aj->Enfermedad1) {
            $xuxemonInv->Enfermedad1 = true;
            $xuxemonInv->save();
            return response()->json(['error' => 'Xuxemon se infectó con Bajón de Azúcar']);
        }

        if ($nrando <= $Aj->Enfermedad2) {
            $xuxemonInv->Enfermedad2 = true;
            $xuxemonInv->save();
            return response()->json(['error' => 'Xuxemon se infectó con Sobredosis de Azúcar']);
        }

        if ($nrando <= $Aj->Enfermedad3) {
            $xuxemonInv->Enfermedad3 = true;
            $xuxemonInv->save();
            return response()->json(['error' => 'Xuxemon se infectó con Atracón']);
        }

        $xuxemonInv->caramelos_comidos += 1;
        $xuxemonInv->save();

        // Verificar la transición de tamaño
        if ($xuxemonInv->tamano == 'Pequeño' && $xuxemonInv->caramelos_comidos >= $Aj->sm_med) {
            $xuxemonInv->tamano = 'Mediano';
            $xuxemonInv->caramelos_comidos = 0; // Reiniciar contador de caramelos_comidos
            $xuxemonInv->save();
        } elseif ($xuxemonInv->tamano == 'Mediano' && $xuxemonInv->caramelos_comidos >= $Aj->med_big) {
            $xuxemonInv->tamano = 'Grande';
            $xuxemonInv->caramelos_comidos = 0; // Reiniciar contador de caramelos_comidos
            $xuxemonInv->save();
        }

        return response()->json(['success' => 'Numero aleatorio '.$nrando]);
    }

    public function XuxemonInfectado($idUser){
        $xuxemonEnf1 = xuxemoninv::where('idusuario', $idUser)
                        ->where('Enfermedad1', true)->get();

        $xuxemonEnf2 = xuxemoninv::where('idusuario', $idUser)
        ->where('Enfermedad2', true)->get();

        $xuxemonEnf3 = xuxemoninv::where('idusuario', $idUser)
        ->where('Enfermedad3', true)->get();
        

        $XuxemonInfectados= [
            'Bajon' => $xuxemonEnf1,
            'Sobredosis' => $xuxemonEnf2,
            'Atracon' => $xuxemonEnf3
        ];

        return response()->json($XuxemonInfectados);
    }

}
