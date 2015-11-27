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
		
		
		 
		for (var i = 0; i < data.length; i++) {
			vales+="<p class='texto'>    "+data[i].id_distribuidor+"    "+data[i].serie+""+data[i].folio+"   "+data[i].folio_venta+"    "+data[i].cantidad+"   "+data[i].numero_pagos+"</p>";
		}
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