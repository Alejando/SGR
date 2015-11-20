<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Distribuidor;
use App\Vale;
use App\Cliente;
use Carbon\Carbon;
class PdfController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function invoice() 
    {
        $data = $this->getData();
        $date = date('Y-m-d');
        $invoice = "2222";
        $view =  \View::make('invoice', compact('data', 'date', 'invoice'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('invoice');
    }

    public function getData() 
    {
        $data =  [
            'quantity'      => '1' ,
            'description'   => 'some ramdom text',
            'price'   => '500',
            'total'     => '500'
        ];
        return $data;
    }

    public function reporteR2($id,$fechaInicio,$fechaFin){

        $vales=Vale::where('id_distribuidor',$id)->whereBetween('fecha_inicio_pago',[$fechaInicio,$fechaFin]);
        


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


 
    public function fechaPagoCorte($fecha){

    }

}
