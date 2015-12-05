var $id=0;

function obtenerId(id){
	$id=id;
	
}
function abonar(){
	var abono=$('#nuevoAbono').val();
	//alert($id+"=="+abono);
	$.ajax({
		type: "GET",
 		url: "abonarPago",
		data: {id:$id, abono:abono}
	});
}

function pagar(){

	$.ajax({
		type: "GET",
 		url: "liquidarPago",
		data: {id:$id}
	});
	
}

function mostrarPDF(){	
	url='reporte_7';
    window.open(url, '_blank');
	
}

function mostrarExcel(){
	url='reporte_7_excel';
    window.open(url, '_blank');
	
}

function imprimirComprobante(distribuidor, cantidad, can_letra, periodo, fechaHoy){
	//var periodo = periodo;
	//alert(distribuidor);
	//alert(cantidad);
	//alert(can_letra);
	//alert(periodo);
	//alert(fechaHoy);
	$('#pBueno').html("Bueno por: $"+cantidad+".00");
	$('#pTexto').html("Recibi de: "+distribuidor+" la cantidad de: $"+cantidad+".00 ("+can_letra+") por el concepto de pago de ventas por vales referente al periodo "+periodo);
	$('#pFecha').html(fechaHoy);
	$('#pDistribuidor').html(distribuidor);
	$('#ticket').show();
	$('#ticket').printArea();
	$('#ticket').hide();

}