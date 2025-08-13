<?php

/**
 *
 */


class Page_tableroController extends Page_mainController
{

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
	protected $_csrf_section = "page_tablero";

	/**
	 * $namepages nombre de la pvariable en la cual se va a guardar  el numero de seccion en la paginacion del controlador
	 * @var string
	 */
	protected $namepages;


    public function init()
	{
		$this->mainModel = new Page_Model_DbTable_Proyectos();
		$this->namefilter = "parametersfiltertablero";
		$this->route = "/page/tablero";
		$this->namepages ="pages_tablero";
		$this->namepageactual ="page_actual_tablero";
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

    public function indexAction() {
        $title = "Plan de Trabajo";
		$this->getLayout()->setTitle($title);
		$this->_view->titlesection = $title;
        // CSRF
		$this->_csrf_section = "index_tablero_".date("YmdHis");
		$this->_csrf->generateCode($this->_csrf_section);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];

        $proyectosModel =  new Page_Model_DbTable_Proyectos();
        $proyecto = $this->_getSanitizedParam('proyecto');
		$ing = $this->_getSanitizedParam('ing');

        $info = $proyectosModel->getById($proyecto);

        $ingenierosModel = new Administracion_Model_DbTable_Proyectosing();
        $this->_view->ingenieros = $ingenierosModel->getList(" proyectosing_proyecto = '".$proyecto."' ","");

		$docModel = new Administracion_Model_DbTable_Documentos();
		$this->_view->docs = $docModel->getList(" documentos_proyecto = '".$proyecto."' ","");

		$requerimientosModel = new Administracion_Model_DbTable_Requerimientos();
		$this->_view->requerimientos = $requerimientosModel->getList(" requerimientos_proyecto = '".$proyecto."' ","");

        $this->_view->info = $info;
        $this->_view->list_tipo = $this->getTipo();
        $this->_view->list_cliente_id = $this->getClienteing();
		$this->_view->list_cliente_all = $this->getClienteAll();
        $this->_view->list_estado = $this->getEstado();
        $this->_view->lista_ingenieros = $this->getIng();
        $this->_view->lista_ingenieros_user = $this->getIngUser();
        $this->_view->tablero = $this->getTablero();

		$this->_view->clientes = $this->getClienteid();
		$this->_view->proyectos = $this->getProyectos();
		$this->_view->list_secciones = $this->getSecciones();
		$this->_view->list_estado_req = $this->getEstadoReq();

		$requerimientosModel = new Administracion_Model_DbTable_Requerimientos();
		$this->_view->requerimientos = $requerimientosModel->getList(" requerimientos_proyecto = '".$proyecto."' ","");
        
    }

	public function updateRequeAction(){
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		$id = $this->_getSanitizedParam("id");
        $cliente = $this->_getSanitizedParam("cliente");
        $proyecto = $this->_getSanitizedParam("proyecto");
		$ing = $this->_getSanitizedParam("ing");
        
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf ) {	

			$requerimientosModel = new Administracion_Model_DbTable_Requerimientos();

			$requerimientos_desc = $_POST["requerimientos_desc"];
			$requerimientos_fecha = $this->_getSanitizedParam("requerimientos_fecha");
			$requerimientos_fecha_t = $_POST["requerimientos_fecha_t"];
			$requerimientos_tipo = $_POST["requerimientos_tipo"];
			$requerimientos_ing = $_POST["requerimientos_ing"];
			$requerimientos_desc = $_POST["requerimientos_desc"];
			$requerimientos_seccion = $_POST["requerimientos_seccion"];

			if ($requerimientos_desc) {
				for ($i = 0; $i < count($requerimientos_desc); $i++) {
					$data_requerimientos = array();
					$data_requerimientos["requerimientos_proyecto"] = $id;
					$data_requerimientos["requerimientos_fecha"] = $requerimientos_fecha;
					$data_requerimientos["requerimientos_fecha_t"] = $requerimientos_fecha_t[$i];
					$data_requerimientos["requerimientos_tipo"] = $requerimientos_tipo[$i];
					$data_requerimientos["requerimientos_ing"] = $requerimientos_ing[$i];
					$data_requerimientos["requerimientos_desc"] = $requerimientos_desc[$i];
					$data_requerimientos["requerimientos_estado"] = "1";
					$data_requerimientos["requerimientos_seccion"] = $requerimientos_seccion[$i];

					// Guarda los requermimientos
					$requerimientosModel->insert($data_requerimientos);
				}
			}

		}

