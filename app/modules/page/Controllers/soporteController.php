<?php
/**
* Controlador de Usuario que permite la  creacion, edicion  y eliminacion de los Usuarios del Sistema
*/
class Page_soporteController extends Page_mainController
{
	public $botonpanel = 5;
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
	protected $_csrf_section = "page_soporte";

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
		$this->mainModel = new Page_Model_DbTable_Proyectos();
		$this->namefilter = "parametersfiltersoporte";
		$this->route = "/page/soporte";
		$this->namepages ="pages_soporte";
		$this->namepageactual ="page_actual_soporte";
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
		
		$title = "Soporte Proyectos";
		$this->getLayout()->setTitle($title);
		$this->_view->titlesection = $title;
		$this->filters();
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$filters =(object)Session::getInstance()->get($this->namefilter);
        $this->_view->filters = $filters;
		$filters = $this->getFilter();
		$order = " fecha_final DESC";
		$list = $this->mainModel->getListIng($filters,$order);
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
		$this->_view->lists = $this->mainModel->getListPagesIng($filters,$order,$start,$amount);
		$this->_view->csrf_section = $this->_csrf_section;
        $this->_view->list_cliente_id = $this->getClienteid();
		$this->_view->list_cliente_all = $this->getClienteAll();
		$this->_view->list_estado = $this->getEstado();
		$this->_view->list_estado_soporte = $this->getEstadoSoporte();
		$this->_view->list_tipo = $this->getTipo();	
		$this->_view->lista_ingenieros = $this->getIng();
		$this->_view->lista_ingenieros_asoc = $this->getIngAsoc();
	}

	private function getIngAsoc()
	{
		$ingenierosModel = new Administracion_Model_DbTable_Proyectosing();
		$userModel = new Administracion_Model_DbTable_Usuario();
		$ingenieros = $ingenierosModel->getList("", "");

		// Array para almacenar los proyectos y los ingenieros a cargo
		$proyectosIngenieros = array();

		foreach ($ingenieros as $value) {
			// Obtener el usuario (ingeniero) asociado al proyecto
			$user = $userModel->getById($value->proyectosing_user);
			
			// Comprobar si se obtuvo un ingeniero válido
			if ($user) {
				// Si el proyecto no está en el array, inicializa un nuevo array para él
				if (!isset($proyectosIngenieros[$value->proyectosing_proyecto])) {
					$proyectosIngenieros[$value->proyectosing_proyecto] = array();
				}

				// Agrega el ingeniero al proyecto correspondiente
				$proyectosIngenieros[$value->proyectosing_proyecto][$value->proyectosing_id]["nombre"] = $user->user_names;
				$proyectosIngenieros[$value->proyectosing_proyecto][$value->proyectosing_id]["ing"] = $user->user_id;
				$proyectosIngenieros[$value->proyectosing_proyecto][$value->proyectosing_id]["id"] = $value->proyectosing_id;
			}
		}

		return $proyectosIngenieros; // Retorna el array con proyectos y sus ingenieros
	}

	public function deteleIngAction(){
		$this->setLayout('blanco');

		$id = $this->_getSanitizedParam("id");
	
		$ingenierosModel = new Administracion_Model_DbTable_Proyectosing();
		$ingenierosModel->deleteRegister($id);
	
		header('Content-Type: application/json');
		echo json_encode(['success' => true, 'message' => 'Ing eliminado'. $id]);
	}

    private function getClienteid()
	{
		if ($_SESSION["kt_login_level"] == 5) {

			$user = $_SESSION["kt_login_id"];
			
			$ingenierosModel = new Administracion_Model_DbTable_Proyectosing();
        	$proyectos = $ingenierosModel->getList(" proyectosing_user = '".$user."' ","");

			$clienteModel = new Page_Model_DbTable_Clientes();
			$proyectosModel =  new Page_Model_DbTable_Proyectos();

			$array = array();
			foreach($proyectos as $value){
				$info = $proyectosModel->getList(" id = '$value->proyectosing_proyecto' AND ( estado = '7' OR estado = '8' OR estado = '9' ) ","")[0];
				$res = $clienteModel->getById($info->cliente_id);
				if ($res) {
					$array[$res->id] = $res->nombre;
				}
			}

		} else {
			$proyectosModel =  new Page_Model_DbTable_Proyectos();
			$proyectos = $proyectosModel->getList(" ( estado = '7' OR estado = '8' OR estado = '9' ) "," fecha_c DESC");
			
			$clienteModel = new Page_Model_DbTable_Clientes();
			$array = array();
			foreach($proyectos as $value){
				$res = $clienteModel->getById($value->cliente_id);
				$array[$res->id] = $res->nombre;
			}
		}	

		asort($array, SORT_NATURAL | SORT_FLAG_CASE);
		
		return $array;
	}

	private function getClienteAll()
    {		
        $clienteModel = new Page_Model_DbTable_Clientes();
		$listCliente = $clienteModel->getList(" categoria = '2' ", " nombre ASC");

        $array = array();
        foreach($listCliente as $res){
			$array[$res->id] = $res->nombre;
        }

        return $array;
    }

	private function getIng()
	{
		$userModel = new Administracion_Model_DbTable_Usuario();
		
		if ($_SESSION["kt_login_level"] == 5) {
			$f = " AND user_id = ". $_SESSION["kt_login_id"];
		}

		$listado = $userModel->getList(" user_level = '5' AND user_state = '1' $f "," user_names ASC ");
		$array = array();
		foreach($listado as $value){
			$array[$value->user_id] = $value->user_names . " ( ". $value->user_user . " ) ";
		}
		
		return $array;
	}

	public function insertAction(){
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		$r = $this->_getSanitizedParam("r");
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf ) {	

			$data = $this->getData();
			$proyectosing_user = $this->_getSanitizedParam("proyectosing_user");

			$uploadDocument =  new Core_Model_Upload_Document();
			$ingenierosModel = new Administracion_Model_DbTable_Proyectosing();

			if($_FILES['documento1']['name'] != ''){
				$data['documento1'] = $uploadDocument->upload("documento1");
			}
			if($_FILES['documento2']['name'] != ''){
				$data['documento2'] = $uploadDocument->upload("documento2");
			}
			if($_FILES['documento3']['name'] != ''){
				$data['documento3'] = $uploadDocument->upload("documento3");
			}

			$id = $this->mainModel->insert($data);

			$hoy = date("Y-m-d H:i");
			$this->mainModel->editField($id,"fecha_final",$hoy);

			$datos = array();
			$datos["proyectosing_user"] = $proyectosing_user;
			$datos["proyectosing_observacion"] = "";
			$datos["proyectosing_proyecto"] = $id;

			$ingenierosModel->insert($datos);
			
			$data['id']= $id;
			$data['log_log'] = print_r($data,true);
			$data['log_tipo'] = 'CREAR PROYECTO';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);
		}
		
		if ($r == "tablero") {
			$ing = $this->_getSanitizedParam("ing");
			header('Location: /page/tablero/?ing='.$ing);
		} else {
			header('Location: /page/soporte/');	
		}
	
	}

	private function getData()
	{
		$data = array();
		$data['fecha_c'] = date("Y-m-d H:i:s");
		$data['nombre'] = $this->_getSanitizedParam("nombre");
		$data['tipo'] = $this->_getSanitizedParam("tipo");
		$data['valor'] = $this->_getSanitizedParam("valor");
		$data['cliente_id'] = $this->_getSanitizedParam("cliente_id");
		$data['estado'] = $this->_getSanitizedParam("estado");
		$data['fecha_aprobado'] = date("Y-m-d H:i:s");
		$data['proyectos_cadmin'] = "";
		$data['proyectos_caprueba'] = "";
		$data['valor']=str_replace(".","",$data['valor']);
		$data['valor']=str_replace(",","",$data['valor']);

		return $data;
	}

	private function getTipo()
	{
		$array = array();
		$array['1'] = 'Desarrollo';
		$array['2'] = 'Soporte';
		$array['3'] = 'Diseño';
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

    	if($this->_getSanitizedParam("cliente")!=""){
    		$cliente_id = $this->_getSanitizedParam("cliente");
    		$filtros .= " AND a.cliente_id='$cliente_id' ";
    	}

		if($this->_getSanitizedParam("estado") == ""){
    		$estado = $this->_getSanitizedParam("estado");
    		$filtros .= " AND ( a.estado= '7' OR a.estado = '9' ) ";
    	}

		if ($_SESSION["kt_login_level"] == 5) {
    		$filtros .= " AND proyectosing_user = '".$_SESSION["kt_login_id"]."' ";
    	}

        if (Session::getInstance()->get($this->namefilter)!="") {
            $filters =(object)Session::getInstance()->get($this->namefilter);
            if ($filters->nombre != '') {
                $filtros = $filtros." AND a.nombre LIKE '%".$filters->nombre."%'";
            }
            if ($filters->cliente_id != '') {
                $filtros = $filtros." AND a.cliente_id ='".$filters->cliente_id."'";
            }
			if ($filters->estado != '') {
				if ($filters->estado == '9') {
                	$filtros = $filtros." AND ( a.estado = '7' OR a.estado ='".$filters->estado."' ) ";
				} else {
					$filtros = $filtros." AND a.estado ='".$filters->estado."'";
				}
            } 
			if ($filters->colaborador != '') {
                $filtros = $filtros." AND b.proyectosing_user ='".$filters->colaborador."'";
            }
		}

		$filtros .= " GROUP BY a.id ";

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
            $parramsfilter['cliente_id'] =  $this->_getSanitizedParam("cliente_id");
			$parramsfilter['estado'] =  $this->_getSanitizedParam("estado");
			$parramsfilter['colaborador'] =  $this->_getSanitizedParam("colaborador");
            Session::getInstance()->set($this->namefilter, $parramsfilter);
        }
		
        if ($this->_getSanitizedParam("cleanfilter") == 1) {
            Session::getInstance()->set($this->namefilter, '');
            Session::getInstance()->set($this->namepageactual,1);
        }
    }

	
    private function getEstado()
    {
        $array = array();
        $array['9'] = 'Finalizado con Soporte';
		$array['8'] = 'Relación finalizada';
		$array['7'] = 'Finalizado con Soporte';
        return $array;
    }

	private function getEstadoSoporte()
    {
        $array = array();
		$array['9'] = 'Finalizado con Soporte';
		$array['8'] = 'Relación finalizada';
        return $array;
    }

}