<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class xuxes_diario extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:xuxes_diario';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Xuxes Diarias sisi';

    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user = User::all();
    
        if (!$user) {
            return response()->json('Usuario no encontrado', 404);
        }
    
        $inventario = inventario::firstOrCreate(['idusuario' => $userId]);
    
        // Verifica si la función ya se ejecutó hoy
        if ($user->ultima_ejecucion) {
            $ultimaEjecucion = Carbon::parse($user->ultima_ejecucion);
    
            if ($ultimaEjecucion->isToday()) {
                return response()->json('Debes esperar al siguiente día para ejecutar la función nuevamente', 400);
            }
        }
    
        // Aumenta la cantidad de objetos aleatorios en el inventario
        for ($i = 0; $i < 10; $i++) {
            $columnasInventario = Schema::getColumnListing('inventarios');
            $columnasPermitidas = array_diff($columnasInventario, ['id', 'idusuario']);
            $columnaAleatoria = collect($columnasPermitidas)->random();
            $nuevoValor = $inventario->{$columnaAleatoria} + 1;
            $inventario->{$columnaAleatoria} = $nuevoValor;
        }
    
        // Guarda los cambios en el inventario
        $inventario->save();
    
        // Actualiza la fecha de última ejecución
        $user->ultima_ejecucion = now();
        $user->save();
    
        return response()->json('Se han aumentado 10 objetos aleatorios al inventario del usuario.');
    }
}
