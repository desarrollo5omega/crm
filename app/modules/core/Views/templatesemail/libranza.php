<div style="padding:40px;text-align:center;background:#333333">
  <div style="display:inline-block;width:700px">
    <table border="0" cellpadding="10" cellspacing="0" width="100%">
      <thead>
        <tr bgcolor="#FFFFFF">
          <td>
            <img src="https://creditosfondtodos.com.co/skins/page/images/logo.png" height="100" tabindex="0">
          </td>
          <td>
            <h2 style="color:#000000"><?php echo $this->data->asunto_correo ?></h2>
          </td>
        </tr>
      </thead>
      <tbody>
        <tr bgcolor="#269cd8">
          <td colspan="2" style="color:#ffffff;text-align:left">
            <div>
              <p>Notificamos que el pagaré de la solicitud WEB00<?php echo $this->data->id ?> para el asociado identificado con <?php echo $this->data->tipo_documento.' '.$this->data->cedula ?> ha sido firmado.</p>
              <p>Adjunto encontrará la libranza de la solicitud en formato PDF y el archivo del pagaré firmado.</p>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>