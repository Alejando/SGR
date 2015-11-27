//Varibales Globales
var nPagosGlobal=4;
var Fecha = new Date(); //variable
var fechaInicioPago=Fecha.getFullYear() + "-" + ('0' + (Fecha.getMonth() + 1)).slice(-2) + "-" +('0' + Fecha.getDate()).slice(-2); 
var BoolFechaPromo=0; //0= no hay promo 1=hay promo
var inputOcultos=""; // datos que no tienen un input y se creara oculto :)
var mensaje="";
var confirma=0;
var cliente;
var distribuidor;
var importe;

$(function() {
	$('#fecha').val(fechaInicioPago);

	mostrarPromocion();
    $("#cantidad").focusout(function(){
    	if(BoolFechaPromo!=1){
    		fechaInicioPago=$('#fecha').val();
    	}
    	
    	var cantidad=$("#cantidad").val(); // obtenemos cantidad del vale
    	importe=cantidad;
    	var pagos=cantidad/nPagosGlobal;
    	var pago=pagos.toFixed(); // crea
    	var pagoFinal=cantidad-(pago*(nPagosGlobal-1));
    	var code="";
    	var pagos="";
	  	//alert(sumaFecha(22,sFecha));
		for (var i = 1; i < nPagosGlobal;i++) {
			code+="<div class='col-md-3'><div class='panel panel-primary'><div class='panel-heading'> Pago "+i+"</div><div class='panel-body'><p>De $"+pago+".00  el "+cambiarTipoFecha(fechaPago(fechaInicioPago,i))+"</p></div></div></div>";
			pagos+="<p class='texto'>Pago "+i+" De $"+pago+".00 </p><p class='texto'>El "+cambiarTipoFecha(fechaPago(fechaInicioPago,i))+"</p>";
			}
	  	code+="<div class='col-md-3'><div class='panel panel-primary'><div class='panel-heading'> Ultimo pago </div><div class='panel-body'><p>De $"+pagoFinal+".00  el "+cambiarTipoFecha(fechaPago(fechaInicioPago,nPagosGlobal))+"</p></div></div></div>";
		pagos+="<p class='texto'>Pago "+i+" De $"+pagoFinal+".00 </p><p class='texto'>El "+cambiarTipoFecha(fechaPago(fechaInicioPago,nPagosGlobal))+"</p>";
		$("#pagos").html(code);
		
		$('#pagosTicket').html(pagos)
	})


	$('#nombreCliente').autocomplete({
    source: 'buscarCliente',
   	minLength: 1,
	  select: function(event, ui) {
	  	cliente=ui.item.value;
	  	inputOcultos+='<input type="hidden" name="id_cliente" value='+ui.item.id+'>';
	  }
	});
	$('#form').submit(function(){

		$('#pFecha').html("Fecha: "+cambiarTipoFecha(fechaInicioPago));
  		$('#pDistribuidor').html("Distribuidor: "+distribuidor);
  		$('#pCliente').html("Cliente: "+$('#nombreCliente').val());
  		$('#pImporte').html("Importe: $"+importe+".00");
  		$('#ticket').show();
  		$('#ticket').printArea();
  		$('#ticket').hide();
		if(BoolFechaPromo==0){
			inputOcultos+='<input type="hidden" name="fecha_inicio_pago" value='+fechaInicioPago+'/>';
		}
		inputOcultos+='<input type="hidden" name="numero_pagos" value="'+nPagosGlobal+'"/>';
		inputOcultos+='<input type="hidden" name="fecha_venta" value="'+$('#fecha').val()+'"/>';
		$("#ocultos").html(inputOcultos);
		if(confirma==1){
			return true;
		}
		else{
			mensaje='<div id="borrarMensaje" facclass="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert">&times;</button><strong> El vale no a sido verificado </strong></div>';
			$('#mensaje').html(mensaje);
					setTimeout(function() {
		        $("#borrarMensaje").fadeOut(1500);
		    },3000);
			return false;
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
		//console.log(fecha+"->"+nPago+":"+nFecha);
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
		    	inputOcultos+='<input type="hidden" name="fecha_inicio_pago" value='+fechaInicioPago+'/>';
		    	inputOcultos+='<input type="hidden" name="id_promocion" value='+data[i].id_promocion+'/>';
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
	
	$.ajax({
		type: "GET",
 		url: "buscarVale",
 		data: {serie:serie, folio:folio},
		success: llegada,
		error: problemas
	});
	function llegada(data){
		
		if(data=="no"){
			
			mensaje='<div id="borrarMensaje" class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert">&times;</button><strong> El vale no existe </strong></div>';
			$('#mensaje').html(mensaje);
			$("#bVericar").removeClass("btn btn-danger"); 
			$("#bVericar").removeClass("btn btn-success"); 
			$("#bVericar").removeClass("btn btn-primary"); 
	    	$("#bVericar").addClass("btn btn-warning"); 
			    	setTimeout(function() {
		        $("#borrarMensaje").fadeOut(1500);
		    },3000);
			
		}
		$.each(data, function() {
			$.each(this, function(name, value) {
				if(name=="id_vale"){
					inputOcultos+='<input type="hidden" name="id_vale" value='+value+'>';
					
				}
			    if(name=="estatus"){
			     	 	//console.log(name + 'r:' + value); 
			    	if(value==0){
			    		$('#nombreCliente').removeAttr("disabled");
						$('#folioVenta').removeAttr("disabled");
						$('#cantidad').removeAttr("disabled");
			    		$("#bVericar").removeClass("btn btn-danger");
			    		$("#bVericar").removeClass("btn btn-warning");  
			    		$("#bVericar").addClass("btn btn-success"); 
			    		mensaje='<div id="borrarMensaje"class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>El vale esta disponible</strong></div>';
						$('#mensaje').html(mensaje);
						    	setTimeout(function() {
					        $("#borrarMensaje").fadeOut(1500);
					    },3000);
			    		confirma=1;

			    	}
			    	else{
						$("#bVericar").removeClass("btn btn-success");
						$("#bVericar").removeClass("btn btn-warning"); 
			    		$("#bVericar").addClass("btn btn-danger"); 
			    		mensaje='<div  id="borrarMensaje"class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert">&times;</button><strong> El vale no esta disponible </strong></div>';
						$('#mensaje').html(mensaje);
						    	setTimeout(function() {
					        $("#borrarMensaje").fadeOut(1500);
					    },3000);
			    	}
			    }
			   	if(name=="cantidad_limite"){
			   		$("#limite_vale").val(value);
			   	}
			   	if(name=="cantidad"){
			   		$("#cantidad").val(value);
			   	}
			   	if(name=="folio_venta"){
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
					distribuidor=result;
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
	var mes =fecha.substring(5, 7);
	var dia = fecha.substring(8);
	return " "+dia+"-"+mes+"-"+anio;
}