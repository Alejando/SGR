<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cuenta extends Model
{
    //
    protected $table = 'cuentas';

    public function vales()
    {
        return $this->hasMany('App\Vale');
    }

    public function pagos()
    {
        return $this->hasMany('App\Pago');
    }
}
