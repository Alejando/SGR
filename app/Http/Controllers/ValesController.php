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
class ValesController extends Controller
{
    public function crearVale()
    {   
        switch (Session::get('tipo')) {
            case 0:   
                return view('s_admin.crearVale');
            break;
            case 1:
               return view('admin.crearVale');
            break; 
        } 
    }
     public function editarVale($id)
    {   
        $vale=Vale::find($id);
         switch (Session::get('tipo')) {
            case 0:   
                return view('s_admin.editarVale',compact('vale'));
            break;
            case 1:
               return view('admin.editarVale',compact('vale'));
            break; 
        } 
    }
    public function cambiarVales()
    {   
        switch (Session::get('tipo')) {
            case 0:   
                return view('s_admin.cambiarVale');
            break;
            case 1:
               return view('admin.cambiarVale');
            break; 
        } 
    }
    public function guardarVale(Request $request)
    {
        $id_distribuidor = $request->input('id_distribuidor');
        $serie = strtoupper($request->input('serie'));
        $folioInicio = $request->input('folio_inicio');
        $folioFin = $request->input('folio_fin');
        if($folioFin>=$folioInicio){
            $auxV= Vale::where('serie',$serie)->get();  
            if (count($auxV)==0) {
                $ultimo=0;
            }
            else{
                $ultimo=$auxV->last()->folio;
            }
            if($folioInicio>$ultimo){
                for($i=$folioInicio;$i<=$folioFin;$i++){
                    $vale = new Vale;
                    $vale->id_distribuidor=$id_distribuidor;
                    $vale->serie=$serie;
                    $vale->folio=$i;
                    $vale->cantidad_limite=Distribuidor::find($id_distribuidor)->limite_vale;
                    $vale->fecha_creacion=Carbon::today(); 
                    $vale->estatus=0; // 0=disponible, 1=ocupado 2=cancelado
                    $vale->save();
                }
                Session::flash('message','Guardado Correctamente');
                    Session::flash('class','success');
          }
            else{
                 Session::flash('message','Folio repetido, el ultimo folio es: '.$ultimo);
                Session::flash('class','danger');
            }
        }
        else{
             Session::flash('message','Folio fin debe ser mayor a folio inicio ');
                Session::flash('class','danger');
        }
       return redirect('crearVale'); 
       
    }
    public function actualizarVales(Request $request)
    {
        $id_distribuidor = $request->input('id_distribuidor');
        $serie = strtoupper($request->input('serie'));
        $folioInicio = $request->input('folio_inicio');
        $folioFin = $request->input('folio_fin');
        if($folioFin>=$folioInicio){
                      
                for($i=$folioInicio;$i<=$folioFin;$i++){
                    $vale = Vale::where('folio',$i)->where('serie',$serie)->where('estatus','<',1)->get();
                    if(sizeof($vale)>0){
                        $vale[0]->id_distribuidor=$id_distribuidor;
                        $vale[0]->serie=$serie;
                        $vale[0]->cantidad_limite=Distribuidor::find($id_distribuidor)->limite_vale;
                        $vale[0]->estatus=0; // 0=disponible, 1=ocupado 2=cancelado
                        $vale[0]->save();
                    }
                }
                Session::flash('message','Folios Actualizados  Correctamente');
                    Session::flash('class','success');
      
        }
        else{
             Session::flash('message','Folio fin debe ser mayor a folio inicio ');
                Session::flash('class','danger');
        }
       return redirect('cambiarVales'); 
       
    }

    public function registrarVale(){
       
        switch (Session::get('tipo')) {
            case 0:
               return view('s_admin.registrarVale');
                break;
            case 1:
               return view('admin.registrarVale');
                break;
            case 2:
                 return view('vendedor.registrarVale');
                break;
        } 
    }

    public function buscarVale(Request $request){
        $serie = $request->input('serie');
         $folio = $request->input('folio');
         $vale = Vale::where('serie',$serie)->where('folio', $folio)->get();
         if(sizeof($vale)<=0){
           return "no";
         }
         else{
            return $vale;
         }
        
       
    }

