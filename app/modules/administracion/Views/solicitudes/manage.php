<h1 class="titulo-principal"><i class="fas fa-cogs"></i> <?php echo $this->titlesection; ?></h1>
<div class="container-fluid">
  <form id="form-solicitud" class="text-start" enctype="multipart/form-data" method="post"
    action="<?php echo $this->routeform;?>" onsubmit="return validarcondiciones(this);">
    <div class="content-dashboard">
      <input type="hidden" name="csrf" id="csrf" value="<?php echo $this->csrf ?>">
      <input type="hidden" name="csrf_section" id="csrf_section" value="<?php echo $this->csrf_section ?>">
      <?php if ($this->content->id) { ?>
      <input type="hidden" name="id" id="id" value="<?= $this->content->id; ?>" />
      <input type="hidden" name="confirm_user" id="confirm_user" value="0" />
      <input type="hidden" name="notificacion_enviada" id="notificacion_enviada"
        value="<?= $this->content->notificacion_enviada; ?>" />
      <input type="hidden" name="cuota_prima" id="cuota_prima" value="<?= $this->content->cuota_prima; ?>" />
      <input type="hidden" name="cuota_prima_desembolso" id="cuota_prima_desembolso"
        value="<?= $this->content->cuota_prima_desembolso; ?>" />

      <?php }?>
      <div class="row">
        <div class="col-12">
          <h4>Información de la solicitud</h4>
        </div>
        <div class="col-3">
          <label for="" class="control-label">Fecha de afiliación</label>
          <label class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text input-icono  fondo-azul-claro "><i class="fas fa-pencil-alt"></i></span>
            </div>
            <input type="text" value="<?= ($this->usuario->fecha_afiliacion); ?>" disabled>
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-3">
          <label for="" class="control-label">Meses desde la afiliación</label>
          <label class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text input-icono  fondo-azul-claro "><i class="fas fa-pencil-alt"></i></span>
            </div>
            <input type="text" value="<?= ($this->mes_diff); ?>" disabled>
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-3">
          <label for="" class="control-label">Fecha de ingreso</label>
          <label class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text input-icono  fondo-azul-claro "><i class="fas fa-pencil-alt"></i></span>
            </div>
            <input type="text" value="<?= ($this->usuario->fecha_afiliacion_koba); ?>" disabled>
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-3">
          <label for="" class="control-label">Meses desde el ingreso</label>
          <label class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text input-icono  fondo-azul-claro "><i class="fas fa-pencil-alt"></i></span>
            </div>
            <input type="text" value="<?= ($this->mes_diff_ingreso); ?>" disabled>
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-3 form-group">
          <label for="linea" class="control-label">linea</label>
          <label class="input-group">

            <div class="input-group-prepend">
              <span class="input-group-text input-icono  fondo-rosado "><i class="far fa-list-alt"></i></span>
            </div>
            <select class="form-select" name="linea" id="linea" onchange="seleccionar_linea();">
              <option value="">Seleccione...</option>
              <?php foreach ($this->lineas AS $key => $value ){?>
              <option <?php if($this->getObjectVariable($this->content,"linea") == $value->codigo){ echo "selected"; }?>
                value="<?php echo $value->codigo; ?>" /> <?= $value->nombre; ?></option>
              <?php } ?>
            </select>

          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-3 form-group d-none">
          <label class="control-label">destino</label>
          <label class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text input-icono  fondo-cafe "><i class="far fa-list-alt"></i></span>
            </div>
            <select class="form-select" name="destino">
              <option value="">Seleccione...</option>
              <?php foreach ($this->list_destino AS $key => $value ){?>
              <option <?php if($this->getObjectVariable($this->content,"destino") == $key ){ echo "selected"; }?>
                value="<?php echo $key; ?>" /> <?= $value; ?></option>
              <?php } ?>
            </select>
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-3 form-group">
          <label for="valor" class="control-label">Valor solicitado</label>
          <label class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text input-icono  fondo-azul-claro "><i class="fas fa-pencil-alt"></i></span>
            </div>
            <input type="text" value="<?= formato_pesos($this->content->valor); ?>" name="valor" id="valor"
              class="form-control currency" onchange=" seleccionar_linea();">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-3 form-group d-none">
          <label for="monto_solicitado" class="control-label">monto solicitado</label>
          <label class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text input-icono  fondo-verde-claro "><i class="fas fa-pencil-alt"></i></span>
            </div>
            <input type="text" value="<?= $this->content->monto_solicitado; ?>" name="monto_solicitado"
              id="monto_solicitado" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>

        <div class="col-3 form-group">
          <label for="cuotas" class="control-label">cuotas</label>
          <label class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text input-icono  fondo-azul-claro "><i class="fas fa-pencil-alt"></i></span>
            </div>
            <select name="cuotas" class="form-control" id="cuotas" onchange="seleccionar_linea();">
              <?php for($i=$this->min;$i<=$this->max;$i++){ ?>
              <option value="<?php echo $i; ?>" <?php if($i==$this->content->cuotas){ echo 'selected="selected"'; } ?>>
                <?php echo $i; ?></option>
              <?php }?>
            </select>
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-3 form-group">
          <label for="valor_cuota" class="control-label">valor cuota</label>
          <label class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text input-icono  fondo-verde-claro "><i class="fas fa-pencil-alt"></i></span>
            </div>
            <input type="text" value="<?= formato_pesos($this->content->valor_cuota); ?>" name="valor_cuota"
              id="valor_cuota" class="form-control currency">
          </label>
          <div class="help-block with-errors"></div>
        </div>


        <div class="col-3 form-group d-none">
          <label class="control-label">Tipo de cuota extra</label>
          <label class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text input-icono  fondo-cafe "><i class="far fa-list-alt"></i></span>
            </div>
            <select class="form-select" name="frecuencia" id="frecuencia">
              <option value="6"
                <?php if($this->getObjectVariable($this->content,"frecuencua") == "6" ){ echo "selected"; }?>>
                Prima (Semestral)</option>
              <option value="12"
                <?php if($this->getObjectVariable($this->content,"frecuencua") == "12" ){ echo "selected"; }?>disabled="">
                Cesantia (Anual)</option>
            </select>
          </label>
          <div class="help-block with-errors"></div>
        </div>


        <div class="col-3 form-group ">
          <label for="cuotas_extra" class="control-label">cuotas extra</label>
          <label class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text input-icono  fondo-morado "><i class="fas fa-pencil-alt"></i></span>
            </div>
            <select name="cuotas_extra" id="abonos01" class="form-control" onchange=" seleccionar_linea();">
              <option <?php if(!$this->content->cuotas_extra){echo "selected";}?> value="">Seleccione
              </option>
              <option <?php if($this->content->cuotas_extra=="Junio"){echo "selected";}?> value="Junio">
                Junio</option>
              <option <?php if($this->content->cuotas_extra=="Diciembre"){echo "selected";}?> value="Diciembre">
                Diciembre</option>
              <option <?php if($this->content->cuotas_extra=="Junio y Diciembre"){echo "selected";}?>
                value="Junio y Diciembre">Junio y Diciembre</option>

            </select>
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-3 form-group ">
          <label for="valor_extra" class="control-label">valor cuotas extra</label>
          <label class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text input-icono  fondo-rojo-claro "><i class="fas fa-pencil-alt"></i></span>
            </div>
            <input type="text" value="<?= formato_pesos($this->content->valor_extra); ?>" name="valor_extra"
              id="valor_extra" class="form-control currency" onchange="seleccionar_linea();">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-3 form-group">
          <label for="tasa" class="control-label">tasa</label>
          <label class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text input-icono  fondo-cafe "><i class="fas fa-pencil-alt"></i></span>
            </div>
            <input type="text" onkeyup="seleccionar_linea()" value="<?= $this->content->tasa; ?>" name="tasa" id="tasa"
              class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>

        <div class="col-12"><br>
          <h4>Información de desembolso</h4>
        </div>

        <div class="col-3 form-group">
          <label for="valor_desembolso" class="control-label">valor desembolso</label>
          <label class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text input-icono  fondo-azul "><i class="fas fa-pencil-alt"></i></span>
            </div>
            <input type="text" value="<?= formato_pesos($this->content->valor_desembolso); ?>"
              onchange=" seleccionar_linea3();" name="valor_desembolso" id="valor_desembolso"
              class="form-control currency">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-3 form-group">
          <label class="control-label">linea desembolso</label>
          <label class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text input-icono  fondo-morado "><i class="far fa-list-alt"></i></span>
            </div>
            <select class="form-select" name="linea_desembolso" id="linea_desembolso" onchange="seleccionar_linea3(true);">
              <option value="">Seleccione...</option>
              <?php foreach ($this->lineas AS $key => $value ){?>
              <option
                <?php if($this->getObjectVariable($this->content,"linea_desembolso") == $value->codigo ){ echo "selected"; }?>
                value="<?php echo $value->codigo; ?>" /> <?= $value->nombre; ?></option>
              <?php } ?>
            </select>
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-3 form-group">
          <label for="cuotas_desembolso" class="control-label">cuotas desembolso</label>
          <label class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text input-icono  fondo-rojo-claro "><i class="fas fa-pencil-alt"></i></span>
            </div>
            <select name="cuotas_desembolso" class="form-control" id="cuotas_desembolso"
              onchange=" seleccionar_linea3(true);">
              <?php for($i=$this->min;$i<=$this->max;$i++){ ?>
              <option value="<?php echo $i; ?>"
                <?php if($this->content->cuotas_desembolso==$i){ echo 'selected="selected"'; } ?>>
                <?php echo $i; ?></option>
              <?php }?>
            </select>
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-3 form-group">
          <label for="valor_cuota_desembolso" class="control-label">valor cuota desembolso</label>
          <label class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text input-icono  fondo-azul "><i class="fas fa-pencil-alt"></i></span>
            </div>
            <input type="text" value="<?= formato_pesos($this->content->valor_cuota_desembolso); ?>"
              name="valor_cuota_desembolso" id="valor_cuota_desembolso" class="form-control currency">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <input type="hidden" value="<?php echo $this->content->id ?>" name="solicitud" id="solicitud">
        <div class="col-3 form-group">
          <label for="tasa_desembolso" class="control-label">tasa desembolso</label>
          <label class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text input-icono  fondo-verde "><i class="fas fa-pencil-alt"></i></span>
            </div>
            <input type="text" value="<?= $this->content->tasa_desembolso; ?>" onkeyup="seleccionar_linea3()"
              name="tasa_desembolso" id="tasa_desembolso" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-3 form-group ">
          <label for="cuotas_extra_desembolso" class="control-label">Primas que compromete</label>
          <label class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text input-icono  fondo-cafe "><i class="fas fa-pencil-alt"></i></span>
            </div>
            <select id="cuotas_extra_desembolso" name="cuotas_extra_desembolso" class="form-control"
              onchange=" seleccionar_linea3();">
              <option <?php if(!$this->content->cuota_prima_desembolso){echo "selected";}?> value="">
                Seleccione</option>
              <option <?php if($this->content->cuota_prima_desembolso=="Junio"){echo "selected";}?> value="Junio">Junio
              </option>
              <option <?php if($this->content->cuota_prima_desembolso=="Diciembre"){echo "selected";}?>
                value="Diciembre">Diciembre</option>
              <option <?php if($this->content->cuota_prima_desembolso=="Junio y Diciembre"){echo "selected";}?>
                value="Junio y Diciembre">Junio y Diciembre</option>
            </select>
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-3 form-group ">
          <label for="valor_extra_desembolso" class="control-label">Valor comprometido de primas</label>
          <label class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text input-icono  fondo-rosado "><i class="fas fa-pencil-alt"></i></span>
            </div>
            <input type="text" value="<?= formato_pesos($this->content->valor_extra_desembolso); ?>"
              onchange="seleccionar_linea3();" name="valor_extra_desembolso" id="valor_extra_desembolso"
              class="form-control currency">
          </label>
          <div class="help-block with-errors"></div>
        </div>

        <div class="col-3 form-group">
          <label for="fecha" class="control-label">fecha</label>
          <label class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text input-icono  fondo-rosado "><i class="fas fa-pencil-alt"></i></span>
            </div>
            <input type="text" value="<?= $this->content->fecha; ?>" name="fecha" id="fecha" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-3 form-group ">
          <label for="recoger_credito" class="control-label">Recoge crédito</label>
          <label class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text input-icono  fondo-cafe "><i class="fas fa-pencil-alt"></i></span>
            </div>
            <select name="recoger_credito" class="form-control">
              <option <?php if(!$this->content->recoger_credito){echo "selected";}?> value="">Seleccione
              </option>
              <option <?php if($this->content->recoger_credito=="1"){echo "selected";}?> value="1">SI
              </option>
              <option <?php if($this->content->recoger_credito=="0"){echo "selected";}?> value="0">NO
              </option>

            </select>
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-3 form-group ">
          <label for="valor_recogidos" class="control-label">valor recogido</label>
          <label class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text input-icono  fondo-rosado "><i class="fas fa-pencil-alt"></i></span>
            </div>
            <input type="text" value="<?= formato_pesos($this->content->valor_recogidos); ?>"
              onchange="restar_recogesaldo();seleccionar_linea3();" name="valor_recogidos"
              id="valor_recogidos" class="form-control currency">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-3 form-group d-none">
          <label for="validacion" class="control-label">Estado de la solicitud</label>
          <label class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text input-icono  fondo-azul-claro "><i class="fas fa-pencil-alt"></i></span>
            </div>
            <input type="hidden" name="validacion" value="<?php  echo $this->content->validacion?>">
            <!-- <select class="form-select" name="validacion" id="validacion">
                            <option value="">Seleccione...</option>
                            <?php foreach ($this->validaciones AS $key => $value ){?>
                            <option
                                <?php if($this->getObjectVariable($this->content,"validacion") == $key ){ echo "selected"; }?>
                                value="<?php echo $key; ?>" /> <?= $value; ?></option>
                            <?php } ?>
                        </select> -->

          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-3 form-group d-none">
          <label for="radicacion" class="control-label">radicacion</label>
          <label class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text input-icono  fondo-verde-claro "><i class="fas fa-pencil-alt"></i></span>
            </div>
            <input type="text" value="<?= $this->content->radicacion; ?>" name="radicacion" id="radicacion"
              class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <input type="hidden" name="paso" value="<?php echo $this->content->paso ?>">


        <div class="col-12"><br>
          <h4>Información del solicitante</h4>
        </div>
        <div class="col-3 form-group d-none">
          <label for="cedula" class="control-label">cedula</label>
          <label class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text input-icono  fondo-verde "><i class="fas fa-pencil-alt"></i></span>
            </div>
            <input type="text" value="<?= $this->content->cedula; ?>" name="cedula" id="cedula" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-3 form-group">
          <label for="nombres" class="control-label">nombres</label>
          <label class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text input-icono  fondo-azul "><i class="fas fa-pencil-alt"></i></span>
            </div>
            <input type="text" value="<?= $this->content->nombres; ?>" name="nombres" id="nombres" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-3 form-group">
          <label for="nombres2" class="control-label">nombres2</label>
          <label class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text input-icono  fondo-verde "><i class="fas fa-pencil-alt"></i></span>
            </div>
            <input type="text" value="<?= $this->content->nombres2; ?>" name="nombres2" id="nombres2"
              class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-3 form-group">
          <label for="apellido1" class="control-label">apellido1</label>
          <label class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text input-icono  fondo-morado "><i class="fas fa-pencil-alt"></i></span>
            </div>
            <input type="text" value="<?= $this->content->apellido1; ?>" name="apellido1" id="apellido1"
              class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-3 form-group">
          <label for="apellido2" class="control-label">apellido2</label>
          <label class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text input-icono  fondo-rojo-claro "><i class="fas fa-pencil-alt"></i></span>
            </div>
            <input type="text" value="<?= $this->content->apellido2; ?>" name="apellido2" id="apellido2"
              class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-3 form-group">
          <label for="sexo" class="control-label">sexo</label>
          <label class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text input-icono  fondo-rosado "><i class="fas fa-pencil-alt"></i></span>
            </div>
            <input type="text" value="<?= $this->content->sexo; ?>" name="sexo" id="sexo" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-3 form-group">
          <label for="tipo_documento" class="control-label">tipo documento</label>
          <label class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text input-icono  fondo-verde-claro "><i class="fas fa-pencil-alt"></i></span>
            </div>
            <input type="text" value="<?= $this->content->tipo_documento; ?>" name="tipo_documento" id="tipo_documento"
              class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-3 form-group">
          <label for="documento" class="control-label">documento</label>
          <label class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text input-icono  fondo-cafe "><i class="fas fa-pencil-alt"></i></span>
            </div>
            <input type="text" value="<?= $this->content->documento; ?>" name="documento" id="documento"
              class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-3 form-group">
          <label for="fecha_documento" class="control-label">fecha documento</label>
          <label class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text input-icono  fondo-verde "><i class="fas fa-calendar-alt"></i></span>
            </div>
            <input type="text"
              value="<?php if($this->content->fecha_documento){ echo $this->content->fecha_documento; } else { echo date('Y-m-d'); } ?>"
              name="fecha_documento" id="fecha_documento" class="form-control" data-provide="datepicker"
              data-date-format="yyyy-mm-dd" data-date-language="es">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-3 form-group">
          <label for="ciudad_documento" class="control-label">ciudad documento</label>
          <label class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text input-icono  fondo-azul "><i class="fas fa-pencil-alt"></i></span>
            </div>
            <select name="ciudad_documento" id="ciudad_documento" required class="form-control">
              <?php foreach ($this->ciudades as $ciudad): ?>
              <option value="<?php echo $ciudad->codigo; ?>"
                <?php if($this->content->ciudad_documento==$ciudad->codigo){ echo 'selected'; } ?>>
                <?php echo  (($ciudad->nombre))." (".($ciudad->departamento).")"; ?></option>
              <?php endforeach ?>
            </select>
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-3 form-group">
          <label for="fecha_nacimiento" class="control-label">fecha nacimiento</label>
          <label class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text input-icono  fondo-morado "><i class="fas fa-calendar-alt"></i></span>
            </div>
            <input type="text"
              value="<?php if($this->content->fecha_nacimiento){ echo $this->content->fecha_nacimiento; } else { echo date('Y-m-d'); } ?>"
              name="fecha_nacimiento" id="fecha_nacimiento" class="form-control" data-provide="datepicker"
              data-date-format="yyyy-mm-dd" data-date-language="es">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-3 form-group">
          <label for="empresa" class="control-label">empresa</label>
          <label class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text input-icono  fondo-rojo-claro "><i class="fas fa-pencil-alt"></i></span>
            </div>
            <input type="text" value="<?= $this->content->empresa; ?>" name="empresa" id="empresa" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-3 form-group">
          <label for="dependencia" class="control-label">dependencia</label>
          <label class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text input-icono  fondo-azul-claro "><i class="fas fa-pencil-alt"></i></span>
            </div>
            <input type="text" value="<?= $this->content->dependencia; ?>" name="dependencia" id="dependencia"
              class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-4 form-group">
          <label for="direccion_oficina" class="control-label">direccion oficina</label>
          <label class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text input-icono  fondo-verde "><i class="fas fa-pencil-alt"></i></span>
            </div>

            <select name="nomenclatura1" id="nomenclatura1" class="form-control d-none">
              <option value="">Nomenclatura</option>
              <?php foreach ($this->nomenclaturas as $key => $value): ?>
              <option value="<?php echo $value->codigo; ?>"
                <?php if($value->codigo==$this->content->nomenclatura1){ echo 'selected'; } ?>>
                <?php echo codificar($value->nombre); ?></option>
              <?php endforeach ?>
            </select>

            <input type="text" value="<?= $this->content->direccion_oficina; ?>" name="direccion_oficina"
              id="direccion_oficina" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-3 form-group">
          <label for="ciudad_oficina" class="control-label">ciudad oficina</label>
          <label class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text input-icono  fondo-verde-claro "><i class="fas fa-pencil-alt"></i></span>
            </div>
            <select name="ciudad_oficina" id="ciudad_oficina" required class="form-control">
              <?php foreach ($this->ciudades as $ciudad): ?>
              <option value="<?php echo $ciudad->codigo; ?>"
                <?php if($this->content->ciudad_oficina==$ciudad->codigo){ echo 'selected'; } ?>>
                <?php echo  (($ciudad->nombre))." (".($ciudad->departamento).")"; ?></option>
              <?php endforeach ?>
            </select>
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-3 form-group">
          <label for="telefono_oficina" class="control-label">telefono oficina</label>
          <label class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text input-icono  fondo-rojo-claro "><i class="fas fa-pencil-alt"></i></span>
            </div>
            <input type="text" value="<?= $this->content->telefono_oficina; ?>" name="telefono_oficina"
              id="telefono_oficina" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-3 form-group">
          <label for="celular" class="control-label">celular</label>
          <label class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text input-icono  fondo-morado "><i class="fas fa-pencil-alt"></i></span>
            </div>
            <input type="text" value="<?= $this->content->celular; ?>" name="celular" id="celular" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-4 form-group">
          <label for="direccion_residencia" class="control-label">direccion residencia</label>
          <label class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text input-icono  fondo-azul "><i class="fas fa-pencil-alt"></i></span>
            </div>

            <select name="nomenclatura2" id="nomenclatura2" class="form-control d-none">
              <option value="">Nomenclatura</option>
              <?php foreach ($this->nomenclaturas as $key => $value): ?>
              <option value="<?php echo $value->codigo; ?>"
                <?php if($value->codigo==$this->content->nomenclatura2){ echo 'selected'; } ?>>
                <?php echo codificar($value->nombre); ?></option>
              <?php endforeach ?>
            </select>

            <input type="text" value="<?= $this->content->direccion_residencia; ?>" name="direccion_residencia"
              id="direccion_residencia" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-3 form-group">
          <label for="barrio" class="control-label">barrio</label>
          <label class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text input-icono  fondo-cafe "><i class="fas fa-pencil-alt"></i></span>
            </div>
            <input type="text" value="<?= $this->content->barrio; ?>" name="barrio" id="barrio" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-3 form-group">
          <label for="ciudad_residencia" class="control-label">ciudad residencia</label>
          <label class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text input-icono  fondo-azul-claro "><i class="fas fa-pencil-alt"></i></span>
            </div>
            <select name="ciudad_residencia" id="ciudad_residencia" required class="form-control">
              <?php foreach ($this->ciudades as $ciudad): ?>
              <option value="<?php echo $ciudad->codigo; ?>"
                <?php if($this->content->ciudad_residencia==$ciudad->codigo){ echo 'selected'; } ?>>
                <?php echo  (($ciudad->nombre))." (".($ciudad->departamento).")"; ?></option>
              <?php endforeach ?>
            </select>
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-3 form-group">
          <label for="telefono" class="control-label">telefono</label>
          <label class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text input-icono  fondo-rosado "><i class="fas fa-pencil-alt"></i></span>
            </div>
            <input type="text" value="<?= $this->content->telefono; ?>" name="telefono" id="telefono"
              class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-4 form-group">
          <label for="correo_empresarial" class="control-label">Correo personal</label>
          <label class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text input-icono  fondo-rosado "><i class="fas fa-pencil-alt"></i></span>
            </div>
            <input type="text" value="<?= $this->content->correo_empresarial; ?>" name="correo_empresarial"
              id="correo_empresarial" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-4 form-group">
          <label for="correo_personal" class="control-label">Correo alterno</label>
          <label class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text input-icono  fondo-azul-claro "><i class="fas fa-pencil-alt"></i></span>
            </div>
            <input type="text" value="<?= $this->content->correo_personal; ?>" name="correo_personal"
              id="correo_personal" class="form-control" required>
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <input type="hidden" name="situacion_laboral" value="<?php echo $this->content->situacion_laboral ?>">
        <input type="hidden" name="cual" value="<?php echo $this->content->cual ?>">
        <input type="hidden" name="ocupacion" value="<?php echo $this->content->ocupacion ?>">
        <input type="hidden" name="estado_civil" value="<?php echo $this->content->estado_civil ?>">
        <input type="hidden" name="conyuge_nombre" value="<?php echo $this->content->conyuge_nombre ?>">
        <input type="hidden" name="conyuge_telefono" value="<?php echo $this->content->conyuge_telefono ?>">
        <input type="hidden" name="conyuge_celular" value="<?php echo $this->content->conyuge_celular ?>">
        <input type="hidden" name="peso" value="<?php echo $this->content->peso ?>">
        <input type="hidden" name="estatura" value="<?php echo $this->content->estatura ?>">
        <input type="hidden" name="declara_renta" value="<?php echo $this->content->declara_renta ?>">
        <input type="hidden" name="persona_publica" value="<?php echo $this->content->persona_publica ?>">
        <input type="hidden" name="cuenta_numero" value="<?php echo $this->content->cuenta_numero ?>">
        <input type="hidden" name="cuenta_tipo" value="<?php echo $this->content->cuenta_tipo ?>">
        <input type="hidden" name="entidad_bancaria" value="<?php echo $this->content->entidad_bancaria ?>">
        <input type="hidden" name="ingreso_mensual" value="<?php echo $this->content->ingreso_mensual ?>">
        <input type="hidden" name="otros_ingresos" value="<?php echo $this->content->otros_ingresos ?>">
        <input type="hidden" name="total_ingresos" value="<?php echo $this->content->total_ingresos ?>">
        <input type="hidden" name="canon_arrendamiento" value="<?php echo $this->content->canon_arrendamiento ?>">
        <input type="hidden" name="otros_gastos" value="<?php echo $this->content->otros_gastos ?>">
        <input type="hidden" name="total_egresos" value="<?php echo $this->content->total_egresos ?>">
        <input type="hidden" name="activos" value="<?php echo $this->content->activos ?>">
        <input type="hidden" name="pasivos" value="<?php echo $this->content->pasivos ?>">
        <input type="hidden" name="patrimonio" value="<?php echo $this->content->patrimonio ?>">
        <input type="hidden" name="descripcion_ingresos" value="<?php echo $this->content->descripcion_ingresos ?>">
        <input type="hidden" name="descripcion_recursos" value="<?php echo $this->content->descripcion_recursos ?>">
        <input type="hidden" name="tipo_garantia" value="<?php echo $this->content->tipo_garantia ?>">
        <input type="hidden" name="FM_meses" value="<?php echo $this->content->FM_meses ?>">

        <div class="col-12"><br>
          <h4>Observaciones</h4>
        </div>

        <div class="col-12 form-group">
          <label for="observaciones" class="form-label">Objetivo del crédito</label>
          <textarea name="observaciones" id="observaciones" class="form-control tinyeditor"
            rows="5"><?= $this->content->observaciones; ?></textarea>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-12 form-group">
          <label for="observacion_analista" class="form-label">observacion analista</label>
          <textarea name="observacion_analista" id="observacion_analista" class="form-control tinyeditor"
            rows="5"><?= $this->content->observacion_analista; ?></textarea>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-12 form-group d-none">
          <label for="observacion_auxiliar" class="form-label">observacion auxiliar</label>
          <textarea name="observacion_auxiliar" id="observacion_auxiliar" class="form-control tinyeditor"
            rows="5"><?= $this->content->observacion_auxiliar; ?></textarea>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-12 form-group d-none">
          <label for="observacion_riesgo" class="form-label">observacion riesgo</label>
          <textarea name="observacion_riesgo" id="observacion_riesgo" class="form-control tinyeditor"
            rows="5"><?= $this->content->observacion_riesgo; ?></textarea>
          <div class="help-block with-errors"></div>
        </div>

        <div class="col-12"><br>
          <h4>Información estado de la solicitud</h4>
        </div>
        <div class="col-3 form-group">
          <label for="tramite" class="control-label">tramite</label>
          <label class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text input-icono  fondo-verde-claro "><i class="fas fa-pencil-alt"></i></span>
            </div>
            <input type="text" value="<?= $this->content->tramite; ?>" name="tramite" id="tramite" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-3 form-group">
          <label class="control-label">ejecutivo de cuenta</label>
          <label class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text input-icono  fondo-azul "><i class="far fa-list-alt"></i></span>
            </div>
            <select class="form-select" name="gestor_comercial">
              <option value="">Seleccione...</option>
              <?php foreach ($this->list_gestor_comercial AS $key => $value ){?>
              <option
                <?php if($this->getObjectVariable($this->content,"gestor_comercial") == $key ){ echo "selected"; }?>
                value="<?php echo $key; ?>" /> <?= $value; ?></option>
              <?php } ?>
            </select>
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-3 form-group">
          <label class="control-label">Analista asignado</label>
          <label class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text input-icono  fondo-morado "><i class="far fa-list-alt"></i></span>
            </div>
            <select class="form-select" name="asignado">
              <option value="">Seleccione...</option>
              <?php foreach ($this->list_asignado AS $key => $value ){?>
              <option <?php if($this->getObjectVariable($this->content,"asignado") == $key ){ echo "selected"; }?>
                value="<?php echo $key; ?>" /> <?= $value; ?></option>
              <?php } ?>
            </select>
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-3 form-group">
          <label class="control-label">Regional</label>
          <label class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text input-icono  fondo-morado "><i class="far fa-list-alt"></i></span>
            </div>
            <select class="form-select" name="regional">
              <option value="">Seleccione...</option>
              <?php foreach ($this->list_regional AS $key => $value ){?>
              <option <?php if($this->getObjectVariable($this->content,"regional") == $key ){ echo "selected"; }?>
                value="<?php echo $key; ?>" /> <?= $value; ?></option>
              <?php } ?>
            </select>
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-3 form-group">
          <label for="fecha_asignado" class="control-label">fecha asignado</label>
          <label class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text input-icono  fondo-cafe "><i class="fas fa-pencil-alt"></i></span>
            </div>
            <input type="text" value="<?= $this->content->fecha_asignado; ?>" name="fecha_asignado" id="fecha_asignado"
              class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-3 form-group">
          <label for="pagare" class="control-label">número de pagare</label>
          <label class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text input-icono  fondo-rojo-claro "><i class="fas fa-pencil-alt"></i></span>
            </div>
            <input type="text" value="<?= $this->content->pagare; ?>" name="pagare" id="pagare" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-3 form-group d-none">
          <label class="control-label">quien</label>
          <label class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text input-icono  fondo-verde "><i class="far fa-list-alt"></i></span>
            </div>
            <select class="form-select" name="quien">
              <option value="">Seleccione...</option>
              <?php foreach ($this->list_quien AS $key => $value ){?>
              <option <?php if($this->getObjectVariable($this->content,"quien") == $key ){ echo "selected"; }?>
                value="<?php echo $key; ?>" /> <?= $value; ?></option>
              <?php } ?>
            </select>
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <input type="hidden" name="fecha_estado" value="<?php echo $this->content->fecha_estado ?>">
        <div class="col-3 form-group d-none">
          <label for="numero_obligacion" class="control-label">número obligación</label>
          <label class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text input-icono  fondo-verde "><i class="fas fa-pencil-alt"></i></span>
            </div>
            <input type="text" value="<?= $this->content->numero_obligacion; ?>" name="numero_obligacion"
              id="numero_obligacion" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>

        <div class="col-3 form-group">
          <label for="capacidad_endeudamiento" class="control-label">capacidad de endeudamiento</label>
          <label class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text input-icono  fondo-verde "><i class="fas fa-pencil-alt"></i></span>
            </div>
            <input type="text" value="<?= $this->content->capacidad_endeudamiento; ?>" name="capacidad_endeudamiento"
              id="capacidad_endeudamiento" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>

        <input type="hidden" name="autorizo" value="<?php echo $this->content->autorizo ?>">
        <input type="hidden" name="fecha_autorizo" value="<?php echo $this->content->fecha_autorizo ?>">
        <div class="col-3 form-group">
          <label class="control-label">Vo Bo Autorización</label>
          <label class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text input-icono  fondo-morado "><i class="far fa-list-alt"></i></span>
            </div>
            <select class="form-select" name="estado_autorizo">
              <option value="" selected disabled>Seleccione...</option>
              <?php foreach ($this->list_estado_autorizo AS $key => $value ){?>
              <option
                <?php if($this->getObjectVariable($this->content,"estado_autorizo") == $key ){ echo "selected"; }?>
                value="<?php echo $key; ?>" /> <?= $value; ?></option>
              <?php } ?>
            </select>
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <input type="hidden" name="incompleta" value="<?php echo $this->content->incompleta ?>">
        <input type="hidden" name="fecha_anterior" value="<?php echo $this->content->fecha_anterior ?>">
        <input type="hidden" name="asignado_anterior" value="<?php echo $this->content->asignado_anterior ?>">
      </div>
    </div>
    <div class="botones-acciones">
      <button class="btn btn-guardar" type="submit">Guardar</button>
      <a href="<?php echo $this->route; ?>" class="btn btn-cancelar">Cancelar</a>
    </div>
  </form>
