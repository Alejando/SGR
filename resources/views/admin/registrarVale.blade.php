@extends ('m_admin')

@section ('titulo') Registrar vale
@stop

@section ('contenido')

   <div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">Registrar Vales</div>
					<div class="panel-body">
						<div class="alert alert-{{ Session::get('class') }} alert-dismissable">
						    <button type="button" class="close" data-dismiss="alert">&times;</button>
						    <strong> {{ Session::get('message')}} </strong>
					    </div>
		                <form class="form" role="form" method="POST" action="ventaVale" >
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
										<p  id="bVericar"class="btn btn-primary" onclick="datosVale()" >Comprobar</p>
									</div>		
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Limite de Credito</label>
										<input type="text"  id="limite_vale" name="limite_vale" class="form-control" disabled>
									</div>	
								</div>
							</div>
							<div class="col-md-12">
								<div class="col-md-6">
									<div class="form-group">
										<label>Nombre del cliente</label>
										<input type="text"  id="nombreCliente" name="nombre"  class="form-control" required>
									</div>	
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Nombre del distribuidor</label>
										<input type="text" id="nombreDistribuidor"  name="nombre_distribuidor" class="form-control" disabled>
									</div>	
								</div>
							</div>	
							<div class="col-md-12">
								
								<div class="col-md-6">
									<div class="form-group">
										<label>Cantidad de venta</label>
										<input type="number"  id="cantidad" name="cantidad" class="form-control" required>
									</div>	
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Folio venta </label>
										<input type="number"  id="folioVenta"name="folio_venta" class="form-control" >
									</div>		
								</div>
								
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label>Promociones Actuales</label>
										<div id="promociones"></div>
								</div>
							</div>	
							<div class="col-md-12">
								<div class="form-group">
									<label>Fecha pagos</label>
										<div id="pagos"></div>
											
								</div>
							</div>	
							<div class="col-md-12">
								<div class="pull-right">
										<button type="reset" class="btn btn-danger ">Borrar datos</button>
										<button type="submit" class="btn btn-success ">Guardar Vale</button>
								</div>
							</div>
							<div id="ocultos"></div>	

						</form>
						
					</div>
				</div>
			</div><!-- /.col-->
		</div><!-- /.row -->
		

@stop

@section ('js') 
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script src="js/actualizarVale.js"></script>