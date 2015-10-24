@extends ('m_vendedor')

@section ('titulo') Consultar Promociones
@stop

@section ('contenido')
	<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">Vales</div>
					<div class="panel-body">
						<table data-toggle="table" data-url="obtenerPromociones"  data-show-refresh="true" data-show-toggle="false" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
						    <thead>
						    <tr>
						        <th data-field="tipo_promocion" data-halign="center"data-sortable="true">Tipo de promoción</th>
						        <th data-field="fecha_creacion" data-halign="center" data-sortable="true">Creación de promoción</th>
						        <th data-field="fecha_termino"  data-halign="center" data-sortable="true">Termino de promoción</th>
						         <th data-field="fecha_inicio" data-halign="center" data-sortable="true">Primer pago</th>
						         
						    </tr>
						    </thead>
						</table>
					</div>
				</div>
			</div>
		</div><!--/.row-->	

@stop