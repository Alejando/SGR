<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    //
    protected $table = 'clientes';
    protected $primaryKey = 'id_cliente';

     public function vales()
    {
        return $this->hasMany('App\Vale', 'id_cliente');
    }
}
