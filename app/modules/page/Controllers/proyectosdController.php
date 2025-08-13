<?php
/**
* Controlador de Proyectos que permite la  creacion, edicion  y eliminacion de los proyectos del Sistema
*/
class Page_proyectosdController extends Page_mainController
{
    public $botonpanel = 3;
	/**
	 * $mainModel  instancia del modelo de  base de datos proyectos
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
	protected $_csrf_section = "page_proyectosd";

	/**
	 * $namepages nombre de la pvariable en la cual se va a guardar  el numero de seccion en la paginacion del controlador
	 * @var string
	 */
	protected $namepages;



	/**
     * Inicializa las variables principales del controlador proyectos .
     *
     * @return void.
     */
	public function init()
	{
		$this->mainModel = new Page_Model_DbTable_Proyectos();
		$this->namefilter = "parametersfilterproyectosd";
		$this->route = "/page/proyectosd";
		$this->namepages ="pages_proyectosd";
		$this->namepageactual ="page_actual_proyectosd";
		$this->_view->route = $this->route;
		if(Session::getInstance()->get($this->namepages)){
			$this->pages = Session::getInstance()->get($this->namepages);
		} else {
			$this->pages = 20;
		}
		parent::init();

	      if ($_SESSION['kt_login_id'] == "") {
	        header("Location:/page/login/logout");
	      }

	}


	/**
     * Recibe la informacion y  muestra un listado de  proyectos con sus respectivos filtros.
     *
     * @return void.
     */
	public function indexAction()
	{
		$title = "Administración de proyectos";
		$this->getLayout()->setTitle($title);
		$this->_view->titlesection = $title;
		$this->filters();
		
		// CSRF
		$this->_csrf_section = "index_proyectosd_".date("YmdHis");
		$this->_csrf->generateCode($this->_csrf_section);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];

		$filters =(object)Session::getInstance()->get($this->namefilter);
        $this->_view->filters = $filters;
		$filters = $this->getFilter();
		$order = " fecha_c DESC";

		if ($_SESSION["kt_login_level"] == 5) {
			$list = $this->mainModel->getListIng($filters,$order);
		} else {
			$list = $this->mainModel->getList($filters,$order);
		}
		
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
		if ($_SESSION["kt_login_level"] == 5) {
			$this->_view->lists = $this->mainModel->getListPagesIng($filters,$order,$start,$amount);
		} else {
			$this->_view->lists = $this->mainModel->getListPages($filters,$order,$start,$amount);
		}
		
