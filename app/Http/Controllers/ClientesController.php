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
       switch (Session::get('tipo')) {
            case 0:
              return view('s_admin.crearCliente');
                break;
            case 1:
                return view('admin.crearCliente');
                break;
            case 2:
                 return view('vendedor.crearCliente');
                break;
        }   
    }

    public function guardarCliente(Request $request)
    {
        $cliente = new Cliente;
        $cliente->nombre = strtoupper($request->input('nombre'));
        $cliente->telefono = $request->input('telefono');
        $cliente->celular = $request->input('celular');
        $cliente->numero_elector = $request->input('numero_elector');
        $cliente->calle = strtoupper($request->input('calle'));
        $cliente->numero_exterior = $request->input('numero_exterior');
        $cliente->numero_interior = $request->input('numero_interior');
        $cliente->colonia = strtoupper($request->input('colonia'));
        $cliente->municipio = strtoupper($request->input('municipio'));
        $cliente->estado = strtoupper($request->input('estado'));
        $cliente->codigo_postal = $request->input('codigo_postal');
       
        


        if($cliente->save()){
            Session::flash('message','Guardado Correctamente');
            Session::flash('class','success');
        }else{
            Session::flash('message','Ha ocurrido un error');
            Session::flash('class','danger');
        }
       switch (Session::get('tipo')) {
            case 0:
               return view('s_admin.crearCliente');
                break;
            case 1:
                return view('admin.crearCliente');
                break;
            case 2:
                 return view('vendedor.crearCliente');
                break;
        }
    }

    public function consultarClientes()
    {
        switch (Session::get('tipo')) {
            case 0:
               return view('s_admin.consultarClientes');
                break;
            case 1:
                return view('admin.consultarClientes');
                break;
            case 2:
                 return view('vendedor.consultarClientes');
                break;
        }
    }

    public function obtenerClientes()
    {
        $clientes = Cliente::all();
        for ($i=0; $i <sizeof($clientes); $i++) { 
            $clientes[$i]->calle=$clientes[$i]->calle." #".$clientes[$i]->numero_exterior." ".$clientes[$i]->colonia." ".$clientes[$i]->municipio." ".$clientes[$i]->estado." ".$clientes[$i]->codigo_postal; 
            $clientes[$i]->id_cliente='<a type="button" class="btn btn-primary margin" href="editarCliente/'. $clientes[$i]->id_cliente.'">Actualizar</a>';    
        }
        
        return $clientes;
    }
    
    public function editarCliente($id)
    {
        $cliente = Cliente::find($id);
        switch (Session::get('tipo')) {
            case 0:
              return view('s_admin.editarCliente',compact('cliente'));
                break;
            case 1:
                return view('admin.editarCliente',compact('cliente'));
                break;
            case 2:
                 return view('vendedor.editarCliente',compact('cliente'));
                break;
        }        
    }
    
     public function actualizarCliente(Request $request,$id)
    {
        $cliente = Cliente::find($id);
        $cliente->nombre = strtoupper($request->input('nombre'));
        $cliente->telefono = $request->input('telefono');
        $cliente->celular = $request->input('celular');
        $cliente->numero_elector = $request->input('numero_elector');
        $cliente->calle = strtoupper($request->input('calle'));
        $cliente->numero_exterior = $request->input('numero_exterior');
        $cliente->numero_interior = $request->input('numero_interior');
        $cliente->colonia = strtoupper($request->input('colonia'));
        $cliente->municipio = strtoupper($request->input('municipio'));
        $cliente->estado = strtoupper($request->input('estado'));
        $cliente->codigo_postal = $request->input('codigo_postal');
        

        if($cliente->save()){
            Session::flash('message','Datos actualizados  Correctamente');
            Session::flash('class','success');
        }else{
            Session::flash('message','Ha ocurrido un error');
            Session::flash('class','danger');
        }
       switch (Session::get('tipo')) {
            case 0:
                 return redirect('consultarClientes');
                break;
            case 1:
                return redirect('consultarClientes');
                break;
            case 2:
                 return redirect('consultarClientes');
                break;
        }  
    }
    public function buscarCliente(Request $request){
       $valor = $request->input('term'); 
        $clientes = Cliente::where('nombre', 'LIKE', '%'.$valor.'%')->orWhere('id_cliente', 'LIKE', '%'.$valor.'%')->take(5)->get();
        $results = array();
        foreach ($clientes as $cliente)
            {
                 $cadena=$cliente->id_cliente.".-".$cliente->nombre; // cadena conjunta de id y nombre
                 $results[] = [ 'id' => $cliente->id_cliente, 'value' => $cadena ];
            }
        return $results;
    }

    public function buscarIdCliente(Request $request){
        $id = $request->input('id');
        $cliente = Cliente::find($id);

        return $cliente->nombre;
    }
}
