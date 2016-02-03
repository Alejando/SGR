<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reporte 1</title>
    <link href="css/reporte_1.css"  rel="stylesheet">
  </head>
  <body>
  	@for ($i = 0; $i < sizeof($data); $i++)

  	@if($i%2==0)
	  		
	<table>
	    <tr>
	      <td colspan="9" class="encabezado">A1</td>
	      <!--td>A2</td>
	      <td>A3</td>
	      <td>A4</td>
	      <td>A5</td>
	      <td>A6</td>
	      <td>A7</td>
	      <td>A8</td>
	      <td>A9</td-->
	      <td class="division">x</td>
	      <td colspan="9" class="encabezado">A1</td>
	      <!--td>A2</td>
	      <td>A3</td>
	      <td>A4</td>
	      <td>A5</td>
	      <td>A6</td>
	      <td>A7</td>
	      <td>A8</td>
	      <td>A9</td-->
	    </tr>
	    <tr>
	      <td colspan="2">B1</td>
	      <!--td>B2</td-->
	      <td colspan="2" class="texto">{{$fechaHoy}}</td>
	      <!--td>B4</td-->
	      <td>B5</td>
	      <td colspan="2">B6</td>
	      <!--td>B7</td-->
	      <td colspan="2" class="texto">{{$data[$i]->folio}}</td>
	      <!--td>B9</td-->
	      <td>x</td>
	      <td colspan="2">B1</td>
	      <!--td>B2</td-->
	      <td colspan="2" class="texto">{{$fechaHoy}}</td>
	      <!--td>B4</td-->
	      <td>B5</td>
	      <td colspan="2">B6</td>
	      <!--td>B7</td-->@if($i+1 < sizeof($data))
	      <td colspan="2" class="texto">{{($data[$i+1]->folio)}}</td>
	      <!--td>B9</td-->@endif
	    </tr>

	    <tr>
	      <td class="espacio" colspan="9"></td>
	      <td class="division espacio"></td>
	      <td class="espacio" colspan="9"></td>
	    </tr>

	    <tr>
	      <td colspan="2">C1</td>
	      <!--td>C2</td-->
	      <td colspan="7">C3</td>
	      <!--td>C4</td>
	      <td>C5</td>
	      <td>C6</td>
	      <td>C7</td>
	      <td>C8</td>
	      <td>C9</td-->
	      <td>x</td>
	      <td colspan="2">C1</td>
	      <!--td>C2</td-->
	      <td colspan="7">C3</td>
	      <!--td>C4</td>
	      <td>C5</td>
	      <td>C6</td>
	      <td>C7</td>
	      <td>C8</td>
	      <td>C9</td-->
	    </tr>
	    <tr>
	      <td colspan="2" class="texto">{{$data[$i]->id_distribuidor}}</td>
	      <!--td>D2</td-->
	      <td colspan="7" class="texto">{{$distribuidor}}</td>
	      <!--td>D4</td>
	      <td>D5</td>
	      <td>D6</td>
	      <td>D7</td>
	      <td>D8</td>
	      <td>D9</td-->
	      <td>x</td>@if($i+1< sizeof($data))
	      <td colspan="2" class="texto">{{$data[$i+1]->id_distribuidor}}</td>
	      <!--td>D2</td-->
	      <td colspan="7" class="texto">{{$distribuidor}}</td>@endif
	      <!--td>D4</td>
	      <td>D5</td>
	      <td>D6</td>
	      <td>D7</td>
	      <td>D8</td>
	      <td>D9</td-->
	    </tr>
	    <tr>
	      <td colspan="2">E1</td>
	      <!--td>E2</td-->
	      <td colspan="7">E3</td>
	      <!--td>E4</td>
	      <td>E5</td>
	      <td>E6</td>
	      <td>E7</td>
	      <td>E8</td>
	      <td>E9</td-->
	      <td>x</td>
	      <td colspan="2">E1</td>
	      <!--td>E2</td-->
	      <td colspan="7">E3</td>
	      <!--td>E4</td>
	      <td>E5</td>
	      <td>E6</td>
	      <td>E7</td>
	      <td>E8</td>
	      <td>E9</td-->
	    </tr>
	    <tr>
	      <td colspan="2" class="texto">{{$data[$i]->id_vale}}</td>
	      <!--td>F2</td-->
	      <td colspan="7" class="texto">{{$data[$i]->id_cliente}}</td>
	      <!--td>F4</td>
	      <td>F5</td>
	      <td>F6</td>
	      <td>F7</td>
	      <td>F8</td>
	      <td>F9</td-->
	      <td>x</td>@if($i+1< sizeof($data))
	       <td colspan="2" class="texto">{{$data[$i+1]->id_vale}}</td>
	      <!--td>F2</td-->
	      <td colspan="7" class="texto">{{$data[$i+1]->id_cliente}}</td>@endif
	      <!--td>F4</td>
	      <td>F5</td>
	      <td>F6</td>
	      <td>F7</td>
	      <td>F8</td>
	      <td>F9</td-->
	    </tr>
	    <tr>
	      <td class="espacio" colspan="9"></td>
	      <td class="division"></td>
	      <td class="espacio" colspan="9"></td>
	    </tr>
	    <tr>
	      <td colspan="6">G1</td>
	      <!--td>G2</td>
	      <td>G3</td>
	      <td>G4</td>
	      <td>G5</td>
	      <td>G6</td-->
	      <td colspan="3" class="texto">{{$data[$i]->numero_pagos}}</td>
	      <!--td>G8</td>
	      <td>G9</td-->
	      <td>x</td>
	      <td colspan="6">G1</td>
	      <!--td>G2</td>
	      <td>G3</td>
	      <td>G4</td>
	      <td>G5</td>
	      <td>G6</td-->@if($i+1< sizeof($data))
	      <td colspan="3" class="texto">{{$data[$i+1]->numero_pagos}}</td>@endif
	      <!--td>G8</td>
	      <td>G9</td-->
	    </tr>
	    <tr>
	      <td colspan="6">H1</td>
	      <!--td>H2</td>
	      <td>H3</td>
	      <td>H4</td>
	      <td>H5</td>
	      <td>H6</td-->
	      <td colspan="3" class="texto">$0.00</td>
	      <!--td>H8</td>
	      <td>H9</td-->
	      <td>x</td>
	      <td colspan="6">H1</td>
	      <!--td>H2</td>
	      <td>H3</td>
	      <td>H4</td>
	      <td>H5</td>
	      <td>H6</td-->
	      <td colspan="3" class="texto">$0.00</td>
	      <!--td>H8</td>
	      <td>H9</td-->
	    </tr>
	    <tr>
	      <td colspan="6" class="texto" >Pago: {{$data[$i]->pagos_realizados}}</td>
	      <!--td>I2</td>
	      <td>I3</td>
	      <td>I4</td>
	      <td>I5</td>
	      <td>I6</td-->
	      <td colspan="3">I7</td>
	      <!--td>I8</td>
	      <td>I9</td-->
	      <td>x</td>@if($i+1< sizeof($data))
	     <td colspan="6" class="texto">Pago: {{$data[$i+1]->pagos_realizados}}</td>@endif
	      <!--td>I2</td>
	      <td>I3</td>
	      <td>I4</td>
	      <td>I5</td>
	      <td>I6</td-->
	      <td colspan="3">I7</td>
	      <!--td>I8</td>
	      <td>I9</td-->
	    </tr>
	    <tr>
	      <td colspan="6">J1</td>
	      <!--td>J2</td>
	      <td>J3</td>
	      <td>J4</td>
	      <td>J5</td>
	      <td>J6</td-->
	      <td colspan="3" class="texto">{{$data[$i]->numero_pagos}}</td>
	      <!--td>J8</td>
	      <td>J9</td-->
	      <td>x</td>
	      <td colspan="6">J1</td>
	      <!--td>J2</td>
	      <td>J3</td>
	      <td>J4</td>
	      <td>J5</td>
	      <td>J6</td-->@if($i+1< sizeof($data))
	      <td colspan="3" class="texto">{{$data[$i+1]->numero_pagos}}</td>@endif
	      <!--td>J8</td>
	      <td>J9</td-->
	    </tr>
	    <tr>
	      <td class="espacio" colspan="9"></td>
	      <td class="division espacio"></td>
	      <td class="espacio" colspan="9"></td>
	    </tr>
	    <tr>
	      <td colspan="3">K1</td>
	      <!--td>K2</td>
	      <td>K3</td-->
	      <td colspan="3">K4</td>
	      <!--td>K5</td>
	      <td>K6</td-->
	      <td colspan="3">K7</td>
	      <!--td>K8</td>
	      <td>K9</td-->
	      <td>x</td>
	      <td colspan="3">K1</td>
	      <!--td>K2</td>
	      <td>K3</td-->
	      <td colspan="3">K4</td>
	      <!--td>K5</td>
	      <td>K6</td-->
	      <td colspan="3">K7</td>
	      <!--td>K8</td>
	      <td>K9</td-->
	    </tr>
	    <tr>
	      <td colspan="3" class="texto">{{$fechaLimite}}</td>
	      <!--td>L2</td>
	      <td>L3</td-->
	      <td colspan="3" class="texto">{{$data[$i]->cantidad_limite}}</td>
	      <!--td>L5</td>
	      <td>L6</td-->
	      <td colspan="3" class="texto">{{$data[$i]->deuda_actual}}</td>
	      <!--td>L8</td>
	      <td>L9</td-->
	      <td>x</td>@if($i+1< sizeof($data))
	      <td colspan="3" class="texto">{{$fechaLimite}}</td>
	      <!--td>L2</td>
	      <td>L3</td-->
	      <td colspan="3" class="texto">{{$data[$i+1]->cantidad_limite}}</td>
	      <!--td>L5</td>
	      <td>L6</td-->
	      <td colspan="3" class="texto">{{$data[$i+1]->deuda_actual}}</td>@endif
	      <!--td>L8</td>
	      <td>L9</td-->
	    </tr>
	    <tr>
	      <td colspan="9">M1</td>
	      <!--td>M2</td>
	      <td>M3</td>
	      <td>M4</td>
	      <td>M5</td>
	      <td>M6</td>
	      <td>M7</td>
	      <td>M8</td>
	      <td>M9</td-->
	      <td>x</td>
	      <td colspan="9">M1</td>
	      <!--td>M2</td>
	      <td>M3</td>
	      <td>M4</td>
	      <td>M5</td>
	      <td>M6</td>
	      <td>M7</td>
	      <td>M8</td>
	      <td>M9</td-->
	    </tr>
	</table>
	<br>
	<br>
	@endif
	@endfor
  </body>
</html>