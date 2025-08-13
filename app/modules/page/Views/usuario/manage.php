<h1 class="titulo-principal"><i class="fas fa-male"></i> <?php echo $this->titlesection; ?></h1>
<div class="container-fluid">
	<form class="text-start" enctype="multipart/form-data" method="post" action="<?php echo $this->routeform;?>" data-bs-toggle="validator">
		<div class="content-dashboard">
			<input type="hidden" name="csrf" id="csrf" value="<?php echo $this->csrf ?>">
			<input type="hidden" name="csrf_section" id="csrf_section" value="<?php echo $this->csrf_section ?>">
			<?php if ($this->content->user_id) { ?>
				<input type="hidden" name="id" id="id" value="<?= $this->content->user_id; ?>" />
			<?php }?>
			<div class="row">
				<input type="hidden" name="user_date"  value="<?php echo $this->content->user_date ?>">
				<div class="col-2 mb-3">
					<label for="user_names"  class="form-label">Nombres</label>
					<div class="input-group">
						<span class="input-group-text input-icono  fondo-morado " ><i class="fas fa-pencil-alt"></i></span>
						<input type="text" value="<?php if($this->Usuarioinfo[$this->content->user_user]["nombres"]){ echo $this->Usuarioinfo[$this->content->user_user]["nombres"];}else{ echo $this->content->user_names;}?>" name="user_names" id="user_names" class="form-control"  required minlength="3" pattern="[^\d]*" data-error="No se permiten números, y debe contener minimo 3 caracteres" >
					</div>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-2 mb-3">
					<label for="user_level" class="form-label">Tipo de usuario</label>
					<div class="input-group">
						<span class="input-group-text input-icono  fondo-rojo-claro " ><i class="far fa-list-alt"></i></span>
						<select class="form-select" name="user_level"  required>
							<option value="">Seleccione...</option>
							<?php foreach ($this->list_user_level AS $key => $value ){?>
								<option <?php if($this->getObjectVariable($this->content,"user_level") == $key ){ echo "selected"; }?> value="<?php echo $key; ?>" /> <?= $value; ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-2 mb-3">
					<label for="user_email"  class="form-label">Correo</label>
					<div class="input-group">
						<span class="input-group-text input-icono" ><i class="fas fa-user-tie"></i></span>
						<input type="email" value="<?= $this->content->user_email; ?>" name="user_email" id="user_email" class="form-control"  required>
					</div>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-2 mb-3">
					<label for="user_user"  class="form-label">Usuario</label>
					<div class="input-group">
						<span class="input-group-text input-icono" ><i class="fas fa-user-tie"></i></span>
						<input type="text" value="<?= $this->content->user_user; ?>" name="user_user" id="user_user" class="form-control"  required>
					</div>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-2 mb-3">
					<label for="user_password"  class="form-label">Contrase&ntilde;a</label>
					<div class="input-group">
						<span class="input-group-text input-icono  fondo-cafe " ><i class="fas fa-key"></i></span>
						<input type="password" value="" name="user_password" id="user_password" class="form-control" <?php if (!$this->content->user_id) { ?>required <?php } ?> pattern="(?=.*\d)(?=.*[A-Z]).{8,}" data-error="La contraseña debe tener al menos 8 caracteres, una mayuscula y un numero">
					</div>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-2 mb-3">
					<label for="user_password"  class="form-label">Repita Contrase&ntilde;a</label>
					<div class="input-group">
						<span class="input-group-text input-icono  fondo-cafe " ><i class="fas fa-key"></i></span>
						<input type="password" value="" name="user_passwordr" id="user_passwordr" data-match="#user_password" data-match-error="Las dos contraseñas no son iguales" class="form-control" <?php if (!$this->content->user_id) { ?>required <?php } ?>   >
					</div>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-2 mb-3">
					<label class="form-label">Estado</label>
					<div class="input-group">
						<span class="input-group-text input-icono  fondo-cafe" ><i class="fas fa-clipboard-check"></i></span>
						<select class="form-select" name="user_state" required  >
							<option value="">Seleccione...</option>
							<?php foreach ($this->list_user_state AS $key => $value ){?>
								<option <?php if($this->getObjectVariable($this->content,"user_state") == $key or ($_GET['id']=="" and $key==1) ){ echo "selected"; }?> value="<?php echo $key; ?>" /> <?= $value; ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="help-block with-errors"></div>
				</div>
				<input type="hidden" name="user_delete"  value="<?php echo $this->content->user_delete ?>">
				<input type="hidden" name="user_current_user"  value="<?php echo $this->content->user_current_user ?>">
				<input type="hidden" name="user_code"  value="<?php echo $this->content->user_code ?>">
			</div>
		</div>
		<div class="botones-acciones">
			<button class="btn btn-guardar" type="submit">Guardar</button>
			<a href="<?php echo $this->route; ?>" class="btn btn-cancelar">Cancelar</a>
		</div>
	</form>
</div>