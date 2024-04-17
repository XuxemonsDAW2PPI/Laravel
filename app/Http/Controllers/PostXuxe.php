<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Xuxemon;

class PostXuxe extends Controller
{

    public function cargarXuxemon(Request $request)
{
    $request->validate([
        'tamanoPorDefecto' => 'required|string|in:Pequeño,Mediano,Grande', // Validar el tamaño por defecto seleccionado por el administrador
    ]);

    $jsonFilePath = './../database/data/data.json';

    if (!file_exists($jsonFilePath) || !is_readable($jsonFilePath)) {
        return response()->json(['message' => 'El archivo JSON no existe o no se puede leer.'], 500);
    }

    $json = file_get_contents($jsonFilePath);

    $data = json_decode($json, true);

    if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
        return response()->json(['message' => 'Error al decodificar el archivo JSON: ' . json_last_error_msg()], 500);
    }

    foreach($data as $row) {
        $xuxemon = new Xuxemon();
        $xuxemon->id = $row['id'];
        $xuxemon->nombre = $row['nombre'];
        $xuxemon->tipo = $row['tipo'];
        $xuxemon->imagen = $row['imagen'];
        $xuxemon->tamano = $request->input('tamanoPorDefecto'); // Establecer el tamaño por defecto seleccionado por el administrador
        $xuxemon->caramelos_comidos = $row['caramelos_comidos'];
        $xuxemon->save();
    }

    return response()->json(['message' => 'Xuxemons cargados correctamente con el tamaño por defecto'], 200);
}

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
        $xuxemon->nombre = $request->input('nombre');
        $xuxemon->tipo = $request->input('tipo');
        $xuxemon->imagen = $request->input('imagen');
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
        $xuxemon->nombre = $request->input('nombre');
        $xuxemon->tipo = $request->input('tipo');
        $xuxemon->imagen = $request->input('imagen');
        $xuxemon->save();
        return response()->json('Xuxemon');
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

    public function actualizarTamano(Request $request)
{
    $request->validate([
        'nuevoTamano' => 'required|string|in:Pequeño,Mediano,Grande', // Ajusta las validaciones según tus necesidades
    ]);

    $nuevoTamano = $request->input('nuevoTamano');

    $xuxemons = Xuxemon::all();

    foreach ($xuxemons as $xuxemon) {
        $xuxemon->tamano = $nuevoTamano;
        $xuxemon->save();
    }

    return response()->json(['message' => 'Tamaño por defecto de los xuxemons modificados correctamente'], 200);
}



}
