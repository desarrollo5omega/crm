
		<table class=" table table-striped  table-hover table-administrator text-start" border="1" width="100%">
			<thead>
				<tr>
				    <td><strong>id</strong></td>
				    <td><strong>usuario</strong></td>
				    <td><strong>nombres</strong></td>
				    <td><strong>correo</strong></td>
				    <td><strong>celular</strong></td>
				    <td><strong>telefono</strong></td>
				    <td><strong>direccion</strong></td>
				    <td><strong>activo</strong></td>
				    <td><strong>ciudad documento</strong></td>
				    <td><strong>salario</strong></td>
				</tr>
			</thead>
			<tbody>
				<?php foreach($this->lists as $content){ ?>
				<?php $id =  $content->user_id; ?>
					<tr>
						<td><?=$content->user_id;?></td>
						<td><?=$content->user_user;?></td>
						<td><?=$content->user_names;?></td>
						<td><?=$content->user_email;?></td>
						<td><?=$content->user_celular;?></td>
						<td><?=$content->user_telefono;?></td>
						<td><?=$content->user_direccion;?></td>
						<td><?=$content->user_state*1;?></td>
						<td><?=$content->user_ciudad_documento;?></td>
						<td><?=$content->user_salario;?></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
