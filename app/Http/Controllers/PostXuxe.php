<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Xuxemon;

class PostXuxe extends Controller
{
    public function index()
    {
        $xuxemon = Xuxemon::all();
        return response()->json($xuxemon);
    }

    public function show($id)
    {
        $xuxemon = Xuxemon::find($id);
        if (!$xuxemon) {
            return response()->json('Xuxemon no encontrado');
        }
        return response()->json($xuxemon);
    }

    public function store(Request $request)
    {
        $xuxemon = new Xuxemon();
        $xuxemon->id = $request->input('id');
        $xuxemon->Nombre = $request->input('Nombre');
        $xuxemon->Tipo = $request->input('Tipo');
        $xuxemon->Imagen = $request->input('Tamano');
        $xuxemon->save();
        return response()->json('Xuxemon creado correctamente');
    }

    public function update(Request $request, $id)
    {
        $xuxemon = Xuxemon::find($id);
        if (!$xuxemon) {
            return response()->json('Xuxemon no encontrado');
        }
        $xuxemon->id = $request->input('id');
        $xuxemon->Nombre = $request->input('Nombre');
        $xuxemon->Tipo = $request->input('Tipo');
        $xuxemon->Imagen = $request->input('Tamano');
        $xuxemon->save();
        return response()->json('Xuxemon actualizado correctamente');
    }

    public function destroy($id)
    {
        $xuxemon = Xuxemon::find($id);
        if (!$xuxemon) {
            return response()->json(['Xuxemon not found']);
        }
        $xuxemon->delete();
        return response()->json(['Xuxemon borrado']);
    }
}
