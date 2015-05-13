<form action="" id="form-utakmica-datum" name="form-utakmica-datum" method="post">
	
	<input type="hidden" name="akcija" value="<?php print $akcija; ?>" />
	<input type="hidden" name="step" value="1" />
	
	<div id="datum_vreme_liga" <?php if ($steps_before > 0) print 'class="finished_step"'; ?>>
		<label for="godina_sezone" class="required-label">Sezona: </label>
		<select name="required[godina_sezone]" <?php if ($steps_before > 0) { print "disabled"; } ?>>
			<?php while ($row = $sezone->fetch_assoc()): ?>
				<option value="<?php print $row['godina_sezone']; ?>" <?php if ($row['godina_sezone'] == $utakmica->godina_sezone) { print 'selected="selected"'; }?>><?php print $row['godina_sezone']; ?></option>
			<?php endwhile; ?>
		</select>
				
		<label for="datum" class="required-label">Datum: </label>
		<input type="text" size="10" name="required[datum]" id="datepicker" value="<?php print date('d/m/Y', $utakmica->datum); ?>" <?php if ($steps_before > 0) { print "disabled"; } ?> />
		
		<label for="vreme_pocetka" class="required-label">Vreme: </label>
		<input type="text" size="10" name="required[vreme_pocetka]" value="<?php print $utakmica->vreme_pocetka; ?>" <?php if ($steps_before > 0) { print "disabled"; } ?> />
		
		<div class="form_element">
			<label for="sifra_lige" class="required-label">Liga: </label>
			<select name="required[sifra_lige]" <?php if ($steps_before > 0) { print "disabled"; } ?>>
				<?php while ($row = $lige->fetch_assoc()): ?>
					<option value="<?php print $row['sifra_lige']; ?>" <?php if ($row['sifra_lige'] == $utakmica->sifra_lige) { print 'selected="selected"'; }?>><?php print $row['sifra_lige']; ?></option>
				<?php endwhile; ?>
			</select>
		</div>
	</div>
	
	<?php if ($steps_before == 0): ?>
	<input type="submit" name="utakmica-datum" id="utakmica-datum" value="Dalje" />
	<?php endif;?>
	 
</form>