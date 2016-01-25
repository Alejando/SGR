@extends ('Layouts.m_super_admin')

@section ('titulo') Consultar Distribuidores
@stop

@section ('contenido')
	<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">Cuentas</div>
					<div class="panel-body">
						<table data-toggle="table" data-url="obtenerDistribuidores"  data-show-refresh="true" data-show-toggle="false" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
						    <thead>
						    <tr>
						    	<th data-field="id_distribuidor" data-sortable="true">ID</th>
						        <th data-field="nombre" data-sortable="true">Nombre</th>
						        <th data-field="telefono" data-halign="center"data-sortable="true">Teléfono</th>
						        <th data-field="celular"   data-halign="center"data-sortable="true">Celular</th>
						        <th data-field="limite_credito"  data-sortable="true">Limite credito</th>
						        <th data-field="limite_vale"  data-sortable="true">Limite vale</th>
						        <th data-field="saldo_actual"  data-sortable="true">Saldo actual</th>
						        <th data-field="comision"  data-sortable="true">Comisión</th>
						        <th data-field="acciones" data-halign="center" data-sortable="true">Acciones </th> 
						    </tr>
						    </thead>
						</table>
					</div>
				</div>
			</div>
		</div><!--/.row-->	

@stop