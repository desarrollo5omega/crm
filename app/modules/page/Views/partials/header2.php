<div class="header-redes">
	<div class="container">
		<?php if($this->infopage->info_pagina_telefono) {?>
			<?php $telefono = intval(preg_replace('/[^0-9]+/', '', $this->infopage->info_pagina_telefono), 10);  ?>
			<a href="tel:<?php echo $telefono; ?>" target="_blank" class="red">
				<i class="fas fa-phone"></i>
				<span><?php echo $this->infopage->info_pagina_telefono ?></span>
			</a>
		<?php } ?>
		<?php if($this->infopage->info_pagina_whatsapp) {?>
			<?php $whatsapp = intval(preg_replace('/[^0-9]+/', '', $this->infopage->info_pagina_whatsapp), 10);  ?>
			<a href="https://api.whatsapp.com/send?phone=<?php echo $whatsapp; ?>" target="_blank" class="red" >
				<i class="fab fa-whatsapp"></i>
				<span><?php echo $this->infopage->info_pagina_whatsapp ?></span>
			</a>
		<?php } ?>
		<?php if($this->infopage->info_pagina_facebook) {?>
			<a href="<?php echo $this->infopage->info_pagina_facebook ?>" target="_blank" class="red">
				<i class="fab fa-facebook-f"></i>
			</a>
		<?php } ?>
		<?php if($this->infopage->info_pagina_twitter) {?>
			<a href="<?php echo $this->infopage->info_pagina_twitter ?>" target="_blank" class="red">
				<i class="fab fa-twitter"></i>
			</a>
		<?php } ?>
		<?php if($this->infopage->info_pagina_instagram) {?>
			<a href="<?php echo $this->infopage->info_pagina_instagram ?>" target="_blank" class="red">
				<i class="fab fa-instagram"></i>
			</a>
		<?php } ?>
		<?php if($this->infopage->info_pagina_pinterest) {?>
			<a href="<?php echo $this->infopage->info_pagina_pinterest ?>" target="_blank" class="red">
				<i class="fab fa-pinterest-p"></i>
			</a>
		<?php } ?>
		<?php if($this->infopage->info_pagina_youtube) {?>
			<a href="<?php echo $this->infopage->info_pagina_youtube ?>" target="_blank" class="red">
				<i class="fab fa-youtube"></i>
			</a>
		<?php } ?>
		<?php if($this->infopage->info_pagina_linkdn) {?>
			<a href="<?php echo $this->infopage->info_pagina_linkdn ?>" target="_blank" class="red">
				<i class="fab fa-linkedin-in"></i>
			</a>
		<?php } ?>
		<?php if($this->infopage->info_pagina_google) {?>
			<a href="<?php echo $this->infopage->info_pagina_google ?>" target="_blank" class="red">
				<i class="fab fa-google-plus-g"></i>
			</a>
		<?php } ?>
		<?php if($this->infopage->info_pagina_flickr) {?>
			<a href="<?php echo $this->infopage->info_pagina_flickr ?>" target="_blank" class="red">
				<i class="fab fa-flickr"></i>
			</a>
		<?php } ?>

	</div>
</div>
<div class="header-content">
	<div class="container">
		<div class="row">
			<div class="col-sm-3">
				<img src="/skins/page/images/logo.png" class="logo2">
			</div>
			<div class="col-sm-9">
				<nav>
					<ul>
						<li><a href="#"><span>Inicio</span></a></li>
						<li><a href="#"><span>Boton 1</span></a></li>
						<li><a href="#"><span>Boton 2</span></a></li>
						<li><a href="#"><span>Boton 3</span></a></li>
						<li><a href="#"><span>Contactenos</span></a></li>
					</ul>
				</nav>
			</div>
		</div>
	</div>
</div>
