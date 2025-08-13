<h1 class="titulo-principal"><i class="fas fa-history"></i> <?php echo $this->titlesection; ?></h1>
<?php if ($this->level == 5) { $none = "d-none"; } ?>
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
							<label class="form-label">Cliente</label>
							<div class="input-group">
								<span class="input-group-text input-icono fondo-rosado " ><i class="far fa-list-alt"></i></span>
								<select class="form-select" name="cliente_id">
									<option value="">Todos</option>									
									<?php foreach ($this->list_cliente_id as $key => $value) : ?>
										<option value="<?= $key; ?>" <?php if ($this->getObjectVariable($this->filters, 'cliente_id') ==  $key) { echo "selected";} ?>><?= $value; ?></option>
									<?php endforeach ?>
								</select>
							</div>
						</div>
						<div class="col-lg-2 col-12 mb-3">
							<label class="form-label">Nombre</label>
							<div class="input-group">
								<span class="input-group-text input-icono fondo-rojo-claro " ><i class="fas fa-pencil-alt"></i></span>
								<input type="text" class="form-control" name="nombre" value="<?php echo $this->getObjectVariable($this->filters, 'nombre') ?>"></input>
							</div>
						</div>
						<div class="col-lg-2 col-12 mb-3">
							<label class="form-label">Colaborador</label>
							<div class="input-group">
								<span class="input-group-text input-icono fondo-rosado " ><i class="far fa-list-alt"></i></span>
								<select class="form-select" name="colaborador">
									<option value="">Todos</option>
									<?php foreach ($this->lista_ingenieros as $key => $value) : ?>
										<option value="<?= $key; ?>" <?php if ($this->getObjectVariable($this->filters, 'colaborador') ==  $key) { echo "selected";} ?>><?= $value; ?></option>
									<?php endforeach ?>
								</select>
							</div>
						</div>
						<div class="col-lg-2 col-12 mb-3">
							<label class="form-label">Estado</label>
							<div class="input-group">
								<span class="input-group-text input-icono fondo-rosado " ><i class="far fa-list-alt"></i></span>
								<select class="form-select" name="estado">
									<option value="">Todos</option>
									<?php foreach ($this->list_estado_soporte as $key => $value) : ?>
										<option value="<?= $key; ?>" <?php if ($this->getObjectVariable($this->filters, 'estado') ==  $key) { echo "selected";} ?>><?= $value; ?></option>
									<?php endforeach ?>
								</select>
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
					<div class="row mb-2">
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
								<a class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modal_crear_proyecto">
									<i class="fas fa-plus-square" data-bs-toggle="tooltip" data-placement="top" title="Crear nuevo"></i> Crear Nuevo
								</a>
							</div>
							<div class="modal fade text-start" id="modal_crear_proyecto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
								<div class="modal-dialog modal-md" role="document">
									<div class="modal-content">
										<form class="text-start" enctype="multipart/form-data" method="post" action="/page/soporte/insert">
											<div class="modal-body">
												<div class="row">
													<div class="col-lg-12">
														<div class="caja_azul">
															<div class="d-flex justify-content-between align-items-center h-100">
																<b class="titulo_dashboard"><i class="fa-solid fa-diagram-project icon-dash"></i> Crear nuevo proyecto en soporte</b>
																<div class="me-2">
																	<button type="button" class="close btn-cerrar-modal" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="row px-3">
													<div class="col-lg-12 mt-3 mb-3">
														<span class="detail-modal">Por favor ingrese los datos del proyecto</span>
													</div>
													<div class="col-lg-12 mb-3">
														<div class="input-group">
															<select class="form-select modal-input" name="cliente_id" required <?php if($_GET['detalle'] == "1" && $_GET['hash'] == "") { echo "disabled"; } ?>>
																<option value="">Cliente</option>
																<?php foreach ($this->list_cliente_all AS $key => $value ){?>
																	<option <?php if($this->getObjectVariable($this->content,"cliente_id") == $key or $_GET['cliente'] == $key){ echo "selected"; $valor_cliente = $key; }?> value="<?php echo $key; ?>"> <?= $value; ?></option>
																<?php } ?>
															</select>
														</div>
														<div class="help-block with-errors"></div>
													</div>

													<div class="col-lg-12 mb-3">
														<div class="input-group">
															<input type="text" value="" name="nombre" id="nombre" class="form-control modal-input" required minlength="3" pattern="[^\d]*" title="No se permiten numeros" placeholder="Nombre del Proyecto">
														</div>
														<div class="help-block with-errors"></div>
													</div>				
													<div class="col-lg-12 mb-3 d-none">
														<div class="input-group">
															<input type="text" value="0" name="valor" id="valor" class="form-control modal-input" onchange="puntitos(this)" onkeyup="puntitos(this)">
														</div>
														<div class="help-block with-errors"></div>
													</div>
													<div class="col-lg-12 mb-3">
														<div class="input-group">
															<select class="form-select modal-input" name="tipo" required>
																<option value="">Tipo de Proyecto</option>
																<?php foreach ($this->list_tipo AS $key => $value ){?>
																	<option <?php if($this->getObjectVariable($this->content,"tipo") == $key ){ echo "selected"; }?> value="<?php echo $key; ?>" /> <?= $value; ?></option>
																<?php } ?>
															</select>
														</div>
														<div class="help-block with-errors"></div>
													</div>
													<div class="input-group">
														<select class="form-select" name="proyectosing_user">
															<option value="">Seleccione ingeniero</option>
															<?php foreach ($this->lista_ingenieros as $key => $value) { ?>
																<option value="<?php echo $key; ?>"><?= $value; ?></option>
															<?php } ?>
														</select>
													</div>
													<div class="col-lg-6 mb-3 d-none">
														<div class="input-group">
															<input type="hidden" value="9" name="estado" id="estado" class="form-control modal-input">
														</div>
														<div class="help-block with-errors"></div>
													</div>

													<div class="col-lg-12 text-center mt-3">
														<div class="btn-modal-footer d-grid gap-2">
															<button class="btn w-100" type="submit">Guardar</button>
															<a class="w-100" data-bs-dismiss="modal">Cancelar</a>
														</div>
													</div>

													<input type="hidden" name="csrf" id="csrf" value="<?php echo $this->csrf ?>">
													<input type="hidden" name="csrf_section" id="csrf_section" value="<?php echo $this->csrf_section ?>">
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
								<td class="no_cel"><b>Fecha finalización</b></td>
								<td><b>Cliente</b></td>
								<td><b>Nombre</b></td>
								<td class="no_cel"><b>Ingeniero</b></td>
								<td><b>Estado</b></td>
								<td class="no_cel"></td>
							</tr>
						</thead>
						<tbody>
							<?php foreach($this->lists as $content){ ?>
								<?php $id =  $content->id; ?>
								<input id="titulo_proyecto<?php echo $id; ?>" value="<?php echo $content->nombre;?> (<?= $this->list_cliente_id[$content->cliente_id];?>)" type="hidden" />
								<tr>
									<td class="no_cel"><?= formatoDMYH(str_replace("T", " ", $content->fecha_final)); ?></td>
									<td><?= $this->list_cliente_id[$content->cliente_id];?></td>
									<td><?= $content->nombre; ?></td>
									<td class="no_cel">
										<?php 
											$ingenieros = [];

											foreach ($this->lista_ingenieros_asoc as $key => $pro) {
												if ($id == $key) {
													foreach ($pro as $llave => $val) {
														$ingenieros[$llave] = [
															"nombre" => $val["nombre"],
															"ing" => $val["ing"],
															"proy" => $key
														];
													}
												}
											}

											// Mostrar los ingenieros en una cadena legible
											if (!empty($ingenieros)) {
												$output = [];
												foreach ($ingenieros as $llave => $val) {
													$output[] = "{$val['nombre']}";
												}
												echo implode(", ", $output);
											} else {
												echo "No hay ingenieros asignados";
											}

										?>
									</td>
									<td><?= $this->list_estado[$content->estado]; ?></td>
									<td class="text-end table-options-no-responsive">
										<?php if ($content->estado != 8) { ?>
											<span data-bs-toggle="tooltip" data-placement="top" title="Terminar relación comercial" class="<?= $none; ?>">
												<a class="btn btn-danger btn-sm" id="terminar_relacion" onclick="terminar('<?php echo $id; ?>','<?= $content->cliente_id ?>');">
													<i class="fas fa-clock"></i>
												</a>
											</span>
											<span data-bs-toggle="tooltip" data-placement="top" title="Asignar requerimientos">
												<a href="/page/view/?cliente=<?= $content->cliente_id ?>&proyecto=<?= $id ?>&sop=1" class="btn btn-primary btn-sm">
													<i class="fa-solid fa-bars"></i>
												</a>
											</span>
											<span data-bs-toggle="tooltip" data-placement="top" title="Asignar Ing" class="<?= $none; ?>">
												<a class="btn btn-cafe btn-sm" data-bs-toggle="modal" data-bs-target="#modal_asignar_<?= $id ?>">
													<i class="fas fa-user"></i>
												</a>
											</span>
										<?php } ?>
									</td>
								</tr>

								<tr class="table-options-responsive">
									<td colspan="11" class="text-end">
										<?php if ($content->estado != 8) { ?>
											<span data-bs-toggle="tooltip" data-placement="top" title="Terminar relación comercial" class="<?= $none; ?>">
												<a class="btn btn-danger btn-sm" id="terminar_relacion" onclick="terminar('<?php echo $id; ?>','<?= $content->cliente_id ?>');">
													<i class="fas fa-clock"></i>
												</a>
											</span>
											<span data-bs-toggle="tooltip" data-placement="top" title="Asignar requerimientos">
												<a href="/page/view/detail?cliente=<?= $content->cliente_id ?>&proyecto=<?= $id ?>" class="btn btn-primary btn-sm">
													<i class="fa-solid fa-bars"></i>
												</a>
											</span>
											<span data-bs-toggle="tooltip" data-placement="top" title="Asignar Ing" class="<?= $none; ?>">
												<a class="btn btn-cafe btn-sm" data-bs-toggle="modal" data-bs-target="#modal_asignar_<?= $id ?>">
													<i class="fas fa-user"></i>
												</a>
											</span>
										<?php } ?>
									</td>
								</tr>

							<?php } ?>
						</tbody>
					</table>

					<?php foreach($this->lists as $content){ ?>
					<?php $id =  $content->id; ?>
						<?php 
							$ingenieros = [];

							foreach ($this->lista_ingenieros_asoc as $key => $pro) {
								if ($id == $key) {
									foreach ($pro as $llave => $val) {
										$ingenieros[$llave] = [
											"nombre" => $val["nombre"],
											"ing" => $val["ing"],
											"proy" => $key
										];
									}
								}
							}

						?>

						<!-- Modal Asignar -->
						<div class="modal modal-lg fade text-start" id="modal_asignar_<?= $id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<form method="POST" action="/page/proyectosd/asignar">
										<div class="modal-body">
											<div class="row">
												<div class="col-lg-12">
													<div class="caja_azul">
														<div class="d-flex justify-content-between align-items-center h-100">
															<b class="titulo_dashboard"><i class="fa-solid fa-user-plus"></i> Asignar Ingeniero a proyecto en soporte</b>
															<div class="me-2">
																<button type="button" class="close btn-cerrar-modal" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="row px-3">
												<div class="col-lg-12 mt-3 mb-3">
													<span class="detail-modal">Por favor asigne al menos un Ingeniero al proyecto</span><br>
													<span class="detail-modal"><div class="card-title">Proyecto: <?=$content->nombre;?></div></span>
												</div>
												<div class="col-12">
													<table class="table table-striped table-hover table-administrator">
														<thead>
															<tr class="bck-table">
																<td>Ingeniero</td>
																<td>Observaciones</td>
																<td>
																	<button id="add-row_<?= $id ?>" class="btn btn-primary btn-sm" type="button">
																		<i class="fas fa-plus"></i>
																	</button>
																</td>
															</tr>
														</thead>
														<tbody id="table-body_<?= $id ?>">
															<tr>
																<td>
																	<div class="input-group">
																		<select class="form-select" name="proyectosing_user[]" id="proyectosing_user">
																			<option value="">Seleccione...</option>
																			<?php 
																				foreach ($this->lista_ingenieros as $key => $value) {
																					// Verifica si el key existe en el array de ingenieros (usa array_column para extraer solo los valores 'ing')
																					if (!in_array($key, array_column($ingenieros, 'ing'))) {
																				?>
																						<option value="<?php echo $key; ?>"><?= $value; ?></option>
																			<?php 
																					}
																				} 
																			?>
																		</select>
																	</div>
																</td>
																<td>
																	<div class="col-12 mb-2 mt-1">
																		<div class="input-group">
																			<span class="input-group-text input-icono" ><i class="fas fa-pencil-alt"></i></span>
																			<input type="text" class="form-control" name="proyectosing_observacion[]" id="proyectosing_observacion"/>
																		</div>
																	</div>
																</td>
																<td>
																	<button type="button" class="btn btn-danger btn-sm btn-delete"><i class="fas fa-minus"></i></button>
																</td>
															</tr>
														</tbody>
													</table>
												</div>

												<script>
												
													$('#add-row_<?= $id ?>').on('click', function() {
														var newRow = `
															<tr>
																<td>
																	<div class="input-group">
																		<select class="form-select" name="proyectosing_user[]" id="proyectosing_user">
																			<option value="">Seleccione...</option>
																			<?php 
																				foreach ($this->lista_ingenieros as $key => $value) {
																					// Verifica si el key existe en el array de ingenieros (usa array_column para extraer solo los valores 'ing')
																					if (!in_array($key, array_column($ingenieros, 'ing'))) {
																				?>
																						<option value="<?php echo $key; ?>"><?= $value; ?></option>
																			<?php 
																					}
																				} 
																			?>
																		</select>
																	</div>
																</td>
																<td>
																	<div class="col-12 mb-2 mt-1">
																		<div class="input-group">
																			<span class="input-group-text input-icono" ><i class="fas fa-pencil-alt"></i></span>
																			<input type="text" class="form-control" name="proyectosing_observacion[]" id="proyectosing_observacion"/>
																		</div>
																	</div>
																</td>
																<td>
																	<button class="btn btn-danger btn-sm btn-delete"><i class="fas fa-minus"></i></button>
																</td>
															</tr>
														`;
														$('#table-body_<?= $id ?>').append(newRow);
													});

													// Función para eliminar una fila
													$('#table-body_<?= $id ?>').on('click', '.btn-delete', function() {
														$(this).closest('tr').remove();
													});
												
												</script>

												<input type="hidden" name="id" value="<?= $id ?>">
												<input type="hidden" name="r" value="soporte">
												<input type="hidden" name="csrf" value="<?= $this->csrf ?>">
												<input type="hidden" name="csrf_section" value="<?= $this->csrf_section ?>">

												<div class="col-lg-12 text-center mt-3 mb-3">
													<div class="btn-modal-footer d-grid gap-2">
														<button class="btn w-100" type="submit">Guardar</button>
														<a class="w-100" data-bs-dismiss="modal">Cancelar</a>
													</div>
												</div>

												<?php foreach ($ingenieros as $key => $valor) { ?>
													<div class="col-lg-12">
														<div class="card mb-1 card-secciones" id="ing_<?= $key ?>">
															<div class="card-body">
																<div class="d-flex justify-content-between align-items-center">
																	<span><?= $valor["nombre"] ?></span>
																	<div class="d-flex">
																		<button type="button" class="btn btn-danger btn-sm" onclick="eliminar_ing(<?= $key ?>)">
																			<i class="fa fa-trash" aria-hidden="true"></i>
																		</button>
																	</div>
																</div>
															</div>
														</div>
													</div>
												<?php } ?>
												
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>

					<?php } ?>
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


<script type="text/javascript">	
	function terminar(id,cliente){
		var titulo = $("#titulo_proyecto"+id).val();
		var x = confirm("Esta seguro de terminar la relación comercial con el proyecto : "+titulo+"? ");
		if(x===true){
			window.location="/page/view/finalizar?id="+id+"&cliente="+cliente+"&proyecto="+id+"&hastw=1";
		}
	}

	function eliminar_ing(id) {
        if (confirm("¿ Estás seguro de que deseas quitar esta asignación ?")) {
            // Enviar la solicitud AJAX si el usuario confirma
            $.post("/page/soporte/deteleIng", { id: id }, function(response) {
                $("#ing_" + id).remove();
				location.reload();
            });
        }
    }
</script>
