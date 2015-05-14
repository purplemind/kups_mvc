<form action="" id="form-utakmica" name="form-utakmica" method="post">
	
	<input type="hidden" name="akcija" value="<?php print $akcija; ?>" />
	
	<div id="utakmica_sudije">

    <div id="utakmica">
    
      <div class="inline">
    		<label for="godina_sezone" class="required-label">Sezona: </label>
    		<select name="required[godina_sezone]">
    			<?php while ($row = $sezone->fetch_assoc()): ?>
    				<option value="<?php print $row['godina_sezone']; ?>" <?php if ($row['godina_sezone'] == $utakmica->godina_sezone) { print 'selected="selected"'; }?>><?php print $row['godina_sezone']; ?></option>
    			<?php endwhile; ?>
    		</select>
  		</div>

  		<div class="inline">
    		<label for="datum" class="required-label">Datum: </label>
    		<input type="text" size="10" name="required[datum]" id="datepicker" value="<?php print date('d/m/Y', $utakmica->datum); ?>" />
  		</div>
  		
  		<div class="inline last">
  			<label for="sifra_lige" class="required-label">Liga: </label>
  			<select name="required[sifra_lige]" id="sifra_lige">
  				<?php while ($row = $lige->fetch_assoc()): ?>
  					<option value="<?php print $row['sifra_lige']; ?>" <?php if ($row['sifra_lige'] == $utakmica->sifra_lige) { print 'selected="selected"'; }?>><?php print $row['sifra_lige']; ?></option>
  				<?php endwhile; ?>
  			</select>
			</div>
  		<div class="clear_float"></div>
  		
  	</div>
  	
  	<div id="sudije">
  	
  		<label for="domacin" class="required-label">Domaćin: </label>
			<select name="required[domacin]" id="domacin">
				<?php while ($row = $klubovi->fetch_assoc()): ?>
					<option value="<?php print $row['sifra_kluba']; ?>">
					  <?php print $row['naziv_kluba']; ?>
					</option>
				<?php endwhile; ?>
			</select>
		
		  <label for="poena_domacin" class="required-label">Poena: </label>
		  <input type="text" size="4" name="required[poena_domacin]" value="0" />
  	
  		<label for="gost" class="required-label">Gost: </label>
			<select name="required[gost]" id="gost">
				<?php while ($row = $klubovi->fetch_assoc()): ?>
					<option value="<?php print $row['sifra_kluba']; ?>">
					  <?php print $row['naziv_kluba']; ?>
					</option>
				<?php endwhile; ?>
			</select>
		
		  <label for="poena_gost" class="required-label">Poena: </label>
		  <input type="text" size="4" name="required[poena_gost]" value="0" />
		  
 		  <div class="form_element">
			  <label for="pregledanje">Pregledati: </label>
			  <input type="radio" name="pregledanje" value="0">Ne
			  <input type="radio" name="pregledanje" value="1">I poluvreme
			  <input type="radio" name="pregledanje" value="2">II poluvreme
		  </div>
		  
		</div>
  	
	</div>
	 
</form>