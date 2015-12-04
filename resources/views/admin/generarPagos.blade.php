@extends ('m_admin')

@section ('titulo') Generar pagos
@stop


@section ('contenido')

  <div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">Generar pagos</div>
					<div class="panel-body">
						 @if(Session::has('message'))
							<div  class="alert alert-{{ Session::get('class') }} alert-dismissable">
								    <button type="button" class="close" data-dismiss="alert">&times;</button>
								    <strong> {{ Session::get('message')}} </strong>
							</div>
						@endif
						<label>Nota: Si no se elige ningun campo, automaticamente generara todos los reportes correspondientes al periodo anterior</label>
					<div class="col-md-6">

 					    	<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<div class="form-group">
								<label>Selecionar fecha corte</label>
								<input type="date"  id="fecha" class="form-control" required>
							</div>
							<div class="form-group">
								<label>Selecionar Distribuidor</label>
								<input type="text"  id="id_distribuidor" class="form-control" required>
							</div>
							<div class="col-md-12">
								<div class="pull-right">
										<a data-toggle="modal" type="button" class="btn btn-success" data-target="#ventana" href="#">Generar pagos</a>
										
								</div>
							</div>	
						
					</div>

				</div>
			</div><!-- /.col-->
		</div><!-- /.row -->

			                                
        <div class="modal fade" id="ventana">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Alerta!</h4>
              </div>
              <div class="modal-body">
                <p>¿Esta usted seguro de que desea crear el pago?</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-small btn-danger" data-dismiss="modal">Cancelar</button>
                 <a class="btn btn-small btn-success" href="consultarPagos" onclick="generar()">Generar</a>
              </div>
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

@stop


@section ('js') 
<script src="js/generarPagos.js"></script>
@stop