		$this->_view->list_tipo = $this->getTipo();
		$this->_view->list_cliente_id = $this->getClienteid();
		$this->_view->list_estado = $this->getEstado();
		$this->_view->lista_ingenieros = $this->getIng();
		$this->_view->lista_ingenieros_asoc = $this->getIngAsoc();
		$total_pendientes = 0;
		foreach($list as $key => $value){
			if($value->estado==6){
				$total_pendientes += $value->valor;
			}
		}
		$this->_view->total_pendientes = $total_pendientes;

	}

	/**
     * Genera la Informacion necesaria para editar o crear un  proyecto  y muestra su formulario
     *
     * @return void.
     */
	public function manageAction()
	{
		$this->_view->route = $this->route;
		$this->_csrf_section = "manage_proyectos_".date("YmdHis");
		$this->_csrf->generateCode($this->_csrf_section);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$this->_view->list_tipo = $this->getTipo();
		$this->_view->list_cliente_id = $this->getClienteid();
		$this->_view->list_estado = $this->getEstado();
		$id = $this->_getSanitizedParam("id");
		if ($id > 0) {
			$content = $this->mainModel->getById($id);
			if($content->id){
				$this->_view->content = $content;
				$this->_view->routeform = $this->route."/update";
				$title = "Actualizar Proyecto";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}else{
				$this->_view->routeform = $this->route."/insert";
				$title = "Crear Proyecto";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}
		} else {
			$this->_view->routeform = $this->route."/insert";
			$title = "Crear Proyecto";
			$this->getLayout()->setTitle($title);
			$this->_view->titlesection = $title;
		}
	}

	/**
     * Inserta la informacion de un proyecto  y redirecciona al listado de proyectos.
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
			
			$data['id']= $id;
			$data['log_log'] = print_r($data,true);
			$data['log_tipo'] = 'CREAR PROYECTO';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);
		}

		if ($detalle == "1") {
			header('Location: /page/proyectos/aprobar2?id='.$id.'&detalle=1');
		} else {
			header('Location: /page/proyectos/aprobar2?id='.$id);
		}

	}

	/**
     * Recibe un identificador  y Actualiza la informacion de un proyecto  y redirecciona al listado de proyectos.
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
				if($_FILES['documento1']['name'] != ''){
					if($content->documento1){
						$uploadDocument->delete($content->documento1);
					}
					$data['documento1'] = $uploadDocument->upload("documento1");
				} else {
					$data['documento1'] = $content->documento1;
				}
			
				if($_FILES['documento2']['name'] != ''){
					if($content->documento2){
						$uploadDocument->delete($content->documento2);
					}
					$data['documento2'] = $uploadDocument->upload("documento2");
				} else {
					$data['documento2'] = $content->documento2;
				}
			
				if($_FILES['documento3']['name'] != ''){
					if($content->documento3){
						$uploadDocument->delete($content->documento3);
					}
					$data['documento3'] = $uploadDocument->upload("documento3");
				} else {
					$data['documento3'] = $content->documento3;
				}
				$this->mainModel->update($data,$id);

				//si se aprueba guardar fecha aprobación
				if($content->estado!="1" and $data['estado']=="1"){
					$hoy = date("Y-m-d H:i:s");
					$this->mainModel->editField($id,"fecha_aprobado",$hoy);
				}
				
				if($data['estado']=="6"){
					$hoy = "";
					$this->mainModel->editField($id,"fecha_aprobado",$hoy);
					$this->mainModel->editField($id,"fecha_final",$hoy);
				}

			}
			$data['id']=$id;
			$data['log_log'] = print_r($data,true);
			$data['log_tipo'] = 'EDITAR PROYECTO';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);
		}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe un identificador  y elimina un proyecto  y redirecciona al listado de proyectos.
     *
     * @return void.
     */
	public function deleteAction()
	{
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf ) {
			$id =  $this->_getSanitizedParam("id");
			if (isset($id) && $id > 0) {
				$content = $this->mainModel->getById($id);
				if (isset($content)) {
					$this->mainModel->deleteRegister($id);
					$data = (array)$content;
					$data['log_log'] = print_r($data,true);
					$data['log_tipo'] = 'BORRAR PROYECTO';
					$logModel = new Administracion_Model_DbTable_Log();
					$logModel->insert($data);
				}
			}
		}
		header('Location: '.$this->route.''.'');
	}

	public function asignarAction(){
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		$id = $this->_getSanitizedParam("id");
		$r = $this->_getSanitizedParam("r");
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf ) {	
			
			$asignarModel = new Administracion_Model_DbTable_Proyectosing();
			$userModel = new Administracion_Model_DbTable_Usuario();

			$proyectosing_user = $_POST["proyectosing_user"];
			$proyectosing_observacion = $_POST["proyectosing_observacion"];

			for ($i = 0; $i < count($proyectosing_user); $i++) {
				if (!empty($proyectosing_user[$i])) { // Mejor usar !empty para verificar
					
					// Preparar datos
					$datos = array();
					$datos["proyectosing_user"] = $proyectosing_user[$i];
					$datos["proyectosing_observacion"] = $proyectosing_observacion[$i];
					$datos["proyectosing_proyecto"] = $id;

					// Verificar si ya existe el registro
					$existe = $asignarModel->getList(" proyectosing_user = '$proyectosing_user[$i]' AND proyectosing_proyecto = '$id' ","")[0];

					// Si no existe, insertar
					if (!$existe) {
						$asignarModel->insert($datos);
					} else {
						// Opcional: registrar o ignorar el duplicado
						// echo "Usuario " . $proyectosing_user[$i] . " ya asignado al proyecto $id<br>";
					}
				}
			}

		}

		if ($r == "soporte") {
			header('Location: /page/soporte/');
		} else {
			header('Location: '.$this->route.''.'');
		}
	}

	/**
     * Recibe la informacion del formulario y la retorna en forma de array para la edicion y creacion de Proyectos.
     *
     * @return array con toda la informacion recibida del formulario.
     */
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
		$data['proyectos_cadmin'] = $this->_getSanitizedParam("proyectos_cadmin");
		$data['proyectos_caprueba'] = $this->_getSanitizedParam("proyectos_caprueba");
		$data['valor']=str_replace(".","",$data['valor']);
		$data['valor']=str_replace(",","",$data['valor']);

		return $data;
	}

	/**
     * Genera los valores del campo tipo.
     *
     * @return array cadena con los valores del campo tipo.
     */
	private function getTipo()
	{
		$array = array();
		$array['1'] = 'Desarrollo';
		$array['2'] = 'Soporte';
		$array['3'] = 'Diseño';
		return $array;
	}


	/**
     * Genera los valores del campo cliente_id.
     *
     * @return array cadena con los valores del campo cliente_id.
     */
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
				$info = $proyectosModel->getList(" id = '$value->proyectosing_proyecto' AND estado = '1' ","")[0];
				$res = $clienteModel->getById($info->cliente_id);
				if ($res) {
					$array[$res->id] = $res->nombre;
				}
			}

		} else {
			$proyectosModel =  new Page_Model_DbTable_Proyectos();
			$proyectos = $proyectosModel->getList(" estado = '1' "," fecha_c DESC");
			
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

	private function getIng()
	{
		$userModel = new Administracion_Model_DbTable_Usuario();
		$listado = $userModel->getList(" user_level = '5' AND user_state = '1' "," user_names ASC ");
		$array = array();
		foreach($listado as $value){
			$array[$value->user_id] = $value->user_names . " ( ". $value->user_user . " ) ";
		}
		
		return $array;
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
				$proyectosIngenieros[$value->proyectosing_proyecto][] = $user->user_names;
			}
		}

		return $proyectosIngenieros; // Retorna el array con proyectos y sus ingenieros
	}

	

	/**
     * Genera los valores del campo estado.
     *
     * @return array cadena con los valores del campo estado.
     */
	private function getEstado()
	{
		$array = array();
		$array['6'] = 'Pendiente';
		//$array['5'] = 'En cotización';
		$array['1'] = 'Aprobado';
		//$array['2'] = 'No Aprobado';
		// $array['3'] = 'En desarrollo';
		$array['4'] = 'Finalizado';
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
    		$filtros .= " AND cliente_id='$cliente_id' ";
    	}

		if($this->_getSanitizedParam("estado")==""){
    		$filtros .= " AND ( estado = '1' OR estado = '3' OR estado = '4' ) ";
    	}

		if ($_SESSION["kt_login_level"] == 5) {
    		$filtros .= " AND proyectosing_user = '".$_SESSION["kt_login_id"]."' ";
    	}


        if (Session::getInstance()->get($this->namefilter)!="") {
            $filters =(object)Session::getInstance()->get($this->namefilter);
            if ($filters->fecha_c != '') {
                $filtros = $filtros." AND fecha_c LIKE '%".$filters->fecha_c."%'";
            }
			if ($filters->fecha_final != '') {
                $filtros = $filtros." AND fecha_final LIKE '%".$filters->fecha_final."%'";
            }
            if ($filters->nombre != '') {
                $filtros = $filtros." AND nombre LIKE '%".$filters->nombre."%'";
            }
            if ($filters->tipo != '') {
                $filtros = $filtros." AND tipo ='".$filters->tipo."'";
            }
            if ($filters->valor != '') {
                $filtros = $filtros." AND valor LIKE '%".$filters->valor."%'";
            }
            if ($filters->cliente_id != '') {
                $filtros = $filtros." AND cliente_id ='".$filters->cliente_id."'";
            }
            if ($filters->estado != '') {
                $filtros = $filtros." AND estado ='".$filters->estado."'";
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
            $parramsfilter['fecha_c'] =  $this->_getSanitizedParam("fecha_c");
			$parramsfilter['fecha_final'] =  $this->_getSanitizedParam("fecha_final");
            $parramsfilter['nombre'] =  $this->_getSanitizedParam("nombre");
            $parramsfilter['tipo'] =  $this->_getSanitizedParam("tipo");
            $parramsfilter['valor'] =  $this->_getSanitizedParam("valor");
            $parramsfilter['cliente_id'] =  $this->_getSanitizedParam("cliente_id");
            $parramsfilter['estado'] =  $this->_getSanitizedParam("estado");
            Session::getInstance()->set($this->namefilter, $parramsfilter);
        }
        if ($this->_getSanitizedParam("cleanfilter") == 1) {
            Session::getInstance()->set($this->namefilter, '');
            Session::getInstance()->set($this->namepageactual,1);
        }
    }


	public function aprobarAction(){
		$this->setLayout('blanco');
		$id = $this->_getSanitizedParam("id");
		$r = $this->_getSanitizedParam("r");
		if($id!=""){
			$this->mainModel->editField($id,"estado",1);
			$hoy = date("Y-m-d H:i:s");
			$this->mainModel->editField($id,"fecha_aprobado",$hoy);
		}

		if($r=="dashboard" or $r==""){
			$url = "/page/sistema/#proyectos";
		}
		if($r=="index"){
			$url = "/page/proyectos/index";
		}

		header("Location:".$url);
	}

}