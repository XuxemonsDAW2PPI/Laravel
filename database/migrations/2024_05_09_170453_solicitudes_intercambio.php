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
        Schema::create('intercambios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idusuario1');
            $table->string('usertag1');
            $table->string('nombre_xuxemon1');
            $table->string('tipo1');
            $table->string('tamano_xuxemon1');
            $table->unsignedBigInteger('caramelos_comidosx1');
            $table->unsignedBigInteger('idusuario2');
            $table->string('usertag2');
            $table->string('nombre_xuxemon2')->nullable();
            $table->string('tipo2')->nullable();
            $table->string('tamano_xuxemon2')->nullable();
            $table->unsignedBigInteger('caramelos_comidosx2')->nullable();
            $table->string('consentimiento1')->nullable();
            $table->string('consentimiento2')->nullable();
            $table->string('estado');

            $table->foreign('idusuario1')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('idusuario2')->references('id')->on('users')->onDelete('cascade');
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
