<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Distribuidor;
use App\Vale;
use App\Cliente;
use Carbon\Carbon;
use App\DistribuidorsController;
use App\Comision;
use App\Pago;
use App\Cuenta;
use Session;

class PdfController extends Controller
{


    public function reporte_2(Request $request){ //reporte cobranza
        $id=$request->input('id');
        $fecha=$request->input('fecha');
        if($fecha==""){
            $fecha=Carbon::today();
        }
        
        $pagosAbonados = Pago::where('id_distribuidor', $id)->where('estado', 3)->get();

        $vales=Vale::where('id_distribuidor',$id)->where('deuda_actual','>',0)->where('estatus',1)->where('fecha_inicio_pago','<=',$this->calcularFechaCorte($fecha))->get();
        
        if(sizeof($vales)>0){
    

        $valesClonados = array();
        for ($i=0; $i <sizeof($vales); $i++) 
        {
            $clon = clone $vales[$i];
            $valesClonados[]=$clon;
        }
        //Caboniar fechas 


        for ($i=0; $i <sizeof($vales); $i++) 
        {
            for($j=0; $j < sizeof($pagosAbonados); $j++)
                {
                    $fecha_pago_carbon = Carbon::parse($vales[$i]->fecha_inicio_pago);
                    $fecha_atraso_carbon = Carbon::parse($pagosAbonados[$j]->fecha_creacion);
                    if(($vales[$i]->pagos_realizados < ($vales[$i]->numero_pagos)-1) && ($fecha_pago_carbon <= $fecha_atraso_carbon ))
                    { 
                        $importe=$vales[$i]->cantidad; //*
                        $saldoAnterior=$vales[$i]->deuda_actual; //*
                        $pagosRealizados=$vales[$i]->pagos_realizados+1; //*
                        $numeroPagos=$vales[$i]->numero_pagos; //*
                        $abono=$this->calcularPago($importe,$numeroPagos,$pagosRealizados); //*
                        $saldoActual=$saldoAnterior-$abono; //*
                        $vales[$i]->deuda_actual=$saldoActual;

                        $vales[$i]->pagos_realizados=$vales[$i]->pagos_realizados+1;
                        $clone = clone $vales[$i];
                        $valesClonados[]=$clone; 
                    }
                }     
        }     

        $saldoTotal=0;
        $saldoImporte=0;
        $saldoAnteriorTotal=0;
        $saldoComision;
        for ($i=0; $i <sizeof($valesClonados); $i++) { 
            
             $importe=$valesClonados[$i]->cantidad; //*
             //11.-saldoImporte
             $saldoImporte+=$importe;
             $saldoAnterior=$valesClonados[$i]->deuda_actual; //*

             //10.-saldoAnteriorTotal
             $saldoAnteriorTotal+=$saldoAnterior;
             $pagosRealizados=$valesClonados[$i]->pagos_realizados+1; //*
             $numeroPagos=$valesClonados[$i]->numero_pagos; //*
             $abono=$this->calcularPago($importe,$numeroPagos,$pagosRealizados); //*

             //8.-saldoTotal
             $saldoTotal+=$abono;
             $saldoActual=$saldoAnterior-$abono; //*
             $nombreCliente=Vale::find($valesClonados[$i]->id_vale)->cliente->nombre;

            $valesClonados[$i]->id_cliente=$nombreCliente;
            $valesClonados[$i]->cantidad="$".$importe.".00";
            $valesClonados[$i]->numero_pagos="$".$saldoAnterior.".00";
            $valesClonados[$i]->pagos_realizados=$pagosRealizados." de ".$numeroPagos;
            $valesClonados[$i]->cantidad_limite="$".$abono.".00";
            $valesClonados[$i]->deuda_actual="$".$saldoActual.".00";
            
         }

        

        //1.-Datas

        $totalVales=sizeof($valesClonados);
        $comision=$this->calcularComision($saldoTotal,$id);
        $saldoDistribuidor=intval(($saldoTotal*$comision)/100);  
        $saldoComision=$saldoTotal-$saldoDistribuidor;

        $datas = $valesClonados;
        
        //2.- FechaHoy
        $fechaHoy = $this->modificarFechas(Carbon::now());
        
        //3.-Distribuidor
        $distribuidor=$id.".-".Distribuidor::find($id)->nombre;


        //4.-fechaEntrega
        $fechaEntrega=$this->CalcularFechaEntrega($fecha);

        //5.- FechaLimite
        $fechaLimite=$this->CalcularFechaLimite($fecha);

        //6.-periodo
        $periodo=$this->calcularPeriodo($fecha);

        //7.-comision
        $saldoDistribuidor=intval(($saldoTotal*$comision)/100); 

        //9.-saldoComision
        $saldoComision=$saldoTotal-$saldoDistribuidor;

        //12.-saldoActualTotal
        $saldoActualTotal=$saldoAnteriorTotal-$saldoTotal;
        
        
     
            $view =  \View::make('reportes/reporte_2', compact('datas','totalVales','fechaHoy','distribuidor', 'fechaEntrega','fechaLimite','periodo','comision','saldoTotal','saldoComision','saldoAnteriorTotal','saldoImporte','saldoActualTotal'))->render();
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML($view);
            return $pdf->stream('reporte_2.pdf');
        }else{
            
           $view =  \View::make('reportes/nodisponible')->render();
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML($view);
            return $pdf->stream('noDisponible.pdf');
        }
        

    }

