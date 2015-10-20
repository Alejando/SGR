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
    public function fechaPago(Request $request){
       $fecha=$request->input('fecha');
       $nPago=$request->input('nPago');
       $cambioFecha=$request->input('cambioFecha');
       
       $fechaCarbon=Carbon::parse($fecha);
       $diasMes=$fechaCarbon->daysInMonth;
       if($cambioFecha==0){          
                $fechaCarbon->addDay();
       }
       if($cambioFecha==1 && $fechaCarbon->day<=15){
              $fechaCarbon->subDay();
       }
        if($fechaCarbon->day>=15 && $fechaCarbon->day<=$diasMes){
            $fechaCarbon->day=1;
            if($nPago%2==0){
                $fechaCarbon->addMonths($nPago/2);
                 $fechaCarbon->day(15);
                return $fechaCarbon->toDateString();
            }
            else{
                $fechaCarbon->addMonths(($nPago+1)/2);
                 $fechaCarbon->subDay();
                return $fechaCarbon->toDateString();
            }
          
        }
        else{
            if($fechaCarbon->day>15){
                 $fechaCarbon->day=1;
                 $fechaCarbon->addMonth();
            }else{
                 $fechaCarbon->day=1;
            }
           
            if($nPago%2==0){
                 $fechaCarbon->addMonths(($nPago)/2);
                 $fechaCarbon->subDay();
                return $fechaCarbon->toDateString();
            }
            else{
               $fechaCarbon->addMonths($nPago/2);
                 $fechaCarbon->day(15);
                return $fechaCarbon->toDateString();
            }
        }

   
    }

}
