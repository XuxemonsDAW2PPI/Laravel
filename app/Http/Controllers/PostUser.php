<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\inventario;
use App\Models\xuxemoninv;

class PostUser extends Controller
{

    public function index()
    {
        $User = User::all();
        return response()->json($User);
    }

    public function show($id)
    {
        $User = User::find($id);
        if (!$User) {
            return response()->json('Usuario no encontrado');
        }
        return response()->json($User);
    }

    public function store(Request $request)
    {
        $randomNumber = rand(1000, 9999);

        $user = new User();
        $user->nombre = $request->input('nombre');
        $user->password = $request->input('password');
        $userFinal = $request->input('nombre') . "#" . $randomNumber;
        $user->tag = $userFinal;
        $user->email = $request->input('email');
        $user->userType = $request->input('usertype');
        $user->save();

        $inventario = new inventario();
        $inventario->idusuario = $user->id;
        $inventario->save();

        return response()->json('Usuario creado correctamente');

    }

    public function update(Request $request, $id)
    {
        $User = User::find($id);
        if (!$User) {
            return response()->json('Usuario no encontrado');
        }
        $User->id = $request->input('id');
        $User->nombre = $request->input('nombre');
        $User->password = $request->input('password');
        $User->email = $request->input('email');
        $User->userType = $request->input('usertype');
        $User->save();
        return response()->json('Usuario actualizado correctamente');
    }

    public function destroy($id)
    {
        $User = User::find($id);
        if (!$User) {
            return response()->json(['Usuario not found']);
        }
        $User->delete();
        return response()->json(['Usuario borrado']);
    }

    public function asignar4Xuxe($userId)
{
    
        $userXuxemonsCount = xuxemoninv::where('idusuario', $userId)->count();
        
        // Si el usuario ya tiene xuxemons asignados, devolver un mensaje indicando que no se puede asignar más
        if ($userXuxemonsCount > 0) {
            return response()->json('Este usuario ya tiene xuxemons asignados', 403);
        }
    
        $xuxemonsData = file_get_contents('./../database/data/data.json');
        $allXuxemons = json_decode($xuxemonsData, true);
    
        // Obtener una muestra aleatoria repetida de 10 xuxemons para el nuevo usuario
        $randomXuxemons = [];
        $tamanos = ['Pequeño', 'Mediano', 'Grande'];
        $totalXuxemons = count($allXuxemons);
    
        for ($i = 0; $i < 10; $i++) {
            $randomIndex = rand(0, $totalXuxemons - 1);
            $randomXuxemons[] = $allXuxemons[$randomIndex];
        }
    
        $user = User::find($userId);
    
        if (!$user) {
            return response()->json('Usuario no encontrado');
        }
    
        $activeXuxemonCount = 0;
    
        foreach ($randomXuxemons as $index => $xuxemon) {
            $xuxemoninv = new xuxemoninv();
            $xuxemoninv->idxuxemon = $xuxemon['id'];
            $xuxemoninv->idusuario = $userId;
            $xuxemoninv->nombre = $xuxemon['nombre'];
            $xuxemoninv->tipo = $xuxemon['tipo'];
            $xuxemoninv->tamano = $tamanos[array_rand($tamanos)]; // Seleccionar aleatoriamente un tamaño
            $xuxemoninv->imagen = $xuxemon['imagen'];
            
            // Asignar estado según el número de Xuxemons activos
            if ($activeXuxemonCount < 4) {
                $xuxemoninv->estado = 'Activo';
                $activeXuxemonCount++;
            } else {
                $xuxemoninv->estado = 'Inactivo';
            }
            
            $xuxemoninv->caramelos_comidos = $xuxemon['caramelos_comidos'];
            $xuxemoninv->save();
        }
    
        return response()->json('Xuxemons asignados correctamente');
    
}

}
