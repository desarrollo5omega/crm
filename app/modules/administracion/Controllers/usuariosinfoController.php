<?php
/**
* Controlador de Usuariosinfo que permite la  creacion, edicion  y eliminacion de los usuarios info del Sistema
*/
class Administracion_usuariosinfoController extends Administracion_mainController
{
	/**
	 * $mainModel  instancia del modelo de  base de datos usuarios info
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
	protected $_csrf_section = "administracion_usuariosinfo";

	/**
	 * $namepages nombre de la pvariable en la cual se va a guardar  el numero de seccion en la paginacion del controlador
	 * @var string
	 */
	protected $namepages;



	/**
     * Inicializa las variables principales del controlador usuariosinfo .
     *
     * @return void.
     */
	public function init()
	{
		$this->mainModel = new Administracion_Model_DbTable_Usuariosinfo();
		$this->namefilter = "parametersfilterusuariosinfo";
		$this->route = "/administracion/usuariosinfo";
		$this->namepages ="pages_usuariosinfo";
		$this->namepageactual ="page_actual_usuariosinfo";
		$this->_view->route = $this->route;
		if(Session::getInstance()->get($this->namepages)){
			$this->pages = Session::getInstance()->get($this->namepages);
		} else {
			$this->pages = 20;
		}
		parent::init();
	}


