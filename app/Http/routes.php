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
Route::get('sesion', 'LoginController@mostrarLogin');
Route::post('login','LoginController@login');
Route::get('logout','LoginController@logout');
Route::get('verificar', ['middleware' => 'prado', function()
{
    return ("Todo con exito");
}]);


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
Route::get('obtenerVales', 'ValesController@obtenerVales' );
Route::get('obtenerValesV', 'ValesController@obtenerValesV' );
Route::post('ventaVale', 'ValesController@ventaVale' );

//******************* CLASE PROMOCION *******************//
Route::get('crearPromocion', 'PromocionsController@crearPromocion');
Route::post('guardarPromocion', 'PromocionsController@guardarPromocion');
Route::get('buscarPromocion', 'PromocionsController@buscarPromocion');
Route::get('fechaPago', 'PromocionsController@fechaPago');
Route::get('consultarPromociones', 'PromocionsController@consultarPromociones' );
Route::get('obtenerPromociones', 'PromocionsController@obtenerPromociones' );

//******************* CLASE CUENTA *******************//
Route::get('crearCuentaVendedor', 'CuentasController@crearCuentaVendedor');
Route::post('guardarCuentaVendedor', 'CuentasController@guardarCuentaVendedor');


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

Route::group(['middleware' => 'admin'], function () {
   	Route::get('admin1', function() { return ("Holi admin1");	});
	Route::get('admin2', function() { return ("Holi admin2");	});
	Route::get('admin3', function() { return ("Holi admin3");	});
	Route::get('admin4', function() { return ("Holi admin4");	});
	Route::get('admin5', function() { return ("Holi admin5");	});
});

Route::group(['middleware' => 'vendedor'], function () {
	Route::get('vendedor1', function() { return ("Holi vendedor1");	});
	Route::get('vendedor2', function() { return ("Holi vendedor2");	});
	Route::get('vendedor3', function() { return ("Holi vendedor3");	});
	Route::get('vendedor4', function() { return ("Holi vendedor4");	});
	Route::get('vendedor5', function() { return ("Holi vendedor5");	});	
});



