
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>@yield('titulo', 'Zapateria el Gran Remate')</title>

	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/datepicker3.css" rel="stylesheet">
	<link href="css/styles.css" rel="stylesheet">
	<link href="css/ticket.css" rel="stylesheet">
	<link href="css/fonts.css" rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="css/uijs.css">
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
						<a class="" href="registrarVale">
							<span class="glyphicon glyphicon-share-alt"></span> Registro de ventas
						</a>
					</li>
					<li>
						<a class="" href="consultarVales">
							<span class="glyphicon glyphicon-share-alt"></span> Ver Vales
						</a>
					</li>
				</ul>
			</li>
			<li class="parent ">
				<a data-toggle="collapse" href="#sub-item-3">
					<span class="glyphicon glyphicon-list" href="#sub-item-3"></span> Clientes <span data-toggle="collapse" href="#sub-item-3" class="icon pull-right"><em class="glyphicon glyphicon-s glyphicon-plus"></em></span> 
				</a>
				<ul class="children collapse" id="sub-item-3">
					<li>
						<a class="" href="crearCliente">
							<span class="glyphicon glyphicon-share-alt"></span> Alta Cliente
						</a>
					</li>
					<li>
						<a class="" href="consultarClientes">
							<span class="glyphicon glyphicon-share-alt"></span> Ver Clientes
						</a>
					</li>
				</ul>
			</li>
			<li class="parent ">
				<a data-toggle="collapse" href="#sub-item-4">
					<span class="glyphicon glyphicon-list" href="#sub-item-4"></span> Promociones <span data-toggle="collapse" href="#sub-item-4" class="icon pull-right"><em class="glyphicon glyphicon-s glyphicon-plus"></em></span> 
				</a>
				<ul class="children collapse" id="sub-item-4">
					<li>
						<a class="" href="consultarPromociones">
							<span class="glyphicon glyphicon-share-alt"></span> Ver Promociones
						</a>
					</li>
				</ul>
			</li>
			
			<li role="presentation" class="divider"></li>
			<li><a href="editarContrasena"><span class="glyphicon glyphicon-wrench"></span> Cambiar Contraseña</a></li>
			<li><a href="logout"><span class="glyphicon glyphicon-user"></span> Cerrar Sesión</a></li>
		</ul>
	</div><!--/.sidebar-->
		
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
				
		<!--/.row-->
		@yield('contenido')
	</div>	<!--/.main-->
</body>
	
	
	<script src="js/jquery.min.js"></script>
	<script src="js/jquery-ui.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/chart.min.js"></script>
	<script src="js/chart-data.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script src="js/custom.js"></script>
	<script src="js/bootstrap-table.js"></script>
	<script src="js/tipoPromocion.js"></script>	
	<script src="js/jquery.PrintArea.js"></script>
	@yield('js')
</html>

