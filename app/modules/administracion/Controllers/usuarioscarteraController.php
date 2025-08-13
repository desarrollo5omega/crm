<?php
/**
* Controlador de Usuarioscartera que permite la  creacion, edicion  y eliminacion de los Usuarios Compra de Cartera del Sistema
*/
class Administracion_usuarioscarteraController extends Administracion_mainController
{
	/**
	 * $mainModel  instancia del modelo de  base de datos Usuarios Compra de Cartera
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
	protected $_csrf_section = "administracion_usuarioscartera";

	/**
	 * $namepages nombre de la pvariable en la cual se va a guardar  el numero de seccion en la paginacion del controlador
	 * @var string
	 */
	protected $namepages;



	/**
     * Inicializa las variables principales del controlador usuarioscartera .
     *
     * @return void.
     */
	public function init()
	{
		$this->mainModel = new Administracion_Model_DbTable_Usuarioscartera();
		$this->namefilter = "parametersfilterusuarioscartera";
		$this->route = "/administracion/usuarioscartera";
		$this->namepages ="pages_usuarioscartera";
		$this->namepageactual ="page_actual_usuarioscartera";
		$this->_view->route = $this->route;
		if(Session::getInstance()->get($this->namepages)){
			$this->pages = Session::getInstance()->get($this->namepages);
		} else {
			$this->pages = 20;
		}
		parent::init();
	}


	/**
     * Recibe la informacion y  muestra un listado de  Usuarios Compra de Cartera con sus respectivos filtros.
     *
     * @return void.
     */
	public function indexAction()
	{
		$title = "Administración de Usuarios Compra de Cartera";
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
	}

	/**
     * Genera la Informacion necesaria para editar o crear un  Usuarios Compra de Cartera  y muestra su formulario
     *
     * @return void.
     */
	public function manageAction()
	{
		$this->_view->route = $this->route;
		$this->_csrf_section = "manage_usuarioscartera_".date("YmdHis");
		$this->_csrf->generateCode($this->_csrf_section);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$id = $this->_getSanitizedParam("id");
		if ($id > 0) {
			$content = $this->mainModel->getById($id);
			if($content->userc_id){
				$this->_view->content = $content;
				$this->_view->routeform = $this->route."/update";
				$title = "Actualizar Usuarios Compra de Cartera";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}else{
				$this->_view->routeform = $this->route."/insert";
				$title = "Crear Usuarios Compra de Cartera";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}
		} else {
			$this->_view->routeform = $this->route."/insert";
			$title = "Crear Usuarios Compra de Cartera";
			$this->getLayout()->setTitle($title);
			$this->_view->titlesection = $title;
		}
	}

	/**
     * Inserta la informacion de un Usuarios Compra de Cartera  y redirecciona al listado de Usuarios Compra de Cartera.
     *
     * @return void.
     */
	public function insertAction(){
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf ) {	
			$data = $this->getData();
			$id = $this->mainModel->insert($data);
			
			$data['userc_id']= $id;
			$data['log_log'] = print_r($data,true);
			$data['log_tipo'] = 'CREAR USUARIOS COMPRA DE CARTERA';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);
		}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe un identificador  y Actualiza la informacion de un Usuarios Compra de Cartera  y redirecciona al listado de Usuarios Compra de Cartera.
     *
     * @return void.
     */
	public function updateAction(){
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf ) {
			$id = $this->_getSanitizedParam("id");
			$content = $this->mainModel->getById($id);
			if ($content->userc_id) {
				$data = $this->getData();
					$this->mainModel->update($data,$id);
			}
			$data['userc_id']=$id;
			$data['log_log'] = print_r($data,true);
			$data['log_tipo'] = 'EDITAR USUARIOS COMPRA DE CARTERA';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe un identificador  y elimina un Usuarios Compra de Cartera  y redirecciona al listado de Usuarios Compra de Cartera.
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
					$data['log_tipo'] = 'BORRAR USUARIOS COMPRA DE CARTERA';
					$logModel = new Administracion_Model_DbTable_Log();
					$logModel->insert($data); }
			}
		}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe la informacion del formulario y la retorna en forma de array para la edicion y creacion de Usuarioscartera.
     *
     * @return array con toda la informacion recibida del formulario.
     */
	private function getData()
	{
		$data = array();
		$data['userc_cedula'] = $this->_getSanitizedParam("userc_cedula");
		$data['userc_nombre'] = $this->_getSanitizedParam("userc_nombre");
		$data['userc_regional'] = $this->_getSanitizedParam("userc_regional");
		$data['userc_cargo'] = $this->_getSanitizedParam("userc_cargo");
		$data['userc_estado'] = $this->_getSanitizedParam("userc_estado");
		$data['userc_salario'] = $this->_getSanitizedParam("userc_salario");
		$data['userc_afiliacion'] = $this->_getSanitizedParam("userc_afiliacion");
		$data['userc_antiguedad'] = $this->_getSanitizedParam("userc_antiguedad");
		$data['userc_vinculacion'] = $this->_getSanitizedParam("userc_vinculacion");
		$data['userc_anti_empresa'] = $this->_getSanitizedParam("userc_anti_empresa");
		$data['userc_aportes'] = $this->_getSanitizedParam("userc_aportes");
		$data['userc_cartera'] = $this->_getSanitizedParam("userc_cartera");
		$data['userc_cupo'] = $this->_getSanitizedParam("userc_cupo");
		$data['userc_capacidad'] = $this->_getSanitizedParam("userc_capacidad");
		$data['userc_prestamo'] = $this->_getSanitizedParam("userc_prestamo");
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
            if ($filters->userc_cedula != '') {
                $filtros = $filtros." AND userc_cedula LIKE '%".$filters->userc_cedula."%'";
            }
            if ($filters->userc_nombre != '') {
                $filtros = $filtros." AND userc_nombre LIKE '%".$filters->userc_nombre."%'";
            }
            if ($filters->userc_regional != '') {
                $filtros = $filtros." AND userc_regional LIKE '%".$filters->userc_regional."%'";
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
					$parramsfilter['userc_cedula'] =  $this->_getSanitizedParam("userc_cedula");
					$parramsfilter['userc_nombre'] =  $this->_getSanitizedParam("userc_nombre");
					$parramsfilter['userc_regional'] =  $this->_getSanitizedParam("userc_regional");Session::getInstance()->set($this->namefilter, $parramsfilter);
        }
        if ($this->_getSanitizedParam("cleanfilter") == 1) {
            Session::getInstance()->set($this->namefilter, '');
            Session::getInstance()->set($this->namepageactual,1);
        }
    }
}