    public function consultarVales()
    {
       switch (Session::get('tipo')) {
            case 0:
               return view('s_admin.consultarVales');
                break;
            case 1:
                return view('admin.consultarVales');
                break;
            case 2:
                 return view('vendedor.consultarVales');
                break;
        }         
    }
    
    public function obtenerVales(Request $request)
    {
        $limite=$request->input('limit');
           if(is_null($limite)){
                $distribuidor=$request->input('distribuidor');
                if($distribuidor=="0"){
                    $fechaInicio=$request->input('fecha_inicio');
                    if($fechaInicio=="0"){
                        $fechaTermino=$request->input('fecha_termino');
                        if($fechaTermino=="0"){
                           $vales = Vale::where('estatus','<',2)->get(); //consulta al inicio
                           
                        }else{
                             //buscar vales con fecha termino
                             $vales = Vale::where('estatus',1)->where('fecha_inicio_pago','<=',$fechaTermino)->get();
                        }
                    }else{
                        $fechaTermino=$request->input('fecha_termino');
                        if($fechaTermino=="0"){
                            $vales = Vale::where('estatus',1)->where('fecha_inicio_pago','=>',$fechaInicio)->get();
                            
                        }else{
                           //buscar vales con fecha inicio y fecha termino
                           $vales = Vale::where('estatus',1)->where('fecha_inicio_pago','=>',$fechaInicio)->where('fecha_inicio_pago','<=',$fechaTermino)->get();
                        }
                    }

                }else{
                    $fechaInicio=$request->input('fecha_inicio');
                    if($fechaInicio=="0"){
                        $fechaTermino=$request->input('fecha_termino');
                        if($fechaTermino=="0"){
                            $vales = Vale::where('estatus',1)->where('id_distribuidor',$distribuidor)->get();
                            
                        }else{
                             //buscar vales con fecha termino y distribuidor
                          $vales = Vale::where('estatus',1)->where('id_distribuidor',$distribuidor)->where('fecha_inicio_pago','<=',$fechaTermino)->get();
                        }
                    }else{
                        $fechaTermino=$request->input('fecha_termino');
                        if($fechaTermino=="0"){
                                    //buscar vales con fecha inicio y distribuidor
                           $vales = Vale::where('estatus',1)->where('id_distribuidor',$distribuidor)->where('fecha_inicio_pago','=>',$fechaInicio)->get();
                            
                        }else{
                           //buscar con los tres valores
                            $vales = Vale::where('estatus',1)->where('id_distribuidor',$distribuidor)->where('fecha_inicio_pago','=>',$fechaInicio)->where('fecha_inicio_pago','<=',$fechaTermino)->get();
                        }
                    }
                }
           }
           else{
             $vales = Vale::where('estatus',1)->get(); //consulta al inicio
           }
      
        for ($i=0; $i <sizeof($vales); $i++) { 

             $distribuidor=Vale::find($vales[$i]->id_vale)->distribuidor->nombre;
             $vales[$i]->id_cliente=Vale::find($vales[$i]->id_vale)->cliente->nombre;
            
            if(Vale::find($vales[$i]->id_vale)->distribuidor->estatus==1){
                $vales[$i]->id_distribuidor='<p  style="background-color: brown; ">'.$distribuidor.'</p>';
            }else{
                $vales[$i]->id_distribuidor=$distribuidor;
            }
             if($vales[$i]->estatus==0){
                $vales[$i]->estatus='Disponible';
             }
             if($vales[$i]->estatus==1){
                $vales[$i]->estatus='<p  style="background-color: green;">Ocupado</p>';
             }
             if($vales[$i]->estatus==2){
                $vales[$i]->estatus='<p  style="background-color: red;">Cancelado</p>';
             }
             if($vales[$i]->estatus==3){
                $vales[$i]->estatus='<p  style="background-color: brown;">Pagado</p>';
                $vales[$i]->id_vale='<a type="button" class="btn btn-primary margin">No disponible</a>'; 
             }
             else{
               
                $vales[$i]->id_vale='<a type="button" class="btn btn-primary margin" href="editarVale/'. $vales[$i]->id_vale.'">Actualizar</a>'; 
             }
   
        }    
        return $vales;
    }
    