	    header('Location: '.$this->route.'?ing='.$ing.'&proyecto='.$proyecto.'&cliente='.$cliente);
	}

	public function seccionAction(){

		$this->setLayout('blanco');

		$seccion = $_POST["seccion"];
		$cliente = $this->_getSanitizedParam('cliente');
		$ing = $this->_getSanitizedParam('ing');
		$proyecto = $this->_getSanitizedParam('proyecto');
	
		$seccionModel =  new Page_Model_DbTable_Secciones();
		
		foreach ($seccion as $value) {
			if ($value) {
				$data["secciones_nombre"] = $value;
				$data["secciones_activo"] = "1";
				$data['secciones_cliente'] = $cliente;
				$data['secciones_proyecto'] = $proyecto;
				$seccionModel->insert($data);
			}			
		}

		header('Location: '.$this->route.'?ing='.$ing.'&proyecto='.$proyecto.'&cliente='.$cliente);
	}

    private function getClienteid()
    {

		$proyectosModel =  new Page_Model_DbTable_Proyectos();
      	$proyectos = $proyectosModel->getList(" ( estado = '1' OR estado = '7' ) "," fecha_c DESC");
		
        $clienteModel = new Page_Model_DbTable_Clientes();
        $array = array();
        foreach($proyectos as $value){
       		$res = $clienteModel->getById($value->cliente_id);
			$array[$res->id] = $res->nombre;
        }
        
        return $array;
    }

	private function getClienteing()
    {

		$ing = $this->_getSanitizedParam('ing');

		$proyectosIngModel =  new Administracion_Model_DbTable_Proyectosing();
      	$proyectosIng = $proyectosIngModel->getList(" proyectosing_user = '".$ing."' ","");
		
        $clienteModel = new Page_Model_DbTable_Clientes();
		$proyectosModel =  new Page_Model_DbTable_Proyectos();
		
        $array = array();
        foreach($proyectosIng as $value){
			$info_proyecto = $proyectosModel->getById($value->proyectosing_proyecto);
			if ($info_proyecto->estado != 8) {
				$res = $clienteModel->getById($info_proyecto->cliente_id);
				$array[$res->id] = $res->nombre;
			}
        }
        asort($array);
        return $array;
    }

	public function obtenerProyectoAction()
	{
		header('Content-Type:application/json');
		$this->setLayout('blanco');
		$respuesta = array();
		$cliente = $this->_getSanitizedParam('cliente');
		$ing = $this->_getSanitizedParam('ing');
		
		$proyectosModel =  new Page_Model_DbTable_Proyectos();
		$proyectosIngModel =  new Administracion_Model_DbTable_Proyectosing();
		$clienteModel = new Page_Model_DbTable_Clientes();

		if ($cliente) {
			$cadena = " cliente_id = '".$cliente."' AND ";
		} else {
			$cadena = "";
		}
		
      	$proyectos = $proyectosModel->getList(" $cadena ( estado = '1' OR estado = '7' OR estado = '9' )  "," fecha_c DESC");
		
		foreach ($proyectos as $key => $value) {
			$existe = $proyectosIngModel->getList(" proyectosing_user = '$ing' AND proyectosing_proyecto = '$value->id' ","");
			$name_cliente = $clienteModel->getById($value->cliente_id);
			if ($existe) {
				$respuesta[$key]["valor"] = $value->id;
				$respuesta[$key]["texto"] = $value->nombre;
				$respuesta[$key]["cliente"] = $name_cliente->nombre;
				$respuesta[$key]["cliente_id"] = $name_cliente->id;
			}
		}

		// Ordenar
		usort($respuesta, function($a, $b) {
			return $a["cliente"] <=> $b["cliente"];
		});
		
		echo json_encode($respuesta);
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

	private function getSecciones()
	{
		$cliente = $this->_getSanitizedParam("cliente");
		$proyecto = $this->_getSanitizedParam("proyecto");

		$seccionModel =  new Page_Model_DbTable_Secciones();
		$listado = $seccionModel->getList(" secciones_cliente = '$cliente' AND secciones_proyecto = '$proyecto' ","");
		$array = array();
		foreach($listado as $value){
			$array[$value->secciones_id] = $value;
		}
		
		return $array;
	}

    private function getTablero()
    {

        $ing = $this->_getSanitizedParam('ing');
		$tableroModel =  new Administracion_Model_DbTable_Tablero();
        $proyectosModel =  new Page_Model_DbTable_Proyectos();
		$clienteModel = new Page_Model_DbTable_Clientes();
        $lista = $tableroModel->getList(" tablero_ing = '".$ing."' ","");
		
        $array = array();
        foreach($lista as $value){
            $proyecto = $proyectosModel->getById($value->tablero_proyecto);
			$cliente = $clienteModel->getById($proyecto->cliente_id);
            $value->nombre = html_entity_decode($proyecto->nombre);
			$value->cliente = html_entity_decode($cliente->nombre);
			$value->cliente_id = html_entity_decode($cliente->id);
       		$array[] = $value;
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
      	$proyectos = $proyectosModel->getList("cliente_id = '".$cliente."' "," fecha_c DESC");

		foreach ($proyectos as $key => $value) {
			$respuesta[$key]["valor"] = $value->id;
			$respuesta[$key]["texto"] = $value->nombre;
		}

		echo json_encode($respuesta);
	}

	public function verReqAction()
	{
		header('Content-Type:application/json');
		$this->setLayout('blanco');
		$respuesta = array();
		$proyecto = $this->_getSanitizedParam('proyecto');
		$ing = $this->_getSanitizedParam('ing');
		
		if ($ing) {
			$requerimientosModel = new Administracion_Model_DbTable_Requerimientos();
			$userModel = new Administracion_Model_DbTable_Usuario();
			$proyectosModel =  new Page_Model_DbTable_Proyectos();
			$docModel = new Administracion_Model_DbTable_Documentos();
			$lista_docs = $docModel->getList(" documentos_proyecto = '".$proyecto."' ","");
			$listaReq = $requerimientosModel->getList(" requerimientos_proyecto = '".$proyecto."' AND requerimientos_ing = '".$ing."' ","");

			$info_proyecto = $proyectosModel->getById($proyecto);
			if ($info_proyecto->descripcion){
				$respuesta["desc"] = $info_proyecto->descripcion; // Descripción del proyecto en la raíz del JSON
				$respuesta["cliente"] = $info_proyecto->cliente_id;
				$respuesta["fecha_final"] = formatoDMYH(date("Y-m-d", strtotime(str_replace("T", " ", $info_proyecto->fecha_final)))); // Descripción del proyecto en la raíz del JSON

				foreach ($listaReq as $key => $value) {
					$user = $userModel->getById($value->requerimientos_ing);
					$value->user_names = $user->user_names;
					$value->user_user = $user->user_user;
					$respuesta['requerimientos'][] = $value; // Agregar lista de requerimientos en una clave separada
				}

				foreach ($lista_docs as $key => $value) {
					$respuesta['docs'][] = $value; // Agregar lista de docs en una clave separada
				}
			}
		}
		echo json_encode($respuesta);
	}

	public function editarRequeAction(){
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		$id = $this->_getSanitizedParam("requerimientos_id");
		$cliente = $this->_getSanitizedParam("cliente");
        $proyecto = $this->_getSanitizedParam("proyecto");
		$ing = $this->_getSanitizedParam("ing");
        
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf ) {	
			
			$requerimientosModel = new Administracion_Model_DbTable_Requerimientos();

			$requerimientosModel->editField($id, "requerimientos_fecha", $this->_getSanitizedParam("requerimientos_fecha"));
			$requerimientosModel->editField($id, "requerimientos_fecha_t", $this->_getSanitizedParam("requerimientos_fecha_t"));
			$requerimientosModel->editField($id, "requerimientos_tipo", $this->_getSanitizedParam("requerimientos_tipo"));
			$requerimientosModel->editField($id, "requerimientos_ing", $this->_getSanitizedParam("requerimientos_ing"));
			$requerimientosModel->editField($id, "requerimientos_desc", $this->_getSanitizedParam("requerimientos_desc"));
			$requerimientosModel->editField($id, "requerimientos_estado", $this->_getSanitizedParam("requerimientos_estado"));
			$requerimientosModel->editField($id, "requerimientos_seccion", $this->_getSanitizedParam("requerimientos_seccion"));

		}

	    header('Location: '.$this->route.'?ing='.$ing.'&cliente='.$cliente.'&proyecto='.$proyecto);
	}


    public function insertTableroAction()
	{
		header('Content-Type:application/json');
		$this->setLayout('blanco');

        $data = array();
        $data["tablero_proyecto"] = $this->_getSanitizedParam('id');
        $data["tablero_ing"] = $this->_getSanitizedParam('ing');
        $data["tablero_fecha"] = $this->_getSanitizedParam('fecha');
        $data["tablero_dia"] = $this->_getSanitizedParam('dia');
        $data["tablero_all"] = $this->_getSanitizedParam('esTodoElDia');
        $data["tablero_inicia"] = $this->_getSanitizedParam('horaInicio');
        $data["tablero_fin"] = $this->_getSanitizedParam('horaFin');
        $data["tablero_color"] = "#cff4fc";
        $data["tablero_fuente"] = "#055160";
        
		
		$tableroModel =  new Administracion_Model_DbTable_Tablero();
		$id = $tableroModel->insert($data);
		
		echo json_encode($data);
	}

	public function updateTableroAction()
	{
		header('Content-Type:application/json');
		$this->setLayout('blanco');

        $data = array();
        $id = $this->_getSanitizedParam('id');
        $tablero_ing = $this->_getSanitizedParam('ing');
        $tablero_fecha = $this->_getSanitizedParam('fecha');
        $tablero_dia = $this->_getSanitizedParam('dia');
        $tablero_all = $this->_getSanitizedParam('esTodoElDia');
        $tablero_inicia = $this->_getSanitizedParam('horaInicio');
        $tablero_fin = $this->_getSanitizedParam('horaFin');
        $tablero_color = "#cff4fc";
        $tablero_fuente = "#055160";

		$tableroModel =  new Administracion_Model_DbTable_Tablero();
		if ($tablero_fecha) {
			$tableroModel->editField($id,"tablero_fecha",$tablero_fecha);	
		}
		$tableroModel->editField($id,"tablero_inicia",$tablero_inicia);
		$tableroModel->editField($id,"tablero_fin",$tablero_fin);
		$tableroModel->editField($id,"tablero_all",$tablero_all);
		$tableroModel->editField($id,"tablero_dia",$tablero_dia);
        
        // $id = $tableroModel->insert($data);
		echo json_encode($data);
	}

    public function deleteTableroAction()
	{
		header('Content-Type:application/json');
		$this->setLayout('blanco');

        $data = array();
        $tablero_id = $this->_getSanitizedParam('id');
        
		$tableroModel =  new Administracion_Model_DbTable_Tablero();
        $id = $tableroModel->deleteRegister($tablero_id);
		echo json_encode($data);
	}

    private function getEstado()
    {
        $array = array();
        $array['6'] = 'Pendiente';
        //$array['5'] = 'En cotización';
        $array['1'] = 'Aprobado';
        $array['2'] = 'No Aprobado';
        $array['3'] = 'En desarrollo';
        $array['4'] = 'Finalizado';
		$array['7'] = 'Finalizado con Soporte';
        return $array;
    } 

	private function getEstadoReq()
    {
        $array = array();
        $array['1'] = 'Asignado';
        $array['2'] = 'En desarrollo';
        $array['3'] = 'Finalizado';
        return $array;
    }


    private function getTipo()
    {
        $array = array();
        $array['1'] = 'Desarrollo';
        $array['2'] = 'Soporte';
        $array['3'] = 'Diseño';
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

    private function getIngUser()
	{
		$userModel = new Administracion_Model_DbTable_Usuario();
		$listado = $userModel->getList(" user_level = '5' AND user_state = '1' "," user_names ASC ");
		$array = array();
		foreach($listado as $value){
			$array[$value->user_id] = $value;
		}
		
		return $array;
	}

}