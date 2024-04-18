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
        Schema::create('Ajustes', function (Blueprint $table) {
            $table->id();
            $table->string('default')->default('Pequeño');
            $table->integer('sm_med');
            $table->integer('med_big');
            $table->integer('Enfermedad1');
            $table->integer('Enfermedad2');
            $table->integer('Enfermedad3');
            $table->integer('Bajon');
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
