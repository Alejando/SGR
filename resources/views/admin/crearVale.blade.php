@extends ('m_admin')

@section ('titulo') Crear Vale
@stop

@section ('css')

@stop
@section ('contenido')

   <div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">Crear Vales</div>
					<div class="panel-body">
						 @if(Session::has('message'))
		                    <div class="alert alert-{{ Session::get('class') }}">{{ Session::get('message')}}</div>
		                
		                @endif
						<div class="col-md-6">
							<label>Nota: Solo puedes crear vales de la misma serie</label>
							<form class="form" role="form" method="GET" action="guardarVale" >
     					    <input type="hidden" name="_token" value="{{ csrf_token() }}">
							
								<div class="form-group ">
									<label>Nombre del distribuidor</label>
									<input type="text"  name="nombre" id="nombreDistribuidor"class="form-control" required >

								</div>
								
								<div class="col-md-4">
									<div class="form-group">
										<label>Serie</label>
										<input type="text"  name="calle" class="form-control" required>
									</div>	
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Folio Inicio</label>
										<input type="number"  name="numero_exterior" class="form-control" >
									</div>		
								</div>
								<div class="col-md-4">
									<div class="form-group">	
										<label>Folio Fin</label>
										<input type="number"  name="municipio" class="form-control" required>
									</div>	
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

@section ('js') 
<script src="js/completar.js"></script>
<script src="js/typeahead.bundle.js"></script>
@stop