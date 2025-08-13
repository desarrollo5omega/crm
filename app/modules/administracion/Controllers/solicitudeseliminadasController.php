<?php
/**
* Controlador de Solicitudeseliminadas que permite la  creacion, edicion  y eliminacion de los Solicitudes Eliminadas del Sistema
*/
class Administracion_solicitudeseliminadasController extends Administracion_mainController
{
  public $botonpanel = 23;
	/**
	 * $mainModel  instancia del modelo de  base de datos Solicitudes Eliminadas
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
	protected $pages ;

	/**
	 * $namefilter nombre de la variable a la fual se le van a guardar los filtros
	 * @var string
	 */
	protected $namefilter;

	/**
	 * $_csrf_section  nombre de la variable general csrf  que se va a almacenar en la session
	 * @var string
	 */
	protected $_csrf_section = "administracion_solicitudeseliminadas";

	/**
	 * $namepages nombre de la pvariable en la cual se va a guardar  el numero de seccion en la paginacion del controlador
	 * @var string
	 */
	protected $namepages;



	/**
     * Inicializa las variables principales del controlador solicitudeseliminadas .
     *
     * @return void.
     */
	public function init()
	{
		$this->mainModel = new Administracion_Model_DbTable_Solicitudeseliminadas();
		$this->namefilter = "parametersfiltersolicitudeseliminadas";
		$this->route = "/administracion/solicitudeseliminadas";
		$this->namepages ="pages_solicitudeseliminadas";
		$this->namepageactual ="page_actual_solicitudeseliminadas";
		$this->_view->route = $this->route;
		if(Session::getInstance()->get($this->namepages)){
			$this->pages = Session::getInstance()->get($this->namepages);
		} else {
			$this->pages = 20;
		}
		parent::init();
	}


	/**
     * Recibe la informacion y  muestra un listado de  Solicitudes Eliminadas con sus respectivos filtros.
     *
     * @return void.
     */
	public function indexAction()
	{
		$title = "Administración de Solicitudes Eliminadas";
		$this->getLayout()->setTitle($title);
		$this->_view->titlesection = $title;
		$this->filters();
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$filters =(object)Session::getInstance()->get($this->namefilter);
        $this->_view->filters = $filters;
		$filters = $this->getFilter();
		$order = "";
		$list = $this->mainModel->getList($filters,$order);
		$amount = $this->pages;
		$page = $this->_getSanitizedParam("page");
		if (!$page && Session::getInstance()->get($this->namepageactual)) {
		   	$page = Session::getInstance()->get($this->namepageactual);
		   	$start = ($page - 1) * $amount;
		} else if(!$page){
			$start = 0;
		   	$page=1;
			Session::getInstance()->set($this->namepageactual,$page);
		} else {
			Session::getInstance()->set($this->namepageactual,$page);
		   	$start = ($page - 1) * $amount;
		}
		$this->_view->register_number = count($list);
		$this->_view->pages = $this->pages;
		$this->_view->totalpages = ceil(count($list)/$amount);
		$this->_view->page = $page;
		$this->_view->lists = $this->mainModel->getListPages($filters,$order,$start,$amount);
		$this->_view->csrf_section = $this->_csrf_section;

    $usuarios_model = new Administracion_Model_DbTable_Usuario();
    $usuarios = $usuarios_model->getList();
    foreach ($usuarios as $key => $value) {
      $usuarios[$value->user_id] = $value->user_names;
    }
    $this->_view->usuarios = $usuarios;
	}

	/**
     * Genera la Informacion necesaria para editar o crear un  Solicitudes Eliminadas  y muestra su formulario
     *
     * @return void.
     */
	public function manageAction()
	{
		$this->_view->route = $this->route;
		$this->_csrf_section = "manage_solicitudeseliminadas_".date("YmdHis");
		$this->_csrf->generateCode($this->_csrf_section);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$id = $this->_getSanitizedParam("id");
		if ($id > 0) {
			$content = $this->mainModel->getById($id);
			if($content->solicitud_id){
				$this->_view->content = $content;
				$this->_view->routeform = $this->route."/update";
				$title = "Actualizar Solicitudes Eliminadas";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}else{
				$this->_view->routeform = $this->route."/insert";
				$title = "Crear Solicitudes Eliminadas";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}
		} else {
			$this->_view->routeform = $this->route."/insert";
			$title = "Crear Solicitudes Eliminadas";
			$this->getLayout()->setTitle($title);
			$this->_view->titlesection = $title;
		}
	}

