var idDistribuidor=0;
var $table = $('#tabla');
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
 var fechaInicio=$('#fecha_inicio').val();
 if(fechaInicio==""){
 	fechaInicio=0;
 }
 var fechaTermino=$('#fecha_termino').val();	
 if (fechaTermino==""){
 	fechaTermino=0;
 }
 if($('#id_distribuidor').val()==""){
 	idDistribuidor=0;
 }
 		//alert(fecha);
	$.ajax({
		type: "GET",
		dataType: "json",
 		url: "obtenerVales",
		data: {fecha_inicio:fechaInicio, distribuidor:idDistribuidor,fecha_termino:fechaTermino},
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
	var fecha_inicio=$('#fecha_inicio').val();
	var fecha_termino=$('#fecha_termino').val();
	url='reporte_9_pdf?fecha_inicio='+fecha_inicio+'&fecha_termino='+fecha_termino+'&id='+idDistribuidor;
    window.open(url, '_blank');
	
}

function mostrarExcel(){
	var fecha_inicio=$('#fecha_inicio').val();
	var fecha_termino=$('#fecha_termino').val();
	url='reporte_9_excel?fecha_inicio='+fecha_inicio+'&fecha_termino='+fecha_termino+'&id='+idDistribuidor;
    window.open(url, '_blank');
	
}
