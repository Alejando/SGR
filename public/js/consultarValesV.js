var $table = $('#table');
var Fecha = new Date(); //variable
var fechaHoy=('0' + Fecha.getDate()).slice(-2) + "-" + ('0' + (Fecha.getMonth() + 1)).slice(-2) + "-" +Fecha.getFullYear(); 
function mostrarTabla(){
$table.bootstrapTable('removeAll');
 var fecha=$('#fecha').val();
	
		//alert(fecha);
	$.ajax({
		type: "GET",
		dataType: "json",
 		url: "obtenerValesV",
		data: {fecha:fecha},
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

function imprimir(){
	var vales=" ";
	var fecha;
	var total = 0;
	 
	 fecha=$('#fecha').val();

	 
	$.ajax({
		type: "GET",
		dataType: "json",
		async: false, 
 		url: "obtenerValesVendedorReporte",
		data: {fecha:fecha},
		success: llegada,
		error: problemas
	});
	function llegada(data){
		//alert(data);
		
		vales+="<table class='tabla_ticket'><tr class='ticket'><td align='center'>Dis</td><td align='center'>Vale</td><td align='center'>Folio</td><td align='center'>Importe</td><td align='center'>Pagos</td></tr>";
		 
		for (var i = 0; i < data.length; i++) {
			total+=parseInt(data[i].cantidad);
			vales+="<tr class='ticket'><td align='center'>"+data[i].id_distribuidor+"</td><td align='center'>"+data[i].serie+""+data[i].folio+"</td><td align='center'>"+data[i].folio_venta+"</td><td align='center'>$"+data[i].cantidad+".00</td><td align='center'>"+data[i].numero_pagos+"</td></tr>";
		}

		vales+="<tr class='ticket'><td></td><td align='center'># "+data.length+"</td><td colspan='1' class='total' align='right'>Total: </td><td class='importe' align='center'>$"+total+".00</td><td></td></tr></table>";
		$('#vales').html(vales);
	}
	function problemas(data){
		alert("error en buscar fecha de pago");
	}
	if(fecha==null){
		fecha=fechaHoy;
	}
	$('#pFecha').html("Fecha: "+fecha);
	$('#ticket').show();
	$('#ticket').printArea();
	$('#ticket').hide();

}
	


