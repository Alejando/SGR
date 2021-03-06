<div style="page-break-after: always;">
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
    <tr id="encabezado" >
        <th id="cliente" >Cliente</th>
        <th>Vale</th>
        <th>Folio Venta</th>
        <th>Fecha Venta</th>
        <th>Pagos</th>
        <th>Importe</th>
        <th>Saldo Anterior</th>
        <th>Abono</th>
        <th>Saldo Actual</th>
      </tr>
    
    <tbody>
     @foreach ($datas as $key=> $data)
       @if($key==65)
        <tr id="encabezado" >
          <td id="cliente" >Cliente</td>
          <td>Vale</td>
          <td>Folio Venta</td>
          <td>Fecha Venta</td>
          <td>Pagos</td>
          <td>Importe</td>
          <td>Saldo Anterior</td>
          <td>Abono</td>
          <td>Saldo Actual</td>
      </tr>
      @endif
      <tr>
        <td>{{$key}}{{$data->id_cliente}}</td>
        <td>{{$data->folio}}</td>
        <td>{{$data->folio_venta}}</td>
        <td>{{$data->fecha_inicio_pago}}</td>
        <td>{{$data->pagos_realizados}}</td>
        <td>{{$data->cantidad}}</td>
        <td>{{$data->numero_pagos}}</td>
        <td>{{$data->cantidad_limite}}</td>
        <td>{{$data->deuda_actual}}</td>
      </tr>

       @endforeach
    </tbody>
    <tfoot>
      <tr>
        <td></td>
        <td>{{$totalVales}} Vales</td>
        <td colspan="3">Totales</td>
        <td >${{$saldoImporte}}.00</td>
        <td >${{$saldoAnteriorTotal}}.00</td>
        <td>${{$saldoTotal}}.00</td>
        <td>${{$saldoActualTotal}}.00</td>
      </tr>
      <tr>
        <td></td>
        <td colspan="2"></td>
        <td colspan="4" class="resaltar"><b>Saldo total ${{$saldoTotal}}, Comision {{$comision}}% Total a pagar</b></td>
        <td class="resaltar"><b>${{$saldoComision}}.00</b></td>
        <td></td>
      </tr>
    </tfoot>
  </table>
</div>