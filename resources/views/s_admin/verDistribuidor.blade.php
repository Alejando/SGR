@extends ('Layouts.m_super_admin_show')
@section ('titulo') Editar distribuidor
@stop

@section ('contenido')

   <div class="row">
		<div class="panel panel-default">
			<div class="panel-heading">Editar Distribuidor</div>
			<div class="panel-body">
				@if(Session::has('message'))
				<div  class="alert alert-{{ Session::get('class') }} alert-dismissable">
					    <button type="button" class="close" data-dismiss="alert">&times;</button>
					    <strong> {{ Session::get('message')}} </strong>
				</div>
				@endif
				<div class="col-md-6">
					<label>Datos Distribuidor</label>
					<br>
					<div class="col-md-12" >
						<div class="col-md-3" >
							<img src="../archivos/{{ $distribuidor->foto }}" name="aboutme" width="140" height="140" class="img-thumbnail">
						</div>
						<div class="col-md-3" >
							</br>
							</br>
							</br>	
							</br>	
						</div>
						</br>
						</br>	
						<div class="form-group col-md-6" >
							<label>Nombre</label>
							<p>{{ $distribuidor->nombre }}</p>									
						</div>
						
						

					</div>
					</br>
					<div class="col-md-12" >

						<div class="col-md-6" >
							<div class="form-group">
								<label>Calle</label>
								<p>{{ $distribuidor->calle }}</p>
							</div>	
							<div class="form-group">
								<label>Número exterior</label>
								<p>{{ $distribuidor->numero_exterior }}</p>
							</div>		
							<div class="form-group">	
								<label>Municipio</label>
								<p>{{ $distribuidor->municipio }}</p>
							</div>
							<div class="form-group">	
								<label>Código Postal</label>
								<p>{{ $distribuidor->codigo_postal }}</p>
							</div>
							<div class="form-group">
								<label>Celular</label>
								<p>{{ $distribuidor->celular }}</p>
							</div>	
						</div>
						<div class="col-md-6">
							<div class="form-group">	
								<label>Colonia</label>
								<p>{{ $distribuidor->colonia }}</p>
							</div>
							<div class="form-group">	
								<label>Número interior</label>
								<p>{{ $distribuidor->numero_interior }}</p>
							</div>
							<div class="form-group">	
								<label>Estado</label>
								<p>{{ $distribuidor->estado }}</p>
							</div>	
		
							
							
							<div class="form-group">
								<label>Telefono</label>
								<p>{{ $distribuidor->telefono }}</p>
							</div>
						</div>	
					</div>		
				</div>
				<div class="col-md-6">
					<div class="col-md-12">
						<label>Datos de Aval</label>
						<div class="form-group">
							<label class="control-label">Nombre de Aval</label>
							<p>{{ $distribuidor->nombre_aval }}</p>
						</div>
						<div class="col-md-6">
							
							<div class="form-group">
								<label>Calle</label>
								<p>{{ $distribuidor->calle_aval }}</p>
							</div>	
							<div class="form-group">
								<label>Número exterior</label>
								<p>{{ $distribuidor->numero_exterior_aval }}</p>
							</div>		
							<div class="form-group">	
								<label>Municipio</label>
								<p>{{ $distribuidor->municipio_aval }}</p>
							</div>
							<div class="form-group">	
								<label>Código Postal</label>
								<p>{{ $distribuidor->codigo_postal_aval }}</p>
							</div>
							<div class="form-group ">
								<label class="control-label">Celular</label>
								<p>{{ $distribuidor->celular_aval }}</p>
							</div>	
						</div>		
						<div class="col-md-6">
							<div class="form-group">	
								<label>Colonia</label>
								<p>{{ $distribuidor->colonia_aval }}</p>
							</div>
							<div class="form-group">	
								<label>Número interior</label>
								<p>{{ $distribuidor->numero_interior_aval }}</p>
							</div>
							<div class="form-group">	
								<label>Estado</label>
								<p>{{ $distribuidor->estado_aval }}</p>
							</div>	
							
							<div class="form-group">
								<label>Teléfono</label>
								<p>{{ $distribuidor->telefono_aval }}</p>

							</div>	
							
						</div>
						<div class="col-md-12">
							<div class="form-group ">
								<div class=" col-md-6 ">
									<label>Firma</label>
								</div>
						
								<div class="col-md-6 pull-right">
									<img src="../archivos/{{ $distribuidor->firma }}" name="aboutme" width="140" height="140" class="img-thumbnail">
								</div>
							</div>
						</div>
					</div>
				</div>
				
				</div>
			</div>
		</div>
			
	</div><!-- /.row -->
		

@stop