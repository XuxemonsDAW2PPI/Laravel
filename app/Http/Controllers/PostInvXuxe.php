<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Xuxemon;
use App\Models\xuxemoninv;

class PostInvXuxe extends Controller
{
    public function give()
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
}
