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


//----------------------------------------------------------//
//---------------> RUTAS SUPER-ADMINISTRADOR <--------------//
//----------------------------------------------------------//