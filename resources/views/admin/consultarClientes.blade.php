@extends ('m_admin')

@section ('titulo') Consultar Clientes
@stop

@section ('contenido')
	<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">Vales</div>
					<div class="panel-body">
						<table data-toggle="table" data-url="obtenerClientes"  data-show-refresh="true" data-show-toggle="false" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
						    <thead>
						    <tr>

						        <th data-field="nombre" data-sortable="true">Nombre</th>
						        <th data-field="telefono" data-halign="center"data-sortable="true">Teléfono</th>
						        <th data-field="celular"   data-halign="center"data-sortable="true">Celular</th>
						        <th data-field="calle"  data-sortable="true">Dirección</th>
						        <th data-field="id_cliente" data-halign="center" data-sortable="true">Acciones</th>
						    </tr>
						    </thead>
						</table>
					</div>
				</div>
			</div>
		</div><!--/.row-->	

@stop