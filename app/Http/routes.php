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
Route::get('editarCliente/{id}', 'ClientesController@editarCliente');
Route::post('actualizarCliente/{id}', 'ClientesController@actualizarCliente');
Route::get('buscarCliente', 'ClientesController@buscarCliente');
Route::get('buscarIdCliente', 'ClientesController@buscarIdCliente');

//----------------------------------------------------------//
//--------------------> RUTAS ADMINISTRADOR <---------------//
//----------------------------------------------------------//

//******************* CLASE DISTRIBUIDOR *******************//
Route::get('crearDistribuidor', 'DistribuidorsController@crearDistribuidor');
Route::post('guardarDistribuidor', 'DistribuidorsController@guardarDistribuidor');
Route::get('buscarIdDistribuidor', 'DistribuidorsController@buscarIdDistribuidor');
Route::get('buscarDistribuidor', 'DistribuidorsController@completarCampo');

//******************* CLASE VALE *******************//
Route::get('crearVale', 'ValesController@crearVale');
Route::post('guardarVale', 'ValesController@guardarVale');
Route::get('registrarVale', 'ValesController@registrarVale');
Route::get('buscarVale', 'ValesController@buscarVale');
Route::get('consultarVales', 'ValesController@consultarVales' );
Route::get('consultarValesV', 'ValesController@consultarValesV' );
Route::get('obtenerVales', 'ValesController@obtenerVales' );
Route::get('obtenerValesV', 'ValesController@obtenerValesV' );
Route::post('ventaVale', 'ValesController@ventaVale' );
//******************* CLASE PROMOCION *******************//
Route::get('crearPromocion', 'PromocionsController@crearPromocion');
Route::post('guardarPromocion', 'PromocionsController@guardarPromocion');
Route::get('buscarPromocion', 'PromocionsController@buscarPromocion');
Route::get('fechaPago', 'PromocionsController@fechaPago');

//******************* CLASE CUENTA *******************//
Route::get('crearCuentaVendedor', 'CuentasController@crearCuentaVendedor');


//----------------------------------------------------------//
//---------------> RUTAS SUPER-ADMINISTRADOR <--------------//
//----------------------------------------------------------//



//----------------------------------------------------------//
//---------------> RUTAS PARA TESTEAR <--------------//
//----------------------------------------------------------//

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
	$colonia_distribuidor = Vale::find(1)->distribuidor->nombre;

	//Pruebas para la relacion de 1 - * de vales y clientes (Aprobada)
	$vales_cliente = Cliente::find(1)->vales;
	$telefono_cliente = Vale::find(1)->cliente->telefono;

	//Pruebas para la relacion de 1 - * de vales y promociones (Aprobada)
	$vales_promocion = Promocion::find(14)->vales;
	$promocion_vale = Vale::find(1)->promociones;
	
	return ("Holi--->".$colonia_distribuidor);
	//return ("Holi--->".$promocion_vale);
});


Route::get('prueba2', function()
{
	return ("Holi");	
});