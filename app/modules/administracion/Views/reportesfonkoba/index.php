<h1 class="titulo-principal"><i class="fas fa-cogs"></i> <?php echo $this->titlesection; ?></h1>
<div class="container-fluid">
  <div class="row">
    <div class="col-12"><br></div>
    <div class="col-12 botones-reportes">
      <?php if ($_SESSION['kt_login_level'] == 1 or $_SESSION['kt_login_level'] == 4 or $_SESSION['kt_login_level'] == 3) { ?>
        <a href="/administracion/reportesfonkoba/solicitudes_estado/" class="btn btn-primary">Solicitudes por estado</a>
        <a href="/administracion/reportesfonkoba/solicitudes_linea/" class="btn btn-primary">Solicitudes por línea</a>
        <a href="/administracion/reportesfonkoba/solicitudes_paso/" class="btn btn-primary">Solicitudes no finalizadas</a>
      <?php } ?>
    </div>
  </div>
</div>