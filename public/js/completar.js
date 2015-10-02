$(function(){
	$('#nombreDistribuidor').autocomplete({
    source: 'completarCampo',
   	minLength: 3,
	  select: function(event, ui) {
	  	$('#nombreDistribuidor').val(ui.item.id);
	  }
	});
  });
