var $id=0;

function obtenerId(id){
	$id=id;
	
}
function abonar(){
	var abono=$('#nuevoAbono').val();
	//alert($id+"=="+abono);
	$.ajax({
		type: "GET",
 		url: "abonarPago",
		data: {id:$id, abono:abono}
	});
}

function pagar(){

	$.ajax({
		type: "GET",
 		url: "liquidarPago",
		data: {id:$id}
	});
	
}

function mostrarPDF(){	
	url='reporte_7';
    window.open(url, '_blank');
	
}

function mostrarExcel(){
	url='reporte_7_excel';
    window.open(url, '_blank');
	
}