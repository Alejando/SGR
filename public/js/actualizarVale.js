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
				     	 	
				    	if(value==0){
				    		 $("#bVericar").addClass("btn btn-success"); 
				    	}
				    	else{
				    		$("#bVericar").addClass("btn btn-danger"); 
				    	}
				    }
				   	if(name=="cantidad_limite"){

				   		$("#limite_vale").val(value);
				   		console.log(name + '=' + value);
				   	}
				    
				  });
				});
			}

			function problemas()
			{
				alert('fallo');
			
			}
}

