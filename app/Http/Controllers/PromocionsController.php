<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Promocion;
use Session;
use Carbon\Carbon;

class PromocionsController extends Controller
{

    public function crearPromocion()
    {
        return view('admin.crearPromocion');
    }

    public function guardarPromocion(Request $request)
    {   //Estandar de promociones 1="PAgue en..." 2="PAgue en 6 quinsenas" 3="Pague en  8 quinsenas"
        $promocion = new Promocion;
        $promocion->tipo_promocion = $request->input('tipo_promocion');
        $promocion->fecha_creacion = $request->input('fecha_creacion');
        $promocion->fecha_termino = $request->input('fecha_termino');
        if($request->input('fecha_inicio') != NULL)
        {
            $promocion->fecha_inicio = $request->input('fecha_inicio');
        }
        if($promocion->save()){
            Session::flash('message','Guardado Correctamente');
            Session::flash('class','success');
        }else{
            Session::flash('message','Ha ocurrido un error');
            Session::flash('class','danger');
        }
       return view('admin.crearPromocion');
    }
    
    public function buscarPromocion(){
        $promocions= Promocion::all();
        $fechaHoy=Carbon::today();           
        $results = array();
        foreach ($promocions as $promocion)//2015-12-27
            {       //fechas obtenidas de la base de datos de la promoción
                $fechaCreacionPromoDB=$promocion->fecha_creacion;
                $fechaTerminoPromoDB=$promocion->fecha_termino;
                //Convercion de fechas  a tipo Carbon 
                $fechaCreacionCarbon=Carbon::parse($fechaCreacionPromoDB);
                $fechaTerminoCarbon=Carbon::parse($fechaTerminoPromoDB);
                if($fechaHoy>=$fechaCreacionCarbon && $fechaHoy<=$fechaTerminoCarbon){
                    $results[] = $promocion;
                }
               
            }
        return response()->json($results);

            
       
        //return($fecha);
    }
}
