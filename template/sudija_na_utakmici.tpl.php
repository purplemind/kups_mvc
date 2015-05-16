<div id="sudija_<?php print $broj_sudije; ?>" class="sudija" class="inline last">
  
  <div id="podaci_sudije_<?php print $broj_sudije; ?>" class="podaci_sudije">
    <label for="sudija" class="required-label">Sudija: </label>
    <select name="required[sudija_<?php print $broj_sudije; ?>]" id="select_sudija_<?php print $broj_sudije; ?>">
      <?php foreach ($sudije as $index => $value): ?>
        <option value="<?php print $value['sifra_sudije']; ?>"><?php print $value['ime_prezime']; ?></option>
      <?php endforeach; ?>
    </select>
   
    <img src="images/delete.png" alt="Obriši" title="Obriši sudiju" class="delete_sudija" id="delete_sudija_<?php print $broj_sudije; ?>" align="right" />
    <br />
    
    <label for="pozicija_sudije" class="required-label">Pozicija na terenu: </label>
    <select name="required[pozicija_<?php print $broj_sudije; ?>]" id="pozicija_<?php print $broj_sudije; ?>">
      <?php foreach ($pozicije as $index => $value): ?>
        <option value="<?php print $index; ?>"><?php print $value; ?></option>
      <?php endforeach; ?>
    </select><br />    
  </div>
  
  <div id="prekrsaji_sudije_<?php print $broj_sudije; ?>" class="prekrsaji_sudije">
    <input type="hidden" id="broj_prekrsaja_sudija_<?php print $broj_sudije; ?>" value="0" />
    
    <div id="dodaj_prekrsaj_<?php print $broj_sudije; ?>" class="dodaj_prekrsaj_btn">Dodaj prekršaj</div>
    
    <div id="pojedinacan_prekrsaj_<?php print $broj_sudije; ?>"></div>
  </div>

  <div class="clear_float"></div>

</div>