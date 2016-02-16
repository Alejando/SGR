@extends ('m_vendedor')

@section ('titulo') Consultar vales
@stop
@section ('css') 
	<link href="css/reporteVendedor.css"  rel="stylesheet">
@stop
@section ('contenido')
  
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">Vales</div>
					<div class="col-lg-12">
						
						<div class="col-lg-4">
							<div class="form-group">
								<label>Fecha Corte</label>
								<input type="date"  id="fecha" class="form-control" />	
							</div>
						</div>
						<div class="col-lg-1">
							<div class="form-group">
								<label>--</label>
								<p  id="consultar" class="btn btn-primary" onclick="mostrarTabla()"> Consultar </p>
							</div>	
						</div>	
						<div class="col-lg-1">
							<div class="form-group">
								<label>--</label>
								<p  class="btn btn-primary" onclick="imprimir()"> imprimir </p>
							</div>	
						</div>	
					</div>
					</br>
					</br>
					<div class="panel-body">
						<table id="table"data-toggle="table" data-url="obtenerValesV"  data-show-refresh="true" data-show-toggle="false" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
						    <thead>
						    <tr>
						        <th data-field="serie" data-halign="center" data-sortable="true">Serie</th>
						        <th data-field="folio" data-halign="center"data-sortable="true">Folio</th>
						        <th data-field="id_distribuidor"  data-sortable="true">Dsitribuidor</th>
						        <th data-field="cantidad" data-halign="center" data-sortable="true">Deuda</th>
						        <th data-field="numero_pagos" data-halign="center" data-sortable="true">Total pagos</th>
						        <th data-field="estatus" data-halign="center" data-sortable="true">Estatus</th>
						    </tr>
						    </thead>
						</table>
					</div>
				</div>
			</div>

			<div id="ticket" style="display: none">
			<p class="titulo">Zapatería "El Gran Remate" </p>
			<p class="titulo">Pasaje Hidalgo #218 Col.Centro </p>
			<p class="titulo">CP. 99000 Fresnillo, zacatecas</p>
			<p class="titulo">Corte de Ventas </p>
			
			<p class="texto" id="pFecha">Fecha: Juanito</p>
			
			<div id="vales"></div>

			<br>
			<br>
			<hr>
				
		</div>
@stop

@section ('js') <script src="js/consultarValesV.js"></script>
@stop