@extends ('Layouts.m_super_admin_show')


@section ('titulo') Editar distribuidor
@stop

@section ('contenido')

   <div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">Editar Distribuidores</div>
					<div class="panel-body">
						 @if(Session::has('message'))
		                    <div class="alert alert-{{ Session::get('class') }}">{{ Session::get('message')}}</div>
		                
		                @endif
						<div class="col-md-6" style="background-color:#000000">
							<label>Datos Distribuidor</label>
							<br>
							
								<div class="form-group col-md-6" style="background-color:#262626">
									<img src="../archivos/{{ $distribuidor->foto }}" name="aboutme" width="130" height="50" class="img-thumbnail">
								</div>
								<div class="form-group col-md-6" style="background-color:#595959">
									<label>Nombre</label>
									<p>{{ $distribuidor->nombre }}</p>
								<br>
								<br>
								<br>
								<br>
								<br>
								<br>
								</div>
								
								
								<div class="col-md-6" style="background-color:#404040">

									
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
								<div class="col-md-6" style="background-color:#737373" >
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
							<div class="col-md-6">
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
										</br>
										</br>
										</br>
									</div>	
									
									<div class="form-group">
										<label>Teléfono</label>
										<p>{{ $distribuidor->telefono_aval }}</p>

									</div>	
								</div>
							</div>
							
								
								
							<div class="form-group">
								<label>Firma</label>
								<div class="col-md-6">
									<img src="../archivos/{{ $distribuidor->firma }}" name="aboutme" class="img-thumbnail">
								</div>
							</div>	
						
							
							<!--div class="col-md-6">
								<div class="form-group">
									<div class="form-group">
										<label>Limite de credito para distribuidor</label>
										<input type="number"  name="limite_credito" class="form-control" required>
									</div>
									<div class="form-group">
										<label>Limite de credito para vales</label>
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
							</div-->
						
						
					</div>
				</div>
			</div><!-- /.col-->
		</div><!-- /.row -->
		
	</div><!--/.main-->
@stop