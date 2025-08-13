<div class="container mt-4">
  <div>
    <h2>Solicitud WEB<?= $numero = str_pad($this->id,6,"0",STR_PAD_LEFT); ?></h2>
  </div>
  <?php if(count($this->logestado)>0){?>
    <table border=1 width='100%' cellpadding=8>
      <tr style="background: #CCCCCC;">
        <td>Estado</td>
        <td>Fecha</td>
        <td>Quien</td>
        <td>Observación</td>
      </tr>
      <?php foreach($this->logestado as $key => $value){?>
        <tr>
          <td><?php echo $value->estado?></td>
          <td><?php echo $value->fecha?></td>
          <td>
            <?php 
              if($this->usuarios[$value->usuario]!=""){ 
                echo $this->usuarios[$value->usuario]; 
              }else{
                echo $value->usuario;
              }
              ?>
          </td>
          <td><?php echo $value->observacion?></td>
        </tr>
      <?php }?>
    </table>
  <?php }else{?>
    <table border=1 width='100%' cellpadding=8>
      <tr style="background: #CCCCCC;">
        <td>Estado</td>
        <td>Fecha</td>
        <td>Quien</td>
        <td>Observación</td>
      </tr>
      <?php if($this->solicitud->fecha_asignado){?>
        <tr>
          <td><b>Radicado</b></td>
          <td><?php echo $this->solicitud->fecha_asignado;?></td>
          <td>Asociado</td>
        </tr>
      <?php }?>
      <?php if($this->solicitud->fecha_autorizo){?>
        <tr>
          <td><b><?php echo $this->list_estado_autorizo[$this->solicitud->estado_autorizo];?></b></td>
          <td><?php echo $this->solicitud->fecha_autorizo;?></td>
          <td><?php echo $this->usuarios[$this->solicitud->asignado]; ?></td>
        </tr>
      <?php }?>
      <?php if($this->solicitud->fecha_incompleta){?>
        <tr>
          <td><b>Aplazada (incompleta)</b></td>
          <td><?php echo $this->solicitud->fecha_incompleta;?></td>
          <td><?php echo $this->usuarios[$this->solicitud->asignado]; ?></td>
          <td><?php echo $this->solicitud->incompleta; ?></td>
        </tr>
      <?php }?>
      <?php if($this->solicitud->fecha){?>
        <tr>
          <td><b><?php echo $this->validaciones[$this->solicitud->validacion];?></b></td>
          <?php if($this->solicitud->validacion==2){ ?>
          <td><?php echo $this->solicitud->fecha_desembolso;?></td>
          <?php }else if($this->solicitud->fecha_estado){?>
          <td><?php echo $this->solicitud->fecha_estado?></td>
          <?php }else{?>
          <td><?php echo $this->solicitud->fecha?></td>
          <?php }?>
          <td>
            <?php if($this->solicitud->validacion==2 or $this->solicitud->validacion==8){ ?>
            <?php echo $this->usuarios[$this->solicitud->quien_desembolso]; ?>
            <?php }else{ ?>
            <?php echo $this->usuarios[$this->solicitud->asignado]; ?>
            <?php } ?>
          </td>
        </tr>
      <?php }?>

      <?php if($this->solicitud->fecha_aceptacion){?>
        <tr>
          <td><b><?php echo $this->acepto_condiciones[$this->solicitud->acepto_cambios];?></b></td>
          <td><?php echo $this->solicitud->fecha_aceptacion;?></td>
          <td>Asociado</td>
        </tr>
      <?php }?>

      <?php if(count($this->envios)>0){?>
      <?php foreach ($this->envios as $key => $value): ?>
        <tr>
          <td><b><?php if($key==0){ echo "Envio Pagaré"; }else{ echo "Reenvio Pagaré"; } ?></b></td>
          <td><?php echo $value->envio_fecha;?></td>
          <td><?php echo $this->usuarios[$value->envio_quien]; ?></td>
        </tr>
      <?php endforeach ?>
      <?php }?>
      <?php if($this->existe_pagare->estado=="1"){?>
        <tr>
          <td><b>Pagaré Firmado</b></td>
          <td><?php echo $this->existe_pagare->fecha_firma;?></td>
          <td>Asociado</td>
        </tr>
      <?php }?>
    </table>
  <?php }?>
</div>