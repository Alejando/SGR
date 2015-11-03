
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>@yield('titulo', 'Zapateria el Gran Remate')</title>

	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/datepicker3.css" rel="stylesheet">
	<link href="css/styles.css" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css'>
	@yield('css')

</head>

<body>
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#"><span>Gran</span> Remate</a>
				<ul class="nav navbar-top-links navbar-right">
				</ul>
			</div>
		</div><!-- /.container-fluid -->
	</nav>
		
	<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
		

		<ul class="nav menu">
			<li ><h3>Bienvenido</h3></li>
			<li ><h4>{{Session::get('nombre')}}</h4></li>
			<li role="presentation" class="divider"></li>
			<li class="parent ">
				<a data-toggle="collapse" href="#sub-item-1">
					<span class="glyphicon glyphicon-list"></span> Vales <span data-toggle="collapse" href="#sub-item-1" class="icon pull-right"><em class="glyphicon glyphicon-s glyphicon-plus"></em></span> 
				</a>
				<ul class="children collapse" id="sub-item-1">
					<li>
						<a class="" href="crearVale">
							<span class="glyphicon glyphicon-share-alt"></span> Crear Vales
						</a>
					</li>
					<li>
						<a class="" href="registrarVale">
							<span class="glyphicon glyphicon-share-alt"></span> Emitir Vales
						</a>
					</li>
					<li>
						<a class="" href="consultarVales">
							<span class="glyphicon glyphicon-share-alt"></span> Consultar Vales
						</a>
					</li>
				</ul>
			</li>
			<li class="parent ">
				<a data-toggle="collapse" href="#sub-item-2">
					<span class="glyphicon glyphicon-list"></span> Distribuidores <span data-toggle="collapse" href="#sub-item-2" class="icon pull-right"><em class="glyphicon glyphicon-s glyphicon-plus"></em></span> 
				</a>
				<ul class="children collapse" id="sub-item-2">
					<li>
						<a class="" href="crearDistribuidor">
							<span class="glyphicon glyphicon-share-alt"></span> Alta Distribuidor
						</a>
					</li>
					<li>
						<a class="" href="#">
							<span class="glyphicon glyphicon-share-alt"></span> Reportes
						</a>
					</li>
				</ul>
			</li>
			<li class="parent ">
				<a data-toggle="collapse" href="#sub-item-3">
					<span class="glyphicon glyphicon-list"></span> Clientes <span data-toggle="collapse" href="#sub-item-3" class="icon pull-right"><em class="glyphicon glyphicon-s glyphicon-plus"></em></span> 
				</a>
				<ul class="children collapse" id="sub-item-3">
					<li>
						<a class="" href="crearCliente">
							<span class="glyphicon glyphicon-share-alt"></span> Alta Cliente
						</a>
					</li>
					<li>
						<a class="" href="consultarClientes">
							<span class="glyphicon glyphicon-share-alt"></span> Consultar Clientes
						</a>
					</li>
				</ul>
			</li>
			<li class="parent "> 
				<a data-toggle="collapse" href="#sub-item-4">
					<span class="glyphicon glyphicon-list"></span> Promociones <span data-toggle="collapse" href="#sub-item-4" class="icon pull-right"><em class="glyphicon glyphicon-s glyphicon-plus"></em></span> 
				</a>
				<ul class="children collapse" id="sub-item-4">
					<li>
						<a class="" href="crearPromocion">
							<span class="glyphicon glyphicon-share-alt"></span> Crear Promoción
						</a>
					</li>
					<li>
						<a class="" href="consultarPromociones">
							<span class="glyphicon glyphicon-share-alt"></span> Consultar Promciones
						</a>
					</li>
				</ul>
			</li>
			<li class="parent "> 
				<a data-toggle="collapse" href="#sub-item-5">
					<span class="glyphicon glyphicon-list"></span> Comisiones <span data-toggle="collapse" href="#sub-item-5" class="icon pull-right"><em class="glyphicon glyphicon-s glyphicon-plus"></em></span> 
				</a>
				<ul class="children collapse" id="sub-item-5">
					<li>
						<a class="" href="#">
							<span class="glyphicon glyphicon-share-alt"></span> Crear Comisión
						</a>
					</li>
					<li>
						<a class="" href="#">
							<span class="glyphicon glyphicon-share-alt"></span> Consultar Comisiones
						</a>
					</li>
				</ul>
			</li>
			<li class="parent ">
				<a data-toggle="collapse" href="#sub-item-6">
					<span class="glyphicon glyphicon-list"></span> Cuentas <span data-toggle="collapse" href="#sub-item-6" class="icon pull-right"><em class="glyphicon glyphicon-s glyphicon-plus"></em></span> 
				</a>
				<ul class="children collapse" id="sub-item-6">
					<li>
						<a class="" href="crearCuentaVendedor">
							<span class="glyphicon glyphicon-share-alt"></span> Crear Cuenta
						</a>
					</li>
					<li>
						<a class="" href="consultarCuentasVendedor">
							<span class="glyphicon glyphicon-share-alt"></span> Consultar Usuarios
						</a>
					</li>
				</ul>
			</li>
			<li><a href=""><span class="glyphicon glyphicon-hand-up"></span> Opciones</a></li>
			<li role="presentation" class="divider"></li>

			<li><a href="logout"><span class="glyphicon glyphicon-user"></span> Cerrar Sesión</a></li>
		</ul>
	</div><!--/.sidebar-->
		
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
				
		<!--/.row-->
		@yield('contenido')
	</div>	<!--/.main-->
</body>
	<script src="js/jquery.js"></script>
	<script src="js/jquery-ui.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/chart.min.js"></script>
	<script src="js/chart-data.js"></script>
	<script src="js/easypiechart.js"></script>
	<script src="js/easypiechart-data.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script src="js/custom.js"></script>
	<script src="js/bootstrap-table.js"></script>
	<script src="js/tipoPromocion.js"></script>

	
	
	
	@yield('js')
</html>
