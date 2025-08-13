<?php if($_GET['detalle']=="1"){ ?>
	<style>
	.ocultar_detalle{
		display:none;
	}
	.header-menu{
		display: none;
	}
	#div_menu,.div_menu2{
		display: none;
	}
	.div10{
		max-width: 100%;
		flex: 0 0 100%;
	}

	  .modal-lg, .modal-xl {
	    max-width: 95%;
	  }

	</style>

<?php }?>

<h1 class="titulo-principal"><i class="fas fa-cogs"></i> <?php echo $this->titlesection; ?></h1>
<div class="container-fluid">
	<form class="text-start" enctype="multipart/form-data" method="post" action="<?php echo $this->routeform;?>" data-bs-toggle="validator">
		<div class="content-dashboard">
			
			<input type="hidden" name="reprogramar" id="reprogramar" value="<?php echo $_GET['reprogramar'] ?>">

			<input type="hidden" name="csrf" id="csrf" value="<?php echo $this->csrf ?>">
			<input type="hidden" name="csrf_section" id="csrf_section" value="<?php echo $this->csrf_section ?>">

			<div class="row">
                <div class="col-lg-4 mb-3">
					<label for="client_id"  class="form-label">Cliente</label>
					<div class="input-group">
						<span class="input-group-text input-icono" ><i class="fas fa-pencil-alt"></i></span>
						<select class="form-select" name="client_id" id="client_id" onchange='cambiar_datos();'>
                            <option value="" selected>Seleccione</option>
                            <?php foreach ($this->clientes as $key => $valor) { ?>
                                <option value="<?= $key ?>"><?= $valor ?></option>
                            <?php } ?> 
                        </select>
					</div>
					<div class="help-block with-errors"></div>
				</div>
                <div class="col-lg-4 mb-3">
					<label for="proyectos"  class="form-label">Proyectos</label>
					<div class="input-group">
						<span class="input-group-text input-icono" ><i class="fas fa-pencil-alt"></i></span>
						<select class="form-select" name="proyecto_id" id="proyectos">
                            <option value="" selected>Seleccione</option>
                            <?php foreach ($this->proyectos as $key => $valor) { ?>
                                <option value="<?= $key ?>"><?= $valor ?></option>
                            <?php } ?>
                        </select>
					</div>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-lg-4 mb-3">
					<label for="fecha"  class="form-label">Fecha del seguimiento</label>
					<div class="input-group">
						<span class="input-group-text input-icono  fondo-rosado " ><i class="fas fa-pencil-alt"></i></span>
						<input type="datetime-local" value="<?= $this->content->fecha; ?>" name="fecha" id="fecha" class="form-control datetimepicker-input" data-bs-toggle="datetimepicker" data-bs-target="#fecha" required >
					</div>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-lg-12 mb-3">
					<label for="seguimiento" class="form-label" >Descripci&oacute;n del seguimiento</label>
					<textarea name="seguimiento" id="seguimiento"   class="form-control tinyeditor" rows="10"  required ><?= $this->content->seguimiento; ?></textarea>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-lg-4 mb-3">
					<label for="programar"  class="form-label">Programar nuevo seguimiento</label>
					<div class="input-group">
						<span class="input-group-text input-icono  fondo-verde-claro " ><i class="fas fa-pencil-alt"></i></span>
						<input type="datetime-local" value="<?= $this->content->programar; ?>" name="programar" id="programar" class="form-control datetimepicker-input" data-bs-toggle="datetimepicker" data-bs-target="#programar"  >
					</div>
					<div class="help-block with-errors"></div>
				</div>
				<input type="hidden" name="detalle"  value="<?php echo $_GET['detalle']; ?>">
			</div>
		</div>
		<div class="botones-acciones">
			<button class="btn btn-guardar" type="submit">Guardar</button>
			<a href="<?php echo $this->route; ?>?proyecto=<?php if($this->content->proyecto_id){ echo $this->content->proyecto_id; } else { echo $this->proyecto; } ?>&detalle=<?php echo $_GET['detalle']; ?>" class="btn btn-cancelar">Cancelar</a>
		</div>
	</form>
</div>

<script>
    cambiar_datos()
    function cambiar_datos() {
        var cliente = $("#client_id").val();
        console.log(cliente);
        $.post("/page/seguimientoproyecto/buscarProyectos", {
            "cliente": cliente
        }, function(res) {
            arrayProyectos(res);
        });
    }

    function arrayProyectos(res) {

        $('#proyectos').empty().append('<option value="">Selecione...</option');

        for (let index = 0; index < res.length; index++) {
            if (typeof res !== 'undefined' && res[index]['texto'] !== '') {
                
                const option = $("<option>", {
                    value: res[index]['valor'],
                    text: res[index]['texto']
                });

                $("#proyectos").append(option);
            }
        }
    }
</script>

<script type="text/javascript">
    $(function () {
        $('#programar').datetimepicker({
            format: 'YYYY-MM-DD HH:mm',
           	viewDate: new DateTime()
        });
        $('#fecha').datetimepicker({
            format: 'YYYY-MM-DD HH:mm',
           	viewDate: new DateTime()
        });        

    });
</script>