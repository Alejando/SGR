@extends ('m_admin')

@section ('titulo') pagina 2
@stop

@section ('contenido')

   <div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">Crear Distribuidores</div>
					<div class="panel-body">
						<div class="col-md-6">
							<label>Datos Distribuidor</label>
							<form class="form" role="form" method="POST" action="guardarDistribuidor">
     					    <input type="hidden" name="_token" value="{{ csrf_token() }}">
							
								<div class="form-group">
									<label>Nombre</label>
									<input type="text"  name="nombre" class="form-control" required>
								</div>
								
								<div class="col-md-6">
									
									<div class="form-group">
										<label>Calle</label>
										<input type="text"  name="calle" class="form-control" required>
									</div>	
									<div class="form-group">
										<label>Número exterior</label>
										<input type="text"  name="calle" class="form-control" required>
									</div>		
									<div class="form-group">	
										<label>Municipio</label>
										<input type="text"  name="calle" class="form-control" required>
									</div>
									<div class="form-group">	
										<label>Código Postal</label>
										<input type="text"  name="calle" class="form-control" required>
									</div>
									<div class="form-group">
										<label>Celular</label>
										<input type="text"  name="celular_aval" class="form-control" required>
									</div>	
								</div>		
								<div class="col-md-6">
									<div class="form-group">	
										<label>Colonia</label>
										<input type="text"  name="calle" class="form-control" required>
									</div>
									<div class="form-group">	
										<label>Número interior</label>
										<input type="text"  name="calle" class="form-control" >
									</div>
									<div class="form-group">	
										<label>Estado</label>
										<input type="text"  name="calle" class="form-control" required>
									</div>	
				
									<div class="form-group">
										</br>
										</br>
										</br>
									</div>	
									
									<div class="form-group">
										<label>Telefono</label>
										<input type="text"  name="celular_aval" class="form-control" required>
									</div>
								</div>	
							</div>
							<div class="col-md-6">
								<label>Datos de Aval</label>
								<div class="form-group">
									<label>Nombre de Aval</label>
									<input type="text"  name="nombre_aval" class="form-control" required>
								</div>
								<div class="col-md-6">
									
									<div class="form-group">
										<label>Calle</label>
										<input type="text"  name="calle" class="form-control" required>
									</div>	
									<div class="form-group">
										<label>Número exterior</label>
										<input type="text"  name="calle" class="form-control" required>
									</div>		
									<div class="form-group">	
										<label>Municipio</label>
										<input type="text"  name="calle" class="form-control" required>
									</div>
									<div class="form-group">	
										<label>Código Postal</label>
										<input type="text"  name="calle" class="form-control" required>
									</div>
									<div class="form-group">
										<label>Celular</label>
										<input type="text"  name="celular_aval" class="form-control" required>
									</div>	
								</div>		
								<div class="col-md-6">
									<div class="form-group">	
										<label>Colonia</label>
										<input type="text"  name="calle" class="form-control" required>
									</div>
									<div class="form-group">	
										<label>Número interior</label>
										<input type="text"  name="calle" class="form-control" >
									</div>
									<div class="form-group">	
										<label>Estado</label>
										<input type="text"  name="calle" class="form-control" required>
									</div>	
				
									<div class="form-group">
										</br>
										</br>
										</br>
									</div>	
									
									<div class="form-group">
										<label>Telefono</label>
										<input type="text"  name="celular_aval" class="form-control" required>
									</div>	
								</div>
								 
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<div class="form-group">
										<label>Limite de credito para distribuidor</label>
										<input type="text"  name="limite_credito" class="form-control" required>
									</div>
									<div class="form-group">
										<label>Limite de credito para vales</label>
										<input type="text"  name="limite_vale" class="form-control" required>
									</div>
									<div class="form-group">
										<label>Foto</label>
										<input type="file">
									</div>	
									<div class="form-group">
										<label>Firma</label>
										<input type="file">
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