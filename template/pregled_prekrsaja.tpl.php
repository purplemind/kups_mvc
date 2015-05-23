<?php
?>
<div id="pregled_prekrsaja">
  
  <div id="izbor_sezone" style="float: left; width: 48%;">
    <select name="sezona">
      <option value="NaN">- Odaberi sezonu -</option>
      <?php if (isset($sezone)): ?>
      <?php while ($sezona = $sezone->fetch_assoc()): ?>
        <option value="<?php print $sezona['godina_sezone']; ?>"><?php print $sezona['godina_sezone']; ?></option>
      <?php endwhile; ?>
      <?php endif; ?>
    </select>
  </div>
  
  <div id="izbor_sudije" style="float: left; width: 48%;">
    <select name="sudija">
      <option value="NaN">- Odaberi sudiju -</option>
      <?php if (isset($sudije)): ?>
      <?php while ($sudija = $sudije->fetch_assoc()): ?>
        <option value="<?php print $sudija['sifra_sudije']; ?>"><?php print $sudija['ime'] . ' ' . $sudija['prezime']; ?></option>
      <?php endwhile; ?>
      <?php endif; ?>
    </select>
  </div>
  
  <div class="clear-float"></div>
  
  <div id="sudijine_utakmice" style="float: left; width: 40%;">
    Spisak utakmica
  </div>
  

  <div id="pregled_prekrsaja_na_utakmici" style="float: left; width: 56%;">
    Spisak prekrsaja  
  </div>

  <div class="clear-float"></div>
  
</div>