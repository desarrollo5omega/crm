<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    #myPieChart {
        height: 350px !important;
        width: 350px !important;
        margin: auto;
    }
</style>

<?php
	function getCalcDate($date) {
		
		$hoy = date("Y-m-d");

		$tms_actual = strtotime($hoy);
		$tms_obj = strtotime($date);

		$dif = ($tms_obj - $tms_actual) / (60 * 60 * 24);

		if ($dif < 0 ) {
			// Si ya se paso - Rojo
			$html = '<div class="progress">
						<div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
					</div>';
		} elseif ($dif <= 5 ) {
			// Si faltan 5 dias o menos - Amarillo	
			$html = '<div class="progress">
						<div class="progress-bar progress-bar-striped bg-warning" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
					</div>';
		} else {
			// Si faltan mas de 5 dias
			$html = '<div class="progress">
						<div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
					</div>';
		}

		return $html;
	}
	
	if ($this->level == 1 || $this->level == 2) {
		
	}
	if ($this->level == 3) { // Proyectos
		$mod_finanzas = "d-none";
		$mod_cotizaciones = "d-none";
		$mod_proximas = "d-none";
	}
	if ($this->level == 4) { // Administrativo
		$mod_finanzas = "d-none";
		$mod_proximas = "d-none";
		$mod_proyectos = "d-none";
	}
?>



<style>
  .modal-lg, .modal-xl {
    max-width: 80%;
  }

  .pestana_activa{
-webkit-box-shadow: 0px 6px 5px 0px rgba(0,0,0,0.60);
-moz-box-shadow: 0px 6px 5px 0px rgba(0,0,0,0.60);
box-shadow: 0px 6px 5px 0px rgba(0,0,0,0.60);
  }

.btn-primary.focus, .btn-primary:focus {
  box-shadow: 0px 6px 5px 0px rgba(0,0,0,0.60);
}

.div_registros{
	margin-top: -30px; margin-right:10px;
}
@media only screen and (max-width: 800px) {
	.div_registros{
		margin-top: 0px; margin-right:10px;
	}
}

.caja_azul b{
	vertical-align: super;
}

.content-table .table{
	font-size: 11.5px;
}

