
var nPagosGlobal=4;
var fechaInicioPago=Fecha.getDate() + "/" + (Fecha.getMonth() +1) + "/" + Fecha.getFullYear();
$(function() {
	mostrarPromocion();

    $("#cantidad").focusout(function(){
    	var cantidad=$("#cantidad").val(); // obtenemos cantidad del vale
    	var pagos=cantidad/nPagosGlobal;
    	var pago=pagos.toFixed(); // crea
    	var pagoFinal=cantidad-(pago*3);
    	var Fecha = new Date(); //variable
    	var sFecha = 
    	var code="";
	  	//alert(sumaFecha(22,sFecha));
		for (var i = 1; i <= nPagosGlobal-1;i++) {
			code+="<div class='col-md-3'><div class='panel panel-primary'><div class='panel-heading'> Pago "+i+"</div><div class='panel-body'><p>De "+pago+" el "+sumaFecha(15*i,sFecha)+"</p></div></div></div>";
			//console.log(code);
		}
	  	code+="<div class='col-md-3'><div class='panel panel-primary'><div class='panel-heading'> Ultimo pago </div><div class='panel-body'><p>De "+pagoFinal+" el "+sumaFecha(15*nPagos,sFecha)+"</p></div></div></div>";
		//console.log(code);
		$("#pagos").html(code);
	})

	

});
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
		     	codigo+="<div class='col-md-6'><div class='panel panel-primary'><div class='panel-heading'> Promoción Comienze a pagar en  "+data[i].fecha_inicio+" </div><div class='panel-body'><p>Inicio  de promocion "+data[i].fecha_creacion+"</p></br><p>fin de promocion"+data[i].fecha_termino+"</p></div></div></div>";
		    	
		     }
		     if(data[i].tipo_promocion==2 ){
		     	codigo+="<div class='col-md-6'><div class='panel panel-primary'><div class='panel-heading'> Promoción paga a 6 quincenas</div><div class='panel-body'><p>Inicio  de promocion "+data[i].fecha_creacion+"</p></br><p>fin de promocion "+data[i].fecha_termino+"</p></div></div></div>";
			 
			 }
		     if(data[i].tipo_promocion==3){
		     	codigo+="<div class='col-md-6'><div class='panel panel-primary'><div class='panel-heading'> Promoción paga a 8 quincenas</div><div class='panel-body'><p>Inicio  de promocion "+data[i].fecha_creacion+"</p></br><p>fin de promocion "+data[i].fecha_termino+"</p></div></div></div>";
			 	
			 }
		};

		  	 //Estandar de promociones 1="PAgue en..." 2="PAgue en 6 quinsenas" 3="Pague en  8 quinsenas"
		  /*   if("fecha_inicio"==name){
		     	fechainicio=value;
		     }if("fecha_creacion"==name){
		     	fechaCreacion=value;
		     }if("fecha_termino"==name){
		     	fechaTermino=value;
		     }
		     if("tipo_promocion"==name){
		     	tipo=value;
		     	control++;
		     }
		     if(tipo==1 && control=1){
		     	codigo+="<div class='col-md-6'><div class='panel panel-primary'><div class='panel-heading'> Promoción Comienze a pagar en  "+fechainicio+" </div><div class='panel-body'><p>Inicio  de promocion "+fechaCreacion+"</p></br><p>fin de promocion"+fechaTermino+"</p></div></div></div>";
		    	control=0;
		     }
		     if(tipo==2 && control=1){
		     	codigo+="<div class='col-md-6'><div class='panel panel-primary'><div class='panel-heading'> Promoción paga a 6 quincenas</div><div class='panel-body'><p>Inicio  de promocion "+fechaCreacion+"</p></br><p>fin de promocion "+fechaTermino+"</p></div></div></div>";
			 	control=0;
			 }
		     if(tipo==3 && control=1){
		     	codigo+="<div class='col-md-6'><div class='panel panel-primary'><div class='panel-heading'> Promoción paga a 8 quincenas</div><div class='panel-body'><p>Inicio  de promocion "+fechaCreacion+"</p></br><p>fin de promocion "+fechaTermino+"</p></div></div></div>";
			 	control=0;
			 }
		    */
	
		//console.log(codigo);
		$("#promociones").html(codigo);
	}
	function problemas(data){
		alert("error en promociones");
	}

	
			
}
function datosVale(){
	//alert("Entrando");
			//event.preventDefault();
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

			return false;

			function llegada(data)
			{
				
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

sumaFecha = function(d, fecha)
{
 var Fecha = new Date();
 var sFecha = fecha || (Fecha.getDate() + "/" + (Fecha.getMonth() +1) + "/" + Fecha.getFullYear());
 var sep = sFecha.indexOf('/') != -1 ? '/' : '-'; 
 var aFecha = sFecha.split(sep);
 var fecha = aFecha[2]+'/'+aFecha[1]+'/'+aFecha[0];
 fecha= new Date(fecha);
 fecha.setDate(fecha.getDate()+parseInt(d));
 var anno=fecha.getFullYear();
 var mes= fecha.getMonth()+1;
 var dia= fecha.getDate();
 mes = (mes < 10) ? ("0" + mes) : mes;
 dia = (dia < 10) ? ("0" + dia) : dia;
 var fechaFinal = dia+sep+mes+sep+anno;
 return (fechaFinal);
 }

/*sumaFecha = function(d, fecha)
{
var Fecha = new Date();
var sFecha = fecha || ((Fecha.getMonth() +1) + “/” + Fecha.getDate() + “/” + Fecha.getFullYear());

var sep = sFecha.indexOf(‘/’) != -1 ? ‘/’ : ‘-‘;
var aFecha = sFecha.split(sep);

var dias = d || 0;

var fFecha = Date.UTC(aFecha[2],aFecha[0],aFecha[1])+(86400000*dias); // 86400000 son los milisegundos que tiene un día

var fechaFinal = new Date(fFecha);

var anno = fechaFinal.getFullYear();
var mes = fechaFinal.getMonth();
var dia = fechaFinal.getDate();
var mes = (mes < 10) ? ("0" + mes) : mes;
var dia = (dia < 10) ? ("0" + dia) : dia;
var fechaFinal = mes+sep+dia+sep+anno;

return (fechaFinal);

}*/