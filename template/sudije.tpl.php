<form action="" id="form-sudije" name="form-sudije" method="post">
	
	<input type="hidden" name="akcija" value="<?php print $akcija; ?>" />
	
	<div class="form_element">
		<label for="sifra_sudije" class="required-label">Šifra sudije: </label>
		<input type="text" size="6" name="required[sifra_sudije]" maxlength="6" value="<?php print $sudija->sifra_sudije; ?>" />
	</div>

	<div class="form_element">
		<label for="ime" class="required-label">Ime sudije: </label>
		<input type="text" size="20" name="required[ime]" value="<?php print $sudija->ime; ?>" />
	</div>
	
	<div class="form_element">
		<label for="prezime" class="required-label">Prezime sudije: </label>
		<input type="text" size="20" name="required[prezime]" value="<?php print $sudija->prezime; ?>" />
	</div>
	
	<div class="form_element">
		<label for="godina_pocetka" class="required-label">Godina sezona: </label>
		<select name="required[godina_pocetka]">
			<?php for ($i = date("Y"); $i >= 2000 ; $i--): ?>
				<option value="<?php print $i; ?>" <?php if ($i == $sudija->godina_pocetka) { print 'selected="selected"'; }?>><?php print $i; ?></option>
			<?php endfor; ?>
		</select>
	</div>
	
	<div class="form_element">
		<label for="mesto_stanovanja" class="required-label">Mesto stanovanja: </label>
		<input type="text" size="40" name="required[mesto_stanovanja]" value="<?php print $sudija->mesto_stanovanja; ?>" />
	</div>

	<div class="form_element">
		<label for="automobil" class="required-label">Automobil: </label>
		<input type="radio" name="required[automobil]" value="1" <?php if ($sudija->automobil) { print "checked"; } ?> >Poseduje auto
		<input type="radio" name="required[automobil]" value="0" <?php if (!$sudija->automobil) { print "checked"; } ?> >Ne poseduje auto
	</div>
	
	<div class="form_element">
		<label for="ne_ekipama">Klubovi kojima ne želi da sudi: </label><br />
		<textarea cols="30" rows="3" name="ne_ekipama"><?php print $sudija->ne_ekipama; ?></textarea>
	</div>

	<div class="form_element">
		<label for="ne_ligama">Lige kojima ne želi da sudi: </label><br />
		<textarea cols="30" rows="3" name="ne_ligama"><?php print $sudija->ne_ligama; ?></textarea>
	</div>

	<div class="form_element">
		<label for="za_komesara">Napomene za komesara: </label><br />
		<textarea cols="30" rows="3" name="za_komesara"><?php print $sudija->za_komesara; ?></textarea>
	</div>
	
	<input type="submit" name="submit-sudija" id="submit-sudija" value="Potvrdi" />
	 
</form>

<?php $res = $sudija->get_all(); ?>
<?php if ($res && $res->num_rows > 0): ?>
	<table name="spisak-sudija">
		<caption>Spisak sudija</caption>
		<tr>
			<th>Šifra</th>
			<th>Ime</th>
			<th>Prezime</th>
			<th>Godina početka</th>
			<th>Mesto stanovanja</th>
			<th>Automobil</th>
			<th>Ne ekipama</th>
			<th>Ne ligama</th>
			<th>Za komesara</th>
			<th>Akcija</th>
			</tr>
		<?php $i = 0; ?>
		<?php while ($row = $res->fetch_assoc()): ?>
			<?php $i++; ?>
		<tr class="<?php ($i % 2 == 0) ? print 'even' : print 'odd'; ?>">
			<td><?php print $row['sifra_sudije']; ?></td>
			<td><?php print $row['ime']; ?></td>
			<td><?php print $row['prezime']; ?></td>
			<td><?php print $row['godina_pocetka']; ?></td>
			<td><?php print $row['mesto_stanovanja']; ?></td>
			<td><?php $row['automobil'] == 1 ? print "Da" : print "Ne"; ?></td>
			<td><?php print $row['ne_ekipama']; ?></td>
			<td><?php print $row['ne_ligama']; ?></td>
			<td><?php print $row['za_komesara']; ?></td>
			<td><a href="?ruta=sudije/<?php print $row['sifra_sudije']; ?>/edit">Izmeni</a> | <a href="?ruta=sudije/<?php print $row['sifra_sudije']; ?>/delete">Obriši</a></td>
		</tr>
		<?php endwhile; ?>
	</table>
<?php endif; ?>

