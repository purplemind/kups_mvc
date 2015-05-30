<div id="loading">
  <img src="images/loading.gif" />
</div>

<div id="pregled_prekrsaja" style="margin-top: 15px;">

  <div id="izbor_sezone" style="float: left;">
    <select name="sezona" id="sezona">
      <option value="NaN">- Odaberi sezonu -</option>
      <?php if (isset($sezone)): ?>
      <?php while ($sezona = $sezone->fetch_assoc()): ?>
        <option value="<?php print $sezona['godina_sezone']; ?>"><?php print $sezona['godina_sezone']; ?></option>
      <?php endwhile; ?>
      <?php endif; ?>
    </select>
  </div>
  
  <div id="izbor_sudije" style="float: left; margin-left: 40px; margin-right: 40px;">
    <select name="sudija" id="sudija">
      <option value="NaN">- Odaberi sudiju -</option>
      <?php if (isset($sudije)): ?>
      <?php while ($sudija = $sudije->fetch_assoc()): ?>
        <option value="<?php print $sudija['sifra_sudije']; ?>"><?php print $sudija['ime'] . ' ' . $sudija['prezime']; ?></option>
      <?php endwhile; ?>
      <?php endif; ?>
    </select>
  </div>
  
  <div id="prikazi_utakmice_btn" class="div_btn">Prikaži utakmice</div>
  
  <div class="clear-float" style="margin-bottom: 10px;"></div>
  
  <div id="sudijine_utakmice" style="float: left; width: 50%; border-right: solid 1px red;">
  </div>
  
  <div id="sudijini_prekrsaji" style="float: left; width: 48%; margin-left: 10px;">
  </div>

  <div class="clear-float"></div>
  
</div>