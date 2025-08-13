<h1 class="titulo-principal"><i class="fas fa-cogs"></i> <?php echo $this->titlesection; ?></h1>
<div class="container-fluid">
	<form action="<?php echo $this->route; ?>" method="post">
        <div class="content-dashboard">
            <div class="row">
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
		            <label>tipo_documento</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-morado " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="tipo_documento" value="<?php echo $this->getObjectVariable($this->filters, 'tipo_documento') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>fecha_documento</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-verde-claro " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="fecha_documento" value="<?php echo $this->getObjectVariable($this->filters, 'fecha_documento') ?>"></input>
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
		            <label>apellidos</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-rojo-claro " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="apellidos" value="<?php echo $this->getObjectVariable($this->filters, 'apellidos') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>ciudad</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-azul-claro " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="ciudad" value="<?php echo $this->getObjectVariable($this->filters, 'ciudad') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>departamento</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-azul " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="departamento" value="<?php echo $this->getObjectVariable($this->filters, 'departamento') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>pais</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-rosado " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="pais" value="<?php echo $this->getObjectVariable($this->filters, 'pais') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>ciudad_documento</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-verde " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="ciudad_documento" value="<?php echo $this->getObjectVariable($this->filters, 'ciudad_documento') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>departamento_documento</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-rojo-claro " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="departamento_documento" value="<?php echo $this->getObjectVariable($this->filters, 'departamento_documento') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>pais_documento</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-azul-claro " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="pais_documento" value="<?php echo $this->getObjectVariable($this->filters, 'pais_documento') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>fecha_nacimiento</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-verde-claro " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="fecha_nacimiento" value="<?php echo $this->getObjectVariable($this->filters, 'fecha_nacimiento') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>ciudad_nacimiento</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-rosado " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="ciudad_nacimiento" value="<?php echo $this->getObjectVariable($this->filters, 'ciudad_nacimiento') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>direccion</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-azul " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="direccion" value="<?php echo $this->getObjectVariable($this->filters, 'direccion') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>email</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-cafe " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="email" value="<?php echo $this->getObjectVariable($this->filters, 'email') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>email2</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-morado " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="email2" value="<?php echo $this->getObjectVariable($this->filters, 'email2') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>telefono</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-verde " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="telefono" value="<?php echo $this->getObjectVariable($this->filters, 'telefono') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>telefono2</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-cafe " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="telefono2" value="<?php echo $this->getObjectVariable($this->filters, 'telefono2') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>celular</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-morado " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="celular" value="<?php echo $this->getObjectVariable($this->filters, 'celular') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>fecha_ingreso</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-rosado " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="fecha_ingreso" value="<?php echo $this->getObjectVariable($this->filters, 'fecha_ingreso') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>genero</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-verde-claro " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="genero" value="<?php echo $this->getObjectVariable($this->filters, 'genero') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>empresa</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-azul " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="empresa" value="<?php echo $this->getObjectVariable($this->filters, 'empresa') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>empresa_cual</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-azul-claro " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="empresa_cual" value="<?php echo $this->getObjectVariable($this->filters, 'empresa_cual') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>barrio</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-rojo-claro " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="barrio" value="<?php echo $this->getObjectVariable($this->filters, 'barrio') ?>"></input>
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
		            <label>direccion_oficina</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-rosado " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="direccion_oficina" value="<?php echo $this->getObjectVariable($this->filters, 'direccion_oficina') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>telefono_oficina</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-verde-claro " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="telefono_oficina" value="<?php echo $this->getObjectVariable($this->filters, 'telefono_oficina') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>telefono_oficina2</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-azul-claro " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="telefono_oficina2" value="<?php echo $this->getObjectVariable($this->filters, 'telefono_oficina2') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>telefono_oficina_ext</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-verde " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="telefono_oficina_ext" value="<?php echo $this->getObjectVariable($this->filters, 'telefono_oficina_ext') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>fecha_afiliacion</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-rojo-claro " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="fecha_afiliacion" value="<?php echo $this->getObjectVariable($this->filters, 'fecha_afiliacion') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>cuenta_numero</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-cafe " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="cuenta_numero" value="<?php echo $this->getObjectVariable($this->filters, 'cuenta_numero') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>cuenta_tipo</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-azul " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="cuenta_tipo" value="<?php echo $this->getObjectVariable($this->filters, 'cuenta_tipo') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>entidad_bancaria</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-morado " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="entidad_bancaria" value="<?php echo $this->getObjectVariable($this->filters, 'entidad_bancaria') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>nivel_educativo</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-verde " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="nivel_educativo" value="<?php echo $this->getObjectVariable($this->filters, 'nivel_educativo') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>titulo</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-rosado " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="titulo" value="<?php echo $this->getObjectVariable($this->filters, 'titulo') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>intereses</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-azul " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="intereses" value="<?php echo $this->getObjectVariable($this->filters, 'intereses') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>codigo_ciuu</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-azul-claro " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="codigo_ciuu" value="<?php echo $this->getObjectVariable($this->filters, 'codigo_ciuu') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>cargo</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-verde-claro " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="cargo" value="<?php echo $this->getObjectVariable($this->filters, 'cargo') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>salario</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-rojo-claro " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="salario" value="<?php echo $this->getObjectVariable($this->filters, 'salario') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>sede</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-cafe " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="sede" value="<?php echo $this->getObjectVariable($this->filters, 'sede') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>ciudad_oficina</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-verde-claro " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="ciudad_oficina" value="<?php echo $this->getObjectVariable($this->filters, 'ciudad_oficina') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>valor_cuota_periodica</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-morado " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="valor_cuota_periodica" value="<?php echo $this->getObjectVariable($this->filters, 'valor_cuota_periodica') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>valor_ahorro_voluntario</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-verde " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="valor_ahorro_voluntario" value="<?php echo $this->getObjectVariable($this->filters, 'valor_ahorro_voluntario') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>valor_ahorro_incentivo</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-rosado " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="valor_ahorro_incentivo" value="<?php echo $this->getObjectVariable($this->filters, 'valor_ahorro_incentivo') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>recursos_publicos</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-rojo-claro " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="recursos_publicos" value="<?php echo $this->getObjectVariable($this->filters, 'recursos_publicos') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>poder_publico</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-cafe " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="poder_publico" value="<?php echo $this->getObjectVariable($this->filters, 'poder_publico') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>reconocimiento</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-azul " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="reconocimiento" value="<?php echo $this->getObjectVariable($this->filters, 'reconocimiento') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>familiares</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-azul-claro " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="familiares" value="<?php echo $this->getObjectVariable($this->filters, 'familiares') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>especifique</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-cafe " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="especifique" value="<?php echo $this->getObjectVariable($this->filters, 'especifique') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>ingresos_mensuales</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-verde " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="ingresos_mensuales" value="<?php echo $this->getObjectVariable($this->filters, 'ingresos_mensuales') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>egresos_mensuales</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-morado " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="egresos_mensuales" value="<?php echo $this->getObjectVariable($this->filters, 'egresos_mensuales') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>activos</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-azul-claro " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="activos" value="<?php echo $this->getObjectVariable($this->filters, 'activos') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>pasivos</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-rojo-claro " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="pasivos" value="<?php echo $this->getObjectVariable($this->filters, 'pasivos') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>patrimonio</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-rosado " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="patrimonio" value="<?php echo $this->getObjectVariable($this->filters, 'patrimonio') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>otros_ingresos</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-azul " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="otros_ingresos" value="<?php echo $this->getObjectVariable($this->filters, 'otros_ingresos') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>concepto_otros_ingresos</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-verde-claro " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="concepto_otros_ingresos" value="<?php echo $this->getObjectVariable($this->filters, 'concepto_otros_ingresos') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>transacciones_moneda_extranjera</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-verde " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="transacciones_moneda_extranjera" value="<?php echo $this->getObjectVariable($this->filters, 'transacciones_moneda_extranjera') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>operaciones_internacionales</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-cafe " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="operaciones_internacionales" value="<?php echo $this->getObjectVariable($this->filters, 'operaciones_internacionales') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>operaciones_cual</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-azul " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="operaciones_cual" value="<?php echo $this->getObjectVariable($this->filters, 'operaciones_cual') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>producto_tipo</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-azul-claro " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="producto_tipo" value="<?php echo $this->getObjectVariable($this->filters, 'producto_tipo') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>producto_numero</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-rojo-claro " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="producto_numero" value="<?php echo $this->getObjectVariable($this->filters, 'producto_numero') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>producto_entidad</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-rosado " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="producto_entidad" value="<?php echo $this->getObjectVariable($this->filters, 'producto_entidad') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>producto_monto</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-verde-claro " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="producto_monto" value="<?php echo $this->getObjectVariable($this->filters, 'producto_monto') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>producto_ciudad</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-morado " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="producto_ciudad" value="<?php echo $this->getObjectVariable($this->filters, 'producto_ciudad') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>producto_pais</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-azul " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="producto_pais" value="<?php echo $this->getObjectVariable($this->filters, 'producto_pais') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>producto_moneda</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-rojo-claro " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="producto_moneda" value="<?php echo $this->getObjectVariable($this->filters, 'producto_moneda') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>situacion_laboral</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-azul-claro " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="situacion_laboral" value="<?php echo $this->getObjectVariable($this->filters, 'situacion_laboral') ?>"></input>
		            </label>
		        </div>
				<div class="col-3">
		            <label>id_deceval</label>
		            <label class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text input-icono fondo-rosado " ><i class="fas fa-pencil-alt"></i></span>
							</div>
		            <input type="text" class="form-control" name="id_deceval" value="<?php echo $this->getObjectVariable($this->filters, 'id_deceval') ?>"></input>
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
					<td>documento</td>
					<td>tipo_documento</td>
					<td>fecha_documento</td>
					<td>nombres</td>
					<td>apellidos</td>
					<td>ciudad</td>
					<td>departamento</td>
					<td>pais</td>
					<td>ciudad_documento</td>
					<td>departamento_documento</td>
					<td>pais_documento</td>
					<td>fecha_nacimiento</td>
					<td>ciudad_nacimiento</td>
					<td>direccion</td>
					<td>email</td>
					<td>email2</td>
					<td>telefono</td>
					<td>telefono2</td>
					<td>celular</td>
					<td>fecha_ingreso</td>
					<td>genero</td>
					<td>empresa</td>
					<td>empresa_cual</td>
					<td>barrio</td>
					<td>estado_civil</td>
					<td>direccion_oficina</td>
					<td>telefono_oficina</td>
					<td>telefono_oficina2</td>
					<td>telefono_oficina_ext</td>
					<td>fecha_afiliacion</td>
					<td>cuenta_numero</td>
					<td>cuenta_tipo</td>
					<td>entidad_bancaria</td>
					<td>nivel_educativo</td>
					<td>titulo</td>
					<td>intereses</td>
					<td>codigo_ciuu</td>
					<td>cargo</td>
					<td>salario</td>
					<td>sede</td>
					<td>ciudad_oficina</td>
					<td>valor_cuota_periodica</td>
					<td>valor_ahorro_voluntario</td>
					<td>valor_ahorro_incentivo</td>
					<td>recursos_publicos</td>
					<td>poder_publico</td>
					<td>reconocimiento</td>
					<td>familiares</td>
					<td>especifique</td>
					<td>ingresos_mensuales</td>
					<td>egresos_mensuales</td>
					<td>activos</td>
					<td>pasivos</td>
					<td>patrimonio</td>
					<td>otros_ingresos</td>
					<td>concepto_otros_ingresos</td>
					<td>transacciones_moneda_extranjera</td>
					<td>operaciones_internacionales</td>
					<td>operaciones_cual</td>
					<td>producto_tipo</td>
					<td>producto_numero</td>
					<td>producto_entidad</td>
					<td>producto_monto</td>
					<td>producto_ciudad</td>
					<td>producto_pais</td>
					<td>producto_moneda</td>
					<td>situacion_laboral</td>
					<td>id_deceval</td>
					<td width="100"></td>
				</tr>
			</thead>
			<tbody>
				<?php foreach($this->lists as $content){ ?>
				<?php $id =  $content->id; ?>
					<tr>
						<td><?=$content->documento;?></td>
						<td><?=$content->tipo_documento;?></td>
						<td><?=$content->fecha_documento;?></td>
						<td><?=$content->nombres;?></td>
						<td><?=$content->apellidos;?></td>
						<td><?=$content->ciudad;?></td>
						<td><?=$content->departamento;?></td>
						<td><?=$content->pais;?></td>
						<td><?=$content->ciudad_documento;?></td>
						<td><?=$content->departamento_documento;?></td>
						<td><?=$content->pais_documento;?></td>
						<td><?=$content->fecha_nacimiento;?></td>
						<td><?=$content->ciudad_nacimiento;?></td>
						<td><?=$content->direccion;?></td>
						<td><?=$content->email;?></td>
						<td><?=$content->email2;?></td>
						<td><?=$content->telefono;?></td>
						<td><?=$content->telefono2;?></td>
						<td><?=$content->celular;?></td>
						<td><?=$content->fecha_ingreso;?></td>
						<td><?=$content->genero;?></td>
						<td><?=$content->empresa;?></td>
						<td><?=$content->empresa_cual;?></td>
						<td><?=$content->barrio;?></td>
						<td><?=$content->estado_civil;?></td>
						<td><?=$content->direccion_oficina;?></td>
						<td><?=$content->telefono_oficina;?></td>
						<td><?=$content->telefono_oficina2;?></td>
						<td><?=$content->telefono_oficina_ext;?></td>
						<td><?=$content->fecha_afiliacion;?></td>
						<td><?=$content->cuenta_numero;?></td>
						<td><?=$content->cuenta_tipo;?></td>
						<td><?=$content->entidad_bancaria;?></td>
						<td><?=$content->nivel_educativo;?></td>
						<td><?=$content->titulo;?></td>
						<td><?=$content->intereses;?></td>
						<td><?=$content->codigo_ciuu;?></td>
						<td><?=$content->cargo;?></td>
						<td><?=$content->salario;?></td>
						<td><?=$content->sede;?></td>
						<td><?=$content->ciudad_oficina;?></td>
						<td><?=$content->valor_cuota_periodica;?></td>
						<td><?=$content->valor_ahorro_voluntario;?></td>
						<td><?=$content->valor_ahorro_incentivo;?></td>
						<td><?=$content->recursos_publicos;?></td>
						<td><?=$content->poder_publico;?></td>
						<td><?=$content->reconocimiento;?></td>
						<td><?=$content->familiares;?></td>
						<td><?=$content->especifique;?></td>
						<td><?=$content->ingresos_mensuales;?></td>
						<td><?=$content->egresos_mensuales;?></td>
						<td><?=$content->activos;?></td>
						<td><?=$content->pasivos;?></td>
						<td><?=$content->patrimonio;?></td>
						<td><?=$content->otros_ingresos;?></td>
						<td><?=$content->concepto_otros_ingresos;?></td>
						<td><?=$content->transacciones_moneda_extranjera;?></td>
						<td><?=$content->operaciones_internacionales;?></td>
						<td><?=$content->operaciones_cual;?></td>
						<td><?=$content->producto_tipo;?></td>
						<td><?=$content->producto_numero;?></td>
						<td><?=$content->producto_entidad;?></td>
						<td><?=$content->producto_monto;?></td>
						<td><?=$content->producto_ciudad;?></td>
						<td><?=$content->producto_pais;?></td>
						<td><?=$content->producto_moneda;?></td>
						<td><?=$content->situacion_laboral;?></td>
						<td><?=$content->id_deceval;?></td>
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