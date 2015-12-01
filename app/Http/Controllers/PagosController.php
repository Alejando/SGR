<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Distribuidor;
use App\Vale;
use App\Cliente;
use App\Movimiento;
use App\Vales_has_promociones;
use Carbon\Carbon;
use Session;

class PagosController extends Controller
{
    public function generarPagos()
    {
        switch (Session::get('tipo')) {
            case 0:   
                return view('s_admin.generarPagos');
            break;
            case 1:
               return view('admin.generarPagos');
            break; 
        } 
    }

    public function consultarPagos(){
    	switch (Session::get('tipo')) {
            case 0:   
                return view('s_admin.consultarPagos');
            break;
            case 1:
               return view('admin.consultarPagos');
            break; 
        } 
    }
    public function obtenerPagos(){
    	
    }

    public function crearPagos(Request $request)
    {   
        $id=$request->input('id');
        $fecha=$request->input('fecha');
        if($fecha==""){
            $fecha=Carbon::today();
        }

        if($id==0){
	                
	            $distribuidores=Distribuidor::all();
	        for($j=0; $j < sizeof($distribuidores); $j++) { 
	            $vales=Vale::where('id_distribuidor',$distribuidores[$j]->id_distribuidor)->where('deuda_actual','>',0)->where('estatus',1)->where('fecha_inicio_pago','<',$this->calcularFechaCorte($fecha))->get();
	            $saldoTotal=0;
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
	            	$pagoAux= Pago::where('$id_distribuidor',$distribuidores[$j]->id_distribuidor)->where('fecha_creacion',$this->calcularFechaCorte($fecha));
	            	 if (count($pagoAux)==0) {
		                $pago=new Pago;
						$pago->id_distribuidor=$distribuidores[$j]->id_distribuidor;
						$pago->cantidad=$saldoTotal;
						$pago->fecha_creacion=$this->calcularFechaCorte($fecha);
						$pago->estado=0;// 0:pendiente  1:desfasado 2:pagado
						$pago->id_cuenta=Session::get('id');
						$pago->save();
		            }             

	            }
	            
	        }
        }else{
        	$vales=Vale::where('id_distribuidor',$id)->where('deuda_actual','>',0)->where('estatus',1)->where('fecha_inicio_pago','<',$this->calcularFechaCorte($fecha))->get();
	            $saldoTotal=0;
	            for ($i=0; $i <sizeof($vales); $i++) { 
	                
	                 $importe=$vales[$i]->cantidad;
	                 $saldoAnterior=$vales[$i]->deuda_actual;
	                 $pagosRealizados=$vales[$i]->pagos_realizados+1;
	                 $numeroPagos=$vales[$i]->numero_pagos;
	                 $abono=$this->calcularPago($importe,$numeroPagos,$pagosRealizados);
	                 $saldoTotal+=$abono;
	                
	            }
	            
                $comision=$this->calcularComision($saldoTotal);
                $saldoDistribuidor=intval(($saldoTotal*$comision)/100);  
                $saldoComision=$saldoTotal-$saldoDistribuidor;
            	
            	$pagoAux= Pago::where('$id_distribuidor',$id)->where('fecha_creacion',$this->calcularFechaCorte($fecha));
            	 if (count($pagoAux)==0) {
	                $pago=new Pago;
					$pago->id_distribuidor=$id;
					$pago->cantidad=$saldoTotal;
					$pago->fecha_creacion=$this->calcularFechaCorte($fecha);
					$pago->estado=0; // 0:pendiente  1:desfasado 2:pagado
					$pago->id_cuenta=Session::get('id');
					$pago->save();
	            }              
        	
        }
        return redirect('consultarPagos');
    }
    
    public function calcularFechaCorte($fecha){
        $fechaCarbon=Carbon::parse($fecha);
        // 10 nomviembre- 24 Novimebre -> 27 Novimebre
        // 25 novimebre-09 Diciembre -> 12 Diciembre
        if($fechaCarbon->day==9){
        	$fechaCarbon->day==10;
        }
        if($fechaCarbon->day==24){
        	$fechaCarbon->day==25;
        }
        if($fechaCarbon->day>=10 && $fechaCarbon->day<=24){
           $fechaCarbon->day=9;
           return $fechaCarbon->toDateString();
        }
        else{
            if($fechaCarbon->day<=9){
                $fechaCarbon->day=24;
                $fechaCarbon->month--;
                return $fechaCarbon->toDateString();           
            }else{
                $fechaCarbon->day=24;
                return $fechaCarbon->toDateString();
            }  
        }

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

    public function calcularComision($total){
        
        $comision=Comision::where('cantidad_inicial','<',$total)->get();
        return $comision[0]->porcentaje;
    }
    
}
