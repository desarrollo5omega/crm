<?php
$cabecera=" En la ciudad de Bogotá D.C., a los [FECHA], se reunieron <b>ORDINARIAMENTE</b> y de conformidad con lo establecido por el Reglamento del Comité de Crédito y Especial de Crédito en el Parágrafo del Artículo 6, los siguientes miembros del <b>[TIPO_ACTA]</b> del Fondo de Empleados Grupo Endesa Colombia- <b>FONDTODOS</b>:";

$cuerpo="
Así mismo, asiste la señora <b>[SECRETARIA]</b>, en calidad de Técnico Crédito y Cartera de FONDTODOS. En dicha Sesión, se desarrolló el siguiente orden del día:<br><br>

<b>1.	VERIFICACIÓN DEL QUÓRUM.</b><br><br>

La señora <b>[SECRETARIA]</b>, en calidad de Técnico Crédito y Cartera, verifica la asistencia a la reunión, encontrando la participación de tres (3) miembros del Comité, lo cual constituye quórum para deliberar y adoptar decisiones válidas.<br><br>

<b>2.	PRESENTACIÓN SOLICITUDES DE CREDITO ASOCIADOS PARA APROBACIÓN Y DESEMBOLSO.</b><br><br>

La señora <b>[SECRETARIA]</b>, en calidad de Técnico Crédito y Cartera de <b>FONDTODOS</b> y secretario del Comité Ordinario de Crédito, presenta la relación de solicitudes de crédito radicadas por los asociados y evaluadas, las cuales se detallan en el Anexo # 1 parte integral de la presente Acta.<br><br>

<b>3.	MONTO TOTAL APROBADO.</b><br><br>

Una vez revisada y analizada la información contenida en el Anexo # 1 de la presente Acta por los miembros del Comité Ordinario de Crédito, al tenor de lo dispuesto por la Circular Básica Contable y Financiera y el Reglamento de Ahorro y Crédito vigente de <b>FONDTODOS</b>, el monto total <b>APROBADO</b> es por la suma de <b>CATORCE MILLONES CIENTO SETENTA MIL PESOS M/CTE ($ 14.170.000)</b>.<br><br>

<b>4.	DESEMBOLSO, NOTIFICACIONES Y ENVIO DE TABLAS DE AMORTIZACIÓN.</b><br><br>

Los miembros del comité Ordinario de Crédito de <b>FONDTODOS</b> solicitan a la señora <b>[SECRETARIA]</b>, en calidad de Técnico Crédito y Cartera <b>FONDTODOS</b>:

Adelantar las acciones pertinentes tendientes al desembolso de las solicitudes de Crédito de acuerdo la información contenida en el anexo N°1 de la presente Acta y en observancia a lo consagrado por el Articulo 44 Parágrafo 1 y 2 del Reglamento de Ahorro y Crédito vigente de <b>FONDTODOS</b>;

<ul>
	<li>Notificar por correo electrónico, llamada telefónica o comunicación a través de documento por escrito al asociado identificado con el Anexo N°1 de la presente Acta en relación con la aprobación y desembolso de la solicitud de Crédito, informando en detalle las condiciones de aprobación.</li>

	<li>Enviar por correo electrónico o comunicación a través de documento por escrito a cada uno de los Asociados indicados en el Anexo N°1 de la presente Acta, la tabla de amortización de la solicitud de Crédito respectiva.</li>

	<li>A los asociados que tienen reporte negativo en la central de riesgo, avisarles de la mora, y a aquellos que tienen cartera castigada girar directamente a las entidades de lo reportaron y solicitar una vez pagado los respectivos paz y salvos.</li>
</ul>

<b>5.	PROPOSICIONES Y VARIOS.</b>

Se encuentra aprobado por el comité de crédito y se realizara su causación y desembolso cuando se cumplan todas las condiciones de acuerdo con el reglamento de crédito.

<br><br>
<table width='100%'>
	<tr>
		<td><b>[PRESIDENTE]</b></td>
		<td><b>[SECRETARIA]</b></td>
	</tr>
	<tr>
		<td><b>Presidente</b></td>
		<td><b>Secretaria</b></td>
	</tr>
</table>";
?>


