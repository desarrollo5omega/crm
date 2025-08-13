<?php

/**
 * Controlador de Solicitudes que permite la  creacion, edicion  y eliminacion de los solicitudes del Sistema
 */
class Administracion_solicitudesController extends Administracion_mainController
{
  public $botonpanel = 6;
  /**
   * $mainModel  instancia del modelo de  base de datos solicitudes
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
  protected $_csrf_section = "administracion_solicitudes";

  /**
   * $namepages nombre de la pvariable en la cual se va a guardar  el numero de seccion en la paginacion del controlador
   * @var string
   */
  protected $namepages;



  /**
   * Inicializa las variables principales del controlador solicitudes .
   *
   * @return void.
   */
  public function init()
  {
    $this->mainModel = new Administracion_Model_DbTable_Solicitudes();
    $this->namefilter = "parametersfiltersolicitudes";
    $this->route = "/administracion/solicitudes";
    $this->namepages = "pages_solicitudes";
    $this->namepageactual = "page_actual_solicitudes";
    $this->_view->route = $this->route;
    if (Session::getInstance()->get($this->namepages)) {
      $this->pages = Session::getInstance()->get($this->namepages);
    } else {
      $this->pages = 20;
    }
    parent::init();
    $validaciones = array("En estudio", "Aprobado", "Desembolsado", "Anulado", "Rechazado", "Procesado", "Aplazado");
    $validaciones[7] = "Cambio de condiciones";
    $validaciones[8] = "Pasar a desembolso";
    $this->_view->validaciones = $validaciones;
  }


  /**
   * Recibe la informacion y  muestra un listado de  solicitudes con sus respectivos filtros.
   *
   * @return void.
   */
  public function indexAction()
  {
    ini_set('memory_limit', '-1');

    $incompletas = $this->mainModel->getList("paso!='8' ", "id DESC");
    $hoy = date("Y-m-d H:i:s");
    $nuevafecha = strtotime('-8 days', strtotime($hoy));
    $fecha1 = date('Y-m-d H:i:s', $nuevafecha);
    $this->mainModel->borrarexpirados($fecha1);
    $filtro = " AND solicitudes.paso = '8' AND solicitudes.asignado!='' ";
    if ($_SESSION["kt_login_level"] == 8) {
      $filtro = " AND (solicitudes.enviadoa LIKE '%Gerencia%' OR solicitudes.enviadoa LIKE '%Comite de credito%' OR (solicitudes.enviadoa = '' OR solicitudes.enviadoa IS NULL))";
    }
    if ($this->_getSanitizedParam('recientes') == 1) {
      //$filtro.= "  AND (solicitudes.validacion!='4' AND (solicitudes.estado_autorizo!='4' or solicitudes.estado_autorizo IS NULL)) ";
      //echo $filtro;
    }
    if ($_SESSION['kt_login_level'] == 3 or $_SESSION['kt_login_level'] == 12) { //analista
      $usuario = $_SESSION['kt_login_id'];
      if (($this->_getSanitizedParam('i') >= 0 and $this->_getSanitizedParam('i') != "") or $this->_getSanitizedParam('incompletas') == "1" or $this->_getSanitizedParam('sin_terminar') == "1") {
        if ($this->_getSanitizedParam('i') == 0) {
        }
      }
    }

    if ($this->_getSanitizedParam('i') != "") { //validacion
      $i = $this->_getSanitizedParam('i');

      $estado = $i;
      if ($i != "4" && $i != "5") {
        if ($i == "todas") {
        } else {
          $filtro .= "  AND solicitudes.validacion='$i' ";
        }
      }
      if ($i == "4") {
        $filtro .= " AND (solicitudes.validacion='$i' OR solicitudes.estado_autorizo='4') AND acepto_cambios!='2' AND vencimiento_aplazado!='1' AND vencimiento_aprobado!='1' ";
      }
      if ($i == "0") {

        $filtro .= " AND (solicitudes.validacion='0' AND solicitudes.estado_autorizo ='1') ";
      }
      if ($i == "5") {
        //echo "hola"; 
        $filtro .= " AND (solicitudes.validacion='0' AND solicitudes.estado_autorizo is NULL) ";
      }
      if ($i == "1") {
        //echo "hola"; 
        $filtro .= " AND ((confimar_solicitud=0 || confimar_solicitud is NULL) AND (acepto_cambios=0 || acepto_cambios is NULL) ) ";
      }
    }
    if ($this->_getSanitizedParam('incompletas') == "1") {
      $estado = "incompletas";
      $filtro = " AND solicitudes.validacion='3' AND (solicitudes.estado_autorizo = 0 or solicitudes.estado_autorizo is null ) AND vencimiento_aplazado!=1 AND vencimiento_aprobado!=1";
    }
    if ($this->_getSanitizedParam('sin_terminar') == "1") {
      $estado = "sin_terminar";
      $filtro = "  AND solicitudes.paso!='8' ";
    }
    if ($this->_getSanitizedParam('confirmadas_asociado') == "1") {
      $estado = "confirmadas_asociado";
      $filtro = "AND (confimar_solicitud='1' || acepto_cambios='1') AND solicitudes.validacion='1' AND estado_autorizo!='4' ";
    }
    if ($this->_getSanitizedParam('rechazadas_asociado') == "1") {
      $estado = "rechazadas_asociado";
      $filtro = "AND acepto_cambios='2' || vencimiento_aplazado=1 || vencimiento_aprobado=1 ";
    }
    if ($estado != "") {

      Session::getInstance()->set("estado", $estado);
    }

    $this->_view->slDevolucion = $this->mainModel->getList("validacion = '9'", "");

    if ($_GET['prueba'] == "1") {
      echo $filtro;
    }

    $title = "Administración de solicitudes";
    $this->getLayout()->setTitle($title);
    $this->_view->titlesection = $title;
    $this->filters();
    $this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
    $filters = (object)Session::getInstance()->get($this->namefilter);
    $this->_view->filters = $filters;
    $filters = $this->getFilter();
    $filters .= $filtro;
    //echo $filters;
    $order = " fecha_asignado DESC, fecha DESC ";
    if ($this->_getSanitizedParam('confirmadas_asociado') == "1") {
      $order = " fecha_aceptacion is NULL DESC, fecha_confimar_solicitud is NULL DESC ";
    }
    if ($this->_getSanitizedParam('i') == "1") {
      $order = " fecha_aprobado DESC ";
    }
    if ($this->_getSanitizedParam('i') == "7") {
      $order = " fecha_estado DESC ";
    }
    $list = $this->mainModel->getList($filters, $order);
    $amount = $this->pages;
    $page = $this->_getSanitizedParam("page");
    if (!$page && Session::getInstance()->get($this->namepageactual)) {
      $page = Session::getInstance()->get($this->namepageactual);
      $start = ($page - 1) * $amount;
    } else if (!$page) {
      $start = 0;
      $page = 1;
      Session::getInstance()->set($this->namepageactual, $page);
    } else {
      Session::getInstance()->set($this->namepageactual, $page);
      $start = ($page - 1) * $amount;
    }
    $this->_view->register_number = count($list);
    $this->_view->pages = $this->pages;
    $this->_view->totalpages = ceil(count($list) / $amount);
    $this->_view->page = $page;
    $lists = $this->_view->lists = $this->mainModel->getListPages($filters, $order, $start, $amount);
    $comiteModel = new Administracion_Model_DbTable_Comite();
    $usuarioModel = new Administracion_Model_DbTable_Usuario();
    // echo '<pre>';
    //   print_r($lists);
    // echo '</pre>';
    foreach ($lists as $value) {
      $id = $value->id;
      $tipo = 1;
      $value->quien_aprobo = "";
      $aprobado = count($comiteModel->getList(" comite_solicitud_id='$id' AND (comite_aprobacion='1' || comite_aprobacion='4') AND comite_tipo='$tipo' ", ""));
      if ($aprobado >= 2) {
        $value->quien_aprobo = "Comité de crédito";
      }
      $tipo = 3;
      $aprobado = count($comiteModel->getList(" comite_solicitud_id='$id' AND (comite_aprobacion='1' || comite_aprobacion='4') AND comite_tipo='$tipo' ", ""));
      if ($aprobado >= 3) {
        $value->quien_aprobo = "Junta directiva";
      }
      $tipo = 2;
      $aprobado = count($comiteModel->getList(" comite_solicitud_id='$id' AND (comite_aprobacion='1' || comite_aprobacion='4') AND comite_tipo='$tipo' ", ""));
      if ($aprobado >= 1) {
        $value->quien_aprobo = "Gerencia";
      }

      $quien = $value->quien;
      $quien_list = $usuarioModel->getById($quien);
      if ($quien_list->user_level == "3") {
        $value->quien_aprobo = "Analista";
      }

      $cedula = $value->cedula;
      $id = $value->id;
      $fecha = substr($value->fecha, 0, 7);
      $value->recientes = $this->mainModel->getList(" cedula='$cedula' AND paso='8' ", "");
    }
    $this->_view->lists = $lists;

    $this->_view->csrf_section = $this->_csrf_section;
    $this->_view->list_asignado = $this->getAsignado();
    $this->_view->list_regional = $this->getRegional();
    $this->_view->list_quien = $this->getQuien();
    $this->_view->list_estado_autorizo = $this->getEstadoautorizo();
    $this->_view->list_linea_desembolso = $this->getLineadesembolso();
    $this->_view->pagares_estado = $this->pagaresEstado();
    $pagareModel = new Page_Model_DbTable_Pagaredeceval();
    $pagare = count($pagareModel->getList("pagare='$id'", ""));
    $existe_pagare = false;
    if ($pagare > 0) {
      $existe_pagare = true;
    }
    $this->_view->existe_pagare = $existe_pagare;
    //echo $_SESSION["estado"];
    if ($_SESSION["estado"] != "" && !$this->_getSanitizedParam("recientes") && ($this->_getSanitizedParam('i') == "" and $this->_getSanitizedParam('confirmadas_asociado') == "" and $this->_getSanitizedParam('incompletas') == "" and $this->_getSanitizedParam('sin_terminar') == "" and $this->_getSanitizedParam('rechazadas_asociado') == "")) {

      if ($_SESSION["estado"] == "incompletas") {
        header('Location: /administracion/solicitudes/?incompletas=1');
      } else if ($_SESSION["estado"] == "confirmadas_asociado") {
        header('Location: /administracion/solicitudes/?confirmadas_asociado=1');
      } else if ($_SESSION["estado"] == "sin_terminar") {
        header('Location: /administracion/solicitudes/?sin_terminar=1');
      } else if ($_SESSION["estado"] == "rechazadas_asociado") {
        header('Location: /administracion/solicitudes/?rechazadas_asociado=1');
      } else {
        header('Location: /administracion/solicitudes/?i=' . $_SESSION["estado"] . '');
      }
    }
  }


  public function agregarcreditosAction()
  {

    $id = $this->_getSanitizedParam('id');
    $this->_view->id = $id;

    $this->_view->route = "/administracion/solicitudes/agregarcreditos";
    $filtro = " AND solicitudes.paso = '8' AND solicitudes.asignado!='' ";

    if ($_SESSION['kt_login_level'] == 3) { //analista
      $usuario = $_SESSION['kt_login_id'];
      if (($this->_getSanitizedParam('i') >= 0 and $this->_getSanitizedParam('i') != "") or $this->_getSanitizedParam('incompletas') == "1" or $this->_getSanitizedParam('sin_terminar') == "1") {
        $filtro .= " AND solicitudes.asignado='$usuario' ";
      }
    }
    if ($this->_getSanitizedParam('i') != "") { //validacion
      $i = $this->_getSanitizedParam('i');
      $filtro .= "  AND solicitudes.validacion='$i' ";
    }
    if ($this->_getSanitizedParam('incompletas') == "1") {
      $filtro = "  AND solicitudes.paso!='8' AND incompleta IS NOT NULL ";
    }
    if ($this->_getSanitizedParam('sin_terminar') == "1") {
      $filtro = "  AND solicitudes.paso!='8' AND incompleta IS NULL ";
    }


    $title = "Agregar solicitudes al acta No. " . $id;
    $this->getLayout()->setTitle($title);
    $this->_view->titlesection = $title;
    $this->filters();
    $this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
    $filters = (object)Session::getInstance()->get($this->namefilter);
    $this->_view->filters = $filters;
    $filters = $this->getFilter();
    $filters .= $filtro;
    $order = " fecha_asignado DESC, fecha DESC ";
    $list = $this->mainModel->getList($filters, $order);
    $amount = $this->pages;
    $page = $this->_getSanitizedParam("page");
    if (!$page && Session::getInstance()->get($this->namepageactual)) {
      $page = Session::getInstance()->get($this->namepageactual);
      $start = ($page - 1) * $amount;
    } else if (!$page) {
      $start = 0;
      $page = 1;
      Session::getInstance()->set($this->namepageactual, $page);
    } else {
      Session::getInstance()->set($this->namepageactual, $page);
      $start = ($page - 1) * $amount;
    }
    $this->_view->register_number = count($list);
    $this->_view->pages = $this->pages;
    $this->_view->totalpages = ceil(count($list) / $amount);
    $this->_view->page = $page;

    $this->_view->lists = $this->mainModel->getListPages($filters, $order, $start, $amount);

    $this->_view->csrf_section = $this->_csrf_section;
    $this->_view->list_asignado = $this->getAsignado();
    $this->_view->list_quien = $this->getQuien();
    $this->_view->list_estado_autorizo = $this->getEstadoautorizo();
    $this->_view->list_linea_desembolso = $this->getLineadesembolso();

    $actascomiteitemsModel = new Administracion_Model_DbTable_Actascomiteitems();
    $items = $actascomiteitemsModel->getList(" aci_acta_id='$id' ", "");
    foreach ($items as $key => $value) {
      $solicitud_id = $value->aci_solicitud_id;
      $value->solicitud = $this->mainModel->getById($solicitud_id);
    }
    $this->_view->items = $items;
  }

  /**
   * Genera la Informacion necesaria para editar o crear un  solicitud  y muestra su formulario
   *
   * @return void.
   */
  public function manageAction()
  {
    $this->_view->route = $this->route;
    $this->_csrf_section = "manage_solicitudes_" . date("YmdHis");
    $this->_csrf->generateCode($this->_csrf_section);
    $this->_view->csrf_section = $this->_csrf_section;
    $this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
    $this->_view->list_destino = $this->getDestino();
    $this->_view->list_linea_desembolso = $this->getLineadesembolso();
    $this->_view->list_gestor_comercial = $this->getGestorcomercial();
    $this->_view->list_asignado = $this->getAsignado();
    $this->_view->list_regional = $this->getRegional();
    $this->_view->list_quien = $this->getQuien();
    $this->_view->list_estado_autorizo = $this->getEstadoautorizo();
    $id = $this->_getSanitizedParam("id");
    if ($id > 0) {
      $content = $this->mainModel->getById($id);
      if ($content->id) {
        $this->_view->content = $content;
        $this->_view->routeform = $this->route . "/update";
        $title = "Actualizar solicitud";
        $this->getLayout()->setTitle($title);
        $this->_view->titlesection = $title;
      } else {
        $this->_view->routeform = $this->route . "/insert";
        $title = "Crear solicitud";
        $this->getLayout()->setTitle($title);
        $this->_view->titlesection = $title;
      }
    } else {
      $this->_view->routeform = $this->route . "/insert";
      $title = "Crear solicitud";
      $this->getLayout()->setTitle($title);
      $this->_view->titlesection = $title;
    }


    $lineaModel = new Administracion_Model_DbTable_Lineas();
    $this->_view->lineas = $lineaModel->getList("", " codigo*1 ASC ");
    $linea2 = $lineaModel->getList("codigo LIKE '%" . $content->linea . "%' ", " codigo*1 ASC ");
    $this->_view->min = $linea2[0]->min_meses;
    $this->_view->max = $linea2[0]->max_meses;
    $validaciones = array("En estudio", "Aprobado", "Contabilizado", "Anulado", "Rechazado", "Procesado");

    $validaciones[7] = "Cambio de condiciones";
    $validaciones[8] = "Pasar a desembolso";
    $this->_view->validaciones = $validaciones;


    $nomenclaturaModel = new Administracion_Model_DbTable_Nomenclatura();
    $this->_view->nomenclaturas = $nomenclaturas = $nomenclaturaModel->getList("", " codigo ASC ");

    $ciudadModel = new Administracion_Model_DbTable_Ciudad();
    $this->_view->ciudades = $ciudadModel->getList("", " nombre ASC ");
    $usuarioModel = new Administracion_Model_DbTable_Usuariosinfo();
    $usuario = $this->_view->usuario = $usuarioModel->getList("documento = '$content->cedula'", "")[0];
    $hoy = date("Y-m-d");
    $fecha_afiliacion = date("Y-m-d", strtotime($usuario->fecha_afiliacion));
    $date1 = new DateTime($hoy);
    $date2 = new DateTime($fecha_afiliacion);

    $diff = $date1->diff($date2);
    $meses = ($diff->y * 12) + $diff->m;
    // will output 2 days
    $this->_view->mes_diff =  $meses;

    $fecha_ingreso = date("Y-m-d", strtotime($usuario->fecha_afiliacion_koba));
    $date1 = new DateTime($hoy);
    $date2 = new DateTime($fecha_ingreso);

    $diff = $date1->diff($date2);
    $meses = ($diff->y * 12) + $diff->m;
    // will output 2 days
    $this->_view->mes_diff_ingreso =  $meses;
  }

