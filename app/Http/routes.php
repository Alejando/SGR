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

//----------------------------------------------------------//
//--------------------> RUTAS REPORTES <--------------------//
//----------------------------------------------------------//
Route::get('pdf', 'PdfController@invoice');
<<<<<<< HEAD
Route::get('R1', 'PdfController@reporte_1');

=======
Route::get('reporteCobranzaPDF', 'PdfController@reporteCobranzaPDF');
>>>>>>> origin/master
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

	Route::get('consultarMovimientos', 'MovimientosController@consultarMovimientos');
	Route::get('obtenerMovimientos', 'MovimientosController@obtenerMovimientos');
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

	Route::get('reporteCobranza', 'DistribuidorsController@reporteCobranza');
	Route::get('emitirReporteCobranza', 'DistribuidorsController@emitirReporteCobranza');
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
	$usuario_cuenta = Vale::find(80)->cuenta->usuario;
	$vales_cuenta = Cuenta::find(2)->vales;

	//Pruebas para la relacion de 1 - * de vales y distribuidor (Aprobada)
	$vales_distribuidor = Distribuidor::find(1)->vales;
	$colonia_distribuidor = Vale::find(80)->distribuidor->colonia;

	//Pruebas para la relacion de 1 - * de vales y clientes (Aprobada)
	$vales_cliente = Cliente::find(1)->vales;
	$telefono_cliente = Vale::find(80)->cliente->nombre;

	//Pruebas para la relacion de 1 - * de vales y promociones (Aprobada)
	//$vales_promocion = Promocion::find(33)->vales;
	//$fecha_termino = Vale::find(80)->promocion->fecha_termino;
	
	
	return ("Holi--->".$telefono_cliente);
});
