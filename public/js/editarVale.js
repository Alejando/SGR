$(function() {
	mostrarPagos();
	promo();
	$("#calcularPagos").click(function(){
		mostrarPagos();
	});
	cambiarIds();
	$('#nombreCliente').autocomplete({
    source: '../buscarCliente',
   	minLength: 1,
	  select: function(event, ui) {
	  $('#id_cliente').val(ui.item.id);
		}
	});
	$('#nombreDistribuidor').autocomplete({
	    source: '../buscarDistribuidor',
	   	minLength: 1,
		  select: function(event, ui) {
		  	$('#id_distribuidor').val(ui.item.id);
		  }
	});
	$('#nombreCuenta').autocomplete({
	    source: '../buscarCuenta',
	   	minLength: 1,
		  select: function(event, ui) {
		  	$('#id_cuenta').val(ui.item.id);
		  }
	});
	$('#estatus').change(function(){
		if($('#estatus').val()=="2"){
			$('#cancelacion').removeAttr('disabled');
		}else{
			$('#cancelacion').Attr('disabled');
		}
	});
	switch($('#id_estatus').val()){
		case '0': $('#estatus > option[value="0"]').attr('selected', 'selected');
			break;
		case '1': $('#estatus > option[value="1"]').attr('selected', 'selected');
			break;
		case '2': $('#estatus > option[value="2"]').attr('selected', 'selected');
				$('#cancelacion').removeAttr('disabled');
			break;
	}
	
});

function cambiarIds(){
	$.ajax({
		type: "GET",
		url: "../buscarIdCliente",
 		data: {id:$('#id_cliente').val()}						
	}).done(function( result ) {
	 //console.log(result); 
		$("#nombreCliente").val(result);
	});

	$.ajax({
		type: "GET",
		url: "../buscarIdDistribuidor",
 		data: {id:$('#id_distribuidor').val()}						
	}).done(function( result ) {
	//console.log(result); 
	$("#nombreDistribuidor").val(result);
	});

	$.ajax({
		type: "GET",
		url: "../buscarIdCuenta",
 		data: {id:$('#id_cuenta').val()}						
	}).done(function( result ) {
	//console.log(result); 
	$("#nombreCuenta").val(result);
	});
}

function promo(){
	$.ajax({
		type: "GET",
		dataType: "text",
 		url: "../verPromo1",
 		data: {id:$('#id_vale').val()},
		success: llegada,
		error: problemas
	});
	function llegada(data){
		 //console.log(data);
		 nFecha=data;

		 //control=1;
		}
	function problemas(data){
		alert("error en buscar fecha de pago");
	}
}
function fechaPago(fecha,nPago){
	var nFecha="";
	var control=0;
	$.ajax({
		type: "GET",
		dataType: "text",
		async: false, 
 		url: "../fechaPago",
 		data: {fecha:fecha, nPago:nPago,cambioFecha:0},
		success: llegada,
		error: problemas
	});
	function llegada(data){
		 //console.log(data);
		 nFecha=data;

		 //control=1;
		}
	function problemas(data){
		alert("error en buscar fecha de pago");
	}
		//console.log(fecha+"->"+nPago+":"+nFecha);
		return nFecha;
}

function cambiarTipoFecha(fecha){
	var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	var anio = fecha.substring(0,4);
	var mes =meses[parseInt(fecha.substring(5, 7))-1];
	var dia = fecha.substring(8);
	return dia+" de "+mes+" de "+anio;
}
function mostrarPagos(){
	var cantidad=$("#cantidad").val(); // obtenemos cantidad del vale
	//console.log(cantidad);
	var nPagosGlobal=$("#numeroPagos").val();
	var pagos=cantidad/nPagosGlobal;
	var pago=pagos.toFixed(); //  para que no tenga decimales
	//console.log(pago);
	var pagoFinal=cantidad-(pago*(nPagosGlobal-1));
	var code="";
	var fechaInicioPago=$("#fecha_inicio_pago").val();
  	//alert(sumaFecha(22,sFecha));
	for (var i = 1; i < nPagosGlobal;i++) {
		code+="<div class='col-md-3'><div class='panel panel-primary'><div class='panel-heading'> Pago "+i+"</div><div class='panel-body'><p>De $"+pago+".00  el "+cambiarTipoFecha(fechaPago(fechaInicioPago,i))+"</p></div></div></div>";
	}
  	code+="<div class='col-md-3'><div class='panel panel-primary'><div class='panel-heading'> Ultimo pago </div><div class='panel-body'><p>De $"+pagoFinal+".00  el "+cambiarTipoFecha(fechaPago(fechaInicioPago,nPagosGlobal))+"</p></div></div></div>";
	$("#pagos").html(code);
}