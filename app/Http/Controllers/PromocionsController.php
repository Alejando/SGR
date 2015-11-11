<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Promocion;

use App\Vales_has_promociones;

use App\Vale;

use Session;
use Carbon\Carbon;

class PromocionsController extends Controller
{

    public function crearPromocion()
    {
        return view('admin.crearPromocion');
    }

    public function guardarPromocion(Request $request)
    {   //Estandar de promociones 1="PAgue en..." 2="PAgue en 6 quincenas" 3="Pague en  8 quincenas"
        $fechaHoy=Carbon::today(); 
        $promocionNueva = new Promocion;
        $promocionNueva->tipo_promocion = $request->input('tipo_promocion');
        $promocionNueva->fecha_creacion = $request->input('fecha_creacion');
        $promocionNueva->fecha_termino = $request->input('fecha_termino');
        if($request->input('fecha_inicio') != NULL)
        {
            $promocionNueva->fecha_inicio = $request->input('fecha_inicio');
            $fechaInicioPagoPromoDB=$promocionNueva->fecha_inicio;
            $fechaInicioPagoNuevaCarbon=Carbon::parse($fechaInicioPagoPromoDB);
        }

        if($request->input('numero_pagos') != NULL)
        {
            $promocionNueva->numero_pagos = $request->input('numero_pagos');
        }

        $fechaCreacionPromoDB=$promocionNueva->fecha_creacion;
        $fechaTerminoPromoDB=$promocionNueva->fecha_termino;
        $fechaInicioNuevaCarbon=Carbon::parse($fechaCreacionPromoDB);
        $fechaTerminoNuevaCarbon=Carbon::parse($fechaTerminoPromoDB);

        $promocions = Promocion::all();
        foreach ($promocions as $promocion)//2015-12-27
            {   
                
                $fechaInicioCarbon=Carbon::parse($promocion->fecha_creacion);
                $fechaTerminoCarbon=Carbon::parse($promocion->fecha_termino);
               
                //if(($fechaInicioNuevaCarbon>=$fechaCreacionCarbon && $fechaInicioNuevaCarbon<=$fechaTerminoCarbon) || ($fechaTerminoNuevaCarbon>=$fechaCreacionCarbon && $fechaTerminoNuevaCarbon<=$fechaTerminoCarbon))

                if(($promocionNueva->tipo_promocion == $promocion->tipo_promocion) && (($fechaInicioNuevaCarbon >= $fechaInicioCarbon && $fechaInicioNuevaCarbon <= $fechaTerminoCarbon) ||  ($fechaTerminoNuevaCarbon >= $fechaInicioCarbon && $fechaTerminoNuevaCarbon <= $fechaTerminoCarbon))) 
                {
                    $promocionRepetida = $promocion;
                    $Repetida = true;
                    break;
                }else{
                   $Repetida = false; 
                } 
                
               
            }


        if($fechaInicioNuevaCarbon<$fechaHoy)
        {
            Session::flash('message','La fecha de inicio no puede ser menor a la fecha de hoy');
            Session::flash('class','danger');
        }else
            {
                if($fechaInicioNuevaCarbon>=$fechaTerminoNuevaCarbon)
                {
                    Session::flash('message','La fecha de inicio no puede ser mayor o igual a la fecha de termino');
                    Session::flash('class','danger');
                }else
                    {
                        if($fechaTerminoNuevaCarbon<=$fechaInicioNuevaCarbon)
                        {
                            Session::flash('message','La fecha de termino no puede ser menor o igual a fecha de inicio');
                            Session::flash('class','danger');
                        }else
                            {
                                if($request->input('fecha_inicio') != NULL)
                                {
                                    if($fechaInicioPagoNuevaCarbon<=$fechaTerminoNuevaCarbon){
                                        Session::flash('message','La fecha del primer pago no puede ser menor o igual a la fecha termino');
                                        Session::flash('class','danger');
                                    }else
                                        {
                                            if($Repetida)
                                            {
                                               switch ($promocionRepetida->tipo_promocion)
                                               {
                                                    case 1:
                                                        Session::flash('message','Ya se encuentra una promoción vigente que abarca del '. $promocionRepetida->fecha_creacion .' al '. $promocionRepetida->fecha_termino .' con fecha de inicio de '. $promocionRepetida->fecha_inicio);
                                                        Session::flash('class','danger');
                                                        break;
                                                    case 2:
                                                        Session::flash('message','Ya se encuentra una promoción vigente que abarca del '. $promocionRepetida->fecha_creacion .' al '. $promocionRepetida->fecha_termino .' a '. $promocionRepetida->numero_pagos .' quincenas');
                                                        Session::flash('class','danger');
                                                        break;
                                                }
                                                
                                            }else
                                                {
                                                    $promocionNueva->save();
                                                    Session::flash('message','Guardado Correctamente');
                                                    Session::flash('class','success');
                                                }
                                        }
                                }else
                                    {
                                        if($Repetida)
                                        {
                                            Session::flash('message','Ya se encuentra una promoción vigente del mismo tipo');
                                            Session::flash('class','danger');
                                        }else
                                            {
                                                $promocionNueva->save();
                                                Session::flash('message','Guardado Correctamente');
                                                Session::flash('class','success');
                                            }
                                    }
                                

                            }

                    }
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
       
            
            if($cambioFecha==1){
                if($fechaCarbon->day==15){
                    $fechaCarbon->day=8;
                }
                else{
                    $fechaCarbon->day=15;
                }
            }
        
        if($fechaCarbon->day>=10 && $fechaCarbon->day<=24){
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
            if($fechaCarbon->day<=9){
                $fechaCarbon->day=15;
            }else{
                $fechaCarbon->day=15;
                $fechaCarbon->addMonth();
            }
           
            if($nPago%2==0){
                 $fechaCarbon->addMonths(($nPago)/2);
                  $fechaCarbon->day=1;
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
    function consultarPromociones(){
        switch (Session::get('tipo')) {
            case 0:
               // return redirect('');
                //return ("Eres un super administrador");
                break;
            case 1:
                return view('admin.consultarPromociones');
                break;
            case 2:
                 return view('vendedor.consultarPromociones');
                break;
        }   
    }
    function obtenerPromociones(){
        
        $promocion = Promocion::where('fecha_termino','>=',Carbon::parse(Carbon::today()))->get();
        for ($i=0; $i <sizeof($promocion); $i++) {        
                if($promocion[$i]->fecha_inicio=="0000-00-00"){
                    $promocion[$i]->fecha_inicio="No aplica";
                }
                if($promocion[$i]->tipo_promocion==2){
                    $promocion[$i]->tipo_promocion="Paga en ".$promocion[$i]->numero_pagos." quincenas";
                }
                if($promocion[$i]->tipo_promocion==1){
                    $promocion[$i]->tipo_promocion="Comienza a pagar en...";
                }
                $promocion[$i]->acciones='<a type="button" class="btn btn-primary margin" href="editarPromocion/'. $promocion[$i]->id_promocion.'">Actualizar</a>'; 
        }    
        return $promocion;
    }

    public function editarPromocion($id)
    {
        $promocion = Promocion::find($id);
        switch (Session::get('tipo')) 
        {
            case 0:
               // return redirect('');
                //return ("Eres un super administrador");
                break;
            case 1:
                switch ($promocion->tipo_promocion) 
                {
                    case 1:
                        //Empiece a pagar apartir de una fehca
                        return view('admin.editarPromocionTipo1',compact('promocion'));
                        break;
                    case 2:
                        //Paga en 6 o 8 quincenas
                        return view('admin.editarPromocionTipo2',compact('promocion'));
                        break;
                    
                }
                break;
            
        }        
    }

     public function actualizarPromocion(Request $request, $id)
     {   //Estandar de promociones 1="PAgue en..." 2="PAgue en 6 quincenas" 3="Pague en  8 quincenas"
        $fechaHoy=Carbon::today(); 
        $promocionEditada = Promocion::find($id);
        //$promocionEditada->tipo_promocion = $request->input('tipo_promocion');
        $promocionEditada->fecha_creacion = $request->input('fecha_creacion');
        $promocionEditada->fecha_termino = $request->input('fecha_termino');
        if($request->input('fecha_inicio') != NULL)
        {
            $promocionEditada->fecha_inicio = $request->input('fecha_inicio');
            $fechaInicioPagoPromoDB=$promocionEditada->fecha_inicio;
            $fechaInicioPagoNuevaCarbon=Carbon::parse($fechaInicioPagoPromoDB);
        }
        //var_dump($promocionEditada->fecha_termino);

        if($request->input('numero_pagos') != NULL)
        {
            $promocionEditada->numero_pagos = $request->input('numero_pagos');
        }

        //return $promocionEditada;

        $fechaCreacionPromoDB=$promocionEditada->fecha_creacion;
        $fechaTerminoPromoDB=$promocionEditada->fecha_termino;
        $fechaInicioNuevaCarbon=Carbon::parse($fechaCreacionPromoDB);
        $fechaTerminoNuevaCarbon=Carbon::parse($fechaTerminoPromoDB);



        $filtroPromocions = Promocion::all();
        for($i=0; $i<count($filtroPromocions); $i++)
            {
                if($promocionEditada->id_promocion != $filtroPromocions[$i]->id_promocion)
                {
                    $promocions[$i] = $filtroPromocions[$i];
                }
            }

        foreach ($promocions as $promocion)//2015-12-27
            {   
                
                $fechaInicioCarbon=Carbon::parse($promocion->fecha_creacion);
                $fechaTerminoCarbon=Carbon::parse($promocion->fecha_termino);
               
                //if(($fechaInicioNuevaCarbon>=$fechaCreacionCarbon && $fechaInicioNuevaCarbon<=$fechaTerminoCarbon) || ($fechaTerminoNuevaCarbon>=$fechaCreacionCarbon && $fechaTerminoNuevaCarbon<=$fechaTerminoCarbon))

                if(($promocionEditada->tipo_promocion == $promocion->tipo_promocion) && (($fechaInicioNuevaCarbon >= $fechaInicioCarbon && $fechaInicioNuevaCarbon <= $fechaTerminoCarbon) ||  ($fechaTerminoNuevaCarbon >= $fechaInicioCarbon && $fechaTerminoNuevaCarbon <= $fechaTerminoCarbon))) 
                {
                    $promocionRepetida = $promocion;
                    $Repetida = true;
                    break;
                }else{
                   $Repetida = false; 
                } 
                
               
            }


        if($fechaInicioNuevaCarbon<$fechaHoy)
        {
            Session::flash('message','La fecha de inicio no puede ser menor a la fecha de hoy');
            Session::flash('class','danger');
        }else
            {
                if($fechaInicioNuevaCarbon>=$fechaTerminoNuevaCarbon)
                {
                    Session::flash('message','La fecha de inicio no puede ser mayor o igual a la fecha de termino');
                    Session::flash('class','danger');
                }else
                    {
                        if($fechaTerminoNuevaCarbon<=$fechaInicioNuevaCarbon)
                        {
                            Session::flash('message','La fecha de termino no puede ser menor o igual a fecha de inicio');
                            Session::flash('class','danger');
                        }else
                            {
                                if($request->input('fecha_inicio') != NULL)
                                {
                                    if($fechaInicioPagoNuevaCarbon<=$fechaTerminoNuevaCarbon){
                                        Session::flash('message','La fecha del primer pago no puede ser menor o igual a la fecha termino');
                                        Session::flash('class','danger');
                                    }else
                                        {
                                            if($Repetida)
                                            {
                                               switch ($promocionRepetida->tipo_promocion)
                                               {
                                                    case 1:
                                                        Session::flash('message','Ya se encuentra una promoción vigente que abarca del '. $promocionRepetida->fecha_creacion .' al '. $promocionRepetida->fecha_termino .' con fecha de inicio de '. $promocionRepetida->fecha_inicio);
                                                        Session::flash('class','danger');
                                                        break;
                                                    case 2:
                                                        Session::flash('message','Ya se encuentra una promoción vigente que abarca del '. $promocionRepetida->fecha_creacion .' al '. $promocionRepetida->fecha_termino .' a '. $promocionRepetida->numero_pagos .' quincenas');
                                                        Session::flash('class','danger');
                                                        break;
                                                }
                                                
                                            }else
                                                {
                                                    $promocionEditada->save();
                                                    Session::flash('message','Guardado Correctamente');
                                                    Session::flash('class','success');
                                                }
                                        }
                                }else
                                    {
                                        if($Repetida)
                                        {
                                            Session::flash('message','Ya se encuentra una promoción vigente del mismo tipo');
                                            Session::flash('class','danger');
                                        }else
                                            {
                                                $promocionEditada->save();
                                                Session::flash('message','Guardado Correctamente');
                                                Session::flash('class','success');
                                            }
                                    }
                                

                            }

                    }
                }
       return redirect('consultarPromociones');
    }

   

}
