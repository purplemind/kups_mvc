$(function() {
    $("#datepicker").datepicker({
    	'dateFormat': "dd/mm/yy"
    });
    
    $('#sifra_lige').change( function() {
    	//alert($(this).val());
    	$.ajax({
    		method: "POST",
    		// ?ruta=ajax/controller/method/args
    		url: "index.php?ruta=ajax/utakmice/get_klubovi/" + $(this).val(),
    		data: { ajax_request: true },
    		datatype: 'json',
    		success: function(data) {
    			klubovi = jQuery.parseJSON(data);
    			$('#domacin').empty();
    			$('#gost').empty();
    			$.each(klubovi, function(key, value) {   
    			     $('#domacin')
    			        .append($('<option>', { value : value.sifra_kluba })
    			        .text(value.naziv_kluba));
    			     
    			     $('#gost')
			         	.append($('<option>', { value : value.sifra_kluba })
			          	.text(value.naziv_kluba));
    			});
    		}
    	});
    });
});