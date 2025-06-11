<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Producto extends Model
{
    public function almacences(){
        return $this->BelongsToMany(Almacen::class)
                        ->withTimestamps()
                        ->withPivot(['cantidad_actual', 'fecha_actualizacion']);
    }

    public function categoria(){
        return $this->belongsTo(Categoria::class);
    }
}
