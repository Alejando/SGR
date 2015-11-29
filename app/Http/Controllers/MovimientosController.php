<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Movimiento;
use App\Cuenta;

class MovimientosController extends Controller
{
    


    public function obtenerMovimientos()
    {
        $movimientos= Movimiento::all();

         for ($i=0; $i <sizeof($movimientos); $i++) { 

             $cuenta=Movimiento::find($movimientos[$i]->id_movimiento)->cuenta->nombre;
             $movimientos[$i]->id_cuenta=$cuenta;
          
          switch ($movimientos[$i]->tipo) { //1:vales 2:cuentas 3:pagos 4:distribuidores 5:comisiones
                case '1':
                 $movimientos[$i]->tipo="Vales";
                break;
                case '2':
                 $movimientos[$i]->tipo="Cuentas";
                break;
                case '3':
                 $movimientos[$i]->tipo="Pagos";
                break;
                case '4':
                 $movimientos[$i]->tipo="Distribuidores";
                break;
                case '5':
                 $movimientos[$i]->tipo="Comisiones";
                break;
              
             
          }
        }    
        return $movimientos;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function consultarMovimientos()
    {
        return view('s_admin.consultarMovimientos');
    }

    
}