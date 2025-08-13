<style>
	.modal-lg, .modal-xl {
		max-width: 70%;
	}
</style>

<h5 class="titulo-principal"><i class="fas fa-users"></i> <?php echo $this->titlesection; ?></h5>
<div class="container-fluid">
	<form action="<?php echo $this->route; ?>" method="post">
        <div class="content-dashboard">
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
					<div class="row">
						<div class="col-lg-2 col-12 mb-3">
							<label class="form-label">Nombre empresa</label>
							<div class="input-group">
								<span class="input-group-text input-icono fondo-azul " ><i class="fas fa-pencil-alt"></i></span>
								<input type="text" class="form-control" name="nombre" value="<?php echo $this->getObjectVariable($this->filters, 'nombre') ?>"></input>
							</div>
						</div>
						<div class="col-lg-2 col-12 mb-3">
							<label class="form-label">Documento</label>
							<div class="input-group">
								<span class="input-group-text input-icono fondo-azul " ><i class="fas fa-pencil-alt"></i></span>
								<input type="text" class="form-control" name="documento" value="<?php echo $this->getObjectVariable($this->filters, 'documento') ?>"></input>
							</div>
						</div>
						<div class="col-lg-2 col-12 mb-3">
							<label class="form-label">Tipo</label>
							<div class="input-group">
								<span class="input-group-text input-icono fondo-rojo-claro " ><i class="far fa-list-alt"></i></span>
								<select class="form-select" name="categoria">
									<option value="">Todas</option>
									<?php foreach ($this->list_categoria as $key => $value) : ?>
										<option value="<?= $key; ?>" <?php if ($this->getObjectVariable($this->filters, 'categoria') ==  $key) { echo "selected";} ?>><?= $value; ?></option>
									<?php endforeach ?>
								</select>
							</div>
						</div>
						<div class="col-lg-2 col-12 mb-3">
							<label class="form-label">Asignado</label>
							<div class="input-group">
								<span class="input-group-text input-icono fondo-azul " ><i class="far fa-list-alt"></i></span>
								<select class="form-select" name="asignado">
									<option value="">Todas</option>
									<?php foreach ($this->list_asignado as $key => $value) : ?>
										<option value="<?= $key; ?>" <?php if ($this->getObjectVariable($this->filters, 'asignado') ==  $key) { echo "selected";} ?>><?= $value; ?></option>
									<?php endforeach ?>
								</select>
							</div>
						</div>
						<div class="col">
							<label class="form-label">&nbsp;</label>
							<button type="submit" class="btn btn-azul w-100"> <i class="fas fa-filter"></i> Filtrar</button>
						</div>
						<div class="col">
							<label class="form-label">&nbsp;</label>
							<a class="btn btn-azul-claro w-100" href="<?php echo $this->route; ?>?cleanfilter=1" > <i class="fas fa-eraser"></i> Limpiar</a>
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
					<div class="row align-items-center">
						<!-- Se encontraron X registros -->
						<div class="col-lg-5 col-md-5 col-sm-5 col-12">
							<div class="titulo-registro">Se encontraron <?php echo $this->register_number; ?> Registros</div>
						</div>

						<!-- Registros por página y select -->
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

						<!-- Botón Crear Nuevo -->
						<div class="col-lg-2 col-md-2 col-sm-12 col-12 mb-2">
							<div class="text-end">
								<a class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modal_crear_cliente">
									<i class="fas fa-plus-square" data-bs-toggle="tooltip" data-placement="top" title="Crear nuevo"></i> Crear Nuevo
								</a>
							</div>
							
							<!-- Modal crear -->
							<div class="modal fade text-start" id="modal_crear_cliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
								<div class="modal-dialog modal-md" role="document">
									<div class="modal-content">
										<form class="text-left" enctype="multipart/form-data" method="post" action="/page/clientes/insert">
											<div class="modal-body">
												<div class="row">
													<div class="col-lg-12">
														<div class="caja_azul">
															<div class="d-flex justify-content-between align-items-center h-100">
																<b class="titulo_dashboard"><i class="fa-solid fa-building icon-dash"></i> Crear nuevo cliente</b>
																<div class="me-2">
																	<button type="button" class="close btn-cerrar-modal" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="row px-3">
													
													<div class="col-lg-12 mt-3 mb-3">
														<span class="detail-modal">Por favor ingrese los datos de la empresa o cliente.</span>
													</div>
													<div class="col-lg-12 mb-3">
														<div class="input-group">
															<input type="text" name="nombre" id="nombre" class="form-control modal-input" required minlength="3" pattern="[^\d]*" title="No se permiten numeros" placeholder="Nombre empresa">
														</div>
														<div class="help-block with-errors"></div>
													</div>
													<div class="col-lg-6 mb-3">
														<div class="input-group">
															<select class="form-select modal-input" name="tipo_documento">
																<option value="">Tipo documento</option>
																<?php foreach ($this->list_tipo_documento AS $key => $value ){?>
																	<option value="<?php echo $key; ?>"> <?= $value; ?></option>
																<?php } ?>
															</select>
														</div>
														<div class="help-block with-errors"></div>
													</div>				
													<div class="col-lg-6 mb-3">
														<div class="input-group">
															<input type="number" name="documento" id="documento" class="form-control modal-input" placeholder="Número de documento">
														</div>
														<div class="help-block with-errors"></div>
													</div>
													<div class="col-lg-12 mb-3">
														<div class="input-group">
															<input type="email" name="email" id="email" class="form-control modal-input" required placeholder="Correo">
														</div>
														<div class="help-block with-errors"></div>
													</div>
													<div class="col-lg-6 mb-3">
														<div class="input-group">
															<input type="number" name="telefono" id="telefono" class="form-control modal-input" placeholder="Teléfono">
														</div>
														<div class="help-block with-errors"></div>
													</div>
													<div class="col-lg-6 mb-3">
														<div class="input-group">
															<input type="tel" name="celular" id="celular" class="form-control modal-input" minlength="10" maxlength="10" required placeholder="Celular">
														</div>
														<div class="help-block with-errors"></div>
													</div>
													<div class="col-lg-12 mb-3">
														<div class="input-group">
															<input type="text" name="contacto_principal" id="contacto_principal" class="form-control modal-input" minlength="3" required placeholder="Contacto principal">
														</div>
														<div class="help-block with-errors"></div>
													</div>
													<div class="col-lg-12 mb-3">
														<div class="input-group">
															<input type="text" name="direccion" id="direccion" class="form-control modal-input" placeholder="Dirección">
														</div>
														<div class="help-block with-errors"></div>
													</div>
													<div class="col-lg-12 mb-3">
														<div class="input-group">
															<input type="text" name="pagina_web" id="pagina_web" class="form-control modal-input" placeholder="Página Web">
														</div>
														<div class="help-block with-errors"></div>
													</div>
													<div class="col-lg-12 mb-3">
														<div class="input-group">
															<select class="form-select modal-input" name="categoria" required>
																<option value="">Tipo</option>
																<?php foreach ($this->list_categoria AS $key => $value ){?>
																	<option value="<?php echo $key; ?>"> <?= $value; ?></option>
																<?php } ?>
															</select>
														</div>
														<div class="help-block with-errors"></div>
													</div>
													<div class="col-lg-12 mb-3">
														<input type="file" name="logo" id="logo" class="form-control  file-document" data-buttonName="btn-primary" onchange="validardocumento('logo');" accept="image/*" >

														<?php if($this->content->logo!=""){ ?>
															<br><a href="/images/<?php echo $this->content->logo; ?>" target="_blank" class="btn btn-primary btn-sm"><i class="fas fa-file-download"></i></a>
														<?php } ?>

														<div class="help-block with-errors"></div>
													</div>


													<input type="hidden" name="csrf" id="csrf" value="<?php echo $this->csrf ?>">
													<input type="hidden" name="csrf_section" id="csrf_section" value="<?php echo $this->csrf_section ?>">

													<div class="col-lg-12 text-center mt-3">
														<div class="btn-modal-footer d-grid gap-2">
															<button class="btn w-100" type="submit">Guardar</button>
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
					<table class=" table table-striped table-des table-hover table-administrator text-start" style="font-size: 14px;">
						<thead>
							<tr>
								<td><b>Logo<b></td>
								<td class="no_cel"><b>Fecha creación</b></td>
								<td><b>Nombre empresa</b></td>
								<td class=""><b>Contacto principal</b></td>
								<td class="no_cel"><b>Documento</b></td>
								<td class="no_cel"><b>Correo</b></td>
								<td class="no_cel"><b>Celular</b></td>
								<td class="no_cel"><b>Fecha a.</b></td>
							</tr>
						</thead>
						<tbody>
							<?php foreach($this->lists as $content){ ?>
							<?php $id =  $content->id; ?>
								<tr>
									<td class="d-flex justify-content-center">
										<div class="img-cliente">
											<?php if ($content->logo) { ?>
												<img src="/images/<?= $content->logo ?>">
											<?php } else { ?>
												<i class="fa-solid fa-image"></i>
											<?php } ?>
										</div>
									</td>
									<td class="no_cel"><?= formatoDMY($content->fecha_c); ?></td>
									<td><?=$content->nombre;?></td>
									<td class=""><?=$content->contacto_principal;?></td>
									<td class="no_cel"><?=$content->documento;?></td>
									<td class="no_cel"><div title="<?=$content->email;?>" style="word-break: break-all"><?=$content->email;?></div></td>
									<td class="no_cel"><?=$content->celular;?></td>
									<td class="no_cel"><?= formatoDMYH($content->fecha_a);?></td>
								</tr>
								<tr>
									<td colspan="11" class="text-end">
										<div>

											<a class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal_cliente_<?= $id ?>">
												<i class="fas fa-pen-alt" data-bs-toggle="tooltip" data-placement="top" title="Editar"></i>
											</a>

											<span data-bs-toggle="tooltip" data-placement="top" title="Detalle"><a class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modal_detalle<?= $id ?>"  ><i class="fas fa-info-circle"></i></a></span>

											<a style="color: #FFFFFF"  onclick="document.getElementById('iframe_proyectos').src='/page/proyectos/?cliente=<?= $id ?>&detalle=1&cleanfilter=1&page=1'; $('#header_proyecto').html('Cliente: <?= $content->nombre;?>'); " class="btn btn-success btn-sm " data-bs-toggle="modal" data-bs-target="#modal_proyectos"><i class="fas fa-project-diagram" data-bs-toggle="tooltip" data-placement="top" title="Proyectos"></i></a>
											
											<a style="color: #FFFFFF"  onclick="document.getElementById('iframe_seguimientos').src='/page/contactos/?cliente=<?= $id ?>&detalle=1&cleanfilter=1&page=1'; $('#header_seguimiento').html('Cliente: <?= $content->nombre;?>'); " class="btn btn-info btn-sm " data-bs-toggle="modal" data-bs-target="#modal_seguimientos"><i class="fas fa-users" data-bs-toggle="tooltip" data-placement="top" title="Contactos"></i></a>

											<span data-bs-toggle="tooltip" data-placement="top" title="Eliminar"><a class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modal<?= $id ?>"  ><i class="fas fa-trash-alt" ></i></a></span>
										</div>
										<!-- Modal editar -->
										<div class="modal fade text-start" id="modal_cliente_<?= $id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
											<div class="modal-dialog modal-md" role="document">
												<div class="modal-content">
													<form class="text-left" enctype="multipart/form-data" method="post" action="/page/clientes/update">
														<div class="modal-body">
															<div class="row">
																<div class="col-lg-12">
																	<div class="caja_azul">
																		<div class="d-flex justify-content-between align-items-center h-100">
																			<b class="titulo_dashboard"><i class="fa-solid fa-building icon-dash"></i> Editar cliente</b>
																			<div class="me-2">
																				<button type="button" class="close btn-cerrar-modal" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="row px-3">
																
																<div class="col-lg-12 mt-3 mb-3">
																	<span class="detail-modal">Por favor ingrese los datos de la empresa o cliente.</span>
																</div>
																<div class="col-lg-12 mb-3">
																	<div class="input-group">
																		<input type="text" value="<?= $content->nombre ?>" name="nombre" id="nombre" class="form-control modal-input" required minlength="3" pattern="[^\d]*" title="No se permiten numeros" placeholder="Nombre empresa">
																	</div>
																	<div class="help-block with-errors"></div>
																</div>
																<div class="col-lg-6 mb-3">
																	<div class="input-group">
																		<select class="form-select modal-input" name="tipo_documento">
																			<option value="">Tipo documento</option>
																			<?php foreach ($this->list_tipo_documento AS $key => $value ){?>
																				<option value="<?php echo $key; ?>" <?php if ($content->tipo_documento == $key){ echo "selected"; } ?> > <?= $value; ?></option>
																			<?php } ?>
																		</select>
																	</div>
																	<div class="help-block with-errors"></div>
																</div>				
																<div class="col-lg-6 mb-3">
																	<div class="input-group">
																		<input type="number" value="<?= $content->documento ?>" name="documento" id="documento" class="form-control modal-input" placeholder="Número de documento">
																	</div>
																	<div class="help-block with-errors"></div>
																</div>
																<div class="col-lg-12 mb-3">
																	<div class="input-group">
																		<input type="email" value="<?= $content->email ?>" name="email" id="email" class="form-control modal-input" required placeholder="Correo">
																	</div>
																	<div class="help-block with-errors"></div>
																</div>
																<div class="col-lg-6 mb-3">
																	<div class="input-group">
																		<input type="number" value="<?= $content->telefono ?>" name="telefono" id="telefono" class="form-control modal-input" placeholder="Teléfono">
																	</div>
																	<div class="help-block with-errors"></div>
																</div>
																<div class="col-lg-6 mb-3">
																	<div class="input-group">
																		<input type="tel" value="<?= $content->celular ?>" name="celular" id="celular" class="form-control modal-input" minlength="10" maxlength="10" required placeholder="Celular">
																	</div>
																	<div class="help-block with-errors"></div>
																</div>
																<div class="col-lg-12 mb-3">
																	<div class="input-group">
																		<input type="text" value="<?= $content->contacto_principal ?>" name="contacto_principal" id="contacto_principal" class="form-control modal-input" minlength="3" required placeholder="Contacto principal">
																	</div>
																	<div class="help-block with-errors"></div>
																</div>
																<div class="col-lg-12 mb-3">
																	<div class="input-group">
																		<input type="text" value="<?= $content->direccion ?>" name="direccion" id="direccion" class="form-control modal-input" placeholder="Dirección">
																	</div>
																	<div class="help-block with-errors"></div>
																</div>
																<div class="col-lg-12 mb-3">
																	<div class="input-group">
																		<input type="text" value="<?= $content->pagina_web ?>" name="pagina_web" id="pagina_web" class="form-control modal-input" placeholder="Página Web">
																	</div>
																	<div class="help-block with-errors"></div>
																</div>
																<div class="col-lg-12 mb-3">
																	<div class="input-group">
																		<select class="form-select modal-input" name="categoria" required>
																			<option value="">Tipo</option>
																			<?php foreach ($this->list_categoria AS $key => $value ){?>
																				<option value="<?php echo $key; ?>" <?php if ($content->categoria == $key){ echo "selected"; } ?>> <?= $value; ?></option>
																			<?php } ?>
																		</select>
																	</div>
																	<div class="help-block with-errors"></div>
																</div>
																<div class="col-lg-12 mb-3">
																	<div class="d-flex justify-content-between">
																		<?php if($content->logo!=""){ ?>
																			<br><img src="/images/<?= $content->logo ?>" width="50" height="50">
																		<?php } ?>
																		
																		<input type="file" name="logo" id="logo" class="form-control  file-document" data-buttonName="btn-primary" onchange="validardocumento('logo');" accept="image/*" >															
																	</div>

																	<div class="help-block with-errors"></div>
																</div>


																<input type="hidden" name="csrf" id="csrf" value="<?php echo $this->csrf ?>">
																<input type="hidden" name="csrf_section" id="csrf_section" value="<?php echo $this->csrf_section ?>">
																<input type="hidden" name="detalle" value="1">
																<input type="hidden" name="id" id="id" value="<?= $content->id; ?>" />

																<div class="col-lg-12 text-center mt-3">
																	<div class="btn-modal-footer d-grid gap-2">
																		<button class="btn w-100" type="submit">Guardar</button>
																		<a class="w-100" data-bs-dismiss="modal">Cancelar</a>
																	</div>
																</div>

															</div>
														</div>
													</form>
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

										<!-- Modal -->
										<div class="modal fade text-start" id="modal_detalle<?= $id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
											<div class="modal-dialog modal-lg" role="document">
												<div class="modal-content">
													<div class="modal-body">

														<div class="row">
															<div class="col-lg-12">
																<div class="caja_azul">
																	<div class="d-flex justify-content-between align-items-center h-100">
																		<b class="titulo_dashboard"><i class="fa-solid fa-circle-info"></i> Detalle</b>
																		<div class="me-2">
																			<button type="button" class="close btn-cerrar-modal" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
																		</div>
																	</div>
																</div>
															</div>
														</div>

														<div class="row mt-2">
															<div class="col-lg-12">
																<div class="row">
																	<div class="col-lg-4">
																		<div class="d-flex justify-content-center align-items-center">
																			<img src="/images/solo_o.png" class="img-profile">
																		</div>
																		<div class=" d-flex justify-content-center align-items-center mt-3">
																			<ul class="list-unstyled">
																				<li class="text-center">
																					<h2><?= $content->nombre; ?></h2>
																				</li>
																			</ul>
																		</div>
																	</div>
																	<div class="col-lg-8">
																		<div class="d-flex justify-content-between align-items-center mb-1">
																			<b class="titulo_dashboard"><i class="fa-solid fa-circle-info"></i> Información</b>
																		</div>
																		<hr class="m-0">
																		<div class="row px-3 mt-2">
																			<div class="col-lg-12">
																				<div class="row">
																					<div class="col-lg-6 mb-2">
																						<i class="fa-solid fa-id-card-clip"></i> <label>Tipo de documento: </label>
																						<?php foreach ($this->list_tipo_documento AS $key => $value ){?>
																							<?php if($content->tipo_documento == $key ){ echo $value; } ?>
																						<?php } ?>
																					</div>
																					<div class="col-lg-6 mb-2">
																						<i class="fa-solid fa-address-card"></i> <label>Número de documento: </label><?= $content->documento; ?>
																					</div>
																					<div class="col-lg-6 mb-2">
																						<i class="fas fa-phone"></i> <label>Teléfono: </label><?= $content->telefono; ?>
																					</div>
																					<div class="col-lg-6 mb-2">
																						<i class="fas fa-mobile-alt"></i> <label>Celular: </label><?= $content->celular; ?>
																					</div>
																					<div class="col-lg-6 mb-2">
																						<i class="fa-solid fa-at"></i> <label>Correo: </label><?= $content->email; ?>
																					</div>																		
																					<div class="col-lg-6 mb-2">
																						<i class="fas fa-user"></i> <label>Contacto principal: </label><?= $content->contacto_principal; ?>
																					</div>
																					<div class="col-lg-6 mb-2">
																						<i class="fas fa-globe"></i> <label>Página web: </label><a href="<?= $content->pagina_web; ?>" target="_blank"><?= $content->pagina_web; ?></a>
																					</div>
																					<div class="col-lg-6 mb-2">
																						<i class="fas fa-tags"></i> <label>Tipo: </label>
																						<?php foreach ($this->list_categoria as $key => $value) {
																							if ($content->categoria == $key) echo $value;
																						} ?>
																					</div>
																					<div class="col-lg-6 mb-2">
																						<i class="fas fa-user-check"></i> <label>Asignado: </label>
																						<?php foreach ($this->list_asignado as $key => $value) {
																							if ($content->asignado == $key) echo $value;
																						} ?>
																					</div>																		
																				</div>
																			</div>
																		</div>
																	</div>
																	<div class="col-lg-12">
																		<hr>
																		<iframe width="100%" height="600" frameborder="0" src="/page/proyectos/?cliente=<?php echo $id; ?>&detalle=1&cleanfilter=1&page=1"></iframe>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>

									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
				<input type="hidden" id="csrf" value="<?php echo $this->csrf ?>"><input type="hidden" id="page-route" value="<?php echo $this->route; ?>/changepage">
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
</div>




<!-- Modal -->
<div class="modal fade text-start" id="modal_seguimientos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  	<div class="modal-dialog modal-lg" role="document">
    	<div class="modal-content ">
      		
			<div class="modal-body">
				<div class="caja_azul mb-3">
					<div class="d-flex justify-content-between align-items-center h-100">
						<b class="titulo_dashboard"><i class="fa-regular fa-address-book"></i> Contactos</b>
						<div class="me-2">
							<button type="button" class="close btn-cerrar-modal" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
						</div>
					</div>
				</div>
				<iframe id="iframe_seguimientos" src="about:blank" width="100%" height="500" frameborder="0"></iframe>
			</div>

    	</div>
  	</div>
</div>

<!-- Modal -->
<div class="modal fade text-start" id="modal_proyectos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  	<div class="modal-dialog modal-lg" role="document">
    	<div class="modal-content ">
      	
			<div class="modal-body">
				<div class="caja_azul mb-3">
					<div class="d-flex justify-content-between align-items-center h-100">
						<b class="titulo_dashboard"><i class="fa-solid fa-diagram-project icon-dash"></i> Proyectos</b>
						<div class="me-2">
							<button type="button" class="close btn-cerrar-modal" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
						</div>
					</div>
				</div>
				<iframe id="iframe_proyectos" src="about:blank" width="100%" height="500" frameborder="0"></iframe>
			</div>

    	</div>
  	</div>
</div>