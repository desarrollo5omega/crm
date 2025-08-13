<div class="container">
	<div class="row">
		<div class="col-12">
			<h3 class="titulo">Detalle Pagaré</h3>

			<?php if($this->id!=""){ ?>
			<table border="0" align="center" cellpadding="5" cellspacing="0" class="tabla">
			  <tr>
			    <td><strong>Número solicitud</strong></td>
			    <td><?php echo $this->numero; ?></td>
			  </tr>
			  <tr>
			    <td><strong>Número pagare</strong></td>
			    <td><?php echo $this->solicitud->pagare; ?></td>
			  </tr>
			  <tr>
			    <td><strong>Monto</strong></td>
			    <td>$ <?php echo number_format($this->solicitud->valor_desembolso); ?></td>
			  </tr>
        <?php if($this->solicitud->valor_recogidos){ ?>  
			  <tr>
			    <td><strong>Total saldo recogidos</strong></td>
			    <td>$ <?php echo number_format($this->solicitud->valor_recogidos); ?></td>
			  </tr>
			  <tr>
			    <td><strong>Valor aprobado</strong></td>
			    <td>$ <?php echo number_format($this->solicitud->valor_recogidos + $this->solicitud->valor_desembolso); ?></td>
			  </tr>
        <?php } ?>
			  <tr>
			    <td><strong>Porcentaje intéres</strong></td>
			    <td><?php echo $this->solicitud->tasa_desembolso; ?>% EA</td>
			  </tr>
			  <tr>
			    <td><strong>Modalidad</strong></td>
			    <td><?php echo $this->modalidad; ?></td>
			  </tr>
			  <tr>
			    <td><strong>Documento Asociado</strong></td>
			    <td><?php echo $this->solicitud->cedula; ?></td>
			  </tr>
			  <tr>
			    <td><strong>Nombre Asociado</strong></td>
			    <td><?php echo $this->nombres; ?></td>
			  </tr>
			  <tr>
			    <td><strong>Fecha solicitud</strong></td>
			    <td><?php echo $this->solicitud->fecha_asignado; ?></td>
			  </tr>
			  <tr>
			    <td><strong>Fecha aprobado</strong></td>
			    <td><?php echo $this->solicitud->fecha_aprobado; ?></td>
			  </tr>
			  <tr>
			    <td><strong>Fecha firma pagaré</strong></td>
			    <td><?php echo $this->existe_pagare[0]->fecha_firma_deceval; ?></td>
			  </tr>
			  <tr>
			    <td><strong>Estado Deceval</strong></td>
			    <td><?php echo $this->existe_pagare[0]->estado_deceval; ?></td>
			  </tr>
			</table>
			<?php } ?>


			<div class="col-12 text-center"><br><a href="/administracion/solicitudes/"><button type="button" class="btn btn-primary">Regresar</button></a></div>

		</div>
	</div>
</div>