	/**
     * Inserta la informacion de un Solicitudes Eliminadas  y redirecciona al listado de Solicitudes Eliminadas.
     *
     * @return void.
     */
	public function insertAction(){
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf ) {	
			$data = $this->getData();
			$id = $this->mainModel->insert($data);
			
			$data['solicitud_id']= $id;
			$data['log_log'] = print_r($data,true);
			$data['log_tipo'] = 'CREAR SOLICITUDES ELIMINADAS';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);
		}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe un identificador  y Actualiza la informacion de un Solicitudes Eliminadas  y redirecciona al listado de Solicitudes Eliminadas.
     *
     * @return void.
     */
	public function updateAction(){
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf ) {
			$id = $this->_getSanitizedParam("id");
			$content = $this->mainModel->getById($id);
			if ($content->solicitud_id) {
				$data = $this->getData();
					$this->mainModel->update($data,$id);
			}
			$data['solicitud_id']=$id;
			$data['log_log'] = print_r($data,true);
			$data['log_tipo'] = 'EDITAR SOLICITUDES ELIMINADAS';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe un identificador  y elimina un Solicitudes Eliminadas  y redirecciona al listado de Solicitudes Eliminadas.
     *
     * @return void.
     */
	public function deleteAction()
	{
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_csrf_section] == $csrf ) {
			$id =  $this->_getSanitizedParam("id");
			if (isset($id) && $id > 0) {
				$content = $this->mainModel->getById($id);
				if (isset($content)) {
					$this->mainModel->deleteRegister($id);$data = (array)$content;
					$data['log_log'] = print_r($data,true);
					$data['log_tipo'] = 'BORRAR SOLICITUDES ELIMINADAS';
					$logModel = new Administracion_Model_DbTable_Log();
					$logModel->insert($data); }
			}
		}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe la informacion del formulario y la retorna en forma de array para la edicion y creacion de Solicitudeseliminadas.
     *
     * @return array con toda la informacion recibida del formulario.
     */
	private function getData()
	{
		$data = array();
		$data['solicitud_solicitud'] = $this->_getSanitizedParam("solicitud_solicitud");
		$data['solicitud_fecha_eliminacion'] = $this->_getSanitizedParam("solicitud_fecha_eliminacion");
		$data['solicitud_usuario'] = $this->_getSanitizedParam("solicitud_usuario");
		$data['solicitud_datos'] = $this->_getSanitizedParam("solicitud_datos");
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
        if (Session::getInstance()->get($this->namefilter)!="") {
            $filters =(object)Session::getInstance()->get($this->namefilter);
            if ($filters->solicitud_solicitud != '') {
                $filtros = $filtros." AND solicitud_solicitud LIKE '%".$filters->solicitud_solicitud."%'";
            }
            if ($filters->solicitud_fecha_eliminacion != '') {
                $filtros = $filtros." AND solicitud_fecha_eliminacion LIKE '%".$filters->solicitud_fecha_eliminacion."%'";
            }
            if ($filters->solicitud_usuario != '') {
                $filtros = $filtros." AND solicitud_usuario LIKE '%".$filters->solicitud_usuario."%'";
            }
            if ($filters->solicitud_datos != '') {
                $filtros = $filtros." AND solicitud_datos LIKE '%".$filters->solicitud_datos."%'";
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
        if ($this->getRequest()->isPost()== true) {
        	Session::getInstance()->set($this->namepageactual,1);
            $parramsfilter = array();
					$parramsfilter['solicitud_solicitud'] =  $this->_getSanitizedParam("solicitud_solicitud");
					$parramsfilter['solicitud_fecha_eliminacion'] =  $this->_getSanitizedParam("solicitud_fecha_eliminacion");
					$parramsfilter['solicitud_usuario'] =  $this->_getSanitizedParam("solicitud_usuario");
					$parramsfilter['solicitud_datos'] =  $this->_getSanitizedParam("solicitud_datos");Session::getInstance()->set($this->namefilter, $parramsfilter);
        }
        if ($this->_getSanitizedParam("cleanfilter") == 1) {
            Session::getInstance()->set($this->namefilter, '');
            Session::getInstance()->set($this->namepageactual,1);
        }
    }
}