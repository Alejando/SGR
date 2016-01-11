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
	
	$('#form').submit(function(){
		//alert($("#folio_inicio").val());
		inputOcultos+='<input type="hidden" name="folio_inicio" value='+$("#folio_inicio").val()+'>';
		$('#oculto').html(inputOcultos);
	});

  });
