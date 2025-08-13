<?php

/**
 *
 */

class Administracion_reportesfonkobaController extends Administracion_mainController
{

  public $botonpanel = 23;
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



  public function indexAction()
  {
    $title = "Reportes";
    $this->getLayout()->setTitle($title);
    $this->_view->titlesection = $title;
  }

  public function solicitudes_estadoAction()
  {
    $title = "Solicitudes por estado";
    $this->getLayout()->setTitle($title);
    $this->_view->titlesection = $title;

    $this->_view->validaciones = $validaciones = array("En estudio", "Aprobado", "Desembolsado", "Anulado", "Rechazado", "Procesado", "Aplazado", "Incompletas");


    $solicitudModel = new Administracion_Model_DbTable_Solicitudes();
    $f1 = " 1=1 ";
    $f2 = " 1=1 ";
    $fecha1 = $this->_getSanitizedParam("fecha1");
    $fecha2 = $this->_getSanitizedParam("fecha2");
    if ($fecha1 != "" and $fecha2 != "") {
      $f1 .= " AND (solicitudes.fecha_asignado >= '$fecha1' AND solicitudes.fecha_asignado <= '$fecha2') ";
      $f2 .= " AND (solicitudes.fecha_asignado >= '$fecha1' AND solicitudes.fecha_asignado <= '$fecha2') ";
    }

    $f1 .= " AND solicitudes.paso = '8' AND solicitudes.asignado!='' AND solicitudes.asignado!='0' ";
    $totales = array();

    for ($i = 0; $i <= 4; $i++) {
      $validacion = $i;
      $totales[$i] = $solicitudModel->getTotal(" validacion = '$validacion' AND $f1 ", "")[0];
      if ($i == 4) {
        $totales[$i] = $solicitudModel->getTotal(" (validacion = '$validacion' OR solicitudes.estado_autorizo='4') AND $f1 ", "")[0];
      }
      if ($i == 0) {
        $totales[$i] = $solicitudModel->getTotal(" (validacion = '$validacion' AND (solicitudes.estado_autorizo!='4' OR solicitudes.estado_autorizo IS NULL)) AND $f1 ", "")[0];
      }
    }
    $totales['7'] = $solicitudModel->getTotal(" solicitudes.paso!='8' AND incompleta IS NOT NULL AND $f2 ", "")[0];
    $this->_view->totales = $totales;

    //$this->_view->total_solicitudes = count($solicitudModel->getList("$f1",""));
    if ($_GET['prueba'] == "1" or 1 == 1) {
      $total_solicitudes = 0;
      //print_r($totales);
      foreach ($totales as $key => $value) {
        $total_solicitudes += $value->total;
      }
      $this->_view->total_solicitudes = $total_solicitudes;
    }
  }

  public function solicitudes_pasoAction()
  {
    $title = "Solicitudes no finalizadas";
    $this->getLayout()->setTitle($title);
    $this->_view->titlesection = $title;

    $this->_view->validaciones = $validaciones = array("1", "2", "3", "4", "5", "6");

    $solicitudModel = new Administracion_Model_DbTable_Solicitudes();
    $f1 = " 1=1 ";
    $fecha1 = $this->_getSanitizedParam("fecha1");
    $fecha2 = $this->_getSanitizedParam("fecha2");
    if ($fecha1 != "" and $fecha2 != "") {
      $f1 .= " AND (solicitudes.fecha_asignado >= '$fecha1' AND solicitudes.fecha_asignado <= '$fecha2') ";
    }

    $f1 .= " AND solicitudes.paso != '7' ";
    $totales = array();

    for ($i = 0; $i <= count($validaciones); $i++) {
      $validacion = $i;
      $totales[$i] = $solicitudModel->getTotal(" paso = '$validacion' AND $f1 ", "")[0];
    }
    $this->_view->totales = $totales;

    $this->_view->total_solicitudes = count($solicitudModel->getList("$f1", ""));
  }

  public function solicitudes_lineaAction()
  {
    $title = "Solicitudes por línea";
    $this->getLayout()->setTitle($title);
    $this->_view->titlesection = $title;

    $lineasModel = new Administracion_Model_DbTable_Lineas();
    $solicitudModel = new Administracion_Model_DbTable_Solicitudes();
    $f1 = " 1=1 ";
    $fecha1 = $this->_getSanitizedParam("fecha1");
    $fecha2 = $this->_getSanitizedParam("fecha2");
    if ($fecha1 != "" and $fecha2 != "") {
      $f1 .= " AND (solicitudes.fecha_asignado >= '$fecha1' AND solicitudes.fecha_asignado <= '$fecha2') ";
    }

    $f1 .= " AND solicitudes.paso = '8' AND solicitudes.asignado!='' AND solicitudes.asignado!='0' ";
    $totales = array();

    $this->_view->lineas = $lineas = $lineasModel->getList(" activo='1' ", " nombre ASC ");
    foreach ($lineas as $key => $linea) {
      $linea_id = $linea->codigo;
      $totales[$key] = $solicitudModel->getTotal(" linea = '$linea_id' AND $f1 ", "")[0];
    }
    $this->_view->totales = $totales;

    $this->_view->total_solicitudes = count($solicitudModel->getList("$f1", ""));
  }

