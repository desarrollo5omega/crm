<h1 class="titulo-principal"><i class="fas fa-cogs"></i> <?php echo $this->titlesection; ?></h1>
<div class="container-fluid">
	<div class="row">
		<div class="col-12"><br></div>
		<div class="col-12">
			<?php if($_SESSION['kt_login_level']==1 or $_SESSION['kt_login_level']==4 or $_SESSION['kt_login_level']==3 or $_SESSION['kt_login_level']==7){ ?>
				<a href="/administracion/consultas/pagares/" class="btn btn-primary">Consultar pagares</a> &nbsp;
			<?php }?>
			<a href="/administracion/consultas/cupos/" class="btn btn-primary">Consultar cupos</a>  &nbsp;
			<a href="/administracion/consultas/solicitudes/" class="btn btn-primary">Consultar solicitudes</a>
			<a href="/administracion/consultas/informacion/" class="btn btn-primary">Consultar informaci&oacute;n</a>
		</div>
	</div>
</div>