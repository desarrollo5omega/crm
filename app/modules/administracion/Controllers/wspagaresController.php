<?php

/**
 * Controlador de Pagares que permite la  creacion, edicion  y eliminacion de los pagares del Sistema
 */
class Administracion_wspagaresController extends Administracion_mainController
{
  /**
   * $mainModel  instancia del modelo de  base de datos pagares
   * @var modeloContenidos
   */
  public $mainModel;

  /**
   * $route  url del controlador base
   * @var string
   */
  protected $route;

  /**
   * $pages cantidad de registros a mostrar por pagina]
   * @var integer
   */
  protected $pages;

  /**
   * $namefilter nombre de la variable a la fual se le van a guardar los filtros
   * @var string
   */
  protected $namefilter;

  /**
   * $_csrf_section  nombre de la variable general csrf  que se va a almacenar en la session
   * @var string
   */
  protected $_csrf_section = "administracion_pagares";

  /**
   * $namepages nombre de la pvariable en la cual se va a guardar  el numero de seccion en la paginacion del controlador
   * @var string
   */
  protected $namepages;



  /**
   * Inicializa las variables principales del controlador pagares .
   *
   * @return void.
   */
  public function init()
  {
    $this->mainModel = new Administracion_Model_DbTable_Pagares();
    $this->namefilter = "parametersfilterpagares";
    $this->route = "/administracion/wspagares";
    $this->namepages = "pages_wspagares";
    $this->namepageactual = "page_actual_wspagares";
    $this->_view->route = $this->route;
    if (Session::getInstance()->get($this->namepages)) {
      $this->pages = Session::getInstance()->get($this->namepages);
    } else {
      $this->pages = 20;
    }
    parent::init();
  }


  public function creargiradorAction()
  {
    $this->setLayout('blanco');
    $id = $this->_getSanitizedParam("id");
    $solicitudesModel = new Administracion_Model_DbTable_Solicitudes();
    $solicitud = $solicitudesModel->getById($id);
    $cedula = $solicitud->cedula;
    if ($solicitud->tipo_garantia == 2) {
      $codeudorModel = new Administracion_Model_DbTable_Codeudor();
      $codeudor1_list = $codeudorModel->getList("solicitud='$id' AND codeudor_numero='1' ", "")[0];
      $codeudor2_list = $codeudorModel->getList("solicitud='$id' AND codeudor_numero='2' ", "")[0];

      $codeudor1 = $codeudor1_list->cedula;
      $codeudor2 = $codeudor2_list->cedula;
    }

    $local_cert = "certificado.pem";
    //$wsdl = "https://pruebas.deceval.com.co:446/weblogic/sdl12/services/SDLService?WSDL";
    $wsdl = "http://localhost:8086/SDLProxy/services/ProxyServicesImplPort?wsdl";

    $client = new soapClient(
      $wsdl,
      array(
        "trace"         => 1,
        "exceptions"    => true,
        "local_cert"    => $local_cert,
        "uri"           => "urn:xmethods-delayed-quotes",
        "style"         => SOAP_RPC,
        "use"           => SOAP_ENCODED,
        "soap_version"  => SOAP_1_2
      )
    );

    $fecha = date("Y-m-d");
    $hora = date("H:i:s");
    $hora2 = date("H:i");
    if ($solicitud->correo_empresarial) {
      $email = $solicitud->correo_empresarial;
    } else {
      $email = $solicitud->correo_personal;
    }
    $direccion = $solicitud->nomenclatura2 . " " . $solicitud->direccion_residencia;
    $fecha_nacimiento = $solicitud->fecha_nacimiento . 'T00:00:00';
    $fecha_exp = $solicitud->fecha_documento . 'T00:00:00';

    $clase_persona = 1; //NATURAL
    $tipo_documento = 1; //CC
    if ($solicitud->tipo_documento == "CC") {
      $tipo_documento = 1;
    }
    if ($solicitud->tipo_documento == "CE") {
      $tipo_documento = 2;
    }
    $nombres1 = trim($solicitud->nombres);
    $nombres2 = trim($solicitud->nombres2);
    $nombres = trim($nombres1 . " " . $nombres2);
    $apellido1 = trim($solicitud->apellido1);
    $apellido2 = trim($solicitud->apellido2);

    $nombres1 = html_entity_decode($nombres1);
    $nombres2 = html_entity_decode($nombres2);
    $nombres = html_entity_decode($nombres);
    $apellido1 = html_entity_decode($apellido1);
    $apellido2 = html_entity_decode($apellido2);


    $celular = $solicitud->celular;
    $documento = $solicitud->documento;
    $telefono = $solicitud->telefono;
    $emisor = '9012814837'; // nit

    $telefono = str_replace(" ", "", $telefono);
    $celular = str_replace(" ", "", $celular);
    if ($telefono == "") {
      $telefono = $celular;
    }

    $ciudad = $solicitud->ciudad_residencia;
    $ciudad = str_pad($ciudad, 5, "0", STR_PAD_LEFT);
    $departamento = substr($ciudad, 0, 2);
    $pais = 'CO';

    $ciudad_documento = $solicitud->ciudad_documento;
    $ciudad_documento = str_pad($ciudad_documento, 5, "0", STR_PAD_LEFT);
    $departamento_documento = substr($ciudad_documento, 0, 2);
    $pais_documento = 'CO';

    //pruebas
    $usuario = '90128148371';
    $codigo_depositante = '640';
    //produccion
    //$usuario = '80004306941';
    //$codigo_depositante = '1046';


    $xml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://services.proxy.deceval.com/">
		   <soapenv:Header/>
		   <soapenv:Body>
		      <ser:creacionGiradoresCodificados>
		         <!--Optional:-->
		         <arg0>
		            <!--Zero or more repetitions:-->
		            <crearGiradorDTO>
		               <correoElectronico>' . $email . '</correoElectronico>
		               <direccion1PersonaGrupo_PGP>' . $direccion . '</direccion1PersonaGrupo_PGP>
		               <fechaExpedicion_Nat>' . $fecha_exp . '</fechaExpedicion_Nat>
		               <fechaNacimiento_Nat>' . $fecha_nacimiento . '</fechaNacimiento_Nat>
		               <fkIdCiudadDomicilio_Nat>' . $ciudad . '</fkIdCiudadDomicilio_Nat>
		               <fkIdClasePersona>' . $clase_persona . '</fkIdClasePersona>
		               <fkIdDepartamentoDomicilio_Nat>' . $departamento . '</fkIdDepartamentoDomicilio_Nat>
		               <fkIdPaisDomicilio_Nat>' . $pais . '</fkIdPaisDomicilio_Nat>
		               <identificacionEmisor>' . $emisor . '</identificacionEmisor>
					   <fkIdCiudadExpedicion_Nat>' . $ciudad_documento . '</fkIdCiudadExpedicion_Nat>
					   <fkIdDepartamentoExpedicion_Nat>' . $departamento_documento . '</fkIdDepartamentoExpedicion_Nat>
					   <fkIdPaisExpedicion_Nat>' . $pais_documento . '</fkIdPaisExpedicion_Nat>
					   <fkIdTipoDocumento>' . $tipo_documento . '</fkIdTipoDocumento>
		               <numeroCelular>' . $celular . '</numeroCelular>
		               <numeroDocumento>' . $documento . '</numeroDocumento>
		               <nombresNat_Nat>' . $nombres . '</nombresNat_Nat>
					   <primerApellido_Nat>' . $apellido1 . '</primerApellido_Nat>';
    if ($apellido2) {
      $xml = $xml . '<segundoApellido_Nat>' . $apellido2 . '</segundoApellido_Nat>';
    }

    $xml = $xml . '<telefono1PersonaGrupo_PGP>' . $telefono . '</telefono1PersonaGrupo_PGP>
					   <fkIdPaisNacionalidad_Nat>' . $pais . '</fkIdPaisNacionalidad_Nat>
		            </crearGiradorDTO>
		            <header>
		               <codigoDepositante>' . $codigo_depositante . '</codigoDepositante>
		               <fecha>' . $fecha . 'T' . $hora . '</fecha>
		               <hora>' . $hora2 . '</hora>
		               <usuario>' . $usuario . '</usuario>
		            </header>
		         </arg0>
		      </ser:creacionGiradoresCodificados>
		   </soapenv:Body>
		</soapenv:Envelope>';

    //print_r($xml);
    $request = $xml;
    $location = $wsdl;
    $action = "";
    $version = 1.2;
    $xml2 = $client->__dorequest($request, $location, $action, $version);
    $res = $this->soaptoarray($xml2);
    //print_r($res);

    $metodo = "creacionGiradoresCodificados";
    $exitoso = $res['exitoso'];
    $codigoError = $res['codigoError'];
    $id_deceval = $res['cuentaGirador'];
    $mensaje = $res['mensajeRespuesta'];
    $descripcion = $res['descripcion'];

    $res = print_r($res, true);
    $numero_solicitud = $solicitud->pagare;

    if (strpos($mensaje, "Girador ya existe en el sistema") !== FALSE) {
      $exitoso = 'true';
    }
    if (strpos($descripcion, "no coincide") !== FALSE) {
      $exitoso = 'false';
    }


    //Registro transaccion
    $data = array();
    $ip = $_SERVER['REMOTE_ADDR'];
    $fecha = date("Y-m-d H:i:s");
    $quien = round($_SESSION['kt_login_id']);
    $data['metodo'] = $metodo;
    $data['xml'] = $xml;
    $data['res'] = $res;
    $data['exitoso'] = $exitoso;
    $data['codigoError'] = $codigoError;
    $data['fecha'] = $fecha;
    $data['solicitud'] = $id;
    $data['numero_solicitud'] = $numero_solicitud;
    $data['ip'] = $ip;
    $data['quien'] = $quien;
    $transaccionModel = new Page_Model_DbTable_Transaccion();
    $transaccionModel->insert($data);

    $ceduladecevalModel = new Administracion_Model_DbTable_Ceduladeceval();
    $existe = $ceduladecevalModel->getList(" cedula='$documento' ", "");
    if (count($existe) == 0 and $id_deceval != "" and $id_deceval != "0") {
      $data['cedula'] = $documento;
      $data['usuario_deceval'] = $id_deceval;
      $data['fecha'] = date("Y-m-d");
      $ceduladecevalModel->insert($data);
    }

    if ($exitoso == 'true') {
      $this->_view->mensaje = "GIRADOR CREADO CON EXITO";
      if ($codeudor1 != "") {
        header("Refresh:3; url=/administracion/wspagares/crearcodeudor1/?id=" . $id);
      } else {
        header("Refresh:3; url=/administracion/wspagares/crearpagare/?id=" . $id);
      }
    } else {
      $this->_view->mensaje = "ERROR CREANDO GIRADOR: " . $mensaje;
    }
  }


