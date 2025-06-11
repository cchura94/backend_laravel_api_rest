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
        Schema::create('almacen_producto', function (Blueprint $table) {
            $table->id();
            $table->integer("cantidad_actual")->default(0);
            $table->dateTime("fecha_actualizacion")->nullable();
            $table->bigInteger("almacen_id")->unsigned();
            $table->unsignedBigInteger("producto_id");

            $table->foreign("almacen_id")->references("id")->on("almacens");
            $table->foreign("producto_id")->references("id")->on("productos");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('almacen_producto');
    }
};
