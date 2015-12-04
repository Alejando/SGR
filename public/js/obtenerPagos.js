
<<<<<<< HEAD
function obtenerId(){
	alert($(this).attr("value"));
	console.log(this);
=======
function obtenerId(id){
	alert(id);
	//alert($(this).attr("values"));
	console.log(this.value);
>>>>>>> d7c41fbafb95c2cc9524194c5234e63d95dd8439
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