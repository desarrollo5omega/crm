<h1 class="titulo-principal"><i class="fas fa-cogs"></i> <?php echo $this->titlesection; ?></h1>
<div class="container-fluid">
	<form class="text-start" enctype="multipart/form-data" method="post" action="<?php echo $this->routeform;?>" data-bs-toggle="validator">
		<div class="content-dashboard">
			<input type="hidden" name="csrf" id="csrf" value="<?php echo $this->csrf ?>">
			<input type="hidden" name="csrf_section" id="csrf_section" value="<?php echo $this->csrf_section ?>">
			<?php if ($this->content->rango_id) { ?>
				<input type="hidden" name="id" id="id" value="<?= $this->content->rango_id; ?>" />
			<?php }?>
			<div class="row">
				<input type="hidden" name="rango_codigo"  value="<?php if($this->content->rango_codigo){ echo $this->content->rango_codigo; } else { echo $this->linea; } ?>">
				<div class="col-3 form-group">
					<label for="rango_min"  class="control-label">min meses</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-azul " ><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->rango_min; ?>" name="rango_min" id="rango_min" class="form-control"  required >
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-3 form-group">
					<label for="rango_max"  class="control-label">max meses</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-verde " ><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->rango_max; ?>" name="rango_max" id="rango_max" class="form-control"  required >
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-3 form-group">
					<label for="rango_tasa_mensual"  class="control-label">tasa mes vencido</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-morado " ><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->rango_tasa_mensual; ?>" name="rango_tasa_mensual" id="rango_tasa_mensual" class="form-control"  required >
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-3 form-group">
					<label for="rango_tasa_anual"  class="control-label">tasa efectivo anual</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-azul-claro " ><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->rango_tasa_anual; ?>" name="rango_tasa_anual" id="rango_tasa_anual" class="form-control"  required >
					</label>
					<div class="help-block with-errors"></div>
				</div>
			</div>
		</div>
		<div class="botones-acciones">
			<button class="btn btn-guardar" type="submit">Guardar</button>
			<a href="<?php echo $this->route; ?>?linea=<?php if($this->content->rango_codigo){ echo $this->content->rango_codigo; } else { echo $this->linea; } ?>" class="btn btn-cancelar">Cancelar</a>
		</div>
	</form>
</div>