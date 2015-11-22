@extends ('Layouts.m_super_admin')

@section ('titulo') Consultar Cuentas Vendedor
@stop

@section ('contenido')
	<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">Cuentas</div>
					<div class="panel-body">
					@if(Session::has('message'))
						<div class="alert alert-{{ Session::get('class') }} alert-dismissable">
						    <button type="button" class="close" data-dismiss="alert">&times;</button>
						    <strong> {{ Session::get('message')}} </strong>
					    </div> 	                
		            @endif
						<table data-toggle="table" data-url="obtenerComisiones"  data-show-refresh="true" data-show-toggle="false" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
						    <thead>
						    <tr>

						        <th data-field="cantidad_inicial" data-sortable="true">Cantidad inicial</th>
						        <th data-field="cantidad_final" data-halign="center"data-sortable="true">Cantidad final</th>
						        <th data-field="porcentaje"   data-halign="center"data-sortable="true">Porcentaje (%)</th>
						        <th data-field="id_comision" data-halign="center" data-sortable="true">Acciones</th>
						    </tr>
						    </thead>
						</table>
					</div>
				</div>
			</div>
		</div><!--/.row-->	

@stop