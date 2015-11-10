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
								<div class="col-md-2">
									<div class="form-group">
										<label>Serie</label>
										<input type="text" value="{{ $vale->serie }}"  id="serie" name="serie" class="form-control" >
									</div>	
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label>Folio </label>
										<input type="number" value="{{$vale->folio}}"  id="folio" name="folio" class="form-control" required>
									</div>		
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label>Fecha de venta </label>
										<input type="date" value="{{$vale->fecha_venta}}"  id="fecha_venta" name="fecha_venta" class="form-control" required>
									</div>		
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label>Fecha de inicio de pago </label>
										<input type="date" value="{{$vale->fecha_inicio_pago}}"  id="fecha_inicio_pago" name="fecha_inicio_pago" class="form-control" required>
									</div>		
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Limite de Credito</label>
										<input type="text" value="{{$vale->cantidad_limite}}" name="limite_vale" class="form-control" >
									</div>	
								</div>
							</div>
							<div class="col-md-12">
								<div class="col-md-4">
									<div class="form-group">
										<label>Nombre del cliente</label>
										<input type="text" value="{{$vale->id_cliente}}" id="nombreCliente" name="nombre"  class="form-control" >
									</div>	
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Nombre del distribuidor</label>
										<input type="text"  value="{{$vale->id_distribuidor}}" id="nombreDistribuidor"  name="nombre_distribuidor" class="form-control" >
									</div>	
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Nombre Vendedor</label>
										<input type="text"  value="{{$vale->id_cuenta}}" id="nombreDistribuidor"  name="nombre_distribuidor" class="form-control" >
									</div>	
								</div>
							</div>	
							<div class="col-md-12">
								
								<div class="col-md-2">
									<div class="form-group">
										<label>Cantidad de venta</label>
										<input type="number" id="cantidad" value="{{$vale->cantidad}}" name="cantidad" class="form-control" required >
									</div>	
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label>Numero de pagos</label>
										<input type="number" id="numeroPagos" value="{{$vale->numero_pagos}}" name="numero_pagos" class="form-control" required >
									</div>	
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label>Folio venta </label>
										<input type="number"   value="{{$vale->folio_venta}}" name="folio_venta" class="form-control" required>
									</div>		
								</div>
								<div class="col-md-3">
									<div class="form-group">
									<label>Estatus del vale</label>
									<select name="estatus" class="form-control"  value= value="{{$vale->estatus}}" id="estatus">
									  <option value="0"class="form-control">Disponible</option>
									  <option value="1" class="form-control">Canjeado</option>
									  <option value="2" class="form-control">Cancelado</option>
									</select>
								</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Motivo de Concelación </label>
										<input type="text"   value="{{$vale->motivo_cancelacion}}" name="motivo_cancelacion" class="form-control" disabled>
									</div>		
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
										<button type="button"id="calcularPagos" class="btn btn-primary ">Calcular nuevos pagos</button>
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
<script src="../js/editarVale.js"></script>
@stop