</style>

	<div class="container-fluid">

		<div class="row" style="margin-top:-15px">

			<a id="clientes" name="clientes"></a>

			<div class="col-lg-12">

				<div class="row">

					<div class="col-lg-9 col-md-12">

                        <div class="row">
					
							<div class="col-12 col-md-5">

								<div class="mt-4 content-dashboard no-padding">
									
									<div class="caja_azul">
										<div class="d-flex justify-content-between align-items-center h-100">
											<b class="titulo_dashboard"><i class="fa-solid fa-building icon-dash"></i> Clientes</b>
											<div class="gris_claro me-2">
											<span data-bs-toggle="tooltip" data-bs-placement="top" title="Crear nuevo cliente">
												<a class="custom-btn-home" data-bs-toggle="modal" data-bs-target="#modal_crear_cliente">
												<span class="add-button-home lf-part">CREAR</span>
												<span class="rg-part"><i class="fas fa-plus"></i></span>
												</a>
											</span>
											</div>
										</div>
									</div>

									<input type="hidden" id="pagina_inicio" value="0">
									<input type="hidden" id="pagina_fin" value="5">

									<div class="col-lg-12 no-padding">
										<div class="input-group">
											<select class="form-select" id="cliente1" onchange="filtrar_cliente();">
												<option value="" class="text-uppercase">Todos los clientes</option>
												<?php foreach ($this->list_cliente_id as $key => $value) : ?>
													<option value="<?= $key; ?>" <?php if ($_GET['cliente1']==$key) { echo "selected";} ?> class="text-uppercase"><?= $value; ?></option>
												<?php endforeach ?>
											</select>
										</div>
									</div>

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
															<input type="hidden" name="detalle" value="1">

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

									<div class="content-table">
										<div class="tabla-fija-scroll-1">
											<table width="100%" border="0" class="table table-striped">
												<thead>
													<tr>
														<th style="width: 30%;">Nombre empresa</th>
														<th>Teléfono</th>
														<th>Correo</th>
														<th></th>
													</tr>	
												</thead>
												<tbody>					
													<?php foreach($this->clientes as $key => $content){?>
														<?php $id =  $content->id; ?>
														<tr class="div_clientes_mas" id="div_clientes_mas<?php echo $key; ?>" <?php if($key>10){ echo 'style="display:none";'; } ?>>
															<td><?=$content->nombre;?></td>
															<td id="numero_cel"><?=$content->celular;?></td>
															<td><div title="<?=$content->email;?>" style="word-break: break-all"><?=$content->email;?></div></td>

															<td>
																<span data-bs-toggle="tooltip" data-bs-placement="top" title="Detalle">
																	<a class="btn btn-warning btn-sm btn-manage" data-bs-toggle="modal" data-bs-target="#modal_detalle<?= $id ?>" onclick="document.getElementById('iframe_cotizaciones<?php echo $id; ?>').src='/page/proyectos/?cliente=<?php echo $id; ?>&detalle=1&cleanfilter=1&page=1'; document.getElementById('iframe_proyecto<?php echo $id; ?>').src='/page/proyectosd/?cliente=<?php echo $id; ?>&detalle=1&cleanfilter=1&page=1'; document.getElementById('iframe_contacto<?php echo $id; ?>').src='/page/contactos/?cliente=<?php echo $id; ?>&detalle=1&cleanfilter=1&page=1';" >
																		<i class="fa fa-info-circle" aria-hidden="true"></i>
																	</a>
																</span>

															</td>
														</tr>
													<?php } ?>
												</tbody>
											</table>
										</div>
									</div>
									<div class="table-foot py-2 div-thead">
										<div class="d-flex justify-content-between align-items-center">
											<div class="ms-3">
												<button type="button" class="btn btn-viewmore btn-sm" onclick="mas_clientes()">VER MÁS</button>
											</div>
										</div>
									</div>

									<input type="hidden" value="6" id="cantidad_clientes">

								</div>
								<?php if(1==0){ ?>
								<div class="col-lg-12 mt-4 content-dashboard no-padding">
									
										<div class="caja_azul">
											<div class="d-flex justify-content-between align-items-center h-100">
												<b class="titulo_dashboard">Proyectos aprobados por mes</b>
											</div>
										</div>



										<div class="col-lg-12 no-padding d-none">
											<table width="100%" border="1">
												<tr>
													<td><b>Mes</b></td>
													<td align="center"><b>Cantidad</b></td>
												</tr>
												<?php foreach($this->meses as $key => $mes){?>

												<?php
													$i++;
													$calificaciones[$i]=$mes;
													$valores[$i]= (int)$this->total_aprobados[$key];
												?>

												<tr>
													<td><?php echo $mes; ?></td>
													<td align="center"><?php echo (int)$this->total_aprobados[$key]; ?></td>
												</tr>										
												<?php }?>
											</table>
										</div>

										<div class="col-lg-12">

										<script type="text/javascript" src="https://www.google.com/jsapi"></script>
										<script type="text/javascript">
										google.load("visualization", "1", {packages:["corechart"]});
										google.setOnLoadCallback(drawChart);
										function drawChart() {

											var data = google.visualization.arrayToDataTable([
											['Task', 'Aprobados'],

											<?php for($x=0;$x<$i;$x++){?>
											<?php if($valores[$x]>0){ ?>
											[
											'<?php echo $calificaciones[$x]; ?>',<?php echo $valores[$x]; ?>
											],
											<?php }?>
											<?php }//for?>

											]);

											var options = {
											title: '',
											};

											var chart = new google.visualization.ColumnChart(document.getElementById('piechart'));

											chart.draw(data, options);
										}
										</script>

										<div id="piechart" style="height: 400px; max-width: 100%;"></div>	

										</div>

								</div>
								<?php } ?>



							</div>

							<div class="col-lg-7 col-md-12">
								<div class="row">

									<div class="col <?= $mod_cotizaciones ?>">
			
										<a id="proyectos" name="proyectos"></a>
										<div class="col-lg-12 mt-4 content-dashboard no-padding">
										
				
											<div class="caja_azul">
												<div class="d-flex justify-content-between align-items-center h-100">
													<b class="titulo_dashboard"><i class="fa-solid fa-barcode icon-dash"></i> Cotizaciones por aprobar</b>
													<div class="gris_claro me-2">
														<span data-bs-toggle="tooltip" data-placement="top" title="Crear nueva cotización" class="mt-3">
															<a class="custom-btn-home" data-bs-toggle="modal" data-bs-target="#modal_crear_cotizacion">
																<span class="add-button-home lf-part">CREAR</span>
																<span class="rg-part"><i class="fas fa-plus"></i></span>
															</a>
														</span>
													</div>
												</div>
											</div>
			
			
										<div class="col-lg-12 no-padding">
			
											<div class="input-group">
												<select class="form-select" id="cliente2" onchange="filtrar_cliente2();">
													<option value="" class="text-uppercase">Todos los clientes</option>
													<?php foreach ($this->list_cliente_id_cotiza as $key => $value) : ?>
														<option value="<?= $key; ?>" <?php if ($_GET['cliente2']==$key) { echo "selected";} ?> class="text-uppercase"><?= $value; ?></option>
													<?php endforeach ?>
												</select>
											</div>
			
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
																			<option value="" class="text-uppercase">Seleccione cliente</option>
																			<?php foreach ($this->list_cliente_id AS $key => $value ){?>
																				<option value="<?php echo $key; ?>" class="text-uppercase"> <?= $value; ?></option>
																			<?php } ?>
																		</select>
																	</div>
																	<div class="help-block with-errors"></div>
																</div>
																<div class="col-lg-12 mb-3">
																	<div class="input-group">
																		<input type="text" name="nombre" id="nombre" class="form-control" required minlength="3" placeholder="Nombre de la cotización" oninput="this.value = this.value.toUpperCase();">
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

																<input type="hidden" name="detalle" value="1">
																<input type="hidden" name="consecutivo" value="<?= $this->ultimo + 1 ?>">
																<input type="hidden" name="csrf" id="csrf" value="<?php echo $this->csrf ?>">
																<input type="hidden" name="csrf_section" id="csrf_section" value="<?php echo $this->csrf_section ?>">
															</div>
														</div>

													</form>
												</div>
											</div>
										</div>
			
			
										<div class="content-table">
											<div class="tabla-fija-scroll-1">
												<table width="100%" border="0" class="table table-striped">
													<thead>
														<tr>
															<th>Cliente - Nombre proyecto</th>
															<th>Valor</th>
															<th class="icon-2"></th>
														</tr>		
													</thead>				
													<tbody>
														<?php foreach($this->proyectos as $key2 => $content){ ?>
															<?php $id =  $content->id; ?>
															<?php $total_proyectos+=(int)$content->valor; ?>
																<tr id="div_proyectos<?php echo $key2; ?>" <?php if($key2>12){ echo 'style="display:none";'; } ?> >
																	<td><?= $this->list_cliente_id[$content->cliente_id];?> - <?=$content->nombre;?></td>
																	
																	<td>$<?php echo formato_pesos($content->valor); ?></td>
																	<td width="80">
																		<div class="d-flex">
																			<span data-bs-toggle="tooltip" data-placement="top" title="Detalle">
																				<a class="btn btn-warning btn-sm btn-manage me-1" data-bs-toggle="modal" data-bs-target="#modal_detalle_proyecto<?= $id ?>" onclick="document.getElementById('iframe_seguimientos<?= $id ?>').src='/page/seguimientoproyecto/?proyecto=<?= $id ?>&detalle=1&cleanfilter=1&page=1';"  >
																					<i class="fa fa-info-circle" aria-hidden="true"></i>
																				</a>
																			</span>
																			<input id="titulo_proyecto<?php echo $id; ?>" value="<?php echo $content->nombre;?> (<?= $this->list_cliente_id[$content->cliente_id];?>)" type="hidden" />
																			<span data-bs-toggle="tooltip" data-bs-placement="top" title="Validar">
																				<a class="btn btn-info btn-sm btn-manage" data-bs-toggle="modal" data-bs-target="#validar<?= $id ?>"><i class="fas fa-check"></i></a>
																			</span>
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
																								<span class="detail-modal font-detail-modal"><b>Proyecto: </b> <?=$content->nombre;?></span><br>
																								<span class="detail-modal font-detail-modal"><b>Tipo: </b> <?= $this->list_tipo[$content->tipo];?></span><br>
																								<span class="detail-modal font-detail-modal"><b>Cliente: </b> <?= $this->list_cliente_id[$content->cliente_id];?></span><br>
																								<span class="detail-modal font-detail-modal"><b>Valor: </b> $ <?php echo formato_pesos($content->valor); ?></span><br>
																							</div>
			
																							<div class="col-12 mb-3 mt-2">
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
			
																	</td>
																</tr>
														<?php } ?>
													</tbody>
												</table>
											</div>
											<div class="table-foot py-2 div-thead">
												<div class="d-flex justify-content-between align-items-center flex-wrap">
													<!-- Botón VER MÁS -->
													<div class="ms-3">
														<button type="button" class="btn btn-viewmore btn-sm" onclick="mas_proyectos()">VER MÁS</button>
													</div>

													<!-- Total Cotizaciones -->
													<div class="d-flex justify-content-end align-items-center me-3">
														<label class="d-none d-md-block"><b class="b-totales">Total valor cotizaciones: $<?php echo formato_pesos($total_proyectos); ?></b></label>
														<label class="d-block d-md-none"><b class="b-totales">$<?php echo formato_pesos($total_proyectos); ?></b></label>
													</div>
												</div>
											</div>


										</div>
			
										
										<input type="hidden" value="9" id="cantidad_proyectos">
			
									</div>
			
								</div>

								<div class="col-md-12 col-sm-12 mt-4 <?= $mod_finanzas ?> col-aprobados">

									<div class="row no-padding">

										<div class="col-lg-12">

											<div class="caja_azul">
												<div class="d-flex justify-content-between align-items-center h-100">
													<b class="titulo_dashboard"><i class="fa-solid fa-money-bill-trend-up icon-dash"></i> Proyectos aprobados en el mes</b>
												</div>
											</div>

											<div style="border: 0px solid #CCCCCC;">
												
												<?php $keys = array_keys($this->meses); ?>
												<?php foreach($this->meses as $key => $value){ ?>

													<?php
													$anterior = $keys[array_search($key, $keys)-1];
													$siguiente = $keys[array_search($key, $keys)+1];
													?>

													<div align="center" id="mes<?php echo $key; ?>" class="div_aprobados content-table mt-0" <?php if($key != date("m")){ echo 'style="display: none;"'; } ?>>
														
														<div style="margin-top: 6px; margin-bottom: 6px;">
														<a  class="azul_oscuro" style="cursor: pointer;" onclick="ir_a_mes('<?php echo $anterior ?>');"><i class="fas fa-caret-left flechas azul_oscuro"></i></a> <b class="azul_oscuro"><?php echo strtoupper($value); ?></b> <a style="cursor: pointer;" onclick="ir_a_mes('<?php echo $siguiente ?>');"><i class="fas fa-caret-right flechas azul_oscuro"></i></a>

														</div>
														<div class="tabla-fija-scroll">
															<table class="table table-striped" >
																<thead>
																	<tr>
																		<th>Cliente - Nombre proyecto</th>
																		<th>Valor</th>
																	</tr>
																</thead>
																<tbody>
																	<?php $total=0; ?>
																	<?php foreach($this->array_aprobados[$key] as $content){ ?>
																		<?php $total+=(int)$content->valor; ?>
																		<tr>
																			<td><?= $this->list_cliente_id[$content->cliente_id];?> - <?=$content->nombre;?></td>
																			<td>$<?= formato_pesos($content->valor);?></td>
																		</tr>
																	<?php } ?>
																</tbody>
															</table>
														</div>
														<div class="table-foot py-2 div-thead d-flex justify-content-end align-items-center">
															<div class="me-3">
																<label><b>Total: $<?= formato_pesos($total);?></b></label>
															</div>												
														</div>
													</div>

												<?php } ?>

											</div>

										</div>

				


									</div>


								</div>

								</div>
							</div>

                    
                            


							<div class="col-lg-6 col-12 <?= $mod_proyectos ?>">
        
								<a id="proyectosd" name="proyectosd"></a>
								<div class="col-lg-12 mt-4 content-dashboard no-padding">
									
									<div class="caja_azul">
										<div class="d-flex justify-content-between align-items-center h-100">
											<b class="titulo_dashboard"><i class="fa-solid fa-diagram-project icon-dash"></i> Proyectos en desarrollo</b>
											<div class="gris_claro me-2">
												<span data-bs-toggle="tooltip" data-placement="top" title="Nuevo proyecto" class="mt-3">
													<a class="custom-btn-home" data-bs-toggle="modal" data-bs-target="#modal_crear_proyecto" onclick="document.getElementById('iframe_crear_proyecto').src='/page/proyectosd/manage?cliente=&detalle=1&hash=1';" >
														<span class="add-button-home lf-part">CREAR</span>
														<span class="rg-part"><i class="fas fa-plus"></i></span>
													</a>
												</span>
											</div>
										</div>
									</div>

									<div class="col-lg-12 no-padding">

										<div class="input-group">
											<select class="form-select" id="cliente3" onchange="filtrar_cliente3();">
												<option value="" class="text-uppercase">Todos los clientes</option>
												<?php foreach ($this->list_cliente_id_proyectos as $key => $value) : ?>
													<option value="<?= $key; ?>" <?php if ($_GET['cliente3']==$key) { echo "selected";} ?> class="text-uppercase"><?= $value; ?></option>
												<?php endforeach ?>
											</select>
										</div>

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
																		<option value="" class="text-uppercase">Seleccione cliente</option>
																		<?php foreach ($this->list_cliente_id AS $key => $value ){?>
																			<option <?php if($this->getObjectVariable($this->content,"cliente_id") == $key or $_GET['cliente'] == $key){ echo "selected"; $valor_cliente = $key; }?> value="<?php echo $key; ?>" class="text-uppercase"> <?= $value; ?></option>
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
																		<?php foreach ($this->list_estado2 AS $key => $value ){?>
																			<option <?php if($this->getObjectVariable($this->content,"estado") == $key ){ echo "selected"; }?> value="<?php echo $key; ?>" /> <?= $value; ?></option>
																		<?php } ?>
																	</select>
																</div>
																<div class="help-block with-errors"></div>
															</div>
															<div class="col-lg-12 mb-3">
																<label for="documento1" class="form-label" >Cotización o documento</label>
																<input type="file" name="documento1" id="documento1" class="form-control  file-document" data-buttonName="btn-primary" onchange="validardocumento('documento1');" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint, text/plain, application/pdf,image/*" >

																<?php if($this->content->documento1!=""){ ?>
																	<br><a href="/images/<?php echo $this->content->documento1; ?>" target="_blank" class="btn btn-primary btn-sm"><i class="fas fa-file-download"></i></a>
																<?php } ?>

																<div class="help-block with-errors"></div>
															</div>
															<div class="col-lg-12 mb-3">
																<label for="documento2" class="form-label" >Cotización o documento</label>
																<input type="file" name="documento2" id="documento2" class="form-control  file-document" data-buttonName="btn-primary" onchange="validardocumento('documento2');" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint, text/plain, application/pdf,image/*" >

																<?php if($this->content->documento2!=""){ ?>
																	<br><a href="/images/<?php echo $this->content->documento2; ?>" target="_blank" class="btn btn-primary btn-sm"><i class="fas fa-file-download"></i></a>
																<?php } ?>

																<div class="help-block with-errors"></div>
															</div>
															<div class="col-lg-12 mb-3">
																<label for="documento3" class="form-label" >Cotización o documento</label>
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


									<div class="content-table">
										<div class="tabla-fija-scroll-1">
											<table width="100%" border="0" class="table table-striped">
												<thead>
													<tr>
														<th width="1%"></th>
														<th>Cliente - Nombre proyecto</th>
														<th width="1%">Requerimientos</th>
														<th class="icon-2"></th>
													</tr>		
												</thead>				
												<tbody>
													<?php foreach($this->aprobados as $key2 => $content){ ?>
														<?php $id =  $content->id; ?>
														<?php $total_proyectos+=(int)$content->valor; ?>
															<tr id="div_proyectos2<?php echo $key2; ?>" <?php if($key2>12){ echo 'style="display:none";'; } ?> >
																<td>
																	<?php if (!$content->fecha_final) { ?>
																		<span class="circle-red" title="Proyectos sin fecha de finalización"></span>
																	<?php } ?>
																</td>
																<td><?= $this->list_cliente_id[$content->cliente_id];?> - <?=$content->nombre;?></td>
																<td>(<?= $content->cuenta_reque ?>) Pendientes</td>
																<td width="90">
																	<div class="d-flex">
																		<a href="/page/view?cliente=<?= $content->cliente_id ?>&proyecto=<?= $id ?>" class="btn btn-success btn-sm btn-manage me-1" data-bs-toggle="tooltip" title="Ver">
																			<i class="fas fa-eye"></i>
																		</a>
																		<?php if ($content->fecha_final) { ?>
																			<a href="/page/view/terminar2?id=<?= $id ?>&cliente=<?= $content->cliente_id ?>&proyecto=<?= $id ?>&hastw=1" class="btn btn-danger btn-sm btn-manage" id="terminar_proyecto" data-bs-toggle="tooltip" title="Terminar proyecto">
																				<i class="fas fa-clock"></i>
																			</a>
																		<?php } ?>
																	</div>
																	<!-- Modal Validar-->
																	<div class="modal fade text-start" id="validar<?= $id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
																		<div class="modal-dialog" role="document">
																			
																			<div class="modal-content">
																				<div class="modal-header">
																					<h4 class="modal-title" id="myModalLabel">Aprobación Proyecto</h4>
																					<button type="button" class="close btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
																				</div>
																				<div class="modal-body">
																					<div class="container">
																						<div class="row text-start">
																							<div class="col-7 mb-1">
																								<b>Proyecto: </b> <?=$content->nombre;?>
																							</div>
																							<div class="col-5 mb-1">
																								<b>Tipo: </b> <?= $this->list_tipo[$content->tipo];?>
																							</div>
																							<div class="col-7 mb-1">
																								<b>Cliente: </b> <?= $this->list_cliente_id[$content->cliente_id];?>
																							</div>
																							<div class="col-5 mb-1">
																								<b>Valor: </b> $ <?php echo formato_pesos($content->valor); ?>
																							</div>

																							<div class="col-12 mb-3 mt-3">
																								<div class="row">
																									<div class="col-12 mb-2 mt-1">
																										<p class="form-label">Comentarios para administración</p>
																										<label class="input-group">
																											<span class="input-group-text input-icono" ><i class="fas fa-pencil-alt"></i></span>
																											<input type="text" class="form-control" id="comentarios_aprueba_<?= $id ?>" />
																										</label>
																									</div>
																									<div class="col-12 mb-2 mt-1">
																										<p class="form-label">Comentarios para proyectos</p>
																										<label class="input-group">
																											<span class="input-group-text input-icono" ><i class="fas fa-pencil-alt"></i></span>
																											<input type="text" class="form-control" id="comentarios_admin_<?= $id ?>" />
																										</label>
																									</div>
																								</div>
																							</div>
																						</div>
																					</div>
																				</div>
																				<div class="modal-footer">
																					<button class="btn btn-guardar" type="button" onclick="aprobar('<?php echo $id; ?>');" id="btn_aprobar_<?= $id ?>">Aprobar</button>
																					<button class="btn btn-cancelar" type="submit" onclick="no_aprobar('<?php echo $id; ?>');" id="btn_noaprobar_<?= $id ?>">No Aprobar</button>
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
										<div class="table-foot py-2 div-thead">
											<div class="d-flex justify-content-between align-items-center">
												<div class="ms-3">
													<button type="button" class="btn btn-viewmore btn-sm" onclick="mas_proyectos2()">VER MÁS</button>
												</div>
												<div class="d-flex justify-content-end align-items-center me-3 d-none">
													<label><b>Total valor proyectos: $<?php echo formato_pesos($total_proyectos); ?></b></label>
												</div>
											</div>
										</div>
									</div>

									
									<input type="hidden" value="9" id="cantidad_proyectos2">

								</div>

							</div>
							
							
							

							<div class="col-lg-6 col-md-12 <?= $mod_proximas ?>">

								<div class="col-lg-12 mt-4 content-dashboard no-padding">
								
									<div class="caja_azul">
										<div class="d-flex justify-content-between align-items-center h-100">
											<b class="titulo_dashboard"><i class="fa-solid fa-business-time icon-dash"></i> Próximos seguimientos</b>
											<div class="gris_claro me-2">
												<span data-bs-toggle="tooltip" data-placement="top" title="Nuevo seguimiento" class="mt-3">
													<a data-bs-toggle="modal" data-bs-target="#modal_crear_seg" class="custom-btn-home">
														<span class="add-button-home lf-part">CREAR</span>
														<span class="rg-part"><i class="fas fa-plus"></i></span>
													</a>
												</span>
											</div>
										</div>
									</div>

									<div class="modal fade text-start" id="modal_crear_seg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
										<div class="modal-dialog modal-md" role="document">
											<div class="modal-content">
												<form class="text-start" enctype="multipart/form-data" method="post" action="/page/seguimientoproyecto/insert">
													<div class="modal-body">
														<div class="row">
															<div class="col-lg-12">
																<div class="caja_azul">
																	<div class="d-flex justify-content-between align-items-center h-100">
																		<b class="titulo_dashboard"><i class="fa-solid fa-business-time icon-dash"></i> Crear nuevo seguimiento</b>
																		<div class="me-2">
																			<button type="button" class="close btn-cerrar-modal" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<div class="row px-3">
															<div class="col-lg-12 mt-3 mb-3">
																<span class="detail-modal">Por favor ingrese los datos del seguimiento</span>
															</div>
															<div class="col-lg-12 mb-3">
																<div class="input-group">
																	<select class="form-select" name="cliente_id" id="client_id" onchange='cambiar_datos();' required>
																		<option value="" class="text-uppercase">Seleccione cliente</option>
																		<?php foreach ($this->list_cliente_id AS $key => $value ){?>
																			<option value="<?php echo $key; ?>" class="text-uppercase"> <?= $value; ?></option>
																		<?php } ?>
																	</select>
																</div>
																<div class="help-block with-errors"></div>
															</div>
															<div class="col-lg-12 mb-3">
																<div class="input-group">
																	<select class="form-select" name="proyecto_id" id="proyectos_seg"></select>
																</div>
																<div class="help-block with-errors"></div>
															</div>
															<div class="col-lg-12 mb-3">
																<div class="input-group">
																<input type="datetime-local" name="fecha" id="fecha" class="form-control datetimepicker-input" data-bs-toggle="datetimepicker" data-bs-target="#fecha" required >
																</div>
																<div class="help-block with-errors"></div>
															</div>
															<div class="col-lg-12 mb-3">
																<div class="input-group">
																	<textarea rows="2" name="seguimiento" id="seguimiento" class="form-control modal-input" minlength="3" placeholder="Descripción del seguimiento"></textarea>
																</div>
																<div class="help-block with-errors"></div>
															</div>
															<div class="col-lg-12 mb-3">
																<div class="input-group">
																<input type="datetime-local" name="programar" id="programar" class="form-control datetimepicker-input" data-bs-toggle="datetimepicker" data-bs-target="#fecha" required >
																</div>
																<div class="help-block with-errors"></div>
															</div>

															<input type="hidden" name="hash" value="1">
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

									<div class="no-input-h"></div>

									<div class="content-table">
										<div class="tabla-fija-scroll-1">
											<table width="100%" border="0" class="table table-striped">
												<thead>
													<tr>
														<th>Cliente - Nombre proyecto</th>
														<th>Fecha</th>
														<th></th>
													</tr>		
												</thead>				
												<tbody>
													<?php foreach($this->programaciones as $key3 => $content){?>
														<?php $id =  $content->id; ?>
														<tr class="div_seguimientos<?= $id ?>"  id="div_seguimientos<?php echo $key3; ?>" <?php if($key3>6){ echo 'style="display:none";'; } ?>>
															<td><?= $this->list_cliente_id[$content->client_id];?> - <?= $this->list_proyectos[$content->proyecto_id];?></td>
															<td>
																<?php $fecha_programar = explode(" ", $content->programar); ?>
																<div><?= $fecha_programar[0];?></div>
																<?= getCalcDate($fecha_programar[0]); ?>
															</td>
															<td>
																<div class="iconos-tres">
																	<span data-bs-toggle="tooltip" data-placement="top" title="Detalle">
																		<a class="btn btn-warning btn-sm btn-manage me-1 mb-1" data-bs-toggle="modal" data-bs-target="#modal_detalle_programacion<?= $id ?>" >
																			<i class="fa fa-info-circle" aria-hidden="true"></i>
																		</a>
																	</span>
																	<span data-bs-toggle="tooltip" data-placement="top" title="Finalizar seguimiento">
																		<a class="btn btn-danger btn-sm btn-manage me-1 mb-1" onclick="finalizar_seguimiento('<?= $id ?>')" style="cursor: pointer;"  >
																		<i class="fa fa-step-forward" aria-hidden="true"></i>
																		</a>
																	</span>
																	<span data-bs-toggle="tooltip" data-placement="top" title="Reprogramar">
																		<a class="btn btn-success btn-sm btn-manage" data-bs-toggle="modal" data-bs-target="#modal_editar_programacion<?= $id ?>" >
																			<i class="fa fa-calendar-plus" aria-hidden="true"></i>
																		</a>
																	</span>
																</div>
															</td>
														</tr>
													<?php } ?>
												</tbody>
											</table>
										</div>
									</div>

									<div class="table-foot py-2 div-thead">
										<div class="d-flex justify-content-between align-items-center">
											<div class="ms-3">
												<button type="button" class="btn btn-viewmore btn-sm" onclick="mas_seguimientos()">VER MÁS</button>
											</div>
										</div>
									</div>

									<input type="hidden" value="6" id="cantidad_seguimientos">

								</div>
								
							</div>
        				
        				</div>
        			
        			</div>


					<div class="col-3" id="div_menu_graf">
						<div class="div-fijo-dash">

							<div class="container-fluid">
								<div class="row mb-2">
									<div class="col-12 mt-4">				
										<div class="caja_azul mb-1">
										    <div class="d-flex justify-content-between align-items-center h-100">
												<b class="titulo_dashboard"><i class="fa-solid fa-barcode icon-dash"></i> Cotizaciones realizadas por mes</b>
											</div>
											<b class="titulo_dashboard"></b>
										</div>
										<div class="col-lg-12 no-padding d-none">
											<table width="100%" border="1">
												<tr>
													<td><b>Mes</b></td>
													<td align="center"><b>Cantidad</b></td>
													<td align="center"><b>Valor</b></td>
												</tr>
												<?php 
												$i = 0; // Inicializa el índice $i
												foreach($this->meses as $key => $mes){ 
													$i++;
													$calificaciones[$i] = $mes;
													$valores[$i] = (int)$this->total_coti_aprobados[$key]; // Cantidad de cotizaciones
													$totales[$i] = number_format($this->totales_coti[$key]); // Valores en pesos
												?>
												<tr>
													<td><?php echo $mes; ?></td>
													<td align="center"><?php echo (int)$this->total_coti_aprobados[$key]; ?></td>
													<td align="center"><?php echo (int)$this->totales_coti[$key]; ?></td>
												</tr>										
												<?php } ?>
											</table>
										</div>

										<div class="row">
											<!-- Gráfica de cantidad de cotizaciones -->
											<div class="col-lg-12 mb-1">
												<div class="card">
													<div class="card-body">
														<canvas id="chartCotizaciones"></canvas>
													</div>
												</div>
											</div>

											<!-- Gráfica de valor total en pesos -->
											<div class="col-lg-12">
												<div class="card">
													<div class="card-body">
														<canvas id="chartValores"></canvas>
													</div>
												</div>
											</div>
										</div>

										<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
										<script type="text/javascript">
											var ctxCotizaciones = document.getElementById('chartCotizaciones').getContext('2d');
											var ctxValores = document.getElementById('chartValores').getContext('2d');

											// Define los colores para cada barra
											var colors = [
															'rgba(255, 206, 86, 0.2)', // amarillo
															'rgba(75, 192, 192, 0.2)', // verde
															'rgba(255, 99, 132, 0.2)', // rosa
															'rgba(54, 162, 235, 0.2)',
															'rgba(153, 102, 255, 0.2)', // lila
															'rgba(255, 159, 64, 0.2)'
														];
											var border = [
															'rgba(255, 206, 86, 1)',
															'rgba(75, 192, 192, 1)',
															'rgba(255, 99, 132, 1)',
															'rgba(54, 162, 235, 1)',                                
															'rgba(153, 102, 255, 1)',
															'rgba(255, 159, 64, 1)'
														];
											// Gráfica de cantidad de cotizaciones
											var dataCotizaciones = {
												labels: [<?php for($x = 1; $x <= $i; $x++) { echo "'" . $calificaciones[$x] . "', "; } ?>],
												datasets: [{
													label: 'Cantidad de Cotizaciones',
													data: [<?php for($x = 1; $x <= $i; $x++) { echo $valores[$x] . ', '; } ?>],
													backgroundColor: colors.slice(0, <?php echo $i; ?>), 
													borderColor: border.slice(0, <?php echo $i; ?>),
													borderWidth: 1
												}]
											};

											// Gráfica de valor total en pesos con formato de moneda
											var dataValores = {
												labels: [<?php for($x = 1; $x <= $i; $x++) { echo "' " . $calificaciones[$x] . "', "; } ?>], // Agregar $ a los labels
												datasets: [{
													label: 'Valor Total en Pesos',
													data: [<?php for($x = 1; $x <= $i; $x++) { echo str_replace(",", "", $totales[$x]) . ', '; } ?>],
													backgroundColor: colors.slice(0, <?php echo $i; ?>),
													borderColor: border.slice(0, <?php echo $i; ?>),
													borderWidth: 1
												}]
											};

											// Opciones para las gráficas
											var options = {
												responsive: true,
												scales: {
													y: {
														beginAtZero: true,
														title: {
															display: true,
															text: 'Cantidad'
														}
													},
													x: {
														title: {
															display: true,
															text: 'Mes'
														}
													}
												},
												plugins: {
													tooltip: {
														callbacks: {
															title: function(tooltipItems) {
																return 'Mes: ' + tooltipItems[0].label;
															}
														}
													}
												}
											};

											// Crear la gráfica de cantidad de cotizaciones
											var chartCotizaciones = new Chart(ctxCotizaciones, {
												type: 'bar',
												data: dataCotizaciones,
												options: {
													...options,
													plugins: {
														tooltip: {
															callbacks: {
																...options.plugins.tooltip.callbacks,
																label: function(tooltipItem) {
																	return 'Cotizaciones: ' + tooltipItem.raw;
																}
															}
														}
													}
												}
											});

											// Crear la gráfica de valor total en pesos con formato de moneda
											var chartValores = new Chart(ctxValores, {
												type: 'bar',
												data: dataValores,
												options: {
													...options,
													scales: {
														y: {
															beginAtZero: true,
															title: {
																display: true,
																text: 'Valor en Pesos'
															},
															ticks: {
																callback: function(value) {
																	return '$' + value.toLocaleString('es-CO'); // Formato de moneda
																}
															}
														}
													},
													plugins: {
														tooltip: {
															callbacks: {
																...options.plugins.tooltip.callbacks,
																label: function(tooltipItem) {
																	return 'Valor Total: $' + tooltipItem.raw.toLocaleString('es-CO'); // Formato de moneda en tooltip
																}
															}
														}
													}
												}
											});
										</script>




									</div>
									<div class="col-12 mt-2">
									    <div class="caja_azul">
    										<div class="d-flex justify-content-between align-items-center h-100">
    											<b class="titulo_dashboard"><i class="fa-solid fa-diagram-project icon-dash"></i> Proyectos en desarrollo</b>
    										</div>
    									</div>
										<div class="col-lg-12 no-padding d-none">
											<table width="100%" border="1">
												<tr>
													<td><b>Mes</b></td>
													<td align="center"><b>Cantidad</b></td>
													<td align="center"><b>Valor</b></td>
												</tr>
												<?php 
												$i = 0; // Inicializa el índice $i
												foreach($this->meses as $key => $mes){ 
													$i++;
													$calificaciones[$i] = $mes;
													$valores[$i] = (int)$this->total_desarrollo[$key];
													$totales[$i] = (int)$this->totales[$key];
												?>
												<tr>
													<td><?php echo $mes; ?></td>
													<td align="center"><?php echo (int)$this->total_desarrollo[$key]; ?></td>
													<td align="center"><?php echo number_format($this->totales[$key]); ?></td>
												</tr>										
												<?php } ?>
											</table>
										</div>
										
										<div class="row">
											<div class="col-lg-12 mb-1">
												<div class="card">
													<div class="card-body">
														<canvas id="myChart_aprobados" style="height: 100px; max-width: 100%;"></canvas>
													</div>
												</div>
											</div>
											<div class="col-lg-12 mb-1">
												<div class="card">
													<div class="card-body">
														<canvas id="myChart_totales" style="height: 100px; max-width: 100%;"></canvas>
													</div>
												</div>
											</div>
										</div>

										<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
										<script type="text/javascript">
											// Gráfica de Aprobados
											var ctx_aprobados = document.getElementById('myChart_aprobados').getContext('2d');

											var colors = [
															'rgba(255, 206, 86, 0.2)', // amarillo
															'rgba(75, 192, 192, 0.2)', // verde
															'rgba(255, 99, 132, 0.2)', // rosa
															'rgba(54, 162, 235, 0.2)',
															'rgba(153, 102, 255, 0.2)', // lila
															'rgba(255, 159, 64, 0.2)'
														];
											var border = [
															'rgba(255, 206, 86, 1)',
															'rgba(75, 192, 192, 1)',
															'rgba(255, 99, 132, 1)',
															'rgba(54, 162, 235, 1)',                                
															'rgba(153, 102, 255, 1)',
															'rgba(255, 159, 64, 1)'
														];

											var data_aprobados = {
												labels: [<?php for($x = 1; $x <= $i; $x++) { echo "'" . $calificaciones[$x] . "', "; } ?>],
												datasets: [{
													label: 'Aprobados',
													data: [<?php for($x = 1; $x <= $i; $x++) { echo $valores[$x] . ', '; } ?>],
													backgroundColor: colors.slice(0, <?php echo $i; ?>),
													borderColor: border.slice(0, <?php echo $i; ?>),
													borderWidth: 1
												}]
											};

											var options_aprobados = {
												responsive: true,
												scales: {
													y: {
														beginAtZero: true,
														title: {
															display: true,
															text: 'Cantidad de Aprobados'
														}
													},
													x: {
														title: {
															display: true,
															text: 'Mes'
														}
													}
												}
											};

											var myChartAprobados = new Chart(ctx_aprobados, {
												type: 'bar',
												data: data_aprobados,
												options: options_aprobados
											});

											// Gráfica de Totales en Valor (Pesos)
											var ctx_totales = document.getElementById('myChart_totales').getContext('2d');

											var data_totales = {
												labels: [<?php for($x = 1; $x <= $i; $x++) { echo "'" . $calificaciones[$x] . "', "; } ?>],
												datasets: [{
													label: 'Totales (Pesos)',
													data: [<?php for($x = 1; $x <= $i; $x++) { echo $totales[$x] . ', '; } ?>],
													backgroundColor: colors.slice(0, <?php echo $i; ?>),
													borderColor: border.slice(0, <?php echo $i; ?>),
													borderWidth: 1
												}]
											};

											var options_totales = {
												responsive: true,
												scales: {
													y: {
														beginAtZero: true,
														title: {
															display: true,
															text: 'Valor en Pesos'
														},
														ticks: {
															callback: function(value) {
																return '$' + new Intl.NumberFormat('es-CO').format(value);
															}
														}
													},
													x: {
														title: {
															display: true,
															text: 'Mes'
														}
													}
												},
												plugins: {
													tooltip: {
														callbacks: {
															label: function(tooltipItem) {
																let value = tooltipItem.raw;
																return 'Valor Total: $' + new Intl.NumberFormat('es-CO').format(value);
															}
														}
													}
												}
											};

											var myChartTotales = new Chart(ctx_totales, {
												type: 'bar',
												data: data_totales,
												options: options_totales
											});

										</script>



									</div>


									<div class="col-12 mt-2 mb-5">
										<div class="caja_azul">
											<div class="d-flex justify-content-between align-items-center h-100">
												<b class="titulo_dashboard"><i class="fa-solid fa-money-bill-trend-up icon-dash"></i> Total proyectos - <?php echo $this->meses_completos[date("m")]; ?></b>
											</div>
										</div>
										<div class="col-lg-12 no-padding">
											<table width="100%" border="1" class="d-none">
												<tr>
													<td><b>Estado</b></td>
													<td align="center"><b>Cantidad</b></td>
													<td align="center"><b>Valor Total</b></td>
												</tr>
												<?php 
												$valorTotalProyectos = 0; // Valor total de proyectos
												$etiquetas = [];
												$cantidades = [];
												$valoresTotales = []; // Array para los valores totales

												foreach ($this->estado as $key => $count) { 
													$valorTotal = $this->estadoSuma[$key]; // Formatear el valor con dos decimales
													$valorTotalProyectos += $this->estadoSuma[$key]; // Sumar el valor total

													// Agregar etiquetas, cantidades y valores totales para la gráfica
													if ($this->listaestado[$key]) {
														$etiquetas[] = $this->listaestado[$key];
													} else {
														$etiquetas[] = "";
													}

													$cantidades[] = $count;
													$valoresTotales[] = $valorTotal; // Agregar el valor total
												?>
												<tr>
													<td><?php echo $this->listaestado[$key]; ?></td>
													<td align="center"><?php echo $count; ?></td>
													<td align="center"><?php echo $valorTotal; ?></td>
												</tr>										
												<?php } ?>
												<!-- Fila de total -->
												<tr>
													<td><b>Total</b></td>
													<td align="center"><b><?php echo $this->totalProyectos; ?></b></td>
													<td align="center"><b><?php echo number_format($valorTotalProyectos, 0,"."); ?></b></td>
												</tr>
											</table>
										</div>

										<div class="col-lg-12 mb-4">
											<div class="card">
												<div class="card-body">
													<canvas id="myPieChart" width="100" height="100" class="mb-1"></canvas>
												</div>
											</div>
										</div>

										<script>
											const ctx_2 = document.getElementById('myPieChart').getContext('2d');

											// Asegúrate de que los datos estén disponibles y sean válidos
											const etiquetas = <?php echo json_encode($etiquetas); ?>;
											const cantidades = <?php echo json_encode($cantidades); ?>;
											const valoresTotales = <?php echo json_encode($valoresTotales); ?>; // Valores totales

											const myPieChart = new Chart(ctx_2, {
												type: 'pie', // Tipo de gráfico
												data: {
													labels: etiquetas, // Etiquetas del gráfico
													datasets: [{
														label: 'Cantidad por Estado',
														data: cantidades, // Datos del gráfico
														backgroundColor: [
															
															'rgba(255, 206, 86, 0.2)', // amarillo
															'rgba(75, 192, 192, 0.2)', // verde
															'rgba(255, 99, 132, 0.2)', // rosa
															'rgba(153, 102, 255, 0.2)', // Lila
															'rgba(54, 162, 235, 0.2)', // Azul
															'rgba(255, 159, 64, 0.2)' //Naranja
														],
														borderColor: [
															
															'rgba(255, 206, 86, 1)',
															'rgba(75, 192, 192, 1)',
															'rgba(255, 99, 132, 1)',
															'rgba(153, 102, 255, 1)',
															'rgba(54, 162, 235, 1)',															
															'rgba(255, 159, 64, 1)'
														],
														borderWidth: 1
													}]
												},
												options: {
													responsive: true,
													plugins: {
														legend: {
															position: 'top',
														},
														title: {
															display: true,
															text: 'Distribución de Cantidad por Estado'
														},
														tooltip: {
															callbacks: {
																label: function(tooltipItem) {
																	const cantidad = tooltipItem.raw; // Obtiene la cantidad del tooltip
																	const valorTotal = valoresTotales[tooltipItem.dataIndex]; // Obtiene el valor total correspondiente
																	return `Cantidad: ${cantidad}\nValor Total: $ ${valorTotal.toLocaleString('es-CO')}`;
																}
															}
														}
													}
												}
											});
										</script>


									</div>
								</div>
							</div>

						</div>						
					</div>

					


					
					
					

				</div>

			</div>

			<div class="mt-5"></div>






		
	</div>

</div>


<script>
	function ir_a_mes($x){
		if($x!=""){
			$(".div_aprobados").hide();
			$("#mes"+$x).show();
		}
	}
</script>

<div align="center" style="position: fixed; left: 50%; top: 40%; margin-left: -100px; display: none;" id="loading"><img src="/corte/loading-gif.gif" width="200" /></div>



			<?php foreach($this->clientes as $content){?>
				<?php $id =  $content->id; ?>
				<!-- Modal -->
				<div class="modal fade text-start" id="modal_detalle<?= $id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				  	<div class="modal-dialog modal-lg" role="document">
				    	<div class="modal-content">
							<form id="form_cliente_<?= $id ?>" onsubmit="editar_cliente(<?= $id ?>); return false;">
								<div class="modal-body">

									<div class="row">
										<div class="col-lg-12">
											<div class="caja_azul">
												<div class="d-flex justify-content-between align-items-center h-100">
													<b class="titulo_dashboard"><i class="fa-solid fa-building icon-dash"></i> Editar cliente</b>
													<div class="me-2 d-flex">
														<button type="button" class="btn btn-primary btn-sm" id="habilitar_form_<?= $id ?>" onclick="habilitar_form(<?= $id ?>)">Habilitar Edición</button>
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

										<div class="row">
											<div class="col mb-3">
												<div class="input-group">
													<input type="text" value="<?= $content->nombre; ?>" name="nombre" id="nombre_<?= $id ?>" class="form-control" disabled minlength="3" placeholder="Nombre empresa">
												</div>
												<div class="help-block with-errors"></div>
											</div>
											
											<div class="col mb-3">
												<div class="input-group">
													<select class="form-select" name="tipo_documento" disabled id="tipo_documento_<?= $id ?>">
														<option value="">Tipo documento</option>
														<?php foreach ($this->list_tipo_documento AS $key => $value ){?>
															<option <?php if($this->getObjectVariable($content,"tipo_documento") == $key ){ echo "selected"; }?> value="<?php echo $key; ?>" /> <?= $value; ?></option>
														<?php } ?>
													</select>
												</div>
												<div class="help-block with-errors"></div>
											</div>				
											<div class="col mb-3">
												<div class="input-group">
													<input type="number" value="<?= $content->documento; ?>" name="documento" id="documento_<?= $id ?>" class="form-control" disabled minlength="3" placeholder="Número de documento">
												</div>
												<div class="help-block with-errors"></div>
											</div>

											<div class="col mb-3">
												<div class="input-group">
													<input type="email" value="<?= $content->email; ?>" name="email" id="email_<?= $id ?>" class="form-control" disabled placeholder="Correo">
												</div>
												<div class="help-block with-errors"></div>
											</div>
											<div class="col mb-3">
												<div class="input-group">
													<input type="number" value="<?= $content->telefono; ?>" name="telefono" id="telefono_<?= $id ?>" class="form-control"  disabled pattern="[0-9]{7}"
													placeholder="Ingrese un número de 7 dígitos" onkeypress="return isNumberKey(event)">
												</div>
												<div class="help-block with-errors"></div>
											</div>				
										</div>
										<div class="row">
											<div class="col mb-3">
												<div class="input-group">
													<input type="text" value="<?= $content->celular; ?>" name="celular" id="celular_<?= $id ?>" class="form-control" disabled pattern="[0-9]{10}"
													placeholder="Ingrese un número de 10 dígitos" maxlength="10" onkeypress="return isNumberKey(event)">
												</div>
												<div class="help-block with-errors"></div>
											</div>				
											<div class="col mb-3">
												<div class="input-group">
													<input type="text" value="<?= $content->contacto_principal; ?>" name="contacto_principal" id="contacto_principal_<?= $id ?>" class="form-control" disabled minlength="3" placeholder="Contacto principal">
												</div>
												<div class="help-block with-errors"></div>
											</div>
											<div class="col mb-3">
												<div class="input-group">
													<input type="text" value="<?= $content->direccion; ?>" name="direccion" id="direccion_<?= $id ?>" class="form-control" disabled minlength="3" placeholder="Dirección">
												</div>
												<div class="help-block with-errors"></div>
											</div>
											<div class="col mb-3">
												<div class="input-group">
													<input type="text" value="<?= $content->pagina_web; ?>" name="pagina_web" id="pagina_web_<?= $id ?>" class="form-control" disabled minlength="3" placeholder="Página web">
												</div>
												<div class="help-block with-errors"></div>
											</div>
											<div class="col mb-3">
												<div class="input-group">
													<select class="form-select" name="categoria" disabled id="categoria_<?= $id ?>">
														<option value="">Tipo</option>
														<?php foreach ($this->list_categoria AS $key => $value ){?>
															<option <?php if($this->getObjectVariable($content,"categoria") == $key ){ echo "selected"; }?> value="<?php echo $key; ?>" /> <?= $value; ?></option>
														<?php } ?>
													</select>
												</div>
												<div class="help-block with-errors"></div>
											</div>
											<div class="col-12">
												<div class="d-flex justify-content-end align-items-center">
													<small>Última actualización: <?= formatoDMYH($content->fecha_a); ?></small>
												</div>
											</div>

											<input type="hidden" name="cliente_id" id="cliente_id_<?= $id ?>" value="<?= $id ?>">
											<input type="hidden" name="fecha_a" value="<?= date("Y-m-d H:i:s") ?>"> 
											<div class="botones-acciones text-center my-1 d-none" id="btn_cliente_<?= $id ?>">
												<button class="btn btn-guardar" type="submit">Guardar</button>
												<button class="btn btn-cancelar" type="button" onclick="deshabilitar_form(<?= $id ?>)">Cancelar</button>
											</div>
										</div>
										<div class="row">
											<div class="col-12" id="cliente_msm_<?= $id ?>">

											</div>
										</div>
									</div>			
												

									<hr>

									
									<!-- Nav tabs -->
									<ul class="nav nav-tabs my-4 nav-custom" id="myTab<?= $id ?>" role="tablist">
										<li class="nav-item" role="presentation">
											<button class="nav-link active" id="cotizaciones-tab<?= $id ?>" data-bs-toggle="tab" data-bs-target="#cotizaciones<?= $id ?>" type="button" role="tab" aria-controls="cotizaciones<?= $id ?>" aria-selected="true">Cotizaciones</button>
										</li>
										<li class="nav-item" role="presentation">
											<button class="nav-link" id="proyectos-tab<?= $id ?>" data-bs-toggle="tab" data-bs-target="#proyectos<?= $id ?>" type="button" role="tab" aria-controls="proyectos<?= $id ?>" aria-selected="true" onclick="recargar(<?= $id ?>)">Proyectos</button>
										</li>
										<li class="nav-item" role="presentation">
											<button class="nav-link" id="contactos-tab<?= $id ?>" data-bs-toggle="tab" data-bs-target="#contactos<?= $id ?>" type="button" role="tab" aria-controls="contactos<?= $id ?>" aria-selected="false">Contactos</button>
										</li>
									</ul>

									<!-- Tab content -->
									<div class="tab-content" id="myTabContent<?= $id ?>">

										<!-- Proyectos Tab -->
										<div class="tab-pane fade show active" id="cotizaciones<?= $id ?>" role="tabpanel" aria-labelledby="cotizaciones-tab<?= $id ?>">
											<div class="row">
												<div class="col-lg-12 mt-3">
													<iframe id="iframe_cotizaciones<?= $id ?>" width="100%" height="600" frameborder="0" src="about:blank"></iframe>
												</div>
											</div>
										</div>

										<!-- Proyectos Tab -->
										<div class="tab-pane fade" id="proyectos<?= $id ?>" role="tabpanel" aria-labelledby="proyectos-tab<?= $id ?>">
											<div class="row">
												<div class="col-lg-12 mt-3">
													<iframe id="iframe_proyecto<?= $id ?>" width="100%" height="600" frameborder="0" src="about:blank"></iframe>
												</div>
											</div>
										</div>

										<!-- Contactos Tab -->
										<div class="tab-pane fade" id="contactos<?= $id ?>" role="tabpanel" aria-labelledby="contactos-tab<?= $id ?>">
											<div class="row">
												<div class="col-lg-12 mt-3">
													<iframe id="iframe_contacto<?= $id ?>" width="100%" height="600" frameborder="0" src="about:blank"></iframe>
												</div>
											</div>
										</div>
									</div>
								

								</div>

					      	</form>	

				    	</div>
				  	</div>
				</div>
			<?php } ?>

			<?php foreach($this->proyectos as $content){?>
				<?php $id =  $content->id; ?>
				<!-- Modal -->
				<div class="modal fade text-start" id="modal_detalle_proyecto<?= $id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				  	<div class="modal-dialog modal-lg" role="document">
				    	<div class="modal-content ">
							<form id="form_cotizacion_<?= $id ?>" onsubmit="editar_cotizacion(<?= $id ?>); return false;">
								<div class="modal-body">

									<div class="row">
										<div class="col-lg-12">
											<div class="caja_azul">
												<div class="d-flex justify-content-between align-items-center h-100">
													<b class="titulo_dashboard"><i class="fa-solid fa-building icon-dash"></i> Editar cotización <?= $content->consecutivo ?></b>
													<div class="me-2 d-flex">
														<button type="button" class="btn btn-primary btn-sm" id="habilitar_form_cotizacion_<?= $id ?>" onclick="habilitar_form_cotizacion(<?= $id ?>)">Habilitar Edición</button>
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

										<div class="col-lg-3 mb-3">
											<div class="input-group">
												<select class="form-select" name="cliente_id" disabled  >
													<option value="">Cliente</option>
													<?php foreach ($this->list_cliente_id AS $key => $value ){?>
														<option <?php if($this->getObjectVariable($content,"cliente_id") == $key ){ echo "selected"; }?> value="<?php echo $key; ?>" /> <?= $value; ?></option>
													<?php } ?>
												</select>
											</div>
											<div class="help-block with-errors"></div>
										</div>

										<div class="col-lg-3 mb-3">
											<div class="input-group">
												<input type="text" value="<?= $content->nombre; ?>" name="nombre" id="nombre" class="form-control" disabled  placeholder="Nombre del proyecto">
											</div>
											<div class="help-block with-errors"></div>
										</div>
										<div class="col-lg-3 mb-3">
											<div class="input-group">
												<select class="form-select" name="tipo" disabled  >
													<option value="">Tipo de proyecto</option>
													<?php foreach ($this->list_tipo AS $key => $value ){?>
														<option <?php if($this->getObjectVariable($content,"tipo") == $key ){ echo "selected"; }?> value="<?php echo $key; ?>" /> <?= $value; ?></option>
													<?php } ?>
												</select>
											</div>
											<div class="help-block with-errors"></div>
										</div>
										<div class="col-lg-3 mb-3">
											<div class="input-group">
												<input type="text" value="<?php if($content->valor!=""){ echo formato_pesos($content->valor); } ?>" name="valor" id="valor" class="form-control" onchange="puntitos(this)" onkeyup="puntitos(this)" disabled placeholder="Valor del proyecto">
											</div>
											<div class="help-block with-errors"></div>
										</div>

										<div class="col-lg-3 mb-3">
											<div class="input-group">
												<select class="form-select" name="estado"  disabled >
													<option value="">Estado del proyecto</option>
													<?php foreach ($this->list_estado AS $key => $value ){?>
														<option <?php if($this->getObjectVariable($content,"estado") == $key ){ echo "selected"; }?> value="<?php echo $key; ?>" /> <?= $value; ?></option>
													<?php } ?>
												</select>
											</div>
											<div class="help-block with-errors"></div>
										</div>
										<div class="col-lg-6 mb-3">
											<?php if($content->documento1!=""){ ?>
												<a href="/images/<?= $content->documento1 ?>" class="btn btn-primary" target="_blank"><i class="fas fa-file-download" data-bs-toggle="tooltip" data-placement="top" title="Documento1"></i></a> 
											<?php } ?>
											<?php if($content->documento2!=""){ ?>
												<a href="/images/<?= $content->documento1 ?>" class="btn btn-primary" target="_blank"><i class="fas fa-file-download" data-bs-toggle="tooltip" data-placement="top" title="Documento2"></i></a> 
											<?php } ?>
											<?php if($content->documento3!=""){ ?>
												<a href="/images/<?= $content->documento1 ?>" class="btn btn-primary" target="_blank"><i class="fas fa-file-download" data-bs-toggle="tooltip" data-placement="top" title="Documento3"></i></a> 
											<?php } ?>																						

										</div>										
										<input type="hidden" name="id" id="id" value="<?= $content->id; ?>" />
										<div class="botones-acciones text-center my-1 d-none" id="btn_cotizacion_<?= $id ?>">
											<button class="btn btn-guardar" type="submit">Guardar</button>
											<button class="btn btn-cancelar" type="button" onclick="deshabilitar_form_cotizacion(<?= $id ?>)">Cancelar</button>
										</div>
									</div>
									<div class="row">
										<div class="col-12" id="cotizacion_msm_<?= $id ?>">

										</div>
									</div>

									<hr>

									<!-- Nav tabs -->
									<ul class="nav nav-tabs my-4 nav-custom" id="myTabCotizaciones<?= $id ?>" role="tablist">
										<li class="nav-item" role="presentation">
											<button class="nav-link active" id="seguimiento-tab<?= $id ?>" data-bs-toggle="tab" data-bs-target="#seguimiento<?= $id ?>" type="button" role="tab" aria-controls="seguimiento<?= $id ?>" aria-selected="true">Seguimientos</button>
										</li>
									</ul>

									<!-- Tab content -->
									<div class="tab-content" id="myTabCotizacionesContent<?= $id ?>">

										<!-- Proyectos Tab -->
										<div class="tab-pane fade show active" id="seguimiento<?= $id ?>" role="tabpanel" aria-labelledby="seguimiento-tab<?= $id ?>">
											<div class="row">
												<div class="col-lg-12 mt-3">
													<iframe id="iframe_seguimientos<?php echo $id; ?>" width="100%" height="600" frameborder="0" src="about:blank"></iframe>
												</div>
											</div>
										</div>
									</div>

								</div>
								
							</form>

				    	</div>
				  	</div>
				</div>
			<?php } ?>
			<?php foreach($this->aprobados as $content){?>
				<?php $id =  $content->id; ?>
				<!-- Modal -->
				<div class="modal fade text-start" id="modal_detalle_proyecto_a_<?= $id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				  	<div class="modal-dialog modal-lg" role="document">
				    	<div class="modal-content ">
				      		<div class="modal-header">
				        		<h4 class="modal-title" id="myModalLabel">Detalle proyectos en desarrollo</h4>
				        		<button type="button" class="close btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				      		</div>
							<div class="modal-body">
								<form id="form_proyectos_<?= $id ?>" onsubmit="editar_proyectos(<?= $id ?>); return false;">
									
									<div class="card">

										<div class="card-header d-flex justify-content-between align-items-center">
											<div class="text-start">Editar proyecto</div>
											<button type="button" class="btn btn-primary btn-sm" id="habilitar_form_proyectos_<?= $id ?>" onclick="habilitar_form_proyectos(<?= $id ?>)">Habilitar Edición</button>
										</div>
										
										<div class="card-body">
											<div class="row">

												<div class="col-3 mb-3">
													<label class="form-label">Cliente</label>
													<div class="input-group">
														<span class="input-group-text input-icono" ><i class="far fa-list-alt"></i></span>
														<select class="form-select" name="cliente_id" required disabled>
															<option value="">Seleccione...</option>
															<?php foreach ($this->list_cliente_id AS $key => $value ){?>
																<option <?php if($this->getObjectVariable($content,"cliente_id") == $key){ echo "selected"; } ?> value="<?php echo $key; ?>"> <?= $value; ?></option>
															<?php } ?>
														</select>
													</div>
													<div class="help-block with-errors"></div>
												</div>

												<div class="col-3 mb-3">
													<label for="nombre"  class="form-label">Nombre del Proyecto</label>
													<div class="input-group">
														<span class="input-group-text input-icono" ><i class="fas fa-pencil-alt"></i></span>
														<input type="text" value="<?= $content->nombre; ?>" name="nombre" id="nombre" class="form-control" disabled minlength="3" pattern="[^\d]*" title="No se permiten numeros">
													</div>
													<div class="help-block with-errors"></div>
												</div>				
												<div class="col-3 mb-3">
													<label for="valor"  class="form-label">Valor del Proyecto</label>
													<div class="input-group">
														<span class="input-group-text input-icono" ><i class="fas fa-pencil-alt"></i></span>
														<input type="text" value="<?php if($content->valor!=""){ echo formato_pesos($content->valor); } ?>" name="valor" id="valor" class="form-control" onchange="puntitos(this)" onkeyup="puntitos(this)" disabled minlength="3">
													</div>
													<div class="help-block with-errors"></div>
												</div>
												<div class="col-3 mb-3">
													<label class="form-label">Tipo de Proyecto</label>
													<div class="input-group">
														<span class="input-group-text input-icono" ><i class="far fa-list-alt"></i></span>
														<select class="form-select" name="tipo" disabled>
															<option value="">Seleccione...</option>
															<?php foreach ($this->list_tipo AS $key => $value ){?>
																<option <?php if($this->getObjectVariable($content,"tipo") == $key ){ echo "selected"; }?> value="<?php echo $key; ?>"> <?= $value; ?></option>
															<?php } ?>
														</select>
													</div>
													<div class="help-block with-errors"></div>
												</div>
																					
												<input type="hidden" name="id" id="id" value="<?= $content->id; ?>" />

												<div class="botones-acciones text-center my-1 d-none" id="btn_proyectos_<?= $id ?>">
													<button class="btn btn-guardar" type="submit">Guardar</button>
													<button class="btn btn-cancelar" type="button" onclick="deshabilitar_form_proyectos(<?= $id ?>)">Cancelar</button>
												</div>
											</div>
											<div class="row">
												<div class="col-12" id="proyectos_msm_<?= $id ?>">

												</div>
											</div>
										</div>
									</div>

								</form>

								<hr>

								<!-- Nav tabs -->
								<ul class="nav nav-tabs my-4 nav-custom" id="myTabCotizaciones<?= $id ?>" role="tablist">
									<li class="nav-item" role="presentation">
										<button class="nav-link active" id="seguimiento-tab<?= $id ?>" data-bs-toggle="tab" data-bs-target="#seguimiento<?= $id ?>" type="button" role="tab" aria-controls="seguimiento<?= $id ?>" aria-selected="true">Seguimientos</button>
									</li>
								</ul>

								<!-- Tab content -->
								<div class="tab-content" id="myTabCotizacionesContent<?= $id ?>">

									<!-- Proyectos Tab -->
									<div class="tab-pane fade show active" id="seguimiento<?= $id ?>" role="tabpanel" aria-labelledby="seguimiento-tab<?= $id ?>">
										<div class="card mt-2">
											<div class="card-header">Seguimientos</div>
											<div class="card-body">
												<iframe id="iframe_seguimientos<?php echo $id; ?>" width="100%" height="600" frameborder="0" src="about:blank"></iframe>
											</div>
										</div>
									</div>
								</div>
								
							</div>

				    	</div>
				  	</div>
				</div>
			<?php } ?>


			<?php foreach($this->programaciones as $key3 => $content){?>
				<?php $id =  $content->id; ?>
				<!-- Modal -->
				<div class="modal fade text-start" id="modal_detalle_programacion<?= $id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				  	<div class="modal-dialog modal-md" role="document">
				    	<div class="modal-content ">
							<div class="modal-body">
								<div class="row">
									<div class="col-lg-12">
										<div class="caja_azul">
											<div class="d-flex justify-content-between align-items-center h-100">
												<b class="titulo_dashboard"><i class="fa-solid fa-business-time icon-dash"></i> Detalle del seguimiento</b>
												<div class="me-2">
													<button type="button" class="close btn-cerrar-modal" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row px-3">
									<div class="col-lg-12 mt-3 mb-3">
										<span class="detail-modal">Cliente: <?= $this->list_cliente_id[$content->client_id];?></span><br>
										<span class="detail-modal"><div class="card-title">Proyecto: <?= $this->list_proyectos[$content->proyecto_id];?></div></span>
									</div>
									<div class="col-lg-12 mb-3">
										<div class="input-group">
											<input type="text" value="<?= $content->fecha; ?>" name="fecha" id="fecha" class="form-control"   disabled >
										</div>
										<div class="help-block with-errors"></div>
									</div>
									<div class="col-lg-12 mb-3">
										<textarea name="seguimiento" id="seguimiento"   class="form-control tinyeditor" rows="2"  disabled ><?= $content->seguimiento; ?></textarea>
										<div class="help-block with-errors"></div>
									</div>
									<div class="col-lg-12 mb-3">
										<div class="input-group">
											<input type="text" value="<?= $content->programar; ?>" name="programar" id="programar" class="form-control" disabled  >
										</div>
										<div class="help-block with-errors"></div>
									</div>
								</div>
							</div>
				    	</div>
				  	</div>
				</div>
				<div class="modal fade text-start" id="modal_editar_programacion<?= $id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				  	<div class="modal-dialog modal-md" role="document">
				    	<div class="modal-content ">
							<div class="modal-body">
								<form class="text-start" enctype="multipart/form-data" method="post" action="/page/seguimientoproyecto/insert">
									<div class="row">
										<div class="col-lg-12">
											<div class="caja_azul">
												<div class="d-flex justify-content-between align-items-center h-100">
													<b class="titulo_dashboard"><i class="fa-solid fa-business-time icon-dash"></i> Reprogamar el seguimiento</b>
													<div class="me-2">
														<button type="button" class="close btn-cerrar-modal" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="row px-3">
										<div class="col-lg-12 mt-3 mb-3">
											<span class="detail-modal">Cliente: <?= $this->list_cliente_id[$content->client_id];?></span><br>
											<span class="detail-modal"><div class="card-title">Proyecto: <?= $this->list_proyectos[$content->proyecto_id];?></div></span>
										</div>
										<div class="col-lg-12 mb-3">
											<div class="input-group">
												<input type="datetime-local" value="<?= $content->fecha; ?>" name="fecha" id="fecha" class="form-control datetimepicker-input" data-bs-toggle="datetimepicker" data-bs-target="#fecha" required >
											</div>
											<div class="help-block with-errors"></div>
										</div>
										<div class="col-lg-12 mb-3">
											<textarea name="seguimiento" id="seguimiento"   class="form-control tinyeditor" rows="2"><?= $content->seguimiento; ?></textarea>
											<div class="help-block with-errors"></div>
										</div>
										<div class="col-lg-12 mb-3">
											<div class="input-group">
											<input type="datetime-local" value="<?= $content->programar; ?>" name="programar" id="programar" class="form-control datetimepicker-input" data-bs-toggle="datetimepicker" data-bs-target="#fecha" required >
											</div>
											<div class="help-block with-errors"></div>
										</div>

										<input type="hidden" name="proyecto_id" value="<?= $content->proyecto_id ?>">
										<input type="hidden" name="reprogramar" id="reprogramar" value="<?= $content->id ?>">
										<input type="hidden" name="hash" value="1">
										<input type="hidden" name="csrf" id="csrf" value="<?php echo $this->csrf ?>">
										<input type="hidden" name="csrf_section" id="csrf_section" value="<?php echo $this->csrf_section ?>">

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
			<?php } ?>


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



<script>
	function mas_proyectos(){
		var cantidad = $("#cantidad_proyectos").val();
		cantidad = Number(cantidad);
		var i = 0;
		var nueva = cantidad+10;
		for(i=cantidad;i<=nueva; i++){
			$("#div_proyectos"+i).show();
		}
		$("#cantidad_proyectos").val(nueva);
	}

	function mas_proyectos2() {
		var cantidad = $("#cantidad_proyectos2").val();
		cantidad = Number(cantidad);
		var nueva = cantidad + 10;
		for (var i = cantidad; i <= nueva; i++) {
			$("#div_proyectos2" + i).show();
		}
		$("#cantidad_proyectos2").val(nueva);
	}


	function mas_clientes(){
		var cantidad = $("#cantidad_clientes").val();
		cantidad = Number(cantidad);
		var i = 0;
		var nueva = cantidad+10;
		for(i=cantidad;i<=nueva; i++){
			$("#div_clientes_mas"+i).show();
		}
		$("#cantidad_clientes").val(nueva);
	}

	function mas_seguimientos(){
		var cantidad = $("#cantidad_seguimientos").val();
		cantidad = Number(cantidad);
		var i = 0;
		var nueva = cantidad+6;
		for(i=cantidad;i<=nueva; i++){
			$("#div_seguimientos"+i).show();
		}
		$("#cantidad_seguimientos").val(nueva);
	}

</script>
<script>
	function adelante(){

		
		var maximo_clientes = Number('<?php echo count($this->clientes); ?>');
		maximo_clientes = Math.ceil(maximo_clientes/6)*6;

		var pagina_inicio = $("#pagina_inicio").val();
		pagina_inicio = Number(pagina_inicio);
		var pagina_fin = $("#pagina_fin").val();
		pagina_fin = Number(pagina_fin);	

		//console.log(pagina_fin+" >="+maximo_clientes);
		if(pagina_fin+6>=maximo_clientes){
			return;
		}

		$(".div_clientes").hide();


		pagina_inicio = pagina_inicio+6;
		pagina_fin = pagina_fin+6;
		var i = 0;

		if(maximo_clientes<pagina_fin){
			pagina_fin = maximo_clientes;
			pagina_inicio = Math.floor(maximo_clientes/6)*6;
		}
		
		for(i=pagina_inicio;i<=pagina_fin; i++){
			$("#div_cliente"+i).show();
		}
		$("#pagina_inicio").val(pagina_inicio);
		$("#pagina_fin").val(pagina_fin);

		$("#pagina_inicio1").html(pagina_inicio+1);
		$("#pagina_fin1").html(pagina_fin+1);

	}

	function atras(){

		$(".div_clientes").hide();

		var pagina_inicio = $("#pagina_inicio").val();
		pagina_inicio = Number(pagina_inicio);
		var pagina_fin = $("#pagina_fin").val();
		pagina_fin = Number(pagina_fin);		

		pagina_inicio = pagina_inicio-6;
		pagina_fin = pagina_fin-6;

		if(pagina_inicio<0){
			pagina_inicio=0;
		}
		if(pagina_fin<5){
			pagina_fin=5;
		}		

		var i = 0;
		
		for(i=pagina_inicio;i<=pagina_fin; i++){
			$("#div_cliente"+i).show();
		}
		$("#pagina_inicio").val(pagina_inicio);
		$("#pagina_fin").val(pagina_fin);

		$("#pagina_inicio1").html(pagina_inicio+1);
		$("#pagina_fin1").html(pagina_fin+1);

	}	
</script>


<script>
function activar(x,id){
	if(x=='proyectos'){
		$('#row_proyecto'+id).show();
		$('#row_contacto'+id).hide(); 
		$('#boton_proyecto'+id).addClass('btn-primary'); 
		$('#boton_proyecto'+id).addClass('pestana_activa');
		$('#boton_proyecto'+id).removeClass('btn-secondary');  
		$('#boton_contacto'+id).removeClass('btn-primary'); 
		$('#boton_contacto'+id).removeClass('pestana_activa'); 
		$('#boton_contacto'+id).addClass('btn-secondary');		
	}
	if(x=='contactos'){
		$('#row_proyecto'+id).hide();
		$('#row_contacto'+id).show(); 
		$('#boton_contacto'+id).addClass('btn-primary'); 
		$('#boton_contacto'+id).addClass('pestana_activa');
		$('#boton_contacto'+id).removeClass('btn-secondary');  
		$('#boton_proyecto'+id).removeClass('btn-primary'); 
		$('#boton_proyecto'+id).removeClass('pestana_activa'); 
		$('#boton_proyecto'+id).addClass('btn-secondary');		
	}	
}	

function finalizar_seguimiento(id){
	var x = confirm("¿Está seguro que desea finalizar el seguimiento?");
	if(x === true){
		//console.log("Enviando ID:", id); // <-- Añadido
		$.post("/page/seguimientoproyecto/finalizar_seguimiento/", {
			id: id
		}, function(res) {
			//console.log("Respuesta:", res); // <-- Añadido
			$(".div_seguimientos" + id).hide();
		});
	}
}


</script>

<script type="text/javascript">
function filtrar_cliente(){
	var cliente1 = $("#cliente1").val();
	var cliente2 = $("#cliente2").val();
	window.location="/page/sistema/index/?cliente1="+cliente1+"#clientes";
}	
function filtrar_cliente2(){
	var cliente2 = $("#cliente2").val();
	window.location="/page/sistema/index/?cliente2="+cliente2+"#proyectos";
}

function filtrar_cliente3(){
	var cliente3 = $("#cliente3").val();
	window.location="/page/sistema/index/?cliente3="+cliente3+"#proyectosd";
}

function aprobar(id){

	var titulo = $("#titulo_proyecto"+id).val();
	var caprueba = $("#comentarios_aprueba_"+id).val();
	var cadmin = $("#comentarios_admin_"+id).val();
	
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

		window.location="/page/proyectos/dirigir/?r=dashboard";
	}
}

function no_aprobar(id){
	var titulo = $("#titulo_proyecto"+id).val();

	$("#btn_aprobar_"+id).prop("disabled", true);
	$("#btn_noaprobar_"+id).prop("disabled", true);

	var x = confirm("Esta seguro de no aprobar el proyecto: "+titulo+" ?");
	if(x===true){
		window.location="/page/proyectos/noaprobar/?id="+id+"&r=dashboard";
	}
}
</script>

<script>

	function habilitar_form(id) {
		
		$("#form_cliente_"+id+" :input:disabled").prop("disabled", false);
		$("#btn_cliente_"+id).removeClass("d-none");

	}

	function habilitar_form_cotizacion(id) {
		
		$("#form_cotizacion_"+id+" :input:disabled").prop("disabled", false);
		$("#btn_cotizacion_"+id).removeClass("d-none");

	}

	function habilitar_form_proyectos(id) {
		
		$("#form_proyectos_"+id+" :input:disabled").prop("disabled", false);
		$("#btn_proyectos_"+id).removeClass("d-none");

	}

	function deshabilitar_form(id) {
		
		$("#form_cliente_"+id+" :input").prop("disabled", true);
		$("#btn_cliente_"+id).addClass("d-none");
		$("#habilitar_form_"+id).prop("disabled", false);

	}

	function deshabilitar_form_cotizacion(id) {
		
		$("#form_cotizacion_"+id+" :input").prop("disabled", true);
		$("#btn_cotizacion_"+id).addClass("d-none");
		$("#habilitar_form_cotizacion_"+id).prop("disabled", false);

	}

	function deshabilitar_form_proyectos(id) {
		
		$("#form_proyectos_"+id+" :input").prop("disabled", true);
		$("#btn_proyectos_"+id).addClass("d-none");
		$("#habilitar_form_proyectos_"+id).prop("disabled", false);

	}
	
	function editar_cliente(id) {
	
		var formData = new FormData(document.getElementById("form_cliente_" + id));

		// Convertir FormData a JSON
		var jsonData = {};
		formData.forEach(function(value, key){
			jsonData[key] = value;
		});

		console.log('Datos a enviar:', jsonData);
	
		$.ajax({
			url: "/page/sistema/updatecliente",
			type: "POST",
			data: JSON.stringify(jsonData), // Enviando como JSON
			processData: false,
			contentType: false,
			success: function(response) {
				console.log(response);
				let html;
				if (response.err == 1) {
					html = '<div class="alert alert-success" role="alert">Datos actualizados correctamente.</div>';
				}
				
				$("#cliente_msm_" + id).html(html);

				location.reload(true);
			},
			error: function() {
				$("#cliente_msm_" + id).html('<div class="alert alert-danger" role="alert">Error al enviar la solicitud. Intenta nuevamente.</div>');
			}
		});

	}

	function editar_cotizacion(id) {
	
		var formData = new FormData(document.getElementById("form_cotizacion_" + id));

		// Convertir FormData a JSON
		var jsonData = {};
		formData.forEach(function(value, key){
			jsonData[key] = value;
		});

		console.log('Datos a enviar:', jsonData);

		$.ajax({
			url: "/page/sistema/updatecotizacion",
			type: "POST",
			data: JSON.stringify(jsonData), // Enviando como JSON
			processData: false,
			contentType: false,
			success: function(response) {
				console.log(response);
				let html;
				if (response.err == 1) {
					html = '<div class="alert alert-success" role="alert">Datos actualizados correctamente.</div>';
				}
				
				$("#cotizacion_msm_" + id).html(html);

				location.reload(true);
			},
			error: function() {
				$("#cotizacion_msm_" + id).html('<div class="alert alert-danger" role="alert">Error al enviar la solicitud. Intenta nuevamente.</div>');
			}
		});

	}

	function editar_proyectos(id) {
	
		var formData = new FormData(document.getElementById("form_proyectos_" + id));

		// Convertir FormData a JSON
		var jsonData = {};
		formData.forEach(function(value, key){
			jsonData[key] = value;
		});

		console.log('Datos a enviar:', jsonData);

		$.ajax({
			url: "/page/sistema/updateproyectos",
			type: "POST",
			data: JSON.stringify(jsonData), // Enviando como JSON
			processData: false,
			contentType: false,
			success: function(response) {
				console.log(response);
				let html;
				if (response.err == 1) {
					html = '<div class="alert alert-success" role="alert">Datos actualizados correctamente.</div>';
				}
				
				$("#proyectos_msm_" + id).html(html);

				location.reload(true);
			},
			error: function() {
				$("#proyectos_msm_" + id).html('<div class="alert alert-danger" role="alert">Error al enviar la solicitud. Intenta nuevamente.</div>');
			}
		});

	}

	function isNumberKey(evt) {
		var charCode = (evt.which) ? evt.which : event.keyCode;
		if (charCode > 31 && (charCode < 48 || charCode > 57)){
		return false;
		}
		return true;
	}

	var isReloading = false; 
	function recargar(id) {
		if (!isReloading) {
			var iframe = document.getElementById('iframe_proyecto' + id);
			if (iframe) {
				console.log("entra");
				iframe.src = iframe.src;
				isReloading = true;
			}
		}
	}

	$(document).ready(function() {
		// Seleccionar todos los <td> que contengan números de celular
		$('td#numero_cel').each(function() {
			console.log($(this).val());
			// Obtener el texto dentro del <td>
			let celular = $(this).text().trim();

			// Si el número tiene 10 dígitos, aplicar el formato
			if (celular.length === 10 && celular.startsWith('3')) {
				celular = celular.replace(/(\d{3})(\d{3})(\d{4})/, '$1-$2-$3');
			}

			// Reemplazar el contenido del <td> con el número formateado
			$(this).text(celular);
		});
	});

	$(document).ready(function() {
		// Asigna el evento usando delegación
		$(document).on('click', '#terminar_proyecto', function(e) {
			e.preventDefault();

			// Muestra el cuadro de confirmación
			var confirmar = confirm("¿Estás seguro de que deseas terminar el proyecto?");

			// Si el usuario confirma, ejecuta el proceso
			if (confirmar) {
				// Llamada AJAX para evitar la recarga de la página
				var url = $(this).attr('href');
				$.ajax({
					url: url,
					method: 'POST',
					success: function(response) {
						if (response.success) {
							// Oculta el tr correspondiente
							$(e.target).closest('tr').hide();
							alert('Proyecto terminado exitosamente.');
						} else {
							alert('Hubo un error al terminar el proyecto.');
						}
					},
					error: function() {
						alert('Hubo un error al procesar la solicitud.');
					}
				});
			}
		});
	});




</script>


<script>
    cambiar_datos()
    function cambiar_datos() {
        var cliente = $("#client_id").val();
        console.log(cliente);
        $.post("/page/seguimientoproyecto/buscarProyectos", {
            "cliente": cliente
        }, function(res) {
            arrayProyectos(res);
        });
    }

    function arrayProyectos(res) {

        $('#proyectos_seg').empty().append('<option value="">Proyecto</option');

        for (let index = 0; index < res.length; index++) {
            if (typeof res !== 'undefined' && res[index]['texto'] !== '') {
                
                const option = $("<option>", {
                    value: res[index]['valor'],
                    text: res[index]['texto']
                });

                $("#proyectos_seg").append(option);
            }
        }
    }
</script>