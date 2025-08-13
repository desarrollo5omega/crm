<h1 class="titulo-principal"><i class="fas fa-cogs"></i> <?php echo $this->titlesection; ?></h1>
<div class="container-fluid">
	<form class="text-start" enctype="multipart/form-data" method="post" action="<?php echo $this->routeform;?>" data-bs-toggle="validator">
		<div class="content-dashboard">
			<input type="hidden" name="csrf" id="csrf" value="<?php echo $this->csrf ?>">
			<input type="hidden" name="csrf_section" id="csrf_section" value="<?php echo $this->csrf_section ?>">
			<?php if ($this->content->id) { ?>
				<input type="hidden" name="id" id="id" value="<?= $this->content->id; ?>" />
			<?php }?>
			<div class="row">
				<div class="col-12 form-group">
					<label for="asociado"  class="control-label">asociado</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-verde " ><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->asociado; ?>" name="asociado" id="asociado" class="form-control"   >
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 form-group">
					<label for="cedula" >cedula</label>
					<input type="file" name="cedula" id="cedula" class="form-control  file-document" data-buttonName="btn-primary" onchange="validardocumento('cedula');" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint, text/plain, application/pdf" >
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 form-group">
					<label for="certificado_ingresos" >certificado_ingresos</label>
					<input type="file" name="certificado_ingresos" id="certificado_ingresos" class="form-control  file-document" data-buttonName="btn-primary" onchange="validardocumento('certificado_ingresos');" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint, text/plain, application/pdf" >
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 form-group">
					<label for="declaracion_renta" >declaracion_renta</label>
					<input type="file" name="declaracion_renta" id="declaracion_renta" class="form-control  file-document" data-buttonName="btn-primary" onchange="validardocumento('declaracion_renta');" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint, text/plain, application/pdf" >
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 form-group">
					<label for="desprendible" >desprendible</label>
					<input type="file" name="desprendible" id="desprendible" class="form-control  file-document" data-buttonName="btn-primary" onchange="validardocumento('desprendible');" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint, text/plain, application/pdf" >
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 form-group">
					<label for="anio"  class="control-label">anio</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-rosado " ><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->anio; ?>" name="anio" id="anio" class="form-control"   >
					</label>
					<div class="help-block with-errors"></div>
				</div>
			</div>
		</div>
		<div class="botones-acciones">
			<button class="btn btn-guardar" type="submit">Guardar</button>
			<a href="<?php echo $this->route; ?>" class="btn btn-cancelar">Cancelar</a>
		</div>
	</form>
</div>