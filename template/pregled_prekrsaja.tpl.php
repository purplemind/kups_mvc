<div id="loading">
  <img src="images/loading.gif" />
</div>

<form id="form-utakmica" name="form-utakmica" method="post">

<div id="pregled_prekrsaja" style="margin-top: 15px;">

  <div id="izbor_sezone" style="float: left;">
    <select name="sezona" id="sezona">
      <option value="NaN">- Odaberi sezonu -</option>
      <?php if (isset($sezone)): ?>
      <?php while ($sezona = $sezone->fetch_assoc()): ?>
        <option value="<?php print $sezona['godina_sezone']; ?>" <?php if (isset($seted_sezona) && $seted_sezona == $sezona['godina_sezone']) { echo 'selected="selected"'; } ?>><?php print $sezona['godina_sezone']; ?></option>
      <?php endwhile; ?>
      <?php endif; ?>
    </select>
  </div>
  
  <div id="izbor_sudije" style="float: left; margin-left: 40px; margin-right: 40px;">
    <select name="sudija" id="sudija">
      <option value="NaN">- Odaberi sudiju -</option>
      <?php if (isset($sudije)): ?>
      <?php while ($sudija = $sudije->fetch_assoc()): ?>
        <option value="<?php print $sudija['sifra_sudije']; ?>" <?php if (isset($seted_sudija) && $seted_sudija == $sudija['sifra_sudije']) { echo 'selected="selected"'; } ?>><?php print $sudija['ime'] . ' ' . $sudija['prezime']; ?></option>
      <?php endwhile; ?>
      <?php endif; ?>
    </select>
  </div>
  
  <div id="submit_div">
    <input type="submit" id="prikazi_utakmice" name="prikazi_utakmice" value="Prikaži utakmice" />
  </div>
    
  <div id="sudijine_utakmice" style="float: left; width: 50%; border-right: solid 1px red;">
    <?php if (isset($utakmice_sudije) && !empty($utakmice_sudije)): ?>
      <?php foreach($utakmice_sudije as $sifra => $podaci): ?>
        <p id="<?php echo $sifra; ?>" class="utakmica_prekrasaj"> <?php echo $podaci['domacin'] . ' - ' . $podaci['gost']; ?></p>
      <?php endforeach;?>
    <?php else: ?>
      <p>Nema utakmica za odabranu sudiju i sezonu.</p> 
    <?php endif; ?>
  </div>
  
  
  <div id="sudijini_prekrsaji" style="float: left; width: 48%; margin-left: 10px;">
    <?php if (isset($prekrsaji_tpl)): ?>
      <?php print $prekrsaji_tpl; ?>
    <?php endif; ?>
  </div>

  <div class="clear_float"></div>
  
</div>

</form>