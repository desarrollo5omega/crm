<style>
  .modal-lg, .modal-xl {
    max-width: 95%;
  }
</style>

<h1 class="titulo-principal"><i class="fas fa-cogs"></i> <?php echo $this->titlesection; ?></h1>
<div class="container-fluid">
	<form action="<?php echo $this->route; ?>" method="post">
        <div class="content-dashboard">
            <div class="row">
				<div class="col-lg-3">
		            <label>Nombre empresa</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-azul-claro " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="nombre" value="<?php echo $this->getObjectVariable($this->filters, 'nombre') ?>"></input>
		            </label>
		        </div>
				<div class="col-lg-3 d-none">
		            <label>Contacto principal</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-cafe " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="contacto_principal" value="<?php echo $this->getObjectVariable($this->filters, 'contacto_principal') ?>"></input>
		            </label>
		        </div>
				<div class="col-lg-3">
		            <label>Documento</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-azul " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="documento" value="<?php echo $this->getObjectVariable($this->filters, 'documento') ?>"></input>
		            </label>
		        </div>
				<div class="col-lg-3 d-none">
					<label>Tipo documento</label>
	                <label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono fondo-verde-claro " ><i class="far fa-list-alt"></i></span>
						</div>
	                    <select class="form-select" name="tipo_documento">
	                        <option value="">Todas</option>
	                        <?php foreach ($this->list_tipo_documento as $key => $value) : ?>
	                            <option value="<?= $key; ?>" <?php if ($this->getObjectVariable($this->filters, 'tipo_documento') ==  $key) { echo "selected";} ?>><?= $value; ?></option>
	                        <?php endforeach ?>
	                    </select>
	               </label>
	            </div>
				<div class="col-lg-3 d-none">
		            <label>Direccion</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-rosado " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="direccion" value="<?php echo $this->getObjectVariable($this->filters, 'direccion') ?>"></input>
		            </label>
		        </div>
				<div class="col-lg-3 d-none">
		            <label>Correo</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-verde " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="email" value="<?php echo $this->getObjectVariable($this->filters, 'email') ?>"></input>
		            </label>
		        </div>
				<div class="col-lg-3 d-none">
		            <label>Teléfono</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-morado " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="telefono" value="<?php echo $this->getObjectVariable($this->filters, 'telefono') ?>"></input>
		            </label>
		        </div>
				<div class="col-lg-3 d-none">
		            <label>Celular</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-rojo-claro " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="celular" value="<?php echo $this->getObjectVariable($this->filters, 'celular') ?>"></input>
		            </label>
		        </div>
				<div class="col-lg-3 d-none">
		            <label>Página web</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-rosado " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="pagina_web" value="<?php echo $this->getObjectVariable($this->filters, 'pagina_web') ?>"></input>
		            </label>
		        </div>
				<div class="col-lg-3">
					<label>Tipo</label>
	                <label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono fondo-rojo-claro " ><i class="far fa-list-alt"></i></span>
						</div>
	                    <select class="form-select" name="categoria">
	                        <option value="">Todas</option>
	                        <?php foreach ($this->list_categoria as $key => $value) : ?>
	                            <option value="<?= $key; ?>" <?php if ($this->getObjectVariable($this->filters, 'categoria') ==  $key) { echo "selected";} ?>><?= $value; ?></option>
	                        <?php endforeach ?>
	                    </select>
	               </label>
	            </div>
				<div class="col-lg-3 d-none">
					<label>Estado</label>
	                <label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono fondo-morado " ><i class="far fa-list-alt"></i></span>
						</div>
	                    <select class="form-select" name="estado">
	                        <option value="">Todas</option>
	                        <?php foreach ($this->list_estado as $key => $value) : ?>
	                            <option value="<?= $key; ?>" <?php if ($this->getObjectVariable($this->filters, 'estado') ==  $key) { echo "selected";} ?>><?= $value; ?></option>
	                        <?php endforeach ?>
	                    </select>
	               </label>
	            </div>
				<div class="col-lg-3">
					<label>Asignado</label>
	                <label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono fondo-azul-claro " ><i class="far fa-list-alt"></i></span>
						</div>
	                    <select class="form-select" name="asignado">
	                        <option value="">Todas</option>
	                        <?php foreach ($this->list_asignado as $key => $value) : ?>
	                            <option value="<?= $key; ?>" <?php if ($this->getObjectVariable($this->filters, 'asignado') ==  $key) { echo "selected";} ?>><?= $value; ?></option>
	                        <?php endforeach ?>
	                    </select>
	               </label>
	            </div>
				<div class="col-lg-3 d-none">
		            <label>Activo</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-cafe " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="activo" value="<?php echo $this->getObjectVariable($this->filters, 'activo') ?>"></input>
		            </label>
		        </div>
				<div class="col-lg-3 d-none">
		            <label>Quien</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-azul " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="quien" value="<?php echo $this->getObjectVariable($this->filters, 'quien') ?>"></input>
		            </label>
		        </div>
				<div class="col-lg-3 d-none">
		            <label>Fecha_c</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-verde-claro " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="fecha_c" value="<?php echo $this->getObjectVariable($this->filters, 'fecha_c') ?>"></input>
		            </label>
		        </div>
				<div class="col-lg-3 d-none">
		            <label>Fecha_a</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-verde " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="fecha_a" value="<?php echo $this->getObjectVariable($this->filters, 'fecha_a') ?>"></input>
		            </label>
		        </div>
                <div class="col-lg-3">
                    <label>&nbsp;</label>
                    <button type="submit" class="btn btn-block btn-azul"> <i class="fas fa-filter"></i> Filtrar</button>
                </div>
                <div class="col-lg-3">
                    <label>&nbsp;</label>
                    <a class="btn btn-block btn-azul-claro " href="<?php echo $this->route; ?>?cleanfilter=1" > <i class="fas fa-eraser"></i> Limpiar Filtro</a>
                </div>
            </div>
        </div>
    </form>
    <div align="center">
		<ul class="pagination justify-content-center">
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
	<div class="content-dashboard">
	    <div class="franja-paginas">
		    <div class="row">
		    	<div class="col-5">
		    		<div class="titulo-registro">Se encontraron <?php echo $this->register_number; ?> Registros</div>
		    	</div>
		    	<div class="col-lg-3 text-end">
		    		<div class="texto-paginas">Registros por pagina:</div>
		    	</div>
		    	<div class="col-1">
		    		<select class="form-control form-control-sm selectpagination">
		    			<option value="20" <?php if($this->pages == 20){ echo 'selected'; } ?>>20</option>
		    			<option value="30" <?php if($this->pages == 30){ echo 'selected'; } ?>>30</option>
		    			<option value="50" <?php if($this->pages == 50){ echo 'selected'; } ?>>50</option>
		    			<option value="100" <?php if($this->pages == 100){ echo 'selected'; } ?>>100</option>
		    		</select>
		    	</div>
		    	<div class="col-lg-3">
		    		<div class="text-end"><a class="btn btn-sm btn-success" href="<?php echo $this->route."\manage"; ?>"> <i class="fas fa-plus-square"></i> Crear Nuevo</a></div>
		    	</div>
		    </div>
	    </div>
		<div class="content-table">
		<table class=" table table-striped  table-hover table-administrator text-start" style="font-size: 14px;">
			<thead>
				<tr>
					<td>Nombre empresa</td>
					<td>Contacto principal</td>
					<td>Documento</td>
					<td>Correo</td>
					<td>Teléfono</td>
					<td>Celular</td>
					<td>Tipo</td>
					<td>Asignado</td>
					<td>Activo</td>
					<td>Fecha c.</td>
					<td>Fecha a.</td>

				</tr>
			</thead>
			<tbody>
				<?php foreach($this->lists as $content){ ?>
				<?php $id =  $content->id; ?>
					<tr>
						<td><?=$content->nombre;?></td>
						<td><?=$content->contacto_principal;?></td>
						<td><?=$content->documento;?></td>

						<td><div title="<?=$content->email;?>" style="max-width: 150px; overflow: hidden;"><?=$content->email;?></div></td>
						<td><?=$content->telefono;?></td>
						<td><?=$content->celular;?></td>

						<td><?= $this->list_categoria[$content->categoria];?>
						<td><?= $this->list_asignado[$content->asignado];?>
						<td><?=$content->activo;?></td>
						<td><?=$content->fecha_c;?></td>
						<td><?=$content->fecha_a;?></td>
					</tr>
					<tr>
						<td colspan="11" class="text-end">
							<div>
								<a class="btn btn-azul btn-sm" href="<?php echo $this->route;?>/manage?id=<?= $id ?>" data-bs-toggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-pen-alt"></i></a>

								<a class="btn btn-amarillo btn-sm" href="/page/contactos/?cliente=<?= $id ?>" data-bs-toggle="tooltip" data-placement="top" title="Contactos"><i class="fas fa-users"></i></a>

								<span data-bs-toggle="tooltip" data-placement="top" title="Detalle"><a class="btn btn-azul-claro btn-sm" data-bs-toggle="modal" data-bs-target="#modal_detalle<?= $id ?>"  ><i class="fas fa-info-circle"></i></a></span>								

								<a class="btn btn-verde btn-sm d-none" href="/page/seguimientos/?cliente=<?= $id ?>" data-bs-toggle="tooltip" data-placement="top" title="Seguimientos">seguimientos</a>

								<span data-bs-toggle="tooltip" data-placement="top" title="Eliminar"><a class="btn btn-rojo btn-sm" data-bs-toggle="modal" data-bs-target="#modal<?= $id ?>"  ><i class="fas fa-trash-alt" ></i></a></span>
							</div>
							<!-- Modal -->
							<div class="modal fade text-start" id="modal<?= $id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
							  	<div class="modal-dialog" role="document">
							    	<div class="modal-content">
							      		<div class="modal-header">
							        		<h4 class="modal-title" id="myModalLabel">Eliminar Registro</h4>
							        		<button type="button" class="close btn-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
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

						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
	<input type="hidden" id="csrf" value="<?php echo $this->csrf ?>"><input type="hidden" id="page-route" value="<?php echo $this->route; ?>/changepage">
	</div>
	 <div align="center">
		<ul class="pagination justify-content-center">
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