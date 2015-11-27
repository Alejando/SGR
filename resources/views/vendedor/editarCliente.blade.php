@extends ('Layouts.m_vendedor_show')

@section ('titulo') Editar Cliente
@stop

@section ('contenido')

  <div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">Editar Clientes</div>
					<div class="panel-body">
						 @if(Session::has('message'))
						<div class="alert alert-{{ Session::get('class') }} alert-dismissable">
						    <button type="button" class="close" data-dismiss="alert">&times;</button>
						    <strong> {{ Session::get('message')}} </strong>
					    </div>
						 	                
		                @endif
						<div class="col-md-6">
							<label>Datos Cliente</label>
							<form class="form" role="form" method="POST" action="{{URL::to('actualizarCliente/').'/'.$cliente->id_cliente}}" enctype="multipart/form-data">
     					    <input type="hidden" name="_token" value="{{ csrf_token() }}">
								<div class="form-group">
									<label>Nombre</label>
									<input type="text" value="{{ $cliente->nombre }}"  name="nombre" class="form-control" required>
								</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Teléfono</label>
									<input type="text" value="{{ $cliente->telefono }}" name="telefono" class="form-control" required>
								</div>
								<div class="form-group">
									<label>Número de elector</label>
									<input type="number" value="{{ $cliente->numero_elector }}" name="numero_elector" class="form-control" required>
								</div>	
								<div class="form-group">
									<label>Número exterior</label>
									<input type="text" value="{{ $cliente->numero_exterior }}"  name="numero_exterior" class="form-control" >
								</div>		
								<div class="form-group">	
									<label>Colonia</label>
									<input type="text"  value="{{ $cliente->colonia }}" name="colonia" class="form-control" required>
								</div>
								<div class="form-group">	
									<label>Estado</label>
									<input type="text" value="{{ $cliente->estado }}" name="estado" class="form-control" required>
								</div>
									
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Celular</label>
									<input type="text"  value="{{ $cliente->celular }}" name="celular" class="form-control" required>
								</div>
								<div class="form-group">
									<label>Calle</label>
									<input type="text" value="{{ $cliente->calle }}"  name="calle" class="form-control" required>
								</div>	
								<div class="form-group">
									<label>Número interior</label>
									<input type="text"  value="{{ $cliente->numero_interior }}" name="numero_interior" class="form-control" >
								</div>		
								<div class="form-group">	
									<label>Municipio</label>
									<input type="text" value="{{ $cliente->municipio }}" name="municipio" class="form-control" required>
								</div>
								<div class="form-group">	
									<label>Código Postal</label>
									<input type="number"  value="{{ $cliente->codigo_postal }}" name="codigo_postal" class="form-control" required>
								</div>	
							</div>	
						</div>
							
							
							<div class="col-md-12">
								<div class="pull-right">
										<button type="reset" class="btn btn-danger ">Borrar datos</button>
										<button type="submit" class="btn btn-success ">Enviar datos</button>
								</div>
							</div>	
						</form>
						
					</div>
				</div>
			</div><!-- /.col-->
		</div><!-- /.row -->
		
	</div><!--/.main-->

@stop