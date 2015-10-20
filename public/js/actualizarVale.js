//Varibales Globales
var nPagosGlobal=4;
var Fecha = new Date(); //variable
var fechaInicioPago=Fecha.getFullYear() + "-" + (Fecha.getMonth() +1) + "-" + Fecha.getDate();
var BoolFechaPromo=0;

$(function() {
	mostrarPromocion();
    $("#cantidad").focusout(function(){
    	var cantidad=$("#cantidad").val(); // obtenemos cantidad del vale
    	var pagos=cantidad/nPagosGlobal;
    	var pago=pagos.toFixed(); // crea
    	var pagoFinal=cantidad-(pago*(nPagosGlobal-1));
    	var code="";
	  	//alert(sumaFecha(22,sFecha));
		for (var i = 1; i < nPagosGlobal;i++) {
			code+="<div class='col-md-3'><div class='panel panel-primary'><div class='panel-heading'> Pago "+i+"</div><div class='panel-body'><p>De $"+pago+".00  el "+cambiarTipoFecha(fechaPago(fechaInicioPago,i))+"</p></div></div></div>";
		}
	  	code+="<div class='col-md-3'><div class='panel panel-primary'><div class='panel-heading'> Ultimo pago </div><div class='panel-body'><p>De $"+pagoFinal+".00  el "+cambiarTipoFecha(fechaPago(fechaInicioPago,nPagosGlobal))+"</p></div></div></div>";
		$("#pagos").html(code);
	})

});

function fechaPago(fecha,nPago){
	var nFecha="";
	var control=0;
	$.ajax({
		type: "GET",
		dataType: "text",
		async: false, 
 		url: "fechaPago",
 		data: {fecha:fecha, nPago:nPago,cambioFecha:BoolFechaPromo},
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
		console.log(fecha+"->"+nPago+":"+nFecha);
		return nFecha;
}
function mostrarPromocion(){
	//alert("hola");
	var codigo="";
	$.ajax({
		type: "GET",
		dataType: "json",
 		url: "buscarPromocion",
		success: llegada,
		error: problemas
	});
	function llegada(data){
		console.log(data.length);
		var tipo=0;
		var control=0; //variable auxiliar en el control de datos
		for (var i = 0; i < data.length; i++) {
			if(data[i].tipo_promocion==1 ){
		     	codigo+="<div class='col-md-6'><div class='panel panel-primary'><div class='panel-heading'> Comience a pagar el  "+cambiarTipoFecha(data[i].fecha_inicio)+" </div><div class='panel-body'><p>Inicio  de promocion "+cambiarTipoFecha(data[i].fecha_creacion)+"</p></br><p>fin de promocion "+cambiarTipoFecha(data[i].fecha_termino)+"</p></div></div></div>";
		    	fechaInicioPago=data[i].fecha_inicio;
		    	BoolFechaPromo=1;
		     }
		     if(data[i].tipo_promocion==2 ){
		     	codigo+="<div class='col-md-6'><div class='panel panel-primary'><div class='panel-heading'> Paga a 6 quincenas</div><div class='panel-body'><p>Inicio  de promocion "+cambiarTipoFecha(data[i].fecha_creacion)+"</p></br><p>fin de promocion "+cambiarTipoFecha(data[i].fecha_termino)+"</p></div></div></div>";
			 	nPagosGlobal=6;
			 }
		     if(data[i].tipo_promocion==3){
		     	codigo+="<div class='col-md-6'><div class='panel panel-primary'><div class='panel-heading'> Paga a 8 quincenas</div><div class='panel-body'><p>Inicio  de promocion "+cambiarTipoFecha(data[i].fecha_creacion)+"</p></br><p>fin de promocion "+cambiarTipoFecha(data[i].fecha_termino)+"</p></div></div></div>";
			 	nPagosGlobal=8;
			 }
		};
		//Estandar de promociones 1="PAgue en..." 2="PAgue en 6 quinsenas" 3="Pague en  8 quinsenas"
		//console.log(codigo);
		$("#promociones").html(codigo);
	}
	function problemas(data){
		alert("error en promociones");
	}	
}

function datosVale(){	
	var serie = $('#serie').val();
	var folio = $('#folio').val();
	$("#nombreCliente").val("");
	$("#pagos").empty();
	$.ajax({
		type: "GET",
		dataType: "json",
 		url: "buscarVale",
 		data: {serie:serie, folio:folio},
		success: llegada,
		error: problemas
	});
	//return false;
	function llegada(data){
		$.each(data, function() {
			$.each(this, function(name, value) {
			    if(name=="estatus"){
			     	 	//console.log(name + 'r:' + value); 
			    	if(value==0){
			    		$("#bVericar").removeClass("btn btn-danger"); 
			    		$("#bVericar").addClass("btn btn-success"); 
			    	}
			    	else{
						$("#bVericar").removeClass("btn btn-success");
			    		$("#bVericar").addClass("btn btn-danger"); 
			    	}
			    }
			   	if(name=="cantidad_limite"){
			   		$("#limite_vale").val(value);
			   	}
			   	if(name=="cantidad"){
			   		$("#cantidad").val(value);
			   	}if(name=="folio_venta"){
			   		$("#folioVenta").val(value);
			   	}
			   	if(name=="id_cliente"){
			   		 //console.log(name + ':' + value); 
					$.ajax({
						type: "GET",
						url: "buscarIdCliente",
				 		data: {id:value}						
					}).done(function( result ) {
					 //console.log(result); 
						$("#nombreCliente").val(result);
					});
			   	}
			   	if(name=="id_distribuidor"){
			   		 //console.log(name + ':' + value); 
					$.ajax({
						type: "GET",
						url: "buscarIdDistribuidor",
				 		data: {id:value}						
					}).done(function( result ) {
					//console.log(result); 
					$("#nombreDistribuidor").val(result);
					});
			   	}
			    
			});
		});
	}
	function problemas()
	{
		alert('fallo');
	}

}

function cambiarTipoFecha(fecha){
	var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	var anio = fecha.substring(0,4);
	var mes =meses[parseInt(fecha.substring(5, 7))-1];
	var dia = fecha.substring(8);
	return dia+" de "+mes+" de "+anio;
}