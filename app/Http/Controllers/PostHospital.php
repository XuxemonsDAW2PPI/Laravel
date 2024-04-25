<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\inventario;
use App\Models\xuxemoninv;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class PostHospital extends Controller
{
    public function CurarEnf1($idUser, $nombre){
        $xuxemoSelect = xuxemoninv::where('idusuario', $idUser)
        ->where('nombre', $nombre)
        ->first();

        if ($xuxemoSelect->Enfermedad1 == false) {
            return response()->json(['error' => 'Xuxemon no tiene esa enfermedad'], 404);
        }

        $Inventario = inventario::where('idusuario', $idUser)->first();

        if ($Inventario->Xocolatina < 1) {
            return response()->json(['error' => 'No tienes Xocolatinas para curar a este Xuxemon'], 404);
        } else {
            $Inventario->Xocolatina -= 1;
            $Inventario->save();
            $xuxemoSelect->Enfermedad1 = false;
            $xuxemoSelect->save();
            return response()->json(['success' => 'Pokemon curado de Bajón de Azucar'], 404);
        }
    }

    public function CurarEnf2($idUser, $nombre){
        $xuxemoSelect = xuxemoninv::where('idusuario', $idUser)
        ->where('nombre', $nombre)
        ->first();

        if ($xuxemoSelect->Enfermedad2 == false) {
            return response()->json(['error' => 'Xuxemon no tiene esa enfermedad'], 404);
        }

        $Inventario = inventario::where('idusuario', $idUser)->first();

        if ($Inventario->XalDeFrutas < 1) {
            return response()->json(['error' => 'No tienes XalDeFrutas para curar a este Xuxemon'], 404);
        } else {
            $Inventario->XalDeFrutas -= 1;
            $Inventario->save();
            $xuxemoSelect->Enfermedad2 = false;
            $xuxemoSelect->save();
            return response()->json(['success' => 'Pokemon curado de Sobredosis'], 404);
        }
    }

    public function CurarEnf3($idUser, $nombre){
        $xuxemoSelect = xuxemoninv::where('idusuario', $idUser)
        ->where('nombre', $nombre)
        ->first();

        if ($xuxemoSelect->Enfermedad3 == false) {
            return response()->json(['error' => 'Xuxemon no tiene esa enfermedad'], 404);
        }

        $Inventario = inventario::where('idusuario', $idUser)->first();

        if ($Inventario->Inxulina < 1) {
            return response()->json(['error' => 'No tienes Inxulina para curar a este Xuxemon'], 404);
        } else {
            $Inventario->Inxulina -= 1;
            $Inventario->save();
            $xuxemoSelect->Enfermedad3 = false;
            $xuxemoSelect->save();
            return response()->json(['success' => 'Pokemon curado de Atracón'], 404);
        }
    }
}
