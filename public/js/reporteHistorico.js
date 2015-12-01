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

	$.ajax({
		type: "GET",
		dataType: "json",
 		url: "emitirReporteHistorico",
		data: {id:idDistribuidor},
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
	url='reporte_8?id='+idDistribuidor;
    window.open(url, '_blank');
	
}