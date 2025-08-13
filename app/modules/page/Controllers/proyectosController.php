<?php
/**
* Controlador de Proyectos que permite la  creacion, edicion  y eliminacion de los proyectos del Sistema
*/
class Page_proyectosController extends Page_mainController
{
    public $botonpanel = 2;
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
	protected $_csrf_section = "page_proyectos";

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
		$this->namefilter = "parametersfilterproyectos";
		$this->route = "/page/proyectos";
		$this->namepages ="pages_proyectos";
		$this->namepageactual ="page_actual_proyectos";
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
		$title = "Administración de cotizaciones";
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
		$this->_view->list_tipo = $this->getTipo();
		$this->_view->list_cliente_id = $this->getClienteid();
		$this->_view->list_estado = $this->getEstado();

		$total_pendientes = 0;
		foreach($list as $key => $value){
			if($value->estado==6){
				$total_pendientes += $value->valor;
			}
		}
		$this->_view->total_pendientes = $total_pendientes;
		
		$ultimo = $this->mainModel->getList("","consecutivo DESC LIMIT 1")[0]; // Ultimo consecutivo
      	$this->_view->ultimo = $ultimo->consecutivo;

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
				$title = "Actualizar Cotización";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}else{
				$this->_view->routeform = $this->route."/insert";
				$title = "Crear Cotización";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}
		} else {
			$this->_view->routeform = $this->route."/insert";
			$title = "Crear Cotización";
			$this->getLayout()->setTitle($title);
			$this->_view->titlesection = $title;
		}

		$ultimo = $this->mainModel->getList("","consecutivo DESC LIMIT 1")[0]; // Ultimo consecutivo
      	$this->_view->ultimo = $ultimo->consecutivo;
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

			$consecutivo = $data['consecutivo'];
			$existeC = $this->mainModel->getList(" consecutivo = '".$consecutivo."' ","")[0];

			if (!$existeC) {
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
			
		}

		if ($detalle == 1) {
			header('Location: /page/sistema/');
		} else {
			header('Location: '.$this->route.''.'');
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

			}
			$data['id']=$id;
			$data['log_log'] = print_r($data,true);
			$data['log_tipo'] = 'EDITAR COTIZACION';
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
		if (Session::getInstance()->get('csrf')[$this->_csrf_section] == $csrf ) {
			$id =  $this->_getSanitizedParam("id");
			if (isset($id) && $id > 0) {
				$content = $this->mainModel->getById($id);
				if (isset($content)) {
					$uploadDocument =  new Core_Model_Upload_Document();
					if (isset($content->documento1) && $content->documento1 != '') {
						$uploadDocument->delete($content->documento1);
					}
					
					if (isset($content->documento2) && $content->documento2 != '') {
						$uploadDocument->delete($content->documento2);
					}
					
					if (isset($content->documento3) && $content->documento3 != '') {
						$uploadDocument->delete($content->documento3);
					}
					$this->mainModel->deleteRegister($id);$data = (array)$content;
					$data['log_log'] = print_r($data,true);
					$data['log_tipo'] = 'BORRAR PROYECTO';
					$logModel = new Administracion_Model_DbTable_Log();
					$logModel->insert($data); }
			}
		}
		header('Location: '.$this->route.''.'');
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
		$data['consecutivo'] = $this->_getSanitizedParam("consecutivo");
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
		$clienteModel = new Page_Model_DbTable_Clientes();
		$listado = $clienteModel->getList(""," nombre ASC ");
		$array = array();
		foreach($listado as $value){
			$array[$value->id] = $value->nombre;
		}
		
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
		$array['6'] = 'Pendiente';
		//$array['5'] = 'En cotización';
		//$array['1'] = 'Aprobado';
		$array['2'] = 'No Aprobado';
		//$array['3'] = 'En desarrollo';
		//$array['4'] = 'Finalizado';
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
    		$filtros .= " AND ( estado = '6' ) ";
    	}


        if (Session::getInstance()->get($this->namefilter)!="") {
            $filters =(object)Session::getInstance()->get($this->namefilter);
            if ($filters->fecha_c != '') {
                $filtros = $filtros." AND fecha_c LIKE '%".$filters->fecha_c."%'";
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
					$parramsfilter['nombre'] =  $this->_getSanitizedParam("nombre");
					$parramsfilter['tipo'] =  $this->_getSanitizedParam("tipo");
					$parramsfilter['valor'] =  $this->_getSanitizedParam("valor");
					$parramsfilter['cliente_id'] =  $this->_getSanitizedParam("cliente_id");
					$parramsfilter['estado'] =  $this->_getSanitizedParam("estado");Session::getInstance()->set($this->namefilter, $parramsfilter);
        }
        if ($this->_getSanitizedParam("cleanfilter") == 1) {
            Session::getInstance()->set($this->namefilter, '');
            Session::getInstance()->set($this->namepageactual,1);
        }
    }


	public function aprobarAction(){
		
		header('Content-Type:application/json');
		$this->setLayout('blanco');
		$id = $this->_getSanitizedParam("id");
		$caprueba = $this->_getSanitizedParam("caprueba");
		$cadmin = $this->_getSanitizedParam("cadmin");
		$r = $this->_getSanitizedParam("r");

		
		if($id!=""){
			$this->mainModel->editField($id,"estado",1);
			$this->mainModel->editField($id,"proyectos_caprueba", $caprueba);
			$this->mainModel->editField($id,"proyectos_cadmin", $cadmin);
			$hoy = date("Y-m-d H:i:s");
			$this->mainModel->editField($id,"fecha_aprobado",$hoy);

			$this->notificaAprobacion($id,'1'); // Con precio
			$this->notificaAprobacion($id,'0'); // Sin precio

			$respuesta["ok"] = "1";
		}
		
		echo json_encode($respuesta);
	}

	public function aprobar2Action(){
	
		$this->setLayout('blanco');
		$id = $this->_getSanitizedParam("id");
		$detalle = $this->_getSanitizedParam("detalle");
		$hoy = date("Y-m-d H:i:s");

		if($id!=""){	

			$this->mainModel->editField($id,"fecha_aprobado",$hoy);

			$this->notificaAprobacion($id,'1'); // Con precio
			$this->notificaAprobacion($id,'0'); // Sin precio

		}
		
		if ($detalle == 1) {
			header('Location: /page/sistema/');
		} else {
			header('Location: /page/proyectosd/');
		}
		
	}

	public function noaprobarAction(){
		$this->setLayout('blanco');
		$id = $this->_getSanitizedParam("id");
		$r = $this->_getSanitizedParam("r");
		$detalle = $this->_getSanitizedParam("detalle");
		$cliente = $this->_getSanitizedParam("cliente");
		if($id!=""){
			$this->mainModel->editField($id,"estado",2);
			$hoy = date("Y-m-d H:i:s");
			$this->mainModel->editField($id,"fecha_aprobado",$hoy);
		}

		$this->notificaNoAprobacion($id,'1'); // Con precio
		// $this->notificaNoAprobacion($id,'0'); // Sin precio
		if($detalle == 1){
			$url = "/page/proyectosd/?cliente=".$cliente."&detalle=1&cleanfilter=1&page=1";
		} else {
			if($r=="dashboard" or $r==""){
				$url = "/page/sistema/#proyectos";
			}
			if($r=="index"){
				$url = "/page/proyectos/index";
			}
		}
		

		header("Location:".$url);
	}

	public function dirigirAction() {

		$r = $this->_getSanitizedParam("r");
		$detalle = $this->_getSanitizedParam("detalle");
		$cliente = $this->_getSanitizedParam("cliente");

		if($detalle == 1){
			$url = "/page/proyectos/?cliente=".$cliente."&detalle=1&cleanfilter=1&page=1";
		} else {
			if($r=="dashboard" or $r==""){
				$url = "/page/sistema/#proyectos";
			}
			if($r=="index"){
				$url = "/page/proyectos/index";
			}
			if($r=="aprobacion"){
				$url = "/page/proyectosd/index";
			}
		}
		header("Location:".$url);
	}
	
	public function notificaAprobacion($id,$con){
		
		$info_proyecto = $this->mainModel->getById($id);
		
		$fecha_c = $info_proyecto->fecha_c;
		$nombre = $info_proyecto->nombre;
		$tipo = $info_proyecto->tipo;
		$valor = $info_proyecto->valor;
		$cliente_id = $info_proyecto->cliente_id;
		$estado = $info_proyecto->estado;
		$fecha_aprobado = $info_proyecto->fecha_aprobado;
		$proyectos_cadmin = $info_proyecto->proyectos_cadmin;
		$proyectos_caprueba = $info_proyecto->proyectos_caprueba;

		$data_info = array();
		$data_info["fecha_c"] = $fecha_c;
		$data_info["nombre"] = $nombre;
		$data_info["tipo"] = $tipo;
		$data_info["valor"] = $valor;
		$data_info["cliente_id"] = $cliente_id;
		$data_info["estado"] = $estado;
		$data_info["fecha_aprobado"] = $fecha_aprobado;
		$data_info["proyectos_cadmin"] = $proyectos_cadmin;
		$data_info["proyectos_caprueba"] = $proyectos_caprueba;
		
		$list_tipo = $this->getTipo();
		$name_tipo = $list_tipo[$tipo];

		$clienteModel = new Page_Model_DbTable_Clientes();
		$info_cliente = $clienteModel->getById($cliente_id);

		$decoded_string = html_entity_decode($nombre, ENT_QUOTES | ENT_HTML401, 'ISO-8859-1');
		$nombre_p = mb_convert_encoding($decoded_string, 'UTF-8', 'ISO-8859-1');

		$data_info["nombre_utf8"] = $nombre_p;
		$data_info["nombre_cliente"] = $info_cliente->nombre;
		$data_info["tipo_proyecto"] = $name_tipo;
		
		if ($con == 1){
			$data_info["agregar_valor"] = 1;
			$data_info["agregar_correo"] = 'info@omegawebsystems.com';
		} else {
			$data_info["agregar_valor"] = 0;
			$data_info["agregar_correo"] = 'proyectos@omegawebsystems.com';
		}


		$sendingemail = new Core_Model_Sendingemail($this->_view);
		$sendingemail->aprobacion($data_info);
	}

	public function notificaNoAprobacion($id,$con){
		
		$info_proyecto = $this->mainModel->getById($id);
		
		$fecha_c = $info_proyecto->fecha_c;
		$nombre = $info_proyecto->nombre;
		$tipo = $info_proyecto->tipo;
		$valor = $info_proyecto->valor;
		$cliente_id = $info_proyecto->cliente_id;
		$estado = $info_proyecto->estado;
		$fecha_aprobado = $info_proyecto->fecha_aprobado;

		$data_info = array();
		$data_info["fecha_c"] = $fecha_c;
		$data_info["nombre"] = $nombre;
		$data_info["tipo"] = $tipo;
		$data_info["valor"] = $valor;
		$data_info["cliente_id"] = $cliente_id;
		$data_info["estado"] = $estado;
		$data_info["fecha_aprobado"] = $fecha_aprobado;
		
		$list_tipo = $this->getTipo();
		$name_tipo = $list_tipo[$tipo];

		$clienteModel = new Page_Model_DbTable_Clientes();
		$info_cliente = $clienteModel->getById($cliente_id);

		$decoded_string = html_entity_decode($nombre, ENT_QUOTES | ENT_HTML401, 'ISO-8859-1');
		$nombre_p = mb_convert_encoding($decoded_string, 'UTF-8', 'ISO-8859-1');

		$data_info["nombre_utf8"] = $nombre_p;
		$data_info["nombre_cliente"] = $info_cliente->nombre;
		$data_info["tipo_proyecto"] = $name_tipo;
		
		if ($con == 1){
			$data_info["agregar_valor"] = 1;
			$data_info["agregar_correo"] = 'info@omegawebsystems.com';
		} else {
			$data_info["agregar_valor"] = 0;
			$data_info["agregar_correo"] = 'proyectos@omegawebsystems.com';
		}


		$sendingemail = new Core_Model_Sendingemail($this->_view);
		$sendingemail->noaprobacion($data_info);
	}

	public function notificarAction() {
		
		$cotizacion = $this->_getSanitizedParam("cotizacion");
		$info = $this->mainModel->getById($cotizacion);
		
        $consecutivo = $info->consecutivo;

		$data_info = array();
		$data_info["fecha_c"] = $info->fecha_c;
		$data_info["nombre"] = $info->nombre;
		$data_info["tipo"] = $info->tipo;
		$data_info["valor"] = $info->valor;
		$data_info["cliente_id"] = $info->cliente_id;
		$data_info["estado"] = $info->estado;
		$data_info["fecha_aprobado"] = $info->fecha_aprobado;
		$data_info["consecutivo"] = $consecutivo;
		$data_info["documento1"] = $info->documento1;
		$data_info["documento2"] = $info->documento2;
		$data_info["documento3"] = $info->documento3;
		
		$list_tipo = $this->getTipo();
		$name_tipo = $list_tipo[$info->tipo];

		$clienteModel = new Page_Model_DbTable_Clientes();
		$info_cliente = $clienteModel->getById($info->cliente_id);

		$decoded_string = html_entity_decode($info->nombre, ENT_QUOTES | ENT_HTML401, 'ISO-8859-1');
		$nombre_p = mb_convert_encoding($decoded_string, 'UTF-8', 'ISO-8859-1');

		$data_info["nombre_utf8"] = $nombre_p;
		$data_info["nombre_cliente"] = $info_cliente->nombre;
		$data_info["correo_cliente"] = $info_cliente->email;
		$data_info["tipo_proyecto"] = $name_tipo;

		$sendingemail = new Core_Model_Sendingemail($this->_view);
		$sendingemail->notificaCotizacion($data_info);

		header('Location: /page/proyectos/');

	}

	/* public function consecutivoAction() {
		$lista = $this->mainModel->getList("","");
		$i = 1;
		foreach ($lista as $valor) {
			$id = $valor->id;
			$ano = date("Y");
			$this->mainModel->editField($id,"consecutivo",$ano.$i);
			$i++;
		}
	} */

	

}