<h1 class="titulo-principal"><i class="fas fa-cogs"></i> <?php echo $this->titlesection; ?></h1>
<div class="container-fluid">
	<form class="text-start" enctype="multipart/form-data" method="post" action="<?php echo $this->routeform;?>" data-bs-toggle="validator">
		<div class="content-dashboard">
			<input type="hidden" name="csrf" id="csrf" value="<?php echo $this->csrf ?>">
			<input type="hidden" name="csrf_section" id="csrf_section" value="<?php echo $this->csrf_section ?>">
			<?php if ($this->content->acta_id) { ?>
				<input type="hidden" name="id" id="id" value="<?= $this->content->acta_id; ?>" />
			<?php }?>
			<div class="row">
				<div class="col-lg-4 form-group">
					<label for="acta_fecha"  class="control-label">fecha del acta</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-cafe " ><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="date" value="<?= $this->content->acta_fecha; ?>" name="acta_fecha" id="acta_fecha" class="form-control"  required >
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-lg-4 form-group">
					<label for="acta_consecutivo"  class="control-label">consecutivo</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-cafe " ><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->acta_consecutivo; ?>" name="acta_consecutivo" id="acta_consecutivo" class="form-control"  required >
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-lg-4 form-group">
					<label class="control-label">tipo</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-verde " ><i class="far fa-list-alt"></i></span>
						</div>
						<select class="form-select" name="acta_tipo" required  >
							<option value="">Seleccione...</option>
							<?php foreach ($this->list_acta_tipo AS $key => $value ){?>
								<option <?php if($this->getObjectVariable($this->content,"acta_tipo") == $key ){ echo "selected"; }?> value="<?php echo $key; ?>" /> <?= $value; ?></option>
							<?php } ?>
						</select>
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 form-group">
					<label for="acta_asistentes"  class="control-label">asistentes</label>
						<input type="hidden" value="<?= $this->content->acta_asistentes; ?>" name="acta_asistentes" id="acta_asistentes" class="form-control"   >

						<div class="row">
							<?php foreach ($this->list_usuarios as $key => $value): ?>
								<div class="col-4"><label onclick="llenar();"><input type="checkbox" name="asistente<?php echo $key ?>" id="asistente<?php echo $key ?>" value="<?php echo $key; ?>" <?php if($this->content->acta_asistentes==$key or strpos($this->content->acta_asistentes,$key.',')!==false or strpos($this->content->acta_asistentes,','.$key)!==false){ echo 'checked'; } ?> > <?php echo $value; ?></label></div>
							<?php endforeach ?>
						</div>

					<div class="help-block with-errors"></div>
				</div>
				<div class="col-6 form-group">
					<label class="control-label">presidente</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-azul " ><i class="far fa-list-alt"></i></span>
						</div>
						<select class="form-select" name="acta_presidente"   >
							<option value="">Seleccione...</option>
							<?php foreach ($this->list_acta_presidente AS $key => $value ){?>
								<option <?php if($this->getObjectVariable($this->content,"acta_presidente") == $key ){ echo "selected"; }?> value="<?php echo $key; ?>" /> <?= $value; ?></option>
							<?php } ?>
						</select>
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-6 form-group">
					<label class="control-label">secretaria</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-rojo-claro " ><i class="far fa-list-alt"></i></span>
						</div>
						<select class="form-select" name="acta_secretaria"   >
							<option value="">Seleccione...</option>
							<?php foreach ($this->list_acta_secretaria AS $key => $value ){?>
								<option <?php if($this->getObjectVariable($this->content,"acta_secretaria") == $key ){ echo "selected"; }?> value="<?php echo $key; ?>" /> <?= $value; ?></option>
							<?php } ?>
						</select>
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 form-group">
					<label for="acta_cabecera" class="form-label" >cabecera</label>
					<textarea name="acta_cabecera" id="acta_cabecera"   class="form-control tinyeditor" rows="5"   ><?php if($this->content->acta_cabecera!=""){ echo $this->content->acta_cabecera; } else{ echo $cabecera; } ?></textarea>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 form-group">
					<label for="acta_cuerpo" class="form-label" >cuerpo</label>
					<textarea name="acta_cuerpo" id="acta_cuerpo"   class="form-control tinyeditor" rows="15"   ><?php if($this->content->acta_cuerpo!=""){ echo $this->content->acta_cuerpo; } else { echo $cuerpo; } ?></textarea>
					<div class="help-block with-errors"></div>
				</div>
			</div>
		</div>
		<div class="botones-acciones">
			<button class="btn btn-guardar" type="submit">Guardar</button>
			<a href="<?php echo $this->route; ?>" class="btn btn-cancelar">Cancelar</a>
		</div>
	</form>
</div>


<script type="text/javascript">
	function llenar(){
		var i=0;
		var res='';
		for(i=0;i<=50;i++){
			if($("#asistente"+i).prop('checked')===true){
				res+=$("#asistente"+i).val()+",";
			}
		}
		$("#acta_asistentes").val(res);
	}
</script>