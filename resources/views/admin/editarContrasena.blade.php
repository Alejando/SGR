@extends ('m_admin')

@section ('titulo') Editar contraseña
@stop

@section ('contenido')

  <div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">Editar Contraseña</div>
					<div class="panel-body">
						@if(Session::has('message'))
							<div  class="alert alert-{{ Session::get('class') }} alert-dismissable">
								    <button type="button" class="close" data-dismiss="alert">&times;</button>
								    <strong> {{ Session::get('message')}} </strong>
							</div>
						@endif
						<div class="col-md-6">
							<label>Cambiar contraseña de cuenta</label>
							<form class="form" role="form" method="POST" action="actualizarContrasena">
     					    <input type="hidden" name="_token" value="{{ csrf_token() }}">
     					  	
								<div class="form-group">
									<label>Contraseña Actual</label>
									<input type="password"   name="contrasena" class="form-control" required>
								</div>
								<div class="form-group">
									<label>Nueva contraseña</label>
									<input type="password"  name="nContrasena" class="form-control" pattern="{10}" required >
								</div>
								<div class="form-group">
									<label>Repetir Contraseña </label>
									<input type="password"   name="rContrasena" class="form-control" pattern="{10}"required>
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