<div class="container-fluid">
text-end
	<div class="text-right">

		<a class="btn btn-success" href="<?php echo $this->route."\manage"; ?>">Crear Nuevo</a>

	</div>

	<form action="<?php echo $this->route; ?>" method="post">

        <div class="container-fluid">

            <div class="row"><div class="form-group col-xs-3">

                    <label> </label>

                    <button type="submit" class="btn btn-block btn-primary">Filtrar</button>

                </div>

                <div class="form-group col-xs-3">

                    <label> </label>

                    <a class="btn btn-block btn-info" href="<?php echo $this->route; ?>?cleanfilter=1" >Limpiar Filtro</a>

                </div>

            </div>

        </div>

    </form>

    <div align="center">

		<ul class="pagination">

	    <?php

	    	$url = $this->route;

	        if ($this->totalpages > 1) {

	            if ($this->page != 1)

	                echo '<li><a href="'.$url.'?page='.($this->page-1).'"> &laquo; Anterior </a></li>';

	            for ($i=1;$i<=$this->totalpages;$i++) {

	                if ($this->page == $i)

	                    echo '<li class="active"><a class="paginaactual">'.$this->page.'</a></li>';

	                else

	                    echo '<li><a href="'.$url.'?page='.$i.'">'.$i.'</a></li>  ';

	            }

	            if ($this->page != $this->totalpages) {

	                echo '<li><a href="'.$url.'?page='.($this->page+1).'">Siguiente &raquo;</a></li>';

				}

	        }

	  	?>

	  	</ul>

	</div>

    <div class="franja-paginas">

	    <div class="row">

	    	<div class="col-xs-6"><div class="titulo-registro">Se encontraron <?php echo $this->register_number; ?> Registros</div></div>

	    	<div class="col-xs-4 text-right">

	    		<div class="texto-paginas">Registros por pagina:</div>

	    	</div>

	    	<div class="col-xs-2">

	    		<select class="form-control selectpagination">

	    			<option value="20" <?php if($this->pages == 20){ echo 'selected'; } ?>>20</option>

	    			<option value="30" <?php if($this->pages == 30){ echo 'selected'; } ?>>30</option>

	    			<option value="50" <?php if($this->pages == 50){ echo 'selected'; } ?>>50</option>

	    			<option value="100" <?php if($this->pages == 100){ echo 'selected'; } ?>>100</option>

	    		</select>

	    	</div>

	    </div>

    </div>

	<div>

		<table class=" table table-striped  table-hover table-administrator text-start">

			<thead>

				<tr>

					<td width="250"></td>

				</tr>

			</thead>

			<tbody>

				<?php foreach($this->lists as $content){ ?>

				<?php $id =  $content->id; ?>

					<tr>

						<td class="text-right">

							<div>

								<a class="btn btn-primary btn-xs" href="<?php echo $this->route;?>/manage?id=<?= $id ?>"><i class="glyphicon glyphicon-pencil"></i> Editar</a>

								<a class="btn btn-danger btn-xs" data-bs-toggle="modal" data-bs-target="#modal<?= $id ?>" ><i class="glyphicon glyphicon-trash"></i> Eliminar</a>

							</div>

							<!-- Modal -->

							<div class="modal fade text-start" id="modal<?= $id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

							  	<div class="modal-dialog" role="document">

							    	<div class="modal-content">

							      		<div class="modal-header">

										  	<button type="button" class="close btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

							        		<h4 class="modal-title" id="myModalLabel">Eliminar Registro</h4>

							      	</div>

							      	<div class="modal-body">

							        	<div class="">¿Esta seguro de eliminar este registro?</div>

							      	</div>

								      <div class="modal-footer">

								        	<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>

								        	<a class="btn btn-danger" href="<?php echo $this->route;?>/delete?id=<?= $id ?>&csrf=<?= $this->csrf;?>" >Eliminar</a>

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

	<div align="center">

		<ul class="pagination">

	    <?php

	    	$url = $this->route;

	        if ($this->totalpages > 1) {

	            if ($this->page != 1)

	                echo '<li><a href="'.$url.'?page='.($this->page-1).'"> &laquo; Anterior </a></li>';

	            for ($i=1;$i<=$this->totalpages;$i++) {

	                if ($this->page == $i)

	                    echo '<li class="active"><a class="paginaactual">'.$this->page.'</a></li>';

	                else

	                    echo '<li><a href="'.$url.'?page='.$i.'">'.$i.'</a></li>  ';

	            }

	            if ($this->page != $this->totalpages)

	                echo '<li><a href="'.$url.'?page='.($this->page+1).'">Siguiente &raquo;</a></li>';

	        }

	  ?>

	  </ul>

	</div>

</div>