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
        $vendedor->nombre = $request->input('nombre');
        $vendedor->telefono = $request->input('telefono');
        $vendedor->usuario = $request->input('usuario');
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
    
}
