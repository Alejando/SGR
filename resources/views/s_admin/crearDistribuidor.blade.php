@extends ('Layouts.m_super_admin')

@section ('titulo') Crear distribuidor
@stop

@section ('contenido')

   <div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">Crear Distribuidores</div>
					<div class="panel-body">
						 @if(Session::has('message'))
							<div  class="alert alert-{{ Session::get('class') }} alert-dismissable">
								    <button type="button" class="close" data-dismiss="alert">&times;</button>
								    <strong> {{ Session::get('message')}} </strong>
							</div>
						@endif
						<div class="col-md-6">
							<label>Datos Distribuidor</label>
							<form class="form" role="form" method="POST" action="guardarDistribuidor" enctype="multipart/form-data">
     					    <input type="hidden" name="_token" value="{{ csrf_token() }}">
							
								<div class="form-group">
									<label>Nombre *</label>
									<input type="text"  name="nombre" class="form-control validate" required>
								</div>
								
								<div class="col-md-6">
									
									<div class="form-group">
										<label>Calle *</label>
										<input type="text"  name="calle" class="form-control" required>
									</div>	
									<div class="form-group">
										<label>Número exterior *</label>
										<input type="text"  name="numero_exterior" class="form-control" required>
									</div>		
									<div class="form-group">	
										<label>Municipio *</label>
										<input type="text"  name="municipio" class="form-control" required>
									</div>
									<div class="form-group">	
										<label>Código Postal *</label>
										<input type="text"  name="codigo_postal" class="form-control" required>
									</div>
									<div class="form-group">
										<label>Celular</label>
										<input type="tel"  name="celular" class="form-control">
									</div>	
								</div>		
								<div class="col-md-6">
									<div class="form-group">	
										<label>Colonia *</label>
										<input type="text"  name="colonia" class="form-control" required>
									</div>
									<div class="form-group">	
										<label>Número interior</label>
										<input type="text"  name="numero_interior" class="form-control">
									</div>
									<div class="form-group">	
										<label>Estado *</label>
										<input type="text"  name="estado" class="form-control" required>
									</div>	
				
									<div class="form-group">
										</br>
										</br>
										</br>
									</div>	
									
									<div class="form-group">
										<label>Telefono</label>
										<input type="tel"  name="telefono" class="form-control" >
									</div>
								</div>	
							</div>
							<div class="col-md-6">
								<label>Datos de Aval</label>
								<div class="form-group">
									<label class="control-label">Nombre de Aval *</label>
									<input type="text"  name="nombre_aval" class="form-control" required>
								</div>
								<div class="col-md-6">
									
									<div class="form-group">
										<label>Calle *</label>
										<input type="text"  name="calle_aval" class="form-control" required>
									</div>	
									<div class="form-group">
										<label>Número exterior *</label>
										<input type="text"  name="numero_exterior_aval" class="form-control" required>
									</div>		
									<div class="form-group">	
										<label>Municipio *</label>
										<input type="text"  name="municipio_aval" class="form-control" required>
									</div>
									<div class="form-group">	
										<label>Código Postal *</label>
										<input type="text"  name="codigo_postal_aval" class="form-control" required>
									</div>
									<div class="form-group ">
										<label class="control-label">Celular</label>
										<input type="text"  name="celular_aval" class="form-control" pattern="[0-9]{10}">
									</div>	
								</div>		
								<div class="col-md-6">
									<div class="form-group">	
										<label>Colonia *</label>
										<input type="text"  name="colonia_aval" class="form-control" required>
									</div>
									<div class="form-group">	
										<label>Número interior</label>
										<input type="text"  name="numero_interior_aval" class="form-control" >
									</div>
									<div class="form-group">	
										<label>Estado *</label>
										<input type="text"  name="estado_aval" class="form-control" required>
									</div>	
				
									<div class="form-group">
										</br>
										</br>
										</br>
									</div>	
									
									<div class="form-group">
										<label>Telefono</label>
										<input type="text"  name="telefono_aval"  class="form-control" >
									</div>	
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<div class="form-group">
										<label>Limite de credito para distribuidor *</label>
										<input type="number"  name="limite_credito" class="form-control" required>
									</div>
									<div class="form-group">
										<label>Limite de credito para vales *</label>
										<input type="number"  name="limite_vale" class="form-control" required>
									</div>
									<div class="form-group">
										<label>Foto</label>
										<input type="file" id="foto" name="foto">
									</div>	
									<div class="form-group">
										<label>Firma</label>
										<input type="file" id="firma" name="firma">
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