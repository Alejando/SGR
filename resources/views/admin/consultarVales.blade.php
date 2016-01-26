@extends ('m_admin')

@section ('titulo') Consultar vales
@stop

@section ('contenido')
  
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">Consultar Vales</div>
			<div class="panel-body">
				@if(Session::has('message'))
							<div  class="alert alert-{{ Session::get('class') }} alert-dismissable">
								    <button type="button" class="close" data-dismiss="alert">&times;</button>
								    <strong> {{ Session::get('message')}} </strong>
							</div>
						@endif
				<div class="col-lg-12">
					<div class="col-lg-4">
						<div class="form-group">
							<label>Distribuidor</label>
							<input type="text"  id="id_distribuidor" class="form-control" />
						</div>
					</div>
					<div class="col-lg-3">
						<div class="form-group">
							<label>Fecha inicio</label>
							<input type="date"  id="fecha_inicio" class="form-control" />
						</div>
					</div>
					<div class="col-lg-3">
						<div class="form-group">
							<label>Fecha termino</label>
							<input type="date"  id="fecha_termino" class="form-control" />
						</div>
					</div>
					<div class="col-lg-1">
						<div class="form-group">
							</br>
							<p  id="consultar" class="btn btn-primary" onclick="mostrarTabla()"> Consultar </p>
						</div>	
					</div>
					<div class="col-lg-1">
						<div class="btn-group">
							<br>
							<button data-toggle="dropdown" class="btn btn-danger ">Exportar <span class="caret"></span></button>
								<ul class="dropdown-menu">
									<li><a onclick="">PDF</a></li>
									<li><a onclick="" class="font-bold">Excel</a></li>
									
								</ul>
						</div>	
					</div> 	
				</div>
				</br>
				</br>
				</br>
				<table id="tabla" data-toggle="table" data-url="obtenerVales" data-show-refresh="true" data-show-toggle="false" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true"  data-sort-name="name" data-sort-order="desc">
				    <thead>
				    <tr>

				        <th data-field="serie"   data-halign="center" data-sortable="true">Serie</th>
				        <th data-field="folio" data-halign="center"data-sortable="true">Folio</th>
				        <th data-field="id_distribuidor" data-sortable="true">Distribuidor</th>
				         <th data-field="id_cliente" data-sortable="true">Cliente</th>
				          <th data-field="fecha_venta" data-sortable="true">Fecha Venta</th>
				        <th data-field="cantidad" data-halign="center" data-sortable="true">Deuda</th>
				        <th data-field="numero_pagos" data-halign="center" data-sortable="true">Total pagos</th>
				        <th data-field="pagos_realizados" data-halign="center" data-sortable="true">Pagos realizados</th>
				        <th data-field="deuda_actual"data-halign="center" data-sortable="true">Adeudo</th>
				        <th data-field="estatus" data-halign="center"  data-sortable="true">Estatus</th>
				        <th data-field="id_vale" data-halign="center" data-sortable="true">Acciones</th>
				    </tr>
				    </thead>
				</table>
			</div>
		</div>
	</div>
@stop


@section ('js') 
<script src="js/consultarVales.js"></script>
@stop