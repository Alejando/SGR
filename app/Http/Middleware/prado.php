<?php

namespace App\Http\Middleware;
use Session;
use Closure;

class prado
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
        
        if($tipo == "1")
        {
            return ("Entras");
        }else{
            return ("Ni mandres");
        }
    }
}
