<?php
/**
* Controlador de Infofinanciera que permite la  creacion, edicion  y eliminacion de los info financiera del Sistema
*/
class Administracion_infofinancieraController extends Administracion_mainController
{
	/**
	 * $mainModel  instancia del modelo de  base de datos info financiera
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
	protected $_csrf_section = "administracion_infofinanciera";

	/**
	 * $namepages nombre de la pvariable en la cual se va a guardar  el numero de seccion en la paginacion del controlador
	 * @var string
	 */
	protected $namepages;



	/**
     * Inicializa las variables principales del controlador infofinanciera .
     *
     * @return void.
     */
	public function init()
	{
		$this->mainModel = new Administracion_Model_DbTable_Infofinanciera();
		$this->namefilter = "parametersfilterinfofinanciera";
		$this->route = "/administracion/infofinanciera";
		$this->namepages ="pages_infofinanciera";
		$this->namepageactual ="page_actual_infofinanciera";
		$this->_view->route = $this->route;
		if(Session::getInstance()->get($this->namepages)){
			$this->pages = Session::getInstance()->get($this->namepages);
		} else {
			$this->pages = 20;
		}
		parent::init();
	}


	/**
     * Recibe la informacion y  muestra un listado de  info financiera con sus respectivos filtros.
     *
     * @return void.
     */
	public function indexAction()
	{
		$title = "Administración de info financiera";
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
     * Genera la Informacion necesaria para editar o crear un  info financiera  y muestra su formulario
     *
     * @return void.
     */
	public function manageAction()
	{
		$this->_view->route = $this->route;
		$this->_csrf_section = "manage_infofinanciera_".date("YmdHis");
		$this->_csrf->generateCode($this->_csrf_section);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$id = $this->_getSanitizedParam("id");
		if ($id > 0) {
			$content = $this->mainModel->getById($id);
			if($content->id){
				$this->_view->content = $content;
				$this->_view->routeform = $this->route."/update";
				$title = "Actualizar info financiera";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}else{
				$this->_view->routeform = $this->route."/insert";
				$title = "Crear info financiera";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}
		} else {
			$this->_view->routeform = $this->route."/insert";
			$title = "Crear info financiera";
			$this->getLayout()->setTitle($title);
			$this->_view->titlesection = $title;
		}
	}

	/**
     * Inserta la informacion de un info financiera  y redirecciona al listado de info financiera.
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
			$data['log_tipo'] = 'CREAR INFO FINANCIERA';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);
		}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe un identificador  y Actualiza la informacion de un info financiera  y redirecciona al listado de info financiera.
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
			$data['log_tipo'] = 'EDITAR INFO FINANCIERA';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe un identificador  y elimina un info financiera  y redirecciona al listado de info financiera.
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
					$data['log_tipo'] = 'BORRAR INFO FINANCIERA';
					$logModel = new Administracion_Model_DbTable_Log();
					$logModel->insert($data); }
			}
		}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe la informacion del formulario y la retorna en forma de array para la edicion y creacion de Infofinanciera.
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
		$data['cedula'] = $this->_getSanitizedParam("cedula");
		if($this->_getSanitizedParam("salario") == '' ) {
			$data['salario'] = '0';
		} else {
			$data['salario'] = $this->_getSanitizedParam("salario");
		}
		if($this->_getSanitizedParam("pension") == '' ) {
			$data['pension'] = '0';
		} else {
			$data['pension'] = $this->_getSanitizedParam("pension");
		}
		if($this->_getSanitizedParam("arriendos") == '' ) {
			$data['arriendos'] = '0';
		} else {
			$data['arriendos'] = $this->_getSanitizedParam("arriendos");
		}
		if($this->_getSanitizedParam("dividendos") == '' ) {
			$data['dividendos'] = '0';
		} else {
			$data['dividendos'] = $this->_getSanitizedParam("dividendos");
		}
		if($this->_getSanitizedParam("rentas") == '' ) {
			$data['rentas'] = '0';
		} else {
			$data['rentas'] = $this->_getSanitizedParam("rentas");
		}
		if($this->_getSanitizedParam("otros_ingresos") == '' ) {
			$data['otros_ingresos'] = '0';
		} else {
			$data['otros_ingresos'] = $this->_getSanitizedParam("otros_ingresos");
		}
		if($this->_getSanitizedParam("total_ingresos") == '' ) {
			$data['total_ingresos'] = '0';
		} else {
			$data['total_ingresos'] = $this->_getSanitizedParam("total_ingresos");
		}
		if($this->_getSanitizedParam("arrendamientos") == '' ) {
			$data['arrendamientos'] = '0';
		} else {
			$data['arrendamientos'] = $this->_getSanitizedParam("arrendamientos");
		}
		if($this->_getSanitizedParam("gastos_familiares") == '' ) {
			$data['gastos_familiares'] = '0';
		} else {
			$data['gastos_familiares'] = $this->_getSanitizedParam("gastos_familiares");
		}
		if($this->_getSanitizedParam("obligaciones_financieras") == '' ) {
			$data['obligaciones_financieras'] = '0';
		} else {
			$data['obligaciones_financieras'] = $this->_getSanitizedParam("obligaciones_financieras");
		}
		if($this->_getSanitizedParam("otros_gastos") == '' ) {
			$data['otros_gastos'] = '0';
		} else {
			$data['otros_gastos'] = $this->_getSanitizedParam("otros_gastos");
		}
		if($this->_getSanitizedParam("total_gastos") == '' ) {
			$data['total_gastos'] = '0';
		} else {
			$data['total_gastos'] = $this->_getSanitizedParam("total_gastos");
		}
		if($this->_getSanitizedParam("capacidad_endeudamiento") == '' ) {
			$data['capacidad_endeudamiento'] = '0';
		} else {
			$data['capacidad_endeudamiento'] = $this->_getSanitizedParam("capacidad_endeudamiento");
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
        if (Session::getInstance()->get($this->namefilter)!="") {
            $filters =(object)Session::getInstance()->get($this->namefilter);
            if ($filters->solicitud != '') {
                $filtros = $filtros." AND solicitud LIKE '%".$filters->solicitud."%'";
            }
            if ($filters->cedula != '') {
                $filtros = $filtros." AND cedula LIKE '%".$filters->cedula."%'";
            }
            if ($filters->salario != '') {
                $filtros = $filtros." AND salario LIKE '%".$filters->salario."%'";
            }
            if ($filters->pension != '') {
                $filtros = $filtros." AND pension LIKE '%".$filters->pension."%'";
            }
            if ($filters->arriendos != '') {
                $filtros = $filtros." AND arriendos LIKE '%".$filters->arriendos."%'";
            }
            if ($filters->dividendos != '') {
                $filtros = $filtros." AND dividendos LIKE '%".$filters->dividendos."%'";
            }
            if ($filters->rentas != '') {
                $filtros = $filtros." AND rentas LIKE '%".$filters->rentas."%'";
            }
            if ($filters->otros_ingresos != '') {
                $filtros = $filtros." AND otros_ingresos LIKE '%".$filters->otros_ingresos."%'";
            }
            if ($filters->total_ingresos != '') {
                $filtros = $filtros." AND total_ingresos LIKE '%".$filters->total_ingresos."%'";
            }
            if ($filters->arrendamientos != '') {
                $filtros = $filtros." AND arrendamientos LIKE '%".$filters->arrendamientos."%'";
            }
            if ($filters->gastos_familiares != '') {
                $filtros = $filtros." AND gastos_familiares LIKE '%".$filters->gastos_familiares."%'";
            }
            if ($filters->obligaciones_financieras != '') {
                $filtros = $filtros." AND obligaciones_financieras LIKE '%".$filters->obligaciones_financieras."%'";
            }
            if ($filters->otros_gastos != '') {
                $filtros = $filtros." AND otros_gastos LIKE '%".$filters->otros_gastos."%'";
            }
            if ($filters->total_gastos != '') {
                $filtros = $filtros." AND total_gastos LIKE '%".$filters->total_gastos."%'";
            }
            if ($filters->capacidad_endeudamiento != '') {
                $filtros = $filtros." AND capacidad_endeudamiento LIKE '%".$filters->capacidad_endeudamiento."%'";
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
					$parramsfilter['cedula'] =  $this->_getSanitizedParam("cedula");
					$parramsfilter['salario'] =  $this->_getSanitizedParam("salario");
					$parramsfilter['pension'] =  $this->_getSanitizedParam("pension");
					$parramsfilter['arriendos'] =  $this->_getSanitizedParam("arriendos");
					$parramsfilter['dividendos'] =  $this->_getSanitizedParam("dividendos");
					$parramsfilter['rentas'] =  $this->_getSanitizedParam("rentas");
					$parramsfilter['otros_ingresos'] =  $this->_getSanitizedParam("otros_ingresos");
					$parramsfilter['total_ingresos'] =  $this->_getSanitizedParam("total_ingresos");
					$parramsfilter['arrendamientos'] =  $this->_getSanitizedParam("arrendamientos");
					$parramsfilter['gastos_familiares'] =  $this->_getSanitizedParam("gastos_familiares");
					$parramsfilter['obligaciones_financieras'] =  $this->_getSanitizedParam("obligaciones_financieras");
					$parramsfilter['otros_gastos'] =  $this->_getSanitizedParam("otros_gastos");
					$parramsfilter['total_gastos'] =  $this->_getSanitizedParam("total_gastos");
					$parramsfilter['capacidad_endeudamiento'] =  $this->_getSanitizedParam("capacidad_endeudamiento");Session::getInstance()->set($this->namefilter, $parramsfilter);
        }
        if ($this->_getSanitizedParam("cleanfilter") == 1) {
            Session::getInstance()->set($this->namefilter, '');
            Session::getInstance()->set($this->namepageactual,1);
        }
    }
}