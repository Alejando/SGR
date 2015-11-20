@extends ('Layouts.m_super_admin')

@section ('titulo') Consultar Movimientos
@stop

@section ('contenido')
	<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">Movimientos</div>
					<div class="panel-body">
						<table data-toggle="table" data-url="obtenerMovimientos"  data-show-refresh="true" data-show-toggle="false" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
						    <thead>
						    <tr>
						   	 	<th data-field="id" data-sortable="true">Id</th>
						        <th data-field="id_cuenta" data-sortable="true">Cuenta</th>
						        <th data-field="fecha" data-halign="center"data-sortable="true">Fecha</th>
						        <th data-field="estado_anterior"   data-halign="center"data-sortable="true">Estado Anterior</th>
						        <th data-field="estado_actual"  data-sortable="true">Estado Actual</th>
						    </tr>
						    </thead>
						</table>
					</div>
				</div>
			</div>
		</div><!--/.row-->	

@stop