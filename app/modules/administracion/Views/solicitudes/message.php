<h1 class="titulo-principal"><i class="fas fa-cogs"></i> Plan de Pagos</h1>
<div class="container-fluid">
  <form class="text-start" enctype="multipart/form-data" method="post" action="/administracion/solicitudes/sendmessage" data-bs-toggle="validator">
    <div class="content-dashboard">
      <input type="hidden" name="id" id="id" value="<?php echo $this->id ?>">
      <div class="row">
        <div class="col-12 form-group">
          <label for="archivo">Asunto</label>
          <input type="text" name="asunto" class="form-control">
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-12 form-group">
          <label for="archivo">Mensaje</label>
          <div>
            <a target="_blank" href="/images/<?php echo $this->solicitud->archivo_soat ?>"><?php echo $this->solicitud->archivo_soat ?></a>
          </div>
          <textarea name="mensaje" id="" cols="30" rows="10" class="tinyeditor"></textarea>
          <div class="help-block with-errors"></div>
        </div>
      </div>
    </div>
    <div class="botones-acciones">
      <button class="btn btn-guardar" type="submit">Enviar</button>
      <a href="/administracion/solicitudes" class="btn btn-cancelar">Cancelar</a>
    </div>
  </form>
</div>