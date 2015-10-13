$(document).ready(function(){
    var next = 1;
    $("#tipo_promocion").change(function(e){
        e.preventDefault();
        var opcion = " ";
        var newInput = ' ';
        $( "select option:selected" ).each(function() {

            opcion = $( this ).text();
            });
        
        if(opcion == "Empiece a pagar a partir de una fecha")
	        {
	        	newInput += '<div class="col-md-12"><div class="form-group col-md-4"><label>Fecha de inicio</label><input type="date"  name="fecha_inicio" class="form-control" required></div><div class="form-group col-md-4"><label>Fecha de creación</label><input type="date"  name="fecha_creacion" class="form-control" required></div><div class="form-group col-md-4"><label>Fecha de termino</label><input type="date"  name="fecha_termino" class="form-control" ></div></div>';  
	        }else
		        {
		        	newInput += '<div class="col-md-12"><div class="form-group col-md-6"><label>Fecha de creación</label><input type="date"  name="fecha_creacion" class="form-control" required></div><div class="form-group col-md-6"><label>Fecha de termino</label><input type="date"  name="fecha_termino" class="form-control" ></div></div>';  
		        }


        $("#nuevaPromocion").html(newInput);
    });
});
