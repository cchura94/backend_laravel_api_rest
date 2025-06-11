<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contacto extends Model
{
    public function entidad_comercial(){
        return $this->belongsTo(EntidadComercial::class);
    } 
}
