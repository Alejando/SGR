$(function() {
	mostrarPagos();
	$("#calcularPagos").click(function(){
		mostrarPagos();
	});

	$('#nombreCliente').autocomplete({
    source: '../buscarCliente',
   	minLength: 1,
	  select: function(event, ui) {
	  	inputOcultos+='<input type="hidden" name="id_cliente" value='+ui.item.id+'>';
	  }
	});

});


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
	console.log(cantidad);
	var nPagosGlobal=$("#numeroPagos").val();
	var pagos=cantidad/nPagosGlobal;
	var pago=pagos.toFixed(); //  para que no tenga decimales
	console.log(pago);
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