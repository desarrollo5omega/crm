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

<?php }?>


<h1 class="titulo-principal ocultar_detalle"><i class="fas fa-cogs"></i> <?php echo $this->titlesection; ?></h1>
<div class="container-fluid">
	<form class="ocultar_detalle" action="<?php echo $this->route."?proyecto=".$this->proyecto."&detalle=".$_GET['detalle']; ?>" method="post">
        <div class="content-dashboard">
            <div class="row">
				<div class="col">
		            <label>Fecha del seguimiento</label>
		            <div class="input-group">
						<span class="input-group-text input-icono" ><i class="fas fa-pencil-alt"></i></span>
		            	<input type="datetime-local" class="form-control" name="fecha" value="<?php echo $this->getObjectVariable($this->filters, 'fecha') ?>"></input>
					</div>
		        </div>
				<div class="col">
		            <label>Descripci&oacute;n del seguimiento</label>
		            <div class="input-group">
						<span class="input-group-text input-icono fondo-verde-claro " ><i class="fas fa-pencil-alt"></i></span>
		            	<input type="text" class="form-control" name="seguimiento" value="<?php echo $this->getObjectVariable($this->filters, 'seguimiento') ?>"></input>
					</div>
		        </div>
				<div class="col">
		            <label>Programar nuevo seguimiento</label>
		            <div class="input-group">
						<span class="input-group-text input-icono fondo-rojo-claro " ><i class="fas fa-pencil-alt"></i></span>
		            	<input type="text" class="form-control" name="programar" value="<?php echo $this->getObjectVariable($this->filters, 'programar') ?>"></input>
					</div>
		        </div>
				<div class="col">
					<label>Quien</label>
	                <div class="input-group">
						<span class="input-group-text input-icono"><i class="far fa-list-alt"></i></span>
	                    <select class="form-select" name="quien">
	                        <option value="">Todas</option>
	                        <?php foreach ($this->list_quien as $key => $value) : ?>
	                            <option value="<?= $key; ?>" <?php if ($this->getObjectVariable($this->filters, 'quien') ==  $key) { echo "selected";} ?>><?= $value; ?></option>
	                        <?php endforeach ?>
	                    </select>
					</div>
	            </div>
                <div class="col">
                    <label>&nbsp;</label>
                    <button type="submit" class="btn w-100 btn-azul"> <i class="fas fa-filter"></i> Filtrar</button>
                </div>
                <div class="col">
                    <label>&nbsp;</label>
                    <a class="btn w-100 btn-azul-claro " href="<?php echo $this->route; ?>?cleanfilter=1" > <i class="fas fa-eraser"></i> Limpiar Filtro</a>
                </div>

                <div class="col-lg-3 d-none">
                    <label>&nbsp;</label>
                    <a class="btn btn-block btn-amarillo " href="/page/proyectos" > <i class="fas fa-arrow-left"></i> Regresar</a>
                </div>

            </div>
        </div>
    </form>
    <div align="center" class="ocultar_detalle">
		<ul class="pagination justify-content-center ">
	    <?php
	    	$url = $this->route;
	        if ($this->totalpages > 1) {
	            if ($this->page != 1)
	                echo '<li class="page-item" ><a class="page-link"  href="'.$url.'?page='.($this->page-1).'&proyecto='.$this->proyecto.'"> &laquo; Anterior </a></li>';
	            for ($i=1;$i<=$this->totalpages;$i++) {
	                if ($this->page == $i)
	                    echo '<li class="active page-item"><a class="page-link">'.$this->page.'</a></li>';
	                else
	                    echo '<li class="page-item"><a class="page-link" href="'.$url.'?page='.$i.'&proyecto='.$this->proyecto.'">'.$i.'</a></li>  ';
	            }
	            if ($this->page != $this->totalpages)
	                echo '<li class="page-item"><a class="page-link" href="'.$url.'?page='.($this->page+1).'&proyecto='.$this->proyecto.'">Siguiente &raquo;</a></li>';
	        }
	  	?>
	  	</ul>
	</div>
	<div class="content-dashboard">
	    <div class="franja-paginas">
		    <div class="row">
		    	<div class="col-lg-5 <?php if($_GET['detalle']=="1"){ echo 'col-lg-9'; } ?>">
		    		<div class="titulo-registro">Se encontraron <?php echo $this->register_number; ?> Registros</div>
		    	</div>
		    	<div class="col-lg-3 text-end ocultar_detalle">
		    		<div class="texto-paginas">Registros por pagina:</div>
		    	</div>
		    	<div class="col-lg-1 ocultar_detalle">
		    		<select class="form-control form-control-sm selectpagination">
		    			<option value="20" <?php if($this->pages == 20){ echo 'selected'; } ?>>20</option>
		    			<option value="30" <?php if($this->pages == 30){ echo 'selected'; } ?>>30</option>
		    			<option value="50" <?php if($this->pages == 50){ echo 'selected'; } ?>>50</option>
		    			<option value="100" <?php if($this->pages == 100){ echo 'selected'; } ?>>100</option>
		    		</select>
		    	</div>
		    	<div class="col-lg-3">
		    		<div class="text-end"><a class="btn btn-sm btn-success" href="<?php echo $this->route."\manage"."?proyecto=".$this->proyecto.""; ?>&detalle=<?php echo $_GET['detalle']; ?>"> <i class="fas fa-plus-square"></i> Crear Nuevo</a></div>
		    	</div>
		    </div>
	    </div>
		<div class="content-table">
			<table class="table table-striped table-des table-hover table-administrator text-start">
				<thead>
					<tr>
						<td>Fecha del seguimiento</td>
						<td>Descripci&oacute;n del seguimiento</td>
						<td>Programar nuevo seguimiento</td>
						<td>quien</td>
						<td width="100"></td>
					</tr>
				</thead>
				<tbody>
					<?php foreach($this->lists as $content){ ?>
					<?php $id =  $content->id; ?>
						<tr>
							<td><?= formatoDMYH($content->fecha); ?></td>
							<td><?=$content->seguimiento;?></td>
							<td><?= formatoDMYH($content->programar); ?></td>
							<td><?= $this->list_quien[$content->quien];?>
							<td class="text-end">
								<div>
									<a class="btn btn-azul btn-sm" href="<?php echo $this->route;?>/manage?id=<?= $id ?>&detalle=<?php echo $_GET['detalle'] ?>" data-bs-toggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-pen-alt"></i></a>
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
												<a class="btn btn-danger" href="<?php echo $this->route;?>/delete?id=<?= $id ?>&csrf=<?= $this->csrf;?><?php echo ''.'&proyecto='.$this->proyecto; ?>&detalle=<?php echo $_GET['detalle'] ?>" >Eliminar</a>
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
	                echo '<li class="page-item"><a class="page-link" href="'.$url.'?page='.($this->page-1).'&proyecto='.$this->proyecto.'"> &laquo; Anterior </a></li>';
	            for ($i=1;$i<=$this->totalpages;$i++) {
	                if ($this->page == $i)
	                    echo '<li class="active page-item"><a class="page-link">'.$this->page.'</a></li>';
	                else
	                    echo '<li class="page-item"><a class="page-link" href="'.$url.'?page='.$i.'&proyecto='.$this->proyecto.'">'.$i.'</a></li>  ';
	            }
	            if ($this->page != $this->totalpages)
	                echo '<li class="page-item"><a class="page-link" href="'.$url.'?page='.($this->page+1).'&proyecto='.$this->proyecto.'">Siguiente &raquo;</a></li>';
	        }
	  	?>
	  	</ul>
	</div>
</div>