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
        Schema::create('amigos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idusuario1');
            $table->unsignedBigInteger('idusuario2');
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
