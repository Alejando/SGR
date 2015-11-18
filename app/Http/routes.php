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
Route::get('pdf', 'PdfController@invoice');

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
	Route::get('buscarDistribuidor', 'DistribuidorsController@buscarDistribuidor');

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
	Route::get('crearCuenta', 'CuentasController@crearCuenta');
	Route::post('guardarCuenta', 'CuentasController@guardarCuenta');
	Route::get('consultarCuentas', 'CuentasController@consultarCuentas' );
	Route::get('obtenerCuentas', 'CuentasController@obtenerCuentas' );
	Route::get('editarCuenta/{id}', 'CuentasController@editarCuenta');
	Route::post('actualizarCuenta/{id}', 'CuentasController@actualizarCuenta');
});

Route::group(['middleware' => 'super_y_admin'], function () {
	Route::get('crearCuentaVendedor', 'CuentasController@crearCuentaVendedor');
	Route::post('guardarCuentaVendedor', 'CuentasController@guardarCuentaVendedor');
	Route::get('consultarCuentasVendedor', 'CuentasController@consultarCuentasVendedor' );
	Route::get('obtenerCuentasVendedor', 'CuentasController@obtenerCuentasVendedor' );
	Route::get('editarCuentaVendedor/{id}', 'CuentasController@editarCuentaVendedor');
	Route::post('actualizarCuentaVendedor/{id}', 'CuentasController@actualizarCuentaVendedor');
	Route::get('buscarIdCuenta', 'CuentasController@buscarIdCuenta');
	Route::get('buscarCuenta', 'CuentasController@buscarCuenta');

	Route::get('crearComision', 'ComisionsController@crearComision');
	Route::post('guardarComision', 'ComisionsController@guardarComision');
	Route::get('consultarComisiones', 'ComisionsController@consultarComisiones' );
	Route::get('obtenerComisiones', 'ComisionsController@obtenerComisiones' );
	Route::get('editarComision/{id}', 'ComisionsController@editarComision');
	Route::post('actualizarComision/{id}', 'ComisionsController@actualizarComision');

	Route::get('crearVale', 'ValesController@crearVale');
   	Route::post('guardarVale', 'ValesController@guardarVale');
   	Route::get('obtenerVales', 'ValesController@obtenerVales' );
   	Route::get('obtenerUltimoVale', 'ValesController@obtenerUltimoVale' );
   	Route::get('editarVale/{id}', 'ValesController@editarVale');
	Route::post('actualizarVale/{id}', 'ValesController@actualizarVale');
	Route::post('modificarVale', 'ValesController@modificarVale');

   	Route::get('crearPromocion', 'PromocionsController@crearPromocion');
	Route::post('guardarPromocion', 'PromocionsController@guardarPromocion');
	Route::get('editarPromocion/{id}', 'PromocionsController@editarPromocion');
	Route::post('actualizarPromocion/{id}', 'PromocionsController@actualizarPromocion');

	Route::get('crearDistribuidor', 'DistribuidorsController@crearDistribuidor');
	Route::post('guardarDistribuidor', 'DistribuidorsController@guardarDistribuidor');
	Route::get('consultarDistribuidores', 'DistribuidorsController@consultarDistribuidores' );
	Route::get('obtenerDistribuidores', 'DistribuidorsController@obtenerDistribuidores' );
	Route::get('editarDistribuidor/{id}', 'DistribuidorsController@editarDistribuidor');
	Route::post('actualizarDistribuidor/{id}', 'DistribuidorsController@actualizarDistribuidor');
	Route::get('verDistribuidor/{id}', 'DistribuidorsController@verDistribuidor');
});
