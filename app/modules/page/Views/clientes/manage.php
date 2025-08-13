<h1 class="titulo-principal ocultar_detalle"><i class="fas fa-users"></i> <?php echo $this->titlesection; ?></h1>
<div class="container-fluid">
	<form class="text-left" enctype="multipart/form-data" method="post" action="<?php echo $this->routeform;?>">
		<div class="content-dashboard">
			<input type="hidden" name="csrf" id="csrf" value="<?php echo $this->csrf ?>">
			<input type="hidden" name="csrf_section" id="csrf_section" value="<?php echo $this->csrf_section ?>">
			<?php if ($this->content->id) { ?>
				<input type="hidden" name="id" id="id" value="<?= $this->content->id; ?>" />
			<?php }?>
			<div class="row">

				<div class="col-lg-2 mb-3">
					<label for="nombre"  class="form-label">Nombre empresa</label>
					<div class="input-group">
						<span class="input-group-text input-icono  fondo-cafe " ><i class="fas fa-pencil-alt"></i></span>
						<input type="text" value="<?= $this->content->nombre; ?>" name="nombre" id="nombre" class="form-control" required minlength="3" pattern="[^\d]*" title="No se permiten numeros">
					</div>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-lg-2 mb-3">
					<label class="form-label">Tipo documento</label>
					<div class="input-group">
						<span class="input-group-text input-icono  fondo-azul " ><i class="far fa-list-alt"></i></span>
						<select class="form-control" name="tipo_documento">
							<option value="">Seleccione...</option>
							<?php foreach ($this->list_tipo_documento AS $key => $value ){?>
								<option <?php if($this->getObjectVariable($this->content,"tipo_documento") == $key ){ echo "selected"; }?> value="<?php echo $key; ?>" /> <?= $value; ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="help-block with-errors"></div>
				</div>				
				<div class="col-lg-2 mb-3">
					<label for="documento"  class="form-label">Número de documento</label>
					<div class="input-group">
						<span class="input-group-text input-icono  fondo-cafe " ><i class="fas fa-pencil-alt"></i></span>
						<input type="number" value="<?= $this->content->documento; ?>" name="documento" id="documento" class="form-control"   >
					</div>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-lg-2 mb-3">
					<label for="email"  class="form-label">Correo</label>
					<div class="input-group">
						<span class="input-group-text input-icono  fondo-verde-claro " ><i class="fas fa-pencil-alt"></i></span>
						<input type="email" value="<?= $this->content->email; ?>" name="email" id="email" class="form-control" required>
					</div>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-lg-2 mb-3">
					<label for="telefono"  class="form-label">Teléfono</label>
					<div class="input-group">
						<span class="input-group-text input-icono  fondo-cafe " ><i class="fas fa-pencil-alt"></i></span>
						<input type="number" value="<?= $this->content->telefono; ?>" name="telefono" id="telefono" class="form-control"   >
					</div>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-lg-2 mb-3">
					<label for="celular"  class="form-label">Celular</label>
					<div class="input-group">
						<span class="input-group-text input-icono  fondo-rojo-claro " ><i class="fas fa-pencil-alt"></i></span>
						<input type="tel" value="<?= $this->content->celular; ?>" name="celular" id="celular" class="form-control" minlength="10" maxlength="10" required>
					</div>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-lg-2 mb-3">
					<label for="contacto_principal"  class="form-label">Contacto principal</label>
					<div class="input-group">
						<span class="input-group-text input-icono  fondo-morado " ><i class="fas fa-pencil-alt"></i></span>
						<input type="text" value="<?= $this->content->contacto_principal; ?>" name="contacto_principal" id="contacto_principal" class="form-control" minlength="3" required>
					</div>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-lg-2 mb-3">
					<label for="direccion"  class="form-label">Dirección</label>
					<div class="input-group">
						<span class="input-group-text input-icono  fondo-cafe" ><i class="fas fa-pencil-alt"></i></span>
						<input type="text" value="<?= $this->content->direccion; ?>" name="direccion" id="direccion" class="form-control"   >
					</div>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-lg-2 mb-3">
					<label for="pagina_web"  class="form-label">Página web</label>
					<div class="input-group">
						<span class="input-group-text input-icono fondo-cafe" ><i class="fas fa-pencil-alt"></i></span>
						<input type="text" value="<?= $this->content->pagina_web; ?>" name="pagina_web" id="pagina_web" class="form-control"   >
					</div>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-lg-2 mb-3">
					<label class="form-label">Tipo</label>
					<div class="input-group">
						<span class="input-group-text input-icono  fondo-rojo-claro " ><i class="far fa-list-alt"></i></span>
						<select class="form-select" name="categoria" required>
							<option value="">Seleccione...</option>
							<?php foreach ($this->list_categoria AS $key => $value ){?>
								<option <?php if($this->getObjectVariable($this->content,"categoria") == $key ){ echo "selected"; }?> value="<?php echo $key; ?>" /> <?= $value; ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-lg-2 mb-3 d-none">
					<label class="form-label">Estado</label>
					<div class="input-group">
						<span class="input-group-text input-icono  fondo-verde-claro " ><i class="far fa-list-alt"></i></span>
						<select class="form-control" name="estado"   >
							<option value="">Seleccione...</option>
							<?php foreach ($this->list_estado AS $key => $value ){?>
								<option <?php if($this->getObjectVariable($this->content,"estado") == $key ){ echo "selected"; }?> value="<?php echo $key; ?>" /> <?= $value; ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-lg-2 mb-3 <?php if($_GET['id']==""){ echo 'd-none'; } ?>">
					<label class="form-label">Asignado</label>
					<div class="input-group">
						<span class="input-group-text input-icono  fondo-rosado " ><i class="far fa-list-alt"></i></span>
						<select class="form-control" name="asignado"   >
							<option value="">Seleccione...</option>
							<?php foreach ($this->list_asignado AS $key => $value ){?>
								<option <?php if($this->getObjectVariable($this->content,"asignado") == $key ){ echo "selected"; }?> value="<?php echo $key; ?>" /> <?= $value; ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-lg-2 mb-3">
					<label for="logo" class="form-label">Logo</label>
					<input type="file" name="logo" id="logo" class="form-control  file-document" data-buttonName="btn-primary" onchange="validardocumento('logo');" accept="image/*" >

					<?php if($this->content->logo!=""){ ?>
						<br><a href="/images/<?php echo $this->content->logo; ?>" target="_blank" class="btn btn-primary btn-sm"><i class="fas fa-file-download"></i></a>
					<?php } ?>

					<div class="help-block with-errors"></div>
				</div>
				<div class="col-lg-4 mb-3 d-none">
					<label class="form-label">Activo</label>
					<input type="checkbox" name="activo" value="1" class="form-control switch-form " <?php if ($this->getObjectVariable($this->content, 'activo') == 1) { echo "checked";} ?>   ></input>
					<div class="help-block with-errors"></div>
				</div>
				<input type="hidden" name="quien"  value="<?php echo $this->content->quien ?>">
				<input type="hidden" name="fecha_c"  value="<?php echo $this->content->fecha_c ?>">
				<input type="hidden" name="fecha_a"  value="<?php echo $this->content->fecha_a ?>">
			</div>
		</div>
		<div class="botones-acciones">
			<button class="btn btn-guardar" type="submit">Guardar</button>
			<a href="<?php echo $this->route; ?>" class="btn btn-cancelar">Cancelar</a>
		</div>
	</form>
</div>