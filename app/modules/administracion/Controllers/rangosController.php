<?php
/**
* Controlador de Rangos que permite la  creacion, edicion  y eliminacion de los rangos de tasas del Sistema
*/
class Administracion_rangosController extends Administracion_mainController
{
	/**
	 * $mainModel  instancia del modelo de  base de datos rangos de tasas
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
	protected $_csrf_section = "administracion_rangos";

	/**
	 * $namepages nombre de la pvariable en la cual se va a guardar  el numero de seccion en la paginacion del controlador
	 * @var string
	 */
	protected $namepages;



	/**
     * Inicializa las variables principales del controlador rangos .
     *
     * @return void.
     */
	public function init()
	{
		$this->mainModel = new Administracion_Model_DbTable_Rangos();
		$this->namefilter = "parametersfilterrangos";
		$this->route = "/administracion/rangos";
		$this->namepages ="pages_rangos";
		$this->namepageactual ="page_actual_rangos";
		$this->_view->route = $this->route;
		if(Session::getInstance()->get($this->namepages)){
			$this->pages = Session::getInstance()->get($this->namepages);
		} else {
			$this->pages = 20;
		}
		parent::init();
	}


	/**
     * Recibe la informacion y  muestra un listado de  rangos de tasas con sus respectivos filtros.
     *
     * @return void.
     */
	public function indexAction()
	{
		$title = "Administración de rangos de tasas";
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
		$this->_view->linea = $this->_getSanitizedParam("linea");

		$this->_view->lineas = $this->getLineas();
	}

	public function getLineas(){
		$lineasModel = new Administracion_Model_DbTable_Lineas();
		$lineas = $lineasModel->getList("","");
		$array = array();
		foreach ($lineas as $key => $value) {
			$array[$value->codigo] = $value->nombre;
		}
		return $array;
	}

	/**
     * Genera la Informacion necesaria para editar o crear un  rango  y muestra su formulario
     *
     * @return void.
     */
	public function manageAction()
	{
		$this->_view->route = $this->route;
		$this->_csrf_section = "manage_rangos_".date("YmdHis");
		$this->_csrf->generateCode($this->_csrf_section);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$this->_view->linea = $this->_getSanitizedParam("linea");
		$id = $this->_getSanitizedParam("id");
		if ($id > 0) {
			$content = $this->mainModel->getById($id);
			if($content->rango_id){
				$this->_view->content = $content;
				$this->_view->routeform = $this->route."/update";
				$title = "Actualizar rango";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}else{
				$this->_view->routeform = $this->route."/insert";
				$title = "Crear rango";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}
		} else {
			$this->_view->routeform = $this->route."/insert";
			$title = "Crear rango";
			$this->getLayout()->setTitle($title);
			$this->_view->titlesection = $title;
		}
	}

	/**
     * Inserta la informacion de un rango  y redirecciona al listado de rangos de tasas.
     *
     * @return void.
     */
	public function insertAction(){
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf ) {	
			$data = $this->getData();
			$id = $this->mainModel->insert($data);
			
			$data['rango_id']= $id;
			$data['log_log'] = print_r($data,true);
			$data['log_tipo'] = 'CREAR RANGO';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);
		}
		$linea = $this->_getSanitizedParam("rango_codigo");
		header('Location: '.$this->route.'?linea='.$linea.'');
	}

	/**
     * Recibe un identificador  y Actualiza la informacion de un rango  y redirecciona al listado de rangos de tasas.
     *
     * @return void.
     */
	public function updateAction(){
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf ) {
			$id = $this->_getSanitizedParam("id");
			$content = $this->mainModel->getById($id);
			if ($content->rango_id) {
				$data = $this->getData();
					$this->mainModel->update($data,$id);
			}
			$data['rango_id']=$id;
			$data['log_log'] = print_r($data,true);
			$data['log_tipo'] = 'EDITAR RANGO';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);}
		$linea = $this->_getSanitizedParam("rango_codigo");
		header('Location: '.$this->route.'?linea='.$linea.'');
	}

	/**
     * Recibe un identificador  y elimina un rango  y redirecciona al listado de rangos de tasas.
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
					$data['log_tipo'] = 'BORRAR RANGO';
					$logModel = new Administracion_Model_DbTable_Log();
					$logModel->insert($data); }
			}
		}
		$linea = $this->_getSanitizedParam("linea");
		header('Location: '.$this->route.'?linea='.$linea.'');
	}

	/**
     * Recibe la informacion del formulario y la retorna en forma de array para la edicion y creacion de Rangos.
     *
     * @return array con toda la informacion recibida del formulario.
     */
	private function getData()
	{
		$data = array();
		$data['rango_codigo'] = $this->_getSanitizedParamHtml("rango_codigo");
		$data['rango_min'] = $this->_getSanitizedParam("rango_min");
		$data['rango_max'] = $this->_getSanitizedParam("rango_max");
		if($this->_getSanitizedParam("rango_tasa_mensual") == '' ) {
			$data['rango_tasa_mensual'] = '0';
		} else {
			$data['rango_tasa_mensual'] = $this->_getSanitizedParam("rango_tasa_mensual");
		}
		if($this->_getSanitizedParam("rango_tasa_anual") == '' ) {
			$data['rango_tasa_anual'] = '0';
		} else {
			$data['rango_tasa_anual'] = $this->_getSanitizedParam("rango_tasa_anual");
		}
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

		if ($_GET['linea'] != '') {
		
			$filtros = $filtros." AND rango_codigo = '".$_GET['linea']."' ";
		}
        if (Session::getInstance()->get($this->namefilter)!="") {
            $filters =(object)Session::getInstance()->get($this->namefilter);
            if ($filters->rango_codigo != '') {
                $filtros = $filtros." AND rango_codigo = '".$filters->rango_codigo."'";
			}
		
            if ($filters->rango_min != '') {
                $filtros = $filtros." AND rango_min LIKE '%".$filters->rango_min."%'";
            }
            if ($filters->rango_max != '') {
                $filtros = $filtros." AND rango_max LIKE '%".$filters->rango_max."%'";
            }
            if ($filters->rango_tasa_mensual != '') {
                $filtros = $filtros." AND rango_tasa_mensual LIKE '%".$filters->rango_tasa_mensual."%'";
            }
            if ($filters->rango_tasa_anual != '') {
                $filtros = $filtros." AND rango_tasa_anual LIKE '%".$filters->rango_tasa_anual."%'";
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
					$parramsfilter['rango_codigo'] =  $this->_getSanitizedParam("rango_codigo");
					$parramsfilter['rango_min'] =  $this->_getSanitizedParam("rango_min");
					$parramsfilter['rango_max'] =  $this->_getSanitizedParam("rango_max");
					$parramsfilter['rango_tasa_mensual'] =  $this->_getSanitizedParam("rango_tasa_mensual");
					$parramsfilter['rango_tasa_anual'] =  $this->_getSanitizedParam("rango_tasa_anual");Session::getInstance()->set($this->namefilter, $parramsfilter);
        }
        if ($this->_getSanitizedParam("cleanfilter") == 1) {
            Session::getInstance()->set($this->namefilter, '');
            Session::getInstance()->set($this->namepageactual,1);
        }
    }
}