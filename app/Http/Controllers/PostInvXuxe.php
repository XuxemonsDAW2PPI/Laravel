<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Xuxemon;
use App\Models\InventarioXuxe;

class PostInvXuxe extends Controller
{
    public function give()
    {
        $InventarioXuxe = new InventarioXuxe();
        $InventarioXuxe->idUsuario = $request->input('idu');
        $InventarioXuxe->idXuxemon = $request->input('idx');
        $InventarioXuxe->save();
    }

    public function mostrarInv()
    {
        
    }
}
