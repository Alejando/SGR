$(function() {
    $("#cantidad").focusout(function(){
    	var cantidad=$("#cantidad").val(); // obtenemos cantidad del vale
    	var nPagos=4;
    	var pagos=cantidad/nPagos;
    	var pago=pagos.toFixed();
    	var pagoFinal=cantidad-(pago*3);
    	var Fecha = new Date(); //variable
    	var sFecha = Fecha.getDate() + "/" + (Fecha.getMonth() +1) + "/" + Fecha.getFullYear();
    	var code="";
	  	//alert(sumaFecha(22,sFecha));
		for (var i = 1; i <= nPagos-1;i++) {
			code+="<div class='col-md-3'><div class='panel panel-primary'><div class='panel-heading'> Pago "+i+"</div><div class='panel-body'><p>De "+pago+" el "+sumaFecha(15*i,sFecha)+"</p></div></div></div>";
			console.log(code);
		}
	  	code+="<div class='col-md-3'><div class='panel panel-primary'><div class='panel-heading'> Ultimo pago </div><div class='panel-body'><p>De "+pagoFinal+" el "+sumaFecha(15*nPagos,sFecha)+"</p></div></div></div>";
		console.log(code);
		$("#pagos").html(code);
	})

});
function datosVale(){
	//alert("Entrando");
			//event.preventDefault();
		var serie = $('#serie').val();
		var folio = $('#folio').val();

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
				   	if(name=="id_distribuidor"){
				   		 //console.log(name + ':' + value); 
						$.ajax({
							type: "GET",
							url: "buscarDistribuidor",
					 		data: {id:value}						
						}).done(function( result ) {
						 console.log(result); 
						$("#nombre_distribuidor").val(result);
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