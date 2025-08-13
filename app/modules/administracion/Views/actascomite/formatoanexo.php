<?php
$tipos = array("","OK APORTES","OK CODEUDOR","OK FONDO MUTUAL","OK HIPOTECA","OK PRENDA");
?>
<div class="container">
	<div class="row">

		<div class="col-12 text-end"><a href="/administracion/actascomite/formatoanexo/?id=<?php echo $this->id; ?>&pdf=1" target="_blank"><button type="button" class="btn btn-primary">Exportar PDF</button></a> <a class="btn btn-success" href="/administracion/actascomite/">Regresar</a></div>

			<table width="100%" cellpadding="3" cellspacing="0" border="0">
				<tr>
					<td height="115" colspan="7"><div style="height: 115px;"><img src="http://fonkobacreditos.omegasolucionesweb.com/corte/logo1.png"></div></td>
				</tr>
				<tr>
					<td colspan="7">
						<div align="center"><b>
						<?php
							if($this->content->acta_tipo=="1"){
								echo "COMITÉ ORDINARIO DE CRÉDITO";
							}
							if($this->content->acta_tipo=="3"){
								echo "COMITÉ ESPECIAL DE CRÉDITO";
							}
							if($this->content->acta_tipo=="2"){
								echo "GERENCIA";
							}
						?><br>
						RELACIÓN DE SOLICITUDES DE CRÉDITO</b>
						</div>
					</td>
				</tr>
			</table>

			<table cellspacing="0" cellpadding="4" border="1" style="font-size: 11px;">

			  <tr height="48" bgcolor="#8EA9DB">
			    <td height="48" width="80">No.</td>
			    <td width="80">No. Radicaci&oacute;n</td>
			    <td width="104">Fecha Radicaci&oacute;n</td>
			    <td width="80">N&uacute;mero Asignado</td>
			    <td width="179">Nombre Asociado</td>
			    <td width="80">N&uacute;mero Documento    de identificaci&oacute;n</td>
			    <td width="80">Empresa</td>
			    <td width="92">Modalidad</td>
			    <td width="80">Cupo M&aacute;ximo</td>
			    <td width="80">Cupo por l&iacute;nea</td>
			    <td width="80">Valor Solicitud    de Cr&eacute;dito ($)</td>
			    <td width="80">Plazo (Meses)</td>
			    <td width="80">Valor Cuota ($)</td>
			    <td width="80">Saldo Cart. a    Recoger Capital ($)</td>
			  </tr>
			  <?php foreach ($this->items as $key => $item): ?>
			  		<?php $solicitud = $item->solicitud; ?>
				  <tr height="20">
				    <td height="20"><?php echo $key+1; ?></td>
				    <td><?php echo $solicitud->id; ?></td>
				    <td><?php echo $solicitud->fecha_asignado; ?></td>
				    <td><?php echo $solicitud->id; ?></td>
				    <td><?php echo $solicitud->nombres; ?> <?php echo $solicitud->nombres2; ?> <?php echo $solicitud->apellido1; ?> <?php echo $solicitud->apellido2; ?></td>
				    <td><?php echo $solicitud->cedula; ?></td>
				    <td><?php echo $solicitud->empresa; ?></td>
				    <td><?php echo $this->list_linea_desembolso[$solicitud->linea_desembolso]; ?></td>
				    <td>$<?php echo number_format($solicitud->cupo_maximo); ?></td>
				    <td>$<?php echo number_format($solicitud->cupo_linea); ?></td>
				    <td>$<?php echo number_format($solicitud->valor); $totales['valor']+=$solicitud->valor; ?></td>
				    <td><?php echo ($solicitud->cuotas); ?></td>
				    <td>$<?php echo number_format($solicitud->valor_cuota); ?></td>
				    <td>$<?php echo number_format($solicitud->valor_recogidos); ?></td>
				  </tr>
			  <?php endforeach ?>
			  <tr height="20" bgcolor="#8EA9DB">
			    <td height="20">&nbsp;</td>
			    <td width="80">&nbsp;</td>
			    <td width="104">&nbsp;</td>
			    <td width="80">&nbsp;</td>
			    <td width="179">&nbsp;</td>
			    <td width="80">&nbsp;</td>
			    <td>&nbsp;</td>
			    <td>&nbsp;</td>
			    <td width="80">&nbsp;</td>
			    <td width="80">&nbsp;</td>
			    <td width="80">$<?php echo number_format($totales['valor']); ?></td>
			    <td width="80">&nbsp;</td>
			    <td width="80">&nbsp;</td>

			    <td width="80">&nbsp;</td>
			  </tr>
			</table>

			<div class="col-12"><br></div>

			<table cellspacing="0" cellpadding="4" border="1" style="font-size: 11px;">

			  <tr height="48" bgcolor="#8EA9DB">
			    <td height="48" width="80">Salario    Mensual ($)</td>
			    <td width="80">Tipo Salario</td>
			    <td width="104">Nivel de    endeudamiento (Con Cuota Sol. Cr&eacute;d.)</td>
			    <td width="80">Tipo Contrato</td>
			    <td width="80">Neto Desembolso    ($)</td>
			    <td width="80">Deudores    Solidarios&nbsp;</td>
			    <td width="92">N&uacute;mero Asignado</td>
			    <td width="80">N&uacute;mero Documento    de identificaci&oacute;n</td>
			    <td width="80">Empresa</td>
			    <td width="80">Salario Mensual ($)</td>
			    <td width="80">Tipo Salario</td>
			    <td width="80">Nivel de    endeudamiento (Con Cuota Sol. Cr&eacute;d.)</td>
			    <td width="80">Tipo Contrato</td>
			    <td colspan="2" width="160">Observaciones</td>
			  </tr>
			  	<?php foreach ($this->items as $key => $item): ?>
				  <?php $solicitud = $item->solicitud;
				  	$salario = $solicitud->salario;
				  ?>
				  <tr height="20">
				    <td height="20"><?php echo $salario; ?></td>
				    <td><?php echo $solicitud->tipo_salario; ?></td>
				    <td><?php echo $solicitud->capacidad_endeudamiento; ?></td>
				    <td><?php echo $solicitud->situacion_laboral; ?></td>
				    <td><?php echo number_format($solicitud->valor_fm); ?></td>
				    <td><?php echo number_format($solicitud->valor_desembolso); ?></td>
				    <td>
				    	<div><?php echo $solicitud->nombres_codeudor; ?></div>
				    </td>
				    <td><?php echo $solicitud->numero_asignado; ?></td>
				    <td><?php echo $solicitud->datos_codeudor->cedula; ?></td>
				    <td><?php echo $solicitud->datos_codeudor->empresa; ?></td>
				    <td><?php echo $solicitud->datos_codeudor->salario; ?></td>
				    <td><?php echo $solicitud->datos_codeudor->tipo_salario; ?></td>
				    <td><?php echo $solicitud->datos_codeudor->nivel_endeudamiento; ?></td>
				    <td><?php echo $solicitud->datos_codeudor->situacion_laboral; ?></td>
				    <td colspan="2"><?php echo $tipos[$solicitud->tipo_garantia]; ?></td>
				  </tr>
					<?php if($solicitud->datos_codeudor2->cedula!=""){ ?>
					  <tr height="20">
				    	<td height="20"><?php echo $salario; ?></td>
				    	<td><?php echo $solicitud->tipo_salario; ?></td>
					    <td><?php echo $solicitud->capacidad_endeudamiento; ?></td>
					    <td>&nbsp;</td>
					    <td><?php echo number_format($solicitud->valor_fm); ?></td>
					    <td><?php echo number_format($solicitud->valor_desembolso); ?></td>
					    <td>
					    	<div><?php echo $solicitud->nombres_codeudor2; ?></div>
					    </td>
					    <td><?php echo $solicitud->numero_asignado; ?></td>
					    <td><?php echo $solicitud->datos_codeudor2->cedula; ?></td>
					    <td><?php echo $solicitud->datos_codeudor2->empresa; ?></td>
					    <td><?php echo $solicitud->datos_codeudor2->salario; ?></td>
					    <td><?php echo $solicitud->datos_codeudor2->tipo_salario; ?></td>
					    <td><?php echo $solicitud->datos_codeudor2->nivel_endeudamiento; ?></td>
					    <td><?php echo $solicitud->datos_codeudor2->situacion_laboral; ?></td>
					    <td colspan="2"><?php echo $tipos[$solicitud->tipo_garantia]; ?></td>
					  </tr>
					<?php } ?>
				<?php endforeach ?>
			  <tr height="20" bgcolor="#8EA9DB">
			    <td height="20">&nbsp;</td>
			    <td>&nbsp;</td>
			    <td>&nbsp;</td>
			    <td>&nbsp;</td>
			    <td>&nbsp;</td>
			    <td>&nbsp;</td>
			    <td>&nbsp;</td>
			    <td>&nbsp;</td>
			    <td>&nbsp;</td>
			    <td>&nbsp;</td>
			    <td>&nbsp;</td>
			    <td>&nbsp;</td>
			    <td>&nbsp;</td>
			    <td>&nbsp;</td>
			    <td colspan="2" width="160">&nbsp;</td>
			  </tr>
			</table>

			<div class="col-12"><br></div>

	</div>
</div>