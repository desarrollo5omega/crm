<h1 class="titulo-principal mb-3 ocultar_detalle"><i class="fas fa-list-alt"></i> <?php echo $this->titlesection; ?></h1>

<?php if ($this->level == 5) { $none = "d-none"; } ?>

<div class="container-fluid">
	<form action="<?php echo $this->route."?detalle=".$_GET['detalle']."&cliente=".$_GET['cliente']; ?>" method="post">
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
						<div class="col-12 col-lg-2 col-md-2 mb-3 ocultar_detalle">
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
						<div class="col-12 col-lg-2 col-md-2 mb-3 ocultar_detalle">
							<label class="form-label">Nombre</label>
							<div class="input-group">
								<span class="input-group-text input-icono fondo-rojo-claro " ><i class="fas fa-pencil-alt"></i></span>
								<input type="text" class="form-control" name="nombre" value="<?php echo $this->getObjectVariable($this->filters, 'nombre') ?>"></input>
							</div>
						</div>

						<div class="col-12 col-lg-2 col-md-2 mb-3">
							<label class="form-label">Estado</label>
							<div class="input-group">
								<span class="input-group-text input-icono fondo-azul " ><i class="far fa-list-alt"></i></span>
								<select class="form-select" name="estado">
									<option value="">Todos</option>
									<?php foreach ($this->list_estado as $key => $value) : ?>
										<option value="<?= $key; ?>" <?php if ($this->getObjectVariable($this->filters, 'estado') ==  $key) { echo "selected";} ?>><?= $value; ?></option>
									<?php endforeach ?>
								</select>
							</div>
						</div>
						<div class="col-12 col-lg-2 col-md-2 mb-3 ocultar_detalle">
							<label class="form-label">Fecha creación</label>
							<div class="input-group">
								<span class="input-group-text input-icono fondo-azul " ><i class="fas fa-pencil-alt"></i></span>
								<input type="date" class="form-control" name="fecha_c" value="<?php echo $this->getObjectVariable($this->filters, 'fecha_c') ?>"></input>
							</div>
						</div>
						<div class="col-12 col-lg-2 col-md-2 mb-3 ocultar_detalle">
							<label class="form-label">Fecha finalización</label>
							<div class="input-group">
								<span class="input-group-text input-icono fondo-azul " ><i class="fas fa-pencil-alt"></i></span>
								<input type="date" class="form-control" name="fecha_final" value="<?php echo $this->getObjectVariable($this->filters, 'fecha_final') ?>"></input>
							</div>
						</div>	            
						<div class="col">
							<label class="form-label">&nbsp;</label>
							<button type="submit" class="btn w-100 btn-azul"> <i class="fas fa-filter"></i> Filtrar</button>
						</div>
						<div class="col">
							<label class="form-label">&nbsp;</label>
							<a class="btn w-100 btn-azul-claro " href="<?php echo $this->route; ?>?cleanfilter=1&cliente=<?php echo $_GET['cliente']; ?>&detalle=<?php echo $_GET['detalle']; ?>" > <i class="fas fa-eraser"></i> Limpiar</a>
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
	                echo '<li class="page-item" ><a class="page-link"  href="'.$url.'?page='.($this->page-1).'&detalle='.$_GET['detalle'].'"> &laquo; Anterior </a></li>';
	            for ($i=1;$i<=$this->totalpages;$i++) {
	                if ($this->page == $i)
	                    echo '<li class="active page-item"><a class="page-link">'.$this->page.'</a></li>';
	                else
	                    echo '<li class="page-item"><a class="page-link" href="'.$url.'?page='.$i.'&detalle='.$_GET['detalle'].'">'.$i.'</a></li>  ';
	            }
	            if ($this->page != $this->totalpages)
	                echo '<li class="page-item"><a class="page-link" href="'.$url.'?page='.($this->page+1).'&detalle='.$_GET['detalle'].'">Siguiente &raquo;</a></li>';
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

						<?php if($_GET['detalle']==""){ ?>
							<div class="col-lg-2 col-md-2 col-sm-12 col-12 mb-2">
								<div class="text-end">
									<a class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modal_crear_proyecto">
										<i class="fas fa-plus-square" data-bs-toggle="tooltip" data-placement="top" title="Crear nuevo"></i> Crear Nuevo
									</a>
								</div>

								<div class="modal fade text-start" id="modal_crear_proyecto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
									<div class="modal-dialog modal-md" role="document">
										<div class="modal-content">
											<form class="text-start" enctype="multipart/form-data" method="post" action="/page/proyectosd/insert">
												<div class="modal-body">
													<div class="row">
														<div class="col-lg-12">
															<div class="caja_azul">
																<div class="d-flex justify-content-between align-items-center h-100">
																	<b class="titulo_dashboard"><i class="fa-solid fa-diagram-project icon-dash"></i> Crear nuevo proyecto</b>
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
																	<?php foreach ($this->list_cliente_id AS $key => $value ){?>
																		<option <?php if($this->getObjectVariable($this->content,"cliente_id") == $key or $_GET['cliente'] == $key){ echo "selected"; $valor_cliente = $key; }?> value="<?php echo $key; ?>"> <?= $value; ?></option>
																	<?php } ?>
																</select>
															</div>
															<div class="help-block with-errors"></div>
														</div>

														<div class="col-lg-12 mb-3">
															<div class="input-group">
																<input type="text" value="<?= $this->content->nombre; ?>" name="nombre" id="nombre" class="form-control modal-input" required minlength="3" pattern="[^\d]*" title="No se permiten numeros" placeholder="Nombre del Proyecto">
															</div>
															<div class="help-block with-errors"></div>
														</div>				
														<div class="col-lg-12 mb-3">
															<div class="input-group">
																<input type="text" value="<?php if($this->content->valor!=""){ echo formato_pesos($this->content->valor); } ?>" name="valor" id="valor" class="form-control modal-input" onchange="puntitos(this)" onkeyup="puntitos(this)" required minlength="3" placeholder="Valor del Proyecto">
															</div>
															<div class="help-block with-errors"></div>
														</div>
														<div class="col-lg-6 mb-3">
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
														<div class="col-lg-6 mb-3">
															<div class="input-group">
																<select class="form-select modal-input" name="estado" required>
																	<option value="">Estado del Proyecto</option>
																	<?php foreach ($this->list_estado AS $key => $value ){?>
																		<option <?php if($this->getObjectVariable($this->content,"estado") == $key ){ echo "selected"; }?> value="<?php echo $key; ?>" /> <?= $value; ?></option>
																	<?php } ?>
																</select>
															</div>
															<div class="help-block with-errors"></div>
														</div>
														<div class="col-lg-12 mb-3">
															<input type="file" name="documento1" id="documento1" class="form-control  file-document" data-buttonName="btn-primary" onchange="validardocumento('documento1');" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint, text/plain, application/pdf,image/*" >

															<?php if($this->content->documento1!=""){ ?>
																<br><a href="/images/<?php echo $this->content->documento1; ?>" target="_blank" class="btn btn-primary btn-sm"><i class="fas fa-file-download"></i></a>
															<?php } ?>

															<div class="help-block with-errors"></div>
														</div>
														<div class="col-lg-12 mb-3">
															<input type="file" name="documento2" id="documento2" class="form-control  file-document" data-buttonName="btn-primary" onchange="validardocumento('documento2');" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint, text/plain, application/pdf,image/*" >

															<?php if($this->content->documento2!=""){ ?>
																<br><a href="/images/<?php echo $this->content->documento2; ?>" target="_blank" class="btn btn-primary btn-sm"><i class="fas fa-file-download"></i></a>
															<?php } ?>

															<div class="help-block with-errors"></div>
														</div>
														<div class="col-lg-12 mb-3">
															<input type="file" name="documento3" id="documento3" class="form-control  file-document" data-buttonName="btn-primary" onchange="validardocumento('documento3');" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint, text/plain, application/pdf,image/*" >

															<?php if($this->content->documento3!=""){ ?>
																<br><a href="/images/<?php echo $this->content->documento3; ?>" target="_blank" class="btn btn-primary btn-sm"><i class="fas fa-file-download"></i></a>
															<?php } ?>

															<div class="help-block with-errors"></div>
														</div>

														<div class="col-lg-12 mb-3">
															<label for="proyectos_cadmin" class="form-label">Comentarios para Administración</label>
															<div class="input-group">
																<textarea rows="2" name="proyectos_cadmin" id="proyectos_cadmin" class="form-control modal-input" minlength="3"><?= $this->content->proyectos_cadmin; ?></textarea>
															</div>
															<div class="help-block with-errors"></div>
														</div>

														<div class="col-lg-12 mb-3">
															<label for="proyectos_caprueba" class="form-label">Comentarios para Proyectos</label>
															<div class="input-group">
																<textarea rows="2" name="proyectos_caprueba" id="proyectos_caprueba" class="form-control modal-input" minlength="3"><?= $this->content->proyectos_caprueba; ?></textarea>
															</div>
															<div class="help-block with-errors"></div>
														</div>

														<div class="col-lg-12 text-center mt-3">
															<div class="btn-modal-footer d-grid gap-2">
																<button class="btn w-100" type="submit">Guardar</button>
																<a class="w-100" data-bs-dismiss="modal">Cancelar</a>
															</div>
														</div>

														<input type="hidden" name="detalle" value="1">
														<input type="hidden" name="csrf" id="csrf" value="<?php echo $this->csrf ?>">
														<input type="hidden" name="csrf_section" id="csrf_section" value="<?php echo $this->csrf_section ?>">
													</div>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
						<?php }else{ ?>
							<div class="col-lg-3">
								<div class="text-end"><a class="btn btn-sm btn-success" target="_self" href="<?php echo $this->route."\manage"; ?>?cliente=<?php echo $_GET['cliente']; ?>&detalle=<?php echo $_GET['detalle']; ?>"> <i class="fas fa-plus-square"></i> Crear Nuevo</a></div>
							</div>		    		
						<?php } ?>

					</div>
				</div>

				<?php if($this->total_pendientes>0){ ?>
					<div align="center" class="mt-2">
						<div class="alert alert-info">
							<b>Total proyectos por aprobar: $<?php echo formato_pesos($this->total_pendientes); ?></b>
						</div>
					</div>
				<?php } ?>

				<div class="content-table">
					<table class=" table table-striped table-des table-hover table-administrator text-start">
						<thead>
							<tr>
								<td class="no_cel"><b>Fecha cotización</b></td>
								<td class="no_cel"><b>Fecha aprobación</b></td>
								<td class="no_cel"><b>Fecha finalización</b></td>
								<td width="35%"><b>Nombre</b></td>
								<td><b>Cliente</b></td>
								<td class="no_cel"><b>Ingeniero</b></td>
								<td><b>Estado</b></td>
								<td class="no_cel" style="min-width: 180px;"></td>
							</tr>
						</thead>
						<tbody>
							<?php foreach($this->lists as $content){ ?>
							<?php $id =  $content->id; ?>
								<input id="titulo_proyecto<?php echo $id; ?>" value="<?php echo $content->nombre;?> (<?= $this->list_cliente_id[$content->cliente_id];?>)" type="hidden" />
								<tr>
									<td class="no_cel"><?= formatoDMYH($content->fecha_c); ?></td>
									<td class="no_cel"><?= formatoDMYH($content->fecha_aprobado); ?></td>
									<td class="no_cel"><?= formatoDMYH(str_replace("T", " ", $content->fecha_final)); ?></td>
									<td><?=$content->nombre;?></td>
									<td><?= $this->list_cliente_id[$content->cliente_id];?></td>
									<td class="no_cel">
										<?php 
											// Inicializa un array para almacenar los ingenieros
											$ingenieros = [];

											// Recorrer la lista de ingenieros asociados
											foreach ($this->lista_ingenieros_asoc as $key => $pro) {
												// Verifica si el ID del proyecto coincide
												if ($id == $key) {
													$ingenieros = $pro; // Asigna los ingenieros asociados al array
													break; // Sal del bucle una vez encontrado
												}
											}

											// Mostrar los ingenieros asociados si los hay
											if (!empty($ingenieros)) {
												echo implode(", ", $ingenieros); // Combina los ingenieros en una cadena separada por comas
											} else {
												echo "No hay ingenieros asignados"; // Mensaje si no hay ingenieros
											}
										?>
									</td>

									<td><?= $this->list_estado[$content->estado] ?></td>
									
									<td class="text-end table-options-no-responsive">
										<div class="">
											
											<span data-bs-toggle="tooltip" data-placement="top" title="Terminar proyecto" class="<?= $none ?>">
												<a class="btn btn-danger btn-sm" id="terminar_proyecto" onclick="terminar('<?php echo $id; ?>','<?= $content->cliente_id ?>');">
													<i class="fas fa-clock"></i>
												</a>
											</span>

											<span data-bs-toggle="tooltip" data-placement="top" title="Ver proyecto">
												<a href="/page/view?cliente=<?= $content->cliente_id ?>&proyecto=<?= $id ?>" class="btn btn-success btn-sm"><i class="fas fa-eye"></i></a>
											</span>

											<span data-bs-toggle="tooltip" data-placement="top" title="Asignar Ing" class="<?= $none ?>">
												<a class="btn btn-cafe btn-sm" data-bs-toggle="modal" data-bs-target="#modal_asignar_<?= $id ?>">
													<i class="fas fa-user"></i>
												</a>
											</span>

											<span data-bs-toggle="tooltip" data-placement="top" title="Editar" class="<?= $none ?>">
												<a class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal_editar<?= $id ?>">
													<i class="fas fa-pen-alt"></i>
												</a>
											</span>
											
											<span data-bs-toggle="tooltip" data-placement="top" title="Detalle">
												<a class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modal_detalle<?= $id ?>">
													<i class="fas fa-info-circle"></i>
												</a>
											</span>

											<span data-bs-toggle="tooltip" data-placement="top" title="Eliminar" class="ocultar_detalle <?= $none ?>">
												<a class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modal<?= $id ?>">
													<i class="fas fa-trash-alt" ></i>
												</a>
											</span>

											<?php if($content->estado=="6"){ ?>
												<button type="button" class="btn btn-sm btn-azul2" data-bs-toggle="tooltip" data-placement="top" title="Aprobar proyecto" onclick="aprobar1('<?php echo $id; ?>');"><i class="far fa-thumbs-up "></i></button>
											<?php } ?>
										</div>
									</td>
								</tr>

								<tr class="table-options-responsive">
									<td colspan="11" class="text-end">
										<div class="">
											
											<span data-bs-toggle="tooltip" data-placement="top" title="Terminar proyecto" class="<?= $none ?>">
												<a class="btn btn-danger btn-sm" id="terminar_proyecto" onclick="terminar('<?php echo $id; ?>','<?= $content->cliente_id ?>');">
													<i class="fas fa-clock"></i>
												</a>
											</span>

											<span data-bs-toggle="tooltip" data-placement="top" title="Ver proyecto">
												<a href="/page/view?cliente=<?= $content->cliente_id ?>&proyecto=<?= $id ?>" class="btn btn-success btn-sm"><i class="fas fa-eye"></i></a>
											</span>

											<span data-bs-toggle="tooltip" data-placement="top" title="Asignar Ing" class="<?= $none ?>">
												<a class="btn btn-cafe btn-sm" data-bs-toggle="modal" data-bs-target="#modal_asignar_<?= $id ?>">
													<i class="fas fa-user"></i>
												</a>
											</span>

											<span data-bs-toggle="tooltip" data-placement="top" title="Editar" class="<?= $none ?>">
												<a class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal_editar<?= $id ?>">
													<i class="fas fa-pen-alt"></i>
												</a>
											</span>
											
											<span data-bs-toggle="tooltip" data-placement="top" title="Detalle">
												<a class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modal_detalle<?= $id ?>">
													<i class="fas fa-info-circle"></i>
												</a>
											</span>

											<span data-bs-toggle="tooltip" data-placement="top" title="Eliminar" class="ocultar_detalle <?= $none ?>">
												<a class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modal<?= $id ?>">
													<i class="fas fa-trash-alt" ></i>
												</a>
											</span>

											<?php if($content->estado=="6"){ ?>
												<button type="button" class="btn btn-sm btn-azul2" data-bs-toggle="tooltip" data-placement="top" title="Aprobar proyecto" onclick="aprobar1('<?php echo $id; ?>');"><i class="far fa-thumbs-up "></i></button>
											<?php } ?>
										</div>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>

					<?php foreach($this->lists as $content){ ?>
					<?php $id =  $content->id; ?>

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
										<a class="btn btn-danger" href="<?php echo $this->route;?>/delete?id=<?= $id ?>&csrf=<?= $this->csrf;?>&csrf_section=<?= $this->csrf_section;?><?php echo ''; ?>" >Eliminar</a>
								</div>
								</div>
							</div>
						</div>
						
						<!-- Modal Asignar -->
						<div class="modal modal-lg fade text-start" id="modal_asignar_<?= $id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<form method="POST" action="<?php echo $this->route;?>/asignar">
										<div class="modal-body">
											<div class="row">
												<div class="col-lg-12">
													<div class="caja_azul">
														<div class="d-flex justify-content-between align-items-center h-100">
															<b class="titulo_dashboard"><i class="fa-solid fa-user-plus"></i> Asignar Ingeniero a Proyecto</b>
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
																	<button id="add-row" class="btn btn-primary btn-sm" type="button">
																		<i class="fas fa-plus"></i>
																	</button>
																</td>
															</tr>
														</thead>
														<tbody id="table-body">
															<tr>
																<td>
																	<div class="input-group">
																		<select class="form-select" name="proyectosing_user[]" id="proyectosing_user">
																			<option value="">Seleccione...</option>
																			<?php foreach ($this->lista_ingenieros AS $key => $value ){?>
																				<option value="<?php echo $key; ?>"><?= $value; ?></option>
																			<?php } ?>
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

												<input type="hidden" name="id" value="<?= $id ?>">
												<input type="hidden" name="csrf" value="<?= $this->csrf ?>">
												<input type="hidden" name="csrf_section" value="<?= $this->csrf_section ?>">

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

						<!-- Modal Editar-->
						<div class="modal fade text-start" id="modal_editar<?= $id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
							<div class="modal-dialog modal-md" role="document">
								<div class="modal-content">
									<form class="text-start" enctype="multipart/form-data" method="post" action="/page/proyectosd/update">
										<div class="modal-body">
											<div class="row">
												<div class="col-lg-12">
													<div class="caja_azul">
														<div class="d-flex justify-content-between align-items-center h-100">
															<b class="titulo_dashboard"><i class="fa-solid fa-diagram-project icon-dash"></i> Editar proyecto</b>
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
														<select class="form-select" name="cliente_id">
															<option value="">Cliente...</option>
															<?php foreach ($this->list_cliente_id AS $key => $value ){?>
																<option <?php if($this->getObjectVariable($content,"cliente_id") == $key ){ echo "selected"; }?> value="<?php echo $key; ?>" /> <?= $value; ?></option>
															<?php } ?>
														</select>
													</div>
													<div class="help-block with-errors"></div>
												</div>

												<div class="col-lg-12 mb-3">
													<div class="input-group">
														<input type="text" value="<?= $content->nombre; ?>" name="nombre" id="nombre" class="form-control" placeholder="Nombre del proyecto">
													</div>
													<div class="help-block with-errors"></div>
												</div>
												<div class="col-lg-12 mb-3">
													<div class="input-group">
														<select class="form-select" name="tipo">
															<option value="">Tipo de proyecto</option>
															<?php foreach ($this->list_tipo AS $key => $value ){?>
																<option <?php if($this->getObjectVariable($content,"tipo") == $key ){ echo "selected"; }?> value="<?php echo $key; ?>"> <?= $value; ?></option>
															<?php } ?>
														</select>
													</div>
													<div class="help-block with-errors"></div>
												</div>
												<div class="col-lg-12 mb-3">
													<div class="input-group">
														<input type="text" value="<?php if($content->valor!=""){ echo formato_pesos($content->valor); } ?>" name="valor" id="valor" class="form-control" onchange="puntitos(this)" onkeyup="puntitos(this)" placeholder="Valor del proyecto">
													</div>
													<div class="help-block with-errors"></div>
												</div>

												<div class="col-lg-12 mb-3">
													<div class="input-group">
														<select class="form-select" name="estado">
															<option value="">Estado del proyecto</option>
															<?php foreach ($this->list_estado AS $key => $value ){?>
																<option <?php if($this->getObjectVariable($content,"estado") == $key ){ echo "selected"; }?> value="<?php echo $key; ?>" /> <?= $value; ?></option>
															<?php } ?>
														</select>
													</div>
													<div class="help-block with-errors"></div>
												</div>
												<div class="col-lg-12 mb-3">
													<div class="d-flex justify-content-between">
														<input type="file" name="documento1" id="documento1" class="form-control  file-document" data-buttonName="btn-primary" onchange="validardocumento('documento1');" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint, text/plain, application/pdf,image/*" >
														<?php if($content->documento1!=""){ ?>
															<a href="/images/<?php echo $content->documento1; ?>" target="_blank" class="btn btn-primary btn-sm ms-1"><i class="fas fa-file-download"></i></a>
														<?php } ?>
													</div>
												</div>
												<div class="col-lg-12 mb-3">
													<div class="d-flex justify-content-between">
														<input type="file" name="documento2" id="documento2" class="form-control  file-document" data-buttonName="btn-primary" onchange="validardocumento('documento2');" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint, text/plain, application/pdf,image/*" >
														<?php if($content->documento2!=""){ ?>
															<a href="/images/<?php echo $content->documento2; ?>" target="_blank" class="btn btn-primary btn-sm ms-1"><i class="fas fa-file-download"></i></a>
														<?php } ?>
													</div>
												</div>
												<div class="col-lg-12 mb-3">
													<div class="d-flex justify-content-between">
														<input type="file" name="documento3" id="documento3" class="form-control  file-document" data-buttonName="btn-primary" onchange="validardocumento('documento3');" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint, text/plain, application/pdf,image/*" >
														<?php if($content->documento3!=""){ ?>
															<a href="/images/<?php echo $content->documento3; ?>" target="_blank" class="btn btn-primary btn-sm ms-1"><i class="fas fa-file-download"></i></a>
														<?php } ?>
													</div>
												</div>

												<input type="hidden" name="id" value="<?= $content->id ?>">
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

						<!-- Modal Editar-->
						<div class="modal fade text-start" id="modal_detalle<?= $id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
							<div class="modal-dialog modal-md" role="document">
								<div class="modal-content">
									<div class="modal-body">
										<div class="row">
											<div class="col-lg-12">
												<div class="caja_azul">
													<div class="d-flex justify-content-between align-items-center h-100">
														<b class="titulo_dashboard"><i class="fa-solid fa-diagram-project icon-dash"></i> Detalle del proyecto</b>
														<div class="me-2">
															<button type="button" class="close btn-cerrar-modal" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row px-3">
											<div class="col-lg-12 mt-3 mb-3">
												<span class="detail-modal"></span>
											</div>
											<div class="col-lg-12 mb-3">
												<div class="input-group">
													<select class="form-select" name="cliente_id" disabled>
														<option value="">Cliente...</option>
														<?php foreach ($this->list_cliente_id AS $key => $value ){?>
															<option <?php if($this->getObjectVariable($content,"cliente_id") == $key ){ echo "selected"; }?> value="<?php echo $key; ?>" /> <?= $value; ?></option>
														<?php } ?>
													</select>
												</div>
												<div class="help-block with-errors"></div>
											</div>

											<div class="col-lg-12 mb-3">
												<div class="input-group">
													<input type="text" value="<?= $content->nombre; ?>" name="nombre" id="nombre" class="form-control" placeholder="Nombre del proyecto" disabled>
												</div>
												<div class="help-block with-errors"></div>
											</div>
											<div class="col-lg-12 mb-3">
												<div class="input-group">
													<select class="form-select" name="tipo" disabled>
														<option value="">Tipo de proyecto</option>
														<?php foreach ($this->list_tipo AS $key => $value ){?>
															<option <?php if($this->getObjectVariable($content,"tipo") == $key ){ echo "selected"; }?> value="<?php echo $key; ?>"> <?= $value; ?></option>
														<?php } ?>
													</select>
												</div>
												<div class="help-block with-errors"></div>
											</div>
											<div class="col-lg-12 mb-3 <?= $none ?>">
												<div class="input-group">
													<input type="text"  disabled value="<?php if($content->valor!=""){ echo formato_pesos($content->valor); } ?>" name="valor" id="valor" class="form-control" onchange="puntitos(this)" onkeyup="puntitos(this)" placeholder="Valor del proyecto">
												</div>
												<div class="help-block with-errors"></div>
											</div>

											<div class="col-lg-12 mb-3">
												<div class="input-group">
													<select class="form-select" name="estado" disabled>
														<option value="">Estado del proyecto</option>
														<?php foreach ($this->list_estado AS $key => $value ){?>
															<option <?php if($this->getObjectVariable($content,"estado") == $key ){ echo "selected"; }?> value="<?php echo $key; ?>" /> <?= $value; ?></option>
														<?php } ?>
													</select>
												</div>
												<div class="help-block with-errors"></div>
											</div>
											<div class="col-lg-12 mb-3">
												<div class="d-flex justify-content-between">
													<?php if($content->documento1!=""){ ?>
														<a href="/images/<?php echo $content->documento1; ?>" target="_blank" class="btn btn-primary btn-sm ms-1"><i class="fas fa-file-download"></i></a>
													<?php } ?>
												</div>
											</div>
											<div class="col-lg-12 mb-3">
												<div class="d-flex justify-content-between">
													<?php if($content->documento2!=""){ ?>
														<a href="/images/<?php echo $content->documento2; ?>" target="_blank" class="btn btn-primary btn-sm ms-1"><i class="fas fa-file-download"></i></a>
													<?php } ?>
												</div>
											</div>
											<div class="col-lg-12 mb-3">
												<div class="d-flex justify-content-between">
													<?php if($content->documento3!=""){ ?>
														<a href="/images/<?php echo $content->documento3; ?>" target="_blank" class="btn btn-primary btn-sm ms-1"><i class="fas fa-file-download"></i></a>
													<?php } ?>
												</div>
											</div>

											<div class="col-lg-12 text-center mt-3">
												<div class="btn-modal-footer d-grid gap-2">
													<a class="w-100" data-bs-dismiss="modal">Cancelar</a>
												</div>
											</div>

										</div>
									</div>
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
	                echo '<li class="page-item" ><a class="page-link"  href="'.$url.'?page='.($this->page-1).'&detalle='.$_GET['detalle'].'"> &laquo; Anterior </a></li>';
	            for ($i=1;$i<=$this->totalpages;$i++) {
	                if ($this->page == $i)
	                    echo '<li class="active page-item"><a class="page-link">'.$this->page.'</a></li>';
	                else
	                    echo '<li class="page-item"><a class="page-link" href="'.$url.'?page='.$i.'&detalle='.$_GET['detalle'].'">'.$i.'</a></li>  ';
	            }
	            if ($this->page != $this->totalpages)
	                echo '<li class="page-item"><a class="page-link" href="'.$url.'?page='.($this->page+1).'&detalle='.$_GET['detalle'].'">Siguiente &raquo;</a></li>';
	        }
	  	?>
	  	</ul>
	</div>
</div>



<!-- Modal -->
<div class="modal fade text-start" id="modal_pdf" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  	<div class="modal-dialog modal-lg" role="document">
    	<div class="modal-content ">
      		<div class="modal-header">
			  <button type="button" class="close btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      	</div>
      	<div class="modal-body">
      			<iframe id="iframe_pdf" src="about:blank" width="100%" height="500"></iframe>
      	</div>

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
						<b class="titulo_dashboard"><i class="fa-solid fa-business-time icon-dash"></i> Seguimientos</b>
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



<script type="text/javascript">
	function aprobar1(id){
		var titulo = $("#titulo_proyecto"+id).val();
		var x = confirm("Quiere aprobar el proyecto: "+titulo+"?");
		if(x===true){
			window.location="/page/proyectos/aprobar/?id="+id+"&r=index";
		}
	}
	
	function terminar(id,cliente){
		var titulo = $("#titulo_proyecto"+id).val();
		var x = confirm("Esta seguro de terminar el proyecto: "+titulo+"? ");
		if(x===true){
			window.location="/page/view/terminar?id="+id+"&cliente="+cliente+"&proyecto="+id+"&hastw=1";
		}
	}
</script>

<script>
    $(document).ready(function() {
        $('#add-row').on('click', function() {
            var newRow = `
                <tr>
					<td>
						<div class="input-group">
							<select class="form-select" name="proyectosing_user[]" id="proyectosing_user">
								<option value="">Seleccione...</option>
								<?php foreach ($this->lista_ingenieros AS $key => $value ){?>
									<option value="<?php echo $key; ?>"><?= $value; ?></option>
								<?php } ?>
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
            $('#table-body').append(newRow);
        });

        // Función para eliminar una fila
        $('#table-body').on('click', '.btn-delete', function() {
            $(this).closest('tr').remove();
        });
    });
</script>