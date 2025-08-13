<h1 class="titulo-principal"><i class="fas fa-cogs"></i> <?php echo $this->titlesection; ?></h1>
<div class="container-fluid">
	<form action="<?php echo $this->route; ?>" method="post">
        <div class="content-dashboard">
            <div class="row">
				<div class="col-3">
		            <label>solicitud</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-verde " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="solicitud" value="<?php echo $this->getObjectVariable($this->filters, 'solicitud') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>nombres</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-azul-claro " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="nombres" value="<?php echo $this->getObjectVariable($this->filters, 'nombres') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>nombres2</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-azul " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="nombres2" value="<?php echo $this->getObjectVariable($this->filters, 'nombres2') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>apellido1</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-morado " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="apellido1" value="<?php echo $this->getObjectVariable($this->filters, 'apellido1') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>apellido2</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-rosado " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="apellido2" value="<?php echo $this->getObjectVariable($this->filters, 'apellido2') ?>"></input>
		            </label>
		        </div>
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
		            <label>tipo_documento</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-rojo-claro " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="tipo_documento" value="<?php echo $this->getObjectVariable($this->filters, 'tipo_documento') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>sexo</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-cafe " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="sexo" value="<?php echo $this->getObjectVariable($this->filters, 'sexo') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>ciudad_documento</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-azul-claro " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="ciudad_documento" value="<?php echo $this->getObjectVariable($this->filters, 'ciudad_documento') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>empresa</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-rosado " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="empresa" value="<?php echo $this->getObjectVariable($this->filters, 'empresa') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>dependencia</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-rojo-claro " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="dependencia" value="<?php echo $this->getObjectVariable($this->filters, 'dependencia') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>direccion_oficina</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-verde " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="direccion_oficina" value="<?php echo $this->getObjectVariable($this->filters, 'direccion_oficina') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>ciudad_oficina</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-morado " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="ciudad_oficina" value="<?php echo $this->getObjectVariable($this->filters, 'ciudad_oficina') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>telefono_oficina</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-cafe " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="telefono_oficina" value="<?php echo $this->getObjectVariable($this->filters, 'telefono_oficina') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>cargo</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-azul " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="cargo" value="<?php echo $this->getObjectVariable($this->filters, 'cargo') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>ciudad</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-verde-claro " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="ciudad" value="<?php echo $this->getObjectVariable($this->filters, 'ciudad') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>telefono</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-verde-claro " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="telefono" value="<?php echo $this->getObjectVariable($this->filters, 'telefono') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>correo_empresarial</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-azul " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="correo_empresarial" value="<?php echo $this->getObjectVariable($this->filters, 'correo_empresarial') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>situacion_laboral</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-verde " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="situacion_laboral" value="<?php echo $this->getObjectVariable($this->filters, 'situacion_laboral') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>cual</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-azul-claro " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="cual" value="<?php echo $this->getObjectVariable($this->filters, 'cual') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>estado_civil</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-morado " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="estado_civil" value="<?php echo $this->getObjectVariable($this->filters, 'estado_civil') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>conyuge_nombre</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-cafe " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="conyuge_nombre" value="<?php echo $this->getObjectVariable($this->filters, 'conyuge_nombre') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>conyuge_telefono</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-rosado " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="conyuge_telefono" value="<?php echo $this->getObjectVariable($this->filters, 'conyuge_telefono') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>conyuge_celular</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-rojo-claro " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="conyuge_celular" value="<?php echo $this->getObjectVariable($this->filters, 'conyuge_celular') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>declara_renta</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-azul " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="declara_renta" value="<?php echo $this->getObjectVariable($this->filters, 'declara_renta') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>persona_publica</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-cafe " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="persona_publica" value="<?php echo $this->getObjectVariable($this->filters, 'persona_publica') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>cuenta_numero</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-verde-claro " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="cuenta_numero" value="<?php echo $this->getObjectVariable($this->filters, 'cuenta_numero') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>cuenta_tipo</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-azul-claro " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="cuenta_tipo" value="<?php echo $this->getObjectVariable($this->filters, 'cuenta_tipo') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>entidad_bancaria</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-verde " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="entidad_bancaria" value="<?php echo $this->getObjectVariable($this->filters, 'entidad_bancaria') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>celular</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-rojo-claro " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="celular" value="<?php echo $this->getObjectVariable($this->filters, 'celular') ?>"></input>
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
		            <label>barrio</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-rosado " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="barrio" value="<?php echo $this->getObjectVariable($this->filters, 'barrio') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>ciudad_residencia</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-verde-claro " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="ciudad_residencia" value="<?php echo $this->getObjectVariable($this->filters, 'ciudad_residencia') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>salario</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-azul-claro " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="salario" value="<?php echo $this->getObjectVariable($this->filters, 'salario') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>forma_pago</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-rosado " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="forma_pago" value="<?php echo $this->getObjectVariable($this->filters, 'forma_pago') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>tiempo_anio</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-morado " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="tiempo_anio" value="<?php echo $this->getObjectVariable($this->filters, 'tiempo_anio') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>tiempo_meses</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-verde " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="tiempo_meses" value="<?php echo $this->getObjectVariable($this->filters, 'tiempo_meses') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>correo</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-rojo-claro " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="correo" value="<?php echo $this->getObjectVariable($this->filters, 'correo') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>asociado</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-azul " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="asociado" value="<?php echo $this->getObjectVariable($this->filters, 'asociado') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
	                <label>fecha_nacimiento</label>
	                <label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-cafe " ><i class="fas fa-calendar-alt"></i></span>
						</div>
	                <input type="text" class="form-control" name="fecha_nacimiento" value="<?php echo $this->getObjectVariable($this->filters, 'fecha_nacimiento') ?>"></input>
	                    </label>
	            </div>
				<div class="col-3">
	                <label>fecha_documento</label>
	                <label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-rojo-claro " ><i class="fas fa-calendar-alt"></i></span>
						</div>
	                <input type="text" class="form-control" name="fecha_documento" value="<?php echo $this->getObjectVariable($this->filters, 'fecha_documento') ?>"></input>
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
					<td>nombres</td>
					<td>nombres2</td>
					<td>apellido1</td>
					<td>apellido2</td>
					<td>cedula</td>
					<td>tipo_documento</td>
					<td>sexo</td>
					<td>ciudad_documento</td>
					<td>empresa</td>
					<td>dependencia</td>
					<td>direccion_oficina</td>
					<td>ciudad_oficina</td>
					<td>telefono_oficina</td>
					<td>cargo</td>
					<td>ciudad</td>
					<td>telefono</td>
					<td>correo_empresarial</td>
					<td>situacion_laboral</td>
					<td>cual</td>
					<td>estado_civil</td>
					<td>conyuge_nombre</td>
					<td>conyuge_telefono</td>
					<td>conyuge_celular</td>
					<td>declara_renta</td>
					<td>persona_publica</td>
					<td>cuenta_numero</td>
					<td>cuenta_tipo</td>
					<td>entidad_bancaria</td>
					<td>celular</td>
					<td>direccion_residencia</td>
					<td>barrio</td>
					<td>ciudad_residencia</td>
					<td>salario</td>
					<td>forma_pago</td>
					<td>tiempo_anio</td>
					<td>tiempo_meses</td>
					<td>correo</td>
					<td>asociado</td>
					<td>fecha_nacimiento</td>
					<td>fecha_documento</td>
					<td width="100"></td>
				</tr>
			</thead>
			<tbody>
				<?php foreach($this->lists as $content){ ?>
				<?php $id =  $content->id; ?>
					<tr>
						<td><?=$content->solicitud;?></td>
						<td><?=$content->nombres;?></td>
						<td><?=$content->nombres2;?></td>
						<td><?=$content->apellido1;?></td>
						<td><?=$content->apellido2;?></td>
						<td><?=$content->cedula;?></td>
						<td><?=$content->tipo_documento;?></td>
						<td><?=$content->sexo;?></td>
						<td><?=$content->ciudad_documento;?></td>
						<td><?=$content->empresa;?></td>
						<td><?=$content->dependencia;?></td>
						<td><?=$content->direccion_oficina;?></td>
						<td><?=$content->ciudad_oficina;?></td>
						<td><?=$content->telefono_oficina;?></td>
						<td><?=$content->cargo;?></td>
						<td><?=$content->ciudad;?></td>
						<td><?=$content->telefono;?></td>
						<td><?=$content->correo_empresarial;?></td>
						<td><?=$content->situacion_laboral;?></td>
						<td><?=$content->cual;?></td>
						<td><?=$content->estado_civil;?></td>
						<td><?=$content->conyuge_nombre;?></td>
						<td><?=$content->conyuge_telefono;?></td>
						<td><?=$content->conyuge_celular;?></td>
						<td><?=$content->declara_renta;?></td>
						<td><?=$content->persona_publica;?></td>
						<td><?=$content->cuenta_numero;?></td>
						<td><?=$content->cuenta_tipo;?></td>
						<td><?=$content->entidad_bancaria;?></td>
						<td><?=$content->celular;?></td>
						<td><?=$content->direccion_residencia;?></td>
						<td><?=$content->barrio;?></td>
						<td><?=$content->ciudad_residencia;?></td>
						<td><?=$content->salario;?></td>
						<td><?=$content->forma_pago;?></td>
						<td><?=$content->tiempo_anio;?></td>
						<td><?=$content->tiempo_meses;?></td>
						<td><?=$content->correo;?></td>
						<td><?=$content->asociado;?></td>
						<td><?=$content->fecha_nacimiento;?></td>
						<td><?=$content->fecha_documento;?></td>
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