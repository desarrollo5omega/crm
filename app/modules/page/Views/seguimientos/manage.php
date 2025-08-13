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
					<label for="seguimiento" class="form-label" >seguimiento</label>
					<textarea name="seguimiento" id="seguimiento"   class="form-control tinyeditor" rows="10"   ><?= $this->content->seguimiento; ?></textarea>
					<div class="help-block with-errors"></div>
				</div>
				<input type="hidden" name="fecha"  value="<?php echo $this->content->fecha ?>">
				<input type="hidden" name="quien"  value="<?php echo $this->content->quien ?>">
				<input type="hidden" name="cliente_id"  value="<?php if($this->content->cliente_id){ echo $this->content->cliente_id; } else { echo $this->cliente; } ?>">
			</div>
		</div>
		<div class="botones-acciones">
			<button class="btn btn-guardar" type="submit">Guardar</button>
			<a href="<?php echo $this->route; ?>?cliente=<?php if($this->content->cliente_id){ echo $this->content->cliente_id; } else { echo $this->cliente; } ?>" class="btn btn-cancelar">Cancelar</a>
		</div>
	</form>
</div>