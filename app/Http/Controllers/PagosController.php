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
        $fechaHoy="'".Carbon::today()->toDateString()."'";
        $this->actualizarPagos();
    	$pagos= Pago::where('estado','<',2)->get();
        for ($i=0; $i <sizeof($pagos); $i++) 
        {
            $pagos[$i]->id_distribuidor=Distribuidor::find( $pagos[$i]->id_distribuidor)->nombre;
             $cantidad = (($this->pagoComision($pagos[$i]->cantidad,$pagos[$i]->comision))-($pagos[$i]->abono));
            $pagos[$i]->cantidad_comision='$'.$cantidad.".00";
            $nombre = "'".$pagos[$i]->id_distribuidor."'";
            $can_letra = "'".$this->num_to_letras($cantidad)."'";
            $periodo = "'".$this->calcularPeriodo($pagos[$i]->fecha_creacion)."'";
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
            $pagos[$i]->acciones ='<a data-toggle="modal" type="button"  class="btn btn-primary margin"  data-target="#abono" onclick="obtenerId('. $pagos[$i]->id_pago.','.$nombre.','.$cantidad.','.$can_letra.','.$periodo.','.$fechaHoy.')" href="#">Abonar</a> <a  data-toggle="modal" type="button" class="btn btn-success margin"  onclick="obtenerId('. $pagos[$i]->id_pago.','.$nombre.','.$cantidad.','.$can_letra.','.$periodo.','.$fechaHoy.')" data-target="#pago" href="#">Pagar</a>';//' <a type="button" class="btn btn-warning " onclick="imprimirComprobante('.$nombre.','.$cantidad.','.$can_letra.','.$periodo.','.$fechaHoy.')">Imprimir</a>';

         }
        
        return $pagos;
    }

    public function calcularPeriodo($fecha){
            // 10 nomviembre- 24 Novimebre
            // 25 novimebre-09 Diciembre
       $fechaCarbon=Carbon::parse($fecha);

       if($fechaCarbon->day>=10 && $fechaCarbon->day<=24){
            return "10-".$fechaCarbon->month."-".$fechaCarbon->year." al 24-".$fechaCarbon->month."-".$fechaCarbon->year;       
        }
        else{
            if($fechaCarbon->day<=9){
                $anioActual=$fechaCarbon->year;
                $mesActual=$fechaCarbon->month;
                $fechaCarbon->subMonth();
                return "25-".$fechaCarbon->month."-".$fechaCarbon->year." al 09-".$mesActual."-".$anioActual; 
                           
            }else{
                $anioActual=$fechaCarbon->year;
                $mesActual=$fechaCarbon->month;
                $fechaCarbon->addMonth();
                return "25-".$mesActual."-".$anioActual." al 09-".$fechaCarbon->month."-".$fechaCarbon->year; 
            }  
        }
    }

    public function pagoComision($cantidad,$comision){
        $saldoComision=intval(($cantidad*$comision)/100); 
        $saldoTotal=$cantidad-$saldoComision;
        return $saldoTotal;

    }
    public function abonarPago(Request $request){
        $id=$request->input('id');
        $abono=$request->input('abono');
        $pago=Pago::find($id);
        $pago->abono+=$abono;
        if($pago->abono>=$this->pagoComision($pago->cantidad,$pago->comision)){
            $pago->estado=2;
            $pago->abono=0;
        }
       
        if($pago->save()){
            Session::flash('message','Abono por $'.$abono.'.00  guardado correctamente.');
            Session::flash('class','success');
        }
        else{
            Session::flash('message','Error al registrar Abono');
            Session::flash('class','danger');
        }
        return $this->num_to_letras($abono);
       
    }
    public function liquidarPago(Request $request){
        $id=$request->input('id');
        $pago=Pago::find($id);
        if($pago->estado==2){
             Session::flash('message','Error al liquidar pago');
            Session::flash('class','danger');
        }
        else{
        $pago->estado=2;    // estados de los pagos
        $pago->abono=0;    // 0=esperando pago, 1=pago desfasado  2=liquidado 3= abonado a otro pago
        $id_distribuidor=$pago->id_distribuidor;
        if($pago->save() ){
            $distribuidor=Distribuidor::find($id_distribuidor);
            $distribuidor->estatus=0;
            $distribuidor->saldo_actual-=$pago->cantidad;
            if($distribuidor->save()){
                 $this->aumentarPagos($id_distribuidor,$pago->fecha_creacion);
            Session::flash('message','Pago registrado correctamente');
            Session::flash('class','success');
            }else{
                 Session::flash('message','Error al actualizar saldo del distribuidor');
            Session::flash('class','danger');
            }
           
        }
        else{
            Session::flash('message','Error al liquidar pago');
            Session::flash('class','danger');
        }
        }
       
      // return "pago realizado";
    }
    public function aumentarPagos($id,$fecha){

        $vales=Vale::where('id_distribuidor',$id)->where('estatus',1)->where('fecha_inicio_pago','<=',$fecha)->get();
        $pagos=pago::where('id_distribuidor',$id)->where('estado',3)->get();
        $nPagos=count($pagos);
         for ($i=0; $i <sizeof($vales); $i++) 
        {
            if($nPagos==0){
                $vales[$i]->pagos_realizados=$vales[$i]->pagos_realizados+1;
                $importe=$vales[$i]->cantidad;
                $saldoAnterior=$vales[$i]->deuda_actual;
                $pagosRealizados=$vales[$i]->pagos_realizados;
                $numeroPagos=$vales[$i]->numero_pagos;
                $abono=$this->calcularPago($importe,$numeroPagos,$pagosRealizados);
                $vales[$i]->deuda_actual=$saldoAnterior-$abono;
                if($numeroPagos==$pagosRealizados){
                    $vales[$i]->estatus=3;
                }
                $vales[$i]->save();
            }
            else{
                $vales[$i]->pagos_realizados=$vales[$i]->pagos_realizados+1;
                $importe=$vales[$i]->cantidad;
                $saldoAnterior=$vales[$i]->deuda_actual;
                $pagosRealizados=$vales[$i]->pagos_realizados;
                $numeroPagos=$vales[$i]->numero_pagos;
                $abono=$this->calcularPago($importe,$numeroPagos,$pagosRealizados);
                $vales[$i]->deuda_actual=$saldoAnterior-$abono;
                if($numeroPagos==$pagosRealizados){
                    $vales[$i]->estatus=3;
                }
                $vales[$i]->save();
                $this->aumentarVariosPagos($vales[$i],$pagos);
            }
           
        }
    }
    


    public function aumentarVariosPagos($vales,$pagos){
        $fechaPago=Carbon::parse($vales->fecha_inicio_pago);
        for ($i=0; $i <sizeof($pagos) ; $i++) { 
            $fechaAtraso= Carbon::parse($pagos[$i]->fecha_creacion);
            if($fechaPago<=$fechaAtraso && $vales->estatus==1){
                $vales->pagos_realizados=$vales->pagos_realizados+1;
                $importe=$vales->cantidad;
                $saldoAnterior=$vales->deuda_actual;
                $pagosRealizados=$vales->pagos_realizados;
                $numeroPagos=$vales->numero_pagos;
                $abono=$this->calcularPago($importe,$numeroPagos,$pagosRealizados);
                $vales->deuda_actual=$saldoAnterior-$abono;
                if($numeroPagos==$pagosRealizados){
                    $vales->estatus=3;
                }
                $vales->save();

            }
            $pagos[$i]->estado=2;
            $pagos[$i]->save();
        }
       
    }

    public function calcularPago($cantidad,$tPagos,$nPago){
        $pagos=$cantidad/$tPagos;
        $pago=round($pagos);  
        $pagoFinal=$cantidad-($pago*($tPagos-1));  

        if($nPago>=$tPagos){
            return $pagoFinal;
        }
        else{
            return $pago;
        }
    }

    public function consultarPagosRealizados(){
         
        $pagos= Pago::where('estado',2)->get();
        for ($i=0; $i <sizeof($pagos); $i++) 
        {
             $fechaHoy="'".Carbon::parse($pagos[$i]->updated_at)->toDateString()."'";
            $pagos[$i]->id_distribuidor=Distribuidor::find( $pagos[$i]->id_distribuidor)->nombre;
            $cantidad = (($this->pagoComision($pagos[$i]->cantidad,$pagos[$i]->comision))-($pagos[$i]->abono));
            $pagos[$i]->cantidad_comision='$'.$cantidad.".00";
            $nombre = "'".$pagos[$i]->id_distribuidor."'";
            $can_letra = "'".$this->num_to_letras($cantidad)."'";
            $periodo = "'".$this->calcularPeriodo($pagos[$i]->fecha_creacion)."'";
            $pagos[$i]->cantidad='$'.$pagos[$i]->cantidad.".00";
            $pagos[$i]->abono='$'.$pagos[$i]->abono.".00";
            $pagos[$i]->fecha_creacion=$this->modificarFechas($pagos[$i]->fecha_creacion);
            $pagos[$i]->fecha_limite=$this->CalcularFechaLimiteCorta($pagos[$i]->fecha_creacion);
            $pagos[$i]->id_cuenta=Cuenta::find($pagos[$i]->id_cuenta)->nombre;
            $pagos[$i]->comision=$pagos[$i]->comision."%";

           
               $pagos[$i]->estado='<p style="background-color: Red;"> Liquidado </p>';
         
           
            $pagos[$i]->acciones ='<a  type="button"  class="btn btn-warning margin"   onclick="reimprimir('. $pagos[$i]->id_pago.','.$nombre.','.$cantidad.','.$can_letra.','.$periodo.','.$fechaHoy.')" href="#">Imprimir</a> ';//' <a type="button" class="btn btn-warning " onclick="imprimirComprobante('.$nombre.','.$cantidad.','.$can_letra.','.$periodo.','.$fechaHoy.')">Imprimir</a>';

         }
        
        return $pagos;
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
	            $vales=Vale::where('id_distribuidor',$distribuidores[$j]->id_distribuidor)->where('deuda_actual','>',0)->where('estatus',1)->where('fecha_inicio_pago','<=',$this->calcularFechaCorte($fecha))->get();
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
	                 $comision=$this->calcularComision($saldoTotal,$distribuidores[$j]->id_distribuidor);
            
	            	$pagoDoble= Pago::where('id_distribuidor',$distribuidores[$j]->id_distribuidor)->where('fecha_creacion',$this->calcularFechaCorte($fecha))->get();
                    $pagoAux= Pago::where('id_distribuidor',$distribuidores[$j]->id_distribuidor)->where('estado',1)->get(); //pagos
	            	 if(count($pagoDoble)==0){
                         if (count($pagoAux)==0) {
    		                $pago = new Pago;
    						$pago->id_distribuidor=$distribuidores[$j]->id_distribuidor;
    						$pago->cantidad=$saldoTotal;
    						$pago->fecha_creacion=$this->calcularFechaCorte($fecha);
    						$pago->estado=0;// 0:pendiente  1:desfasado 2:pagado 3:Cancelado por nuevo pago
                            $pago->comision=$comision;
    						$pago->id_cuenta=Session::get('id');
    						$pago->save();
                            $distribuidores[$j]->comision=$comision;
                            $distribuidores[$j]->save();
                         
    		            }else{
                                $pagoAux[0]->estado=3;
                                $pagoAux[0]->save();
                                $pago=new Pago;
                                $pago->id_distribuidor=$distribuidores[$j]->id_distribuidor;
                                $pago->cantidad=$saldoTotal+($this->saldoAtrasado($vales,$distribuidores[$j]->id_distribuidor));
                                $pago->fecha_creacion=$this->calcularFechaCorte($fecha);
                                $pago->estado=0;// 0:pendiente  1:desfasado 2:pagado 3:Cancelado por nuevo pago
                                $pago->comision=0;
                                $pago->abono=$pagoAux[0]->abono;
                                $pago->id_cuenta=Session::get('id');
                                $pago->save();
                                $distribuidores[$j]->comision=$comision;
                                $distribuidores[$j]->save();
                               
                            

                        }///else     
                    }   

	            }// if saldo total
	            
	        }// for distribuidores
        }
        else{
        	$vales=Vale::where('id_distribuidor',$id)->where('deuda_actual','>',0)->where('estatus',1)->where('fecha_inicio_pago','<=',$this->calcularFechaCorte($fecha))->get();
	            $saldoTotal=0;
                $distribuidor=Distribuidor::find($id);
	            for ($i=0; $i <sizeof($vales); $i++) { 
                    
                     $importe=$vales[$i]->cantidad;
                     $saldoAnterior=$vales[$i]->deuda_actual;
                     $pagosRealizados=$vales[$i]->pagos_realizados+1;
                     $numeroPagos=$vales[$i]->numero_pagos;
                     $abono=$this->calcularPago($importe,$numeroPagos,$pagosRealizados);
                     $saldoTotal+=$abono;
                    
                }
                if($saldoTotal>0){
                     $comision=$this->calcularComision($saldoTotal,$id);
            
                    $pagoDoble= Pago::where('id_distribuidor',$distribuidor->id_distribuidor)->where('fecha_creacion',$this->calcularFechaCorte($fecha))->get();
                    $pagoAux=   Pago::where('id_distribuidor',$distribuidor->id_distribuidor)->where('estado',1)->get();
                     if(count($pagoDoble)==0){
                         if (count($pagoAux)==0) {
                            $pago = new Pago;
                            $pago->id_distribuidor=$distribuidor->id_distribuidor;
                            $pago->cantidad=$saldoTotal;
                            $pago->fecha_creacion=$this->calcularFechaCorte($fecha);
                            $pago->estado=0;// 0:pendiente  1:desfasado 2:pagado 3:Cancelado por nuevo pago
                            $pago->comision=$comision;
                            $pago->id_cuenta=Session::get('id');
                            $pago->save();
                            $distribuidor->comision=$comision;
                            $distribuidor->save();

                         
                        }else{
                                $pagoAux[0]->estado=3;
                                $pagoAux[0]->save();
                                $pago=new Pago;
                                $pago->id_distribuidor=$distribuidor->id_distribuidor;
                                $pago->cantidad=$saldoTotal+($this->saldoAtrasado($vales,$distribuidor->id_distribuidor));
                                $pago->fecha_creacion=$this->calcularFechaCorte($fecha);
                                $pago->estado=0;// 0:pendiente  1:desfasado 2:pagado 3:Cancelado por nuevo pago
                                $pago->comision=0;
                                $pago->abono=$pagoAux[0]->abono;
                                $pago->id_cuenta=Session::get('id');
                                $pago->save();
                                $distribuidor->comision=$comision;
                                $distribuidor->save();

                              
                               
                            

                        }///else     
                    }   

                }// if saldo total
                
            }// for distribuidores
        	
        
        return redirect('consultarPagos');
    }
    //////////////////////////////////////////////////////////////////////////////////////

    public function saldoAtrasado($vales,$id){
        $pagos= Pago::where('id_distribuidor',$id)->where('estado',3)->get();
        $nPagos=count($pagos);
        $acumulado=0;
        for ($i=0; $i <sizeof($vales); $i++) { 
         $fechaPago=Carbon::parse($vales[$i]->fecha_inicio_pago);
         $control=0;
           
             for ($j=0; $j <$nPagos ; $j++) { 
                 $fechaAtraso= Carbon::parse($pagos[$j]->fecha_creacion);
                 $importe=$vales[$i]->cantidad;
                 $pagosRealizados=$vales[$i]->pagos_realizados+$control+2;
                 $numeroPagos=$vales[$i]->numero_pagos;
                 $abono=$this->calcularPago($importe,$numeroPagos,$pagosRealizados);
                 if(($pagosRealizados<=$numeroPagos) && ($fechaPago<=$fechaAtraso)){
                    $control++;
                    $acumulado+=$abono;
                 }
                 
            }
        }
        return $acumulado;
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


    public function calcularComisionActual($fecha,$comision){
       $fechaLimite=Carbon::parse($this->CalcularFechaLimiteCorta($fecha));
       $fechaLimiteUno=Carbon::parse($this->CalcularFechaLimiteCorta($fecha))->addDay();
       $fechaLimiteDos=Carbon::parse($this->CalcularFechaLimiteCorta($fecha))->addDays(2);
      
       $fechaHoy=Carbon::today();
        // 10 nomviembre- 24 Novimebre-> 04 Diciembre
        // 25 novimebre-09 Diciembre -> 18 Diciembre


       if ($fechaHoy>$fechaLimite ) {
            if($comision<=0){
                $comision=0;
              return $comision;
            
            }
            else{
              if($fechaHoy==$fechaLimiteUno){
                $comision=$comision-2;
                return $comision;
                }
                elseif ($fechaHoy==$fechaLimiteDos) {
                    $comision=$comision-2;
                    return $comision;
                }
                elseif ($fechaHoy>$fechaLimiteDos){
                    $comision=0;
                    return $comision;
                }  
            }
          
       }else{
            return $comision;
       }
        
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
    public function nuevoEstado($fecha,$id){
        $fechaLimite=Carbon::parse($this->fechaLimiteBaja($fecha));
        $fechaHoy=Carbon::today();
        // 10 nomviembre- 24 Novimebre-> 04 Diciembre
        // 25 novimebre-09 Diciembre -> 18 Diciembre
        
        if($fechaHoy>=$fechaLimite){
            $distribuidor=Distribuidor::find($id);
            $distribuidor->estatus=1; //baja temporal
            $distribuidor->save();
            return 1;
        }else{
            return 0;

        }
    }
    public function fechaLimiteBaja($fecha){
        $fechaCarbon=Carbon::parse($fecha);
        // 10 nomviembre- 24 Novimebre-> 07 Diciembre
            // 25 novimebre-09 Diciembre -> 21 Diciembre
        if($fechaCarbon->day>=10 && $fechaCarbon->day<=24){
             $fechaCarbon->addMonth(); 
            return "07-".($fechaCarbon->month)."-".$fechaCarbon->year;       
        }
        else{
            if($fechaCarbon->day<=9){
                return "21-".($fechaCarbon->month)."-".$fechaCarbon->year;                
            }else{
                 $fechaCarbon->addMonth(); 
                return "21-".($fechaCarbon->month)."-".$fechaCarbon->year; 
            }  
        }
    }
    public function actualizarPagos(){
       $fechaHoy=Carbon::today();
        $pagos= Pago::where('estado','<',2)->get();
         for ($i=0; $i <sizeof($pagos); $i++) 
        { 
            $fechaActualizacion=Carbon::parse($pagos[$i]->updated_at);
           if($fechaHoy>$fechaActualizacion){
                $pagos[$i]->comision=$this->calcularComisionActual($pagos[$i]->fecha_creacion,$pagos[$i]->comision);
                $pagos[$i]->estado=$this->nuevoEstado($pagos[$i]->fecha_creacion,$pagos[$i]->id_distribuidor);
                $pagos[$i]->save();
            }
        }
    }


    function num_to_letras($numero)
{
    $moneda = 'PESO';
    $subfijo = 'M.N.';
    $xarray = array(
        0 => 'Cero'
        , 1 => 'UN', 'DOS', 'TRES', 'CUATRO', 'CINCO', 'SEIS', 'SIETE', 'OCHO', 'NUEVE'
        , 'DIEZ', 'ONCE', 'DOCE', 'TRECE', 'CATORCE', 'QUINCE', 'DIECISEIS', 'DIECISIETE', 'DIECIOCHO', 'DIECINUEVE'
        , 'VEINTI', 30 => 'TREINTA', 40 => 'CUARENTA', 50 => 'CINCUENTA'
        , 60 => 'SESENTA', 70 => 'SETENTA', 80 => 'OCHENTA', 90 => 'NOVENTA'
        , 100 => 'CIENTO', 200 => 'DOSCIENTOS', 300 => 'TRESCIENTOS', 400 => 'CUATROCIENTOS', 500 => 'QUINIENTOS'
        , 600 => 'SEISCIENTOS', 700 => 'SETECIENTOS', 800 => 'OCHOCIENTOS', 900 => 'NOVECIENTOS'
    );
 
    $numero = trim($numero);
    $xpos_punto = strpos($numero, '.');
    $xaux_int = $numero;
    $xdecimales = '00';
    if (!($xpos_punto === false)) {
        if ($xpos_punto == 0) {
            $numero = '0' . $numero;
            $xpos_punto = strpos($numero, '.');
        }
        $xaux_int = substr($numero, 0, $xpos_punto); // obtengo el entero de la cifra a covertir
        $xdecimales = substr($numero . '00', $xpos_punto + 1, 2); // obtengo los valores decimales
    }
 
    $XAUX = str_pad($xaux_int, 18, ' ', STR_PAD_LEFT); // ajusto la longitud de la cifra, para que sea divisible por centenas de miles (grupos de 6)
    $xcadena = '';
    for ($xz = 0; $xz < 3; $xz++) {
        $xaux = substr($XAUX, $xz * 6, 6);
        $xi = 0;
        $xlimite = 6; // inicializo el contador de centenas xi y establezco el límite a 6 dígitos en la parte entera
        $xexit = true; // bandera para controlar el ciclo del While
        while ($xexit) {
            if ($xi == $xlimite) { // si ya llegó al límite máximo de enteros
                break; // termina el ciclo
            }
 
            $x3digitos = ($xlimite - $xi) * -1; // comienzo con los tres primeros digitos de la cifra, comenzando por la izquierda
            $xaux = substr($xaux, $x3digitos, abs($x3digitos)); // obtengo la centena (los tres dígitos)
            for ($xy = 1; $xy < 4; $xy++) { // ciclo para revisar centenas, decenas y unidades, en ese orden
                switch ($xy) {
                    case 1: // checa las centenas
                        $key = (int) substr($xaux, 0, 3);
                        if (100 > $key) { // si el grupo de tres dígitos es menor a una centena ( < 99) no hace nada y pasa a revisar las decenas
                            /* do nothing */
                        } else {
                            if (TRUE === array_key_exists($key, $xarray)) {  // busco si la centena es número redondo (100, 200, 300, 400, etc..)
                                $xseek = $xarray[$key];
                                $xsub = $this->subfijo($xaux); // devuelve el subfijo correspondiente (Millón, Millones, Mil o nada)
                                if (100 == $key) {
                                    $xcadena = ' ' . $xcadena . ' CIEN ' . $xsub;
                                } else {
                                    $xcadena = ' ' . $xcadena . ' ' . $xseek . ' ' . $xsub;
                                }
                                $xy = 3; // la centena fue redonda, entonces termino el ciclo del for y ya no reviso decenas ni unidades
                            } else { // entra aquí si la centena no fue numero redondo (101, 253, 120, 980, etc.)
                                $key = (int) substr($xaux, 0, 1) * 100;
                                $xseek = $xarray[$key]; // toma el primer caracter de la centena y lo multiplica por cien y lo busca en el arreglo (para que busque 100,200,300, etc)
                                $xcadena = ' ' . $xcadena . ' ' . $xseek;
                            } // ENDIF ($xseek)
                        } // ENDIF (substr($xaux, 0, 3) < 100)
                        break;
                    case 2: // checa las decenas (con la misma lógica que las centenas)
                        $key = (int) substr($xaux, 1, 2);
                        if (10 > $key) {
                            /* do nothing */
                        } else {
                            if (TRUE === array_key_exists($key, $xarray)) {
                                $xseek = $xarray[$key];
                                $xsub = $this->subfijo($xaux);
                                if (20 == $key) {
                                    $xcadena = ' ' . $xcadena . ' VEINTE ' . $xsub;
                                } else {
                                    $xcadena = ' ' . $xcadena . ' ' . $xseek . ' ' . $xsub;
                                }
                                $xy = 3;
                            } else {
                                $key = (int) substr($xaux, 1, 1) * 10;
                                $xseek = $xarray[$key];
                                if (20 == $key)
                                    $xcadena = ' ' . $xcadena . ' ' . $xseek;
                                else
                                    $xcadena = ' ' . $xcadena . ' ' . $xseek . ' Y ';
                            } // ENDIF ($xseek)
                        } // ENDIF (substr($xaux, 1, 2) < 10)
                        break;
                    case 3: // checa las unidades
                        $key = (int) substr($xaux, 2, 1);
                        if (1 > $key) { // si la unidad es cero, ya no hace nada
                            /* do nothing */
                        } else {
                            $xseek = $xarray[$key]; // obtengo directamente el valor de la unidad (del uno al nueve)
                            $xsub = $this->subfijo($xaux);
                            $xcadena = ' ' . $xcadena . ' ' . $xseek . ' ' . $xsub;
                        } // ENDIF (substr($xaux, 2, 1) < 1)
                        break;
                } // END SWITCH
            } // END FOR
            $xi = $xi + 3;
        } // ENDDO
        # si la cadena obtenida termina en MILLON o BILLON, entonces le agrega al final la conjuncion DE
        if ('ILLON' == substr(trim($xcadena), -5, 5)) {
            $xcadena.= ' DE';
        }
 
        # si la cadena obtenida en MILLONES o BILLONES, entonces le agrega al final la conjuncion DE
        if ('ILLONES' == substr(trim($xcadena), -7, 7)) {
            $xcadena.= ' DE';
        }
 
        # depurar leyendas finales
        if ('' != trim($xaux)) {
            switch ($xz) {
                case 0:
                    if ('1' == trim(substr($XAUX, $xz * 6, 6))) {
                        $xcadena.= 'UN BILLON ';
                    } else {
                        $xcadena.= ' BILLONES ';
                    }
                    break;
                case 1:
                    if ('1' == trim(substr($XAUX, $xz * 6, 6))) {
                        $xcadena.= 'UN MILLON ';
                    } else {
                        $xcadena.= ' MILLONES ';
                    }
                    break;
                case 2:
                    if (1 > $numero) {
                        $xcadena = "CERO {$moneda}S {$xdecimales}/100 {$subfijo}";
                    }
                    if ($numero >= 1 && $numero < 2) {
                        $xcadena = "UN {$moneda} {$xdecimales}/100 {$subfijo}";
                    }
                    if ($numero >= 2) {
                        $xcadena.= " {$moneda}S {$xdecimales}/100 {$subfijo}"; //
                    }
                    break;
            } // endswitch ($xz)
        } // ENDIF (trim($xaux) != "")
 
        $xcadena = str_replace('VEINTI ', 'VEINTI', $xcadena); // quito el espacio para el VEINTI, para que quede: VEINTICUATRO, VEINTIUN, VEINTIDOS, etc
        $xcadena = str_replace('  ', ' ', $xcadena); // quito espacios dobles
        $xcadena = str_replace('UN UN', 'UN', $xcadena); // quito la duplicidad
        $xcadena = str_replace('  ', ' ', $xcadena); // quito espacios dobles
        $xcadena = str_replace('BILLON DE MILLONES', 'BILLON DE', $xcadena); // corrigo la leyenda
        $xcadena = str_replace('BILLONES DE MILLONES', 'BILLONES DE', $xcadena); // corrigo la leyenda
        $xcadena = str_replace('DE UN', 'UN', $xcadena); // corrigo la leyenda
    } // ENDFOR ($xz)
  
   return trim($xcadena);
}
 

    function subfijo($cifras)
    {
        $cifras = trim($cifras);
        $strlen = strlen($cifras);
        $_sub = '';
        if (4 <= $strlen && 6 >= $strlen) {
            $_sub = 'MIL';
        }
     
        return $_sub;
    }
}
