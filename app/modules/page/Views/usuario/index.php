<h1 class="titulo-principal"><i class="fas fa-male"></i> <?php echo $this->titlesection; ?></h1>
<div class="container-fluid">
	<form action="<?php echo $this->route; ?>" method="post">
		<div class="row collapse-filters">
			<div class="col-lg-12 mb-2">
				<div class="d-flex justify-content-end">
					<div class="gris_claro me-2">
						<div class="mt-1">
							<a data-bs-toggle="modal" data-bs-target="#modal_crear_seg" class="custom-btn-home" onclick="$('#div_filtros').fadeToggle(300);">
								<span class="add-button-home lf-part">Filtros</span>
								<span class="rg-part"><i class="fa-solid fa-filter"></i></span>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="card" id="div_filtros">
			<div class="card-body">
				<div class="content-dashboard">
					<div class="row">
						<div class="col-lg-2 col-12 mb-3">
							<label class="form-label">Estado</label>
							<div class="input-group">
								<span class="input-group-text input-icono fondo-verde-claro " ><i class="far fa-list-alt"></i></span>
								<select class="form-select" name="user_state">
									<option value="">Todas</option>
									<?php foreach ($this->list_user_state as $key => $value) : ?>
										<option value="<?= $key; ?>" <?php if ($this->getObjectVariable($this->filters, 'user_state') ==  $key) { echo "selected";} ?>><?= $value; ?></option>
									<?php endforeach ?>
								</select>
							</div>
						</div>
						<div class="col-lg-2 col-12 mb-3">
							<label class="form-label">Nombres</label>
							<div class="input-group">
								<span class="input-group-text input-icono fondo-rosado " ><i class="fas fa-pencil-alt"></i></span>
								<input type="text" class="form-control" name="user_names" value="<?php echo $this->getObjectVariable($this->filters, 'user_names') ?>"></input>
							</div>
						</div>
						<div class="col-lg-2 col-12 mb-3">
							<label class="form-label">Tipo de usuario</label>
							<div class="input-group">
								<span class="input-group-text input-icono fondo-cafe " ><i class="far fa-list-alt"></i></span>
								<select class="form-select" name="user_level">
									<option value="">Todas</option>
									<?php foreach ($this->list_user_level as $key => $value) : ?>
										<option value="<?= $key; ?>" <?php if ($this->getObjectVariable($this->filters, 'user_level') ==  $key) { echo "selected";} ?>><?= $value; ?></option>
									<?php endforeach ?>
								</select>
							</div>
						</div>
						<div class="col-lg-2 col-12 mb-3">
							<label class="form-label">Usuario</label>
							<div class="input-group">
								<span class="input-group-text input-icono fondo-cafe " ><i class="fas fa-pencil-alt"></i></span>
								<input type="text" class="form-control" name="user_user" value="<?php echo $this->getObjectVariable($this->filters, 'user_user') ?>"></input>
							</div>
						</div>
						<div class="col mb-3">
							<label class="form-label">&nbsp;</label>
							<button type="submit" class="btn w-100 btn-azul"> <i class="fas fa-filter"></i> Filtrar</button>
						</div>
						<div class="col mb-3">
							<label class="form-label">&nbsp;</label>
							<a class="btn w-100 btn-azul-claro " href="<?php echo $this->route; ?>?cleanfilter=1" > <i class="fas fa-eraser"></i> Limpiar Filtro</a>
						</div>
					</div>
				</div>
			</div>
		</div>
    </form>
    <div align="center">
		<ul class="pagination justify-content-center mt-3">
	    <?php
	    	$url = $this->route;
	        if ($this->totalpages > 1) {
	            if ($this->page != 1)
	                echo '<li class="page-item" ><a class="page-link"  href="'.$url.'?page='.($this->page-1).'"> &laquo; Anterior </a></li>';
	            for ($i=1;$i<=$this->totalpages;$i++) {
	                if ($this->page == $i)
	                    echo '<li class="active page-item"><a class="page-link">'.$this->page.'</a></li>';
	                else
	                    echo '<li class="page-item"><a class="page-link" href="'.$url.'?page='.$i.'">'.$i.'</a></li>  ';
	            }
	            if ($this->page != $this->totalpages)
	                echo '<li class="page-item"><a class="page-link" href="'.$url.'?page='.($this->page+1).'">Siguiente &raquo;</a></li>';
	        }
	  	?>
	  	</ul>
	</div>
	<div class="card">
		<div class="card-body">
			<div class="content-dashboard">
				<div class="franja-paginas">
					<div class="row">
						<div class="col-lg-5 col-md-5 col-sm-5 col-12 <?php if($_GET['detalle']=="1"){ echo 'col-lg-9'; } ?>">
							<div class="titulo-registro">Se encontraron <?php echo $this->register_number; ?> Registros</div>
						</div>

						<div class="col-lg-5 col-md-5 col-sm-5 col-12 text-md-center">
							<div class="d-flex justify-content-md-center align-items-center">
								<span class="texto-paginas me-2">Registros por página:</span>
								<select class="form-control form-control-sm selectpagination w-auto">
									<option value="20" <?php if($this->pages == 20){ echo 'selected'; } ?>>20</option>
									<option value="30" <?php if($this->pages == 30){ echo 'selected'; } ?>>30</option>
									<option value="50" <?php if($this->pages == 50){ echo 'selected'; } ?>>50</option>
									<option value="100" <?php if($this->pages == 100){ echo 'selected'; } ?>>100</option>
								</select>
							</div>
						</div>

						<div class="col-lg-2 col-md-2 col-sm-12 col-12 mb-2">
							<div class="text-end">
								<a class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modal_crear_user">
									<i class="fas fa-plus-square" data-bs-toggle="tooltip" data-placement="top" title="Crear nuevo"></i> Crear Nuevo
								</a>
							</div>

							<div class="modal fade text-start" id="modal_crear_user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
								<div class="modal-dialog modal-md" role="document">
									<div class="modal-content">
										<form class="text-start" enctype="multipart/form-data" method="post" action="/page/usuario/insert">
											<div class="modal-body">
												<div class="row">
													<div class="col-lg-12">
														<div class="caja_azul">
															<div class="d-flex justify-content-between align-items-center h-100">
																<b class="titulo_dashboard"><i class="fa-solid fa-user"></i> Crear nuevo usuario</b>
																<div class="me-2">
																	<button type="button" class="close btn-cerrar-modal" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="row px-3">
													<div class="col-lg-12 mt-3 mb-3">
														<span class="detail-modal">Por favor ingrese los datos del usuario.</span><br>
													</div>
													<div class="col-lg-12 mb-3">
														<div class="input-group">
															<input type="text" name="user_names" id="user_names" class="form-control"  required minlength="3" pattern="[^\d]*" data-error="No se permiten números, y debe contener minimo 3 caracteres" placeholder="Nombre usuario">
														</div>
														<div class="help-block with-errors"></div>
													</div>
													<div class="col-lg-12 mb-3">
														<div class="input-group">
															<select class="form-select" name="user_level"  required>
																<option value="">Tipo</option>
																<?php foreach ($this->list_user_level AS $key => $value ){?>
																	<option value="<?php echo $key; ?>"> <?= $value; ?></option>
																<?php } ?>
															</select>
														</div>
														<div class="help-block with-errors"></div>
													</div>
													<div class="col-lg-12 mb-3">
														<div class="input-group">
															<input type="email" name="user_email" id="user_email" class="form-control" required placeholder="Correo">
														</div>
														<div class="help-block with-errors"></div>
													</div>
													<div class="col-lg-12 mb-3">
														<div class="input-group">
															<input type="text" name="user_user" id="user_user" class="form-control"  required placeholder="Usuario">
														</div>
														<div class="help-block with-errors"></div>
													</div>
													<div class="col-lg-6 mb-3">
														<div class="input-group">
															<input type="password" name="user_password" id="user_password" class="form-control" 
																placeholder="Contraseña" required 
																pattern="(?=.*\d)(?=.*[A-Z]).{8,}" 
																title="Debe tener al menos 8 caracteres, una mayúscula y un número">
														</div>
														<small id="passwordHelp" class="text-danger d-none">La contraseña debe tener al menos 8 caracteres, una mayúscula y un número.</small>
													</div>

													<div class="col-lg-6 mb-3">
														<div class="input-group">
															<input type="password" name="user_passwordr" id="user_passwordr" class="form-control" 
																placeholder="Repita contraseña" required>
														</div>
														<small id="matchHelp" class="text-danger d-none">Las contraseñas no coinciden.</small>
													</div>
													<div class="col-lg-12 mb-3">
														<div class="input-group">
															<select class="form-select" name="user_state" required  >
																<option value="">Estado</option>
																<?php foreach ($this->list_user_state AS $key => $value ){?>
																	<option value="<?php echo $key; ?>" /> <?= $value; ?></option>
																<?php } ?>
															</select>
														</div>
														<div class="help-block with-errors"></div>
													</div>

													<div class="col-lg-12 text-center mt-3">
														<div class="btn-modal-footer d-grid gap-2">
															<button id="submitBtn" class="btn w-100" type="submit" disabled>Guardar</button>
															<a class="w-100" data-bs-dismiss="modal">Cancelar</a>
														</div>
													</div>

												</div>
											</div>

										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="content-table">
					<table class=" table table-striped table-des table-hover table-administrator text-start">
						<thead>
							<tr>
								<td class="no_cel"><b>Estado</b></td>
								<td><b>Nombres</b></td>
								<td class="no_cel"><b>Nivel</b></td>
								<td class="no_cel"><b>Usuario</b></td>
								<td><b>Correo</b></td>
								<td class="no_cel" width="100"></td>
							</tr>
						</thead>
						<tbody>
							<?php foreach($this->lists as $content){ ?>
							<?php $id =  $content->user_id; ?>
								<tr>
									<td class="no_cel"><?= $this->list_user_state[$content->user_state];?></td>
									<td><?=$content->user_names;?></td>
									<td class="no_cel"><?= $this->list_user_level[$content->user_level];?></td>
									<td class="no_cel"><?=$content->user_user;?></td>
									<td><?=$content->user_email;?></td>
									<td class="text-end table-options-no-responsive">
										<div>
											<span data-bs-toggle="tooltip" data-bs-toggle="tooltip" data-placement="top" title="Editar" class="d-none1">
												<a class="btn btn-azul btn-sm" data-bs-toggle="modal" data-bs-target="#editar<?= $id ?>"><i class="fas fa-pen-alt"></i></a>
											</span>
											<span data-bs-toggle="tooltip" data-placement="top" title="Eliminar" class="d-none1">
												<a class="btn btn-rojo btn-sm" data-bs-toggle="modal" data-bs-target="#modal<?= $id ?>"><i class="fas fa-trash-alt" ></i></a></span>
										</div>
									</td>
								</tr>

								<tr class="table-options-responsive">
									<td colspan="11" class="text-end">
										<div>
											<span data-bs-toggle="tooltip" data-bs-toggle="tooltip" data-placement="top" title="Editar" class="d-none1">
												<a class="btn btn-azul btn-sm" data-bs-toggle="modal" data-bs-target="#editar<?= $id ?>"><i class="fas fa-pen-alt"></i></a>
											</span>
											<span data-bs-toggle="tooltip" data-placement="top" title="Eliminar" class="d-none1">
												<a class="btn btn-rojo btn-sm" data-bs-toggle="modal" data-bs-target="#modal<?= $id ?>"><i class="fas fa-trash-alt" ></i></a></span>
										</div>
									</td>
								</tr>

								<!-- Modal Editar -->
								<div class="modal fade text-start" id="editar<?= $id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-body">
												<div class="row">
													<div class="col-lg-12">
														<div class="caja_azul">
															<div class="d-flex justify-content-between align-items-center h-100">
																<b class="titulo_dashboard"><i class="fa-solid fa-user"></i> Editar usuario</b>
																<div class="me-2">
																	<button type="button" class="close btn-cerrar-modal" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
																</div>
															</div>
														</div>
													</div>
												</div>

												<form class="text-start" enctype="multipart/form-data" method="post" action="/page/usuario/update" data-bs-toggle="validator">
													
													<div class="row px-3">
													
														<div class="col-lg-12 mt-3 mb-3">
															<span class="detail-modal">Por favor ingrese los datos del usuario.</span>
														</div>

														<div class="col-lg-12 mb-3">
															<div class="input-group">
																<input type="text" name="user_names" value="<?= $content->user_names; ?>" class="form-control modal-input" placeholder="Nombre del usuario">
															</div>
															<div class="help-block with-errors"></div>
														</div>
														<div class="col-lg-12 mb-3">
															<div class="input-group">
																<select class="form-select modal-input" name="user_level"  required>
																	<option value="">Seleccione...</option>
																	<?php foreach ($this->list_user_level AS $key => $value ){?>
																		<option <?php if($this->getObjectVariable($content,"user_level") == $key ){ echo "selected"; }?> value="<?php echo $key; ?>" /> <?= $value; ?></option>
																	<?php } ?>
																</select>
															</div>
															<div class="help-block with-errors"></div>
														</div>
														<div class="col-lg-12 mb-3">
															<div class="input-group">
																<input type="email" value="<?= $content->user_email; ?>" name="user_email" id="user_email" class="form-control modal-input" placeholder="Correo">
															</div>
															<div class="help-block with-errors"></div>
														</div>
														<div class="col-lg-12 mb-3">
															<div class="input-group">
																<input type="text" value="<?= $content->user_user; ?>" name="user_user" id="user_user" class="form-control modal-input" placeholder="Usuario">
															</div>
															<div class="help-block with-errors"></div>
														</div>
														<div class="col-lg-6 mb-3">
															<div class="input-group">
																<input type="password" value="" name="user_password" id="user_password" class="form-control modal-input" pattern="(?=.*\d)(?=.*[A-Z]).{8,}" data-error="La contraseña debe tener al menos 8 caracteres, una mayuscula y un numero" placeholder="Contraseña">
															</div>
															<div class="help-block with-errors"></div>
														</div>
														<div class="col-lg-6 mb-3">
															<div class="input-group">
																<input type="password" value="" name="user_passwordr" id="user_passwordr" data-match="#user_password" data-match-error="Las dos contraseñas no son iguales" class="form-control modal-input" placeholder="Repetir contraseña">
															</div>
															<div class="help-block with-errors"></div>
														</div>
														<div class="col-lg-12 mb-3">
															<div class="input-group">
																<select class="form-select" name="user_state" required  >
																	<option value="">Seleccione...</option>
																	<?php foreach ($this->list_user_state AS $key => $value ){?>
																		<option <?php if($this->getObjectVariable($content,"user_state") == $key){ echo "selected"; }?> value="<?php echo $key; ?>" /> <?= $value; ?></option>
																	<?php } ?>
																</select>
															</div>
															<div class="help-block with-errors"></div>
														</div>
														
														<input type="hidden" name="csrf" id="csrf" value="<?php echo $this->csrf ?>">
														<input type="hidden" name="csrf_section" id="csrf_section" value="<?php echo $this->csrf_section ?>">
														<input type="hidden" name="id" id="id" value="<?= $content->user_id; ?>" />
														<input type="hidden" name="user_delete"  value="<?php echo $content->user_delete ?>">
														<input type="hidden" name="user_current_user"  value="<?php echo $content->user_current_user ?>">
														<input type="hidden" name="user_code"  value="<?php echo $content->user_code ?>">
														
														<div class="col-lg-12 text-center mt-3">
															<div class="btn-modal-footer d-grid gap-2">
																<button class="btn w-100" type="submit">Guardar</button>
																<a class="w-100" data-bs-dismiss="modal">Cancelar</a>
															</div>
														</div>
													</div>
												</form>
												
											</div>
										</div>
									</div>
								</div>

								<!-- Modal -->
								<div class="modal fade text-start" id="modal<?= $id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h4 class="modal-title" id="myModalLabel">Eliminar Registro</h4>
												<button type="button" class="close btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
										</div>
										<div class="modal-body">
											<div class="">¿Esta seguro de eliminar este registro?</div>
										</div>
										<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
												<a class="btn btn-danger" href="<?php echo $this->route;?>/delete?id=<?= $id ?>&csrf=<?= $this->csrf;?><?php echo ''; ?>" >Eliminar</a>
										</div>
										</div>
									</div>
								</div>
							<?php } ?>
						</tbody>
					</table>
				</div>
				<input type="hidden" id="csrf" value="<?php echo $this->csrf ?>"><input type="hidden" id="page-route" value="<?php echo $this->route; ?>/changepage">
			</div>
		</div>
	</div>
	<div align="center">
		<ul class="pagination justify-content-center mt-4 mb-5">
	    <?php
	    	$url = $this->route;
	        if ($this->totalpages > 1) {
	            if ($this->page != 1)
	                echo '<li class="page-item"><a class="page-link" href="'.$url.'?page='.($this->page-1).'"> &laquo; Anterior </a></li>';
	            for ($i=1;$i<=$this->totalpages;$i++) {
	                if ($this->page == $i)
	                    echo '<li class="active page-item"><a class="page-link">'.$this->page.'</a></li>';
	                else
	                    echo '<li class="page-item"><a class="page-link" href="'.$url.'?page='.$i.'">'.$i.'</a></li>  ';
	            }
	            if ($this->page != $this->totalpages)
	                echo '<li class="page-item"><a class="page-link" href="'.$url.'?page='.($this->page+1).'">Siguiente &raquo;</a></li>';
	        }
	  	?>
	  	</ul>
	</div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const password = document.getElementById("user_password");
        const confirmPassword = document.getElementById("user_passwordr");
        const passwordHelp = document.getElementById("passwordHelp");
        const matchHelp = document.getElementById("matchHelp");
        const submitBtn = document.getElementById("submitBtn");

        function validatePassword() {
            const regex = /^(?=.*\d)(?=.*[A-Z]).{8,}$/;
            if (!regex.test(password.value)) {
                passwordHelp.classList.remove("d-none");
                return false;
            } else {
                passwordHelp.classList.add("d-none");
                return true;
            }
        }

        function validateMatch() {
            if (password.value !== confirmPassword.value || password.value === "") {
                matchHelp.classList.remove("d-none");
                return false;
            } else {
                matchHelp.classList.add("d-none");
                return true;
            }
        }

        function checkValidation() {
            if (validatePassword() && validateMatch()) {
                submitBtn.removeAttribute("disabled");
            } else {
                submitBtn.setAttribute("disabled", "true");
            }
        }

        password.addEventListener("input", checkValidation);
        confirmPassword.addEventListener("input", checkValidation);
    });
</script>