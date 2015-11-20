<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Example 2</title>
<<<<<<< HEAD
  
=======
    <link href="css/pdf.css"  rel="stylesheet">
>>>>>>> origin/master
  </head>
  <body>

    <main>
      <div id="details" class="clearfix">
        <div id="invoice">
          <h1>INVOICE {{ $invoice }}</h1>
          <div class="date">Date of Invoice: {{ $date }}</div>
        </div>
      </div>
      
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
            <th>NORA AYRAM THALIA CASTILLO CAMACHO</th>
            <th>2142</th>
            <th>335229</th>
            <th>499.00</th>
            <th>289.00</th>
            <th>1 de 4</th>
            <th>632.00</th>
            <th>1,895.00</th>
          </tr>
          <tr>
            <th>EDREY CATALINA GONZALEZ DE LA ROSA</th>
            <th>2142</th>
            <th>335229</th>
            <th>499.00</th>
            <th>289.00</th>
            <th>1 de 4</th>
            <th>632.00</th>
            <th>1,895.00</th>
          </tr>
          <tr>
            <th>ALEJANDRO FERNANDO ROBERTO TEOFILO PRADO LOPEZ DEL ROSAL VERDE</th>
            <th>2142</th>
            <th>335229</th>
            <th>499.00</th>
            <th>289.00</th>
            <th>1 de 4</th>
            <th>632.00</th>
            <th>1,895.00</th>
          </tr>

        </tbody>
       
      </table>
      <table>
        <thead>
          <tr>
            <th class="no">Nombre</th>
            <th class="desc">DESCRIPTION*</th>
            <th class="unit">UNIT PRICE</th>
            <th class="total">TOTAL*</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="no">{{ $data['quantity'] }}</td>
            <td class="desc">{{ $data['description'] }}</td>
            <td class="unit">{{ $data['price'] }}</td>
            <td class="total">{{ $data['total'] }} </td>
          </tr>

        </tbody>
        <tfoot>
          <tr>
            <td colspan="2"></td>
            <td >TOTAL</td>
            <td>$6,500.00</td>
          </tr>
        </tfoot>
      </table>
  </body>
</html>