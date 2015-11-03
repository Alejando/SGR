<?php
use App\Pago;
use App\Cliente;
use App\Cuenta;
use App\Promocion;
use App\Vale;
use App\Distribuidor;

//----------------------------------------------------------//
//--------------------> RUTAS PUBLICAS <--------------------//
//----------------------------------------------------------//
Route::get('/','LoginController@mostrarLogin');
Route::get('sesion', 'LoginController@mostrarLogin');
Route::post('login','LoginController@login');
Route::get('logout','LoginController@logout');

//---------------> Grupos <----------------///
Route::group(['middleware' => 'mixto'], function () {

	Route::get('registrarVale', 'ValesController@registrarVale');
	Route::get('buscarVale', 'ValesController@buscarVale');
	Route::post('ventaVale', 'ValesController@ventaVale' );
	Route::get('consultarVales', 'ValesController@consultarVales' );

	Route::get('consultarPromociones', 'PromocionsController@consultarPromociones' );
	Route::get('buscarPromocion', 'PromocionsController@buscarPromocion');
	Route::get('fechaPago', 'PromocionsController@fechaPago');
	Route::get('obtenerPromociones', 'PromocionsController@obtenerPromociones' );
	
	Route::get('buscarIdDistribuidor', 'DistribuidorsController@buscarIdDistribuidor');
	Route::get('buscarDistribuidor', 'DistribuidorsController@completarCampo');

	Route::get('crearCliente', 'ClientesController@crearCliente');
	Route::post('guardarCliente', 'ClientesController@guardarCliente');
	Route::get('consultarClientes', 'ClientesController@consultarClientes' );
	Route::get('obtenerClientes', 'ClientesController@obtenerClientes' );
	Route::get('editarCliente/{id}', 'ClientesController@editarCliente');
	Route::post('actualizarCliente/{id}', 'ClientesController@actualizarCliente');
	Route::get('buscarCliente', 'ClientesController@buscarCliente');
	Route::get('buscarIdCliente', 'ClientesController@buscarIdCliente');
});
Route::group(['middleware' => 'admin'], function () {

	
});

Route::group(['middleware' => 'vendedor'], function () {
	Route::get('obtenerValesV', 'ValesController@obtenerValesV' );
});
Route::group(['middleware' => 'super_admin'], function () {
	
});

Route::group(['middleware' => 'super_y_admin'], function () {
	Route::get('crearCuentaVendedor', 'CuentasController@crearCuentaVendedor');
	Route::post('guardarCuentaVendedor', 'CuentasController@guardarCuentaVendedor');
	Route::get('consultarCuentasVendedor', 'CuentasController@consultarCuentasVendedor' );
	Route::get('obtenerCuentasVendedor', 'CuentasController@obtenerCuentasVendedor' );
	Route::get('editarCuentaVendedor/{id}', 'CuentasController@editarCuentaVendedor');
	Route::post('actualizarCuentaVendedor/{id}', 'CuentasController@actualizarCuentaVendedor');

	Route::get('crearComision', 'ComisionsController@crearComision');
	Route::post('guardarComision', 'ComisionsController@guardarComision');

	Route::get('crearVale', 'ValesController@crearVale');
   	Route::post('guardarVale', 'ValesController@guardarVale');
   	Route::get('obtenerVales', 'ValesController@obtenerVales' );
   	Route::get('obtenerUltimoVale', 'ValesController@obtenerUltimoVale' );
   	Route::get('editarVale/{id}', 'ValesController@editarVale');
	Route::post('actualizarVale/{id}', 'ValesController@actualizarVale');

   	Route::get('crearPromocion', 'PromocionsController@crearPromocion');
	Route::post('guardarPromocion', 'PromocionsController@guardarPromocion');

	Route::get('crearDistribuidor', 'DistribuidorsController@crearDistribuidor');
	Route::post('guardarDistribuidor', 'DistribuidorsController@guardarDistribuidor');
});



