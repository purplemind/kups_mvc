<div id="loading">
  <img src="images/loading.gif" />
</div>

<form action="" id="form-utakmica" name="form-utakmica" method="post">
	
	<input type="hidden" name="broj_sudija" id="broj_sudija" value="<?php print count($sudije); ?>" />
	
	<div id="utakmica_sudije">

    <div id="utakmica">
      <div class="inline">
    		<label for="godina_sezone" class="required-label">Sezona: </label>
    		<select name="required[godina_sezone]">
    			<?php while ($row = $sezone->fetch_assoc()): ?>
    				<option value="<?php print $row['godina_sezone']; ?>" <?php if ($row['godina_sezone'] == $utakmica->godina_sezone) { print 'selected="selected"'; }?>><?php print $row['godina_sezone']; ?></option>
    			<?php endwhile; ?>
    		</select>
  		</div>

  		<div class="inline">
    		<label for="datum" class="required-label">Datum: </label>
    		<input type="text" size="10" name="required[datum]" id="datepicker" value="<?php print DateTime::createFromFormat('Y-m-d H:i:s', $utakmica->datum)->format('d/m/Y'); ?>" />
  		</div>
  		
  		<div class="inline last">
  			<label for="sifra_lige" class="required-label">Liga: </label>
  			<select name="required[sifra_lige]" id="sifra_lige">
  			  <option value="0">- Liga -</option>
  				<?php foreach ($lige as $index => $value): ?>
  					<option value="<?php print $value['sifra_lige']; ?>" <?php if ($value['sifra_lige'] == $utakmica->sifra_lige) { print 'selected="selected"'; }?>><?php print $value['naziv_lige']; ?></option>
  				<?php endforeach; ?>
  			</select>
			</div>
  		<div class="clear_float"></div>	
  	</div>
  	
  	<div id="rezultat_pregledanje">
      <div class="inline">
    		<label for="domacin" class="required-label">Domaćin: </label>
  			<select name="required[domacin]" id="domacin">
    			<?php while ($row = $klubovi->fetch_assoc()): ?>
    				<option value="<?php print $row['sifra_kluba']; ?>" <?php if ($row['sifra_kluba'] == $utakmica->domacin) { print 'selected="selected"'; }?>><?php print $row['naziv_kluba']; ?></option>
    			<?php endwhile; ?>
  			</select>
  		</div>
		
  		<div class="inline last">
  		  <label for="poena_domacin" class="required-label">Poena: </label>
		    <input type="text" size="4" name="required[poena_domacin]" value="<?php print $utakmica->domacin_golova; ?>" />
		  </div>
  	  
  	  <div class="clear_float"></div>
  	  
      <div class="inline">
  		  <label for="gost" class="required-label">Gost: </label>
  			<select name="required[gost]" id="gost">
  			  <?php $klubovi->data_seek(0); ?>
    			<?php while ($row = $klubovi->fetch_assoc()): ?>
    				<option value="<?php print $row['sifra_kluba']; ?>" <?php if ($row['sifra_kluba'] == $utakmica->gost) { print 'selected="selected"'; }?>><?php print $row['naziv_kluba']; ?></option>
    			<?php endwhile; ?>
  			</select>
		  </div>
		  
  		<div class="inline last">
  		  <label for="poena_gost" class="required-label">Poena: </label>
  		  <input type="text" size="4" name="required[poena_gost]" value="<?php print $utakmica->gost_golova; ?>" />
		  </div>
		  
		  <div class="clear_float"></div>
 		  
		</div>
  	
  	<?php foreach($sudije as $index => $value): ?>
  	  <div id="sudija_<?php print $index; ?>" class="sudija">
  	  
    	  <div id="podaci_sudije_<?php print $index; ?>" class="podaci_sudije">
    	    <label class="required-label" for="sudija">Sudija: </label>
    	    <select id="select_sudija_<?php print $index; ?>" name="required[sudija_<?php print $index; ?>]">
    	      <?php foreach ($all_sudije as $ind => $val): ?>
    	        <option value="<?php print $val['sifra_sudije']; ?>" <?php if ($val['sifra_sudije'] == $value['sifra_sudije']) { print 'selected="selected"'; }?>><?php print $val['ime_prezime']; ?></option>
    	      <?php endforeach; ?>
    	    </select>
    	    
    	    <img id="delete_sudija_<?php print $index; ?>" class="delete_sudija" align="right" title="Obriši sudiju" alt="Obriši" src="images/delete.png"><br />
    	    
          <label class="required-label" for="pozicija_sudije">Pozicija na terenu: </label>
          <select id="pozicija_<?php print $index; ?>" name="required[pozicija_<?php print $index; ?>]">
            <?php foreach($all_pozicije as $ind => $val): ?>
              <option value="<?php print $ind; ?>" <?php if ($ind == $value['pozicija']) { print 'selected="selected"'; }?>><?php print $val; ?></option>
            <?php endforeach; ?>
          </select>
    	  </div>
    	  
   	    <div id="prekrsaji_sudije_<?php print $index; ?>" class="prekrsaji_sudije">
   	      <input id="broj_prekrsaja_sudija_<?php print $index; ?>" type="hidden" value="<?php print count($prekrsaji_sudije[$value['sifra_sudije']]); ?>" name="broj_prekrsaja_sudija_<?php print $index; ?>">
          <div id="dodaj_prekrsaj_<?php print $index; ?>" class="dodaj_prekrsaj_btn">Dodaj prekršaj</div>
          <div id="pojedinacan_prekrsaj_<?php print $index; ?>">
            <?php foreach ($prekrsaji_sudije[$value['sifra_sudije']] as $ind => $val): ?>
              <div id="div_prekrsaj_<?php print $index; ?>_<?php print $ind; ?>" class="prekrsaj">
                <select id="prekrsaj_<?php print $index; ?>_<?php print $ind; ?>" name="prekrsaj_<?php print $index; ?>_<?php print $ind; ?>">
                  <?php foreach($all_faulovi as $i => $v): ?>
                    <option value="<?php print $v['sifra_faula']; ?>" <?php if ($v['sifra_faula'] == $val['sifra_faula']) { print 'selected="selected"'; } ?>><?php print $v['naziv_faula']; ?></option>
                  <?php endforeach; ?>
                </select>
                <img id="<?php print $index; ?>_<?php print $ind; ?>" class="delete_prekrsaj" title="Obriši prekršaj" alt="Obriši" src="images/delete.png">
              </div>
            <?php endforeach; ?>
          </div>
        </div>
 	    
 	    </div>
    <?php endforeach; ?>
  	
  	<div id="dodajSudiju" class="fixed_btn">Dodaj sudiju</div>
	</div>
	
	<div id="submit_div" align="center"><input type="submit" id="sacuvaj_utakmicu" name="sacuvaj_utakmicu" value="Sacuvaj" /></div>
	
</form>
