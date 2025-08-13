<?php
/**
* Controlador de Usuario que permite la  creacion, edicion  y eliminacion de los Usuarios del Sistema
*/
class Page_logController extends Page_mainController
{
	public $botonpanel = 4;
	/**
	 * $mainModel  instancia del modelo de  base de datos Usuarios
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
	protected $_csrf_section = "page_log";

	/**
	 * $namepages nombre de la pvariable en la cual se va a guardar  el numero de seccion en la paginacion del controlador
	 * @var string
	 */
	protected $namepages;



	/**
     * Inicializa las variables principales del controlador usuario .
     *
     * @return void.
     */
	public function init()
	{
		$this->mainModel = new Administracion_Model_DbTable_Log();
		$this->namefilter = "parametersfilterlog";
		$this->route = "/page/log";
		$this->namepages ="pages_log";
		$this->namepageactual ="page_actual_log";
		$this->_view->route = $this->route;
		if(Session::getInstance()->get($this->namepages)){
			$this->pages = Session::getInstance()->get($this->namepages);
		} else {
			$this->pages = 20;
		}
		parent::init();
	}


	/**
     * Recibe la informacion y  muestra un listado de  Usuarios con sus respectivos filtros.
     *
     * @return void.
     */
	public function indexAction()
	{
		
		$title = "Logs";
		$this->getLayout()->setTitle($title);
		$this->_view->titlesection = $title;
		$this->filters();
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$filters =(object)Session::getInstance()->get($this->namefilter);
        $this->_view->filters = $filters;
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
     * Genera la consulta con los filtros de este controlador.
     *
     * @return array cadena con los filtros que se van a asignar a la base de datos
     */
    protected function getFilter()
    {
    	$filtros = " log_tipo = 'LOGIN' ";
        if (Session::getInstance()->get($this->namefilter)!="") {
            $filters =(object)Session::getInstance()->get($this->namefilter);
            if ($filters->user_state != '') {
                $filtros = $filtros." AND user_state ='".$filters->user_state."'";
            }
            if ($filters->user_date != '') {
                $filtros = $filtros." AND user_date LIKE '%".$filters->user_date."%'";
            }
            if ($filters->user_names != '') {
                $filtros = $filtros." AND user_names LIKE '%".$filters->user_names."%'";
            }
            if ($filters->user_level != '') {
                $filtros = $filtros." AND user_level ='".$filters->user_level."'";
            }
            if ($filters->user_user != '') {
                $filtros = $filtros." AND user_user LIKE '%".$filters->user_user."%'";
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
					$parramsfilter['user_state'] =  $this->_getSanitizedParam("user_state");
					$parramsfilter['user_date'] =  $this->_getSanitizedParam("user_date");
					$parramsfilter['user_names'] =  $this->_getSanitizedParam("user_names");
					$parramsfilter['user_level'] =  $this->_getSanitizedParam("user_level");
					$parramsfilter['user_user'] =  $this->_getSanitizedParam("user_user");Session::getInstance()->set($this->namefilter, $parramsfilter);
        }
        if ($this->_getSanitizedParam("cleanfilter") == 1) {
            Session::getInstance()->set($this->namefilter, '');
            Session::getInstance()->set($this->namepageactual,1);
        }
    }

}