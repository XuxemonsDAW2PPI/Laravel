<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inventario', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idUsuario'); // Clave foránea hacia la tabla 'users'
            $table->unsignedBigInteger('idXuxemon'); // Clave foránea hacia la tabla 'xuxemons'
            
            // Definir las restricciones de clave foránea
            $table->foreign('idUsuario')->references('id')->on('users');
            $table->foreign('idXuxemon')->references('id')->on('xuxemons');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
