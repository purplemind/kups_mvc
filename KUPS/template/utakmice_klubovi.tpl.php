<form action="" id="form-klubovi-sudije" name="form-klubovi-sudije" method="post">
	
	<input type="hidden" name="step" value="2" />
	<?php foreach($first_step as $key => $value): ?>
		<input type="hidden" name="<?php print $key; ?>" value="<?php print $value; ?>" />
	<?php endforeach; ?>
	
	<div id="klubovi_sudije">
	
		<div class="poseban_odeljak">
			<label for="domacin" class="required-label">Domaćin: </label>
			<select name="required[domacin]" <?php if ($steps_before > 1) { print "disabled"; } ?>>
				<?php while ($row = $klubovi->fetch_assoc()): ?>
					<option value="<?php print $row['sifra_kluba']; ?>" <?php //if ($i == $sudija->godina_pocetka) { print 'selected="selected"'; }?>><?php print $row['naziv_kluba']; ?></option>
				<?php endwhile; ?>
			</select>
		
		  <label for="poena_domacin_ht" class="required-label">Poena (HT): </label>
		  <input type="text" size="4" name="required[poena_domacin_ht]" value="<?php //print $sudija->ime; ?>" <?php if ($steps_before > 1) { print "disabled"; } ?> />
		  
		  <label for="poena_domacin_ft" class="required-label">Poena (FT): </label>
		  <input type="text" size="4" name="required[poena_domacin_ft]" value="<?php //print $sudija->ime; ?>" <?php if ($steps_before > 1) { print "disabled"; } ?> />
		</div>

		<div class="poseban_odeljak">
			<label for="gost" class="required-label">Gost: </label>
			<select name="required[gost]" <?php if ($steps_before > 1) { print "disabled"; } ?>>
				<?php $klubovi->data_seek(0); while ($row = $klubovi->fetch_assoc()): ?>
					<option value="<?php print $row['sifra_kluba']; ?>" <?php //if ($i == $sudija->godina_pocetka) { print 'selected="selected"'; }?>><?php print $row['naziv_kluba']; ?></option>
				<?php endwhile; ?>
			</select>
		
		  <label for="poena_gost_ht" class="required-label">Poena (HT): </label>
		  <input type="text" size="4" name="required[poena_gost_ht]" value="<?php //print $sudija->ime; ?>" <?php if ($steps_before > 1) { print "disabled"; } ?> />
		  
		  <label for="poena_gost_ft" class="required-label">Poena (FT): </label>
		  <input type="text" size="4" name="required[poena_gost_ft]" value="<?php //print $sudija->ime; ?>" <?php if ($steps_before > 1) { print "disabled"; } ?> />
		</div>
		
		<div class="poseban_odeljak">
		  <label for="broj_produzetaka" class="required-label">Broj produžetaka: </label>
		  <input type="text" size="4" name="required[broj_produzetaka]" value="<?php //print $sudija->ime; ?>" <?php if ($steps_before > 1) { print "disabled"; } ?> />
		
		  <label for="trajanje_utakmice" class="required-label">Trajanje utakmice: </label>
		  <input type="text" size="4" name="required[trajanje_utakmice]" value="<?php //print $sudija->ime; ?>" <?php if ($steps_before > 1) { print "disabled"; } ?> />
		
		  <label for="trajanje_produzetaka" class="required-label">Trajanje produžetaka: </label>
		  <input type="text" size="4" name="required[trajanje_produzetaka]" value="<?php //print $sudija->ime; ?>" <?php if ($steps_before > 1) { print "disabled"; } ?> />
		  
		  <div class="form_element">
			  <label for="pregledanje">Pregledati: </label>
			  <input type="radio" name="pregledanje" value="0" <?php //if ($sudija->automobil) { print "checked"; } ?> >Ne
			  <input type="radio" name="pregledanje" value="1" <?php //if (!$sudija->automobil) { print "checked"; } ?> >I poluvreme
			  <input type="radio" name="pregledanje" value="2" <?php //if (!$sudija->automobil) { print "checked"; } ?> >II poluvreme
		  </div>
		</div>
		
	</div>
	
	<input type="submit" name="klubovi-sudije" id="klubovi-sudije" value="Dalje" />
	
</form>