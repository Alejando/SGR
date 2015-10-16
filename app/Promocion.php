<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promocion extends Model
{
    //
    protected $table = 'promocions';
    protected $primaryKey = 'id_promocion';


     public function vales()
    {
        return $this->belongsToMany('App\Vale', 'vales_has_promociones', 'promocion_id', 'vale_id');
    }
}