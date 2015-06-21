<h3>
  <?php
    switch ($akcija) {
      case 'add':
        echo "Dodaj sezonu";
        break;

      case 'edit':
        echo "Promena informacija o sezoni";
        break;
        
      case 'delete':
        echo "Obriši podatke sezone";
        break; 
    }
  ?>
</h3>

<form id="form-sezona" name="form-sezona" method="post">
	
	<div class="form_element">
		<label for="godina-sezone">Godina sezona:</label>
		<select name="godina-sezone" id="godina-sezone">
			<?php for ($i = date("Y"); $i >= 2005 ; $i--): ?>
				<option value="<?php print $i; ?>" <?php if (isset($sezona) && $i == $sezona->godina) { print 'selected="selected"'; }?>><?php print $i; ?></option>
			<?php endfor; ?>
		</select>
	</div>
	
	<div class="form_element">
		<label for="naziv-sezone">Naziv sezone:</label>
		<input type="text" size="20" name="naziv-sezone" id="naziv-sezone" value="<?php (isset($sezona)) ? print $sezona->naziv : ""; ?>" />
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
			<td><a href="?ruta=sezona/edit/<?php print $row['godina_sezone']; ?>">Izmeni</a> | <a class="delete" href="?ruta=sezona/delete/<?php print $row['godina_sezone']; ?>" name="<?php print $row['godina_sezone']; ?>">Obriši</a--></td>
		</tr>
		<?php endwhile; ?>
	</table>
<?php endif; ?>
