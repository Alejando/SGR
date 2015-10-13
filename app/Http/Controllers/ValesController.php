<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Distribuidor;
use App\Vale;
use Session;
class ValesController extends Controller
{
   public function completarCampo(Request $request)
    {
        $distribuidor = $request->input('temp'); 

        $distris = Distribuidor::where('nombre', 'LIKE', '%'.$distribuidor.'%')->take(5)->get();
        $results = array();
        foreach ($distris as $distri)
            {
                $results[] = [ 'id' => $distri->id_distribuidor, 'value' => $distri->nombre ];
            }
        return response()->json($results);
    }


    public function crearVale()
    {

        return view('admin.crearVale');

    }

    public function guardarVale(Request $request)
    {
       
        $distri = $request->input('id_distribuidor');
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
                $vale->id_distribuidor=$distri;
                $vale->serie=$serie;
                $vale->folio=$i;
                $vale->cantidad_limite=Distribuidor::find($distri)->limite_vale;
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

    public function registrarVale(){
         return view('vendedor.registrarVale');
    }

    public function buscarVale(Request $request){
         
         $serie = $request->input('serie');
         $folio = $request->input('folio');
         $vale = Vale::where('serie',$serie)->where('folio', $folio)->get();

        return $vale;
    }

    public function buscarDistribuidor(Request $request){
         
         $id = $request->input('id');
         $distribuidor = Distribuidor::find($id);

        return $distribuidor->nombre;
    }
  
}
