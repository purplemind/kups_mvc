<div class="prekrsaj" id="div_prekrsaj_<?php print $broj_sudije; ?>_<?php print $broj_prekrsaja;?>">
  <select name="prekrsaj_<?php print $broj_sudije; ?>_<?php print $broj_prekrsaja?>" id="prekrsaj_<?php print $broj_sudije; ?>_<?php print $broj_prekrsaja?>">
    <?php foreach ($prekrsaji as $index => $value): ?>
      <option value="<?php print $value['sifra_faula']; ?>"><?php print $value['naziv_faula']; ?></option>
    <?php endforeach; ?>
  </select>
  
  <img src="images/delete.png" alt="Obriši" title="Obriši prekršaj" class="delete_prekrsaj" id="<?php print $broj_sudije; ?>_<?php print $broj_prekrsaja; ?>" />
</div>