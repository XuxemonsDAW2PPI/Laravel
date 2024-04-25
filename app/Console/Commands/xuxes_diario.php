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
         // Obtener todos los inventarios
         $inventarios = Inventario::all();

         if ($inventarios->isEmpty()) {
             return response()->json('Inventarios no encontrados', 404);
         }
 
         foreach ($inventarios as $inventario) {
             // Obtener las columnas permitidas para la selección aleatoria
             $columnasInventario = Schema::getColumnListing('inventarios');
             
             // Excluir los campos que no deseas modificar (id e idusuario)
             $columnasPermitidas = array_diff($columnasInventario, ['id', 'idusuario']);
 
             // Aumenta la cantidad de objetos aleatorios en el inventario
             for ($i = 0; $i < 10; $i++) {
                 // Seleccionar una columna aleatoria de las permitidas
                 $columnaAleatoria = collect($columnasPermitidas)->random();
                 // Aumentar el valor de la columna seleccionada
                 $nuevoValor = $inventario->{$columnaAleatoria} + 1;
                 // Asignar el nuevo valor a la columna seleccionada
                 $inventario->{$columnaAleatoria} = $nuevoValor;
             }
 
             // Guardar los cambios en el inventario
             $inventario->save();
         }
 
         return response()->json('Se han aumentado 10 objetos aleatorios en todos los inventarios.');
        
    }
}
