$(function(){
	var inputOcultos="";
	$('#nombreDistribuidor').autocomplete({
	    source: 'buscarDistribuidor',
	   	minLength: 1,
		  select: function(event, ui) {
		  	inputOcultos+='<input type="hidden" name="id_distribuidor" value='+ui.item.id+'>';
		  }
	});
	setTimeout(function() {
		        $("#mensaje").fadeOut(1500);
		    },3000);
	$.ajax({
		type: "GET",
		dataType: "json",
 		url: "obtenerUltimoVale",
		success: llegada,
		error: problemas
	});
	function llegada(data){
	
		$("#serie").val(data.serie);

		$("#folio_inicio").val((data.folio)+1);
		inputOcultos+='<input type="hidden" name="folio_inicio" value='+(data.folio+1)+'>';
		  
		 $('#oculto').html(inputOcultos);
	 }
	function problemas(data){
		alert("error al buscar ultimo vale");
	}

  });
