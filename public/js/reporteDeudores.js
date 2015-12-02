
var $table = $('#table');

function mostrarTabla(){
$table.bootstrapTable('removeAll');
 var fecha=$('#fecha').val();
	
		//alert(fecha);
	$.ajax({
		type: "GET",
		dataType: "json",
 		url: "emitirReporteDeudores",
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

function mostrarPDF(){
	var fecha=$('#fecha').val();
	url='reporte_6?fecha='+fecha;
    window.open(url, '_blank');
	
}

function mostrarExcel(){
	var fecha=$('#fecha').val();
	url='reporte_6_excel?fecha='+fecha;
    window.open(url, '_blank');
	
}