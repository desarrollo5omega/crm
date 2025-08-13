<?php
/**
* Controlador de Pagares que permite la  creacion, edicion  y eliminacion de los pagares del Sistema
*/
class Administracion_pagaresController extends Administracion_mainController
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
		$this->route = "/administracion/pagares";
		$this->namepages ="pages_pagares";
		$this->namepageactual ="page_actual_pagares";
		$this->_view->route = $this->route;
		if(Session::getInstance()->get($this->namepages)){
			$this->pages = Session::getInstance()->get($this->namepages);
		} else {
			$this->pages = 20;
		}
		parent::init();
	}


	/**
     * Recibe la informacion y  muestra un listado de  pagares con sus respectivos filtros.
     *
     * @return void.
     */
	public function indexAction()
	{
		$title = "Administración de pagares";
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
     * Genera la Informacion necesaria para editar o crear un  pagares  y muestra su formulario
     *
     * @return void.
     */
	public function manageAction()
	{
		$this->_view->route = $this->route;
		$this->_csrf_section = "manage_pagares_".date("YmdHis");
		$this->_csrf->generateCode($this->_csrf_section);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$id = $this->_getSanitizedParam("id");
		if ($id > 0) {
			$content = $this->mainModel->getById($id);
			if($content->id){
				$this->_view->content = $content;
				$this->_view->routeform = $this->route."/update";
				$title = "Actualizar pagares";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}else{
				$this->_view->routeform = $this->route."/insert";
				$title = "Crear pagares";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}
		} else {
			$this->_view->routeform = $this->route."/insert";
			$title = "Crear pagares";
			$this->getLayout()->setTitle($title);
			$this->_view->titlesection = $title;
		}
	}

	/**
     * Inserta la informacion de un pagares  y redirecciona al listado de pagares.
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
			$data['log_tipo'] = 'CREAR PAGARES';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);
		}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe un identificador  y Actualiza la informacion de un pagares  y redirecciona al listado de pagares.
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
			$data['log_tipo'] = 'EDITAR PAGARES';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe un identificador  y elimina un pagares  y redirecciona al listado de pagares.
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
					$data['log_tipo'] = 'BORRAR PAGARES';
					$logModel = new Administracion_Model_DbTable_Log();
					$logModel->insert($data); }
			}
		}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe la informacion del formulario y la retorna en forma de array para la edicion y creacion de Pagares.
     *
     * @return array con toda la informacion recibida del formulario.
     */
	private function getData()
	{
		$data = array();
		$data['pagare'] = $this->_getSanitizedParam("pagare");
		$data['pagare_deceval'] = $this->_getSanitizedParam("pagare_deceval");
		$data['fecha'] = $this->_getSanitizedParam("fecha");
		if($this->_getSanitizedParam("estado") == '' ) {
			$data['estado'] = '0';
		} else {
			$data['estado'] = $this->_getSanitizedParam("estado");
		}
		$data['token'] = $this->_getSanitizedParam("token");
		$data['modalidad'] = $this->_getSanitizedParam("modalidad");
		$data['fecha_firma'] = $this->_getSanitizedParam("fecha_firma");
		$data['ip'] = $this->_getSanitizedParam("ip");
		$data['fecha_firma1'] = $this->_getSanitizedParam("fecha_firma1");
		$data['ip1'] = $this->_getSanitizedParam("ip1");
		$data['fecha_firma2'] = $this->_getSanitizedParam("fecha_firma2");
		$data['ip2'] = $this->_getSanitizedParam("ip2");
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
            if ($filters->pagare != '') {
                $filtros = $filtros." AND pagare LIKE '%".$filters->pagare."%'";
            }
            if ($filters->pagare_deceval != '') {
                $filtros = $filtros." AND pagare_deceval LIKE '%".$filters->pagare_deceval."%'";
            }
            if ($filters->fecha != '') {
                $filtros = $filtros." AND fecha LIKE '%".$filters->fecha."%'";
            }
            if ($filters->estado != '') {
                $filtros = $filtros." AND estado LIKE '%".$filters->estado."%'";
            }
            if ($filters->token != '') {
                $filtros = $filtros." AND token LIKE '%".$filters->token."%'";
            }
            if ($filters->modalidad != '') {
                $filtros = $filtros." AND modalidad LIKE '%".$filters->modalidad."%'";
            }
            if ($filters->fecha_firma != '') {
                $filtros = $filtros." AND fecha_firma LIKE '%".$filters->fecha_firma."%'";
            }
            if ($filters->ip != '') {
                $filtros = $filtros." AND ip LIKE '%".$filters->ip."%'";
            }
            if ($filters->fecha_firma1 != '') {
                $filtros = $filtros." AND fecha_firma1 LIKE '%".$filters->fecha_firma1."%'";
            }
            if ($filters->ip1 != '') {
                $filtros = $filtros." AND ip1 LIKE '%".$filters->ip1."%'";
            }
            if ($filters->fecha_firma2 != '') {
                $filtros = $filtros." AND fecha_firma2 LIKE '%".$filters->fecha_firma2."%'";
            }
            if ($filters->ip2 != '') {
                $filtros = $filtros." AND ip2 LIKE '%".$filters->ip2."%'";
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
					$parramsfilter['pagare'] =  $this->_getSanitizedParam("pagare");
					$parramsfilter['pagare_deceval'] =  $this->_getSanitizedParam("pagare_deceval");
					$parramsfilter['fecha'] =  $this->_getSanitizedParam("fecha");
					$parramsfilter['estado'] =  $this->_getSanitizedParam("estado");
					$parramsfilter['token'] =  $this->_getSanitizedParam("token");
					$parramsfilter['modalidad'] =  $this->_getSanitizedParam("modalidad");
					$parramsfilter['fecha_firma'] =  $this->_getSanitizedParam("fecha_firma");
					$parramsfilter['ip'] =  $this->_getSanitizedParam("ip");
					$parramsfilter['fecha_firma1'] =  $this->_getSanitizedParam("fecha_firma1");
					$parramsfilter['ip1'] =  $this->_getSanitizedParam("ip1");
					$parramsfilter['fecha_firma2'] =  $this->_getSanitizedParam("fecha_firma2");
					$parramsfilter['ip2'] =  $this->_getSanitizedParam("ip2");Session::getInstance()->set($this->namefilter, $parramsfilter);
        }
        if ($this->_getSanitizedParam("cleanfilter") == 1) {
            Session::getInstance()->set($this->namefilter, '');
            Session::getInstance()->set($this->namepageactual,1);
        }
    }
}