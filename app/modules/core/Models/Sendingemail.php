<?php

/**
 * Modelo del modulo Core que se encarga de  enviar todos los correos nesesarios del sistema.
 */
class Core_Model_Sendingemail
{
  /**
   * Intancia de la calse emmail
   * @var class
   */
  protected $email;

  protected $_view;

  public function __construct($view)
  {
    $this->email = new Core_Model_Mail();
    $this->_view = $view;
  }


  public function forgotpassword($user)
  {
    if ($user) {
      $code = [];
      $code['user'] = $user->user_id;
      $code['code'] = $user->code;
      $codeEmail = base64_encode(json_encode($code));
      $this->_view->url = "http://" . $_SERVER['HTTP_HOST'] . "/administracion/index/changepassword?code=" . $codeEmail;
      $this->_view->host = "http://" . $_SERVER['HTTP_HOST'] . "/";
      $this->_view->nombre = $user->user_names . " " . $user->user_lastnames;
      $this->_view->usuario = $user->user_user;
      /*fin parametros de la vista */
      //$this->email->getMail()->setFrom("desarrollo4@omegawebsystems.com","Intranet Coopcafam");
      $this->email->getMail()->addAddress($user->user_email,  $user->user_names . " " . $user->user_lastnames);
      $content = $this->_view->getRoutPHP('/../app/modules/core/Views/templatesemail/forgotpassword.php');
      $this->email->getMail()->Subject = "Recuperación de Contraseña Gestor de Contenidos";
      $this->email->getMail()->msgHTML($content);
      $this->email->getMail()->AltBody = $content;
      if ($this->email->sed() == true) {
        return true;
      } else {
        return false;
      }
    }
  }
  public function forgotpassword2($user, $correo, $cedula, $code)
  {
    if ($user) {
      $code = [];
      $code['user'] = $user->user_id;
      $code['code'] = $user->code;
      $codeEmail = base64_encode(json_encode($code));
      $this->_view->url = "https://" . $_SERVER['HTTP_HOST'] . "/page/index/changepassword?code=" . $codeEmail;
      $this->_view->host = "https://" . $_SERVER['HTTP_HOST'] . "/";
      $this->_view->nombre = $user->user_names . " " . $user->user_lastnames;
      $this->_view->usuario = $user->user_user;
      /*fin parametros de la vista */
      $this->email->getMail()->setFrom("$correo", "Recuperación Contraseña creditos fonkoba");
      $this->email->getMail()->addAddress($user->user_email,  $user->user_names . " " . $user->user_lastnames);
      $this->email->getMail()->addBCC("desarrollo2@omegawebsystems.com", "cambio contraseña");
      $content = $this->_view->getRoutPHP('/../app/modules/core/Views/templatesemail/forgotpassword.php');
      $this->email->getMail()->Subject = "Recuperación de Contraseña";
      $this->email->getMail()->msgHTML($content);
      $this->email->getMail()->AltBody = $content;
      if ($this->email->sed()) {
        return 1;
      } else {
        echo $this->email->getMail()->ErrorInfo;
        return 2;
      }
    }
  }
  public function enviarplan($data, $doc)
  {
    $this->_view->data = $data;
    $this->email->getMail()->addAddress($data->correo_personal, $data->nombres . " " . $data->apellidos);
    $this->email->getMail()->addAddress($data->correo_empresarial, $data->nombres . " " . $data->nombres2 . " " . $data->apellido1 . " " . $data->apellido2);
    $this->email->getMail()->addAddress("", "Plan de Pagos");
    $this->email->getMail()->addBCC("desarrollo2@omegawebsystems.com", "Plan de Pagos");
    // $this->email->getMail()->addBCC("yenny.berdugo@fondtodos.com", "Plan de Pagos");
    // $this->email->getMail()->addBCC("katlyn.martinez@fondtodos.com", "Plan de Pagos");
    $this->email->getMail()->addBCC($data->correo_analista, $data->nombre_analista);
    if ($doc != '') {
      $this->email->getMail()->AddAttachment(FILE_PATH . $doc);
    }
    $content = $this->_view->getRoutPHP('/../app/modules/core/Views/templatesemail/plan.php');
    $this->email->getMail()->Subject = "Plan de pagos";
    $this->email->getMail()->msgHTML($content);
    $this->email->getMail()->AltBody = $content;
    if ($this->email->sed()) {
      return 1;
    } else {
      return 2;
    }
  }
  public function sendmessage($data)
  {
    $this->_view->data = $data;
    $this->email->getMail()->addAddress($data->correo_personal, $data->nombres . " " . $data->apellidos);
    $this->email->getMail()->addAddress($data->correo_empresarial, $data->nombres . " " . $data->nombres2 . " " . $data->apellido1 . " " . $data->apellido2);
    $this->email->getMail()->addBCC("desarrollo2@omegawebsystems.com", "Plan de Pagos");
    // $this->email->getMail()->addBCC("yenny.berdugo@fondtodos.com", "Plan de Pagos");
    // $this->email->getMail()->addBCC("katlyn.martinez@fondtodos.com", "Plan de Pagos");
    $this->email->getMail()->addBCC($data->correo_analista, $data->nombre_analista);
    $content = $this->_view->getRoutPHP('/../app/modules/core/Views/templatesemail/message.php');
    $this->email->getMail()->Subject = $data->asunto_correo;
    $this->email->getMail()->msgHTML($content);
    $this->email->getMail()->AltBody = $content;
    if ($this->email->sed()) {
      return 1;
    } else {
      return 2;
    }
  }
  public function enviarLibranza($solicitud, $correos, $pdflibranza, $pdfpagare)
  {
    $this->_view->data = $solicitud;
    $correos = explode(",", $correos);
    foreach ($correos as $correo) {
      $this->email->getMail()->addAddress($correo, 'Libranza Fondtodos');
    }
    $this->email->getMail()->addBCC("desarrollo2@omegawebsystems.com", "Libranza Fondtodos");
    $content = $this->_view->getRoutPHP('/../app/modules/core/Views/templatesemail/libranza.php');
    $this->email->getMail()->AddAttachment($pdfpagare);
    $this->email->getMail()->AddAttachment($pdflibranza);
    $this->email->getMail()->Subject = 'Libranza Fondtodos solicitud WEB00'.$solicitud->id.' '.$solicitud->cedula.$solicitud->tipo_documento;
    $this->email->getMail()->msgHTML($content);
    $this->email->getMail()->AltBody = $content;
    if ($this->email->sed()) {
      return 1;
    } else {
      return 2;
    }
  }

