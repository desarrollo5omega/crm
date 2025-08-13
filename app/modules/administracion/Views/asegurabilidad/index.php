<h1 class="titulo-principal"><i class="fas fa-cogs"></i> <?php echo $this->titlesection; ?></h1>
<div class="container-fluid">
	<form action="<?php echo $this->route; ?>" method="post">
        <div class="content-dashboard">
            <div class="row">
				<div class="col-3">
		            <label>solicitud</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-rojo-claro " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="solicitud" value="<?php echo $this->getObjectVariable($this->filters, 'solicitud') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>paso</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-rosado " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="paso" value="<?php echo $this->getObjectVariable($this->filters, 'paso') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
	                <label>fecha</label>
	                <label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-azul " ><i class="fas fa-calendar-alt"></i></span>
						</div>
	                <input type="text" class="form-control" name="fecha" value="<?php echo $this->getObjectVariable($this->filters, 'fecha') ?>"></input>
	                    </label>
	            </div>
				<div class="col-3">
		            <label>tipo_documento</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-azul-claro " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="tipo_documento" value="<?php echo $this->getObjectVariable($this->filters, 'tipo_documento') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>documento</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-cafe " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="documento" value="<?php echo $this->getObjectVariable($this->filters, 'documento') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>nombres</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-verde " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="nombres" value="<?php echo $this->getObjectVariable($this->filters, 'nombres') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>nombres2</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-morado " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="nombres2" value="<?php echo $this->getObjectVariable($this->filters, 'nombres2') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>apellido1</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-verde-claro " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="apellido1" value="<?php echo $this->getObjectVariable($this->filters, 'apellido1') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>apellido2</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-verde-claro " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="apellido2" value="<?php echo $this->getObjectVariable($this->filters, 'apellido2') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>fn_dia</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-cafe " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="fn_dia" value="<?php echo $this->getObjectVariable($this->filters, 'fn_dia') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>fn_mes</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-verde " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="fn_mes" value="<?php echo $this->getObjectVariable($this->filters, 'fn_mes') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>fn_anio</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-rojo-claro " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="fn_anio" value="<?php echo $this->getObjectVariable($this->filters, 'fn_anio') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>telefono_oficina</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-azul-claro " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="telefono_oficina" value="<?php echo $this->getObjectVariable($this->filters, 'telefono_oficina') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>correo_personal</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-rosado " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="correo_personal" value="<?php echo $this->getObjectVariable($this->filters, 'correo_personal') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>direccion_residencia</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-morado " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="direccion_residencia" value="<?php echo $this->getObjectVariable($this->filters, 'direccion_residencia') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>ciudad_residencia</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-azul " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="ciudad_residencia" value="<?php echo $this->getObjectVariable($this->filters, 'ciudad_residencia') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>sexo</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-verde " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="sexo" value="<?php echo $this->getObjectVariable($this->filters, 'sexo') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>celular</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-verde-claro " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="celular" value="<?php echo $this->getObjectVariable($this->filters, 'celular') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>ocupacion</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-morado " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="ocupacion" value="<?php echo $this->getObjectVariable($this->filters, 'ocupacion') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>estado_civil</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-azul " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="estado_civil" value="<?php echo $this->getObjectVariable($this->filters, 'estado_civil') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>peso</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-cafe " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="peso" value="<?php echo $this->getObjectVariable($this->filters, 'peso') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>estatura</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-rojo-claro " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="estatura" value="<?php echo $this->getObjectVariable($this->filters, 'estatura') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>prima</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-rosado " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="prima" value="<?php echo $this->getObjectVariable($this->filters, 'prima') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>prima_valor</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-azul-claro " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="prima_valor" value="<?php echo $this->getObjectVariable($this->filters, 'prima_valor') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>otra_cual</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-morado " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="otra_cual" value="<?php echo $this->getObjectVariable($this->filters, 'otra_cual') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>otra_cual2</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-rosado " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="otra_cual2" value="<?php echo $this->getObjectVariable($this->filters, 'otra_cual2') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>tiene</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-azul " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="tiene" value="<?php echo $this->getObjectVariable($this->filters, 'tiene') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>drogas</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-cafe " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="drogas" value="<?php echo $this->getObjectVariable($this->filters, 'drogas') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>alcoholismo</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-verde-claro " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="alcoholismo" value="<?php echo $this->getObjectVariable($this->filters, 'alcoholismo') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>drogadiccion</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-rojo-claro " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="drogadiccion" value="<?php echo $this->getObjectVariable($this->filters, 'drogadiccion') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>hospitalizado</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-azul-claro " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="hospitalizado" value="<?php echo $this->getObjectVariable($this->filters, 'hospitalizado') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>antecedentes</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-verde " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="antecedentes" value="<?php echo $this->getObjectVariable($this->filters, 'antecedentes') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>observaciones</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-morado " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="observaciones" value="<?php echo $this->getObjectVariable($this->filters, 'observaciones') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>cobertura</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-rojo-claro " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="cobertura" value="<?php echo $this->getObjectVariable($this->filters, 'cobertura') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>consecutivo</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-azul " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="consecutivo" value="<?php echo $this->getObjectVariable($this->filters, 'consecutivo') ?>"></input>
		            </label>
		        </div>
                <div class="col-3">
                    <label>&nbsp;</label>
                    <button type="submit" class="btn btn-block btn-azul"> <i class="fas fa-filter"></i> Filtrar</button>
                </div>
                <div class="col-3">
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
		    	<div class="col-3">
		    		<div class="text-end"><a class="btn btn-sm btn-success" href="<?php echo $this->route."\manage"; ?>"> <i class="fas fa-plus-square"></i> Crear Nuevo</a></div>
		    	</div>
		    </div>
	    </div>
		<div class="content-table">
		<table class=" table table-striped  table-hover table-administrator text-start">
			<thead>
				<tr>
					<td>solicitud</td>
					<td>paso</td>
					<td>fecha</td>
					<td>tipo_documento</td>
					<td>documento</td>
					<td>nombres</td>
					<td>nombres2</td>
					<td>apellido1</td>
					<td>apellido2</td>
					<td>fn_dia</td>
					<td>fn_mes</td>
					<td>fn_anio</td>
					<td>telefono_oficina</td>
					<td>correo_personal</td>
					<td>direccion_residencia</td>
					<td>ciudad_residencia</td>
					<td>sexo</td>
					<td>celular</td>
					<td>ocupacion</td>
					<td>estado_civil</td>
					<td>peso</td>
					<td>estatura</td>
					<td>prima</td>
					<td>prima_valor</td>
					<td>otra_cual</td>
					<td>otra_cual2</td>
					<td>tiene</td>
					<td>drogas</td>
					<td>alcoholismo</td>
					<td>drogadiccion</td>
					<td>hospitalizado</td>
					<td>antecedentes</td>
					<td>observaciones</td>
					<td>cobertura</td>
					<td>consecutivo</td>
					<td width="100"></td>
				</tr>
			</thead>
			<tbody>
				<?php foreach($this->lists as $content){ ?>
				<?php $id =  $content->id; ?>
					<tr>
						<td><?=$content->solicitud;?></td>
						<td><?=$content->paso;?></td>
						<td><?=$content->fecha;?></td>
						<td><?=$content->tipo_documento;?></td>
						<td><?=$content->documento;?></td>
						<td><?=$content->nombres;?></td>
						<td><?=$content->nombres2;?></td>
						<td><?=$content->apellido1;?></td>
						<td><?=$content->apellido2;?></td>
						<td><?=$content->fn_dia;?></td>
						<td><?=$content->fn_mes;?></td>
						<td><?=$content->fn_anio;?></td>
						<td><?=$content->telefono_oficina;?></td>
						<td><?=$content->correo_personal;?></td>
						<td><?=$content->direccion_residencia;?></td>
						<td><?=$content->ciudad_residencia;?></td>
						<td><?=$content->sexo;?></td>
						<td><?=$content->celular;?></td>
						<td><?=$content->ocupacion;?></td>
						<td><?=$content->estado_civil;?></td>
						<td><?=$content->peso;?></td>
						<td><?=$content->estatura;?></td>
						<td><?=$content->prima;?></td>
						<td><?=$content->prima_valor;?></td>
						<td><?=$content->otra_cual;?></td>
						<td><?=$content->otra_cual2;?></td>
						<td><?=$content->tiene;?></td>
						<td><?=$content->drogas;?></td>
						<td><?=$content->alcoholismo;?></td>
						<td><?=$content->drogadiccion;?></td>
						<td><?=$content->hospitalizado;?></td>
						<td><?=$content->antecedentes;?></td>
						<td><?=$content->observaciones;?></td>
						<td><?=$content->cobertura;?></td>
						<td><?=$content->consecutivo;?></td>
						<td class="text-end">
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