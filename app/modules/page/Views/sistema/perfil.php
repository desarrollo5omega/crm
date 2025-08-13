<?php //print_r($_SESSION); ?>
<div class="container">
	<div class="row">
		<div class="col-12 text-start"><h3 class="titulo">Mi perfil</h3></div>
		<div align="left" class="col-12">
			<div class="separador_login2"></div>
		</div>
		<div class="col-12">
			<br>
			<form class="text-start" enctype="multipart/form-data" method="post" action="/page/sistema/guardarperfil/" data-bs-toggle="validator">
				<div class="content-dashboard">
					<input type="hidden" name="csrf" id="csrf" value="<?php echo $this->csrf ?>">
					<input type="hidden" name="csrf_section" id="csrf_section" value="<?php echo $this->csrf_section ?>">
					<?php if ($this->content->user_id) { ?>
						<input type="hidden" name="id" id="id" value="<?= $this->content->user_id; ?>" />
					<?php }?>
					<div class="row">

						<input type="hidden" name="user_date"  value="<?php echo $this->content->user_date ?>">
						<div class="col-4 form-group">
							<label for="user_names"  class="control-label">Nombres</label>
							<label class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text input-icono  fondo-morado " ><i class="fas fa-pencil-alt"></i></span>
								</div>
								<input type="text" value="<?= $this->content->user_names; ?>" name="user_names" id="user_names" class="form-control"  readonly >
							</label>
							<div class="help-block with-errors"></div>
						</div>
						<div class="col-4 form-group">
							<label for="user_email"  class="control-label">correo</label>
							<label class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text input-icono  fondo-verde-claro " ><i class="fas fa-envelope"></i></span>
								</div>
								<input type="email" value="<?= $this->content->user_email; ?>" name="user_email" id="user_email" class="form-control"  required data-remote="/core/user/validationemail?csrf=1&email=<?= $this->content->user_email; ?>" >
							</label>
							<div class="help-block with-errors"></div>
						</div>

						<div class="col-4 form-group">
							<label for="user_user"  class="control-label">Usuario</label>
							<label class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text input-icono  fondo-rosado " ><i class="fas fa-user-tie"></i></span>
								</div>
								<input type="text" value="<?= $this->content->user_user; ?>" name="user_user" id="user_user" class="form-control"  required data-remote="/core/user/validation?csrf=1&user=<?= $this->content->user_user; ?>" readonly >
							</label>
							<div class="help-block with-errors"></div>
						</div>
						<div class="col-4 form-group">
							<label for="user_password"  class="control-label">Contrase&ntilde;a</label>
							<label class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text input-icono  fondo-cafe " ><i class="fas fa-key"></i></span>
								</div>
								<input type="password" value="" name="user_password" id="user_password" class="form-control" <?php if (!$this->content->user_id or $_GET['actualizar']=="1") { ?> required <?php } ?> data-remote="/core/user/validarclave"  >
							</label>
							<div class="help-block with-errors"></div>
						</div>
						<div class="col-4 form-group">
							<label for="user_password"  class="control-label">Repita Contrase&ntilde;a</label>
							<label class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text input-icono  fondo-cafe " ><i class="fas fa-key"></i></span>
								</div>
								<input type="password" value="" name="user_passwordr" id="user_passwordr" data-match="#user_password" min="8" data-match-error="Las dos contraseñas no son iguales" class="form-control" >
							</label>
							<div class="help-block with-errors"></div>
						</div>
						<input type="hidden" name="user_delete"  value="<?php echo $this->content->user_delete ?>">
						<input type="hidden" name="user_current_user"  value="<?php echo $this->content->user_current_user ?>">
						<input type="hidden" name="user_code"  value="<?php echo $this->content->user_code ?>">
					</div>
				</div>
				<div class="botones-acciones text-center">
					<button class="btn btn-azul" type="submit">Guardar</button>
				</div>
			</form>


				<br><br>
				<?php if($_GET['a']=="1"){ ?>
					<div class="div_rojo col-4 offset-4 text-center">Guardado</div>
				<?php } ?>
				<?php if($_GET['actualizar']=="1"){ ?>
					<div class="div_rojo col-4 offset-4 text-center"><i class="fas fa-key"></i> &nbsp; Por favor actualice su contraseña</div>
				<?php } ?>
		</div>
	</div>
</div>

