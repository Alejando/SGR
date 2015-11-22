<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    //
   protected $table = 'movimientos';
   protected $primaryKey = 'id_movimiento';

   public function cuenta()
    {
        return $this->belongsTo('App\Cuenta', 'id_cuenta');
    }
}
