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
          $movimientos[$i]->estado_anterior=$this->movimientoBonito( $movimientos[$i]->estado_anterior);
           $movimientos[$i]->estado_actual=$this->movimientoBonito( $movimientos[$i]->estado_actual);
        }    
        return $movimientos;
    }

    public function movimientoBonito($movimiento){
      
        $movimiento=str_replace('"','',$movimiento);
        $movimiento=str_replace('{','',$movimiento);
        $movimiento=str_replace('}','',$movimiento);
      $inicio=strpos($movimiento,'created_at');
      $movimiento=iconv_substr($movimiento,0,$inicio);
        $movimiento=str_replace(',',' | ',$movimiento);
           return $movimiento;
    }
    public function consultarMovimientos()
    {
        return view('s_admin.consultarMovimientos');
    }

    
}
