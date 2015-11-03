@extends ('Layouts.m_admin_show')

@section ('titulo') Editar Vale
@stop

@section ('css')

@stop
@section ('contenido')

   <div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">Registrar Vales</div>
					<div class="panel-body">
						<div id="mensaje">
						@if(Session::has('message'))
						<div class="alert alert-{{ Session::get('class') }} alert-dismissable">
							    <button type="button" class="close" data-dismiss="alert"></button>
							    <strong> {{ Session::get('message')}} </strong>
						</div>
						@endif
					    </div>
		                <form class="form" id="form"role="form" method="POST" action="actualizarVale" >
		                	<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<div class="col-md-12">
								<label>Editar vale</label>
								</br>
								<div class="col-md-3">
									<div class="form-group">
										<label>Serie</label>
										<input type="text" value="{{ $vale->serie }}"  id="serie" name="serie" class="form-control" >
									</div>	
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Folio </label>
										<input type="number" value="{{$vale->folio}}"  id="folio" name="folio" class="form-control" required>
									</div>		
								</div>
								
								<div class="col-md-6">
									<div class="form-group">
										<label>Limite de Credito</label>
										<input type="text" value="{{$vale->limite_vale}}" name="limite_vale" class="form-control" >
									</div>	
								</div>
							</div>
							<div class="col-md-12">
								<div class="col-md-6">
									<div class="form-group">
										<label>Nombre del cliente</label>
										<input type="text"  id="nombreCliente" name="nombre"  class="form-control" >
									</div>	
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Nombre del distribuidor</label>
										<input type="text" id="nombreDistribuidor"  name="nombre_distribuidor" class="form-control" >
									</div>	
								</div>
							</div>	
							<div class="col-md-12">
								
								<div class="col-md-6">
									<div class="form-group">
										<label>Cantidad de venta</label>
										<input type="number" value="{{$vale->cantidad}}" name="cantidad" class="form-control" required >
									</div>	
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Folio venta </label>
										<input type="number"   value="{{$vale->serie}}" name="folio_venta" class="form-control" required>
									</div>		
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
@stop