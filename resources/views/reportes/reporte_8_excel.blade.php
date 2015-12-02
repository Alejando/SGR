<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reporte 2</title>

    <link href="css/reporte_6_excel.css"  rel="stylesheet">

  </head>
  <body>

    <main>
    	<table>
	        <tr>
	          <td><b>ZAPATERIA EL GRAN REMATE</b></td>
	        </tr>
	        <tr>
	          <td><b>Reporte Historico</b></td>    
	        </tr>
	        <tr>
	          <td><b>Fecha:</b>{{$fechaHoy}}</td>
	        </tr>
	        <tr>
	          <td><b>Distribuidor: {{$distribuidor}}</b></td>
	        </tr>
      	</table>

      <br>
      <table>
        <thead id="encabezado">
          <tr>
            <th id="cliente" >Cliente</th>
            <th class="campo">Vale</th>
            <th class="campo">Folio de venta</th>
            <th class="campo">Importe</th>
            <th class="campo">Fecha de venta</th>
          </tr>
        </thead>
        <tbody>
         @foreach ($datas as $data)
          <tr>
            <td>{{$data->id_cliente}}</td>
            <td>{{$data->folio}}</td>
            <td>{{$data->folio_venta}}</td>
            <td>{{$data->cantidad}}</td>
            <td>{{$data->fecha_venta}}</td>
          </tr>

           @endforeach
        </tbody>
        <tfoot>
          <tr>
            <td></td>
            <td></td>
            <td><b>Total<b></td>
            <td>{{$saldoTotal}}.00</td>
            <td ></td>
            
          </tr>
        </tfoot>
      </table>
  </body>
</html>