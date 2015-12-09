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


class PdfController extends Controller
{


    public function reporte_2(Request $request){
        $id=$request->input('id');
        $fecha=$request->input('fecha');
        if($fecha==""){
            $fecha=Carbon::today();
        }
        $vales=Vale::where('id_distribuidor',$id)->where('deuda_actual','>',0)->where('estatus',1)->where('fecha_inicio_pago','<',$this->calcularFechaCorte($fecha))->get();
        $saldoTotal=0;
        $saldoImporte=0;
        $saldoAnteriorTotal=0;
        $saldoComision;
        for ($i=0; $i <sizeof($vales); $i++) { 
            
             $importe=$vales[$i]->cantidad;
             $saldoImporte+=$importe;
             $saldoAnterior=$vales[$i]->deuda_actual;
             $saldoAnteriorTotal+=$saldoAnterior;
             $pagosRealizados=$vales[$i]->pagos_realizados+1;
             $numeroPagos=$vales[$i]->numero_pagos;
             $abono=$this->calcularPago($importe,$numeroPagos,$pagosRealizados);
             $saldoTotal+=$abono;
             $saldoActual=$saldoAnterior-($abono*$pagosRealizados);
             $nombreCliente=Vale::find($vales[$i]->id_vale)->cliente->nombre;

            $vales[$i]->id_cliente=$nombreCliente;
            $vales[$i]->cantidad="$".$importe.".00";
            $vales[$i]->numero_pagos="$".$saldoAnterior.".00";
            $vales[$i]->pagos_realizados=$pagosRealizados." de ".$numeroPagos;
            $vales[$i]->cantidad_limite="$".$abono.".00";
            $vales[$i]->deuda_actual="$".$saldoActual.".00";
            
         }
        $comision=$this->calcularComision($saldoTotal);
        $saldoDistribuidor=intval(($saldoTotal*$comision)/100);  
        $saldoComision=$saldoTotal-$saldoDistribuidor;
        $datas = $vales;
        $distribuidor=$id.".-".Distribuidor::find($id)->nombre;
        $fechaHoy = $this->modificarFechas(Carbon::now());
        $fechaEntrega=$this->CalcularFechaEntrega($fecha);
        $fechaLimite=$this->CalcularFechaLimite($fecha);
        $periodo=$this->calcularPeriodo($fecha);
        $saldoActualTotal=$saldoAnteriorTotal-$saldoTotal;
        $view =  \View::make('reportes/reporte_2', compact('datas', 'fechaHoy','distribuidor', 'fechaEntrega','fechaLimite','periodo','comision','saldoTotal','saldoComision','saldoAnteriorTotal','saldoImporte','saldoActualTotal'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('reporte_2.pdf');

    }

    public function calcularPago($cantidad,$tPagos,$nPago){
        $pagos=$cantidad/$tPagos;
        $pago=intval($pagos);  
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
                $fechaCarbon->month++;
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
                return "25-".$this->meses($fechaCarbon->month-1)."-".$fechaCarbon->year." al 09-".$this->meses($fechaCarbon->month)."-".$fechaCarbon->year;                
            }else{
                return "25-".$this->meses($fechaCarbon->month)."-".$fechaCarbon->year." al 09-".$this->meses($fechaCarbon->month+1)."-".$fechaCarbon->year; 
            }  
        }
    }

    public function CalcularFechaLimite($fecha){
       $fechaCarbon=Carbon::parse($fecha);
        // 10 nomviembre- 24 Novimebre-> 04 Diciembre
            // 25 novimebre-09 Diciembre -> 18 Diciembre
        if($fechaCarbon->day>=10 && $fechaCarbon->day<=24){
            return "04-".$this->meses($fechaCarbon->month+1)."-".$fechaCarbon->year;       
        }
        else{
            if($fechaCarbon->day<=9){
                return "18-".$this->meses($fechaCarbon->month)."-".$fechaCarbon->year;                
            }else{
                return "18-".$this->meses($fechaCarbon->month+1)."-".$fechaCarbon->year; 
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
                return "15-".($fechaCarbon->month+1)."-".$fechaCarbon->year; 
            }  
        }
    }
     public function CalcularFechaLimiteCorta($fecha){
       $fechaCarbon=Carbon::parse($fecha);
        // 10 nomviembre- 24 Novimebre-> 04 Diciembre
            // 25 novimebre-09 Diciembre -> 18 Diciembre
        if($fechaCarbon->day>=10 && $fechaCarbon->day<=24){
            return "04-".($fechaCarbon->month+1)."-".$fechaCarbon->year;       
        }
        else{
            if($fechaCarbon->day<=9){
                return "18-".($fechaCarbon->month)."-".$fechaCarbon->year;                
            }else{
                return "18-".($fechaCarbon->month+1)."-".$fechaCarbon->year; 
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
                return "12-".$this->meses($fechaCarbon->month+1)."-".$fechaCarbon->year; 
            }  
        }
    }


