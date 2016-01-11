<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reporte 2</title>

    <link href="css/reporte_2_excel.css"  rel="stylesheet">

  </head>
  <body>

    <main>

      <table>
        <tr>
          <td><b>ZAPATERIA EL GRAN REMATE</b></td>
        </tr>
        <tr>
          <td><b>Reporte de cobranza</b></td>    
        </tr>
        <tr>
          <td><b>Fecha:</b>{{$fechaHoy}}</td>
        </tr>
        <tr>
          <td><b>Distribuidor:</b> {{$distribuidor}}</td>
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
            <th id="cliente" >Cliente</th>
            <th class="campo">Vale</th>
            <th class="campo">Folio Venta</th>
             <th class="campo">Fecha Venta</th>
            <th class="campo">Importe</th>
            <th class="campo">Saldo Anterior</th>
            <th class="campo">Pagos</th>
            <th class="campo">Abono</th>
            <th class="campo">Saldo Actual</th>
          </tr>
        </thead>
        <tbody>
         @foreach ($datas as $data)
          <tr>
            <td>{{$data->id_cliente}}</td>
            <td>{{$data->folio}}</td>
            <td>{{$data->folio_venta}}</td>
             <td>{{$data->fecha_inicio_venta}}</td>
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
            <td></td>
            <td> {{$totalVales}} Vales</td>
            <td ><b>Totales</b></td>
            <td >{{$saldoImporte}}.00</td>
            <td >{{$saldoAnteriorTotal}}.00</td>
            <td></td>
            <td>{{$saldoTotal}}.00</td>
            <td>{{$saldoActualTotal}}.00</td>
          </tr>
          <tr>
            <td colspan="2"></td>
            <td colspan="4"><b>Comision {{$comision}}% Total a pagar</b></td>
            <td>{{$saldoComision}}.00</td>
            <td></td>
          </tr>
        </tfoot>
      </table>
  </body>
</html>