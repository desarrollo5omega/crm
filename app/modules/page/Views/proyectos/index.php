
<style>
	  .modal-lg, .modal-xl {
	    max-width: 80%;
	  }	
</style>

<h1 class="titulo-principal ocultar_detalle"><i class="fas fa-list-alt"></i> <?php echo $this->titlesection; ?></h1>
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
							<label>Cliente</label>
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
							<label>Nombre</label>
							<div class="input-group">
								<span class="input-group-text input-icono fondo-rojo-claro " ><i class="fas fa-pencil-alt"></i></span>
								<input type="text" class="form-control" name="nombre" value="<?php echo $this->getObjectVariable($this->filters, 'nombre') ?>"></input>
							</div>
						</div>
						<div class="col-12 col-lg-2 col-md-2 mb-3 ocultar_detalle">
							<label>Tipo</label>
							<div class="input-group">
								<span class="input-group-text input-icono fondo-cafe " ><i class="far fa-list-alt"></i></span>
								<select class="form-select" name="tipo">
									<option value="">Todos</option>
									<?php foreach ($this->list_tipo as $key => $value) : ?>
										<option value="<?= $key; ?>" <?php if ($this->getObjectVariable($this->filters, 'tipo') ==  $key) { echo "selected";} ?>><?= $value; ?></option>
									<?php endforeach ?>
								</select>
							</div>
						</div>
						<div class="col d-none ocultar_detalle">
							<label>Valor</label>
							<div class="input-group">
								<span class="input-group-text input-icono fondo-morado " ><i class="fas fa-pencil-alt"></i></span>
								<input type="text" class="form-control" name="valor" value="<?php echo $this->getObjectVariable($this->filters, 'valor') ?>"></input>
							</div>
						</div>
						<div class="col-12 col-lg-2 col-md-2 mb-3">
							<label>Estado</label>
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
							<label>Fecha creación</label>
							<div class="input-group">
								<span class="input-group-text input-icono fondo-azul " ><i class="fas fa-pencil-alt"></i></span>
								<input type="text" class="form-control" name="fecha_c" value="<?php echo $this->getObjectVariable($this->filters, 'fecha_c') ?>"></input>
							</div>
						</div>	            
						<div class="col">
							<label>&nbsp;</label>
							<button type="submit" class="btn w-100 btn-azul"> <i class="fas fa-filter"></i> Filtrar</button>
						</div>
						<div class="col">
							<label>&nbsp;</label>
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
									<a class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modal_crear_cotizacion">
										<i class="fas fa-plus-square" data-bs-toggle="tooltip" data-placement="top" title="Crear nuevo"></i> Crear Nuevo
									</a>
								</div>

								<div class="modal fade text-start" id="modal_crear_cotizacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
									<div class="modal-dialog modal-md" role="document">
										<div class="modal-content">
											<form class="text-start" enctype="multipart/form-data" method="post" action="/page/proyectos/insert">
												<div class="modal-body">
													<div class="row">
														<div class="col-lg-12">
															<div class="caja_azul">
																<div class="d-flex justify-content-between align-items-center h-100">
																	<b class="titulo_dashboard"><i class="fa-solid fa-barcode icon-dash"></i> Crear nueva cotización</b>
																	<div class="me-2">
																		<button type="button" class="close btn-cerrar-modal" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div class="row px-3">
														<div class="col-lg-12 mt-3 mb-3">
															<span class="detail-modal">Por favor ingrese los datos de la cotización.</span><br>
															<span class="detail-modal"><div class="card-title">Cotizacion No. <?= $this->ultimo + 1 ?></div></span>
														</div>
														<div class="col-lg-12 mb-3">
															<div class="input-group">
																<select class="form-select" name="cliente_id" required>
																	<option value="">Cliente</option>
																	<?php foreach ($this->list_cliente_id AS $key => $value ){?>
																		<option value="<?php echo $key; ?>"> <?= $value; ?></option>
																	<?php } ?>
																</select>
															</div>
															<div class="help-block with-errors"></div>
														</div>
														<div class="col-lg-12 mb-3">
															<div class="input-group">
																<input type="text" name="nombre" id="nombre" class="form-control" required minlength="3" placeholder="Nombre de la cotización">
															</div>
															<div class="help-block with-errors"></div>
														</div>				
														<div class="col-lg-12 mb-3">
															<div class="input-group">
																<input type="text" name="valor" id="valor" class="form-control" onchange="puntitos(this)" onkeyup="puntitos(this)" required minlength="3" placeholder="Valor de la cotización">
															</div>
															<div class="help-block with-errors"></div>
														</div>
														<div class="col-lg-6 mb-3">
															<div class="input-group">
																<select class="form-select" name="tipo" required>
																	<option value="">Tipo de cotización</option>
																	<?php foreach ($this->list_tipo AS $key => $value ){?>
																		<option value="<?php echo $key; ?>"> <?= $value; ?></option>
																	<?php } ?>
																</select>
															</div>
															<div class="help-block with-errors"></div>
														</div>
														<div class="col-lg-6 mb-3">
															<div class="input-group">
																<select class="form-select" name="estado" required>
																	<option value="">Estado de la cotización</option>
																	<?php foreach ($this->list_estado AS $key => $value ){?>
																		<option value="<?php echo $key; ?>"> <?= $value; ?></option>
																	<?php } ?>
																</select>
															</div>
															<div class="help-block with-errors"></div>
														</div>
														<div class="col-lg-12 mb-3">
															<label for="documento1" class="form-label">Cotización o documento</label>
															<input type="file" name="documento1" id="documento1" class="form-control  file-document" data-buttonName="btn-primary" onchange="validardocumento('documento1');" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint, text/plain, application/pdf,image/*" >

															<div class="help-block with-errors"></div>
														</div>
														<div class="col-lg-12 mb-3">
															<label for="documento2" class="form-label">Cotización o documento</label>
															<input type="file" name="documento2" id="documento2" class="form-control  file-document" data-buttonName="btn-primary" onchange="validardocumento('documento2');" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint, text/plain, application/pdf,image/*" >

															<div class="help-block with-errors"></div>
														</div>
														<div class="col-lg-12 mb-3">
															<label for="documento3" class="form-label">Cotización o documento</label>
															<input type="file" name="documento3" id="documento3" class="form-control  file-document" data-buttonName="btn-primary" onchange="validardocumento('documento3');" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint, text/plain, application/pdf,image/*" >

															<div class="help-block with-errors"></div>
														</div>

														<div class="col-lg-12 text-center mt-3">
															<div class="btn-modal-footer d-grid gap-2">
																<button class="btn w-100" type="submit">Guardar</button>
																<a class="w-100" data-bs-dismiss="modal">Cancelar</a>
															</div>
														</div>
														<input type="hidden" name="consecutivo" value="<?= $this->ultimo + 1 ?>">
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
								<td class="no_cel"><b>No.</b></td>
								<td class="no_cel"><b>Fecha creación</b></td>
								<td width="40%"><b>Nombre</b></td>
								<td class="no_cel"><b>Valor</b></td>
								<td><b>Cliente</b></td>
								<td><b>Estado</b></td>
								<td class="no_cel" style="min-width: 180px;"></td>
							</tr>
						</thead>
						<tbody>
							<?php foreach($this->lists as $content){ ?>
							<?php $id =  $content->id; ?>
								<tr>
									<td class="no_cel"><?= $content->consecutivo; ?></td>
									<td class="no_cel"><?= formatoDMYH($content->fecha_c);?></td>
									<td><?=$content->nombre;?></td>
				
									<td class="no_cel">$ <?=formato_pesos($content->valor);?></td>
									<td><?= $this->list_cliente_id[$content->cliente_id];?></td>
									<td><?= $this->list_estado[$content->estado] ?></td>
						
						
									<td class="text-end table-options-no-responsive">
										<div class="">
											
											<span data-bs-toggle="tooltip" data-placement="top" title="Editar">
												<a class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal_editar<?= $id ?>"><i class="fas fa-pen-alt"></i></a>
											</span>
											<span data-bs-toggle="tooltip" data-placement="top" title="Detalle">
												<a class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modal_detalle<?= $id ?>"><i class="fas fa-info-circle"></i></a>
											</span>
											<span data-bs-toggle="tooltip" data-placement="top" title="Seguimientos">
												<a class="btn btn-secondary btn-sm " data-bs-toggle="modal" data-bs-target="#modal_seguimientos" onclick="document.getElementById('iframe_seguimientos').src='/page/seguimientoproyecto/?proyecto=<?= $id ?>&detalle=1&cleanfilter=1&page=1'; $('#header_seguimiento').html('Cliente: <?= $this->list_cliente_id[$content->cliente_id];?><br>Proyecto: <?php echo $content->nombre; ?>'); " ><i class="far fa-comment-dots"></i></a>
											</span>
											<?php if($content->estado=="6"){ ?>
												<span data-bs-toggle="tooltip" data-bs-placement="top" title="Validar">
													<a class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#validar<?= $id ?>"><i class="fas fa-check"></i></a>
												</span>
											<?php } ?>
											<a class="btn btn-cafe btn-sm" href="<?php echo $this->route;?>/notificar?cotizacion=<?= $id ?>" target="_top" data-bs-toggle="tooltip" data-placement="top" title="Enviar Cotización">
												<i class="fa fa-envelope" aria-hidden="true"></i>
											</a>
											<span data-bs-toggle="tooltip" data-placement="top" title="Eliminar" class="ocultar_detalle">
												<a class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modal<?= $id ?>"><i class="fas fa-trash-alt" ></i></a>
											</span>
											<input id="titulo_proyecto<?php echo $id; ?>" value="<?php echo $content->nombre;?> (<?= $this->list_cliente_id[$content->cliente_id];?>)" type="hidden" />
											<input id="cliente_proyecto<?php echo $id; ?>" value="<?= $content->cliente_id ?>" type="hidden" />

										</div>
									</td>
								</tr>
								<tr class="table-options-responsive">
									<td colspan="11" class="text-end">
										<div class="">
											
											<span data-bs-toggle="tooltip" data-placement="top" title="Editar">
												<a class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal_editar<?= $id ?>"><i class="fas fa-pen-alt"></i></a>
											</span>
											<span data-bs-toggle="tooltip" data-placement="top" title="Detalle">
												<a class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modal_detalle<?= $id ?>"><i class="fas fa-info-circle"></i></a>
											</span>
											<span data-bs-toggle="tooltip" data-placement="top" title="Seguimientos">
												<a class="btn btn-secondary btn-sm " data-bs-toggle="modal" data-bs-target="#modal_seguimientos" onclick="document.getElementById('iframe_seguimientos').src='/page/seguimientoproyecto/?proyecto=<?= $id ?>&detalle=1&cleanfilter=1&page=1'; $('#header_seguimiento').html('Cliente: <?= $this->list_cliente_id[$content->cliente_id];?><br>Proyecto: <?php echo $content->nombre; ?>'); " ><i class="far fa-comment-dots"></i></a>
											</span>
											<?php if($content->estado=="6"){ ?>
												<span data-bs-toggle="tooltip" data-bs-placement="top" title="Validar">
													<a class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#validar<?= $id ?>"><i class="fas fa-check"></i></a>
												</span>
											<?php } ?>
											<a class="btn btn-cafe btn-sm" href="<?php echo $this->route;?>/notificar?cotizacion=<?= $id ?>" target="_top" data-bs-toggle="tooltip" data-placement="top" title="Enviar Cotización">
												<i class="fa fa-envelope" aria-hidden="true"></i>
											</a>
											<span data-bs-toggle="tooltip" data-placement="top" title="Eliminar" class="ocultar_detalle">
												<a class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modal<?= $id ?>"><i class="fas fa-trash-alt" ></i></a>
											</span>
											<input id="titulo_proyecto<?php echo $id; ?>" value="<?php echo $content->nombre;?> (<?= $this->list_cliente_id[$content->cliente_id];?>)" type="hidden" />
											<input id="cliente_proyecto<?php echo $id; ?>" value="<?= $content->cliente_id ?>" type="hidden" />

										</div>
									</td>		
								</tr>
								<!-- Modal editar -->
								<div class="modal fade text-start" id="modal_editar<?= $id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
									<div class="modal-dialog modal-md" role="document">
										<div class="modal-content">
											<form class="text-start" enctype="multipart/form-data" method="post" action="/page/proyectos/update">
												<div class="modal-body">
													<div class="row">
														<div class="col-lg-12">
															<div class="caja_azul">
																<div class="d-flex justify-content-between align-items-center h-100">
																	<b class="titulo_dashboard"><i class="fa-solid fa-barcode icon-dash"></i> Editar cotización</b>
																	<div class="me-2">
																		<button type="button" class="close btn-cerrar-modal" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div class="row px-3">
														<div class="col-lg-12 mt-3 mb-3">
															<span class="detail-modal">Por favor ingrese los datos de la cotización.</span><br>
															<span class="detail-modal"><div class="card-title">Cotizacion No. <?= $content->consecutivo ?></div></span>
														</div>
														<div class="col-lg-12 mb-3">
															<div class="input-group">
																<select class="form-select" disabled>
																	<option value="">Cliente</option>
																	<?php foreach ($this->list_cliente_id AS $key => $value ){?>
																		<option value="<?php echo $key; ?>" <?php if ($content->cliente_id == $key) { echo "selected"; } ?>> <?= $value; ?></option>
																	<?php } ?>
																</select>
																<input type="hidden" name="cliente_id" value="<?= $content->cliente_id; ?>">
															</div>
															<div class="help-block with-errors"></div>
														</div>
														<div class="col-lg-12 mb-3">
															<div class="input-group">
																<input type="text" value="<?= $content->nombre ?>" name="nombre" id="nombre" class="form-control" required minlength="3" placeholder="Nombre de la cotización">
															</div>
															<div class="help-block with-errors"></div>
														</div>				
														<div class="col-lg-12 mb-3">
															<div class="input-group">
																<input type="text" value="<?= $content->valor ?>"  name="valor" id="valor" class="form-control" onchange="puntitos(this)" onkeyup="puntitos(this)" required minlength="3" placeholder="Valor de la cotización">
															</div>
															<div class="help-block with-errors"></div>
														</div>
														<div class="col-lg-6 mb-3">
															<div class="input-group">
																<select class="form-select" name="tipo" required>
																	<option value="">Tipo de cotización</option>
																	<?php foreach ($this->list_tipo AS $key => $value ){?>
																		<option value="<?php echo $key; ?>" <?php if ($content->tipo == $key) { echo "selected"; } ?> > <?= $value; ?> </option>
																	<?php } ?>
																</select>
															</div>
															<div class="help-block with-errors"></div>
														</div>
														<div class="col-lg-6 mb-3">
															<div class="input-group">
																<select class="form-select" name="estado" required>
																	<option value="">Estado de la cotización</option>
																	<?php foreach ($this->list_estado AS $key => $value ){?>
																		<option value="<?php echo $key; ?>" <?php if ($content->estado == $key) { echo "selected"; } ?> > <?= $value; ?></option>
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

														<div class="col-lg-12 text-center mt-3">
															<div class="btn-modal-footer d-grid gap-2">
																<button class="btn w-100" type="submit">Guardar</button>
																<a class="w-100" data-bs-dismiss="modal">Cancelar</a>
															</div>
														</div>

														<input type="hidden" name="hash" value="1">
														<input type="hidden" name="id" value="<?= $content->id ?>">
														<input type="hidden" name="csrf" id="csrf" value="<?php echo $this->csrf ?>">
														<input type="hidden" name="csrf_section" id="csrf_section" value="<?php echo $this->csrf_section ?>">
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
												<button type="button" class="btn btn-default" data-bs-dismiss="modal">Cancelar</button>
												<a class="btn btn-danger" href="<?php echo $this->route;?>/delete?id=<?= $id ?>&csrf=<?= $this->csrf;?><?php echo ''; ?>" >Eliminar</a>
										</div>
										</div>
									</div>
								</div>

								<!-- Modal Validar-->
								<div class="modal fade text-start" id="validar<?= $id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-body">
												<div class="row">
													<div class="col-lg-12">
														<div class="caja_azul">
															<div class="d-flex justify-content-between align-items-center h-100">
																<b class="titulo_dashboard"><i class="fa-solid fa-clipboard-check"></i> Aprobación Proyecto</b>
																<div class="me-2">
																	<button type="button" class="close btn-cerrar-modal" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="row px-3">
													<div class="col-lg-12 mt-3 mb-3">
														<span class="detail-modal"><b>Proyecto: </b> <?=$content->nombre;?></span><br>
														<span class="detail-modal"><b>Tipo: </b> <?= $this->list_tipo[$content->tipo];?></span><br>
														<span class="detail-modal"><b>Cliente: </b> <?= $this->list_cliente_id[$content->cliente_id];?></span><br>
														<span class="detail-modal"><b>Valor: </b> $ <?php echo formato_pesos($content->valor); ?></span><br>
													</div>

													<span class="detail-modal mt-3"><div class="card-title">Cotizacion No. <?= $content->consecutivo ?></div></span>

													<div class="container">
														<div class="row">
															<div class="col-12 mb-3 mt-3">
																<div class="row">
																	<div class="col-12 mb-3">
																		<label class="input-group">
																			<input type="text" class="form-control" id="comentarios_aprueba_<?= $id ?>" placeholder="Comentarios para administración"/>
																		</label>
																	</div>
																	<div class="col-12 mb-3">
																		<label class="input-group">
																			<input type="text" class="form-control" id="comentarios_admin_<?= $id ?>" placeholder="Comentarios para proyectos" />
																		</label>
																	</div>
																</div>
															</div>

															<div class="col-lg-12 text-center mt-3">
																<div class="btn-modal-footer d-grid gap-2">
																	<button class="btn btn-guardar w-100" type="button" onclick="aprobar('<?php echo $id; ?>');" id="btn_aprobar_<?= $id ?>">Aprobar</button>
																	<a class="w-100" onclick="no_aprobar('<?php echo $id; ?>');" id="btn_noaprobar_<?= $id ?>">No Aprobar</a>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>


								<!-- Modal -->
								<div class="modal fade text-start" id="modal_detalle<?= $id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
									<div class="modal-dialog modal-md" role="document">
										<div class="modal-content">
											<div class="modal-body">
												<div class="row">
													<div class="col-lg-12">
														<div class="caja_azul">
															<div class="d-flex justify-content-between align-items-center h-100">
																<b class="titulo_dashboard"><i class="fa-solid fa-barcode icon-dash"></i> Ver cotización</b>
																<div class="me-2">
																	<button type="button" class="close btn-cerrar-modal" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="row px-3">
													<div class="col-lg-12 mt-3 mb-3">
														<span class="detail-modal"><div class="card-title">Cotizacion No. <?= $content->consecutivo ?></div></span>
													</div>
													<div class="col-lg-12 mb-3">
														<div class="input-group">
															<select class="form-select" disabled>
																<option value="">Cliente</option>
																<?php foreach ($this->list_cliente_id AS $key => $value ){?>
																	<option value="<?php echo $key; ?>" <?php if ($content->cliente_id == $key) { echo "selected"; } ?>> <?= $value; ?></option>
																<?php } ?>
															</select>
															<input type="hidden" name="cliente_id" value="<?= $content->cliente_id; ?>">
														</div>
														<div class="help-block with-errors"></div>
													</div>
													<div class="col-lg-12 mb-3">
														<div class="input-group">
															<input type="text" disabled value="<?= $content->nombre ?>" name="nombre" id="nombre" class="form-control" required minlength="3" placeholder="Nombre de la cotización">
														</div>
														<div class="help-block with-errors"></div>
													</div>				
													<div class="col-lg-12 mb-3">
														<div class="input-group">
															<input type="text" disabled value="<?= $content->valor ?>"  name="valor" id="valor" class="form-control" onchange="puntitos(this)" onkeyup="puntitos(this)" required minlength="3" placeholder="Valor de la cotización">
														</div>
														<div class="help-block with-errors"></div>
													</div>
													<div class="col-lg-6 mb-3">
														<div class="input-group">
															<select class="form-select" name="tipo" disabled>
																<option value="">Tipo de cotización</option>
																<?php foreach ($this->list_tipo AS $key => $value ){?>
																	<option value="<?php echo $key; ?>" <?php if ($content->tipo == $key) { echo "selected"; } ?> > <?= $value; ?> </option>
																<?php } ?>
															</select>
														</div>
														<div class="help-block with-errors"></div>
													</div>
													<div class="col-lg-6 mb-3">
														<div class="input-group">
															<select class="form-select" name="estado" disabled>
																<option value="">Estado de la cotización</option>
																<?php foreach ($this->list_estado AS $key => $value ){?>
																	<option value="<?php echo $key; ?>" <?php if ($content->estado == $key) { echo "selected"; } ?> > <?= $value; ?></option>
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

function aprobar(id){

	var titulo = $("#titulo_proyecto"+id).val();
	var caprueba = $("#comentarios_aprueba_"+id).val();
	var cadmin = $("#comentarios_admin_"+id).val();
	var cliente = $("#cliente_proyecto"+id).val();

	$("#btn_aprobar_"+id).prop("disabled", true);
	$("#btn_noaprobar_"+id).prop("disabled", true);

	var x = confirm("Quiere aprobar el proyecto: "+titulo+" ?");

	if(x===true){
		
		$.post("/page/proyectos/aprobar/", {
			"id": id,
			"r": "dashboard",
			"caprueba" : caprueba,
			"cadmin" : cadmin
		}, function(res) {
			
		});
		
		window.location='/page/proyectos/dirigir?cliente='+cliente+'&r=aprobacion';
	}
}

function no_aprobar(id){

	var titulo = $("#titulo_proyecto"+id).val();
	var cliente = $("#cliente_proyecto"+id).val();

	$("#btn_aprobar_"+id).prop("disabled", true);
	$("#btn_noaprobar_"+id).prop("disabled", true);

	var x = confirm("Esta seguro de no aprobar el proyecto: "+titulo+" ?");
	if(x===true){
		window.location="/page/proyectos/noaprobar/?id="+id+"&r=index&cliente="+cliente;
	}
}
</script>