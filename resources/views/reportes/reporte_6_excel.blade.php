<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reporte 6</title>

    <link href="css/reporte_6_excel.css"  rel="stylesheet">

  </head>
  <body>

    <main>
    	<table>
	        <tr>
	          <td><b>ZAPATERIA EL GRAN REMATE</b></td>
	        </tr>
	        <tr>
	          <td><b>Reporte de pago de distribuidoras</b></td>    
	        </tr>
	        <tr>
	          <td><b>Fecha:</b>{{$fechaHoy}}</td>
	        </tr>
	        <tr>
	          <td><b>Fecha de reporte: </b>{{$fechaEntrega}}</td>
	        </tr>
	        <tr>  
	          <td><b>Periodo: </b>{{$periodo}}</td>
	        </tr>
	        <tr>   
	          <td><b>Fecha límite de pago: </b>{{$fechaLimite}}</td>
	        </tr>
      	</table>
      <br>
      <table>
        <thead id="encabezado">
          <tr>
            <th id="cliente" >Nombre</th>
            <th class="campo">Pago sin Comision </th>
            <th class="campo">Comisión</th>
            <th class="campo">Pago con Comisión</th>
          </tr>
        </thead>
        <tbody>

         @foreach ($datas as $data)
          <tr>
            <td>{{$data->nombre}}</td>
            <td>{{$data->id_comision}}</td>
            <td>{{$data->telefono}}</td>
            <td>{{$data->celular}}</td>
          </tr>

           @endforeach
        </tbody>
        <tfoot>
          <tr>
            <td ><b>Total<b></td>
            <td >{{$SaldoTotalSinComision}}.00</td>
            <td></td>
            <td>{{$SaldoTotalConComision}}.00</td>
          </tr>
        </tfoot>
      </table>
  </body>
</html>