  public function crearcodeudor1Action()
  {
    $this->setLayout('blanco');
    $id = $this->_getSanitizedParam("id");
    $solicitudesModel = new Administracion_Model_DbTable_Solicitudes();
    $solicitud = $solicitudesModel->getById($id);


    $codeudorModel = new Administracion_Model_DbTable_Codeudor();
    $codeudor1_list = $codeudorModel->getList(" solicitud='$id' AND codeudor_numero='1' ", "")[0];
    $codeudor1 = $codeudor1_list->cedula;
    $codeudor2 = $codeudor2_list->cedula;
    $cedula = $codeudor1_list->cedula;


    $local_cert = "certificado.pem";
    $wsdl = "https://pruebas.deceval.com.co:446/weblogic/sdl12/services/SDLService?WSDL";
    $wsdl = "http://localhost:8086/SDLProxy/services/ProxyServicesImplPort?wsdl";

    $client = new soapClient(
      $wsdl,
      array(
        "trace"         => 1,
        "exceptions"    => true,
        "local_cert"    => $local_cert,
        "uri"           => "urn:xmethods-delayed-quotes",
        "style"         => SOAP_RPC,
        "use"           => SOAP_ENCODED,
        "soap_version"  => SOAP_1_2
      )
    );

    $fecha = date("Y-m-d");
    $hora = date("H:i:s");
    $hora2 = date("H:i");
    $email = $codeudor1_list->correo_empresarial;
    if ($email == "") {
      $email = $codeudor1_list->correo;
    }
    $direccion = $codeudor1_list->nomenclatura2 . " " . $codeudor1_list->direccion_residencia;
    $fecha_nacimiento = $codeudor1_list->fecha_nacimiento . 'T00:00:00';
    $fecha_exp = $codeudor1_list->fecha_documento . 'T00:00:00';

    $clase_persona = 1; //NATURAL
    $tipo_documento = 1; //CC
    if ($codeudor1_list->tipo_documento == "CC") {
      $tipo_documento = 1;
    }
    if ($codeudor1_list->tipo_documento == "CE") {
      $tipo_documento = 2;
    }

    $nombres1 = trim($codeudor1_list->nombres);
    $nombres2 = trim($codeudor1_list->nombres2);
    $nombres = trim($nombres1 . " " . $nombres2);
    $apellido1 = trim($codeudor1_list->apellido1);
    $apellido2 = trim($codeudor1_list->apellido2);

    $nombres1 = html_entity_decode($nombres1);
    $nombres2 = html_entity_decode($nombres2);
    $nombres = html_entity_decode($nombres);
    $apellido1 = html_entity_decode($apellido1);
    $apellido2 = html_entity_decode($apellido2);

    $celular = $codeudor1_list->celular;
    $documento = $cedula;
    $telefono = $codeudor1_list->telefono;
    $emisor = '9012814837'; // nit

    $telefono = str_replace(" ", "", $telefono);
    $celular = str_replace(" ", "", $celular);
    if ($telefono == "") {
      $telefono = $celular;
    }
    $ciudad = $codeudor1_list->ciudad_residencia;
    $ciudad = str_pad($ciudad, 5, "0", STR_PAD_LEFT);
    $departamento = substr($ciudad, 0, 2);
    $pais = 'CO';

    $ciudad_documento = $codeudor1_list->ciudad_documento;
    $ciudad_documento = str_pad($ciudad_documento, 5, "0", STR_PAD_LEFT);
    $departamento_documento = substr($ciudad_documento, 0, 2);
    $pais_documento = 'CO';

    //pruebas
    $usuario = '90128148371';
    $codigo_depositante = '640';
    //produccion
    //$usuario = '80004306941';
    //$codigo_depositante = '1046';


    $xml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://services.proxy.deceval.com/">
		   <soapenv:Header/>
		   <soapenv:Body>
		      <ser:creacionGiradoresCodificados>
		         <!--Optional:-->
		         <arg0>
		            <!--Zero or more repetitions:-->
		            <crearGiradorDTO>
		               <correoElectronico>' . $email . '</correoElectronico>
		               <direccion1PersonaGrupo_PGP>' . $direccion . '</direccion1PersonaGrupo_PGP>
		               <fechaExpedicion_Nat>' . $fecha_exp . '</fechaExpedicion_Nat>
		               <fechaNacimiento_Nat>' . $fecha_nacimiento . '</fechaNacimiento_Nat>
		               <fkIdCiudadDomicilio_Nat>' . $ciudad . '</fkIdCiudadDomicilio_Nat>
		               <fkIdClasePersona>' . $clase_persona . '</fkIdClasePersona>
		               <fkIdDepartamentoDomicilio_Nat>' . $departamento . '</fkIdDepartamentoDomicilio_Nat>
		               <fkIdPaisDomicilio_Nat>' . $pais . '</fkIdPaisDomicilio_Nat>
		               <identificacionEmisor>' . $emisor . '</identificacionEmisor>
					   <fkIdCiudadExpedicion_Nat>' . $ciudad_documento . '</fkIdCiudadExpedicion_Nat>
					   <fkIdDepartamentoExpedicion_Nat>' . $departamento_documento . '</fkIdDepartamentoExpedicion_Nat>
					   <fkIdPaisExpedicion_Nat>' . $pais_documento . '</fkIdPaisExpedicion_Nat>
					   <fkIdTipoDocumento>' . $tipo_documento . '</fkIdTipoDocumento>
		               <numeroCelular>' . $celular . '</numeroCelular>
		               <numeroDocumento>' . $documento . '</numeroDocumento>
		               <nombresNat_Nat>' . $nombres . '</nombresNat_Nat>
					   <primerApellido_Nat>' . $apellido1 . '</primerApellido_Nat>
					   <segundoApellido_Nat>' . $apellido2 . '</segundoApellido_Nat>
		               <telefono1PersonaGrupo_PGP>' . $telefono . '</telefono1PersonaGrupo_PGP>
					   <fkIdPaisNacionalidad_Nat>' . $pais . '</fkIdPaisNacionalidad_Nat>
		            </crearGiradorDTO>
		            <header>
		               <codigoDepositante>' . $codigo_depositante . '</codigoDepositante>
		               <fecha>' . $fecha . 'T' . $hora . '</fecha>
		               <hora>' . $hora2 . '</hora>
		               <usuario>' . $usuario . '</usuario>
		            </header>
		         </arg0>
		      </ser:creacionGiradoresCodificados>
		   </soapenv:Body>
		</soapenv:Envelope>';

    if ($apellido2 == "") {
      $xml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://services.proxy.deceval.com/">
			   <soapenv:Header/>
			   <soapenv:Body>
			      <ser:creacionGiradoresCodificados>
			         <!--Optional:-->
			         <arg0>
			            <!--Zero or more repetitions:-->
			            <crearGiradorDTO>
			               <correoElectronico>' . $email . '</correoElectronico>
			               <direccion1PersonaGrupo_PGP>' . $direccion . '</direccion1PersonaGrupo_PGP>
			               <fechaExpedicion_Nat>' . $fecha_exp . '</fechaExpedicion_Nat>
			               <fechaNacimiento_Nat>' . $fecha_nacimiento . '</fechaNacimiento_Nat>
			               <fkIdCiudadDomicilio_Nat>' . $ciudad . '</fkIdCiudadDomicilio_Nat>
			               <fkIdClasePersona>' . $clase_persona . '</fkIdClasePersona>
			               <fkIdDepartamentoDomicilio_Nat>' . $departamento . '</fkIdDepartamentoDomicilio_Nat>
			               <fkIdPaisDomicilio_Nat>' . $pais . '</fkIdPaisDomicilio_Nat>
			               <identificacionEmisor>' . $emisor . '</identificacionEmisor>
						   <fkIdCiudadExpedicion_Nat>' . $ciudad_documento . '</fkIdCiudadExpedicion_Nat>
						   <fkIdDepartamentoExpedicion_Nat>' . $departamento_documento . '</fkIdDepartamentoExpedicion_Nat>
						   <fkIdPaisExpedicion_Nat>' . $pais_documento . '</fkIdPaisExpedicion_Nat>
						   <fkIdTipoDocumento>' . $tipo_documento . '</fkIdTipoDocumento>
			               <numeroCelular>' . $celular . '</numeroCelular>
			               <numeroDocumento>' . $documento . '</numeroDocumento>
			               <nombresNat_Nat>' . $nombres . '</nombresNat_Nat>
						   <primerApellido_Nat>' . $apellido1 . '</primerApellido_Nat>
			               <telefono1PersonaGrupo_PGP>' . $telefono . '</telefono1PersonaGrupo_PGP>
						   <fkIdPaisNacionalidad_Nat>' . $pais . '</fkIdPaisNacionalidad_Nat>
			            </crearGiradorDTO>
			            <header>
			               <codigoDepositante>' . $codigo_depositante . '</codigoDepositante>
			               <fecha>' . $fecha . 'T' . $hora . '</fecha>
			               <hora>' . $hora2 . '</hora>
			               <usuario>' . $usuario . '</usuario>
			            </header>
			         </arg0>
			      </ser:creacionGiradoresCodificados>
			   </soapenv:Body>
			</soapenv:Envelope>';
    }
    //print($xml);
    $request = $xml;
    $location = $wsdl;
    $action = "";
    $version = 1.2;
    $xml2 = $client->__dorequest($request, $location, $action, $version);
    $res = $this->soaptoarray($xml2);
    //print_r($res);

    $metodo = "creacionGiradoresCodificados";
    $exitoso = $res['exitoso'];
    $codigoError = $res['codigoError'];
    $id_deceval = $res['cuentaGirador'];
    $mensaje = $res['mensajeRespuesta'];
    $descripcion = $res['descripcion'];

    $res = print_r($res, true);
    $numero_solicitud = $solicitud->pagare;

    if (strpos($mensaje, "Girador ya existe en el sistema") !== FALSE) {
      $exitoso = 'true';
    }
    if (strpos($descripcion, "no coincide") !== FALSE) {
      $exitoso = 'false';
    }


    //Registro transaccion
    $data = array();
    $ip = $_SERVER['REMOTE_ADDR'];
    $fecha = date("Y-m-d H:i:s");
    $quien = round($_SESSION['kt_login_id']);
    $data['metodo'] = $metodo;
    $data['xml'] = $xml;
    $data['res'] = $res;
    $data['exitoso'] = $exitoso;
    $data['codigoError'] = $codigoError;
    $data['fecha'] = $fecha;
    $data['solicitud'] = $id;
    $data['numero_solicitud'] = $numero_solicitud;
    $data['ip'] = $ip;
    $data['quien'] = $quien;
    $transaccionModel = new Page_Model_DbTable_Transaccion();
    $transaccionModel->insert($data);

    $ceduladecevalModel = new Administracion_Model_DbTable_Ceduladeceval();
    $existe = $ceduladecevalModel->getList(" cedula='$documento' ", "");
    if (count($existe) == 0 and $id_deceval != "" and $id_deceval != "0") {
      $data['cedula'] = $documento;
      $data['usuario_deceval'] = $id_deceval;
      $data['fecha'] = date("Y-m-d");
      $ceduladecevalModel->insert($data);
    }

    if ($exitoso == 'true') {
      $this->_view->mensaje = "CODEUDOR1 CREADO CON EXITO";
      // if ($codeudor2 != "") {
      //   header("Refresh:3; url=/administracion/wspagares/crearcodeudor2/?id=" . $id);
      // } else {
        header("Refresh:3; url=/administracion/wspagares/crearpagare/?id=" . $id);
      // }
    } else {
      $this->_view->mensaje = "ERROR CREANDO CODEUDOR1: " . $mensaje;
    }
  }


