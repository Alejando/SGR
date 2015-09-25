<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    //
    protected $table = 'clientes';

     public function vales()
    {
        return $this->hasMany('App\Vale');
    }
}
