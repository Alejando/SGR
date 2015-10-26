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

    /*public function login(Request $request)
    {
       if(Auth::attempt(['email' => $request['usuario'], 'password' => $request['contrasena']]))
       {
       	 return ("Entro");
       }else{
       	return ("Ni madres");
       }
    }*/

    public function login(Request $request)
    {
    	$usuario = $request->input('usuario');
    	$contrasena = $request->input('contrasena');

    	$cuentas = Cuenta::all();

    	foreach ($cuentas as $cuenta)
    	{
    		if(($cuenta->usuario == $usuario) && ($cuenta->contrasena == $contrasena))
    		{
    			Session::put('id', $cuenta->id );
    			Session::put('nombre', $cuenta->nombre );
    			Session::put('tipo', $cuenta->tipo );

    			switch ($cuenta->tipo) {
				    case 0:
				        //return redirect('');
				    	return ("Eres un super administrador");
				        break;
				    case 1:
				        //return redirect('');
				    	return ("Eres un administrador");
				        break;
				    case 2:
				        //return redirect('');
				    	return ("Eres un vendedor");
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
        return "exit";
    }
    
}
