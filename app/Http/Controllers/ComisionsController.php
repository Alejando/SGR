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
}
