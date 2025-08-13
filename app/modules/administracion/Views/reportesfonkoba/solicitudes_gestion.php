<h1 class="titulo-principal"><i class="fas fa-cogs"></i> <?php echo $this->titlesection; ?></h1>
<div class="container-fluid">
	<div class="row">
		<div class="col-12"><br></div>
		<?php echo $this->getRoutPHP('modules/administracion/Views/reportes/filtro.php'); ?>

		<div class="col-md-12 col-lg-6">
			<table width="100%" border="0" cellpadding="5" cellspacing="0" class="tablaGris2 tablesorter" id="myTable">

			  <thead>
			  <tr class="fondo3">
			    <th><div align="left">Categoría</div></th>
			    <th><div align="center">Cantidad</div></th>
			    <th><div align="center">Porcentaje</div></td>
			    <th><div align="center">Monto</div></th>
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
								$valores[$i]= $total = $this->totales[$i]->total*1;
						       	echo $total;
					       	?>
				       	</div>
				    </td>
				    <td>
				      	<div align="right">
				          <?php
							$porcentaje = number_format($total/$this->total_solicitudes*100,1);
							$total_porcentaje+=$porcentaje;
							echo $porcentaje."%";
							?></div>
						</td>
				    <td>
				      	<div align="right">
				        	<?php
								echo formato_pesos($this->totales[$i]->total2);
								$total2+=$this->totales[$i]->total2;
							?>
				      	</div>
				    </td>
			    </tr>
			    <?php }?>
			</tbody>
			  <tr>
			    <td><div align="right"><strong>TOTAL</strong></div></td>
			    <td><div align="center"><strong><?php echo $this->total_solicitudes; ?></strong></div></td>
			    <td><div align="right">
				    <?php
					if($total_porcentaje>100){
						$total_porcentaje=100;
					}
					echo $total_porcentaje; ?>%</div>
				</td>
			    <td><div align="right"><strong><?php echo  formato_pesos($total2);  ?></strong></div></td>
			  </tr>
			</table>
		</div>
		<div class="col-md-12 col-lg-6">



		    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
		    <script type="text/javascript">
		      google.load("visualization", "1", {packages:["corechart"]});
		      google.setOnLoadCallback(drawChart);
		      function drawChart() {

		        var data = google.visualization.arrayToDataTable([
		          ['Task', 'Hours per Day'],

				  <?php for($x=0;$x<$i;$x++){?>
				  <?php if($valores[$x]>0){ ?>
				  [
				  '<?php echo $calificaciones[$x]; ?>',<?php echo $valores[$x]; ?>
				  ],
				  <?php }?>
				  <?php }//for?>

		        ]);

		        var options = {
		          title: '',
		        };

		        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

		        chart.draw(data, options);
		      }
		    </script>

		    <div id="piechart"></div>

		</div>
	</div>
</div>