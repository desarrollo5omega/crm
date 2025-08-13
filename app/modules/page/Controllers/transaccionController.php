<?php
/**
* Controlador de Transaccion que permite la  creacion, edicion  y eliminacion de los transaccion del Sistema
*/
class Page_transaccionController extends Page_mainController
{
	/**
	 * $mainModel  instancia del modelo de  base de datos transaccion
	 * @var modeloContenidos
	 */
	private $mainModel;

	/**
	 * $route  url del controlador base
	 * @var string
	 */
	private $route;

	/**
	 * $pages cantidad de registros a mostrar por pagina]
	 * @var integer
	 */
	private $pages ;

	/**
	 * $namefilter nombre de la variable a la fual se le van a guardar los filtros
	 * @var string
	 */
	protected $namefilter;

	/**
	 * $_csrf_section  nombre de la variable general csrf  que se va a almacenar en la session
	 * @var string
	 */
	protected $_csrf_section = "page_transaccion";

	/**
	 * $namepages nombre de la pvariable en la cual se va a guardar  el numero de seccion en la paginacion del controlador
	 * @var string
	 */
	protected $namepages;



	/**
     * Inicializa las variables principales del controlador transaccion .
     *
     * @return void.
     */
	public function init()
	{
		$this->mainModel = new Page_Model_DbTable_Transaccion();
		$this->namefilter = "parametersfiltertransaccion";
		$this->route = "/page/transaccion";
		$this->namepages ="pages_transaccion";
		$this->_view->route = $this->route;
		if(Session::getInstance()->get($this->namepages)){
			$this->pages = Session::getInstance()->get($this->namepages);
		} else {
			$this->pages = 20;
		}
		parent::init();
	}


	/**
     * Recibe la informacion y  muestra un listado de  transaccion con sus respectivos filtros.
     *
     * @return void.
     */
	public function indexAction()
	{
		$this->setLayout('administracion_panel');
		$this->getLayout()->setTitle("Listar transaccion");
		$this->filters();
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$filters =(object)Session::getInstance()->get($this->namefilter);
        $this->_view->filters = $filters;
		$filters = $this->getFilter();
		$order = "";
		$list = $this->mainModel->getList($filters,$order);
		$amount = $this->pages;
		$page = $this->_getSanitizedParam("page");
		if (!$page) {
		   	$start = 0;
		   	$page=1;
		}
		else {
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
     * Genera la Informacion necesaria para editar o crear un  transaccion  y muestra su formulario
     *
     * @return void.
     */
	public function manageAction()
	{
		$this->_view->route = $this->route;
		$this->setLayout('administracion_panel');
		$this->_csrf_section = "manage_transaccion_".date("YmdHis");
		$this->_csrf->generateCode($this->_csrf_section);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$id = $this->_getSanitizedParam("id");
		if ($id > 0) {
			$content = $this->mainModel->getById($id);
			if($content->id){
				$this->_view->content = $content;
				$this->_view->routeform = $this->route."/update";
				$this->getLayout()->setTitle("Actualizar transaccion");
			}else{
				$this->_view->routeform = $this->route."/insert";
				$this->getLayout()->setTitle("Crear transaccion");
			}
		} else {
			$this->_view->routeform = $this->route."/insert";
			$this->getLayout()->setTitle("Crear transaccion");
		}
	}

	/**
     * Inserta la informacion de un transaccion  y redirecciona al listado de transaccion.
     *
     * @return void.
     */
	public function insertAction(){
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf ) {	
			$data = $this->getData();
			$id = $this->mainModel->insert($data);
			
		}
		header('Location: '.$this->route);
	}

	/**
     * Recibe un identificador  y Actualiza la informacion de un transaccion  y redirecciona al listado de transaccion.
     *
     * @return void.
     */
	public function updateAction(){
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf ) {
			$id = $this->_getSanitizedParam("id");
			$content = $this->mainModel->getById($id);
			if ($content->id) {
				$data = $this->getData();
					$this->mainModel->update($data,$id);
			}
		}
		header('Location: '.$this->route);
	}

	/**
     * Recibe un identificador  y elimina un transaccion  y redirecciona al listado de transaccion.
     *
     * @return void.
     */
	public function deleteAction()
	{
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_csrf_section] == $csrf ) {
			$id =  $this->_getSanitizedParam("id");
			if (isset($id) && $id > 0) {
				$content = $this->mainModel->getById($id);
				if (isset($content)) {
					$this->mainModel->deleteRegister($id);
				}
			}
		}
		header('Location: '.$this->route);
	}

	/**
     * Recibe la informacion del formulario y la retorna en forma de array para la edicion y creacion de Transaccion.
     *
     * @return array con toda la informacion recibida del formulario.
     */
	private function getData()
	{
		$data = array();
		$data['metodo'] = $this->_getSanitizedParam("metodo");
		$data['xml'] = $this->_getSanitizedParam("xml");
		$data['res'] = $this->_getSanitizedParam("res");
		$data['exitoso'] = $this->_getSanitizedParam("exitoso");
		$data['codigoError'] = $this->_getSanitizedParam("codigoError");
		$data['fecha'] = $this->_getSanitizedParam("fecha");
		if($this->_getSanitizedParam("solicitud") == '' ) {
			$data['solicitud'] = '0';
		} else {
			$data['solicitud'] = $this->_getSanitizedParam("solicitud");
		}
		$data['numero_solicitud'] = $this->_getSanitizedParam("numero_solicitud");
		$data['ip'] = $this->_getSanitizedParam("ip");
		if($this->_getSanitizedParam("quien") == '' ) {
			$data['quien'] = '0';
		} else {
			$data['quien'] = $this->_getSanitizedParam("quien");
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
            $parramsfilter = array();Session::getInstance()->set($this->namefilter, $parramsfilter);
        }
        if ($this->_getSanitizedParam("cleanfilter") == 1) {
             Session::getInstance()->set($this->namefilter, '');
        }
    }
}