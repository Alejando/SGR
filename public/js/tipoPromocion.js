$(document).ready(function(){
    var next = 1;
    $("#tipo_promocion").change(function(e){
        e.preventDefault();
        //var opcion = " ";
        var newInput = ' ';
        /*$( "select option:selected" ).each(function() {

            opcion = $( this ).value();
            });*/
        var option = $("#tipo_promocion option:selected").val();
        //alert(option);

        switch (option) {
            case "1":
                newInput += '<div class="col-md-12"><div class="form-group col-md-12"><label>Empiece a pagar a partir de:</label><input type="date"  name="fecha_inicio" class="form-control" required></div><div class="form-group col-md-6"><label>Fecha de inicio</label><input type="date"  name="fecha_creacion" class="form-control" required></div><div class="form-group col-md-6"><label>Fecha de termino</label><input type="date"  name="fecha_termino" class="form-control" ></div></div>';  
                break;
            case "2":
                newInput += '<div class="col-md-12"><div class="form-group col-md-12"><label>Número de pagos</label><select name="numero_pagos" class="form-control" id="numero_pagos"><option class="form-control">Selecciona Número de pagos</option><option value="6" class="form-control">A 6 quincenas</option><option value="8" class="form-control">A 8 quincenas</option></select></div><div class="form-group col-md-6"><label>Fecha de inicio</label><input type="date"  name="fecha_creacion" class="form-control" required></div><div class="form-group col-md-6"><label>Fecha de termino</label><input type="date"  name="fecha_termino" class="form-control" ></div></div>';  
                break;
            default:
                newInput += '';
        }


        $("#nuevaPromocion").html(newInput);
    });
});
