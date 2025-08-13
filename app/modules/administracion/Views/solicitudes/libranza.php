<div class="container py-5">
    <h1 class="text-center mb-5">Libranza</h1>
<form action="/administracion/solicitudes/exportarlibranza" method="post">
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="prestamo">Valor préstamo</label>
      <input type="number" class="form-control" id="prestamo" name="prestamo" value="<?php echo $this->solicitud->monto_solicitado?>" required min=0>
    </div>
    <div class="form-group col-md-6">
      <label for="linea"> Línea de crédito </label>
      <input type="text" class="form-control" id="linea" name="linea" value="<?php echo $this->solicitud->linea?>" required>
    </div>
 
  <div class="form-group col-md-6">
    <label for="cuota">Valor Cuota</label>
    <input type="text" class="form-control" id="cuota" name="cuota" value="<?php echo $this->solicitud->valor_cuota ?>" required>
  </div>
  <div class="form-group col-md-6">
    <label for="tasa">Tasa de Interés</label>
    <input type="number" class="form-control" id="tasa" name="tasa" placeholder="Tasa de Interés M.V." value="<?php echo $this->solicitud->tasa_desembolso?>" required step=0.01 min=0>
  </div>
  <div class="form-group col-md-6">
    <label for="ncuotas">Número de Cuotas</label>
    <input type="number" class="form-control" id="ncuotas" name="ncuotas" value="<?php echo $this->solicitud->cuotas?>" min=0 required>
  </div>
  <div class="form-group col-md-6">
    <label for="codigo"> Código de descuento</label>
    <input type="text" class="form-control" id="codigo" name="codigo" required>
  </div>
  </div>
  <div class="form-row mt-3">
    <div class="form-group col-12">
      <label for="deudorp">Deudor principal</label>
      <input type="text" class="form-control" id="deudorp" value="<?php echo $this->nombre?>" name="deudorp" required>
    </div>
    <div class="form-group col-12">
      <label for="deudors">Deudor Solidario</label>
      <input type="text" class="form-control" id="deudors" value="<?php echo $this->nombre2?>" name="deudors" required>
    </div>
    <div class="form-group col-md-2">
      <label for="fecha">Fecha</label>
      <input type="date" class="form-control" id="fecha" name="fecha" value="<?php echo date('Y-m-d'); ?>"required>
    </div>
  </div>
 <input type="hidden" name="id" value="<?php echo $_GET["id"]?>">
  <button type="submit" class="btn btn-primary">Exportar PDF</button>
 
</form>
</div>