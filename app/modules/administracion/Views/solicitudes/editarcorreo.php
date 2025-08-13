
<form action="/administracion/solicitudes/updatecorreos" class="mt-5" method="post">
<input type="hidden" name="id" value="<?php echo $_GET["solicitud"] ?>">
<div class="container">
	<div class="row">

			<div class="col-12">
				<div class="row form-group">

					<div class="col-md-12 col-lg-12">

						<div class="row  text-center">
							<div class="col-12 titulo-seccion"><h2>Editar correos</h2></div><br><br>


                            <div class="form-group col-12 mt-4">
    <label for="exampleInputEmail1">Correo Personal</label>
    <input type="email" name="correo_personal" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="<?php echo $this->solicitud->correo_personal?>">

  </div>
  <div class="form-group col-12">
    <label for="exampleInputEmail1">Correo Empresarial  </label>
    <input type="email" name="correo_empresarial" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="<?php echo $this->solicitud->correo_empresarial?>">

  </div>
		
  <div class="text-center w-100"><button class="btn btn-primary" type="submit">Guardar</button></div></div>	  


						</div>

				


					</div>

				</div>
			</div>




	</div>
	




	</div>
</div>


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
	<?php if($_GET["envio"]==1){?>
  $("#envio").modal("show");
  <?php }?>
</script>