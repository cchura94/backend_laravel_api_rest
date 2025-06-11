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
        Schema::create('personas', function (Blueprint $table) {
            $table->id();
            $table->string("nombres", 50);
            $table->string("apellidos", 50)->nullable();
            $table->date("fecha_nacimiento")->nullable();
            $table->string("genero", 30)->nullable();
            $table->string("telefono", 20)->nullable();
            $table->string("direccion", 200)->nullable();
            $table->string("documento_identidad")->nullable();
            $table->string("tipo_documento", 20)->nullable();
            $table->string("nacionalidad", 30);
            // N:1 
            $table->bigInteger("user_id")->unsigned();
            $table->foreign("user_id")->references("id")->on("users");           
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personas');
    }
};