</div>

<div class="entity-floats">
<?php if($_SESSION['kt_login_level']=="1" or $_SESSION['kt_login_level']=="3" or $_SESSION['kt_login_level']=="8" or $_SESSION['kt_login_level']=="14" or $_SESSION['kt_login_level']=="15" or $_SESSION['kt_login_level']=="16"){ ?>
  <?php if($this->content->estado_autorizo=="1"){ ?>
    <a class="btn btn-success btn-sm" href="<?php echo $this->route;?>/formatocomite/?id=<?php echo $this->content->id ?>" data-bs-toggle="tooltip" data-placement="top" title="Formato aprobación comité de crédito" target="_blank"><i class="fas fa-users"></i></a>
    <a class="btn btn-azul btn-sm" href="<?php echo $this->route;?>/formatocomiteespecial/?id=<?php echo $this->content->id ?>" data-bs-toggle="tooltip" data-placement="top" title="Formato aprobación aprobación junta directiva" target="_blank"><i class="fas fa-users"></i></a>
    <a class="btn btn-warning btn-sm" href="<?php echo $this->route;?>/formatogerencia/?id=<?php echo $this->content->id ?>" data-bs-toggle="tooltip" data-placement="top" title="Formato aprobación gerencia" target="_blank"><i class="fas fa-user"></i></a>
    <?php if($this->content->quien_aprobo=="Analista"){ ?>
      <a class="btn btn-success btn-sm" href="<?php echo $this->route;?>/formatoanalista/?id=<?php echo $this->content->id ?>" data-bs-toggle="tooltip" data-placement="top" title="Formato aprobación analista" target="_blank"><i class="fas fa-user"></i></a>
    <?php } ?>
  <?php } ?>
<?php } ?>
</div>

