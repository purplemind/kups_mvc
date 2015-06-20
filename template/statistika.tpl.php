<div id="statistika">
  
  <p>Prikaz opcija za koje se zeli pogledati statistika.</p>
  
  <form id="form-statistika" name="form-statistika" method="post">
  
    <?php if (isset($sudije)): ?>
      <div id="sudija">
        <select name="sudija">
          <option value="NaN">- Odaberi sudiju -</option>
          <?php foreach ($sudije as $sudija): ?>
            <option value="<?php print $sudija['sifra_sudije']; ?>" <?php if (isset($seted_sudija) && $seted_sudija == $sudija['sifra_sudije']) { echo 'selected="selected"'; } ?>><?php print $sudija['ime'] . ' ' . $sudija['prezime']; ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    <?php endif;?>
    
    <?php if (isset($sezone)): ?>
      <div id="sezona">
          <select name="sezona">
            <option value="NaN">- Odaberi sezonu -</option>
            <?php foreach ($sezone as $sezona): ?>
              <option value="<?php print $sezona['godina_sezone']; ?>" <?php if (isset($seted_sezona) && $seted_sezona == $sezona['godina_sezone']) { echo 'selected="selected"'; } ?>><?php print $sezona['godina_sezone']; ?></option>
            <?php endforeach; ?>
          </select>
      </div>
    <?php endif; ?>
    
    <input type="submit" value="Statistika" name="statistika" />
    
    <?php if (isset($po_ligama)): ?>
      <div id="statistika_po_ligama">
        <table>
          <tr>
            <th>Liga</th>
            <th>Broj utakmica</th>
          </tr>
          <?php foreach($po_ligama as $po_ligi): ?>
            <tr>
              <td><?php echo $po_ligi['naziv_lige']; ?></td>
              <td><?php echo $po_ligi['broj_utakmica']; ?></td>
            </tr>
          <?php endforeach; ?>
        </table>
      </div>
    <?php endif; ?>
    
    <?php if (isset($po_pozicijama)): ?>
      <div id="statistika_po_pozicijama">
        <table>
          <tr>
            <th>Pozicija</th>
            <th>Broj utakmica</th>
          </tr>
          <?php foreach ($po_pozicijama as $po_poziciji): ?>
            <tr>
              <td><?php echo $po_poziciji['pozicija']; ?></td>
              <td><?php echo $po_poziciji['broj_utakmica']; ?></td>
            </tr>
          <?php endforeach; ?>
        </table>
      </div>
    <?php endif; ?>
    
    <?php if (isset($po_ocenama)): ?>
      <div id="statistika_po_ocenama">
        <table>
          <tr>
            <th>Ocena</th>
            <th>Broj ocena u sezoni</th>
          </tr>
          <?php foreach ($po_ocenama as $po_oceni): ?>
            <tr>
              <td><?php echo $po_oceni['ocena_prekrsaja']; ?></td>
              <td><?php echo $po_oceni['broj_faulova']; ?></td>
            </tr>
          <?php endforeach; ?>
        </table>
      </div>
    <?php endif; ?>
  
  </form>
  
</div>