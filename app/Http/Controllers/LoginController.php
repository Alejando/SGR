<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Redirect;
use App\Http\Requests;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Cuenta;
use Session;

class LoginController extends Controller
{
    public function mostrarLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
    	$usuario = strtoupper($request->input('usuario'));
    	$contrasena = strtoupper($request->input('contrasena'));

    	$cuentas = Cuenta::all();

    	foreach ($cuentas as $cuenta)
    	{
    		if(($cuenta->usuario == $usuario) && ($cuenta->contrasena == $contrasena))
    		{
    			Session::put('id', $cuenta->id_cuenta );
    			Session::put('nombre', $cuenta->nombre );
    			Session::put('tipo', $cuenta->tipo );

    			switch ($cuenta->tipo) {
				    case 0:
				        return redirect('crearCuenta');
				    	//return ("Eres un super administrador");
				        break;
				    case 1:
				        return redirect('crearVale');
				    	//return ("Eres un administrador");
				        break;
				    case 2:
				        return redirect('registrarVale');
				    	//return ("Eres un vendedor");
				        break;
				}
    		}

    	}
    	Session::flash('message','El usuario o contraseña no son validos');
        Session::flash('class','danger');
    	return redirect('sesion');
    }

    public function logout()
    {
    	Session::flush();
        return redirect("sesion");
    }
    
}
