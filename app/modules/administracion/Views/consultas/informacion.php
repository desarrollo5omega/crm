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

			<?php if (count($this->solicitudes)>0): ?>
				<embed width='100%' height='400' src='/page/sistema/paso1/?id=<?php echo $this->solicitudes[0]->id; ?>&mod=detalle_solicitud&consulta=1'></embed>
			<?php endif ?>
		</div>
	</div>
</div>