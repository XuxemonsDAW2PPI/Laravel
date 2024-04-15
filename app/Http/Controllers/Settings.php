<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ajuste;

class Settings extends Controller
{
    public function sm_med(Request $request){
        $Ajuste = Ajuste::find(1);
        if (!$Ajuste) {
            return response()->json('Usuario no encontrado');
        }
        $Ajuste->id = 1;
        $Ajuste->sm_med = $request->input('sm_med');
        $Ajuste->save();
        return response()->json('Ajustes actualizados correctamente');
    }
    public function med_big(Request $request){
        $Ajuste = Ajuste::find(1);
        if (!$Ajuste) {
            return response()->json('Usuario no encontrado');
        }
        $Ajuste->id = 1;
        $Ajuste->med_big = $request->input('med_big');
        $Ajuste->save();
        return response()->json('Ajustes actualizados correctamente');
    }


    
}