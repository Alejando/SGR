@extends ('m_admin')

@section ('titulo') Consultar Clientes
@stop

@section ('contenido')
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">Reporte Historico</div>
			<div class="col-lg-12">
					<div class="col-lg-4">
						<div class="form-group">
							<label>Distribuidor</label>
							<input type="text"  id="id_distribuidor" class="form-control" />
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
								</ul>
						</div>	
					</div>	
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
						        <th data-field="cantidad" data-halign="center" data-sortable="true">Importe</th>
						        <th data-field="fecha_venta"  data-halign="center" data-sortable="true">Fecha de venta</th>
					   		 </tr>
					    </thead>
					</table>
				</div>
		</div>
	</div>
@stop
@section ('js') <script src="js/reporteHistorico.js"></script>
@stop