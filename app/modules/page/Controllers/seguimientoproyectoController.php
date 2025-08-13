<?php
/**
* Controlador de Seguimientoproyecto que permite la  creacion, edicion  y eliminacion de los seguimiento proyecto del Sistema
*/
class Page_seguimientoproyectoController extends Page_mainController
{
    public $botonpanel = 9;
	/**
	 * $mainModel  instancia del modelo de  base de datos seguimiento proyecto
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
	protected $_csrf_section = "page_seguimientoproyecto";

	/**
	 * $namepages nombre de la pvariable en la cual se va a guardar  el numero de seccion en la paginacion del controlador
	 * @var string
	 */
	protected $namepages;



	/**
     * Inicializa las variables principales del controlador seguimientoproyecto .
     *
     * @return void.
     */
	public function init()
	{
		$this->mainModel = new Page_Model_DbTable_Seguimientoproyecto();
		$this->namefilter = "parametersfilterseguimientoproyecto";
		$this->route = "/page/seguimientoproyecto";
		$this->namepages ="pages_seguimientoproyecto";
		$this->namepageactual ="page_actual_seguimientoproyecto";
		$this->_view->route = $this->route;
		if(Session::getInstance()->get($this->namepages)){
			$this->pages = Session::getInstance()->get($this->namepages);
		} else {
			$this->pages = 20;
		}
		parent::init();
	}


	/**
     * Recibe la informacion y  muestra un listado de  seguimiento proyecto con sus respectivos filtros.
     *
     * @return void.
     */
	public function indexAction()
	{
		$title = "Administración de seguimiento proyecto";
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
		$this->_view->list_quien = $this->getQuien();
		$this->_view->proyecto = $this->_getSanitizedParam("proyecto");
	}

	/**
     * Genera la Informacion necesaria para editar o crear un  seguimiento  y muestra su formulario
     *
     * @return void.
     */
	public function manageAction()
	{
		$this->_view->route = $this->route;
		$this->_csrf_section = "manage_seguimientoproyecto_".date("YmdHis");
		$this->_csrf->generateCode($this->_csrf_section);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$this->_view->list_quien = $this->getQuien();
		$this->_view->proyecto = $this->_getSanitizedParam("proyecto");
		$id = $this->_getSanitizedParam("id");
		
		if ($id > 0) {
			$content = $this->mainModel->getById($id);
			if($content->id){
				$this->_view->content = $content;
				$this->_view->routeform = $this->route."/update";
				$title = "Actualizar seguimiento";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}else{
				$this->_view->routeform = $this->route."/insert";
				$title = "Crear seguimiento";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}
		} else {
			$this->_view->routeform = $this->route."/insert";
			$title = "Crear seguimiento";
			$this->getLayout()->setTitle($title);
			$this->_view->titlesection = $title;

			$content = new stdClass();
			$content->fecha = date("Y-m-d H:i:s");
			$this->_view->content = $content;

			$reprogramar = $this->_getSanitizedParam("reprogramar");
			if($reprogramar!=""){
				$aux = $this->mainModel->getById($reprogramar);
				$content->fecha = $aux->programar;
				$content->seguimiento = $aux->seguimiento;
				$this->_view->content = $content;
			}

		}
	}

	public function manage2Action()
	{

		$this->_view->route = $this->route;
		$this->_csrf_section = "manage2_seguimientoproyecto_".date("YmdHis");
		$this->_csrf->generateCode($this->_csrf_section);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		
		$this->_view->routeform = $this->route."/insert";
		$title = "Crear seguimiento";
		$this->getLayout()->setTitle($title);
		$this->_view->titlesection = $title;
		$this->_view->clientes = $this->getClienteid();
		$this->_view->proyectos = $this->getProyectos();

		$content = new stdClass();
		$content->fecha = date("Y-m-d H:i:s");
		$this->_view->content = $content;

	}

	private function getClienteid()
	{
		$clienteModel = new Page_Model_DbTable_Clientes();
		$listado = $clienteModel->getList(""," nombre ASC ");
		$array = array();
		foreach($listado as $value){
			$array[$value->id] = $value->nombre;
		}
		
		return $array;
	}

	private function getProyectos()
	{
		$proyectosModel =  new Page_Model_DbTable_Proyectos();
      	$proyectos = $proyectosModel->getList(" estado='6' "," fecha_c DESC LIMIT 100 ");

		$array = array();
		foreach($proyectos as $value){
			$array[$value->id] = $value->nombre;
		}
		
		return $array;
	}

	public function buscarProyectosAction()
	{
		header('Content-Type:application/json');
		$this->setLayout('blanco');
		$respuesta = array();
		$cliente = $this->_getSanitizedParam('cliente');
		$proyectosModel =  new Page_Model_DbTable_Proyectos();
      	$proyectos = $proyectosModel->getList(" estado='6' AND cliente_id = '".$cliente."' "," fecha_c DESC");

		foreach ($proyectos as $key => $value) {
			$respuesta[$key]["valor"] = $value->id;
			$respuesta[$key]["texto"] = html_entity_decode($value->nombre);
		}

		echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
	}

	

