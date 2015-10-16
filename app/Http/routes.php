<?php
use App\Pago;
use App\Cliente;
use App\Cuenta;
use App\Promocion;
use App\Vale;
use App\Distribuidor;


//----------------------------------------------------------//
//--------------------> RUTAS VENDEDOR <--------------------//
//----------------------------------------------------------//

//******************* CLASE CLIENTE *******************//
Route::get('crearCliente', 'ClientesController@crearCliente');
Route::post('guardarCliente', 'ClientesController@guardarCliente');
Route::get('consultarClientes', 'ClientesController@consultarClientes' );
Route::get('obtenerClientes', 'ClientesController@obtenerClientes' );

//----------------------------------------------------------//
//--------------------> RUTAS ADMINISTRADOR <---------------//
//----------------------------------------------------------//

//******************* CLASE DISTRIBUIDOR *******************//
Route::get('crearDistribuidor', 'DistribuidorsController@crearDistribuidor');
Route::post('guardarDistribuidor', 'DistribuidorsController@guardarDistribuidor');

//******************* CLASE VALE *******************//
Route::get('crearVale', 'ValesController@crearVale');
Route::get('completarCampo', 'ValesController@completarCampo');
Route::post('guardarVale', 'ValesController@guardarVale');
Route::get('registrarVale', 'ValesController@registrarVale');
Route::get('buscarVale', 'ValesController@buscarVale');
Route::get('buscarIdDistribuidor', 'ValesController@buscarIdDistribuidor');
Route::get('buscarCliente', 'ValesController@buscarCliente');
Route::get('buscarIdCliente', 'ValesController@buscarIdCliente');

//******************* CLASE PROMOCION *******************//
Route::get('crearPromocion', 'PromocionsController@crearPromocion');
Route::post('guardarPromocion', 'PromocionsController@guardarPromocion');
Route::get('buscarPromocion', 'PromocionsController@buscarPromocion');

//******************* CLASE CUENTA *******************//
Route::get('crearCuentaVendedor', 'CuentasController@crearCuentaVendedor');


//----------------------------------------------------------//
//---------------> RUTAS SUPER-ADMINISTRADOR <--------------//
//----------------------------------------------------------//