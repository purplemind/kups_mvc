<?php if (isset($prekrsaji) && is_array($prekrsaji)): ?>

  <input type="hidden" name="id_utakmice" id="id_utakmice" value="<?php print $id_utakmice; ?>" />
  <input type="hidden" name="id_sudije" id="id_sudije" value="<?php print $id_sudije; ?>" />
   
  <?php
    $i = 0; 
  	$ocene = array(
			'NaN' => 'Ocena',
			'CC' => 'CC',
			'MC' => 'MC',
			'BC' => 'BC',
			'NC' => 'NC',
			'NG' => 'NG',
			'CJ/IJ' => 'CJ/IJ',
			'GM/BM' => 'GM/BM',
			'NR' => 'NR',
    );
  ?>
  <div class="lista_prekrsaja" style="width: 100%;">
    <?php foreach($prekrsaji as $id_prekrsaja => $prekrsaj): ?>
      <div class="single_prekrsaj" style="width: 100%;">
        <?php echo (++$i) . '. ' . $prekrsaj['naziv_faula']; ?>
        <select id="prekrsaj_<?php echo $id_prekrsaja; ?>" name="prekrsaj_<?php echo $id_prekrsaja; ?>">
          <?php foreach ($ocene as $key => $value): ?>
            <option value="<?php echo $key; ?>" <?php if ($value == $prekrsaj['ocena_faula']) { echo 'selected="selected"'; }?>><?php echo $value; ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <?php endforeach; ?>
  </div>
  
  <input type="submit" id="sacuvaj_promene_ocenjivanje" name="sacuvaj_promene_ocenjivanje" value="Sačuvaj promene" />
      
<?php endif; ?>
