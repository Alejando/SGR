<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promocion extends Model
{
    //
    protected $table = 'promocions';
    protected $primaryKey = 'id_promocion';

     public function vales()
    {
        return $this->hasMany('App\Vale', 'id_promocion');
    }
}