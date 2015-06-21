$(function() {
	
	//$("form")[0].reset();
	//$('#broj_sudija').val(0);

	var windowWidth = Math.floor(window.innerWidth);
	var windowHeight = Math.floor(window.innerHeight);
	var horizontalCenter = windowWidth/2 - 62; //loading image dimension: 125x125
	var verticalCenter = windowHeight/2 - 62;
	dodajSudiju_btn = $("#dodajSudiju.fixed_btn");
	dodajSudiju_btn.css({top: verticalCenter/*windowHeight - dodajSudiju_btn.height() - 25*/, left: windowWidth - dodajSudiju_btn.width() - 50});
	dodajSudiju_btn.fadeIn('slow');
	$('#submit_div').fadeIn('slow');

	$('#loading').css({ top: verticalCenter, left: horizontalCenter });
	
	$("#datepicker").datepicker({
    	'dateFormat': "dd/mm/yy"
    });
	
	// Dodaj sudiju
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
    			jQuery(data).hide().appendTo('#utakmica_sudije').fadeIn('slow');
    			$('#broj_sudija').val(parseInt($('#broj_sudija').val()) + 1);
    			$(document).scrollTop($(document).height());
    		},
    		complete: function() {
    			$('#loading').hide();	
    		}
    	});    	
    	return false;
    });
	
    // Dodaj prekrsaj
	$(document).on('click', '.dodaj_prekrsaj_btn', function() {
		id = $(this).attr('id');
		res = id.split("_");
		var broj_sudije = res[res.length-1];
		$.ajax({
			method: "POST",
			url: "index.php?ruta=ajax/sudije/prekrsaji_template/" + 
				broj_sudije + "/" + 
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
    
	// Prikaz odabira klubova nakon sto se odabere liga
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
        		/*$('#rezultat_pregledanje').fadeIn('slow');*/
    		},
    	})
    	.always(function() {
    		$('#loading').hide();
    	});
    });

    // Obrisi prekrsaj
    $(document).on('click', '.delete_prekrsaj', function() {
    	id = $(this).attr('id');
		res = id.split("_");
		var broj_sudije = res[res.length - 2];
		var broj_prekrsaja = res[res.length - 1];
		var ukupno_prekrsaja = $('#broj_prekrsaja_sudija_' + broj_sudije).val();
		$('#broj_prekrsaja_sudija_' + broj_sudije).val(ukupno_prekrsaja - 1);
		$('#div_prekrsaj_' + broj_sudije + "_" + broj_prekrsaja).remove();
		var brojac = 1;
		for (i = 1; i <= ukupno_prekrsaja; i++) {
			if (i != broj_prekrsaja) {
				$("#div_prekrsaj_" + broj_sudije + "_" + i).attr("id", "div_prekrsaj_" + broj_sudije + "_" + brojac);
				// slika
				$('#' + broj_sudije + "_" + i).attr('id', broj_sudije + '_' + brojac);
				// select tag
				$('#prekrsaj_' + broj_sudije + "_" + i).attr('name', 'prekrsaj_' + broj_sudije + '_' + brojac);
				$('#prekrsaj_' + broj_sudije + "_" + i).attr('id', 'prekrsaj_' + broj_sudije + '_' + brojac);
				brojac++;
			}
		}
		var visina = Math.max(70, $('#prekrsaji_sudije_' + broj_sudije).height());
		$('#podaci_sudije_' + broj_sudije).hide().height(visina).fadeIn('slow');
    });
    
    // Obrisi sudiju
    $(document).on('click', '.delete_sudija', function() {
    	id = $(this).attr('id');
    	res = id.split("_");
    	var broj_sudije = res[res.length - 1];
    	var ukupno_sudija = $('#broj_sudija').val();
    	$('#sudija_' + broj_sudije).fadeOut('slow', function() { $(this).remove(); });
    	$('#broj_sudija').val(ukupno_sudija - 1);
    	var brojac = 1;
    	for (i = 1; i <= ukupno_sudija; i++) {
    		if (i != broj_sudije) {
    			ukupno_prekrsaja = $('#broj_prekrsaja_sudija_' + i).val();
    			$('#sudija_' + i).attr('id', 'sudija_' + brojac);
    			$('#podaci_sudije_' + i).attr('id', 'podaci_sudije_' + brojac);
    			$('#select_sudija_' + i).attr('name', 'required[sudija_' + brojac + ']');
    			$('#select_sudija_' + i).attr('id', 'select_sudija_' + brojac);
    			$('#delete_sudija_' + i).attr('id', 'delete_sudija_' + brojac);
    			$('#pozicija_' + i).attr('name', 'required[pozicija_' + brojac + ']');
    			$('#pozicija_' + i).attr('id', 'pozicija_' + brojac);
    			$('#prekrsaji_sudije_' + i).attr('id', 'prekrsaji_sudije_' + brojac);
    			$('#broj_prekrsaja_sudija_' + i).attr('name', 'broj_prekrsaja_sudija_' + brojac);
    			$('#broj_prekrsaja_sudija_' + i).attr('id', 'broj_prekrsaja_sudija_' + brojac);
    			$('#dodaj_prekrsaj_' + i).attr('id', 'dodaj_prekrsaj_' + brojac);
    			$('#pojedinacan_prekrsaj_' + i).attr('id', 'pojedinacan_prekrsaj_' + brojac);
    			for (j = 1; j <= ukupno_prekrsaja; j++) {
    				$("#div_prekrsaj_" + i + "_" + j).attr("id", "div_prekrsaj_" + brojac + "_" + j);
    				// slika
    				$('#' + i + "_" + j).attr('id', brojac + '_' + j);
    				// select tag
    				$('#prekrsaj_' + i + "_" + j).attr('name', 'prekrsaj_' + brojac + '_' + j);
    				$('#prekrsaj_' + i + "_" + j).attr('id', 'prekrsaj_' + brojac + '_' + j);
    			}
    			brojac++;
    		}
    	}
    });
    
    // Prikaz prekrsaja sudije na utkamici:
    $(document).on('click', 'p.utakmica_prekrasaj', function() {
    	var utakmica = $(this).attr('id');
    	var sudija = $('#sudija').val();
		$.ajax({
			method: "POST",
			// ?ruta=ajax/controller/method/args
			url: "index.php?ruta=ocenjivanje/" + utakmica + "/" + sudija,
			//data: { ajax_request: true, dataType: 'json' }, 
			//datatype: 'json',
			data: { ajax_request: true, dataType: 'html' },
			datatype: 'html',
    		beforeSend: function() {
    	    	$('#loading').show();
    		},
    		success: function(data) {
    			$('#sudijini_prekrsaji').empty()
    				.fadeOut('slow')
    				.append(data)
        			.fadeIn('slow');
    		},
    		complete: function() {
    			$('#loading').hide();
    		}
		});    	
    });
    
    // Function to delete Sezona:
    function deleteSezona(sezona) {
		$.ajax({
			method: "POST",
			// ?ruta=ajax/controller/method/args
			url: "index.php?ruta=sezona/delete/" + sezona,
			//data: { ajax_request: true, dataType: 'json' }, 
			//datatype: 'json',
			data: { ajax_request: true, dataType: 'html' },
			datatype: 'html',
    		beforeSend: function() {
    	    	$('#loading').show();
    		},
    		success: function(data) {
    			$('#base_content').html(data);
    		},
    		complete: function() {
    			$('#loading').hide();
    		}
		});    	    	
    }
    
    // Are you sure on delete:
    $(document).on('click', 'a.delete', function(e) {
    	e.preventDefault();
    	var name = $(this).attr("name");
    	$('<div></div>').appendTo('body')
    	  .html('<div><h5>Da li ste sigurni?</h5></div>')
    	  .dialog({
    	      modal: true, title: 'Brisanje ' + name + '?', zIndex: 10000, autoOpen: true,
    	      width: '300px', resizable: false,
    	      buttons: {
    	          Ne: function () {
    	              $(this).dialog("close");
    	          },
		          Da: function () {
		        	  deleteSezona(name);
    	        	  //location.reload(true);
		              $(this).dialog("close");
		          }
    	      },
    	      close: function (event, ui) {
    	          $(this).remove();
    	      }
    	});
    });
    
});