<style>
  .entity-floats{
    position: fixed;
    top: 50%;
    right: 0;
    display: flex;
    flex-direction: column;
    gap: 5px;
  }
</style>
<?php


function codificar($x){
    $x = utf8_encode($x);
    return $x;
}
?>
<script>
$(document).ready(function() {

  $("#cuotas").val('<?php echo $this->content->cuotas?>');
  $("#cuotas_desembolso").val('<?php echo $this->content->cuotas_desembolso?>');
  <?php if($this->content->cuotas_extra>0){ ?>
  $("#abonos").val('<?php echo $this->content->cuotas_extra ?>');
  <?php }?>
  <?php if($this->content->cuotas_extra_desembolso){ ?>
  $("#abonos2").val('<?php echo $this->content->cuotas_extra_desembolso ?>');
  <?php }?>
  $("#linea").val('<?php echo $this->content->linea?>');

  $("#linea_desembolso").val('<?php echo $this->content->linea_desembolso?>');

  seleccionar_linea3();
});

function seleccionar_linea() {

  var linea = $("#linea").val();
  var valor = $("#valor").val();
  var monto_solicitado = $("#monto_solicitado").val();
  var cuotas = $("#cuotas").val();

  var abonos = $("#cuotas_extra").val();
  $("#cuota_prima").val(abonos);
  var extra = $("#valor_extra").val();
  var destino = $("#destino").val();
  var frecuencia = $("#frecuencia").val();
  $("#linea2").val(linea);
  $("#cuotas2").val(cuotas);
  $("#frecuencia2").val(frecuencia);



  $.post("/page/sistema/filtrolinea/", {
    "linea": linea,
    "valor": valor,
    "monto_solicitado": monto_solicitado,
    "cuotas": cuotas,
    "abonos": abonos,
    "extra": extra,
    "destino": destino
  }, function(res) {
    $('#saldo_actual1').html(res.saldo_actual1);
    res.tasa_nominal = res.tasa_nominal.substring(0, 4);
    $('#tasa_nominal').html(res.tasa_nominal + "%");
    $('#tasa_mes').html(res.tasa + "%");
    $('#tasa').val(res.tasa);
    $('#valor_disponible').html(res.valor_disponible);
    $('#cuotas').html(res.menu_cuotas);
    //limitarCuotas();


    if (res.r > 0) {
      $("#valor_cuota1").html(res.r1);
      $("#valor_cuota").val(res.r2);
      $("#valor_cuota2").val(res.r);
    }

    var valor_desembolso = valor;
    $("#valor_desembolso").val(valor_desembolso);
    $("#valor_desembolso1").val(valor_desembolso);

    //sumar_saldos(0);

    var smmlv = 877803;
    var cuota_minima = Number(smmlv * 6 / 100);
    if (Number(res.r) < Number(cuota_minima)) {
      $("#div_siguiente").hide();
      $("#error_cuota").show();
    } else {
      $("#div_siguiente").show();
      $("#error_cuota").hide();
    }


  });
}

