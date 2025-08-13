


	<div class="container">


		<div class="row">
			<div class="col-12">
				<h1 class="titulo-principal ocultar_detalle"><i class="fas fa-cogs"></i> Inicio</h1>
			</div>
			<div class="col-lg-12 mt-4 content-dashboard">
				
				<div><b class="titulo_dashboard">Últimos clientes</b></div>
				<div class="content-table">
					<table width="100%" border="1" class="table table-striped">
						<thead>
							<tr>
								<th>Nombre empresa</th>
								<th>Contacto principal</th>
								<th>Teléfono</th>
								<th>Correo</th>
								<th>Tipo</th>
								<th></th>
							</tr>	
						</thead>
						<tbody>					
							<?php foreach($this->clientes as $content){?>
							<tr>
								<td><?=$content->nombre;?></td>
								<td><?=$content->contacto_principal;?></td>
								<td><?=$content->telefono;?> <?=$content->celular;?></td>
								<td><div title="<?=$content->email;?>" style="max-width: 150px; overflow: hidden;"><?=$content->email;?></div></td>
								<td><?= $this->list_categoria[$content->categoria];?></td>
								<td>
									<span data-bs-toggle="tooltip" data-placement="top" title="Detalle"><a class="btn btn-azul-claro btn-sm" data-bs-toggle="modal" data-bs-target="#modal_detalle<?= $id ?>"  ><i class="fas fa-info-circle"></i></a></span>		
								</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>

			</div>

			<?php foreach($this->clientes as $content){?>
				<!-- Modal -->
				<div class="modal fade text-start" id="modal_detalle<?= $id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				  	<div class="modal-dialog modal-lg" role="document">
				    	<div class="modal-content">
				      		<div class="modal-header">
				        		<h4 class="modal-title" id="myModalLabel">Detalle</h4>
				        		<button type="button" class="close btn-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				      		</div>
					      	<div class="modal-body">

								<div class="row">
									<div class="col-lg-4 form-group">
										<label for="nombre"  class="control-label">Nombre empresa</label>
										<label class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text input-icono  fondo-verde " ><i class="fas fa-pencil-alt"></i></span>
											</div>
											<input type="text" value="<?= $content->nombre; ?>" name="nombre" id="nombre" class="form-control" disabled   >
										</label>
										<div class="help-block with-errors"></div>
									</div>

									<div class="col-lg-4 form-group">
										<label class="control-label">Tipo documento</label>
										<label class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text input-icono  fondo-azul " ><i class="far fa-list-alt"></i></span>
											</div>
											<select class="form-select" name="tipo_documento" disabled  >
												<option value="">Seleccione...</option>
												<?php foreach ($this->list_tipo_documento AS $key => $value ){?>
													<option <?php if($this->getObjectVariable($this->content,"tipo_documento") == $key ){ echo "selected"; }?> value="<?php echo $key; ?>" /> <?= $value; ?></option>
												<?php } ?>
											</select>
										</label>
										<div class="help-block with-errors"></div>
									</div>				
									<div class="col-lg-4 form-group">
										<label for="documento"  class="control-label">Número de documento</label>
										<label class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text input-icono  fondo-rosado " ><i class="fas fa-pencil-alt"></i></span>
											</div>
											<input type="number" value="<?= $content->documento; ?>" name="documento" id="documento" class="form-control" disabled  >
										</label>
										<div class="help-block with-errors"></div>
									</div>

									<div class="col-lg-4 form-group">
										<label for="email"  class="control-label">Correo</label>
										<label class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text input-icono  fondo-verde-claro " ><i class="fas fa-pencil-alt"></i></span>
											</div>
											<input type="text" value="<?= $content->email; ?>" name="email" id="email" class="form-control" disabled  >
										</label>
										<div class="help-block with-errors"></div>
									</div>
									<div class="col-lg-4 form-group">
										<label for="telefono"  class="control-label">Teléfono</label>
										<label class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text input-icono  fondo-cafe " ><i class="fas fa-pencil-alt"></i></span>
											</div>
											<input type="number" value="<?= $content->telefono; ?>" name="telefono" id="telefono" class="form-control"  disabled >
										</label>
										<div class="help-block with-errors"></div>
									</div>				

									<div class="col-lg-4 form-group">
										<label for="celular"  class="control-label">Celular</label>
										<label class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text input-icono  fondo-rojo-claro " ><i class="fas fa-pencil-alt"></i></span>
											</div>
											<input type="text" value="<?= $content->celular; ?>" name="celular" id="celular" class="form-control" disabled  >
										</label>
										<div class="help-block with-errors"></div>
									</div>				

									<div class="col-lg-4 form-group">
										<label for="contacto_principal"  class="control-label">Contacto principal</label>
										<label class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text input-icono  fondo-morado " ><i class="fas fa-pencil-alt"></i></span>
											</div>
											<input type="text" value="<?= $content->contacto_principal; ?>" name="contacto_principal" id="contacto_principal" class="form-control" disabled  >
										</label>
										<div class="help-block with-errors"></div>
									</div>


									<div class="col-lg-4 form-group">
										<label for="direccion"  class="control-label">Dirección</label>
										<label class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text input-icono  fondo-azul-claro " ><i class="fas fa-pencil-alt"></i></span>
											</div>
											<input type="text" value="<?= $content->direccion; ?>" name="direccion" id="direccion" class="form-control" disabled  >
										</label>
										<div class="help-block with-errors"></div>
									</div>


									<div class="col-lg-4 form-group">
										<label for="pagina_web"  class="control-label">Pagina web</label>
										<label class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text input-icono  fondo-verde " ><i class="fas fa-pencil-alt"></i></span>
											</div>
											<input type="text" value="<?= $content->pagina_web; ?>" name="pagina_web" id="pagina_web" class="form-control" disabled  >
										</label>
										<div class="help-block with-errors"></div>
									</div>
									<div class="col-lg-4 form-group">
										<label class="control-label">Tipo</label>
										<label class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text input-icono  fondo-rojo-claro " ><i class="far fa-list-alt"></i></span>
											</div>
											<select class="form-select" name="categoria" disabled  >
												<option value="">Seleccione...</option>
												<?php foreach ($this->list_categoria AS $key => $value ){?>
													<option <?php if($this->getObjectVariable($this->content,"categoria") == $key ){ echo "selected"; }?> value="<?php echo $key; ?>" /> <?= $value; ?></option>
												<?php } ?>
											</select>
										</label>
										<div class="help-block with-errors"></div>
									</div>
									<div class="col-lg-4 form-group d-none1">
										<label class="control-label">Estado</label>
										<label class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text input-icono  fondo-verde-claro " ><i class="far fa-list-alt"></i></span>
											</div>
											<select class="form-select" name="estado"  disabled >
												<option value="">Seleccione...</option>
												<?php foreach ($this->list_estado AS $key => $value ){?>
													<option <?php if($this->getObjectVariable($this->content,"estado") == $key ){ echo "selected"; }?> value="<?php echo $key; ?>" /> <?= $value; ?></option>
												<?php } ?>
											</select>
										</label>
										<div class="help-block with-errors"></div>
									</div>
									<div class="col-lg-4 form-group">
										<label class="control-label">Asignado</label>
										<label class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text input-icono  fondo-rosado " ><i class="far fa-list-alt"></i></span>
											</div>
											<select class="form-select" name="asignado" disabled  >
												<option value="">Seleccione...</option>
												<?php foreach ($this->list_asignado AS $key => $value ){?>
													<option <?php if($this->getObjectVariable($this->content,"asignado") == $key ){ echo "selected"; }?> value="<?php echo $key; ?>" /> <?= $value; ?></option>
												<?php } ?>
											</select>
										</label>
										<div class="help-block with-errors"></div>
									</div>
									<div class="col-lg-4 form-group">
										<label   class="control-label">Activo</label>
											<input type="checkbox" name="activo" value="1" class="form-control switch-form " <?php if ($this->getObjectVariable($this->content, 'activo') == 1) { echo "checked";} ?>  disabled ></input>
											<div class="help-block with-errors"></div>
									</div>

								</div>

								<hr>

								<div class="row">
									<iframe width="100%" height="600" frameborder="0" src="/page/proyectos/?cliente=<?php echo $id; ?>&detalle=1"></iframe>
								</div>

					      	</div>

				    	</div>
				  	</div>
				</div>
			<?php } ?>

			<div class="col-lg-12 mt-4 content-dashboard">
				
				<div><b class="titulo_dashboard">Proyectos en proceso de aprobación</b></div>
				<div class="content-table">
					<table width="100%" border="1" class="table table-striped">
						<thead>
							<tr>
								<th>Nombre proyecto</th>
								<th>Tipo</th>
								<th>Cliente</th>
								<th>Estado</th>
								<th>Fecha</th>
								<th></th>
							</tr>		
						</thead>				
						<tbody>
							<?php foreach($this->proyectos as $content){?>
							<tr>
								<td><?=$content->nombre;?></td>
								<td><?= $this->list_tipo[$content->tipo];?></td>
								<td><?= $this->list_cliente_id[$content->cliente_id];?></td>
								<td><?= $this->list_estado[$content->estado];?></td>
								<td><?= $content->fecha_c;?></td>
								<td>
									<span data-bs-toggle="tooltip" data-placement="top" title="Detalle"><a class="btn btn-amarillo btn-sm" data-bs-toggle="modal" data-bs-target="#modal_detalle_proyecto<?= $id ?>"  ><i class="fas fa-info-circle"></i></a></span>
								</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>

			</div>			


			<?php foreach($this->proyectos as $content){?>
				<!-- Modal -->
				<div class="modal fade text-start" id="modal_detalle_proyecto<?= $id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				  	<div class="modal-dialog modal-lg" role="document">
				    	<div class="modal-content ">
				      		<div class="modal-header">
				        		<h4 class="modal-title" id="myModalLabel">Detalle</h4>
				        		<button type="button" class="close btn-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				      	</div>
				      	<div class="modal-body">


							<form class="text-start">
								<div class="content-dashboard">
									
									
									<div class="row">
										<input type="hidden" name="fecha_c"  value="<?php echo $content->fecha_c ?>">
										<div class="col-lg-6 form-group">
											<label for="nombre"  class="control-label">Nombre del proyecto</label>
											<label class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text input-icono  fondo-rojo-claro " ><i class="fas fa-pencil-alt"></i></span>
												</div>
												<input type="text" value="<?= $content->nombre; ?>" name="nombre" id="nombre" class="form-control" disabled  >
											</label>
											<div class="help-block with-errors"></div>
										</div>
										<div class="col-lg-6 form-group">
											<label class="control-label">Tipo de proyecto</label>
											<label class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text input-icono  fondo-verde " ><i class="far fa-list-alt"></i></span>
												</div>
												<select class="form-select" name="tipo" disabled  >
													<option value="">Seleccione...</option>
													<?php foreach ($this->list_tipo AS $key => $value ){?>
														<option <?php if($this->getObjectVariable($content,"tipo") == $key ){ echo "selected"; }?> value="<?php echo $key; ?>" /> <?= $value; ?></option>
													<?php } ?>
												</select>
											</label>
											<div class="help-block with-errors"></div>
										</div>
										<div class="col-lg-6 form-group">
											<label for="valor"  class="control-label">Valor del proyecto</label>
											<label class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text input-icono  fondo-morado " ><i class="fas fa-pencil-alt"></i></span>
												</div>
												<input type="text" value="<?php if($content->valor!=""){ echo formato_pesos($content->valor); } ?>" name="valor" id="valor" class="form-control" onchange="puntitos(this)" onkeyup="puntitos(this)" disabled  >
											</label>
											<div class="help-block with-errors"></div>
										</div>
										<div class="col-lg-6 form-group">
											<label class="control-label">Cliente</label>
											<label class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text input-icono  fondo-verde-claro " ><i class="far fa-list-alt"></i></span>
												</div>
												<select class="form-select" name="cliente_id" disabled  >
													<option value="">Seleccione...</option>
													<?php foreach ($this->list_cliente_id AS $key => $value ){?>
														<option <?php if($this->getObjectVariable($content,"cliente_id") == $key ){ echo "selected"; }?> value="<?php echo $key; ?>" /> <?= $value; ?></option>
													<?php } ?>
												</select>
											</label>
											<div class="help-block with-errors"></div>
										</div>
										<div class="col-lg-6 form-group">
											<label class="control-label">Estado del proyecto</label>
											<label class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text input-icono  fondo-azul-claro " ><i class="far fa-list-alt"></i></span>
												</div>
												<select class="form-select" name="estado"  disabled >
													<option value="">Seleccione...</option>
													<?php foreach ($this->list_estado AS $key => $value ){?>
														<option <?php if($this->getObjectVariable($content,"estado") == $key ){ echo "selected"; }?> value="<?php echo $key; ?>" /> <?= $value; ?></option>
													<?php } ?>
												</select>
											</label>
											<div class="help-block with-errors"></div>
										</div>
										<div class="col-lg-6 form-group">
											<label for="documento1" >Cotización o documento</label>

											<?php if($content->documento1!=""){ ?>
												<br><a href="/images/<?php echo $content->documento1; ?>" target="_blank"><?php echo $content->documento1; ?></a>
											<?php } ?>

										</div>
										<div class="col-lg-6 form-group">
											<label for="documento2" >Cotización o documento</label>

											<?php if($content->documento2!=""){ ?>
												<br><a href="/images/<?php echo $content->documento2; ?>" target="_blank"><?php echo $content->documento2; ?></a>
											<?php } ?>														

										</div>
										<div class="col-lg-6 form-group">
											<label for="documento3" >Cotización o documento</label>

											<?php if($content->documento3!=""){ ?>
												<br><a href="/images/<?php echo $content->documento3; ?>" target="_blank"><?php echo $content->documento3; ?></a>
											<?php } ?>

										</div>
									</div>
								</div>

							</form>							      		

				      	</div>

				    	</div>
				  	</div>
				</div>	
			<?php } ?>



		
	</div>

</div>


<div align="center" style="position: fixed; left: 50%; top: 40%; margin-left: -100px; display: none;" id="loading"><img src="/corte/loading-gif.gif" width="200" /></div>

