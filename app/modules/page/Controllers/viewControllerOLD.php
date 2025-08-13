<?php

/**
 *
 */


class Page_viewController extends Page_mainController
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
	protected $_csrf_section = "page_view";

	/**
	 * $namepages nombre de la pvariable en la cual se va a guardar  el numero de seccion en la paginacion del controlador
	 * @var string
	 */
	protected $namepages;


    public function init()
	{
		$this->mainModel = new Page_Model_DbTable_Proyectos();
		$this->namefilter = "parametersfilterview";
		$this->route = "/page/view";
		$this->namepages ="pages_view";
		$this->namepageactual ="page_actual_view";
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
        
        // CSRF
		$this->_csrf_section = "index_view_".date("YmdHis");
		$this->_csrf->generateCode($this->_csrf_section);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];

        $proyectosModel =  new Page_Model_DbTable_Proyectos();
        $proyecto = $this->_getSanitizedParam('proyecto');

        $info = $proyectosModel->getById($proyecto);

        $ingenierosModel = new Administracion_Model_DbTable_Proyectosing();
        $this->_view->ingenieros = $ingenierosModel->getList(" proyectosing_proyecto = '".$proyecto."' ","");

		$docModel = new Administracion_Model_DbTable_Documentos();
		$this->_view->docs = $docModel->getList(" documentos_proyecto = '".$proyecto."' ","");

		$requerimientosModel = new Administracion_Model_DbTable_Requerimientos();
		$this->_view->requerimientos = $requerimientosModel->getList(" requerimientos_proyecto = '".$proyecto."' ","");

        $this->_view->info = $info;
        $this->_view->list_tipo = $this->getTipo();
        $this->_view->list_cliente_id = $this->getClienteid();
        $this->_view->list_estado = $this->getEstado();
		$this->_view->list_estado_req = $this->getEstadoReq();
        $this->_view->lista_ingenieros = $this->getIng();
        $this->_view->lista_ingenieros_user = $this->getIngUser(); 
		$this->_view->lista_proyecto_sff = $this->getProyectoSFF(); // Proyectos sin fecha de finalizacion
		$this->_view->list_tablero_id = $this->getTableroId();
		$this->_view->list_secciones = $this->getSecciones();
		
    }

	public function detailAction() {
        
        // CSRF
		$this->_csrf_section = "index_view_".date("YmdHis");
		$this->_csrf->generateCode($this->_csrf_section);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];

        $proyectosModel =  new Page_Model_DbTable_Proyectos();
        $proyecto = $this->_getSanitizedParam('proyecto');

        $info = $proyectosModel->getById($proyecto);

        $ingenierosModel = new Administracion_Model_DbTable_Proyectosing();
        $this->_view->ingenieros = $ingenierosModel->getList(" proyectosing_proyecto = '".$proyecto."' ","");

		$docModel = new Administracion_Model_DbTable_Documentos();
		$this->_view->docs = $docModel->getList(" documentos_proyecto = '".$proyecto."' ","");

		$requerimientosModel = new Administracion_Model_DbTable_Requerimientos();
		$this->_view->requerimientos = $requerimientosModel->getList(" requerimientos_proyecto = '".$proyecto."' ","");

        $this->_view->info = $info;
        $this->_view->list_tipo = $this->getTipo();
        $this->_view->list_cliente_id = $this->getClienteid();
        $this->_view->list_estado = $this->getEstado();
		$this->_view->list_estado_req = $this->getEstadoReq();
        $this->_view->lista_ingenieros = $this->getIng();
        $this->_view->lista_ingenieros_user = $this->getIngUser(); 
		$this->_view->lista_proyecto_sff = $this->getProyectoSFF(); // Proyectos sin fecha de finalizacion
		$this->_view->list_tablero_id = $this->getTableroId();
		$this->_view->list_secciones = $this->getSecciones();
		
    }

    public function updateGeneralAction(){
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		$id = $this->_getSanitizedParam("id");
		$r = $this->_getSanitizedParam("r");
        $cliente = $this->_getSanitizedParam("cliente");
        $proyecto = $this->_getSanitizedParam("proyecto");
		$descripcion = $this->_getSanitizedParam("descripcion");
		$fecha_final = $this->_getSanitizedParam("fecha_final");
        
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf ) {	

			$asignarModel = new Administracion_Model_DbTable_Proyectosing();
			$userModel = new Administracion_Model_DbTable_Usuario();
			$uploadDocument = new Core_Model_Upload_Document();
			$docModel = new Administracion_Model_DbTable_Documentos();
			$requerimientosModel = new Administracion_Model_DbTable_Requerimientos();

			$this->mainModel->editField($id,"fecha_final", $fecha_final);
			$this->mainModel->editField($id,"descripcion", $descripcion);

			// Verifica si hay archivos para procesar
			$docModel->deleteDoc($proyecto); 
			
			foreach ($_POST["adjuntos_name"] as $name) {
				$data_adjunto = array(); // Asegúrate de reiniciar el array en cada iteración
				$data_adjunto["documentos_proyecto"] = $proyecto; // Asigna el ID del proyecto
				$data_adjunto["documentos_nombre"] = $name; // El nombre del archivo subido
				$docModel->insert($data_adjunto); // Inserta en la base de datos
			}

			if (!empty($_FILES['adjuntos']['name'][0])) {
                foreach ($_FILES['adjuntos']['name'] as $key => $name) {
                    // Crear un array de cada archivo individual para pasarlo al método upload()
                    $file = [
                        'name' => $_FILES['adjuntos']['name'][$key],
                        'type' => $_FILES['adjuntos']['type'][$key],
                        'tmp_name' => $_FILES['adjuntos']['tmp_name'][$key],
                        'error' => $_FILES['adjuntos']['error'][$key],
                        'size' => $_FILES['adjuntos']['size'][$key]
                    ];
            
                    // Subir el archivo y obtener el nombre del archivo subido
                    if ($file['error'] == 0) {
                        $resultado_adjunto = $uploadDocument->uploadArray($file);
            
                        if ($resultado_adjunto) {
                            // Guardar la información en la base de datos
                            $data_adjunto = [
                                "documentos_proyecto" => $proyecto,
                                "documentos_nombre" => $resultado_adjunto
                            ];
                            $docModel->insert($data_adjunto);
                        }
                    }
                }
            } else {
                echo "No hay archivos para subir.";
            }

			
			if ($this->_getSanitizedParam("requerimientos_desc")) { 
				$data_requerimientos = array();
				$data_requerimientos["requerimientos_proyecto"] = $id;
				$data_requerimientos["requerimientos_fecha"] = $this->_getSanitizedParam("requerimientos_fecha");
				$data_requerimientos["requerimientos_fecha_t"] = $this->_getSanitizedParam("requerimientos_fecha_t");
				$data_requerimientos["requerimientos_tipo"] = $this->_getSanitizedParam("requerimientos_tipo");
				$data_requerimientos["requerimientos_ing"] = $this->_getSanitizedParam("requerimientos_ing");
				$data_requerimientos["requerimientos_desc"] = $this->_getSanitizedParam("requerimientos_desc");
				$data_requerimientos["requerimientos_estado"] = "1";

				// Guarda los requermimientos
				$requerimientosModel->insert($data_requerimientos);
			}		
			

			$proyectosing_user = $_POST["proyectosing_user"];
			$proyectosing_observacion = $_POST["proyectosing_observacion"];
            
			if ($proyectosing_user) {
				
				$asignarModel->deleteAll($id);

				for ($i = 0; $i < count($proyectosing_user); $i++) {

					if ($proyectosing_user[$i]) {					
						$datos = array();
						$datos["proyectosing_user"] = $proyectosing_user[$i];
						$datos["proyectosing_observacion"] = $proyectosing_observacion[$i];
						$datos["proyectosing_proyecto"] = $id;

						$data_user = $userModel->getById($proyectosing_user[$i]);
						$data_proyecto = $this->mainModel->getById($id);

						$asignarModel->insert($datos);

						// Enviar correo
						// Bloqueamos el envio de correos
						/* $content = new stdClass();
						$content->correo = $data_user->user_email;
						$content->usuario = $data_user->user_user;
						$content->proyecto = $data_proyecto->nombre;

						$sendingemail = new Core_Model_Sendingemail($this->_view);
						$sendingemail->notificaAsignacion($content); */
						
					}
				}
			}

		}

		if ($r == "detail") {
			header('Location: /page/view/detail?cliente='.$cliente.'&proyecto='.$proyecto);
		} else {
			header('Location: '.$this->route.'?cliente='.$cliente.'&proyecto='.$proyecto);
		}
	    
	}

	public function updateRequeAction(){
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		$id = $this->_getSanitizedParam("id");
		$r = $this->_getSanitizedParam("r");
        $cliente = $this->_getSanitizedParam("cliente");
        $proyecto = $this->_getSanitizedParam("proyecto");
        
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

		if ($r == "detail") {
			header('Location: /page/view/detail?cliente='.$cliente.'&proyecto='.$proyecto);
		} else {
			header('Location: '.$this->route.'?cliente='.$cliente.'&proyecto='.$proyecto);
		}

	}

	public function editarRequeAction(){
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		$id = $this->_getSanitizedParam("requerimientos_id");
		$cliente = $this->_getSanitizedParam("cliente");
        $proyecto = $this->_getSanitizedParam("proyecto");
        
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

	    header('Location: '.$this->route.'?cliente='.$cliente.'&proyecto='.$proyecto);
	}

	public function terminarAction(){
		$this->setLayout('blanco');
		$id = $this->_getSanitizedParam("id");
		$cliente = $this->_getSanitizedParam("cliente");
        $proyecto = $this->_getSanitizedParam("proyecto");
		$hastw = $this->_getSanitizedParam("hastw");
        
			
		$proyectosModel =  new Page_Model_DbTable_Proyectos();
		$proyectosModel->editField($id, "estado", "7");

		if ($hastw) {
			header('Location: /page/proyectosd/');
		} else {
			header('Location: /page/soporte/index?cliente='.$cliente.'&proyecto='.$proyecto);
		}
	}

	public function finalizarAction(){
		$this->setLayout('blanco');
		$id = $this->_getSanitizedParam("id");
		$cliente = $this->_getSanitizedParam("cliente");
        $proyecto = $this->_getSanitizedParam("proyecto");
		$hastw = $this->_getSanitizedParam("hastw");
        
			
		$proyectosModel =  new Page_Model_DbTable_Proyectos();
		$proyectosModel->editField($id, "estado", "8");

		
		header('Location: /page/soporte/index');
		
	}

	public function downloadAction() {
		$this->setLayout('blanco');
	
		$id = $this->_getSanitizedParam("id");
	
		$docModel = new Administracion_Model_DbTable_Documentos();
		$doc = $docModel->getList(" documentos_id = '".$id."' ", "")[0];
	
		$ruta = PUBLIC_PATH.'/images/' . $doc->documentos_nombre;
		
		$ext = pathinfo($ruta, PATHINFO_EXTENSION);
		$tipos = [
			'pdf'  => 'application/pdf',
			'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
			'xls'  => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
		];

		$tipoMime = $tipos[$ext] ?? 'application/octet-stream';

		header("Content-Type: $tipoMime");
		header("Content-Disposition: attachment; filename=" . basename($ruta));
		header("Content-Length: " . filesize($ruta));

		readfile($ruta);
	}
	

	public function terminar2Action(){
		$this->setLayout('blanco');
		$proyecto = $this->_getSanitizedParam("proyecto");
	
		$proyectosModel = new Page_Model_DbTable_Proyectos();
		$proyectosModel->editField($proyecto, "estado", "7"); // Ejecuta la actualización
	
		// Responde con JSON para indicar el éxito o el fallo de la operación
		header('Content-Type: application/json');
		echo json_encode(['success' => true, 'message' => 'Proyecto terminado exitosamente.']);
	}	

	private function getTableroId()
	{
		$tableroModel =  new Administracion_Model_DbTable_Tablero();
		$listado = $tableroModel->getList("","");
		$array = array();
		foreach($listado as $value){
			$array[$value->tablero_proyecto] = $value->tablero_proyecto;
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

    private function getClienteid()
    {

		$proyectosModel =  new Page_Model_DbTable_Proyectos();
      	$proyectos = $proyectosModel->getList(" estado = '1' "," fecha_c DESC");
		
        $clienteModel = new Page_Model_DbTable_Clientes();
        $array = array();
        foreach($proyectos as $value){
       		$res = $clienteModel->getById($value->cliente_id);
			$array[$res->id] = $res->nombre;
        }
        
        return $array;
    }

	public function getProyectoSFF(){

		$cliente = $this->_getSanitizedParam("cliente");

		if ($cliente) {
			$mas = " AND cliente_id = '".$cliente."' ";
		}

		$proyectosModel =  new Page_Model_DbTable_Proyectos();
      	$proyectos = $proyectosModel->getList(" (fecha_final = '' OR fecha_final IS NULL) AND estado = '1' "," fecha_c DESC");
		
        $array = array();
        foreach($proyectos as $value){
			$array[$value->id] = $value;
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
      	$proyectos = $proyectosModel->getList("cliente_id = '".$cliente."' AND ( estado = '1' OR estado = '7' OR estado = '9' )  "," fecha_c DESC");

		foreach ($proyectos as $key => $value) {
			$respuesta[$key]["valor"] = $value->id;
			$respuesta[$key]["texto"] = $value->nombre;
		}

		echo json_encode($respuesta);
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
		$array['8'] = 'Finalizado relación';
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

	public function deleteRequerimientoAction()
	{
		header('Content-Type:application/json');
		$this->setLayout('blanco');

        $data = array();
        $tablero_id = $this->_getSanitizedParam('id');
        
		$requeModel =  new Administracion_Model_DbTable_Requerimientos();
        $id = $requeModel->deleteRegister($tablero_id);
		echo json_encode($data);
	}

	public function stopRequerimientoAction()
	{
		header('Content-Type:application/json');
		$this->setLayout('blanco');

        $data = array();
        $id = $this->_getSanitizedParam('id');
        
		$requeModel =  new Administracion_Model_DbTable_Requerimientos();
		$requeModel->editField($id,"requerimientos_estado", "3");

		echo json_encode($data);
	}

	public function deleteSeccionAction()
	{
		header('Content-Type:application/json');
		$this->setLayout('blanco');

        $data = array();
        $seccion_id = $this->_getSanitizedParam('id');
        
		$seccionModel =  new Page_Model_DbTable_Secciones();
        $id = $seccionModel->deleteRegister($seccion_id);
		echo json_encode($data);
	}

	public function update_seccionAction()
	{
		$this->setLayout('blanco');

        $data = array();
        $update_secciones_nombre = $this->_getSanitizedParam('update_secciones_nombre');
		$update_secciones_id = $this->_getSanitizedParam('update_secciones_id');
		$cliente = $this->_getSanitizedParam('cliente');
		$proyecto = $this->_getSanitizedParam('proyecto');
		$clientre = $this->_getSanitizedParam('r');
		
		$seccionModel =  new Page_Model_DbTable_Secciones();
		$seccionModel->editField($update_secciones_id,"secciones_nombre", $update_secciones_nombre);

		if ($r == "detail") {
			header('Location: /page/view/detail?cliente='.$cliente.'&proyecto='.$proyecto);
		} else {
			header('Location: /page/view?cliente='.$cliente.'&proyecto='.$proyecto);
		}

	}

	public function seccionAction(){

		$this->setLayout('blanco');

		$seccion = $_POST["seccion"];
		$cliente = $this->_getSanitizedParam('cliente');
		$r = $this->_getSanitizedParam('r');
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

		if ($r == "detail") {
			header('Location: /page/view/detail?cliente='.$cliente.'&proyecto='.$proyecto);
		} else {
			header('Location: /page/view?cliente='.$cliente.'&proyecto='.$proyecto);
		}
		

	}

}