    public function meses($mes){
        if($mes==13){
            $mes=1;
        }
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre","nulo");
        
        return $meses[$mes-1];
    }
    
    public function calcularComision($total){
        
        $comision=Comision::where('cantidad_inicial','<',$total)->get();
        return $comision[count($comision)-1]->porcentaje;
    }


    public function reporte_1(Request $request)
    {
        $id=$request->input('id');
        $fecha=$request->input('fecha');
        $vales=Vale::where('id_distribuidor',$id)->where('deuda_actual','>',0)->where('estatus',1)->where('fecha_inicio_pago','<',$this->calcularFechaCorte($fecha))->get();
        $saldoTotal=0;
        $saldoComision;
        for ($i=0; $i <sizeof($vales); $i++) { 
            
             $importe=$vales[$i]->cantidad;
             $saldoAnterior=$vales[$i]->deuda_actual;
             $pagosRealizados=$vales[$i]->pagos_realizados+1;
             $numeroPagos=$vales[$i]->numero_pagos;
             $abono=$this->calcularPago($importe,$numeroPagos,$pagosRealizados);
             $saldoTotal+=$abono;
            $saldoActual=$saldoAnterior-($abono*$pagosRealizados);
             $nombreCliente=Vale::find($vales[$i]->id_vale)->cliente->nombre;

            $vales[$i]->id_vale=$vales[$i]->id_cliente;
            $vales[$i]->id_cliente=$nombreCliente;
            $vales[$i]->cantidad="$".$importe.".00";
            $vales[$i]->numero_pagos="$".$saldoAnterior.".00";
            $vales[$i]->pagos_realizados=$pagosRealizados." de ".$numeroPagos;
            $vales[$i]->cantidad_limite="$".$abono.".00";
            $vales[$i]->deuda_actual="$".$saldoActual.".00";
            
         }
         
        $comision=$this->calcularComision($saldoTotal);
        $saldoDistribuidor=intval(($saldoTotal*$comision)/100);  
        $saldoComision=$saldoTotal-$saldoDistribuidor;
        $data = $vales;
        $distribuidor=Distribuidor::find($id)->nombre;
        $fechaHoy = $this->modificarFechas(Carbon::today()->toDateString());
        $fechaEntrega=$this->CalcularFechaEntrega($fecha);
        $fechaLimite=$this->CalcularFechaLimiteCliente($fecha);
        $periodo=$this->calcularPeriodo($fecha);
        $view =  \View::make('reportes/reporte_1', compact('data', 'fechaHoy','distribuidor', 'fechaEntrega','fechaLimite','periodo','comision','saldoTotal','saldoComision'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('reporte_1.pdf');

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
            $vales=Vale::where('id_distribuidor',$distribuidores[$j]->id_distribuidor)->where('deuda_actual','>',0)->where('estatus',1)->where('fecha_inicio_pago','<',$this->calcularFechaCorte($fecha))->get();
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
                    $comision=$this->calcularComision($saldoTotal);
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
        $fechaHoy = Carbon::now();
        $fechaEntrega=$this->CalcularFechaEntrega($fecha);
        $fechaLimite=$this->CalcularFechaLimite($fecha);
        $periodo=$this->calcularPeriodo($fecha);

        $view =  \View::make('reportes/reporte_6', compact('datas', 'fechaHoy', 'fechaEntrega','fechaLimite','periodo','SaldoTotalSinComision','SaldoTotalConComision'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('reporte_6.pdf');
    }

    public function reporte_8(Request $request)
    {
        $id=$request->input('id');
        $saldoTotal=0;
        $saldoTotalActual=0;
        $vales=Vale::where('id_distribuidor',$id)->where('estatus',1)->get();

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
    }
     public function reporte_7(){

        $pagos= Pago::where('estado','<',2)->get();
        $saldoTotal=0;  
        $saldoTotalAbono=0;
        for ($i=0; $i <sizeof($pagos); $i++) 
        {
            $saldoTotal+= $pagos[$i]->cantidad;
            $saldoTotalAbono+= $pagos[$i]->abono;
            $pagos[$i]->cantidad_comision='$'.$this->pagoComision($pagos[$i]->cantidad,$pagos[$i]->comision).".00";
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
}
    
