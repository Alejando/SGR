@extends ('m_admin')

@section ('titulo') Consultar Promociones
@stop

@section ('contenido')
	<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">Promociones</div>
					<div class="panel-body">
						@if(Session::has('message'))
                            <div class="alert alert-{{ Session::get('class') }}">{{ Session::get('message')}}</div>
                        @endif
						<table data-toggle="table" data-url="obtenerPromociones"  data-show-refresh="true" data-show-toggle="false" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
						    <thead>
						    <tr>
						        <th data-field="tipo_promocion" data-halign="center"data-sortable="true">Tipo de promoción</th>
						        <th data-field="fecha_creacion" data-halign="center" data-sortable="true">Creación de promoción</th>
						        <th data-field="fecha_termino"  data-halign="center" data-sortable="true">Termino de promoción</th>
						        <th data-field="fecha_inicio" data-halign="center" data-sortable="true">Primer pago</th>
						        <th data-field="acciones"  data-halign="center" data-sortable="true">Acciones</th>
						    </tr>
						    </thead>
						</table>
					</div>
				</div>
			</div>
		</div><!--/.row-->	

@stop