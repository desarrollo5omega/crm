<?php if($_GET['detalle']=="1"){ ?>
	<style>
	.ocultar_detalle{
		display:none;
	}
	.header-menu{
		display: none;
	}
	#div_menu,.div_menu2{
		display: none;
	}
	.div10{
		max-width: 100%;
		flex: 0 0 100%;
	}

	  .modal-lg, .modal-xl {
	    max-width: 95%;
	  }

	</style>

	<h1>Proyectos</h1>
<?php }?>


<h1 class="titulo-principal ocultar_detalle"><i class="fas fa-cogs"></i> <?php echo $this->titlesection; ?></h1>
<div class="container-fluid">
	<form action="<?php echo $this->route."?detalle=".$_GET['detalle']."&cliente=".$_GET['cliente']; ?>" method="post">
        <div class="content-dashboard">
            <div class="row">
				<div class="col ocultar_detalle">
					<label>Cliente</label>
	                <label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono fondo-rosado " ><i class="far fa-list-alt"></i></span>
						</div>
	                    <select class="form-select" name="cliente_id">
	                        <option value="">Todos</option>
	                        <?php foreach ($this->list_cliente_id as $key => $value) : ?>
	                            <option value="<?= $key; ?>" <?php if ($this->getObjectVariable($this->filters, 'cliente_id') ==  $key) { echo "selected";} ?>><?= $value; ?></option>
	                        <?php endforeach ?>
	                    </select>
	               </label>
	            </div>
				<div class="col ocultar_detalle">
		            <label>Nombre</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-rojo-claro " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="nombre" value="<?php echo $this->getObjectVariable($this->filters, 'nombre') ?>"></input>
		            </label>
		        </div>
				<div class="col ocultar_detalle">
					<label>Tipo</label>
	                <label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono fondo-cafe " ><i class="far fa-list-alt"></i></span>
						</div>
	                    <select class="form-select" name="tipo">
	                        <option value="">Todos</option>
	                        <?php foreach ($this->list_tipo as $key => $value) : ?>
	                            <option value="<?= $key; ?>" <?php if ($this->getObjectVariable($this->filters, 'tipo') ==  $key) { echo "selected";} ?>><?= $value; ?></option>
	                        <?php endforeach ?>
	                    </select>
	               </label>
	            </div>
				<div class="col d-none ocultar_detalle">
		            <label>Valor</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-morado " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="valor" value="<?php echo $this->getObjectVariable($this->filters, 'valor') ?>"></input>
		            </label>
		        </div>

				<div class="col ">
					<label>Estado</label>
	                <label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono fondo-azul " ><i class="far fa-list-alt"></i></span>
						</div>
	                    <select class="form-select" name="estado">
	                        <option value="">Todos</option>
	                        <?php foreach ($this->list_estado as $key => $value) : ?>
	                            <option value="<?= $key; ?>" <?php if ($this->getObjectVariable($this->filters, 'estado') ==  $key) { echo "selected";} ?>><?= $value; ?></option>
	                        <?php endforeach ?>
	                    </select>
	               </label>
	            </div>
				<div class="col ocultar_detalle">
		            <label>Fecha creación</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-azul " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="fecha_c" value="<?php echo $this->getObjectVariable($this->filters, 'fecha_c') ?>"></input>
		            </label>
		        </div>	            
                <div class="col">
                    <label>&nbsp;</label>
                    <button type="submit" class="btn btn-block btn-azul"> <i class="fas fa-filter"></i> Filtrar</button>
                </div>
                <div class="col">
                    <label>&nbsp;</label>
                    <a class="btn btn-block btn-azul-claro " href="<?php echo $this->route; ?>?cleanfilter=1&cliente=<?php echo $_GET['cliente']; ?>&detalle=<?php echo $_GET['detalle']; ?>" > <i class="fas fa-eraser"></i> Limpiar</a>
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
	<div class="content-dashboard">
	    <div class="franja-paginas">
		    <div class="row">
		    	<div class="col-5 <?php if($_GET['detalle']=="1"){ echo 'col-lg-9'; } ?>">
		    		<div class="titulo-registro">Se encontraron <?php echo $this->register_number; ?> Registros</div>
		    	</div>
		    	<div class="col-lg-3 text-end ocultar_detalle">
		    		<div class="texto-paginas">Registros por pagina:</div>
		    	</div>
		    	<div class="col-1 ocultar_detalle">
		    		<select class="form-control form-control-sm selectpagination">
		    			<option value="20" <?php if($this->pages == 20){ echo 'selected'; } ?>>20</option>
		    			<option value="30" <?php if($this->pages == 30){ echo 'selected'; } ?>>30</option>
		    			<option value="50" <?php if($this->pages == 50){ echo 'selected'; } ?>>50</option>
		    			<option value="100" <?php if($this->pages == 100){ echo 'selected'; } ?>>100</option>
		    		</select>
		    	</div>

		    	<?php if($_GET['detalle']==""){ ?>
			    	<div class="col-lg-3">
			    		<div class="text-end"><a class="btn btn-sm btn-success" href="<?php echo $this->route."\manage"; ?>?cliente=<?php echo $_GET['cliente']; ?>"> <i class="fas fa-plus-square"></i> Crear Nuevo</a></div>
			    	</div>
		    	<?php }else{ ?>
		    		<div class="col-lg-3">
			    		<div class="text-end"><a class="btn btn-sm btn-success" target="_top" href="<?php echo $this->route."\manage"; ?>?cliente=<?php echo $_GET['cliente']; ?>"> <i class="fas fa-plus-square"></i> Crear Nuevo</a></div>
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
		<table class=" table table-striped  table-hover table-administrator text-start">
			<thead>
				<tr>
					<td>Fecha creación</td>
					<td width="40%">Nombre</td>

					<td>Valor</td>
					<td>Cliente</td>
					<td style="min-width: 180px;"></td>
				</tr>
			</thead>
			<tbody>
				<?php foreach($this->lists as $content){ ?>
				<?php $id =  $content->id; ?>
					<tr>
						<td><?=$content->fecha_c;?></td>
						<td><?=$content->nombre;?></td>
	
						<td>$ <?=formato_pesos($content->valor);?></td>
						<td><?= $this->list_cliente_id[$content->cliente_id];?></td>

			
			
						<td  class="text-end">
							<div class="">
								<a class="btn btn-azul btn-sm" href="<?php echo $this->route;?>/manage?id=<?= $id ?>" target="_top" data-bs-toggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-pen-alt"></i></a>
								
								<span data-bs-toggle="tooltip" data-placement="top" title="Detalle" class=""><a class="btn btn-amarillo btn-sm" data-bs-toggle="modal" data-bs-target="#modal_detalle<?= $id ?>"  ><i class="fas fa-info-circle"></i></a></span>

								<a class="btn btn-azul btn-sm ocultar_detalle" href="/page/seguimientoproyecto/?proyecto=<?= $id ?>" data-bs-toggle="tooltip" data-placement="top" title="Seguimientos"><i class="far fa-comment-dots"></i></a>

								<span data-bs-toggle="tooltip" data-placement="top" title="Eliminar" class="ocultar_detalle"><a class="btn btn-rojo btn-sm" data-bs-toggle="modal" data-bs-target="#modal<?= $id ?>"  ><i class="fas fa-trash-alt" ></i></a></span>
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
											</div>

										</form>							      		

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
        		<button type="button" class="close btn-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      	</div>
      	<div class="modal-body">
      			<iframe id="iframe_pdf" src="about:blank" width="100%" height="500"></iframe>
      	</div>

    	</div>
  	</div>
</div>	