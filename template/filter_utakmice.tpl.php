<form id="select_edit_utakmice" name="select_edit_utakmice" method="post">
  
  <div id="utakmice_filteri">
    <select id="filter_sezona" name="filter_sezona">
      <option value="0">- Sezona -</option>
      <?php while ($row = $sezone->fetch_assoc()): ?>
    	  <option value="<?php print $row['godina_sezone']; ?>" <?php if (isset($selected_sezona) && $selected_sezona == $row['godina_sezone']) { echo 'selected="selected"'; } ?>><?php print $row['godina_sezone']; ?></option>
    	<?php endwhile; ?>
    </select>
    
    <select id="filter_liga" name="filter_liga">
  	  <option value="0">- Liga -</option>
  		<?php foreach ($lige as $index => $value): ?>
  		  <option value="<?php print $value['sifra_lige']; ?>" <?php if (isset($selected_liga) && $selected_liga == $value['sifra_lige']) { echo 'selected="selected"'; } ?>><?php print $value['naziv_lige']; ?></option>
  		<?php endforeach; ?>
    </select>
    
    <input type="submit" name="primeni_filter_btn" value="Primeni filter" />
  </div>
  
  <?php if (isset($filter) && isset($utakmice)): ?>
    <table name="pregled_utakmica">
      <caption>Utakmice po zadatim filterima</caption>
      <tr>
        <th style="width: 15%;">Datum</th>
        <th style="width: 10%;">Liga</th>
        <th style="width: 50%;">Utakmica</th>
        <th style="width: 10%;">Rezultat</th>
        <th style="width: 15%;">Akcija</th>
      </tr>
      <?php foreach ($utakmice as $index => $values): ?>
          <?php //print $values['sifra_utakmice']; ?>
          <tr>
            <td><?php print DateTime::createFromFormat('Y-m-d H:i:s', $values['datum'])->format('d.m.Y.'); ?></td>
            <td><?php print $values['sifra_lige']; ?></td>
            <td><?php print $values['domacin'] .' - ' .$values['gost']; ?></td>
            <td><?php print $values['domacin_ft_golova'] .' : ' .$values['gost_ft_golova']; ?></td>
            <td><a href="?ruta=utakmice/edit/<?php print $values['sifra_utakmice']; ?>">Izmeni</a> / <a href="utakmica/delete/<?php print $values['sifra_utakmice']; ?>">Obriši</a></td>
          </tr>          
      <?php endforeach; ?>
    </table>
  <?php endif; ?>

  <div id="pager">
    <a href="?ruta=utakmice/filter/1&filter_sezona=<?php if (isset($selected_sezona)) { print $selected_sezona; } ?>&filter_liga=<?php if (isset($selected_liga)) { print $selected_liga; } ?>">1</a>
    <a href="?ruta=utakmice/filter/2&filter_sezona=<?php if (isset($selected_sezona)) { print $selected_sezona; } ?>&filter_liga=<?php if (isset($selected_liga)) { print $selected_liga; } ?>">2</a>
    <a href="?ruta=utakmice/filter/3&filter_sezona=<?php if (isset($selected_sezona)) { print $selected_sezona; } ?>&filter_liga=<?php if (isset($selected_liga)) { print $selected_liga; } ?>">3</a>
  </div>
  
</form>