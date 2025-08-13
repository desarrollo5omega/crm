<h1 class="titulo-principal ocultar_detalle"><i class="fas fa-list-alt"></i> <?php echo $this->titlesection; ?></h1>
<div class="container-fluid">
	<form class="text-start" enctype="multipart/form-data" method="post" action="<?= $this->routeform ?>">
		<div class="content-dashboard">
			<input type="hidden" name="detalle" id="detalle" value="<?php echo $_GET['detalle']; ?>">
			<input type="hidden" name="csrf" id="csrf" value="<?php echo $this->csrf ?>">
			<input type="hidden" name="csrf_section" id="csrf_section" value="<?php echo $this->csrf_section ?>">
			<?php if ($this->content->id) { ?>
				<input type="hidden" name="id" id="id" value="<?= $this->content->id; ?>" />
			<?php }?>
			<div class="row">
				<input type="hidden" name="fecha_c"  value="<?php echo $this->content->fecha_c ?>">

				<div class="col-3 mb-3">
					<label class="form-label">Cliente</label>
					<div class="input-group">
						<span class="input-group-text input-icono  fondo-verde-claro " ><i class="far fa-list-alt"></i></span>
						<select class="form-select" name="cliente_id" required <?php if($_GET['detalle'] == "1" && $_GET['hash'] == "") { echo "disabled"; } ?>>
							<option value="">Seleccione...</option>
							<?php foreach ($this->list_cliente_id AS $key => $value ){?>
								<option <?php if($this->getObjectVariable($this->content,"cliente_id") == $key or $_GET['cliente'] == $key){ echo "selected"; $valor_cliente = $key; }?> value="<?php echo $key; ?>"> <?= $value; ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="help-block with-errors"></div>
				</div>

				<div class="col-3 mb-3">
					<label for="nombre"  class="form-label">Nombre del Proyecto</label>
					<div class="input-group">
						<span class="input-group-text input-icono  fondo-rojo-claro " ><i class="fas fa-pencil-alt"></i></span>
						<input type="text" value="<?= $this->content->nombre; ?>" name="nombre" id="nombre" class="form-control" required minlength="3" pattern="[^\d]*" title="No se permiten numeros">
					</div>
					<div class="help-block with-errors"></div>
				</div>				
				<div class="col-3 mb-3">
					<label for="valor"  class="form-label">Valor del Proyecto</label>
					<div class="input-group">
						<span class="input-group-text input-icono  fondo-morado " ><i class="fas fa-pencil-alt"></i></span>
						<input type="text" value="<?php if($this->content->valor!=""){ echo formato_pesos($this->content->valor); } ?>" name="valor" id="valor" class="form-control" onchange="puntitos(this)" onkeyup="puntitos(this)" required minlength="3">
					</div>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-3 mb-3">
					<label class="form-label">Tipo de Proyecto</label>
					<div class="input-group">
						<span class="input-group-text input-icono  fondo-cafe " ><i class="far fa-list-alt"></i></span>
						<select class="form-select" name="tipo" required>
							<option value="">Seleccione...</option>
							<?php foreach ($this->list_tipo AS $key => $value ){?>
								<option <?php if($this->getObjectVariable($this->content,"tipo") == $key ){ echo "selected"; }?> value="<?php echo $key; ?>" /> <?= $value; ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-3 mb-3">
					<label class="form-label">Estado del Proyecto</label>
					<div class="input-group">
						<span class="input-group-text input-icono  fondo-cafe" ><i class="far fa-list-alt"></i></span>
						<select class="form-select" name="estado" required>
							<option value="">Seleccione...</option>
							<?php foreach ($this->list_estado AS $key => $value ){?>
								<option <?php if($this->getObjectVariable($this->content,"estado") == $key ){ echo "selected"; }?> value="<?php echo $key; ?>" /> <?= $value; ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-3 mb-3">
					<label for="documento1" class="form-label" >Cotización o documento</label>
					<input type="file" name="documento1" id="documento1" class="form-control  file-document" data-buttonName="btn-primary" onchange="validardocumento('documento1');" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint, text/plain, application/pdf,image/*" >

					<?php if($this->content->documento1!=""){ ?>
						<br><a href="/images/<?php echo $this->content->documento1; ?>" target="_blank" class="btn btn-primary btn-sm"><i class="fas fa-file-download"></i></a>
					<?php } ?>

					<div class="help-block with-errors"></div>
				</div>
				<div class="col-3 mb-3">
					<label for="documento2" class="form-label" >Cotización o documento</label>
					<input type="file" name="documento2" id="documento2" class="form-control  file-document" data-buttonName="btn-primary" onchange="validardocumento('documento2');" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint, text/plain, application/pdf,image/*" >

					<?php if($this->content->documento2!=""){ ?>
						<br><a href="/images/<?php echo $this->content->documento2; ?>" target="_blank" class="btn btn-primary btn-sm"><i class="fas fa-file-download"></i></a>
					<?php } ?>

					<div class="help-block with-errors"></div>
				</div>
				<div class="col-3 mb-3">
					<label for="documento3" class="form-label" >Cotización o documento</label>
					<input type="file" name="documento3" id="documento3" class="form-control  file-document" data-buttonName="btn-primary" onchange="validardocumento('documento3');" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint, text/plain, application/pdf,image/*" >

					<?php if($this->content->documento3!=""){ ?>
						<br><a href="/images/<?php echo $this->content->documento3; ?>" target="_blank" class="btn btn-primary btn-sm"><i class="fas fa-file-download"></i></a>
					<?php } ?>

					<div class="help-block with-errors"></div>
				</div>

				<div class="col-6 mb-3">
					<label for="proyectos_cadmin" class="form-label">Comentarios para Administración</label>
					<div class="input-group">
						<textarea rows="3" name="proyectos_cadmin" id="proyectos_cadmin" class="form-control" minlength="3"><?= $this->content->proyectos_cadmin; ?></textarea>
					</div>
					<div class="help-block with-errors"></div>
				</div>

				<div class="col-6 mb-3">
					<label for="proyectos_caprueba" class="form-label">Comentarios para Proyectos</label>
					<div class="input-group">
						<textarea rows="3" name="proyectos_caprueba" id="proyectos_caprueba" class="form-control" minlength="3"><?= $this->content->proyectos_caprueba; ?></textarea>
					</div>
					<div class="help-block with-errors"></div>
				</div>


				<?php if($_GET['detalle'] == "1") { ?>
					<input type="hidden" name="cliente_id" value="<?= $valor_cliente; ?>">
					<input type="hidden" name="detalle" value="1">
				<?php } ?>
				
			</div>
		</div>
		<div class="botones-acciones">
			<button class="btn btn-guardar" type="submit">Guardar</button>
			<?php if($_GET['detalle'] == "1") { ?>
				<a href="<?php echo $this->route.'?detalle=1&cliente='.$_GET['cliente']; ?>" class="btn btn-cancelar">Cancelar</a>
			<?php } else { ?>
				<a href="<?php echo $this->route; ?>" class="btn btn-cancelar">Cancelar</a>
			<?php } ?>
		</div>
	</form>
</div>