function seleccionar_linea2() {

  var linea = $("#linea").val();
  var valor = $("#valor").val();
  var monto_solicitado = $("#monto_solicitado").val();
  var cuotas = $("#cuotas").val();

  var abonos = $("#abonos").val();
  var extra = $("#extra").val();
  var destino = $("#destino").val();
  var frecuencia = $("#frecuencia").val();
  var tasa = $("#tasa").val();

  $("#linea2").val(linea);
  $("#cuotas2").val(cuotas);
  $("#frecuencia2").val(frecuencia);



  $.post("/page/sistema/filtrolinea/", {
    "linea": linea,
    "valor": valor,
    "monto_solicitado": monto_solicitado,
    "cuotas": cuotas,
    "abonos": abonos,
    "extra": extra,
    "destino": destino,
    "tasa": tasa
  }, function(res) {
    $('#saldo_actual1').html(res.saldo_actual1);
    res.tasa_nominal = res.tasa_nominal.substring(0, 4);
    $('#tasa_nominal').html(res.tasa_nominal + "%");
    $('#tasa_mes').html(res.tasa + "%");
    $('#tasa').val(res.tasa);
    $('#valor_disponible').html(res.valor_disponible);
    $('#cuotas').html(res.menu_cuotas);


    if (res.r > 0) {
      $("#valor_cuota1").html(res.r1);
      $("#valor_cuota").val(res.r2);
      $("#valor_cuota2").val(res.r);
    }

    var valor_desembolso = valor;
    $("#valor_desembolso").val(valor_desembolso);
    $("#valor_desembolso1").val(valor_desembolso);

    //sumar_saldos(0);

    var smmlv = 877803;
    var cuota_minima = Number(smmlv * 6 / 100);
    if (Number(res.r) < Number(cuota_minima)) {
      $("#div_siguiente").hide();
      $("#error_cuota").show();
    } else {
      $("#div_siguiente").show();
      $("#error_cuota").hide();
    }


  });
}

