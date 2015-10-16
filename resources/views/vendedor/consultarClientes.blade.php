@extends ('m_vendedor')

@section ('titulo') Consultar Clientes
@stop

@section ('contenido')

	<div class="col-sm-9 col-sm-offset-3 col-lg-12 col-lg-offset-0 main">			

		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">Consultar clientes</div>
					<div class="panel-body">
						<table data-toggle="table"  data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
						    <thead>
						    <tr>
						        <th data-sortable="true">Nombre</th>
						        <th data-sortable="true">Teléfono</th>
						        <th data-sortable="true">Celular</th>
						        <th data-sortable="true">Dirección</th>
						        <th class="col-lg-1">Acciones</th>
						    </tr>
						    </thead>
						    <tbody>
						        @foreach($clientes as $cliente)
					            <tr>
					                <td>{{ $cliente->nombre }} </td>
					                <td>{{ $cliente->telefono }} </td>
					                <td>{{ $cliente->celular }} </td>
					                <td>{{ $cliente->calle }}, #{{ $cliente->numero_exterior }}, {{ $cliente->colonia }}, {{ $cliente->municipio }}, {{ $cliente->estado }}, {{ $cliente->codigo_postal }} </td>
					                <td><a type="button" class="btn btn-primary margin" href="{{ URL::to('editarCliente/' . $cliente->id_cliente) }}">Actualizar</a></td>
					                
					            </tr>
						        @endforeach
					        </tbody>
						</table>
					</div>
				</div>
			</div>
			
			
		
	</div><!--/.main-->

	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/chart.min.js"></script>
	<script src="js/chart-data.js"></script>
	<script src="js/easypiechart.js"></script>
	<script src="js/easypiechart-data.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script src="js/custom.js"></script>
	<script src="js/bootstrap-table.js"></script>
		


@stop