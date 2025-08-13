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
				<input type="hidden" name="archivo"  value="<?php echo $this->content->archivo ?>">
				<input type="hidden" name="archivo2"  value="<?php echo $this->content->archivo2 ?>">
				<input type="hidden" name="archivo3"  value="<?php echo $this->content->archivo3 ?>">
				<div class="col-12 form-group">
					<label for="archivo4" >archivo4</label>
					<input type="file" name="archivo4" id="archivo4" class="form-control  file-document" data-buttonName="btn-primary" onchange="validardocumento('archivo4');" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint, text/plain, application/pdf" if(!$this->content->id){ echo 'required'; }>
					<div class="help-block with-errors"></div>
				</div>
				<input type="hidden" name="archivo_inactivos"  value="<?php echo $this->content->archivo_inactivos ?>">
			</div>
		</div>
		<div class="botones-acciones">
			<button class="btn btn-guardar" type="submit">Guardar</button>
			<a href="<?php echo $this->route; ?>" class="btn btn-cancelar">Cancelar</a>
		</div>
	</form>
</div>