  public function crearcodeudor2Action()
  {
    $this->setLayout('blanco');
    $id = $this->_getSanitizedParam("id");
    $solicitudesModel = new Administracion_Model_DbTable_Solicitudes();
    $solicitud = $solicitudesModel->getById($id);
    $cedula = $codeudor2_list->cedula;

    $codeudorModel = new Administracion_Model_DbTable_Codeudor();
    $codeudor1_list = $codeudorModel->getList(" solicitud='$id' AND codeudor_numero='2' ", "")[0];
    $codeudor1 = $codeudor1_list->cedula;
    $codeudor2 = $codeudor2_list->cedula;


    $local_cert = "certificado.pem";
    $wsdl = "https://pruebas.deceval.com.co:446/weblogic/sdl12/services/SDLService?WSDL";
    $wsdl = "http://localhost:8086/SDLProxy/services/ProxyServicesImplPort?wsdl";

    $client = new soapClient(
      $wsdl,
      array(
        "trace"         => 1,
        "exceptions"    => true,
        "local_cert"    => $local_cert,
        "uri"           => "urn:xmethods-delayed-quotes",
        "style"         => SOAP_RPC,
        "use"           => SOAP_ENCODED,
        "soap_version"  => SOAP_1_2
      )
    );

    $fecha = date("Y-m-d");
    $hora = date("H:i:s");
    $hora2 = date("H:i");
    $email = $codeudor1_list->correo_empresarial;
    if ($email == "") {
      $email = $codeudor1_list->correo;
    }
    $direccion = $codeudor1_list->nomenclatura2 . " " . $codeudor1_list->direccion_residencia;
    $fecha_nacimiento = $codeudor1_list->fecha_nacimiento . 'T00:00:00';
    $fecha_exp = $codeudor1_list->fecha_documento . 'T00:00:00';

    $clase_persona = 1; //NATURAL
    $tipo_documento = 1; //CC
    if ($codeudor1_list->tipo_documento == "CC") {
      $tipo_documento = 1;
    }
    if ($codeudor1_list->tipo_documento == "CE") {
      $tipo_documento = 2;
    }


    $nombres1 = trim($codeudor1_list->nombres);
    $nombres2 = trim($codeudor1_list->nombres2);
    $nombres = trim($nombres1 . " " . $nombres2);
    $apellido1 = trim($codeudor1_list->apellido1);
    $apellido2 = trim($codeudor1_list->apellido2);

    $nombres1 = html_entity_decode($nombres1);
    $nombres2 = html_entity_decode($nombres2);
    $nombres = html_entity_decode($nombres);
    $apellido1 = html_entity_decode($apellido1);
    $apellido2 = html_entity_decode($apellido2);


    $celular = $codeudor1_list->celular;
    $documento = $cedula;
    $telefono = $codeudor1_list->telefono;
    $emisor = '9012814837'; // nit

    $telefono = str_replace(" ", "", $telefono);
    $celular = str_replace(" ", "", $celular);
    if ($telefono == "") {
      $telefono = $celular;
    }
    $ciudad = $codeudor1_list->ciudad_residencia;
    $ciudad = str_pad($ciudad, 5, "0", STR_PAD_LEFT);
    $departamento = substr($ciudad, 0, 2);
    $pais = 'CO';

    $ciudad_documento = $codeudor1_list->ciudad_documento;
    $ciudad_documento = str_pad($ciudad_documento, 5, "0", STR_PAD_LEFT);
    $departamento_documento = substr($ciudad_documento, 0, 2);
    $pais_documento = 'CO';

    //pruebas
    $usuario = '90128148371';
    $codigo_depositante = '640';
    //produccion
    //$usuario = '80004306941';
    //$codigo_depositante = '1046';


    $xml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://services.proxy.deceval.com/">
		   <soapenv:Header/>
		   <soapenv:Body>
		      <ser:creacionGiradoresCodificados>
		         <!--Optional:-->
		         <arg0>
		            <!--Zero or more repetitions:-->
		            <crearGiradorDTO>
		               <correoElectronico>' . $email . '</correoElectronico>
		               <direccion1PersonaGrupo_PGP>' . $direccion . '</direccion1PersonaGrupo_PGP>
		               <fechaExpedicion_Nat>' . $fecha_exp . '</fechaExpedicion_Nat>
		               <fechaNacimiento_Nat>' . $fecha_nacimiento . '</fechaNacimiento_Nat>
		               <fkIdCiudadDomicilio_Nat>' . $ciudad . '</fkIdCiudadDomicilio_Nat>
		               <fkIdClasePersona>' . $clase_persona . '</fkIdClasePersona>
		               <fkIdDepartamentoDomicilio_Nat>' . $departamento . '</fkIdDepartamentoDomicilio_Nat>
		               <fkIdPaisDomicilio_Nat>' . $pais . '</fkIdPaisDomicilio_Nat>
		               <identificacionEmisor>' . $emisor . '</identificacionEmisor>
					   <fkIdCiudadExpedicion_Nat>' . $ciudad_documento . '</fkIdCiudadExpedicion_Nat>
					   <fkIdDepartamentoExpedicion_Nat>' . $departamento_documento . '</fkIdDepartamentoExpedicion_Nat>
					   <fkIdPaisExpedicion_Nat>' . $pais_documento . '</fkIdPaisExpedicion_Nat>
					   <fkIdTipoDocumento>' . $tipo_documento . '</fkIdTipoDocumento>
		               <numeroCelular>' . $celular . '</numeroCelular>
		               <numeroDocumento>' . $documento . '</numeroDocumento>
		               <nombresNat_Nat>' . $nombres . '</nombresNat_Nat>
					   <primerApellido_Nat>' . $apellido1 . '</primerApellido_Nat>
					   <segundoApellido_Nat>' . $apellido2 . '</segundoApellido_Nat>
		               <telefono1PersonaGrupo_PGP>' . $telefono . '</telefono1PersonaGrupo_PGP>
					   <fkIdPaisNacionalidad_Nat>' . $pais . '</fkIdPaisNacionalidad_Nat>
		            </crearGiradorDTO>
		            <header>
		               <codigoDepositante>' . $codigo_depositante . '</codigoDepositante>
		               <fecha>' . $fecha . 'T' . $hora . '</fecha>
		               <hora>' . $hora2 . '</hora>
		               <usuario>' . $usuario . '</usuario>
		            </header>
		         </arg0>
		      </ser:creacionGiradoresCodificados>
		   </soapenv:Body>
		</soapenv:Envelope>';

    if ($apellido2 == "") {
      $xml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://services.proxy.deceval.com/">
			   <soapenv:Header/>
			   <soapenv:Body>
			      <ser:creacionGiradoresCodificados>
			         <!--Optional:-->
			         <arg0>
			            <!--Zero or more repetitions:-->
			            <crearGiradorDTO>
			               <correoElectronico>' . $email . '</correoElectronico>
			               <direccion1PersonaGrupo_PGP>' . $direccion . '</direccion1PersonaGrupo_PGP>
			               <fechaExpedicion_Nat>' . $fecha_exp . '</fechaExpedicion_Nat>
			               <fechaNacimiento_Nat>' . $fecha_nacimiento . '</fechaNacimiento_Nat>
			               <fkIdCiudadDomicilio_Nat>' . $ciudad . '</fkIdCiudadDomicilio_Nat>
			               <fkIdClasePersona>' . $clase_persona . '</fkIdClasePersona>
			               <fkIdDepartamentoDomicilio_Nat>' . $departamento . '</fkIdDepartamentoDomicilio_Nat>
			               <fkIdPaisDomicilio_Nat>' . $pais . '</fkIdPaisDomicilio_Nat>
			               <identificacionEmisor>' . $emisor . '</identificacionEmisor>
						   <fkIdCiudadExpedicion_Nat>' . $ciudad_documento . '</fkIdCiudadExpedicion_Nat>
						   <fkIdDepartamentoExpedicion_Nat>' . $departamento_documento . '</fkIdDepartamentoExpedicion_Nat>
						   <fkIdPaisExpedicion_Nat>' . $pais_documento . '</fkIdPaisExpedicion_Nat>
						   <fkIdTipoDocumento>' . $tipo_documento . '</fkIdTipoDocumento>
			               <numeroCelular>' . $celular . '</numeroCelular>
			               <numeroDocumento>' . $documento . '</numeroDocumento>
			               <nombresNat_Nat>' . $nombres . '</nombresNat_Nat>
						   <primerApellido_Nat>' . $apellido1 . '</primerApellido_Nat>
			               <telefono1PersonaGrupo_PGP>' . $telefono . '</telefono1PersonaGrupo_PGP>
						   <fkIdPaisNacionalidad_Nat>' . $pais . '</fkIdPaisNacionalidad_Nat>
			            </crearGiradorDTO>
			            <header>
			               <codigoDepositante>' . $codigo_depositante . '</codigoDepositante>
			               <fecha>' . $fecha . 'T' . $hora . '</fecha>
			               <hora>' . $hora2 . '</hora>
			               <usuario>' . $usuario . '</usuario>
			            </header>
			         </arg0>
			      </ser:creacionGiradoresCodificados>
			   </soapenv:Body>
			</soapenv:Envelope>';
    }

    $request = $xml;
    $location = $wsdl;
    $action = "";
    $version = 1.2;
    $xml2 = $client->__dorequest($request, $location, $action, $version);
    $res = $this->soaptoarray($xml2);
    //print_r($res);

    $metodo = "creacionGiradoresCodificados";
    $exitoso = $res['exitoso'];
    $codigoError = $res['codigoError'];
    $id_deceval = $res['cuentaGirador'];
    $mensaje = $res['mensajeRespuesta'];
    $descripcion = $res['descripcion'];

    $res = print_r($res, true);
    $numero_solicitud = $solicitud->pagare;

    if (strpos($mensaje, "Girador ya existe en el sistema") !== FALSE) {
      $exitoso = 'true';
    }
    if (strpos($descripcion, "no coincide") !== FALSE) {
      $exitoso = 'false';
    }



    //Registro transaccion
    $data = array();
    $ip = $_SERVER['REMOTE_ADDR'];
    $fecha = date("Y-m-d H:i:s");
    $quien = round($_SESSION['kt_login_id']);
    $data['metodo'] = $metodo;
    $data['xml'] = $xml;
    $data['res'] = $res;
    $data['exitoso'] = $exitoso;
    $data['codigoError'] = $codigoError;
    $data['fecha'] = $fecha;
    $data['solicitud'] = $id;
    $data['numero_solicitud'] = $numero_solicitud;
    $data['ip'] = $ip;
    $data['quien'] = $quien;
    $transaccionModel = new Page_Model_DbTable_Transaccion();
    $transaccionModel->insert($data);

    $ceduladecevalModel = new Administracion_Model_DbTable_Ceduladeceval();
    $existe = $ceduladecevalModel->getList(" cedula='$documento' ", "");
    if (count($existe) == 0 and $id_deceval != "" and $id_deceval != "0") {
      $data['cedula'] = $documento;
      $data['usuario_deceval'] = $id_deceval;
      $data['fecha'] = date("Y-m-d");
      $ceduladecevalModel->insert($data);
    }

    if ($exitoso == 'true') {
      $this->_view->mensaje = "CODEUDOR2 CREADO CON EXITO";
      header("Refresh:3; url=/administracion/wspagares/crearpagare/?id=" . $id);
    } else {
      $this->_view->mensaje = "ERROR CREANDO CODEUDOR2: " . $mensaje;
    }
  }


