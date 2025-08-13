<h1 class="titulo-principal"><i class="fas fa-cogs"></i> <?php echo $this->titlesection; ?></h1>
<div class="container-fluid">
	<div class="row">
		<div class="col-12"><br></div>
		<div class="col-12">

			<form id="form1" name="form1" method="post" action="">
			  <table border="0" align="left" cellpadding="3" cellspacing="0">
			    <tr>
			      <td>C&eacute;dula</td>
			      <td><label>
			        <input type="text" name="cedula" id="cedula" value="<?php echo $_POST['cedula']; ?>" />
			      </label></td>
			      <td><label>
			        <input type="submit" name="button" id="button" value="Consultar" class="btn btn-primary" />
			      </label></td>
			    </tr>
			  </table>
			</form>
			<br /><br />

			<style>
			.tabla, .tabla td{
				font-size:12px !important;
			}
			.tabla, .tabla th{
				font-size:10px !important;
			}
			</style>
			<table width="100%" border="1" cellpadding="3" cellspacing="0" class="tabla">
			  <tr>
			    <td><div align="left"><strong>ID</strong></div></td>
			    <td><div align="left"><strong>Fecha solicitud</strong></div></td>
			    <td><div align="left"><strong>C&eacute;dula asociado</strong></div></td>
			    <td><div align="left"><strong>nombre asociado</strong></div></td>
			    <td><div align="left"><strong>Cod L&iacute;nea</strong></div></td>
			    <td><div align="left"><strong>L&iacute;nea</strong></div></td>
			    <td><strong>Valor solicitado</strong></td>
			    <td><strong>Valor aprobado</strong></td>
			    <td><strong>Estado DECSIS</strong></td>
			    <td><strong>Obvervaci&oacute;n analista</strong></td>
			    <td><strong>Analista asignado</strong></td>
			  </tr>
				<?php foreach ($this->solicitudes as $key => $solicitud): ?>
				    <tr>
				      <td><div align="left"><?php echo $solicitud->id; ?></div></td>
				      <td><div align="left"><?php echo $solicitud->fecha_asignado; ?></div></td>
				      <td><div align="left"><?php echo $solicitud->cedula; ?></div></td>
				      <td><div align="left"><?php echo $solicitud->nombres." ".$solicitud->apellido1; ?></div></td>
				      <td><div align="left"><?php echo $solicitud->linea_list->codigo; ?></div></td>
				      <td><div align="left"><?php echo $solicitud->linea_list->nombre; ?></div></td>
				      <td><?php echo number_format($solicitud->valor); ?></td>
				      <td><?php if($solicitud->valor_aprobado>0) { echo number_format($solicitud->valor_aprobado); } ?></td>
				      <td><?php $validacion = $solicitud->validacion; echo $this->validaciones[$validacion]; ?>
				      </td>
				      <td><?php echo $solicitud->observacion_analista; ?></td>
				      <td><?php echo $solicitud->analista->user_user; ?></td>
				    </tr>
				<?php endforeach ?>
			</table>
		</div>
	</div>
</div>