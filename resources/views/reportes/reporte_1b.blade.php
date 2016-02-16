<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reporte 1</title>
    <link href="css/reporte_1b.css"  rel="stylesheet">
  </head>
  <body>
  	@for ($i = 0; $i < sizeof($data); $i++)

  	@if($i%2==0)
	  		
	<table  background="img/logo_tabla.jpg" >
	    <tr>
	      <td colspan="9" class="mitad invisible izq_texto"><img src="img/logo_tabla.jpg" width="110px" height="80px"/></td>
	      <!--td>A2</td>
	      <td>A3</td>
	      <td>A4</td>
	      <td>A5</td>
	      <td>A6</td>
	      <td>A7</td>
	      <td>A8</td>
	      <td>A9</td-->
	      <td class="division" class="">l</td>
	      <td colspan="9" class="mitad invisible izq_texto"><img src="img/logo_tabla.jpg" width="110px" height="80px"/></td>
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
	      <td colspan="2" class="negrita der_texto">Fecha:</td>
	      <!--td>B2</td-->
	      <td colspan="2" class="texto inf_linea">{{$fechaHoy}}</td>
	      <!--td>B4</td-->
	      <td class="invisible">B5</td>
	      <td colspan="2" class="negrita der_texto">FOLIO:</td>
	      <!--td>B7</td-->
	      <td colspan="2" class="texto inf_linea">{{$data[$i]->folio}}</td>
	      <!--td>B9</td-->
	      <td class="">l</td>
	      <td colspan="2" class="negrita der_texto">Fecha:</td>
	      <!--td>B2</td-->
	      <td colspan="2" class="texto inf_linea">{{$fechaHoy}}</td>
	      <!--td>B4</td-->
	      <td class="invisible">B5</td>
	      <td colspan="2" class="negrita der_texto">FOLIO:</td>
	      <!--td>B7</td-->@if($i+1 < sizeof($data))
	      <td colspan="2" class="texto inf_linea">{{($data[$i+1]->folio)}}</td>
	      <!--td>B9</td-->@endif
	    </tr>

	    <tr>
	      <td class="espacio" colspan="9"></td>
	      <td class="division espacio"></td>
	      <td class="espacio" colspan="9"></td>
	    </tr>

	    <tr>
	    
	      <td colspan="2" class="negrita izq_border sup_border color">No.</td>
	      <!--td>C2</td-->
	      <td colspan="7" class="negrita der_border sup_border color">DISTRIBUIDOR</td>
	      <!--td>C4</td>
	      <td>C5</td>
	      <td>C6</td>
	      <td>C7</td>
	      <td>C8</td>
	      <td>C9</td-->
	      <td class="">l</td>
	      <td colspan="2" class="negrita izq_border sup_border color">No.</td>
	      <!--td>C2</td-->
	      <td colspan="7" class="negrita der_border sup_border color">DISTRIBUIDOR</td>
	      <!--td>C4</td>
	      <td>C5</td>
	      <td>C6</td>
	      <td>C7</td>
	      <td>C8</td>
	      <td>C9</td-->
	    </tr>
	    <tr>
	      <td colspan="2" class="texto izq_border">{{$data[$i]->id_distribuidor}}</td>
	      <!--td>D2</td-->
	      <td colspan="7" class="texto der_border">{{$distribuidor}}</td>
	      <!--td>D4</td>
	      <td>D5</td>
	      <td>D6</td>
	      <td>D7</td>
	      <td>D8</td>
	      <td>D9</td-->
	      <td class="">l</td>@if($i+1< sizeof($data))
	      <td colspan="2" class="texto izq_border">{{$data[$i+1]->id_distribuidor}}</td>
	      <!--td>D2</td-->
	      <td colspan="7" class="texto der_border">{{$distribuidor}}</td>@endif
	      <!--td>D4</td>
	      <td>D5</td>
	      <td>D6</td>
	      <td>D7</td>
	      <td>D8</td>
	      <td>D9</td-->
	    </tr>
	    <tr>
	      <td colspan="2" class="negrita izq_border color">No.</td>
	      <!--td>E2</td-->
	      <td colspan="7" class="negrita der_border color">CLIENTE</td>
	      <!--td>E4</td>
	      <td>E5</td>
	      <td>E6</td>
	      <td>E7</td>
	      <td>E8</td>
	      <td>E9</td-->
	      <td class="">l</td>
	      <td colspan="2" class="negrita izq_border color">No.</td>
	      <!--td>E2</td-->
	      <td colspan="7" class="negrita der_border color">CLIENTE</td>
	      <!--td>E4</td>
	      <td>E5</td>
	      <td>E6</td>
	      <td>E7</td>
	      <td>E8</td>
	      <td>E9</td-->
	    </tr>
	    <tr>
	      <td colspan="2" class="texto izq_border inf_border">{{$data[$i]->id_vale}}</td>
	      <!--td>F2</td-->
	      <td colspan="7" class="texto der_border inf_border">{{$data[$i]->id_cliente}}</td>
	      <!--td>F4</td>
	      <td>F5</td>
	      <td>F6</td>
	      <td>F7</td>
	      <td>F8</td>
	      <td>F9</td-->
	      <td class="">l</td>@if($i+1< sizeof($data))
	       <td colspan="2" class="texto izq_border inf_border">{{$data[$i+1]->id_vale}}</td>
	      <!--td>F2</td-->
	      <td colspan="7" class="texto der_border inf_border">{{$data[$i+1]->id_cliente}}</td>@endif
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
	      <td colspan="3" class="invisible">G1</td>
	      <td colspan="3" class="negrita der_texto izq_border sup_border color">SALDO ANTERIOR:</td>
	      <!--td>G2</td>
	      <td>G3</td>
	      <td>G4</td>
	      <td>G5</td>
	      <td>G6</td-->
	      <td colspan="3" class="texto der_border sup_border">{{$data[$i]->numero_pagos}}</td>
	      <!--td>G8</td>
	      <td>G9</td-->
	      <td class="">l</td>
	      <td colspan="3" class="invisible">G1</td>
	      <td colspan="3" class="negrita der_texto izq_border sup_border color">SALDO ANTERIOR:</td>
	      <!--td>G2</td>
	      <td>G3</td>
	      <td>G4</td>
	      <td>G5</td>
	      <td>G6</td-->@if($i+1< sizeof($data))
	      <td colspan="3" class="texto der_border sup_border">{{$data[$i+1]->numero_pagos}}</td>@endif
	      <!--td>G8</td>
	      <td>G9</td-->
	    </tr>
	    <tr>
	      <td colspan="3" class="invisible">G2</td>
	      <td colspan="3" class="negrita der_texto izq_border color">CARGOS:</td>
	      <!--td>H2</td>
	      <td>H3</td>
	      <td>H4</td>
	      <td>H5</td>
	      <td>H6</td-->
	      <td colspan="3" class="texto der_border">$0.00</td>
	      <!--td>H8</td>
	      <td>H9</td-->
	      <td class="">l</td>
	      <td colspan="3" class="invisible">G2</td>
	      <td colspan="3" class="negrita der_texto izq_border color">CARGOS:</td>
	      <!--td>H2</td>
	      <td>H3</td>
	      <td>H4</td>
	      <td>H5</td>
	      <td>H6</td-->
	      <td colspan="3" class="texto der_border">$0.00</td>
	      <!--td>H8</td>
	      <td>H9</td-->
	    </tr>
	    <tr>
	      <td colspan="3" class="texto der_border">Pago: {{$data[$i]->pagos_realizados}}</td>
	      <td colspan="3" class="invisible color"></td>
	      <!--td>I2</td>
	      <td>I3</td>
	      <td>I4</td>
	      <td>I5</td>
	      <td>I6</td-->
	      <td colspan="3" class="invisible der_border">I7</td>
	      <!--td>I8</td>
	      <td>I9</td-->
	      <td class="">l</td>@if($i+1< sizeof($data))
	   
	     
	    <td colspan="3" class="texto der_border" >Pago: {{$data[$i+1]->pagos_realizados}}</td>
	    <td colspan="3" class="invisible color"></td>
	     @endif
	      <!--td>I2</td>
	      <td>I3</td>
	      <td>I4</td>
	      <td>I5</td>
	      <td>I6</td-->
	      <td colspan="3" class="invisible der_border">I7</td>
	      <!--td>I8</td>
	      <td>I9</td-->
	    </tr>
	    <tr>
	      <td colspan="3" class="invisible">G4</td>
	      <td colspan="3" class="negrita der_texto izq_border inf_border color">SALDO:</td>
	      <!--td>J2</td>
	      <td>J3</td>
	      <td>J4</td>
	      <td>J5</td>
	      <td>J6</td-->
	      <td colspan="3" class="texto der_border inf_border">{{$data[$i]->numero_pagos}}</td>
	      <!--td>J8</td>
	      <td>J9</td-->
	      <td class="">l</td>
	      <td colspan="3" class="invisible">G4</td>
	      <td colspan="3" class="negrita der_texto izq_border inf_border color">SALDO:</td>
	      <!--td>J2</td>
	      <td>J3</td>
	      <td>J4</td>
	      <td>J5</td>
	      <td>J6</td-->@if($i+1< sizeof($data))
	      <td colspan="3" class="texto der_border inf_border">{{$data[$i+1]->numero_pagos}}</td>@endif
	      <!--td>J8</td>
	      <td>J9</td-->
	    </tr>

	    <tr>
	      <td class="espacio" colspan="9"></td>
	      <td class="division espacio"></td>
	      <td class="espacio" colspan="9"></td>
	    </tr>

	    <tr>
	      <td colspan="3" class="negrita izq_border sup_border color">VENCIMIENTO</td>
	      <!--td>K2</td>
	      <td>K3</td-->
	      <td colspan="3" class="negrita sup_border color">PAGO MINIMO</td>
	      <!--td>K5</td>
	      <td>K6</td-->
	      <td colspan="3" class="negrita der_border sup_border color">NUEVO SALDO</td>
	      <!--td>K8</td>
	      <td>K9</td-->
	      <td class="">l</td>
	      <td colspan="3" class="negrita izq_border sup_border color">VENCIMIENTO</td>
	      <!--td>K2</td>
	      <td>K3</td-->
	      <td colspan="3" class="negrita sup_border color">PAGO MINIMO</td>
	      <!--td>K5</td>
	      <td>K6</td-->
	      <td colspan="3" class="negrita der_border sup_border color">NUEVO SALDO</td>
	      <!--td>K8</td>
	      <td>K9</td-->
	    </tr>
	    <tr>
	      <td colspan="3" class="texto izq_border inf_border">{{$fechaLimite}}</td>
	      <!--td>L2</td>
	      <td>L3</td-->
	      <td colspan="3" class="texto inf_border">{{$data[$i]->cantidad_limite}}</td>
	      <!--td>L5</td>
	      <td>L6</td-->
	      <td colspan="3" class="texto der_border inf_border">{{$data[$i]->deuda_actual}}</td>
	      <!--td>L8</td>
	      <td>L9</td-->
	      <td class="">l</td>@if($i+1< sizeof($data))
	      <td colspan="3" class="texto izq_border inf_border">{{$fechaLimite}}</td>
	      <!--td>L2</td>
	      <td>L3</td-->
	      <td colspan="3" class="texto inf_border">{{$data[$i+1]->cantidad_limite}}</td>
	      <!--td>L5</td>
	      <td>L6</td-->
	      <td colspan="3" class="texto der_border inf_border">{{$data[$i+1]->deuda_actual}}</td>@endif
	      <!--td>L8</td>
	      <td>L9</td-->
	    </tr>
	    <tr>
	      <td colspan="9"  class="negrita mensaje">Calzando a Fresnillo</td>
	      <!--td>M2</td>
	      <td>M3</td>
	      <td>M4</td>
	      <td>M5</td>
	      <td>M6</td>
	      <td>M7</td>
	      <td>M8</td>
	      <td>M9</td-->
	      <td class="">l</td>
	      <td colspan="9"  class="negrita mensaje">Calzando a Fresnillo</td>
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
	<hr style="border-style: dashed none none none;border-width: 2px;"></hr>
	@endif
	@endfor
  </body>
</html>