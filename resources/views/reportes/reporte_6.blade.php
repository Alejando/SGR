<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reporte 6</title>

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
          <td class="medio invisible" id="subtitulo">Reporte de pago de distribuidoras</td> 
          <td class="medio invisible"></td>
        </tr>
        <tr>
          <td class="medio invisible" colspan="3" id="distribuidor"></td>
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
            <th id="cliente" >Nombre</th>
            <th>Pago sin Comision </th>
            <th>Comisión</th>
            <th>Pago con Comisión</th>
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
            <td >Total</td>
            <td >${{$SaldoTotalSinComision}}.00</td>
            <td></td>
            <td>${{$SaldoTotalConComision}}.00</td>
          </tr>
        </tfoot>
      </table>
  </body>
</html>