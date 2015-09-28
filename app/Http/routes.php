<?php
use App\Pago;
use App\Cliente;
use App\Cuenta;
use App\Promocion;
use App\Vale;
use App\Distribuidor;
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Rutas de  los administradores  //

Route::get('crearDistribuidor', 'DistribuidorsController@crearDistribuidor');
Route::post('guardarDistribuidor', 'DistribuidorsController@guardarDistribuidor');

Route::get('/', function () {
    return view('welcome');
});

Route::get('admin', function () {
    return view('m_admin');
});
Route::get('vendedor', function () {
    return view('m_vendedor');
});
Route::get('login', function () {
    return view('c_sesion');
});
<<<<<<< HEAD
=======

>>>>>>> 6498a0304767f61823889bd55eb6ea979e8738e7




<<<<<<< HEAD
=======
//----------------------------------------------------------//
//---------------------> URL TEST DATA <--------------------//
//----------------------------------------------------------//

>>>>>>> 6498a0304767f61823889bd55eb6ea979e8738e7
Route::get('clientes', function () {
    $clientes = Cliente::all();

    return ($clientes);
});

Route::get('distribuidores', function () {
    $distribuidores = Distribuidor::all();

    return ($distribuidores);
});

Route::get('pagos', function () {
    $pagos = Pago::all();

    return ($pagos);
});

Route::get('cuentas', function () {
    $cuentas = Cuenta::all();

    return ($cuentas);
});

Route::get('vales', function () {
    $vales = Vale::all();

    return ($vales);
});

Route::get('promociones', function () {
    $promociones = Promocion::all();

    return ($promociones);
});


Route::get('prueba', function()
{
	//--------------------------------------------------------------------------------------------------
	//Pruebas para la relacion de 1 - * de pagos y distribuidores (Aprobada)
	$calle_distribuidor = Pago::find(1)->distribuidor->calle;
	$pagos = Distribuidor::find(1)->pagos;

	//Pruebas para la relacion de 1 - * de pagos y cuenta (Aprobada)
	$nombre_cuenta = Pago::find(1)->cuenta->nombre;
	$pagos_cuenta = Cuenta::find(1)->pagos;

	//Pruebas para la relacion de 1 - * de vales y cuenta (Aprobada)
	$usuario_cuenta = Vale::find(1)->cuenta->usuario;
	$vales_cuenta = Cuenta::find(2)->vales;

	//Pruebas para la relacion de 1 - * de vales y distribuidor (Aprobada)
	$vales_distribuidor = Distribuidor::find(1)->vales;
	$colonia_distribuidor = Vale::find(1)->distribuidor->colonia;

	//Pruebas para la relacion de 1 - * de vales y clientes (Aprobada)
	$vales_cliente = Cliente::find(1)->vales;
	$telefono_cliente = Vale::find(1)->cliente->telefono;

	//Pruebas para la relacion de 1 - * de vales y promociones (Aprobada)
	$vales_promocion = Promocion::find(1)->vales;
	$fecha_termino = Vale::find(1)->promocion->fecha_termino;
	
	

	return ("Holi--->".$fecha_termino);
});
