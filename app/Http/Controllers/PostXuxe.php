<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Xuxemon;

class PostXuxe extends Controller
{

    public function cargarXuxemon()
    {
        $jsonFilePath = './../database/data/data.json';

        // Verificar si el archivo existe y es accesible
        if (!file_exists($jsonFilePath) || !is_readable($jsonFilePath)) {
            die("El archivo JSON no existe o no se puede leer.");
        }
        
        // Leer el contenido del archivo JSON
        $json = file_get_contents($jsonFilePath);
        
        // Decodificar el JSON a un array asociativo
        $data = json_decode($json, true);
        
        // Verificar si la decodificación fue exitosa
        if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
            die("Error al decodificar el archivo JSON: " . json_last_error_msg());
        }

        $data = json_decode($json, true);


        foreach($data as $row) {
            $xuxemon = new Xuxemon();
            $xuxemon->id = $row['id'];
            $xuxemon->nombre = $row['nombre'];
            $xuxemon->tipo = $row['tipo'];
            $xuxemon->imagen = $row['imagen'];
            $xuxemon->save();
        }
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
}