    public function obtenerValesV(Request $request )
    {
        $fecha=$request->input('fecha');
        if(is_null($fecha)){
            $fecha=Carbon::today();
        }
       $cuenta=Session::get('id');
        $vales = Vale::where('id_cuenta',$cuenta)->where('fecha_venta',$fecha)->get();
       for ($i=0; $i <sizeof($vales); $i++) { 
             $vales[$i]->id_distribuidor=Vale::find($vales[$i]->id_vale)->distribuidor->nombre;
             if($vales[$i]->estatus==0){
                $vales[$i]->estatus="Disponible";
             }
             if($vales[$i]->estatus==1){
                $vales[$i]->estatus='<p  style="background-color: green;">Ocupado</p>';
             }
             if($vales[$i]->estatus==2){
                $vales[$i]->estatus='<p  style="background-color: red;">cancelado</p>';
             }
                
        }    
        return $vales;
    }
    public function obtenerValesVendedorReporte(Request $request )
    {
        $fecha=$request->input('fecha');
        if($fecha==""){
            $fecha=Carbon::today();
        }
       $cuenta=Session::get('id');
        $vales = Vale::where('id_cuenta',$cuenta)->where('fecha_venta',$fecha)->get();
        return $vales;
    }
    
    public function ventaVale(Request $request){
        
        $vale = Vale::find($request->input('id_vale'));
        $folio = $request->input('folio');
        $serie = strtoupper($request->input('serie'));
        $idCliente = $request->input('id_cliente');
        $nombre = strtoupper($request->input('nombre'));
        $cuenta = Session::get('id');
        $fechaVenta = $request->input('fecha_venta');
        $numeroPagos = $request->input('numero_pagos');
        $folioVenta = $request->input('folio_venta');
        $cantidad = $request->input('cantidad');
        $fechaPago = $request->input('fecha_inicio_pago');
        $idPromocion=$request->input('id_promocion');
        $saldoDistribuidor=$vale->distribuidor->saldo_actual;
        $saldoNuevoDistribuidor=$saldoDistribuidor+$cantidad;
        $limiteCreditoDistribuidor=$vale->distribuidor->limite_credito;
        if($vale->estatus==0){
            if($vale->distribuidor->estatus==0){ //0->activo 1->desactivado
                if($cantidad<=$vale->cantidad_limite || $vale->cantidad_limite==0){
               
                    if($saldoNuevoDistribuidor<=$limiteCreditoDistribuidor){ 
                         if(is_null($idCliente)){
                            $cliente= new Cliente;
                            $cliente->nombre=$nombre;
                            $cliente->save();
                             $idCliente = Cliente::max('id_cliente');
                        }
                        if($idPromocion>0){
                            $vale_promo = new Vales_has_promociones;
                            $vale_promo->vale_id = $vale->id_vale;
                            $vale_promo->promocion_id = $idPromocion;
                            $vale_promo->save();
                        }
                        $vale->distribuidor->saldo_actual=$saldoNuevoDistribuidor;
                        $vale->distribuidor->save();
                        $vale->id_cliente=$idCliente;
                        $vale->id_cuenta=$cuenta;
                        $vale->fecha_venta=Carbon::today();
                        $vale->cantidad=$cantidad;
                        $vale->numero_pagos=$numeroPagos;
                        $vale->folio_venta=$folioVenta;
                        $vale->deuda_actual=$cantidad;
                        $vale->id_promocion=$idPromocion;
                        $vale->estatus=1; // 0=disponible, 1=ocupado 2=cancelado
                        $vale->fecha_inicio_pago=$fechaPago;
                        if($vale->save()){
                            Session::flash('message','Venta con vale exitoso!');
                            Session::flash('class','success');
                        }
                        else{
                            Session::flash('message','Error al guardar el vale en la base de datos');
                            Session::flash('class','danger');
                        }
                    }
                    else{
                        Session::flash('message','El distribuidor a superado limite de credito por $'.($saldoNuevoDistribuidor-$limiteCreditoDistribuidor).'.00');
                        Session::flash('class','danger');
                    }
                }
                else{
                    Session::flash('message','El monto de venta es mayor al limite permitido para este vale');
                    Session::flash('class','danger');
                }
            }
            else{
                Session::flash('message','Por el momento el distribuidor se encuentra dado de baja temporalmente');
                Session::flash('class','danger');
            }
        }
        else{
            if($vale->estatus==2){
                Session::flash('message','El vale '.$serie.' - '.$folio.' se encuentra cancelado debiado a: '.$vale->motivo_cancelacion);
                Session::flash('class','danger');
            }
            else{
                Session::flash('message','El vale  '.$serie.' - '.$folio.' ya ha sido utilizado');
                Session::flash('class','danger');
            }   
        }
        

        return redirect('registrarVale');
                
      
    }
    public function obtenerUltimoVale(){
        $id = Vale::max('id_vale');
        $vale =Vale::find($id);
        return $vale;
    }

    
    public function modificarVale(Request $request){
        
        $vale = Vale::find($request->input('id_vale'));
        $valeMovimiento=(string)$vale;
        $folio = $request->input('folio');
        $serie = $request->input('serie');
        $fechaVenta = $request->input('fecha_venta');
        $fechaPago = $request->input('fecha_inicio_pago');
        $idPromocion = $request->input('id_promocion');
        $limiteVale =$request->input('limite_vale');
        $idCliente = $request->input('id_cliente');
        $idCuenta = $request->input('id_cuenta');
        $idDistribuidor = $request->input('id_distribuidor');
        $cantidad = $request->input('cantidad');
        $numeroPagos = $request->input('numero_pagos');
        $folioVenta = $request->input('folio_venta');
        $estatus = $request->input('estatus');
        $motivoCancelacion = $request->input('motivo_cancelacion');
       
        $vale->folio=$folio;

        $vale->serie=$serie;
        $vale->fecha_venta=$fechaVenta;
        $vale->fecha_inicio_pago=$fechaPago;
        $vale->id_promocion=$idPromocion;
        $vale->id_cliente=$idCliente;
        $vale->id_cuenta=$idCuenta;
        $vale->id_distribuidor=$idDistribuidor;
        $vale->cantidad=$cantidad;
        $vale->deuda_actual=$cantidad;
        $vale->numero_pagos=$numeroPagos;
        $vale->folio_venta=$folioVenta;
        $vale->estatus=$estatus;
        $vale->cantidad_limite=$limiteVale;
        $vale->motivo_cancelacion=$motivoCancelacion;
         $auxVale= Vale::where('serie',$serie)->where('folio',$folio)->get();  
         if(sizeof($auxVale)==0){
             Session::flash('message',' Ya existe Vale!');
                Session::flash('class','danger');
                 return redirect('consultarVales');
         }else{
             if($vale->save()){
                $movimiento= new Movimiento;
                $movimiento->id_cuenta=Session::get('id');
                $movimiento->fecha=Carbon::today();
                $movimiento->estado_anterior=$valeMovimiento;
                $movimiento->estado_actual=(string)Vale::find($request->input('id_vale'));
                $movimiento->tipo=1; // 1:vales 2:cuentas 3:pagos 4:distribuidores 5:comisiones
                $movimiento->save();
                Session::flash('message',' Vale actualizado exitoso!');
                Session::flash('class','success');
                 return redirect('consultarVales');
            }
            else{
                Session::flash('message','Error al guardar el vale en la base de datos');
                Session::flash('class','danger');
                 return redirect('consultarVales');
            }
         }
       
            
            

     
                

    }
    

}
