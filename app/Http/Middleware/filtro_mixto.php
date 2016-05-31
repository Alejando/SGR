<?php

namespace App\Http\Middleware;
use Session;
use Closure;

class filtro_mixto
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
        
        if($tipo>3 || $tipo===null)
        {
             //Session::flash('message','Tu tipo es: '.$tipo);
           // Session::flash('class','success');
            Session::flush();
            return redirect('logout');
        }
        return $next($request);
    }
}
