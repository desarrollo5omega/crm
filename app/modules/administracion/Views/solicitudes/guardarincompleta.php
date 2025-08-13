<?php 

if($this->estado == '2'){
  $txt = 'aplazada';
}else if($this->estado == '4'){
  $txt = 'rechazada';
}

?>
<div class="container-fluid">
	<br>
	<p class="text-center">La notificación de solicitud <?php echo $txt ?> fue enviada</p>
	<p class="text-center"><a href="/administracion/solicitudes/"><button type="button" class="btn btn-sm btn-primary">regresar</button></a></p>
</div>