  public function aprobacion($data_info)
    {
        if ($data_info) {

          $this->_view->fecha_c = $data_info["fecha_c"];
          $this->_view->nombre = $data_info["nombre"];
          $this->_view->tipo = $data_info["tipo"];
          $this->_view->valor = $data_info["valor"];
          $this->_view->cliente_id = $data_info["cliente_id"];
          $this->_view->estado = $data_info["estado"];
          $this->_view->fecha_aprobado = $data_info["fecha_aprobado"];
          $this->_view->nombre_utf8 = $data_info["nombre_utf8"];
          $this->_view->nombre_cliente = $data_info["nombre_cliente"];
          $this->_view->tipo_proyecto = $data_info["tipo_proyecto"];
          $this->_view->agregar_valor = $data_info["agregar_valor"];
          $this->_view->agregar_correo = $data_info["agregar_correo"];
          $this->_view->proyectos_cadmin = $data_info["proyectos_cadmin"];
          $this->_view->proyectos_caprueba = $data_info["proyectos_caprueba"];

          $asunto = "Aprobación de proyecto - " . $data_info["nombre_utf8"];

          /*fin parametros de la vista */
          //$this->email->getMail()->setFrom("desarrollo4@omegawebsystems.com","Intranet Coopcafam");
          $this->email->getMail()->addAddress($data_info["agregar_correo"]);
          $this->email->getMail()->addBCC("desarrollo5@omegawebsystems.com");

          $content = $this->_view->getRoutPHP('/../app/modules/core/Views/templatesemail/aprobacion.php');
          
          $this->email->getMail()->Subject = $asunto;
          $this->email->getMail()->msgHTML($content);
          $this->email->getMail()->AltBody = $content;
          if ($this->email->sed()==true) {
              return true;
          } else {
              return false;
          }

        }

    }

    public function noaprobacion($data_info)
    {
        if ($data_info) {

          $this->_view->fecha_c = $data_info["fecha_c"];
          $this->_view->nombre = $data_info["nombre"];
          $this->_view->tipo = $data_info["tipo"];
          $this->_view->valor = $data_info["valor"];
          $this->_view->cliente_id = $data_info["cliente_id"];
          $this->_view->estado = $data_info["estado"];
          $this->_view->fecha_aprobado = $data_info["fecha_aprobado"];
          $this->_view->nombre_utf8 = $data_info["nombre_utf8"];
          $this->_view->nombre_cliente = $data_info["nombre_cliente"];
          $this->_view->tipo_proyecto = $data_info["tipo_proyecto"];
          $this->_view->agregar_valor = $data_info["agregar_valor"];
          $this->_view->agregar_correo = $data_info["agregar_correo"];

          $asunto = "No aprobación de proyecto - " . $data_info["nombre_utf8"];

          /*fin parametros de la vista */
          //$this->email->getMail()->setFrom("desarrollo4@omegawebsystems.com","Intranet Coopcafam");
          $this->email->getMail()->addAddress($data_info["agregar_correo"]);
          $this->email->getMail()->addBCC("desarrollo5@omegawebsystems.com");

          $content = $this->_view->getRoutPHP('/../app/modules/core/Views/templatesemail/noaprobacion.php');
          
          $this->email->getMail()->Subject = $asunto;
          $this->email->getMail()->msgHTML($content);
          $this->email->getMail()->AltBody = $content;
          if ($this->email->sed()==true) {
              return true;
          } else {
              return false;
          }

        }

    }


