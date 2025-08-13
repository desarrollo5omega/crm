<?php
/**
* Controlador de Documentossarlaft que permite la  creacion, edicion  y eliminacion de los documentos sarlaft del Sistema
*/
class Administracion_documentossarlaftController extends Administracion_mainController
{
	/**
	 * $mainModel  instancia del modelo de  base de datos documentos sarlaft
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
	protected $_csrf_section = "administracion_documentossarlaft";

	/**
	 * $namepages nombre de la pvariable en la cual se va a guardar  el numero de seccion en la paginacion del controlador
	 * @var string
	 */
	protected $namepages;



	/**
     * Inicializa las variables principales del controlador documentossarlaft .
     *
     * @return void.
     */
	public function init()
	{
		$this->mainModel = new Administracion_Model_DbTable_Documentossarlaft();
		$this->namefilter = "parametersfilterdocumentossarlaft";
		$this->route = "/administracion/documentossarlaft";
		$this->namepages ="pages_documentossarlaft";
		$this->namepageactual ="page_actual_documentossarlaft";
		$this->_view->route = $this->route;
		if(Session::getInstance()->get($this->namepages)){
			$this->pages = Session::getInstance()->get($this->namepages);
		} else {
			$this->pages = 20;
		}
		parent::init();
	}


	/**
     * Recibe la informacion y  muestra un listado de  documentos sarlaft con sus respectivos filtros.
     *
     * @return void.
     */
	public function indexAction()
	{
		$title = "Administración de documentos sarlaft";
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
     * Genera la Informacion necesaria para editar o crear un  documentos sarlaft  y muestra su formulario
     *
     * @return void.
     */
	public function manageAction()
	{
		$this->_view->route = $this->route;
		$this->_csrf_section = "manage_documentossarlaft_".date("YmdHis");
		$this->_csrf->generateCode($this->_csrf_section);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$id = $this->_getSanitizedParam("id");
		if ($id > 0) {
			$content = $this->mainModel->getById($id);
			if($content->id){
				$this->_view->content = $content;
				$this->_view->routeform = $this->route."/update";
				$title = "Actualizar documentos sarlaft";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}else{
				$this->_view->routeform = $this->route."/insert";
				$title = "Crear documentos sarlaft";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}
		} else {
			$this->_view->routeform = $this->route."/insert";
			$title = "Crear documentos sarlaft";
			$this->getLayout()->setTitle($title);
			$this->_view->titlesection = $title;
		}
	}

	/**
     * Inserta la informacion de un documentos sarlaft  y redirecciona al listado de documentos sarlaft.
     *
     * @return void.
     */
	public function insertAction(){
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf ) {	
			$data = $this->getData();
			$uploadDocument =  new Core_Model_Upload_Document();
			if($_FILES['cedula']['name'] != ''){
				$data['cedula'] = $uploadDocument->upload("cedula");
			}
			if($_FILES['certificado_ingresos']['name'] != ''){
				$data['certificado_ingresos'] = $uploadDocument->upload("certificado_ingresos");
			}
			if($_FILES['declaracion_renta']['name'] != ''){
				$data['declaracion_renta'] = $uploadDocument->upload("declaracion_renta");
			}
			if($_FILES['desprendible']['name'] != ''){
				$data['desprendible'] = $uploadDocument->upload("desprendible");
			}
			$id = $this->mainModel->insert($data);
			
			$data['id']= $id;
			$data['log_log'] = print_r($data,true);
			$data['log_tipo'] = 'CREAR DOCUMENTOS SARLAFT';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);
		}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe un identificador  y Actualiza la informacion de un documentos sarlaft  y redirecciona al listado de documentos sarlaft.
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
					$uploadDocument =  new Core_Model_Upload_Document();
				if($_FILES['cedula']['name'] != ''){
					if($content->cedula){
						$uploadDocument->delete($content->cedula);
					}
					$data['cedula'] = $uploadDocument->upload("cedula");
				} else {
					$data['cedula'] = $content->cedula;
				}
			
				if($_FILES['certificado_ingresos']['name'] != ''){
					if($content->certificado_ingresos){
						$uploadDocument->delete($content->certificado_ingresos);
					}
					$data['certificado_ingresos'] = $uploadDocument->upload("certificado_ingresos");
				} else {
					$data['certificado_ingresos'] = $content->certificado_ingresos;
				}
			
