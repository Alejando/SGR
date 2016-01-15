@extends ('m_admin')

@section ('titulo') Actualizar vales
@stop

@section ('css')

@stop
@section ('contenido')

   <div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">Actualizar Vales</div>
				<div class="panel-body">
					@if(Session::has('message'))
                    <div id="mensaje"class="alert alert-{{ Session::get('class') }} alert-dismissable">
					    <button type="button" class="close" data-dismiss="alert">&times;</button>
					    <strong> {{ Session::get('message')}} </strong>
			    	</div>
	                @endif
					<div class="col-md-6">
						<label><strong>Nota: </strong> Sólo se pueden actualizar vales de la misma serie</label>
						<form id="form"class="form" role="form" method="POST" action="actualizarVales" >
 					    	<input type="hidden" name="_token" value="{{ csrf_token() }}">
						
							<div class="form-group ">
								<label>Nuevo distribuidor</label>
								<input type="text"  name="id_distribuidor" id="nombreDistribuidor"class="form-control" required >

							</div>
							
							<div class="col-md-4">
								<div class="form-group">
									<label>Serie</label>
									<input type="text" id="serie" name="serie" class="form-control" >
								</div>	
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Folio Inicio</label>
									<input type="number"  id="folio_inicio"  class="form-control"  required>
								</div>		
							</div>
							<div class="col-md-4">
								<div class="form-group">	
									<label>Folio Fin</label>
									<input type="number"  name="folio_fin" class="form-control" required>
								</div>	
							</div>
							<div id="oculto"></div>
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
<script src="js/cambiarVale.js"></script>
@stop