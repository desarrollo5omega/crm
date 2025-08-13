
  <div class="login-header">
    <img src="/skins/page/images/logo-horizontal.png">
  </div>
  <div class="login-caja">
    <div class="login-content login-content-transparente">
      <div class="text-center text-white">
        Por favor ingrese su dirección de correo electrónico y
        recibirás un enlace para crear una nueva contraseña.
      </div>
      <br>
      <form  autocomplete="off" action="/page/login/forgotpassword2" method="post" >
          <div class="mb-4" >
              <label class="control-label sr-only">Correo</label> 
              <div class="input-group">
                  <i class="fas fa-envelope icon-input-left"></i>
                  <input type="email" class="form-control" id="correo" name="correo" value="<?php echo $_GET['correo']; ?>" placeholder="Correo" required>
                  <div class="help-block with-errors"></div>
              </div>
          </div>
          <?php if ($this->error_olvido): ?>
            <div class="col-12 pb-2">
              <div class="alert alert-danger text-center">
                <?php echo $this->error_olvido; ?>
              </div>
            </div>
          <?php endif ?>
          <?php if ($this->mensaje_olvido): ?>
            <div class="col-12 pb-2">
              <div class="alert alert-success text-center">
                <?php echo $this->mensaje_olvido?><span id="email"><?php echo $this->correo_envio; ?></span>
              </div>
            </div>
          <?php endif ?>
          <div class="text-center mb-2"><button  class="btn-azul-login" type="submit">Enviar</button></div>
          <div class="text-center"><a href="/page/index/" class="olvido">Volver al Login</a></div>
      </form>
    </div>
    <div class="login-image">
      <img src="/skins/page/images/ilustracion-login.png" alt="">
    </div>
  </div>
  <div class="login-derechos">
    &copy; <?php echo date('Y') ?> Todos los derechos reservados | Diseñado por <a href="https://omegasolucionesweb.com" target="_blank" class="text-decoration-none">OMEGA SOLUCIONES WEB</a>
    <br>
    info@omegawebsystems.com - 310 6671747 - 310 668 6780
  </div>