<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Distribuidor;
use App\Vale;
use App\Cliente;
use App\Movimiento;
use App\Comision;
use App\Cuenta;
use App\Pago;
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
    public function modificarFechas($fecha){
        $fechaCarbon=Carbon::parse($fecha);
        return $fechaCarbon->day."-".$fechaCarbon->month."-".$fechaCarbon->year;
    }
    public function obtenerPagos(){
    	$pagos= Pago::where('estado','<',2)->get();
        for ($i=0; $i <sizeof($pagos); $i++) 
        {
            $pagos[$i]->id_distribuidor=Distribuidor::find( $pagos[$i]->id_distribuidor)->nombre;
            $pagos[$i]->cantidad='$'.$pagos[$i]->cantidad.".00";
            $pagos[$i]->abono='$'.$pagos[$i]->abono.".00";
            $pagos[$i]->fecha_creacion=$this->modificarFechas($pagos[$i]->fecha_creacion);
            $pagos[$i]->fecha_limite=$this->CalcularFechaLimiteCorta($pagos[$i]->fecha_creacion);
            $pagos[$i]->id_cuenta=Cuenta::find($pagos[$i]->id_cuenta)->nombre;
            $pagos[$i]->comision=$pagos[$i]->comision."%";
            if( $pagos[$i]->estado==0){
               $pagos[$i]->estado='<p style="background-color: green;">Esperando pago.</p>';
            }
             if( $pagos[$i]->estado==1){
               $pagos[$i]->estado='<p style="background-color: Red;">Pago Desfasado</p>';
            }
            $pagos[$i]->acciones ='<a data-toggle="modal" type="button"  class="btn btn-primary margin" value="'.$pagos[$i]->id_pago.'" data-target="#abono" onclick="obtenerId('.$pagos[$i]->id_pago.')" href="#">Abonar</a> <a  data-toggle="modal" type="button" class="btn btn-success margin"  name="'.$pagos[$i]->id_pago.'" data-target="#pago" href="#">Pagar</a>';

         }
        
        return $pagos;
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
            
	            	$pagoAux= Pago::where('id_distribuidor',$distribuidores[$j]->id_distribuidor)->where('fecha_creacion',$this->calcularFechaCorte($fecha))->get();
	            	 
                     if (count($pagoAux)==0) {
		                $pago = new Pago;
						$pago->id_distribuidor=$distribuidores[$j]->id_distribuidor;
						$pago->cantidad=$saldoTotal;
						$pago->fecha_creacion=$this->calcularFechaCorte($fecha);
						$pago->estado=0;// 0:pendiente  1:desfasado 2:pagado 3:Cancelado por nuevo pago
                        $pago->comision=$comision;
						$pago->id_cuenta=Session::get('id');
						$pago->save();
		            }else{
                        if($pagoAux[0]->estatus==1){
                            $pago=new Pago;
                            $pago->id_distribuidor=$distribuidores[$j]->id_distribuidor;
                            $pago->cantidad=$saldoTotal;
                            $pago->fecha_creacion=$this->calcularFechaCorte($fecha);
                            $pago->estado=0;// 0:pendiente  1:desfasado 2:pagado 3:Cancelado por nuevo pago
                            $pago->comision=0;
                            $pago->abono=$pagoAux[0]->abono;
                            $pago->id_cuenta=Session::get('id');
                            $pago->save();
                            $pagoAux[0]->estatus=3;
                            $pagoAux->save();
                        }
                    }         

	            }
	            
	        }
        }
        else{
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
            	
            	$pagoAux= Pago::where('$id_distribuidor',$id)->where('fecha_creacion',$this->calcularFechaCorte($fecha));
                 $comision=$this->calcularComision($saldoTotal);
            	 if (count($pagoAux)==0) {
	                $pago=new Pago;
					$pago->id_distribuidor=$id;
					$pago->cantidad=$saldoTotal;
					$pago->fecha_creacion=$this->calcularFechaCorte($fecha);
					$pago->estado=0; // 0:pendiente  1:desfasado 2:pagado
                    $pago->comision=$comision;
					$pago->id_cuenta=Session::get('id');
					$pago->save();
	            }
                else{
                        if($pagoAux[0]->estatus==1){
                            $pago=new Pago;
                            $pago->id_distribuidor=$distribuidores[$j]->id_distribuidor;
                            $pago->cantidad=$saldoTotal;
                            $pago->fecha_creacion=$this->calcularFechaCorte($fecha);
                            $pago->estado=0;// 0:pendiente  1:desfasado 2:pagado
                            $pago->comision=0;
                            $pago->abono=$pagoAux[0]->abono;
                            $pago->id_cuenta=Session::get('id');
                            $pago->save();
                        }
                    }              
        	
        }
        return 'consultarPagos';
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

    public function calcularComisionActual($fecha,$cantidad){
        $fechaCarbon=Carbon::parse($fecha);
        // 10 nomviembre- 24 Novimebre-> 04 Diciembre
            // 25 novimebre-09 Diciembre -> 18 Diciembre
        
        if($fechaCarbon->day==5 || $fechaCarbon->day==19){
            $comision=$comision-2;
        }
        if($fechaCarbon->day==6 || $fechaCarbon->day==20){
            $comision=$comision-2;
        }
        if(($fechaCarbon->day>7 && $fechaCarbon->day<19) || ($fechaCarbon->day>21 && $fechaCarbon->day<5)){
            $comision=0;
        }
        return $comision;
    }

    public function calcularComision($total){
        
        $comision=Comision::where('cantidad_inicial','<',$total)->get();
        return $comision[0]->porcentaje;
    }
    
}
