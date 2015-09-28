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

    public function promocion()
    {
        return $this->belongsTo('App\Promocion', 'id_promocion');
    }

    public function distribuidor()
    {
        return $this->belongsTo('App\Distribuidor', 'id_distribuidor');
    }

    public function cuenta()
    {
        return $this->belongsTo('App\Cuenta', 'id_cuenta');
    }
}
