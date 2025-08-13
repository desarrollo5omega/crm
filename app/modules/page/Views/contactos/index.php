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
	</style>
<?php }?>

<h1 class="titulo-principal ocultar_detalle"><i class="fas fa-cogs"></i> <?php echo $this->titlesection; ?></h1>
<div class="container-fluid">
	<form class="ocultar_detalle" action="<?php echo $this->route."?cliente=".$this->cliente.""; ?>" method="post">
        <div class="content-dashboard">
            <div class="row">
				<div class="col-lg-3">
		            <label>Nombres</label>
		            <label class="input-group">
						<span class="input-group-text input-icono" ><i class="fas fa-pencil-alt"></i></span>
		            	<input type="text" class="form-control" name="nombres" value="<?php echo $this->getObjectVariable($this->filters, 'nombres') ?>"></input>
		            </label>
		        </div>
				<div class="col-lg-3">
		            <label>Primer Apellido</label>
		            <label class="input-group">
						<span class="input-group-text input-icono fondo-verde-claro " ><i class="fas fa-pencil-alt"></i></span>
		            <input type="text" class="form-control" name="apellido1" value="<?php echo $this->getObjectVariable($this->filters, 'apellido1') ?>"></input>
		            </label>
		        </div>
				<div class="col-lg-3">
		            <label>Segundo Apellido</label>
		            <label class="input-group">
						<span class="input-group-text input-icono fondo-cafe " ><i class="fas fa-pencil-alt"></i></span>
		            <input type="text" class="form-control" name="apellido2" value="<?php echo $this->getObjectVariable($this->filters, 'apellido2') ?>"></input>
		            </label>
		        </div>
				<div class="col-lg-3">
		            <label>Categor��a</label>
		            <label class="input-group">
						<span class="input-group-text input-icono fondo-verde " ><i class="fas fa-pencil-alt"></i></span>
		            <input type="text" class="form-control" name="categoria" value="<?php echo $this->getObjectVariable($this->filters, 'categoria') ?>"></input>
		            </label>
		        </div>
				<div class="col-lg-3">
		            <label>Correo</label>
		            <label class="input-group">
						<span class="input-group-text input-icono fondo-rosado " ><i class="fas fa-pencil-alt"></i></span>
		            <input type="text" class="form-control" name="email" value="<?php echo $this->getObjectVariable($this->filters, 'email') ?>"></input>
		            </label>
		        </div>
				<div class="col-lg-3">
		            <label>Correo alternativo</label>
		            <label class="input-group">
						<span class="input-group-text input-icono fondo-morado " ><i class="fas fa-pencil-alt"></i></span>
		            <input type="text" class="form-control" name="email2" value="<?php echo $this->getObjectVariable($this->filters, 'email2') ?>"></input>
		            </label>
		        </div>
				<div class="col-lg-3">
		            <label>Tel��fono</label>
		            <label class="input-group">
						<span class="input-group-text input-icono fondo-rojo-claro " ><i class="fas fa-pencil-alt"></i></span>
		            <input type="text" class="form-control" name="celular" value="<?php echo $this->getObjectVariable($this->filters, 'celular') ?>"></input>
		            </label>
		        </div>
				<div class="col-lg-3">
		            <label>Celular</label>
		            <label class="input-group">
						<span class="input-group-text input-icono fondo-azul-claro " ><i class="fas fa-pencil-alt"></i></span>
		            <input type="text" class="form-control" name="celular2" value="<?php echo $this->getObjectVariable($this->filters, 'celular2') ?>"></input>
		            </label>
		        </div>
				<div class="col-lg-3">
		            <label>Fecha creaci��n</label>
		            <label class="input-group">
						<span class="input-group-text input-icono fondo-verde-claro " ><i class="fas fa-pencil-alt"></i></span>
		            <input type="text" class="form-control" name="fecha_c" value="<?php echo $this->getObjectVariable($this->filters, 'fecha_c') ?>"></input>
		            </label>
		        </div>
				<div class="col-lg-3 d-none">
		            <label>quien</label>
		            <label class="input-group">
						<span class="input-group-text input-icono fondo-azul-claro " ><i class="fas fa-pencil-alt"></i></span>
		            <input type="text" class="form-control" name="quien" value="<?php echo $this->getObjectVariable($this->filters, 'quien') ?>"></input>
		            </label>
		        </div>
				<div class="col-lg-3 d-none">
		            <label>cliente_id</label>
		            <label class="input-group">
						<span class="input-group-text input-icono fondo-rosado " ><i class="fas fa-pencil-alt"></i></span>
		            <input type="text" class="form-control" name="cliente_id" value="<?php echo $this->getObjectVariable($this->filters, 'cliente_id') ?>"></input>
		            </label>
		        </div>
				<div class="col-lg-3 d-none">
		            <label>observacion</label>
		            <label class="input-group">
						<span class="input-group-text input-icono fondo-cafe " ><i class="fas fa-pencil-alt"></i></span>
		            <input type="text" class="form-control" name="observacion" value="<?php echo $this->getObjectVariable($this->filters, 'observacion') ?>"></input>
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
	                echo '<li class="page-item" ><a class="page-link"  href="'.$url.'?page='.($this->page-1).'&cliente='.$this->cliente.'"> &laquo; Anterior </a></li>';
	            for ($i=1;$i<=$this->totalpages;$i++) {
	                if ($this->page == $i)
	                    echo '<li class="active page-item"><a class="page-link">'.$this->page.'</a></li>';
	                else
	                    echo '<li class="page-item"><a class="page-link" href="'.$url.'?page='.$i.'&cliente='.$this->cliente.'">'.$i.'</a></li>  ';
	            }
	            if ($this->page != $this->totalpages)
	                echo '<li class="page-item"><a class="page-link" href="'.$url.'?page='.($this->page+1).'&cliente='.$this->cliente.'">Siguiente &raquo;</a></li>';
	        }
	  	?>
	  	</ul>
	</div>
	<div class="content-dashboard">
	    <div class="franja-paginas ">
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
		    	<div class="col-lg-3">
		    		<div class="text-end"><a class="btn btn-sm btn-success" target="_self" href="<?php echo $this->route."\manage"."?cliente=".$this->cliente.""; ?>&detalle=1"> <i class="fas fa-plus-square"></i> Crear Nuevo</a></div>
		    	</div>
		    </div>
	    </div>
		<div class="content-table">
		<table class=" table table-striped table-des table-hover table-administrator text-start">
			<thead>
				<tr>
					<td><b>nombres</b></td>
					<td><b>apellido1</b></td>
					<td><b>apellido2</b></td>
					<td><b>categoria</b></td>
					<td><b>email</b></td>
					<td><b>celular</b></td>
					<td><b>fecha c.</b></td>

					<td width="100" class="ocultar_detalle"></td>
				</tr>
			</thead>
			<tbody style="word-break: break-all;">
				<?php foreach($this->lists as $content){ ?>
				<?php $id =  $content->id; ?>
					<tr>
						<td><?=$content->nombres;?></td>
						<td><?=$content->apellido1;?></td>
						<td><?=$content->apellido2;?></td>
						<td><?=$content->categoria;?></td>
						<td><?=$content->email;?></td>
	
						<td><?=$content->celular;?></td>

						<td><?=$content->fecha_c;?></td>
	
						<td class="text-end ocultar_detalle">
							<div>
								<a class="btn btn-azul btn-sm" href="<?php echo $this->route;?>/manage?id=<?= $id ?>" data-bs-toggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-pen-alt"></i></a>
								<span data-bs-toggle="tooltip" data-placement="top" title="Eliminar"><a class="btn btn-rojo btn-sm" data-bs-toggle="modal" data-bs-target="#modal<?= $id ?>"  ><i class="fas fa-trash-alt" ></i></a></span>
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
								        	<a class="btn btn-danger" href="<?php echo $this->route;?>/delete?id=<?= $id ?>&csrf=<?= $this->csrf;?><?php echo ''.'&cliente='.$this->cliente; ?>" >Eliminar</a>
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
	                echo '<li class="page-item"><a class="page-link" href="'.$url.'?page='.($this->page-1).'&cliente='.$this->cliente.'"> &laquo; Anterior </a></li>';
	            for ($i=1;$i<=$this->totalpages;$i++) {
	                if ($this->page == $i)
	                    echo '<li class="active page-item"><a class="page-link">'.$this->page.'</a></li>';
	                else
	                    echo '<li class="page-item"><a class="page-link" href="'.$url.'?page='.$i.'&cliente='.$this->cliente.'">'.$i.'</a></li>  ';
	            }
	            if ($this->page != $this->totalpages)
	                echo '<li class="page-item"><a class="page-link" href="'.$url.'?page='.($this->page+1).'&cliente='.$this->cliente.'">Siguiente &raquo;</a></li>';
	        }
	  	?>
	  	</ul>
	</div>
</div>