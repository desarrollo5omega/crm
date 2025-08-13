<link rel="stylesheet" href="/skins/page/css/global.css?v=1.04">

<div class="container-fluid">
  <div class="row">
    <div class="col-12"><br></div>
    <div class="col-12">
      <a href="/administracion/solicitudes/detalle/?paso=&id=<?php echo $_GET['id']; ?>&usuario=<?php echo $_GET['usuario']; ?>" class="btn btn-primary">Resumen</a>
      <a href="/administracion/solicitudes/detalle/?paso=1&id=<?php echo $_GET['id']; ?>&usuario=<?php echo $_GET['usuario']; ?>" class="btn btn-primary">Información del asociado</a>
      <!-- <a href="/administracion/solicitudes/detalle/?paso=4&id=<?php echo $_GET['id']; ?>&usuario=<?php echo $_GET['usuario']; ?>" class="btn btn-primary">Referencias</a>  -->
      <a href="/administracion/solicitudes/detalle/?paso=5&id=<?php echo $_GET['id']; ?>&usuario=<?php echo $_GET['usuario']; ?>" class="btn btn-primary">Garantía</a>
      <?php if($this->solicitud->linea == 'EDU' || $this->solicitud->linea == 'CC' || $this->solicitud->linea == 'CCC' || $this->solicitud->linea == 'VEH'){ ?>
        <a href="/administracion/solicitudes/detalle/?paso=carta&id=<?php echo $_GET['id']; ?>&usuario=<?php echo $_GET['usuario']; ?>" class="btn btn-primary">
          Carta de compromiso
        </a>
      <?php } ?>
      <a href="/administracion/solicitudes/libranza?id=<?php echo $_GET['id']; ?>" class="btn btn-primary d-none" target="_blank">Libranza</a>

      <a href="/administracion/solicitudes/detalle/?paso=6&id=<?php echo $_GET['id']; ?>&usuario=<?php echo $_GET['usuario']; ?>" class="btn btn-primary">Documentos</a>

      <!-- <a href="/administracion/solicitudes/detalle/?paso=sarlaft&id=<?php echo $_GET['id']; ?>&usuario=<?php echo $_GET['usuario']; ?>" class="btn btn-primary">Sarlaft</a> -->
      <?php if ($totalRows_rsReferencia > 0) { ?><a href="../pp.php?mod=detalle_solicitud&paso=referenciacion&id=<?php echo $_GET['id']; ?>&usuario=<?php echo $_GET['usuario']; ?>" class="btn btn-primary">Referenciación</a><?php } ?>
      <a class="btn btn-success" href="/administracion/solicitudes/">Regresar</a>
    </div>
  </div>
  <div class="row">
    <div class="col-12" id="pasos1">
      <?php
      $getmod = "detalle_solicitud";
      if ($_GET['paso'] == "") {
        echo "<embed width='100%' height='400' src='/page/sistema/resumen/?id=" . $_GET['id'] . "&mod=detalle_solicitud'></embed>";
      }
      if ($_GET['paso'] == 1) {
      echo "<embed width='100%' height='600' id='embed_paso1' src='/page/sistema/paso1/?id=".$_GET['id']."&mod=detalle_solicitud&monto=1'></embed><br>
		  <div class='text-center mt-4'>
		  <a target='_blank' class='btn btn-primary' href='/administracion/solicitudes/solicitudpdf?id=".$_GET['id']."&bootstrap=1'>Descargar en PDF</a>
		  </div>
		  ";
      }
      if ($_GET['paso'] == 2) {
        echo "<embed width='100%' height='400' src='/page/sistema/paso2/?id=" . $_GET['id'] . "&mod=detalle_solicitud'></embed>";
      }
      if ($_GET['paso'] == 3) {
        echo "<embed width='100%' height='400' src='/page/sistema/paso3/?id=" . $_GET['id'] . "&mod=detalle_solicitud'></embed>";
      }
      if ($_GET['paso'] == "carta") {
        echo "
        <embed width='100%' height='400' src='/page/sistema/cartacompromiso/?id=" . $_GET['id'] . "&mod=detalle_solicitud'>
        </embed>
        <div class='text-center mt-4'>
          <a target='_blank' class='btn btn-primary' href='/administracion/solicitudes/cartapdf?id=".$_GET['id']."'>
            Descargar en PDF
          </a>
        </div>
        ";
        
      }
      
      if ($_GET['paso'] == 4) {
        echo "<embed width='100%' height='400' src='/page/sistema/paso4/?id=" . $_GET['id'] . "&mod=detalle_solicitud'></embed>";
      }
      if ($_GET['paso'] == 5) {
        echo "<embed width='100%' height='200' src='/page/sistema/paso5/?id=" . $_GET['id'] . "&mod=detalle_solicitud'></embed>";
        if ($_GET['prueba'] == "") {
          if ($this->solicitud->tipo_garantia == "2") {
            echo "<h2>CODEUDOR 1</h2>";
            echo "<embed width='100%' height='600' src='/page/codeudor/?id=" . $_GET['id'] . "&mod=detalle_solicitud&n=1'></embed>";
            if ($this->codeudor2->id > 0) {
              echo "<h2>CODEUDOR 2</h2>";
              echo "<embed width='100%' height='600' src='/page/codeudor/?id=" . $_GET['id'] . "&mod=detalle_solicitud&n=2'></embed>";
            }
          }
          if ($this->solicitud->tipo_garantia == "3") {
            echo "<embed width='100%' height='400' src='/page/sistema/fondomutual/?id=" . $_GET['id'] . "&mod=detalle_solicitud'></embed>";
          }
        }
      }
      if ($_GET['paso'] == 6) {
        echo "<embed width='100%' height='400' src='/page/sistema/paso6/?id=" . $_GET['id'] . "&mod=detalle_solicitud'></embed>";
        echo "<div class='container'>";
        echo $this->getRoutPHP('modules/page/Views/comite/documentosadicionales.php');
        echo "</div><br><br><br>";
      }
      if ($_GET['paso'] == 7) {
        echo "<embed width='100%' height='400' src='/page/sistema/paso7/?id=" . $_GET['id'] . "&mod=detalle_solicitud'></embed>";
      }
      if ($_GET['paso'] == "referenciacion") {
        echo "<embed width='100%' height='400' src='/page/sistema/referenciacion/?id=" . $_GET['id'] . "&mod=detalle_solicitud'></embed>";
      }
      if ($_GET['paso'] == "sarlaft") {
        echo "<embed width='100%' height='400' src='/page/sarlaft/?id=" . $_GET['id'] . "&documento=" . $this->solicitud->cedula . "&mod=detalle_solicitud'></embed>";
      }
      ?>
    </div>
  </div>
</div>