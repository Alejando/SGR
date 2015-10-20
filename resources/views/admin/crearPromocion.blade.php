@extends ('m_admin')

@section ('titulo') pagina 2
@stop

@section ('contenido')

<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">Crear Promoción</div>
					<div class="panel-body">
						 @if(Session::has('message'))
		                    <div class="alert alert-{{ Session::get('class') }}">{{ Session::get('message')}}</div>
		                
		                @endif
						<div class="col-md-6">
							<label>Datos de la promoción</label>
							<form class="form" role="form" method="POST" action="guardarPromocion" enctype="multipart/form-data">
     					    <input type="hidden" name="_token" value="{{ csrf_token() }}">
								<div class="form-group">
									<label>Tipo de promoción</label>
									<select name="tipo_promocion" class="form-control" id="tipo_promocion">
									  <option class="form-control">Selecciona promoción</option>
									  <option value="1" class="form-control">Empiece a pagar a partir de una fecha</option>
									  <option value="2" class="form-control">Pague a un número de quincenas</option>
									</select>
								</div>
								
			                    	<div id="nuevaPromocion"></div>
			                    
				
							<div class="col-md-12">
								<div class="pull-right">
										<button type="reset" class="btn btn-danger ">Borrar datos</button>
										<button type="submit" class="btn btn-success ">Enviar datos</button>
								</div>
							</div>	
						</form>
						</div>
						
					</div>
				</div>
			</div><!-- /.col-->
		</div><!-- /.row -->
		
	</div><!--/.main-->
						<!--div class="col-md-12">
								<div class="form-group col-md-4">
									<label>Fecha de inicio</label>
									<input type="date"  name="fecha_inicio" class="form-control" required>
								</div>
								<div class="form-group col-md-4">
									<label>Fecha de creación</label>
									<input type="date"  name="fecha_creacion" class="form-control" required>
								</div>	
								<div class="form-group col-md-4">
									<label>Fecha de termino</label>
									<input type="date"  name="fecha_termino" class="form-control" >
								</div>		
							</div>
							<div class="col-md-12">
								<div class="form-group col-md-6">
									<label>Fecha de creación</label>
									<input type="date"  name="fecha_creacion" class="form-control" required>
								</div>	
								<div class="form-group col-md-6">
									<label>Fecha de termino</label>
									<input type="date"  name="fecha_termino" class="form-control" >
								</div>		
							</div-->

@stop