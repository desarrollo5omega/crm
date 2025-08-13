<h1 class="titulo-principal"><i class="fas fa-cogs"></i> <?php echo $this->titlesection; ?></h1>
<div class="container-fluid">
	<div class="row">
		<div class="col-12"><br></div>
		<div class="col-12 botones-reportes">


			<?php if($_SESSION['kt_login_level']==1 or $_SESSION['kt_login_level']==4 or $_SESSION['kt_login_level']==3){?>
			    <a href="/administracion/reportes/solicitudes_estado/" class="btn btn-primary">Solicitudes por estado</a>
			    <a href="/administracion/reportes/solicitudes_linea/"  class="btn btn-primary">Solicitudes por línea</a>
			    <a href="/administracion/reportes/solicitudes_paso/"  class="btn btn-primary">Solicitudes no finalizadas</a>
			    <a href="/administracion/reportes/solicitudes_gestion/"  class="btn btn-primary">Gestión solicitudes</a>
			    <a href="/administracion/reportes/solicitudes_gestion2/"  class="btn btn-primary">Gestión analistas</a>
			    <a href="/administracion/reportes/solicitudes/"  class="btn btn-primary">Visualizar solicitudes</a>
			<?php }?>
			<?php if(1==0){ ?>
				    <a href="../pp.php?mod=reporte_solicitudes"  class="btn btn-primary">Exportar solicitudes</a>
				    <a href="../pp.php?mod=reporte_solicitudes_no_finalizadas"  class="btn btn-primary">Exportar solicitudes no finalizadas</a>
				    <a href="../pp.php?mod=reporte_solicitudes_seguro"  class="btn btn-primary">Exportar solicitudes seguro</a>
				    <a href="../pp.php?mod=reporte_solicitudes_seguro2"  class="btn btn-primary">Exportar solicitudes seguro2</a>
				<?php if($_SESSION['kt_login_level']==1 or $_SESSION['kt_login_level']==4){?>
				    <a href="../pp.php?mod=reporte_autorizaciones"  class="btn btn-primary">Exportar autorizaciones</a>
				    <a href="exportar.php?excel=1" class="btn btn-primary">Exportar LINIX</a>
				    <a href="exportar_info.php?excel=1" class="btn btn-primary">Exportar Info Usuarios</a>
				    <a href="../pp.php?mod=exportar_encuestas" class="btn btn-primary">Exportar encuestas</a>
				<?php }?>
			<?php }?>

		</div>
	</div>
</div>