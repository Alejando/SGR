@extends ('Layouts.m_super_admin')

@section ('titulo') Crear Comisión
@stop

@section ('contenido')

  <div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">Crear Comision</div>
					<div class="panel-body">
						 @if(Session::has('message'))
							<div  class="alert alert-{{ Session::get('class') }} alert-dismissable">
								    <button type="button" class="close" data-dismiss="alert">&times;</button>
								    <strong> {{ Session::get('message')}} </strong>
							</div>
						@endif
						<div class="col-md-6">
							<label>Datos comisión</label>
							<form class="form" role="form" method="POST" action="guardarComision" enctype="multipart/form-data">
     					    <input type="hidden" name="_token" value="{{ csrf_token() }}">
								<div class="form-group">
									<label>Cantidad inicial</label>
									<input type="number"  name="cantidad_inicial" class="form-control" required>
								</div>
								<div class="form-group">
									<label>Cantidad final</label>
									<input type="number"  name="cantidad_final" class="form-control" required>
								</div>
								<div class="form-group">
									<label>Porcentaje</label>
									<input type="number"  name="porcentaje" class="form-control" required>
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