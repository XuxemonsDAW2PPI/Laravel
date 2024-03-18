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
        Schema::create('inventarios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idusuario')->default(0); // Clave foránea hacia la tabla 'users'
            $table->unsignedBigInteger('monedas')->default(0); // Clave foránea hacia la tabla 'xuxemons'
            $table->unsignedBigInteger('caramelos')->default(0); 
            $table->unsignedBigInteger('piruleta')->default(0); 
            $table->unsignedBigInteger('piruletal')->default(0); 
            $table->unsignedBigInteger('algodon')->default(0); 
            $table->unsignedBigInteger('tabletachoco')->default(0); 
            $table->unsignedBigInteger('caramelo')->default(0); 
            $table->unsignedBigInteger('baston')->default(0);
            $table->unsignedBigInteger('caramelolargo')->default(0);
            $table->unsignedBigInteger('carameloredondo')->default(0);
            $table->unsignedBigInteger('surtido')->default(0);
            
        });
        Schema::table('inventarios', function (Blueprint $table) {
            $table->foreign('idusuario')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
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
