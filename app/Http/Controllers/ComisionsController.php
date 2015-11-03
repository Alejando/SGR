<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Comision;
use Session;
use Redirect;


class ComisionsController extends Controller
{
    public function crearComision()
    {
        return view('admin.crearComision');
    }

     public function guardarComision(Request $request)
    {
        $comision = new Comision;
        $comision->cantidad_inicial = $request->input('cantidad_inicial');
        $comision->cantidad_final = $request->input('cantidad_final');
        $comision->porcentaje = $request->input('porcentaje');

        if($comision->save()){
            Session::flash('message','Guardado Correctamente');
            Session::flash('class','success');
        }else{
            Session::flash('message','Ha ocurrido un error');
            Session::flash('class','danger');
        }
       return redirect('crearComision');
    }

    public function consultarComisiones()
    {
    
        switch (Session::get('tipo')) {
            case 0:
                // return redirect('');
                //return view('superAdmin.consultarCuentasVendedor');
                break;
            case 1:
                return view('admin.consultarComisiones');
                break;
        }  
    }

    public function obtenerComisiones()
    {
        $comisiones = Comision::all();
        for ($i=0; $i <sizeof($comisiones); $i++) 
        {
            $comisiones[$i]->porcentaje = $comisiones[$i]->porcentaje.' %';
            $comisiones[$i]->id_comision = '<a type="button" class="btn btn-primary margin" href="editarComision/'. $comisiones[$i]->id_comision .'">Actualizar</a>';    
        }
        
        return $comisiones;
    }

    public function editaromision($id)
    {
        $comision = Comision::find($id);
        switch (Session::get('tipo')) {
            case 0:
               // return redirect('');
                //return ("Eres un super administrador");
                break;
            case 1:
                return view('admin.editarComision',compact('comision'));
                break;
            
        }        
    }

    public function actualizaromision(Request $request,$id)
    {
        $cuenta = Cuenta::find($id);
        $cuenta->nombre = strtoupper($request->input('nombre'));
        $cuenta->telefono = $request->input('telefono');
        $cuenta->usuario = strtoupper($request->input('usuario'));
        $cuenta->contrasena = $request->input('contrasena');
        


        if($cuenta->save()){
            Session::flash('message','Datos actualizados  Correctamente');
            Session::flash('class','success');
        }else{
            Session::flash('message','Ha ocurrido un error');
            Session::flash('class','danger');
        }
       switch (Session::get('tipo')) {
            case 0:
               // return redirect('');
                //return view('admin.consultarCuentasVendedor');
                break;
            case 1:
                return redirect('consultarCuentasVendedor');
                break;
        }  
    }
}
