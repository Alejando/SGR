@extends ('m_vendedor')

@section ('titulo') Consultar vales
@stop

@section ('contenido')
  
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">Vales</div>
					<div class="panel-body">
						<table data-toggle="table" data-url="obtenerValesV"  data-show-refresh="true" data-show-toggle="false" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
						    <thead>
						    <tr>

						        <th data-field="serie" data-halign="center" data-sortable="true">Serie</th>
						        <th data-field="folio" data-halign="center"data-sortable="true">Folio</th>
						        <th data-field="id_distribuidor"  data-sortable="true">Dsitribuidor</th>
						        <th data-field="cantidad" data-halign="center" data-sortable="true">Deuda</th>
						        <th data-field="numero_pagos" data-halign="center" data-sortable="true">Total pagos</th>
						        <th data-field="pagos_realizados" data-halign="center" data-sortable="true">Pagos realizados</th>
						        <th data-field="deuda_actual"data-halign="center" data-sortable="true">Adeudo</th>
						        <th data-field="estatus" data-halign="center" data-sortable="true">Estatus</th>
						    </tr>
						    </thead>
						</table>
					</div>
				</div>
			</div>
		</div><!--/.row-->	
@stop