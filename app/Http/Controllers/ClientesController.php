<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Cliente;
use Session;

class ClientesController extends Controller
{

    public function crearCliente()
    {
        return view('vendedor.crearCliente');
    }

    public function guardarCliente(Request $request)
    {
        $cliente = new Cliente;
        $cliente->nombre = $request->input('nombre');
        $cliente->telefono = $request->input('telefono');
        $cliente->celular = $request->input('celular');
        $cliente->numero_elector = $request->input('numero_elector');
        $cliente->calle = $request->input('calle');
        $cliente->numero_exterior = $request->input('numero_exterior');
        $cliente->numero_interior = $request->input('numero_interior');
        $cliente->colonia = $request->input('colonia');
        $cliente->municipio = $request->input('municipio');
        $cliente->estado = $request->input('estado');
        $cliente->codigo_postal = $request->input('codigo_postal');
        $cliente->nombre_referencia_1 = $request->input('nombre_referencia_1');
        $cliente->telefono_referencia_1 = $request->input('telefono_referencia_1');
        $cliente->nombre_referencia_2 = $request->input('nombre_referencia_2');
        $cliente->telefono_referencia_2 = $request->input('telefono_referencia_2');
        


        if($cliente->save()){
            Session::flash('message','Guardado Correctamente');
            Session::flash('class','success');
        }else{
            Session::flash('message','Ha ocurrido un error');
            Session::flash('class','danger');
        }
       return view('vendedor.crearCliente');
    }

    public function consultarClientes()
    {
        $clientes = Cliente::all();
        return view('vendedor.consultarClientes',compact('clientes'));
    }

    public function obtenerClientes()
    {
        $clientes = Cliente::all();
        return $clientes;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
