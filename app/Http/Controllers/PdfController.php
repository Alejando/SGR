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
class PdfController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function invoice() 
    {
        $data = $this->getData();
        $date = date('Y-m-d');
        $invoice = "2222";
        $view =  \View::make('invoice', compact('data', 'date', 'invoice'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('invoice');
    }


    public function getData() 
    {
        $data =  [
            'quantity'      => '1' ,
            'description'   => 'some ramdom text',
            'price'   => '500',
            'total'     => '500'
        ];
        return $data;
    }

    public function reporteR2($id,$fechaInicio,$fechaFin){

    public function reporteCobranzaPDF(Request $request){
       $id=$request->input('id');
        $fecha=$request->input('fecha');
        $vales=Vale::where('id_distribuidor',$id)->where('deuda_actual','>',0)->where('estatus',1)->where('fecha_inicio_pago','<',$fecha)->get();

        for ($i=0; $i <sizeof($vales); $i++) { 
            
             $importe=$vales[$i]->cantidad;
             $saldoAnterior=$vales[$i]->deuda_actual;
             $pagosRealizados=$vales[$i]->pagos_realizados+1;
             $numeroPagos=$vales[$i]->numero_pagos;
             $abono=$this->calcularPago($importe,$numeroPagos,$pagosRealizados);
             $saldoActual=$saldoAnterior-$abono;
             $nombreCliente=Vale::find($vales[$i]->id_vale)->cliente->nombre;

            $vales[$i]->id_cliente=$nombreCliente;
            $vales[$i]->cantidad="$".$importe.".00";
            $vales[$i]->numero_pagos="$".$saldoAnterior.".00";
            $vales[$i]->pagos_realizados=$pagosRealizados." de ".$numeroPagos;
            $vales[$i]->cantidad_limite="$".$abono.".00";
            $vales[$i]->deuda_actual="$".$saldoActual.".00";
            
         }

        $datas = $vales;
        $distribuidor=$id.".-".Distribuidor::find($id)->nombre;
        $fechaHoy = Carbon::today();
        $fechaEntrega=$this->CalcularFechaEntrega($fecha);
        $fechaLimite=$this->CalcularFechaLimite($fecha);
        $periodo=$this->calcularPeriodo($fecha);

        $view =  \View::make('reporte_2', compact('datas', 'fechaHoy','distribuidor', 'fechaEntrega','fechaLimite','periodo'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('reporte_2');

    }
>>>>>>> origin/master

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



    public function reporte_1()
    {
        $data = $this->getData();
        $date = date('Y-m-d');
        $invoice = "2222";
        $view =  \View::make('reportes/reporte_1', compact('data', 'date', 'invoice'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('reporte_1');
    }

}
