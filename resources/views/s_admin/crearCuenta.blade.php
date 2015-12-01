@extends ('Layouts.m_super_admin')

@section ('titulo') Crear Vendedor
@stop

@section ('contenido')

  <div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">Crear Cuenta</div>
					<div class="panel-body">
						@if(Session::has('message'))
							<div  class="alert alert-{{ Session::get('class') }} alert-dismissable">
								    <button type="button" class="close" data-dismiss="alert">&times;</button>
								    <strong> {{ Session::get('message')}} </strong>
							</div>
						@endif
						<div class="col-md-6">
							<label>Datos del Vendedor</label>
							<form class="form" role="form" method="POST" action="guardarCuenta" enctype="multipart/form-data">
     					    <input type="hidden" name="_token" value="{{ csrf_token() }}">
     					    	<div class="form-group">
									<label>Tipo de cuenta</label>
									<select name="tipo" class="form-control" id="tipo">
									  <option value="1" class="form-control">Administrador</option>
									  <option value="2" class="form-control">Vendedor</option>
									</select>
								</div>
								<div class="form-group">
									<label>Nombre</label>
									<input type="text"  name="nombre" class="form-control" required>
								</div>
								<div class="form-group">
									<label>Teléfono</label>
									<input type="number"  name="telefono" class="form-control" required>
								</div>
								<div class="form-group">
									<label>Usuario</label>
									<input type="text"  name="usuario" class="form-control" required>
								</div>
								<div class="form-group">
									<label>Contraseña</label>
									<input type="password"  name="contrasena" class="form-control" required>
								</div>
								<div class="form-group">
									<label>Repita Contraseña</label>
									<input type="password"  name="contrasena2" class="form-control" required>
								</div>
								
						</div>
						
							
							<div class="col-md-12">
								<div class="pull-right">
										<button type="reset" class="btn btn-danger ">Borrar datos</button>
										<button type="submit" class="btn btn-success ">Enviar datos</button>
								</div>
							</div>	
						</form>
						
					</div>
				</div>
			</div><!-- /.col-->
		</div><!-- /.row -->
		
	</div><!--/.main-->

@stop