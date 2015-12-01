@extends ('m_admin')

@section ('titulo') Consultar pagos
@stop

@section ('contenido')
	<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">Consultar pagos</div>
					<div class="panel-body">
						<table data-toggle="table" data-url="obtenerPagos"  data-show-refresh="true" data-show-toggle="false" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
						    <thead>
						    <tr>

						        <th data-field="id_pago" data-sortable="true">Id</th>
						        <th data-field="id_distribuidor" data-halign="center"data-sortable="true">Distribuidor</th>
						        <th data-field="cantidad"   data-halign="center"data-sortable="true">Cantidad</th>
						        <th data-field="fecha_creación"  data-sortable="true">Fecha corte</th>
						        <th data-field="fecha_limite"   data-halign="center"data-sortable="true">Fecha limite</th>
						        <th data-field="comision"   data-halign="center"data-sortable="true">Comisión actual</th>
						        <th data-field="estado"   data-halign="center"data-sortable="true">estado</th>
						        <th data-field="acciones" data-halign="center" data-sortable="true">Acciones</th>
						    </tr>
						    </thead>
						</table>
					</div>
				</div>
			</div>

@stop