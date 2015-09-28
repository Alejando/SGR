<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cuenta extends Model
{
    //
    protected $table = 'cuentas';
    protected $primaryKey = 'id_cuenta';

    public function vales()
    {
        return $this->hasMany('App\Vale', 'id_cuenta');
    }

    public function pagos()
    {
        return $this->hasMany('App\Pago', 'id_cuenta');
    }
}
