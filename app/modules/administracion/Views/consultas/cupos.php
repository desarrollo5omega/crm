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
			<table border="1" width="100%" class="tabla">
			  <tr>
			    <th><div align="left">c&eacute;dula</div></th>
			    <th><div align="left">nombre</div></th>
			    <th><div align="left">cod l&iacute;nea</div></th>
			    <th><div align="left">l&iacute;nea</div></th>
			    <th><div align="left">cupo</div></th>
			    <th><div align="left">saldo actual</div></th>
			    <th><div align="left">saldo disponible</div></th>
			  </tr>

				<?php foreach ($this->cupos as $key => $cupo): ?>
				    <tr>
				      <td><div align="left"><?php echo $cupo->cedula; ?></div></td>
				      <td><div align="left"><?php echo $cupo->usuario->nombres." ".$cupo->usuario->apellidos; ?></div></td>
				      <td><div align="left"><?php echo $cupo->linea; ?></div></td>
				      <td><div align="left"><?php echo $cupo->linea_list->nombre; ?></div></td>
				      <td><div align="left"><?php echo number_format($cupo_actual); ?></div></td>
				      <td><div align="left"><?php echo number_format($cupo->saldo_actual); ?></div></td>
				      <td><?php echo number_format($cupo_actual - $cupo->saldo_actual); ?></td>
				    </tr>
				<?php endforeach ?>
			</table>
		</div>
	</div>
</div>