    public function reporte_9_pdf(Request $request)
    {
        
                $distribuidor=$request->input('distribuidor');
                if($distribuidor=="0"){
                    $fechaInicio=$request->input('fecha_inicio');
                    if($fechaInicio=="0"){
                        $fechaTermino=$request->input('fecha_termino');
                        if($fechaTermino=="0"){
                            $vendedor=$request->input('vendedor');
                            if($vendedor=="0"){
                                 $vales = Vale::where('estatus',1)->get(); //consulta al inicio
                            }else{
                                $vales = Vale::where('estatus',1)->where('id_cuenta',$vendedor)->get();
                            }
                        }else{
                            $vendedor=$request->input('vendedor');
                            if($vendedor=="0"){
                                $vales = Vale::where('estatus',1)->where('fecha_inicio_pago','<=',$fechaTermino)->get();//buscar vales con fecha termino
                            }else{
                                $vales = Vale::where('estatus',1)->where('fecha_inicio_pago','<=',$fechaTermino)->where('id_cuenta',$vendedor)->get();//buscar vales con fecha termino y vendedor
                            }
                        }
                    }else{
                        $fechaTermino=$request->input('fecha_termino');
                        if($fechaTermino=="0"){
                            $vendedor=$request->input('vendedor');
                            if($vendedor=="0"){
                                 $vales = Vale::where('estatus',1)->where('fecha_inicio_pago','>=',$fechaInicio)->get();
                            // fecha inicio
                            }else{
                                $vales = Vale::where('estatus',1)->where('fecha_inicio_pago','>=',$fechaInicio)->where('id_cuenta',$vendedor)->get();//buscar vales con fecha termino y vendedor
                            }

                        }else{
                          $vendedor=$request->input('vendedor');
                            if($vendedor=="0"){
                                $vales = Vale::where('estatus',1)->where('fecha_inicio_pago','>=',$fechaInicio)->where('fecha_inicio_pago','<=',$fechaTermino)->get();//buscar vales con fecha inicio y fecha termino
                            
                            }else{
                                $vales = Vale::where('estatus',1)->where('fecha_inicio_pago','>=',$fechaInicio)->where('fecha_inicio_pago','<=',$fechaTermino)->where('id_cuenta',$vendedor)->get();//buscar vales con fecha Inicio, termino y vendedor
                            }
                           
                        }
                    }

                }else{
                    $fechaInicio=$request->input('fecha_inicio');
                    if($fechaInicio=="0"){
                        $fechaTermino=$request->input('fecha_termino');
                        if($fechaTermino=="0"){
                            $vendedor=$request->input('vendedor');
                            if($vendedor=="0"){
                                $vales = Vale::where('id_distribuidor',$distribuidor)->where('estatus',1)->get(); //consulta con distribuidor
                            }else{
                                $vales = Vale::where('estatus',1)->where('id_cuenta',$vendedor)->where('id_distribuidor',$distribuidor)->get();
                            }
                                                        
                        }else{
                            $vendedor=$request->input('vendedor');
                            if($vendedor=="0"){
                                //buscar vales con fecha termino y distribuidor
                                $vales = Vale::where('estatus',1)->where('id_distribuidor',$distribuidor)->where('fecha_inicio_pago','<=',$fechaTermino)->get();
                            }else{
                                $vales = Vale::where('estatus',1)->where('id_distribuidor',$distribuidor)->where('fecha_inicio_pago','<=',$fechaTermino)->where('id_cuenta',$vendedor)->get();
                            }                            
                        }
                    }else{
                        $fechaTermino=$request->input('fecha_termino');
                        if($fechaTermino=="0"){
                            $vendedor=$request->input('vendedor');
                            if($vendedor=="0"){
                               //buscar vales con fecha inicio y distribuidor
                                $vales = Vale::where('estatus',1)->where('id_distribuidor',$distribuidor)->where('fecha_inicio_pago','>=',$fechaInicio)->get();
                            }else{
                                $vales = Vale::where('estatus',1)->where('id_distribuidor',$distribuidor)->where('fecha_inicio_pago','>=',$fechaInicio)->where('id_cuenta',$vendedor)->get(); //buscar vales con fecha inicio y distribuidor vendedor

                            }   
                                    
                            
                        }else{
                            if($vendedor=="0"){
                               //buscar con los tres valores
                              $vales = Vale::where('estatus',1)->where('id_distribuidor',$distribuidor)->where('fecha_inicio_pago','>=',$fechaInicio)->where('fecha_inicio_pago','<=',$fechaTermino)->get();
                       
                            }else{
                                $vales = Vale::where('estatus',1)->where('id_distribuidor',$distribuidor)->where('fecha_inicio_pago','>=',$fechaInicio)->where('fecha_inicio_pago','<=',$fechaTermino)->where('id_cuenta',$vendedor)->get(); //buscar vales con 4 valores
                                
                            }   
                              
                        }
                    }
                }
           
           
         if(sizeof($vales)>0){
      
        for ($i=0; $i <sizeof($vales); $i++) { 

             $distribuidor=Vale::find($vales[$i]->id_vale)->distribuidor->nombre;

             if($vales[$i]->id_cliente != 0)
             {
                $vales[$i]->id_cliente=Vale::find($vales[$i]->id_vale)->cliente->nombre;
             }
             
                $vales[$i]->id_distribuidor=$distribuidor;
            
             if($vales[$i]->estatus==0){
                $vales[$i]->estatus='Disponible';
             }
             if($vales[$i]->estatus==1){
                $vales[$i]->estatus='Ocupado';
             }
             if($vales[$i]->estatus==2){
                $vales[$i]->estatus='Cancelado';
             }
             if($vales[$i]->estatus==3){
                $vales[$i]->estatus='Pagado';
               
             }
            
          }
        
        $fechaHoy = $this->modificarFechas(Carbon::now());

        $view =  \View::make('reportes/reporte_9', compact('vales','fechaHoy'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $view; //$pdf->stream('reporte_9.pdf');
         }else{
            
           $view =  \View::make('reportes/nodisponible')->render();
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML($view);
            return $pdf->stream('noDisponible.pdf');
        }
    }

    public function tabla_reporte_2($id,$fecha)
    {
        $pagosAbonados = Pago::where('id_distribuidor', $id)->where('estado', 3)->get();

        $vales=Vale::where('id_distribuidor',$id)->where('deuda_actual','>',0)->where('estatus',1)->where('fecha_inicio_pago','<=',$this->calcularFechaCorte($fecha))->get();
        
        $valesClonados = array();
        for ($i=0; $i <sizeof($vales); $i++) 
        {
            $clon = clone $vales[$i];
            $valesClonados[]=$clon;
        }

        for ($i=0; $i <sizeof($vales); $i++) 
        {
            for($j=0; $j < sizeof($pagosAbonados); $j++)
                {
                    $fecha_pago_carbon = Carbon::parse($vales[$i]->fecha_inicio_pago);
                    $fecha_atraso_carbon = Carbon::parse($pagosAbonados[$j]->fecha_creacion);
                    if(($vales[$i]->pagos_realizados < ($vales[$i]->numero_pagos)-1) && ($fecha_pago_carbon <= $fecha_atraso_carbon ))
                    { 

                        $importe=$vales[$i]->cantidad; //*
                        $saldoAnterior=$vales[$i]->deuda_actual; //*
                        $pagosRealizados=$vales[$i]->pagos_realizados+1; //*
                        $numeroPagos=$vales[$i]->numero_pagos; //*
                        $abono=$this->calcularPago($importe,$numeroPagos,$pagosRealizados); //*
                        $saldoActual=$saldoAnterior-$abono; //*
                        $vales[$i]->deuda_actual=$saldoActual;

                        $vales[$i]->pagos_realizados=$vales[$i]->pagos_realizados+1;
                        $clone = clone $vales[$i];
                        $valesClonados[]=$clone; 
                    }
                }     
        }  

        
        $saldoTotal=0;
        $saldoImporte=0;
        $saldoAnteriorTotal=0;
        $saldoComision;
        for ($i=0; $i <sizeof($valesClonados); $i++) { 
            
             $importe=$valesClonados[$i]->cantidad;
             //11.-saldoImporte
             $saldoImporte+=$importe;
             $saldoAnterior=$valesClonados[$i]->deuda_actual;

             //10.-saldoAnteriorTotal
             $saldoAnteriorTotal+=$saldoAnterior;
             $pagosRealizados=$valesClonados[$i]->pagos_realizados+1;
             $numeroPagos=$valesClonados[$i]->numero_pagos;
             $abono=$this->calcularPago($importe,$numeroPagos,$pagosRealizados);

             //8.-saldoTotal
             $saldoTotal+=$abono;
             $saldoActual=$saldoAnterior-$abono;
             $nombreCliente=Vale::find($valesClonados[$i]->id_vale)->cliente->nombre;

            $valesClonados[$i]->id_cliente=$nombreCliente;
            $valesClonados[$i]->cantidad="$".$importe.".00";
            $valesClonados[$i]->numero_pagos="$".$saldoAnterior.".00";
            $valesClonados[$i]->pagos_realizados=$pagosRealizados." de ".$numeroPagos;
            $valesClonados[$i]->cantidad_limite="$".$abono.".00";
            $valesClonados[$i]->deuda_actual="$".$saldoActual.".00";
            
         }
        
          $totalVales=sizeof($valesClonados);
        //1.-Datas
        $datas = $valesClonados;
        
        //2.- FechaHoy
        $fechaHoy = $this->modificarFechas(Carbon::now());
        
        //3.-Distribuidor
        $distribuidor=$id.".-".Distribuidor::find($id)->nombre;


        //4.-fechaEntrega
        $fechaEntrega=$this->CalcularFechaEntrega($fecha);

        //5.- FechaLimite
        $fechaLimite=$this->CalcularFechaLimite($fecha);

        //6.-periodo
        $periodo=$this->calcularPeriodo($fecha);

        //7.-comision
        $comision=$this->calcularComision($saldoTotal,$id);
        $saldoDistribuidor=intval(($saldoTotal*$comision)/100); 

        //9.-saldoComision
        $saldoComision=$saldoTotal-$saldoDistribuidor;

        //12.-saldoActualTotal
        $saldoActualTotal=$saldoAnteriorTotal-$saldoTotal;
        
        $view =  \View::make('reportes/reporte_2_todos', compact('totalVales','datas', 'fechaHoy','distribuidor', 'fechaEntrega','fechaLimite','periodo','comision','saldoTotal','saldoComision','saldoAnteriorTotal','saldoImporte','saldoActualTotal'))->render();

        return ($view);
    }


    public function reporte_2_todos(Request $request){
        $fecha=$request->input('fecha');
        $head = '<!DOCTYPE html><html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/><title>Reporte 2</title><link href="css/pdf.css"  rel="stylesheet"></head><body>';
        $foot =   '</body></html>';
        $body = ' ';
        $todo = ' ';

        $distribuidores = Distribuidor::all();
        for ($i=0; $i < sizeof($distribuidores); $i++)
        {
            $id=$distribuidores[$i]->id_distribuidor; 

            $vales=Vale::where('id_distribuidor',$id)->where('deuda_actual','>',0)->where('estatus',1)->where('fecha_inicio_pago','<=',$this->calcularFechaCorte($fecha))->get();
            
            if(count($vales)!=0)
            { 
                $conVales[] = $distribuidores[$i]->id_distribuidor;   
            }
           
        }

        for ($i=0; $i <sizeof($conVales); $i++) 
        {
            $body = $this->tabla_reporte_2($conVales[$i],$fecha);
            $todo = $todo . $body;
        } 
        $result = $head.$todo.$foot;
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($result);
        return $result;//->stream('reporte_2_todos.pdf');
        
        //return ($conVales);
        //$result = $head.$body.$foot;
        //return ($todo);
    }

    public function calcularPago($cantidad,$tPagos,$nPago){
        $pagos=$cantidad/$tPagos;
        $pago=round($pagos);  
        $pagoFinal=$cantidad-($pago*($tPagos-1));  

        if($nPago==$tPagos){
            return $pagoFinal;
        }
        else{
            return $pago;
        }
    }
    public function calcularFechaCorte($fecha){
        $fechaCarbon=Carbon::parse($fecha);
        // 10 nomviembre- 24 Novimebre-> 27 Novimebre
            // 25 novimebre-09 Diciembre -> 12 Diciembre
        if($fechaCarbon->day>=10 && $fechaCarbon->day<=24){
           $fechaCarbon->day=24;
           return $fechaCarbon->toDateString();
        }
        else{
            if($fechaCarbon->day<=9){
                $fechaCarbon->day=9;
                return $fechaCarbon->toDateString();           
            }else{
                $fechaCarbon->day=9;
                $fechaCarbon->addMonth();
                return $fechaCarbon->toDateString();
            }  
        }

    }
    public function calcularPeriodo($fecha){
            // 10 nomviembre- 24 Novimebre
            // 25 novimebre-09 Diciembre
       $fechaCarbon=Carbon::parse($fecha);

       if($fechaCarbon->day>=10 && $fechaCarbon->day<=24){
            return "10-".$this->meses($fechaCarbon->month)."-".$fechaCarbon->year." al 24-".$this->meses($fechaCarbon->month)."-".$fechaCarbon->year;       
        }
        else{
            if($fechaCarbon->day<=9){
               if($fechaCarbon->month-1==0){
                    return "25-".$this->meses($fechaCarbon->month-1)."-".($fechaCarbon->year-1)." al 09-".$this->meses($fechaCarbon->month)."-".$fechaCarbon->year;
                }else{
                    return "25-".$this->meses($fechaCarbon->month-1)."-".$fechaCarbon->year." al 09-".$this->meses($fechaCarbon->month)."-".$fechaCarbon->year;
                }
                                
            }else{
                $anioActual=$fechaCarbon->year;
                $mesActual=$fechaCarbon->month;
                $fechaCarbon->addMonth();
                return "25-".$this->meses($mesActual)."-".$anioActual." al 09-".$this->meses($fechaCarbon->month)."-".$fechaCarbon->year; 
            }  
        }
    }

    public function CalcularFechaLimite($fecha){
       $fechaCarbon=Carbon::parse($fecha);
        // 10 nomviembre- 24 Novimebre-> 04 Diciembre
            // 25 novimebre-09 Diciembre -> 18 Diciembre
        if($fechaCarbon->day>=10 && $fechaCarbon->day<=24){
            $fechaCarbon->addMonth();
            return "04-".$this->meses($fechaCarbon->month)."-".$fechaCarbon->year;       
        }
        else{
            if($fechaCarbon->day<=9){
                return "18-".$this->meses($fechaCarbon->month)."-".$fechaCarbon->year;                
            }else{
                $fechaCarbon->addMonth();
                return "18-".$this->meses($fechaCarbon->month)."-".$fechaCarbon->year; 
            }  
        }
    }
    public function CalcularFechaLimiteCliente($fecha){
       $fechaCarbon=Carbon::parse($fecha);
        // 10 nomviembre- 24 Novimebre-> 30 Noviembre
            // 25 novimebre-09 Diciembre -> 15 Diciembre
        if($fechaCarbon->day>=10 && $fechaCarbon->day<=24){
            $fechaCarbon->day=1;
            $fechaCarbon->addMonth();
            $fechaCarbon->subDay();
            return $fechaCarbon->day."-".($fechaCarbon->month)."-".$fechaCarbon->year;       
        }
        else{
            if($fechaCarbon->day<=9){
                return "15-".($fechaCarbon->month)."-".$fechaCarbon->year;                
            }else{
                $fechaCarbon->addMonth();
                return "15-".($fechaCarbon->month)."-".$fechaCarbon->year; 
            }  
        }
    }
     public function CalcularFechaLimiteCorta($fecha){
       $fechaCarbon=Carbon::parse($fecha);
        // 10 nomviembre- 24 Novimebre-> 04 Diciembre
            // 25 novimebre-09 Diciembre -> 18 Diciembre
        if($fechaCarbon->day>=10 && $fechaCarbon->day<=24){
            $fechaCarbon->addMonth(); 
            return "04-".($fechaCarbon->month)."-".$fechaCarbon->year;       
        }
        else{
            if($fechaCarbon->day<=9){
                return "18-".($fechaCarbon->month)."-".$fechaCarbon->year;                
            }else{
                $fechaCarbon->addMonth(); 
                return "18-".($fechaCarbon->month)."-".$fechaCarbon->year; 
            }  
        }
    }

    public function CalcularFechaEntrega($fecha){
       $fechaCarbon=Carbon::parse($fecha);
        // 10 nomviembre- 24 Novimebre-> 27 Novimebre
            // 25 novimebre-09 Diciembre -> 12 Diciembre
        if($fechaCarbon->day>=10 && $fechaCarbon->day<=24){
            return "27-".$this->meses($fechaCarbon->month)."-".$fechaCarbon->year;       
        }
        else{
            if($fechaCarbon->day<=9){
                return "12-".$this->meses($fechaCarbon->month)."-".$fechaCarbon->year;                
            }else{
                $fechaCarbon->addMonth();
                return "12-".$this->meses($fechaCarbon->month)."-".$fechaCarbon->year; 
            }  
        }
    }


    public function meses($mes){
        if($mes==13 ){
            $mes=1;
        }
        if($mes==0){
            $mes=12;
        }
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre","nulo");
        
        return $meses[$mes-1];
    }
    
    public function calcularComision($total,$id){
        
        $comision=Comision::where('cantidad_inicial','<',$total)->get();
        $distribuidor= Distribuidor::find($id);
        if($distribuidor->estatus==1){
             return 0;
        }else{
            return $comision[count($comision)-1]->porcentaje;
           
        }
        
    }


    public function reporte_1(Request $request)
    {
        $id=$request->input('id');
        $fecha=$request->input('fecha');

        $pagosAbonados = Pago::where('id_distribuidor', $id)->where('estado', 3)->get();


        $vales=Vale::where('id_distribuidor',$id)->where('deuda_actual','>',0)->where('estatus',1)->where('fecha_inicio_pago','<=',$this->calcularFechaCorte($fecha))->get();
        $valesClonados = array();
        for ($i=0; $i <sizeof($vales); $i++) 
        {
            $clon = clone $vales[$i];
            $valesClonados[]=$clon;
        }

        for ($i=0; $i <sizeof($vales); $i++) 
        {
            for($j=0; $j < sizeof($pagosAbonados); $j++)
                {
                    $fecha_pago_carbon = Carbon::parse($vales[$i]->fecha_inicio_pago);
                    $fecha_atraso_carbon = Carbon::parse($pagosAbonados[$j]->fecha_creacion);
                    if(($vales[$i]->pagos_realizados < ($vales[$i]->numero_pagos)-1) && ($fecha_pago_carbon <= $fecha_atraso_carbon ))
                    { 

                        $importe=$vales[$i]->cantidad; //*
                        $saldoAnterior=$vales[$i]->deuda_actual; //*
                        $pagosRealizados=$vales[$i]->pagos_realizados+1; //*
                        $numeroPagos=$vales[$i]->numero_pagos; //*
                        $abono=$this->calcularPago($importe,$numeroPagos,$pagosRealizados); //*
                        $saldoActual=$saldoAnterior-$abono; //*
                        $vales[$i]->deuda_actual=$saldoActual;

                        $vales[$i]->pagos_realizados=$vales[$i]->pagos_realizados+1;
                        $clone = clone $vales[$i];
                        $valesClonados[]=$clone; 
                    }
                }     
        } 


        $saldoTotal=0;

        $saldoComision;
        if(sizeof($vales)>0){

        for ($i=0; $i <sizeof($valesClonados); $i++) { 

            
             $importe=$valesClonados[$i]->cantidad;
             $saldoAnterior=$valesClonados[$i]->deuda_actual;
             $pagosRealizados=$valesClonados[$i]->pagos_realizados+1;
             $numeroPagos=$valesClonados[$i]->numero_pagos;
             $abono=$this->calcularPago($importe,$numeroPagos,$pagosRealizados);
             $saldoTotal+=$abono;

             $saldoActual=$saldoAnterior-$abono;

            $saldoActual=$saldoAnterior-$abono;

             $nombreCliente=Vale::find($valesClonados[$i]->id_vale)->cliente->nombre;

            $valesClonados[$i]->id_vale=$valesClonados[$i]->id_cliente;
            $valesClonados[$i]->id_cliente=$nombreCliente;
            $valesClonados[$i]->cantidad="$".$importe.".00";
            $valesClonados[$i]->numero_pagos="$".$saldoAnterior.".00";
            $valesClonados[$i]->pagos_realizados=$pagosRealizados." de ".$numeroPagos;
            $valesClonados[$i]->cantidad_limite="$".$abono.".00";
            $valesClonados[$i]->deuda_actual="$".$saldoActual.".00";
            
         }
         
        $comision=$this->calcularComision($saldoTotal,$id);
        $saldoDistribuidor=intval(($saldoTotal*$comision)/100);  
        $saldoComision=$saldoTotal-$saldoDistribuidor;
        $data = $valesClonados;
        $distribuidor=Distribuidor::find($id)->nombre;
        $fechaHoy = $this->modificarFechas(Carbon::today()->toDateString());
        $fechaEntrega=$this->CalcularFechaEntrega($fecha);
        $fechaLimite=$this->CalcularFechaLimiteCliente($fecha);
        $periodo=$this->calcularPeriodo($fecha);
        $view =  \View::make('reportes/reporte_1', compact('data', 'fechaHoy','distribuidor', 'fechaEntrega','fechaLimite','periodo','comision','saldoTotal','saldoComision'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('reporte_1.pdf');
         }else{
            
           $view =  \View::make('reportes/nodisponible')->render();
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML($view);
            return $pdf->stream('noDisponible.pdf');
        }
    }
     public function reporte_1b(Request $request)
    {
        $id=$request->input('id');
        $fecha=$request->input('fecha');

        $pagosAbonados = Pago::where('id_distribuidor', $id)->where('estado', 3)->get();


        $vales=Vale::where('id_distribuidor',$id)->where('deuda_actual','>',0)->where('estatus',1)->where('fecha_inicio_pago','<=',$this->calcularFechaCorte($fecha))->get();
        $valesClonados = array();
        for ($i=0; $i <sizeof($vales); $i++) 
        {
            $clon = clone $vales[$i];
            $valesClonados[]=$clon;
        }

        for ($i=0; $i <sizeof($vales); $i++) 
        {
            for($j=0; $j < sizeof($pagosAbonados); $j++)
                {
                    $fecha_pago_carbon = Carbon::parse($vales[$i]->fecha_inicio_pago);
                    $fecha_atraso_carbon = Carbon::parse($pagosAbonados[$j]->fecha_creacion);
                    if(($vales[$i]->pagos_realizados < ($vales[$i]->numero_pagos)-1) && ($fecha_pago_carbon <= $fecha_atraso_carbon ))
                    { 

                        $importe=$vales[$i]->cantidad; //*
                        $saldoAnterior=$vales[$i]->deuda_actual; //*
                        $pagosRealizados=$vales[$i]->pagos_realizados+1; //*
                        $numeroPagos=$vales[$i]->numero_pagos; //*
                        $abono=$this->calcularPago($importe,$numeroPagos,$pagosRealizados); //*
                        $saldoActual=$saldoAnterior-$abono; //*
                        $vales[$i]->deuda_actual=$saldoActual;

                        $vales[$i]->pagos_realizados=$vales[$i]->pagos_realizados+1;
                        $clone = clone $vales[$i];
                        $valesClonados[]=$clone; 
                    }
                }     
        }

        $saldoTotal=0;

        $saldoComision;
        if(sizeof($vales)>0){



        for ($i=0; $i <sizeof($valesClonados); $i++) { 

            
             $importe=$valesClonados[$i]->cantidad;
             $saldoAnterior=$valesClonados[$i]->deuda_actual;
             $pagosRealizados=$valesClonados[$i]->pagos_realizados+1;
             $numeroPagos=$valesClonados[$i]->numero_pagos;
             $abono=$this->calcularPago($importe,$numeroPagos,$pagosRealizados);
             $saldoTotal+=$abono;

            $saldoActual=$saldoAnterior-$abono;
             $nombreCliente=Vale::find($valesClonados[$i]->id_vale)->cliente->nombre;

            $valesClonados[$i]->id_vale=$valesClonados[$i]->id_cliente;
            $valesClonados[$i]->id_cliente=$nombreCliente;
            $valesClonados[$i]->cantidad="$".$importe.".00";
            $valesClonados[$i]->numero_pagos="$".$saldoAnterior.".00";
            $valesClonados[$i]->pagos_realizados=$pagosRealizados." de ".$numeroPagos;
            $valesClonados[$i]->cantidad_limite="$".$abono.".00";
            $valesClonados[$i]->deuda_actual="$".$saldoActual.".00";
            
         }
         
        $comision=$this->calcularComision($saldoTotal,$id);
        $saldoDistribuidor=intval(($saldoTotal*$comision)/100);  
        $saldoComision=$saldoTotal-$saldoDistribuidor;
        $data = $valesClonados;
        $distribuidor=Distribuidor::find($id)->nombre;
        $fechaHoy = $this->modificarFechas(Carbon::today()->toDateString());
        $fechaEntrega=$this->CalcularFechaEntrega($fecha);
        $fechaLimite=$this->CalcularFechaLimiteCliente($fecha);
        $periodo=$this->calcularPeriodo($fecha);
        $view =  \View::make('reportes/reporte_1b', compact('data', 'fechaHoy','distribuidor', 'fechaEntrega','fechaLimite','periodo','comision','saldoTotal','saldoComision'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('reporte_1b.pdf');
         }else{
            
           $view =  \View::make('reportes/nodisponible')->render();
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML($view);
            return $pdf->stream('noDisponible.pdf');
        }
    }


    public function reporte_6(Request $request){
         $fecha=$request->input('fecha');
        if($fecha==""){
            $fecha=Carbon::today();
        }
        $resultado = array();
        $SaldoTotalConComision=0;
        $SaldoTotalSinComision=0;
        $distribuidores=Distribuidor::all();
        for($j=sizeof($distribuidores)-1; $j >=0; $j--) { 
            $vales=Vale::where('id_distribuidor',$distribuidores[$j]->id_distribuidor)->where('deuda_actual','>',0)->where('estatus',1)->where('fecha_inicio_pago','<=',$this->calcularFechaCorte($fecha))->get();
            $saldoTotal=0;
          if (count($vales)==0) {
                unset($distribuidores[$j]);

            }else{
                for ($i=0; $i <sizeof($vales); $i++) { 
                
                 $importe=$vales[$i]->cantidad;
                 $saldoAnterior=$vales[$i]->deuda_actual;
                 $pagosRealizados=$vales[$i]->pagos_realizados+1;
                 $numeroPagos=$vales[$i]->numero_pagos;
                 $abono=$this->calcularPago($importe,$numeroPagos,$pagosRealizados);
                 $saldoTotal+=$abono;
                
                }

                if($saldoTotal>0){
                    $comision=$this->calcularComision($saldoTotal,$distribuidores[$j]->id_distribuidor);
                    $saldoDistribuidor=intval(($saldoTotal*$comision)/100);  
                    $saldoComision=$saldoTotal-$saldoDistribuidor;
                    $SaldoTotalSinComision+=$saldoTotal;
                    $SaldoTotalConComision+=$saldoComision;
                    $distribuidores[$j]->id_comision =$saldoTotal;
                    $distribuidores[$j]->telefono=$comision; 
                    $distribuidores[$j]->celular =$saldoComision;
                }
            }
            
        }
         $datas=$distribuidores;
        if(sizeof($distribuidores)>0){
        $fechaHoy = Carbon::now();
        $fechaEntrega=$this->CalcularFechaEntrega($fecha);
        $fechaLimite=$this->CalcularFechaLimite($fecha);
        $periodo=$this->calcularPeriodo($fecha);

        $view =  \View::make('reportes/reporte_6', compact('datas', 'fechaHoy', 'fechaEntrega','fechaLimite','periodo','SaldoTotalSinComision','SaldoTotalConComision'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('reporte_6.pdf');
         }else{
            
           $view =  \View::make('reportes/nodisponible')->render();
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML($view);
            return $pdf->stream('noDisponible.pdf');
        }
    }

    public function reporte_8(Request $request)
    {
        $id=$request->input('id');
        $saldoTotal=0;
        $saldoTotalActual=0;
        $vales=Vale::where('id_distribuidor',$id)->where('estatus',1)->get();
        if(sizeof($vales)){
        for ($i=0; $i <sizeof($vales); $i++) 
        { 

            
             $importe=$vales[$i]->cantidad;
             $saldoAnterior=$vales[$i]->deuda_actual;
             $pagosRealizados=$vales[$i]->pagos_realizados;
             $numeroPagos=$vales[$i]->numero_pagos;
             $abono=$this->calcularPago($importe,$numeroPagos,$pagosRealizados);
             $saldoActual=$saldoAnterior-$abono;
             $nombreCliente=Vale::find($vales[$i]->id_vale)->cliente->nombre;
             $saldoTotalActual+=$saldoAnterior;
             $saldoTotal+=$importe;
            $vales[$i]->id_cliente=$nombreCliente;
            $vales[$i]->cantidad="$".$importe.".00";
            $vales[$i]->pagos_realizados=$pagosRealizados." de ".$numeroPagos;
            $vales[$i]->deuda_actual="$".$saldoAnterior.".00";
            
         }
        $datas = $vales;
        $distribuidor=$id.".-".Distribuidor::find($id)->nombre;
        $fechaHoy = Carbon::now();

        $view =  \View::make('reportes/reporte_8', compact('datas', 'fechaHoy','distribuidor','saldoTotal','saldoTotalActual'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('reporte_8.pdf');
         }else{
            
           $view =  \View::make('reportes/nodisponible')->render();
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML($view);
            return $pdf->stream('noDisponible.pdf');
        }
    }
     public function reporte_7(){

        $pagos= Pago::where('estado','<',2)->get();
        $saldoTotal=0;  
        $saldoTotalAbono=0;
        for ($i=0; $i <sizeof($pagos); $i++) 
        {
            $saldoTotal+= $pagos[$i]->cantidad;
            $saldoTotalAbono+= $pagos[$i]->abono;
            $pagos[$i]->cantidad_comision='$'.(($this->pagoComision($pagos[$i]->cantidad,$pagos[$i]->comision))-$pagos[$i]->abono).".00";
            $pagos[$i]->id_distribuidor=Distribuidor::find($pagos[$i]->id_distribuidor)->nombre;
            $pagos[$i]->cantidad='$'.$pagos[$i]->cantidad.".00";
            $pagos[$i]->abono='$'.$pagos[$i]->abono.".00";
            $pagos[$i]->fecha_creacion=$this->modificarFechas($pagos[$i]->fecha_creacion);
            $pagos[$i]->fecha_limite=$this->CalcularFechaLimiteCorta($pagos[$i]->fecha_creacion);
            $pagos[$i]->id_cuenta=Cuenta::find($pagos[$i]->id_cuenta)->nombre;
            $pagos[$i]->comision=$pagos[$i]->comision."%";
            if( $pagos[$i]->estado==0){
               $pagos[$i]->estado='Esperando pago...';
            }
             if( $pagos[$i]->estado==1){
               $pagos[$i]->estado='Pago Desfasado';
            }
            

         }
          $datas = $pagos;
          $fechaHoy = Carbon::now();
        
       $view =  \View::make('reportes/reporte_7', compact('datas','saldoTotal','saldoTotalAbono','fechaHoy'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('reporte_7.pdf');


     }

     public function pagoComision($cantidad,$comision){
        $saldoComision=intval(($cantidad*$comision)/100); 
        $saldoTotal=$cantidad-$saldoComision;
        return $saldoTotal;

    }
     public function modificarFechas($fecha){
        $fechaCarbon=Carbon::parse($fecha);
        return $fechaCarbon->day."-".$fechaCarbon->month."-".$fechaCarbon->year;
    }



     public function reporte_1b_todos(Request $request)
    {
        
        $tipo =$request->input('tipo');
        $fecha =$request->input('fecha');

        //Partes de la vista
        $head = '<!DOCTYPE html><html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/><title>Reporte 1</title><link href="css/reporte_1'.$tipo.'.css"  rel="stylesheet" ></head>';
        $foot = '</html>';
        $body = ' ';
        $todo = ' ';


        //Filtrar los administradores que tienen vales
        $distribuidores = Distribuidor::all();
        for ($i=0; $i < sizeof($distribuidores); $i++)
        {
            $id=$distribuidores[$i]->id_distribuidor; 

            $vales=Vale::where('id_distribuidor',$id)->where('deuda_actual','>',0)->where('estatus',1)->where('fecha_inicio_pago','<',$this->calcularFechaCorte($fecha))->get();
            
            if(count($vales)!=0)
            { 
                $conVales[] = $distribuidores[$i]->id_distribuidor;   
            }
           
        }

        //Crear el cuerpo de la vista
        for ($i=0; $i <sizeof($conVales); $i++) 
        {
            $body = $this->body_reporte_1b($conVales[$i],$fecha);
            $todo = $todo . $body;
        } 
        $result = $head.$todo.$foot;

        //Crear el pdf
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($result);
        return $result;//$pdf->stream('reporte_1b_todos.pdf');
    }


    public function body_reporte_1b($id,$fecha)
    {
        $vales=Vale::where('id_distribuidor',$id)->where('deuda_actual','>',0)->where('estatus',1)->where('fecha_inicio_pago','<=',$this->calcularFechaCorte($fecha))->get();

        $pagosAbonados = Pago::where('id_distribuidor', $id)->where('estado', 3)->get();

        
        $valesClonados = array();
        for ($i=0; $i <sizeof($vales); $i++) 
        {
            $clon = clone $vales[$i];
            $valesClonados[]=$clon;
        }

        for ($i=0; $i <sizeof($vales); $i++) 
        {
            for($j=0; $j < sizeof($pagosAbonados); $j++)
                {
                    $fecha_pago_carbon = Carbon::parse($vales[$i]->fecha_inicio_pago);
                    $fecha_atraso_carbon = Carbon::parse($pagosAbonados[$j]->fecha_creacion);
                    if(($vales[$i]->pagos_realizados < ($vales[$i]->numero_pagos)-1) && ($fecha_pago_carbon <= $fecha_atraso_carbon ))
                    { 

                        $importe=$vales[$i]->cantidad; //*
                        $saldoAnterior=$vales[$i]->deuda_actual; //*
                        $pagosRealizados=$vales[$i]->pagos_realizados+1; //*
                        $numeroPagos=$vales[$i]->numero_pagos; //*
                        $abono=$this->calcularPago($importe,$numeroPagos,$pagosRealizados); //*
                        $saldoActual=$saldoAnterior-$abono; //*
                        $vales[$i]->deuda_actual=$saldoActual;

                        $vales[$i]->pagos_realizados=$vales[$i]->pagos_realizados+1;
                        $clone = clone $vales[$i];
                        $valesClonados[]=$clone; 
                    }
                }     
        }

        $saldoTotal=0;
        $saldoComision;
        for ($i=0; $i <sizeof($valesClonados); $i++) { 
            
             $importe=$valesClonados[$i]->cantidad;
             $saldoAnterior=$valesClonados[$i]->deuda_actual;
             $pagosRealizados=$valesClonados[$i]->pagos_realizados+1;
             $numeroPagos=$valesClonados[$i]->numero_pagos;
             $abono=$this->calcularPago($importe,$numeroPagos,$pagosRealizados);
             $saldoTotal+=$abono;
             $saldoActual=$saldoAnterior-$abono;
             $nombreCliente=Vale::find($valesClonados[$i]->id_vale)->cliente->nombre;

            $valesClonados[$i]->id_vale=$valesClonados[$i]->id_cliente;
            $valesClonados[$i]->id_cliente=$nombreCliente;
            $valesClonados[$i]->cantidad="$".$importe.".00";
            $valesClonados[$i]->numero_pagos="$".$saldoAnterior.".00";
            $valesClonados[$i]->pagos_realizados=$pagosRealizados." de ".$numeroPagos;
            $valesClonados[$i]->cantidad_limite="$".$abono.".00";
            $valesClonados[$i]->deuda_actual="$".$saldoActual.".00";
            
         }
         
        $comision=$this->calcularComision($saldoTotal,$id);
        $saldoDistribuidor=intval(($saldoTotal*$comision)/100);  
        $saldoComision=$saldoTotal-$saldoDistribuidor;
        $data = $valesClonados;
        $distribuidor=Distribuidor::find($id)->nombre;
        $fechaHoy = $this->modificarFechas(Carbon::today()->toDateString());
        $fechaEntrega=$this->CalcularFechaEntrega($fecha);
        $fechaLimite=$this->CalcularFechaLimiteCliente($fecha);
        $periodo=$this->calcularPeriodo($fecha);
        $view =  \View::make('reportes/reporte_1b_todos', compact('data', 'fechaHoy','distribuidor', 'fechaEntrega','fechaLimite','periodo','comision','saldoTotal','saldoComision'))->render();
        
        return ($view);

    }



}
    
