<div id="loading">
  <img src="images/loading.gif" />
</div>

<form action="" id="form-utakmica" name="form-utakmica" method="post">
	
	<!-- input type="hidden" name="akcija" value="<?php //print $akcija; ?>" /-->
	<input type="hidden" name="broj_sudija" id="broj_sudija" value="0" />
	
	<div id="utakmica_sudije">

    <div id="utakmica">
      <div class="inline">
    		<label for="godina_sezone" class="required-label">Sezona: </label>
    		<select name="required[godina_sezone]">
    			<?php while ($row = $sezone->fetch_assoc()): ?>
    				<option value="<?php print $row['godina_sezone']; ?>"><?php print $row['godina_sezone']; ?></option>
    			<?php endwhile; ?>
    		</select>
  		</div>

  		<div class="inline">
    		<label for="datum" class="required-label">Datum: </label>
    		<input type="text" size="10" name="required[datum]" id="datepicker" value="<?php print date('d/m/Y'); ?>" />
  		</div>
  		
  		<div class="inline last">
  			<label for="sifra_lige" class="required-label">Liga: </label>
  			<select name="required[sifra_lige]" id="sifra_lige">
  			   <option value="0">- Liga -</option>
  				<?php foreach ($lige as $index => $value): ?>
  					<option value="<?php print $value['sifra_lige']; ?>"><?php print $value['naziv_lige']; ?></option>
  				<?php endforeach; ?>
  			</select>
			</div>
  		<div class="clear_float"></div>	
  	</div>
  	
  	<div id="rezultat_pregledanje">
      <div class="inline">
    		<label for="domacin" class="required-label">Domaćin: </label>
  			<select name="required[domacin]" id="domacin">
  			</select>
  		</div>
		
  		<div class="inline last">
  		  <label for="poena_domacin" class="required-label">Poena: </label>
		    <input type="text" size="4" name="required[poena_domacin]" value="0" />
		  </div>
  	  
  	  <div class="clear_float"></div>
  	  
      <div class="inline">
  		  <label for="gost" class="required-label">Gost: </label>
  			<select name="required[gost]" id="gost">
  			</select>
		  </div>
		  
  		<div class="inline last">
  		  <label for="poena_gost" class="required-label">Poena: </label>
  		  <input type="text" size="4" name="required[poena_gost]" value="0" />
		  </div>
		  
		  <div class="clear_float"></div>
		  
 		  <div class="form_element">
			  <label for="pregledanje">Pregledati: </label>
			  <input type="radio" name="pregledanje" value="0">Ne
			  <input type="radio" name="pregledanje" value="1">I poluvreme
			  <input type="radio" name="pregledanje" value="2">II poluvreme
		  </div>  		  
		</div>
  	
  	<div id="dodajSudiju" class="fixed_btn">Dodaj sudiju</div>
	</div>
	
	<div id="submit_div" align="center"><input type="submit" id="sacuvaj_utakmica" name="sacuvaj_utakmica" value="Sacuvaj" /></div>
	
</form>