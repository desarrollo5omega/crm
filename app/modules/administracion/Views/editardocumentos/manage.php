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
				<input type="hidden" name="solicitud"  value="<?php if($this->content->solicitud){ echo $this->content->solicitud; } else { echo $this->id; } ?>">
				<div class="col-12 form-group">
					<label for="cedula" >cedula</label>
					<input type="file" name="cedula" id="cedula" class="form-control  file-document" data-buttonName="btn-primary" accept="image/*, application/pdf"  >
					<div class="help-block with-errors"></div>

					<?php if($this->content->cedula) { ?>

						<div id="imagen_cedula">

							<img src="/images/<?= $this->content->cedula; ?>"  class="img-thumbnail thumbnail-administrator" />

							<div><button class="btn btn-danger btn-sm" type="button" onclick="eliminarImagen('cedula','<?php echo $this->route."/deleteimage"; ?>')"><i class="glyphicon glyphicon-remove" ></i> Eliminar Imagen</button></div>

						</div>

					<?php } ?>

				</div>

				<div class="col-12 form-group">

					<label for="desprendible_pago" >Desprendible de pago</label>

					<input type="file" name="desprendible_pago" id="desprendible_pago" class="form-control  file-document" data-buttonName="btn-primary" accept="image/*, application/pdf"  >

					<div class="help-block with-errors"></div>

					<?php if($this->content->desprendible_pago) { ?>

						<div id="imagen_desprendible_pago">

							<?php if(strpos($this->content->desprendible_pago,".pdf")===false){ ?>
								<img src="/images/<?= $this->content->desprendible_pago; ?>"  class="img-thumbnail thumbnail-administrator" />
							<?php } ?>

							<div><button class="btn btn-danger btn-sm" type="button" onclick="eliminarImagen('desprendible_pago','<?php echo $this->route."/deleteimage"; ?>')"><i class="glyphicon glyphicon-remove" ></i> Eliminar Imagen</button></div>

						</div>

					<?php } ?>

				</div>

				<div class="col-12 form-group">

					<label for="desprendible_pago2" >Desprendible de pago2</label>

					<input type="file" name="desprendible_pago2" id="desprendible_pago2" class="form-control  file-document" data-buttonName="btn-primary" accept="image/*, application/pdf"  >

					<div class="help-block with-errors"></div>

					<?php if($this->content->desprendible_pago2) { ?>

						<div id="imagen_desprendible_pago2">

							<?php if(strpos($this->content->desprendible_pago2,".pdf")===false){ ?>
								<img src="/images/<?= $this->content->desprendible_pago2; ?>"  class="img-thumbnail thumbnail-administrator" />
							<?php } ?>

							<div><button class="btn btn-danger btn-sm" type="button" onclick="eliminarImagen('desprendible_pago2','<?php echo $this->route."/deleteimage"; ?>')"><i class="glyphicon glyphicon-remove" ></i> Eliminar Imagen</button></div>

						</div>

					<?php } ?>

				</div>

				<div class="col-12 form-group">

					<label for="desprendible_pago3" >Desprendible de pago3</label>

					<input type="file" name="desprendible_pago3" id="desprendible_pago3" class="form-control  file-document" data-buttonName="btn-primary" accept="image/*, application/pdf"  >

					<div class="help-block with-errors"></div>

					<?php if($this->content->desprendible_pago3) { ?>

						<div id="imagen_desprendible_pago3">

							<?php if(strpos($this->content->desprendible_pago3,".pdf")===false){ ?>
								<img src="/images/<?= $this->content->desprendible_pago3; ?>"  class="img-thumbnail thumbnail-administrator" />
							<?php } ?>

							<div><button class="btn btn-danger btn-sm" type="button" onclick="eliminarImagen('desprendible_pago3','<?php echo $this->route."/deleteimage"; ?>')"><i class="glyphicon glyphicon-remove" ></i> Eliminar Imagen</button></div>

						</div>

					<?php } ?>

				</div>

				<div class="col-12 form-group">

					<label for="desprendible_pago4" >Desprendible de pago4</label>

					<input type="file" name="desprendible_pago4" id="desprendible_pago4" class="form-control  file-document" data-buttonName="btn-primary" accept="image/*, application/pdf"  >

					<div class="help-block with-errors"></div>

					<?php if($this->content->desprendible_pago4) { ?>

						<div id="imagen_desprendible_pago4">

							<?php if(strpos($this->content->desprendible_pago4,".pdf")===false){ ?>
								<img src="/images/<?= $this->content->desprendible_pago4; ?>"  class="img-thumbnail thumbnail-administrator" />
							<?php } ?>

							<div><button class="btn btn-danger btn-sm" type="button" onclick="eliminarImagen('desprendible_pago4','<?php echo $this->route."/deleteimage"; ?>')"><i class="glyphicon glyphicon-remove" ></i> Eliminar Imagen</button></div>

						</div>

					<?php } ?>

				</div>

				<div class="col-12 form-group">

					<label for="desprendible_pago5" >Desprendible de pago5</label>

					<input type="file" name="desprendible_pago5" id="desprendible_pago5" class="form-control  file-document" data-buttonName="btn-primary" accept="image/*, application/pdf"  >

					<div class="help-block with-errors"></div>

					<?php if($this->content->desprendible_pago5) { ?>

						<div id="imagen_desprendible_pago5">

							<?php if(strpos($this->content->desprendible_pago5,".pdf")===false){ ?>
								<img src="/images/<?= $this->content->desprendible_pago5; ?>"  class="img-thumbnail thumbnail-administrator" />
							<?php } ?>

							<div><button class="btn btn-danger btn-sm" type="button" onclick="eliminarImagen('desprendible_pago5','<?php echo $this->route."/deleteimage"; ?>')"><i class="glyphicon glyphicon-remove" ></i> Eliminar Imagen</button></div>

						</div>

					<?php } ?>

				</div>

				<div class="col-12 form-group d-none">

					<label for="certificado_laboral" >certificado_laboral</label>

					<input type="file" name="certificado_laboral" id="certificado_laboral" class="form-control  file-document" data-buttonName="btn-primary" accept="image/*, application/pdf"  >

					<div class="help-block with-errors"></div>

					<?php if($this->content->certificado_laboral) { ?>

						<div id="imagen_certificado_laboral">

							<img src="/images/<?= $this->content->certificado_laboral; ?>"  class="img-thumbnail thumbnail-administrator" />

							<div><button class="btn btn-danger btn-sm" type="button" onclick="eliminarImagen('certificado_laboral','<?php echo $this->route."/deleteimage"; ?>')"><i class="glyphicon glyphicon-remove" ></i> Eliminar Imagen</button></div>

						</div>

					<?php } ?>

				</div>

				<div class="col-12 form-group d-none">

					<label for="otros_ingresos" >otros_ingresos</label>

					<input type="file" name="otros_ingresos" id="otros_ingresos" class="form-control  file-document" data-buttonName="btn-primary" accept="image/*, application/pdf"  >

					<div class="help-block with-errors"></div>

					<?php if($this->content->otros_ingresos) { ?>

						<div id="imagen_otros_ingresos">

							<img src="/images/<?= $this->content->otros_ingresos; ?>"  class="img-thumbnail thumbnail-administrator" />

							<div><button class="btn btn-danger btn-sm" type="button" onclick="eliminarImagen('otros_ingresos','<?php echo $this->route."/deleteimage"; ?>')"><i class="glyphicon glyphicon-remove" ></i> Eliminar Imagen</button></div>

						</div>

					<?php } ?>

				</div>

				<div class="col-12 form-group d-none">

					<label for="certificado_tradicion" >certificado_tradicion</label>

					<input type="file" name="certificado_tradicion" id="certificado_tradicion" class="form-control  file-document" data-buttonName="btn-primary" accept="image/*, application/pdf"  >

					<div class="help-block with-errors"></div>

					<?php if($this->content->certificado_tradicion) { ?>

						<div id="imagen_certificado_tradicion">

							<img src="/images/<?= $this->content->certificado_tradicion; ?>"  class="img-thumbnail thumbnail-administrator" />

							<div><button class="btn btn-danger btn-sm" type="button" onclick="eliminarImagen('certificado_tradicion','<?php echo $this->route."/deleteimage"; ?>')"><i class="glyphicon glyphicon-remove" ></i> Eliminar Imagen</button></div>

						</div>

					<?php } ?>

				</div>

				<div class="col-12 form-group d-none">

					<label for="estado_obligacion" >estado_obligacion</label>

					<input type="file" name="estado_obligacion" id="estado_obligacion" class="form-control  file-document" data-buttonName="btn-primary" accept="image/*, application/pdf"  >

					<div class="help-block with-errors"></div>

					<?php if($this->content->estado_obligacion) { ?>

						<div id="imagen_estado_obligacion">

							<img src="/images/<?= $this->content->estado_obligacion; ?>"  class="img-thumbnail thumbnail-administrator" />

							<div><button class="btn btn-danger btn-sm" type="button" onclick="eliminarImagen('estado_obligacion','<?php echo $this->route."/deleteimage"; ?>')"><i class="glyphicon glyphicon-remove" ></i> Eliminar Imagen</button></div>

						</div>

					<?php } ?>

				</div>

				<div class="col-12 form-group d-none">

					<label for="estado_obligacion2" >estado_obligacion2</label>

					<input type="file" name="estado_obligacion2" id="estado_obligacion2" class="form-control  file-document" data-buttonName="btn-primary" accept="image/*, application/pdf"  >

					<div class="help-block with-errors"></div>

					<?php if($this->content->estado_obligacion2) { ?>

						<div id="imagen_estado_obligacion2">

							<img src="/images/<?= $this->content->estado_obligacion2; ?>"  class="img-thumbnail thumbnail-administrator" />

							<div><button class="btn btn-danger btn-sm" type="button" onclick="eliminarImagen('estado_obligacion2','<?php echo $this->route."/deleteimage"; ?>')"><i class="glyphicon glyphicon-remove" ></i> Eliminar Imagen</button></div>

						</div>

					<?php } ?>

				</div>

				<div class="col-12 form-group d-none">

					<label for="estado_obligacion3" >estado_obligacion3</label>

					<input type="file" name="estado_obligacion3" id="estado_obligacion3" class="form-control  file-document" data-buttonName="btn-primary" accept="image/*, application/pdf"  >

					<div class="help-block with-errors"></div>

					<?php if($this->content->estado_obligacion3) { ?>

						<div id="imagen_estado_obligacion3">

							<img src="/images/<?= $this->content->estado_obligacion3; ?>"  class="img-thumbnail thumbnail-administrator" />

							<div><button class="btn btn-danger btn-sm" type="button" onclick="eliminarImagen('estado_obligacion3','<?php echo $this->route."/deleteimage"; ?>')"><i class="glyphicon glyphicon-remove" ></i> Eliminar Imagen</button></div>

						</div>

					<?php } ?>

				</div>

				<div class="col-12 form-group d-none">

					<label for="factura_proforma" >factura_proforma</label>

					<input type="file" name="factura_proforma" id="factura_proforma" class="form-control  file-document" data-buttonName="btn-primary" accept="image/*, application/pdf"  >

					<div class="help-block with-errors"></div>

					<?php if($this->content->factura_proforma) { ?>

						<div id="imagen_factura_proforma">

							<img src="/images/<?= $this->content->factura_proforma; ?>"  class="img-thumbnail thumbnail-administrator" />

							<div><button class="btn btn-danger btn-sm" type="button" onclick="eliminarImagen('factura_proforma','<?php echo $this->route."/deleteimage"; ?>')"><i class="glyphicon glyphicon-remove" ></i> Eliminar Imagen</button></div>

						</div>

					<?php } ?>

				</div>

				<div class="col-12 form-group d-none">

					<label for="recibo_matricula" >recibo_matricula</label>

					<input type="file" name="recibo_matricula" id="recibo_matricula" class="form-control  file-document" data-buttonName="btn-primary" accept="image/*, application/pdf"  >

					<div class="help-block with-errors"></div>

					<?php if($this->content->recibo_matricula) { ?>

						<div id="imagen_recibo_matricula">

							<img src="/images/<?= $this->content->recibo_matricula; ?>"  class="img-thumbnail thumbnail-administrator" />

							<div><button class="btn btn-danger btn-sm" type="button" onclick="eliminarImagen('recibo_matricula','<?php echo $this->route."/deleteimage"; ?>')"><i class="glyphicon glyphicon-remove" ></i> Eliminar Imagen</button></div>

						</div>

					<?php } ?>

				</div>

				<div class="col-12 form-group d-none">

					<label for="contrato_vivienda" >contrato_vivienda</label>

					<input type="file" name="contrato_vivienda" id="contrato_vivienda" class="form-control  file-document" data-buttonName="btn-primary" accept="image/*, application/pdf"  >

					<div class="help-block with-errors"></div>

					<?php if($this->content->contrato_vivienda) { ?>

						<div id="imagen_contrato_vivienda">

							<img src="/images/<?= $this->content->contrato_vivienda; ?>"  class="img-thumbnail thumbnail-administrator" />

							<div><button class="btn btn-danger btn-sm" type="button" onclick="eliminarImagen('contrato_vivienda','<?php echo $this->route."/deleteimage"; ?>')"><i class="glyphicon glyphicon-remove" ></i> Eliminar Imagen</button></div>

						</div>

					<?php } ?>

				</div>

				<div class="col-12 form-group d-none">

					<label for="declaracion_renta" >declaracion_renta</label>

					<input type="file" name="declaracion_renta" id="declaracion_renta" class="form-control  file-document" data-buttonName="btn-primary" accept="image/*, application/pdf"  >

					<div class="help-block with-errors"></div>

					<?php if($this->content->declaracion_renta) { ?>

						<div id="imagen_declaracion_renta">

							<img src="/images/<?= $this->content->declaracion_renta; ?>"  class="img-thumbnail thumbnail-administrator" />

							<div><button class="btn btn-danger btn-sm" type="button" onclick="eliminarImagen('declaracion_renta','<?php echo $this->route."/deleteimage"; ?>')"><i class="glyphicon glyphicon-remove" ></i> Eliminar Imagen</button></div>

						</div>

					<?php } ?>

				</div>

				<input type="hidden" name="tipo"  value="<?php if($this->content->tipo){ echo $this->content->tipo; } else { echo $this->tipo; } ?>">

			</div>

		</div>

		<div class="botones-acciones">
			<button class="btn btn-guardar" type="submit">Guardar</button>
			<a href="/administracion/solicitudes/detalle?id=<?php if($this->content->solicitud){ echo $this->content->solicitud; } else { echo $this->id; } ?>&paso=6" class="btn btn-cancelar">Cancelar</a>
		</div>

	</form>

</div>