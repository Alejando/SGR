<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Distribuidor;
use Session;
use App\Movimiento;
use Carbon\Carbon;
class DistribuidorsController extends Controller
{
    


    public function crearDistribuidor()
    {   
         switch (Session::get('tipo')) {
            case 0:
               return view('s_admin.crearDistribuidor');
                break;
            case 1:
                 return view('admin.crearDistribuidor');
                break;
        }  
       
    }

 
    public function guardarDistribuidor(Request $request)
    {
        $distribuidor = new Distribuidor;
        $distribuidor->nombre = strtoupper($request->input('nombre'));
        $distribuidor->calle = strtoupper($request->input('calle'));
        $distribuidor->numero_exterior = $request->input('numero_exterior');
        $distribuidor->municipio = strtoupper($request->input('municipio'));
        $distribuidor->codigo_postal = $request->input('codigo_postal');
        $distribuidor->celular = $request->input('celular');
        $distribuidor->colonia = strtoupper($request->input('colonia'));
        $distribuidor->numero_interior = $request->input('numero_interior');
        $distribuidor->estado = strtoupper($request->input('estado'));
        $distribuidor->telefono = $request->input('telefono');
        $distribuidor->nombre_aval = strtoupper($request->input('nombre_aval'));
        $distribuidor->calle_aval = strtoupper($request->input('calle_aval'));
        $distribuidor->numero_exterior_aval = $request->input('numero_exterior_aval');
        $distribuidor->municipio_aval = strtoupper($request->input('municipio_aval'));
        $distribuidor->codigo_postal_aval = $request->input('codigo_postal_aval');
        $distribuidor->celular_aval = $request->input('celular_aval');
        $distribuidor->colonia_aval = strtoupper($request->input('colonia_aval'));
        $distribuidor->numero_interior_aval = $request->input('numero_interior_aval');
        $distribuidor->estado_aval = strtoupper($request->input('estado_aval'));
        $distribuidor->telefono_aval = $request->input('telefono_aval');
        $distribuidor->limite_credito = $request->input('limite_credito');
        $distribuidor->limite_vale = $request->input('limite_vale');
       
        

        $fileFirma = $request->file('firma');
        if($fileFirma)
        {
            $nombreFirma='FIRMA_'.$distribuidor->nombre.'.'.$fileFirma->getClientOriginalExtension();
            $distribuidor->firma=$nombreFirma;
            \Storage::disk('local')->put($nombreFirma,  \File::get($fileFirma));  
        }else{
            $distribuidor->firma='firma_default.jpg';
        }
        
        
        $fileFoto = $request->file('foto');
        if($fileFoto)
        {
            $nombreFoto='FOTO_'.$distribuidor->nombre.'.'.$fileFoto->getClientOriginalExtension();
            $distribuidor->foto=$nombreFoto;
            \Storage::disk('local')->put($nombreFoto,  \File::get($fileFoto));
        }else{
            $distribuidor->foto='foto_default.jpg';
        }
        
       

        if($distribuidor->save()){
            Session::flash('message','Guardado Correctamente');
            Session::flash('class','success');
        }else{
            Session::flash('message','Ha ocurrido un error');
            Session::flash('class','danger');
        }
       switch (Session::get('tipo')) {
            case 0:
               return redirect('s_admin.crearDistribuidor');
                break;
            case 1:
                 return redirect('admin.crearDistribuidor');
                break;
        }  
    }
    public function buscarIdDistribuidor(Request $request){
         
         $id = $request->input('id');
         $distribuidor = Distribuidor::find($id);

        return $distribuidor->nombre;
    }
    public function buscarDistribuidor(Request $request)
    {
        $valor = $request->input('term');
        $distris = Distribuidor::where('nombre', 'LIKE', '%'.$valor.'%')->orWhere('id_distribuidor', 'LIKE', '%'.$valor.'%')->take(5)->get();
        $results = array();

        foreach ($distris as $distri)
        {
                $cadena=$distri->id_distribuidor.".-".$distri->nombre; // cadena conjunta de id y nombre
                 $results[] = [ 'id' => $distri->id_distribuidor, 'value' => $cadena ];
        }
        return $results;
    }

    public function consultarDistribuidores()
    {
    
        switch (Session::get('tipo')) {
            case 0:
                return view('s_admin.consultarDistribuidores');
                break;
            case 1:
                return view('admin.consultarDistribuidores');
                break;
        }  
    }

