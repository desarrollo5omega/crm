<h1 class="titulo-principal"><i class="fas fa-cogs"></i> Plan de Pagos</h1>
<div class="container-fluid">
  <form class="text-start" enctype="multipart/form-data" method="post" action="/administracion/solicitudes/enviarplan" data-bs-toggle="validator">
    <div class="content-dashboard">
      <div class="text-center">
        <span>
          <?php echo $this->message; ?>
        </span>
      </div>
    </div>
  </form>
</div>

<script>
  setTimeout(function() {
    window.location.href = '/administracion/solicitudes';
  }, 5000);
</script>