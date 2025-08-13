<head>
  <meta charset="UTF-8">
</head>

<div class="container">
		<table width="100%" border="1">
			<tr>
				<th>Id</th>
				<th>Cédula</th>
				<th>Asociado</th>
				<th>Monto de la solicitud</th>
				<th>Plazo</th>
				<th>Linea de credito</th>
				<th>Compromete Prima</th>
				<th>Recoge saldos</th>
				<th>Tipo garantia</th>
				<th>Monto aprobado</th>
				<th>Plazo</th>
				<th>Linea de credito</th>
        <th>correo corporativo</th>
        <th>correo personal</th>
        <th>telefono oficina</th>
        <th>celular</th>

				<th>Cuenta Bancaria No</th>
				<th>Tipo de cuenta</th>
				<th>Entidad bancaria</th>

				<th>Observaciones</th>
				<th>Fecha radicado</th>
				<th>Fecha desembolso</th>
				<th>Ente aprobador</th>

	
				
				
			</tr>
			<?php foreach ($this->content as $key => $value): ?>
				<?php //$id =  $value->id; ?>
				<tr>
				<td><?php echo ucwords($value->id); ?></td>
				<td><?php echo ucwords($value->cedula); ?></td>
				    <td><?php echo ucwords($value->nombre_as." ".$value->nombre2_as." ".$value->apellido_as." ".$value->apellido2_as); ?></td>
					<td><?php echo number_format($value->monto_solicitado,0,",","."); ?></td>
					<td><?php echo ($value->cuotas); ?></td>
					<td><?php echo ($value->linea); ?></td>
					<td><?php if($value->valor_extra_desembolso>0){ echo "SI"; }else{echo "NO";} ?></td>
					<td><?php if($value->recoger_credito==1){ echo "SI"; }else{echo "NO";} ?></td>
					<td><?php echo ucwords($value->garantia_nombre); ?></td>
					<td><?php echo number_format($value->valor_desembolso,0,",","."); ?></td>
					<td><?php echo ($value->cuotas_desembolso); ?></td>
					<td><?php echo ucwords($this->linea_desembolso[$value->linea_desembolso]); ?></td>
          <td><?php echo ($value->correo_empresarial); ?></td>
          <td><?php echo ($value->correo_personal); ?></td>
          <td><?php echo ($value->telefono_oficina); ?></td>
          <td><?php echo ($value->celular); ?></td>

          <td><?php echo ($value->cuenta_numero); ?>&nbsp;</td>
          <td><?php echo ($value->cuenta_tipo); ?></td>
          <td><?php echo ($value->entidad_bancaria); ?></td>

					<td>
              <?php echo ucwords(strip_tags($value->observacion_analista)); ?>
          </td>
					<td><?php echo ($value->fecha); ?></td>
					<td><?php echo ($value->fecha_desembolso); ?></td>
					<td><?php echo $value->quien_aprobo; ?></td>
					
				</tr>
			<?php endforeach ?>
		</table>
</div>