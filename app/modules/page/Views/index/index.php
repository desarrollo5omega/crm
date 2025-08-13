
  <div class="login-header">
    <img src="/skins/page/images/logo-horizontal.png">
  </div>
  <div class="login-caja">
    <div class="login-content">
      <form autocomplete="off" action="/page/login/login" method="post" class="recaptcha-form">
        <div class="row">
          <div class="col-12">
            <h2>
              <span>BIENVENIDOS</span>
            </h2>
          </div>
          <div class="form-group mt-4">
            <label class="control-label sr-only">Correo</label>
            <div class="input-group">
              <input type="text" class="form-control login-input" id="correo" name="correo" placeholder="Correo" required>
              <div class="help-block with-errors"></div>
            </div>
          </div>
          <div class="form-group my-4">
            <label class="control-label sr-only">Contraseña</label>
            <div class="input-group">
              <input type="password" class="form-control login-input" id="password" name="password" placeholder="Contraseña" required>
              <div class="help-block with-errors"></div>
            </div>
          </div>
          <?php if ($this->error_login) { ?>
            <div class="error_login"><?php echo $this->error_login; ?></div>
          <?php } ?>
          <div class="col-12 d-flex justify-content-center mb-3 ">
            <div class="g-recaptcha" data-sitekey="6LeYq_kqAAAAANCkRckJLf713qaa0duwxpltrqbC"></div>
          </div>
          <input type="hidden" id="csrf" name="csrf" value="<?php echo $this->csrf; ?>" />
          <div class="text-center"><button class="btn-azul-login" type="submit">Entrar</button></div>
          <div class="text-center mt-2"><a href="/page/index/recordar" class="olvido">¿Olvidaste tu contraseña?</a></div>
        </div>
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

  <script>
      document.querySelector('.recaptcha-form').addEventListener('submit', function(event) {
          event.preventDefault(); // Evita el envío del formulario

          var recaptchaResponse = grecaptcha.getResponse();

          if (recaptchaResponse.length == 0) {
              alert('Por favor, completa el reCAPTCHA');
          } else {
              // Envía el formulario de manera programática
              this.submit();
          }
      });
  </script>
