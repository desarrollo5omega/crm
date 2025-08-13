<?php
/**
* Controlador de Documentosadicionales que permite la  creacion, edicion  y eliminacion de los documentos adicionales del Sistema
*/
class Administracion_documentosadicionalesController extends Administracion_mainController
{
	/**
	 * $mainModel  instancia del modelo de  base de datos documentos adicionales
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
	protected $_csrf_section = "administracion_documentosadicionales";

	/**
	 * $namepages nombre de la pvariable en la cual se va a guardar  el numero de seccion en la paginacion del controlador
	 * @var string
	 */
	protected $namepages;



	/**
     * Inicializa las variables principales del controlador documentosadicionales .
     *
     * @return void.
     */
	public function init()
	{
		$this->mainModel = new Administracion_Model_DbTable_Documentosadicionales();
		$this->namefilter = "parametersfilterdocumentosadicionales";
		$this->route = "/administracion/documentosadicionales";
		$this->namepages ="pages_documentosadicionales";
		$this->namepageactual ="page_actual_documentosadicionales";
		$this->_view->route = $this->route;
		if(Session::getInstance()->get($this->namepages)){
			$this->pages = Session::getInstance()->get($this->namepages);
		} else {
			$this->pages = 20;
		}
		parent::init();
	}


	/**
     * Recibe la informacion y  muestra un listado de  documentos adicionales con sus respectivos filtros.
     *
     * @return void.
     */
	public function indexAction()
	{
		$title = "Administración de documentos adicionales";
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
		$this->_view->solicitud = $this->_getSanitizedParam("solicitud");

		$this->_view->list_usuarios = $this->getUsuarios();
	}

	private function getUsuarios()
	{
		$array = array();
		$lineaModel = new Administracion_Model_DbTable_Usuario();
		$list = $lineaModel->getList(""," user_names ASC ");
		foreach ($list as $key => $value) {
			$array[$value->user_id] = $value->user_names;
		}
		return $array;
	}

	/**
     * Genera la Informacion necesaria para editar o crear un  documentos adicionales  y muestra su formulario
     *
     * @return void.
     */
	public function manageAction()
	{
		$this->_view->route = $this->route;
		$this->_csrf_section = "manage_documentosadicionales_".date("YmdHis");
		$this->_csrf->generateCode($this->_csrf_section);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$this->_view->solicitud = $this->_getSanitizedParam("solicitud");
		$id = $this->_getSanitizedParam("id");
		if ($id > 0) {
			$content = $this->mainModel->getById($id);
			if($content->id){
				$this->_view->content = $content;
				$this->_view->routeform = $this->route."/update";
				$title = "Actualizar documentos adicionales";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}else{
				$this->_view->routeform = $this->route."/insert";
				$title = "Crear documentos adicionales";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}
		} else {
			$this->_view->routeform = $this->route."/insert";
			$title = "Crear documentos adicionales";
			$this->getLayout()->setTitle($title);
			$this->_view->titlesection = $title;
		}
	}

	/**
     * Inserta la informacion de un documentos adicionales  y redirecciona al listado de documentos adicionales.
     *
     * @return void.
     */
	public function insertAction(){
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf ) {	
			$data = $this->getData();
			$uploadDocument =  new Core_Model_Upload_Document();
			if($_FILES['archivo']['name'] != ''){
				$data['archivo'] = $uploadDocument->upload("archivo");
			}
			$id = $this->mainModel->insert($data);
			
			$data['id']= $id;
			$data['log_log'] = print_r($data,true);
			$data['log_tipo'] = 'CREAR DOCUMENTOS ADICIONALES';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);
		}
		$solicitud = $this->_getSanitizedParam("solicitud");
		header('Location: '.$this->route.'?solicitud='.$solicitud.'');
	}

	/**
     * Recibe un identificador  y Actualiza la informacion de un documentos adicionales  y redirecciona al listado de documentos adicionales.
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
				if($_FILES['archivo']['name'] != ''){
					if($content->archivo){
						$uploadDocument->delete($content->archivo);
					}
					$data['archivo'] = $uploadDocument->upload("archivo");
				} else {
					$data['archivo'] = $content->archivo;
				}
				$this->mainModel->update($data,$id);
			}
			$data['id']=$id;
			$data['log_log'] = print_r($data,true);
			$data['log_tipo'] = 'EDITAR DOCUMENTOS ADICIONALES';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);}
		$solicitud = $this->_getSanitizedParam("solicitud");
		header('Location: '.$this->route.'?solicitud='.$solicitud.'');
	}

	/**
     * Recibe un identificador  y elimina un documentos adicionales  y redirecciona al listado de documentos adicionales.
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
					if (isset($content->archivo) && $content->archivo != '') {
						$uploadDocument->delete($content->archivo);
					}
					$this->mainModel->deleteRegister($id);$data = (array)$content;
					$data['log_log'] = print_r($data,true);
					$data['log_tipo'] = 'BORRAR DOCUMENTOS ADICIONALES';
					$logModel = new Administracion_Model_DbTable_Log();
					$logModel->insert($data); }
			}
		}
		$solicitud = $this->_getSanitizedParam("solicitud");
		header('Location: '.$this->route.'?solicitud='.$solicitud.'');
	}

	/**
     * Recibe la informacion del formulario y la retorna en forma de array para la edicion y creacion de Documentosadicionales.
     *
     * @return array con toda la informacion recibida del formulario.
     */
	private function getData()
	{
		$data = array();
		$data['titulo'] = $this->_getSanitizedParam("titulo");
		$data['archivo'] = "";
		$data['fecha'] = $this->_getSanitizedParamHtml("fecha");
		$data['quien'] = $this->_getSanitizedParamHtml("quien");
		$data['solicitud'] = $this->_getSanitizedParamHtml("solicitud");
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
		$solicitud= $this->_getSanitizedParam("solicitud");
		$filtros = $filtros." AND solicitud = '$solicitud' ";
        if (Session::getInstance()->get($this->namefilter)!="") {
            $filters =(object)Session::getInstance()->get($this->namefilter);
            if ($filters->titulo != '') {
                $filtros = $filtros." AND titulo LIKE '%".$filters->titulo."%'";
            }
            if ($filters->archivo != '') {
                $filtros = $filtros." AND archivo LIKE '%".$filters->archivo."%'";
            }
            if ($filters->fecha != '') {
                $filtros = $filtros." AND fecha LIKE '%".$filters->fecha."%'";
            }
            if ($filters->quien != '') {
                $filtros = $filtros." AND quien LIKE '%".$filters->quien."%'";
            }
            if ($filters->solicitud != '') {
                $filtros = $filtros." AND solicitud LIKE '%".$filters->solicitud."%'";
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
					$parramsfilter['titulo'] =  $this->_getSanitizedParam("titulo");
					$parramsfilter['archivo'] =  $this->_getSanitizedParam("archivo");
					$parramsfilter['fecha'] =  $this->_getSanitizedParam("fecha");
					$parramsfilter['quien'] =  $this->_getSanitizedParam("quien");
					$parramsfilter['solicitud'] =  $this->_getSanitizedParam("solicitud");Session::getInstance()->set($this->namefilter, $parramsfilter);
        }
        if ($this->_getSanitizedParam("cleanfilter") == 1) {
            Session::getInstance()->set($this->namefilter, '');
            Session::getInstance()->set($this->namepageactual,1);
        }
    }
}