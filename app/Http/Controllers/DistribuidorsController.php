<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Distribuidor;
use Session;
class DistribuidorsController extends Controller
{
    


    public function crearDistribuidor()
    {
        return view('distribuidor.crearDistribuidor');
    }

 
    public function guardarDistribuidor(Request $request)
    {
        $distribuidor = new Distribuidor;
        $distribuidor->nombre = $request->input('nombre');
        $distribuidor->calle = $request->input('calle');
        $distribuidor->numero_exterior = $request->input('numero_exterior');
        $distribuidor->municipio = $request->input('municipio');
        $distribuidor->codigo_postal = $request->input('codigo_postal');
        $distribuidor->celular = $request->input('celular');
        $distribuidor->colonia = $request->input('colonia');
        $distribuidor->numero_interior = $request->input('numero_interior');
        $distribuidor->estado = $request->input('estado');
        $distribuidor->telefono = $request->input('telefono');
        $distribuidor->nombre_aval = $request->input('nombre_aval');
        $distribuidor->calle_aval = $request->input('calle_aval');
        $distribuidor->numero_exterior_aval = $request->input('numero_exterior_aval');
        $distribuidor->municipio_aval = $request->input('municipio_aval');
        $distribuidor->codigo_postal_aval = $request->input('codigo_postal_aval');
        $distribuidor->celular_aval = $request->input('celular_aval');
        $distribuidor->colonia_aval = $request->input('colonia_aval');
        $distribuidor->numero_interior_aval = $request->input('numero_interior_aval');
        $distribuidor->estado_aval = $request->input('estado_aval');
        $distribuidor->telefono_aval = $request->input('telefono_aval');
        $distribuidor->limite_credito = $request->input('limite_credito');
        $distribuidor->limite_vale = $request->input('limite_vale');
       
       if ($request->hasFile('foto')) {
         $file = $request->file('foto');
         $nombreFoto=$file->getClientOriginalName();
         $distribuidor->foto=$nombreFoto;
         $file->move('fotos/', $nombreFoto); 
        }
         if ($request->hasFile('firma')) {
        $file = $request->file('firma');
         $nombreFirma=$file->getClientOriginalName();
         $distribuidor->foto=$nombreFirma;
         $file->move('firma/', $nombreFirma); 
        }
       

        if($distribuidor->save()){
            Session::flash('message','Guardado Correctamente');
            Session::flash('class','success');
        }else{
            Session::flash('message','Ha ocurrido un error');
            Session::flash('class','danger');
        }
       return view('distribuidor.crearDistribuidor');
    }

    public function verDistribuidor($id)
    {
        //
    }

    public function editarDistribuidor($id)
    {
        //
    }

  
    public function actualizarDistribuidor(Request $request, $id)
    {
        //
    }

}
