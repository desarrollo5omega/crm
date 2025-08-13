<?php
/**
* Controlador de Clientes que permite la  creacion, edicion  y eliminacion de los clientes del Sistema
*/
class Page_clientesController extends Page_mainController
{
    public $botonpanel = 10;
	/**
	 * $mainModel  instancia del modelo de  base de datos clientes
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
	protected $_csrf_section = "page_clientes";

	/**
	 * $namepages nombre de la pvariable en la cual se va a guardar  el numero de seccion en la paginacion del controlador
	 * @var string
	 */
	protected $namepages;



	/**
     * Inicializa las variables principales del controlador clientes .
     *
     * @return void.
     */
	public function init()
	{
		$this->mainModel = new Page_Model_DbTable_Clientes();
		$this->namefilter = "parametersfilterclientes";
		$this->route = "/page/clientes";
		$this->namepages ="pages_clientes";
		$this->namepageactual ="page_actual_clientes";
		$this->_view->route = $this->route;
		if(Session::getInstance()->get($this->namepages)){
			$this->pages = Session::getInstance()->get($this->namepages);
		} else {
			$this->pages = 20;
		}
		parent::init();
	}


	/**
     * Recibe la informacion y  muestra un listado de  clientes con sus respectivos filtros.
     *
     * @return void.
     */
	public function indexAction()
	{


		$title = "Administración de clientes";
		$this->getLayout()->setTitle($title);
		$this->_view->titlesection = $title;
		$this->filters();
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$filters =(object)Session::getInstance()->get($this->namefilter);
        $this->_view->filters = $filters;
		$filters = $this->getFilter();
		$order = " fecha_c DESC";
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
		$this->_view->list_tipo_documento = $this->getTipodocumento();
		$this->_view->list_categoria = $this->getCategoria();
		$this->_view->list_estado = $this->getEstado();
		$this->_view->list_asignado = $this->getAsignado();
	}

	/**
     * Genera la Informacion necesaria para editar o crear un  cliente  y muestra su formulario
     *
     * @return void.
     */
	public function manageAction()
	{
		$this->_view->route = $this->route;
		$this->_csrf_section = "manage_clientes_".date("YmdHis");
		$this->_csrf->generateCode($this->_csrf_section);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$this->_view->list_tipo_documento = $this->getTipodocumento();
		$this->_view->list_categoria = $this->getCategoria();
		$this->_view->list_estado = $this->getEstado();
		$this->_view->list_asignado = $this->getAsignado();
		$id = $this->_getSanitizedParam("id");
		if ($id > 0) {
			$content = $this->mainModel->getById($id);
			if($content->id){
				$this->_view->content = $content;
				$this->_view->routeform = $this->route."/update";
				$title = "Actualizar cliente";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}else{
				$this->_view->routeform = $this->route."/insert";
				$title = "Crear cliente";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}
		} else {
			$this->_view->routeform = $this->route."/insert";
			$title = "Crear cliente";
			$this->getLayout()->setTitle($title);
			$this->_view->titlesection = $title;
		}
	}

