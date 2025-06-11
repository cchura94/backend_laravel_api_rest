<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Almacen extends Model
{
    public function sucursal(){
        return $this->belongsTo(Sucursal::class);
    }

    public function productos(){
        return $this->belongsToMany(Producto::class)
                        ->withTimestamps()
                        ->withPivot(['cantidad_actual', 'fecha_actualizacion']);
    }

    public function notas(){
        return $this->belongsToMany(Nota::class, "movimientos")
                    ->withTimestamps()
                    ->withPivot(["producto_id", "cantidad", "tipo_movimiento", "precio_unitario_compra", "precio_unitario_venta", "total_linea", "observaciones"]);
    } 
}
