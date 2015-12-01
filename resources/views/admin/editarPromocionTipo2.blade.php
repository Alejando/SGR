@extends ('Layouts.m_admin_show')
@section ('titulo') Editar promoción
@stop

@section ('contenido')

<div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Editar Promoción</div>
                    <div class="panel-body">
                         @if(Session::has('message'))
                            <div  class="alert alert-{{ Session::get('class') }} alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <strong> {{ Session::get('message')}} </strong>
                            </div>
                        @endif
                        <div class="col-md-6">
                            <label>Datos de la promoción</label>
                            <form class="form" role="form" method="POST" action="{{URL::to('actualizarPromocion/').'/'.$promocion->id_promocion}}" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-group">
                                	<div class="col-md-12">
                                		<div class="form-group col-md-12">
                                			<label>Número de pagos</label>
                                			<select name="numero_pagos" class="form-control" id="numero_pagos">
                                			@if($promocion->numero_pagos == 6)
                                				<option selected="selected" value="6" class="form-control">A 6 quincenas</option>
                                				<option value="8" class="form-control">A 8 quincenas</option>
                                			@endif
                                			@if($promocion->numero_pagos == 8)
                                				<option value="6" class="form-control">A 6 quincenas</option>
                                				<option selected="selected" value="8" class="form-control">A 8 quincenas</option>
                                			@endif
                                			</select>
                                		</div>
                                		<div class="form-group col-md-6">
                                			<label>Fecha de inicio</label>
                                			<input type="date"  value="{{ $promocion->fecha_creacion }}" name="fecha_creacion" class="form-control" required>
                                		</div>
                                		<div class="form-group col-md-6">
                                			<label>Fecha de termino</label>
                                			<input type="date"  value="{{ $promocion->fecha_termino }}" name="fecha_termino" class="form-control" >
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
                </div>
            </div><!-- /.col-->
        </div><!-- /.row -->
        
    </div><!--/.main-->

@stop