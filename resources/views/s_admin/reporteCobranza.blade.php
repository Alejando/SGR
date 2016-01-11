@extends ('Layouts.m_super_admin')
@section ('titulo') Consultar Clientes
@stop

@section ('contenido')
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">Reporte Cobranza</div>
			<div class="col-lg-12">
					<div class="col-lg-4">
						<div class="form-group">
							<label>Distribuidor</label>
							<input type="text"  id="id_distribuidor" class="form-control" />
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label>Fecha Corte</label>
							<input type="date"  id="fecha" class="form-control" />	
						</div>
					</div>
					<div class="col-lg-1">
						<div class="form-group">
							<br>
							<p  id="consultar" class="btn btn-primary" onclick="mostrarTabla()"> Consultar </p>
						</div>	
					</div>
					<div class="col-lg-1">
						<div class="btn-group">
							<br>
							<button data-toggle="dropdown" class="btn btn-warning ">Exportar <span class="caret"></span></button>
								<ul class="dropdown-menu">
									<li><a onclick="mostrarPDF()">PDF</a></li>
									<li><a onclick="mostrarExcel()" class="font-bold">Excel</a></li>
									<li><a onclick="mostrarReporte1()" class="font-bold">Comprobantes A</a></li>
									<li><a onclick="mostrarReporte1b()" class="font-bold">Comprobantes B</a></li>
								</ul>
						</div>	
					</div>	
					<!--div class="col-lg-1">
						<div class="form-group">
							<label>--</label>
							<p  id="pdf"class="btn btn-primary" onclick="mostrarPDF()"> Mostrar PDF </p>
						</div>	
					</div>
					<div class="col-lg-1">
						<div class="form-group">
							<label>--</label>
							<p  id="pdf"class="btn btn-primary" onclick="mostrarExcel()">Mostrar Excel </p>
						</div>	
					</div-->	
				</div>
				</br>
				</br>
				<div class="panel-body">
					<table  id="table" data-toggle="table" data-pagination="true"   >
					    <thead>
					    	<tr>
						        <th data-field="id_cliente" data-sortable="true">Cliente</th>
						        <th data-field="folio" data-halign="center"data-sortable="true">Vale</th>
						        <th data-field="folio_venta" data-halign="center"  data-sortable="false">Folio Venta</th>
						        <th data-field="fecha_inicio_pago" data-halign="center"  data-sortable="false">Fecha venta</th>
						        <th data-field="cantidad" data-halign="center" data-sortable="true">Importe</th>
						        <th data-field="numero_pagos" data-halign="center" data-sortable="true">Saldo Anterior</th>
						        <th data-field="pagos_realizados" data-halign="center" data-sortable="true">Pagos</th>
						        <th data-field="cantidad_limite" data-halign="center" data-sortable="true">Abono</th>
						         <th data-field="deuda_actual"  data-halign="center" data-sortable="true">Saldo Actual</th>
					   		 </tr>
					    </thead>
					</table>
				</div>
		</div>
	</div>
@stop
@section ('js') <script src="js/reporteCobranza.js"></script>
@stop