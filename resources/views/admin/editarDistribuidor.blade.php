@extends ('Layouts.m_admin_show')

@section ('titulo') Editar distribuidor

@stop

@section ('contenido')

   <div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">Crear Distribuidores</div>
					<div class="panel-body">
						 @if(Session::has('message'))
		                    <div class="alert alert-{{ Session::get('class') }}">{{ Session::get('message')}}</div>
		                
		                @endif
						<div class="col-md-6">
							<label>Datos Distribuidor</label>
							<form class="form" role="form" method="POST" action="{{URL::to('actualizarDistribuidor/').'/'.$distribuidor->id_distribuidor}}" enctype="multipart/form-data">
     					    <input type="hidden" name="_token" value="{{ csrf_token() }}">
							
								<div class="form-group">
									<label>Nombre</label>
									<input type="text"  value="{{ $distribuidor->nombre }}" name="nombre" class="form-control validate" required>
								</div>
								
								<div class="col-md-6">
									
									<div class="form-group">
										<label>Calle</label>
										<input type="text" value="{{ $distribuidor->calle }}" name="calle" class="form-control" required>
									</div>	
									<div class="form-group">
										<label>Número exterior</label>
										<input type="text"  value="{{ $distribuidor->numero_exterior }}" name="numero_exterior" class="form-control" >
									</div>		
									<div class="form-group">	
										<label>Municipio</label>
										<input type="text"  value="{{ $distribuidor->municipio }}" name="municipio" class="form-control" required>
									</div>
									<div class="form-group">	
										<label>Código Postal</label>
										<input type="text"  value="{{ $distribuidor->codigo_postal }}" name="codigo_postal" class="form-control" required>
									</div>
									<div class="form-group">
										<label>Celular</label>
										<input type="tel" value="{{ $distribuidor->celular }}" name="celular" class="form-control">
									</div>	
								</div>		
								<div class="col-md-6">
									<div class="form-group">	
										<label>Colonia</label>
										<input type="text" value="{{ $distribuidor->colonia }}" name="colonia" class="form-control" required>
									</div>
									<div class="form-group">	
										<label>Número interior</label>
										<input type="text" value="{{ $distribuidor->numero_interior }}" name="numero_interior" class="form-control">
									</div>
									<div class="form-group">	
										<label>Estado</label>
										<input type="text" value="{{ $distribuidor->estado }}" name="estado" class="form-control" required>
									</div>	
				
									<div class="form-group">
										</br>
										</br>
										</br>
									</div>	
									
									<div class="form-group">
										<label>Telefono</label>
										<input type="tel" value="{{ $distribuidor->telefono }}" name="telefono" class="form-control" >
									</div>
								</div>	
							</div>
							<div class="col-md-6">
								<label>Datos de Aval</label>
								<div class="form-group">
									<label class="control-label">Nombre de Aval</label>
									<input type="text" value="{{ $distribuidor->nombre_aval }}" name="nombre_aval" class="form-control" required>
								</div>
								<div class="col-md-6">
									
									<div class="form-group">
										<label>Calle</label>
										<input type="text" value="{{ $distribuidor->calle_aval }}" name="calle_aval" class="form-control" required>
									</div>	
									<div class="form-group">
										<label>Número exterior</label>
										<input type="text" value="{{ $distribuidor->numero_exterior_aval }}" name="numero_exterior_aval" class="form-control" >
									</div>		
									<div class="form-group">	
										<label>Municipio</label>
										<input type="text" value="{{ $distribuidor->municipio_aval }}" name="municipio_aval" class="form-control" required>
									</div>
									<div class="form-group">	
										<label>Código Postal</label>
										<input type="text" value="{{ $distribuidor->codigo_postal_aval }}" name="codigo_postal_aval" class="form-control" required>
									</div>
									<div class="form-group ">
										<label class="control-label">Celular</label>
										<input type="text" value="{{ $distribuidor->celular_aval }}" name="celular_aval" class="form-control" pattern="[0-9]{10}" required>
									</div>	
								</div>		
								<div class="col-md-6">
									<div class="form-group">	
										<label>Colonia</label>
										<input type="text" value="{{ $distribuidor->colonia_aval }}" name="colonia_aval" class="form-control" required>
									</div>
									<div class="form-group">	
										<label>Número interior</label>
										<input type="text" value="{{ $distribuidor->numero_interior_aval }}" name="numero_interior_aval" class="form-control" >
									</div>
									<div class="form-group">	
										<label>Estado</label>
										<input type="text" value="{{ $distribuidor->estado_aval }}" name="estado_aval" class="form-control" required>
									</div>	
				
									<div class="form-group">
										</br>
										</br>
										</br>
									</div>	
									
									<div class="form-group">
										<label>Telefono</label>
										<input type="text" value="{{ $distribuidor->telefono_aval }}" name="telefono_aval"  class="form-control" >
									</div>	
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<div class="form-group">
										<label>Limite de credito para distribuidor</label>
										<input type="number" value="{{ $distribuidor->limite_credito }}" name="limite_credito" class="form-control" required>
									</div>
									<div class="form-group">
										<label>Limite de credito para vales</label>
										<input type="number" value="{{ $distribuidor->limite_vale }}" name="limite_vale" class="form-control" required>
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