@extends ('m_admin')

@section ('titulo') Consultar Clientes
@stop

@section ('contenido')
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">Reporte Deudores</div>
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
							<p  id="pdf"class="btn btn-primary" onclick="mostrarPDF()"> Mostrar PDF </p>
						</div>	
					</div>	
				</div>
				</br>
				</br>
				<div class="panel-body">
					<table  id="table" data-toggle="table" data-pagination="true"   >
					    <thead>
					    	<tr>
						        <th data-field="nombre" data-sortable="true">Distribuidora</th>
						        <th data-field="pagoSinComision" data-halign="center"data-sortable="true">Pago sin Comisión</th>
						        <th data-field="comision" data-halign="center"  data-sortable="false">Comisión (%) </th>
						        <th data-field="pagoConComision" data-halign="center" data-sortable="true">Pago con Comisión</th>
					   		 </tr>
					    </thead>
					</table>
				</div>
		</div>
	</div>
@stop
@section ('js') <script src="js/reporteDeudores.js"></script>
@stop