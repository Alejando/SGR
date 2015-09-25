<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Distribuidor extends Model
{
    //
    protected $table = 'distribuidors';


    public function vales()
    {
        return $this->hasMany('App\Vale');
    }

    public function pagos()
    {
        return $this->hasMany('App\Pago');
    }
}
