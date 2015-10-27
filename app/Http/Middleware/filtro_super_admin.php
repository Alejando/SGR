<?php

namespace App\Http\Middleware;
use Session;
use Closure;
use Redirect;
class filtro_super_admin
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
        
        if($tipo != "0")
        {
            return redirect('c_sesion');
        }
        return $next($request);
    }
}
