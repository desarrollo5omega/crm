<?php
function con_cero1($x){
    $x = str_pad($x, 2, "0", STR_PAD_LEFT);
    return $x;
}
?>
<table cellspacing="0" cellpadding="0" width="100%" border="1">
  <tr>
    <td>tipo de    identificacion</td>
    <td>cedula</td>
    <td>nombre</td>
    <td>apellido</td>
    <td>direccion    residencia</td>
    <td>barrio</td>
    <td>telefono fijo</td>
    <td>celular</td>
    <td>salario</td>
    <td>direccion    laboral</td>
    <td>fecha    nacimiento&nbsp;</td>
    <td>fecha de    expedicion documento&nbsp;</td>
    <td>cuidad    nacimiento&nbsp;</td>
    <td>nacionalidad</td>
    <td>estado civil</td>
    <td>genero</td>
    <td>nivel    educativo&nbsp;</td>
    <td>titulo</td>
    <td>fecha de ingreso</td>
    <td>tipo de    contrato&nbsp;</td>
    <td>cargo&nbsp;</td>
    <td>codigo ciuu</td>
    <td>ciudad    laboral&nbsp;</td>
    <td>sede</td>
    <td>pagador</td>
    <td>otra</td>
    <td>valor cuota    periodica</td>
    <td>valor ahorro    voluntario</td>
    <td>valor ahorro    incentivo&nbsp;</td>
    <td>ingresos    mensuales</td>
    <td>egresos    mensuales</td>
    <td>activos</td>
    <td>pasivos</td>
    <td>otros    ingresos&nbsp;</td>
    <td>concepto&nbsp;</td>
    <td>&iquest;Por su cargo o    actividad, maneja recursos p&uacute;blicos?</td>
    <td>&iquest;Por su cargo o    actividad, ejerce alg&uacute;n grado de poder p&uacute;blico?</td>
    <td>&iquest;Por su    actividad u oficio, goza usted de reconocimiento p&uacute;blico general?</td>
    <td><br />
    &iquest;Tiene Familiares hasta el segundo grado de consanguinidad y afinidad que    encajen en los escenarios descritos previamente?</td>
    <td>Si alguna de las    preguntas anteriores es afirmativa por favor especifique</td>
    <td>&iquest;Realiza    transacciones en moneda extranjera?</td>
    <td>Tipo de producto</td>
    <td>Identificaci&oacute;n o    n&uacute;mero del Producto</td>
    <td>Entidad</td>
    <td>Monto</td>
    <td>Ciudad</td>
    <td>Pa&iacute;s</td>
    <td>Moneda</td>
    <?php for($i=0;$i<5;$i++){ ?>
        <td>nombre y    apellidos beneficiarios<?php echo $i+1; ?></td>
        <td>identificacion<?php echo $i+1; ?></td>
        <td>fecha de    nacimiento<?php echo $i+1; ?><br />
        dia/mes/a&ntilde;o<?php echo $i+1; ?></td>
        <td>parentesco&nbsp;<?php echo $i+1; ?></td>
        <td>autorizado</td>
    <?php } ?>
    <?php for($i=0;$i<5;$i++){ ?>
        <td>nombre y    apellidos hijos<?php echo $i+1; ?></td>
        <td>fecha de    nacimiento<br />
        dia/mes/a&ntilde;o<?php echo $i+1; ?></td>
        <td>edad<?php echo $i+1; ?></td>
        <td>nivel de    escolaridad&nbsp;<?php echo $i+1; ?></td>
    <?php } ?>
    <td>fecha de    actualizacion dia/mes/a&ntilde;o</td>
    <td>autorizaciones y    declaraciones (solo autorizo)</td>
  </tr>
  <?php foreach ($this->listado as $key => $value): ?>
      <tr>
        <td><?php echo $value->tipo_documento; ?></td>
        <td><?php echo $value->documento; ?></td>
        <td><?php echo $value->nombres; ?></td>
        <td><?php echo $value->apellidos; ?></td>
        <td><?php echo $value->direccion; ?></td>
        <td><?php echo $value->barrio; ?></td>
        <td><?php echo $value->telefono; ?></td>
        <td><?php echo $value->celular; ?></td>
        <td><?php echo $value->salario; ?></td>
        <td><?php echo $value->direccion_oficina; ?></td>
        <td><?php echo $value->fecha_nacimiento; ?></td>
        <td><?php echo $value->fecha_documento; ?></td>
        <td><?php echo $this->array_ciudades[$value->ciudad_nacimiento]; ?></td>
        <td><?php echo $value->pais; ?></td>
        <td><?php echo $value->estado_civil; ?></td>
        <td><?php echo $value->genero; ?></td>
        <td><?php echo $value->nivel_educativo; ?></td>
        <td><?php echo $value->titulo; ?></td>
        <td><?php echo $value->fecha_ingreso; ?></td>
        <td><?php echo $value->situacion_laboral; ?></td>
        <td><?php echo $value->cargo; ?></td>
        <td><?php echo $value->codigo_ciuu; ?></td>
        <td><?php echo $this->array_ciudades[$value->ciudad_oficina]; ?></td>
        <td><?php echo $value->sede; ?></td>
        <td><?php echo $value->empresa; ?></td>
        <td><?php echo $value->empresa_cual; ?></td>
        <td><?php echo $value->valor_cuota_periodica; ?></td>
        <td><?php echo $value->valor_ahorro_voluntario; ?></td>
        <td><?php echo $value->valor_ahorro_incentivo; ?></td>
        <td><?php echo $value->ingresos_mensuales; ?></td>
        <td><?php echo $value->egresos_mensuales; ?></td>
        <td><?php echo $value->activos; ?></td>
        <td><?php echo $value->pasivos; ?></td>
        <td><?php echo $value->otros_ingresos; ?></td>
        <td><?php echo $value->concepto_otros_ingresos; ?></td>
        <td><?php echo $value->recursos_publicos; ?></td>
        <td><?php echo $value->poder_publico; ?></td>
        <td><?php echo $value->reconocimiento; ?></td>
        <td><?php echo $value->familiares; ?></td>
        <td><?php echo $value->especifique; ?></td>
        <td><?php echo $value->transacciones_moneda_extranjera; ?></td>
        <td><?php echo $value->producto_tipo; ?></td>
        <td><?php echo $value->producto_numero; ?></td>
        <td><?php echo $value->producto_entidad; ?></td>
        <td><?php echo $value->producto_monto; ?></td>
        <td><?php echo $value->producto_ciudad; ?></td>
        <td><?php echo $value->producto_pais; ?></td>
        <td><?php echo $value->producto_moneda; ?></td>
        <?php for($i=0;$i<5;$i++){ ?>
            <?php
            $fecha_nacimiento="";
            if($value->beneficiarios[$i]->fecha_a!=""){
                $fecha_nacimiento = $value->beneficiarios[$i]->fecha_a."-".con_cero1($value->beneficiarios[$i]->fecha_m)."-".con_cero1($value->beneficiarios[$i]->fecha_d);
            }
            ?>
            <td><?php echo $value->beneficiarios[$i]->nombres; ?></td>
            <td><?php echo $value->beneficiarios[$i]->documento; ?></td>
            <td><?php echo $fecha_nacimiento; ?></td>
            <td><?php echo $value->beneficiarios[$i]->parentesco; ?></td>
            <td><?php echo $value->beneficiarios[$i]->porcentaje; ?></td>
        <?php } ?>
        <?php for($i=0;$i<5;$i++){ ?>
            <?php
            $fecha_nacimiento="";
            if($value->hijos[$i]->fecha_a!=""){
                $fecha_nacimiento = $value->hijos[$i]->fecha_a."-".con_cero1($value->hijos[$i]->fecha_m)."-".con_cero1($value->hijos[$i]->fecha_d);
            }
            ?>
            <td><?php echo $value->hijos[$i]->nombres; ?></td>
            <td><?php echo $fecha_nacimiento; ?></td>
            <td><?php echo $value->hijos[$i]->edad; ?></td>
            <td><?php echo $value->hijos[$i]->nivel_escolar; ?></td>
        <?php } ?>
        <td><?php echo $value->fecha; ?></td>
        <td>Autorizo</td>
      </tr>
    <?php endforeach ?>
</table>