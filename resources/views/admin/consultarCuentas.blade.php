@extends ('Layouts.m_super_admin')

@section ('titulo') Consultar Cuentas Vendedor
@stop

@section ('contenido')
	<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">Cuentas</div>
					<div class="panel-body">
						<table data-toggle="table" data-url="obtenerCuentas"  data-show-refresh="true" data-show-toggle="false" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
						    <thead>
						    <tr>
						   	 	<th data-field="tipo" data-sortable="true">Tipo</th>
						        <th data-field="nombre" data-sortable="true">Nombre</th>
						        <th data-field="telefono" data-halign="center"data-sortable="true">Teléfono</th>
						        <th data-field="usuario"   data-halign="center"data-sortable="true">Usuario</th>
						        <th data-field="contrasena"  data-sortable="true">Contraseña</th>
						        <th data-field="id_cuenta" data-halign="center" data-sortable="true">Acciones</th>
						    </tr>
						    </thead>
						</table>
					</div>
				</div>
			</div>
		</div><!--/.row-->	

@stop