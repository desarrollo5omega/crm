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
		$this->_view->validaciones = array("En estudio","Aprobado","Desembolsado","Anulado","Rechazado","Procesado","Aplazado");
	}


	/**
     * Recibe la informacion y  muestra un listado de  solicitudes con sus respectivos filtros.
     *
     * @return void.
     */
	public function indexAction()
	{

		$filtro = " AND solicitudes.paso = '8' AND solicitudes.asignado!='' ";

		if($_SESSION['kt_login_level']==3 or $_SESSION['kt_login_level']==12){ //analista
			$usuario = $_SESSION['kt_login_id'];
			if(($this->_getSanitizedParam('i')>=0 and $this->_getSanitizedParam('i')!="") or $this->_getSanitizedParam('incompletas')=="1" or $this->_getSanitizedParam('sin_terminar')=="1"){
				if($this->_getSanitizedParam('i')==0){
					$filtro.= " AND solicitudes.asignado='$usuario' ";
				}
			}
		}
		if($this->_getSanitizedParam('i')!=""){ //validacion
			$i = $this->_getSanitizedParam('i');
			if($i!="4"){
				$filtro.= "  AND solicitudes.validacion='$i' ";
			}
			if($i=="4"){
				$filtro .= " AND (solicitudes.validacion='$i' OR solicitudes.estado_autorizo='4') ";
			}
			if($i=="0"){
				$filtro .= " AND (solicitudes.estado_autorizo!='4' OR solicitudes.estado_autorizo IS NULL) ";
			}
		}
		if($this->_getSanitizedParam('incompletas')=="1"){
			$filtro = "  AND solicitudes.paso!='8' AND incompleta IS NOT NULL ";
		}
		if($this->_getSanitizedParam('sin_terminar')=="1"){
			$filtro = "  AND solicitudes.paso!='8' AND incompleta IS NULL ";
		}

		if($_GET['prueba']=="1"){
			echo $filtro;
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
		//echo $filters;
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

	public function agregarcreditosAction()
	{

		$id = $this->_getSanitizedParam('id');
		$this->_view->id = $id;

		$this->_view->route = "/administracion/solicitudes/agregarcreditos";
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

		$title = "Agregar solicitudes al acta No. ".$id;
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

		$actascomiteitemsModel = new Administracion_Model_DbTable_Actascomiteitems();
		$items = $actascomiteitemsModel->getList(" aci_acta_id='$id' ","");
		foreach ($items as $key => $value) {
			$solicitud_id = $value->aci_solicitud_id;
			$value->solicitud = $this->mainModel->getById($solicitud_id);
		}
		$this->_view->items = $items;
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


		$lineaModel = new Administracion_Model_DbTable_Lineas();
		$this->_view->lineas = $lineaModel->getList(""," codigo*1 ASC ");

		$validaciones = array("En estudio","Aprobado","Contabilizado","Anulado","Rechazado","Procesado");
		$this->_view->validaciones = $validaciones;


		$nomenclaturaModel = new Administracion_Model_DbTable_Nomenclatura();
		$this->_view->nomenclaturas = $nomenclaturas = $nomenclaturaModel->getList(""," codigo ASC ");

		$ciudadModel = new Administracion_Model_DbTable_Ciudad();
		$this->_view->ciudades = $ciudadModel->getList(""," nombre ASC ");


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
		$data['frecuencia'] = $this->_getSanitizedParam("frecuencia");
		$data['capacidad_endeudamiento'] = $this->_getSanitizedParam("capacidad_endeudamiento");
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
			$array[$value->codigo] = $value->nombre;
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
		$list = $lineaModel->getList(" user_level='3' OR user_level='12' "," user_names ASC ");
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
		$array['1'] = 'Revisado';
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
			$parramsfilter['estado_autorizo'] =  $this->_getSanitizedParam("estado_autorizo");
			Session::getInstance()->set($this->namefilter, $parramsfilter);
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

		$id = $this->_getSanitizedParam("id");
		$solicitudModel = new Administracion_Model_DbTable_Solicitudes();
		$solicitud = $solicitudModel->getById($id);
		$this->_view->solicitud = $solicitud;
		if($solicitud->tipo_garantia==3){
			$afianzafondosModel = new Administracion_Model_DbTable_Archivosafianzafondos();
			$this->_view->afianzafondos = $afianzafondosModel->getList("solicitud=$id","")[0];
		}
		$codeudorModel = new Administracion_Model_DbTable_Codeudor();
		$this->_view->codeudor2 = $codeudorModel->getList(" solicitud='$id' AND codeudor_numero='2' ","")[0];

		$documentosadicionalesModel = new Administracion_Model_DbTable_Documentosadicionales();
		$this->_view->adicionales = $documentosadicionalesModel->getList(" solicitud='$id' ","");

	}

	public function incompletaAction(){

		$title = "Solicitud incompleta";
		$this->getLayout()->setTitle($title);
		$this->_view->titlesection = $title;

	}

	public function guardarincompletaAction(){
		$id = $this->_getSanitizedParam("id");
		$texto_incompleta = $this->_getSanitizedParamHtml("mensaje");
		$estado = $this->_getSanitizedParam("estado");
		$solicitudModel = new Administracion_Model_DbTable_Solicitudes();
		$solicitud = $solicitudModel->getById($id);

		if($estado=="4"){
			$solicitudModel->editField($id,"estado_autorizo","4");
		}

		$motivo = $texto_incompleta;
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

		if($solicitud->tipo_garantia=="2"){
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

			$solicitudModel->editField($id,"incompleta",$texto_incompleta);
			//$solicitudModel->editField($id,"paso",$paso);
			//$solicitudModel->editField($id,"asignado",0);

			if($fecha_anterior==""){
				$fecha_anterior = $solicitud->fecha_asignado;
				$solicitudModel->editField($id,"fecha_anterior",$fecha_anterior);
				$solicitudModel->editField($id,"asignado_anterior",$asignado_anterior);
			}
		}

		$numero = con_ceros($id);
		$correo1 = $analista->user_email;

		$linea = $solicitud->linea_desembolso;
		$lineaModel = new Administracion_Model_DbTable_Lineas();
		$lineas = $lineaModel->getList(" codigo='$linea' ","")[0];

		$tabla = $this->generartabla($numero,$usuario,$solicitud,$lineas,$analista);
		$contenido = $tabla;

		/*
		$mensaje = "
		<br>
		La solicitud WEB".$numero." esta incompleta.<br /><br />Motivo: ".$motivo."<br /><br />Puede revisar su solicitud en el botón <strong>Mis solicitudes</strong> y enviarla nuevamente despues de realizar la corrección.
		<br /><br />".$contenido;
		*/

		$mensaje = "
		<br>
		Estimado(a) Asociado(a), la solicitud WEB".$numero." esta incompleta.<br /><br /><b>Motivo: </b>".$motivo."<br /><br />
		<br /><br />".$contenido;
		$asunto = "Solicitud de crédito ".$numero." incompleta";

		if($estado=="4"){
			$mensaje = "
			<br>
			Estimado(a) Asociado(a), la solicitud WEB".$numero." fue rechazada.<br /><br /><b>Motivo: </b>".$motivo."<br /><br />
			<br /><br />".$contenido;
			$asunto = "Solicitud de crédito ".$numero." rechazada";
		}

		$content = $mensaje;

		$emailModel = new Core_Model_Mail();
        $emailModel->getMail()->setFrom("notificaciones@fondtodos.com", "Notificaciones Sistema Solicitud de créditos");
        $emailModel->getMail()->addBCC("desarrollo2@omegawebsystems.com");
    $emailModel->getMail()->addBCC("notificaciones@fondtodos.com");
        if($correo_empresarial!=""){
        	$emailModel->getMail()->addAddress("".$correo_empresarial);
        }
        if($correo_personal!=""){
        	$emailModel->getMail()->addAddress("".$correo_personal);
        }
		if($correo1!=""){
			$emailModel->getMail()->addCC("".$correo1);
			$emailModel->getMail()->AddReplyTo("".$correo1);
		}

		//$emailModel->getMail()->addCC("servicio.asociado@fendesa.com");

        $emailModel->getMail()->Subject = $asunto;
        $emailModel->getMail()->msgHTML($content);
        $emailModel->getMail()->AltBody = $content;
        $emailModel->sed();
		$this->_view->error = $emailModel->getMail()->ErrorInfo;

	}

	function formato_pesos($x){
		$res = number_format($x,0,',','.');
		return $res;
	}

	function enviaracomiteAction(){

		$solicitudModel = new Administracion_Model_DbTable_Solicitudes();
		$id = $this->_getSanitizedParam("id");
		$this->_view->id = $id;
		$this->_view->numero = $numero = str_pad($id,6,"0",STR_PAD_LEFT);
		$solicitud = $solicitudModel->getById($id);

		$emailModel = new Core_Model_Mail();
		$asunto = " Solicitud aprobación comité de crédito WEB".$numero."";
		$content = "<br>Estimado(a) usuario. la solicitud de crédito WEB".$numero." requiere de su aprobación: ";

		$solicitudModel = new Administracion_Model_DbTable_Solicitudes();
		$solicitud = $solicitudModel->getById($id);

		$linea = $solicitud->linea_desembolso;
		$lineaModel = new Administracion_Model_DbTable_Lineas();
		$lineas = $lineaModel->getList(" codigo='$linea' ","")[0];

		$usuarioModel = new Administracion_Model_DbTable_Usuario();
		$cedula = $solicitud->cedula;
		$usuario = $usuarioModel->getList(" user_user = '$cedula' ","")[0];

		$analista_id = $solicitud->asignado;
		$analista = $usuarioModel->getById($analista_id);

		$gestor_comercial1 = $solicitud->gestor_comercial;
		$gestor_comercial = $usuarioModel->getList(" nombre = 'gestor_comercial' ","")[0];


		$tabla = $this->generartabla($numero,$usuario,$solicitud,$lineas,$analista);

		$content.= $tabla;


		$userModel = new Administracion_Model_DbTable_Usuario();
		$aprobadores = $userModel->getList(" user_level='4' ","");
		foreach ($aprobadores as $key => $value) {
			$email = $value->user_email;
			$user_id = $value->user_id;
			$codificado = base64_encode($user_id);
			$codificado = str_replace("=","_", $codificado);

	        //envio
			$content1 = $content."<br><br><br>Por favor utilice el siguiente enlace para indicar su aprobación: <a href='https://creditosfondtodos.com.co/page/comite/?id=".$id."&e=".$codificado."'><button type='button' class='btn btn-primary' style='background:#0084C9; color:#FFFFFF; padding:5px 10px;'>Ingresar</button></a>";

			$emailModel->getMail()->ClearAllRecipients();
	        $emailModel->getMail()->setFrom("notificaciones@fondtodos.com", "Notificaciones Sistema Solicitud de créditos");
	        $emailModel->getMail()->addBCC("desarrollo2@omegawebsystems.com");
    $emailModel->getMail()->addBCC("notificaciones@fondtodos.com");
			$emailModel->getMail()->addAddress("".$email);

	        $emailModel->getMail()->Subject = $asunto;
	        $emailModel->getMail()->msgHTML($content1);
	        $emailModel->getMail()->AltBody = $content;
	        $emailModel->sed();
	        //envio
        }

        header("Location:/administracion/solicitudes/comiteenviado/");

	}



	function comiteenviadoAction(){

	}

	function formatocomiteAction(){
		$id = $this->_getSanitizedParam("id");
		$this->_view->numero = $numero = str_pad($id,6,"0",STR_PAD_LEFT);
		$this->_view->id = $id;

		$solicitudModel = new Administracion_Model_DbTable_Solicitudes();
		$solicitud = $solicitudModel->getById($id);
		$this->_view->solicitud = $solicitud;

		$userModel = new Administracion_Model_DbTable_Usuario();

		$comiteModel = new Administracion_Model_DbTable_Comite();
		$comites = $comiteModel->getList(" comite_solicitud_id='$id' AND comite_tipo='1' ","");
		foreach ($comites as $key => $value) {
			$user_id = $value->comite_user_id;
			$aprobador = $userModel->getById($user_id);
			$value->user_names = $aprobador->user_names;
		}

		$this->_view->comites = $comites;

		//tabla
		$cedula = $solicitud->cedula;
		$usuarioModel = new Administracion_Model_DbTable_Usuario();
		$usuario = $usuarioModel->getList(" user_user='$cedula' ","")[0];
		$linea = $solicitud->linea_desembolso;
		$lineaModel = new Administracion_Model_DbTable_Lineas();
		$lineas = $lineaModel->getList(" codigo='$linea' ","")[0];
		$asignado = $solicitud->asignado;
		$analista = $usuarioModel->getById($asignado);
		$tabla = $this->generartabla($numero,$usuario,$solicitud,$lineas,$analista);
		$tabla = str_replace('style="max-width:900px;"','style="max-width:100%; background:#FFFFFF;"',$tabla);
		$this->_view->tabla = $tabla;
		$tabla2 = html_entity_decode($tabla);

		$excel = $this->_getSanitizedParam("excel");
		if($excel==1){
			$this->setLayout('blanco');
			$hoy = date("YmdHis");
			header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
			header("Content-type:   application/x-msexcel; charset=utf-8");
			header("Content-Disposition: attachment; filename=formato_comite_ordinario_".$id.".xls");
		}

		$pdf = $this->_getSanitizedParam("pdf");
		if($pdf==1){
			$this->setLayout("blanco");
			$titulo = "FORMATO DE APROBACIÓN COMITÉ ORDINARIO";
			$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'ISO-8859-1', false);
			$pdf->SetHeaderData('Logo.png', 30,$codigo,$titulo);
			$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$pdf->setPrintFooter(false);

			// set default monospaced font
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

			// set margins
			$pdf->SetMargins(PDF_MARGIN_LEFT, 40, PDF_MARGIN_RIGHT);
			$pdf->SetHeaderMargin(10);

			// set auto page breaks
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

			// set image scale factor
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

			// set some language-dependent strings (optional)
			if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
				require_once(dirname(__FILE__).'/lang/eng.php');
				$pdf->setLanguageArray($l);
			}

			//$pdf->SetProtection(array('print', 'copy'), '', null, 0, null);

			$fecha = $this->_view->comites[0]->comite_fecha;
			$fecha = substr($fecha,0,10);

			//$pdf->AddPage();
			$pdf->AddPage('L', 'A4');
			$pdf->SetFont('dejavusans', '',8, '', true);

			$tabla = '
			<table width="100%" cellpadding="3" cellspacing="0" border="0">
				<tr>
					<td colspan="7">
						Fecha: '.$fecha.'
					</td>
				</tr>
			</table>


			<div class="col-12">
				<table width="100%" cellpadding="3" cellspacing="0" border="1">
					<tr bgcolor="#CCCCCC">
						<th>APROBADOR</th>
						<th colspan="3">APROBO</th>
						<th>OBSERVACIONES</th>
						<th>FECHA</th>
						<th>FIRMA</th>
					</tr>
					<tr bgcolor="#CCCCCC">
						<th></th>
						<th><div align="center">SI</div></th>
						<th><div align="center">NO</div></th>
						<th><div align="center">APL</div></th>
						<th></th>
						<th></th>
						<th></th>
					</tr>';

			foreach ($comites as $key => $comite){
				$aprobacion1='';
				if($comite->comite_aprobacion=="1"){
					$aprobacion1='<b>X</b>';
				}
				$aprobacion2='';
				if($comite->comite_aprobacion=="2"){
					$aprobacion2='<b>X</b>';
				}
				$aprobacion3='';
				if($comite->comite_aprobacion=="3"){
					$aprobacion3='<b>X</b>';
				}
				$tabla.='
						<tr>
							<td>'.html_entity_decode($comite->user_names).'</td>
							<td align="center">'.$aprobacion1.'</td>
							<td align="center">'.$aprobacion2.'</td>
							<td align="center">'.$aprobacion3.'</td>
							<td>'.html_entity_decode($comite->comite_observacion).'</td>
							<td>'.$comite->comite_fecha.'</td>
							<td>'.$comite->firma.'</td>
						</tr>';
			}
			$tabla.='
					<tr>
						<td colspan="7">
							<div style="font-size: 11px;">Nota: A partir de la fecha para la aprobación de la solicitud de crédito es requisito NECESARIO NO estar reportado en la centrales de riesgo con cartera morosa de más de 90 dias y NO tener cartera castigada, salvo que se adjunten los respectivos paz y salvos expedidos por las entidades que generaron el reporte, con una antigüedad no mayor a 30 dias.</div>
						</td>
					</tr>
				</table>
			</div>
			';

			$tabla.='


				<div class="col-12"><br></div>
				<div class="col-12">
					<h5>Información Bancaria (Para desembolso)</h5>
					<table width="100%" cellpadding="3" cellspacing="0" border="1" bgcolor="#FFFFFF">
						<tr>
							<td><div align="center"><b>Cuenta Bancaria No</b></div></td>
							<td><div align="center"><b>Tipo de cuenta</b></div></td>
							<td><div align="center"><b>Entidad bancaria</b></div></td>
						</tr>
						<tr>
							<td><div align="center">'.$solicitud->cuenta_numero.'</div></td>
							<td><div align="center">'.$solicitud->cuenta_tipo.'</div></td>
							<td><div align="center">'.$solicitud->entidad_bancaria.'</div></td>
						</tr>
					</table>
				</div>


			';

			$tabla .= $tabla2;

			if($solicitud->observaciones!=""){
				$observacion1 = $solicitud->observaciones;
			} else {
				$observacion1 = 'Ninguna';
			}
			if($solicitud->observacion_analista!=""){
				$observacion2 = $solicitud->observacion_analista;
			} else {
				$observacion2 = 'Ninguna';
			}

			$observacion1 = html_entity_decode($observacion1);

			$tabla.='
				<div class="col-12">
					<br>
					<b>Observación del asociado</b>
					'.$observacion1.'
				</div>
				<div class="col-12">
					<b>Observación del analista</b>
					'.$observacion2.'
				</div>
			';

			$pdf->writeHTMLCell(0, 0, '', '', $tabla, 0, 1, 0, true, '', true);
			$pdf->Output('reporte.pdf', 'I');
		}

	}

	function enviaracomiteespecialAction(){

		$solicitudModel = new Administracion_Model_DbTable_Solicitudes();
		$id = $this->_getSanitizedParam("id");
		$this->_view->id = $id;
		$this->_view->numero = $numero = str_pad($id,6,"0",STR_PAD_LEFT);
		$solicitud = $solicitudModel->getById($id);

		$emailModel = new Core_Model_Mail();
		$asunto = " Solicitud aprobación Junta Directiva WEB".$numero."";
		$content = "<br>Estimado(a) usuario. la solicitud de crédito WEB".$numero." requiere de su aprobación: ";

		$solicitudModel = new Administracion_Model_DbTable_Solicitudes();
		$solicitud = $solicitudModel->getById($id);

		$linea = $solicitud->linea_desembolso;
		$lineaModel = new Administracion_Model_DbTable_Lineas();
		$lineas = $lineaModel->getList(" codigo='$linea' ","")[0];

		$usuarioModel = new Administracion_Model_DbTable_Usuario();
		$cedula = $solicitud->cedula;
		$usuario = $usuarioModel->getList(" user_user = '$cedula' ","")[0];

		$analista_id = $solicitud->asignado;
		$analista = $usuarioModel->getById($analista_id);

		$gestor_comercial1 = $solicitud->gestor_comercial;
		$gestor_comercial = $usuarioModel->getList(" nombre = 'gestor_comercial' ","")[0];


		$tabla = $this->generartabla($numero,$usuario,$solicitud,$lineas,$analista);

		$content.= $tabla;


		$userModel = new Administracion_Model_DbTable_Usuario();
		$aprobadores = $userModel->getList(" user_level='9' ","");
		foreach ($aprobadores as $key => $value) {
			$email = $value->user_email;
			$user_id = $value->user_id;
			$codificado = base64_encode($user_id);
			$codificado = str_replace("=","_", $codificado);

	        //envio
			$content1 = $content."<br><br><br>Por favor utilice el siguiente enlace para indicar su aprobación: <a href='https://creditosfondtodos.com.co/page/comiteespecial/?id=".$id."&e=".$codificado."'><button type='button' class='btn btn-primary' style='background:#0084C9; color:#FFFFFF; padding:5px 10px;'>Ingresar</button></a>";

			$emailModel->getMail()->ClearAllRecipients();
	        $emailModel->getMail()->setFrom("notificaciones@fondtodos.com", "Notificaciones FONDTODOS");
	        $emailModel->getMail()->addBCC("desarrollo2@omegawebsystems.com");
    $emailModel->getMail()->addBCC("notificaciones@fondtodos.com");
			$emailModel->getMail()->addAddress("".$email);

	        $emailModel->getMail()->Subject = $asunto;
	        $emailModel->getMail()->msgHTML($content1);
	        $emailModel->getMail()->AltBody = $content;
	       if( $emailModel->sed()==true){
			   echo "envio";
			   header("Location:/administracion/solicitudes/comiteespecialenviado/");
		   }else{
			
			   echo "no envio";
		   }
	        //envio
        }

       

	}



	function comiteespecialenviadoAction(){

	}

	function formatocomiteespecialAction(){
		$id = $this->_getSanitizedParam("id");
		$this->_view->numero  = $numero = str_pad($id,6,"0",STR_PAD_LEFT);
		$this->_view->id = $id;

		$solicitudModel = new Administracion_Model_DbTable_Solicitudes();
		$solicitud = $solicitudModel->getById($id);
		$this->_view->solicitud = $solicitud;

		$userModel = new Administracion_Model_DbTable_Usuario();

		$comiteModel = new Administracion_Model_DbTable_Comite();
		$comites = $comiteModel->getList(" comite_solicitud_id='$id' AND comite_tipo='3' ","");
		foreach ($comites as $key => $value) {
			$user_id = $value->comite_user_id;
			$aprobador = $userModel->getById($user_id);
			$value->user_names = $aprobador->user_names;
		}

		$this->_view->comites = $comites;


		//tabla
		$cedula = $solicitud->cedula;
		$usuarioModel = new Administracion_Model_DbTable_Usuario();
		$usuario = $usuarioModel->getList(" user_user='$cedula' ","")[0];
		$linea = $solicitud->linea_desembolso;
		$lineaModel = new Administracion_Model_DbTable_Lineas();
		$lineas = $lineaModel->getList(" codigo='$linea' ","")[0];
		$asignado = $solicitud->asignado;
		$analista = $usuarioModel->getById($asignado);
		$tabla = $this->generartabla($numero,$usuario,$solicitud,$lineas,$analista);
		$tabla = str_replace('style="max-width:900px;"','style="max-width:100%; background:#FFFFFF;"',$tabla);
		$this->_view->tabla = $tabla;
		$tabla2 = html_entity_decode($tabla);

		$excel = $this->_getSanitizedParam("excel");
		if($excel==1){
			$this->setLayout('blanco');
			$hoy = date("YmdHis");
			header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
			header("Content-type:   application/x-msexcel; charset=utf-8");
			header("Content-Disposition: attachment; filename=formato_comite_especial_".$id.".xls");
		}

		$pdf = $this->_getSanitizedParam("pdf");
		if($pdf==1){
			$this->setLayout("blanco");
			$titulo = "FORMATO DE APROBACIÓN COMITÉ ESPECIAL";
			$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'ISO-8859-1', false);
			$pdf->SetHeaderData('Logo.png', 30,$codigo,$titulo);
			$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$pdf->setPrintFooter(false);

			// set default monospaced font
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

			// set margins
			$pdf->SetMargins(PDF_MARGIN_LEFT, 40, PDF_MARGIN_RIGHT);
			$pdf->SetHeaderMargin(10);

			// set auto page breaks
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

			// set image scale factor
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

			// set some language-dependent strings (optional)
			if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
				require_once(dirname(__FILE__).'/lang/eng.php');
				$pdf->setLanguageArray($l);
			}

			//$pdf->SetProtection(array('print', 'copy'), '', null, 0, null);


			$fecha = $this->_view->comites[0]->comite_fecha;
			$fecha = substr($fecha,0,10);

			//$pdf->AddPage();
			$pdf->AddPage('L', 'A4');
			$pdf->SetFont('dejavusans', '',8, '', true);

			$tabla = '
			<table width="100%" cellpadding="3" cellspacing="0" border="0">
				<tr>
					<td colspan="7">
						Fecha: '.$fecha.'
					</td>
				</tr>
			</table>


			<div class="col-12">
				<table width="100%" cellpadding="3" cellspacing="0" border="1">
					<tr bgcolor="#CCCCCC">
						<th>APROBADOR</th>
						<th colspan="3">APROBO</th>
						<th>OBSERVACIONES</th>
						<th>FECHA</th>
						<th>FIRMA</th>
					</tr>
					<tr bgcolor="#CCCCCC">
						<th></th>
						<th><div align="center">SI</div></th>
						<th><div align="center">NO</div></th>
						<th><div align="center">APL</div></th>
						<th></th>
						<th></th>
						<th></th>
					</tr>';

			foreach ($comites as $key => $comite){
				$aprobacion1='';
				if($comite->comite_aprobacion=="1"){
					$aprobacion1='<b>X</b>';
				}
				$aprobacion2='';
				if($comite->comite_aprobacion=="2"){
					$aprobacion2='<b>X</b>';
				}
				$aprobacion3='';
				if($comite->comite_aprobacion=="3"){
					$aprobacion3='<b>X</b>';
				}
				$tabla.='
						<tr>
							<td>'.html_entity_decode($comite->user_names).'</td>
							<td align="center">'.$aprobacion1.'</td>
							<td align="center">'.$aprobacion2.'</td>
							<td align="center">'.$aprobacion3.'</td>
							<td>'.html_entity_decode($comite->comite_observacion).'</td>
							<td>'.$comite->comite_fecha.'</td>
							<td>'.$comite->firma.'</td>
						</tr>';
			}
			$tabla.='
					<tr>
						<td colspan="7">
							<div style="font-size: 11px;">Nota: A partir de la fecha para la aprobación de la solicitud de crédito es requisito NECESARIO NO estar reportado en la centrales de riesgo con cartera morosa de más de 90 dias y NO tener cartera castigada, salvo que se adjunten los respectivos paz y salvos expedidos por las entidades que generaron el reporte, con una antigüedad no mayor a 30 dias.</div>
						</td>
					</tr>
				</table>
			</div>
			';

			$tabla.='


				<div class="col-12"><br></div>
				<div class="col-12">
					<h5>Información Bancaria (Para desembolso)</h5>
					<table width="100%" cellpadding="3" cellspacing="0" border="1" bgcolor="#FFFFFF">
						<tr>
							<td><div align="center"><b>Cuenta Bancaria No</b></div></td>
							<td><div align="center"><b>Tipo de cuenta</b></div></td>
							<td><div align="center"><b>Entidad bancaria</b></div></td>
						</tr>
						<tr>
							<td><div align="center">'.$solicitud->cuenta_numero.'</div></td>
							<td><div align="center">'.$solicitud->cuenta_tipo.'</div></td>
							<td><div align="center">'.$solicitud->entidad_bancaria.'</div></td>
						</tr>
					</table>
				</div>


			';

			$tabla .= $tabla2;

			if($solicitud->observaciones!=""){
				$observacion1 = $solicitud->observaciones;
			} else {
				$observacion1 = 'Ninguna';
			}
			if($solicitud->observacion_analista!=""){
				$observacion2 = $solicitud->observacion_analista;
			} else {
				$observacion2 = 'Ninguna';
			}

			$observacion1 = html_entity_decode($observacion1);

			$tabla.='
				<div class="col-12">
					<br>
					<b>Observación del asociado</b>
					'.$observacion1.'
				</div>
				<div class="col-12">
					<b>Observación del analista</b>
					'.$observacion2.'
				</div>
			';

			$pdf->writeHTMLCell(0, 0, '', '', $tabla, 0, 1, 0, true, '', true);
			$pdf->Output('reporte.pdf', 'I');
		}

	}

	function enviaragerenciaAction(){

		$solicitudModel = new Administracion_Model_DbTable_Solicitudes();
		$id = $this->_getSanitizedParam("id");
		$this->_view->id = $id;
		$this->_view->numero = $numero = str_pad($id,6,"0",STR_PAD_LEFT);
		$solicitud = $solicitudModel->getById($id);

		$emailModel = new Core_Model_Mail();
		$asunto = " Solicitud aprobación de crédito WEB".$numero."";
		$content = "<br>Estimado(a) usuario. la solicitud de crédito WEB".$numero." requiere de su aprobación: ";

		$solicitudModel = new Administracion_Model_DbTable_Solicitudes();
		$solicitud = $solicitudModel->getById($id);

		$linea = $solicitud->linea_desembolso;
		$lineaModel = new Administracion_Model_DbTable_Lineas();
		$lineas = $lineaModel->getList(" codigo='$linea' ","")[0];

		$usuarioModel = new Administracion_Model_DbTable_Usuario();
		$cedula = $solicitud->cedula;
		$usuario = $usuarioModel->getList(" user_user = '$cedula' ","")[0];

		$analista_id = $solicitud->asignado;
		$analista = $usuarioModel->getById($analista_id);

		$gestor_comercial1 = $solicitud->gestor_comercial;
		$gestor_comercial = $usuarioModel->getList(" nombre = 'gestor_comercial' ","")[0];

		$tabla = $this->generartabla($numero,$usuario,$solicitud,$lineas,$analista);

		$content.= $tabla;


		$userModel = new Administracion_Model_DbTable_Usuario();
		$aprobadores = $userModel->getList(" user_level='8' ","");
		foreach ($aprobadores as $key => $value) {
			$email = $value->user_email;
			$user_id = $value->user_id;
			$codificado = base64_encode($user_id);
			$codificado = str_replace("=","_", $codificado);

	        //envio
			$content1 = $content."<br><br><br>Por favor utilice el siguiente enlace para indicar su aprobación: <a href='https://creditosfondtodos.com.co/page/gerencia/?id=".$id."&e=".$codificado."'><button type='button' class='btn btn-primary' style='background:#0084C9; color:#FFFFFF; padding:5px 10px;'>Ingresar</button></a>";

			$emailModel->getMail()->ClearAllRecipients();
	        $emailModel->getMail()->setFrom("notificaciones@fondtodos.com", "Notificaciones FONDTODOS");
	        $emailModel->getMail()->addBCC("desarrollo2@omegawebsystems.com");
    $emailModel->getMail()->addBCC("notificaciones@fondtodos.com");
			$emailModel->getMail()->addAddress("".$email);

	        $emailModel->getMail()->Subject = $asunto;
	        $emailModel->getMail()->msgHTML($content1);
	        $emailModel->getMail()->AltBody = $content;
	        $emailModel->sed();
	        //envio
        }

        header("Location:/administracion/solicitudes/gerenciaenviado/");

	}

	function gerenciaenviadoAction(){

	}

	function formatogerenciaAction(){
		$id = $this->_getSanitizedParam("id");
		$this->_view->numero = $numero =  str_pad($id,6,"0",STR_PAD_LEFT);
		$this->_view->id = $id;

		$solicitudModel = new Administracion_Model_DbTable_Solicitudes();
		$solicitud = $solicitudModel->getById($id);
		$this->_view->solicitud = $solicitud;

		$userModel = new Administracion_Model_DbTable_Usuario();

		$comiteModel = new Administracion_Model_DbTable_Comite();
		$comites = $comiteModel->getList(" comite_solicitud_id='$id' AND comite_tipo='2' ","");
		foreach ($comites as $key => $value) {
			$user_id = $value->comite_user_id;
			$aprobador = $userModel->getById($user_id);
			$value->user_names = $aprobador->user_names;
		}

		$this->_view->comites = $comites;

		//tabla
		$cedula = $solicitud->cedula;
		$usuarioModel = new Administracion_Model_DbTable_Usuario();
		$usuario = $usuarioModel->getList(" user_user='$cedula' ","")[0];
		$linea = $solicitud->linea_desembolso;
		$lineaModel = new Administracion_Model_DbTable_Lineas();
		$lineas = $lineaModel->getList(" codigo='$linea' ","")[0];
		$asignado = $solicitud->asignado;
		$analista = $usuarioModel->getById($asignado);
		$tabla = $this->generartabla($numero,$usuario,$solicitud,$lineas,$analista);
		$tabla = str_replace('style="max-width:900px;"','style="max-width:100%; background:#FFFFFF;"',$tabla);
		$this->_view->tabla = $tabla;
		$tabla2 = html_entity_decode($tabla);


		$excel = $this->_getSanitizedParam("excel");
		if($excel==1){
			$this->setLayout('blanco');
			$hoy = date("YmdHis");
			header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
			header("Content-type:   application/x-msexcel; charset=utf-8");
			header("Content-Disposition: attachment; filename=formato_comite_".$id.".xls");
		}

		$pdf = $this->_getSanitizedParam("pdf");
		if($pdf==1){
			$this->setLayout("blanco");
			$titulo = "FORMATO DE APROBACIÓN GERENCIA";
			$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'ISO-8859-1', false);
			$pdf->SetHeaderData('Logo.png', 30,$codigo,$titulo);
			$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$pdf->setPrintFooter(false);

			// set default monospaced font
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

			// set margins
			$pdf->SetMargins(PDF_MARGIN_LEFT, 40, PDF_MARGIN_RIGHT);
			$pdf->SetHeaderMargin(10);

			// set auto page breaks
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

			// set image scale factor
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

			// set some language-dependent strings (optional)
			if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
				require_once(dirname(__FILE__).'/lang/eng.php');
				$pdf->setLanguageArray($l);
			}

			//$pdf->SetProtection(array('print', 'copy'), '', null, 0, null);


			$fecha = $this->_view->comites[0]->comite_fecha;
			$fecha = substr($fecha,0,10);

			//$pdf->AddPage();
			$pdf->AddPage('L', 'A4');
			$pdf->SetFont('dejavusans', '',8, '', true);

			$tabla = '
			<table width="100%" cellpadding="3" cellspacing="0" border="0">
				<tr>
					<td colspan="7">
						Fecha: '.$fecha.'
					</td>
				</tr>
			</table>


			<div class="col-12">
				<table width="100%" cellpadding="3" cellspacing="0" border="1">
					<tr bgcolor="#CCCCCC">
						<th>APROBADOR</th>
						<th colspan="3">APROBO</th>
						<th>OBSERVACIONES</th>
						<th>FECHA</th>
						<th>FIRMA</th>
					</tr>
					<tr bgcolor="#CCCCCC">
						<th></th>
						<th><div align="center">SI</div></th>
						<th><div align="center">NO</div></th>
						<th><div align="center">APL</div></th>
						<th></th>
						<th></th>
						<th></th>
					</tr>';

			foreach ($comites as $key => $comite){
				$aprobacion1='';
				if($comite->comite_aprobacion=="1"){
					$aprobacion1='<b>X</b>';
				}
				$aprobacion2='';
				if($comite->comite_aprobacion=="2"){
					$aprobacion2='<b>X</b>';
				}
				$aprobacion3='';
				if($comite->comite_aprobacion=="3"){
					$aprobacion3='<b>X</b>';
				}
				$tabla.='
						<tr>
							<td>'.html_entity_decode($comite->user_names).'</td>
							<td align="center">'.$aprobacion1.'</td>
							<td align="center">'.$aprobacion2.'</td>
							<td align="center">'.$aprobacion3.'</td>
							<td>'.html_entity_decode($comite->comite_observacion).'</td>
							<td>'.$comite->comite_fecha.'</td>
							<td>'.$comite->firma.'</td>
						</tr>';
			}
			$tabla.='
					<tr>
						<td colspan="7">
							<div style="font-size: 11px;">Nota: A partir de la fecha para la aprobación de la solicitud de crédito es requisito NECESARIO NO estar reportado en la centrales de riesgo con cartera morosa de más de 90 dias y NO tener cartera castigada, salvo que se adjunten los respectivos paz y salvos expedidos por las entidades que generaron el reporte, con una antigüedad no mayor a 30 dias.</div>
						</td>
					</tr>
				</table>
			</div>
			';

			$tabla.='


				<div class="col-12"><br></div>
				<div class="col-12">
					<h5>Información Bancaria (Para desembolso)</h5>
					<table width="100%" cellpadding="3" cellspacing="0" border="1" bgcolor="#FFFFFF">
						<tr>
							<td><div align="center"><b>Cuenta Bancaria No</b></div></td>
							<td><div align="center"><b>Tipo de cuenta</b></div></td>
							<td><div align="center"><b>Entidad bancaria</b></div></td>
						</tr>
						<tr>
							<td><div align="center">'.$solicitud->cuenta_numero.'</div></td>
							<td><div align="center">'.$solicitud->cuenta_tipo.'</div></td>
							<td><div align="center">'.$solicitud->entidad_bancaria.'</div></td>
						</tr>
					</table>
				</div>


			';

			$tabla .= $tabla2;


			if($solicitud->observaciones!=""){
				$observacion1 = $solicitud->observaciones;
			} else {
				$observacion1 = 'Ninguna';
			}
			if($solicitud->observacion_analista!=""){
				$observacion2 = $solicitud->observacion_analista;
			} else {
				$observacion2 = 'Ninguna';
			}

			$observacion1 = html_entity_decode($observacion1);

			$tabla.='
				<div class="col-12">
					<br>
					<b>Observación del asociado</b>
					'.$observacion1.'
				</div>
				<div class="col-12">
					<b>Observación del analista</b>
					'.$observacion2.'
				</div>
			';

			//$pdf->AddPage('L', 'A4');

			$pdf->writeHTMLCell(0, 0, '', '', $tabla, 0, 1, 0, true, '', true);
			$pdf->Output('reporte.pdf', 'I');
		}

	}


	function generartabla($numero,$usuario,$solicitud,$lineas,$analista){

		$nombres = $solicitud->nombres." ".$solicitud->nombres2." ".$solicitud->apellido1." ".$solicitud->apellido2;
		$garantias = array("","APORTES SOCIALES INDIVIDUALES","DEUDOR SOLIDARIO","AFIANZADORA","HIPOTECARIA","PRENDARIA");

		$tabla .= '<table width="100%" style="max-width:900px;" border="1" cellspacing="0" cellpadding="3" class="formulario">
		  <tr class="fondo-gris">
		    <td colspan="2"><div align="center">
		    <b>Resumen de solicitud</b></div></td>
		  </tr>
		  <tr>
		    <td><strong>Solicitud</strong></td>
		    <td align="right">WEB'.$numero.'</td>
		  </tr>
		  <tr>
		    <td><strong>Documento</strong></td>
		    <td align="right">'.$solicitud->cedula.'</td>
		  </tr>
		  <tr>
		    <td><strong>Nombre</strong></td>
		    <td align="right">'.$nombres.'</td>
		  </tr>
		  <tr>
		    <td><strong>Email</strong></td>
		    <td align="right">'.$solicitud->correo_personal.'</td>
		  </tr>
		  <tr>
		    <td><strong>Celular</strong></td>
		    <td align="right">'.$solicitud->celular.'</td>
		  </tr>
		  <tr>
		    <td><strong>Tel&eacute;fono</strong></td>
		    <td align="right">'.$solicitud->telefono.'</td>
		  </tr>
		  <tr>
		    <td><strong>L&iacute;nea de cr&eacute;dito</strong></td>
		    <td align="right">'.$lineas->codigo.' - '.$lineas->nombre.'&nbsp;</td>
		  </tr>';


		$valida = array("NO","SI");
		$valida['']="NO";
		$saldo = $solicitud->valor-$solicitud->valor_desembolso;

		$tabla.='
		  <tr>
		    <td><strong>Valor solicitado</strong></td>
		    <td align="right">$'.$this->formato_pesos($solicitud->valor).'</td>
		  </tr>
		  <tr>
		    <td><strong>Recoge créditos?</strong></td>
		    <td align="right">'.$valida[$solicitud->recoger_credito].'</td>
		  </tr>';

		if($solicitud->recoger_credito=="1"){
			$tabla.='
			  <tr>
			    <td><strong>Créditos recogidos</strong></td>
			    <td align="right">'.$solicitud->numeros_recogidos.'</td>
			  </tr>
			  <tr>
			    <td><strong>Total saldo recogidos</strong></td>
			    <td align="right">$'.$this->formato_pesos($solicitud->valor_recogidos).'</td>
			  </tr>';
		}


	

		$tabla.='
		  <tr>
		    <td><strong>Valor desembolso</strong></td>
		    <td align="right">$'.$this->formato_pesos($solicitud->valor_desembolso).'</td>
		  </tr>
		  <tr>
		    <td><strong>N&uacute;mero de Cuotas</strong></td>
		    <td align="right">'.$solicitud->cuotas.'</td>
		  </tr>
		  <tr>
		    <td><strong>Valor aproximado de cuota</strong></td>
		    <td align="right">$'.$this->formato_pesos($solicitud->valor_cuota).'</td>
		  </tr>
		  <tr>
		    <td><strong>Tasa efectiva anual</strong></td>
		    <td align="right">'.$solicitud->tasa_anual.'%</td>
		  </tr>
		  <tr>
		    <td><strong>Tasa mes vencido</strong></td>
		    <td align="right">'.$solicitud->tasa.'%</td>
		  </tr>
		  <tr>
		    <td><strong>Garantía</strong></td>
		    <td align="right">'.$garantias[$solicitud->tipo_garantia].'</td>
		  </tr>
		  <tr>
		    <td><strong>Fecha solicitud</strong></td>
		    <td align="right">'.$solicitud->fecha_asignado.'</td>
		  </tr>';

		  if($solicitud->fecha_anterior!=""){
			$tabla.='
			  <tr>
			    <td><strong>Fecha solicitud anterior incompleta</strong></td>
			    <td align="right">'.$solicitud->fecha_anterior.'</td>
			  </tr>';
		  }

		$correo1 = $analista->user_email;
		$extension = "";
		if($analista->user_ext!=""){
			$extension = " ext ".$analista->user_ext;
		}

		$tabla.='
		  <tr>
		    <td><strong>Trámite</strong></td>
		    <td align="right">'.$solicitud->tramite.'</td>
		  </tr>
		  <tr>
		    <td><strong>Analista de crédito asignado</strong></td>
		    <td align="right">'.$analista->user_names.'</td>
		  </tr>
		  <tr>
		    <td><strong>Email</strong></td>
		    <td align="right">'.$correo1.'</td>
		  </tr>
		</table>';

		return $tabla;

	}



	public function desembolsoAction(){
		$id = $this->_getSanitizedParam("id");
		$hoy = date("Y-m-d H:i:s");
		$solicitudModel = new Administracion_Model_DbTable_Solicitudes();
		$solicitudModel->editField($id,"validacion","2");
		$solicitudModel->editField($id,"fecha_desembolso",$hoy);
		$solicitudModel->editField($id,"quien_desembolso",$_SESSION['kt_login_id']);
		header("Location:/administracion/solicitudes/");
	}
	public function libranzaAction(){
		$solicitudModel = new Administracion_Model_DbTable_Solicitudes();
		$codeudorModel = new Administracion_Model_DbTable_Codeudor();
		$id = $this->_getSanitizedParam("id");
		$solicitud=$solicitudModel->getById($id);
		$codeudorModel->getList("solicitud=$id","")[0];
		$this->_view->solicitud=$solicitud;
		$nombre=$solicitud->nombres;
		if($solicitud->nombres2!=""){
			$nombre=$nombre." ".$solicitud->nombres2;
		}
		$nombre=$nombre." ".$solicitud->apellido1;
		if($solicitud->apellido2!=""){
			$nombre=$nombre." ".$solicitud->apellido2;
		}
		$nombre2=$codeudorModel->nombres;
		if($codeudorModel->nombres2!=""){
			$nombre2=$nombre2." ".$codeudorModel->nombres2;
		}
		$nombre2=$nombre2." ".$codeudorModel->apellido1;
		if($codeudorModel->apellido2!=""){
			$nombre2=$nombre2." ".$codeudorModel->apellido2;
		}
		$this->_view->nombre=$nombre;
		$this->_view->codeudor_nombre=$nombre2;
	}
	public function exportarlibranzaAction(){
		$id = $this->_getSanitizedParam("id");
		$solicitudModel = new Administracion_Model_DbTable_Solicitudes();
		$codeudorModel = new Administracion_Model_DbTable_Codeudor();
		$solicitud=$solicitudModel->getById($id);
		$nombre=$solicitud->nombres;
		if($solicitud->nombres2!=""){
			$nombre=$nombre." ".$solicitud->nombres2;
		}
		$nombre=$nombre." ".$solicitud->apellido1;
		if($solicitud->apellido2!=""){
			$nombre=$nombre." ".$solicitud->apellido2;
		}
		$this->_view->nombre=$nombre;
		$this->_view->solicitud=$solicitud;
		$this->_view->codeudor=$codeudorModel->getList("solicitud=$id","")[0];
		$this->setLayout('blanco');
		$this->getLayout()->setTitle("PDF");
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetMargins(PDF_MARGIN_LEFT,10, PDF_MARGIN_RIGHT);
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->SetHeaderMargin(0);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$pdf->AddPage('P', 'A4');
		$pdf->SetFont('helvetica','',8);
		$content = $this->_view->getRoutPHP('modules/administracion/Views/solicitudes/exportarlibranza.php');
		$pdf->writeHTML($content, true, false, true, false, '');
		$pdf->Output("libranza.pdf", 'I');

	}
}