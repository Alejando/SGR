var $id=0; //id pago
var $distribuidor;
var $table = $('#table');
var $periodo;
function obtenerId(id,distribuidor, cantidad, can_letra, periodo, fechaHoy){
	$id=id;
	$distribuidor=distribuidor;
	$periodo=periodo;
	if(distribuidor!=""){
		$('#pBueno').html("Bueno por: $"+cantidad+".00");
		$('#pTexto').html("Recibi de: "+distribuidor+" la cantidad de: $"+cantidad+".00 ("+can_letra+") por el concepto de pago de ventas por vales referente al periodo "+periodo);
		$('#pFecha').html(fechaHoy);
		$('#pDistribuidor').html(distribuidor);
		//$('#ticket').show();
		//$('#ticket').printArea();
		//$('#ticket').hide();
	}

}
function reimprimir(id,distribuidor, cantidad, can_letra, periodo, fechaHoy){
	$id=id;
	$distribuidor=distribuidor;
	$periodo=periodo;
	if(distribuidor!=""){
		$('#pBueno').html("Bueno por: $"+cantidad+".00");
		$('#pTexto').html("Recibi de: "+distribuidor+" la cantidad de: $"+cantidad+".00 ("+can_letra+") por el concepto de pago de ventas por vales referente al periodo "+periodo);
		$('#pFecha').html(fechaHoy);
		$('#pDistribuidor').html(distribuidor);
		$('#ticket').show();
		$('#ticket').printArea();
		$('#ticket').hide();
	}

}
function abonar(){
	var abono=$('#nuevoAbono').val();
	//alert($id+"=="+abono);
	$.ajax({
		type: "GET",
 		url: "abonarPago",
 		data: {id:$id, abono:abono},
		success: llegada,
		async: false
	});
	function llegada(data){
	
	 $('#pBueno').html("Bueno por: $"+abono+".00");
	 $('#pTexto').html("Recibi de: "+$distribuidor+" la cantidad de: $"+abono+".00 ("+data+") por el concepto de abono de ventas por vales referente al periodo "+$periodo);
	 imprimir_abono();
	}
	 setTimeout(
   function(){
	 $( location ).attr("href", 'consultarPagos');
   }, 1000);
}
function pagosRealizados(){
	$table.bootstrapTable('removeAll');
	$.ajax({
		type: "GET",
		dataType: "json",
 		url: "consultarPagosRealizados",
		success: llegada,
		error: problemas
	});
	function llegada(data){
		
		$table.bootstrapTable('append',data);
		}
	function problemas(data){
		alert("error en buscar fecha de pago");
	}
}
function pagar(){
	
	$.ajax({
		type: "GET",
 		url: "liquidarPago",
		data: {id:$id},
		success: llegada,
		async: false
	});
	function llegada(data){
	 imprimir_pago();
	}
	 setTimeout(
   function(){
	 $( location ).attr("href", 'consultarPagos');
   }, 1000);

	
}

function mostrarPDF(){	
	url='reporte_7';
    window.open(url, '_blank');
	
}

function mostrarExcel(){
	url='reporte_7_excel';
    window.open(url, '_blank');
	
}

function imprimir_abono(){
	$('#ticket1').html($('#ticket').clone());
	$('#ticketMega').show();
	$('#ticketMega').printArea();
	$('#ticketMega').hide();
}

function imprimir_pago(){
	//$('#ticket1').html($('#ticket').clone());
	$('#ticketMega').show();
	$('#ticketMega').printArea();
	$('#ticketMega').hide();
}

/*

function imprimirComprobante(distribuidor, cantidad, can_letra, periodo, fechaHoy){

	$('#pBueno').html("Bueno por: $"+cantidad+".00");
	$('#pTexto').html("Recibi de: "+distribuidor+" la cantidad de: $"+cantidad+".00 ("+can_letra+") por el concepto de pago de ventas por vales referente al periodo "+periodo);
	$('#pFecha').html(fechaHoy);
	$('#pDistribuidor').html(distribuidor);
	$('#ticket').show();
	$('#ticket').printArea();
	$('#ticket').hide();

}*/