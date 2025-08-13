<h1 class="titulo-principal"><i class="fas fa-cogs"></i> <?php echo $this->titlesection; ?></h1>
<div class="container-fluid">
	<div class="row">
		<div class="col-12"><br></div>
    <?php if($this->send == '1'){ ?>
      <div class="col-12 text-center">
        El pagare <?php echo $this->numero; ?> fue enviado para firma.
      </div>
    <?php }else{ ?>
      <div class="col-12 text-center">
        Ha ocurrido un error enviando el pagare, por favor inténtelo nuevamente.
      </div>
    <?php } ?>
		<div class="col-12"><br></div>
    <?php if($this->send == '2'){ ?>
      <div class="col-12 text-center d-none">
        <a class="btn btn-info btn-sm mt-2" href="/administracion/solicitudes/aprobar/?id=<?php echo $this->id ?>" data-bs-toggle="tooltip" data-placement="top" title="reenviar pagaré">
          Reenviar
          <i class="fas fa-file-signature"></i>
        </a>
      </div>
    <?php } ?>
		<div class="col-12 text-center d-none"><a href="/administracion/solicitudes/"><button type="button" class="btn btn-primary">Regresar</button></a></div>
	</div>
</div>