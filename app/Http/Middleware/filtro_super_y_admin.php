<?php

namespace App\Http\Middleware;
use Session;
use Closure;
use Redirect;
class filtro_super_y_admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $tipo = Session::get('tipo');
        
        if(( $tipo != "0" ) && ( $tipo != "1" ))
        {
            Session::flash('message','Tu tipo es: '.$tipo);
            Session::flash('class','success');
            return redirect('sesion');
        }
        return $next($request);
    }
}
