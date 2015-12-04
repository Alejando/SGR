<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reporte 7</title>

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
          <td class="medio invisible" id="subtitulo">Reporte global de deudores</td> 
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
            <th id="cliente" >Nombre</th>
            <th>Cantidad</th>
            <th>Abono</th>
            <th>Fecha corte</th>
            <th>Fecha limite</th>
            <th>Comisión actual</th>
            <th>Estado</th>
          </tr>
        </thead>
        <tbody>

         @foreach ($datas as $data)
          <tr>
            <td>{{$data->id_distribuidor}}</td>
            <td>{{$data->cantidad}}</td>
            <td>{{$data->abono}}</td>
            <td>{{$data->fecha_creacion}}</td>
            <td>{{$data->fecha_limite}}</td>
            <td>{{$data->comision}}</td>
            <td>{{$data->estado}}</td>
          </tr>

           @endforeach
        </tbody>
        <tfoot>
          <tr>
            <td>Total</td>
            <td>${{$saldoTotal}}.00</td>
            <td>${{$saldoTotalAbono}}.00</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
        </tfoot>
      </table>
  </body>
</html>