<?php

/**
 * Controlador de Importarasociados que permite la  creacion, edicion  y eliminacion de los importar asociados del Sistema
 */
class Administracion_importarasociadosnacionalController extends Administracion_mainController
{
  public $botonpanel = 22;
  /**
   * $mainModel  instancia del modelo de  base de datos importar asociados
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
  protected $_csrf_section = "administracion_importarasociados";

  /**
   * $namepages nombre de la pvariable en la cual se va a guardar  el numero de seccion en la paginacion del controlador
   * @var string
   */
  protected $namepages;



  /**
   * Inicializa las variables principales del controlador importarasociados .
   *
   * @return void.
   */
  public function init()
  {
    $this->mainModel = new Administracion_Model_DbTable_Archivosregional();
    $this->namefilter = "parametersfilterimportarasociados";
    $this->route = "/administracion/importarasociadosnacional";
    $this->namepages = "pages_importarasociados";
    $this->namepageactual = "page_actual_importarasociados";
    $this->_view->route = $this->route;
    if (Session::getInstance()->get($this->namepages)) {
      $this->pages = Session::getInstance()->get($this->namepages);
    } else {
      $this->pages = 20;
    }
    parent::init();
  }


  /**
   * Recibe la informacion y  muestra un listado de  importar asociados con sus respectivos filtros.
   *
   * @return void.
   */
  public function indexAction()
  {
    $title = "Administración de importar asociados";
    $this->getLayout()->setTitle($title);
    $this->_view->titlesection = $title;
    $this->filters();
    $this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
    $filters = (object)Session::getInstance()->get($this->namefilter);
    $this->_view->filters = $filters;
    $filters = $this->getFilter();
    $order = "";
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
    $archivosModel = new Administracion_Model_DbTable_Archivosregional();

    $this->_view->register_number = count($list);
    $this->_view->pages = $this->pages;
    $this->_view->totalpages = ceil(count($list) / $amount);
    $this->_view->page = $page;
    $this->_view->lists = $archivosModel->getListPages($filters, $order, $start, $amount);
    $this->_view->csrf_section = $this->_csrf_section;
  }

  /**
   * Genera la Informacion necesaria para editar o crear un  importar asociados  y muestra su formulario
   *
   * @return void.
   */
  public function manageAction()
  {
    $this->_view->route = $this->route;
    $this->_csrf_section = "manage_importarasociados_" . date("YmdHis");
    $this->_csrf->generateCode($this->_csrf_section);
    $this->_view->csrf_section = $this->_csrf_section;
    $this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
    $id = $this->_getSanitizedParam("id");
    if ($id > 0) {
      $content = $this->mainModel->getById($id);
      if ($content->archivo_id) {
        $this->_view->content = $content;
        $this->_view->routeform = $this->route . "/update";
        $title = "Actualizar importar asociados";
        $this->getLayout()->setTitle($title);
        $this->_view->titlesection = $title;
      } else {
        $this->_view->routeform = $this->route . "/insert";
        $title = "Crear importar asociados";
        $this->getLayout()->setTitle($title);
        $this->_view->titlesection = $title;
      }
    } else {
      $this->_view->routeform = $this->route . "/insert";
      $title = "Crear importar asociados";
      $this->getLayout()->setTitle($title);
      $this->_view->titlesection = $title;
    }
  }

