<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name=viewport content="width=device-width, initial-scale=1.0">
	<title><?= $this->_titlepage ?></title>
	<link rel="stylesheet" type="text/css" href="/scripts/carousel/carousel.css">
	<link rel="stylesheet" href="/components/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="/skins/page/css/global.css?v=1.12">
	<link rel="stylesheet" href="/skins/page/css/estiloseditor.css?v=1.00">
	<link rel="stylesheet" href="/components/bootstrap-fileinput/css/fileinput.css">
	<script href="/components/fullcalendar/dist/index.global.min.js"></script>
	<link href='https://fonts.googleapis.com/css?family=Arizonia' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Great+Vibes' rel='stylesheet' type='text/css'>
	<link href="https://fonts.googleapis.com/css2?family=Euphoria+Script&family=Homemade+Apple&family=Miss+Fajardose&display=swap" rel="stylesheet">
	
	<script type="text/javascript" id="www-widgetapi-script" src="https://s.ytimg.com/yts/jsbin/www-widgetapi-vflS50iB-/www-widgetapi.js" async=""></script>
	<script src="https://www.youtube.com/player_api"></script>
	<link rel="icon" href="/skins/page/images/favicon_omega.ico" type="image/x-icon">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>

	
</head>
<body <?php if($this->_data['es_login'] == 1){ ?> class="login-fondo" <?php } ?>>

	<script src="/components/jquery/dist/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.8/umd/popper.min.js"></script>
	<script src="/components/bootstrap/dist/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="/scripts/carousel/carousel.js"></script>
    <script src="/components/bootstrap-validator/dist/validator.min.js"></script>
	<script src="/skins/page/js/main.js?v=1.03"></script>

	<script src="/components/moment/moment.js"></script>
	<script src="/components/tempusdominus-bootstrap-4/build/js/tempusdominus-bootstrap-4.js"></script>
	<link href="/components/tempusdominus-bootstrap-4/build/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet">
	<link rel="stylesheet" href="/components/Font-Awesome/css/all.css">
	


	<?php if($_GET['mod']!="detalle_solicitud"){ ?>
	<header class="bg-white">
		
			<?= $this->_data['header']; ?>
		
	</header>
	<?php }?>


	<?php if($this->_data['es_login']!=1){ ?>
		<div>
			<article id="contenido_panel" class="col-12">
				<section id="contenido_general">
					<?= $this->_content ?>
				</section>
			</article>
		</div>
	<?php }else{ ?>
		<?= $this->_content ?>
	<?php } ?>

	<?= $this->_data['botones']; ?>

	
	<footer class="footer <?php if($this->_data['es_login'] == 1){ ?> d-none <?php } ?>">
		<?= $this->_data['footer']; ?>
	</footer>




 	<link rel="stylesheet" href="/components/bootstrap-fileinput/css/fileinput.css">
	<script src="/components/bootstrap-fileinput/js/fileinput.min.js"></script>
    <script src="/components/bootstrap-fileinput/js/locales/es.js"></script>
	<div class="modal fade" id="modaleditor" tabindex="-1" role="dialog" aria-labelledby="modaleditorLabel" aria-hidden="true">
  		<div class="modal-dialog" role="document">
    		<div class="modal-content"></div>
		</div>
	</div>
	<script>
	$('.ls-modal').on('click', function(e){
		e.preventDefault();
		$('#modaleditor').modal('show').find('.modal-content').load($(this).attr('href'));
	});
</script>



</body>
</html>