				if($_FILES['declaracion_renta']['name'] != ''){
					if($content->declaracion_renta){
						$uploadDocument->delete($content->declaracion_renta);
					}
					$data['declaracion_renta'] = $uploadDocument->upload("declaracion_renta");
				} else {
					$data['declaracion_renta'] = $content->declaracion_renta;
				}
			
				if($_FILES['desprendible']['name'] != ''){
					if($content->desprendible){
						$uploadDocument->delete($content->desprendible);
					}
					$data['desprendible'] = $uploadDocument->upload("desprendible");
				} else {
					$data['desprendible'] = $content->desprendible;
				}
				$this->mainModel->update($data,$id);
			}
			$data['id']=$id;
			$data['log_log'] = print_r($data,true);
			$data['log_tipo'] = 'EDITAR DOCUMENTOS SARLAFT';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe un identificador  y elimina un documentos sarlaft  y redirecciona al listado de documentos sarlaft.
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
					$uploadDocument =  new Core_Model_Upload_Document();
					if (isset($content->cedula) && $content->cedula != '') {
						$uploadDocument->delete($content->cedula);
					}
					
					if (isset($content->certificado_ingresos) && $content->certificado_ingresos != '') {
						$uploadDocument->delete($content->certificado_ingresos);
					}
					
					if (isset($content->declaracion_renta) && $content->declaracion_renta != '') {
						$uploadDocument->delete($content->declaracion_renta);
					}
					
					if (isset($content->desprendible) && $content->desprendible != '') {
						$uploadDocument->delete($content->desprendible);
					}
					$this->mainModel->deleteRegister($id);$data = (array)$content;
					$data['log_log'] = print_r($data,true);
					$data['log_tipo'] = 'BORRAR DOCUMENTOS SARLAFT';
					$logModel = new Administracion_Model_DbTable_Log();
					$logModel->insert($data); }
			}
		}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe la informacion del formulario y la retorna en forma de array para la edicion y creacion de Documentossarlaft.
     *
     * @return array con toda la informacion recibida del formulario.
     */
	private function getData()
	{
		$data = array();
		$data['asociado'] = $this->_getSanitizedParam("asociado");
		$data['cedula'] = "";
		$data['certificado_ingresos'] = "";
		$data['declaracion_renta'] = "";
		$data['desprendible'] = "";
		$data['anio'] = $this->_getSanitizedParam("anio");
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
            if ($filters->asociado != '') {
                $filtros = $filtros." AND asociado LIKE '%".$filters->asociado."%'";
            }
            if ($filters->cedula != '') {
                $filtros = $filtros." AND cedula LIKE '%".$filters->cedula."%'";
            }
            if ($filters->certificado_ingresos != '') {
                $filtros = $filtros." AND certificado_ingresos LIKE '%".$filters->certificado_ingresos."%'";
            }
            if ($filters->declaracion_renta != '') {
                $filtros = $filtros." AND declaracion_renta LIKE '%".$filters->declaracion_renta."%'";
            }
            if ($filters->desprendible != '') {
                $filtros = $filtros." AND desprendible LIKE '%".$filters->desprendible."%'";
            }
            if ($filters->anio != '') {
                $filtros = $filtros." AND anio LIKE '%".$filters->anio."%'";
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
					$parramsfilter['asociado'] =  $this->_getSanitizedParam("asociado");
					$parramsfilter['cedula'] =  $this->_getSanitizedParam("cedula");
					$parramsfilter['certificado_ingresos'] =  $this->_getSanitizedParam("certificado_ingresos");
					$parramsfilter['declaracion_renta'] =  $this->_getSanitizedParam("declaracion_renta");
					$parramsfilter['desprendible'] =  $this->_getSanitizedParam("desprendible");
					$parramsfilter['anio'] =  $this->_getSanitizedParam("anio");Session::getInstance()->set($this->namefilter, $parramsfilter);
        }
        if ($this->_getSanitizedParam("cleanfilter") == 1) {
            Session::getInstance()->set($this->namefilter, '');
            Session::getInstance()->set($this->namepageactual,1);
        }
    }
}