<?php
/**
* Controlador de Seguimientos que permite la  creacion, edicion  y eliminacion de los seguimientos del Sistema
*/
class Page_seguimientosController extends Page_mainController
{
	/**
	 * $mainModel  instancia del modelo de  base de datos seguimientos
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
	protected $_csrf_section = "page_seguimientos";

	/**
	 * $namepages nombre de la pvariable en la cual se va a guardar  el numero de seccion en la paginacion del controlador
	 * @var string
	 */
	protected $namepages;



	/**
     * Inicializa las variables principales del controlador seguimientos .
     *
     * @return void.
     */
	public function init()
	{
		$this->mainModel = new Page_Model_DbTable_Seguimientos();
		$this->namefilter = "parametersfilterseguimientos";
		$this->route = "/page/seguimientos";
		$this->namepages ="pages_seguimientos";
		$this->namepageactual ="page_actual_seguimientos";
		$this->_view->route = $this->route;
		if(Session::getInstance()->get($this->namepages)){
			$this->pages = Session::getInstance()->get($this->namepages);
		} else {
			$this->pages = 20;
		}
		parent::init();

	      if ($_SESSION['kt_login_id'] == "") {
	        header("Location:/page/login/logout");
	      }

	}


	/**
     * Recibe la informacion y  muestra un listado de  seguimientos con sus respectivos filtros.
     *
     * @return void.
     */
	public function indexAction()
	{
		$title = "Administración de seguimientos";
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
		$this->_view->cliente = $this->_getSanitizedParam("cliente");

		$this->_view->array_usuarios = $this->getAsignado();
	}

	/**
     * Genera la Informacion necesaria para editar o crear un  seguimiento  y muestra su formulario
     *
     * @return void.
     */
	public function manageAction()
	{
		$this->_view->route = $this->route;
		$this->_csrf_section = "manage_seguimientos_".date("YmdHis");
		$this->_csrf->generateCode($this->_csrf_section);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$this->_view->cliente = $this->_getSanitizedParam("cliente");
		$id = $this->_getSanitizedParam("id");
		if ($id > 0) {
			$content = $this->mainModel->getById($id);
			if($content->id){
				$this->_view->content = $content;
				$this->_view->routeform = $this->route."/update";
				$title = "Actualizar seguimiento";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}else{
				$this->_view->routeform = $this->route."/insert";
				$title = "Crear seguimiento";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}
		} else {
			$this->_view->routeform = $this->route."/insert";
			$title = "Crear seguimiento";
			$this->getLayout()->setTitle($title);
			$this->_view->titlesection = $title;
		}
	}

	/**
     * Inserta la informacion de un seguimiento  y redirecciona al listado de seguimientos.
     *
     * @return void.
     */
	public function insertAction(){
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf ) {	
			$data = $this->getData();
			$id = $this->mainModel->insert($data);
			
			$data['id']= $id;
			$data['log_log'] = print_r($data,true);
			$data['log_tipo'] = 'CREAR SEGUIMIENTO';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);
		}
		$cliente = $this->_getSanitizedParam("cliente_id");
		header('Location: '.$this->route.'?cliente='.$cliente.'');
	}

	/**
     * Recibe un identificador  y Actualiza la informacion de un seguimiento  y redirecciona al listado de seguimientos.
     *
     * @return void.
     */
	public function updateAction(){
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf ) {
			$id = $this->_getSanitizedParam("id");
			$content = $this->mainModel->getById($id);
			if ($content->id) {
				$data = $this->getData();
					$this->mainModel->update($data,$id);
			}
			$data['id']=$id;
			$data['log_log'] = print_r($data,true);
			$data['log_tipo'] = 'EDITAR SEGUIMIENTO';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);}
		$cliente = $this->_getSanitizedParam("cliente_id");
		header('Location: '.$this->route.'?cliente='.$cliente.'');
	}

	/**
     * Recibe un identificador  y elimina un seguimiento  y redirecciona al listado de seguimientos.
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
					$data['log_tipo'] = 'BORRAR SEGUIMIENTO';
					$logModel = new Administracion_Model_DbTable_Log();
					$logModel->insert($data); }
			}
		}
		$cliente = $this->_getSanitizedParam("cliente");
		header('Location: '.$this->route.'?cliente='.$cliente.'');
	}

	/**
     * Recibe la informacion del formulario y la retorna en forma de array para la edicion y creacion de Seguimientos.
     *
     * @return array con toda la informacion recibida del formulario.
     */
	private function getData()
	{
		$data = array();
		$data['seguimiento'] = $this->_getSanitizedParamHtml("seguimiento");
		$data['fecha'] = date("Y-m-d H:i:s");
		$data['quien'] = $_SESSION['kt_login_id'];
		$data['cliente_id'] = $this->_getSanitizedParamHtml("cliente_id");
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
		$cliente= $this->_getSanitizedParam("cliente");
		$filtros = $filtros." AND cliente_id = '$cliente' ";
        if (Session::getInstance()->get($this->namefilter)!="") {
            $filters =(object)Session::getInstance()->get($this->namefilter);
            if ($filters->seguimiento != '') {
                $filtros = $filtros." AND seguimiento LIKE '%".$filters->seguimiento."%'";
            }
            if ($filters->fecha != '') {
                $filtros = $filtros." AND fecha LIKE '%".$filters->fecha."%'";
            }
            if ($filters->quien != '') {
                $filtros = $filtros." AND quien LIKE '%".$filters->quien."%'";
            }
            if ($filters->cliente_id != '') {
                $filtros = $filtros." AND cliente_id LIKE '%".$filters->cliente_id."%'";
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
					$parramsfilter['seguimiento'] =  $this->_getSanitizedParam("seguimiento");
					$parramsfilter['fecha'] =  $this->_getSanitizedParam("fecha");
					$parramsfilter['quien'] =  $this->_getSanitizedParam("quien");
					$parramsfilter['cliente_id'] =  $this->_getSanitizedParam("cliente_id");Session::getInstance()->set($this->namefilter, $parramsfilter);
        }
        if ($this->_getSanitizedParam("cleanfilter") == 1) {
            Session::getInstance()->set($this->namefilter, '');
            Session::getInstance()->set($this->namepageactual,1);
        }
    }

	private function getAsignado()
	{

		$usuarioModel = new Administracion_Model_DbTable_Usuario();
		$list = $usuarioModel->getList(" user_state='1' "," user_names ASC ");

		$array = array();
		foreach($list as $data){
			$array[$data->user_id] = ''.$data->user_names;
		}
		return $array;
	}

}