function restar_recogesaldo() {
  var valor2 = "<?php echo $this->content->valor_desembolso;?>".replace(/\./g, '');
  var valor_recogido = $("#valor_recogidos").val().replace(/\./g, '');
  var nuevo_valor = valor2 - valor_recogido;
  $("#valor_desembolso").val(nuevo_valor);
  puntitos(document.getElementById('valor_desembolso'));

}

function seleccionar_linea3(bool_tasa) {

  var linea = $("#linea_desembolso").val();
  var valor = $("#valor_desembolso").val();

  var monto_solicitado = $("#monto_solicitado").val();
  var cuotas = $("#cuotas_desembolso").val();

  var abonos = $("#cuotas_extra_desembolso").val();
  // var abonotext = $('select[name="cuotas_extra_desembolso"] option:selected').text();
  // $("#cuota_prima_desembolso").val(abonotext);
  var extra = $("#valor_extra_desembolso").val();
  var destino = $("#destino").val();
  var frecuencia = $("#frecuencia").val();
  var tasa_desembolso = $("#tasa_desembolso").val();
  var solicitud = $("#solicitud").val();

  var active_tasa = 0
  if (bool_tasa) {
    active_tasa = 1
  }

  $("#linea2").val(linea);
  $("#cuotas2").val(cuotas);
  $("#frecuencia2").val(frecuencia);
  

  $.post("/page/sistema/filtrolineaadmin/", {
    "linea": linea,
    "valor": valor,
    "monto_solicitado": monto_solicitado,
    "cuotas": cuotas,
    "abonos": abonos,
    "extra": extra,
    "destino": destino,
    "tasa_desembolso": tasa_desembolso,
    "solicitud": solicitud,
    "active_tasa": active_tasa
  }, function(res) {
    if (res) {
      $('#saldo_actual1').html(res.saldo_actual1);
      $('#tasa_mes').html(res.tasa + "%");
      if(bool_tasa){
        $('#tasa_desembolso').val(res.tasa);
      }
      $('#valor_disponible').html(res.valor_disponible);
      $('#cuotas_desembolso').html(res.menu_cuotas);
    }
    // limitarCuotas2();


    if (res.r > 0) {
      $("#valor_cuota1").html(res.r1);
      $("#valor_cuota_desembolso").val(res.r2);
      $("#valor_cuota2").val(res.r);
    }

    var valor_desembolso = valor;
    $("#valor_desembolso").val(valor_desembolso);
    $("#valor_desembolso1").val(valor_desembolso);

    //sumar_saldos(0);

    var smmlv = 877803;
    var cuota_minima = Number(smmlv * 6 / 100);
    if (Number(res.r) < Number(cuota_minima)) {
      $("#div_siguiente").hide();
      $("#error_cuota").show();
    } else {
      $("#div_siguiente").show();
      $("#error_cuota").hide();
    }


  });
  //window.location="/page/sistema/?linea="+linea;
}

function validarcondiciones(a) {
  //event.preventDefault();
  let notificacion_enviada = $("#notificacion_enviada").val();
  if (notificacion_enviada != 1 && <?php echo $this->content->validacion ?> == 6) {
    let valor_desembolso = $("#valor_desembolso").val();
    let valor = $("#valor").val();
    let linea_desembolso = $("#linea_desembolso").val();
    let linea = $("#linea").val();
    let cuotas_desembolso = $("#cuotas_desembolso").val();
    let cuotas = $("#cuotas").val();
    let valor_cuota_desembolso = $("#valor_cuota_desembolso").val();
    let valor_cuota = $("#valor_cuota").val();
    //console.log(cuotas_desembolso);
    //console.log(cuotas);
    if (valor_desembolso != valor || linea_desembolso != linea || cuotas_desembolso != cuotas ||
      valor_cuota_desembolso != valor_cuota) {
      var notificar = confirm("Se enviara un correo al asociado notificando el cambio de condiciones");
      if (notificar) {
        $("#confirm_user").val("1");

      } else {
        event.preventDefault();
      }
    }
  }

}
</script>