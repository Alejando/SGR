<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Cuenta;
use Session;

//Tipo 1: Administrador
//Tipo 2: Vendedor

class CuentasController extends Controller
{
    public function crearCuentaVendedor()
    {
        return view('admin.crearCuentaVendedor');
    }

     public function guardarCuentaVendedor(Request $request)
    {
        $vendedor = new Cuenta;
        $vendedor->nombre = strtoupper($request->input('nombre'));
        $vendedor->telefono = strtoupper($request->input('telefono'));
        $vendedor->usuario = strtoupper($request->input('usuario'));
        $vendedor->contrasena = $request->input('contrasena');
        $vendedor->tipo = 2;
        
        $contrasena = $request->input('contrasena');
        $contrasena2 = $request->input('contrasena2');

        if($contrasena != $contrasena2)
        {
            Session::flash('message','La primera contraseña escrita no coincide con la segunda');
            Session::flash('class','danger');
        }else
            {
                if($vendedor->save()){
                    Session::flash('message','Guardado Correctamente');
                    Session::flash('class','success');
                }else{
                    Session::flash('message','Ha ocurrido un error');
                    Session::flash('class','danger');
                }
            }
       return view('admin.crearCuentaVendedor');
    }

    public function consultarCuentasVendedor()
    {
    
        switch (Session::get('tipo')) {
            case 0:
                // return redirect('');
                //return view('superAdmin.consultarCuentasVendedor');
                break;
            case 1:
                return view('admin.consultarCuentasVendedor');
                break;
        }  
    }

    public function obtenerCuentasVendedor()
    {
        $cuentas = Cuenta::where('tipo',2)->get();
        for ($i=0; $i <sizeof($cuentas); $i++) { 
            $cuentas[$i]->id_cuenta='<a type="button" class="btn btn-primary margin" href="editarCuentaVendedor/'. $cuentas[$i]->id_cuenta.'">Actualizar</a>';    
        }
        
        return $cuentas;
    }

    public function editarCuentaVendedor($id)
    {
        $cuenta = Cuenta::find($id);
        switch (Session::get('tipo')) {
            case 0:
               // return redirect('');
                //return ("Eres un super administrador");
                break;
            case 1:
                return view('admin.editarCuentaVendedor',compact('cuenta'));
                break;
            
        }        
    }

    public function actualizarCuentaVendedor(Request $request,$id)
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
