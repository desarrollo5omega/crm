<?php
/**
* Controlador de Solicitudes que permite la  creacion, edicion  y eliminacion de los solicitudes del Sistema
*/
class Administracion_solicitudesController extends Administracion_mainController
{
	public $botonpanel = 6;
	/**
	 * $mainModel  instancia del modelo de  base de datos solicitudes
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
	protected $_csrf_section = "administracion_solicitudes";

	/**
	 * $namepages nombre de la pvariable en la cual se va a guardar  el numero de seccion en la paginacion del controlador
	 * @var string
	 */
	protected $namepages;



	/**
     * Inicializa las variables principales del controlador solicitudes .
     *
     * @return void.
     */
	public function init()
	{
		$this->mainModel = new Administracion_Model_DbTable_Solicitudes();
		$this->namefilter = "parametersfiltersolicitudes";
		$this->route = "/administracion/solicitudes";
		$this->namepages ="pages_solicitudes";
		$this->namepageactual ="page_actual_solicitudes";
		$this->_view->route = $this->route;
		if(Session::getInstance()->get($this->namepages)){
			$this->pages = Session::getInstance()->get($this->namepages);
		} else {
			$this->pages = 20;
		}
		parent::init();
		$this->_view->validaciones = array("En estudio","Aprobado","Contabilizado","Anulado","Rechazado","Procesado");
	}


	/**
     * Recibe la informacion y  muestra un listado de  solicitudes con sus respectivos filtros.
     *
     * @return void.
     */
	public function indexAction()
	{

		$filtro = " AND solicitudes.paso = '8' AND solicitudes.asignado!='' ";

		if($_SESSION['kt_login_level']==3){ //analista
			$usuario = $_SESSION['kt_login_id'];
			if(($this->_getSanitizedParam('i')>=0 and $this->_getSanitizedParam('i')!="") or $this->_getSanitizedParam('incompletas')=="1" or $this->_getSanitizedParam('sin_terminar')=="1"){
				$filtro.= " AND solicitudes.asignado='$usuario' ";
			}
		}
		if($this->_getSanitizedParam('i')!=""){ //validacion
			$i = $this->_getSanitizedParam('i');
			$filtro.= "  AND solicitudes.validacion='$i' ";
		}
		if($this->_getSanitizedParam('incompletas')=="1"){
			$filtro = "  AND solicitudes.paso!='8' AND incompleta IS NOT NULL ";
		}
		if($this->_getSanitizedParam('sin_terminar')=="1"){
			$filtro = "  AND solicitudes.paso!='8' AND incompleta IS NULL ";
		}

		$title = "Administración de solicitudes";
		$this->getLayout()->setTitle($title);
		$this->_view->titlesection = $title;
		$this->filters();
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$filters =(object)Session::getInstance()->get($this->namefilter);
        $this->_view->filters = $filters;
		$filters = $this->getFilter();
		$filters .= $filtro;
		$order = " fecha_asignado DESC, fecha DESC ";
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
		$this->_view->list_asignado = $this->getAsignado();
		$this->_view->list_quien = $this->getQuien();
		$this->_view->list_estado_autorizo = $this->getEstadoautorizo();
		$this->_view->list_linea_desembolso = $this->getLineadesembolso();
	}

	/**
     * Genera la Informacion necesaria para editar o crear un  solicitud  y muestra su formulario
     *
     * @return void.
     */
	public function manageAction()
	{
		$this->_view->route = $this->route;
		$this->_csrf_section = "manage_solicitudes_".date("YmdHis");
		$this->_csrf->generateCode($this->_csrf_section);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$this->_view->list_destino = $this->getDestino();
		$this->_view->list_linea_desembolso = $this->getLineadesembolso();
		$this->_view->list_gestor_comercial = $this->getGestorcomercial();
		$this->_view->list_asignado = $this->getAsignado();
		$this->_view->list_quien = $this->getQuien();
		$this->_view->list_estado_autorizo = $this->getEstadoautorizo();
		$id = $this->_getSanitizedParam("id");
		if ($id > 0) {
			$content = $this->mainModel->getById($id);
			if($content->id){
				$this->_view->content = $content;
				$this->_view->routeform = $this->route."/update";
				$title = "Actualizar solicitud";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}else{
				$this->_view->routeform = $this->route."/insert";
				$title = "Crear solicitud";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}
		} else {
			$this->_view->routeform = $this->route."/insert";
			$title = "Crear solicitud";
			$this->getLayout()->setTitle($title);
			$this->_view->titlesection = $title;
		}
	}

