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
				<div class="col-12 form-group">
					<label for="archivo_fecha"  class="control-label">Fecha</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-verde-claro " ><i class="fas fa-calendar-alt"></i></span>
						</div>
					<input type="text" value="<?php if($this->content->archivo_fecha){ echo $this->content->archivo_fecha; } else { echo date('Y-m-d'); } ?>" name="archivo_fecha" id="archivo_fecha" class="form-control"  required data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-language="es"  >
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 form-group">
					<label for="archivo_archivo" >Archivo</label>
					<input type="file" name="archivo_archivo" id="archivo_archivo" class="form-control  file-document" data-buttonName="btn-primary" onchange="validardocumento('archivo_archivo');" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint, text/plain, application/pdf" if(!$this->content->archivo_id){ echo 'required'; }>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 form-group">
					<label class="control-label">Usuario</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-azul " ><i class="far fa-list-alt"></i></span>
						</div>
						<select class="form-select" name="archivo_usuario"  required >
							<option value="">Seleccione...</option>
							<?php foreach ($this->list_archivo_usuario AS $key => $value ){?>
								<option <?php if($this->getObjectVariable($this->content,"archivo_usuario") == $key ){ echo "selected"; }?> value="<?php echo $key; ?>" /> <?= $value; ?></option>
							<?php } ?>
						</select>
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