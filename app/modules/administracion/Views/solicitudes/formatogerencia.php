<div class="container">
	<div class="row">
		<?php if($_GET['excel']==""){ ?>
			<div class="col-12 text-end">
				<br><br>
				<a href="/administracion/solicitudes/formatogerencia/?id=<?php echo $this->id; ?>&excel=1"><button type="button" class="btn btn-primary d-none">Exportar</button></a>
				<a href="/administracion/solicitudes/formatogerencia/?id=<?php echo $this->id; ?>&pdf=1"><button type="button" class="btn btn-primary">Exportar PDF</button></a>
			</div>
		<?php } ?>

		<table width="100%" cellpadding="3" cellspacing="0" border="0">
			<tr>
				<td height="115" colspan="7"><div style="height: 115px;"><img src="http://creditosfondtodos.com.co/skins/page/images/logo.png"></div></td>
			</tr>
			<tr>
				<td colspan="7">
					<?php
						$fecha = $this->comites[0]->comite_fecha;
						$fecha = substr($fecha,0,10);
					?>
					Fecha: <?php echo $fecha ?>
				</td>
			</tr>
		</table>


		<div class="col-12">
			<table width="100%" cellpadding="3" cellspacing="0" border="1">
				<tr style="background: #CCCCCC; color: #000000">
					<th>APROBADOR</th>
					<th colspan="4">APROBO</th>
					<th>OBSERVACIONES</th>
					<th>FECHA</th>
					<th>FIRMA</th>
				</tr>
				<tr style="background: #CCCCCC; color: #000000">
					<th></th>
					<th><div align="center">SI</div></th>
					<th><div align="center">NO</div></th>
					<th><div align="center">APL</div></th>
					<th><div align="center">Cambio Condiciones</div></th>
					<th></th>
					<th></th>
					<th></th>
				</tr>
				<?php foreach ($this->comites as $key => $comite): ?>
					<tr>
						<td><?php echo $comite->user_names; ?></td>
						<td align="center"><?php if($comite->comite_aprobacion=="1"){ echo '<b>X</b>'; } ?></td>
						<td align="center"><?php if($comite->comite_aprobacion=="2"){ echo '<b>X</b>'; } ?></td>
						<td align="center"><?php if($comite->comite_aprobacion=="3"){ echo '<b>X</b>'; } ?></td>
						<td align="center"><?php if($comite->comite_aprobacion=="4"){ echo '<b>X</b>'; } ?></td>
						<td><?php echo $comite->comite_observacion; ?></td>
						<td><?php echo $comite->comite_fecha; ?></td>
						<td><?php echo $comite->firma; ?></td>
					</tr>
				<?php endforeach ?>
				
			</table>
		</div>
	</div>

	<div class="row">
		<div class="col-12"><br></div>
		<div class="col-12">
			<h5>Información Bancaria (Para desembolso)</h5>
			<table width="100%" cellpadding="3" cellspacing="0" border="1" bgcolor="#FFFFFF">
				<tr>
					<td><div align="center"><b>Cuenta Bancaria No</b></div></td>
					<td><div align="center"><b>Tipo de cuenta</b></div></td>
					<td><div align="center"><b>Entidad bancaria</b></div></td>
				</tr>
				<tr>
					<td><div align="center"><?php echo $this->solicitud->cuenta_numero; ?></div></td>
					<td><div align="center"><?php echo $this->solicitud->cuenta_tipo; ?></div></td>
					<td><div align="center"><?php echo $this->solicitud->entidad_bancaria; ?></div></td>
				</tr>
			</table>
		</div>
	</div>

	<div class="row">
		<div class="col-12">
			<br>
			<?php echo $this->tabla; ?>
		</div>
		<div class="col-12">
			<br>
			<div><b>Observación del asociado</b></div>
			<div><?php if($this->solicitud->observaciones!=""){ echo $this->solicitud->observaciones; } else { echo 'Ninguna'; }?></div>
		</div>
		<div class="col-12">
			<div><b>Observación del analista</b></div>
			<div><?php if($this->solicitud->observacion_analista!=""){ echo $this->solicitud->observacion_analista; } else { echo "Ninguna"; } ?></div>
		</div>
	</div>




</div>