<h1 class="titulo-principal"><i class="fas fa-cogs"></i> Plan de Pagos</h1>
<div class="container-fluid">
  <form class="text-start" enctype="multipart/form-data" method="post" action="/administracion/solicitudes/enviarplan" data-bs-toggle="validator">
    <div class="content-dashboard">
      <input type="hidden" name="id" id="id" value="<?php echo $this->solicitud ?>">
      <div class="row">
        <div class="col-12 form-group">
          <label for="archivo">archivo</label>
          <div>
            <a target="_blank" href="/images/<?php echo $this->solicitud->archivo_soat ?>"><?php echo $this->solicitud->archivo_soat ?></a>
          </div>
          <input type="file" name="archivo" id="archivo" class="form-control  file-document" data-buttonName="btn-primary" onchange="validardocumento('archivo');" accept=" image/*, application/pdf" required>
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