	/**
     * Inserta la informacion de un cliente  y redirecciona al listado de clientes.
     *
     * @return void.
     */
	public function insertAction(){

		$this->setLayout('blanco');
		
		$csrf = $this->_getSanitizedParam("csrf"); 
		$detalle = $this->_getSanitizedParam("detalle");

		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf ) {	
			$data = $this->getData();
		
			$uploadDocument =  new Core_Model_Upload_Document();
			if($_FILES['logo']['name'] != ''){
				$data['logo'] = $uploadDocument->upload("logo");
			}

			$id = $this->mainModel->insert($data);
			
			$data['id']= $id;
			$data['log_log'] = print_r($data,true);
			$data['log_tipo'] = 'CREAR CLIENTE';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);
		}

		if ($detalle == "1") {
			header('Location: /page/sistema/');
		} else {
			header('Location: '.$this->route.''.'');
		}
		
	}

	/**
     * Recibe un identificador  y Actualiza la informacion de un cliente  y redirecciona al listado de clientes.
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
				if($_FILES['logo']['name'] != ''){
					$data['logo'] = $uploadDocument->upload("logo");
				}
				
				$this->mainModel->update($data,$id);
			}
			$data['id']=$id;
			$data['log_log'] = print_r($data,true);
			$data['log_tipo'] = 'EDITAR CLIENTE';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe un identificador  y elimina un cliente  y redirecciona al listado de clientes.
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
					$data['log_tipo'] = 'BORRAR CLIENTE';
					$logModel = new Administracion_Model_DbTable_Log();
					$logModel->insert($data); }
			}
		}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe la informacion del formulario y la retorna en forma de array para la edicion y creacion de Clientes.
     *
     * @return array con toda la informacion recibida del formulario.
     */
	private function getData()
	{
		$data = array();
		$data['nombre'] = $this->_getSanitizedParam("nombre");
		$data['contacto_principal'] = $this->_getSanitizedParam("contacto_principal");
		$data['documento'] = $this->_getSanitizedParam("documento");
		$data['tipo_documento'] = $this->_getSanitizedParam("tipo_documento");
		$data['direccion'] = $this->_getSanitizedParam("direccion");
		$data['email'] = $this->_getSanitizedParam("email");
		$data['telefono'] = $this->_getSanitizedParam("telefono");
		$data['celular'] = $this->_getSanitizedParam("celular");
		$data['pagina_web'] = $this->_getSanitizedParam("pagina_web");
		if($this->_getSanitizedParam("categoria") == '' ) {
			$data['categoria'] = '0';
		} else {
			$data['categoria'] = $this->_getSanitizedParam("categoria");
		}
		if($this->_getSanitizedParam("estado") == '' ) {
			$data['estado'] = '0';
		} else {
			$data['estado'] = $this->_getSanitizedParam("estado");
		}
		$data['asignado'] = $this->_getSanitizedParam("asignado");
		if($this->_getSanitizedParam("activo") == '' ) {
			$data['activo'] = '0';
		} else {
			$data['activo'] = $this->_getSanitizedParam("activo");
		}
		$data['quien'] = $_SESSION['kt_login_id'];
		$data['fecha_c'] = date("Y-m-d H:i:s");
		$data['fecha_a'] = date("Y-m-d H:i:s");
		return $data;
	}

	/**
     * Genera los valores del campo tipo documento.
     *
     * @return array cadena con los valores del campo tipo documento.
     */
	private function getTipodocumento()
	{
		$array = array();
		$array['CC'] = 'CC';
		$array['CE'] = 'CE';
		$array['Pasaporte'] = 'Pasaporte';
		$array['Nit'] = 'Nit';
		return $array;
	}


	/**
     * Genera los valores del campo categoria.
     *
     * @return array cadena con los valores del campo categoria.
     */
	private function getCategoria()
	{
		$array = array();
		$array['1'] = 'Prospecto';
		$array['2'] = 'Cliente';
		return $array;
	}


	/**
     * Genera los valores del campo estado.
     *
     * @return array cadena con los valores del campo estado.
     */
	private function getEstado()
	{
		$array = array();
		$array['1'] = 'Contacto inicial';
		$array['2'] = 'Presentación';
		$array['3'] = 'Cotización';
		$array['4'] = 'Contratación';
		$array['5'] = 'Desarrollo';
		$array['6'] = 'Proyecto finalizado';
		return $array;
	}


	/**
     * Genera los valores del campo asignado.
     *
     * @return array cadena con los valores del campo asignado.
     */
	private function getAsignado()
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
    	$filtros = " 1 = 1 AND categoria = 2";
        if (Session::getInstance()->get($this->namefilter)!="") {
            $filters =(object)Session::getInstance()->get($this->namefilter);
            if ($filters->nombre != '') {
                $filtros = $filtros." AND nombre LIKE '%".$filters->nombre."%'";
            }
            if ($filters->contacto_principal != '') {
                $filtros = $filtros." AND contacto_principal LIKE '%".$filters->contacto_principal."%'";
            }
            if ($filters->documento != '') {
                $filtros = $filtros." AND documento LIKE '%".$filters->documento."%'";
            }
            if ($filters->tipo_documento != '') {
                $filtros = $filtros." AND tipo_documento ='".$filters->tipo_documento."'";
            }
            if ($filters->direccion != '') {
                $filtros = $filtros." AND direccion LIKE '%".$filters->direccion."%'";
            }
            if ($filters->email != '') {
                $filtros = $filtros." AND email LIKE '%".$filters->email."%'";
            }
            if ($filters->telefono != '') {
                $filtros = $filtros." AND telefono LIKE '%".$filters->telefono."%'";
            }
            if ($filters->celular != '') {
                $filtros = $filtros." AND celular LIKE '%".$filters->celular."%'";
            }
            if ($filters->pagina_web != '') {
                $filtros = $filtros." AND pagina_web LIKE '%".$filters->pagina_web."%'";
            }
            if ($filters->categoria != '') {
                $filtros = $filtros." AND categoria ='".$filters->categoria."'";
            }
            if ($filters->estado != '') {
                $filtros = $filtros." AND estado ='".$filters->estado."'";
            }
            if ($filters->asignado != '') {
                $filtros = $filtros." AND asignado ='".$filters->asignado."'";
            }
            if ($filters->activo != '') {
                $filtros = $filtros." AND activo LIKE '%".$filters->activo."%'";
            }
            if ($filters->quien != '') {
                $filtros = $filtros." AND quien LIKE '%".$filters->quien."%'";
            }
            if ($filters->fecha_c != '') {
                $filtros = $filtros." AND fecha_c LIKE '%".$filters->fecha_c."%'";
            }
            if ($filters->fecha_a != '') {
                $filtros = $filtros." AND fecha_a LIKE '%".$filters->fecha_a."%'";
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
					$parramsfilter['nombre'] =  $this->_getSanitizedParam("nombre");
					$parramsfilter['contacto_principal'] =  $this->_getSanitizedParam("contacto_principal");
					$parramsfilter['documento'] =  $this->_getSanitizedParam("documento");
					$parramsfilter['tipo_documento'] =  $this->_getSanitizedParam("tipo_documento");
					$parramsfilter['direccion'] =  $this->_getSanitizedParam("direccion");
					$parramsfilter['email'] =  $this->_getSanitizedParam("email");
					$parramsfilter['telefono'] =  $this->_getSanitizedParam("telefono");
					$parramsfilter['celular'] =  $this->_getSanitizedParam("celular");
					$parramsfilter['pagina_web'] =  $this->_getSanitizedParam("pagina_web");
					$parramsfilter['categoria'] =  $this->_getSanitizedParam("categoria");
					$parramsfilter['estado'] =  $this->_getSanitizedParam("estado");
					$parramsfilter['asignado'] =  $this->_getSanitizedParam("asignado");
					$parramsfilter['activo'] =  $this->_getSanitizedParam("activo");
					$parramsfilter['quien'] =  $this->_getSanitizedParam("quien");
					$parramsfilter['fecha_c'] =  $this->_getSanitizedParam("fecha_c");
					$parramsfilter['fecha_a'] =  $this->_getSanitizedParam("fecha_a");Session::getInstance()->set($this->namefilter, $parramsfilter);
        }
        if ($this->_getSanitizedParam("cleanfilter") == 1) {
            Session::getInstance()->set($this->namefilter, '');
            Session::getInstance()->set($this->namepageactual,1);
        }
    }
}