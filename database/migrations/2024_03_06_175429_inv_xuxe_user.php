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
            $table->string('tamano')->default('Pequeño');
            $table->string('imagen');
            $table->string('estado');
            $table->unsignedBigInteger('caramelos_comidos')->default(0);

            $table->foreign('idusuario')->references('id')->on('users')->onDelete('cascade');
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
