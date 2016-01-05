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
	var fecha=$('#fecha').val();
	url='reporte_2?fecha='+fecha+'&id='+idDistribuidor;
    window.open(url, '_blank');
	
}

function mostrarExcel(){
	var fecha=$('#fecha').val();
	url='reporte_2_excel?fecha='+fecha+'&id='+idDistribuidor;
    window.open(url, '_blank');
	
}

function mostrarReporte1(){
	var fecha=$('#fecha').val();
	url='reporte_1?fecha='+fecha+'&id='+idDistribuidor;
    window.open(url, '_blank');
	
}
function mostrarReporte1b(){
	var fecha=$('#fecha').val();
	url='reporte_1b?fecha='+fecha+'&id='+idDistribuidor;
    window.open(url, '_blank');
	
}