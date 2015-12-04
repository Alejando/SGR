
function obtenerId(){
	alert($(this).attr("values"));
	console.log(this.value);
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