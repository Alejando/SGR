function datosVale(){
	alert("Entrando");
			//event.preventDefault();
		var serie = $('#serie').val();
		var folio = $('#folio').val();

		$.ajax({
				type: "GET",
		 		url: "buscarVale",
		 		data: {serie:serie, folio:folio},
				success: llegada,
				error: problemas
			});

			return false;

			function llegada(data)
			{
				alert(data);	
			}

			function problemas()
			{
				alert('fallo');
			
			}
}

