<div class="container p-4">
  <div class="row">
    <div class="col-12">
      <form action="/administracion/reportes/solicitudes" method="post" class="mb-4 row align-items-end">
        <div class="col-md-3">
          <label>Fecha Aprobación (inicio):</label>
          <input type="date" name="fecha_aprobacion_start" class="form-control" value="<?php echo $this->fecha_aprobacion_start ?>">
        </div>
        <div class="col-md-3">
          <label>Fecha Aprobación (final):</label>
          <input type="date" name="fecha_aprobacion_end" class="form-control" value="<?php echo $this->fecha_aprobacion_end ?>">
        </div>
        <div class="col-md-3">
          <label>Radicación (inicio):</label>
          <input type="date" name="fecha_asignado_start" class="form-control" value="<?php echo $this->fecha_asignado_start ?>">
        </div>
        <div class="col-md-3">
          <label>Radicación (final):</label>
          <input type="date" name="fecha_asignado_end" class="form-control" value="<?php echo $this->fecha_asignado_end ?>">
        </div>
        <div class="col-md-3">
          <label>Fecha Desembolso (inicio):</label>
          <input type="date" name="fecha_desembolso_start" class="form-control" value="<?php echo $this->fecha_desembolso_start ?>">
        </div>
        <div class="col-md-3">
          <label>Fecha Desembolso (final):</label>
          <input type="date" name="fecha_desembolso_end" class="form-control" value="<?php echo $this->fecha_desembolso_end ?>">
        </div>
        <div class="col-md-3">
          <br>
          <button type="submit" class="btn btn-primary w-100 mt-auto">Filtrar</button>
        </div>
        <div class="col-md-3">
          <br>
          <a href="/administracion/reportes/solicitudes?cleanfilter=1" class="btn btn-info w-100 mt-auto">Limpiar filtros</a>
        </div>
      </form>
    </div>
    
    <div class="col-12">
      <div class="row justify-content-end">
        <div class="col-md-3">
          <form action="/administracion/reportes/exportsoli" method="post">
            <input type="hidden" name="fecha_aprobacion_start" class="form-control" value="<?php echo $this->fecha_aprobacion_start ?>">
            <input type="hidden" name="fecha_aprobacion_end" class="form-control" value="<?php echo $this->fecha_aprobacion_end ?>">
            <input type="hidden" name="fecha_asignado_start" class="form-control" value="<?php echo $this->fecha_asignado_start ?>">
            <input type="hidden" name="fecha_asignado_end" class="form-control" value="<?php echo $this->fecha_asignado_end ?>">
            <input type="hidden" name="fecha_desembolso_start" class="form-control" value="<?php echo $this->fecha_desembolso_start ?>">
            <input type="hidden" name="fecha_desembolso_end" class="form-control" value="<?php echo $this->fecha_desembolso_end ?>">
            <button type="submit" class="btn btn-sm btn-success w-100"><i class="fa fa-file-excel-o" aria-hidden="true"></i>Exportar Excel</button>
          </form>
        </div>
      </div>
    </div>
    <div class="col-12">
      <?php echo count($this->solicitudes) ?> Registros encontrados
    </div>
    <div class="col-12">
      <table class="table table-bordered mt-3">
        <thead>
          <tr>
            <th>ID</th>
            <th>Fecha Aprobación</th>
            <th>Radicación</th>
            <th>Fecha Desembolso</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($this->solicitudes as $solicitud): ?>
            <tr>
              <td>
                <?php echo $solicitud->id ?>
              </td>
              <td>
                <?php echo $solicitud->fecha_aprobado ?>
              </td>
              <td>
                <?php echo $solicitud->fecha_asignado ?>
              </td>
              <td>
                <?php echo $solicitud->fecha_desembolso ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>