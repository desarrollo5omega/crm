<h1 class="titulo-principal"><i class="fas fa-cogs"></i> <?php echo $this->titlesection; ?></h1>
<div class="container-fluid">
	<form class="text-start" enctype="multipart/form-data" method="post" action="<?php echo $this->routeform;?>" data-bs-toggle="validator">
		<div class="content-dashboard">
			<input type="hidden" name="csrf" id="csrf" value="<?php echo $this->csrf ?>">
			<input type="hidden" name="csrf_section" id="csrf_section" value="<?php echo $this->csrf_section ?>">
			<?php if ($this->content->archivo_id) { ?>
				<input type="hidden" name="id" id="id" value="<?= $this->content->archivo_id; ?>" />
			<?php }?>
			<div class="row">
				<input type="hidden" name="archivo"  value="<?php echo $this->content->archivo ?>">
				<div class="col-12 form-group">
					<label for="archivo2" >archivo asociados</label>
					<div class="row">
						<div class="col-10">
							<input type="file" name="archivo_archivo" id="archivo_archivo" class="form-control  file-document" data-buttonName="btn-primary" onchange="validardocumento('archivo_archivo');" accept="application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" >
              <input type="hidden" name="archivo_fecha" value="<?php echo date('Y-m-d'); ?>">
              <input type="hidden" name="archivo_usuario" value="<?php echo Session::getInstance()->get('kt_login_id') ?>">
						</div>

						
						<div class="col-2">
							<a href="/files/asociadosregional.xlsx">XLSX Ejemplo</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="botones-acciones">
			<button class="btn btn-guardar" type="submit">Guardar</button>
			<a href="<?php echo $this->route; ?>" class="btn btn-cancelar">Cancelar</a>
		</div>
	</form>
</div>