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
