<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Comision;
use Session;
use Redirect;
use App\Movimiento;
use Carbon\Carbon;


class ComisionsController extends Controller
{
    public function crearComision()
    {
        return view('admin.crearComision');
    }

     public function guardarComision(Request $request)
    {
        $comisionNueva = new Comision;
        $comisionNueva->cantidad_inicial = $request->input('cantidad_inicial');
        $comisionNueva->cantidad_final = $request->input('cantidad_final');
        $comisionNueva->porcentaje = $request->input('porcentaje');

        $comisiones = Comision::all();
         foreach ($comisiones as $comision)
            {
                if(($comisionNueva->cantidad_inicial >= $comision->cantidad_inicial && $comisionNueva->cantidad_inicial <= $comision->cantidad_final ) ||  ($comisionNueva->cantidad_final >= $comision->cantidad_inicial && $comisionNueva->cantidad_final <= $comision->cantidad_final )) 
                {
                    $comision_repetida = $comision;
                    $Repetida = true;
                    break;
                }else{
                   $Repetida = false; 
                }
            }

        if($comisionNueva->porcentaje >= 50)
        {
            Session::flash('message','El porcentaje de comisión no puede ser mayor al 50%');
            Session::flash('class','danger'); 
        }
        else
        {
            if($comisionNueva->cantidad_inicial < 0 || $comisionNueva->cantidad_final < 0 )
            {
                Session::flash('message','Las cantidades no pueden ser menores a cero');
                Session::flash('class','danger');
            }
            else
            {
                if($comisionNueva->cantidad_final <= $comisionNueva->cantidad_inicial)
                {
                    Session::flash('message','La cantidad final no puede ser menor o igual a la cantidad inicial');
                    Session::flash('class','danger');
                }else
                {
                    if($Repetida)
                    {
                        Session::flash('message','Las cantidades ingresadas ya se encuentran en el rango de una comisión que va de '. $comision_repetida->cantidad_inicial .' a '. $comision_repetida->cantidad_final );
                        Session::flash('class','danger');
                    }else
                        {
                            if($comisionNueva->save())
                            {
                                Session::flash('message','Guardado Correctamente');
                                Session::flash('class','success');
                            }else{
                                Session::flash('message','Ha ocurrido un error');
                                Session::flash('class','danger');
                            }
                        }
                }
            }
        }

       return redirect('crearComision');
    }

    public function consultarComisiones()
    {
    
        switch (Session::get('tipo')) {
            case 0:
               return view('s_admin.consultarComisiones');
                break;
            case 1:
                return view('admin.consultarComisiones');
                break;
        }  
    }

    public function obtenerComisiones()
    {
        $comisiones = Comision::all();
        for ($i=0; $i <sizeof($comisiones); $i++) 
        {
            $comisiones[$i]->porcentaje = $comisiones[$i]->porcentaje.' %';
            $comisiones[$i]->id_comision = '<a type="button" class="btn btn-primary margin" href="editarComision/'. $comisiones[$i]->id_comision .'">Actualizar</a>';    
        }
        
        return $comisiones;
    }

    public function editarComision($id)
    {
        $comision = Comision::find($id);
        switch (Session::get('tipo')) {
            case 0:
              return view('s_admin.consultarComisiones');
                break;
            case 1:
                return view('admin.consultarComisiones');
                break;
            
        }        
    }

    public function actualizarComision(Request $request,$id)
    {
        $comisionEditada = Comision::find($id);
        $comisionMovimiento=(string)$comisionEditada;
        $comisionEditada->cantidad_inicial = $request->input('cantidad_inicial');
        $comisionEditada->cantidad_final = $request->input('cantidad_final');
        $comisionEditada->porcentaje = $request->input('porcentaje');

        
        $comisiones = Comision::all();
        for($i=0; $i<count($comisiones); $i++)
            {
                if($comisionEditada->id_comision != $comisiones[$i]->id_comision)
                {
                    $NuevasComisiones[$i] = $comisiones[$i];
                }
            }

        //return $NuevasComisiones; 
               
        foreach ($NuevasComisiones as $NuevaComision)
            {
                if(($comisionEditada->cantidad_inicial >= $NuevaComision->cantidad_inicial && $comisionEditada->cantidad_inicial <= $NuevaComision->cantidad_final ) ||  ($comisionEditada->cantidad_final >= $NuevaComision->cantidad_inicial && $comisionEditada->cantidad_final <= $NuevaComision->cantidad_final )) 
                {
                    $comision_repetida = $NuevaComision;
                    $Repetida = true;
                    break;
                }else{
                   $Repetida = false; 
                }
            }

        if($comisionEditada->porcentaje >= 50)
        {
            Session::flash('message','El porcentaje de comisión no puede ser mayor al 50%');
            Session::flash('class','danger'); 
        }
        else
        {
            if($comisionEditada->cantidad_inicial < 0 || $comisionEditada->cantidad_final < 0 )
            {
                Session::flash('message','Las cantidades no pueden ser menores a cero');
                Session::flash('class','danger');
            }
            else
            {
                if($comisionEditada->cantidad_final <= $comisionEditada->cantidad_inicial)
                {
                    Session::flash('message','La cantidad final no puede ser menor o igual a la cantidad inicial');
                    Session::flash('class','danger');
                }else
                {
                    if($Repetida)
                    {
                        Session::flash('message','Las cantidades ingresadas ya se encuentran en el rango de una comisión que va de '. $comision_repetida->cantidad_inicial .' a '. $comision_repetida->cantidad_final );
                        Session::flash('class','danger');
                    }else
                        {
                            if($comisionEditada->save())
                            {
                                $movimiento= new Movimiento;
                                $movimiento->id_cuenta=Session::get('id');
                                $movimiento->fecha=Carbon::today();
                                $movimiento->estado_anterior=$comisionMovimiento;
                                $movimiento->estado_actual=(string)Comision::find($id);
                                $movimiento->tipo=5; // 1:vales 2:cuentas 3:pagos 4:distribuidores 5:comisiones
                                $movimiento->save();
                                Session::flash('message','Guardado Correctamente');
                                Session::flash('class','success');
                            }else{
                                Session::flash('message','Ha ocurrido un error');
                                Session::flash('class','danger');
                            }
                        }
                }
            }
        }

       switch (Session::get('tipo')) {
            case 0:
              return redirect('s_admin.consultarComisiones');
                break;
            case 1:
                return redirect('admin.consultarComisiones');
                break;
            
        }        
       
    }
}
