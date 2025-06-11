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
        Schema::create('notas', function (Blueprint $table) {
            $table->id();

            $table->string("codigo_nota", 100)->unique();
            $table->date("fecha_emision");
            $table->string("tipo_nota", 20);
            $table->bigInteger("entidad_comercial_id")->unsigned();
            $table->bigInteger("user_id")->unsigned();
            $table->decimal("subtotal", 12, 2);
            $table->decimal("impuestos", 12, 2)->nullable();
            $table->decimal("descuento_total", 12, 2)->nullable();
            $table->decimal("total_calculado", 12, 2);
            $table->string("estado_nota", 50);
            $table->text("observaciones")->nullable();

            // N:1
            $table->foreign("entidad_comercial_id")->references("id")->on("entidad_comercials");
            $table->foreign("user_id")->references("id")->on("users");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notas');
    }
};
