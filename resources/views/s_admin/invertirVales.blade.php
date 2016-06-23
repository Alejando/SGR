@extends ('s_admin')

@section ('titulo') Invertir vales
@stop

@section ('css')

@stop
@section ('contenido')

   <div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">Invertir Vales</div>
				<div class="panel-body">
					@if(Session::has('message'))
                    <div id="mensaje"class="alert alert-{{ Session::get('class') }} alert-dismissable">
					    <button type="button" class="close" data-dismiss="alert">&times;</button>
					    <strong> {{ Session::get('message')}} </strong>
			    	</div>
	                @endif
					<div class="col-md-9">
						<!-- <label><strong>Nota: </strong> Sólo se pueden invertir vales de la misma serie</label> -->
						<form id="form"class="form" role="form" method="POST" action="invertirVales" >
 					    	<input type="hidden" name="_token" value="{{ csrf_token() }}">
						
												
							<div class="col-md-6">
								<div class="form-group">
									<label>Folio Vale 1</label>
									<input type="number"  name="vale_1" class="form-control" required>
								</div>	
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Serie vale 1</label>
									<input type="number"  name="serie_1"  class="form-control"  >
								</div>		
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Folio Vale 2</label>
									<input type="number"  name="vale_2" class="form-control" required>
								</div>	
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Folio serie 2</label>
									<input type="number"  name="serie_2"  class="form-control"  >
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