    public function notificaAsignacion($data)
    {
        if ($data) {

          $this->_view->user_email = $data->user_email;
          $this->_view->user_user = $data->user_user;
          $this->_view->proyecto = $data->proyecto;

          $asunto = "Asignación de proyecto - " . $data->proyecto;

          /*fin parametros de la vista */
          $this->email->getMail()->addAddress($data->user_email);
          $this->email->getMail()->addBCC("desarrollo5@omegawebsystems.com");

          $content = $this->_view->getRoutPHP('/../app/modules/core/Views/templatesemail/notificaAsignacion.php');
          
          $this->email->getMail()->Subject = $asunto;
          $this->email->getMail()->msgHTML($content);
          $this->email->getMail()->AltBody = $content;
          if ($this->email->sed()==true) {
              return true;
          } else {
              return false;
          }

        }

    }

    public function notificaCotizacion($data)
    {
        // Verificar si hay datos
        if ($data) {
            // Asignación de variables de vista
            $this->_view->fecha_c = $data["fecha_c"];
            $this->_view->nombre = $data["nombre"];
            $this->_view->tipo = $data["tipo"];
            $this->_view->valor = $data["valor"];
            $this->_view->cliente_id = $data["cliente_id"];
            $this->_view->estado = $data["estado"];
            $this->_view->fecha_aprobado = $data["fecha_aprobado"];
            $this->_view->nombre_utf8 = $data["nombre_utf8"];
            $this->_view->nombre_cliente = $data["nombre_cliente"];

            // Preparar asunto del correo
            $asunto = "CRM OMEGA Cotización - " . $data["consecutivo"];
            
            // Añadir destinatario
            $this->email->getMail()->addAddress($data["correo_cliente"]);
            // $this->email->getMail()->addBCC("desarrollo5@omegawebsystems.com");

            // Manejo de documentos adjuntos
            $documents = [$data["documento1"], $data["documento2"], $data["documento3"]];
            foreach ($documents as $doc) {
                if ($doc && file_exists(FILE_PATH . $doc)) {
                    $this->email->getMail()->addAttachment(FILE_PATH . $doc);
                }
            }

            // Obtener contenido del correo
            $content = $this->_view->getRoutPHP('/../app/modules/core/Views/templatesemail/notificaCotizacion.php');
            
            // Configuración del correo
            $this->email->getMail()->Subject = $asunto;
            $this->email->getMail()->msgHTML($content);
            $this->email->getMail()->AltBody = strip_tags($content); // Proporcionar una versión de texto sin formato

            // Envío del correo y manejo de retorno
            return $this->email->sed();
        }

        return false; // Retornar falso si no hay datos
    }
    
    public function notificaSeguimiento($data)
    {
        // Verificar si hay datos
        if ($data) {
            
            $this->_view->id = $data->id;
            $this->_view->fecha = $data->fecha;
            $this->_view->seguimiento = $data->seguimiento;
            $this->_view->programado = $data->programado;
            $this->_view->proyecto = $data->proyecto;
            $this->_view->cliente = $data->cliente;
            $this->_view->finalizado = $data->finalizado;

            // Preparar asunto del correo
            $asunto = "CRM OMEGA Seguimiento vencido ";
            
            // Añadir destinatario
            $this->email->getMail()->addAddress("pvargas@omegawebsystems.com");

            // Obtener contenido del correo
            $content = $this->_view->getRoutPHP('/../app/modules/core/Views/templatesemail/notificaSeguimiento.php');
            
            // Configuración del correo
            $this->email->getMail()->Subject = $asunto;
            $this->email->getMail()->msgHTML($content);
            $this->email->getMail()->AltBody = strip_tags($content); // Proporcionar una versión de texto sin formato

            // Envío del correo y manejo de retorno
            return $this->email->sed();
        }

        return false; // Retornar falso si no hay datos
    }



}
