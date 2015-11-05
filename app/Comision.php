<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comision extends Model
{
    //
    protected $table = 'comisions';
    protected $primaryKey = 'id_comision';

    public function distribuidores()
    {
        return $this->hasMany('App\Distribuidor', 'id_distribuidor');
    }
}
