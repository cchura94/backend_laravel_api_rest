<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    // protected $table = "categorias";
    // protected $primaryKey = 'cod_cate';
    // public $incrementing = false;
    // protected $keyType = 'string';

    // public $timestamps = false;

    public function productos(){
        return $this->hasMany(Producto::class);
    }

}