	/**
     * Inserta la informacion de un seguimiento  y redirecciona al listado de seguimiento proyecto.
     *
     * @return void.
     */
	public function insertAction(){
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		$hash = $this->_getSanitizedParam("hash");
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf ) {	
			$data = $this->getData();
			$id = $this->mainModel->insert($data);
			
			$data['id']= $id;
			$data['log_log'] = print_r($data,true);
			$data['log_tipo'] = 'CREAR SEGUIMIENTO';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);
		}
		$proyecto = $this->_getSanitizedParam("proyecto_id");
		$detalle = $this->_getSanitizedParam("detalle");
		$reprogramar = $this->_getSanitizedParam("reprogramar");
		if($reprogramar!=""){
			$this->mainModel->editField($reprogramar,"finalizado",1);
		}

		if ($hash == 1) {
			header('Location: /page/sistema/');
		} else {
			header('Location: '.$this->route.'?proyecto='.$proyecto.'&detalle='.$detalle);
		}
	}

	/**
     * Recibe un identificador  y Actualiza la informacion de un seguimiento  y redirecciona al listado de seguimiento proyecto.
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
			$data['log_tipo'] = 'EDITAR SEGUIMIENTO';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);}

		$proyecto = $this->_getSanitizedParam("proyecto_id");
		$detalle = $this->_getSanitizedParam("detalle");
		header('Location: '.$this->route.'?proyecto='.$proyecto.'&detalle='.$detalle);
	}

	/**
     * Recibe un identificador  y elimina un seguimiento  y redirecciona al listado de seguimiento proyecto.
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
					$data['log_tipo'] = 'BORRAR SEGUIMIENTO';
					$logModel = new Administracion_Model_DbTable_Log();
					$logModel->insert($data); }
			}
		}
		$proyecto = $this->_getSanitizedParam("proyecto");
		$detalle = $this->_getSanitizedParam("detalle");
		header('Location: '.$this->route.'?proyecto='.$proyecto.'&detalle='.$detalle);
	}

	/**
     * Recibe la informacion del formulario y la retorna en forma de array para la edicion y creacion de Seguimientoproyecto.
     *
     * @return array con toda la informacion recibida del formulario.
     */
	private function getData()
	{
		$data = array();
		$data['fecha'] = $this->_getSanitizedParam("fecha");
		$data['seguimiento'] = $this->_getSanitizedParamHtml("seguimiento");
		$data['programar'] = $this->_getSanitizedParam("programar");
		$data['quien'] = $_SESSION['kt_login_id'];
		$data['proyecto_id'] = $this->_getSanitizedParamHtml("proyecto_id");

		$proyectoModel = new Page_Model_DbTable_Proyectos();
		$proyecto = $proyectoModel->getById($data['proyecto_id']);
		$data['client_id'] = $proyecto->cliente_id;

		if($data['fecha']!=""){
			$data['fecha']=date("Y-m-d H:i",strtotime($data['fecha']));
		}
		if($data['programar']!=""){
			$data['programar']=date("Y-m-d H:i",strtotime($data['programar']));
		}		

		return $data;
	}

	/**
     * Genera los valores del campo quien.
     *
     * @return array cadena con los valores del campo quien.
     */
	private function getQuien()
	{
		$usuarioModel = new Administracion_Model_DbTable_Usuario();
		$list = $usuarioModel->getList(" user_state='1' "," user_names ASC ");

		$array = array();
		foreach($list as $data){
			$array[$data->user_id] = ''.$data->user_names;
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
		$proyecto= $this->_getSanitizedParam("proyecto");
		$filtros = $filtros." AND proyecto_id = '$proyecto' ";
        if (Session::getInstance()->get($this->namefilter)!="") {
            $filters =(object)Session::getInstance()->get($this->namefilter);
            if ($filters->fecha != '') {
                $filtros = $filtros." AND fecha LIKE '%".$filters->fecha."%'";
            }
            if ($filters->seguimiento != '') {
                $filtros = $filtros." AND seguimiento LIKE '%".$filters->seguimiento."%'";
            }
            if ($filters->programar != '') {
                $filtros = $filtros." AND programar LIKE '%".$filters->programar."%'";
            }
            if ($filters->quien != '') {
                $filtros = $filtros." AND quien ='".$filters->quien."'";
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
					$parramsfilter['fecha'] =  $this->_getSanitizedParam("fecha");
					$parramsfilter['seguimiento'] =  $this->_getSanitizedParam("seguimiento");
					$parramsfilter['programar'] =  $this->_getSanitizedParam("programar");
					$parramsfilter['quien'] =  $this->_getSanitizedParam("quien");Session::getInstance()->set($this->namefilter, $parramsfilter);
        }
        if ($this->_getSanitizedParam("cleanfilter") == 1) {
            Session::getInstance()->set($this->namefilter, '');
            Session::getInstance()->set($this->namepageactual,1);
        }
    }

    public function finalizar_seguimientoAction(){
    	$this->setLayout('blanco');
    	$id = $this->_getSanitizedParam("id");
    	if($id>0){
    		$this->mainModel->editField($id,"finalizado",1);
    	}

    	echo "id:".$id." finalizado";
    }
    
    public function envioavisoAction() {

		$this->setLayout('blanco');
		
		$proyectosModel =  new Page_Model_DbTable_Proyectos();
		$clienteModel = new Page_Model_DbTable_Clientes();

		$hoy = date("Y-m-d");
		$lista_seg = $this->mainModel->getList(" programar LIKE '%".$hoy."%' AND finalizado IS NULL ","");

		if ($lista_seg) {
    		foreach ($lista_seg as $item) {
    			
    			$proyectos = $proyectosModel->getById($item->proyecto_id);
    			$cliente = $clienteModel->getById($item->client_id);
    
    			$content = new stdClass();
    			$content->id = $item->id;
    			$content->fecha = $item->fecha;
    			$content->seguimiento = utf8_decode($item->seguimiento);
    			$content->programado = ($item->programar ?: '-');
    			$content->proyecto = $proyectos->nombre;
    			$content->cliente = $cliente->nombre . " - " . $cliente->contacto_principal;
    			$content->finalizado = ($item->finalizado ?: 'No');
    
    			$sendingemail = new Core_Model_Sendingemail($this->_view);
    			$sendingemail->notificaSeguimiento($content);
    
    		}
		} else {
		    echo "Sin registros";
		    exit;
		}

	}


}