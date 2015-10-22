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
        for ($i=0; $i <sizeof($clientes); $i++) { 
       $clientes[$i]->calle=$clientes[$i]->calle." #".$clientes[$i]->numero_exterior." ".$clientes[$i]->colonia." ".$clientes[$i]->municipio." ".$clientes[$i]->estado." ".$clientes[$i]->codigo_postal;
             
              $clientes[$i]->id_cliente='<a type="button" class="btn btn-primary margin" href="editarCliente/'. $clientes[$i]->id_cliente.'">Actualizar</a>';    
        }
        
        return $clientes;
    }
    
    public function editarCliente($id)
    {
        $cliente = Cliente::find($id);
        return view('vendedor.editarCliente',compact('cliente'));
    }
     public function actualizarCliente(Request $request,$id)
    {
        $cliente = Cliente::find($id);
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
            Session::flash('message','Datos actualizados  Correctamente');
            Session::flash('class','success');
        }else{
            Session::flash('message','Ha ocurrido un error');
            Session::flash('class','danger');
        }
       return  view('vendedor.editarCliente',compact('cliente'));
    }
    public function buscarCliente(Request $request){
            $valor = $request->input('nombre'); 

        $clientes = cliente::where('nombre', 'LIKE', '%'.$valor.'%')->take(5)->get();
        $results = array();
        foreach ($clientes as $cliente)
            {
                $results[] = [ 'id' => $cliente->id_cliente, 'value' => $cliente->nombre ];
            }
        return response()->json($results);
    }
    public function buscarIdCliente(Request $request){
           $id = $request->input('id');
         $cliente = Cliente::find($id);

        return $cliente->nombre;
    }
}
