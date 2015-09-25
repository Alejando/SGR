<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promocion extends Model
{
    //
    protected $table = 'promocions';

     public function vales()
    {
        return $this->hasMany('App\Vale');
    }
}