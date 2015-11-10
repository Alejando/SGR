<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Distribuidor;
use App\Vale;
use App\Cliente;
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
                return view('s_admin.editarVale');
            break;
            case 1:
               return view('admin.editarVale',compact('vale'));
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
                 Session::flash('message','Folio repetido, el ultimo folio es: '.$auxV->last()->folio);
                Session::flash('class','danger');
            }
        }
        else{
             Session::flash('message','Folio fin debe ser mayor a folio inicio ');
                Session::flash('class','danger');
        }
       return redirect('crearVale'); 
       
    }

    public function registrarVale(){
       
        switch (Session::get('tipo')) {
            case 0:
               // return redirect('');
                //return ("Eres un super administrador");
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
       return  " > ".Session::get('tipo')." <";
       /*  $serie = $request->input('serie');
         $folio = $request->input('folio');
         $vale = Vale::where('serie',$serie)->where('folio', $folio)->get();
         if(sizeof($vale)<=0){
           return "no";
         }
         else{
            return $vale;
         }
        */
       
    }

    public function consultarVales()
    {
       switch (Session::get('tipo')) {
            case 0:
               // return redirect('');
                //return ("Eres un super administrador");
                break;
            case 1:
                return view('admin.consultarVales');
                break;
            case 2:
                 return view('vendedor.consultarVales');
                break;
        }         
    }
    
    public function obtenerVales()
    {
        $vales = Vale::all();
        for ($i=0; $i <sizeof($vales); $i++) { 
             $vales[$i]->id_distribuidor=Vale::find($vales[$i]->id_vale)->distribuidor->nombre;
             if($vales[$i]->estatus==0){
                $vales[$i]->estatus="Disponible";
             }
             if($vales[$i]->estatus==1){
                $vales[$i]->estatus="Ocupado";
             }
             if($vales[$i]->estatus==2){
                $vales[$i]->estatus="Cancelado";
             }
              $vales[$i]->id_vale='<a type="button" class="btn btn-primary margin" href="editarVale/'. $vales[$i]->id_vale.'">Actualizar</a>';    
        }    
        return $vales;
    }
    
    public function obtenerValesV()
    {
       $cuenta=1;
        $vales = Vale::where('id_cuenta',$cuenta)->where('fecha_venta',Carbon::today())->get();
       for ($i=0; $i <sizeof($vales); $i++) { 
             $vales[$i]->id_distribuidor=Vale::find($vales[$i]->id_vale)->distribuidor->nombre;
             if($vales[$i]->estatus==0){
                $vales[$i]->estatus="Disponible";
             }
             if($vales[$i]->estatus==1){
                $vales[$i]->estatus="Ocupado";
             }
             if($vales[$i]->estatus==2){
                $vales[$i]->estatus="Cancelado";
             }
                
        }    
        return $vales;
    }
    public function ventaVale(Request $request){
        
        $vale = Vale::find($request->input('id_vale'));
        $folio = $request->input('folio');
        $serie = $request->input('serie');
        $idCliente = $request->input('id_cliente');
        $nombre = strtoupper($request->input('nombre'));
        $cuenta = Session::get('id');
        $fechaVenta = Carbon::today(); 
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
                if($cantidad<$vale->cantidad_limite || $vale->cantidad_limite==0){
               
                    if($saldoNuevoDistribuidor<$limiteCreditoDistribuidor){ 
                         if(is_null($idCliente)){
                            $cliente= new Cliente;
                            $cliente->nombre=$nombre;
                            $cliente->save();
                             $idCliente = Cliente::max('id_cliente');
                        }
                        if(is_null($idPromocion)){
                            $vale_promo = new Vales_has_promociones;
                            $vale_promo->vale_id = $vale->id_vale;
                            $vale_promo->promocion_id = $idPromocion;
                            $vale_promo->save();
                        }
                        $vale->id_cliente=$idCliente;
                        $vale->id_cuenta=$cuenta;
                        $vale->fecha_venta=Carbon::today();
                        $vale->cantidad=$cantidad;
                        $vale->numero_pagos=$numeroPagos;
                        $vale->folio_venta=$folioVenta;
                        $vale->deuda_actual=$cantidad;
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
                        Session::flash('message','El distribuidor a superado limite de credito por $'.$saldoNuevoDistribuidor-$limiteCreditoDistribuidor.'.00');
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
        
        switch (Session::get('tipo')) {
            case 0:
               // return redirect('');
                //return ("Eres un super administrador");
                break;
            case 1:
                return redirect('registrarVale');
                break;
            case 2:
                 return redirect('registrarVale');
                break;
        }   
      
    }

    public function obtenerUltimoVale(){
        $id = Vale::max('id_vale');
        $vale =Vale::find($id);
        return $vale;
    }

    
    

}