  /**
   * Inserta la informacion de un importar asociados  y redirecciona al listado de importar asociados.
   *
   * @return void.
   */
  public function insertAction()
  {
    $this->setLayout('blanco');
    $csrf = $this->_getSanitizedParam("csrf");
    if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf) {
      $data = $this->getData();
      $uploadDocument =  new Core_Model_Upload_Document();
      if ($_FILES['archivo_archivo']['name'] != '') {
        $data['archivo_archivo'] = $uploadDocument->upload("archivo_archivo");
      }
      $id = $this->mainModel->insert($data);

      $data['id'] = $id;
      $data['log_log'] = print_r($data, true);
      $data['log_tipo'] = 'CREAR IMPORTAR ASOCIADOS';
      $logModel = new Administracion_Model_DbTable_Log();
      $logModel->insert($data);
    }
    header('Location: ' . $this->route . '' . '');
  }

  /**
   * Recibe un identificador  y Actualiza la informacion de un importar asociados  y redirecciona al listado de importar asociados.
   *
   * @return void.
   */
  public function updateAction()
  {
    $this->setLayout('blanco');
    $csrf = $this->_getSanitizedParam("csrf");
    if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf) {
      $id = $this->_getSanitizedParam("id");
      $content = $this->mainModel->getById($id);
      if ($content->archivo_id) {
        $data = $this->getData();
        $uploadDocument =  new Core_Model_Upload_Document();

        if ($_FILES['archivo_archivo']['name'] != '') {
          if ($content->archivo_archivo) {
            $uploadDocument->delete($content->archivo_archivo);
          }
          $data['archivo_archivo'] = $uploadDocument->upload("archivo_archivo");
        } else {
          $data['archivo_archivo'] = $content->archivo_archivo;
        }

        $this->mainModel->update($data, $id);
      }
      $data['id'] = $id;
      $data['log_log'] = print_r($data, true);
      $data['log_tipo'] = 'EDITAR IMPORTAR ASOCIADOS';
      $logModel = new Administracion_Model_DbTable_Log();
      $logModel->insert($data);
    }
    //header('Location: '.$this->route.''.'');
    header('Location:/administracion/importarasociadosnacional/carga?inicio=1');
  }


  public function cargaAction()
  {
    $archivosModel = new Administracion_Model_DbTable_Archivosregional();
    $this->setLayout('blanco');
    $id = 1;
    $content = $archivosModel->getById($id);
    $archivo = $content->archivo_archivo;
    $this->getLayout()->setTitle("Importar cupos");

    //leer archivo
    ini_set('memory_limit', '-1');
    ini_set('max_execution_time', 300);
    $inputFileName = FILE_PATH . '/' . $archivo;
    $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
    $infoexel = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
    //$ahorrosModel = new Administracion_Model_DbTable_Ahorrosaportes();
    $usuariosModel = new Administracion_Model_DbTable_Usuarioscartera();
    if ($_GET['inicio'] != "") {
      $inicio = $_GET['inicio'];
    }
    if($inicio == 1){
      $usuariosModel->truncate();
    }
    $i = 0;
    //print_r($infoexel);
    foreach ($infoexel as $fila) {

      $data = array();
      $i++;
      //echo $i;
      if ($i > $inicio and $i <= $inicio + 2000) {

        $data['userc_cedula'] = $fila['A'];
        $data['userc_nombre'] = $fila['B'];
        $data['userc_regional'] = $fila['D'];
        $data['userc_cargo'] = $fila['F'];
        $data['userc_estado'] = $fila['I'];
        $data['userc_salario'] = $fila['J'];
        $data['userc_afiliacion'] = $fila['K'];
        $data['userc_antiguedad'] = $fila['L'];
        $data['userc_vinculacion'] = $fila['M'];
        $data['userc_anti_empresa'] = $fila['N'];
        $data['userc_aportes'] = $fila['O'];
        $data['userc_cartera'] = $fila['P'];
        $data['userc_cupo'] = $fila['Q'];
        $data['userc_capacidad'] = $fila['R'];
        $data['userc_prestamo'] = $fila['S'];

        if($data['userc_cedula'] != ""){
          $usuariosModel->insert($data);
        }
      }
    }
    if (count($infoexel) <= $inicio) {
      header("Location:/administracion/importarasociadosnacional/");
    } else {
      $inicio = $inicio + 2000;
      header("Location: /administracion/importarasociadosnacional/carga?inicio=" . $inicio);
    }
  }

  /**
   * Recibe un identificador  y elimina un importar asociados  y redirecciona al listado de importar asociados.
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
          $uploadDocument =  new Core_Model_Upload_Document();
          if (isset($content->archivo_archivo) && $content->archivo_archivo != '') {
            $uploadDocument->delete($content->archivo_archivo);
          }
          $this->mainModel->deleteRegister($id);
          $data = (array)$content;
          $data['log_log'] = print_r($data, true);
          $data['log_tipo'] = 'BORRAR IMPORTAR ASOCIADOS';
          $logModel = new Administracion_Model_DbTable_Log();
          $logModel->insert($data);
        }
      }
    }
    header('Location: ' . $this->route . '' . '');
  }

  /**
   * Recibe la informacion del formulario y la retorna en forma de array para la edicion y creacion de Importarasociados.
   *
   * @return array con toda la informacion recibida del formulario.
   */
  private function getData()
  {
    $data = array();
    $data['archivo_archivo'] = '';
    $data['archivo_fecha'] = $this->_getSanitizedParam("archivo_fecha");
    $data['archivo_usuario'] = $this->_getSanitizedParam("archivo_usuario");
    return $data;
  }
  /**
   * Genera la consulta con los filtros de este controlador.
   *
   * @return array cadena con los filtros que se van a asignar a la base de datos
   */
  protected function getFilter()
  {
    $filtros = " 1 = 1 ";
    if (Session::getInstance()->get($this->namefilter) != "") {
      $filters = (object)Session::getInstance()->get($this->namefilter);
      if ($filters->archivo_archivo != '') {
        $filtros = $filtros . " AND archivo_archivo LIKE '%" . $filters->archivo_archivo . "%'";
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
      $parramsfilter['archivo_archivo'] =  $this->_getSanitizedParam("archivo_archivo");
      Session::getInstance()->set($this->namefilter, $parramsfilter);
    }
    if ($this->_getSanitizedParam("cleanfilter") == 1) {
      Session::getInstance()->set($this->namefilter, '');
      Session::getInstance()->set($this->namepageactual, 1);
    }
  }
  function limpiarN($x)
  {
    $x = str_replace('$', '', $x);
    $x = str_replace(',', '', $x);
    $x = str_replace(' ', '', $x);
    $x = str_replace('.', '', $x);
    $x = str_replace("'", '', $x);
    $x = (float) $x;
    return $x;
  }
}
