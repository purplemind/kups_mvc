$(function() {

	var windowWidth = Math.floor(window.innerWidth);
	var windowHeight = Math.floor(window.innerHeight);
	var horizontalCenter = windowWidth/2 - 62; //loading image dimension: 125x125
	var verticalCenter = windowHeight/2 - 62;
	$('#loading').css({ top: verticalCenter, left: horizontalCenter });
	
	$("#datepicker").datepicker({
    	'dateFormat': "dd/mm/yy"
    });
	
    $("#dodajSudiju").click( function() {
    	$.ajax({
    		method: "POST",
    		// ?ruta=ajax/controller/method/args
    		url: "index.php?ruta=ajax/sudije/get_sudija_template/" + (parseInt($('#broj_sudija').val()) + 1),
    		data: { ajax_request: true, dataType: 'html' },
    		datatype: 'html',
    		beforeSend: function() {
    	    	$('#loading').show();
    		},
    		success: function(data) {
    			jQuery(data).hide().appendTo('#rezultat_pregledanje').fadeIn('slow');
    			$('#broj_sudija').val(parseInt($('#broj_sudija').val()) + 1);
    			$(document).scrollTop($(document).height());
    		},
    		complete: function() {
    			$('#loading').hide();	
    		}
    	});    	
    	return false;
    });
	
	$(document).on('click', '.dodaj_prekrsaj_btn', function() {
		id = $(this).attr('id');
		res = id.split("_");
		var broj_sudije = res[res.length-1];
		$.ajax({
			method: "POST",
			url: "index.php?ruta=ajax/sudije/prekrsaji_template/" + 
				$('#broj_sudija').val() + "/" + 
				(parseInt($('#broj_prekrsaja_sudija_' + broj_sudije).val()) + 1),
			data: { ajax_request: true, dataType: 'html' }, 
			datatype: 'html',
    		beforeSend: function() {
    	    	$('#loading').show();
    		},
    		success: function(data) {
    			jQuery(data).hide().appendTo('#pojedinacan_prekrsaj_' + broj_sudije).fadeIn('slow');
    			$('#broj_prekrsaja_sudija_' + broj_sudije).val(parseInt($('#broj_prekrsaja_sudija_' + broj_sudije).val()) + 1);
    			$('#podaci_sudije_' + broj_sudije).hide().height($('#sudija_' + broj_sudije).height()).fadeIn('slow');
    		},
    		complete: function() {
    			$('#loading').hide();
    		}
		});
		return false;
	});
    
    $('#sifra_lige').change( function() {
    	$('#loading').show();
    	$.ajax({
    		method: "POST",
    		// ?ruta=ajax/controller/method/args
    		url: "index.php?ruta=ajax/utakmice/get_klubovi/" + $(this).val(),
    		data: { ajax_request: true, dataType: 'json' },
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
        		$('#rezultat_pregledanje').fadeIn('slow');
        		dodajSudiju_btn = $("#dodajSudiju.fixed_btn");
        		dodajSudiju_btn.css({top: verticalCenter/*windowHeight - dodajSudiju_btn.height() - 25*/, left: windowWidth - dodajSudiju_btn.width() - 50});
    		},
    	})
    	.always(function() {
    		$('#loading').hide();
    	});
    });
        
});