<!-- <div class="text-center">
	Por favor ingrese su dirección de correo electrónico y
	recibirás un enlace para crear una nueva contraseña.
</div>
<br>
<form  autocomplete="off" action="/administracion/loginuser/forgotpassword" method="post" >
    <div class="form-group " >
        <label class="control-label sr-only">Correo</label>
        <div class="input-group">
            <i class="fas fa-envelope icon-input-left"></i>
            <input type="email" class="form-control" id="email" name="email" placeholder="Correo" required>
            <div class="help-block with-errors"></div>
        </div>
    </div>
    <?php if($this->error_olvido){ ?>
        <div class="error_login"><?php echo $this->error_olvido; ?></div>
    <?php } ?>
    <?php if($this->mensaje_olvido){ ?>
        <div class="mensaje_login"><?php echo $this->mensaje_olvido; ?></div>
    <?php } ?>
    <input type="hidden" id="csrf" name="csrf" value="<?php echo $this->csrf; ?>" />
    <div class="text-center"><a href="/administracion" class="olvido">Volver al Login</a></div>
    <div class="text-center"><button  class="btn-azul-login" type="submit">Enviar</button></div>
</form> -->

<style type="text/css">
.logo2 {
  margin-top: -10px;
}
body{
  max-height: 100vh;
  overflow: hidden;
}
.separador_gris{
  display: none;
}
header{
  display: none;
}
</style>
<?php //echo password_hash("admin.2008", PASSWORD_DEFAULT);?>
<div class="fondo_negro">
</div>

<img src="/skins/page/images/imagen-fondo.png" class="fondo1">
<div class="container-fluid no-padding login-container d-flex align-items-center">
  <div class="container text-center zindexlogin">
    <div class="row align-items-center ">
      <div class="col-md-8">
        <div class="row">
          <div class="col-12">
            <div class="row title-container">
              <img src="/skins/page/images/credit.png" alt="">
              <span>
                Sistema de 
                <br>
                <strong>
                  Solicitud 
                  <br>
                  de Crédito
                </strong>
              </span>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4 px-0">
        <form method="post" action="/administracion/loginuser/forgotpassword" class="col-md-12 no_pad_cel borde_login">
          <div align="center" class="caja_login col-md-12 no_pad_cel">
            <div class="titulo_login_azul blanco col-md-12 mt-4">
              <img src="/skins/page/images/logo.png" alt="" class="logo">
            </div>
            <div align="center">
              <br>
              <span>
                Ingresa a tu cuenta
              </span>
            </div>
            <div class="col-sm-12 col-md-12 form-group">
              <div class="col-sm-12 col-md-12 px-4">
                <div class="row">
                  <div class="col-md-12 no-padding text-start">
                    <label for="cedula">Usuario</label>
                    <div class="input-container">
                      <img src="/skins/page/images/user.png" alt="">
                      <input type="email" class="form-control" id="email" name="email" placeholder="Correo" required>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-12 text-center">
                <br>
                <a href="/administracion/" class="enlace blanco">Volver al login</a>
              </div>
              <div class="col-md-12">
                <br>
                <button class="btn btn-azul" type="submit">
                  Ingresar
                </button>
                <br><br>
              </div>
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
                <?php echo $this->mensaje_olvido; ?> 
              </div>
            </div>
          <?php endif ?>
          <input type="hidden" id="csrf" name="csrf" value="<?php echo $this->csrf; ?>" />
        </form>
      </div>
    </div>
  </div>
  <div class="redes">
    <div class="row">
      <?php if($this->infopage->info_pagina_instagram){ ?>
        <a target="_blank" href="<?php echo $this->infopage->info_pagina_instagram ?>">
          <img src="/skins/page/images/instagram.png" alt="">
        </a>
      <?php } ?>
      <?php if($this->infopage->info_pagina_facebook){ ?>
        <a target="_blank" href="<?php echo $this->infopage->info_pagina_facebook ?>">
          <img src="/skins/page/images/facebook.png" alt="">
        </a>
      <?php } ?>
      <?php if($this->infopage->info_pagina_twitter){ ?>
        <a target="_blank" href="<?php echo $this->infopage->info_pagina_twitter ?>">
          <img src="/skins/page/images/twitter.png" alt="">
        </a>
      <?php } ?>
    </div>
  </div>
</div>
<div class="login-derechos1">
  Fondtodos &copy;<?php echo date('Y') ?> Todos los derechos reservados | Desarrollado por Omega Soluciones Web
</div>