    public function obtenerDistribuidores()
    {
        $distribuidores = Distribuidor::all();
        for ($i=0; $i <sizeof($distribuidores); $i++) 
        {
            
            //$distribuidores[$i]->calle=$distribuidores[$i]->calle." #".$distribuidores[$i]->numero_exterior." ".$distribuidores[$i]->colonia." ".$distribuidores[$i]->municipio." ".$distribuidores[$i]->estado." ".$distribuidores[$i]->codigo_postal; 
            $distribuidores[$i]->acciones = '<a type="button" class="btn btn-success margin" href="verDistribuidor/'. $distribuidores[$i]->id_distribuidor .'">Ver</a> <a type="button" class="btn btn-primary margin" href="editarDistribuidor/'. $distribuidores[$i]->id_distribuidor .'">Actualizar</a>';    
        }
        
        return $distribuidores;
    }

    public function editarDistribuidor($id)
    {
        $distribuidor = Distribuidor::find($id);

        switch (Session::get('tipo')) {
            case 0:
                return view('s_admin.editarDistribuidor',compact('distribuidor'));      
                break;
            case 1:
                 return view('admin.editarDistribuidor',compact('distribuidor'));      
                break;
        }  
        
    }

    public function actualizarDistribuidor(Request $request,$id)
    {

        $distribuidor = Distribuidor::find($id);
        $distribuidorMovimiento= (string)$distribuidor;
        $distribuidor->nombre = strtoupper($request->input('nombre'));
        $distribuidor->calle = strtoupper($request->input('calle'));
        $distribuidor->numero_exterior = $request->input('numero_exterior');
        $distribuidor->municipio = strtoupper($request->input('municipio'));
        $distribuidor->codigo_postal = $request->input('codigo_postal');
        $distribuidor->celular = $request->input('celular');
        $distribuidor->colonia = strtoupper($request->input('colonia'));
        $distribuidor->numero_interior = $request->input('numero_interior');
        $distribuidor->estado = strtoupper($request->input('estado'));
        $distribuidor->telefono = $request->input('telefono');
        $distribuidor->nombre_aval = strtoupper($request->input('nombre_aval'));
        $distribuidor->calle_aval = strtoupper($request->input('calle_aval'));
        $distribuidor->numero_exterior_aval = $request->input('numero_exterior_aval');
        $distribuidor->municipio_aval = strtoupper($request->input('municipio_aval'));
        $distribuidor->codigo_postal_aval = $request->input('codigo_postal_aval');
        $distribuidor->celular_aval = $request->input('celular_aval');
        $distribuidor->colonia_aval = strtoupper($request->input('colonia_aval'));
        $distribuidor->numero_interior_aval = $request->input('numero_interior_aval');
        $distribuidor->estado_aval = strtoupper($request->input('estado_aval'));
        $distribuidor->telefono_aval = $request->input('telefono_aval');
        $distribuidor->limite_credito = $request->input('limite_credito');
        $distribuidor->limite_vale = $request->input('limite_vale');
       
        
        
      
        $fileFirma = $request->file('firma');
        if($fileFirma)
        {
            $nombreFirma='FIRMA_'.$distribuidor->nombre.'.'.$fileFirma->getClientOriginalExtension();
            $distribuidor->firma=$nombreFirma;
            \Storage::disk('local')->put($nombreFirma,  \File::get($fileFirma));  
        }
        
        
        $fileFoto = $request->file('foto');
        if($fileFoto)
        {
            $nombreFoto='FOTO_'.$distribuidor->nombre.'.'.$fileFoto->getClientOriginalExtension();
            $distribuidor->foto=$nombreFoto;
            \Storage::disk('local')->put($nombreFoto,  \File::get($fileFoto));
        }





        if($distribuidor->save()){
            $movimiento= new Movimiento;
            $movimiento->id_cuenta=Session::get('id');
            $movimiento->fecha=Carbon::today();
            $movimiento->estado_anterior=$distribuidorMovimiento;
            $movimiento->estado_actual=(string)Distribuidor::find($id);
            $movimiento->tipo=4; // 1:vales 2:cuentas 3:pagos 4:distribuidores 5:comisiones
            $movimiento->save();
            Session::flash('message','Guardado Correctamente');
            Session::flash('class','success');
        }else{
            Session::flash('message','Ha ocurrido un error');
            Session::flash('class','danger');
        }
      
      
       return redirect('consultarDistribuidores');
    }

    public function verDistribuidor($id)
    {
      
        $distribuidor = Distribuidor::find($id);
        switch (Session::get('tipo')) {
            case 0:
              return view('s_admin.verDistribuidor',compact('distribuidor'));
                break;
            case 1:
                return view('admin.verDistribuidor',compact('distribuidor'));
                break;
                
            
        } 
    }
    public function reporteCobranza()
    {   
         switch (Session::get('tipo')) {
            case 0:
               return view('s_admin.reporteCobranza');
                break;
            case 1:
                 return view('admin.reporteCobranza');
                break;
        }  
    }

    public function emitirReporteCobranza()
    {   

        $id=2;
         $vales=Vale::where('id_distribuidor',$id)->whereBetween('fecha_inicio_pago',[$fechaInicio,$fechaFin]);


    }


}
