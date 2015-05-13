<h3>
	<?php if ($akcija == 'edit'): ?>
		Promena informacija o sezoni
	<?php else: ?>
		Dodaj sezonu
	<?php endif; ?>
</h3>
<form action="" id="form-sezona" name="form-sezona" method="post">
	
	<input type="hidden" name="akcija" value="<?php print $akcija; ?>" />
	
	<div class="form_element">
		<label for="godina-sezone">Godina sezona:</label>
		<select name="godina-sezone" id="godina-sezone">
			<?php for ($i = date("Y"); $i >= 2005 ; $i--): ?>
				<option value="<?php print $i; ?>" <?php if ($i == $sezona->godina) { print 'selected="selected"'; }?>><?php print $i; ?></option>
			<?php endfor; ?>
		</select>
	</div>
	
	<div class="form_element">
		<label for="naziv-sezone">Naziv sezone:</label>
		<input type="text" size="20" name="naziv-sezone" id="naziv-sezone" value="<?php ($akcija == 'edit') ? print $sezona->naziv : ""; ?>" />
	</div>
	
	<input type="submit" name="submit-sezona" id="submit-sezona" value="Potvrdi" />
	 
</form>

<?php $res = $sezona->get_all(); ?>
<?php if (!empty($res)): ?>
	<table name="spisak-sezona">
		<caption>Spisak sezona</caption>
		<tr>
			<th>Godina sezone</th>
			<th>Naziv sezone</th>
			<th>Akcija</th>
		</tr>
		<?php $i = 0; ?>
		<?php while ($row = $res->fetch_assoc()): ?>
			<?php $i++; ?>
		<tr class="<?php ($i % 2 == 0) ? print 'even' : print 'odd'; ?>">
			<td><?php print $row['godina_sezone']; ?></td>
			<td><?php print $row['naziv_sezone']; ?></td>
			<td><a href="?ruta=sezona/<?php print $row['godina_sezone']; ?>/edit">Izmeni</a> | <a href="?ruta=sezona/<?php print $row['godina_sezone']; ?>/delete">Obriši</a></td>
		</tr>
		<?php endwhile; ?>
	</table>
<?php endif; ?>
