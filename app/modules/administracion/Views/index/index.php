<!-- <form  autocomplete="off" action="/administracion/loginuser" method="post" >
    <div class="form-group " >
        <label class="control-label sr-only">Usuario</label>
        <div class="input-group">
            <i class="fas fa-user-tie icon-input-left"></i>
            <input type="text" class="form-control" id="user" name="user" placeholder="Usuario" required>
            <div class="help-block with-errors"></div>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label sr-only">Contraseña</label>
        <div class="input-group">
            <i class="fas fa-shield-alt icon-input-left"></i>
            <input type="password" class="form-control " id="password" name="password" placeholder="Contraseña" required>
            <div class="help-block with-errors"></div>
        </div>
    </div>
    <?php if($this->error_login){ ?>
        <div class="error_login"><?php echo $this->error_login; ?></div>
    <?php } ?>
    <input type="hidden" id="csrf" name="csrf" value="<?php echo $this->csrf; ?>" />
    <?php if($_GET["url"]!=""){ ?>
    <input type="hidden" name="url" value="<?php echo $_GET["url"]?>">
    <input type="hidden" name="id" value="<?php echo $_GET["id"]?>">
    <input type="hidden" name="e" value="<?php echo $_GET["e"]?>">
    <?php } ?>
    <div class="text-center"><a href="/administracion/index/olvido" class="olvido">¿Haz olvidado tu contraseña?</a></div>
    <div class="text-center"><button  class="btn-azul-login" type="submit">Entrar</button></div>
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
        <form method="post" action="/administracion/loginuser" class="col-md-12 no_pad_cel borde_login">
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
                      <input type="text" name="user" required class="form-control texto_normal campo_login" value="<?php echo $_GET['cedula']; ?>" placeholder="Usuario">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-12 col-md-12 px-4">
                <div class="row">
                  <div class="col-md-12 no-padding text-start">
                    <label for="cedula">Contraseña</label>
                    <div class="input-container">
                      <img src="/skins/page/images/password.png" alt="">
                      <input type="password" name="password" required class="form-control texto_normal campo_login" value="" placeholder="Contraseña">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-12 text-center">
                <br>
                <a href="/administracion/index/olvido" class="enlace blanco">¿Olvidaste tu contraseña?</a>
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
          <?php if ($this->error_login): ?>
            <div class="col-12 pb-2">
              <div class="alert alert-danger text-center">
                <?php echo $this->error_login; ?> 
              </div>
            </div>
          <?php endif ?>
          <input type="hidden" id="csrf" name="csrf" value="<?php echo $this->csrf; ?>" />
          <?php if($_GET["url"]!=""){ ?>
          <input type="hidden" name="url" value="<?php echo $_GET["url"]?>">
          <input type="hidden" name="id" value="<?php echo $_GET["id"]?>">
          <input type="hidden" name="e" value="<?php echo $_GET["e"]?>">
          <?php } ?>
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