  public function crearpagareAction()
  {
    $this->setLayout('blanco');
    $id = $this->_getSanitizedParam("id");
    $solicitudesModel = new Administracion_Model_DbTable_Solicitudes();
    $solicitud = $solicitudesModel->getById($id);
    $cedula = $solicitud->cedula;

    if ($solicitud->tipo_garantia == 2) {
      $codeudorModel = new Administracion_Model_DbTable_Codeudor();
      $codeudor1_list = $codeudorModel->getList(" solicitud='$id' AND codeudor_numero='1' ", "")[0];
      $codeudor2_list = $codeudorModel->getList(" solicitud='$id' AND codeudor_numero='2' ", "")[0];
      $codeudor1 = $codeudor1_list->cedula;
      $codeudor2 = $codeudor2_list->cedula;
    }
    $numero_obligacion = $solicitud->pagare;
    $pagareModel = new Page_Model_DbTable_Pagaredeceval();
    $existe_pagare = $pagareModel->getList(" pagare='$numero_obligacion' ", "");

    //EVALUAR SI EXISTE EL PAGARE
    if (count($existe_pagare) > 0) {

      if ($existe_pagare[0]->estado == "0") {
        $this->_view->mensaje1 = "EL PAGARE YA EXISTE PERO NO SE HA FIRMADO, REENVIANDO EMAIL";
        header("Refresh:3; url= /administracion/solicitudes/enviarpagare/?id=" . $id);
      }
      if ($existe_pagare[0]->estado == "1") {
        $this->_view->mensaje1 = "EL PAGARE YA FUE FIRMADO";
        header("Refresh:3; url=/administracion/solicitudes/?pagina=1");
      }
    }
    if (count($existe_pagare) == 0) {
      $local_cert = "certificado.pem";
      $wsdl = "https://pruebas.deceval.com.co:446/weblogic/sdl12/services/SDLService?WSDL";
      $wsdl = "http://localhost:8086/SDLProxy/services/ProxyServicesImplPort?wsdl";

      $client = new soapClient(
        $wsdl,
        array(
          "trace"         => 1,
          "exceptions"    => true,
          "local_cert"    => $local_cert,
          "uri"           => "urn:xmethods-delayed-quotes",
          "style"         => SOAP_RPC,
          "use"           => SOAP_ENCODED,
          "soap_version"  => SOAP_1_2,
          "connection_timeout" => 120
        )
      );

      $fecha = date("Y-m-d");
      $hora = date("H:i:s");
      $hora2 = date("H:i");

      $emisor = '9012814837';
      $id_clase_documento = 596; //id plantilla
      $id_clase_documento = 724; //id plantilla
      //produccion
      //$id_clase_documento = 397; //id plantilla
      $tipo_pagare = 2; //en blanco con carta de instrucciones
      $numero_credito = $solicitud->pagare;
      $numero_pagare = $solicitud->pagare;

      $tipo_documento = 1; //CC
      if ($solicitud->tipo_documento == "CC") {
        $tipo_documento = 1;
      }
      if ($solicitud->tipo_documento == "CE") {
        $tipo_documento = 2;
      }

      $documento = $solicitud->cedula;
      $ceduladecevalModel = new Administracion_Model_DbTable_Ceduladeceval();
      $existe = $ceduladecevalModel->getList(" cedula='$documento' ", "")[0];
      $cuenta = $existe->usuario_deceval;

      $moneda = 2; // PESOS
      $empresa = 'Fondo de empleados FEDEAA';
      $monto = '';
      $tasa_interes = $solicitud->tasa_desembolso;
      $tipo_tasa = 1; //EA

      $ciudad = $solicitud->ciudad_residencia;
      $ciudad = str_pad($ciudad, 5, "0", STR_PAD_LEFT);
      $departamento = substr($ciudad, 0, 2);
      $pais = 'CO';

      //pruebas
      $usuario = '90128148371';
      $codigo_depositante = '640';
      //produccion
      //$usuario = '80004306941';
      //$codigo_depositante = '1046';

      $xml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://services.proxy.deceval.com/">
			   <soapenv:Header/>
			   <soapenv:Body>
			      <ser:creacionPagaresCodificado>
			         <arg0>
			            <documentoPagareServiceDTO>

			           		<nitEmisor>' . $emisor . '</nitEmisor>
			                <idClaseDefinicionDocumento>' . $id_clase_documento . '</idClaseDefinicionDocumento>
			                <fechaGrabacionPagare>' . $fecha . '</fechaGrabacionPagare>
							<tipoPagare>' . $tipo_pagare . '</tipoPagare>
							<numPagareEntidad>' . $numero_pagare . '</numPagareEntidad>
							<fechaDesembolso>' . $fecha . '</fechaDesembolso>
							<otorganteTipoId>' . $tipo_documento . '</otorganteTipoId>
							<otorganteNumId>' . $documento . '</otorganteNumId>
							<otorganteCuenta>' . $cuenta . '</otorganteCuenta>
							<creditoReembolsableEn>' . $moneda . '</creditoReembolsableEn>
							<ciudadDesembolso>' . $ciudad . '</ciudadDesembolso>
							<departamento>' . $departamento . '</departamento>
							<pais>' . $pais . '</pais>
							<mensajeRespuesta></mensajeRespuesta>
							<listaAmortizaciones></listaAmortizaciones>';

      if ($codeudor1 != "") {

        $codeudor1_deceval = $ceduladecevalModel->getList(" cedula='$codeudor1' ", "")[0]->usuario_deceval;

        $xml .= '
					   <listaCodeudoresAvalistasPagare>
					       <giradorCuenta>' . $codeudor1_deceval . '</giradorCuenta>
				               <giradorNumId>' . $codeudor1 . '</giradorNumId>
				               <giradorTipoId>1</giradorTipoId>
				               <idPersonaRepresentada>' . $documento . '</idPersonaRepresentada>
				               <idRol>6</idRol>
				       </listaCodeudoresAvalistasPagare>
				';
      }

      if ($codeudor2 != "") {

        $codeudor2_deceval = $ceduladecevalModel->getList(" cedula='$codeudor2' ", "")[0]->usuario_deceval;

        $xml .= '
					   <listaCodeudoresAvalistasPagare>
					       <giradorCuenta>' . $codeudor2_deceval . '</giradorCuenta>
				               <giradorNumId>' . $codeudor2 . '</giradorNumId>
				               <giradorTipoId>1</giradorTipoId>
				               <idPersonaRepresentada>' . $documento . '</idPersonaRepresentada>
				               <idRol>6</idRol>
				       </listaCodeudoresAvalistasPagare>
				';
      }

      $xml .= '
			            </documentoPagareServiceDTO>
			            <header>
			               <codigoDepositante>' . $codigo_depositante . '</codigoDepositante>
			               <fecha>' . $fecha . 'T' . $hora . '</fecha>
			               <hora>' . $hora2 . '</hora>
			               <usuario>' . $usuario . '</usuario>
			            </header>
			         </arg0>
			      </ser:creacionPagaresCodificado>
			   </soapenv:Body>
			</soapenv:Envelope>';
      //print_r($xml);
      $request = $xml;
      $location = $wsdl;
      $action = "";
      $version = 1.2;

      $xml2 = $client->__dorequest($request, $location, $action, $version);
      $res = $this->soaptoarray($xml2);
      // print_r($res);

      $metodo = "creacionPagaresCodificado";
      $exitoso = $res['exitoso'];
      $codigoError = $res['codigoError'];
      $id_pagare = $res['idDocumentoPagare'];

      $res = print_r($res, true);
      $numero_solicitud = $solicitud->pagare;
      $modalidad = $solicitud->linea;
      $token = $this->crear_token();
      $estado = 0; //sin firmar

      //Registro transaccion
      $data = array();
      $ip = $_SERVER['REMOTE_ADDR'];
      $fecha = date("Y-m-d H:i:s");
      $quien = round($_SESSION['kt_login_id']);
      $data['metodo'] = $metodo;
      $data['xml'] = $xml;
      $data['res'] = $res;
      $data['exitoso'] = $exitoso;
      $data['codigoError'] = $codigoError;
      $data['fecha'] = $fecha;
      $data['solicitud'] = $id;
      $data['numero_solicitud'] = $numero_solicitud;
      $data['ip'] = $ip;
      $data['quien'] = $quien;
      $transaccionModel = new Page_Model_DbTable_Transaccion();
      $transaccionModel->insert($data);
      if ($exitoso == 'true' || 1 == 0) {
        if ($id_pagare != '') {

          $data['pagare'] = $numero_solicitud;
          $data['pagare_deceval'] = $id_pagare;
          $data['fecha'] = $fecha;
          $data['estado'] = $estado;
          $data['token'] = $token;
          $data['modalidad'] = $modalidad;

          $pagareModel->insert($data);
        }

        $this->_view->mensaje1 = "PAGARE CREADO CON EXITO";
        if($solicitud->linea_desembolso != 'VEH'){
          header("Refresh:3; url= /administracion/solicitudes/enviarpagare/?id=" . $id);
        }else{
          header("Refresh:3; url= /administracion/solicitudes/");
        }
      } else {
        $this->_view->mensaje1 = "ERROR CREANDO PAGARE: " . $res['mensajeRespuesta'];
        header("Refresh:3; url=/administracion/solicitudes/?pagina=1&aprobada=3");
      }
    }
  }

