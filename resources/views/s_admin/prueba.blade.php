@extends ('Layouts.m_super_admin')

@section ('titulo') pagina 2
@stop

@section ('contenido')

  <div class="row row-no-gutter col-no-gutter-container">
			<div class="col-md-6 col-no-gutter">
				<div class="panel panel-default">
					<div class="panel-heading">New Visitors</div>
					<div class="panel-body">
						<div class="canvas-wrapper">
							<canvas class="chart" id="bar-chart" ></canvas>
						</div>
					</div>
				</div>
			</div><!--/.col-->
			
			<div class="col-md-6 col-no-gutter">
				<div class="panel panel-default">
					<div class="panel-heading">Activity</div>
					<div class="panel-body">
						<div class="canvas-wrapper">
							<canvas class="chart" id="radar-chart" ></canvas>
						</div>
					</div>
				</div>
			</div><!--/.col-->
		</div><!--/.row-->

@stop