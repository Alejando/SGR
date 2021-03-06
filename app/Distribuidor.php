<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Distribuidor extends Model
{
    //
    protected $table = 'distribuidors';
    protected $primaryKey = 'id_distribuidor';


    public function vales()
    {
        return $this->hasMany('App\Vale', 'id_distribuidor');
    }

    public function pagos()
    {
        return $this->hasMany('App\Pago', 'id_distribuidor');
    }

    public function comision()
    {
        return $this->belongsTo('App\Comision', 'id_distribuidor');
    }

    public function cuenta()
    {
        return $this->belongsTo('App\Cuenta', 'id_cuenta');
    }
}