  public function solicitudes_gestionAction()
  {
    $title = "Gestión de Solicitudes";
    $this->getLayout()->setTitle($title);
    $this->_view->titlesection = $title;

    $this->_view->validaciones = $validaciones = array("Menos de 1 dia", "1 dia", "2 dias", "3 dias", "4 dias", "5 dias", "6 dias", "7 dias o mas");

    $solicitudModel = new Administracion_Model_DbTable_Solicitudes();
    $f1 = " 1=1 ";
    $fecha1 = $this->_getSanitizedParam("fecha1");
    $fecha2 = $this->_getSanitizedParam("fecha2");
    if ($fecha1 != "" and $fecha2 != "") {
      $f1 .= " AND (solicitudes.fecha_asignado >= '$fecha1' AND solicitudes.fecha_asignado <= '$fecha2') ";
    }

    $f1 .= " AND solicitudes.paso = '8' AND solicitudes.asignado!='' AND solicitudes.asignado!='0' AND validacion='2' ";
    $totales = array();

    $solicitudes = $solicitudModel->getList("$f1", "");
    foreach ($solicitudes as $key => $solicitud) {
      $dif = $this->diferencia($solicitud->fecha_estado, $solicitud->fecha_asignado);
      $categoria = $this->calcular_categoria($dif);
      $totales[$categoria]++;
    }
    $this->_view->totales = $totales;
    $this->_view->total_solicitudes = count($solicitudModel->getList("$f1", ""));
  }


  public function solicitudes_gestion2Action()
  {
    $title = "Gestión de Solicitudes";
    $this->getLayout()->setTitle($title);
    $this->_view->titlesection = $title;

    $this->_view->validaciones = $validaciones = array("Menos de 1 dia", "1 dia", "2 dias", "3 dias", "4 dias", "5 dias", "6 dias", "7 dias o mas");

    $solicitudModel = new Administracion_Model_DbTable_Solicitudes();
    $usuariosModel = new Administracion_Model_DbTable_Usuario();
    $f1 = " 1=1 ";
    $fecha1 = $this->_getSanitizedParam("fecha1");
    $fecha2 = $this->_getSanitizedParam("fecha2");
    if ($fecha1 != "" and $fecha2 != "") {
      $f1 .= " AND (solicitudes.fecha_asignado >= '$fecha1' AND solicitudes.fecha_asignado <= '$fecha2') ";
    }

    $f1 .= " AND solicitudes.paso = '8' AND solicitudes.asignado!='' AND solicitudes.asignado!='0' AND validacion='2' ";
    $totales = array();

    $solicitudes = $solicitudModel->getList("$f1", "");
    foreach ($solicitudes as $key => $solicitud) {
      $dif = $this->diferencia($solicitud->fecha_estado, $solicitud->fecha_asignado);
      $categoria = $this->calcular_categoria($dif);
      $totales[$categoria]++;
      $analista = $solicitud->asignado;
      $totales2[$analista][$categoria]++;
    }
    $this->_view->totales = $totales;
    $this->_view->totales2 = $totales2;
    $this->_view->total_solicitudes = count($solicitudModel->getList("$f1", ""));

    $this->_view->analistas = $usuariosModel->getList(" user_level='3' ", "");
  }

  public function calcular_categoria($x)
  {
    $categorias = array("Menos de 1 dia", "1 dia", "2 dias", "3 dias", "4 dias", "5 dias", "6 dias", "7 dias o mas");
    if ($x < 1) {
      $cat = 0;
    }
    if ($x >= 1) {
      $cat = 1;
    }
    if ($x >= 2) {
      $cat = 2;
    }
    if ($x >= 3) {
      $cat = 3;
    }
    if ($x >= 4) {
      $cat = 4;
    }
    if ($x >= 5) {
      $cat = 5;
    }
    if ($x >= 6) {
      $cat = 6;
    }
    if ($x >= 7) {
      $cat = 7;
    }
    return $categorias[$cat];
  }

  public function diferencia($fecha_i, $fecha_f)
  {
    $dias   = (strtotime($fecha_i) - strtotime($fecha_f)) / 86400;
    $dias = round($dias, 2);
    return $dias;
  }
}
