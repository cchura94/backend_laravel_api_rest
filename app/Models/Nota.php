<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function entidad_comercial(){
        return $this->belongsTo(EntidadComercial::class);
    }

    public function almacenes(){
        return $this->belongsToMany(Almacen::class, "movimiento")
                    ->withTimestamps()
                    ->withPivot(["producto_id", "cantidad", "tipo_movimiento", "precio_unitario_compra", "precio_unitario_venta", "total_linea", "observaciones"]);
    }
}
