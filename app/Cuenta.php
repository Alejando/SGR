<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class Cuenta extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;
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