  public function soaptoarray($response)
  {
    $search  = array('<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"', '<soapenv:Header/', '<soapenv:Body', '</', '<');
    $replace = array(' ', ' ', ' ', '@end@', '*start*');
    $customer = str_replace($search, $replace, $response);
    $soapres = explode('*start*', $customer);

    foreach ($soapres as $key => $value) {
      $res[$key] = $value;
      $temp = explode('@end@', $value);
      $tempval = explode('>', $temp[0]);
      $tmp = explode("State", $tempval[0]);

      $resp{
        $tempval[0]} = $tempval[1];
    }
    return $resp;
  }

  public function crear_token()
  {
    $hoy = date("Y-m-d H:i:s");
    $hoy = md5($hoy);
    $hoy = mb_strtoupper($hoy);
    $hoy = substr($hoy, 0, 8);
    return $hoy;
  }


  public function consultarestadosAction()
  {
    $this->setLayout('blanco');
    $solicitudesModel = new Administracion_Model_DbTable_Solicitudes();
    $hoy = date("Y-m-d");
    $solicitudes = $solicitudesModel->getList(" paso='8' AND validacion!='3' AND (fecha_estado!='$hoy' OR fecha_estado IS NULL OR fecha_estado='') ", " id DESC ");

    //$user = "CYFF3D340M3GA";
    //$password = "04d36e68f2f614";
    $user = "CYFF3D30M3GA0P1Q";
    $password = "0q1p2o9w3ie8r5t6y";

    foreach ($solicitudes as $key => $solicitud) {

      echo $solicitud->id . "<br>";
      $cedula = $solicitud->cedula;
      $token = $token = $this->getToken($user, $password, $cedula);
      $nit = $cedula;
      $numsol = $solicitud->pagare;
      $res = $this->getestado($token, $numsol, $nit);
      //print_r($res);
      $mensaje = $res->Message;
      echo "mensaje:" . $mensaje . "<br>";

      $estado = "";
      if (strpos($mensaje, "aprobada") !== false) {
        $estado = 1;
      }
      if (strpos($mensaje, "contabilizada") !== false) {
        $estado = 2;
      }
      if (strpos($mensaje, "rechazada") !== false) {
        $estado = 4;
      }
      if (strpos($mensaje, "anulada") !== false) {
        $estado = 3;
      }
      if (strpos($mensaje, "radicada") !== false) {
        $estado = 0;
      }
      if ($estado > 0) {
        $id = $solicitud->id;
        $solicitudesModel->editField($id, "validacion", $estado);
        $solicitudesModel->editField($id, "fecha_estado", $hoy);
        if ($estado == 2) {
          $solicitudesModel->editField($id, "paso", "8");
        }
        echo "ID: " . $id . " Mensaje: " . $mensaje . " Estado: " . $estado . "<br>";


        if ($estado != $solicitud->validacion) {
          if ($estado == "4" or $estado == "3") {
            $this->enviarestado($id);
          }
        }
      }
      if ($estado == 0) {
        $id = $solicitud->id;
        $solicitudesModel->editField($id, "fecha_estado", $hoy);
      }

      $pagareModel = new Administracion_Model_DbTable_Pagares();
      if ($numsol != "" and $estado == "2") {
        $pagare_list = $pagareModel->getList(" pagare='$numsol' ", "")[0];
        $pagare_deceval = $pagare_list->pagare_deceval;
        $numpagare = $pagare_deceval;
        $res = $this->ActualizaPagareSolicitud($token, $numsol, $nit, $numpagare);
        //print_r($res);
      }

      if ($res->Monto != "" and $res->Monto != $solicitud->valor_desembolso) {
        $solicitudModel->editField($id, "valor_desembolso", $res->Monto);
      }
      if ($res->Codlin != "" and $res->Codlin != $solicitud->linea_desembolso) {
        $solicitudModel->editField($id, "linea_desembolso", $res->Codlin);
      }
      if ($res->Plazo != "" and $res->Plazo != $solicitud->cuotas_desembolso) {
        $solicitudModel->editField($id, "cuotas_desembolso", $res->Plazo);
      }
      if ($res->valorcuota != "" and $res->valorcuota != $solicitud->valor_cuota_desembolso) {
        $solicitudModel->editField($id, "valor_cuota_desembolso", $res->valorcuota);
      }
    }
  }


