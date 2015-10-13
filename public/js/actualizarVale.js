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

