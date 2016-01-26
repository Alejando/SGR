<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reporte 9</title>

    <link href="css/pdf.css"  rel="stylesheet">

  </head>
  <body>

    <main>

      <table>
        <tr>
          <td class="medio invisible" id="logo" rowspan="2"><img height="60" width="100" src="img/logoGR.jpg"></td>
          <td class="medio invisible" id="titulo">ZAPATERIA EL GRAN REMATE</td> 
          <td class="medio invisible" id="fecha">{{$fechaHoy}}</td>
        </tr>
        <tr>
          <!--td class="medio invisible">B1 -logo </td-->
          <td class="medio invisible" id="subtitulo">Reporte vales</td> 
          <td class="medio invisible"></td>
        </tr>
        <tr>
          <td class="medio invisible" colspan="3" id="distribuidor"></td>
          <!--td class="medio invisible">C2</td> 
          <td class="medio invisible">C4</td-->
        </tr>
        <tr>
          <td class="medio invisible" id="fechaReporte"></td>
          <td class="medio invisible" id="periodo"></td> 
          <td class="medio invisible" id="fechaLimite"></td>
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
            <td>{{$vale->deuda_actual}}</td>
            <td>{{$vale->total_pagos}}</td>
            <td>{{$vale->pagos_realizados}}</td>
            <td>{{$vale->adeudo}}</td>
            <td>{{$vale->estatus}}</td>
          </tr>
        @endforeach
        </tbody>
        <!--tfoot>
          <tr>
            <td></td>
            <td>${{$saldoTotal}}.00</td>
            <td>${{$saldoTotalAbono}}.00</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
        </tfoot-->
      </table>
  </body>
</html>