  /**
   * Inserta la informacion de un solicitud  y redirecciona al listado de solicitudes.
   *
   * @return void.
   */
  public function insertAction()
  {
    $this->setLayout('blanco');
    $csrf = $this->_getSanitizedParam("csrf");
    if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf) {
      $data = $this->getData();
      $id = $this->mainModel->insert($data);
      $data['id'] = $id;
      $data['log_log'] = print_r($data, true);
      $data['log_tipo'] = 'CREAR SOLICITUD';
      $logModel = new Administracion_Model_DbTable_Log();
      $logModel->insert($data);
    }
    header('Location: ' . $this->route . '' . '');
  }



  /**
   * Recibe un identificador  y Actualiza la informacion de un solicitud  y redirecciona al listado de solicitudes.
   *
   * @return void.
   */
  public function updateAction()
  {
    $this->setLayout('blanco');
    $csrf = $this->_getSanitizedParam("csrf");
    $confirm_user = $this->_getSanitizedParam("confirm_user");
    if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf) {
      $id = $this->_getSanitizedParam("id");
      $content = $this->mainModel->getById($id);
      if ($content->id) {
        $data = $this->getData();
        $this->mainModel->update($data, $id);
        $this->mainModel->editField($id, "regional", $this->_getSanitizedParam("regional"));
        $content2 = $this->mainModel->getById($id);
        if ($content2->estado_autorizo != $this->_getSanitizedParam("estado_autorizo")) {
          $this->mainModel->editField($id, "fecha_autorizo", date("Y-m-d"));
        }
        if ($content2->validacion == 3 && $content2->estado_autorizo == 1) {
          $this->mainModel->editField($id, "validacion", 0);
        }
        if ($content2->validacion == 9 && $content2->estado_autorizo == 1) {
          $this->mainModel->editField($id, "validacion", 0);
        }
        if ($content2->estado_autorizo == 4) {
          $this->mainModel->editField($id, "validacion", 3);
        }
      }
      if ($confirm_user == 1) {
        if ($this->notificarUsuario($id)) {
          $this->mainModel->editField($id, "notificacion_enviada", 1);
        }
      }
      $hoy = date("Y-m-d H:i:s");
      //echo $content->estado_autorizo."<br>";
      //echo $this->_getSanitizedParam("estado_autorizo");
      if ($content->estado_autorizo != $this->_getSanitizedParam("estado_autorizo")) {
        if ($this->_getSanitizedParam("estado_autorizo") == 0) {
          $estado = "Pendiente";
        }
        if ($this->_getSanitizedParam("estado_autorizo") == 1) {
          $estado = "Revisado";
        }
        if ($this->_getSanitizedParam("estado_autorizo") == 4) {
          $estado = "Rechazado";
        }
        $logestado = new Administracion_Model_DbTable_Logestado();
        $dataestado["solicitud"] = $id;
        $dataestado["estado"] = $estado;
        $dataestado["usuario"] = $_SESSION["kt_login_id"];
        $dataestado["fecha"] = $hoy;
        $logestado->insert($dataestado);
      }
      //header("Location:/administracion/solicitudes/");

      $data['id'] = $id;
      $data['log_log'] = print_r($data, true);
      $data['log_tipo'] = 'EDITAR SOLICITUD';
      $logModel = new Administracion_Model_DbTable_Log();
      $logModel->insert($data);
    }
    header('Location: ' . $this->route . '' . '');
  }

  /**
   * Recibe un identificador  y elimina un solicitud  y redirecciona al listado de solicitudes.
   *
   * @return void.
   */
  public function deleteAction()
  {
    $this->setLayout('blanco');
    $csrf = $this->_getSanitizedParam("csrf");
    if (Session::getInstance()->get('csrf')[$this->_csrf_section] == $csrf) {
      $id =  $this->_getSanitizedParam("id");
      if (isset($id) && $id > 0) {
        $content = $this->mainModel->getById($id);
        if (isset($content)) {
          $this->mainModel->deleteRegister($id);
          $data = (array)$content;
          $data['log_log'] = print_r($data, true);
          $data['log_tipo'] = 'BORRAR SOLICITUD';
          $logModel = new Administracion_Model_DbTable_Log();
          $logModel->insert($data);
        }
      }
    }
    header('Location: ' . $this->route . '' . '');
  }

  /**
   * Recibe la informacion del formulario y la retorna en forma de array para la edicion y creacion de Solicitudes.
   *
   * @return array con toda la informacion recibida del formulario.
   */
  private function getData()
  {
    $data = array();
    $data['recoger_credito'] = $this->_getSanitizedParam("recoger_credito");
    $data['valor_recogidos'] = str_replace(".", "", $this->_getSanitizedParam("valor_recogidos"));
    $data['cedula'] = $this->_getSanitizedParam("documento");
    $data['cuota_prima'] = $this->_getSanitizedParam("cuota_prima");
    $data['cuota_prima_desembolso'] = $this->_getSanitizedParam("cuota_prima_desembolso");

    if ($this->_getSanitizedParam("linea") == '') {
      $data['linea'] = '0';
    } else {
      $data['linea'] = $this->_getSanitizedParam("linea");
    }
    $data['destino'] = $this->_getSanitizedParam("destino");
    if ($this->_getSanitizedParam("valor") == '') {
      $data['valor'] = '0';
    } else {
      $data['valor'] = str_replace(".", "", $this->_getSanitizedParam("valor"));
    }
    if ($this->_getSanitizedParam("monto_solicitado") == '') {
      $data['monto_solicitado'] = '0';
    } else {
      $data['monto_solicitado'] = $this->_getSanitizedParam("monto_solicitado");
    }
    $data['valor_desembolso'] = str_replace(".", "", $this->_getSanitizedParam("valor_desembolso"));
    if ($this->_getSanitizedParam("linea_desembolso") == '') {
      $data['linea_desembolso'] = '0';
    } else {
      $data['linea_desembolso'] = $this->_getSanitizedParam("linea_desembolso");
    }
    if ($this->_getSanitizedParam("cuotas_desembolso") == '') {
      $data['cuotas_desembolso'] = '0';
    } else {
      $data['cuotas_desembolso'] = $this->_getSanitizedParam("cuotas_desembolso");
    }
    if ($this->_getSanitizedParam("valor_cuota_desembolso") == '') {
      $data['valor_cuota_desembolso'] = '0';
    } else {
      $data['valor_cuota_desembolso'] = str_replace(".", "", $this->_getSanitizedParam("valor_cuota_desembolso"));
    }
    if ($this->_getSanitizedParam("tasa_desembolso") == '') {
      $data['tasa_desembolso'] = '0';
    } else {
      $data['tasa_desembolso'] = $this->_getSanitizedParam("tasa_desembolso");
    }
    if ($this->_getSanitizedParam("cuotas_extra_desembolso") == '') {
      $data['cuotas_extra_desembolso'] = '0';
    } else {
      $data['cuotas_extra_desembolso'] = $this->_getSanitizedParam("cuotas_extra_desembolso");
    }
    if ($this->_getSanitizedParam("valor_extra_desembolso") == '') {
      $data['valor_extra_desembolso'] = '0';
    } else {
      $data['valor_extra_desembolso'] = str_replace(".", "", $this->_getSanitizedParam("valor_extra_desembolso"));
    }
    if ($this->_getSanitizedParam("cuotas") == '') {
      $data['cuotas'] = '0';
    } else {
      $data['cuotas'] = $this->_getSanitizedParam("cuotas");
    }
    if ($this->_getSanitizedParam("valor_cuota") == '') {
      $data['valor_cuota'] = '0';
    } else {
      $data['valor_cuota'] = str_replace(".", "", $this->_getSanitizedParam("valor_cuota"));
    }
    if ($this->_getSanitizedParam("cuotas_extra") == '') {
      $data['cuotas_extra'] = '0';
    } else {
      $data['cuotas_extra'] = $this->_getSanitizedParam("cuotas_extra");
    }
    if ($this->_getSanitizedParam("valor_extra") == '') {
      $data['valor_extra'] = '0';
    } else {
      $data['valor_extra'] = str_replace(".", "", $this->_getSanitizedParam("valor_extra"));
    }
    if ($this->_getSanitizedParam("tasa") == '') {
      $data['tasa'] = '0';
    } else {
      $data['tasa'] = $this->_getSanitizedParam("tasa");
    }
    $data['fecha'] = $this->_getSanitizedParam("fecha");
    if ($this->_getSanitizedParam("validacion") == '') {
      $data['validacion'] = '0';
    } else {
      $data['validacion'] = $this->_getSanitizedParam("validacion");
    }
    $data['radicacion'] = $this->_getSanitizedParam("radicacion");
    $data['paso'] = $this->_getSanitizedParam("paso") * 1;
    $data['nombres'] = $this->_getSanitizedParam("nombres");
    $data['nombres2'] = $this->_getSanitizedParam("nombres2");
    $data['apellido1'] = $this->_getSanitizedParam("apellido1");
    $data['apellido2'] = $this->_getSanitizedParam("apellido2");
    $data['sexo'] = $this->_getSanitizedParam("sexo");
    $data['tipo_documento'] = $this->_getSanitizedParam("tipo_documento");
    $data['documento'] = $this->_getSanitizedParam("documento");
    $data['fecha_documento'] = $this->_getSanitizedParam("fecha_documento");
    $data['ciudad_documento'] = $this->_getSanitizedParam("ciudad_documento");
    $data['fecha_nacimiento'] = $this->_getSanitizedParam("fecha_nacimiento");
    $data['empresa'] = $this->_getSanitizedParam("empresa");
    $data['dependencia'] = $this->_getSanitizedParam("dependencia");
    $data['direccion_oficina'] = $this->_getSanitizedParam("direccion_oficina");
    $data['ciudad_oficina'] = $this->_getSanitizedParam("ciudad_oficina");
    $data['telefono_oficina'] = $this->_getSanitizedParam("telefono_oficina");
    $data['celular'] = $this->_getSanitizedParam("celular");
    $data['direccion_residencia'] = $this->_getSanitizedParam("direccion_residencia");
    $data['barrio'] = $this->_getSanitizedParam("barrio");
    $data['ciudad_residencia'] = $this->_getSanitizedParam("ciudad_residencia");
    $data['telefono'] = $this->_getSanitizedParam("telefono");
    $data['correo_empresarial'] = $this->_getSanitizedParam("correo_empresarial");
    $data['correo_personal'] = $this->_getSanitizedParam("correo_personal");
    $data['situacion_laboral'] = $this->_getSanitizedParam("situacion_laboral");
    $data['cual'] = $this->_getSanitizedParam("cual");
    $data['ocupacion'] = $this->_getSanitizedParam("ocupacion");
    $data['estado_civil'] = $this->_getSanitizedParam("estado_civil");
    $data['conyuge_nombre'] = $this->_getSanitizedParam("conyuge_nombre");
    $data['conyuge_telefono'] = $this->_getSanitizedParam("conyuge_telefono");
    $data['conyuge_celular'] = $this->_getSanitizedParam("conyuge_celular");
    $data['peso'] = $this->_getSanitizedParam("peso");
    $data['estatura'] = $this->_getSanitizedParam("estatura");
    $data['declara_renta'] = $this->_getSanitizedParam("declara_renta");
    $data['persona_publica'] = $this->_getSanitizedParam("persona_publica");
    $data['cuenta_numero'] = $this->_getSanitizedParam("cuenta_numero");
    $data['cuenta_tipo'] = $this->_getSanitizedParam("cuenta_tipo");
    $data['entidad_bancaria'] = $this->_getSanitizedParam("entidad_bancaria");
    $data['ingreso_mensual'] = $this->_getSanitizedParam("ingreso_mensual") * 1;
    $data['otros_ingresos'] = $this->_getSanitizedParam("otros_ingresos") * 1;
    $data['total_ingresos'] = $this->_getSanitizedParam("total_ingresos") * 1;
    $data['canon_arrendamiento'] = $this->_getSanitizedParam("canon_arrendamiento") * 1;
    $data['otros_gastos'] = $this->_getSanitizedParam("otros_gastos") * 1;
    $data['total_egresos'] = $this->_getSanitizedParam("total_egresos") * 1;
    $data['activos'] = $this->_getSanitizedParam("activos") * 1;
    $data['pasivos'] = $this->_getSanitizedParam("pasivos") * 1;
    $data['patrimonio'] = $this->_getSanitizedParam("patrimonio") * 1;
    $data['descripcion_ingresos'] = $this->_getSanitizedParam("descripcion_ingresos");
    $data['descripcion_recursos'] = $this->_getSanitizedParam("descripcion_recursos");
    $data['tipo_garantia'] = $this->_getSanitizedParam("tipo_garantia");
    $data['FM_meses'] = $this->_getSanitizedParam("FM_meses") * 1;
    $data['observaciones'] = $this->_getSanitizedParamHtml("observaciones");
    $data['observacion_analista'] = $this->_getSanitizedParamHtml("observacion_analista");
    $data['observacion_auxiliar'] = $this->_getSanitizedParamHtml("observacion_auxiliar");
    $data['observacion_riesgo'] = $this->_getSanitizedParamHtml("observacion_riesgo");
    $data['tramite'] = $this->_getSanitizedParam("tramite");
    $data['gestor_comercial'] = $this->_getSanitizedParam("gestor_comercial");
    if ($this->_getSanitizedParam("asignado") == '') {
      $data['asignado'] = '0';
    } else {
      $data['asignado'] = $this->_getSanitizedParam("asignado");
    }
    $data['fecha_asignado'] = $this->_getSanitizedParam("fecha_asignado");
    $data['pagare'] = $this->_getSanitizedParam("pagare");
    if ($this->_getSanitizedParam("quien") == '') {
      $data['quien'] = '0';
    } else {
      $data['quien'] = $this->_getSanitizedParam("quien");
    }
    $data['fecha_estado'] = $this->_getSanitizedParam("fecha_estado");
    $data['numero_obligacion'] = $this->_getSanitizedParam("numero_obligacion");
    $data['autorizo'] = $this->_getSanitizedParam("autorizo") * 1;
    $data['fecha_autorizo'] = '';
    if ($this->_getSanitizedParam("estado_autorizo") == '') {
      $data['estado_autorizo'] = '0';
    } else {
      $data['estado_autorizo'] = $this->_getSanitizedParam("estado_autorizo");
    }
    $data['incompleta'] = $this->_getSanitizedParam("incompleta");
    $data['fecha_anterior'] = $this->_getSanitizedParam("fecha_anterior");
    $data['asignado_anterior'] = $this->_getSanitizedParam("asignado_anterior") * 1;
    $data['frecuencia'] = $this->_getSanitizedParam("frecuencia");
    $data['capacidad_endeudamiento'] = $this->_getSanitizedParam("capacidad_endeudamiento");

    return $data;
  }

  /**
   * Genera los valores del campo destino.
   *
   * @return array cadena con los valores del campo destino.
   */
  private function getDestino()
  {
    $array = array();
    $array['VIVIENDA NUEVA'] = 'VIVIENDA NUEVA';
    $array['VIVIENDA NUEVA'] = 'VIVIENDA NUEVA';
    $array['MEJORA VIVIENDA'] = 'MEJORA VIVIENDA';
    $array['TIQUETES'] = 'TIQUETES';
    $array['OTROS DESTINOS'] = 'OTROS DESTINOS';
    return $array;
  }


  /**
   * Genera los valores del campo linea_desembolso.
   *
   * @return array cadena con los valores del campo linea_desembolso.
   */
  private function getLineadesembolso()
  {
    $array = array();
    $lineaModel = new Administracion_Model_DbTable_Lineas();
    $list = $lineaModel->getList("", " nombre ASC ");
    foreach ($list as $key => $value) {
      $array[$value->codigo] = $value->nombre;
    }
    return $array;
  }


  /**
   * Genera los valores del campo gestor_comercial.
   *
   * @return array cadena con los valores del campo gestor_comercial.
   */
  private function getGestorcomercial()
  {
    $array = array();
    $lineaModel = new Administracion_Model_DbTable_Gestores();
    $list = $lineaModel->getList("", " nombre ASC ");
    foreach ($list as $key => $value) {
      $array[$value->id] = $value->nombre;
    }
    return $array;
  }


  /**
   * Genera los valores del campo asignado.
   *
   * @return array cadena con los valores del campo asignado.
   */
  private function getAsignado()
  {
    $array = array();
    $lineaModel = new Administracion_Model_DbTable_Usuario();
    $list = $lineaModel->getList(" user_level='3' OR user_level='13' OR user_level='1'", " user_names ASC ");
    foreach ($list as $key => $value) {
      $array[$value->user_id] = $value->user_names;
    }
    return $array;
  }
  private function getRegional()
  {
    $array = array();
    $regionalModel = new Administracion_Model_DbTable_Regional();
    $list = $regionalModel->getList("", "nombre ASC");
    foreach ($list as $key => $value) {
      $array[$value->id] = $value->nombre;
    }
    return $array;
  }


  /**
   * Genera los valores del campo quien.
   *
   * @return array cadena con los valores del campo quien.
   */
  private function getQuien()
  {
    $array = array();
    $lineaModel = new Administracion_Model_DbTable_Usuario();
    $list = $lineaModel->getList("", " user_names ASC ");
    foreach ($list as $key => $value) {
      $array[$value->user_id] = $value->user_names;
    }
    return $array;
  }


  /**
   * Genera los valores del campo estado_autorizo.
   *
   * @return array cadena con los valores del campo estado_autorizo.
   */
  private function getEstadoautorizo()
  {
    $array = array();
    // $array['0'] = 'Pendiente';
    $array['1'] = 'Revisado';
    $array['4'] = 'Rechazado';
    return $array;
  }

  /**
   * Genera la consulta con los filtros de este controlador.
   *
   * @return array cadena con los filtros que se van a asignar a la base de datos
   */
  protected function getFilter()
  {
    $user_id = $_SESSION["kt_login_id"];
    $usuarioModel = new Administracion_Model_DbTable_Usuario();
    $user = $usuarioModel->getById($user_id);
    $regionales = $user->user_regional;

    $filtros = " 1 = 1 ";
    //if($regionales){
    //$regionales=explode(",", $regionales);
    //foreach ($regionales as $value) {
    //if($value === reset($regionales)){
    //$filtros = $filtros." AND (regional = $value";
    //}else if($value === end($regionales)){
    //$filtros = $filtros." OR regional = $value)";
    //}else{
    //$filtros = $filtros." OR regional = $value";
    //}
    //  }
    //}
    //echo $filtros;

    $documento = $this->_getSanitizedParam("documento");
    if ($documento != '') {
      $filtros = $filtros . " AND cedula LIKE '%" . $documento . "%'";
    }

    if (Session::getInstance()->get($this->namefilter) != "") {
      $filters = (object)Session::getInstance()->get($this->namefilter);
      if ($filters->cedula != '') {
        $filtros = $filtros . " AND cedula LIKE '%" . $filters->cedula . "%'";
      }
      if ($filters->linea != '') {
        $filtros = $filtros . " AND linea LIKE '%" . $filters->linea . "%'";
      }
      if ($filters->linea_desembolso != '') {
        $filtros = $filtros . " AND linea_desembolso LIKE '%" . $filters->linea_desembolso . "%'";
      }
      if ($filters->validacion != '') {
        $filtros = $filtros . " AND validacion LIKE '%" . $filters->validacion . "%'";
      }
      if ($filters->nombres != '') {
        $filtros = $filtros . " AND nombres LIKE '%" . $filters->nombres . "%'";
      }
      if ($filters->apellido1 != '') {
        $filtros = $filtros . " AND apellido1 LIKE '%" . $filters->apellido1 . "%'";
      }
      if ($filters->apellido2 != '') {
        $filtros = $filtros . " AND apellido2 LIKE '%" . $filters->apellido2 . "%'";
      }
      if ($filters->asignado != '') {
        $filtros = $filtros . " AND asignado ='" . $filters->asignado . "'";
      }
      if ($filters->fecha_asignado != '') {
        $filtros = $filtros . " AND fecha_asignado >= '" . $filters->fecha_asignado . "'";
      }
      if ($filters->fecha_asignado2 != '') {
        $filtros = $filtros . " AND fecha_asignado <= '" . $filters->fecha_asignado2 . "'";
      }      
      if ($filters->pagare != '') {
        $filtros = $filtros . " AND pagare LIKE '%" . $filters->pagare . "%'";
      }
      if ($filters->quien != '') {
        $filtros = $filtros . " AND quien ='" . $filters->quien . "'";
      }
      if ($filters->estado_autorizo != '') {
        $filtros = $filtros . " AND estado_autorizo ='" . $filters->estado_autorizo . "'";
      }
      if ($filters->regional != '') {
        $filtros = $filtros . " AND regional ='" . $filters->regional . "'";
      }
      // if ($filters->ente_aprobador != '') {
      //   $filtros = $filtros . " AND comite.comite_tipo ='" . $filters->ente_aprobador . "'";
      // }
      if($filters->ente_aprobador == 'Analista'){
        $filtros = $filtros . " AND (solicitudes.enviadoa = '' OR solicitudes.enviadoa IS NULL)";
      }else if ($filters->ente_aprobador != '') {
        $filtros = $filtros . " AND enviadoa = '" . $filters->ente_aprobador . "'";
      }
      if ($filters->fecha_desembolso != '' && $filters->fecha_desembolso_final != '') {
        $inicio = DateTime::createFromFormat('Y-m-d', $filters->fecha_desembolso);
        $fin = DateTime::createFromFormat('Y-m-d', $filters->fecha_desembolso_final);

        if ($inicio < $fin) {
          $intervalo = new DateInterval('P1D'); // Intervalo de 1 día
          $periodo = new DatePeriod($inicio, $intervalo, $fin->modify('+1 day'));
          $fechas = [];
          foreach ($periodo as $fecha) {
            $fechas[] = $fecha->format('Y-m-d');
          }
          $filtros = $filtros . " AND validacion = '2'";
          $filtros = $filtros . " AND ( ";
           foreach ($fechas as $key => $fecha) {
            if($key != 0){
              $filtros = $filtros . " OR ";
            }
            $filtros = $filtros . " fecha_desembolso LIKE '%" . $fecha . "%' ";
          }
          $filtros = $filtros . " )";
        }
      }
    }
    return $filtros;
  }

  /**
   * Recibe y asigna los filtros de este controlador
   *
   * @return void
   */
  protected function filters()
  {
    if ($this->getRequest()->isPost() == true) {
      Session::getInstance()->set($this->namepageactual, 1);
      $parramsfilter = array();
      $parramsfilter['cedula'] =  $this->_getSanitizedParam("cedula");
      $parramsfilter['linea'] =  $this->_getSanitizedParam("linea");
      $parramsfilter['linea_desembolso'] =  $this->_getSanitizedParam("linea_desembolso");
      $parramsfilter['validacion'] =  $this->_getSanitizedParam("validacion");
      $parramsfilter['nombres'] =  $this->_getSanitizedParam("nombres");
      $parramsfilter['apellido1'] =  $this->_getSanitizedParam("apellido1");
      $parramsfilter['apellido2'] =  $this->_getSanitizedParam("apellido2");
      $parramsfilter['asignado'] =  $this->_getSanitizedParam("asignado");
      $parramsfilter['fecha_asignado'] =  $this->_getSanitizedParam("fecha_asignado");
      $parramsfilter['fecha_asignado2'] =  $this->_getSanitizedParam("fecha_asignado2");
      $parramsfilter['pagare'] =  $this->_getSanitizedParam("pagare");
      $parramsfilter['quien'] =  $this->_getSanitizedParam("quien");
      $parramsfilter['estado_autorizo'] =  $this->_getSanitizedParam("estado_autorizo");
      $parramsfilter['regional'] =  $this->_getSanitizedParam("regional");
      $parramsfilter['ente_aprobador'] =  $this->_getSanitizedParam("ente_aprobador");
      $parramsfilter['fecha_desembolso'] =  $this->_getSanitizedParam("fecha_desembolso");
      $parramsfilter['fecha_desembolso_final'] =  $this->_getSanitizedParam("fecha_desembolso_final");
      Session::getInstance()->set($this->namefilter, $parramsfilter);
    }
    if ($this->_getSanitizedParam("cleanfilter") == 1) {
      Session::getInstance()->set($this->namefilter, '');
      Session::getInstance()->set($this->namepageactual, 1);
    }
  }

  public function detallepagareAction()
  {
    $id = $this->_getSanitizedParam("id");
    $solicitudesModel = new Administracion_Model_DbTable_Solicitudes();
    $solicitud = $solicitudesModel->getById($id);

    $pagare = $solicitud->pagare;
    $pagareModel = new Page_Model_DbTable_Pagaredeceval();
    $existe_pagare = $pagareModel->getList(" pagare='$pagare' ", "");

    $linea = $solicitud->linea;
    $lineaModel = new Administracion_Model_DbTable_Lineas();
    $linea_list = $lineaModel->getList(" codigo='$linea' ", "")[0];
    $modalidad = $linea . " - " . $linea_list->nombre;


    $nombres = $solicitud->nombres . " " . $solicitud->nombres2 . " " . $solicitud->apellido1 . " " . $solicitud->apellido2;

    $this->_view->solicitud = $solicitud;
    $this->_view->modalidad = $modalidad;
    $this->_view->nombres = $nombres;
    $this->_view->existe_pagare = $existe_pagare;
    $this->_view->id = $id;

    $numero = "WEB" . con_ceros($id);
    $this->_view->numero = $numero;
  }



  public function detalleAction()
  {
    $this->_view->route = $this->route;
    $this->_csrf_section = "manage_solicitudes_" . date("YmdHis");
    $this->_csrf->generateCode($this->_csrf_section);
    $this->_view->csrf_section = $this->_csrf_section;
    $this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];

    $id = $this->_getSanitizedParam("id");
    $solicitudModel = new Administracion_Model_DbTable_Solicitudes();
    $solicitud = $solicitudModel->getById($id);
    $this->_view->solicitud = $solicitud;
    if ($solicitud->tipo_garantia == 3) {
      $afianzafondosModel = new Administracion_Model_DbTable_Archivosafianzafondos();
      $this->_view->afianzafondos = $afianzafondosModel->getList("solicitud=$id", "")[0];
    }
    $codeudorModel = new Administracion_Model_DbTable_Codeudor();
    $this->_view->codeudor2 = $codeudorModel->getList(" solicitud='$id' AND codeudor_numero='2' ", "")[0];

    $documentosadicionalesModel = new Administracion_Model_DbTable_Documentosadicionales();
    $this->_view->adicionales = $documentosadicionalesModel->getList(" solicitud='$id' ", "");
  }

  public function incompletaAction()
  {

    $title = "Solicitud incompleta";
    $this->getLayout()->setTitle($title);
    $this->_view->titlesection = $title;
  }

  public function guardarincompletaAction()
  {
    $id = $this->_getSanitizedParam("id");
    $texto_incompleta = $this->_getSanitizedParamHtml("mensaje");
    $this->_view->estado = $estado = $this->_getSanitizedParam("estado");
    $solicitudModel = new Administracion_Model_DbTable_Solicitudes();
    $solicitud = $solicitudModel->getById($id);

    if ($estado == "4") {
      $solicitudModel->editField($id, "estado_autorizo", "4");
      $logestado = new Administracion_Model_DbTable_Logestado();
      $hora = date("H:i:s");
      $hoy = date("Y-m-d");
      $dataestado["solicitud"] = $id;
      $dataestado["estado"] = "Rechazado";
      $dataestado["usuario"] = $_SESSION["kt_login_id"];
      $dataestado["fecha"] = $hoy . " " . $hora;
      $id_estado = $logestado->insert($dataestado);
      $logestado->editField($id_estado, "observacion", $texto_incompleta);
    }

    $motivo = $texto_incompleta;
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

    $gestorModel = new Administracion_Model_DbTable_Gestores();
    $gestorcomercial = $gestorModel->getList(" nombre='$gestor_comercial' ", "")[0];

    $correo_gestor = $gestorcomercial->email;
    $correo_codeudor = "";

    if ($solicitud->tipo_garantia == "2") {
      $codeudorModel = new Administracion_Model_DbTable_Codeudor();
      $codeudor = $codeudorModel->getList(" solicitud='$id' ", "")[0];

      $correo_codeudor = $codeudor->correo;
      $correo_codeudor2 = $codeudor->correo_empresarial;
    }

    $correo_personal = $solicitud->correo_personal;
    $correo_empresarial = $solicitud->correo_empresarial;


    if ($id != "") {

      $paso = 5;
      if ($solicitud->peso == "") {
        $paso = 1;
      }

      $solicitudModel->editField($id, "incompleta", $texto_incompleta);
      $solicitudModel->editField($id, "fecha_incompleta", date("Y-m-d"));
      $solicitudModel->editField($id, "validacion", 3);
      if ($estado == "2") {
        $logestado = new Administracion_Model_DbTable_Logestado();
        $hora = date("H:i:s");
        $hoy = date("Y-m-d");
        $dataestado["solicitud"] = $id;
        $dataestado["estado"] = "Aplazado";
        $dataestado["usuario"] = $_SESSION["kt_login_id"];
        $dataestado["fecha"] = $hoy . " " . $hora;
        $id_estado = $logestado->insert($dataestado);
        $logestado->editField($id_estado, "observacion", $texto_incompleta);
      }
      //$solicitudModel->editField($id,"asignado",0);

      if ($fecha_anterior == "") {
        $fecha_anterior = $solicitud->fecha_asignado;
        $solicitudModel->editField($id, "fecha_anterior", $fecha_anterior);
        $solicitudModel->editField($id, "asignado_anterior", $asignado_anterior);
      }
    }
    $nombre = $solicitud->nombres;
    if ($solicitud->nombres2) {
      $nombre = $nombre . " " . $solicitud->nombres2;
    }
    $nombre = $nombre . " " . $solicitud->apellido1;
    if ($solicitud->apellido2) {
      $nombre = $nombre . " " . $solicitud->apellido2;
    }
    $numero = con_ceros($id);
    $correo1 = $analista->user_email;

    $linea = $solicitud->linea;
    $linea2 = $solicitud->linea_desembolso;
    $lineaModel = new Administracion_Model_DbTable_Lineas();
    $lineas = $lineaModel->getList(" codigo='$linea' ", "")[0];
    $lineas2 = $lineaModel->getList(" codigo='$linea2' ", "")[0];
    $hash = md5($solicitud->cedula . "F0nK");
    $tabla = $this->generartabla($numero, $usuario, $solicitud, $lineas, $analista, $lineas2);
    $contenido = $tabla;
    //2024-02-16 no agregar tabla en el mensaje
    $contenido="";

    /*
      $mensaje = "
      <br>
      La solicitud WEB".$numero." esta incompleta.<br /><br />Motivo: ".$motivo."<br /><br />Puede revisar su solicitud en el botón <strong>Mis solicitudes</strong> y enviarla nuevamente despues de realizar la corrección.
      <br /><br />".$contenido;
      */


    $mensaje = "
      
      Estimado(a) Asociado(a), la solicitud WEB" . $numero . " esta incompleta.<br /><br /><b>Motivo: </b>" . $motivo . "<br /><br />
      <span style='color: #dc3545;font-size: 16px;'>Ingrese al siguiente enlace para actualizar sus documentos <a href='https://creditosfondtodos.com.co/page/editarincompleta?id=" . $id . "&hash=" . $hash . "'>Clic aquí</a></span>
      <br /><br />" . $contenido . "<br><br>";
    $asunto = "Solicitud de crédito " . $numero . " - " . $nombre . " incompleta";
    $solicitudModel->editField($id, "documentos_actualizados", 0);

    if ($estado == "4") {
      $solicitudModel->editField($id, "validacion", 4);
      $mensaje = "
        
        Estimado(a) Asociado(a), la solicitud WEB" . $numero . " fue rechazada.<br /><br /><b>Motivo: </b>" . $motivo . "<br /><br />
        <br /><br />" . $contenido;
      $asunto = "Solicitud de crédito " . $numero . " - " . $nombre . " rechazada";
    }

    $content = $mensaje;

    $emailModel = new Core_Model_Mail();
    $emailModel->getMail()->setFrom("notificaciones@fondtodos.com", "Notificaciones Sistema Solicitud de créditos");
    $emailModel->getMail()->addBCC("desarrollo2@omegawebsystems.com");
    $emailModel->getMail()->addBCC("notificaciones@fondtodos.com");
    if ($correo_empresarial != "") {
      $emailModel->getMail()->addAddress("" . $correo_empresarial);
    }
    if ($correo_personal != "") {
      $emailModel->getMail()->addAddress("" . $correo_personal);
    }
    if ($correo1 != "") {
      $emailModel->getMail()->addBCC("" . $correo1);
      //$emailModel->getMail()->AddReplyTo("".$correo1);
    }

    //$emailModel->getMail()->addCC("servicio.asociado@fendesa.com");

    $emailModel->getMail()->Subject = $asunto;
    $emailModel->getMail()->msgHTML($content);
    $emailModel->getMail()->AltBody = $content;
    $emailModel->sed();
    $this->_view->error = $emailModel->getMail()->ErrorInfo;
  }

  function formato_pesos($x)
  {
    $res = number_format($x, 0, ',', '.');
    return $res;
  }

  function enviaracomiteAction()
  {

    $solicitudModel = new Administracion_Model_DbTable_Solicitudes();
    $id = $this->_getSanitizedParam("id");
    $this->_view->id = $id;
    $this->_view->numero = $numero = str_pad($id, 6, "0", STR_PAD_LEFT);
    $solicitud = $solicitudModel->getById($id);
    $nombre = $solicitud->nombres;
    if ($solicitud->nombres2) {
      $nombre = $nombre . " " . $solicitud->nombres2;
    }
    $nombre = $nombre . " " . $solicitud->apellido1;
    if ($solicitud->apellido2) {
      $nombre = $nombre . " " . $solicitud->apellido2;
    }
    $emailModel = new Core_Model_Mail();
    $asunto = "Solicitud aprobación comité de crédito WEB" . $numero . " - " . $nombre;
    $content = "<br>Estimado(a) usuario. la solicitud de crédito WEB" . $numero . " requiere de su aprobación: ";

    $solicitudModel = new Administracion_Model_DbTable_Solicitudes();
    $solicitud = $solicitudModel->getById($id);

    $linea = $solicitud->linea;
    $linea2 = $solicitud->linea_desembolso;
    $lineaModel = new Administracion_Model_DbTable_Lineas();
    $lineas = $lineaModel->getList(" codigo='$linea' ", "")[0];
    $lineas2 = $lineaModel->getList(" codigo='$linea2' ", "")[0];

    $usuarioModel = new Administracion_Model_DbTable_Usuario();
    $cedula = $solicitud->cedula;
    $usuario = $usuarioModel->getList(" user_user = '$cedula' ", "")[0];

    $analista_id = $solicitud->asignado;
    $analista = $usuarioModel->getById($analista_id);

    $gestor_comercial1 = $solicitud->gestor_comercial;
    $gestor_comercial = $usuarioModel->getList(" nombre = 'gestor_comercial' ", "")[0];


    $tabla = $this->generartabla($numero, $usuario, $solicitud, $lineas, $analista, $lineas2);

    $content .= $tabla;


    $userModel = new Administracion_Model_DbTable_Usuario();
    $aprobadores = $userModel->getList(" user_level='4' ", "");
    foreach ($aprobadores as $key => $value) {
      $email = $value->user_email;
      $user_id = $value->user_id;
      $codificado = base64_encode($user_id);
      $codificado = str_replace("=", "_", $codificado);

      //envio
      $content1 = $content . "<br><br><br>Por favor utilice el siguiente enlace para indicar su aprobación: <a href='https://creditosfondtodos.com.co/page/comite/?id=" . $id . "&e=" . $codificado . "'><button type='button' class='btn btn-primary' style='background:#0084C9; color:#FFFFFF; padding:5px 10px;'>Ingresar</button></a>";

      $emailModel->getMail()->ClearAllRecipients();
      $emailModel->getMail()->setFrom("notificaciones@fondtodos.com", "Notificaciones Sistema Solicitud de créditos");
      $emailModel->getMail()->addBCC("desarrollo2@omegawebsystems.com");
      $emailModel->getMail()->addBCC("notificaciones@fondtodos.com");
      $emailModel->getMail()->addAddress("" . $email);

      $emailModel->getMail()->Subject = $asunto;
      $emailModel->getMail()->msgHTML($content1);
      $emailModel->getMail()->AltBody = $content;
      if ($emailModel->sed()) {
        $solicitudModel->editField($id, "enviadoa", "Comité de crédito");
      }
      //envio
    }

    header("Location:/administracion/solicitudes/comiteenviado/");
  }



  function comiteenviadoAction()
  {
  }

  function formatocomiteAction()
  {
    $id = $this->_getSanitizedParam("id");
    $this->_view->numero = $numero = str_pad($id, 6, "0", STR_PAD_LEFT);
    $this->_view->id = $id;

    $solicitudModel = new Administracion_Model_DbTable_Solicitudes();
    $solicitud = $solicitudModel->getById($id);
    $this->_view->solicitud = $solicitud;

    $userModel = new Administracion_Model_DbTable_Usuario();

    $comiteModel = new Administracion_Model_DbTable_Comite();
    $comites = $comiteModel->getList(" comite_solicitud_id='$id' AND comite_tipo='1' ", "");
    foreach ($comites as $key => $value) {
      $user_id = $value->comite_user_id;
      $aprobador = $userModel->getById($user_id);
      $value->user_names = $aprobador->user_names;
    }

    $this->_view->comites = $comites;

    //tabla
    $cedula = $solicitud->cedula;
    $usuarioModel = new Administracion_Model_DbTable_Usuario();
    $usuario = $usuarioModel->getList(" user_user='$cedula' ", "")[0];
    $linea = $solicitud->linea;
    $linea2 = $solicitud->linea_desembolso;
    $lineaModel = new Administracion_Model_DbTable_Lineas();
    $lineas = $lineaModel->getList(" codigo='$linea' ", "")[0];
    $lineas2 = $lineaModel->getList(" codigo='$linea2' ", "")[0];
    $asignado = $solicitud->asignado;
    $analista = $usuarioModel->getById($asignado);
    $tabla = $this->generartabla($numero, $usuario, $solicitud, $lineas, $analista, $lineas2);
    $tabla = str_replace('style="max-width:900px;"', 'style="max-width:100%; background:#FFFFFF;"', $tabla);
    $this->_view->tabla = $tabla;
    $tabla2 = html_entity_decode($tabla);

    $excel = $this->_getSanitizedParam("excel");
    if ($excel == 1) {
      $this->setLayout('blanco');
      $hoy = date("YmdHis");
      header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
      header("Content-type:   application/x-msexcel; charset=utf-8");
      header("Content-Disposition: attachment; filename=formato_comite_ordinario_" . $id . ".xls");
    }

    $pdf = $this->_getSanitizedParam("pdf");
    if ($pdf == 1) {
      $this->setLayout("blanco");
      $titulo = "FORMATO DE APROBACIÓN COMITÉ ORDINARIO";
      $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'ISO-8859-1', false);
      $pdf->SetHeaderData('logo.png', 30, $codigo, $titulo);
      $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
      $pdf->setPrintFooter(false);

      // set default monospaced font
      $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

      // set margins
      $pdf->SetMargins(PDF_MARGIN_LEFT, 40, PDF_MARGIN_RIGHT);
      $pdf->SetHeaderMargin(10);

      // set auto page breaks
      $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

      // set image scale factor
      $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

      // set some language-dependent strings (optional)
      if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
        require_once(dirname(__FILE__) . '/lang/eng.php');
        $pdf->setLanguageArray($l);
      }

      //$pdf->SetProtection(array('print', 'copy'), '', null, 0, null);

      $fecha = $this->_view->comites[0]->comite_fecha;
      $fecha = substr($fecha, 0, 10);

      //$pdf->AddPage();
      $pdf->AddPage('L', 'A4');
      $pdf->SetFont('dejavusans', '', 8, '', true);

      $tabla = '
        <table width="100%" cellpadding="3" cellspacing="0" border="1">
          <tr>
            <td colspan="7">
              Fecha: ' . $fecha . '
            </td>
          </tr>
        </table>


        <div class="col-12">
          <table width="100%" cellpadding="3" cellspacing="0" border="1">
            <tr bgcolor="#CCCCCC">
              <th>APROBADOR</th>
              <th colspan="4">APROBO</th>
              <th>OBSERVACIONES</th>
              <th>FECHA</th>
              <th>FIRMA</th>
            </tr>
            <tr bgcolor="#CCCCCC">
              <th></th>
              <th><div align="center">SI</div></th>
              <th><div align="center">NO</div></th>
              <th><div align="center">APL</div></th>
              <th><div align="center">Cambio Condiciones</div></th>
              <th></th>
              <th></th>
              <th></th>
            </tr>';

      foreach ($comites as $key => $comite) {
        $aprobacion1 = '';
        if ($comite->comite_aprobacion == "1") {
          $aprobacion1 = '<b>X</b>';
        }
        $aprobacion2 = '';
        if ($comite->comite_aprobacion == "2") {
          $aprobacion2 = '<b>X</b>';
        }
        $aprobacion3 = '';
        if ($comite->comite_aprobacion == "3") {
          $aprobacion3 = '<b>X</b>';
        }
        if ($comite->comite_aprobacion == "4") {
          $aprobacion4 = '<b>X</b>';
        }
        $tabla .= '
              <tr>
                <td>' . html_entity_decode($comite->user_names) . '</td>
                <td align="center">' . $aprobacion1 . '</td>
                <td align="center">' . $aprobacion2 . '</td>
                <td align="center">' . $aprobacion3 . '</td>
                <td align="center">' . $aprobacion4 . '</td>
                <td>' . html_entity_decode($comite->comite_observacion) . '</td>
                <td>' . $comite->comite_fecha . '</td>
                <td>' . $comite->firma . '</td>
              </tr></table>';
      }

      $tabla .= '


          <div class="col-12"><br></div>
          <div class="col-12">
            <h5>Información Bancaria (Para desembolso)</h5>
            <table width="100%" cellpadding="3" cellspacing="0" border="1" bgcolor="#FFFFFF">
              <tr>
                <td><div align="center"><b>Cuenta Bancaria No</b></div></td>
                <td><div align="center"><b>Tipo de cuenta</b></div></td>
                <td><div align="center"><b>Entidad bancaria</b></div></td>
              </tr>
              <tr>
                <td><div align="center">' . $solicitud->cuenta_numero . '</div></td>
                <td><div align="center">' . $solicitud->cuenta_tipo . '</div></td>
                <td><div align="center">' . $solicitud->entidad_bancaria . '</div></td>
              </tr>
            </table>
          </div>


        ';

      $tabla .= $tabla2;

      if ($solicitud->observaciones != "") {
        $observacion1 = $solicitud->observaciones;
      } else {
        $observacion1 = 'Ninguna';
      }
      if ($solicitud->observacion_analista != "") {
        $observacion2 = $solicitud->observacion_analista;
      } else {
        $observacion2 = 'Ninguna';
      }

      $observacion1 = html_entity_decode($observacion1);

      $tabla .= '
          <div class="col-12">
            <br>
            <b>Observación del asociado</b>
            ' . $observacion1 . '
          </div>
          <div class="col-12">
            <b>Observación del analista</b>
            ' . $observacion2 . '
          </div>
        ';

      $pdf->writeHTMLCell(0, 0, '', '', $tabla, 0, 1, 0, true, '', true);
      ob_end_clean();
      $pdf->Output('reporte.pdf', 'I');
    }
  }

  function enviaracomiteespecialAction()
  {

    $solicitudModel = new Administracion_Model_DbTable_Solicitudes();
    $id = $this->_getSanitizedParam("id");
    $this->_view->id = $id;
    $this->_view->numero = $numero = str_pad($id, 6, "0", STR_PAD_LEFT);
    $solicitud = $solicitudModel->getById($id);
    $nombre = $solicitud->nombres;
    if ($solicitud->nombres2) {
      $nombre = $nombre . " " . $solicitud->nombres2;
    }
    $nombre = $nombre . " " . $solicitud->apellido1;
    if ($solicitud->apellido2) {
      $nombre = $nombre . " " . $solicitud->apellido2;
    }
    $emailModel = new Core_Model_Mail();
    $asunto = " Solicitud aprobación Junta Directiva WEB" . $numero . " - " . $nombre;
    $content = "<br>Estimado(a) usuario. la solicitud de crédito WEB" . $numero . " requiere de su aprobación: ";

    $solicitudModel = new Administracion_Model_DbTable_Solicitudes();
    $solicitud = $solicitudModel->getById($id);
    $linea = $solicitud->linea;
    $linea2 = $solicitud->linea_desembolso;
    $lineaModel = new Administracion_Model_DbTable_Lineas();
    $lineas = $lineaModel->getList(" codigo='$linea' ", "")[0];
    $lineas2 = $lineaModel->getList(" codigo='$linea2' ", "")[0];

    $usuarioModel = new Administracion_Model_DbTable_Usuario();
    $cedula = $solicitud->cedula;
    $usuario = $usuarioModel->getList(" user_user = '$cedula' ", "")[0];

    $analista_id = $solicitud->asignado;
    $analista = $usuarioModel->getById($analista_id);

    $gestor_comercial1 = $solicitud->gestor_comercial;
    $gestor_comercial = $usuarioModel->getList(" nombre = 'gestor_comercial' ", "")[0];


    $tabla = $this->generartabla($numero, $usuario, $solicitud, $lineas, $analista, $lineas2);

    $content .= $tabla;


    $userModel = new Administracion_Model_DbTable_Usuario();
    $aprobadores = $userModel->getList(" user_level='9' ", "");
    foreach ($aprobadores as $key => $value) {
      $email = $value->user_email;
      $user_id = $value->user_id;
      $codificado = base64_encode($user_id);
      $codificado = str_replace("=", "_", $codificado);

      //envio
      $content1 = $content . "<br><br><br>Por favor utilice el siguiente enlace para indicar su aprobación: <a href='https://creditosfondtodos.com.co/page/comiteespecial/?id=" . $id . "&e=" . $codificado . "'><button type='button' class='btn btn-primary' style='background:#0084C9; color:#FFFFFF; padding:5px 10px;'>Ingresar</button></a>";

      $emailModel->getMail()->ClearAllRecipients();
      $emailModel->getMail()->setFrom("notificaciones@fondtodos.com", "Notificaciones FONDTODOS");
      $emailModel->getMail()->addBCC("desarrollo2@omegawebsystems.com");
    $emailModel->getMail()->addBCC("notificaciones@fondtodos.com");
      $emailModel->getMail()->addAddress("" . $email);

      $emailModel->getMail()->Subject = $asunto;
      $emailModel->getMail()->msgHTML($content1);
      $emailModel->getMail()->AltBody = $content;
      if ($emailModel->sed() == true) {
        $solicitudModel->editField($id, "enviadoa", "Junta directiva");
        //echo "envio";

      } else {

        //echo "no envio";
      }
      //envio
    }


    header("Location:/administracion/solicitudes/comiteespecialenviado/");
  }



  function comiteespecialenviadoAction()
  {
  }

  function formatocomiteespecialAction()
  {
    $id = $this->_getSanitizedParam("id");
    $this->_view->numero  = $numero = str_pad($id, 6, "0", STR_PAD_LEFT);
    $this->_view->id = $id;

    $solicitudModel = new Administracion_Model_DbTable_Solicitudes();
    $solicitud = $solicitudModel->getById($id);
    $this->_view->solicitud = $solicitud;

    $userModel = new Administracion_Model_DbTable_Usuario();

    $comiteModel = new Administracion_Model_DbTable_Comite();
    $comites = $comiteModel->getList(" comite_solicitud_id='$id' AND comite_tipo='3' ", "");
    foreach ($comites as $key => $value) {
      $user_id = $value->comite_user_id;
      $aprobador = $userModel->getById($user_id);
      $value->user_names = $aprobador->user_names;
    }

    $this->_view->comites = $comites;


    //tabla
    $cedula = $solicitud->cedula;
    $usuarioModel = new Administracion_Model_DbTable_Usuario();
    $usuario = $usuarioModel->getList(" user_user='$cedula' ", "")[0];
    $linea = $solicitud->linea;
    $linea2 = $solicitud->linea_desembolso;
    $lineaModel = new Administracion_Model_DbTable_Lineas();
    $lineas = $lineaModel->getList(" codigo='$linea' ", "")[0];
    $lineas2 = $lineaModel->getList(" codigo='$linea2' ", "")[0];
    $asignado = $solicitud->asignado;
    $analista = $usuarioModel->getById($asignado);
    $tabla = $this->generartabla($numero, $usuario, $solicitud, $lineas, $analista, $lineas2);
    $tabla = str_replace('style="max-width:900px;"', 'style="max-width:100%; background:#FFFFFF;"', $tabla);
    $this->_view->tabla = $tabla;
    $tabla2 = html_entity_decode($tabla);

    $excel = $this->_getSanitizedParam("excel");
    if ($excel == 1) {
      $this->setLayout('blanco');
      $hoy = date("YmdHis");
      header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
      header("Content-type:   application/x-msexcel; charset=utf-8");
      header("Content-Disposition: attachment; filename=formato_comite_especial_" . $id . ".xls");
    }

    $pdf = $this->_getSanitizedParam("pdf");
    if ($pdf == 1) {
      $this->setLayout("blanco");
      $titulo = "FORMATO DE APROBACIÓN COMITÉ ESPECIAL";
      $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'ISO-8859-1', false);
      $pdf->SetHeaderData('Logo.png', 30, $codigo, $titulo);
      $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
      $pdf->setPrintFooter(false);

      // set default monospaced font
      $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

      // set margins
      $pdf->SetMargins(PDF_MARGIN_LEFT, 40, PDF_MARGIN_RIGHT);
      $pdf->SetHeaderMargin(10);

      // set auto page breaks
      $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

      // set image scale factor
      $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

      // set some language-dependent strings (optional)
      if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
        require_once(dirname(__FILE__) . '/lang/eng.php');
        $pdf->setLanguageArray($l);
      }

      //$pdf->SetProtection(array('print', 'copy'), '', null, 0, null);


      $fecha = $this->_view->comites[0]->comite_fecha;
      $fecha = substr($fecha, 0, 10);

      //$pdf->AddPage();
      $pdf->AddPage('L', 'A4');
      $pdf->SetFont('dejavusans', '', 8, '', true);

      $tabla = '
        <table width="100%" cellpadding="3" cellspacing="0" border="0">
          <tr>
            <td colspan="7">
              Fecha: ' . $fecha . '
            </td>
          </tr>
        </table>


        <div class="col-12">
          <table width="100%" cellpadding="3" cellspacing="0" border="1">
            <tr bgcolor="#CCCCCC">
              <th>APROBADOR</th>
              <th colspan="4">APROBO</th>
              <th>OBSERVACIONES</th>
              <th>FECHA</th>
              <th>FIRMA</th>
            </tr>
            <tr bgcolor="#CCCCCC">
              <th></th>
              <th><div align="center">SI</div></th>
              <th><div align="center">NO</div></th>
              <th><div align="center">APL</div></th>
              <th><div align="center">Cambio Condiciones</div></th>
              <th></th>
              <th></th>
              <th></th>
            </tr>';

      foreach ($comites as $key => $comite) {
        $aprobacion1 = '';
        if ($comite->comite_aprobacion == "1") {
          $aprobacion1 = '<b>X</b>';
        }
        $aprobacion2 = '';
        if ($comite->comite_aprobacion == "2") {
          $aprobacion2 = '<b>X</b>';
        }
        $aprobacion3 = '';
        if ($comite->comite_aprobacion == "3") {
          $aprobacion3 = '<b>X</b>';
        }
        if ($comite->comite_aprobacion == "4") {
          $aprobacion4 = '<b>X</b>';
        }
        $tabla .= '
              <tr>
                <td>' . html_entity_decode($comite->user_names) . '</td>
                <td align="center">' . $aprobacion1 . '</td>
                <td align="center">' . $aprobacion2 . '</td>
                <td align="center">' . $aprobacion3 . '</td>
                <td align="center">' . $aprobacion4 . '</td>
                <td>' . html_entity_decode($comite->comite_observacion) . '</td>
                <td>' . $comite->comite_fecha . '</td>
                <td>' . $comite->firma . '</td>
              </tr>';
      }
      $tabla .= '
            <tr>
              <td colspan="7">
                <div style="font-size: 11px;">Nota: A partir de la fecha para la aprobación de la solicitud de crédito es requisito NECESARIO NO estar reportado en la centrales de riesgo con cartera morosa de más de 90 dias y NO tener cartera castigada, salvo que se adjunten los respectivos paz y salvos expedidos por las entidades que generaron el reporte, con una antigüedad no mayor a 30 dias.</div>
              </td>
            </tr>
          </table>
        </div>
        ';

      $tabla .= '


          <div class="col-12"><br></div>
          <div class="col-12">
            <h5>Información Bancaria (Para desembolso)</h5>
            <table width="100%" cellpadding="3" cellspacing="0" border="1" bgcolor="#FFFFFF">
              <tr>
                <td><div align="center"><b>Cuenta Bancaria No</b></div></td>
                <td><div align="center"><b>Tipo de cuenta</b></div></td>
                <td><div align="center"><b>Entidad bancaria</b></div></td>
              </tr>
              <tr>
                <td><div align="center">' . $solicitud->cuenta_numero . '</div></td>
                <td><div align="center">' . $solicitud->cuenta_tipo . '</div></td>
                <td><div align="center">' . $solicitud->entidad_bancaria . '</div></td>
              </tr>
            </table>
          </div>


        ';

      $tabla .= $tabla2;

      if ($solicitud->observaciones != "") {
        $observacion1 = $solicitud->observaciones;
      } else {
        $observacion1 = 'Ninguna';
      }
      if ($solicitud->observacion_analista != "") {
        $observacion2 = $solicitud->observacion_analista;
      } else {
        $observacion2 = 'Ninguna';
      }

      $observacion1 = html_entity_decode($observacion1);

      $tabla .= '
          <div class="col-12">
            <br>
            <b>Observación del asociado</b>
            ' . $observacion1 . '
          </div>
          <div class="col-12">
            <b>Observación del analista</b>
            ' . $observacion2 . '
          </div>
        ';

      $pdf->writeHTMLCell(0, 0, '', '', $tabla, 0, 1, 0, true, '', true);
      ob_end_clean();
      $pdf->Output('reporte.pdf', 'I');
    }
  }

  function enviaragerenciaAction()
  {

    $solicitudModel = new Administracion_Model_DbTable_Solicitudes();
    $id = $this->_getSanitizedParam("id");
    $this->_view->id = $id;
    $this->_view->numero = $numero = str_pad($id, 6, "0", STR_PAD_LEFT);
    $solicitud = $solicitudModel->getById($id);
    if ($solicitud->validacion == '9') {
      $solicitudModel->editField($id, "validacion", "0");
    }
    $nombre = $solicitud->nombres;
    if ($solicitud->nombres2) {
      $nombre = $nombre . " " . $solicitud->nombres2;
    }
    $nombre = $nombre . " " . $solicitud->apellido1;
    if ($solicitud->apellido2) {
      $nombre = $nombre . " " . $solicitud->apellido2;
    }
    $emailModel = new Core_Model_Mail();
    $asunto = " Solicitud aprobación de crédito WEB" . $numero . " - " . $nombre;
    $content = "<br>Estimado(a) usuario. la solicitud de crédito WEB" . $numero . " requiere de su aprobación: ";

    $solicitudModel = new Administracion_Model_DbTable_Solicitudes();
    $solicitud = $solicitudModel->getById($id);

    $linea = $solicitud->linea;
    $linea2 = $solicitud->linea_desembolso;
    $lineaModel = new Administracion_Model_DbTable_Lineas();
    $lineas = $lineaModel->getList(" codigo='$linea' ", "")[0];
    $lineas2 = $lineaModel->getList(" codigo='$linea2' ", "")[0];

    $usuarioModel = new Administracion_Model_DbTable_Usuario();
    $cedula = $solicitud->cedula;
    $usuario = $usuarioModel->getList(" user_user = '$cedula' ", "")[0];

    $analista_id = $solicitud->asignado;
    $analista = $usuarioModel->getById($analista_id);

    $gestor_comercial1 = $solicitud->gestor_comercial;
    $gestor_comercial = $usuarioModel->getList(" nombre = 'gestor_comercial' ", "")[0];

    $tabla = $this->generartabla($numero, $usuario, $solicitud, $lineas, $analista, $lineas2);

    $content .= $tabla;


    $userModel = new Administracion_Model_DbTable_Usuario();
    $aprobadores = $userModel->getList(" user_level='8' ", "");
    foreach ($aprobadores as $key => $value) {
      $email = $value->user_email;
      $user_id = $value->user_id;
      $codificado = base64_encode($user_id);
      $codificado = str_replace("=", "_", $codificado);
      $f = md5(microtime());

      //envio
      $content1 = $content . "<br><br><br>Por favor utilice el siguiente enlace para indicar su aprobación: <a href='https://creditosfondtodos.com.co/page/gerencia/?id=" . $id . "&e=" . $codificado . "&f=".$f."'><button type='button' class='btn btn-primary' style='background:#0084C9; color:#FFFFFF; padding:5px 10px;'>Ingresar</button></a>";

      $emailModel->getMail()->ClearAllRecipients();
      //$emailModel->getMail()->setFrom("notificaciones@fondtodos.com", "Notificaciones FONDTODOS");
      $emailModel->getMail()->addBCC("desarrollo2@omegawebsystems.com");
    $emailModel->getMail()->addBCC("notificaciones@fondtodos.com");
      //$emailModel->getMail()->addBCC("soporteomega@omegawebsystems.com");
      //$emailModel->getMail()->addBCC("cristianreyes84@gmail.com");
      if ($email != "") {
        $emailModel->getMail()->addAddress("" . $email);
      }

      $emailModel->getMail()->Subject = $asunto;
      $emailModel->getMail()->msgHTML($content1);
      $emailModel->getMail()->AltBody = $content;
      if ($emailModel->sed()) {
        $solicitudModel->editField($id, "enviadoa", "Gerencia");
      }
      //envio
    }

    header("Location:/administracion/solicitudes/gerenciaenviado/");
  }

  function gerenciaenviadoAction()
  {
  }

  function formatogerenciaAction()
  {
    $id = $this->_getSanitizedParam("id");
    $this->_view->numero = $numero =  str_pad($id, 6, "0", STR_PAD_LEFT);
    $this->_view->id = $id;

    $solicitudModel = new Administracion_Model_DbTable_Solicitudes();
    $solicitud = $solicitudModel->getById($id);
    $this->_view->solicitud = $solicitud;

    $userModel = new Administracion_Model_DbTable_Usuario();

    $comiteModel = new Administracion_Model_DbTable_Comite();
    $comites = $comiteModel->getList(" comite_solicitud_id='$id' AND comite_tipo='2' ", "");
    foreach ($comites as $key => $value) {
      $user_id = $value->comite_user_id;
      $aprobador = $userModel->getById($user_id);
      $value->user_names = $aprobador->user_names;
    }

    $this->_view->comites = $comites;

    //tabla
    $cedula = $solicitud->cedula;
    $usuarioModel = new Administracion_Model_DbTable_Usuario();
    $usuario = $usuarioModel->getList(" user_user='$cedula' ", "")[0];
    $linea = $solicitud->linea;
    $linea2 = $solicitud->linea_desembolso;
    $lineaModel = new Administracion_Model_DbTable_Lineas();
    $lineas = $lineaModel->getList(" codigo='$linea' ", "")[0];
    $lineas2 = $lineaModel->getList(" codigo='$linea2' ", "")[0];
    $asignado = $solicitud->asignado;
    $analista = $usuarioModel->getById($asignado);
    $tabla = $this->generartabla($numero, $usuario, $solicitud, $lineas, $analista, $lineas2);
    $tabla = str_replace('style="max-width:900px;"', 'style="max-width:100%; background:#FFFFFF;"', $tabla);
    $this->_view->tabla = $tabla;
    $tabla2 = html_entity_decode($tabla);


    $excel = $this->_getSanitizedParam("excel");
    if ($excel == 1) {
      $this->setLayout('blanco');
      $hoy = date("YmdHis");
      header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
      header("Content-type:   application/x-msexcel; charset=utf-8");
      header("Content-Disposition: attachment; filename=formato_comite_" . $id . ".xls");
    }

    $pdf = $this->_getSanitizedParam("pdf");
    if ($pdf == 1) {
      $this->setLayout("blanco");
      $titulo = "FORMATO DE APROBACIÓN GERENCIA";
      $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'ISO-8859-1', false);
      //$pdf->SetHeaderData('Logo.png', 30,$codigo,$titulo);
      //$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
      //$pdf->setPrintFooter(false);

      // set default monospaced font
      $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

      // set margins
      $pdf->SetMargins(PDF_MARGIN_LEFT, 40, PDF_MARGIN_RIGHT);
      $pdf->SetHeaderMargin(10);

      // set auto page breaks
      $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

      // set image scale factor
      $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

      // set some language-dependent strings (optional)
      if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
        require_once(dirname(__FILE__) . '/lang/eng.php');
        $pdf->setLanguageArray($l);
      }

      //$pdf->SetProtection(array('print', 'copy'), '', null, 0, null);


      $fecha = $this->_view->comites[0]->comite_fecha;
      $fecha = substr($fecha, 0, 10);

      //$pdf->AddPage();
      $pdf->AddPage('L', 'A4');
      $pdf->SetFont('dejavusans', '', 8, '', true);

      $tabla = '
        <table width="100%" cellpadding="3" cellspacing="0" border="0">
          <tr>
            <td colspan="7">
              Fecha: ' . $fecha . '
            </td>
          </tr>
        </table>


        <div class="col-12">
          <table width="100%" cellpadding="3" cellspacing="0" border="1">
            <tr bgcolor="#CCCCCC">
              <th>APROBADOR</th>
              <th colspan="4">APROBO</th>
              <th>OBSERVACIONES</th>
              <th>FECHA</th>
              <th>FIRMA</th>
            </tr>
            <tr bgcolor="#CCCCCC">
              <th></th>
              <th><div align="center">SI</div></th>
              <th><div align="center">NO</div></th>
              <th><div align="center">APL</div></th>
              <th><div align="center">Cambio Condiciones</div></th>
              <th></th>
              <th></th>
              <th></th>
            </tr>';

      foreach ($comites as $key => $comite) {
        $aprobacion1 = '';
        if ($comite->comite_aprobacion == "1") {
          $aprobacion1 = '<b>X</b>';
        }
        $aprobacion2 = '';
        if ($comite->comite_aprobacion == "2") {
          $aprobacion2 = '<b>X</b>';
        }
        $aprobacion3 = '';
        if ($comite->comite_aprobacion == "3") {
          $aprobacion3 = '<b>X</b>';
        }
        if ($comite->comite_aprobacion == "4") {
          $aprobacion4 = '<b>X</b>';
        }
        $tabla .= '
              <tr>
                <td>' . html_entity_decode($comite->user_names) . '</td>
                <td align="center">' . $aprobacion1 . '</td>
                <td align="center">' . $aprobacion2 . '</td>
                <td align="center">' . $aprobacion3 . '</td>
                <td align="center">' . $aprobacion4 . '</td>
                <td>' . html_entity_decode($comite->comite_observacion) . '</td>
                <td>' . $comite->comite_fecha . '</td>
                <td>' . $comite->firma . '</td>
              </tr>';
      }
      $tabla .= '
            
          </table>
        </div>
        ';

      $tabla .= '
          <div class="col-12"><br></div>
          <div class="col-12">
            <h5>Información Bancaria (Para desembolso)</h5>
            <table width="100%" cellpadding="3" cellspacing="0" border="1" bgcolor="#FFFFFF">
              <tr>
                <td><div align="center"><b>Cuenta Bancaria No</b></div></td>
                <td><div align="center"><b>Tipo de cuenta</b></div></td>
                <td><div align="center"><b>Entidad bancaria</b></div></td>
              </tr>
              <tr>
                <td><div align="center">' . $solicitud->cuenta_numero . '</div></td>
                <td><div align="center">' . $solicitud->cuenta_tipo . '</div></td>
                <td><div align="center">' . $solicitud->entidad_bancaria . '</div></td>
              </tr>
            </table>
          </div>


        ';

      $tabla .= $tabla2;


      if ($solicitud->observaciones != "") {
        $observacion1 = $solicitud->observaciones;
      } else {
        $observacion1 = 'Ninguna';
      }
      if ($solicitud->observacion_analista != "") {
        $observacion2 = $solicitud->observacion_analista;
      } else {
        $observacion2 = 'Ninguna';
      }

      $observacion1 = html_entity_decode($observacion1);

      $tabla .= '
          <div class="col-12">
            <br>
            <b>Observación del asociado</b>
            ' . $observacion1 . '
          </div>
          <div class="col-12">
            <b>Observación del analista</b>
            ' . $observacion2 . '
          </div>
        ';

      //$pdf->AddPage('L', 'A4');

      $pdf->writeHTMLCell(0, 0, '', '', $tabla, 0, 1, 0, true, '', true);
      ob_end_clean();
      $pdf->Output('reporte.pdf', 'I');
    }
  }

  function formatoanalistaAction()
  {
    $id = $this->_getSanitizedParam("id");
    $this->_view->numero = $numero =  str_pad($id, 6, "0", STR_PAD_LEFT);
    $this->_view->id = $id;

    $solicitudModel = new Administracion_Model_DbTable_Solicitudes();
    $solicitud = $solicitudModel->getById($id);
    $this->_view->solicitud = $solicitud;

    $userModel = new Administracion_Model_DbTable_Usuario();

    $analista = $userModel->getById($solicitud->quien);
    $this->_view->analista = $analista;
    $aprobador = $analista;

    
      $comiteModel = new Administracion_Model_DbTable_Comite();
      $comites = $comiteModel->getList(" comite_solicitud_id='$id' AND comite_tipo='2' ","");
      foreach ($comites as $key => $value) {
        $user_id = $value->comite_user_id;
        $aprobador = $userModel->getById($user_id);
        $value->user_names = $aprobador->user_names;
      }

      $this->_view->comites = $comites;
      


    //tabla
    $cedula = $solicitud->cedula;
    $usuarioModel = new Administracion_Model_DbTable_Usuario();
    $usuario = $usuarioModel->getList(" user_user='$cedula' ", "")[0];
    $linea = $solicitud->linea;
    $linea2 = $solicitud->linea_desembolso;
    $lineaModel = new Administracion_Model_DbTable_Lineas();
    $lineas = $lineaModel->getList(" codigo='$linea' ", "")[0];
    $lineas2 = $lineaModel->getList(" codigo='$linea2' ", "")[0];
    $asignado = $solicitud->asignado;
    $analista = $usuarioModel->getById($asignado);
    $tabla = $this->generartabla($numero, $usuario, $solicitud, $lineas, $analista, $lineas2);
    $tabla = str_replace('style="max-width:900px;"', 'style="max-width:100%; background:#FFFFFF;"', $tabla);
    $this->_view->tabla = $tabla;
    $tabla2 = html_entity_decode($tabla);


    $excel = $this->_getSanitizedParam("excel");
    if ($excel == 1) {
      $this->setLayout('blanco');
      $hoy = date("YmdHis");
      header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
      header("Content-type:   application/x-msexcel; charset=utf-8");
      header("Content-Disposition: attachment; filename=formato_comite_" . $id . ".xls");
    }

    $pdf = $this->_getSanitizedParam("pdf");
    if ($pdf == 1) {
      $this->setLayout("blanco");
      $titulo = "FORMATO DE APROBACIÓN ANALISTA";
      $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'ISO-8859-1', false);
      //$pdf->SetHeaderData('Logo.png', 30,$codigo,$titulo);
      //$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
      //$pdf->setPrintFooter(false);

      // set default monospaced font
      $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

      // set margins
      $pdf->SetMargins(PDF_MARGIN_LEFT, 40, PDF_MARGIN_RIGHT);
      $pdf->SetHeaderMargin(10);

      // set auto page breaks
      $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

      // set image scale factor
      $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

      // set some language-dependent strings (optional)
      if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
        require_once(dirname(__FILE__) . '/lang/eng.php');
        $pdf->setLanguageArray($l);
      }

      //$pdf->SetProtection(array('print', 'copy'), '', null, 0, null);


      $fecha = $solicitud->fecha_aprobado;
      $fecha = substr($fecha, 0, 10);

      //$pdf->AddPage();
      $pdf->AddPage('L', 'A4');
      $pdf->SetFont('dejavusans', '', 8, '', true);

      $tabla = '
        <table width="100%" cellpadding="3" cellspacing="0" border="0">
          <tr>
            <td colspan="7">
              Fecha: ' . $fecha . '
            </td>
          </tr>
        </table>


        <div class="col-12">
          <table width="100%" cellpadding="3" cellspacing="0" border="1">
            <tr bgcolor="#CCCCCC">
              <th>APROBADOR</th>
              <th colspan="4">APROBO</th>
              <th>OBSERVACIONES</th>
              <th>FECHA</th>
              <th>FIRMA</th>
            </tr>
            <tr bgcolor="#CCCCCC">
              <th></th>
              <th><div align="center">SI</div></th>
              <th><div align="center">NO</div></th>
              <th><div align="center">APL</div></th>
              <th><div align="center">Cambio Condiciones</div></th>
              <th></th>
              <th></th>
              <th></th>
            </tr>';


      $aprobacion1 = '';
      if ($fecha != "") {
        $aprobacion1 = '<b>X</b>';
      }
      $tabla .= '
              <tr>
                <td>' . html_entity_decode($aprobador->user_names) . '</td>
                <td align="center">' . $aprobacion1 . '</td>
                <td align="center">' . $aprobacion2 . '</td>
                <td align="center">' . $aprobacion3 . '</td>
                <td align="center">' . $aprobacion4 . '</td>
                <td>' . html_entity_decode($comite->comite_observacion) . '</td>
                <td>' . $solicitud->fecha_aprobado . '</td>
                <td>' . $comite->firma . '</td>
              </tr>';

      $tabla .= '
            
          </table>
        </div>
        ';

      $tabla .= '
          <div class="col-12"><br></div>
          <div class="col-12">
            <h5>Información Bancaria (Para desembolso)</h5>
            <table width="100%" cellpadding="3" cellspacing="0" border="1" bgcolor="#FFFFFF">
              <tr>
                <td><div align="center"><b>Cuenta Bancaria No</b></div></td>
                <td><div align="center"><b>Tipo de cuenta</b></div></td>
                <td><div align="center"><b>Entidad bancaria</b></div></td>
              </tr>
              <tr>
                <td><div align="center">' . $solicitud->cuenta_numero . '</div></td>
                <td><div align="center">' . $solicitud->cuenta_tipo . '</div></td>
                <td><div align="center">' . $solicitud->entidad_bancaria . '</div></td>
              </tr>
            </table>
          </div>


        ';

      $tabla .= $tabla2;


      if ($solicitud->observaciones != "") {
        $observacion1 = $solicitud->observaciones;
      } else {
        $observacion1 = 'Ninguna';
      }
      if ($solicitud->observacion_analista != "") {
        $observacion2 = $solicitud->observacion_analista;
      } else {
        $observacion2 = 'Ninguna';
      }

      $observacion1 = html_entity_decode($observacion1);

      $tabla .= '
          <div class="col-12">
            <br>
            <b>Observación del asociado</b>
            ' . $observacion1 . '
          </div>
          <div class="col-12">
            <b>Observación del analista</b>
            ' . $observacion2 . '
          </div>
        ';

      //$pdf->AddPage('L', 'A4');

      $pdf->writeHTMLCell(0, 0, '', '', $tabla, 0, 1, 0, true, '', true);
      ob_end_clean();
      $pdf->Output('reporte.pdf', 'I');
    }
  }


  function generartabla($numero, $usuario, $solicitud, $lineas, $analista, $lineas2)
  {

    $nombres = $solicitud->nombres . " " . $solicitud->nombres2 . " " . $solicitud->apellido1 . " " . $solicitud->apellido2;
    $garantias = array("", "APORTES SOCIALES INDIVIDUALES", "DEUDOR SOLIDARIO", "AFIANZADORA", "HIPOTECARIA", "PRENDARIA");

    $fondo_gris = 'background: #CCCCCC; background-color: #CCCCCC; color: #000000';
    $tabla = '';
    $tabla .= '<table width="100%" style="max-width:900px;" border="1" cellspacing="0" cellpadding="3" class="formulario">

      <tr class="fondo-gris" style="' . $fondo_gris . '">
        <td colspan="2"><div align="center">
        <b>Datos personales</b></div></td>
      </tr>
      <tr>
        <td><strong>Documento</strong></td>
        <td align="right">' . $solicitud->cedula . '</td>
      </tr>
      <tr>
        <td><strong>Nombre</strong></td>
        <td align="right">' . $nombres . '</td>
      </tr>
      <tr>
        <td><strong>Email</strong></td>
        <td align="right">' . $solicitud->correo_personal . '</td>
      </tr>
      <tr>
        <td><strong>Celular</strong></td>
        <td align="right">' . $solicitud->celular . '</td>
      </tr>
      <tr>
        <td><strong>Tel&eacute;fono</strong></td>
        <td align="right">' . $solicitud->telefono . '</td>
      </tr>
      <tr>
        <td><strong>Cargo</strong></td>
        <td align="right">' . $solicitud->cargo . '</td>
      </tr>
      <tr>
        <td><strong>Salario</strong></td>
        <td align="right">' . number_format($usuario->salario) . '</td>
      </tr>

      <tr class="fondo-gris" style="' . $fondo_gris . '">
        <td colspan="2"><div align="center">
        <b>Resumen de solicitud</b></div></td>
      </tr>
      <tr>
        <td><strong>Solicitud</strong></td>
        <td align="right">WEB' . $numero . '</td>
      </tr>

      <tr>
        <td><strong>L&iacute;nea de cr&eacute;dito</strong></td>
        <td align="right">' . $lineas->codigo . ' - ' . $lineas->nombre . '&nbsp;</td>
      </tr>';

    if ($solicitud->cuotas_extra_desembolso != '' && $solicitud->cuotas_extra_desembolso != 0) {
      $tabla .= '
      <tr>
        <td><strong>¿Compromete primas?</strong></td>
        <td align="right">Si</td>
      </tr>
      <tr>
        <td><strong>Compromiso de primas</strong></td>
        <td align="right">' . $solicitud->cuotas_extra_desembolso . '</td>
      </tr>
      <tr>
        <td><strong>Valor de compromiso de primas</strong></td>
        <td align="right">' . $solicitud->valor_extra_desembolso . '</td>
      </tr>
      ';
    }

    $valida = array("NO", "SI");
    $valida[''] = "NO";
    $saldo = $solicitud->valor - $solicitud->valor_desembolso;

    $tabla .= '
      <tr>
        <td><strong>Valor solicitado</strong></td>
        <td align="right">$' . $this->formato_pesos($solicitud->valor) . '</td>
      </tr>
      <tr>
        <td><strong>N&uacute;mero de Cuotas</strong></td>
        <td align="right">' . $solicitud->cuotas . '</td>
      </tr>';
    if ($solicitud->linea_desembolso == "LI") {
      $tabla .= '
      <tr>
        <td><strong>Recoge créditos?</strong></td>
        <td align="right">' . $valida[$solicitud->recoger_credito] . '</td>
      </tr>';
    }
    $tabla .= ' 
      <tr>
        <td><strong>Valor aproximado de cuota</strong></td>
        <td align="right">$' . $this->formato_pesos($solicitud->valor_cuota) . '</td>
      </tr>
      <tr>
        <td><strong>Fecha solicitud</strong></td>
        <td align="right">' . $solicitud->fecha_asignado . '</td>
      </tr>
      ';


    $tabla .= '
      <tr class="fondo-gris" style="' . $fondo_gris . '">
        <td colspan="2"><div align="center">
        <b>Condiciones otorgadas</b></div></td>
      </tr>
      <tr>
        <td><strong>Linea de crédito</strong></td>
        <td align="right">' . $lineas2->codigo . ' - ' . $lineas2->nombre . '&nbsp;</td>
      </tr>
      <tr>
        <td><strong>Valor desembolso</strong></td>
        <td align="right">$' . $this->formato_pesos($solicitud->valor_desembolso) . '</td>
      </tr>';
    if ($solicitud->recoger_credito == "1") {
      $tabla .= '
          <tr>
            <td><strong>Total saldo recogidos</strong></td>
            <td align="right">$' . $this->formato_pesos($solicitud->valor_recogidos) . '</td>
          </tr>
          <tr>
            <td><strong>Valor aprobado</strong></td>
            <td align="right">$' . $this->formato_pesos($solicitud->valor_recogidos + $solicitud->valor_desembolso) . '</td>
          </tr>';
    }
    $tabla .= '<tr>
      <td><strong>Cuotas desembolso</strong></td>
      <td align="right">' . ($solicitud->cuotas_desembolso) . '</td>
    </tr>
    <tr>
      <td><strong>Valor aproximado de cuota desembolso</strong></td>
      <td align="right">$' . $this->formato_pesos($solicitud->valor_cuota_desembolso) . '</td>
    </tr>';
    if ($solicitud->cuotas_extra_desembolso && $solicitud->valor_extra_desembolso) {
      $tabla .= ' <tr>
        <td><strong>Compromiso de primas</strong></td>
        <td align="right">' . $solicitud->cuotas_extra_desembolso . '</td>
      </tr>
      <tr>
        <td><strong>Valor compromiso de primas</strong></td>
        <td align="right">$' . $this->formato_pesos($solicitud->valor_extra_desembolso) . '</td>
      </tr>';
    }

    $tabla .= ' 
      <tr>
        <td><strong>Tasa mes vencido</strong></td>
        <td align="right">' . $solicitud->tasa_desembolso . '%</td>
      </tr>
      <tr>
        <td><strong>Garantía</strong></td>
        <td align="right">' . $garantias[$solicitud->tipo_garantia] . '</td>
      </tr>';
    if ($solicitud->garantia_adicional) {
      $tabla .= '
         <tr>
           <td><strong>Garantía Adicional</strong></td>
           <td align="right">' . $garantias[$solicitud->garantia_adicional] . '</td>
          </tr>';
    }
    if ($solicitud->fecha_anterior != "") {
      $tabla .= '
        <tr>
          <td><strong>Fecha solicitud anterior incompleta</strong></td>
          <td align="right">' . $solicitud->fecha_anterior . '</td>
        </tr>';
    }

    $correo1 = $analista->user_email;
    $extension = "";
    if ($analista->user_ext != "") {
      $extension = " ext " . $analista->user_ext;
    }
    $userModel = new Administracion_Model_DbTable_Usuario();
    $comercial = $userModel->getList("user_regional LIKE '%$solicitud->regional%' AND user_level = 13", "")[0];
    $analistasModel = new Administracion_Model_DbTable_Usuario();
    $analista = $analistasModel->getList("user_id = '$solicitud->asignado'", "")[0];
    $usuarioModel = new Administracion_Model_DbTable_Usuariosinfo();
    $usuario = $this->_view->usuario = $usuarioModel->getList("documento = '$solicitud->cedula'", "")[0];
    $hoy = date("Y-m-d");
    $fecha_afiliacion = date("Y-m-d", strtotime($usuario->fecha_afiliacion));
    $date1 = new DateTime($hoy);
    $date2 = new DateTime($fecha_afiliacion);

    $diff = $date1->diff($date2);
    $meses_fonkoba = ($diff->y * 12) + $diff->m;


    $fecha_ingreso = date("Y-m-d", strtotime($usuario->fecha_afiliacion_koba));
    $date1 = new DateTime($hoy);
    $date2 = new DateTime($fecha_ingreso);

    $diff = $date1->diff($date2);
    $meses_koba = ($diff->y * 12) + $diff->m;

    $tabla .= '

      <tr class="fondo-gris" style="' . $fondo_gris . '">
        <td colspan="2"><div align="center">
        <b>Información Fondtodos</b></div></td>
      </tr>

      <tr>
        <td><strong>Trámite</strong></td>
        <td align="right">' . $solicitud->tramite . '</td>
      </tr>
      <tr>
        <td><strong>Analista </strong></td>
        <td align="right">'.$analista->user_names.'</td>
      </tr>
      <tr>
        <td><strong>Email</strong></td>
        <td align="right">información@fondtodos.com</td>
      </tr>
      <tr>
        <td><strong>Celular</strong></td>
        <td align="right">3135132222</td>
      </tr>
      <tr>
        <td><strong>Fecha de afiliación Fondtodos</strong></td>
        <td align="right">' . $fecha_afiliacion . ' - ' . $meses_fonkoba . ' meses</td>
      </tr>
      <tr>
        <td><strong>Fecha de afiliación D1</strong></td>
        <td align="right">' . $fecha_ingreso . ' - ' . $meses_koba . ' meses</td>
      </tr>
      </table>';

    return $tabla;
  }



  public function desembolsoAction()
  {
    $id = $this->_getSanitizedParam("id");
    $hoy = date("Y-m-d H:i:s");
    $solicitudModel = new Administracion_Model_DbTable_Solicitudes();
    $solicitudModel->editField($id, "validacion", "2");
    $solicitudModel->editField($id, "fecha_desembolso", $hoy);
    $solicitudModel->editField($id, "quien_desembolso", $_SESSION['kt_login_id']);
    $logestado = new Administracion_Model_DbTable_Logestado();
    $dataestado["solicitud"] = $id;
    $dataestado["estado"] = "Desembolsar";
    $dataestado["usuario"] = $_SESSION["kt_login_id"];
    $dataestado["fecha"] = $hoy;
    $logestado->insert($dataestado);
    header("Location:/administracion/solicitudes/");
  }
  public function pasardesembolsoAction()
  {
    $id = $this->_getSanitizedParam("id");
    $hoy = date("Y-m-d H:i:s");
    $solicitudModel = new Administracion_Model_DbTable_Solicitudes();
    $solicitudModel->editField($id, "validacion", "8");
    $solicitudModel->editField($id, "fecha_desembolso", $hoy);
    $solicitudModel->editField($id, "quien_desembolso", $_SESSION['kt_login_id']);
    $logestado = new Administracion_Model_DbTable_Logestado();
    $dataestado["solicitud"] = $id;
    $dataestado["estado"] = "Pasar a desembolso";
    $dataestado["usuario"] = $_SESSION["kt_login_id"];
    $dataestado["fecha"] = $hoy;
    $logestado->insert($dataestado);
    header("Location:/administracion/solicitudes/");
  }

  public function aprobarsolicitudAction()
  {
    $id = $this->_getSanitizedParam("id");
    $hoy = date("Y-m-d H:i:s");
    $solicitudModel = new Administracion_Model_DbTable_Solicitudes();
    $solicitudModel->editField($id, "validacion", "1");
    $solicitudModel->editField($id, "fecha_estado", $hoy);
    $solicitudModel->editField($id, "fecha_aprobado", $hoy);
    $solicitudModel->editField($id, "quien", $_SESSION['kt_login_id']);
    $logestado = new Administracion_Model_DbTable_Logestado();
    $dataestado["solicitud"] = $id;
    $dataestado["estado"] = "Aprobado";
    $dataestado["usuario"] = $_SESSION["kt_login_id"];
    $dataestado["fecha"] = $hoy;
    $logestado->insert($dataestado);
    header("Location:/administracion/solicitudes/?i=1");
    if ($this->enviaraprobacion($id)) {
      $solicitudModel->editField($id, "correo_aprobacion_enviado", "1");
    }
  }
  public function correoaprobacionAction()
  {
    $id = $this->_getSanitizedParam("id");
    if ($this->enviaraprobacion($id)) {
      $solicitudModel = new Administracion_Model_DbTable_Solicitudes();
      $solicitudModel->editField($id, "correo_aprobacion_enviado", "1");
    }
  }
  public function enviaraprobacion($id)
  {
    $validacion1 = "";

    $validacion1 = "APROBADA";


    $solicitudModel = new Administracion_Model_DbTable_Solicitudes();
    $numero = str_pad($id, 6, "0", STR_PAD_LEFT);
    $solicitud = $solicitudModel->getById($id);
    $linea = $solicitud->linea;
    $linea2 = $solicitud->linea_desembolso;
    $lineaModel = new Administracion_Model_DbTable_Lineas();
    $lineas = $lineaModel->getList(" codigo='$linea' ", "")[0];
    $lineas2 = $lineaModel->getList(" codigo='$linea2' ", "")[0];
    $nombre = $solicitud->nombres;
    if ($solicitud->nombres2) {
      $nombre = $nombre . " " . $solicitud->nombres2;
    }
    $nombre = $nombre . " " . $solicitud->apellido1;
    if ($solicitud->apellido2) {
      $nombre = $nombre . " " . $solicitud->apellido2;
    }
    $emailModel = new Core_Model_Mail();
    $asunto = "Novedad solicitud crédito WEB" . $numero . " - " . $nombre;

    $usuarioModel = new Administracion_Model_DbTable_Usuario();
    $analista_id = $solicitud->asignado;
    $analista = $usuarioModel->getById($analista_id);
    $cedula = $solicitud->cedula;
    $usuario = $usuarioModel->getList(" user_user = '$cedula' ", "")[0];

    $email = $solicitud->correo_personal;
    $correo1 = $analista->user_email;

    $content = '<br>
      <p>Estimado asociado(a), su solicitud <b>WEB' . $numero . '</b>, por valor de <b>$' . number_format($solicitud->valor_desembolso) . '</b> fue <b>' . $validacion1 . '</b></p>';
    $tabla = $this->generartabla($numero, $usuario, $solicitud, $lineas, $analista, $lineas2);

    $content .= $tabla;
    $hash = md5($solicitud->cedula);
    $ruta = "https://creditosfondtodos.com.co/";
    $enlace = "page/confirmarsolicitud/?id=" . $id . "&hash=" . $hash . "&confirmacion=1";
    $enlace2 = "page/confirmarsolicitud/?id=" . $id . "&hash=" . $hash . "&confirmacion=2";
    $boton_azul2 = "background:#01508A; color:#FFF; font-size:18px; padding:4px 10px; text-decoration:none; max-width:200px; border-bottom:1px solid #FFFFFF; border-radius:4px;margin-right:7px;";


    $mensaje_recogida="";
    if($solicitud->recoger_credito==1){
      $mensaje_recogida=" Tenga presente que en este momento se encuentra en curso la cuota  de la obligación que se está recogiendo, si desea continuar con el proceso de recogida de saldos, esta cuota será abonada a su obligacion vigente.";
    }

    $content = $content . "Por favor confirmar su aceptación.".$mensaje_recogida."<br><a href='" . $ruta . $enlace . "' style='" . $boton_azul2 . "'>Confirmar</a> <a href='" . $ruta . $enlace2 . "' style='" . $boton_azul2 . "'>Cancelar</a><br>";



    $emailModel->getMail()->setFrom("notificaciones@fondtodos.com", "Notificaciones FONDTODOS");
    $emailModel->getMail()->addBCC("soporteomega@omegawebsystems.com");
    $emailModel->getMail()->addBCC("desarrollo2@omegawebsystems.com");
    $emailModel->getMail()->addBCC("notificaciones@fondtodos.com");
    if ($validacion != "4") {
      $emailModel->getMail()->addAddress("" . $email);
    }
    $emailModel->getMail()->addBCC("" . $correo1);

    $emailModel->getMail()->Subject = $asunto;
    $emailModel->getMail()->msgHTML($content);
    $emailModel->getMail()->AltBody = $content;
    if ($emailModel->sed()) {
      return true;
    } else {
      return false;
    }
  }

  public function libranzaAction()
  {
    $solicitudModel = new Administracion_Model_DbTable_Solicitudes();
    $codeudorModel = new Administracion_Model_DbTable_Codeudor();
    $id = $this->_getSanitizedParam("id");
    $solicitud = $solicitudModel->getById($id);
    $codeudorModel->getList("solicitud=$id", "")[0];
    $this->_view->solicitud = $solicitud;
    $nombre = $solicitud->nombres;
    if ($solicitud->nombres2 != "") {
      $nombre = $nombre . " " . $solicitud->nombres2;
    }
    $nombre = $nombre . " " . $solicitud->apellido1;
    if ($solicitud->apellido2 != "") {
      $nombre = $nombre . " " . $solicitud->apellido2;
    }
    $nombre2 = $codeudorModel->nombres;
    if ($codeudorModel->nombres2 != "") {
      $nombre2 = $nombre2 . " " . $codeudorModel->nombres2;
    }
    $nombre2 = $nombre2 . " " . $codeudorModel->apellido1;
    if ($codeudorModel->apellido2 != "") {
      $nombre2 = $nombre2 . " " . $codeudorModel->apellido2;
    }
    $this->_view->nombre = $nombre;
    $this->_view->codeudor_nombre = $nombre2;
  }
  public function exportarlibranzaAction()
  {
    $id = $this->_getSanitizedParam("id");
    $solicitudModel = new Administracion_Model_DbTable_Solicitudes();
    $codeudorModel = new Administracion_Model_DbTable_Codeudor();
    $solicitud = $solicitudModel->getById($id);
    $nombre = $solicitud->nombres;
    if ($solicitud->nombres2 != "") {
      $nombre = $nombre . " " . $solicitud->nombres2;
    }
    $nombre = $nombre . " " . $solicitud->apellido1;
    if ($solicitud->apellido2 != "") {
      $nombre = $nombre . " " . $solicitud->apellido2;
    }
    $this->_view->nombre = $nombre;
    $this->_view->solicitud = $solicitud;
    $this->_view->codeudor = $codeudorModel->getList("solicitud=$id", "")[0];
    $this->setLayout('blanco');
    $this->getLayout()->setTitle("PDF");
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->SetHeaderMargin(0);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    $pdf->AddPage('P', 'A4');
    $pdf->SetFont('helvetica', '', 8);
    $content = $this->_view->getRoutPHP('modules/administracion/Views/solicitudes/exportarlibranza.php');
    $pdf->writeHTML($content, true, false, true, false, '');
    $pdf->Output("libranza.pdf", 'I');
  }

  //DECEVAL

  public function aprobarAction()
  {
    $id = $this->_getSanitizedParam("id");
    $solicitudesModel = new Administracion_Model_DbTable_Solicitudes();
    $solicitud = $solicitudesModel->getById($id);
    if (($solicitud->linea == "CF" && $solicitud->linea_desembolso == "CF") || ($solicitud->linea == "SE" && $solicitud->linea_desembolso == "SE") || ($solicitud->linea == "SO" && $solicitud->linea_desembolso == "SO") || ($solicitud->linea == "CDU" && $solicitud->linea_desembolso == "CDU")) {
    } else {
      $cedula = $solicitud->cedula;

      $codeudorModel = new Administracion_Model_DbTable_Codeudor();
      $codeudor1_list = $codeudorModel->getList(" solicitud='$id' AND codeudor_numero='1' ", "")[0];
      $codeudor2_list = $codeudorModel->getList(" solicitud='$id' AND codeudor_numero='2' ", "")[0];
      $codeudor1 = $codeudor1_list->cedula;
      $codeudor2 = $codeudor2_list->cedula;

      //validar info asociado
      $error = 0;
      if ($solicitud->documento == "") {
        $error = 1;
      }
      if ($solicitud->tipo_documento == "") {
        $error = 1;
      }
      if ($solicitud->nombres == "") {
        $error = 1;
      }
      if ($solicitud->apellido1 == "") {
        $error = 1;
      }
      if ($solicitud->ciudad_residencia == "") {
        $error = 1;
      }
      if ($solicitud->ciudad_documento == "") {
        $error = 1;
      }
      if ($solicitud->fecha_nacimiento == "" or $solicitud->fecha_nacimiento == "0" or $solicitud->fecha_nacimiento == "0000-00-00") {
        $error = 1;
      }
      if ($solicitud->fecha_documento == "" or $solicitud->fecha_documento == "0" or $solicitud->fecha_documento == "0000-00-00") {
        $error = 1;
      }
      if ($solicitud->direccion_residencia == "") {
        $error = 1;
      }
      if ($solicitud->correo_personal == "") {
        $error = 1;
      }
      if ($solicitud->celular == "") {
        $error = 1;
      }


      //validar info codeudor1
      if ($codeudor1_list->cedula != "") {
        if ($codeudor1_list->tipo_documento == "") {
          $error = 3;
        }
        if ($codeudor1_list->nombres == "") {
          $error = 3;
        }
        if ($codeudor1_list->apellido1 == "") {
          $error = 3;
        }
        if ($codeudor1_list->ciudad_residencia == "") {
          $error = 3;
        }
        if ($codeudor1_list->ciudad_documento == "") {
          $error = 3;
        }
        if ($codeudor1_list->fecha_nacimiento == "" or $codeudor1_list->fecha_nacimiento == "0" or $codeudor1_list->fecha_nacimiento == "0000-00-00") {
          $error = 3;
        }
        if ($codeudor1_list->fecha_documento == "" or $codeudor1_list->fecha_documento == "0" or $codeudor1_list->fecha_documento == "0000-00-00") {
          $error = 3;
        }
        if ($codeudor1_list->direccion_residencia == "") {
          $error = 3;
        }
        if ($codeudor1_list->correo == "") {
          $error = 3;
        }
        if ($codeudor1_list->celular == "") {
          $error = 3;
        }
      }

      //validar info codeudor2
      // if ($codeudor2_list->cedula != "") {
        // if ($codeudor2_list->tipo_documento == "") {
          // $error = 5;
        // }
        // if ($codeudor2_list->nombres == "") {
          // $error = 5;
        // }
        // if ($codeudor2_list->apellido1 == "") {
          // $error = 5;
        // }
        // if ($codeudor2_list->ciudad_residencia == "") {
          // $error = 5;
        // }
        // if ($codeudor2_list->ciudad_documento == "") {
          // $error = 5;
        // }
        // if ($codeudor2_list->fecha_nacimiento == "" or $codeudor2_list->fecha_nacimiento == "0" or $codeudor2_list->fecha_nacimiento == "0000-00-00") {
          // $error = 5;
        // }
        // if ($codeudor2_list->fecha_documento == "" or $codeudor2_list->fecha_documento == "0" or $codeudor2_list->fecha_documento == "0000-00-00") {
          // $error = 5;
        // }
        // if ($codeudor2_list->direccion_residencia == "") {
          // $error = 5;
        // }
        // if ($codeudor2_list->correo == "") {
          // $error = 5;
        // }
        // if ($codeudor2_list->celular == "") {
          // $error = 5;
        // }
      // }

      //VALIDAR SI YA EXISTE PAGARE
      /* $filtro = " pagare_deceval.estado='1' AND solicitudes.cedula =  '$cedula' ";
      if($codeudor1=="" and $codeudor2==""){
        $filtro .= " AND (solicitudes.codeudor1='' OR solicitudes.codeudor1 IS NULL) AND (solicitudes.codeudor2='' OR solicitudes.codeudor2 IS NULL) ";
      }
      if($codeudor1!="" and $codeudor2==""){
        $filtro .= " AND solicitudes.codeudor1 = '$codeudor1' AND (solicitudes.codeudor2='' OR solicitudes.codeudor2 IS NULL) ";
      }
      if($codeudor1!="" and $codeudor2!=""){
        $filtro .= " AND solicitudes.codeudor1 = '$codeudor1' AND solicitudes.codeudor2 = '$codeudor2' ";
      }

      $modalidad = $solicitud->linea;
      $filtro .= " AND pagare_deceval.modalidad = '$modalidad' ";


      $pagares = $solicitudesModel->getPagares("".$filtro,"");
      $existe = 0;
      if(count($pagares)>0){
        $pagare1 = $pagares[0]->pagare;
        if($id>0 and $pagare1!=""){
          $solicitudesModel->editField($id,"pagare",$pagare1);
        }
      } */
      //VALIDAR SI YA EXISTE PAGARE

      if ($error == 1 and $existe == 0) {
        $this->_view->error = "Error creando el girador, faltan algunos datos del asociado.";
        if ($_SESSION['ingreso_temporal'] == "1") {
          $_SESSION['kt_login_id'] = "";
          $_SESSION['kt_login_level'] = "";
        }
        //header("Refresh:3; url= /page/usuariosinfo/manage/?id=".$cedula);
      }
      if ($error == 2 and $existe == 0) {
        $this->_view->error = "Error creando el girador, no existe el asociado";
        if ($_SESSION['ingreso_temporal'] == "1") {
          $_SESSION['kt_login_id'] = "";
          $_SESSION['kt_login_level'] = "";
        }
        //header("Refresh:3; url= /page/usuariosinfo/manage/?documento=".$cedula);
      }
      if ($error == 3 and $existe == 0) {
        $this->_view->error = "Error creando el girador, faltan algunos datos del codeudor1";
        if ($_SESSION['ingreso_temporal'] == "1") {
          $_SESSION['kt_login_id'] = "";
          $_SESSION['kt_login_level'] = "";
        }
        //header("Refresh:3; url= /page/usuariosinfo/manage/?id=".$codeudor1);
      }
      if ($error == 4 and $existe == 0) {
        $this->_view->error = "Error creando el girador, no existe el codeudor1";
        //header("Refresh:3; url= /page/usuariosinfo/manage/?documento=".$codeudor1);
        if ($_SESSION['ingreso_temporal'] == "1") {
          $_SESSION['kt_login_id'] = "";
          $_SESSION['kt_login_level'] = "";
        }
      }
      if ($error == 5 and $existe == 0) {
        $this->_view->error = "Error creando el girador, faltan algunos datos del codeudor2";
        //header("Refresh:3; url= /page/usuariosinfo/manage/?id=".$codeudor2);
        if ($_SESSION['ingreso_temporal'] == "1") {
          $_SESSION['kt_login_id'] = "";
          $_SESSION['kt_login_level'] = "";
        }
      }
      if ($error == 6 and $existe == 0) {
        $this->_view->error = "Error creando el girador, no existe el codeudor2";
        //header("Refresh:3; url= /page/usuariosinfo/manage/?documento=".$codeudor2);
        if ($_SESSION['ingreso_temporal'] == "1") {
          $_SESSION['kt_login_id'] = "";
          $_SESSION['kt_login_level'] = "";
        }
      }
      if ($error == 0 and $existe == 0) {
        if($solicitud->estado_autorizo != '4'){
          header("Location: /administracion/wspagares/creargirador/?id=" . $id);
        }
      }
    }
  }



  public function enviarpagareAction()
  {
    if ($_SESSION['ingreso_temporal'] == "1") {
      $_SESSION['kt_login_id'] = "";
      $_SESSION['kt_login_level'] = "";
    }
    $id = $this->_getSanitizedParam("id");
    $solicitudesModel = new Administracion_Model_DbTable_Solicitudes();
    $solicitud = $solicitudesModel->getById($id);
    if (($solicitud->linea == "CF" && $solicitud->linea_desembolso == "CF") || ($solicitud->linea == "SE" && $solicitud->linea_desembolso == "SE") || ($solicitud->linea == "SO" && $solicitud->linea_desembolso == "SO") || ($solicitud->linea == "CDU" && $solicitud->linea_desembolso == "CDU")) {
    } else {
      $cedula = $solicitud->cedula;
      $codeudorModel = new Administracion_Model_DbTable_Codeudor();
      $codeudor1_list = $codeudorModel->getList("solicitud='$id' AND codeudor_numero='1' ", "")[0];
      $codeudor2_list = $codeudorModel->getList("solicitud='$id' AND codeudor_numero='2' ", "")[0];
      $codeudor1 = $codeudor1_list->cedula;
      $codeudor2 = $codeudor2_list->cedula;


      $numero_obligacion = $solicitud->pagare;
      $pagareModel = new Page_Model_DbTable_Pagaredeceval();
      $existe_pagare = $pagareModel->getList(" pagare='$numero_obligacion' ", "")[0];

      $hoy = date("Y-m-d");
      if ($id > 0 and ($solicitud->fecha_aprobado == '0000-00-00' or $solicitud->fecha_aprobado == '')) {
        $solicitudesModel->editField($id, "fecha_aprobado", $hoy);
      }

      $nombre = $solicitud->nombres . " " . $solicitud->nombres2 . " " . $solicitud->apellido1 . " " . $solicitud->apellido2;
      $nombre2 = $codeudor1_list->nombres . " " . $codeudor1_list->nombres2 . " " . $codeudor1_list->apellido1 . " " . $codeudor1_list->apellido2;
      $nombre3 = $codeudor2_list->nombres . " " . $codeudor2_list->nombres2 . " " . $codeudor2_list->apellido1 . " " . $codeudor2_list->apellido2;
      $correo_personal = $solicitud->correo_personal;
      $correo_personal1 = $codeudor1_list->correo;
      $correo_personal2 = $codeudor2_list->correo;
      $correo_empresarial = $solicitud->correo_empresarial;
      $correo_empresarial1 = $codeudor1_list->correo_empresarial;
      $correo_empresarial2 = $codeudor2_list->correo_empresarial;
      $numero = $solicitud->pagare;
      $numero = "WEB" . con_ceros($id);
      $this->_view->numero = $numero;
      $nombre = utf8_decode($nombre);
      $nombre2 = utf8_decode($nombre2);
      $nombre3 = utf8_decode($nombre3);
      $token = $existe_pagare->token;
      $linea = $solicitud->linea;
      $lineaModel = new Administracion_Model_DbTable_Lineas();
      $linea_list = $lineaModel->getList(" codigo='$linea' ", "")[0];
      $modalidad = $linea_list->nombre;
      $fecha_solicitud = $solicitud->fecha_solicitud;

      $hash = password_hash($id . "OMEGA", PASSWORD_DEFAULT);

      $ruta = "http://192.168.1.232:8081/";
      $ruta = "https://creditosfondtodos.com.co/";
      $enlace = "page/firmarpagare/?id=" . $id . "&rol=0&hash=" . $hash;
      $enlace1 = "page/firmarpagare/?id=" . $id . "&rol=1&hash=" . $hash;
      $enlace2 = "page/firmarpagare/?id=" . $id . "&rol=2&hash=" . $hash;

      $boton_azul2 = "background:#01508A; color:#FFF; font-size:18px; padding:4px 10px; text-decoration:none; max-width:200px; border-bottom:1px solid #FFFFFF; border-radius:4px;";
      //$banner = "<img src='".$ruta."/corte/banner.jpg' /><br /><br />";
      $subrayado = "text-decoration:underline;";


      $mensaje = $banner . "Estimado " . $nombre . " estamos a un paso de desembolsar su solicitud de crédito.<br /><br />
      Por favor haga click en el siguiente botón para firmar su pagaré<br /><br /><br />
      El siguiente token <strong style='font-size:16px;'>" . $token . "</strong> va a ser solicitado para la firma de su pagaré, por favor cópielo. <br /><br />
      <a href='" . $ruta . $enlace . "' style='" . $boton_azul2 . "'>FIRMAR PAGARÉ</a>";

      $mensaje1 = $banner . "Estimado " . $nombre2 . ",  estamos a un paso de desembolsar su solicitud de crédito.<br /><br />
      Por favor haga click en el siguiente botón para firmar el pagaré como Codeudor<br /><br /><br />
      El siguiente token <strong style='font-size:16px;'>" . $token . "</strong> va a ser solicitado para la firma de su pagaré, por favor cópielo. <br /><br />
      <a href='" . $ruta . $enlace1 . "' style='" . $boton_azul2 . "'>FIRMAR PAGARÉ</a>";

      $mensaje2 = $banner . " estamos a un paso de desembolsar su solicitud de crédito.<br /><br />
      Por favor haga click en el siguiente botón para firmar el pagaré como Codeudor<br /><br /><br />
      El siguiente token <strong style='font-size:16px;'>" . $token . "</strong> va a ser solicitado para la firma de su pagaré, por favor cópielo. <br /><br />
      <a href='" . $ruta . $enlace2 . "' style='" . $boton_azul2 . "'>FIRMAR PAGARÉ</a>";

      $nombres = $nombre;
      if ($codeudor1 != "") {
        $nombres .= ", " . $nombre2;
      }
      if ($codeudor2 != "") {
        $nombres .= ", " . $nombre3;
      }

      // $adicional="<br /><br /><br /><strong>LIBRANZA</strong><br />
      // Nosotros <span style='".$subrayado."'>".$nombres."</span> Identificados como aparece al pie de nuestras firmas, autorizamos permanente, expresa e irrevocablemente al pagador de la empresa donde laboramos, o a las empresas que paguen nuestras pensiones, o a las empresas en las que por ley debamos mantener nuestras cesantías, para que de conformidad con los artículos 55 y 56 del Decreto Ley 1481 de 1989, 142 y 144 de la ley 79 de 1988 y el artículo 4 de la ley 920 de 2004, deduzca de nuestros salarios, prestaciones legales o extralegales, bonificaciones, indemnizaciones, cesantías, pensión y en general de cualquier valor a nuestro favor, las cuotas a nuestro cargo generadas según el plan de amortización definido para esta obligación con el Fondo de Empleados FEDEAA. Igualmente queda plenamente autorizado para que descuente de nuestras prestaciones sociales y demás derechos de carácter laboral que nos correspondan, los saldos que adeudemos al Fondo de Empleados FEDEAA en la fecha que por cualquier causal o motivo nos retiremos de la empresa en la que laboramos. Así mismo autorizamos expresa e irrevocablemente al Fondo de Empleados FEDEAA, a descontar de nuestra cuenta de ahorros o cuenta corriente, o de nuestra cuenta de nómina, el valor correspondiente al saldo mensual que no descuente la empresa a la que nos encontremos vinculados laboralmente. De igual manera autorizamos irrevocablemente para descontar cualquier otro valor que se genere con ocasión de la domiciliación que por este documento se realiza.<br /><br />
      // Autorizamos expresa e irrevocablemente al Fondo de Empleados FEDEAA a quien represente sus derechos u ostente en el futuro la calidad de acreedor, para consultar, reportar, procesar, solicitar y divulgar a las centrales de riesgo toda la información correspondiente a nuestras obligaciones vigentes o vencidas que contraigamos o hayamos contraído con el Fondo de Empleados FEDEAA.";

      $mensaje = $mensaje . $adicional;
      $mensaje1 = $mensaje1 . $adicional;
      $mensaje2 = $mensaje2 . $adicional;
      $nombre2 = $solicitud->nombres;
      if ($solicitud->nombres2) {
        $nombre2 = $nombre2 . " " . $solicitud->nombres2;
      }
      $nombre2 = $nombre2 . " " . $solicitud->apellido1;
      if ($solicitud->apellido2) {
        $nombre2 = $nombre2 . " " . $solicitud->apellido2;
      }
      $asunto = "Solicitud de Crédito FONDTODOS #" . $numero . " - " . $nombre2 . " Aprobada";

      $asunto = ($asunto);
      $mensaje = ($mensaje);
      $mensaje1 = ($mensaje1);
      $mensaje2 = ($mensaje2);


      $emailModel = new Core_Model_Mail();
      $emailModel->getMail()->setFrom("notificaciones@fondtodos.com", "Notificaciones FONDTODOS");
      $emailModel->getMail()->addBCC("soporteomega@omegawebsystems.com");
      $emailModel->getMail()->addBCC("desarrollo2@omegawebsystems.com");
    $emailModel->getMail()->addBCC("notificaciones@fondtodos.com");

      if ($correo_personal != "") {
        $emailModel->getMail()->addAddress("" . $correo_personal);
      }
      if ($correo_empresarial != "") {
        $emailModel->getMail()->addAddress("" . $correo_empresarial);
      }

      $emailModel->getMail()->Subject = $asunto;
      $emailModel->getMail()->msgHTML($mensaje);
      $emailModel->getMail()->AltBody = $mensaje;
      if ($emailModel->sed()) {
        $this->_view->send = '1';
        $this->_view->id = $id;
        $solicitudesModel->editField($id, "pagare_enviado", 1);
      } else {
        $this->_view->send = '2';
        $this->_view->id = $id;
      }

      if ($codeudor1 != "") {

        $emailModel = new Core_Model_Mail();
        $emailModel->getMail()->setFrom("notificaciones@fondtodos.com", "Notificaciones FONDTODOS");
        $emailModel->getMail()->addBCC("soporteomega@omegawebsystems.com");
        $emailModel->getMail()->addBCC("desarrollo2@omegawebsystems.com");
    $emailModel->getMail()->addBCC("notificaciones@fondtodos.com");

        if ($correo_personal1 != "") {
          $emailModel->getMail()->addAddress("" . $correo_personal1);
        }
        if ($correo_empresarial1 != "") {
          $emailModel->getMail()->addAddress("" . $correo_empresarial1);
        }

        $emailModel->getMail()->Subject = $asunto;
        $emailModel->getMail()->msgHTML($mensaje1);
        $emailModel->getMail()->AltBody = $mensaje1;
        $emailModel->sed();
      }

      if ($codeudor2 != "") {

        $emailModel = new Core_Model_Mail();
        $emailModel->getMail()->setFrom("notificaciones@fondtodos.com", "Notificaciones FONDTODOS");
        $emailModel->getMail()->addBCC("soporteomega@omegawebsystems.com");
        $emailModel->getMail()->addBCC("desarrollo2@omegawebsystems.com");
    $emailModel->getMail()->addBCC("notificaciones@fondtodos.com");


        if ($correo_personal2 != "") {
          $emailModel->getMail()->addAddress("" . $correo_personal2);
        }
        if ($correo_empresarial2 != "") {
          $emailModel->getMail()->addAddress("" . $correo_empresarial2);
        }

        $emailModel->getMail()->Subject = $asunto;
        $emailModel->getMail()->msgHTML($mensaje2);
        $emailModel->getMail()->AltBody = $mensaje2;
        $emailModel->sed();
      }

      $enviarpagareModel = new Administracion_Model_DbTable_Enviopagare();
      $data['envio_solicitud'] = $id;
      $data['envio_fecha'] = date("Y-m-d H:i:s");
      $data['envio_quien'] = $_SESSION['kt_login_id'];
      $enviarpagareModel->insert($data);
    }
  }


  public function enviarpagare2Action()
  {
    $this->setLayout('blanco');
    $id = $this->_getSanitizedParam("id");
    $solicitudesModel = new Administracion_Model_DbTable_Solicitudes();
    $solicitud = $solicitudesModel->getById($id);
    $cedula = $solicitud->cedula;


    $codeudorModel = new Administracion_Model_DbTable_Codeudor();
    $codeudor1_list = $codeudorModel->getList(" solicitud='$id' AND numero='1' ", "")[0];
    $codeudor2_list = $codeudorModel->getList(" solicitud='$id' AND numero='2' ", "")[0];
    $codeudor1 = $codeudor1_list->cedula;
    $codeudor2 = $codeudor2_list->cedula;
    $numero_obligacion = $solicitud->numero_obligacion;
    $pagareModel = new Page_Model_DbTable_Pagaredeceval();
    $existe_pagare = $pagareModel->getList(" pagare='$numero_obligacion' ", "")[0];

    $hoy = date("Y-m-d");
    if ($id > 0 and ($solicitud->fecha_aprobado == '0000-00-00' or $solicitud->fecha_aprobado == '')) {
      $solicitudesModel->editField($id, "fecha_aprobado", $hoy);
    }

    $nombre = $solicitud->nombres . " " . $solicitud->nombres2 . " " . $solicitud->apellido1 . " " . $solicitud->apellido2;
    $nombre2 = $codeudor1_list->nombres . " " . $codeudor1_list->nombres2 . " " . $codeudor1_list->apellido1 . " " . $codeudor1_list->apellido2;
    $nombre3 = $codeudor2_list->nombres . " " . $codeudor2_list->nombres2 . " " . $codeudor2_list->apellido1 . " " . $codeudor2_list->apellido2;
    $correo_personal = $solicitud->correo_personal;
    $correo_personal1 = $codeudor1_list->correo;
    $correo_personal2 = $codeudor2_list->correo;
    $correo_empresarial = $solicitud->correo_empresarial;
    $correo_empresarial1 = $codeudor1_list->correo_empresarial;
    $correo_empresarial2 = $codeudor2_list->correo_empresarial;
    $numero = $solicitud->pagare;
    $numero = "WEB" . con_ceros($id);
    $this->_view->numero = $numero;
    $nombre = ($nombre);
    $nombre2 = ($nombre2);
    $nombre3 = ($nombre3);
    $token = $existe_pagare->token;
    $linea = $solicitud->linea;
    $lineaModel = new Administracion_Model_DbTable_Lineas();
    $linea_list = $lineaModel->getList(" codigo='$linea' ", "")[0];
    $modalidad = $linea_list->nombre;
    $fecha_solicitud = $solicitud->fecha_solicitud;

    $hash = password_hash($id . "OMEGA", PASSWORD_DEFAULT);

    $ruta = "http://192.168.1.232:8081/";
    $ruta = "http://creditos.fedeaa.com:8081/";
    $enlace = "page/firmarpagare/?id=" . $id . "&rol=0&hash=" . $hash;
    $enlace1 = "page/firmarpagare/?id=" . $id . "&rol=1&hash=" . $hash;
    $enlace2 = "page/firmarpagare/?id=" . $id . "&rol=2&hash=" . $hash;

    $boton_azul2 = "background:#01508A; color:#FFF; font-size:18px; padding:4px 10px; text-decoration:none; max-width:200px; border-bottom:1px solid #FFFFFF; border-radius:4px;";
    //$banner = "<img src='".$ruta."/corte/banner.jpg' /><br /><br />";
    $subrayado = "text-decoration:underline;";


    $mensaje = $banner . "Estimado " . $nombre . ", su solicitud de crédito <strong>N°" . $numero . "</strong> en la modalidad de <strong>" . $modalidad . "</strong> solicitada el <strong>" . $fecha_solicitud . "</strong> ha sido aprobada.<br /><br />
      Por favor haga click en el siguiente botón para firmar su pagaré<br /><br /><br />
      El siguiente token va a ser solicitado para la firma de su pagaré, por favor copielo y tengalo a la mano: <strong style='font-size:16px;'>" . $token . "</strong><br /><br />
      <a href='" . $ruta . $enlace . "' style='" . $boton_azul2 . "'>FIRMAR PAGARÉ</a>";

    $mensaje1 = $banner . "Estimado " . $nombre2 . ", la solicitud de crédito <strong>N°" . $numero . "</strong> en la modalidad de <strong>" . $modalidad . "</strong> solicitada el <strong>" . $fecha_solicitud . "</strong> por el asociado " . $nombre . " ha sido aprobada.<br /><br />
      Por favor haga click en el siguiente botón para firmar el pagaré como Codeudor<br /><br /><br />
      El siguiente token va a ser solicitado para la firma del pagaré, por favor copielo y tengalo a la mano: <strong style='font-size:16px;'>" . $token . "</strong><br /><br />
      <a href='" . $ruta . $enlace1 . "' style='" . $boton_azul2 . "'>FIRMAR PAGARÉ</a>";

    $mensaje2 = $banner . "Estimado " . $nombre3 . ", la solicitud de crédito <strong>N°" . $numero . "</strong> en la modalidad de <strong>" . $modalidad . "</strong> solicitada el <strong>" . $fecha_solicitud . "</strong> por el asociado " . $nombre . " ha sido aprobada.<br /><br />
      Por favor haga click en el siguiente botón para firmar el pagaré como Codeudor<br /><br /><br />
      El siguiente token va a ser solicitado para la firma del pagaré, por favor copielo y tengalo a la mano: <strong style='font-size:16px;'>" . $token . "</strong><br /><br />
      <a href='" . $ruta . $enlace2 . "' style='" . $boton_azul2 . "'>FIRMAR PAGARÉ</a>";

    $nombres = $nombre;
    if ($codeudor1 != "") {
      $nombres .= ", " . $nombre2;
    }
    if ($codeudor2 != "") {
      $nombres .= ", " . $nombre3;
    }

    /*
      $adicional="<br /><br /><br /><strong>AUTORIZACIÓN DE DESCUENTO</strong><br />
      Nosotros <span style='".$subrayado."'>".$nombres."</span> Identificados como aparece al pie de nuestras firmas, autorizamos permanente, expresa e irrevocablemente al pagador de la empresa donde laboramos, o a las empresas que paguen nuestras pensiones, o a las empresas en las que por ley debamos mantener nuestras cesantías, para que de conformidad con los artículos 55 y 56 del Decreto Ley 1481 de 1989, 142 y 144 de la ley 79 de 1988 y el artículo 4 de la ley 920 de 2004, deduzca de nuestros salarios, prestaciones legales o extralegales, bonificaciones, indemnizaciones, cesantías, pensión y en general de cualquier valor a nuestro favor, las cuotas a nuestro cargo generadas según el plan de amortización definido para esta obligación con el Fondo de Empleados FEDEAA. Igualmente queda plenamente autorizado para que descuente de nuestras prestaciones sociales y demás derechos de carácter laboral que nos correspondan, los saldos que adeudemos al Fondo de Empleados FEDEAA en la fecha que por cualquier causal o motivo nos retiremos de la empresa en la que laboramos. Así mismo autorizamos expresa e irrevocablemente al Fondo de Empleados FEDEAA, a descontar de nuestra cuenta de ahorros o cuenta corriente, o de nuestra cuenta de nómina, el valor correspondiente al saldo mensual que no descuente la empresa a la que nos encontremos vinculados laboralmente. De igual manera autorizamos irrevocablemente para descontar cualquier otro valor que se genere con ocasión de la domiciliación que por este documento se realiza.<br /><br />
      Autorizamos expresa e irrevocablemente al Fondo de Empleados FEDEAA a quien represente sus derechos u ostente en el futuro la calidad de acreedor, para consultar, reportar, procesar, solicitar y divulgar a las centrales de riesgo toda la información correspondiente a nuestras obligaciones vigentes o vencidas que contraigamos o hayamos contraído con el Fondo de Empleados FEDEAA.";

      $contenido_plan = $this->generarplan($id);

      $adicional.="<br><br><b>PLAN DE PAGOS</b><br>".$contenido_plan;

      $mensaje=$mensaje.$adicional;
      $mensaje1=$mensaje1.$adicional;
      $mensaje2=$mensaje2.$adicional;
      */

    $asunto = "Solicitud de Crédito FONDTODOS #" . $numero . " Aprobada [Plan de pagos]";

    $asunto = ($asunto);
    $mensaje = ($mensaje);
    $mensaje1 = ($mensaje1);
    $mensaje2 = ($mensaje2);


    $emailModel = new Core_Model_Mail();
    $emailModel->getMail()->setFrom("notificaciones@fondtodos.com", "Notificaciones FONDTODOS");
    $emailModel->getMail()->addBCC("soporteomega@omegawebsystems.com");
    $emailModel->getMail()->addBCC("desarrollo2@omegawebsystems.com");
    $emailModel->getMail()->addBCC("notificaciones@fondtodos.com");


    if ($correo_personal != "") {
      //$emailModel->getMail()->addAddress("".$correo_personal);
    }
    if ($correo_empresarial != "") {
      //$emailModel->getMail()->addAddress("".$correo_empresarial);
    }

    //$emailModel->getMail()->addStringAttachment(file_get_contents("http://creditos.fedeaa.com:8081/administracion/solicitudes/generarpdfplan/?id=".$id), "Plan_de_pagos_".$id.".pdf");
    //$this->generarpdfplan($id);
    //$emailModel->getMail()->AddAttachment("E:/apache24/htdocs/fedeaa_creditos/public/pdfs/Libranza".$id.".pdf", "Libranza".$id.".pdf");

    $emailModel->getMail()->Subject = $asunto;
    $emailModel->getMail()->msgHTML($mensaje);
    $emailModel->getMail()->AltBody = $mensaje;
    $emailModel->sed();


    //echo $mensaje;

    /*
      if($codeudor1!=""){

        $emailModel = new Core_Model_Mail();
        $emailModel->getMail()->setFrom("notificaciones@fedeaa.com", "Notificaciones FEDEAA");
        $emailModel->getMail()->addBCC("soporteomega@omegawebsystems.com");

        if($correo_personal1!=""){
          $emailModel->getMail()->addAddress("".$correo_personal1);
        }
        if($correo_empresarial1!=""){
          $emailModel->getMail()->addAddress("".$correo_empresarial1);
        }

        $emailModel->getMail()->Subject = $asunto;
        $emailModel->getMail()->msgHTML($mensaje1);
        $emailModel->getMail()->AltBody = $mensaje1;
        $emailModel->sed();

      }

      if($codeudor2!=""){

        $emailModel = new Core_Model_Mail();
        $emailModel->getMail()->setFrom("notificaciones@fedeaa.com", "Notificaciones FEDEAA");
        $emailModel->getMail()->addBCC("soporteomega@omegawebsystems.com");

        if($correo_personal2!=""){
          $emailModel->getMail()->addAddress("".$correo_personal2);
        }
        if($correo_empresarial2!=""){
          $emailModel->getMail()->addAddress("".$correo_empresarial2);
        }

        $emailModel->getMail()->Subject = $asunto;
        $emailModel->getMail()->msgHTML($mensaje2);
        $emailModel->getMail()->AltBody = $mensaje2;
        $emailModel->sed();

      }
      */
  }

  //DECEVAL

  public function pagaresEstado()
  {
    $pagareModel = new Page_Model_DbTable_Pagaredeceval();
    $pagares = $pagareModel->getList("", "");
    $pagares2 = array();
    foreach ($pagares as $key => $value) {
      $pagares2[$value->pagare] = $value->estado;
    }
    return $pagares2;
  }

  function notificarUsuario($id)
  {

    $solicitudModel = new Administracion_Model_DbTable_Solicitudes();
    $id = $this->_getSanitizedParam("id");
    $this->_view->id = $id;
    $this->_view->numero = $numero = str_pad($id, 6, "0", STR_PAD_LEFT);
    $solicitud = $solicitudModel->getById($id);
    $nombre = $solicitud->nombres;
    if ($solicitud->nombres2) {
      $nombre = $nombre . " " . $solicitud->nombres2;
    }
    $nombre = $nombre . " " . $solicitud->apellido1;
    if ($solicitud->apellido2) {
      $nombre = $nombre . " " . $solicitud->apellido2;
    }
    $emailModel = new Core_Model_Mail();
    $asunto = " Notificacion cambio de condiciones solicitud de crédito WEB" . $numero . " - " . $nombre;
    $content = "<br>Señor asociado su solicitud radicada en día " . $solicitud->fecha . " le ha sido aprobada con las siguientes condiciones: ";

    $solicitudModel = new Administracion_Model_DbTable_Solicitudes();
    $solicitud = $solicitudModel->getById($id);

    $linea = $solicitud->linea;
    $linea2 = $solicitud->linea_desembolso;
    $lineaModel = new Administracion_Model_DbTable_Lineas();
    $lineas = $lineaModel->getList(" codigo='$linea' ", "")[0];
    $lineas2 = $lineaModel->getList(" codigo='$linea2' ", "")[0];

    $usuarioModel = new Administracion_Model_DbTable_Usuario();
    $cedula = $solicitud->cedula;
    $usuario = $usuarioModel->getList(" user_user = '$cedula' ", "")[0];

    $analista_id = $solicitud->asignado;
    $analista = $usuarioModel->getById($analista_id);

    $gestor_comercial1 = $solicitud->gestor_comercial;
    $gestor_comercial = $usuarioModel->getList(" nombre = 'gestor_comercial' ", "")[0];


    $tabla = $this->generartabla($numero, $usuario, $solicitud, $lineas, $analista, $lineas2);

    $content .= $tabla;


    $userModel = new Administracion_Model_DbTable_Usuario();
    $user = $userModel->getList(" user_user='$solicitud->cedula' ", "")[0];

    $email = $solicitud->correo_personal;
    $user_id = $usuario->user_id;
    $codificado = base64_encode($user_id);
    $codificado = str_replace("=", "_", $codificado);

    //envio
    $content1 = $content . "<br><br><br>Por favor utilice el siguiente enlace para indicar su aprobación: <a href='https://creditosfondtodos.com.co/page/cambiosolicitud/?id=" . $id . "&e=" . $codificado . "'><button type='button' class='btn btn-primary' style='background:#0084C9; color:#FFFFFF; padding:5px 10px;'>Ingresar</button></a>";

    $emailModel->getMail()->ClearAllRecipients();
    $emailModel->getMail()->setFrom("notificaciones@fondtodos.com", "Notificaciones Sistema Solicitud de créditos");
    $emailModel->getMail()->addBCC("desarrollo2@omegawebsystems.com");
    $emailModel->getMail()->addBCC("notificaciones@fondtodos.com");
    $emailModel->getMail()->addAddress("" . $email);
    $correo_analista = $analista->user_email;
    $emailModel->getMail()->addBCC("" . $correo_analista);
    $emailModel->getMail()->Subject = $asunto;
    $emailModel->getMail()->msgHTML($content1);
    $emailModel->getMail()->AltBody = $content;
    if ($emailModel->sed()) {
      return true;
    } else {
      return false;
    }
    //envio


    //header("Location:/administracion/solicitudes/comiteenviado/");

  }
  public function reenviarcambiocondicionesAction()
  {
    $id = $this->_getSanitizedParam("id");
    $this->notificarUsuario($id);
    $this->mainModel->editField($id, "notificacion_enviada", 1);
    header('Location: ' . $this->route . '' . '');
  }
  public function historialestadosAction()
  {
    $id = $this->_getSanitizedParam("id");
    $solicitudesModel = new Administracion_Model_DbTable_Solicitudes();
    $logestadoModel = new Administracion_Model_DbTable_Logestado();
    $this->_view->logestado = $logestadoModel->getList("solicitud=$id", "fecha ASC");
    $this->_view->id = $id;
    $solicitud = $solicitudesModel->getById($id);
    $this->_view->solicitud = $solicitud;
    $this->_view->list_estado_autorizo = $this->getEstadoautorizo();
    $validaciones = array("En estudio", "Aprobado", "Desembolsado", "Anulado", "Rechazado", "Procesado", "Aplazado");
    $validaciones[7] = "Cambio de condiciones";
    $validaciones[8] = "Pasar a desembolso";
    $this->_view->validaciones = $validaciones;
    $acepto_condiciones = array();
    $acepto_condiciones[1] = "Acepto cambio de condiciones";
    $acepto_condiciones[2] = "Rechazo cambio de condiciones";
    $this->_view->acepto_condiciones = $acepto_condiciones;

    $this->_view->usuarios = $this->getAsignado();

    $pagare = $solicitud->pagare;
    $pagareModel = new Page_Model_DbTable_Pagaredeceval();
    $existe_pagare = $pagareModel->getList(" pagare='$pagare' ", "");
    $this->_view->existe_pagare = $existe_pagare[0];

    $enviopagareModel = new Administracion_Model_DbTable_Enviopagare();
    $envios = $enviopagareModel->getList(" envio_solicitud='$id' ", " envio_fecha ASC ");
    $this->_view->envios = $envios;
  }
  public function exportarAction()
  {
    ini_set('max_execution_time', '300');
    ini_set('memory_limit', '512M');
    
    $order = "solicitudes.id DESC";
    $filtro = " AND solicitudes.paso = '8' AND solicitudes.asignado!='' AND solicitudes.asignado!='0' ";

    if ($_SESSION['kt_login_level'] == 3 or $_SESSION['kt_login_level'] == 12) { //analista
      $usuario = $_SESSION['kt_login_id'];
      if (($this->_getSanitizedParam('i') >= 0 and $this->_getSanitizedParam('i') != "") or $this->_getSanitizedParam('incompletas') == "1" or $this->_getSanitizedParam('sin_terminar') == "1") {
        if ($this->_getSanitizedParam('i') == 0) {
        }
      }
    }
    if ($this->_getSanitizedParam('i') != "") { //validacion
      $i = $this->_getSanitizedParam('i');

      $estado = $i;
      if ($i != "4" && $i != "5") {
        if ($i == "todas") {
        } else {
          $filtro .= "  AND solicitudes.validacion='$i' ";
        }
      }
      if ($i == "4") {
        $filtro .= " AND (solicitudes.validacion='$i' OR solicitudes.estado_autorizo='4') AND acepto_cambios!='2' AND vencimiento_aplazado!='1' AND vencimiento_aprobado!='1' ";
      }
      if ($i == "0") {

        $filtro .= " AND (solicitudes.validacion='0' AND solicitudes.estado_autorizo ='1') ";
      }
      if ($i == "5") {
        //echo "hola"; 
        $filtro .= " AND (solicitudes.validacion='0' AND solicitudes.estado_autorizo is NULL) ";
      }
      if ($i == "1") {
        //echo "hola"; 
        $filtro .= " AND ((confimar_solicitud=0 || confimar_solicitud is NULL) AND (acepto_cambios=0 || acepto_cambios is NULL) ) ";
      }
    }
    if ($this->_getSanitizedParam('incompletas') == "1") {
      $estado = "incompletas";
      $filtro = " AND solicitudes.validacion='3' AND (solicitudes.estado_autorizo = 0 or solicitudes.estado_autorizo is null ) AND vencimiento_aplazado!=1 AND vencimiento_aprobado!=1";
    }
    if ($this->_getSanitizedParam('sin_terminar') == "1") {
      $estado = "sin_terminar";
      $filtro = "  AND solicitudes.paso!='8' AND incompleta IS NULL ";
    }
    if ($this->_getSanitizedParam('confirmadas_asociado') == "1") {
      $estado = "confirmadas_asociado";
      $filtro = "AND (confimar_solicitud='1' || acepto_cambios='1') AND solicitudes.validacion='1' AND estado_autorizo!=4 ";
    }
    if ($this->_getSanitizedParam('rechazadas_asociado') == "1") {
      $estado = "rechazadas_asociado";
      $filtro = "AND acepto_cambios='2' || vencimiento_aplazado=1 || vencimiento_aprobado=1 ";
    }
    
    $fecha_asignado = $this->_getSanitizedParam('fecha_asignado');
    $fecha_asignado2 = $this->_getSanitizedParam('fecha_asignado2');
    if ($fecha_asignado != '') {
      $filtro = $filtro . " AND fecha_asignado >= '" . $fecha_asignado . "'";
    }
    if ($fecha_asignado2 != '') {
      $filtro = $filtro . " AND fecha_asignado <= '" . $fecha_asignado2 . "'";
    }    

    if ($_GET['prueba'] == "1") {
      echo $filtro;
    }
    $filters = $this->getFilter();
    $filters .= $filtro;
    //echo $filters;
    $order = " fecha_asignado DESC, fecha DESC ";
    if ($this->_getSanitizedParam('confirmadas_asociado') == "1") {
      $order = " fecha_aceptacion DESC ";
    }
    $list = $this->mainModel->getList2($filters, $order);
    $comiteModel = new Administracion_Model_DbTable_Comite();
    $usuarioModel = new Administracion_Model_DbTable_Usuario();
    foreach ($list as $value) {
      $id = $value->id;
      $tipo = 1;
      $value->quien_aprobo = "";
      $aprobado = count($comiteModel->getList(" comite_solicitud_id='$id' AND (comite_aprobacion='1' || comite_aprobacion='4') AND comite_tipo='$tipo' ", ""));
      if ($aprobado >= 2) {
        $value->quien_aprobo = "Comité de crédito";
      }
      $tipo = 3;
      $aprobado = count($comiteModel->getList(" comite_solicitud_id='$id' AND (comite_aprobacion='1' || comite_aprobacion='4') AND comite_tipo='$tipo' ", ""));
      if ($aprobado >= 3) {
        $value->quien_aprobo = "Junta directiva";
      }
      $tipo = 2;
      $aprobado = count($comiteModel->getList(" comite_solicitud_id='$id' AND (comite_aprobacion='1' || comite_aprobacion='4') AND comite_tipo='$tipo' ", ""));
      if ($aprobado >= 1) {
        $value->quien_aprobo = "Gerencia";
      }

      $quien = $value->quien;
      $quien_list = $usuarioModel->getById($quien);
      if ($quien_list->user_level == "3") {
        $value->quien_aprobo = "Analista";
      }
    }
    $this->_view->content = $list;
    $this->_view->linea_desembolso = $this->lineaDesembolso();
    //$this->_view->marca = $this->getMarca();
    //$this->_view->ciudades = $this->getCiudad();

    $this->setLayout('blanco');

    $hoy = date("YmdHis");

    $excel = $this->_getSanitizedParam("excel");

    //$this->_view->estado = $this->getEstado();
    
    //$this->_view->list_regional = $this->getRegional();
    //$this->_view->list_garantias = $this->getGarantias();   

    if ($excel == 1) {

      header("Content-Type:   application/vnd.ms-excel; charset=utf-8");

      header("Content-type:   application/x-msexcel; charset=utf-8");

      header("Content-Disposition: attachment; filename=solicitudes" . $hoy . ".xls");
    }
  }

  public function getGarantias()
  {
    $garantiasModel = new Administracion_Model_DbTable_Garantias();
    $garantias = $garantiasModel->getList("", " garantia_nombre ASC "); 
    $array = array();
    foreach ($garantias as $key => $value) {
      $linea2[$value->garantia_id] = $value->garantia_nombre;
    }
    return $linea2;    
  }
  public function lineaDesembolso()
  {
    $lineaModel = new Administracion_Model_DbTable_Lineas();
    $linea = $lineaModel->getList("", "");
    $linea2 = array();
    foreach ($linea as $key => $value) {
      $linea2[$value->codigo] = $value->nombre;
    }
    return $linea2;
  }
  public function solicitudgarantiasAction()
  {
    $id = $this->_getSanitizedParam("solicitud");
    $garantialineaModel = new Administracion_Model_DbTable_Garantialinea();
    $solicitudModel = new Administracion_Model_DbTable_Solicitudes();
    $solicitud = $solicitudModel->getById($id);
    $codigo = $solicitud->linea;
    $this->_view->solicitud = $solicitud;
    $garantiasModel = new Administracion_Model_DbTable_Garantias();
    $this->_view->garantias = $garantiasModel->getList("", " garantia_nombre ASC ");
  }
  public function updategarantiaAction()
  {
    $this->setLayout('blanco');
    $tipo_garantia = $this->_getSanitizedParam("tipo_garantia");
    $garantia_adicional = $this->_getSanitizedParam("garantia_adicional");
    $codeudorModel = new Administracion_Model_DbTable_Codeudor();
    //echo $tipo_garantia;
    $id = $this->_getSanitizedParam("id");
    $solicitudModel = new Administracion_Model_DbTable_Solicitudes();
    $solicitud = $solicitudModel->getById($id);
    $codeudorModel->borrar($id);

    if ($tipo_garantia) {

      //extract($_POST);
      if ($tipo_garantia == "2") {
        $this->_view->numero = $numero = str_pad($id, 6, "0", STR_PAD_LEFT);


        //codeudor1
        $data['solicitud'] = $id;
        $data['cedula'] = $this->_getSanitizedParam("documento_codeudor");
        $data['nombres'] = $this->_getSanitizedParam("nombres_codeudor");
        $data['nombres2'] = $this->_getSanitizedParam("nombres2_codeudor");
        $data['apellido1'] = $this->_getSanitizedParam("apellido1_codeudor");
        $data['apellido2'] = $this->_getSanitizedParam("apellido2_codeudor");
        $data['salario'] = 0;
        $data['correo'] = $this->_getSanitizedParam("correo_personal_codeudor");
        $data['codeudor_numero'] = "1";
        $codeudorModel->insert($data);

        //envio codeudor
        $emailModel = new Core_Model_Mail();

        $asunto = "Notificación Codeudor - Solicitud de crédito WEB" . $numero . "";


        $codeudor = $codeudorModel->getList(" solicitud='$id' AND codeudor_numero='1' ", "")[0];

        $correo = $codeudor->correo;
        $correo_codificado = md5($codeudor->cedula);
        $nombres_codeudor = $codeudor->nombres . " " . $codeudor->nombres2 . " " . $codeudor->apellido1 . " " . $codeudor->apellido2;
        $nombres_asociado = $solicitud->nombres . " " . $solicitud->nombres2 . " " . $solicitud->apellido1 . " " . $solicitud->apellido2;
        $valor = $solicitud->valor;

        $content = "Estimado(a) <b>" . $nombres_codeudor . "</b>, el/la asociado(a) <b>" . $nombres_asociado . "</b> te ha ingresado como codeudor en la solicitud de crédito <b>No. WEB" . $numero . "</b> del sistema de solicitudes de crédito de FONDTODOS por valor de <b>$" . number_format($valor) . "<b/><br><br>Por favor ingresa en el siguiente enlace para completar tu información personal: <a href='https://creditosfondtodos.com.co/page/codeudor/?id=" . $id . "&e=" . $correo_codificado . "&n=1'><button type='button' class='btn btn-primary' style='background:#0084C9; color:#FFFFFF; padding:5px 10px;'>Ingresar</button></a>";

        $emailModel->getMail()->ClearAllRecipients();
        $emailModel->getMail()->setFrom("notificaciones@fondtodos.com", "Notificaciones FONDTODOS");
        $emailModel->getMail()->addBCC("soporteomega@omegawebsystems.com");
        $emailModel->getMail()->addBCC("desarrollo2@omegawebsystems.com");
    $emailModel->getMail()->addBCC("notificaciones@fondtodos.com");
        $emailModel->getMail()->addAddress("" . $correo);

        $emailModel->getMail()->Subject = $asunto;
        $emailModel->getMail()->msgHTML($content);
        $emailModel->getMail()->AltBody = $content;
        $emailModel->sed();
      }

      $solicitudModel = new Administracion_Model_DbTable_Solicitudes();
      $solicitudModel->editField($id, "tipo_garantia", $tipo_garantia);
      $solicitudModel->editField($id, "garantia_adicional", $garantia_adicional);
    }
    header("location: /administracion/solicitudes/solicitudgarantias/?solicitud=" . $id . "&envio=1");
  }

  public function soatAction()
  {
    $id = $this->_getSanitizedParam("id");
    $this->_view->id = $id;
    $solicitudModel = new Administracion_Model_DbTable_Solicitudes();
    $this->_view->solicitud = $solicitudModel->getById($id);
  }
  public function enviarsoatAction()
  {
    $id = $this->_getSanitizedParam("id");
    $solicitudModel = new Administracion_Model_DbTable_Solicitudes();
    $uploadImage =  new Core_Model_Upload_Document();
    $this->_view->numero = $numero = str_pad($id, 6, "0", STR_PAD_LEFT);

    if ($_FILES['archivo']['name'] != '') {
      $archivo = $uploadImage->upload("archivo");
      $solicitudModel->editField($id, "archivo_soat", $archivo);
    }
    $solicitud = $solicitudModel->getById($id);
    $correo = $solicitud->correo_personal;
    $emailModel = new Core_Model_Mail();

    $asunto = "Notificación SOAT - Solicitud de crédito WEB" . $numero . "";

    $content = "
    <h3>Hola " . $solicitud->nombres . ' ' . $solicitud->nombres2 . ' ' . $solicitud->apellido1 . ' ' . $solicitud->apellido2 . "</h2>
    <br><br>
    En este correo encontraras adjunto tu plan de pagos de la solicitud WEB" . $numero;

    $userModel = new Administracion_Model_DbTable_Usuario();
    $analista = $userModel->getById($solicitud->asignado);
    $correo_analista = $analista->user_email;
    $nombre_analista = $analista->user_names;

    $emailModel->getMail()->ClearAllRecipients();
    $emailModel->getMail()->setFrom("notificaciones@fondtodos.com", "Notificaciones FONDTODOS");
    $emailModel->getMail()->addBCC("soporteomega@omegawebsystems.com");
    // $emailModel->getMail()->addBCC("soporteomega@omegawebsystems.com");
    $emailModel->getMail()->addBCC("desarrollo2@omegawebsystems.com");
    $emailModel->getMail()->addBCC("notificaciones@fondtodos.com");
    $emailModel->getMail()->addBCC($correo_analista);
    // $emailModel->getMail()->addBCC("katlyn.martinez@fondtodos.com");
    //$emailModel->getMail()->addBCC("desarrollo2@omegawebsystems.com");
    $emailModel->getMail()->addBCC("notificaciones@fondtodos.com");
    $emailModel->getMail()->addAddress("" . $correo);
    if ($archivo) {
      $emailModel->getMail()->AddAttachment(
        FILE_PATH . $solicitud->archivo_soat,
        $archivo
      );


      $emailModel->getMail()->Subject = $asunto;
      $emailModel->getMail()->msgHTML($content);
      $emailModel->getMail()->AltBody = $content;
      if ($emailModel->sed()) {
        $logestado = new Administracion_Model_DbTable_Logestado();
        $hoy = date("Y-m-d");
        $hora = date("H:i:s");
        $dataestado["solicitud"] = $id;
        $dataestado["estado"] = "Envio archivo SOAT";
        $dataestado["usuario"] = $_SESSION["kt_login_id"];
        $dataestado["fecha"] = $hoy . " " . $hora;
        $logestado->insert($dataestado);
        header('Location: ' . $this->route . '' . '');
      } else {
        header('Location: ' . $this->route . '?errorsoat=1' . '');
      }
    } else {
      header('Location: ' . $this->route . '?errorsoat=1' . '');
    }
  }
  public function editarcorreoAction()
  {
    $id = $this->_getSanitizedParam("solicitud");
    $solicitudModel = new Administracion_Model_DbTable_Solicitudes();
    $solicitud = $solicitudModel->getById($id);
    $this->_view->solicitud = $solicitud;
  }

  public function updatecorreosAction()
  {
    $this->setLayout('blanco');
    //echo $tipo_garantia;
    $id = $this->_getSanitizedParam("id");
    $correo_personal = $this->_getSanitizedParam("correo_personal");
    //echo $correo_personal;
    $correo_empresarial = $this->_getSanitizedParam("correo_empresarial");
    $solicitudModel = new Administracion_Model_DbTable_Solicitudes();
    $solicitud = $solicitudModel->getById($id);
    $solicitudModel->editField($id, "correo_personal", $correo_personal);
    $solicitudModel->editField($id, "correo_empresarial", $correo_empresarial);

    header("location: /administracion/solicitudes/editarcorreo/?solicitud=" . $id . "&envio=1");
  }
  public function aprobargerenciaAction()
  {
    $this->setLayout('blanco');
    $user_id = $_SESSION["kt_login_id"];
    $user_level = $_SESSION["kt_login_level"];
    if ($user_level == 8) {
      $id = $this->_getSanitizedParam("id");
      $codificado = base64_encode($user_id);
      $codificado = str_replace("=", "_", $codificado);
      $enlace = "/page/gerencia/?id=" . $id . "&e=" . $codificado;
      header("location: " . $enlace);
    }
  }
  public function aprobaranalistaAction()
  {
    $this->setLayout('blanco');
    $user_id = $_SESSION["kt_login_id"];
    $user_level = $_SESSION["kt_login_level"];
    if ($user_level == 3 || $user_level == 1) {
      $id = $this->_getSanitizedParam("id");
      $codificado = base64_encode($user_id);
      $codificado = str_replace("=", "_", $codificado);
      $enlace = "/page/analista/?id=" . $id . "&e=" . $codificado;
      header("location: " . $enlace);
    }
  }
  public function enviarcodeudorAction()
  {
    $id = $this->_getSanitizedParam("id");
    //envio codeudor
    $emailModel = new Core_Model_Mail();
    $this->_view->numero = $numero = str_pad($id, 6, "0", STR_PAD_LEFT);

    $asunto = "Notificación Codeudor - Solicitud de crédito WEB" . $numero . "";
    $solicitudModel = new Administracion_Model_DbTable_Solicitudes();
    $solicitud = $solicitudModel->getById($id);
    $codeudorModel = new Administracion_Model_DbTable_Codeudor();
    $codeudor = $codeudorModel->getList(" solicitud='$id' AND codeudor_numero='1' ", "")[0];

    $correo = $codeudor->correo;
    $correo_codificado = md5($codeudor->cedula);
    $nombres_codeudor = $codeudor->nombres . " " . $codeudor->nombres2 . " " . $codeudor->apellido1 . " " . $codeudor->apellido2;
    $nombres_asociado = $solicitud->nombres . " " . $solicitud->nombres2 . " " . $solicitud->apellido1 . " " . $solicitud->apellido2;
    $valor = $solicitud->valor;

    $content = "Estimado(a) <b>" . $nombres_codeudor . "</b>, el/la asociado(a) <b>" . $nombres_asociado . "</b> lo ha ingresado como codeudor en la solicitud de crédito <b>No. WEB" . $numero . "</b> del sistema de solicitudes de crédito de FONDTODOS por valor de <b>$" . number_format($valor) . "<b/><br><br>Por favor ingrese en el siguiente enlace para completar su información personal: <a href='https://creditosfondtodos.com.co/page/codeudor/?id=" . $id . "&e=" . $correo_codificado . "&n=1'><button type='button' class='btn btn-primary' style='background:#0084C9; color:#FFFFFF; padding:5px 10px;'>Ingresar</button></a>";

    $emailModel->getMail()->ClearAllRecipients();
    $emailModel->getMail()->setFrom("notificaciones@fondtodos.com", "Notificaciones FONDTODOS");
    $emailModel->getMail()->addBCC("soporteomega@omegawebsystems.com");
    $emailModel->getMail()->addBCC("desarrollo2@omegawebsystems.com");
    $emailModel->getMail()->addBCC("notificaciones@fondtodos.com");
    $emailModel->getMail()->addAddress("" . $correo);

    $emailModel->getMail()->Subject = $asunto;
    $emailModel->getMail()->msgHTML($content);
    $emailModel->getMail()->AltBody = $content;
    if ($emailModel->sed()) {
      echo "envio";
    };
  }
  public function solicitudpdfAction()
  {
    //$this->setLayout('blanco');
    //$this->getLayout()->setData("header","");
    //require_once VENDOR_PATH . 'autoload.php';
    //echo VENDOR_PATH . 'autoload.php';
    $this->setLayout('blanco');
    //ini_set("pcre.backtrack_limit", "5000000");
    //$this->setLayout('blanco');
    ini_set("memory_limit", -1);
    ini_set('max_execution_time', '90');
    //$this->getLayout()->setData("panel_header","");
    //$this->getLayout()->setData("panel_botones","");
    $id = $this->_getSanitizedParam("id");
    $prueba = $this->_getSanitizedParam("prueba");
    $bootstrap = $this->_getSanitizedParam("bootstrap");
    //echo $id;
    //echo phpinfo();
    $mpdf = new \Mpdf\Mpdf();

    $mpdf->setDisplayMode('fullpage');
    $host = "http://creditosfondtodos.com.co";
    // $host = "http://localhost:8043";
    //$mpdf->AddPage("");
    $header = "<img src='/skins/page/images/logo.png' width='250px' />  ";
    //$mpdf->SetHTMLHeader($header, '1', true);
    $url = "/page/sistema/paso1pdf/";
    //echo $host . $url."?id=".$id."&mod=detalle_solicitud";
    //$this->_view->getRoutPHP('modules/page/Views/sistema/paso1.php');
    //$contenido =$this->_view->getRoutPHP('modules/page/Views/sistema/paso1.php');

    $contenido = file_get_contents($host . $url . "?id=" . $id . "&mod=detalle_solicitud&monto=1&prueba=" . $prueba);

    //$contenido = str_replace("http://auditoria.construye.coop",$host,$contenido);
    // $contenido = str_replace('src="/images/', 'src="' . $host . '/images/', $contenido);
    //$contenido = str_replace('src="/corte/', 'src="' . $host . '/corte/', $contenido);
    $contenido = html_entity_decode($contenido);
    $html = $contenido;
    //echo $html;

    if ($bootstrap == 1) {
      $stylesheet = file_get_contents('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css');
      $customCss = '
      .w-100{
        width:100% !important;
      }
      .caja-campo{
        background-color:#eee;
        padding: 3px 9px;
        border-radius:4px;
        border: 1px solid #ccc;
        height:20px;
      }
      .checkbox{
        background-color:#eee;
        width: 15px;
        height: 15px;
        border-radius:4px;
        border: 1px solid #ccc;
      }
      
      .form-control{
        display:content !important;
      }
      .titulo-seccion{
        font-size: 16px;
        font-weight: bold;
        color: #FFF;
        margin-bottom: 10px;
        margin-top: 20px;
        background: #EBF0F6;
        background:#88a231;
        padding: 10px;
        border-radius: 18px;
      }
      table,
      th,
      td {
        border: 1px solid black;
        border-collapse: collapse;
      }
      .row {
        margin-left: 0; 
        margin-right: 0; 
      }
      
      .row .col-xs-1, .row .col-xs-2, .row .col-xs-3, .row .col-xs-4, .row .col-xs-5, .row .col-xs-6, .row .col-xs-7, .row .col-xs-8, .row .col-xs-9, .row .col-xs-10, .row .col-xs-11, .row .col-xs-12 {
        padding-left: 0;
        padding-right: 0;
      }
      .col-lg-1{
        width:7%;
        float:left;
      }
      .col-lg-2{
        width:13%;
        float:left;
      }
      .col-lg-3{
        width:23%;
        float:left;
      }
      .col-lg-4{
        width:33%;
        float:left;
      }
      .col-lg2-4{
        width:31.5%;
        float:left;
      }
      .col-lg-5{
        width:37.5%;
        float:left;
      }
      .col-lg-6{
        width:47.5%;
        float:left;
      }
      .col-lg-7{
        width:57.5%;
        float:left;
      }
      body { 
    font-size: 9pt; 
}
      label{}
      @page {
      margin-header: 0mm;  
  margin-top: 120px;

     margin-left: 0px;
   margin-right: 0px;
   font-size:8px !important;
    header: header_name;
 footer: footer_name;
    }
  
      .px{
        padding-left: 6px !important;
        padding-right: 6px !important;
      }
      
      .user_redondo {
        background: #66a3e0;
        border: 0;
        border-bottom-left-radius: 0px;
        border-bottom-right-radius: 0px;
        border-bottom: 2px #FFFFFF solid;
      }
      .page_break {
        page-break-before: always;
      }
      
      .tabla_sin, .tabla_sin td, .tabla_sin tr{
        border: #FFFFFF 1px solid white !important;
      }
      .mb-3{
      margin-bottom:7px 
      }
      
      ';

      $combinedCss = $stylesheet . $customCss;


      $mpdf->WriteHTML($combinedCss, 1);

      $mpdf->WriteHTML($html);
    }
    if ($_GET["prueba"] != 1) {
      //$mpdf->WriteHTML($html);  
      $mpdf->Output();
    } else {
      echo $html;
    }
  }

  public function planAction()
  {
    $this->_view->solicitud = $solicitud = $this->_getSanitizedParam('id');
  }

  public function enviarplanAction()
  {
    $solicitud = $this->_getSanitizedParam('id');

    $solicitudesModel = new Administracion_Model_DbTable_Solicitudes();

    $uploadDocument =  new Core_Model_Upload_Document();
    if ($_FILES['archivo']['name'] != '') {
      $doc = $uploadDocument->upload("archivo");
    }

    $data = $solicitudesModel->getById($solicitud);

    $userModel = new Administracion_Model_DbTable_Usuario();
    $analista = $userModel->getById($data->asignado);
    $data->correo_analista = $analista->user_email;
    $data->nombre_analista = $analista->user_names;

    $emailModel = new Core_Model_Sendingemail($this->_view);
    if ($emailModel->enviarplan($data, $doc) == 1) {
      $this->_view->message = "El plan de pagos se ha enviado correctamente";
      $logestadoModel = new Administracion_Model_DbTable_Logestado();
      $data = array(
        'id_solicitud' => $solicitud,
        'id_estado' => 'Plan de pagos enviado',
        'id_usuario' => Session::getInstance()->get('kt_login_id'),
        'fecha' => date('Y-m-d H:i:s'),
        'observacion' => ''
      );
      $logestadoModel->insert($data);
    } else {
      $this->_view->message = "Ha ocurrido un error al enviar el plan de pagos, por favor intente nuevamente";
    }
  }

  public function messageAction()
  {
    $this->_view->id = $this->_getSanitizedParam('id');
  }

  public function sendmessageAction()
  {
    $solicitud = $this->_getSanitizedParam('id');

    $solicitudesModel = new Administracion_Model_DbTable_Solicitudes();

    $data = $solicitudesModel->getById($solicitud);
    $data->mensaje_correo = $this->_getSanitizedParamHtml('mensaje');
    $data->asunto_correo = $this->_getSanitizedParamHtml('asunto');

    $userModel = new Administracion_Model_DbTable_Usuario();
    $analista = $userModel->getById($data->asignado);
    $data->correo_analista = $analista->user_email;
    $data->nombre_analista = $analista->user_names;

    $emailModel = new Core_Model_Sendingemail($this->_view);
    if ($emailModel->sendmessage($data) == 1) {
      $this->_view->message = "El mensaje se ha enviado correctamente";
      $logestadoModel = new Administracion_Model_DbTable_Logestado();
      $data_log = array();
      $data_log['solicitud'] = $solicitud;
      $data_log['estado'] = 'Mensaje enviado: '.$data->asunto_correo;
      $data_log['usuario'] = Session::getInstance()->get('kt_login_id');
      $data_log['fecha'] = date('Y-m-d H:i:s');
      $data_log['observacion'] = $data->mensaje_correo;
      $logestadoModel->insert($data_log);
    } else {
      $this->_view->message = "Ha ocurrido un error al enviar el mensaje, por favor intente nuevamente";
    }
  }
  public function cartapdfAction()
  {

    $id = $this->_getSanitizedParam('id');

    $solicitudesModel = new Administracion_Model_DbTable_Solicitudes();
    $solicitud = $solicitudesModel->getById($id);

    $compromisoModel = new Administracion_Model_DbTable_Cartacompromiso();
    $carta = $compromisoModel->getList("solicitud = $id", "")[0];
    $idCarta = $carta->id;
    $obligacionesModel = new Administracion_Model_DbTable_Obligaciones();
    $obligaciones = $obligacionesModel->getList("id_carta = '$idCarta'", "");

    $mpdf = new \Mpdf\Mpdf();

    $mpdf->setDisplayMode('fullpage');

    $stylesheet = file_get_contents('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css');
    $customCss = '
      .w-100{
        width:100% !important;
      }
      .caja-campo{
        background-color:#eee;
        padding: 3px 9px;
        border-radius:4px;
        border: 1px solid #ccc;
        height:20px;
      }
      .checkbox{
        background-color:#eee;
        width: 15px;
        height: 15px;
        border-radius:4px;
        border: 1px solid #ccc;
      }
      
      .form-control{
        display:content !important;
      }
      .titulo-seccion{
        font-size: 16px;
        font-weight: bold;
        color: #FFF;
        margin-bottom: 10px;
        margin-top: 20px;
        background: #EBF0F6;
        background:#88a231;
        padding: 10px;
        border-radius: 18px;
      }
      table,
      th,
      td {
        border: 1px solid black;
        border-collapse: collapse;
      }
      .row {
        margin-left: 0; 
        margin-right: 0; 
      }
      
      .row .col-xs-1, .row .col-xs-2, .row .col-xs-3, .row .col-xs-4, .row .col-xs-5, .row .col-xs-6, .row .col-xs-7, .row .col-xs-8, .row .col-xs-9, .row .col-xs-10, .row .col-xs-11, .row .col-xs-12 {
        padding-left: 0;
        padding-right: 0;
      }
      .col-lg-1{
        width:7%;
        float:left;
      }
      .col-lg-2{
        width:13%;
        float:left;
      }
      .col-lg-3{
        width:23%;
        float:left;
      }
      .col-lg-4{
        width:33%;
        float:left;
      }
      .col-lg2-4{
        width:31.5%;
        float:left;
      }
      .col-lg-5{
        width:37.5%;
        float:left;
      }
      .col-lg-6{
        width:47.5%;
        float:left;
      }
      .col-lg-7{
        width:57.5%;
        float:left;
      }
      body { 
        font-size: 9pt; 
      }
      label{}
      @page {
        margin-header: 0mm;  
        margin-top: 120px;
        margin-left: 0px;
        margin-right: 0px;
        font-size:8px !important;
        header: header_name;
        footer: footer_name;
      }
  
      .px{
        padding-left: 6px !important;
        padding-right: 6px !important;
      }
      
      .user_redondo {
        background: #66a3e0;
        border: 0;
        border-bottom-left-radius: 0px;
        border-bottom-right-radius: 0px;
        border-bottom: 2px #FFFFFF solid;
      }
      .page_break {
        page-break-before: always;
      }
      
      .tabla_sin, .tabla_sin td, .tabla_sin tr{
        border: #FFFFFF 1px solid white !important;
      }
      .mb-3{
        margin-bottom:7px 
      }
      
      ';

    $combinedCss = $stylesheet . $customCss;



    $nombre = $solicitud->nombres . ' ' . $solicitud->nombres2 . ' ' . $solicitud->apellido1 . ' ' . $solicitud->apellido2;
    $mpdf->WriteHTML($combinedCss, 1);
    $html = '
      <div class="container px-4">
        <div class="row">
          <div class="col-12">
            <div class="row justify-content-center titulo-seccion no-padding">CARTA DE COMPROMISO
              CANCELACIÓN DE OBLIGACIONES Y
              LEGALIZACIÓN DE GARANTIAS</div>
            <p class="text-justify">Yo, <span
                style="text-decoration:underline;color:#000">' . $nombre . '</span> identificado con
              cédula de
              ciudadanía número <span style="text-decoration:underline;color:#000">' . $solicitud->cedula . '</span> me
              comprometo con el Fondo de
              Empleados D1 SAS FONDTODOS a suministrar los siguientes documentos:</p>

            <p class="text-justify">1. Para las líneas de créditos como: compra de cartera, educación y otras que
              requieran comprobantes de pago, me comprometo a presentar en un plazo
              máximo de cinco (5) días hábiles a partir de la fecha de desembolso, los soportes
              correspondientes a las obligaciones canceladas, las cuales se relacionan a
              continuación:</p>

            <table class="table table-bordered">
              <thead>
                <tr>
                  <th scope="col">ENTIDAD</th>
                  <th scope="col">TIPO PRODUCTO/ N° OBLIGACION</th>
                  <th scope="col">VALOR
                  </th>
                </tr>
              </thead>
              <tbody>
    ';
    foreach ($obligaciones as $obligacion) {
      $html .= '
                <tr>
                  <td>
                    <div class="caja-campo">' . $obligacion->entidad . '</div>
                  </td>
                  <td>
                    <div class="caja-campo">' . $obligacion->numero_obligacion . '</div>
                  </td>
                  <td>
                    <div class="caja-campo">' . $obligacion->valor . '</div>
                  </td>
                </tr>
          ';
    }
    $html .= '
              </tbody>
            </table>
            <p class="text-justify">2. Para las líneas de créditos con garantía prendaria (Vehículo) me comprometo a
              constituir la garantía a nombre de FONDTODOS en un plazo de cinco (5) días hábiles
              como máximo, tiempo que transcurrirá a partir de la fecha de desembolso.</p>
            <p class="text-justify">
              3. Entiendo acepto y autorizo, que tanto en los puntos 1 y 2 del presente documento
              se modifique por parte de Fondtodos la tasa de interés y la línea de crédito,
              correspondientes a la línea de libre inversión, lo cual aplicará para toda la vigencia
              del crédito, si no llegare a cumplir con dichos soportes en los tiempos aquí
              definidos.
            </p>
            <p class="text-justify">A través del presente documento manifiesto estar siendo notificado de que los correos a
              los cuales debo enviar los soportes pertinentes son: <a
                href="mailto:yenny.berdugo@fonkoba.com">yenny.berdugo@fonkoba.com</a> y
              <a href="mailto:katlyn.martinez@fonkoba.com">katlyn.martinez@fonkoba.com</a> indicando en el asunto la palabra
              soporte de pago con el
              respectivo número de cedula.
            </p>

            <div id="firma"></div>

            <div id="signatureShow" class="d-flex align-items-baseline">
              <span class="mr-2 font-weight-bold">Firma: </span>
              <h4>
                ' . $carta->firma . '
              </h4>
            </div>

            <div class="fecha_firma mb-3 text-start">
              <span class="font-weight-bold text-start">
                Fecha: 
              </span>
              <span>
                ' . $carta->fecha_firma . '
              </span>
            </div>
          </div>
        </div>
      </div>
    ';
    $mpdf->WriteHTML($html);
    if ($_GET["prueba"] != 1) {
      //$mpdf->WriteHTML($html);  
      $mpdf->Output();
    } else {
      echo $html;
    }
  }
}
