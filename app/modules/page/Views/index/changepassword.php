    <div class="login-header">
        <img src="/skins/page/images/logo-horizontal.png">
    </div>
    <div class="login-caja">
        <div class="login-content login-content-transparente">
            <?php if ($this->error != '') {?>
                <div class="text-center error_login">
                    <?= $this->error;?>
                </div>
                <br>
                <div class="text-center"><a href="/page/index/" class="olvido">Volver al Login</a></div>
            <?php } else { ?>
                <?php if ($this->message != '') { ?>
                    <div class="text-center mensaje_login">
                        <?php echo $this->message; ?>
                    </div>
                    <br>
                    <div class="text-center"><a href="/page/index/" class="olvido">Volver al Login</a></div>
                <?php } else { ?>
                    <div class="box_password">
                        <form data-bs-toggle="validator" role="form" method="post" action="/page/index/changepassword" id="passwordForm">
                            <input type="hidden" name="code" value="<?php echo $this->code; ?>" />
                            <div class="mb-3">
                                <label class="control-label sr-only">Contraseña:</label>
                                <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Contraseña" required />
                                <div class="help-block with-errors alert alert-danger mt-3 d-none text-center" id="passwordError"></div>
                            </div>
                            <div class="mb-3">
                                <label class="control-label sr-only">Repita Contraseña:</label>
                                <input type="password" name="re_password" id="inputRePassword" class="form-control" data-match="#inputPassword" data-match-error="Las dos Contraseñas no son iguales" placeholder="Repita Contraseña" required />
                                <div class="help-block with-errors alert alert-danger mt-3 d-none text-center" id="rePasswordError"></div>
                            </div>
                            <div class="text-center">
                                <button class="btn-azul-login" type="submit" id="submitBtn" disabled>Cambiar Contraseña</button>
                            </div>
                        </form>
                    </div>
                <?php } ?>
            <?php } ?>
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
$(document).ready(function() {
    function validatePassword() {
        const password = $('#inputPassword').val();
        const rePassword = $('#inputRePassword').val();
        const passwordError = $('#passwordError');
        const rePasswordError = $('#rePasswordError');
        const submitBtn = $('#submitBtn');

        // Regex to check for at least 8 characters, one number, and one uppercase letter
        const passwordPattern = /^(?=.*[A-Z])(?=.*\d).{8,}$/;

        let isValid = true;

        if (!passwordPattern.test(password)) {
            passwordError.removeClass('d-none');
            passwordError.text('La contraseña debe tener al menos 8 caracteres, un número y una letra mayúscula.');
            isValid = false;
        } else {
            passwordError.addClass('d-none');
            passwordError.text('');
        }

        if (password !== rePassword) {
            rePasswordError.removeClass('d-none');
            rePasswordError.text('Las dos contraseñas no son iguales.');
            isValid = false;
        } else {
            rePasswordError.addClass('d-none');
            rePasswordError.text('');
        }

        submitBtn.prop('disabled', !isValid);
    }

    $('#inputPassword, #inputRePassword').on('input', validatePassword);
});
</script>