<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Models\Ajuste;

class Settings extends Controller
{
    public function swtmñ($id){
        $Ajuste = Ajuste::find($id);
        if (!$Ajuste) {
            return response()->json('Usuario no encontrado');
        }
        $Ajuste->id = $request->input('id');
        $Ajuste->default = $request->input('default');
        $Ajuste->sm_med = $request->input('sm_med');
        $Ajuste->med_big = $request->input('med_big');
        $Ajuste->save();
        return response()->json('Ajustes actualizados correctamente');
    }

    
}
