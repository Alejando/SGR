<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reporte 7</title>

    <link href="css/reporte_6_excel.css"  rel="stylesheet">

  </head>
  <body>

    <main>
      <table>
        <tr>
          <td><b>ZAPATERIA EL GRAN REMATE</b></td>
        </tr>
        <tr>
          <td><b>Reporte global de deudores</b></td>    
        </tr>
        <tr>
          <td><b>Fecha:</b>{{$fechaHoy}}</td>
        </tr>
      </table>
      <br>
      <table>
        <thead id="encabezado">
          <tr>
            <th id="cliente" >Nombre</th>
            <th class="campo">Cantidad</th>
            <th class="campo">Abono</th>
            <th class="campo">Cantidad a pagar</th>
            <th class="campo">Fecha corte</th>
            <th class="campo">Fecha limite</th>
            <th class="campo">Comisión actual</th>
            <th class="campo">Estado</th>
          </tr>
        </thead>
        <tbody>

         @foreach ($datas as $data)
          <tr>
            <td>{{$data->id_distribuidor}}</td>
            <td>${{$data->cantidad}}</td>
            <td>${{$data->abono}}</td>
            <td>${{$data->cantidad_comision}}</td>
            <td>{{$data->fecha_creacion}}</td>
            <td>{{$data->fecha_limite}}</td>
            <td>{{$data->comision}}</td>
            <td>{{$data->estado}}</td>
          </tr>

           @endforeach
        </tbody>
        <tfoot>
          <tr>
            <td><b>Total</b></td>
            <td>${{$saldoTotal}}.00</td>
            <td>${{$saldoTotalAbono}}.00</td>
            <td>${{$saldoTotalComision}}.00</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
        </tfoot>
      </table>
  </body>
</html>