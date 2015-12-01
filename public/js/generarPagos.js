var idDistribuidor=0;
$(function() {
	$('#id_distribuidor').autocomplete({
		    source: 'buscarDistribuidor',
		   	minLength: 1,
			  select: function(event, ui) { 
			  	idDistribuidor=ui.item.id;
			  }
	});

	
});

function generar(){
if($('#id_distribuidor').val()=""){
	idDistribuidor=0;
}
 var fecha=$('#fecha').val();
 alert("si se pudo");
	$.ajax({
		type: "GET",
		dataType: "json",
 		url: "crearPagos",
		data: {fecha:fecha, id:idDistribuidor}
	});
}
