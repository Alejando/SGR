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
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{

     public function reporte_2_excel(Request $request){
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
             $saldoActual=$saldoAnterior-$abono;
             $nombreCliente=Vale::find($vales[$i]->id_vale)->cliente->nombre;

            $vales[$i]->id_cliente=$nombreCliente;
            $vales[$i]->cantidad=$importe.".00";
            $vales[$i]->numero_pagos=$saldoAnterior.".00";
            $vales[$i]->pagos_realizados=$pagosRealizados." de ".$numeroPagos;
            $vales[$i]->cantidad_limite=$abono.".00";
            $vales[$i]->deuda_actual=$saldoActual.".00";
            
         }
        $comision=$this->calcularComision($saldoTotal);
        $saldoDistribuidor=intval(($saldoTotal*$comision)/100);  
        $saldoComision=$saldoTotal-$saldoDistribuidor;
        $datas = $vales;
        $distribuidor=$id.".-".Distribuidor::find($id)->nombre;
        $fechaHoy = Carbon::now();
        $fechaEntrega=$this->CalcularFechaEntrega($fecha);
        $fechaLimite=$this->CalcularFechaLimite($fecha);
        $periodo=$this->calcularPeriodo($fecha);
        $saldoActualTotal=$saldoAnteriorTotal-$saldoTotal;

        Excel::create('Reporte_Cobranza', function($excel) use ($datas, $fechaHoy, $distribuidor, $fechaEntrega, $fechaLimite, $periodo, $comision, $saldoTotal, $saldoComision, $saldoAnteriorTotal, $saldoImporte, $saldoActualTotal ) {
            $excel->sheet('Reporte_Cobranza', function($sheet) use ($datas, $fechaHoy, $distribuidor, $fechaEntrega, $fechaLimite, $periodo, $comision, $saldoTotal, $saldoComision, $saldoAnteriorTotal, $saldoImporte, $saldoActualTotal ) {
                $sheet->loadView('reportes.reporte_2_excel')->with("datas", $datas)->with("fechaHoy", $fechaHoy)->with("distribuidor", $distribuidor)->with("fechaEntrega", $fechaEntrega)->with("fechaLimite", $fechaLimite)->with("periodo", $periodo)->with("comision", $comision)->with("saldoTotal", $saldoTotal)->with("saldoComision", $saldoComision)->with("saldoAnteriorTotal", $saldoAnteriorTotal)->with("saldoImporte", $saldoImporte)->with("saldoActualTotal", $saldoActualTotal);
            });
        })->export('xls');
    }

    public function reporte_6_excel(Request $request){
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

        Excel::create('Reporte_Pago', function($excel) use ($datas, $fechaHoy, $fechaEntrega, $fechaLimite, $periodo, $SaldoTotalSinComision, $SaldoTotalConComision) {
            $excel->sheet('Reporte_Pago', function($sheet) use ($datas, $fechaHoy, $fechaEntrega, $fechaLimite, $periodo, $SaldoTotalSinComision, $SaldoTotalConComision) {
                $sheet->loadView('reportes.reporte_6_excel')->with("datas", $datas)->with("fechaHoy", $fechaHoy)->with("fechaEntrega", $fechaEntrega)->with("fechaLimite", $fechaLimite)->with("periodo", $periodo)->with("SaldoTotalSinComision", $SaldoTotalSinComision)->with("SaldoTotalConComision", $SaldoTotalConComision);
            });
        })->export('xls');

    }

    public function reporte_8_excel(Request $request)
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
            $vales[$i]->cantidad=$importe.".00";
            $vales[$i]->pagos_realizados=$pagosRealizados." de ".$numeroPagos;
            $vales[$i]->deuda_actual=$saldoAnterior.".00";
            
         }
        $datas = $vales;
        $distribuidor=$id.".-".Distribuidor::find($id)->nombre;
        $fechaHoy = Carbon::now();

        Excel::create('Reporte_Historico', function($excel) use ($datas, $fechaHoy, $distribuidor, $saldoTotal, $saldoTotalActual) {
            $excel->sheet('Reporte_Historico', function($sheet) use ($datas, $fechaHoy, $distribuidor, $saldoTotal, $saldoTotalActual) {
                $sheet->loadView('reportes.reporte_8_excel')->with("datas", $datas)->with("fechaHoy", $fechaHoy)->with("distribuidor", $distribuidor)->with("saldoTotal", $saldoTotal)->with("saldoTotalActual", $saldoTotalActual);
            });
        })->export('xls');
    }

    public function reporte_7_excel(){

        $pagos= Pago::where('estado','<',2)->get();
        $saldoTotal=0;  
        $saldoTotalAbono=0;
        for ($i=0; $i <sizeof($pagos); $i++) 
        {
            $saldoTotal+= $pagos[$i]->cantidad;
            $saldoTotalAbono+= $pagos[$i]->abono;
            $pagos[$i]->cantidad_comision=$this->pagoComision($pagos[$i]->cantidad,$pagos[$i]->comision).".00";
            $pagos[$i]->id_distribuidor=Distribuidor::find($pagos[$i]->id_distribuidor)->nombre;
            $pagos[$i]->cantidad=$pagos[$i]->cantidad.".00";
            $pagos[$i]->abono=$pagos[$i]->abono.".00";
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

        Excel::create('Reporte_Deudores', function($excel) use ($datas, $fechaHoy, $saldoTotal, $saldoTotalAbono) {
            $excel->sheet('Reporte_Deudores', function($sheet) use ($datas, $fechaHoy, $saldoTotal, $saldoTotalAbono) {
                $sheet->loadView('reportes.reporte_7_excel')->with("datas", $datas)->with("fechaHoy", $fechaHoy)->with("saldoTotal", $saldoTotal)->with("saldoTotalAbono", $saldoTotalAbono);
            });
        })->export('xls');


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
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        
        return $meses[$mes-1];
    }
    public function calcularComision($total){
        
        $comision=Comision::where('cantidad_inicial','<',$total)->get();
        return $comision[count($comision)-1]->porcentaje;
    }

}