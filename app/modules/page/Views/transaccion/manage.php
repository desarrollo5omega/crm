<div class="container-fluid">
text-start
<form class="text-left" enctype="multipart/form-data" method="post" action="<?php echo $this->routeform;?>" data-bs-toggle="validator">

	<input type="hidden" name="csrf" id="csrf" value="<?php echo $this->csrf ?>">

	<input type="hidden" name="csrf_section" id="csrf_section" value="<?php echo $this->csrf_section ?>">

	<?php if ($this->content->id) { ?>

		<input type="hidden" name="id" id="id" value="<?= $this->content->id; ?>" />

	<?php }?>

	<div class="row">

		<div class="col-xs-1 form-group">

			<label for="metodo"  class="control-label">metodo</label>

			<input type="text" value="<?= $this->content->metodo; ?>" name="metodo" id="metodo" class="form-control"   >

		</div>

		<div class="col-xs-1 form-group">

			<label for="xml"  class="control-label">xml</label>

			<input type="text" value="<?= $this->content->xml; ?>" name="xml" id="xml" class="form-control"   >

		</div>

		<div class="col-xs-1 form-group">

			<label for="res"  class="control-label">res</label>

			<input type="text" value="<?= $this->content->res; ?>" name="res" id="res" class="form-control"   >

		</div>

		<div class="col-xs-1 form-group">

			<label for="exitoso"  class="control-label">exitoso</label>

			<input type="text" value="<?= $this->content->exitoso; ?>" name="exitoso" id="exitoso" class="form-control"   >

		</div>

		<div class="col-xs-1 form-group">

			<label for="codigoError"  class="control-label">codigoError</label>

			<input type="text" value="<?= $this->content->codigoError; ?>" name="codigoError" id="codigoError" class="form-control"   >

		</div>

		<div class="col-xs-1 form-group">

			<label for="fecha"  class="control-label">fecha</label>

			<input type="text" value="<?= $this->content->fecha; ?>" name="fecha" id="fecha" class="form-control"   >

		</div>

		<div class="col-xs-1 form-group">

			<label for="solicitud"  class="control-label">solicitud</label>

			<input type="text" value="<?= $this->content->solicitud; ?>" name="solicitud" id="solicitud" class="form-control"   >

		</div>

		<div class="col-xs-1 form-group">

			<label for="numero_solicitud"  class="control-label">numero_solicitud</label>

			<input type="text" value="<?= $this->content->numero_solicitud; ?>" name="numero_solicitud" id="numero_solicitud" class="form-control"   >

		</div>

		<div class="col-xs-1 form-group">

			<label for="ip"  class="control-label">ip</label>

			<input type="text" value="<?= $this->content->ip; ?>" name="ip" id="ip" class="form-control"   >

		</div>

		<div class="col-xs-1 form-group">

			<label for="quien"  class="control-label">quien</label>

			<input type="text" value="<?= $this->content->quien; ?>" name="quien" id="quien" class="form-control"   >

		</div>

	</div>

	<div class="row">

		<div class="col-xs-6">

			<button class="btn btn-success btn-block" type="submit">Guardar</button>

		</div>

		<div class="col-xs-6">

			<a class="btn btn-primary btn-block"  href="<?php echo $this->route; ?>">Cancelar</a>

		</div>

	</div>

</form>

</div>