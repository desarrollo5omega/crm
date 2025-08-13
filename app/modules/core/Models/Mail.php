<?php

/**
 * Modelo del modulo Core que se encarga de inicializar  la clase de envio de correos
 */


class Core_Model_Mail
{
  /**
   * classe de  phpmailer
   * @var class
   */
  private $mail;

  /**
   * asigna los valores a la clase e instancia el phpMailer
   */
  public function __construct()
  {
    $this->mail = new PHPMailer;
    $this->mail->CharSet = 'UTF-8';
    $this->mail->isSMTP();
    $this->mail->SMTPDebug = 0;
    $this->mail->SMTPSecure = "ssl";
    $this->mail->Host = "mail.omegasolucionesweb.com";
    $this->mail->Port = 465;
    $this->mail->SMTPAuth = true;
    $this->mail->Username = "notificaciones@omegasolucionesweb.com";
    $this->mail->Password = "Adm.2025*";
    $this->mail->setfrom("notificaciones@omegasolucionesweb.com", "Notificaciones CRM Omega");
    // $this->mail = new PHPMailer;
    // $this->mail->CharSet = 'UTF-8';
    // $this->mail->isSMTP();
    // $this->mail->SMTPDebug = 0;
    // $this->mail->SMTPSecure = "ssl";
    // $this->mail->Host = "smtp.gmail.com";
    // $this->mail->Port = 465;
    // $this->mail->SMTPAuth = true;
    // $this->mail->Username = "creditosfonkoba@gmail.com";
    // $this->mail->Password = "mqahkhoxbsqaqlxi";
    // $this->mail->setfrom("creditosfonkoba@gmail.com", "Notificaciones FONDTODOS");
  }
  /**
   * retorna la  instancia de email
   * @return class email
   */
  public function getMail()
  {
    return $this->mail;
  }

  /**
   * envia el correo
   * @return bool envia el estado del correo
   */
  public function sed()
  {
    /*
		$email = "creyes@omegawebsystems.com";
		$asunto = "envio desde omegasol";
		$content = "prueba de envio";
		$res =file_get_contents("https://omegasolucionesweb.com/page/index/enviarfonkoba/?email=".$email."&asunto=".$asunto."&content=".$content);
		*/

    if ($this->mail->send()) {
      return true;
    } else {
      return false;
    }
  }
}
