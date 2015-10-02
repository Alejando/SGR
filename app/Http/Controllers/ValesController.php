<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Distribuidor;

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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function guardarVale(Request $request)
    {
        $vale = new Vale;
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
       
        $file = $request->file('foto');
        $nombreFoto='foto'.$nombre.'.'.$file->getClientOriginalExtension();
        $distribuidor->foto=$nombreFoto;
      
       $file = $request->file('firma');
        $nombreFirma='firma'.$nombre.'.'.$file->getClientOriginalExtension();
        $distribuidor->firma=$nombreFirma;
        ;
        
       

        if($distribuidor->save()){
            \Storage::disk('local')->put($nombreFoto,  \File::get($file));
            \Storage::disk('local')->put($nombreFirma,  \File::get($file));
            Session::flash('message','Guardado Correctamente');
            Session::flash('class','success');
        }else{
            Session::flash('message','Ha ocurrido un error');
            Session::flash('class','danger');
        }
       return view('distribuidor.crearDistribuidor');
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
