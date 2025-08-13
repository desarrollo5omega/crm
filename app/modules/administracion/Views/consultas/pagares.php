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
			    <td><strong>Fecha solicitud</strong></td>
			    <td><strong>N&uacute;mero obligaci&oacute;n</strong></td>
			    <td><div align="left"><strong>N&uacute;mero Pagare</strong></div></td>
			    <td><div align="left"><strong>ID Deceval</strong></div></td>
			    <td><div align="left"><strong>Fecha firma</strong></div></td>
			    <td><div align="left"><strong>c&eacute;dula asociado</strong></div></td>
			    <td><div align="left"><strong>nombre asociado</strong></div></td>
			    <td><div align="left"><strong>empresa</strong></div></td>
			    <td><div align="left"><strong>cod modalidad</strong></div></td>
			    <td><div align="left"><strong>modalidad</strong></div></td>
			    <td><div align="left"><strong>codeudor1</strong></div></td>
			    <td><div align="left"><strong>codeudor2</strong></div></td>
			  </tr>

			  <?php foreach ($this->pagares as $key => $pagare): ?>

			    <tr>
			      <td><?php echo $pagare->fecha_solicitud; ?></td>
			      <td><?php echo $pagare->a_obliga; ?></td>
			      <td><div align="left"><?php echo $pagare->pagare; ?></div></td>
			      <td><div align="left"><?php echo $pagare->pagare_deceval; ?></div></td>
			      <td><div align="left"><?php echo $pagare->fecha_firma; ?></div></td>
			      <td><div align="left"><?php echo $pagare->cedula; ?></div></td>
			      <td><div align="left"><?php echo $pagare->nombre; ?></div></td>
			      <td><div align="left"><?php echo $pagare->empresa; ?></div></td>
			      <td><div align="left"><?php echo $pagare->cod_modalidad; ?></div></td>
			      <td><div align="left"><?php echo $pagare->modalidad; ?></div></td>
			      <td><div align="left"><?php echo $pagare->codeudor1." ".$pagare->nombre_codeudor1; ?></div></td>
			      <td><div align="left"><?php echo $pagare->codeudor2." ".$pagare->nombre_codeudor2; ?></div></td>
			    </tr>
			    <?php endforeach ?>
			</table>
		</div>
	</div>
</div>