  private function enviarestado($id)
  {

    //$id = $this->_getSanitizedParam("id");
    $solicitudModel = new Administracion_Model_DbTable_Solicitudes();
    $solicitud = $solicitudModel->getById($id);


    $asignado_anterior = $solicitud->asignado;
    $fecha_anterior = $solicitud->fecha_anterior;
    $linea_id = $solicitud->linea;
    $cedula = $solicitud->cedula;
    $asignado = $solicitud->asignado;
    $gestor_comercial = $solicitud->gestor_comercial;

    $lineaModel = new Administracion_Model_DbTable_Lineas();
    $linea = $lineaModel->getById($linea_id);

    $usuarioModel = new Administracion_Model_DbTable_Usuario();
    $usuario = $usuarioModel->getList(" user_user='$cedula' ", "")[0];
    $analista = $usuarioModel->getById($asignado);

    $gestorcomercial = $usuarioModel->getById($gestor_comercial);
    $gestor_comercial_nombre = $gestorcomercial->user_names;

    $correo_gestor = $gestorcomercial->user_email;
    $correo_codeudor = "";
    $correo_codeudor2 = "";
    $correo_codeudorB = "";
    $correo_codeudor2B = "";

    //if($solicitud->tipo_garantia=="DEUDOR SOLIDARIO"){
    if ($solicitud->tipo_garantia == "2" or in_array("2", $solicitud->tipo_garantia)) {
      $codeudorModel = new Administracion_Model_DbTable_Codeudor();
      $codeudor = $codeudorModel->getList(" solicitud='$id' AND codeudor_numero='1' ", "")[0];
      $correo_codeudor = $codeudor->correo;
      $correo_codeudor2 = $codeudor->correo_empresarial;

      $codeudor2 = $codeudorModel->getList(" solicitud='$id' AND codeudor_numero='2' ", "")[0];
      $correo_codeudorB = $codeudor2->correo;
      $correo_codeudor2B = $codeudor2->correo_empresarial;
    }


    $correo_personal = $solicitud->correo_personal;
    $correo_empresarial = $solicitud->correo_empresarial;

    $numero = con_ceros($id);
    $correo = $solicitud->correo_personal;
    $correoB = $solicitud->correo_corporativo;
    $correo1 = $analista->correo;

    $correo_personal = $solicitud->correo_personal;
    $correo_empresarial = $solicitud->correo_empresarial;

    $nombres = $solicitud->nombres . " " . $solicitud->nombres2 . " " . $solicitud->apellido1 . " " . $solicitud->apellido2;

    $contenido = '
			<table width="100%" border="0" cellspacing="0" cellpadding="3">
			  <tr>
			    <td colspan="2"><div align="center">
			    <h2 align="left">Resumen solicitud</strong></h2></td>
			  </tr>
			  <tr>
			    <td><strong>Solicitud</strong></td>
			    <td>WEB' . $numero . '</td>
			  </tr>
			  <tr>
			    <td><strong>Documento</strong></td>
			    <td>' . $solicitud->cedula . '</td>
			  </tr>
			  <tr>
			    <td><strong>Nombre</strong></td>
			    <td>' . $nombres . '</td>
			  </tr>
			  <tr>
			    <td><strong>Email</strong></td>
			    <td>' . $solicitud->correo_personal . '</td>
			  </tr>
			  <tr>
			    <td><strong>Celular</strong></td>
			    <td>' . $solicitud->celular . '</td>
			  </tr>
			  <tr>
			    <td><strong>Tel&eacute;fono</strong></td>
			    <td>' . $solicitud->telefono . '</td>
			  </tr>
			  <tr>
			    <td><strong>L&iacute;nea de cr&eacute;dito</strong></td>
			    <td>' . $linea->codigo . ' - ' . $linea->nombre . '&nbsp;</td>
			  </tr>';

    if ($solicitud->destino != "") {
      $contenido .= '
						  <tr>
						    <td><strong>Destino</strong></td>
						    <td>' . $solicitud->destino . '</td>
						  </tr>';
    }

    $contenido .= '
			  <tr>
			    <td><strong>Valor solicitado</strong></td>
			    <td>' . formato_pesos($solicitud->valor) . '</td>
			  </tr>
			  <tr>
			    <td><strong>Monto unificado</strong></td>
			    <td>' . formato_pesos($solicitud->monto_solicitado) . '</td>
			  </tr>
			  <tr>
			    <td><strong>N&uacute;mero de Cuotas</strong></td>
			    <td>' . $solicitud->cuotas . '</td>
			  </tr>
			  <tr>
			    <td><strong>Valor aproximado de cuota</strong></td>
			    <td>' . formato_pesos($solicitud->valor_cuota) . '</td>
			  </tr>
			  <tr>
			    <td><strong>Tasa de interes</strong></td>
			    <td>' . $solicitud->tasa . '%</td>
			  </tr>
			  <tr>
			    <td><strong>Cuotas extra</strong></td>
			    <td>' . $solicitud->cuotas_extra . '</td>
			  </tr>
			  <tr>
			    <td><strong>Valor cuota extra</strong></td>
			    <td>' . formato_pesos($solicitud->valor_extra) . '</td>
			  </tr>
			  <tr>
			    <td><strong>Fecha solicitud</strong></td>
			    <td>' . $solicitud->fecha_asignado . '</td>
			  </tr>';

    if ($solicitud->fecha_anterior != "") {
      $contenido .= '
			  <tr>
			    <td><strong>Fecha solicitud anterior incompleta</strong></td>
			    <td>' . $solicitud->fecha_anterior . '</td>
			  </tr>';
    }

    $contenido .= '
			  <tr>
			    <td><strong>Tramite</strong></td>
			    <td>' . $solicitud->tramite . '</td>
			  </tr>
			  <tr>
			    <td><strong>Gestor Comercial</strong></td>
			    <td>' . $gestor_comercial_nombre . '</td>
			  </tr>
			  <tr>
			    <td><strong>Analista asignado</strong></td>
			    <td>' . $analista->user_names . '</td>
			  </tr>
			  <tr>
			    <td><strong>Email</strong></td>
			    <td>' . $analista->user_email . '</td>
			  </tr>
			  <tr>
			    <td><strong>Tel&eacute;fono</strong></td>
			    <td>' . $analista->user_telefono . '</td>
			  </tr>
			  <tr>
			    <td><strong>Celular del ejecutivo de cuenta</strong></td>
			    <td>' . $gestorcomercial->user_celular . '</td>
			  </tr>
			  <tr>
			    <td><strong>Observaciones del analista</strong></td>
			    <td>' . $solicitud->observacion_analista . '</td>
			  </tr>
			</table>';

    $validaciones[6] = "Radicado";
    $validaciones[7] = "Revisado";
    $validaciones[0] = "En estudio";
    $validaciones[1] = "Aprobado";
    $validaciones[2] = "Contabilizado";
    $validaciones[3] = "Anulado";
    $validaciones[4] = "Rechazado";
    $validaciones[5] = "Procesado";

    $mensaje = "La solicitud WEB" . $numero . " cambio de estado a: <b>" . $validaciones[$solicitud->validacion] . "</b><br />
		<br /><br />" . $contenido;
    $asunto = "Solicitud de crédito " . $numero . ", cambio de estado";
    $content = $mensaje;

    $emailModel = new Core_Model_Mail();
    $emailModel->getMail()->setFrom("notificaciones@fondtodos.com", "Notificaciones Sistema Solicitud de créditos");
    $emailModel->getMail()->addBCC("soporteomega@omegawebsystems.com");
    $emailModel->getMail()->addBCC("desarrollo2@omegawebsystems.com");
    $emailModel->getMail()->addBCC("notificaciones@fondtodos.com");
    if ($correo_personal != "") {
      $emailModel->getMail()->addAddress("" . $correo_personal);
    }
    if ($correo_empresarial != "") {
      $emailModel->getMail()->addAddress("" . $correo_empresarial);
    }
    if ($correo_gestor != "") {
      $emailModel->getMail()->addBCC("" . $correo_gestor);
    }
    if ($correo_analista != "") {
      $emailModel->getMail()->addBCC("" . $correo_analista);
    }


    $emailModel->getMail()->Subject = $asunto;
    $emailModel->getMail()->msgHTML($content);
    $emailModel->getMail()->AltBody = $content;
    $emailModel->sed();
    $this->_view->error = $emailModel->getMail()->ErrorInfo;
  }

