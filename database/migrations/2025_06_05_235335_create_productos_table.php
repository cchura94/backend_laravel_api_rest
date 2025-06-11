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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string("nombre", 200);
            $table->text("descripcion")->nullable();
            $table->string("codigo_barra", 100)->unique()->nullable();
            $table->string("unidad_medida", 50);
            $table->string("marca", 100)->nullable();
            $table->bigInteger("categoria_id")->unsigned();
            $table->decimal("precio_venta_actual", 12, 2)->default(0);
            $table->integer("stock_minimo")->default(0);
            $table->string("imagen_url")->nullable();
            $table->boolean("activo")->default(true);
            $table->dateTime("fecha_registro");

            // N:1
            $table->foreign("categoria_id")->references("id")->on("categorias");
                        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
