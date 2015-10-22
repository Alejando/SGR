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
        return view('admin.crearVale');
    }

    public function guardarVale(Request $request)
    {
        $id_distribuidor = $request->input('id_distribuidor');
        $serie = $request->input('serie');
        $folioInicio = $request->input('folio_inicio');
        $folioFin = $request->input('folio_fin');
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
                $vale->cantidad_limite=Vale::find($id_distribuidor)->distribuidor->limite_vale;
                $vale->fecha_creacion=Carbon::today(); 
                $vale->estatus=0; // 0=disponible, 1=ocupado 2=cancelado
                $vale->save();
            }
            Session::flash('message','Guardado Correctamente');
                Session::flash('class','success');
        }
        else{
             Session::flash('message','Folio repetido el ultimo folio es: '.$auxV->last()->folio);
            Session::flash('class','danger');
        }
       return view('admin.crearVale'); 
       
    }

    public function registrarVale(){
         return view('vendedor.registrarVale');
    }

    public function buscarVale(Request $request){
         
         $serie = $request->input('serie');
         $folio = $request->input('folio');
         $vale = Vale::where('serie',$serie)->where('folio', $folio)->get();
        return $vale;
    }

    public function consultarVales()
    {
        $vales = Vale::all();
        return view('vendedor.consultarVales',compact('vales'));
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

    public function ventaVale(Request $request){
        $serie = $request->input('serie');
        $folio = $request->input('folio');
        $vale = Vale::where('serie',$serie)->where('folio', $folio)->get();
        $nombre = $request->input('nombre');
        $cuenta = 1;
        $fechaVenta = Carbon::today(); 
        $numeroPagos = $request->input('numero_pagos');
        $folioVenta = $request->input('folio_venta');
        $cantidad = $request->input('cantidad');
        $fechaPago = $request->input('fecha_inicio_pago');

        if($vale->estatus!=0){
            if($vale->cantidad_limite==0 || $cantidad> $vale->cantidad_limite){
                $saldoDistribuidor=Vale::find($vale->id_distribuidor)->distribuidor->saldo_actual;
                $saldoNuevoDistribuidor=$saldoDistribuidor+$cantidad;
                $limiteCreditoDistribuidor=Vale::find($id_distribuidor)->distribuidor->limite_credito;
                if($saldoNuevoDistribuidor<$limiteCreditoDistribuidor;){
                $vale->id_cliente=$id_distribuidor;
                $vale->serie=$serie;
                $vale->folio=$i;
                $vale->cantidad_limite=Distribuidor::find($id_distribuidor)->limite_vale;
                $vale->fecha_creacion=date("Y-m-d");
                $vale->estatus=0; // 0=disponible, 1=ocupado 2=cancelado
                $vale->save();
                }
                else{
                    Session::flash('El distribuidor a superado limite de credito por $'$saldoNuevoDistribuidor-$limiteCreditoDistribuidor'.00');
                    Session::flash('class','danger');
                }
            }
            else{
                Session::flash('El monto de venta es mayor al limite permitido para este vale');
                Session::flash('class','danger');
                }
        }
        else{
            Session::flash('message','El vale  '.$serie.'-'.$folio.'ya ha sido utilizado');
            Session::flash('class','danger');
        }
       
        /////////////////////////////////////////
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
                $vale->fecha_creacion=date("Y-m-d");
                $vale->estatus=0; // 0=disponible, 1=ocupado 2=cancelado
                $vale->save();
            }
            Session::flash('message','Guardado Correctamente');
                Session::flash('class','success');
        }
        else{
             Session::flash('message','Folio repetido el ultimo folio es: '.$auxV->last()->folio);
            Session::flash('class','danger');
        }
       return view('admin.crearVale'); 
    }


    
    
  
}
