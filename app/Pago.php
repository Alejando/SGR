<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    //
    protected $table = 'pagos';

    public function cuenta()
    {
        return $this->belongsTo('App\Cuenta');
    }

    public function distribuidor()
    {
        return $this->belongsTo('App\Distribuidor');
    }
}
