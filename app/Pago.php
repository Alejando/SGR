<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    //
    protected $table = 'pagos';
    protected $primaryKey = 'id_pago';

    public function cuenta()
    {
        return $this->belongsTo('App\Cuenta', 'id_cuenta');
    }

    public function distribuidor()
    {
        return $this->belongsTo('App\Distribuidor', 'id_distribuidor');
    }
}
