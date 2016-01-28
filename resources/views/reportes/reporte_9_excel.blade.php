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
	          <td><b>Reporte vales</b></td>    
	        </tr>
	        <tr>
	          <td><b>Fecha:</b>{{$fechaHoy}}</td>
	        </tr>
      	</table>
      <br>
      <table>
        <thead id="encabezado">
          <tr>
            <th>Serie</th>
            <th>Folio</th>
            <th>Distribuidor</th>
            <th>Cliente</th>
            <th>Fecha Venta</th>
            <th>Deuda</th>
            <th>Total de pagos</th>
            <th>Pagos realizados</th>
            <th>Adeudo</th>
            <th>Estatus</th>
          </tr>
        </thead>
        <tbody>

         @foreach ($vales as $vale)
          <tr>
            <td>{{$vale->serie}}</td>
            <td>{{$vale->folio}}</td>
            <td>{{$vale->id_distribuidor}}</td>
            <td>{{$vale->id_cliente}}</td>
            <td>{{$vale->fecha_venta}}</td>
            <td>{{$vale->cantidad}}</td>
            <td>{{$vale->numero_pagos}}</td>
            <td>{{$vale->pagos_realizados}}</td>
            <td>{{$vale->deuda_actual}}</td>
            <td>{{$vale->estatus}}</td>
          </tr>
        @endforeach
        </tbody>
        
      </table>
  </body>
</html>