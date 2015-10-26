<?php

namespace App\Http\Middleware;
use Session;
use Closure;

class filtro_vendedor
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
        
        if($tipo == "2")
        {
            return ("Entras vendedor");
        }else{
            return ("Ni mandres, tu no eres un vendedor");
        }
    }
}
