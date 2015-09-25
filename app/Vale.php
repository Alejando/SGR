<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vale extends Model
{
    //
     protected $table = 'vales';

     public function cliente()
    {
        return $this->belongsTo('App\Cliente');
    }

    public function promocion()
    {
        return $this->belongsTo('App\Promocion');
    }

    public function distribuidor()
    {
        return $this->belongsTo('App\Distribuidor');
    }

    public function cuenta()
    {
        return $this->belongsTo('App\Cuenta');
    }
}
