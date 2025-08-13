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

</style>




	<div class="container-fluid">


		<div class="row">
			<div class="col-12">
				<h1 class="titulo-principal ocultar_detalle"><i class="fas fa-cogs"></i> Inicio</h1>
			</div>

			<a id="clientes" name="clientes"></a>
			<div class="col-12">
				<div class="row">
					<div class="col-8">

						<div class="col-lg-12 mt-4 content-dashboard">
							
							<div class="caja_azul"><b class="titulo_dashboard">Últimos clientes</b></div>


							<div class="gris_claro" align="right" style="margin-top: -30px; margin-right:10px;">
								Registros <span id="pagina_inicio1">1</span> al <span id="pagina_fin1" style="margin-right: 10px;">6</span>
								<a style="cursor: pointer;" onclick="atras();"><i class="fas fa-chevron-circle-left gris_claro"></i></a> <a style="cursor: pointer;" onclick="adelante();"><i class="fas fa-chevron-circle-right gris_claro"></i></a>
								<input type="hidden" id="pagina_inicio" value="0">
								<input type="hidden" id="pagina_fin" value="5">

							</div>


								<div class="col-12 mt-2">
	
	                <label class="input-group">
	                	<label></label>
                  	<select class="form-select" id="cliente1" onchange="filtrar_cliente();">
                      <option value="">Todos los clientes</option>
                      <?php foreach ($this->list_cliente_id as $key => $value) : ?>
                          <option value="<?= $key; ?>" <?php if ($_GET['cliente1']==$key) { echo "selected";} ?>><?= $value; ?></option>
                      <?php endforeach ?>
                  	</select>
	               </label>
	            	</div>

							<div class="content-table">
								<table width="100%" border="0" class="table table-striped">
									<thead>
										<tr>
											<th>Nombre empresa</th>
											<th>Contacto principal</th>
											<th>Teléfono</th>
											<th>Correo</th>
	
											<th></th>
										</tr>	
									</thead>
									<tbody>					
										<?php foreach($this->clientes as $key => $content){?>
											<?php $id =  $content->id; ?>
										<tr class="div_clientes" id="div_cliente<?php echo $key; ?>" <?php if($key>5){ echo 'style="display:none";'; } ?>>
											<td><?=$content->nombre;?></td>
											<td><?=$content->contacto_principal;?></td>
											<td><?=$content->telefono;?> - <?=$content->celular;?></td>
											<td><div title="<?=$content->email;?>" style="word-break: break-all"><?=$content->email;?></div></td>

											<td>

												<span data-bs-toggle="tooltip" data-placement="top" title="Detalle"><a class="btn btn-azul-claro btn-sm" data-bs-toggle="modal" data-bs-target="#modal_detalle<?= $id ?>" onclick="document.getElementById('iframe_proyecto<?php echo $id; ?>').src='/page/proyectos/?cliente=<?php echo $id; ?>&detalle=1&cleanfilter=1&page=1'; document.getElementById('iframe_contacto<?php echo $id; ?>').src='/page/contactos/?cliente=<?php echo $id; ?>&detalle=1&cleanfilter=1&page=1';" ><i class="fas fa-info-circle"></i></a></span>		
											</td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>

						</div>

						<a id="proyectos" name="proyectos"></a>
						<div class="col-lg-12 mt-4 content-dashboard">
							
							<div class="caja_azul"><b class="titulo_dashboard">Proyectos en proceso de aprobación</b></div>

								<div class="col-lg-12">
									<label></label>
	                <label class="input-group">
                  	<select class="form-select" id="cliente2" onchange="filtrar_cliente2();">
                      <option value="">Todos los clientes</option>
                      <?php foreach ($this->list_cliente_id as $key => $value) : ?>
                          <option value="<?= $key; ?>" <?php if ($_GET['cliente2']==$key) { echo "selected";} ?>><?= $value; ?></option>
                      <?php endforeach ?>
                  	</select>
	               </label>
	            	</div>


							<div class="content-table">
								<table width="100%" border="0" class="table table-striped">
									<thead>
										<tr>
											<th>Cliente</th>
											<th>Nombre proyecto</th>
											<th>Tipo</th>
											<th>Fecha</th>
											<th></th>
										</tr>		
									</thead>				
									<tbody>
										<?php foreach($this->proyectos as $key2 => $content){?>
											<?php $id =  $content->id; ?>
											<?php $total_proyectos+=(int)$content->valor; ?>
										<tr id="div_proyectos<?php echo $key2; ?>" <?php if($key2>9){ echo 'style="display:none";'; } ?> >
											<td><?= $this->list_cliente_id[$content->cliente_id];?></td>
											<td><?=$content->nombre;?></td>
											<td><?= $this->list_tipo[$content->tipo];?></td>
											
											<td><?= $content->fecha_c;?></td>
											<td>
												<span data-bs-toggle="tooltip" data-placement="top" title="Detalle"><a class="btn btn-amarillo btn-sm" data-bs-toggle="modal" data-bs-target="#modal_detalle_proyecto<?= $id ?>" onclick="document.getElementById('iframe_seguimientos<?= $id ?>').src='/page/seguimientoproyecto/?proyecto=<?= $id ?>&detalle=1&cleanfilter=1&page=1';"  ><i class="fas fa-info-circle"></i></a></span>
											</td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>


							<div align="center"><b>Total valor proyectos: $<?php echo formato_pesos($total_proyectos); ?></b></div>

							<div align="center" class="mt-2 mb-4"><button type="button" class="btn btn-primary" onclick="mas_proyectos()">Ver más</button></div>
							<input type="hidden" value="9" id="cantidad_proyectos">

						</div>

						<div class="col-lg-12 mt-4 content-dashboard">
							
							<div><b class="titulo_dashboard">Próximas programaciones</b></div>
							<div class="content-table">
								<table width="100%" border="0" class="table table-striped">
									<thead>
										<tr>
											<th>Cliente</th>
											<th>Nombre proyecto</th>
											<th>Fecha programada</th>
											<th></th>
										</tr>		
									</thead>				
									<tbody>
										<?php foreach($this->programaciones as $key3 => $content){?>
											<?php $id =  $content->id; ?>
										<tr id="div_programaciones<?php echo $key3; ?>" <?php if($key3>9999){ echo 'style="display:none";'; } ?> class="div_programacion<?php echo $id; ?>" >
											<td><?= $this->list_cliente_id[$content->client_id];?></td>
											<td><?= $this->list_proyectos[$content->proyecto_id];?></td>
											<td><?= $content->programar;?></td>
											<td style="min-width: 130px;">
												<span data-bs-toggle="tooltip" data-placement="top" title="Detalle"><a class="btn btn-amarillo btn-sm" data-bs-toggle="modal" data-bs-target="#modal_detalle_programacion<?= $id ?>" ><i class="fas fa-info-circle"></i></a></span>

												<span data-bs-toggle="tooltip" data-placement="top" title="Finalizar seguimiento"><a class="btn btn-primary btn-sm" onclick="finalizar_seguimiento('<?= $id ?>')" style="cursor: pointer; color: white;"  ><i class="far fa-calendar-times"></i></a></span>

												<span data-bs-toggle="tooltip" data-placement="top" title="Reprogramar"><a class="btn btn-primary btn-sm" target="_top" href="/page/seguimientoproyecto/manage/?proyecto=<?php echo $content->proyecto_id; ?>&reprogramar=<?php echo $id ?>" ><i class="far fa-calendar-plus"></i></a></span>
											</td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>



						</div>												

					</div>





					<div class="col-4 mt-4">
						<div><b class="titulo_dashboard">Proyectos aprobados</b></div>
						<div style="border: 1px solid #CCCCCC; min-height: 500px;">
							
							<?php $keys = array_keys($this->meses); ?>
							<?php foreach($this->meses as $key => $value){ ?>

								<?php
								$anterior = $keys[array_search($key, $keys)-1];
								$siguiente = $keys[array_search($key, $keys)+1];
								?>

								<div align="center" id="mes<?php echo $key; ?>" class="div_aprobados content-table" <?php if($key != date("m")){ echo 'style="display: none;"'; } ?>>
									<a style="cursor: pointer;" onclick="ir_a_mes('<?php echo $anterior ?>');"><i class="fas fa-chevron-circle-left"></i></a> <b><?php echo $value; ?></b> <a style="cursor: pointer;" onclick="ir_a_mes('<?php echo $siguiente ?>');"><i class="fas fa-chevron-circle-right"></i></a>
									<table width="100%" class="table table-striped" >
										<thead>
											<tr>
												<th>Cliente</th>
												<th>Nombre proyecto</th>
												<th>Valor</th>
											</tr>
										</thead>
										<tbody style="word-break: break-all;">
											<?php $total=0; ?>
											<?php foreach($this->array_aprobados[$key] as $content){ ?>
												<?php $total+=(int)$content->valor; ?>
												<tr>
													<td><?= $this->list_cliente_id[$content->cliente_id];?></td>
													<td><?=$content->nombre;?></td>
													<td style="word-break: normal;">$<?= formato_pesos($content->valor);?></td>
												</tr>
											<?php } ?>
											<tr>
												<td></td>
												<td><b>Total</b></td>
												<td style="word-break: normal;"><b>$<?= formato_pesos($total);?></b></td>
											</tr>
										</tbody>
									</table>
								</div>

							<?php } ?>

						</div>
					</div>
				</div>
			</div>

			






		
	</div>

</div>


<div style="height: 50px;"></div>

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
				      		<div class="modal-header">
				        		<h4 class="modal-title" id="myModalLabel">Detalle</h4>
				        		<button type="button" class="close btn-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				      		</div>
					      	<div class="modal-body">

									<div class="row">
										<div class="col-12 text-end">
											<a href="/page/clientes/manage/?id=<?php echo $content
											->id;?>"><button type="button" class="btn btn-primary btn-sm">Editar</button></a>
										</div>
									</div>

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
									<div class="col-lg-4 form-group d-none">
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
									<div class="col-lg-4 form-group d-none">
										<label   class="control-label">Activo</label>
											<input type="checkbox" name="activo" value="1" class="form-control switch-form " <?php if ($this->getObjectVariable($this->content, 'activo') == 1) { echo "checked";} ?>  disabled ></input>
											<div class="help-block with-errors"></div>
									</div>

								</div>

								<hr>

								<button id="boton_proyecto<?php echo $id; ?>" type="button" class="btn btn-primary pestana_activa" onclick="activar('proyectos','<?php echo $id; ?>');">Proyectos</button> <button id="boton_contacto<?php echo $id; ?>" type="button" class="btn btn-secondary" onclick="activar('contactos','<?php echo $id; ?>');">Contactos</button>



								<div class="row mt-2" id="row_proyecto<?php echo $id; ?>">
									<iframe id="iframe_proyecto<?php echo $id; ?>" width="100%" height="600" frameborder="0" src="about:blank"></iframe>
								</div>

								<div class="row mt-2" id="row_contacto<?php echo $id; ?>" style="display: none;">
									<iframe id="iframe_contacto<?php echo $id; ?>" width="100%" height="600" frameborder="0" src="about:blank"></iframe>
								</div>								

					      	</div>

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
											<label for="documento1" >Documentos relacionados</label>

											<br>
											<?php if($content->documento1!=""){ ?>
												<a style="color: #FFFFFF" onclick="document.getElementById('iframe_pdf').src='/images/<?php echo $content->documento1; ?>';"  class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal_pdf" ><i class="fas fa-file-download" data-bs-toggle="tooltip" data-placement="top" title="Documento1"></i></a> 
											<?php } ?>
											<?php if($content->documento2!=""){ ?>
												<a style="color: #FFFFFF" onclick="document.getElementById('iframe_pdf').src='/images/<?php echo $content->documento2; ?>';" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal_pdf" ><i class="fas fa-file-download" data-bs-toggle="tooltip" data-placement="top" title="Documento2"></i></a> 
											<?php } ?>
											<?php if($content->documento3!=""){ ?>
												<a style="color: #FFFFFF" onclick="document.getElementById('iframe_pdf').src='/images/<?php echo $content->documento3; ?>';" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal_pdf" ><i class="fas fa-file-download" data-bs-toggle="tooltip" data-placement="top" title="Documento3"></i></a> 
											<?php } ?>																						

										</div>										

									</div>

										<hr>
										<div class="row mt-2">
											<iframe id="iframe_seguimientos<?php echo $id; ?>" width="100%" height="600" frameborder="0" src="about:blank"></iframe>
										</div>

								</div>

							</form>							      		

				      	</div>

				    	</div>
				  	</div>
				</div>	
			<?php } ?>


			<?php foreach($this->programaciones as $key3 => $content){?>
				<?php $id =  $content->id; ?>
				<!-- Modal -->
				<div class="modal fade text-start" id="modal_detalle_programacion<?= $id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				  	<div class="modal-dialog modal-lg" role="document">
				    	<div class="modal-content ">
				      		<div class="modal-header">
				        		<h4 class="modal-title" id="myModalLabel">

											<div>Cliente: <?= $this->list_cliente_id[$content->client_id];?></div>
											<div>Proyecto: <?= $this->list_proyectos[$content->proyecto_id];?></div>				        			

				        		</h4>
				        		<button type="button" class="close btn-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				      	</div>
				      	<div class="modal-body">


							<form class="text-start">
								<div class="content-dashboard">
								
									
									<div class="row">
										<div class="col-lg-4 form-group">
											<label for="fecha"  class="control-label">Fecha del seguimiento</label>
											<label class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text input-icono  fondo-rosado " ><i class="fas fa-pencil-alt"></i></span>
												</div>
												<input type="text" value="<?= $content->fecha; ?>" name="fecha" id="fecha" class="form-control"   disabled >
											</label>
											<div class="help-block with-errors"></div>
										</div>
										<div class="col-lg-12 form-group">
											<label for="seguimiento" class="form-label" >Descripci&oacute;n del seguimiento</label>
											<textarea name="seguimiento" id="seguimiento"   class="form-control tinyeditor" rows="10"  disabled ><?= $content->seguimiento; ?></textarea>
											<div class="help-block with-errors"></div>
										</div>
										<div class="col-lg-4 form-group">
											<label for="programar"  class="control-label">Programar nuevo seguimiento</label>
											<label class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text input-icono  fondo-verde-claro " ><i class="fas fa-pencil-alt"></i></span>
												</div>
												<input type="text" value="<?= $content->programar; ?>" name="programar" id="programar" class="form-control" disabled  >
											</label>
											<div class="help-block with-errors"></div>
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
				        		<button type="button" class="close btn-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
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
	var x = confirm("esta seguro que desea finalizar el seguimiento?");
	if(x===true){
	  $.post("/page/seguimientoproyecto/finalizar_seguimiento/", {
	    "id": id,
	  }, function(res) {
	  			$(".div_programacion"+id).hide();
	  });
	}
}


</script>

<script type="text/javascript">
function filtrar_cliente(){
	var cliente1 = $("#cliente1").val();
	var cliente2 = $("#cliente2").val();
	window.location="/page/sistema/index/?cliente1="+cliente1+"&cliente2="+cliente2+"#clientes";
}	
function filtrar_cliente2(){
	var cliente1 = $("#cliente1").val();
	var cliente2 = $("#cliente2").val();
	window.location="/page/sistema/index/?cliente1="+cliente1+"&cliente2="+cliente2+"#proyectos";
}	
</script>