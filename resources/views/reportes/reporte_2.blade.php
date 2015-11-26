<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reporte 2</title>

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
          <td class="medio invisible" id="subtitulo">Reporte de cobranza</td> 
          <td class="medio invisible"></td>
        </tr>
        <tr>
          <td class="medio invisible" colspan="3" id="distribuidor">Distribuidor: {{$distribuidor}}</td>
          <!--td class="medio invisible">C2</td> 
          <td class="medio invisible">C4</td-->
        </tr>
        <tr>
          <td class="medio invisible" id="fechaReporte">Fecha de reporte: {{$fechaEntrega}}</td>
          <td class="medio invisible" id="periodo">Periodo: {{$periodo}}</td> 
          <td class="medio invisible" id="fechaLimite">Fecha límite de pago: {{$fechaLimite}}</td>
        </tr>
      </table>
      <br>
      <table>
        <thead id="encabezado">
          <tr>
            <th id="cliente" >Cliente</th>
            <th>Vale</th>
            <th>Folio Venta</th>
            <th>Importe</th>
            <th>Saldo Anterior</th>
            <th>Pagos</th>
            <th>Abono</th>
            <th>Saldo Actual</th>
          </tr>
        </thead>
        <tbody>
         @foreach ($datas as $data)
          <tr>
            <td>{{$data->id_cliente}}</td>
            <td>{{$data->folio}}</td>
            <td>{{$data->folio_venta}}</td>
            <td>{{$data->cantidad}}</td>
            <td>{{$data->numero_pagos}}</td>
            <td>{{$data->pagos_realizados}}</td>
            <td>{{$data->cantidad_limite}}</td>
            <td>{{$data->deuda_actual}}</td>
          </tr>

           @endforeach
        </tbody>
        <tfoot>
          <tr>
            <td colspan="2"></td>
            <td colspan="4">Total</td>
            <td>${{$saldoTotal}}.00</td>
            <td></td>
          </tr>
          <tr>
            <td colspan="2"></td>
            <td colspan="4">Comision {{$comision}}% Total a pagar</td>
            <td>${{$saldoComision}}.00</td>
            <td></td>
          </tr>
        </tfoot>
      </table>
  </body>
</html>