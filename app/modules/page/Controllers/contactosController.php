<?php
/**
* Controlador de Contactos que permite la  creacion, edicion  y eliminacion de los contactos del Sistema
*/
class Page_contactosController extends Page_mainController
{
	/**
	 * $mainModel  instancia del modelo de  base de datos contactos
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
	protected $_csrf_section = "page_contactos";

	/**
	 * $namepages nombre de la pvariable en la cual se va a guardar  el numero de seccion en la paginacion del controlador
	 * @var string
	 */
	protected $namepages;



	/**
     * Inicializa las variables principales del controlador contactos .
     *
     * @return void.
     */
	public function init()
	{
		$this->mainModel = new Page_Model_DbTable_Contactos();
		$this->namefilter = "parametersfiltercontactos";
		$this->route = "/page/contactos";
		$this->namepages ="pages_contactos";
		$this->namepageactual ="page_actual_contactos";
		$this->_view->route = $this->route;
		if(Session::getInstance()->get($this->namepages)){
			$this->pages = Session::getInstance()->get($this->namepages);
		} else {
			$this->pages = 20;
		}
		parent::init();
	}


	/**
     * Recibe la informacion y  muestra un listado de  contactos con sus respectivos filtros.
     *
     * @return void.
     */
	public function indexAction()
	{
		$title = "Administración de contactos";
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
	}

	/**
     * Genera la Informacion necesaria para editar o crear un  contacto  y muestra su formulario
     *
     * @return void.
     */
	public function manageAction()
	{
		$this->_view->route = $this->route;
		$this->_csrf_section = "manage_contactos_".date("YmdHis");
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
				$title = "Actualizar contacto";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}else{
				$this->_view->routeform = $this->route."/insert";
				$title = "Crear contacto";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}
		} else {
			$this->_view->routeform = $this->route."/insert";
			$title = "Crear contacto";
			$this->getLayout()->setTitle($title);
			$this->_view->titlesection = $title;
		}
	}

	/**
     * Inserta la informacion de un contacto  y redirecciona al listado de contactos.
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
			$data['log_tipo'] = 'CREAR CONTACTO';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);
		}
		$cliente = $this->_getSanitizedParam("cliente_id");
		$detalle = $this->_getSanitizedParam("detalle");
		header('Location: '.$this->route.'?cliente='.$cliente.'&detalle='.$detalle);
	}

	/**
     * Recibe un identificador  y Actualiza la informacion de un contacto  y redirecciona al listado de contactos.
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
			$data['log_tipo'] = 'EDITAR CONTACTO';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);}
		$cliente = $this->_getSanitizedParam("cliente_id");
		header('Location: '.$this->route.'?cliente='.$cliente.'');
	}

	/**
     * Recibe un identificador  y elimina un contacto  y redirecciona al listado de contactos.
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
					$data['log_tipo'] = 'BORRAR CONTACTO';
					$logModel = new Administracion_Model_DbTable_Log();
					$logModel->insert($data); }
			}
		}
		$cliente = $this->_getSanitizedParam("cliente");
		header('Location: '.$this->route.'?cliente='.$cliente.'');
	}

	/**
     * Recibe la informacion del formulario y la retorna en forma de array para la edicion y creacion de Contactos.
     *
     * @return array con toda la informacion recibida del formulario.
     */
	private function getData()
	{
		$data = array();
		$data['nombres'] = $this->_getSanitizedParam("nombres");
		$data['apellido1'] = $this->_getSanitizedParam("apellido1");
		$data['apellido2'] = $this->_getSanitizedParam("apellido2");
		$data['categoria'] = $this->_getSanitizedParam("categoria");
		$data['email'] = $this->_getSanitizedParam("email");
		$data['email2'] = $this->_getSanitizedParam("email2");
		$data['celular'] = $this->_getSanitizedParam("celular");
		$data['celular2'] = $this->_getSanitizedParam("celular2");
		$data['fecha_c'] = date("Y-m-d H:i:s");
		$data['quien'] = $_SESSION['kt_login_id'];
		$data['cliente_id'] = $this->_getSanitizedParamHtml("cliente_id");
		$data['observacion'] = $this->_getSanitizedParamHtml("observacion");
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
            if ($filters->nombres != '') {
                $filtros = $filtros." AND nombres LIKE '%".$filters->nombres."%'";
            }
            if ($filters->apellido1 != '') {
                $filtros = $filtros." AND apellido1 LIKE '%".$filters->apellido1."%'";
            }
            if ($filters->apellido2 != '') {
                $filtros = $filtros." AND apellido2 LIKE '%".$filters->apellido2."%'";
            }
            if ($filters->categoria != '') {
                $filtros = $filtros." AND categoria LIKE '%".$filters->categoria."%'";
            }
            if ($filters->email != '') {
                $filtros = $filtros." AND email LIKE '%".$filters->email."%'";
            }
            if ($filters->email2 != '') {
                $filtros = $filtros." AND email2 LIKE '%".$filters->email2."%'";
            }
            if ($filters->celular != '') {
                $filtros = $filtros." AND celular LIKE '%".$filters->celular."%'";
            }
            if ($filters->celular2 != '') {
                $filtros = $filtros." AND celular2 LIKE '%".$filters->celular2."%'";
            }
            if ($filters->fecha_c != '') {
                $filtros = $filtros." AND fecha_c LIKE '%".$filters->fecha_c."%'";
            }
            if ($filters->quien != '') {
                $filtros = $filtros." AND quien LIKE '%".$filters->quien."%'";
            }
            if ($filters->cliente_id != '') {
                $filtros = $filtros." AND cliente_id LIKE '%".$filters->cliente_id."%'";
            }
            if ($filters->observacion != '') {
                $filtros = $filtros." AND observacion LIKE '%".$filters->observacion."%'";
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
					$parramsfilter['nombres'] =  $this->_getSanitizedParam("nombres");
					$parramsfilter['apellido1'] =  $this->_getSanitizedParam("apellido1");
					$parramsfilter['apellido2'] =  $this->_getSanitizedParam("apellido2");
					$parramsfilter['categoria'] =  $this->_getSanitizedParam("categoria");
					$parramsfilter['email'] =  $this->_getSanitizedParam("email");
					$parramsfilter['email2'] =  $this->_getSanitizedParam("email2");
					$parramsfilter['celular'] =  $this->_getSanitizedParam("celular");
					$parramsfilter['celular2'] =  $this->_getSanitizedParam("celular2");
					$parramsfilter['fecha_c'] =  $this->_getSanitizedParam("fecha_c");
					$parramsfilter['quien'] =  $this->_getSanitizedParam("quien");
					$parramsfilter['cliente_id'] =  $this->_getSanitizedParam("cliente_id");
					$parramsfilter['observacion'] =  $this->_getSanitizedParam("observacion");Session::getInstance()->set($this->namefilter, $parramsfilter);
        }
        if ($this->_getSanitizedParam("cleanfilter") == 1) {
            Session::getInstance()->set($this->namefilter, '');
            Session::getInstance()->set($this->namepageactual,1);
        }
    }
}