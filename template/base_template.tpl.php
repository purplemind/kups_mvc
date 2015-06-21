<div id="main_content">
	<?php $content = $register->router->loader(); ?>
	<?php if ($register->infos->has_errors()): ?>
		<div class="msg error"><?php $register->infos->print_errors(); ?></div>
	<?php endif; ?>
	<?php if ($register->infos->has_infos()): ?>
		<div class="msg info"><?php $register->infos->print_infos(); ?></div>
	<?php endif; ?>
	<div id="base_content">
	  <?php print $content; ?>
	</div>
</div>
