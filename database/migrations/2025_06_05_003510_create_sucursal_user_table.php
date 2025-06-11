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
        Schema::create('sucursal_user', function (Blueprint $table) {
            $table->id();

            $table->bigInteger("sucursal_id")->unsigned();
            $table->bigInteger("user_id")->unsigned();
            $table->bigInteger("role_id")->unsigned()->nullable();

            $table->foreign("sucursal_id")->references("id")->on("sucursals");
            $table->foreign("user_id")->references("id")->on("users");

            $table->foreign("role_id")->references("id")->on("roles");            
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sucursal_user');
    }
};
