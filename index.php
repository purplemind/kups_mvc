<?php
/*** error reporting on ***/
error_reporting(E_ALL);

	include_once 'app/baseController.class.php';
	include_once 'app/register.class.php';
	include_once 'app/db.class.php';
	include_once 'app/info.class.php';
	include_once 'app/router.class.php';
	include_once 'app/template.class.php';
	
	$site_path = realpath(dirname(__FILE__));
 	define ('__SITE_PATH', $site_path);
 	
 	$register = new Registry;
	$db = new DB;
 	$register->db_conn = $db->connect();
 	$register->infos = new Info;
 	$register->template = new Template($register);
 	$register->router = new Router($register);
 	$register->router->setPath(__SITE_PATH . '/' . 'controller');
 	
 	if (isset($_POST['ajax_request'])) {// && $_POST['ajax_request'] === TRUE) {
 	  die($register->router->loader());
 	}
 	
?>

<!DOCTYPE html>
<html>
<head>
	<!-- meta charset="UTF-8"-->
	<?php header('Content-Type: text/html; charset=UTF-8'); ?>
	<!-- script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script-->
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src="js/kups.js"></script>
	<link type="text/css" rel="stylesheet" href="//fonts.googleapis.com/css?family=Alfa+Slab+One|Droid+Serif:400,700">
	<!-- link href='http://fonts.googleapis.com/css?family=Arvo' rel='stylesheet' type='text/css' -->
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/form_element.css">
	<title>KUPS Database</title>
</head>

<body>
	<div id="container" align="center">
	
		<div id="content">
			
			<div id="menu">
				Formulari
				<ul>
					<li class="first"><a href="?ruta=sezona">Sezona</a></li>
					<li><a href="?ruta=sudije">Sudije</a></li>
					<li>
					   <a href="?ruta=utakmice">Utakmice</a>
					   <ul>
					     <li><a href="?ruta=utakmice/search">Pretraga</a></li>
					   </ul>
					</li>
					<li><a href="?ruta=ocenjivanje">Ocenjivanje</a></li>
					<li><a href="?ruta=statistika">Statistika</a></li>
				</ul>
			</div>
			
			<div id="main_content">
				<?php $content = $register->router->loader(); ?>
				<?php if ($register->infos->has_errors()): ?>
					<div class="msg error"><?php $register->infos->print_errors(); ?></div>
				<?php endif; ?>
				<?php if ($register->infos->has_infos()): ?>
					<div class="msg info"><?php $register->infos->print_infos(); ?></div>
				<?php endif; ?>
				<?php print $content; ?>
			</div>
			
			<div class="clear-float"></div>
			
		</div>
		
	</div>
</body>

</html>