  private function getestado($token, $numsol, $nit)
  {

    $data = array(
      'token' => $token,
      'numsol' => $numsol,
      'nit' => $nit
    );

    $options = array(
      'http' => array(
        'method'  => 'POST',
        'content' => json_encode($data),
        'header' =>  "Content-Type: application/json\r\n" .
          "Accept: application/json\r\n"
      )
    );

    $url = URL_WS . "/EstadoSolicitud";

    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $response = json_decode($result);
    return $response;
  }

  private function getToken($user, $password, $cedula)
  {
    $data = array(
      'user' => '' . $user,
      'pw' => '' . $password,
      'nit' => '' . $cedula
    );

    $options = array(
      'http' => array(
        'method'  => 'POST',
        'content' => json_encode($data),
        'header' =>  "Content-Type: application/json\r\n" .
          "Accept: application/json\r\n"
      )
    );

    $url = URL_WS . "/GetToken";

    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $response = json_decode($result);
    return $response->Token;
  }

  private function ActualizaPagareSolicitud($token, $numsol, $nit, $numpagare)
  {
    $data = array(
      'token' => '' . $token,
      'numsol' => '' . $numsol,
      'nit' => '' . $nit,
      'numpagare' => '' . $numpagare
    );

    $options = array(
      'http' => array(
        'method'  => 'POST',
        'content' => json_encode($data),
        'header' =>  "Content-Type: application/json\r\n" .
          "Accept: application/json\r\n"
      )
    );

    $url = URL_WS . "/ActualizaPagareSolicitud";

    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $response = json_decode($result);
    return $response;
  }



