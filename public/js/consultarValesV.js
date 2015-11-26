var $table = $('#table');
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
	$.ajax({
		type: "GET",
		dataType: "json",
 		url: "obtenerValesVendedorReporte",
		data: {fecha:fecha},
		success: llegada,
		error: problemas
	});
	function llegada(data){
		
		
		}
	function problemas(data){
		alert("error en buscar fecha de pago");
	}
	
}