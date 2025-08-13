<?php
/**
* Controlador de Referencias que permite la  creacion, edicion  y eliminacion de los referencias del Sistema
*/
class Administracion_referenciasController extends Administracion_mainController
{
	/**
	 * $mainModel  instancia del modelo de  base de datos referencias
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
	protected $_csrf_section = "administracion_referencias";

	/**
	 * $namepages nombre de la pvariable en la cual se va a guardar  el numero de seccion en la paginacion del controlador
	 * @var string
	 */
	protected $namepages;



	/**
     * Inicializa las variables principales del controlador referencias .
     *
     * @return void.
     */
	public function init()
	{
		$this->mainModel = new Administracion_Model_DbTable_Referencias();
		$this->namefilter = "parametersfilterreferencias";
		$this->route = "/administracion/referencias";
		$this->namepages ="pages_referencias";
		$this->namepageactual ="page_actual_referencias";
		$this->_view->route = $this->route;
		if(Session::getInstance()->get($this->namepages)){
			$this->pages = Session::getInstance()->get($this->namepages);
		} else {
			$this->pages = 20;
		}
		parent::init();
	}


	/**
     * Recibe la informacion y  muestra un listado de  referencias con sus respectivos filtros.
     *
     * @return void.
     */
	public function indexAction()
	{
		$title = "Administración de referencias";
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
     * Genera la Informacion necesaria para editar o crear un  referencia  y muestra su formulario
     *
     * @return void.
     */
	public function manageAction()
	{
		$this->_view->route = $this->route;
		$this->_csrf_section = "manage_referencias_".date("YmdHis");
		$this->_csrf->generateCode($this->_csrf_section);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$id = $this->_getSanitizedParam("id");
		if ($id > 0) {
			$content = $this->mainModel->getById($id);
			if($content->id){
				$this->_view->content = $content;
				$this->_view->routeform = $this->route."/update";
				$title = "Actualizar referencia";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}else{
				$this->_view->routeform = $this->route."/insert";
				$title = "Crear referencia";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}
		} else {
			$this->_view->routeform = $this->route."/insert";
			$title = "Crear referencia";
			$this->getLayout()->setTitle($title);
			$this->_view->titlesection = $title;
		}
	}

	/**
     * Inserta la informacion de un referencia  y redirecciona al listado de referencias.
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
			$data['log_tipo'] = 'CREAR REFERENCIA';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);
		}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe un identificador  y Actualiza la informacion de un referencia  y redirecciona al listado de referencias.
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
			$data['log_tipo'] = 'EDITAR REFERENCIA';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe un identificador  y elimina un referencia  y redirecciona al listado de referencias.
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
					$data['log_tipo'] = 'BORRAR REFERENCIA';
					$logModel = new Administracion_Model_DbTable_Log();
					$logModel->insert($data); }
			}
		}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe la informacion del formulario y la retorna en forma de array para la edicion y creacion de Referencias.
     *
     * @return array con toda la informacion recibida del formulario.
     */
	private function getData()
	{
		$data = array();
		if($this->_getSanitizedParam("solicitud") == '' ) {
			$data['solicitud'] = '0';
		} else {
			$data['solicitud'] = $this->_getSanitizedParam("solicitud");
		}
		if($this->_getSanitizedParam("tipo") == '' ) {
			$data['tipo'] = '0';
		} else {
			$data['tipo'] = $this->_getSanitizedParam("tipo");
		}
		if($this->_getSanitizedParam("numero") == '' ) {
			$data['numero'] = '0';
		} else {
			$data['numero'] = $this->_getSanitizedParam("numero");
		}
		$data['nombres'] = $this->_getSanitizedParam("nombres");
		$data['parentesco'] = $this->_getSanitizedParam("parentesco");
		$data['direccion'] = $this->_getSanitizedParam("direccion");
		$data['ciudad'] = $this->_getSanitizedParam("ciudad");
		$data['telefono'] = $this->_getSanitizedParam("telefono");
		$data['celular'] = $this->_getSanitizedParam("celular");
		$data['departamento'] = $this->_getSanitizedParam("departamento");
		$data['actividad'] = $this->_getSanitizedParam("actividad");
		$data['empresa'] = $this->_getSanitizedParam("empresa");
		$data['cargo'] = $this->_getSanitizedParam("cargo");
		$data['telefono_empresa'] = $this->_getSanitizedParam("telefono_empresa");
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
            if ($filters->solicitud != '') {
                $filtros = $filtros." AND solicitud LIKE '%".$filters->solicitud."%'";
            }
            if ($filters->tipo != '') {
                $filtros = $filtros." AND tipo LIKE '%".$filters->tipo."%'";
            }
            if ($filters->numero != '') {
                $filtros = $filtros." AND numero LIKE '%".$filters->numero."%'";
            }
            if ($filters->nombres != '') {
                $filtros = $filtros." AND nombres LIKE '%".$filters->nombres."%'";
            }
            if ($filters->parentesco != '') {
                $filtros = $filtros." AND parentesco LIKE '%".$filters->parentesco."%'";
            }
            if ($filters->direccion != '') {
                $filtros = $filtros." AND direccion LIKE '%".$filters->direccion."%'";
            }
            if ($filters->ciudad != '') {
                $filtros = $filtros." AND ciudad LIKE '%".$filters->ciudad."%'";
            }
            if ($filters->telefono != '') {
                $filtros = $filtros." AND telefono LIKE '%".$filters->telefono."%'";
            }
            if ($filters->celular != '') {
                $filtros = $filtros." AND celular LIKE '%".$filters->celular."%'";
            }
            if ($filters->departamento != '') {
                $filtros = $filtros." AND departamento LIKE '%".$filters->departamento."%'";
            }
            if ($filters->actividad != '') {
                $filtros = $filtros." AND actividad LIKE '%".$filters->actividad."%'";
            }
            if ($filters->empresa != '') {
                $filtros = $filtros." AND empresa LIKE '%".$filters->empresa."%'";
            }
            if ($filters->cargo != '') {
                $filtros = $filtros." AND cargo LIKE '%".$filters->cargo."%'";
            }
            if ($filters->telefono_empresa != '') {
                $filtros = $filtros." AND telefono_empresa LIKE '%".$filters->telefono_empresa."%'";
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
					$parramsfilter['solicitud'] =  $this->_getSanitizedParam("solicitud");
					$parramsfilter['tipo'] =  $this->_getSanitizedParam("tipo");
					$parramsfilter['numero'] =  $this->_getSanitizedParam("numero");
					$parramsfilter['nombres'] =  $this->_getSanitizedParam("nombres");
					$parramsfilter['parentesco'] =  $this->_getSanitizedParam("parentesco");
					$parramsfilter['direccion'] =  $this->_getSanitizedParam("direccion");
					$parramsfilter['ciudad'] =  $this->_getSanitizedParam("ciudad");
					$parramsfilter['telefono'] =  $this->_getSanitizedParam("telefono");
					$parramsfilter['celular'] =  $this->_getSanitizedParam("celular");
					$parramsfilter['departamento'] =  $this->_getSanitizedParam("departamento");
					$parramsfilter['actividad'] =  $this->_getSanitizedParam("actividad");
					$parramsfilter['empresa'] =  $this->_getSanitizedParam("empresa");
					$parramsfilter['cargo'] =  $this->_getSanitizedParam("cargo");
					$parramsfilter['telefono_empresa'] =  $this->_getSanitizedParam("telefono_empresa");Session::getInstance()->set($this->namefilter, $parramsfilter);
        }
        if ($this->_getSanitizedParam("cleanfilter") == 1) {
            Session::getInstance()->set($this->namefilter, '');
            Session::getInstance()->set($this->namepageactual,1);
        }
    }
}