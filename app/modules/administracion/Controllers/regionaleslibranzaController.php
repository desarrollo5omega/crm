<?php
/**
* Controlador de Regionaleslibranza que permite la  creacion, edicion  y eliminacion de los Regionales Libranza del Sistema
*/
class Administracion_regionaleslibranzaController extends Administracion_mainController
{
	/**
	 * $mainModel  instancia del modelo de  base de datos Regionales Libranza
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
	protected $_csrf_section = "administracion_regionaleslibranza";

	/**
	 * $namepages nombre de la pvariable en la cual se va a guardar  el numero de seccion en la paginacion del controlador
	 * @var string
	 */
	protected $namepages;



	/**
     * Inicializa las variables principales del controlador regionaleslibranza .
     *
     * @return void.
     */
	public function init()
	{
		$this->mainModel = new Administracion_Model_DbTable_Regionaleslibranza();
		$this->namefilter = "parametersfilterregionaleslibranza";
		$this->route = "/administracion/regionaleslibranza";
		$this->namepages ="pages_regionaleslibranza";
		$this->namepageactual ="page_actual_regionaleslibranza";
		$this->_view->route = $this->route;
		if(Session::getInstance()->get($this->namepages)){
			$this->pages = Session::getInstance()->get($this->namepages);
		} else {
			$this->pages = 20;
		}
		parent::init();
	}


	/**
     * Recibe la informacion y  muestra un listado de  Regionales Libranza con sus respectivos filtros.
     *
     * @return void.
     */
	public function indexAction()
	{
		$title = "Administración de Regionales Libranza";
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
		$this->_view->list_regional_identificacion = $this->getRegionalidentificacion();
	}

	/**
     * Genera la Informacion necesaria para editar o crear un  Regionales Libranza  y muestra su formulario
     *
     * @return void.
     */
	public function manageAction()
	{
		$this->_view->route = $this->route;
		$this->_csrf_section = "manage_regionaleslibranza_".date("YmdHis");
		$this->_csrf->generateCode($this->_csrf_section);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$this->_view->list_regional_identificacion = $this->getRegionalidentificacion();
		$id = $this->_getSanitizedParam("id");
		if ($id > 0) {
			$content = $this->mainModel->getById($id);
			if($content->regional_id){
				$this->_view->content = $content;
				$this->_view->routeform = $this->route."/update";
				$title = "Actualizar Regionales Libranza";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}else{
				$this->_view->routeform = $this->route."/insert";
				$title = "Crear Regionales Libranza";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}
		} else {
			$this->_view->routeform = $this->route."/insert";
			$title = "Crear Regionales Libranza";
			$this->getLayout()->setTitle($title);
			$this->_view->titlesection = $title;
		}
	}

	/**
     * Inserta la informacion de un Regionales Libranza  y redirecciona al listado de Regionales Libranza.
     *
     * @return void.
     */
	public function insertAction(){
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf ) {	
			$data = $this->getData();
			$id = $this->mainModel->insert($data);
			
			$data['regional_id']= $id;
			$data['log_log'] = print_r($data,true);
			$data['log_tipo'] = 'CREAR REGIONALES LIBRANZA';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);
		}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe un identificador  y Actualiza la informacion de un Regionales Libranza  y redirecciona al listado de Regionales Libranza.
     *
     * @return void.
     */
	public function updateAction(){
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf ) {
			$id = $this->_getSanitizedParam("id");
			$content = $this->mainModel->getById($id);
			if ($content->regional_id) {
				$data = $this->getData();
					$this->mainModel->update($data,$id);
			}
			$data['regional_id']=$id;
			$data['log_log'] = print_r($data,true);
			$data['log_tipo'] = 'EDITAR REGIONALES LIBRANZA';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe un identificador  y elimina un Regionales Libranza  y redirecciona al listado de Regionales Libranza.
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
					$data['log_tipo'] = 'BORRAR REGIONALES LIBRANZA';
					$logModel = new Administracion_Model_DbTable_Log();
					$logModel->insert($data); }
			}
		}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe la informacion del formulario y la retorna en forma de array para la edicion y creacion de Regionaleslibranza.
     *
     * @return array con toda la informacion recibida del formulario.
     */
	private function getData()
	{
		$data = array();
		$data['regional_regional'] = $this->_getSanitizedParam("regional_regional");
		$data['regional_cedula'] = $this->_getSanitizedParam("regional_cedula");
		$data['regional_nombre'] = $this->_getSanitizedParam("regional_nombre");
		$data['regional_cargo'] = $this->_getSanitizedParam("regional_cargo");
		$data['regional_correos'] = $this->_getSanitizedParam("regional_correos");
		$data['regional_identificacion'] = $this->_getSanitizedParam("regional_identificacion");
		return $data;
	}

	/**
     * Genera los valores del campo Id Regional.
     *
     * @return array cadena con los valores del campo Id Regional.
     */
	private function getRegionalidentificacion()
	{
		$modelData = new Administracion_Model_DbTable_Dependregional();
		$data = $modelData->getList();
		$array = array();
		foreach ($data as $key => $value) {
			$array[$value->id] = $value->nombre;
		}
		return $array;
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
            if ($filters->regional_regional != '') {
                $filtros = $filtros." AND regional_regional LIKE '%".$filters->regional_regional."%'";
            }
            if ($filters->regional_cedula != '') {
                $filtros = $filtros." AND regional_cedula LIKE '%".$filters->regional_cedula."%'";
            }
            if ($filters->regional_nombre != '') {
                $filtros = $filtros." AND regional_nombre LIKE '%".$filters->regional_nombre."%'";
            }
            if ($filters->regional_cargo != '') {
                $filtros = $filtros." AND regional_cargo LIKE '%".$filters->regional_cargo."%'";
            }
            if ($filters->regional_correos != '') {
                $filtros = $filtros." AND regional_correos LIKE '%".$filters->regional_correos."%'";
            }
            if ($filters->regional_identificacion != '') {
                $filtros = $filtros." AND regional_identificacion LIKE '%".$filters->regional_identificacion."%'";
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
					$parramsfilter['regional_regional'] =  $this->_getSanitizedParam("regional_regional");
					$parramsfilter['regional_cedula'] =  $this->_getSanitizedParam("regional_cedula");
					$parramsfilter['regional_nombre'] =  $this->_getSanitizedParam("regional_nombre");
					$parramsfilter['regional_cargo'] =  $this->_getSanitizedParam("regional_cargo");
					$parramsfilter['regional_correos'] =  $this->_getSanitizedParam("regional_correos");
					$parramsfilter['regional_identificacion'] =  $this->_getSanitizedParam("regional_identificacion");Session::getInstance()->set($this->namefilter, $parramsfilter);
        }
        if ($this->_getSanitizedParam("cleanfilter") == 1) {
            Session::getInstance()->set($this->namefilter, '');
            Session::getInstance()->set($this->namepageactual,1);
        }
    }
}