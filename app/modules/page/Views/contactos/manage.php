<?php if($_GET['detalle']=="1"){ ?>
	<style>
	.ocultar_detalle{
		display:none;
	}
	.header-menu{
		display: none;
	}
	#div_menu,.div_menu2{
		display: none;
	}
	.div10{
		max-width: 100%;
		flex: 0 0 100%;
	}
	</style>

<?php }?>


<h1 class="titulo-principal ocultar_detalle"><i class="fas fa-cogs"></i> <?php echo $this->titlesection; ?></h1>
<div class="container-fluid">
	<form class="text-start" enctype="multipart/form-data" method="post" action="<?php echo $this->routeform;?>" data-bs-toggle="validator">
		<div class="content-dashboard">
			<input type="hidden" name="csrf" id="csrf" value="<?php echo $this->csrf ?>">
			<input type="hidden" name="csrf_section" id="csrf_section" value="<?php echo $this->csrf_section ?>">
			<?php if ($this->content->id) { ?>
				<input type="hidden" name="id" id="id" value="<?= $this->content->id; ?>" />
			<?php }?>
			<div class="row">
				<div class="col-lg-4 mb-3">
					<label for="nombres" class="form-label">Nombres</label>
					<label class="input-group">
						<span class="input-group-text input-icono" ><i class="fas fa-pencil-alt"></i></span>
						<input type="text" value="<?= $this->content->nombres; ?>" name="nombres" id="nombres" class="form-control">
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-lg-4 mb-3">
					<label for="apellido1" class="form-label">Primer Apellido</label>
					<label class="input-group">
						<span class="input-group-text input-icono" ><i class="fas fa-pencil-alt"></i></span>
						<input type="text" value="<?= $this->content->apellido1; ?>" name="apellido1" id="apellido1" class="form-control">
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-lg-4 mb-3">
					<label for="apellido2"  class="form-label">Segundo Apellido</label>
					<label class="input-group">
						<span class="input-group-text input-icono" ><i class="fas fa-pencil-alt"></i></span>
						<input type="text" value="<?= $this->content->apellido2; ?>" name="apellido2" id="apellido2" class="form-control">
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-lg-4 mb-3">
					<label for="categoria"  class="form-label">Categoria</label>
					<label class="input-group">
						<span class="input-group-text input-icono" ><i class="fas fa-pencil-alt"></i></span>
						<input type="text" value="<?= $this->content->categoria; ?>" name="categoria" id="categoria" class="form-control">
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-lg-4 mb-3">
					<label for="email"  class="form-label">Correo</label>
					<label class="input-group">
						<span class="input-group-text input-icono" ><i class="fas fa-pencil-alt"></i></span>
						<input type="text" value="<?= $this->content->email; ?>" name="email" id="email" class="form-control">
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-lg-4 mb-3">
					<label for="email2"  class="form-label">Correo alternativo</label>
					<label class="input-group">
						<span class="input-group-text input-icono" ><i class="fas fa-pencil-alt"></i></span>
						<input type="text" value="<?= $this->content->email2; ?>" name="email2" id="email2" class="form-control">
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-lg-4 mb-3">
					<label for="celular"  class="form-label">Teléfono</label>
					<label class="input-group">
						<span class="input-group-text input-icono  fondo-rojo-claro " ><i class="fas fa-pencil-alt"></i></span>
						<input type="text" value="<?= $this->content->celular; ?>" name="celular" id="celular" class="form-control">
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-lg-4 mb-3">
					<label for="celular2"  class="form-label">Celular</label>
					<label class="input-group">
						<span class="input-group-text input-icono  fondo-rosado " ><i class="fas fa-pencil-alt"></i></span>
						<input type="text" value="<?= $this->content->celular2; ?>" name="celular2" id="celular2" class="form-control"   >
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<input type="hidden" name="fecha_c"  value="<?php echo $this->content->fecha_c ?>">
				<input type="hidden" name="quien"  value="<?php echo $this->content->quien ?>">
				<input type="hidden" name="cliente_id"  value="<?php if($this->content->cliente_id){ echo $this->content->cliente_id; } else { echo $this->cliente; } ?>">
				<input type="hidden" name="detalle"  value="<?php echo $_GET['detalle'];?>">
				<div class="col-lg-12 mb-3">
					<label for="observacion" class="form-label" >Observación</label>
					<textarea name="observacion" id="observacion" class="form-control tinyeditor" rows="4"><?= $this->content->observacion; ?></textarea>
					<div class="help-block with-errors"></div>
				</div>
			</div>
		</div>
		<div class="botones-acciones">
			<button class="btn btn-guardar" type="submit">Guardar</button>
			<a href="<?php echo $this->route; ?>?cliente=<?php if($this->content->cliente_id){ echo $this->content->cliente_id; } else { echo $this->cliente; } ?>&detalle=<?php echo $_GET['detalle']; ?>" class="btn btn-cancelar">Cancelar</a>
		</div>
	</form>
</div>