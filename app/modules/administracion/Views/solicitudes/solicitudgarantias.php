
<form action="/administracion/solicitudes/updategarantia" class="mt-5" method="post">
<input type="hidden" name="id" value="<?php echo $_GET["solicitud"] ?>">
<div id="div_paso5"><?php echo $this->getRoutPHP('modules/page/Views/sistema/paso5.php'); ?>
<div class="container">
	<div class="row">

			<div class="col-12">
				<div class="row form-group">

					<div class="col-md-12 col-lg-12">

						<div class="row  text-center">
							<div class="col-12 titulo-seccion">Garantia adicional</div><br><br>


							  <select name="garantia_adicional" id="garantia_adicional" onchange="seleccion_tipo_garantia2();" class="form-control col-lg-4 offset-lg-4"  >
							  		<option value="">Seleccione</option>
							  		<?php foreach ($this->garantias as $key => $garantia): ?>
							  			<option value="<?php echo $garantia->garantia_id; ?>" <?php if($this->solicitud->garantia_adicional==$garantia->garantia_id){ echo 'selected="selected"'; }  ?>><?php echo utf8_encode($garantia->garantia_nombre); ?></option>
							  		<?php endforeach ?>
							  </select>
							  


						</div>

						<br>
						<div id="div_paso4C"></div>
						<div id="div_paso4B"></div>


					</div>

				</div>
			</div>




	</div>
	




	</div>
</div>
<div class="text-center"><button class="btn btn-primary" type="submit">Guardar</button></div></div>

<div class="modal fade" id="envio" tabindex="-1" role="dialog" aria-labelledby="envioLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
		  <img src="/skins/page/images/logo.png" alt="" width=150px>
        <button type="button" class="close btn-close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center p-4">
        <h6 class="text-muted font-weight-bold"> Se han guardado los cambios correctamente</h6>
      </div>

    </div>
  </div>
</div>

</form>
<script>
	function seleccion_tipo_garantia2(){
    console.log("entro");
	var e = document.getElementById("garantia_adicional");
	var no = e.options[e.selectedIndex].value;
	var linea = $("#linea").val();

	//var valor = sin_puntos(document.getElementById('valor').value);
	if(no=='2'){ //codeudor
    
		$('#div_paso4C').load('/page/sistema/codeudorparcial/?id=<?php echo $_GET['id']; ?>');
		if(linea=="CM" || linea=="CCC" || linea=="CE"){
			$('#div_paso4B').load('/page/sistema/codeudorparcial2/?id=<?php echo $_GET['id']; ?>');
		}
	}
	
	if(no=='4'){ //hipoteca
		$('#div_paso4C').load('/page/sistema/blanco/');
	}
	if(no=='5'){ //prenda
		$('#div_paso4C').load('/page/sistema/blanco/');
	}
	if(no=='1'){ //aportes sociales
		$('#div_paso4C').load('/page/sistema/blanco/');
		//document.getElementById('Enviar').style.display='';
	}
	if(no=='GARANTIA PERSONAL'){
		$('#div_paso4C').load('/page/sistema/requisitospersonal/?id=<?php echo $_GET['id']; ?>');
		//document.getElementById('Enviar').style.display='';
	}
}
function seleccion_tipo_garantia(){
    console.log("entro");
	var e = document.getElementById("tipo_garantia");
	var no = e.options[e.selectedIndex].value;
	var linea = $("#linea").val();

	//var valor = sin_puntos(document.getElementById('valor').value);
	if(no=='2'){ //codeudor
    
		$('#div_paso4').load('/page/sistema/codeudorparcial/?id=<?php echo $_GET['id']; ?>');
		if(linea=="CM" || linea=="CCC" || linea=="CE"){
			$('#div_paso4B').load('/page/sistema/codeudorparcial2/?id=<?php echo $_GET['id']; ?>');
		}
	}
	
	if(no=='4'){ //hipoteca
		$('#div_paso4').load('/page/sistema/blanco/');
	}
	if(no=='5'){ //prenda
		$('#div_paso4').load('/page/sistema/blanco/');
	}
	if(no=='1'){ //aportes sociales
		$('#div_paso4').load('/page/sistema/blanco/');
		//document.getElementById('Enviar').style.display='';
	}
	if(no=='GARANTIA PERSONAL'){
		$('#div_paso4').load('/page/sistema/requisitospersonal/?id=<?php echo $_GET['id']; ?>');
		//document.getElementById('Enviar').style.display='';
	}
}

</script>
<script>
	<?php if($_GET["envio"]==1){?>
  $("#envio").modal("show");
  <?php }?>
</script>