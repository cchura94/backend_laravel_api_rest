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
        Schema::create('contactos', function (Blueprint $table) {
            $table->id();
            $table->string("nombre_completo");
            $table->string("rol_contacto")->nullable();
            $table->string("telefono_secundario")->nullable();
            $table->string("correo_secundario")->nullable();
            $table->text("observaciones")->nullable();

            $table->bigInteger("entidad_comercial_id")->unsigned();
            $table->foreign("entidad_comercial_id")->references("id")->on("entidad_comercials");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contactos');
    }
};
