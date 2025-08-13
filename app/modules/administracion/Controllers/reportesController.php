<?php

/**
 *
 */

class Administracion_reportesController extends Administracion_mainController
{

  public $botonpanel = 13;
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
    $fecha1d = $this->_getSanitizedParam("fecha1d");
    $fecha2d = $this->_getSanitizedParam("fecha2d");
    if ($fecha1 != "" and $fecha2 != "") {
      $f1 .= " AND (solicitudes.fecha_asignado >= '$fecha1' AND solicitudes.fecha_asignado <= '$fecha2') ";
      $f2 .= " AND (solicitudes.fecha_asignado >= '$fecha1' AND solicitudes.fecha_asignado <= '$fecha2') ";
    }
    if ($fecha1d != "" and $fecha2d != "") {
      $f1 .= " AND (solicitudes.fecha_desembolso >= '$fecha1d' AND solicitudes.fecha_desembolso <= '$fecha2d') ";
      $f2 .= " AND (solicitudes.fecha_desembolso >= '$fecha1d' AND solicitudes.fecha_desembolso <= '$fecha2d') ";
    }

    $f1 .= " AND solicitudes.paso = '8' AND solicitudes.asignado!='' AND solicitudes.asignado!='0' ";
    $totales = array();

    for ($i = 0; $i <= 4; $i++) {
      $validacion = $i;
      $totales[$i] = $solicitudModel->getTotal(" validacion = '$validacion' AND $f1 ", "")[0];
      if ($i == 4) {
        $totales[$i] = $solicitudModel->getTotal(" (solicitudes.validacion='$i' OR solicitudes.estado_autorizo='4') AND acepto_cambios!='2' AND vencimiento_aplazado!='1' AND vencimiento_aprobado!='1' AND $f1 ", "")[0];
      }
      if ($i == 0) {
        $f2 = " AND (solicitudes.validacion='0' AND solicitudes.estado_autorizo ='1') ";
        $totales[$i] = $solicitudModel->getTotal(" (validacion = '$validacion' $f2 AND $f1 ", "")[0];
      }

      if ($i == 1) {
        $f2 = " AND ((confimar_solicitud=0 || confimar_solicitud is NULL) AND (acepto_cambios=0 || acepto_cambios is NULL) ) ";
        $totales[$i] = $solicitudModel->getTotal(" (validacion = '$validacion' AND $f1 $f2 ", "")[0];
      }
      if ($i == 5) {
        $f2 = " AND (solicitudes.validacion='0' AND solicitudes.estado_autorizo is NULL) ";
        $totales[$i] = $solicitudModel->getTotal(" (validacion = '$validacion' AND $f1 $f2 ", "")[0];
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

  public function solicitudesAction()
  {
    $fecha_aprobacion_start = $this->_getSanitizedParam("fecha_aprobacion_start");
    $fecha_aprobacion_end = $this->_getSanitizedParam("fecha_aprobacion_end");
    $fecha_desembolso_start = $this->_getSanitizedParam("fecha_desembolso_start");
    $fecha_desembolso_end = $this->_getSanitizedParam("fecha_desembolso_end");
    $fecha_asignado_start = $this->_getSanitizedParam("fecha_asignado_start");
    $fecha_asignado_end = $this->_getSanitizedParam("fecha_asignado_end");
    $this->_view->fecha_aprobacion_start = $fecha_aprobacion_start;
    $this->_view->fecha_aprobacion_end = $fecha_aprobacion_end;
    $this->_view->fecha_desembolso_start = $fecha_desembolso_start;
    $this->_view->fecha_desembolso_end = $fecha_desembolso_end;
    $this->_view->fecha_asignado_start = $fecha_asignado_start;
    $this->_view->fecha_asignado_end = $fecha_asignado_end;
    $cleanfilter = $this->_getSanitizedParam("cleanfilter");

    $solicitudModel = new Administracion_Model_DbTable_Solicitudes();

    $f1 = " validacion = '2' ";
    if($fecha_aprobacion_start!="" and $fecha_aprobacion_end!=""){
      $f1 .= " AND (solicitudes.fecha_aprobacion >= '$fecha_aprobacion_start' AND solicitudes.fecha_aprobacion <= '$fecha_aprobacion_end') ";
    }
    if($fecha_desembolso_start!="" and $fecha_desembolso_end!=""){
      $f1 .= " AND (solicitudes.fecha_desembolso >= '$fecha_desembolso_start' AND solicitudes.fecha_desembolso <= '$fecha_desembolso_end') ";
    }
    if($fecha_asignado_start!="" and $fecha_asignado_end!=""){
      $f1 .= " AND (solicitudes.fecha_asignado >= '$fecha_asignado_start' AND solicitudes.fecha_asignado <= '$fecha_asignado_end') ";
    }
    if($fecha_asignado_start == "" and $fecha_asignado_end == ""	 and $fecha_aprobacion_start == "" and $fecha_aprobacion_end == "" and $fecha_desembolso_start == "" and $fecha_desembolso_end == ""){
      $fecha_1 = date("Y-m-d", strtotime("-1 month"));
      $fecha_2 = date("Y-m-d");
      $f1 .= " AND (solicitudes.fecha_desembolso >= '$fecha_1' AND solicitudes.fecha_desembolso <= '$fecha_2') ";
    }
    if($cleanfilter=="1"){
      $fecha_1 = date("Y-m-d", strtotime("-1 month"));
      $fecha_2 = date("Y-m-d");
      $f1 .= " AND (solicitudes.fecha_desembolso >= '$fecha_1' AND solicitudes.fecha_desembolso <= '$fecha_2') ";
    }

    $this->_view->solicitudes = $solicitudes = $solicitudModel->getOnlyDates("$f1", " fecha_asignado DESC ");
  }

  public function exportsoliAction()
  {
    $this->setLayout('blanco');
    $fecha_aprobacion_start = $this->_getSanitizedParam("fecha_aprobacion_start");
    $fecha_aprobacion_end = $this->_getSanitizedParam("fecha_aprobacion_end");
    $fecha_desembolso_start = $this->_getSanitizedParam("fecha_desembolso_start");
    $fecha_desembolso_end = $this->_getSanitizedParam("fecha_desembolso_end");
    $fecha_asignado_start = $this->_getSanitizedParam("fecha_asignado_start");
    $fecha_asignado_end = $this->_getSanitizedParam("fecha_asignado_end");
    $this->_view->fecha_aprobacion_start = $fecha_aprobacion_start;
    $this->_view->fecha_aprobacion_end = $fecha_aprobacion_end;
    $this->_view->fecha_desembolso_start = $fecha_desembolso_start;
    $this->_view->fecha_desembolso_end = $fecha_desembolso_end;
    $this->_view->fecha_asignado_start = $fecha_asignado_start;
    $this->_view->fecha_asignado_end = $fecha_asignado_end;
    $cleanfilter = $this->_getSanitizedParam("cleanfilter");

    $solicitudModel = new Administracion_Model_DbTable_Solicitudes();

    $f1 = " validacion = '2' ";
    if($fecha_aprobacion_start!="" and $fecha_aprobacion_end!=""){
      $f1 .= " AND (solicitudes.fecha_aprobacion >= '$fecha_aprobacion_start' AND solicitudes.fecha_aprobacion <= '$fecha_aprobacion_end') ";
    }
    if($fecha_desembolso_start!="" and $fecha_desembolso_end!=""){
      $f1 .= " AND (solicitudes.fecha_desembolso >= '$fecha_desembolso_start' AND solicitudes.fecha_desembolso <= '$fecha_desembolso_end') ";
    }
    if($fecha_asignado_start!="" and $fecha_asignado_end!=""){
      $f1 .= " AND (solicitudes.fecha_asignado >= '$fecha_asignado_start' AND solicitudes.fecha_asignado <= '$fecha_asignado_end') ";
    }
    if($fecha_asignado_start == "" and $fecha_asignado_end == ""	 and $fecha_aprobacion_start == "" and $fecha_aprobacion_end == "" and $fecha_desembolso_start == "" and $fecha_desembolso_end == ""){
      $fecha_1 = date("Y-m-d", strtotime("-1 month"));
      $fecha_2 = date("Y-m-d");
      $f1 .= " AND (solicitudes.fecha_desembolso >= '$fecha_1' AND solicitudes.fecha_desembolso <= '$fecha_2') ";
    }
    if($cleanfilter=="1"){
      $fecha_1 = date("Y-m-d", strtotime("-1 month"));
      $fecha_2 = date("Y-m-d");
      $f1 .= " AND (solicitudes.fecha_desembolso >= '$fecha_1' AND solicitudes.fecha_desembolso <= '$fecha_2') ";
    }

    $solicitudes = $solicitudModel->getOnlyDates("$f1", " fecha_asignado DESC ");
    $table = '';
    $table .= '
      <table class="table table-bordered mt-3">
        <thead>
          <tr>
            <th>ID</th>
            <th>Fecha Aprobación</th>
            <th>Radicación</th>
            <th>Fecha Desembolso</th>
          </tr>
        </thead>
        <tbody>
    ';

    foreach($solicitudes as $s){
      $table .= '
        <tr>
          <td>'.$s->id.'</td>
          <td>'.$s->fecha_aprobado.'</td>
          <td>'.$s->fecha_asignado.'</td>
          <td>'.$s->fecha_desembolso.'</td>
        </tr>
      ';
    }

    $table .= '
        </tbody>
      </table>
    ';

    //Exportar $table a excel

    $table = utf8_decode($table);
    header("Content-type: application/vnd.ms-excel;charset=utf-8");
    header("Content-Disposition: attachment; filename=agenda_" . date('Y:m:d:m:s') . ".xls");
    header("Pragma: no-cache");
    header("Expires: 0");
    echo $table;

  }
}
