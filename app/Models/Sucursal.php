<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    public function users(){
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function almacenes(){
        return $this->hasMany(Almacen::class);
    }
}
