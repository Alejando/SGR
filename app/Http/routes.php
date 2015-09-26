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

