<h1 class="titulo-principal"><i class="fas fa-cogs"></i> <?php echo $this->titlesection; ?></h1>
<div class="container-fluid">
	<form class="text-start" enctype="multipart/form-data" method="post" action="<?php echo $this->routeform;?>" data-bs-toggle="validator">
		<div class="content-dashboard">
			<input type="hidden" name="csrf" id="csrf" value="<?php echo $this->csrf ?>">
			<input type="hidden" name="csrf_section" id="csrf_section" value="<?php echo $this->csrf_section ?>">
			<?php if ($this->content->id) { ?>
				<input type="hidden" name="id" id="id" value="<?= $this->content->id; ?>" />
			<?php }?>
			<div class="row">
				<div class="col-2 form-group">
					<label for="codigo"  class="control-label">codigo</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-azul-claro " ><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->codigo; ?>" name="codigo" id="codigo" class="form-control"  required >
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-5 form-group">
					<label for="nombre"  class="control-label">nombre</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-rosado " ><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->nombre; ?>" name="nombre" id="nombre" class="form-control"  required >
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-5 form-group">
					<label for="detalle"  class="control-label">detalle</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-cafe " ><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->detalle; ?>" name="detalle" id="detalle" class="form-control"   >
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<input type="hidden" name="tasa_cobrada"  value="<?php echo $this->content->tasa_cobrada ?>">
				<div class="col-3 form-group">
					<label for="tasa_real"  class="control-label">tasa mes vencido</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-verde-claro " ><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->tasa_real; ?>" name="tasa_real" id="tasa_real" class="form-control"  required >
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-3 form-group">
					<label for="efectivo_anual"  class="control-label">tasa efectiva anual</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-azul " ><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->efectivo_anual; ?>" name="efectivo_anual" id="efectivo_anual" class="form-control"   >
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-3 form-group">
					<label for="min_meses"  class="control-label">min cuotas</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-morado " ><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->min_meses; ?>" name="min_meses" min="1" id="min_meses" class="form-control"   >
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-3 form-group">
					<label for="max_meses"  class="control-label">max cuotas</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-morado " ><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->max_meses; ?>" name="max_meses" id="max_meses" class="form-control"   >
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-3 form-group">
					<label for="maxMonto"  class="control-label">max valor</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-rojo-claro " ><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->maxMonto; ?>" name="maxMonto" id="maxMonto" class="form-control"   >
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 form-group">
					<label for="descripcionGeneral" class="form-label" >descripcion general</label>
					<textarea name="descripcionGeneral" id="descripcionGeneral"   class="form-control tinyeditor" rows="10"   ><?= $this->content->descripcionGeneral; ?></textarea>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 form-group">
					<label for="requisitos" class="form-label" >requisitos</label>
					<textarea name="requisitos" id="requisitos"   class="form-control tinyeditor" rows="10"   ><?= $this->content->requisitos; ?></textarea>
					<div class="help-block with-errors"></div>
				</div>
		<div class="col-6 form-group">
			<label   class="control-label">activo</label>
				<input type="checkbox" name="activo" value="1" class="form-control switch-form " <?php if ($this->getObjectVariable($this->content, 'activo') == 1) { echo "checked";} ?>   ></input>
				<div class="help-block with-errors"></div>
		</div>


		<div class="col-12"><h4>Solicitud de documentos</h4></div>

		<div class="col-6 form-group">
			<label   class="control-label">Solicitar Archivo cédula?</label>
				<input type="checkbox" name="archivo1" value="1" class="form-control switch-form " <?php if ($this->getObjectVariable($this->content, 'archivo1') == 1) { echo "checked";} ?>   ></input>
				<div class="help-block with-errors"></div>
		</div>
		<div class="col-6 form-group">
			<label   class="control-label">Solicitar Archivo desprendible de pago?</label>
				<input type="checkbox" name="archivo2" value="1" class="form-control switch-form " <?php if ($this->getObjectVariable($this->content, 'archivo2') == 1) { echo "checked";} ?>   ></input>
				<div class="help-block with-errors"></div>
		</div>
		<div class="col-6 form-group">
			<label   class="control-label">Solicitar Archivo desprendible de pago2?</label>
				<input type="checkbox" name="archivo22" value="1" class="form-control switch-form " <?php if ($this->getObjectVariable($this->content, 'archivo22') == 1) { echo "checked";} ?>   ></input>
				<div class="help-block with-errors"></div>
		</div>
		<div class="col-6 form-group">
			<label   class="control-label">Solicitar Archivo desprendible de pago3?</label>
				<input type="checkbox" name="archivo23" value="1" class="form-control switch-form " <?php if ($this->getObjectVariable($this->content, 'archivo23') == 1) { echo "checked";} ?>   ></input>
				<div class="help-block with-errors"></div>
		</div>
		<div class="col-6 form-group">
			<label   class="control-label">Solicitar Archivo desprendible de pago4?</label>
				<input type="checkbox" name="archivo24" value="1" class="form-control switch-form " <?php if ($this->getObjectVariable($this->content, 'archivo24') == 1) { echo "checked";} ?>   ></input>
				<div class="help-block with-errors"></div>
		</div>
		<div class="col-6 form-group">
			<label   class="control-label">Solicitar Archivo certificado laboral?</label>
				<input type="checkbox" name="archivo3" value="1" class="form-control switch-form " <?php if ($this->getObjectVariable($this->content, 'archivo3') == 1) { echo "checked";} ?>   ></input>
				<div class="help-block with-errors"></div>
		</div>
		<div class="col-6 form-group">
			<label   class="control-label">Solicitar Archivo otros documentos?</label>
				<input type="checkbox" name="archivo4" value="1" class="form-control switch-form " <?php if ($this->getObjectVariable($this->content, 'archivo4') == 1) { echo "checked";} ?>   ></input>
				<div class="help-block with-errors"></div>
		</div>


		<div class="col-6 form-group">
			<label   class="control-label">Solicitar Archivo Certificado tradición y libertad?</label>
				<input type="checkbox" name="certificado_tradicion" value="1" class="form-control switch-form " <?php if ($this->getObjectVariable($this->content, 'certificado_tradicion') == 1) { echo "checked";} ?>   ></input>
				<div class="help-block with-errors"></div>
		</div>
		<div class="col-6 form-group">
			<label   class="control-label">Solicitar Archivo Estado de cuenta de la obligacion?</label>
				<input type="checkbox" name="estado_obligacion" value="1" class="form-control switch-form " <?php if ($this->getObjectVariable($this->content, 'estado_obligacion') == 1) { echo "checked";} ?>   ></input>
				<div class="help-block with-errors"></div>
		</div>
		<div class="col-6 form-group">
			<label   class="control-label">Solicitar Archivo Estado de cuenta de la obligacion2?</label>
				<input type="checkbox" name="estado_obligacion2" value="1" class="form-control switch-form " <?php if ($this->getObjectVariable($this->content, 'estado_obligacion2') == 1) { echo "checked";} ?>   ></input>
				<div class="help-block with-errors"></div>
		</div>
		<div class="col-6 form-group">
			<label   class="control-label">Solicitar Archivo Estado de cuenta de la obligacion3?</label>
				<input type="checkbox" name="estado_obligacion3" value="1" class="form-control switch-form " <?php if ($this->getObjectVariable($this->content, 'estado_obligacion3') == 1) { echo "checked";} ?>   ></input>
				<div class="help-block with-errors"></div>
		</div>
		<div class="col-6 form-group">
			<label   class="control-label">Solicitar Archivo Factura proforma?</label>
				<input type="checkbox" name="factura_proforma" value="1" class="form-control switch-form " <?php if ($this->getObjectVariable($this->content, 'factura_proforma') == 1) { echo "checked";} ?>   ></input>
				<div class="help-block with-errors"></div>
		</div>
		<div class="col-6 form-group">
			<label   class="control-label">Solicitar Archivo Recibo de matricula?</label>
				<input type="checkbox" name="recibo_matricula" value="1" class="form-control switch-form " <?php if ($this->getObjectVariable($this->content, 'recibo_matricula') == 1) { echo "checked";} ?>   ></input>
				<div class="help-block with-errors"></div>
		</div>
		<div class="col-6 form-group">
			<label   class="control-label">Solicitar Archivo orden medica?</label>
				<input type="checkbox" name="orden_medica" value="1" class="form-control switch-form " <?php if ($this->getObjectVariable($this->content, 'orden_medica') == 1) { echo "checked";} ?>   ></input>
				<div class="help-block with-errors"></div>
		</div>
		<div class="col-6 form-group">
			<label   class="control-label">Solicitar Archivo certificación?</label>
				<input type="checkbox" name="certificacion" value="1" class="form-control switch-form " <?php if ($this->getObjectVariable($this->content, 'certificacion') == 1) { echo "checked";} ?>   ></input>
				<div class="help-block with-errors"></div>
		</div>
		<div class="col-6 form-group">
			<label   class="control-label">Solicitar Archivo Recibo de cotización?</label>
				<input type="checkbox" name="cotizacion" value="1" class="form-control switch-form " <?php if ($this->getObjectVariable($this->content, 'cotizacion') == 1) { echo "checked";} ?>   ></input>
				<div class="help-block with-errors"></div>
		</div>
		<div class="col-6 form-group">
			<label   class="control-label">Solicitar Archivo peritaje del vehículo?</label>
				<input type="checkbox" name="peritaje_vehiculo" value="1" class="form-control switch-form " <?php if ($this->getObjectVariable($this->content, 'peritaje_vehiculo') == 1) { echo "checked";} ?>   ></input>
				<div class="help-block with-errors"></div>
		</div>
		<div class="col-6 form-group">
			<label   class="control-label">Solicitar Archivo Evidencia de calamidad?</label>
				<input type="checkbox" name="evidencia_calamidad" value="1" class="form-control switch-form " <?php if ($this->getObjectVariable($this->content, 'evidencia_calamidad') == 1) { echo "checked";} ?>   ></input>
				<div class="help-block with-errors"></div>
		</div>
		<div class="col-6 form-group">
			<label   class="control-label">Solicitar Archivo Impuesto vehículo?</label>
				<input type="checkbox" name="impuesto_vehiculo" value="1" class="form-control switch-form " <?php if ($this->getObjectVariable($this->content, 'impuesto_vehiculo') == 1) { echo "checked";} ?>   ></input>
				<div class="help-block with-errors"></div>
		</div>
		<div class="col-6 form-group">
			<label   class="control-label">Solicitar Archivo SOAT?</label>
				<input type="checkbox" name="soat" value="1" class="form-control switch-form " <?php if ($this->getObjectVariable($this->content, 'soat') == 1) { echo "checked";} ?>   ></input>
				<div class="help-block with-errors"></div>
		</div>
		<div class="col-12"></div>

		<div class="col-6"><h4>Garantías que aplican para la línea</h4></div>
		<div class="col-6"><h4>Obligatoria</h4></div>

		<div class="col-6">
			<div class="row">
				<?php foreach ($this->garantias as $key => $garantia): ?>
					<div class="col-12">
						<label><input type="checkbox" name="garantia<?php echo $key; ?>" value="<?php echo $garantia->garantia_id; ?>" <?php if($this->array_garantias[$garantia->garantia_id]==1){ echo 'checked'; } ?> > <?php echo utf8_encode($garantia->garantia_nombre); ?></label>
					</div>
				<?php endforeach ?>
			</div>
		</div>

		<div class="col-6">
			<div class="row">
				<?php foreach ($this->garantias as $key => $garantia): ?>
					<div class="col-12">
						<label><input type="checkbox" name="obligatoria<?php echo $key; ?>" value="1" <?php if($this->array_obligatorios[$garantia->garantia_id]==1){ echo 'checked'; } ?> ></label>
					</div>
				<?php endforeach ?>
			</div>
		</div>

			</div>
		</div>
		<div class="botones-acciones">
			<button class="btn btn-guardar" type="submit">Guardar</button>
			<a href="<?php echo $this->route; ?>" class="btn btn-cancelar">Cancelar</a>
		</div>
	</form>
</div>