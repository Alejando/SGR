<?php

namespace App\Http\Middleware;
use Session;
use Closure;

class filtro_admin
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
        
        if($tipo != "1")
        {
            return redirect('c_sesion');
        }
        return $next($request);
    }
}
