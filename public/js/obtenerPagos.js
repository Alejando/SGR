
function obtenerId(){
	alert($(this).attr("value"));
	console.log(this);
}

function pagar(){
if($('#id_distribuidor').val()==""){
	idDistribuidor=0;
}
 var fecha=$('#fecha').val();
 //alert("si se pudo");
	$.ajax({
		type: "GET",
		dataType: "json",
 		url: "crearPagos",
		data: {fecha:fecha, id:idDistribuidor}
	});
	
}