<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntidadComercial extends Model
{
    public function contactos(){
        return $this->hasMany(Contacto::class);
    }

    public function notas(){
        return $this->hasMany(Nota::class);
    }
}