	/**
     * Recibe la informacion y  muestra un listado de  usuarios info con sus respectivos filtros.
     *
     * @return void.
     */
	public function indexAction()
	{
		$title = "Administración de usuarios info";
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
     * Genera la Informacion necesaria para editar o crear un  usuarios info  y muestra su formulario
     *
     * @return void.
     */
	public function manageAction()
	{
		$this->_view->route = $this->route;
		$this->_csrf_section = "manage_usuariosinfo_".date("YmdHis");
		$this->_csrf->generateCode($this->_csrf_section);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$id = $this->_getSanitizedParam("id");
		if ($id > 0) {
			$content = $this->mainModel->getById($id);
			if($content->){
				$this->_view->content = $content;
				$this->_view->routeform = $this->route."/update";
				$title = "Actualizar usuarios info";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}else{
				$this->_view->routeform = $this->route."/insert";
				$title = "Crear usuarios info";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}
		} else {
			$this->_view->routeform = $this->route."/insert";
			$title = "Crear usuarios info";
			$this->getLayout()->setTitle($title);
			$this->_view->titlesection = $title;
		}
	}

	/**
     * Inserta la informacion de un usuarios info  y redirecciona al listado de usuarios info.
     *
     * @return void.
     */
	public function insertAction(){
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf ) {	
			$data = $this->getData();
			$id = $this->mainModel->insert($data);

			$data['']= $id;
			$data['log_log'] = print_r($data,true);
			$data['log_tipo'] = 'CREAR USUARIOS INFO';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);
		}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe un identificador  y Actualiza la informacion de un usuarios info  y redirecciona al listado de usuarios info.
     *
     * @return void.
     */
	public function updateAction(){
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf ) {
			$id = $this->_getSanitizedParam("id");
			$content = $this->mainModel->getById($id);
			if ($content->) {
				$data = $this->getData();
					$this->mainModel->update($data,$id);
			}
			$data['']=$id;
			$data['log_log'] = print_r($data,true);
			$data['log_tipo'] = 'EDITAR USUARIOS INFO';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe un identificador  y elimina un usuarios info  y redirecciona al listado de usuarios info.
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
					$data['log_tipo'] = 'BORRAR USUARIOS INFO';
					$logModel = new Administracion_Model_DbTable_Log();
					$logModel->insert($data); }
			}
		}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe la informacion del formulario y la retorna en forma de array para la edicion y creacion de Usuariosinfo.
     *
     * @return array con toda la informacion recibida del formulario.
     */
	private function getData()
	{
		$data = array();
		$data['documento'] = $this->_getSanitizedParam("documento");
		$data['tipo_documento'] = $this->_getSanitizedParam("tipo_documento");
		$data['fecha_documento'] = $this->_getSanitizedParam("fecha_documento");
		$data['nombres'] = $this->_getSanitizedParam("nombres");
		$data['apellidos'] = $this->_getSanitizedParam("apellidos");
		$data['ciudad'] = $this->_getSanitizedParam("ciudad");
		$data['departamento'] = $this->_getSanitizedParam("departamento");
		$data['pais'] = $this->_getSanitizedParam("pais");
		$data['ciudad_documento'] = $this->_getSanitizedParam("ciudad_documento");
		$data['departamento_documento'] = $this->_getSanitizedParam("departamento_documento");
		$data['pais_documento'] = $this->_getSanitizedParam("pais_documento");
		$data['fecha_nacimiento'] = $this->_getSanitizedParam("fecha_nacimiento");
		$data['direccion'] = $this->_getSanitizedParam("direccion");
		$data['email'] = $this->_getSanitizedParam("email");
		$data['telefono'] = $this->_getSanitizedParam("telefono");
		$data['celular'] = $this->_getSanitizedParam("celular");
		$data['id_deceval'] = $this->_getSanitizedParam("id_deceval");
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
            if ($filters->documento != '') {
                $filtros = $filtros." AND documento LIKE '%".$filters->documento."%'";
            }
            if ($filters->tipo_documento != '') {
                $filtros = $filtros." AND tipo_documento LIKE '%".$filters->tipo_documento."%'";
            }
            if ($filters->fecha_documento != '') {
                $filtros = $filtros." AND fecha_documento LIKE '%".$filters->fecha_documento."%'";
            }
            if ($filters->nombres != '') {
                $filtros = $filtros." AND nombres LIKE '%".$filters->nombres."%'";
            }
            if ($filters->apellidos != '') {
                $filtros = $filtros." AND apellidos LIKE '%".$filters->apellidos."%'";
            }
            if ($filters->ciudad != '') {
                $filtros = $filtros." AND ciudad LIKE '%".$filters->ciudad."%'";
            }
            if ($filters->departamento != '') {
                $filtros = $filtros." AND departamento LIKE '%".$filters->departamento."%'";
            }
            if ($filters->pais != '') {
                $filtros = $filtros." AND pais LIKE '%".$filters->pais."%'";
            }
            if ($filters->ciudad_documento != '') {
                $filtros = $filtros." AND ciudad_documento LIKE '%".$filters->ciudad_documento."%'";
            }
            if ($filters->departamento_documento != '') {
                $filtros = $filtros." AND departamento_documento LIKE '%".$filters->departamento_documento."%'";
            }
            if ($filters->pais_documento != '') {
                $filtros = $filtros." AND pais_documento LIKE '%".$filters->pais_documento."%'";
            }
            if ($filters->fecha_nacimiento != '') {
                $filtros = $filtros." AND fecha_nacimiento LIKE '%".$filters->fecha_nacimiento."%'";
            }
            if ($filters->direccion != '') {
                $filtros = $filtros." AND direccion LIKE '%".$filters->direccion."%'";
            }
            if ($filters->email != '') {
                $filtros = $filtros." AND email LIKE '%".$filters->email."%'";
            }
            if ($filters->telefono != '') {
                $filtros = $filtros." AND telefono LIKE '%".$filters->telefono."%'";
            }
            if ($filters->celular != '') {
                $filtros = $filtros." AND celular LIKE '%".$filters->celular."%'";
            }
            if ($filters->id_deceval != '') {
                $filtros = $filtros." AND id_deceval LIKE '%".$filters->id_deceval."%'";
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
					$parramsfilter['documento'] =  $this->_getSanitizedParam("documento");
					$parramsfilter['tipo_documento'] =  $this->_getSanitizedParam("tipo_documento");
					$parramsfilter['fecha_documento'] =  $this->_getSanitizedParam("fecha_documento");
					$parramsfilter['nombres'] =  $this->_getSanitizedParam("nombres");
					$parramsfilter['apellidos'] =  $this->_getSanitizedParam("apellidos");
					$parramsfilter['ciudad'] =  $this->_getSanitizedParam("ciudad");
					$parramsfilter['departamento'] =  $this->_getSanitizedParam("departamento");
					$parramsfilter['pais'] =  $this->_getSanitizedParam("pais");
					$parramsfilter['ciudad_documento'] =  $this->_getSanitizedParam("ciudad_documento");
					$parramsfilter['departamento_documento'] =  $this->_getSanitizedParam("departamento_documento");
					$parramsfilter['pais_documento'] =  $this->_getSanitizedParam("pais_documento");
					$parramsfilter['fecha_nacimiento'] =  $this->_getSanitizedParam("fecha_nacimiento");
					$parramsfilter['direccion'] =  $this->_getSanitizedParam("direccion");
					$parramsfilter['email'] =  $this->_getSanitizedParam("email");
					$parramsfilter['telefono'] =  $this->_getSanitizedParam("telefono");
					$parramsfilter['celular'] =  $this->_getSanitizedParam("celular");
					$parramsfilter['id_deceval'] =  $this->_getSanitizedParam("id_deceval");Session::getInstance()->set($this->namefilter, $parramsfilter);
        }
        if ($this->_getSanitizedParam("cleanfilter") == 1) {
            Session::getInstance()->set($this->namefilter, '');
            Session::getInstance()->set($this->namepageactual,1);
        }
    }
}