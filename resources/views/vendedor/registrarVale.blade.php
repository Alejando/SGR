@extends ('m_ADMIN')

@section ('titulo') Registrar vale
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
		                <form class="form" role="form" method="GET" action="actualizarVale" >
		                	<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<div class="col-md-12">
								<label>Registro de vales</label>
								</br>
								<div class="col-md-2">
									<div class="form-group">
										<label>Serie</label>
										<input type="text"  id="serie" name="serie" class="form-control" required>
									</div>	
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label>Folio </label>
										<input type="number"  id="folio" name="folio" class="form-control" required>
									</div>		
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label>Verificar</label>
										<p class="btn btn-danger" onclick="datosVale()" >Comprobar</p>
									</div>		
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Limite de Credito</label>
										<input type="text"  name="limite_vale" class="form-control" disabled>
									</div>	
								</div>
							</div>
							<div class="col-md-12">
								<div class="col-md-6">
									<div class="form-group">
										<label>Nombre del cliente</label>
										<input type="text"  id="nombre" name="nombre"  class="form-control" required>
									</div>	
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Nombre del distribuidor</label>
										<input type="text"  name="nombre_distribuidor" class="form-control" disabled>
									</div>	
								</div>
							</div>	
							<div class="col-md-12">
								
								<div class="col-md-6">
									<div class="form-group">
										<label>Cantidad de venta</label>
										<input type="text"  name="cantidad" class="form-control" required>
									</div>	
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Folio venta </label>
										<input type="number"  name="folio_venta" class="form-control" >
									</div>		
								</div>
								
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label>Promociones Actuales</label>
								</div>
							</div>	
							<div class="col-md-12">
								<div class="form-group">
									<label>Fecha pagos</label>
								</div>
							</div>	
							<div class="col-md-12">
								<div class="pull-right">
										<button type="reset" class="btn btn-danger ">Borrar datos</button>
										<button type="submit" class="btn btn-success ">Guardar Vale</button>
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
<script src="js/actualizarVale.js"></script>