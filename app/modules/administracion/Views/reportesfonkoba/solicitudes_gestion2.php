<h1 class="titulo-principal"><i class="fas fa-cogs"></i> <?php echo $this->titlesection; ?></h1>
<div class="container-fluid">
	<div class="row">
		<div class="col-12"><br></div>
		<?php echo $this->getRoutPHP('modules/administracion/Views/reportes/filtro.php'); ?>

		<div class="col-md-12 col-lg-12">
			<table width="100%" border="0" cellpadding="5" cellspacing="0" class="tablaGris2 tablesorter" id="myTable">

			  <thead>
			  <tr class="fondo3">
			    <th><div align="left">Categoría</div></th>
			    <th><div align="center">Cantidad</div></th>
			    <?php foreach ($this->analistas as $key => $value): ?>
			    	<th><div align="center"><?php echo $value->user_user; ?></div></td>
			    <?php endforeach ?>
			    </tr>
			  </thead>
			  <tbody>
			  <?php for($i=0;$i<count($this->validaciones);$i++){ ?>
			  	<?php $titulo = $this->validaciones[$i]; ?>
			    <tr>
			    	<td><?php echo $titulo; ?></td>
				    <td>
				    	<div align="center">
							<?php
								$calificaciones[$i]=$titulo;
								$valores[$i]= $total = $this->totales[$i]*1;
						       	echo $total;
					       	?>
				       	</div>
				    </td>
				    <?php foreach ($this->analistas as $key => $value): ?>
					    <td>
					      	<div align="right">
					      		<?php
					      			$analista = $value->user_id;
					      			$total2 = $this->totales2[$analista][$i]*1;
					      			echo $total2;
					      			$TOTAL2 += $total2;
					      		?>
					      	</div>
					    </td>
				    <?php endforeach ?>
			    </tr>
			    <?php }?>
			</tbody>
			  <tr>
			    <td><div align="right"><strong>TOTAL</strong></div></td>
			    <td><div align="center"><strong><?php echo $this->total_solicitudes; ?></strong></div></td>
			    <td><div align="right"><strong><?php echo $TOTAL2;  ?></strong></div></td>
			  </tr>
			</table>
		</div>

	</div>
</div>