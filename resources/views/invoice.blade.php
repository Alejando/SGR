<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Example 2</title>

    <!--link href="css/pdf.css"  rel="stylesheet"-->

  </head>
  <body>

    <main>

      <table>
        <tr>
          <td class="medio invisible" id="logo" rowspan="2"><img height="60" width="100" src="img/logoGR.jpg"></td>
          <td class="medio invisible" id="titulo">ZAPATERIA EL GRAN REMATE</td> 
          <td class="medio invisible" id="fecha"></td>
        </tr>
        <tr>
          <!--td class="medio invisible">B1 -logo </td-->
          <td class="medio invisible" id="subtitulo">Reporte de cobranza</td> 
          <td class="medio invisible"></td>
        </tr>
        <tr>
          <td class="medio invisible" colspan="3" id="distribuidor">Distribuidor: </td>
          <!--td class="medio invisible">C2</td> 
          <td class="medio invisible">C4</td-->
        </tr>
        <tr>
          <td class="medio invisible" id="fechaReporte">Fecha de reporte: </td>
          <td class="medio invisible" id="periodo">Periodo: </td> 
          <td class="medio invisible" id="fechaLimite">Fecha límite de pago: </td>
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
          <tr>
            <td>NORA AYRAM THALIA CASTILLO CAMACHO</td>
            <td>2142</td>
            <td>335229</td>
            <td>499.00</td>
            <td>289.00</td>
            <td>1 de 4</td>
            <td>632.00</td>
            <td>1,895.00</td>
          </tr>
          <tr>
            <td>EDREY CATALINA GONZALEZ DE LA ROSA</td>
            <td>2142</td>
            <td>335229</td>
            <td>499.00</td>
            <td>289.00</td>
            <td>1 de 4</td>
            <td>632.00</td>
            <td>1,895.00</td>
          </tr>
          <tr>
            <td>ALEJANDRO FERNANDO ROBERTO TEOFILO PRADO LOPEZ DEL ROSAL VERDE</td>
            <td>2142</td>
            <td>335229</td>
            <td>499.00</td>
            <td>289.00</td>
            <td>1 de 4</td>
            <td>632.00</td>
            <td>1,895.00</td>
          </tr>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="2"></td>
            <td colspan="4">Total</td>
            <td>3.091.00</td>
            <td></td>
          </tr>
          <tr>
            <td colspan="2"></td>
            <td colspan="4">Comision 11.00% Total a pagar</td>
            <td>2,751.00</td>
            <td></td>
          </tr>
        </tfoot>
      </table>
  </body>
</html>