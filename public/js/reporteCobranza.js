var idDistribuidor;
 var $table = $('#table');
$(function() {


	$('#id_distribuidor').autocomplete({
		    source: 'buscarDistribuidor',
		   	minLength: 1,
			  select: function(event, ui) {
			  
			  	idDistribuidor=ui.item.id;
			  }
	});

	
});


function mostrarTabla(){
$table.bootstrapTable('removeAll');
 
	var fecha=$('#fecha').val();
		//alert(fecha);
	$.ajax({
		type: "GET",
		dataType: "json",
 		url: "emitirReporteCobranza",
		data: {fecha:fecha, id:idDistribuidor},
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

function mostrarPDF(){

	$.ajax({
		type: "GET",
 		url: "reporteCobranzaPDF",
		data: {fecha:fecha, id:idDistribuidor}
	});
	
}