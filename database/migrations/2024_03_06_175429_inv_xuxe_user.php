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
        Schema::create('xuxemoninvs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idxuxemon');
            $table->unsignedBigInteger('idusuario');
            $table->string('nombre');
            $table->string('tipo');
            $table->string('tamano');
            $table->string('imagen');
            $table->string('estado');

            $table->foreign('idusuario')->references('id')->on('users');
            $table->foreign('idxuxemon')->references('id')->on('xuxemons');
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
