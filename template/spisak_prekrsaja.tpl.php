<div class="prekrsaj">
  <select name="prekrsaj_<?php print $broj_sudije; ?>_<?php print $broj_prekrsaja?>">
    <?php foreach ($prekrsaji as $index => $value): ?>
      <option value="<?php print $value['sifra_faula']; ?>"><?php print $value['naziv_faula']; ?></option>
    <?php endforeach; ?>
  </select>
</div>