	/**
     * Inserta la informacion de un solicitud  y redirecciona al listado de solicitudes.
     *
     * @return void.
     */
	public function insertAction(){
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf ) {	
			$data = $this->getData();
			$id = $this->mainModel->insert($data);
			
			$data['id']= $id;
			$data['log_log'] = print_r($data,true);
			$data['log_tipo'] = 'CREAR SOLICITUD';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);
		}
		header('Location: '.$this->route.''.'');
	}



	/**
     * Recibe un identificador  y Actualiza la informacion de un solicitud  y redirecciona al listado de solicitudes.
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
			$data['log_tipo'] = 'EDITAR SOLICITUD';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe un identificador  y elimina un solicitud  y redirecciona al listado de solicitudes.
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
					$data['log_tipo'] = 'BORRAR SOLICITUD';
					$logModel = new Administracion_Model_DbTable_Log();
					$logModel->insert($data); }
			}
		}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe la informacion del formulario y la retorna en forma de array para la edicion y creacion de Solicitudes.
     *
     * @return array con toda la informacion recibida del formulario.
     */
	private function getData()
	{
		$data = array();
		if($this->_getSanitizedParam("cedula") == '' ) {
			$data['cedula'] = '0';
		} else {
			$data['cedula'] = $this->_getSanitizedParam("cedula");
		}
		if($this->_getSanitizedParam("linea") == '' ) {
			$data['linea'] = '0';
		} else {
			$data['linea'] = $this->_getSanitizedParam("linea");
		}
		$data['destino'] = $this->_getSanitizedParam("destino");
		if($this->_getSanitizedParam("valor") == '' ) {
			$data['valor'] = '0';
		} else {
			$data['valor'] = $this->_getSanitizedParam("valor");
		}
		if($this->_getSanitizedParam("monto_solicitado") == '' ) {
			$data['monto_solicitado'] = '0';
		} else {
			$data['monto_solicitado'] = $this->_getSanitizedParam("monto_solicitado");
		}
		$data['valor_desembolso'] = $this->_getSanitizedParam("valor_desembolso");
		if($this->_getSanitizedParam("linea_desembolso") == '' ) {
			$data['linea_desembolso'] = '0';
		} else {
			$data['linea_desembolso'] = $this->_getSanitizedParam("linea_desembolso");
		}
		if($this->_getSanitizedParam("cuotas_desembolso") == '' ) {
			$data['cuotas_desembolso'] = '0';
		} else {
			$data['cuotas_desembolso'] = $this->_getSanitizedParam("cuotas_desembolso");
		}
		if($this->_getSanitizedParam("valor_cuota_desembolso") == '' ) {
			$data['valor_cuota_desembolso'] = '0';
		} else {
			$data['valor_cuota_desembolso'] = $this->_getSanitizedParam("valor_cuota_desembolso");
		}
		if($this->_getSanitizedParam("tasa_desembolso") == '' ) {
			$data['tasa_desembolso'] = '0';
		} else {
			$data['tasa_desembolso'] = $this->_getSanitizedParam("tasa_desembolso");
		}
		if($this->_getSanitizedParam("cuotas_extra_desembolso") == '' ) {
			$data['cuotas_extra_desembolso'] = '0';
		} else {
			$data['cuotas_extra_desembolso'] = $this->_getSanitizedParam("cuotas_extra_desembolso");
		}
		if($this->_getSanitizedParam("valor_extra_desembolso") == '' ) {
			$data['valor_extra_desembolso'] = '0';
		} else {
			$data['valor_extra_desembolso'] = $this->_getSanitizedParam("valor_extra_desembolso");
		}
		if($this->_getSanitizedParam("cuotas") == '' ) {
			$data['cuotas'] = '0';
		} else {
			$data['cuotas'] = $this->_getSanitizedParam("cuotas");
		}
		if($this->_getSanitizedParam("valor_cuota") == '' ) {
			$data['valor_cuota'] = '0';
		} else {
			$data['valor_cuota'] = $this->_getSanitizedParam("valor_cuota");
		}
		if($this->_getSanitizedParam("cuotas_extra") == '' ) {
			$data['cuotas_extra'] = '0';
		} else {
			$data['cuotas_extra'] = $this->_getSanitizedParam("cuotas_extra");
		}
		if($this->_getSanitizedParam("valor_extra") == '' ) {
			$data['valor_extra'] = '0';
		} else {
			$data['valor_extra'] = $this->_getSanitizedParam("valor_extra");
		}
		if($this->_getSanitizedParam("tasa") == '' ) {
			$data['tasa'] = '0';
		} else {
			$data['tasa'] = $this->_getSanitizedParam("tasa");
		}
		$data['fecha'] = $this->_getSanitizedParam("fecha");
		if($this->_getSanitizedParam("validacion") == '' ) {
			$data['validacion'] = '0';
		} else {
			$data['validacion'] = $this->_getSanitizedParam("validacion");
		}
		$data['radicacion'] = $this->_getSanitizedParam("radicacion");
		$data['paso'] = $this->_getSanitizedParam("paso")*1;
		$data['nombres'] = $this->_getSanitizedParam("nombres");
		$data['nombres2'] = $this->_getSanitizedParam("nombres2");
		$data['apellido1'] = $this->_getSanitizedParam("apellido1");
		$data['apellido2'] = $this->_getSanitizedParam("apellido2");
		$data['sexo'] = $this->_getSanitizedParam("sexo");
		$data['tipo_documento'] = $this->_getSanitizedParam("tipo_documento");
		$data['documento'] = $this->_getSanitizedParam("documento");
		$data['fecha_documento'] = $this->_getSanitizedParam("fecha_documento");
		$data['ciudad_documento'] = $this->_getSanitizedParam("ciudad_documento");
		$data['fecha_nacimiento'] = $this->_getSanitizedParam("fecha_nacimiento");
		$data['empresa'] = $this->_getSanitizedParam("empresa");
		$data['dependencia'] = $this->_getSanitizedParam("dependencia");
		$data['direccion_oficina'] = $this->_getSanitizedParam("direccion_oficina");
		$data['ciudad_oficina'] = $this->_getSanitizedParam("ciudad_oficina");
		$data['telefono_oficina'] = $this->_getSanitizedParam("telefono_oficina");
		$data['celular'] = $this->_getSanitizedParam("celular");
		$data['direccion_residencia'] = $this->_getSanitizedParam("direccion_residencia");
		$data['barrio'] = $this->_getSanitizedParam("barrio");
		$data['ciudad_residencia'] = $this->_getSanitizedParam("ciudad_residencia");
		$data['telefono'] = $this->_getSanitizedParam("telefono");
		$data['correo_empresarial'] = $this->_getSanitizedParam("correo_empresarial");
		$data['correo_personal'] = $this->_getSanitizedParam("correo_personal");
		$data['situacion_laboral'] = $this->_getSanitizedParam("situacion_laboral");
		$data['cual'] = $this->_getSanitizedParam("cual");
		$data['ocupacion'] = $this->_getSanitizedParam("ocupacion");
		$data['estado_civil'] = $this->_getSanitizedParam("estado_civil");
		$data['conyuge_nombre'] = $this->_getSanitizedParam("conyuge_nombre");
		$data['conyuge_telefono'] = $this->_getSanitizedParam("conyuge_telefono");
		$data['conyuge_celular'] = $this->_getSanitizedParam("conyuge_celular");
		$data['peso'] = $this->_getSanitizedParam("peso");
		$data['estatura'] = $this->_getSanitizedParam("estatura");
		$data['declara_renta'] = $this->_getSanitizedParam("declara_renta");
		$data['persona_publica'] = $this->_getSanitizedParam("persona_publica");
		$data['cuenta_numero'] = $this->_getSanitizedParam("cuenta_numero");
		$data['cuenta_tipo'] = $this->_getSanitizedParam("cuenta_tipo");
		$data['entidad_bancaria'] = $this->_getSanitizedParam("entidad_bancaria");
		$data['ingreso_mensual'] = $this->_getSanitizedParam("ingreso_mensual")*1;
		$data['otros_ingresos'] = $this->_getSanitizedParam("otros_ingresos")*1;
		$data['total_ingresos'] = $this->_getSanitizedParam("total_ingresos")*1;
		$data['canon_arrendamiento'] = $this->_getSanitizedParam("canon_arrendamiento")*1;
		$data['otros_gastos'] = $this->_getSanitizedParam("otros_gastos")*1;
		$data['total_egresos'] = $this->_getSanitizedParam("total_egresos")*1;
		$data['activos'] = $this->_getSanitizedParam("activos")*1;
		$data['pasivos'] = $this->_getSanitizedParam("pasivos")*1;
		$data['patrimonio'] = $this->_getSanitizedParam("patrimonio")*1;
		$data['descripcion_ingresos'] = $this->_getSanitizedParam("descripcion_ingresos");
		$data['descripcion_recursos'] = $this->_getSanitizedParam("descripcion_recursos");
		$data['tipo_garantia'] = $this->_getSanitizedParam("tipo_garantia");
		$data['FM_meses'] = $this->_getSanitizedParam("FM_meses")*1;
		$data['observaciones'] = $this->_getSanitizedParamHtml("observaciones");
		$data['observacion_analista'] = $this->_getSanitizedParamHtml("observacion_analista");
		$data['observacion_auxiliar'] = $this->_getSanitizedParamHtml("observacion_auxiliar");
		$data['observacion_riesgo'] = $this->_getSanitizedParamHtml("observacion_riesgo");
		$data['tramite'] = $this->_getSanitizedParam("tramite");
		$data['gestor_comercial'] = $this->_getSanitizedParam("gestor_comercial");
		if($this->_getSanitizedParam("asignado") == '' ) {
			$data['asignado'] = '0';
		} else {
			$data['asignado'] = $this->_getSanitizedParam("asignado");
		}
		$data['fecha_asignado'] = $this->_getSanitizedParam("fecha_asignado");
		$data['pagare'] = $this->_getSanitizedParam("pagare");
		if($this->_getSanitizedParam("quien") == '' ) {
			$data['quien'] = '0';
		} else {
			$data['quien'] = $this->_getSanitizedParam("quien");
		}
		$data['fecha_estado'] = '' ;
		$data['numero_obligacion'] = $this->_getSanitizedParam("numero_obligacion");
		$data['autorizo'] = $this->_getSanitizedParam("autorizo")*1;
		$data['fecha_autorizo'] = '' ;
		if($this->_getSanitizedParam("estado_autorizo") == '' ) {
			$data['estado_autorizo'] = '0';
		} else {
			$data['estado_autorizo'] = $this->_getSanitizedParam("estado_autorizo");
		}
		$data['incompleta'] = $this->_getSanitizedParam("incompleta");
		$data['fecha_anterior'] = $this->_getSanitizedParam("fecha_anterior");
		$data['asignado_anterior'] = $this->_getSanitizedParam("asignado_anterior")*1;
		return $data;
	}

	/**
     * Genera los valores del campo destino.
     *
     * @return array cadena con los valores del campo destino.
     */
	private function getDestino()
	{
		$array = array();
		$array['VIVIENDA NUEVA'] = 'VIVIENDA NUEVA';
		$array['VIVIENDA NUEVA'] = 'VIVIENDA NUEVA';
		$array['MEJORA VIVIENDA'] = 'MEJORA VIVIENDA';
		$array['TIQUETES'] = 'TIQUETES';
		$array['OTROS DESTINOS'] = 'OTROS DESTINOS';
		return $array;
	}


	/**
     * Genera los valores del campo linea_desembolso.
     *
     * @return array cadena con los valores del campo linea_desembolso.
     */
	private function getLineadesembolso()
	{
		$array = array();
		$lineaModel = new Administracion_Model_DbTable_Lineas();
		$list = $lineaModel->getList(" activo='1' "," nombre ASC ");
		foreach ($list as $key => $value) {
			$array[$value->id] = $value->nombre;
		}
		return $array;
	}


	/**
     * Genera los valores del campo gestor_comercial.
     *
     * @return array cadena con los valores del campo gestor_comercial.
     */
	private function getGestorcomercial()
	{
		$array = array();
		$lineaModel = new Administracion_Model_DbTable_Gestores();
		$list = $lineaModel->getList(""," nombre ASC ");
		foreach ($list as $key => $value) {
			$array[$value->id] = $value->nombre;
		}
		return $array;
	}


	/**
     * Genera los valores del campo asignado.
     *
     * @return array cadena con los valores del campo asignado.
     */
	private function getAsignado()
	{
		$array = array();
		$lineaModel = new Administracion_Model_DbTable_Usuario();
		$list = $lineaModel->getList(" user_level='3' "," user_names ASC ");
		foreach ($list as $key => $value) {
			$array[$value->user_id] = $value->user_names;
		}
		return $array;
	}


	/**
     * Genera los valores del campo quien.
     *
     * @return array cadena con los valores del campo quien.
     */
	private function getQuien()
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
     * Genera los valores del campo estado_autorizo.
     *
     * @return array cadena con los valores del campo estado_autorizo.
     */
	private function getEstadoautorizo()
	{
		$array = array();
		$array['0'] = 'Pendiente';
		$array['1'] = 'Aprobado';
		$array['4'] = 'Rechazado';
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
        if (Session::getInstance()->get($this->namefilter)!="") {
            $filters =(object)Session::getInstance()->get($this->namefilter);
            if ($filters->cedula != '') {
                $filtros = $filtros." AND cedula LIKE '%".$filters->cedula."%'";
            }
            if ($filters->linea != '') {
                $filtros = $filtros." AND linea LIKE '%".$filters->linea."%'";
            }
            if ($filters->validacion != '') {
                $filtros = $filtros." AND validacion LIKE '%".$filters->validacion."%'";
            }
            if ($filters->nombres != '') {
                $filtros = $filtros." AND nombres LIKE '%".$filters->nombres."%'";
            }
            if ($filters->apellido1 != '') {
                $filtros = $filtros." AND apellido1 LIKE '%".$filters->apellido1."%'";
            }
            if ($filters->apellido2 != '') {
                $filtros = $filtros." AND apellido2 LIKE '%".$filters->apellido2."%'";
            }
            if ($filters->asignado != '') {
                $filtros = $filtros." AND asignado ='".$filters->asignado."'";
            }
            if ($filters->fecha_asignado != '') {
                $filtros = $filtros." AND fecha_asignado LIKE '%".$filters->fecha_asignado."%'";
            }
            if ($filters->pagare != '') {
                $filtros = $filtros." AND pagare LIKE '%".$filters->pagare."%'";
            }
            if ($filters->quien != '') {
                $filtros = $filtros." AND quien ='".$filters->quien."'";
            }
            if ($filters->estado_autorizo != '') {
                $filtros = $filtros." AND estado_autorizo ='".$filters->estado_autorizo."'";
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
					$parramsfilter['cedula'] =  $this->_getSanitizedParam("cedula");
					$parramsfilter['linea'] =  $this->_getSanitizedParam("linea");
					$parramsfilter['validacion'] =  $this->_getSanitizedParam("validacion");
					$parramsfilter['nombres'] =  $this->_getSanitizedParam("nombres");
					$parramsfilter['apellido1'] =  $this->_getSanitizedParam("apellido1");
					$parramsfilter['apellido2'] =  $this->_getSanitizedParam("apellido2");
					$parramsfilter['asignado'] =  $this->_getSanitizedParam("asignado");
					$parramsfilter['fecha_asignado'] =  $this->_getSanitizedParam("fecha_asignado");
					$parramsfilter['pagare'] =  $this->_getSanitizedParam("pagare");
					$parramsfilter['quien'] =  $this->_getSanitizedParam("quien");
					$parramsfilter['estado_autorizo'] =  $this->_getSanitizedParam("estado_autorizo");Session::getInstance()->set($this->namefilter, $parramsfilter);
        }
        if ($this->_getSanitizedParam("cleanfilter") == 1) {
            Session::getInstance()->set($this->namefilter, '');
            Session::getInstance()->set($this->namepageactual,1);
        }
    }



	public function detalleAction(){
		$this->_view->route = $this->route;
		$this->_csrf_section = "manage_solicitudes_".date("YmdHis");
		$this->_csrf->generateCode($this->_csrf_section);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
	}

	public function incompletaAction(){

		$title = "Solicitud incompleta";
		$this->getLayout()->setTitle($title);
		$this->_view->titlesection = $title;

	}

	public function guardarincompletaAction(){
		$id = $this->_getSanitizedParam("id");
		$incompleta = $this->_getSanitizedParam("incompleta");
		$solicitudModel = new Administracion_Model_DbTable_Solicitudes();
		$solicitud = $solicitudModel->getById($id);

		$motivo = $solicitud->incompleta;
		$asignado_anterior = $solicitud->asignado;
		$fecha_anterior = $solicitud->fecha_anterior;
		$linea_id = $solicitud->linea;
		$cedula = $solicitud->cedula;
		$asignado = $solicitud->asignado;
		$gestor_comercial = $solicitud->gestor_comercial;

		$lineaModel = new Administracion_Model_DbTable_Lineas();
		$linea = $lineaModel->getById($linea_id);

		$usuarioModel = new Administracion_Model_DbTable_Usuario();
		$usuario = $usuarioModel->getList(" user_user='$cedula' ","")[0];
		$analista = $usuarioModel->getById($asignado);

		$gestorModel = new Administracion_Model_DbTable_Gestores();
		$gestorcomercial = $gestorModel->getList(" nombre='$gestor_comercial' ","")[0];

		$correo_gestor = $gestorcomercial->email;
		$correo_codeudor = "";

		if($solicitud->tipo_garantia=="DEUDOR SOLIDARIO"){
			$codeudorModel = new Administracion_Model_DbTable_Codeudor();
			$codeudor = $codeudorModel->getList(" solicitud='$id' ","")[0];

			$correo_codeudor = $codeudor->correo;
			$correo_codeudor2 = $codeudor->correo_empresarial;
		}

		$correo_personal = $solicitud->correo_personal;
		$correo_empresarial = $solicitud->correo_empresarial;


		if($id!=""){

			$paso = 5;
			if($solicitud->peso==""){
				$paso=1;
			}

			$solicitudModel->editField($id,"incompleta",$incompleta);
			$solicitudModel->editField($id,"paso",$paso);
			$solicitudModel->editField($id,"asignado",0);

			if($fecha_anterior==""){
				$fecha_anterior = $solicitud->fecha_asignado;
				$solicitudModel->editField($id,"fecha_anterior",$fecha_anterior);
				$solicitudModel->editField($id,"asignado_anterior",$asignado_anterior);
			}
		}

		$numero = con_ceros($id);
		$correo = $usuario->correo;
		$correo1 = $analista->correo;

		$contenido = '
			<table width="100%" border="0" cellspacing="0" cellpadding="3">
			  <tr>
			    <td colspan="2"><div align="center">
			    <h2 align="left">Resumen solicitud</strong></h2></td>
			  </tr>
			  <tr>
			    <td><strong>Solicitud</strong></td>
			    <td>WEB'.$numero.'</td>
			  </tr>
			  <tr>
			    <td><strong>Documento</strong></td>
			    <td>'.$usuario->usuario.'</td>
			  </tr>
			  <tr>
			    <td><strong>Nombre</strong></td>
			    <td>'.$usuario->nombre.'</td>
			  </tr>
			  <tr>
			    <td><strong>Email</strong></td>
			    <td>'.$usuario->correo.'</td>
			  </tr>
			  <tr>
			    <td><strong>Celular</strong></td>
			    <td>'.$usuario->celular.'</td>
			  </tr>
			  <tr>
			    <td><strong>Tel&eacute;fono</strong></td>
			    <td>'.$usuario->telefono.'</td>
			  </tr>
			  <tr>
			    <td><strong>L&iacute;nea de cr&eacute;dito</strong></td>
			    <td>'.$linea->codigo.' - '.$linea->nombre.'&nbsp;</td>
			  </tr>';

			  if($solicitud->destino!=""){
				$contenido .= '
						  <tr>
						    <td><strong>Destino</strong></td>
						    <td>'.$solicitud->destino.'</td>
						  </tr>';
			  }

		$contenido .= '
			  <tr>
			    <td><strong>Valor solicitado</strong></td>
			    <td>'.formato_pesos($solicitud->valor).'</td>
			  </tr>
			  <tr>
			    <td><strong>Monto unificado</strong></td>
			    <td>'.formato_pesos($solicitud->monto_solicitado).'</td>
			  </tr>
			  <tr>
			    <td><strong>N&uacute;mero de Cuotas</strong></td>
			    <td>'.$solicitud->cuotas.'</td>
			  </tr>
			  <tr>
			    <td><strong>Valor aproximado de cuota</strong></td>
			    <td>'.formato_pesos($solicitud->valor_cuota).'</td>
			  </tr>
			  <tr>
			    <td><strong>Tasa de interes</strong></td>
			    <td>'.$solicitud->tasa.'%</td>
			  </tr>
			  <tr>
			    <td><strong>Cuotas extra</strong></td>
			    <td>'.$solicitud->cuotas_extra.'</td>
			  </tr>
			  <tr>
			    <td><strong>Valor cuota extra</strong></td>
			    <td>'.formato_pesos($solicitud->valor_extra).'</td>
			  </tr>
			  <tr>
			    <td><strong>Fecha solicitud</strong></td>
			    <td>'.$solicitud->fecha_asignado.'</td>
			  </tr>';

			  if($solicitud->fecha_anterior!=""){
		$contenido .= '
			  <tr>
			    <td><strong>Fecha solicitud anterior incompleta</strong></td>
			    <td>'.$solicitud->fecha_anterior.'</td>
			  </tr>';
			  }

		$contenido .= '
			  <tr>
			    <td><strong>Tramite</strong></td>
			    <td>'.$solicitud->tramite.'</td>
			  </tr>
			  <tr>
			    <td><strong>Gestor Comercial</strong></td>
			    <td>'.$solicitud->gestor_comercial.'</td>
			  </tr>
			  <tr>
			    <td><strong>Analista asignado</strong></td>
			    <td>'.$analista->nombre.'</td>
			  </tr>
			  <tr>
			    <td><strong>Email</strong></td>
			    <td>'.$analista->correo.'</td>
			  </tr>
			  <tr>
			    <td><strong>Tel&eacute;fono</strong></td>
			    <td>'.$analista->telefono.'</td>
			  </tr>
			  <tr>
			    <td><strong>Celular del analista</strong></td>
			    <td>'.$analista->celular.'</td>
			  </tr>
			</table>';


		$mensaje = "La solicitud WEB".$numero." esta incompleta.<br /><br />Motivo: ".$motivo."<br /><br />Puede revisar su solicitud en el botón <strong>Mis solicitudes</strong> y enviarla nuevamente despues de realizar la corrección.
		<br /><br />".$contenido;
		$asunto = "Solicitud de crédito ".$numero." incompleta ";
		$content = $mensaje;

		$emailModel = new Core_Model_Mail();
        $emailModel->getMail()->setFrom("notificaciones@fondtodos.com", "Notificaciones Sistema Solicitud de créditos");
        $emailModel->getMail()->addBCC("soporteomega@omegawebsystems.com");
		$emailModel->getMail()->addAddress("".$email);

        $emailModel->getMail()->Subject = $asunto;
        $emailModel->getMail()->msgHTML($content);
        $emailModel->getMail()->AltBody = $content;
        $emailModel->sed();
		$this->_view->error = $emailModel->getMail()->ErrorInfo;

	}

}