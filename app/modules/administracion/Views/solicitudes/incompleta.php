<h1 class="titulo-principal"><i class="fas fa-cogs"></i> <?php echo $this->titlesection; ?></h1>
<div class="container-fluid">
	<div class="row">
		<div class="col-12"><br></div>
		<form class="text-start col-lg-10 offset-lg-1" enctype="multipart/form-data" method="post" action="/administracion/solicitudes/guardarincompleta" data-bs-toggle="validator">
			<div class="row">
				<div class="col-12">
					<label>Estado de la solicitud</label>
					<select name="estado" class="form-control">
						<option value="2">Aplazada</option>
						<option value="4">Rechazada</option>
					</select>
				</div>
				<div class="col-12 form-group">
					<label for="mensaje"  class="control-label">Observación solicitud</label>
					<label class="input-group">
						<textarea name="mensaje" rows="5" id="mensaje" class="form-control tinyeditor"><?= $this->content->incompleta; ?></textarea>
					</label>
					<div class="help-block with-errors"></div>
				</div>
			</div>
			<div class="botones-acciones">
				<button class="btn btn-guardar" type="submit">Guardar</button>
				<a href="<?php echo $this->route; ?>" class="btn btn-cancelar">Cancelar</a>
			</div>
			<input type="hidden" name="id" id="id" value="<?php echo $_GET['id']; ?>" />
		</form>
	</div>
</div>