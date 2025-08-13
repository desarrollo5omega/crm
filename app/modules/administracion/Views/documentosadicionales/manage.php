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
					<label for="titulo"  class="control-label">titulo</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-verde-claro " ><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->titulo; ?>" name="titulo" id="titulo" class="form-control"  required >
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 form-group">
					<label for="archivo" >archivo</label>
					<input type="file" name="archivo" id="archivo" class="form-control  file-document" data-buttonName="btn-primary" onchange="validardocumento('archivo');" accept=" image/*, application/pdf" >
					<div class="help-block with-errors"></div>
				</div>
				<input type="hidden" name="fecha"  value="<?php if($this->content->fecha){ echo $this->content->fecha; } else { echo date("Y-m-d H:i:s"); } ?>">
				<input type="hidden" name="quien"  value="<?php if($this->content->quien){ echo $this->content->quien; } else { echo $_SESSION['kt_login_id']; } ?>">
				<input type="hidden" name="solicitud"  value="<?php if($this->content->solicitud){ echo $this->content->solicitud; } else { echo $this->solicitud; } ?>">
			</div>
		</div>
		<div class="botones-acciones">
			<button class="btn btn-guardar" type="submit">Guardar</button>
			<a href="<?php echo $this->route; ?>?solicitud=<?php if($this->content->solicitud){ echo $this->content->solicitud; } else { echo $this->solicitud; } ?>" class="btn btn-cancelar">Cancelar</a>
		</div>
	</form>
</div>