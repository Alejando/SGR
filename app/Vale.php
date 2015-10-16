<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vale extends Model
{
    //
     protected $table = 'vales';
     protected $primaryKey = 'id_vale';

     public function cliente()
    {
        return $this->belongsTo('App\Cliente', 'id_cliente');
    }

    public function distribuidor()
    {
        return $this->belongsTo('App\Distribuidor', 'id_distribuidor');
    }

    public function cuenta()
    {
        return $this->belongsTo('App\Cuenta', 'id_cuenta');
    }

    public function promociones()
    {
        return $this->belongsToMany('App\Promocion', 'vales_has_promociones', 'vale_id', 'promocion_id');
    }
}