  public function generarplanAction()
  {
    header('Access-Control-Allow-Origin: *');
    $this->setLayout('blanco');
    $solicitudModel = new Administracion_Model_DbTable_Solicitudes();
    $id = $this->_getSanitizedParam("id");
    $solicitud = $solicitudModel->getById($id);

    //CALCULAR CUPOS
    $linea = $solicitud->linea_desembolso;
    $tasa_nominal = $solicitud->tasa_desembolso;
    $cuotas = $solicitud->cuotas_desembolso;
    $valor1 = $solicitud->valor_desembolso;
    $monto_solicitado = $solicitud->valor_desembolso;
    $monto_aux = $monto_solicitado;
    $valor = $valor1;

    $abonos = $solicitud->cuotas_extra_desembolso;
    $extra = $solicitud->valor_cuota_desembolso;

    $abonos2 = $solicitud->cuotas_extra_desembolso2;
    $extra2 = $solicitud->valor_cuota_desembolso2;

    $tasa_nominal = $tasa_nominal * 12;
    $tasa = $tasa_nominal / 12;

    $fecha_desembolso = $solicitud->fecha_aprobado;

    $res = $this->consultarestado($id);
    $fecha_primera_cuota = str_replace("/", "-", $res->fhapricuota);



    //CALCULAR CUOTA

    //CUOTAS EXTRA
    $cuotaextra = str_replace('.', '', $extra);
    $numerocuotasextra = $abonos;
    $i = $tasa / 100;

    //calcular valor presente cuotas
    $anio = date('Y');
    $hoy = date("Y-m-d");
    $hoy = $fecha_desembolso;
    if ($hoy <= $anio . '-06-30') {
      $meses = 6 - date('m');
    } else {
      $meses = 12 - date('m');
    }
    $presente = 0;
    for ($m = 1; $m <= $numerocuotasextra; $m++) {
      $p = 1 + ($i);
      $p = pow($p, -1 * $meses);
      $p = $p * $cuotaextra;
      $presente = $presente + $p;
      $meses = $meses + 6;
    }
    //calcular valor presente cuotas

    //CUOTAS EXTRA

    //CUOTAS EXTRA2
    $cuotaextra2 = str_replace('.', '', $extra2);
    $numerocuotasextra2 = $abonos2;
    $i = $tasa / 100;

    //calcular valor presente cuotas
    $anio = date('Y');
    $hoy = date("Y-m-d");
    $hoy = $fecha_desembolso;
    if ($hoy <= $anio . '-06-30') {
      $meses = 6 - date('m');
    } else {
      $meses = 12 - date('m');
    }
    $presente2 = 0;
    for ($m = 1; $m <= $numerocuotasextra2; $m++) {
      $p = 1 + ($i);
      $p = pow($p, -1 * $meses);
      $p = $p * $cuotaextra2;
      $presente2 = $presente2 + $p;
      $meses = $meses + 6;
    }
    //calcular valor presente cuotas

    //CUOTAS EXTRA2


    $i = $tasa / 100;
    //calcular intereses dias
    $fecha = date("Y-m-d", strtotime("$hoy +1 month"));
    $var = explode("-", $fecha);
    $ultimo =  $this->UltimoDia($var[0], $var[1]);
    if ($ultimo == 31) {
      $ultimo = 30;
    }
    $fecha = $var[0] . "-" . $var[1] . "-" . $ultimo;
    $fecha = $fecha_primera_cuota;
    $date1 = new Datetime($hoy);
    $date2 = new Datetime($fecha);
    $diff = $date1->diff($date2);
    $dias_intereses = $diff->days;
    //$interes2 = $valor * ($i/30*$dias_intereses);

    $interes2 = $valor * (($tasa_nominal / 360) / 100 * $dias_intereses);
    $interes_dia = $valor * (($tasa_nominal / 360) / 100 * 1);
    $valor1 = $valor;
    $valor = $valor + $interes2;
    //calcular intereses dias

    //echo "valor: ".$valor." tasa_nominal:".$tasa_nominal." dias_intereses:".$dias_intereses." interes2:".$interes2;

    $k1 = $valor - $presente - $presente2; // prestamo
    $n = $max_meses;
    if ($cuotas != "") {
      $n = $cuotas; //cuotas
    }
    $r = $k1 * $i;

    $factor_seguro = 0.35 / 1000;
    $r1 = 1 - pow((1 + $i + $factor_seguro), (-1 * $n));
    if ($r1 > 0) {
      //$r = $r / $r1; //cuota

      //CUOTA = ROUND(VALOR*(INTERES/FACTOR),0)
      $r = round($valor1 * (($i + $factor_seguro) / $r1), 0);
    }

    //$r = 112000;
    $r = $res->valorcuota * 1;

    $hoy = date("Y") . "-" . date("m") . "-" . date("d");
    $diahoy = date("d");
    //CALCULAR CUOTA

    $hoy = date("Y-m-d");
    $hoy = $fecha_desembolso;
    $diahoy = date("d");
    $k = $monto_aux;
    $interes = $k * $i;
    $seguro = $k * 0.35 / 1000 * $dias_intereses / 30;
    //$seguro = 0;

    //$seguro = $seguro+$seguro2;
    $interes = $interes2;

    $abono = $r - $interes - $seguro;
    $saldo = $k;


    //fechas extra
    $fechas_extra = array();
    $antes_de_junio = 0;
    if ($hoy <= $anio . '-06-30') {
      $antes_de_junio = 1;
    }

    $primera_extra = $anio . '-06-30';
    if ($antes_de_junio == 0) {
      $primera_extra = $anio . '-12-30';
    }

    for ($x = 1; $x <= $numerocuotasextra; $x++) {
      if ($x == 1) {
        $fechas_extra[$primera_extra] = 1;
      } else {
        $aux = $primera_extra;
        $nueva_fecha = date("Y-m-d", strtotime("$aux +6 month"));
        $fechas_extra[$nueva_fecha] = 1;
        $primera_extra = $nueva_fecha;
      }
    }
    $aux1 = print_r($fechas_extra, true);
    //fechas extra

    //fechas extra2
    $fechas_extra2 = array();
    $antes_de_junio = 0;
    if ($hoy <= $anio . '-06-30') {
      $antes_de_junio = 1;
    }

    $primera_extra = $anio . '-03-30';
    if ($antes_de_junio == 0) {
      $primera_extra = ($anio + 1) . '-03-30';
    }

    for ($x = 1; $x <= $numerocuotasextra2; $x++) {
      if ($x == 1) {
        $fechas_extra2[$primera_extra] = 1;
      } else {
        $aux = $primera_extra;
        $nueva_fecha = date("Y-m-d", strtotime("$aux +12 month"));
        $fechas_extra2[$nueva_fecha] = 1;
        $primera_extra = $nueva_fecha;
      }
    }
    $aux2 = print_r($fechas_extra2, true);
    //fechas extra2

    //$dias_intereses--;
    $tabla = '<table width="100%" border="1" cellspacing="3" class="table-striped">
		      		<tr class="fondo-gris azul">
		      			<th class="text-center">NUMERO</th>
		      			<th class="text-center">FECHA</th>
		      			<th class="text-center">CAPITAL</th>
		      			<th class="text-center">INTERESES</th>
		      			<th class="text-center">CUOTA</th>
		      			<th class="text-center">SEGUROS</th>
		      			<th class="text-center">CUOTA EXTRA</th>
		      			<th class="text-center">TOTAL</th>
		      			<th class="text-center">SALDO</th>
		      		</tr>';

    $siguiente = $fecha_primera_cuota;
    for ($j = 1; $j <= $n; $j++) {

      /*
				if($diahoy >= 9){
					$meses = $j;
				}else{
					$meses = $j-1;
				}
				*/
      $meses = $j;
      //$fecha = date("Y-m-d", strtotime("$siguiente +1 month"));
      //$siguiente = $fecha;
      $fecha = $siguiente;
      $var = explode("-", $fecha);
      $var[1]++;
      if ($var[1] > 12) {
        $var[0]++;
        $var[1] = 1;
      }
      $var[1] = $this->con_cero($var[1]);


      $max_meses = 120;


      $ultimo =  $this->UltimoDia($var[0], $var[1]);
      if ($ultimo == 31) {
        $ultimo = 30;
      }
      $fecha = $var[0] . "-" . $var[1] . "-" . $ultimo;
      $siguiente = $fecha;
      if ($j == 1) {
        $fecha = $fecha_primera_cuota;
        $siguiente = $fecha;
      }
      if ($max_meses > 1) {
        $fecha2 = $var[0] . "-" . $var[1];
      } else {
        if ($hoy <= (date("Y") . "-06-30")) {
          $fecha2 = date("Y") . "-06";
        } else {
          $fecha2 = date("Y") . "-12";
        }
      }

      $cuota_extra = 0;
      if ($fechas_extra[$fecha] == 1) {
        $cuota_extra = $cuotaextra;
      }
      if ($fechas_extra2[$fecha] == 1) {
        $cuota_extra += $cuotaextra2;
      }


      //calcular seguro nuevamente
      if ($j > 1) {
        $date1 = new Datetime($fecha_anterior1);
        $date2 = new Datetime($fecha);
        $diff = $date1->diff($date2);
        $dias_intereses = $diff->days;
        $seguro = round($saldo * $dias_intereses * 0.35 / 30000);
        //echo "fecha_anterior1:".$fecha_anterior1." fecha:".$fecha." dias_intereses:".$dias_intereses." saldo:".$saldo."<br>";
        //
        $interes = round($saldo * $dias_intereses * $tasa_nominal / 36000);
        $abono = round($r - $interes - $seguro);
      }
      //calcular seguro nuevamente

      if ($j == $n) {
        $abono = $saldo;
        $r1 = round($abono) + round($interes) + round($seguro);
        //$saldo1 = $r-$r1;
        $r = $r1 - $saldo1;
      }

      $tabla .= '
			      		<tr>
			      			<td class="text-center">' . $j . '</td>
			      			<td class="text-center">' . $fecha . '</td>
			      			<td class="text-center">' . number_format($abono) . '</td>
			      			<td class="text-center">' . number_format($interes) . '</td>
			      			<td class="text-center">' . number_format(round($abono) + round($interes) + round($seguro)) . '</td>
			      			<td class="text-center">' . number_format($seguro) . '</td>
			      			<td class="text-center">' . number_format($cuota_extra) . '</td>
			      			<td class="text-center">' . number_format($r + $cuota_extra) . '</td>';
      $saldo = $saldo - $abono  - $cuota_extra;
      $saldo = round($saldo);
      if ($saldo < 200) {
        //$saldo=0;
      }

      $tabla .= '
			      			<td class="text-center">' . number_format($saldo) . '</td>
			      		</tr>';

      //$interes = $saldo * $i;
      //$seguro = $saldo*0.35/1000;
      //$seguro = 0;
      //$abono = $r - $interes - $seguro;

      $fecha_anterior1 = $fecha;
    }

    $tabla .= '</table>';

    $tabla = str_replace(array("\r", "\n", "\t", "      "), '', $tabla);

    echo $tabla;
  }


  public function UltimoDia($anho, $mes)
  {
    if (((fmod($anho, 4) == 0) and (fmod($anho, 100) != 0)) or (fmod($anho, 400) == 0)) {
      $dias_febrero = 29;
    } else {
      $dias_febrero = 28;
    }
    switch ($mes) {
      case 1:
        return 31;
        break;
      case 2:
        return $dias_febrero;
        break;
      case 3:
        return 31;
        break;
      case 4:
        return 30;
        break;
      case 5:
        return 31;
        break;
      case 6:
        return 30;
        break;
      case 7:
        return 31;
        break;
      case 8:
        return 31;
        break;
      case 9:
        return 30;
        break;
      case 10:
        return 31;
        break;
      case 11:
        return 30;
        break;
      case 12:
        return 31;
        break;
    }
  }

  public function con_cero($x)
  {
    $x = $x * 1;
    if ($x < 10) {
      $x = "0" . $x;
    }
    return $x;
  }
}
