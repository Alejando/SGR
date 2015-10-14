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
						        <th data-field="state" data-checkbox="true" >Item ID</th>
						        <th data-field="id_cliente" data-sortable="true">Item ID</th>
						        <th data-field="nombre"  data-sortable="true">Item Name</th>
						        <th data-field="colonia" data-sortable="true">Item Price</th>
						        <th>Acciones</th>
						    </tr>
						    </thead>
						    <tbody>
						        @foreach($clientes as $cliente)
					            <tr>
					                <td>{{ $cliente->id_cliente }} </td>
					                <td>{{ $cliente->nombre }} </td>
					                <td>{{ $cliente->colonia }} </td>
					                
					            </tr>
						        @endforeach
					        </tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading">Basic Table</div>
					<div class="panel-body">
						<table data-toggle="table">
						    <thead>
						    <tr>
						        <th>Item ID</th>
						        <th>Item Name</th>
						        <th>Item Price</th>
						    </tr>
						    </thead>
						    <tbody>
						        @foreach($clientes as $cliente)
					            <tr>
					                <td>{{ $cliente->id_cliente }} </td>
					                <td>{{ $cliente->nombre }} </td>
					                <td>{{ $cliente->colonia }} </td>
					                
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