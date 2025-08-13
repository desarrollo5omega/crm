<h1 class="titulo-principal"><i class="fas fa-cogs"></i> <?php echo $this->titlesection; ?></h1>
<div class="container-fluid">
	<div class="col-12 text-end margin10"><button class="btn btn-warning btn-sm" onclick="$('#div_filtro').toggle();">Ver filtro</button> <a class="btn btn-success" href="/administracion/actascomite/">Regresar</a></div>
	<form action="<?php echo $this->route; ?>" method="post" id="div_filtro" style="display: none;">
        <div class="content-dashboard">
            <div class="row">
				<div class="col-3">
		            <label>cedula</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-verde-claro " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="cedula" value="<?php echo $this->getObjectVariable($this->filters, 'cedula') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>linea</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-morado " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="linea" value="<?php echo $this->getObjectVariable($this->filters, 'linea') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>validacion</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-rosado " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="validacion" value="<?php echo $this->getObjectVariable($this->filters, 'validacion') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>nombres</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-cafe " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="nombres" value="<?php echo $this->getObjectVariable($this->filters, 'nombres') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>apellido1</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-azul " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="apellido1" value="<?php echo $this->getObjectVariable($this->filters, 'apellido1') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>apellido2</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-rojo-claro " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="apellido2" value="<?php echo $this->getObjectVariable($this->filters, 'apellido2') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
					<label>asignado</label>
	                <label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono fondo-verde " ><i class="far fa-list-alt"></i></span>
						</div>
	                    <select class="form-select" name="asignado">
	                        <option value="">Todas</option>
	                        <?php foreach ($this->list_asignado as $key => $value) : ?>
	                            <option value="<?= $key; ?>" <?php if ($this->getObjectVariable($this->filters, 'asignado') ==  $key) { echo "selected";} ?>><?= $value; ?></option>
	                        <?php endforeach ?>
	                    </select>
	               </label>
	            </div>
				<div class="col-3">
		            <label>fecha asignado</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-azul-claro " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="fecha_asignado" value="<?php echo $this->getObjectVariable($this->filters, 'fecha_asignado') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>pagare</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-rosado " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="pagare" value="<?php echo $this->getObjectVariable($this->filters, 'pagare') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
					<label>quien</label>
	                <label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono fondo-azul-claro " ><i class="far fa-list-alt"></i></span>
						</div>
	                    <select class="form-select" name="quien">
	                        <option value="">Todas</option>
	                        <?php foreach ($this->list_quien as $key => $value) : ?>
	                            <option value="<?= $key; ?>" <?php if ($this->getObjectVariable($this->filters, 'quien') ==  $key) { echo "selected";} ?>><?= $value; ?></option>
	                        <?php endforeach ?>
	                    </select>
	               </label>
	            </div>
				<div class="col-3">
					<label>estado autorizo</label>
	                <label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono fondo-morado " ><i class="far fa-list-alt"></i></span>
						</div>
	                    <select class="form-select" name="estado_autorizo">
	                        <option value="">Todas</option>
	                        <?php foreach ($this->list_estado_autorizo as $key => $value) : ?>
	                            <option value="<?= $key; ?>" <?php if ($this->getObjectVariable($this->filters, 'estado_autorizo') ==  $key) { echo "selected";} ?>><?= $value; ?></option>
	                        <?php endforeach ?>
	                    </select>
	               </label>
	            </div>
                <div class="col-3">
                    <label>&nbsp;</label>
                    <button type="submit" class="btn btn-block btn-azul"> <i class="fas fa-filter"></i> Filtrar</button>
                </div>
                <div class="col-3">
                    <label>&nbsp;</label>
                    <a class="btn btn-block btn-azul-claro " href="<?php echo $this->route; ?>?id=<?php echo $this->id; ?>cleanfilter=1" > <i class="fas fa-eraser"></i> Limpiar Filtro</a>
                </div>
            </div>
        </div>
        <input type="hidden" name="id" value="<?php echo $this->id; ?>">
    </form>

    <div class="col-12">
    	<h4>Solicitudes en el acta</h4>
    	<div class="col-12">
    		<table width="100%" bgcolor="#CCCCCC" cellpadding="5">
    			<tr>
    				<th>Número</th>
    				<th>Documento</th>
    				<th>Nombre</th>
    				<th>Modalidad</th>
    				<th>Valor</th>
    				<th></th>
    			</tr>
    			<?php foreach ($this->items as $key => $item): ?>
	      			<tr>
	    				<td><?php echo $id = $item->solicitud->id; ?></td>
	    				<td><?php echo $item->solicitud->cedula; ?></td>
	    				<td><?php echo $item->solicitud->nombres; ?> <?php echo $item->solicitud->nombres2; ?> <?php echo $item->solicitud->apellido1; ?> <?php echo $item->solicitud->apellido2; ?></td>
	    				<td><?php echo $this->list_linea_desembolso[$item->solicitud->linea_desembolso]; ?></td>
	    				<td>$<?php echo number_format($item->solicitud->valor); ?></td>
	    				<td><a class="btn btn-rojo btn-sm" href="/administracion/actascomite/quitar/?id=<?= $id ?>&acta=<?php echo $this->id; ?>" data-bs-toggle="tooltip" data-placement="top" title="Quitar del acta"><i class="fas fa-minus-square"></i></a></td>
	    			</tr>
    			<?php endforeach ?>
    		</table>
    	</div>
    </div>

	<?php
		$validaciones = array("En estudio","Aprobado","Contabilizado","Anulado","Rechazado","Procesado");
	?>
	<div align="left" class="d-none">
		<?php
	    $estilo = "";
	    if($_GET['i']=="" and $_GET['incompletas']=="" and $_GET['sin_terminar']==""){
	        $estilo="background:#7CB33E; ";
	    }
	    ?>
	    <a href="/administracion/solicitudes/" class="btn btn-primary btn-sm" style=" <?php echo $estilo; ?>">Todas</a> &nbsp;
	    <?php for($i=0;$i<=5;$i++){?>
	    <?php
	    $estilo = "";
	    if($_GET['i']==$i and $_GET['i']!=""){
	        $estilo="background:#7CB33E; ";
	    }
	    ?>
	    	<a href="/administracion/solicitudes/?i=<?php echo $i; ?>" class="btn btn-primary btn-sm" style=" <?php echo $estilo; ?>"><?php echo $validaciones[$i]; ?></a> &nbsp;
		<?php }?>

		<?php
	    $estilo = "";
	    if($_GET['incompletas']=="1"){
	        $estilo="background:#7CB33E; ";
	    }
		?>
	    <a href="/administracion/solicitudes/?incompletas=1" class="btn btn-primary btn-sm" style=" <?php echo $estilo; ?>">Incompletas</a> &nbsp;
		<?php
	    $estilo = "";
	    if($_GET['sin_terminar']=="1"){
	        $estilo="background:#7CB33E; ";
	    }
		?>
	    <a href="/administracion/solicitudes/?sin_terminar=1" class="btn btn-primary btn-sm" style=" <?php echo $estilo; ?>">Sin terminar</a> &nbsp;
	</div>

    <div align="center" class="margin10">
		<ul class="pagination justify-content-center">
	    <?php
	    	$url = $this->route;
	        if ($this->totalpages > 1) {
	            if ($this->page != 1)
	                echo '<li class="page-item" ><a class="page-link"  href="'.$url.'?page='.($this->page-1).'&id='.$_GET['id'].'"> &laquo; Anterior </a></li>';
	            for ($i=1;$i<=$this->totalpages;$i++) {
	                if ($this->page == $i)
	                    echo '<li class="active page-item"><a class="page-link">'.$this->page.'</a></li>';
	                else
	                    echo '<li class="page-item"><a class="page-link" href="'.$url.'?page='.$i.'&id='.$_GET['id'].'">'.$i.'</a></li>  ';
	            }
	            if ($this->page != $this->totalpages)
	                echo '<li class="page-item"><a class="page-link" href="'.$url.'?page='.($this->page+1).'&id='.$_GET['id'].'">Siguiente &raquo;</a></li>';
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
		    	<div class="col-3 text-end">
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
		    	<div class="col-3 d-none">
		    		<div class="text-end"><a class="btn btn-sm btn-success" href="<?php echo $this->route."\manage"; ?>"> <i class="fas fa-plus-square"></i> Crear Nuevo</a></div>
		    	</div>
		    </div>
	    </div>
		<div class="content-table">
		<table class=" table table-striped  table-hover table-administrator text-start">
			<thead>
				<tr>
					<td>ID</td>
					<td>cedula</td>
					<td>linea</td>
					<td>estado</td>
					<td>nombres</td>
					<td>apellido1</td>
					<td>apellido2</td>
					<td>asignado a</td>
					<td>fecha asignado</td>
					<td>pagare</td>
					<td>aprobado por</td>
					<td>VBo</td>
				</tr>
			</thead>
			<tbody>
				<?php foreach($this->lists as $content){ ?>
				<?php $id =  $content->id; ?>
					<tr>
						<td><?=$content->id;?></td>
						<td><?=$content->cedula;?></td>
						<td><?php echo $content->linea_desembolso ?></td>
						<td><?php echo $this->validaciones[$content->validacion]; ?></td>
						<td><?=$content->nombres;?></td>
						<td><?=$content->apellido1;?></td>
						<td><?=$content->apellido2;?></td>
						<td><?= $this->list_asignado[$content->asignado];?>
						<td><?=$content->fecha_asignado;?></td>
						<td><?=$content->pagare;?></td>
						<td><?= $this->list_quien[$content->quien];?>
						<td><?= $this->list_estado_autorizo[$content->estado_autorizo];?>
					</tr>
					<tr>
						<td colspan="12" class="text-end">
							<div>
								<a class="btn btn-azul btn-sm" href="/administracion/actascomite/agregar/?id=<?= $id ?>&acta=<?php echo $this->id; ?>" data-bs-toggle="tooltip" data-placement="top" title="Agregar al acta"><i class="fas fa-plus-square"></i></a>
								<a class="btn btn-rojo btn-sm" href="/administracion/actascomite/quitar/?id=<?= $id ?>&acta=<?php echo $this->id; ?>" data-bs-toggle="tooltip" data-placement="top" title="Quitar del acta"><i class="fas fa-minus-square"></i></a>

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